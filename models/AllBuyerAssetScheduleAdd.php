<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class AllBuyerAssetScheduleAdd extends AllBuyerAssetSchedule
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'all_buyer_asset_schedule';

    // Page object name
    public $PageObjName = "AllBuyerAssetScheduleAdd";

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

        // Table object (all_buyer_asset_schedule)
        if (!isset($GLOBALS["all_buyer_asset_schedule"]) || get_class($GLOBALS["all_buyer_asset_schedule"]) == PROJECT_NAMESPACE . "all_buyer_asset_schedule") {
            $GLOBALS["all_buyer_asset_schedule"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'all_buyer_asset_schedule');
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
                $tbl = Container("all_buyer_asset_schedule");
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
                    if ($pageName == "allbuyerassetscheduleview") {
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
            $key .= @$ar['buyer_asset_schedule_id'];
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
            $this->buyer_asset_schedule_id->Visible = false;
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
        $this->buyer_asset_schedule_id->Visible = false;
        $this->buyer_config_asset_schedule_id->Visible = false;
        $this->asset_id->setVisibility();
        $this->member_id->setVisibility();
        $this->num_installment->setVisibility();
        $this->installment_per_price->setVisibility();
        $this->interest->setVisibility();
        $this->principal->setVisibility();
        $this->remaining_principal->setVisibility();
        $this->pay_number->setVisibility();
        $this->expired_date->setVisibility();
        $this->date_payment->setVisibility();
        $this->status_payment->setVisibility();
        $this->cuser->setVisibility();
        $this->cdate->setVisibility();
        $this->cip->setVisibility();
        $this->uuser->setVisibility();
        $this->udate->setVisibility();
        $this->uip->setVisibility();
        $this->transaction_datetime->Visible = false;
        $this->payment_scheme->Visible = false;
        $this->transaction_ref->Visible = false;
        $this->channel_response_desc->Visible = false;
        $this->res_status->Visible = false;
        $this->res_referenceNo->Visible = false;
        $this->installment_all->Visible = false;
        $this->res_paidAgent->Visible = false;
        $this->res_paidChannel->Visible = false;
        $this->res_maskedPan->Visible = false;
        $this->receive_per_installment_invertor->Visible = false;
        $this->receive_per_installment->Visible = false;
        $this->is_email->Visible = false;
        $this->receipt_status->Visible = false;
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
        $this->setupLookupOptions($this->asset_id);
        $this->setupLookupOptions($this->member_id);
        $this->setupLookupOptions($this->status_payment);

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
            if (($keyValue = Get("buyer_asset_schedule_id") ?? Route("buyer_asset_schedule_id")) !== null) {
                $this->buyer_asset_schedule_id->setQueryStringValue($keyValue);
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
                    $this->terminate("allbuyerassetschedulelist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "allbuyerassetschedulelist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "allbuyerassetscheduleview") {
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
        $this->buyer_asset_schedule_id->CurrentValue = null;
        $this->buyer_asset_schedule_id->OldValue = $this->buyer_asset_schedule_id->CurrentValue;
        $this->buyer_config_asset_schedule_id->CurrentValue = null;
        $this->buyer_config_asset_schedule_id->OldValue = $this->buyer_config_asset_schedule_id->CurrentValue;
        $this->asset_id->CurrentValue = null;
        $this->asset_id->OldValue = $this->asset_id->CurrentValue;
        $this->member_id->CurrentValue = null;
        $this->member_id->OldValue = $this->member_id->CurrentValue;
        $this->num_installment->CurrentValue = null;
        $this->num_installment->OldValue = $this->num_installment->CurrentValue;
        $this->installment_per_price->CurrentValue = null;
        $this->installment_per_price->OldValue = $this->installment_per_price->CurrentValue;
        $this->interest->CurrentValue = null;
        $this->interest->OldValue = $this->interest->CurrentValue;
        $this->principal->CurrentValue = null;
        $this->principal->OldValue = $this->principal->CurrentValue;
        $this->remaining_principal->CurrentValue = null;
        $this->remaining_principal->OldValue = $this->remaining_principal->CurrentValue;
        $this->pay_number->CurrentValue = null;
        $this->pay_number->OldValue = $this->pay_number->CurrentValue;
        $this->expired_date->CurrentValue = null;
        $this->expired_date->OldValue = $this->expired_date->CurrentValue;
        $this->date_payment->CurrentValue = null;
        $this->date_payment->OldValue = $this->date_payment->CurrentValue;
        $this->status_payment->CurrentValue = 1;
        $this->cuser->CurrentValue = null;
        $this->cuser->OldValue = $this->cuser->CurrentValue;
        $this->cdate->CurrentValue = null;
        $this->cdate->OldValue = $this->cdate->CurrentValue;
        $this->cip->CurrentValue = null;
        $this->cip->OldValue = $this->cip->CurrentValue;
        $this->uuser->CurrentValue = null;
        $this->uuser->OldValue = $this->uuser->CurrentValue;
        $this->udate->CurrentValue = null;
        $this->udate->OldValue = $this->udate->CurrentValue;
        $this->uip->CurrentValue = null;
        $this->uip->OldValue = $this->uip->CurrentValue;
        $this->transaction_datetime->CurrentValue = null;
        $this->transaction_datetime->OldValue = $this->transaction_datetime->CurrentValue;
        $this->payment_scheme->CurrentValue = null;
        $this->payment_scheme->OldValue = $this->payment_scheme->CurrentValue;
        $this->transaction_ref->CurrentValue = null;
        $this->transaction_ref->OldValue = $this->transaction_ref->CurrentValue;
        $this->channel_response_desc->CurrentValue = null;
        $this->channel_response_desc->OldValue = $this->channel_response_desc->CurrentValue;
        $this->res_status->CurrentValue = null;
        $this->res_status->OldValue = $this->res_status->CurrentValue;
        $this->res_referenceNo->CurrentValue = null;
        $this->res_referenceNo->OldValue = $this->res_referenceNo->CurrentValue;
        $this->installment_all->CurrentValue = null;
        $this->installment_all->OldValue = $this->installment_all->CurrentValue;
        $this->res_paidAgent->CurrentValue = null;
        $this->res_paidAgent->OldValue = $this->res_paidAgent->CurrentValue;
        $this->res_paidChannel->CurrentValue = null;
        $this->res_paidChannel->OldValue = $this->res_paidChannel->CurrentValue;
        $this->res_maskedPan->CurrentValue = null;
        $this->res_maskedPan->OldValue = $this->res_maskedPan->CurrentValue;
        $this->receive_per_installment_invertor->CurrentValue = null;
        $this->receive_per_installment_invertor->OldValue = $this->receive_per_installment_invertor->CurrentValue;
        $this->receive_per_installment->CurrentValue = null;
        $this->receive_per_installment->OldValue = $this->receive_per_installment->CurrentValue;
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

        // Check field name 'asset_id' first before field var 'x_asset_id'
        $val = $CurrentForm->hasValue("asset_id") ? $CurrentForm->getValue("asset_id") : $CurrentForm->getValue("x_asset_id");
        if (!$this->asset_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_id->Visible = false; // Disable update for API request
            } else {
                $this->asset_id->setFormValue($val);
            }
        }

        // Check field name 'member_id' first before field var 'x_member_id'
        $val = $CurrentForm->hasValue("member_id") ? $CurrentForm->getValue("member_id") : $CurrentForm->getValue("x_member_id");
        if (!$this->member_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->member_id->Visible = false; // Disable update for API request
            } else {
                $this->member_id->setFormValue($val);
            }
        }

        // Check field name 'num_installment' first before field var 'x_num_installment'
        $val = $CurrentForm->hasValue("num_installment") ? $CurrentForm->getValue("num_installment") : $CurrentForm->getValue("x_num_installment");
        if (!$this->num_installment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->num_installment->Visible = false; // Disable update for API request
            } else {
                $this->num_installment->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'installment_per_price' first before field var 'x_installment_per_price'
        $val = $CurrentForm->hasValue("installment_per_price") ? $CurrentForm->getValue("installment_per_price") : $CurrentForm->getValue("x_installment_per_price");
        if (!$this->installment_per_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->installment_per_price->Visible = false; // Disable update for API request
            } else {
                $this->installment_per_price->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'interest' first before field var 'x_interest'
        $val = $CurrentForm->hasValue("interest") ? $CurrentForm->getValue("interest") : $CurrentForm->getValue("x_interest");
        if (!$this->interest->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->interest->Visible = false; // Disable update for API request
            } else {
                $this->interest->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'principal' first before field var 'x_principal'
        $val = $CurrentForm->hasValue("principal") ? $CurrentForm->getValue("principal") : $CurrentForm->getValue("x_principal");
        if (!$this->principal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->principal->Visible = false; // Disable update for API request
            } else {
                $this->principal->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'remaining_principal' first before field var 'x_remaining_principal'
        $val = $CurrentForm->hasValue("remaining_principal") ? $CurrentForm->getValue("remaining_principal") : $CurrentForm->getValue("x_remaining_principal");
        if (!$this->remaining_principal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->remaining_principal->Visible = false; // Disable update for API request
            } else {
                $this->remaining_principal->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'pay_number' first before field var 'x_pay_number'
        $val = $CurrentForm->hasValue("pay_number") ? $CurrentForm->getValue("pay_number") : $CurrentForm->getValue("x_pay_number");
        if (!$this->pay_number->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pay_number->Visible = false; // Disable update for API request
            } else {
                $this->pay_number->setFormValue($val);
            }
        }

        // Check field name 'expired_date' first before field var 'x_expired_date'
        $val = $CurrentForm->hasValue("expired_date") ? $CurrentForm->getValue("expired_date") : $CurrentForm->getValue("x_expired_date");
        if (!$this->expired_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->expired_date->Visible = false; // Disable update for API request
            } else {
                $this->expired_date->setFormValue($val, true, $validate);
            }
            $this->expired_date->CurrentValue = UnFormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern());
        }

        // Check field name 'date_payment' first before field var 'x_date_payment'
        $val = $CurrentForm->hasValue("date_payment") ? $CurrentForm->getValue("date_payment") : $CurrentForm->getValue("x_date_payment");
        if (!$this->date_payment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->date_payment->Visible = false; // Disable update for API request
            } else {
                $this->date_payment->setFormValue($val, true, $validate);
            }
            $this->date_payment->CurrentValue = UnFormatDateTime($this->date_payment->CurrentValue, $this->date_payment->formatPattern());
        }

        // Check field name 'status_payment' first before field var 'x_status_payment'
        $val = $CurrentForm->hasValue("status_payment") ? $CurrentForm->getValue("status_payment") : $CurrentForm->getValue("x_status_payment");
        if (!$this->status_payment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_payment->Visible = false; // Disable update for API request
            } else {
                $this->status_payment->setFormValue($val);
            }
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

        // Check field name 'buyer_asset_schedule_id' first before field var 'x_buyer_asset_schedule_id'
        $val = $CurrentForm->hasValue("buyer_asset_schedule_id") ? $CurrentForm->getValue("buyer_asset_schedule_id") : $CurrentForm->getValue("x_buyer_asset_schedule_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->asset_id->CurrentValue = $this->asset_id->FormValue;
        $this->member_id->CurrentValue = $this->member_id->FormValue;
        $this->num_installment->CurrentValue = $this->num_installment->FormValue;
        $this->installment_per_price->CurrentValue = $this->installment_per_price->FormValue;
        $this->interest->CurrentValue = $this->interest->FormValue;
        $this->principal->CurrentValue = $this->principal->FormValue;
        $this->remaining_principal->CurrentValue = $this->remaining_principal->FormValue;
        $this->pay_number->CurrentValue = $this->pay_number->FormValue;
        $this->expired_date->CurrentValue = $this->expired_date->FormValue;
        $this->expired_date->CurrentValue = UnFormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern());
        $this->date_payment->CurrentValue = $this->date_payment->FormValue;
        $this->date_payment->CurrentValue = UnFormatDateTime($this->date_payment->CurrentValue, $this->date_payment->formatPattern());
        $this->status_payment->CurrentValue = $this->status_payment->FormValue;
        $this->cuser->CurrentValue = $this->cuser->FormValue;
        $this->cdate->CurrentValue = $this->cdate->FormValue;
        $this->cdate->CurrentValue = UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
        $this->cip->CurrentValue = $this->cip->FormValue;
        $this->uuser->CurrentValue = $this->uuser->FormValue;
        $this->udate->CurrentValue = $this->udate->FormValue;
        $this->udate->CurrentValue = UnFormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern());
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
        $this->buyer_asset_schedule_id->setDbValue($row['buyer_asset_schedule_id']);
        $this->buyer_config_asset_schedule_id->setDbValue($row['buyer_config_asset_schedule_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->num_installment->setDbValue($row['num_installment']);
        $this->installment_per_price->setDbValue($row['installment_per_price']);
        $this->interest->setDbValue($row['interest']);
        $this->principal->setDbValue($row['principal']);
        $this->remaining_principal->setDbValue($row['remaining_principal']);
        $this->pay_number->setDbValue($row['pay_number']);
        $this->expired_date->setDbValue($row['expired_date']);
        $this->date_payment->setDbValue($row['date_payment']);
        $this->status_payment->setDbValue($row['status_payment']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cip->setDbValue($row['cip']);
        $this->uuser->setDbValue($row['uuser']);
        $this->udate->setDbValue($row['udate']);
        $this->uip->setDbValue($row['uip']);
        $this->transaction_datetime->setDbValue($row['transaction_datetime']);
        $this->payment_scheme->setDbValue($row['payment_scheme']);
        $this->transaction_ref->setDbValue($row['transaction_ref']);
        $this->channel_response_desc->setDbValue($row['channel_response_desc']);
        $this->res_status->setDbValue($row['res_status']);
        $this->res_referenceNo->setDbValue($row['res_referenceNo']);
        $this->installment_all->setDbValue($row['installment_all']);
        $this->res_paidAgent->setDbValue($row['res_paidAgent']);
        $this->res_paidChannel->setDbValue($row['res_paidChannel']);
        $this->res_maskedPan->setDbValue($row['res_maskedPan']);
        $this->receive_per_installment_invertor->setDbValue($row['receive_per_installment_invertor']);
        $this->receive_per_installment->setDbValue($row['receive_per_installment']);
        $this->is_email->setDbValue($row['is_email']);
        $this->receipt_status->setDbValue($row['receipt_status']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['buyer_asset_schedule_id'] = $this->buyer_asset_schedule_id->CurrentValue;
        $row['buyer_config_asset_schedule_id'] = $this->buyer_config_asset_schedule_id->CurrentValue;
        $row['asset_id'] = $this->asset_id->CurrentValue;
        $row['member_id'] = $this->member_id->CurrentValue;
        $row['num_installment'] = $this->num_installment->CurrentValue;
        $row['installment_per_price'] = $this->installment_per_price->CurrentValue;
        $row['interest'] = $this->interest->CurrentValue;
        $row['principal'] = $this->principal->CurrentValue;
        $row['remaining_principal'] = $this->remaining_principal->CurrentValue;
        $row['pay_number'] = $this->pay_number->CurrentValue;
        $row['expired_date'] = $this->expired_date->CurrentValue;
        $row['date_payment'] = $this->date_payment->CurrentValue;
        $row['status_payment'] = $this->status_payment->CurrentValue;
        $row['cuser'] = $this->cuser->CurrentValue;
        $row['cdate'] = $this->cdate->CurrentValue;
        $row['cip'] = $this->cip->CurrentValue;
        $row['uuser'] = $this->uuser->CurrentValue;
        $row['udate'] = $this->udate->CurrentValue;
        $row['uip'] = $this->uip->CurrentValue;
        $row['transaction_datetime'] = $this->transaction_datetime->CurrentValue;
        $row['payment_scheme'] = $this->payment_scheme->CurrentValue;
        $row['transaction_ref'] = $this->transaction_ref->CurrentValue;
        $row['channel_response_desc'] = $this->channel_response_desc->CurrentValue;
        $row['res_status'] = $this->res_status->CurrentValue;
        $row['res_referenceNo'] = $this->res_referenceNo->CurrentValue;
        $row['installment_all'] = $this->installment_all->CurrentValue;
        $row['res_paidAgent'] = $this->res_paidAgent->CurrentValue;
        $row['res_paidChannel'] = $this->res_paidChannel->CurrentValue;
        $row['res_maskedPan'] = $this->res_maskedPan->CurrentValue;
        $row['receive_per_installment_invertor'] = $this->receive_per_installment_invertor->CurrentValue;
        $row['receive_per_installment'] = $this->receive_per_installment->CurrentValue;
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

        // buyer_asset_schedule_id
        $this->buyer_asset_schedule_id->RowCssClass = "row";

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->RowCssClass = "row";

        // asset_id
        $this->asset_id->RowCssClass = "row";

        // member_id
        $this->member_id->RowCssClass = "row";

        // num_installment
        $this->num_installment->RowCssClass = "row";

        // installment_per_price
        $this->installment_per_price->RowCssClass = "row";

        // interest
        $this->interest->RowCssClass = "row";

        // principal
        $this->principal->RowCssClass = "row";

        // remaining_principal
        $this->remaining_principal->RowCssClass = "row";

        // pay_number
        $this->pay_number->RowCssClass = "row";

        // expired_date
        $this->expired_date->RowCssClass = "row";

        // date_payment
        $this->date_payment->RowCssClass = "row";

        // status_payment
        $this->status_payment->RowCssClass = "row";

        // cuser
        $this->cuser->RowCssClass = "row";

        // cdate
        $this->cdate->RowCssClass = "row";

        // cip
        $this->cip->RowCssClass = "row";

        // uuser
        $this->uuser->RowCssClass = "row";

        // udate
        $this->udate->RowCssClass = "row";

        // uip
        $this->uip->RowCssClass = "row";

        // transaction_datetime
        $this->transaction_datetime->RowCssClass = "row";

        // payment_scheme
        $this->payment_scheme->RowCssClass = "row";

        // transaction_ref
        $this->transaction_ref->RowCssClass = "row";

        // channel_response_desc
        $this->channel_response_desc->RowCssClass = "row";

        // res_status
        $this->res_status->RowCssClass = "row";

        // res_referenceNo
        $this->res_referenceNo->RowCssClass = "row";

        // installment_all
        $this->installment_all->RowCssClass = "row";

        // res_paidAgent
        $this->res_paidAgent->RowCssClass = "row";

        // res_paidChannel
        $this->res_paidChannel->RowCssClass = "row";

        // res_maskedPan
        $this->res_maskedPan->RowCssClass = "row";

        // receive_per_installment_invertor
        $this->receive_per_installment_invertor->RowCssClass = "row";

        // receive_per_installment
        $this->receive_per_installment->RowCssClass = "row";

        // is_email
        $this->is_email->RowCssClass = "row";

        // receipt_status
        $this->receipt_status->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
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

            // num_installment
            $this->num_installment->ViewValue = $this->num_installment->CurrentValue;
            $this->num_installment->ViewValue = FormatNumber($this->num_installment->ViewValue, $this->num_installment->formatPattern());
            $this->num_installment->ViewCustomAttributes = "";

            // installment_per_price
            $this->installment_per_price->ViewValue = $this->installment_per_price->CurrentValue;
            $this->installment_per_price->ViewValue = FormatCurrency($this->installment_per_price->ViewValue, $this->installment_per_price->formatPattern());
            $this->installment_per_price->ViewCustomAttributes = "";

            // interest
            $this->interest->ViewValue = $this->interest->CurrentValue;
            $this->interest->ViewValue = FormatNumber($this->interest->ViewValue, $this->interest->formatPattern());
            $this->interest->ViewCustomAttributes = "";

            // principal
            $this->principal->ViewValue = $this->principal->CurrentValue;
            $this->principal->ViewValue = FormatNumber($this->principal->ViewValue, $this->principal->formatPattern());
            $this->principal->ViewCustomAttributes = "";

            // remaining_principal
            $this->remaining_principal->ViewValue = $this->remaining_principal->CurrentValue;
            $this->remaining_principal->ViewValue = FormatNumber($this->remaining_principal->ViewValue, $this->remaining_principal->formatPattern());
            $this->remaining_principal->ViewCustomAttributes = "";

            // pay_number
            $this->pay_number->ViewValue = $this->pay_number->CurrentValue;
            $this->pay_number->ViewCustomAttributes = "";

            // expired_date
            $this->expired_date->ViewValue = $this->expired_date->CurrentValue;
            $this->expired_date->ViewValue = FormatDateTime($this->expired_date->ViewValue, $this->expired_date->formatPattern());
            $this->expired_date->ViewCustomAttributes = "";

            // date_payment
            $this->date_payment->ViewValue = $this->date_payment->CurrentValue;
            $this->date_payment->ViewValue = FormatDateTime($this->date_payment->ViewValue, $this->date_payment->formatPattern());
            $this->date_payment->ViewCustomAttributes = "";

            // status_payment
            if (strval($this->status_payment->CurrentValue) != "") {
                $this->status_payment->ViewValue = $this->status_payment->optionCaption($this->status_payment->CurrentValue);
            } else {
                $this->status_payment->ViewValue = null;
            }
            $this->status_payment->ViewCustomAttributes = "";

            // cuser
            $this->cuser->ViewValue = $this->cuser->CurrentValue;
            $this->cuser->ViewCustomAttributes = "";

            // cdate
            $this->cdate->ViewValue = $this->cdate->CurrentValue;
            $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
            $this->cdate->ViewCustomAttributes = "";

            // cip
            $this->cip->ViewValue = $this->cip->CurrentValue;
            $this->cip->ViewCustomAttributes = "";

            // uuser
            $this->uuser->ViewValue = $this->uuser->CurrentValue;
            $this->uuser->ViewCustomAttributes = "";

            // udate
            $this->udate->ViewValue = $this->udate->CurrentValue;
            $this->udate->ViewValue = FormatDateTime($this->udate->ViewValue, $this->udate->formatPattern());
            $this->udate->ViewCustomAttributes = "";

            // uip
            $this->uip->ViewValue = $this->uip->CurrentValue;
            $this->uip->ViewCustomAttributes = "";

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";
            $this->asset_id->TooltipValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // num_installment
            $this->num_installment->LinkCustomAttributes = "";
            $this->num_installment->HrefValue = "";

            // installment_per_price
            $this->installment_per_price->LinkCustomAttributes = "";
            $this->installment_per_price->HrefValue = "";

            // interest
            $this->interest->LinkCustomAttributes = "";
            $this->interest->HrefValue = "";

            // principal
            $this->principal->LinkCustomAttributes = "";
            $this->principal->HrefValue = "";

            // remaining_principal
            $this->remaining_principal->LinkCustomAttributes = "";
            $this->remaining_principal->HrefValue = "";

            // pay_number
            $this->pay_number->LinkCustomAttributes = "";
            $this->pay_number->HrefValue = "";
            $this->pay_number->TooltipValue = "";

            // expired_date
            $this->expired_date->LinkCustomAttributes = "";
            $this->expired_date->HrefValue = "";

            // date_payment
            $this->date_payment->LinkCustomAttributes = "";
            $this->date_payment->HrefValue = "";
            $this->date_payment->TooltipValue = "";

            // status_payment
            $this->status_payment->LinkCustomAttributes = "";
            $this->status_payment->HrefValue = "";
            $this->status_payment->TooltipValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
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

            // member_id
            $this->member_id->setupEditAttributes();
            $this->member_id->EditCustomAttributes = "";
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
                $sqlWrk = $this->member_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->member_id->EditValue = $arwrk;
            }
            $this->member_id->PlaceHolder = RemoveHtml($this->member_id->caption());

            // num_installment
            $this->num_installment->setupEditAttributes();
            $this->num_installment->EditCustomAttributes = "";
            $this->num_installment->EditValue = HtmlEncode($this->num_installment->CurrentValue);
            $this->num_installment->PlaceHolder = RemoveHtml($this->num_installment->caption());
            if (strval($this->num_installment->EditValue) != "" && is_numeric($this->num_installment->EditValue)) {
                $this->num_installment->EditValue = FormatNumber($this->num_installment->EditValue, null);
            }

            // installment_per_price
            $this->installment_per_price->setupEditAttributes();
            $this->installment_per_price->EditCustomAttributes = "";
            $this->installment_per_price->EditValue = HtmlEncode($this->installment_per_price->CurrentValue);
            $this->installment_per_price->PlaceHolder = RemoveHtml($this->installment_per_price->caption());
            if (strval($this->installment_per_price->EditValue) != "" && is_numeric($this->installment_per_price->EditValue)) {
                $this->installment_per_price->EditValue = FormatNumber($this->installment_per_price->EditValue, null);
            }

            // interest
            $this->interest->setupEditAttributes();
            $this->interest->EditCustomAttributes = "";
            $this->interest->EditValue = HtmlEncode($this->interest->CurrentValue);
            $this->interest->PlaceHolder = RemoveHtml($this->interest->caption());
            if (strval($this->interest->EditValue) != "" && is_numeric($this->interest->EditValue)) {
                $this->interest->EditValue = FormatNumber($this->interest->EditValue, null);
            }

            // principal
            $this->principal->setupEditAttributes();
            $this->principal->EditCustomAttributes = "";
            $this->principal->EditValue = HtmlEncode($this->principal->CurrentValue);
            $this->principal->PlaceHolder = RemoveHtml($this->principal->caption());
            if (strval($this->principal->EditValue) != "" && is_numeric($this->principal->EditValue)) {
                $this->principal->EditValue = FormatNumber($this->principal->EditValue, null);
            }

            // remaining_principal
            $this->remaining_principal->setupEditAttributes();
            $this->remaining_principal->EditCustomAttributes = "";
            $this->remaining_principal->EditValue = HtmlEncode($this->remaining_principal->CurrentValue);
            $this->remaining_principal->PlaceHolder = RemoveHtml($this->remaining_principal->caption());
            if (strval($this->remaining_principal->EditValue) != "" && is_numeric($this->remaining_principal->EditValue)) {
                $this->remaining_principal->EditValue = FormatNumber($this->remaining_principal->EditValue, null);
            }

            // pay_number
            $this->pay_number->setupEditAttributes();
            $this->pay_number->EditCustomAttributes = "";
            if (!$this->pay_number->Raw) {
                $this->pay_number->CurrentValue = HtmlDecode($this->pay_number->CurrentValue);
            }
            $this->pay_number->EditValue = HtmlEncode($this->pay_number->CurrentValue);
            $this->pay_number->PlaceHolder = RemoveHtml($this->pay_number->caption());

            // expired_date
            $this->expired_date->setupEditAttributes();
            $this->expired_date->EditCustomAttributes = "";
            $this->expired_date->EditValue = HtmlEncode(FormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern()));
            $this->expired_date->PlaceHolder = RemoveHtml($this->expired_date->caption());

            // date_payment
            $this->date_payment->setupEditAttributes();
            $this->date_payment->EditCustomAttributes = "";
            $this->date_payment->EditValue = HtmlEncode(FormatDateTime($this->date_payment->CurrentValue, $this->date_payment->formatPattern()));
            $this->date_payment->PlaceHolder = RemoveHtml($this->date_payment->caption());

            // status_payment
            $this->status_payment->setupEditAttributes();
            $this->status_payment->EditCustomAttributes = "";
            $this->status_payment->EditValue = $this->status_payment->options(true);
            $this->status_payment->PlaceHolder = RemoveHtml($this->status_payment->caption());

            // cuser

            // cdate

            // cip

            // uuser

            // udate

            // uip

            // Add refer script

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";

            // num_installment
            $this->num_installment->LinkCustomAttributes = "";
            $this->num_installment->HrefValue = "";

            // installment_per_price
            $this->installment_per_price->LinkCustomAttributes = "";
            $this->installment_per_price->HrefValue = "";

            // interest
            $this->interest->LinkCustomAttributes = "";
            $this->interest->HrefValue = "";

            // principal
            $this->principal->LinkCustomAttributes = "";
            $this->principal->HrefValue = "";

            // remaining_principal
            $this->remaining_principal->LinkCustomAttributes = "";
            $this->remaining_principal->HrefValue = "";

            // pay_number
            $this->pay_number->LinkCustomAttributes = "";
            $this->pay_number->HrefValue = "";

            // expired_date
            $this->expired_date->LinkCustomAttributes = "";
            $this->expired_date->HrefValue = "";

            // date_payment
            $this->date_payment->LinkCustomAttributes = "";
            $this->date_payment->HrefValue = "";

            // status_payment
            $this->status_payment->LinkCustomAttributes = "";
            $this->status_payment->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";

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
        if ($this->asset_id->Required) {
            if (!$this->asset_id->IsDetailKey && EmptyValue($this->asset_id->FormValue)) {
                $this->asset_id->addErrorMessage(str_replace("%s", $this->asset_id->caption(), $this->asset_id->RequiredErrorMessage));
            }
        }
        if ($this->member_id->Required) {
            if (!$this->member_id->IsDetailKey && EmptyValue($this->member_id->FormValue)) {
                $this->member_id->addErrorMessage(str_replace("%s", $this->member_id->caption(), $this->member_id->RequiredErrorMessage));
            }
        }
        if ($this->num_installment->Required) {
            if (!$this->num_installment->IsDetailKey && EmptyValue($this->num_installment->FormValue)) {
                $this->num_installment->addErrorMessage(str_replace("%s", $this->num_installment->caption(), $this->num_installment->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->num_installment->FormValue)) {
            $this->num_installment->addErrorMessage($this->num_installment->getErrorMessage(false));
        }
        if ($this->installment_per_price->Required) {
            if (!$this->installment_per_price->IsDetailKey && EmptyValue($this->installment_per_price->FormValue)) {
                $this->installment_per_price->addErrorMessage(str_replace("%s", $this->installment_per_price->caption(), $this->installment_per_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->installment_per_price->FormValue)) {
            $this->installment_per_price->addErrorMessage($this->installment_per_price->getErrorMessage(false));
        }
        if ($this->interest->Required) {
            if (!$this->interest->IsDetailKey && EmptyValue($this->interest->FormValue)) {
                $this->interest->addErrorMessage(str_replace("%s", $this->interest->caption(), $this->interest->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->interest->FormValue)) {
            $this->interest->addErrorMessage($this->interest->getErrorMessage(false));
        }
        if ($this->principal->Required) {
            if (!$this->principal->IsDetailKey && EmptyValue($this->principal->FormValue)) {
                $this->principal->addErrorMessage(str_replace("%s", $this->principal->caption(), $this->principal->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->principal->FormValue)) {
            $this->principal->addErrorMessage($this->principal->getErrorMessage(false));
        }
        if ($this->remaining_principal->Required) {
            if (!$this->remaining_principal->IsDetailKey && EmptyValue($this->remaining_principal->FormValue)) {
                $this->remaining_principal->addErrorMessage(str_replace("%s", $this->remaining_principal->caption(), $this->remaining_principal->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->remaining_principal->FormValue)) {
            $this->remaining_principal->addErrorMessage($this->remaining_principal->getErrorMessage(false));
        }
        if ($this->pay_number->Required) {
            if (!$this->pay_number->IsDetailKey && EmptyValue($this->pay_number->FormValue)) {
                $this->pay_number->addErrorMessage(str_replace("%s", $this->pay_number->caption(), $this->pay_number->RequiredErrorMessage));
            }
        }
        if ($this->expired_date->Required) {
            if (!$this->expired_date->IsDetailKey && EmptyValue($this->expired_date->FormValue)) {
                $this->expired_date->addErrorMessage(str_replace("%s", $this->expired_date->caption(), $this->expired_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->expired_date->FormValue, $this->expired_date->formatPattern())) {
            $this->expired_date->addErrorMessage($this->expired_date->getErrorMessage(false));
        }
        if ($this->date_payment->Required) {
            if (!$this->date_payment->IsDetailKey && EmptyValue($this->date_payment->FormValue)) {
                $this->date_payment->addErrorMessage(str_replace("%s", $this->date_payment->caption(), $this->date_payment->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->date_payment->FormValue, $this->date_payment->formatPattern())) {
            $this->date_payment->addErrorMessage($this->date_payment->getErrorMessage(false));
        }
        if ($this->status_payment->Required) {
            if (!$this->status_payment->IsDetailKey && EmptyValue($this->status_payment->FormValue)) {
                $this->status_payment->addErrorMessage(str_replace("%s", $this->status_payment->caption(), $this->status_payment->RequiredErrorMessage));
            }
        }
        if ($this->cuser->Required) {
            if (!$this->cuser->IsDetailKey && EmptyValue($this->cuser->FormValue)) {
                $this->cuser->addErrorMessage(str_replace("%s", $this->cuser->caption(), $this->cuser->RequiredErrorMessage));
            }
        }
        if ($this->cdate->Required) {
            if (!$this->cdate->IsDetailKey && EmptyValue($this->cdate->FormValue)) {
                $this->cdate->addErrorMessage(str_replace("%s", $this->cdate->caption(), $this->cdate->RequiredErrorMessage));
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

        // asset_id
        $this->asset_id->setDbValueDef($rsnew, $this->asset_id->CurrentValue, 0, false);

        // member_id
        $this->member_id->setDbValueDef($rsnew, $this->member_id->CurrentValue, 0, false);

        // num_installment
        $this->num_installment->setDbValueDef($rsnew, $this->num_installment->CurrentValue, null, false);

        // installment_per_price
        $this->installment_per_price->setDbValueDef($rsnew, $this->installment_per_price->CurrentValue, null, false);

        // interest
        $this->interest->setDbValueDef($rsnew, $this->interest->CurrentValue, null, false);

        // principal
        $this->principal->setDbValueDef($rsnew, $this->principal->CurrentValue, null, false);

        // remaining_principal
        $this->remaining_principal->setDbValueDef($rsnew, $this->remaining_principal->CurrentValue, null, false);

        // pay_number
        $this->pay_number->setDbValueDef($rsnew, $this->pay_number->CurrentValue, null, false);

        // expired_date
        $this->expired_date->setDbValueDef($rsnew, UnFormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern()), null, false);

        // date_payment
        $this->date_payment->setDbValueDef($rsnew, UnFormatDateTime($this->date_payment->CurrentValue, $this->date_payment->formatPattern()), null, false);

        // status_payment
        $this->status_payment->setDbValueDef($rsnew, $this->status_payment->CurrentValue, null, strval($this->status_payment->CurrentValue) == "");

        // cuser
        $this->cuser->CurrentValue = CurrentUserID();
        $this->cuser->setDbValueDef($rsnew, $this->cuser->CurrentValue, null);

        // cdate
        $this->cdate->CurrentValue = CurrentDateTime();
        $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

        // cip
        $this->cip->CurrentValue = CurrentUserIP();
        $this->cip->setDbValueDef($rsnew, $this->cip->CurrentValue, null);

        // uuser
        $this->uuser->CurrentValue = CurrentUserID();
        $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, null);

        // udate
        $this->udate->CurrentValue = CurrentDateTime();
        $this->udate->setDbValueDef($rsnew, $this->udate->CurrentValue, null);

        // uip
        $this->uip->CurrentValue = CurrentUserIP();
        $this->uip->setDbValueDef($rsnew, $this->uip->CurrentValue, null);

        // buyer_config_asset_schedule_id
        if ($this->buyer_config_asset_schedule_id->getSessionValue() != "") {
            $rsnew['buyer_config_asset_schedule_id'] = $this->buyer_config_asset_schedule_id->getSessionValue();
        }

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
            if ($masterTblVar == "all_buyer_config_asset_schedule") {
                $validMaster = true;
                $masterTbl = Container("all_buyer_config_asset_schedule");
                if (($parm = Get("fk_buyer_config_asset_schedule_id", Get("buyer_config_asset_schedule_id"))) !== null) {
                    $masterTbl->buyer_config_asset_schedule_id->setQueryStringValue($parm);
                    $this->buyer_config_asset_schedule_id->setQueryStringValue($masterTbl->buyer_config_asset_schedule_id->QueryStringValue);
                    $this->buyer_config_asset_schedule_id->setSessionValue($this->buyer_config_asset_schedule_id->QueryStringValue);
                    if (!is_numeric($masterTbl->buyer_config_asset_schedule_id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "number_deals_available") {
                $validMaster = true;
                $masterTbl = Container("number_deals_available");
                if (($parm = Get("fk_buyer_config_asset_schedule_id", Get("buyer_config_asset_schedule_id"))) !== null) {
                    $masterTbl->buyer_config_asset_schedule_id->setQueryStringValue($parm);
                    $this->buyer_config_asset_schedule_id->setQueryStringValue($masterTbl->buyer_config_asset_schedule_id->QueryStringValue);
                    $this->buyer_config_asset_schedule_id->setSessionValue($this->buyer_config_asset_schedule_id->QueryStringValue);
                    if (!is_numeric($masterTbl->buyer_config_asset_schedule_id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "number_of_accrued") {
                $validMaster = true;
                $masterTbl = Container("number_of_accrued");
                if (($parm = Get("fk_buyer_config_asset_schedule_id", Get("buyer_config_asset_schedule_id"))) !== null) {
                    $masterTbl->buyer_config_asset_schedule_id->setQueryStringValue($parm);
                    $this->buyer_config_asset_schedule_id->setQueryStringValue($masterTbl->buyer_config_asset_schedule_id->QueryStringValue);
                    $this->buyer_config_asset_schedule_id->setSessionValue($this->buyer_config_asset_schedule_id->QueryStringValue);
                    if (!is_numeric($masterTbl->buyer_config_asset_schedule_id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "number_of_unpaid_units") {
                $validMaster = true;
                $masterTbl = Container("number_of_unpaid_units");
                if (($parm = Get("fk_buyer_config_asset_schedule_id", Get("buyer_config_asset_schedule_id"))) !== null) {
                    $masterTbl->buyer_config_asset_schedule_id->setQueryStringValue($parm);
                    $this->buyer_config_asset_schedule_id->setQueryStringValue($masterTbl->buyer_config_asset_schedule_id->QueryStringValue);
                    $this->buyer_config_asset_schedule_id->setSessionValue($this->buyer_config_asset_schedule_id->QueryStringValue);
                    if (!is_numeric($masterTbl->buyer_config_asset_schedule_id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "outstanding_amount") {
                $validMaster = true;
                $masterTbl = Container("outstanding_amount");
                if (($parm = Get("fk_buyer_config_asset_schedule_id", Get("buyer_config_asset_schedule_id"))) !== null) {
                    $masterTbl->buyer_config_asset_schedule_id->setQueryStringValue($parm);
                    $this->buyer_config_asset_schedule_id->setQueryStringValue($masterTbl->buyer_config_asset_schedule_id->QueryStringValue);
                    $this->buyer_config_asset_schedule_id->setSessionValue($this->buyer_config_asset_schedule_id->QueryStringValue);
                    if (!is_numeric($masterTbl->buyer_config_asset_schedule_id->QueryStringValue)) {
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
            if ($masterTblVar == "all_buyer_config_asset_schedule") {
                $validMaster = true;
                $masterTbl = Container("all_buyer_config_asset_schedule");
                if (($parm = Post("fk_buyer_config_asset_schedule_id", Post("buyer_config_asset_schedule_id"))) !== null) {
                    $masterTbl->buyer_config_asset_schedule_id->setFormValue($parm);
                    $this->buyer_config_asset_schedule_id->setFormValue($masterTbl->buyer_config_asset_schedule_id->FormValue);
                    $this->buyer_config_asset_schedule_id->setSessionValue($this->buyer_config_asset_schedule_id->FormValue);
                    if (!is_numeric($masterTbl->buyer_config_asset_schedule_id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "number_deals_available") {
                $validMaster = true;
                $masterTbl = Container("number_deals_available");
                if (($parm = Post("fk_buyer_config_asset_schedule_id", Post("buyer_config_asset_schedule_id"))) !== null) {
                    $masterTbl->buyer_config_asset_schedule_id->setFormValue($parm);
                    $this->buyer_config_asset_schedule_id->setFormValue($masterTbl->buyer_config_asset_schedule_id->FormValue);
                    $this->buyer_config_asset_schedule_id->setSessionValue($this->buyer_config_asset_schedule_id->FormValue);
                    if (!is_numeric($masterTbl->buyer_config_asset_schedule_id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "number_of_accrued") {
                $validMaster = true;
                $masterTbl = Container("number_of_accrued");
                if (($parm = Post("fk_buyer_config_asset_schedule_id", Post("buyer_config_asset_schedule_id"))) !== null) {
                    $masterTbl->buyer_config_asset_schedule_id->setFormValue($parm);
                    $this->buyer_config_asset_schedule_id->setFormValue($masterTbl->buyer_config_asset_schedule_id->FormValue);
                    $this->buyer_config_asset_schedule_id->setSessionValue($this->buyer_config_asset_schedule_id->FormValue);
                    if (!is_numeric($masterTbl->buyer_config_asset_schedule_id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "number_of_unpaid_units") {
                $validMaster = true;
                $masterTbl = Container("number_of_unpaid_units");
                if (($parm = Post("fk_buyer_config_asset_schedule_id", Post("buyer_config_asset_schedule_id"))) !== null) {
                    $masterTbl->buyer_config_asset_schedule_id->setFormValue($parm);
                    $this->buyer_config_asset_schedule_id->setFormValue($masterTbl->buyer_config_asset_schedule_id->FormValue);
                    $this->buyer_config_asset_schedule_id->setSessionValue($this->buyer_config_asset_schedule_id->FormValue);
                    if (!is_numeric($masterTbl->buyer_config_asset_schedule_id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "outstanding_amount") {
                $validMaster = true;
                $masterTbl = Container("outstanding_amount");
                if (($parm = Post("fk_buyer_config_asset_schedule_id", Post("buyer_config_asset_schedule_id"))) !== null) {
                    $masterTbl->buyer_config_asset_schedule_id->setFormValue($parm);
                    $this->buyer_config_asset_schedule_id->setFormValue($masterTbl->buyer_config_asset_schedule_id->FormValue);
                    $this->buyer_config_asset_schedule_id->setSessionValue($this->buyer_config_asset_schedule_id->FormValue);
                    if (!is_numeric($masterTbl->buyer_config_asset_schedule_id->FormValue)) {
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
            if ($masterTblVar != "all_buyer_config_asset_schedule") {
                if ($this->buyer_config_asset_schedule_id->CurrentValue == "") {
                    $this->buyer_config_asset_schedule_id->setSessionValue("");
                }
            }
            if ($masterTblVar != "number_deals_available") {
                if ($this->buyer_config_asset_schedule_id->CurrentValue == "") {
                    $this->buyer_config_asset_schedule_id->setSessionValue("");
                }
            }
            if ($masterTblVar != "number_of_accrued") {
                if ($this->buyer_config_asset_schedule_id->CurrentValue == "") {
                    $this->buyer_config_asset_schedule_id->setSessionValue("");
                }
            }
            if ($masterTblVar != "number_of_unpaid_units") {
                if ($this->buyer_config_asset_schedule_id->CurrentValue == "") {
                    $this->buyer_config_asset_schedule_id->setSessionValue("");
                }
            }
            if ($masterTblVar != "outstanding_amount") {
                if ($this->buyer_config_asset_schedule_id->CurrentValue == "") {
                    $this->buyer_config_asset_schedule_id->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("allbuyerassetschedulelist"), "", $this->TableVar, true);
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
                case "x_asset_id":
                    $conn = Conn("DB");
                    break;
                case "x_member_id":
                    $conn = Conn("DB");
                    break;
                case "x_status_payment":
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

        // $asset_id = @$_GET['fk_asset_id'];
        if(isset($_GET['fk_asset_id'])) {
            $asset_id = @$_GET['fk_asset_id'];
            $sql_buyer_booking = "SELECT * FROM `buyer_booking_asset` WHERE asset_id = ".$asset_id." AND status_payment = 2 LIMIT 0,1";
            $res_booking = ExecuteRow($sql_buyer_booking);
            $fk_member_id = $res_booking['member_id'];

            // Set Member ID Auto
            $this->member_id->setDbValue($fk_member_id);
            // echo "asset_id " .$asset_id;
            // echo "member_id " .$fk_member_id;
        }
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
