<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class LogMemberScbAdd extends LogMemberScb
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'log_member_scb';

    // Page object name
    public $PageObjName = "LogMemberScbAdd";

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

        // Table object (log_member_scb)
        if (!isset($GLOBALS["log_member_scb"]) || get_class($GLOBALS["log_member_scb"]) == PROJECT_NAMESPACE . "log_member_scb") {
            $GLOBALS["log_member_scb"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'log_member_scb');
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
                $tbl = Container("log_member_scb");
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
                    if ($pageName == "logmemberscbview") {
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
            $key .= @$ar['log_member_scb_id'];
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
            $this->log_member_scb_id->Visible = false;
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
        $this->log_member_scb_id->Visible = false;
        $this->reference_id->setVisibility();
        $this->reference_url->setVisibility();
        $this->member_id->setVisibility();
        $this->refreshtoken->setVisibility();
        $this->auth_code->setVisibility();
        $this->_token->setVisibility();
        $this->state->setVisibility();
        $this->cdate->setVisibility();
        $this->cuser->setVisibility();
        $this->cip->setVisibility();
        $this->status->setVisibility();
        $this->at_expire_in->setVisibility();
        $this->rt_expire_in->setVisibility();
        $this->asset_id->setVisibility();
        $this->decision_status->setVisibility();
        $this->decision_timestamp->setVisibility();
        $this->deposit_amount->setVisibility();
        $this->due_date->setVisibility();
        $this->rental_fee->setVisibility();
        $this->fullName->setVisibility();
        $this->age->setVisibility();
        $this->maritalStatus->setVisibility();
        $this->noOfChildren->setVisibility();
        $this->educationLevel->setVisibility();
        $this->workplace->setVisibility();
        $this->occupation->setVisibility();
        $this->jobPosition->setVisibility();
        $this->submissionDate->setVisibility();
        $this->bankruptcy_tendency->setVisibility();
        $this->blacklist_tendency->setVisibility();
        $this->money_laundering_tendency->setVisibility();
        $this->mobile_fraud_behavior->setVisibility();
        $this->face_similarity_score->setVisibility();
        $this->identification_verification_matched_flag->setVisibility();
        $this->bankstatement_confident_score->setVisibility();
        $this->estimated_monthly_income->setVisibility();
        $this->estimated_monthly_debt->setVisibility();
        $this->income_stability->setVisibility();
        $this->customer_grade->setVisibility();
        $this->color_sign->setVisibility();
        $this->rental_period->setVisibility();
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
            if (($keyValue = Get("log_member_scb_id") ?? Route("log_member_scb_id")) !== null) {
                $this->log_member_scb_id->setQueryStringValue($keyValue);
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
                    $this->terminate("logmemberscblist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "logmemberscblist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "logmemberscbview") {
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
        $this->log_member_scb_id->CurrentValue = null;
        $this->log_member_scb_id->OldValue = $this->log_member_scb_id->CurrentValue;
        $this->reference_id->CurrentValue = null;
        $this->reference_id->OldValue = $this->reference_id->CurrentValue;
        $this->reference_url->CurrentValue = null;
        $this->reference_url->OldValue = $this->reference_url->CurrentValue;
        $this->member_id->CurrentValue = null;
        $this->member_id->OldValue = $this->member_id->CurrentValue;
        $this->refreshtoken->CurrentValue = null;
        $this->refreshtoken->OldValue = $this->refreshtoken->CurrentValue;
        $this->auth_code->CurrentValue = null;
        $this->auth_code->OldValue = $this->auth_code->CurrentValue;
        $this->_token->CurrentValue = null;
        $this->_token->OldValue = $this->_token->CurrentValue;
        $this->state->CurrentValue = null;
        $this->state->OldValue = $this->state->CurrentValue;
        $this->cdate->CurrentValue = null;
        $this->cdate->OldValue = $this->cdate->CurrentValue;
        $this->cuser->CurrentValue = null;
        $this->cuser->OldValue = $this->cuser->CurrentValue;
        $this->cip->CurrentValue = null;
        $this->cip->OldValue = $this->cip->CurrentValue;
        $this->status->CurrentValue = null;
        $this->status->OldValue = $this->status->CurrentValue;
        $this->at_expire_in->CurrentValue = null;
        $this->at_expire_in->OldValue = $this->at_expire_in->CurrentValue;
        $this->rt_expire_in->CurrentValue = null;
        $this->rt_expire_in->OldValue = $this->rt_expire_in->CurrentValue;
        $this->asset_id->CurrentValue = null;
        $this->asset_id->OldValue = $this->asset_id->CurrentValue;
        $this->decision_status->CurrentValue = null;
        $this->decision_status->OldValue = $this->decision_status->CurrentValue;
        $this->decision_timestamp->CurrentValue = null;
        $this->decision_timestamp->OldValue = $this->decision_timestamp->CurrentValue;
        $this->deposit_amount->CurrentValue = null;
        $this->deposit_amount->OldValue = $this->deposit_amount->CurrentValue;
        $this->due_date->CurrentValue = null;
        $this->due_date->OldValue = $this->due_date->CurrentValue;
        $this->rental_fee->CurrentValue = null;
        $this->rental_fee->OldValue = $this->rental_fee->CurrentValue;
        $this->fullName->CurrentValue = null;
        $this->fullName->OldValue = $this->fullName->CurrentValue;
        $this->age->CurrentValue = null;
        $this->age->OldValue = $this->age->CurrentValue;
        $this->maritalStatus->CurrentValue = null;
        $this->maritalStatus->OldValue = $this->maritalStatus->CurrentValue;
        $this->noOfChildren->CurrentValue = null;
        $this->noOfChildren->OldValue = $this->noOfChildren->CurrentValue;
        $this->educationLevel->CurrentValue = null;
        $this->educationLevel->OldValue = $this->educationLevel->CurrentValue;
        $this->workplace->CurrentValue = null;
        $this->workplace->OldValue = $this->workplace->CurrentValue;
        $this->occupation->CurrentValue = null;
        $this->occupation->OldValue = $this->occupation->CurrentValue;
        $this->jobPosition->CurrentValue = null;
        $this->jobPosition->OldValue = $this->jobPosition->CurrentValue;
        $this->submissionDate->CurrentValue = null;
        $this->submissionDate->OldValue = $this->submissionDate->CurrentValue;
        $this->bankruptcy_tendency->CurrentValue = null;
        $this->bankruptcy_tendency->OldValue = $this->bankruptcy_tendency->CurrentValue;
        $this->blacklist_tendency->CurrentValue = null;
        $this->blacklist_tendency->OldValue = $this->blacklist_tendency->CurrentValue;
        $this->money_laundering_tendency->CurrentValue = null;
        $this->money_laundering_tendency->OldValue = $this->money_laundering_tendency->CurrentValue;
        $this->mobile_fraud_behavior->CurrentValue = null;
        $this->mobile_fraud_behavior->OldValue = $this->mobile_fraud_behavior->CurrentValue;
        $this->face_similarity_score->CurrentValue = null;
        $this->face_similarity_score->OldValue = $this->face_similarity_score->CurrentValue;
        $this->identification_verification_matched_flag->CurrentValue = null;
        $this->identification_verification_matched_flag->OldValue = $this->identification_verification_matched_flag->CurrentValue;
        $this->bankstatement_confident_score->CurrentValue = null;
        $this->bankstatement_confident_score->OldValue = $this->bankstatement_confident_score->CurrentValue;
        $this->estimated_monthly_income->CurrentValue = null;
        $this->estimated_monthly_income->OldValue = $this->estimated_monthly_income->CurrentValue;
        $this->estimated_monthly_debt->CurrentValue = null;
        $this->estimated_monthly_debt->OldValue = $this->estimated_monthly_debt->CurrentValue;
        $this->income_stability->CurrentValue = null;
        $this->income_stability->OldValue = $this->income_stability->CurrentValue;
        $this->customer_grade->CurrentValue = null;
        $this->customer_grade->OldValue = $this->customer_grade->CurrentValue;
        $this->color_sign->CurrentValue = null;
        $this->color_sign->OldValue = $this->color_sign->CurrentValue;
        $this->rental_period->CurrentValue = null;
        $this->rental_period->OldValue = $this->rental_period->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'reference_id' first before field var 'x_reference_id'
        $val = $CurrentForm->hasValue("reference_id") ? $CurrentForm->getValue("reference_id") : $CurrentForm->getValue("x_reference_id");
        if (!$this->reference_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->reference_id->Visible = false; // Disable update for API request
            } else {
                $this->reference_id->setFormValue($val);
            }
        }

        // Check field name 'reference_url' first before field var 'x_reference_url'
        $val = $CurrentForm->hasValue("reference_url") ? $CurrentForm->getValue("reference_url") : $CurrentForm->getValue("x_reference_url");
        if (!$this->reference_url->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->reference_url->Visible = false; // Disable update for API request
            } else {
                $this->reference_url->setFormValue($val);
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

        // Check field name 'refreshtoken' first before field var 'x_refreshtoken'
        $val = $CurrentForm->hasValue("refreshtoken") ? $CurrentForm->getValue("refreshtoken") : $CurrentForm->getValue("x_refreshtoken");
        if (!$this->refreshtoken->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->refreshtoken->Visible = false; // Disable update for API request
            } else {
                $this->refreshtoken->setFormValue($val);
            }
        }

        // Check field name 'auth_code' first before field var 'x_auth_code'
        $val = $CurrentForm->hasValue("auth_code") ? $CurrentForm->getValue("auth_code") : $CurrentForm->getValue("x_auth_code");
        if (!$this->auth_code->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->auth_code->Visible = false; // Disable update for API request
            } else {
                $this->auth_code->setFormValue($val);
            }
        }

        // Check field name 'token' first before field var 'x__token'
        $val = $CurrentForm->hasValue("token") ? $CurrentForm->getValue("token") : $CurrentForm->getValue("x__token");
        if (!$this->_token->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_token->Visible = false; // Disable update for API request
            } else {
                $this->_token->setFormValue($val);
            }
        }

        // Check field name 'state' first before field var 'x_state'
        $val = $CurrentForm->hasValue("state") ? $CurrentForm->getValue("state") : $CurrentForm->getValue("x_state");
        if (!$this->state->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->state->Visible = false; // Disable update for API request
            } else {
                $this->state->setFormValue($val);
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
                $this->cuser->setFormValue($val, true, $validate);
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

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
            }
        }

        // Check field name 'at_expire_in' first before field var 'x_at_expire_in'
        $val = $CurrentForm->hasValue("at_expire_in") ? $CurrentForm->getValue("at_expire_in") : $CurrentForm->getValue("x_at_expire_in");
        if (!$this->at_expire_in->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->at_expire_in->Visible = false; // Disable update for API request
            } else {
                $this->at_expire_in->setFormValue($val);
            }
        }

        // Check field name 'rt_expire_in' first before field var 'x_rt_expire_in'
        $val = $CurrentForm->hasValue("rt_expire_in") ? $CurrentForm->getValue("rt_expire_in") : $CurrentForm->getValue("x_rt_expire_in");
        if (!$this->rt_expire_in->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rt_expire_in->Visible = false; // Disable update for API request
            } else {
                $this->rt_expire_in->setFormValue($val);
            }
        }

        // Check field name 'asset_id' first before field var 'x_asset_id'
        $val = $CurrentForm->hasValue("asset_id") ? $CurrentForm->getValue("asset_id") : $CurrentForm->getValue("x_asset_id");
        if (!$this->asset_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_id->Visible = false; // Disable update for API request
            } else {
                $this->asset_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'decision_status' first before field var 'x_decision_status'
        $val = $CurrentForm->hasValue("decision_status") ? $CurrentForm->getValue("decision_status") : $CurrentForm->getValue("x_decision_status");
        if (!$this->decision_status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->decision_status->Visible = false; // Disable update for API request
            } else {
                $this->decision_status->setFormValue($val);
            }
        }

        // Check field name 'decision_timestamp' first before field var 'x_decision_timestamp'
        $val = $CurrentForm->hasValue("decision_timestamp") ? $CurrentForm->getValue("decision_timestamp") : $CurrentForm->getValue("x_decision_timestamp");
        if (!$this->decision_timestamp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->decision_timestamp->Visible = false; // Disable update for API request
            } else {
                $this->decision_timestamp->setFormValue($val, true, $validate);
            }
            $this->decision_timestamp->CurrentValue = UnFormatDateTime($this->decision_timestamp->CurrentValue, $this->decision_timestamp->formatPattern());
        }

        // Check field name 'deposit_amount' first before field var 'x_deposit_amount'
        $val = $CurrentForm->hasValue("deposit_amount") ? $CurrentForm->getValue("deposit_amount") : $CurrentForm->getValue("x_deposit_amount");
        if (!$this->deposit_amount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->deposit_amount->Visible = false; // Disable update for API request
            } else {
                $this->deposit_amount->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'due_date' first before field var 'x_due_date'
        $val = $CurrentForm->hasValue("due_date") ? $CurrentForm->getValue("due_date") : $CurrentForm->getValue("x_due_date");
        if (!$this->due_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->due_date->Visible = false; // Disable update for API request
            } else {
                $this->due_date->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'rental_fee' first before field var 'x_rental_fee'
        $val = $CurrentForm->hasValue("rental_fee") ? $CurrentForm->getValue("rental_fee") : $CurrentForm->getValue("x_rental_fee");
        if (!$this->rental_fee->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rental_fee->Visible = false; // Disable update for API request
            } else {
                $this->rental_fee->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'fullName' first before field var 'x_fullName'
        $val = $CurrentForm->hasValue("fullName") ? $CurrentForm->getValue("fullName") : $CurrentForm->getValue("x_fullName");
        if (!$this->fullName->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fullName->Visible = false; // Disable update for API request
            } else {
                $this->fullName->setFormValue($val);
            }
        }

        // Check field name 'age' first before field var 'x_age'
        $val = $CurrentForm->hasValue("age") ? $CurrentForm->getValue("age") : $CurrentForm->getValue("x_age");
        if (!$this->age->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->age->Visible = false; // Disable update for API request
            } else {
                $this->age->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'maritalStatus' first before field var 'x_maritalStatus'
        $val = $CurrentForm->hasValue("maritalStatus") ? $CurrentForm->getValue("maritalStatus") : $CurrentForm->getValue("x_maritalStatus");
        if (!$this->maritalStatus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->maritalStatus->Visible = false; // Disable update for API request
            } else {
                $this->maritalStatus->setFormValue($val);
            }
        }

        // Check field name 'noOfChildren' first before field var 'x_noOfChildren'
        $val = $CurrentForm->hasValue("noOfChildren") ? $CurrentForm->getValue("noOfChildren") : $CurrentForm->getValue("x_noOfChildren");
        if (!$this->noOfChildren->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->noOfChildren->Visible = false; // Disable update for API request
            } else {
                $this->noOfChildren->setFormValue($val);
            }
        }

        // Check field name 'educationLevel' first before field var 'x_educationLevel'
        $val = $CurrentForm->hasValue("educationLevel") ? $CurrentForm->getValue("educationLevel") : $CurrentForm->getValue("x_educationLevel");
        if (!$this->educationLevel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->educationLevel->Visible = false; // Disable update for API request
            } else {
                $this->educationLevel->setFormValue($val);
            }
        }

        // Check field name 'workplace' first before field var 'x_workplace'
        $val = $CurrentForm->hasValue("workplace") ? $CurrentForm->getValue("workplace") : $CurrentForm->getValue("x_workplace");
        if (!$this->workplace->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->workplace->Visible = false; // Disable update for API request
            } else {
                $this->workplace->setFormValue($val);
            }
        }

        // Check field name 'occupation' first before field var 'x_occupation'
        $val = $CurrentForm->hasValue("occupation") ? $CurrentForm->getValue("occupation") : $CurrentForm->getValue("x_occupation");
        if (!$this->occupation->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->occupation->Visible = false; // Disable update for API request
            } else {
                $this->occupation->setFormValue($val);
            }
        }

        // Check field name 'jobPosition' first before field var 'x_jobPosition'
        $val = $CurrentForm->hasValue("jobPosition") ? $CurrentForm->getValue("jobPosition") : $CurrentForm->getValue("x_jobPosition");
        if (!$this->jobPosition->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jobPosition->Visible = false; // Disable update for API request
            } else {
                $this->jobPosition->setFormValue($val);
            }
        }

        // Check field name 'submissionDate' first before field var 'x_submissionDate'
        $val = $CurrentForm->hasValue("submissionDate") ? $CurrentForm->getValue("submissionDate") : $CurrentForm->getValue("x_submissionDate");
        if (!$this->submissionDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->submissionDate->Visible = false; // Disable update for API request
            } else {
                $this->submissionDate->setFormValue($val, true, $validate);
            }
            $this->submissionDate->CurrentValue = UnFormatDateTime($this->submissionDate->CurrentValue, $this->submissionDate->formatPattern());
        }

        // Check field name 'bankruptcy_tendency' first before field var 'x_bankruptcy_tendency'
        $val = $CurrentForm->hasValue("bankruptcy_tendency") ? $CurrentForm->getValue("bankruptcy_tendency") : $CurrentForm->getValue("x_bankruptcy_tendency");
        if (!$this->bankruptcy_tendency->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bankruptcy_tendency->Visible = false; // Disable update for API request
            } else {
                $this->bankruptcy_tendency->setFormValue($val);
            }
        }

        // Check field name 'blacklist_tendency' first before field var 'x_blacklist_tendency'
        $val = $CurrentForm->hasValue("blacklist_tendency") ? $CurrentForm->getValue("blacklist_tendency") : $CurrentForm->getValue("x_blacklist_tendency");
        if (!$this->blacklist_tendency->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->blacklist_tendency->Visible = false; // Disable update for API request
            } else {
                $this->blacklist_tendency->setFormValue($val);
            }
        }

        // Check field name 'money_laundering_tendency' first before field var 'x_money_laundering_tendency'
        $val = $CurrentForm->hasValue("money_laundering_tendency") ? $CurrentForm->getValue("money_laundering_tendency") : $CurrentForm->getValue("x_money_laundering_tendency");
        if (!$this->money_laundering_tendency->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->money_laundering_tendency->Visible = false; // Disable update for API request
            } else {
                $this->money_laundering_tendency->setFormValue($val);
            }
        }

        // Check field name 'mobile_fraud_behavior' first before field var 'x_mobile_fraud_behavior'
        $val = $CurrentForm->hasValue("mobile_fraud_behavior") ? $CurrentForm->getValue("mobile_fraud_behavior") : $CurrentForm->getValue("x_mobile_fraud_behavior");
        if (!$this->mobile_fraud_behavior->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->mobile_fraud_behavior->Visible = false; // Disable update for API request
            } else {
                $this->mobile_fraud_behavior->setFormValue($val);
            }
        }

        // Check field name 'face_similarity_score' first before field var 'x_face_similarity_score'
        $val = $CurrentForm->hasValue("face_similarity_score") ? $CurrentForm->getValue("face_similarity_score") : $CurrentForm->getValue("x_face_similarity_score");
        if (!$this->face_similarity_score->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->face_similarity_score->Visible = false; // Disable update for API request
            } else {
                $this->face_similarity_score->setFormValue($val);
            }
        }

        // Check field name 'identification_verification_matched_flag' first before field var 'x_identification_verification_matched_flag'
        $val = $CurrentForm->hasValue("identification_verification_matched_flag") ? $CurrentForm->getValue("identification_verification_matched_flag") : $CurrentForm->getValue("x_identification_verification_matched_flag");
        if (!$this->identification_verification_matched_flag->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->identification_verification_matched_flag->Visible = false; // Disable update for API request
            } else {
                $this->identification_verification_matched_flag->setFormValue($val);
            }
        }

        // Check field name 'bankstatement_confident_score' first before field var 'x_bankstatement_confident_score'
        $val = $CurrentForm->hasValue("bankstatement_confident_score") ? $CurrentForm->getValue("bankstatement_confident_score") : $CurrentForm->getValue("x_bankstatement_confident_score");
        if (!$this->bankstatement_confident_score->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bankstatement_confident_score->Visible = false; // Disable update for API request
            } else {
                $this->bankstatement_confident_score->setFormValue($val);
            }
        }

        // Check field name 'estimated_monthly_income' first before field var 'x_estimated_monthly_income'
        $val = $CurrentForm->hasValue("estimated_monthly_income") ? $CurrentForm->getValue("estimated_monthly_income") : $CurrentForm->getValue("x_estimated_monthly_income");
        if (!$this->estimated_monthly_income->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estimated_monthly_income->Visible = false; // Disable update for API request
            } else {
                $this->estimated_monthly_income->setFormValue($val);
            }
        }

        // Check field name 'estimated_monthly_debt' first before field var 'x_estimated_monthly_debt'
        $val = $CurrentForm->hasValue("estimated_monthly_debt") ? $CurrentForm->getValue("estimated_monthly_debt") : $CurrentForm->getValue("x_estimated_monthly_debt");
        if (!$this->estimated_monthly_debt->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estimated_monthly_debt->Visible = false; // Disable update for API request
            } else {
                $this->estimated_monthly_debt->setFormValue($val);
            }
        }

        // Check field name 'income_stability' first before field var 'x_income_stability'
        $val = $CurrentForm->hasValue("income_stability") ? $CurrentForm->getValue("income_stability") : $CurrentForm->getValue("x_income_stability");
        if (!$this->income_stability->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->income_stability->Visible = false; // Disable update for API request
            } else {
                $this->income_stability->setFormValue($val);
            }
        }

        // Check field name 'customer_grade' first before field var 'x_customer_grade'
        $val = $CurrentForm->hasValue("customer_grade") ? $CurrentForm->getValue("customer_grade") : $CurrentForm->getValue("x_customer_grade");
        if (!$this->customer_grade->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->customer_grade->Visible = false; // Disable update for API request
            } else {
                $this->customer_grade->setFormValue($val);
            }
        }

        // Check field name 'color_sign' first before field var 'x_color_sign'
        $val = $CurrentForm->hasValue("color_sign") ? $CurrentForm->getValue("color_sign") : $CurrentForm->getValue("x_color_sign");
        if (!$this->color_sign->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->color_sign->Visible = false; // Disable update for API request
            } else {
                $this->color_sign->setFormValue($val);
            }
        }

        // Check field name 'rental_period' first before field var 'x_rental_period'
        $val = $CurrentForm->hasValue("rental_period") ? $CurrentForm->getValue("rental_period") : $CurrentForm->getValue("x_rental_period");
        if (!$this->rental_period->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rental_period->Visible = false; // Disable update for API request
            } else {
                $this->rental_period->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'log_member_scb_id' first before field var 'x_log_member_scb_id'
        $val = $CurrentForm->hasValue("log_member_scb_id") ? $CurrentForm->getValue("log_member_scb_id") : $CurrentForm->getValue("x_log_member_scb_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->reference_id->CurrentValue = $this->reference_id->FormValue;
        $this->reference_url->CurrentValue = $this->reference_url->FormValue;
        $this->member_id->CurrentValue = $this->member_id->FormValue;
        $this->refreshtoken->CurrentValue = $this->refreshtoken->FormValue;
        $this->auth_code->CurrentValue = $this->auth_code->FormValue;
        $this->_token->CurrentValue = $this->_token->FormValue;
        $this->state->CurrentValue = $this->state->FormValue;
        $this->cdate->CurrentValue = $this->cdate->FormValue;
        $this->cdate->CurrentValue = UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
        $this->cuser->CurrentValue = $this->cuser->FormValue;
        $this->cip->CurrentValue = $this->cip->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->at_expire_in->CurrentValue = $this->at_expire_in->FormValue;
        $this->rt_expire_in->CurrentValue = $this->rt_expire_in->FormValue;
        $this->asset_id->CurrentValue = $this->asset_id->FormValue;
        $this->decision_status->CurrentValue = $this->decision_status->FormValue;
        $this->decision_timestamp->CurrentValue = $this->decision_timestamp->FormValue;
        $this->decision_timestamp->CurrentValue = UnFormatDateTime($this->decision_timestamp->CurrentValue, $this->decision_timestamp->formatPattern());
        $this->deposit_amount->CurrentValue = $this->deposit_amount->FormValue;
        $this->due_date->CurrentValue = $this->due_date->FormValue;
        $this->rental_fee->CurrentValue = $this->rental_fee->FormValue;
        $this->fullName->CurrentValue = $this->fullName->FormValue;
        $this->age->CurrentValue = $this->age->FormValue;
        $this->maritalStatus->CurrentValue = $this->maritalStatus->FormValue;
        $this->noOfChildren->CurrentValue = $this->noOfChildren->FormValue;
        $this->educationLevel->CurrentValue = $this->educationLevel->FormValue;
        $this->workplace->CurrentValue = $this->workplace->FormValue;
        $this->occupation->CurrentValue = $this->occupation->FormValue;
        $this->jobPosition->CurrentValue = $this->jobPosition->FormValue;
        $this->submissionDate->CurrentValue = $this->submissionDate->FormValue;
        $this->submissionDate->CurrentValue = UnFormatDateTime($this->submissionDate->CurrentValue, $this->submissionDate->formatPattern());
        $this->bankruptcy_tendency->CurrentValue = $this->bankruptcy_tendency->FormValue;
        $this->blacklist_tendency->CurrentValue = $this->blacklist_tendency->FormValue;
        $this->money_laundering_tendency->CurrentValue = $this->money_laundering_tendency->FormValue;
        $this->mobile_fraud_behavior->CurrentValue = $this->mobile_fraud_behavior->FormValue;
        $this->face_similarity_score->CurrentValue = $this->face_similarity_score->FormValue;
        $this->identification_verification_matched_flag->CurrentValue = $this->identification_verification_matched_flag->FormValue;
        $this->bankstatement_confident_score->CurrentValue = $this->bankstatement_confident_score->FormValue;
        $this->estimated_monthly_income->CurrentValue = $this->estimated_monthly_income->FormValue;
        $this->estimated_monthly_debt->CurrentValue = $this->estimated_monthly_debt->FormValue;
        $this->income_stability->CurrentValue = $this->income_stability->FormValue;
        $this->customer_grade->CurrentValue = $this->customer_grade->FormValue;
        $this->color_sign->CurrentValue = $this->color_sign->FormValue;
        $this->rental_period->CurrentValue = $this->rental_period->FormValue;
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
        $this->log_member_scb_id->setDbValue($row['log_member_scb_id']);
        $this->reference_id->setDbValue($row['reference_id']);
        $this->reference_url->setDbValue($row['reference_url']);
        $this->member_id->setDbValue($row['member_id']);
        $this->refreshtoken->setDbValue($row['refreshtoken']);
        $this->auth_code->setDbValue($row['auth_code']);
        $this->_token->setDbValue($row['token']);
        $this->state->setDbValue($row['state']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->status->setDbValue($row['status']);
        $this->at_expire_in->setDbValue($row['at_expire_in']);
        $this->rt_expire_in->setDbValue($row['rt_expire_in']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->decision_status->setDbValue($row['decision_status']);
        $this->decision_timestamp->setDbValue($row['decision_timestamp']);
        $this->deposit_amount->setDbValue($row['deposit_amount']);
        $this->due_date->setDbValue($row['due_date']);
        $this->rental_fee->setDbValue($row['rental_fee']);
        $this->fullName->setDbValue($row['fullName']);
        $this->age->setDbValue($row['age']);
        $this->maritalStatus->setDbValue($row['maritalStatus']);
        $this->noOfChildren->setDbValue($row['noOfChildren']);
        $this->educationLevel->setDbValue($row['educationLevel']);
        $this->workplace->setDbValue($row['workplace']);
        $this->occupation->setDbValue($row['occupation']);
        $this->jobPosition->setDbValue($row['jobPosition']);
        $this->submissionDate->setDbValue($row['submissionDate']);
        $this->bankruptcy_tendency->setDbValue($row['bankruptcy_tendency']);
        $this->blacklist_tendency->setDbValue($row['blacklist_tendency']);
        $this->money_laundering_tendency->setDbValue($row['money_laundering_tendency']);
        $this->mobile_fraud_behavior->setDbValue($row['mobile_fraud_behavior']);
        $this->face_similarity_score->setDbValue($row['face_similarity_score']);
        $this->identification_verification_matched_flag->setDbValue($row['identification_verification_matched_flag']);
        $this->bankstatement_confident_score->setDbValue($row['bankstatement_confident_score']);
        $this->estimated_monthly_income->setDbValue($row['estimated_monthly_income']);
        $this->estimated_monthly_debt->setDbValue($row['estimated_monthly_debt']);
        $this->income_stability->setDbValue($row['income_stability']);
        $this->customer_grade->setDbValue($row['customer_grade']);
        $this->color_sign->setDbValue($row['color_sign']);
        $this->rental_period->setDbValue($row['rental_period']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['log_member_scb_id'] = $this->log_member_scb_id->CurrentValue;
        $row['reference_id'] = $this->reference_id->CurrentValue;
        $row['reference_url'] = $this->reference_url->CurrentValue;
        $row['member_id'] = $this->member_id->CurrentValue;
        $row['refreshtoken'] = $this->refreshtoken->CurrentValue;
        $row['auth_code'] = $this->auth_code->CurrentValue;
        $row['token'] = $this->_token->CurrentValue;
        $row['state'] = $this->state->CurrentValue;
        $row['cdate'] = $this->cdate->CurrentValue;
        $row['cuser'] = $this->cuser->CurrentValue;
        $row['cip'] = $this->cip->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['at_expire_in'] = $this->at_expire_in->CurrentValue;
        $row['rt_expire_in'] = $this->rt_expire_in->CurrentValue;
        $row['asset_id'] = $this->asset_id->CurrentValue;
        $row['decision_status'] = $this->decision_status->CurrentValue;
        $row['decision_timestamp'] = $this->decision_timestamp->CurrentValue;
        $row['deposit_amount'] = $this->deposit_amount->CurrentValue;
        $row['due_date'] = $this->due_date->CurrentValue;
        $row['rental_fee'] = $this->rental_fee->CurrentValue;
        $row['fullName'] = $this->fullName->CurrentValue;
        $row['age'] = $this->age->CurrentValue;
        $row['maritalStatus'] = $this->maritalStatus->CurrentValue;
        $row['noOfChildren'] = $this->noOfChildren->CurrentValue;
        $row['educationLevel'] = $this->educationLevel->CurrentValue;
        $row['workplace'] = $this->workplace->CurrentValue;
        $row['occupation'] = $this->occupation->CurrentValue;
        $row['jobPosition'] = $this->jobPosition->CurrentValue;
        $row['submissionDate'] = $this->submissionDate->CurrentValue;
        $row['bankruptcy_tendency'] = $this->bankruptcy_tendency->CurrentValue;
        $row['blacklist_tendency'] = $this->blacklist_tendency->CurrentValue;
        $row['money_laundering_tendency'] = $this->money_laundering_tendency->CurrentValue;
        $row['mobile_fraud_behavior'] = $this->mobile_fraud_behavior->CurrentValue;
        $row['face_similarity_score'] = $this->face_similarity_score->CurrentValue;
        $row['identification_verification_matched_flag'] = $this->identification_verification_matched_flag->CurrentValue;
        $row['bankstatement_confident_score'] = $this->bankstatement_confident_score->CurrentValue;
        $row['estimated_monthly_income'] = $this->estimated_monthly_income->CurrentValue;
        $row['estimated_monthly_debt'] = $this->estimated_monthly_debt->CurrentValue;
        $row['income_stability'] = $this->income_stability->CurrentValue;
        $row['customer_grade'] = $this->customer_grade->CurrentValue;
        $row['color_sign'] = $this->color_sign->CurrentValue;
        $row['rental_period'] = $this->rental_period->CurrentValue;
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

        // log_member_scb_id
        $this->log_member_scb_id->RowCssClass = "row";

        // reference_id
        $this->reference_id->RowCssClass = "row";

        // reference_url
        $this->reference_url->RowCssClass = "row";

        // member_id
        $this->member_id->RowCssClass = "row";

        // refreshtoken
        $this->refreshtoken->RowCssClass = "row";

        // auth_code
        $this->auth_code->RowCssClass = "row";

        // token
        $this->_token->RowCssClass = "row";

        // state
        $this->state->RowCssClass = "row";

        // cdate
        $this->cdate->RowCssClass = "row";

        // cuser
        $this->cuser->RowCssClass = "row";

        // cip
        $this->cip->RowCssClass = "row";

        // status
        $this->status->RowCssClass = "row";

        // at_expire_in
        $this->at_expire_in->RowCssClass = "row";

        // rt_expire_in
        $this->rt_expire_in->RowCssClass = "row";

        // asset_id
        $this->asset_id->RowCssClass = "row";

        // decision_status
        $this->decision_status->RowCssClass = "row";

        // decision_timestamp
        $this->decision_timestamp->RowCssClass = "row";

        // deposit_amount
        $this->deposit_amount->RowCssClass = "row";

        // due_date
        $this->due_date->RowCssClass = "row";

        // rental_fee
        $this->rental_fee->RowCssClass = "row";

        // fullName
        $this->fullName->RowCssClass = "row";

        // age
        $this->age->RowCssClass = "row";

        // maritalStatus
        $this->maritalStatus->RowCssClass = "row";

        // noOfChildren
        $this->noOfChildren->RowCssClass = "row";

        // educationLevel
        $this->educationLevel->RowCssClass = "row";

        // workplace
        $this->workplace->RowCssClass = "row";

        // occupation
        $this->occupation->RowCssClass = "row";

        // jobPosition
        $this->jobPosition->RowCssClass = "row";

        // submissionDate
        $this->submissionDate->RowCssClass = "row";

        // bankruptcy_tendency
        $this->bankruptcy_tendency->RowCssClass = "row";

        // blacklist_tendency
        $this->blacklist_tendency->RowCssClass = "row";

        // money_laundering_tendency
        $this->money_laundering_tendency->RowCssClass = "row";

        // mobile_fraud_behavior
        $this->mobile_fraud_behavior->RowCssClass = "row";

        // face_similarity_score
        $this->face_similarity_score->RowCssClass = "row";

        // identification_verification_matched_flag
        $this->identification_verification_matched_flag->RowCssClass = "row";

        // bankstatement_confident_score
        $this->bankstatement_confident_score->RowCssClass = "row";

        // estimated_monthly_income
        $this->estimated_monthly_income->RowCssClass = "row";

        // estimated_monthly_debt
        $this->estimated_monthly_debt->RowCssClass = "row";

        // income_stability
        $this->income_stability->RowCssClass = "row";

        // customer_grade
        $this->customer_grade->RowCssClass = "row";

        // color_sign
        $this->color_sign->RowCssClass = "row";

        // rental_period
        $this->rental_period->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // log_member_scb_id
            $this->log_member_scb_id->ViewValue = $this->log_member_scb_id->CurrentValue;
            $this->log_member_scb_id->ViewCustomAttributes = "";

            // reference_id
            $this->reference_id->ViewValue = $this->reference_id->CurrentValue;
            $this->reference_id->ViewCustomAttributes = "";

            // reference_url
            $this->reference_url->ViewValue = $this->reference_url->CurrentValue;
            $this->reference_url->ViewCustomAttributes = "";

            // member_id
            $this->member_id->ViewValue = $this->member_id->CurrentValue;
            $this->member_id->ViewValue = FormatNumber($this->member_id->ViewValue, $this->member_id->formatPattern());
            $this->member_id->ViewCustomAttributes = "";

            // refreshtoken
            $this->refreshtoken->ViewValue = $this->refreshtoken->CurrentValue;
            $this->refreshtoken->ViewCustomAttributes = "";

            // auth_code
            $this->auth_code->ViewValue = $this->auth_code->CurrentValue;
            $this->auth_code->ViewCustomAttributes = "";

            // token
            $this->_token->ViewValue = $this->_token->CurrentValue;
            $this->_token->ViewCustomAttributes = "";

            // state
            $this->state->ViewValue = $this->state->CurrentValue;
            $this->state->ViewCustomAttributes = "";

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

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // at_expire_in
            $this->at_expire_in->ViewValue = $this->at_expire_in->CurrentValue;
            $this->at_expire_in->ViewCustomAttributes = "";

            // rt_expire_in
            $this->rt_expire_in->ViewValue = $this->rt_expire_in->CurrentValue;
            $this->rt_expire_in->ViewCustomAttributes = "";

            // asset_id
            $this->asset_id->ViewValue = $this->asset_id->CurrentValue;
            $this->asset_id->ViewValue = FormatNumber($this->asset_id->ViewValue, $this->asset_id->formatPattern());
            $this->asset_id->ViewCustomAttributes = "";

            // decision_status
            $this->decision_status->ViewValue = $this->decision_status->CurrentValue;
            $this->decision_status->ViewCustomAttributes = "";

            // decision_timestamp
            $this->decision_timestamp->ViewValue = $this->decision_timestamp->CurrentValue;
            $this->decision_timestamp->ViewValue = FormatDateTime($this->decision_timestamp->ViewValue, $this->decision_timestamp->formatPattern());
            $this->decision_timestamp->ViewCustomAttributes = "";

            // deposit_amount
            $this->deposit_amount->ViewValue = $this->deposit_amount->CurrentValue;
            $this->deposit_amount->ViewValue = FormatNumber($this->deposit_amount->ViewValue, $this->deposit_amount->formatPattern());
            $this->deposit_amount->ViewCustomAttributes = "";

            // due_date
            $this->due_date->ViewValue = $this->due_date->CurrentValue;
            $this->due_date->ViewValue = FormatNumber($this->due_date->ViewValue, $this->due_date->formatPattern());
            $this->due_date->ViewCustomAttributes = "";

            // rental_fee
            $this->rental_fee->ViewValue = $this->rental_fee->CurrentValue;
            $this->rental_fee->ViewValue = FormatNumber($this->rental_fee->ViewValue, $this->rental_fee->formatPattern());
            $this->rental_fee->ViewCustomAttributes = "";

            // fullName
            $this->fullName->ViewValue = $this->fullName->CurrentValue;
            $this->fullName->ViewCustomAttributes = "";

            // age
            $this->age->ViewValue = $this->age->CurrentValue;
            $this->age->ViewValue = FormatNumber($this->age->ViewValue, $this->age->formatPattern());
            $this->age->ViewCustomAttributes = "";

            // maritalStatus
            $this->maritalStatus->ViewValue = $this->maritalStatus->CurrentValue;
            $this->maritalStatus->ViewCustomAttributes = "";

            // noOfChildren
            $this->noOfChildren->ViewValue = $this->noOfChildren->CurrentValue;
            $this->noOfChildren->ViewCustomAttributes = "";

            // educationLevel
            $this->educationLevel->ViewValue = $this->educationLevel->CurrentValue;
            $this->educationLevel->ViewCustomAttributes = "";

            // workplace
            $this->workplace->ViewValue = $this->workplace->CurrentValue;
            $this->workplace->ViewCustomAttributes = "";

            // occupation
            $this->occupation->ViewValue = $this->occupation->CurrentValue;
            $this->occupation->ViewCustomAttributes = "";

            // jobPosition
            $this->jobPosition->ViewValue = $this->jobPosition->CurrentValue;
            $this->jobPosition->ViewCustomAttributes = "";

            // submissionDate
            $this->submissionDate->ViewValue = $this->submissionDate->CurrentValue;
            $this->submissionDate->ViewValue = FormatDateTime($this->submissionDate->ViewValue, $this->submissionDate->formatPattern());
            $this->submissionDate->ViewCustomAttributes = "";

            // bankruptcy_tendency
            $this->bankruptcy_tendency->ViewValue = $this->bankruptcy_tendency->CurrentValue;
            $this->bankruptcy_tendency->ViewCustomAttributes = "";

            // blacklist_tendency
            $this->blacklist_tendency->ViewValue = $this->blacklist_tendency->CurrentValue;
            $this->blacklist_tendency->ViewCustomAttributes = "";

            // money_laundering_tendency
            $this->money_laundering_tendency->ViewValue = $this->money_laundering_tendency->CurrentValue;
            $this->money_laundering_tendency->ViewCustomAttributes = "";

            // mobile_fraud_behavior
            $this->mobile_fraud_behavior->ViewValue = $this->mobile_fraud_behavior->CurrentValue;
            $this->mobile_fraud_behavior->ViewCustomAttributes = "";

            // face_similarity_score
            $this->face_similarity_score->ViewValue = $this->face_similarity_score->CurrentValue;
            $this->face_similarity_score->ViewCustomAttributes = "";

            // identification_verification_matched_flag
            $this->identification_verification_matched_flag->ViewValue = $this->identification_verification_matched_flag->CurrentValue;
            $this->identification_verification_matched_flag->ViewCustomAttributes = "";

            // bankstatement_confident_score
            $this->bankstatement_confident_score->ViewValue = $this->bankstatement_confident_score->CurrentValue;
            $this->bankstatement_confident_score->ViewCustomAttributes = "";

            // estimated_monthly_income
            $this->estimated_monthly_income->ViewValue = $this->estimated_monthly_income->CurrentValue;
            $this->estimated_monthly_income->ViewCustomAttributes = "";

            // estimated_monthly_debt
            $this->estimated_monthly_debt->ViewValue = $this->estimated_monthly_debt->CurrentValue;
            $this->estimated_monthly_debt->ViewCustomAttributes = "";

            // income_stability
            $this->income_stability->ViewValue = $this->income_stability->CurrentValue;
            $this->income_stability->ViewCustomAttributes = "";

            // customer_grade
            $this->customer_grade->ViewValue = $this->customer_grade->CurrentValue;
            $this->customer_grade->ViewCustomAttributes = "";

            // color_sign
            $this->color_sign->ViewValue = $this->color_sign->CurrentValue;
            $this->color_sign->ViewCustomAttributes = "";

            // rental_period
            $this->rental_period->ViewValue = $this->rental_period->CurrentValue;
            $this->rental_period->ViewValue = FormatNumber($this->rental_period->ViewValue, $this->rental_period->formatPattern());
            $this->rental_period->ViewCustomAttributes = "";

            // reference_id
            $this->reference_id->LinkCustomAttributes = "";
            $this->reference_id->HrefValue = "";

            // reference_url
            $this->reference_url->LinkCustomAttributes = "";
            $this->reference_url->HrefValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";

            // refreshtoken
            $this->refreshtoken->LinkCustomAttributes = "";
            $this->refreshtoken->HrefValue = "";

            // auth_code
            $this->auth_code->LinkCustomAttributes = "";
            $this->auth_code->HrefValue = "";

            // token
            $this->_token->LinkCustomAttributes = "";
            $this->_token->HrefValue = "";

            // state
            $this->state->LinkCustomAttributes = "";
            $this->state->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // at_expire_in
            $this->at_expire_in->LinkCustomAttributes = "";
            $this->at_expire_in->HrefValue = "";

            // rt_expire_in
            $this->rt_expire_in->LinkCustomAttributes = "";
            $this->rt_expire_in->HrefValue = "";

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";

            // decision_status
            $this->decision_status->LinkCustomAttributes = "";
            $this->decision_status->HrefValue = "";

            // decision_timestamp
            $this->decision_timestamp->LinkCustomAttributes = "";
            $this->decision_timestamp->HrefValue = "";

            // deposit_amount
            $this->deposit_amount->LinkCustomAttributes = "";
            $this->deposit_amount->HrefValue = "";

            // due_date
            $this->due_date->LinkCustomAttributes = "";
            $this->due_date->HrefValue = "";

            // rental_fee
            $this->rental_fee->LinkCustomAttributes = "";
            $this->rental_fee->HrefValue = "";

            // fullName
            $this->fullName->LinkCustomAttributes = "";
            $this->fullName->HrefValue = "";

            // age
            $this->age->LinkCustomAttributes = "";
            $this->age->HrefValue = "";

            // maritalStatus
            $this->maritalStatus->LinkCustomAttributes = "";
            $this->maritalStatus->HrefValue = "";

            // noOfChildren
            $this->noOfChildren->LinkCustomAttributes = "";
            $this->noOfChildren->HrefValue = "";

            // educationLevel
            $this->educationLevel->LinkCustomAttributes = "";
            $this->educationLevel->HrefValue = "";

            // workplace
            $this->workplace->LinkCustomAttributes = "";
            $this->workplace->HrefValue = "";

            // occupation
            $this->occupation->LinkCustomAttributes = "";
            $this->occupation->HrefValue = "";

            // jobPosition
            $this->jobPosition->LinkCustomAttributes = "";
            $this->jobPosition->HrefValue = "";

            // submissionDate
            $this->submissionDate->LinkCustomAttributes = "";
            $this->submissionDate->HrefValue = "";

            // bankruptcy_tendency
            $this->bankruptcy_tendency->LinkCustomAttributes = "";
            $this->bankruptcy_tendency->HrefValue = "";

            // blacklist_tendency
            $this->blacklist_tendency->LinkCustomAttributes = "";
            $this->blacklist_tendency->HrefValue = "";

            // money_laundering_tendency
            $this->money_laundering_tendency->LinkCustomAttributes = "";
            $this->money_laundering_tendency->HrefValue = "";

            // mobile_fraud_behavior
            $this->mobile_fraud_behavior->LinkCustomAttributes = "";
            $this->mobile_fraud_behavior->HrefValue = "";

            // face_similarity_score
            $this->face_similarity_score->LinkCustomAttributes = "";
            $this->face_similarity_score->HrefValue = "";

            // identification_verification_matched_flag
            $this->identification_verification_matched_flag->LinkCustomAttributes = "";
            $this->identification_verification_matched_flag->HrefValue = "";

            // bankstatement_confident_score
            $this->bankstatement_confident_score->LinkCustomAttributes = "";
            $this->bankstatement_confident_score->HrefValue = "";

            // estimated_monthly_income
            $this->estimated_monthly_income->LinkCustomAttributes = "";
            $this->estimated_monthly_income->HrefValue = "";

            // estimated_monthly_debt
            $this->estimated_monthly_debt->LinkCustomAttributes = "";
            $this->estimated_monthly_debt->HrefValue = "";

            // income_stability
            $this->income_stability->LinkCustomAttributes = "";
            $this->income_stability->HrefValue = "";

            // customer_grade
            $this->customer_grade->LinkCustomAttributes = "";
            $this->customer_grade->HrefValue = "";

            // color_sign
            $this->color_sign->LinkCustomAttributes = "";
            $this->color_sign->HrefValue = "";

            // rental_period
            $this->rental_period->LinkCustomAttributes = "";
            $this->rental_period->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // reference_id
            $this->reference_id->setupEditAttributes();
            $this->reference_id->EditCustomAttributes = "";
            if (!$this->reference_id->Raw) {
                $this->reference_id->CurrentValue = HtmlDecode($this->reference_id->CurrentValue);
            }
            $this->reference_id->EditValue = HtmlEncode($this->reference_id->CurrentValue);
            $this->reference_id->PlaceHolder = RemoveHtml($this->reference_id->caption());

            // reference_url
            $this->reference_url->setupEditAttributes();
            $this->reference_url->EditCustomAttributes = "";
            $this->reference_url->EditValue = HtmlEncode($this->reference_url->CurrentValue);
            $this->reference_url->PlaceHolder = RemoveHtml($this->reference_url->caption());

            // member_id
            $this->member_id->setupEditAttributes();
            $this->member_id->EditCustomAttributes = "";
            $this->member_id->EditValue = HtmlEncode($this->member_id->CurrentValue);
            $this->member_id->PlaceHolder = RemoveHtml($this->member_id->caption());
            if (strval($this->member_id->EditValue) != "" && is_numeric($this->member_id->EditValue)) {
                $this->member_id->EditValue = FormatNumber($this->member_id->EditValue, null);
            }

            // refreshtoken
            $this->refreshtoken->setupEditAttributes();
            $this->refreshtoken->EditCustomAttributes = "";
            $this->refreshtoken->EditValue = HtmlEncode($this->refreshtoken->CurrentValue);
            $this->refreshtoken->PlaceHolder = RemoveHtml($this->refreshtoken->caption());

            // auth_code
            $this->auth_code->setupEditAttributes();
            $this->auth_code->EditCustomAttributes = "";
            $this->auth_code->EditValue = HtmlEncode($this->auth_code->CurrentValue);
            $this->auth_code->PlaceHolder = RemoveHtml($this->auth_code->caption());

            // token
            $this->_token->setupEditAttributes();
            $this->_token->EditCustomAttributes = "";
            $this->_token->EditValue = HtmlEncode($this->_token->CurrentValue);
            $this->_token->PlaceHolder = RemoveHtml($this->_token->caption());

            // state
            $this->state->setupEditAttributes();
            $this->state->EditCustomAttributes = "";
            $this->state->EditValue = HtmlEncode($this->state->CurrentValue);
            $this->state->PlaceHolder = RemoveHtml($this->state->caption());

            // cdate
            $this->cdate->setupEditAttributes();
            $this->cdate->EditCustomAttributes = "";
            $this->cdate->EditValue = HtmlEncode(FormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern()));
            $this->cdate->PlaceHolder = RemoveHtml($this->cdate->caption());

            // cuser
            $this->cuser->setupEditAttributes();
            $this->cuser->EditCustomAttributes = "";
            $this->cuser->EditValue = HtmlEncode($this->cuser->CurrentValue);
            $this->cuser->PlaceHolder = RemoveHtml($this->cuser->caption());
            if (strval($this->cuser->EditValue) != "" && is_numeric($this->cuser->EditValue)) {
                $this->cuser->EditValue = FormatNumber($this->cuser->EditValue, null);
            }

            // cip
            $this->cip->setupEditAttributes();
            $this->cip->EditCustomAttributes = "";
            if (!$this->cip->Raw) {
                $this->cip->CurrentValue = HtmlDecode($this->cip->CurrentValue);
            }
            $this->cip->EditValue = HtmlEncode($this->cip->CurrentValue);
            $this->cip->PlaceHolder = RemoveHtml($this->cip->caption());

            // status
            $this->status->setupEditAttributes();
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // at_expire_in
            $this->at_expire_in->setupEditAttributes();
            $this->at_expire_in->EditCustomAttributes = "";
            $this->at_expire_in->EditValue = HtmlEncode($this->at_expire_in->CurrentValue);
            $this->at_expire_in->PlaceHolder = RemoveHtml($this->at_expire_in->caption());

            // rt_expire_in
            $this->rt_expire_in->setupEditAttributes();
            $this->rt_expire_in->EditCustomAttributes = "";
            $this->rt_expire_in->EditValue = HtmlEncode($this->rt_expire_in->CurrentValue);
            $this->rt_expire_in->PlaceHolder = RemoveHtml($this->rt_expire_in->caption());

            // asset_id
            $this->asset_id->setupEditAttributes();
            $this->asset_id->EditCustomAttributes = "";
            $this->asset_id->EditValue = HtmlEncode($this->asset_id->CurrentValue);
            $this->asset_id->PlaceHolder = RemoveHtml($this->asset_id->caption());
            if (strval($this->asset_id->EditValue) != "" && is_numeric($this->asset_id->EditValue)) {
                $this->asset_id->EditValue = FormatNumber($this->asset_id->EditValue, null);
            }

            // decision_status
            $this->decision_status->setupEditAttributes();
            $this->decision_status->EditCustomAttributes = "";
            if (!$this->decision_status->Raw) {
                $this->decision_status->CurrentValue = HtmlDecode($this->decision_status->CurrentValue);
            }
            $this->decision_status->EditValue = HtmlEncode($this->decision_status->CurrentValue);
            $this->decision_status->PlaceHolder = RemoveHtml($this->decision_status->caption());

            // decision_timestamp
            $this->decision_timestamp->setupEditAttributes();
            $this->decision_timestamp->EditCustomAttributes = "";
            $this->decision_timestamp->EditValue = HtmlEncode(FormatDateTime($this->decision_timestamp->CurrentValue, $this->decision_timestamp->formatPattern()));
            $this->decision_timestamp->PlaceHolder = RemoveHtml($this->decision_timestamp->caption());

            // deposit_amount
            $this->deposit_amount->setupEditAttributes();
            $this->deposit_amount->EditCustomAttributes = "";
            $this->deposit_amount->EditValue = HtmlEncode($this->deposit_amount->CurrentValue);
            $this->deposit_amount->PlaceHolder = RemoveHtml($this->deposit_amount->caption());
            if (strval($this->deposit_amount->EditValue) != "" && is_numeric($this->deposit_amount->EditValue)) {
                $this->deposit_amount->EditValue = FormatNumber($this->deposit_amount->EditValue, null);
            }

            // due_date
            $this->due_date->setupEditAttributes();
            $this->due_date->EditCustomAttributes = "";
            $this->due_date->EditValue = HtmlEncode($this->due_date->CurrentValue);
            $this->due_date->PlaceHolder = RemoveHtml($this->due_date->caption());
            if (strval($this->due_date->EditValue) != "" && is_numeric($this->due_date->EditValue)) {
                $this->due_date->EditValue = FormatNumber($this->due_date->EditValue, null);
            }

            // rental_fee
            $this->rental_fee->setupEditAttributes();
            $this->rental_fee->EditCustomAttributes = "";
            $this->rental_fee->EditValue = HtmlEncode($this->rental_fee->CurrentValue);
            $this->rental_fee->PlaceHolder = RemoveHtml($this->rental_fee->caption());
            if (strval($this->rental_fee->EditValue) != "" && is_numeric($this->rental_fee->EditValue)) {
                $this->rental_fee->EditValue = FormatNumber($this->rental_fee->EditValue, null);
            }

            // fullName
            $this->fullName->setupEditAttributes();
            $this->fullName->EditCustomAttributes = "";
            if (!$this->fullName->Raw) {
                $this->fullName->CurrentValue = HtmlDecode($this->fullName->CurrentValue);
            }
            $this->fullName->EditValue = HtmlEncode($this->fullName->CurrentValue);
            $this->fullName->PlaceHolder = RemoveHtml($this->fullName->caption());

            // age
            $this->age->setupEditAttributes();
            $this->age->EditCustomAttributes = "";
            $this->age->EditValue = HtmlEncode($this->age->CurrentValue);
            $this->age->PlaceHolder = RemoveHtml($this->age->caption());
            if (strval($this->age->EditValue) != "" && is_numeric($this->age->EditValue)) {
                $this->age->EditValue = FormatNumber($this->age->EditValue, null);
            }

            // maritalStatus
            $this->maritalStatus->setupEditAttributes();
            $this->maritalStatus->EditCustomAttributes = "";
            if (!$this->maritalStatus->Raw) {
                $this->maritalStatus->CurrentValue = HtmlDecode($this->maritalStatus->CurrentValue);
            }
            $this->maritalStatus->EditValue = HtmlEncode($this->maritalStatus->CurrentValue);
            $this->maritalStatus->PlaceHolder = RemoveHtml($this->maritalStatus->caption());

            // noOfChildren
            $this->noOfChildren->setupEditAttributes();
            $this->noOfChildren->EditCustomAttributes = "";
            if (!$this->noOfChildren->Raw) {
                $this->noOfChildren->CurrentValue = HtmlDecode($this->noOfChildren->CurrentValue);
            }
            $this->noOfChildren->EditValue = HtmlEncode($this->noOfChildren->CurrentValue);
            $this->noOfChildren->PlaceHolder = RemoveHtml($this->noOfChildren->caption());

            // educationLevel
            $this->educationLevel->setupEditAttributes();
            $this->educationLevel->EditCustomAttributes = "";
            if (!$this->educationLevel->Raw) {
                $this->educationLevel->CurrentValue = HtmlDecode($this->educationLevel->CurrentValue);
            }
            $this->educationLevel->EditValue = HtmlEncode($this->educationLevel->CurrentValue);
            $this->educationLevel->PlaceHolder = RemoveHtml($this->educationLevel->caption());

            // workplace
            $this->workplace->setupEditAttributes();
            $this->workplace->EditCustomAttributes = "";
            if (!$this->workplace->Raw) {
                $this->workplace->CurrentValue = HtmlDecode($this->workplace->CurrentValue);
            }
            $this->workplace->EditValue = HtmlEncode($this->workplace->CurrentValue);
            $this->workplace->PlaceHolder = RemoveHtml($this->workplace->caption());

            // occupation
            $this->occupation->setupEditAttributes();
            $this->occupation->EditCustomAttributes = "";
            if (!$this->occupation->Raw) {
                $this->occupation->CurrentValue = HtmlDecode($this->occupation->CurrentValue);
            }
            $this->occupation->EditValue = HtmlEncode($this->occupation->CurrentValue);
            $this->occupation->PlaceHolder = RemoveHtml($this->occupation->caption());

            // jobPosition
            $this->jobPosition->setupEditAttributes();
            $this->jobPosition->EditCustomAttributes = "";
            if (!$this->jobPosition->Raw) {
                $this->jobPosition->CurrentValue = HtmlDecode($this->jobPosition->CurrentValue);
            }
            $this->jobPosition->EditValue = HtmlEncode($this->jobPosition->CurrentValue);
            $this->jobPosition->PlaceHolder = RemoveHtml($this->jobPosition->caption());

            // submissionDate
            $this->submissionDate->setupEditAttributes();
            $this->submissionDate->EditCustomAttributes = "";
            $this->submissionDate->EditValue = HtmlEncode(FormatDateTime($this->submissionDate->CurrentValue, $this->submissionDate->formatPattern()));
            $this->submissionDate->PlaceHolder = RemoveHtml($this->submissionDate->caption());

            // bankruptcy_tendency
            $this->bankruptcy_tendency->setupEditAttributes();
            $this->bankruptcy_tendency->EditCustomAttributes = "";
            if (!$this->bankruptcy_tendency->Raw) {
                $this->bankruptcy_tendency->CurrentValue = HtmlDecode($this->bankruptcy_tendency->CurrentValue);
            }
            $this->bankruptcy_tendency->EditValue = HtmlEncode($this->bankruptcy_tendency->CurrentValue);
            $this->bankruptcy_tendency->PlaceHolder = RemoveHtml($this->bankruptcy_tendency->caption());

            // blacklist_tendency
            $this->blacklist_tendency->setupEditAttributes();
            $this->blacklist_tendency->EditCustomAttributes = "";
            if (!$this->blacklist_tendency->Raw) {
                $this->blacklist_tendency->CurrentValue = HtmlDecode($this->blacklist_tendency->CurrentValue);
            }
            $this->blacklist_tendency->EditValue = HtmlEncode($this->blacklist_tendency->CurrentValue);
            $this->blacklist_tendency->PlaceHolder = RemoveHtml($this->blacklist_tendency->caption());

            // money_laundering_tendency
            $this->money_laundering_tendency->setupEditAttributes();
            $this->money_laundering_tendency->EditCustomAttributes = "";
            if (!$this->money_laundering_tendency->Raw) {
                $this->money_laundering_tendency->CurrentValue = HtmlDecode($this->money_laundering_tendency->CurrentValue);
            }
            $this->money_laundering_tendency->EditValue = HtmlEncode($this->money_laundering_tendency->CurrentValue);
            $this->money_laundering_tendency->PlaceHolder = RemoveHtml($this->money_laundering_tendency->caption());

            // mobile_fraud_behavior
            $this->mobile_fraud_behavior->setupEditAttributes();
            $this->mobile_fraud_behavior->EditCustomAttributes = "";
            if (!$this->mobile_fraud_behavior->Raw) {
                $this->mobile_fraud_behavior->CurrentValue = HtmlDecode($this->mobile_fraud_behavior->CurrentValue);
            }
            $this->mobile_fraud_behavior->EditValue = HtmlEncode($this->mobile_fraud_behavior->CurrentValue);
            $this->mobile_fraud_behavior->PlaceHolder = RemoveHtml($this->mobile_fraud_behavior->caption());

            // face_similarity_score
            $this->face_similarity_score->setupEditAttributes();
            $this->face_similarity_score->EditCustomAttributes = "";
            if (!$this->face_similarity_score->Raw) {
                $this->face_similarity_score->CurrentValue = HtmlDecode($this->face_similarity_score->CurrentValue);
            }
            $this->face_similarity_score->EditValue = HtmlEncode($this->face_similarity_score->CurrentValue);
            $this->face_similarity_score->PlaceHolder = RemoveHtml($this->face_similarity_score->caption());

            // identification_verification_matched_flag
            $this->identification_verification_matched_flag->setupEditAttributes();
            $this->identification_verification_matched_flag->EditCustomAttributes = "";
            if (!$this->identification_verification_matched_flag->Raw) {
                $this->identification_verification_matched_flag->CurrentValue = HtmlDecode($this->identification_verification_matched_flag->CurrentValue);
            }
            $this->identification_verification_matched_flag->EditValue = HtmlEncode($this->identification_verification_matched_flag->CurrentValue);
            $this->identification_verification_matched_flag->PlaceHolder = RemoveHtml($this->identification_verification_matched_flag->caption());

            // bankstatement_confident_score
            $this->bankstatement_confident_score->setupEditAttributes();
            $this->bankstatement_confident_score->EditCustomAttributes = "";
            if (!$this->bankstatement_confident_score->Raw) {
                $this->bankstatement_confident_score->CurrentValue = HtmlDecode($this->bankstatement_confident_score->CurrentValue);
            }
            $this->bankstatement_confident_score->EditValue = HtmlEncode($this->bankstatement_confident_score->CurrentValue);
            $this->bankstatement_confident_score->PlaceHolder = RemoveHtml($this->bankstatement_confident_score->caption());

            // estimated_monthly_income
            $this->estimated_monthly_income->setupEditAttributes();
            $this->estimated_monthly_income->EditCustomAttributes = "";
            if (!$this->estimated_monthly_income->Raw) {
                $this->estimated_monthly_income->CurrentValue = HtmlDecode($this->estimated_monthly_income->CurrentValue);
            }
            $this->estimated_monthly_income->EditValue = HtmlEncode($this->estimated_monthly_income->CurrentValue);
            $this->estimated_monthly_income->PlaceHolder = RemoveHtml($this->estimated_monthly_income->caption());

            // estimated_monthly_debt
            $this->estimated_monthly_debt->setupEditAttributes();
            $this->estimated_monthly_debt->EditCustomAttributes = "";
            if (!$this->estimated_monthly_debt->Raw) {
                $this->estimated_monthly_debt->CurrentValue = HtmlDecode($this->estimated_monthly_debt->CurrentValue);
            }
            $this->estimated_monthly_debt->EditValue = HtmlEncode($this->estimated_monthly_debt->CurrentValue);
            $this->estimated_monthly_debt->PlaceHolder = RemoveHtml($this->estimated_monthly_debt->caption());

            // income_stability
            $this->income_stability->setupEditAttributes();
            $this->income_stability->EditCustomAttributes = "";
            if (!$this->income_stability->Raw) {
                $this->income_stability->CurrentValue = HtmlDecode($this->income_stability->CurrentValue);
            }
            $this->income_stability->EditValue = HtmlEncode($this->income_stability->CurrentValue);
            $this->income_stability->PlaceHolder = RemoveHtml($this->income_stability->caption());

            // customer_grade
            $this->customer_grade->setupEditAttributes();
            $this->customer_grade->EditCustomAttributes = "";
            if (!$this->customer_grade->Raw) {
                $this->customer_grade->CurrentValue = HtmlDecode($this->customer_grade->CurrentValue);
            }
            $this->customer_grade->EditValue = HtmlEncode($this->customer_grade->CurrentValue);
            $this->customer_grade->PlaceHolder = RemoveHtml($this->customer_grade->caption());

            // color_sign
            $this->color_sign->setupEditAttributes();
            $this->color_sign->EditCustomAttributes = "";
            if (!$this->color_sign->Raw) {
                $this->color_sign->CurrentValue = HtmlDecode($this->color_sign->CurrentValue);
            }
            $this->color_sign->EditValue = HtmlEncode($this->color_sign->CurrentValue);
            $this->color_sign->PlaceHolder = RemoveHtml($this->color_sign->caption());

            // rental_period
            $this->rental_period->setupEditAttributes();
            $this->rental_period->EditCustomAttributes = "";
            $this->rental_period->EditValue = HtmlEncode($this->rental_period->CurrentValue);
            $this->rental_period->PlaceHolder = RemoveHtml($this->rental_period->caption());
            if (strval($this->rental_period->EditValue) != "" && is_numeric($this->rental_period->EditValue)) {
                $this->rental_period->EditValue = FormatNumber($this->rental_period->EditValue, null);
            }

            // Add refer script

            // reference_id
            $this->reference_id->LinkCustomAttributes = "";
            $this->reference_id->HrefValue = "";

            // reference_url
            $this->reference_url->LinkCustomAttributes = "";
            $this->reference_url->HrefValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";

            // refreshtoken
            $this->refreshtoken->LinkCustomAttributes = "";
            $this->refreshtoken->HrefValue = "";

            // auth_code
            $this->auth_code->LinkCustomAttributes = "";
            $this->auth_code->HrefValue = "";

            // token
            $this->_token->LinkCustomAttributes = "";
            $this->_token->HrefValue = "";

            // state
            $this->state->LinkCustomAttributes = "";
            $this->state->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // at_expire_in
            $this->at_expire_in->LinkCustomAttributes = "";
            $this->at_expire_in->HrefValue = "";

            // rt_expire_in
            $this->rt_expire_in->LinkCustomAttributes = "";
            $this->rt_expire_in->HrefValue = "";

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";

            // decision_status
            $this->decision_status->LinkCustomAttributes = "";
            $this->decision_status->HrefValue = "";

            // decision_timestamp
            $this->decision_timestamp->LinkCustomAttributes = "";
            $this->decision_timestamp->HrefValue = "";

            // deposit_amount
            $this->deposit_amount->LinkCustomAttributes = "";
            $this->deposit_amount->HrefValue = "";

            // due_date
            $this->due_date->LinkCustomAttributes = "";
            $this->due_date->HrefValue = "";

            // rental_fee
            $this->rental_fee->LinkCustomAttributes = "";
            $this->rental_fee->HrefValue = "";

            // fullName
            $this->fullName->LinkCustomAttributes = "";
            $this->fullName->HrefValue = "";

            // age
            $this->age->LinkCustomAttributes = "";
            $this->age->HrefValue = "";

            // maritalStatus
            $this->maritalStatus->LinkCustomAttributes = "";
            $this->maritalStatus->HrefValue = "";

            // noOfChildren
            $this->noOfChildren->LinkCustomAttributes = "";
            $this->noOfChildren->HrefValue = "";

            // educationLevel
            $this->educationLevel->LinkCustomAttributes = "";
            $this->educationLevel->HrefValue = "";

            // workplace
            $this->workplace->LinkCustomAttributes = "";
            $this->workplace->HrefValue = "";

            // occupation
            $this->occupation->LinkCustomAttributes = "";
            $this->occupation->HrefValue = "";

            // jobPosition
            $this->jobPosition->LinkCustomAttributes = "";
            $this->jobPosition->HrefValue = "";

            // submissionDate
            $this->submissionDate->LinkCustomAttributes = "";
            $this->submissionDate->HrefValue = "";

            // bankruptcy_tendency
            $this->bankruptcy_tendency->LinkCustomAttributes = "";
            $this->bankruptcy_tendency->HrefValue = "";

            // blacklist_tendency
            $this->blacklist_tendency->LinkCustomAttributes = "";
            $this->blacklist_tendency->HrefValue = "";

            // money_laundering_tendency
            $this->money_laundering_tendency->LinkCustomAttributes = "";
            $this->money_laundering_tendency->HrefValue = "";

            // mobile_fraud_behavior
            $this->mobile_fraud_behavior->LinkCustomAttributes = "";
            $this->mobile_fraud_behavior->HrefValue = "";

            // face_similarity_score
            $this->face_similarity_score->LinkCustomAttributes = "";
            $this->face_similarity_score->HrefValue = "";

            // identification_verification_matched_flag
            $this->identification_verification_matched_flag->LinkCustomAttributes = "";
            $this->identification_verification_matched_flag->HrefValue = "";

            // bankstatement_confident_score
            $this->bankstatement_confident_score->LinkCustomAttributes = "";
            $this->bankstatement_confident_score->HrefValue = "";

            // estimated_monthly_income
            $this->estimated_monthly_income->LinkCustomAttributes = "";
            $this->estimated_monthly_income->HrefValue = "";

            // estimated_monthly_debt
            $this->estimated_monthly_debt->LinkCustomAttributes = "";
            $this->estimated_monthly_debt->HrefValue = "";

            // income_stability
            $this->income_stability->LinkCustomAttributes = "";
            $this->income_stability->HrefValue = "";

            // customer_grade
            $this->customer_grade->LinkCustomAttributes = "";
            $this->customer_grade->HrefValue = "";

            // color_sign
            $this->color_sign->LinkCustomAttributes = "";
            $this->color_sign->HrefValue = "";

            // rental_period
            $this->rental_period->LinkCustomAttributes = "";
            $this->rental_period->HrefValue = "";
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
        if ($this->reference_id->Required) {
            if (!$this->reference_id->IsDetailKey && EmptyValue($this->reference_id->FormValue)) {
                $this->reference_id->addErrorMessage(str_replace("%s", $this->reference_id->caption(), $this->reference_id->RequiredErrorMessage));
            }
        }
        if ($this->reference_url->Required) {
            if (!$this->reference_url->IsDetailKey && EmptyValue($this->reference_url->FormValue)) {
                $this->reference_url->addErrorMessage(str_replace("%s", $this->reference_url->caption(), $this->reference_url->RequiredErrorMessage));
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
        if ($this->refreshtoken->Required) {
            if (!$this->refreshtoken->IsDetailKey && EmptyValue($this->refreshtoken->FormValue)) {
                $this->refreshtoken->addErrorMessage(str_replace("%s", $this->refreshtoken->caption(), $this->refreshtoken->RequiredErrorMessage));
            }
        }
        if ($this->auth_code->Required) {
            if (!$this->auth_code->IsDetailKey && EmptyValue($this->auth_code->FormValue)) {
                $this->auth_code->addErrorMessage(str_replace("%s", $this->auth_code->caption(), $this->auth_code->RequiredErrorMessage));
            }
        }
        if ($this->_token->Required) {
            if (!$this->_token->IsDetailKey && EmptyValue($this->_token->FormValue)) {
                $this->_token->addErrorMessage(str_replace("%s", $this->_token->caption(), $this->_token->RequiredErrorMessage));
            }
        }
        if ($this->state->Required) {
            if (!$this->state->IsDetailKey && EmptyValue($this->state->FormValue)) {
                $this->state->addErrorMessage(str_replace("%s", $this->state->caption(), $this->state->RequiredErrorMessage));
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
        if (!CheckInteger($this->cuser->FormValue)) {
            $this->cuser->addErrorMessage($this->cuser->getErrorMessage(false));
        }
        if ($this->cip->Required) {
            if (!$this->cip->IsDetailKey && EmptyValue($this->cip->FormValue)) {
                $this->cip->addErrorMessage(str_replace("%s", $this->cip->caption(), $this->cip->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->at_expire_in->Required) {
            if (!$this->at_expire_in->IsDetailKey && EmptyValue($this->at_expire_in->FormValue)) {
                $this->at_expire_in->addErrorMessage(str_replace("%s", $this->at_expire_in->caption(), $this->at_expire_in->RequiredErrorMessage));
            }
        }
        if ($this->rt_expire_in->Required) {
            if (!$this->rt_expire_in->IsDetailKey && EmptyValue($this->rt_expire_in->FormValue)) {
                $this->rt_expire_in->addErrorMessage(str_replace("%s", $this->rt_expire_in->caption(), $this->rt_expire_in->RequiredErrorMessage));
            }
        }
        if ($this->asset_id->Required) {
            if (!$this->asset_id->IsDetailKey && EmptyValue($this->asset_id->FormValue)) {
                $this->asset_id->addErrorMessage(str_replace("%s", $this->asset_id->caption(), $this->asset_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->asset_id->FormValue)) {
            $this->asset_id->addErrorMessage($this->asset_id->getErrorMessage(false));
        }
        if ($this->decision_status->Required) {
            if (!$this->decision_status->IsDetailKey && EmptyValue($this->decision_status->FormValue)) {
                $this->decision_status->addErrorMessage(str_replace("%s", $this->decision_status->caption(), $this->decision_status->RequiredErrorMessage));
            }
        }
        if ($this->decision_timestamp->Required) {
            if (!$this->decision_timestamp->IsDetailKey && EmptyValue($this->decision_timestamp->FormValue)) {
                $this->decision_timestamp->addErrorMessage(str_replace("%s", $this->decision_timestamp->caption(), $this->decision_timestamp->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->decision_timestamp->FormValue, $this->decision_timestamp->formatPattern())) {
            $this->decision_timestamp->addErrorMessage($this->decision_timestamp->getErrorMessage(false));
        }
        if ($this->deposit_amount->Required) {
            if (!$this->deposit_amount->IsDetailKey && EmptyValue($this->deposit_amount->FormValue)) {
                $this->deposit_amount->addErrorMessage(str_replace("%s", $this->deposit_amount->caption(), $this->deposit_amount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->deposit_amount->FormValue)) {
            $this->deposit_amount->addErrorMessage($this->deposit_amount->getErrorMessage(false));
        }
        if ($this->due_date->Required) {
            if (!$this->due_date->IsDetailKey && EmptyValue($this->due_date->FormValue)) {
                $this->due_date->addErrorMessage(str_replace("%s", $this->due_date->caption(), $this->due_date->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->due_date->FormValue)) {
            $this->due_date->addErrorMessage($this->due_date->getErrorMessage(false));
        }
        if ($this->rental_fee->Required) {
            if (!$this->rental_fee->IsDetailKey && EmptyValue($this->rental_fee->FormValue)) {
                $this->rental_fee->addErrorMessage(str_replace("%s", $this->rental_fee->caption(), $this->rental_fee->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->rental_fee->FormValue)) {
            $this->rental_fee->addErrorMessage($this->rental_fee->getErrorMessage(false));
        }
        if ($this->fullName->Required) {
            if (!$this->fullName->IsDetailKey && EmptyValue($this->fullName->FormValue)) {
                $this->fullName->addErrorMessage(str_replace("%s", $this->fullName->caption(), $this->fullName->RequiredErrorMessage));
            }
        }
        if ($this->age->Required) {
            if (!$this->age->IsDetailKey && EmptyValue($this->age->FormValue)) {
                $this->age->addErrorMessage(str_replace("%s", $this->age->caption(), $this->age->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->age->FormValue)) {
            $this->age->addErrorMessage($this->age->getErrorMessage(false));
        }
        if ($this->maritalStatus->Required) {
            if (!$this->maritalStatus->IsDetailKey && EmptyValue($this->maritalStatus->FormValue)) {
                $this->maritalStatus->addErrorMessage(str_replace("%s", $this->maritalStatus->caption(), $this->maritalStatus->RequiredErrorMessage));
            }
        }
        if ($this->noOfChildren->Required) {
            if (!$this->noOfChildren->IsDetailKey && EmptyValue($this->noOfChildren->FormValue)) {
                $this->noOfChildren->addErrorMessage(str_replace("%s", $this->noOfChildren->caption(), $this->noOfChildren->RequiredErrorMessage));
            }
        }
        if ($this->educationLevel->Required) {
            if (!$this->educationLevel->IsDetailKey && EmptyValue($this->educationLevel->FormValue)) {
                $this->educationLevel->addErrorMessage(str_replace("%s", $this->educationLevel->caption(), $this->educationLevel->RequiredErrorMessage));
            }
        }
        if ($this->workplace->Required) {
            if (!$this->workplace->IsDetailKey && EmptyValue($this->workplace->FormValue)) {
                $this->workplace->addErrorMessage(str_replace("%s", $this->workplace->caption(), $this->workplace->RequiredErrorMessage));
            }
        }
        if ($this->occupation->Required) {
            if (!$this->occupation->IsDetailKey && EmptyValue($this->occupation->FormValue)) {
                $this->occupation->addErrorMessage(str_replace("%s", $this->occupation->caption(), $this->occupation->RequiredErrorMessage));
            }
        }
        if ($this->jobPosition->Required) {
            if (!$this->jobPosition->IsDetailKey && EmptyValue($this->jobPosition->FormValue)) {
                $this->jobPosition->addErrorMessage(str_replace("%s", $this->jobPosition->caption(), $this->jobPosition->RequiredErrorMessage));
            }
        }
        if ($this->submissionDate->Required) {
            if (!$this->submissionDate->IsDetailKey && EmptyValue($this->submissionDate->FormValue)) {
                $this->submissionDate->addErrorMessage(str_replace("%s", $this->submissionDate->caption(), $this->submissionDate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->submissionDate->FormValue, $this->submissionDate->formatPattern())) {
            $this->submissionDate->addErrorMessage($this->submissionDate->getErrorMessage(false));
        }
        if ($this->bankruptcy_tendency->Required) {
            if (!$this->bankruptcy_tendency->IsDetailKey && EmptyValue($this->bankruptcy_tendency->FormValue)) {
                $this->bankruptcy_tendency->addErrorMessage(str_replace("%s", $this->bankruptcy_tendency->caption(), $this->bankruptcy_tendency->RequiredErrorMessage));
            }
        }
        if ($this->blacklist_tendency->Required) {
            if (!$this->blacklist_tendency->IsDetailKey && EmptyValue($this->blacklist_tendency->FormValue)) {
                $this->blacklist_tendency->addErrorMessage(str_replace("%s", $this->blacklist_tendency->caption(), $this->blacklist_tendency->RequiredErrorMessage));
            }
        }
        if ($this->money_laundering_tendency->Required) {
            if (!$this->money_laundering_tendency->IsDetailKey && EmptyValue($this->money_laundering_tendency->FormValue)) {
                $this->money_laundering_tendency->addErrorMessage(str_replace("%s", $this->money_laundering_tendency->caption(), $this->money_laundering_tendency->RequiredErrorMessage));
            }
        }
        if ($this->mobile_fraud_behavior->Required) {
            if (!$this->mobile_fraud_behavior->IsDetailKey && EmptyValue($this->mobile_fraud_behavior->FormValue)) {
                $this->mobile_fraud_behavior->addErrorMessage(str_replace("%s", $this->mobile_fraud_behavior->caption(), $this->mobile_fraud_behavior->RequiredErrorMessage));
            }
        }
        if ($this->face_similarity_score->Required) {
            if (!$this->face_similarity_score->IsDetailKey && EmptyValue($this->face_similarity_score->FormValue)) {
                $this->face_similarity_score->addErrorMessage(str_replace("%s", $this->face_similarity_score->caption(), $this->face_similarity_score->RequiredErrorMessage));
            }
        }
        if ($this->identification_verification_matched_flag->Required) {
            if (!$this->identification_verification_matched_flag->IsDetailKey && EmptyValue($this->identification_verification_matched_flag->FormValue)) {
                $this->identification_verification_matched_flag->addErrorMessage(str_replace("%s", $this->identification_verification_matched_flag->caption(), $this->identification_verification_matched_flag->RequiredErrorMessage));
            }
        }
        if ($this->bankstatement_confident_score->Required) {
            if (!$this->bankstatement_confident_score->IsDetailKey && EmptyValue($this->bankstatement_confident_score->FormValue)) {
                $this->bankstatement_confident_score->addErrorMessage(str_replace("%s", $this->bankstatement_confident_score->caption(), $this->bankstatement_confident_score->RequiredErrorMessage));
            }
        }
        if ($this->estimated_monthly_income->Required) {
            if (!$this->estimated_monthly_income->IsDetailKey && EmptyValue($this->estimated_monthly_income->FormValue)) {
                $this->estimated_monthly_income->addErrorMessage(str_replace("%s", $this->estimated_monthly_income->caption(), $this->estimated_monthly_income->RequiredErrorMessage));
            }
        }
        if ($this->estimated_monthly_debt->Required) {
            if (!$this->estimated_monthly_debt->IsDetailKey && EmptyValue($this->estimated_monthly_debt->FormValue)) {
                $this->estimated_monthly_debt->addErrorMessage(str_replace("%s", $this->estimated_monthly_debt->caption(), $this->estimated_monthly_debt->RequiredErrorMessage));
            }
        }
        if ($this->income_stability->Required) {
            if (!$this->income_stability->IsDetailKey && EmptyValue($this->income_stability->FormValue)) {
                $this->income_stability->addErrorMessage(str_replace("%s", $this->income_stability->caption(), $this->income_stability->RequiredErrorMessage));
            }
        }
        if ($this->customer_grade->Required) {
            if (!$this->customer_grade->IsDetailKey && EmptyValue($this->customer_grade->FormValue)) {
                $this->customer_grade->addErrorMessage(str_replace("%s", $this->customer_grade->caption(), $this->customer_grade->RequiredErrorMessage));
            }
        }
        if ($this->color_sign->Required) {
            if (!$this->color_sign->IsDetailKey && EmptyValue($this->color_sign->FormValue)) {
                $this->color_sign->addErrorMessage(str_replace("%s", $this->color_sign->caption(), $this->color_sign->RequiredErrorMessage));
            }
        }
        if ($this->rental_period->Required) {
            if (!$this->rental_period->IsDetailKey && EmptyValue($this->rental_period->FormValue)) {
                $this->rental_period->addErrorMessage(str_replace("%s", $this->rental_period->caption(), $this->rental_period->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->rental_period->FormValue)) {
            $this->rental_period->addErrorMessage($this->rental_period->getErrorMessage(false));
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

        // reference_id
        $this->reference_id->setDbValueDef($rsnew, $this->reference_id->CurrentValue, null, false);

        // reference_url
        $this->reference_url->setDbValueDef($rsnew, $this->reference_url->CurrentValue, null, false);

        // member_id
        $this->member_id->setDbValueDef($rsnew, $this->member_id->CurrentValue, null, false);

        // refreshtoken
        $this->refreshtoken->setDbValueDef($rsnew, $this->refreshtoken->CurrentValue, null, false);

        // auth_code
        $this->auth_code->setDbValueDef($rsnew, $this->auth_code->CurrentValue, null, false);

        // token
        $this->_token->setDbValueDef($rsnew, $this->_token->CurrentValue, null, false);

        // state
        $this->state->setDbValueDef($rsnew, $this->state->CurrentValue, null, false);

        // cdate
        $this->cdate->setDbValueDef($rsnew, UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern()), null, false);

        // cuser
        $this->cuser->setDbValueDef($rsnew, $this->cuser->CurrentValue, null, false);

        // cip
        $this->cip->setDbValueDef($rsnew, $this->cip->CurrentValue, null, false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, false);

        // at_expire_in
        $this->at_expire_in->setDbValueDef($rsnew, $this->at_expire_in->CurrentValue, null, false);

        // rt_expire_in
        $this->rt_expire_in->setDbValueDef($rsnew, $this->rt_expire_in->CurrentValue, null, false);

        // asset_id
        $this->asset_id->setDbValueDef($rsnew, $this->asset_id->CurrentValue, null, false);

        // decision_status
        $this->decision_status->setDbValueDef($rsnew, $this->decision_status->CurrentValue, null, false);

        // decision_timestamp
        $this->decision_timestamp->setDbValueDef($rsnew, UnFormatDateTime($this->decision_timestamp->CurrentValue, $this->decision_timestamp->formatPattern()), null, false);

        // deposit_amount
        $this->deposit_amount->setDbValueDef($rsnew, $this->deposit_amount->CurrentValue, null, false);

        // due_date
        $this->due_date->setDbValueDef($rsnew, $this->due_date->CurrentValue, null, false);

        // rental_fee
        $this->rental_fee->setDbValueDef($rsnew, $this->rental_fee->CurrentValue, null, false);

        // fullName
        $this->fullName->setDbValueDef($rsnew, $this->fullName->CurrentValue, null, false);

        // age
        $this->age->setDbValueDef($rsnew, $this->age->CurrentValue, null, false);

        // maritalStatus
        $this->maritalStatus->setDbValueDef($rsnew, $this->maritalStatus->CurrentValue, null, false);

        // noOfChildren
        $this->noOfChildren->setDbValueDef($rsnew, $this->noOfChildren->CurrentValue, null, false);

        // educationLevel
        $this->educationLevel->setDbValueDef($rsnew, $this->educationLevel->CurrentValue, null, false);

        // workplace
        $this->workplace->setDbValueDef($rsnew, $this->workplace->CurrentValue, null, false);

        // occupation
        $this->occupation->setDbValueDef($rsnew, $this->occupation->CurrentValue, null, false);

        // jobPosition
        $this->jobPosition->setDbValueDef($rsnew, $this->jobPosition->CurrentValue, null, false);

        // submissionDate
        $this->submissionDate->setDbValueDef($rsnew, UnFormatDateTime($this->submissionDate->CurrentValue, $this->submissionDate->formatPattern()), null, false);

        // bankruptcy_tendency
        $this->bankruptcy_tendency->setDbValueDef($rsnew, $this->bankruptcy_tendency->CurrentValue, null, false);

        // blacklist_tendency
        $this->blacklist_tendency->setDbValueDef($rsnew, $this->blacklist_tendency->CurrentValue, null, false);

        // money_laundering_tendency
        $this->money_laundering_tendency->setDbValueDef($rsnew, $this->money_laundering_tendency->CurrentValue, null, false);

        // mobile_fraud_behavior
        $this->mobile_fraud_behavior->setDbValueDef($rsnew, $this->mobile_fraud_behavior->CurrentValue, null, false);

        // face_similarity_score
        $this->face_similarity_score->setDbValueDef($rsnew, $this->face_similarity_score->CurrentValue, null, false);

        // identification_verification_matched_flag
        $this->identification_verification_matched_flag->setDbValueDef($rsnew, $this->identification_verification_matched_flag->CurrentValue, null, false);

        // bankstatement_confident_score
        $this->bankstatement_confident_score->setDbValueDef($rsnew, $this->bankstatement_confident_score->CurrentValue, null, false);

        // estimated_monthly_income
        $this->estimated_monthly_income->setDbValueDef($rsnew, $this->estimated_monthly_income->CurrentValue, null, false);

        // estimated_monthly_debt
        $this->estimated_monthly_debt->setDbValueDef($rsnew, $this->estimated_monthly_debt->CurrentValue, null, false);

        // income_stability
        $this->income_stability->setDbValueDef($rsnew, $this->income_stability->CurrentValue, null, false);

        // customer_grade
        $this->customer_grade->setDbValueDef($rsnew, $this->customer_grade->CurrentValue, null, false);

        // color_sign
        $this->color_sign->setDbValueDef($rsnew, $this->color_sign->CurrentValue, null, false);

        // rental_period
        $this->rental_period->setDbValueDef($rsnew, $this->rental_period->CurrentValue, null, false);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("logmemberscblist"), "", $this->TableVar, true);
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
