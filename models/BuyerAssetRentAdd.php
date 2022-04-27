<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class BuyerAssetRentAdd extends BuyerAssetRent
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'buyer_asset_rent';

    // Page object name
    public $PageObjName = "BuyerAssetRentAdd";

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

        // Table object (buyer_asset_rent)
        if (!isset($GLOBALS["buyer_asset_rent"]) || get_class($GLOBALS["buyer_asset_rent"]) == PROJECT_NAMESPACE . "buyer_asset_rent") {
            $GLOBALS["buyer_asset_rent"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'buyer_asset_rent');
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
                $tbl = Container("buyer_asset_rent");
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
                    if ($pageName == "buyerassetrentview") {
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
            $key .= @$ar['buyer_asset_rent_id'];
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
            $this->buyer_asset_rent_id->Visible = false;
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
        $this->buyer_asset_rent_id->Visible = false;
        $this->asset_id->setVisibility();
        $this->member_id->setVisibility();
        $this->one_time_status->setVisibility();
        $this->half_price_1->setVisibility();
        $this->status_pay_half_price_1->setVisibility();
        $this->pay_number_half_price_1->setVisibility();
        $this->date_pay_half_price_1->setVisibility();
        $this->due_date_pay_half_price_1->setVisibility();
        $this->half_price_2->setVisibility();
        $this->status_pay_half_price_2->setVisibility();
        $this->pay_number_half_price_2->setVisibility();
        $this->date_pay_half_price_2->setVisibility();
        $this->due_date_pay_half_price_2->setVisibility();
        $this->transaction_datetime1->Visible = false;
        $this->payment_scheme1->Visible = false;
        $this->transaction_ref1->Visible = false;
        $this->channel_response_desc1->Visible = false;
        $this->res_status1->Visible = false;
        $this->res_referenceNo1->Visible = false;
        $this->transaction_datetime2->Visible = false;
        $this->payment_scheme2->Visible = false;
        $this->transaction_ref2->Visible = false;
        $this->channel_response_desc2->Visible = false;
        $this->res_status2->Visible = false;
        $this->res_referenceNo2->Visible = false;
        $this->status_approve->Visible = false;
        $this->cdate->setVisibility();
        $this->cip->setVisibility();
        $this->cuser->setVisibility();
        $this->uuser->setVisibility();
        $this->uip->setVisibility();
        $this->udate->setVisibility();
        $this->res_paidAgent1->Visible = false;
        $this->res_paidChannel1->Visible = false;
        $this->res_maskedPan1->Visible = false;
        $this->res_paidAgent2->Visible = false;
        $this->res_paidChannel2->Visible = false;
        $this->res_maskedPan2->Visible = false;
        $this->is_email1->Visible = false;
        $this->is_email2->Visible = false;
        $this->receipt_status1->Visible = false;
        $this->receipt_status2->Visible = false;
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
        $this->setupLookupOptions($this->one_time_status);
        $this->setupLookupOptions($this->status_pay_half_price_1);
        $this->setupLookupOptions($this->status_pay_half_price_2);

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
            if (($keyValue = Get("buyer_asset_rent_id") ?? Route("buyer_asset_rent_id")) !== null) {
                $this->buyer_asset_rent_id->setQueryStringValue($keyValue);
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
                    $this->terminate("buyerassetrentlist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "buyerassetrentlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "buyerassetrentview") {
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
        $this->buyer_asset_rent_id->CurrentValue = null;
        $this->buyer_asset_rent_id->OldValue = $this->buyer_asset_rent_id->CurrentValue;
        $this->asset_id->CurrentValue = null;
        $this->asset_id->OldValue = $this->asset_id->CurrentValue;
        $this->member_id->CurrentValue = null;
        $this->member_id->OldValue = $this->member_id->CurrentValue;
        $this->one_time_status->CurrentValue = 0;
        $this->half_price_1->CurrentValue = null;
        $this->half_price_1->OldValue = $this->half_price_1->CurrentValue;
        $this->status_pay_half_price_1->CurrentValue = 1;
        $this->pay_number_half_price_1->CurrentValue = null;
        $this->pay_number_half_price_1->OldValue = $this->pay_number_half_price_1->CurrentValue;
        $this->date_pay_half_price_1->CurrentValue = null;
        $this->date_pay_half_price_1->OldValue = $this->date_pay_half_price_1->CurrentValue;
        $this->due_date_pay_half_price_1->CurrentValue = null;
        $this->due_date_pay_half_price_1->OldValue = $this->due_date_pay_half_price_1->CurrentValue;
        $this->half_price_2->CurrentValue = null;
        $this->half_price_2->OldValue = $this->half_price_2->CurrentValue;
        $this->status_pay_half_price_2->CurrentValue = 1;
        $this->pay_number_half_price_2->CurrentValue = null;
        $this->pay_number_half_price_2->OldValue = $this->pay_number_half_price_2->CurrentValue;
        $this->date_pay_half_price_2->CurrentValue = null;
        $this->date_pay_half_price_2->OldValue = $this->date_pay_half_price_2->CurrentValue;
        $this->due_date_pay_half_price_2->CurrentValue = null;
        $this->due_date_pay_half_price_2->OldValue = $this->due_date_pay_half_price_2->CurrentValue;
        $this->transaction_datetime1->CurrentValue = null;
        $this->transaction_datetime1->OldValue = $this->transaction_datetime1->CurrentValue;
        $this->payment_scheme1->CurrentValue = null;
        $this->payment_scheme1->OldValue = $this->payment_scheme1->CurrentValue;
        $this->transaction_ref1->CurrentValue = null;
        $this->transaction_ref1->OldValue = $this->transaction_ref1->CurrentValue;
        $this->channel_response_desc1->CurrentValue = null;
        $this->channel_response_desc1->OldValue = $this->channel_response_desc1->CurrentValue;
        $this->res_status1->CurrentValue = null;
        $this->res_status1->OldValue = $this->res_status1->CurrentValue;
        $this->res_referenceNo1->CurrentValue = null;
        $this->res_referenceNo1->OldValue = $this->res_referenceNo1->CurrentValue;
        $this->transaction_datetime2->CurrentValue = null;
        $this->transaction_datetime2->OldValue = $this->transaction_datetime2->CurrentValue;
        $this->payment_scheme2->CurrentValue = null;
        $this->payment_scheme2->OldValue = $this->payment_scheme2->CurrentValue;
        $this->transaction_ref2->CurrentValue = null;
        $this->transaction_ref2->OldValue = $this->transaction_ref2->CurrentValue;
        $this->channel_response_desc2->CurrentValue = null;
        $this->channel_response_desc2->OldValue = $this->channel_response_desc2->CurrentValue;
        $this->res_status2->CurrentValue = null;
        $this->res_status2->OldValue = $this->res_status2->CurrentValue;
        $this->res_referenceNo2->CurrentValue = null;
        $this->res_referenceNo2->OldValue = $this->res_referenceNo2->CurrentValue;
        $this->status_approve->CurrentValue = 0;
        $this->cdate->CurrentValue = null;
        $this->cdate->OldValue = $this->cdate->CurrentValue;
        $this->cip->CurrentValue = null;
        $this->cip->OldValue = $this->cip->CurrentValue;
        $this->cuser->CurrentValue = null;
        $this->cuser->OldValue = $this->cuser->CurrentValue;
        $this->uuser->CurrentValue = null;
        $this->uuser->OldValue = $this->uuser->CurrentValue;
        $this->uip->CurrentValue = null;
        $this->uip->OldValue = $this->uip->CurrentValue;
        $this->udate->CurrentValue = null;
        $this->udate->OldValue = $this->udate->CurrentValue;
        $this->res_paidAgent1->CurrentValue = null;
        $this->res_paidAgent1->OldValue = $this->res_paidAgent1->CurrentValue;
        $this->res_paidChannel1->CurrentValue = null;
        $this->res_paidChannel1->OldValue = $this->res_paidChannel1->CurrentValue;
        $this->res_maskedPan1->CurrentValue = null;
        $this->res_maskedPan1->OldValue = $this->res_maskedPan1->CurrentValue;
        $this->res_paidAgent2->CurrentValue = null;
        $this->res_paidAgent2->OldValue = $this->res_paidAgent2->CurrentValue;
        $this->res_paidChannel2->CurrentValue = null;
        $this->res_paidChannel2->OldValue = $this->res_paidChannel2->CurrentValue;
        $this->res_maskedPan2->CurrentValue = null;
        $this->res_maskedPan2->OldValue = $this->res_maskedPan2->CurrentValue;
        $this->is_email1->CurrentValue = null;
        $this->is_email1->OldValue = $this->is_email1->CurrentValue;
        $this->is_email2->CurrentValue = null;
        $this->is_email2->OldValue = $this->is_email2->CurrentValue;
        $this->receipt_status1->CurrentValue = null;
        $this->receipt_status1->OldValue = $this->receipt_status1->CurrentValue;
        $this->receipt_status2->CurrentValue = null;
        $this->receipt_status2->OldValue = $this->receipt_status2->CurrentValue;
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

        // Check field name 'one_time_status' first before field var 'x_one_time_status'
        $val = $CurrentForm->hasValue("one_time_status") ? $CurrentForm->getValue("one_time_status") : $CurrentForm->getValue("x_one_time_status");
        if (!$this->one_time_status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->one_time_status->Visible = false; // Disable update for API request
            } else {
                $this->one_time_status->setFormValue($val);
            }
        }

        // Check field name 'half_price_1' first before field var 'x_half_price_1'
        $val = $CurrentForm->hasValue("half_price_1") ? $CurrentForm->getValue("half_price_1") : $CurrentForm->getValue("x_half_price_1");
        if (!$this->half_price_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->half_price_1->Visible = false; // Disable update for API request
            } else {
                $this->half_price_1->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'status_pay_half_price_1' first before field var 'x_status_pay_half_price_1'
        $val = $CurrentForm->hasValue("status_pay_half_price_1") ? $CurrentForm->getValue("status_pay_half_price_1") : $CurrentForm->getValue("x_status_pay_half_price_1");
        if (!$this->status_pay_half_price_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_pay_half_price_1->Visible = false; // Disable update for API request
            } else {
                $this->status_pay_half_price_1->setFormValue($val);
            }
        }

        // Check field name 'pay_number_half_price_1' first before field var 'x_pay_number_half_price_1'
        $val = $CurrentForm->hasValue("pay_number_half_price_1") ? $CurrentForm->getValue("pay_number_half_price_1") : $CurrentForm->getValue("x_pay_number_half_price_1");
        if (!$this->pay_number_half_price_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pay_number_half_price_1->Visible = false; // Disable update for API request
            } else {
                $this->pay_number_half_price_1->setFormValue($val);
            }
        }

        // Check field name 'date_pay_half_price_1' first before field var 'x_date_pay_half_price_1'
        $val = $CurrentForm->hasValue("date_pay_half_price_1") ? $CurrentForm->getValue("date_pay_half_price_1") : $CurrentForm->getValue("x_date_pay_half_price_1");
        if (!$this->date_pay_half_price_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->date_pay_half_price_1->Visible = false; // Disable update for API request
            } else {
                $this->date_pay_half_price_1->setFormValue($val, true, $validate);
            }
            $this->date_pay_half_price_1->CurrentValue = UnFormatDateTime($this->date_pay_half_price_1->CurrentValue, $this->date_pay_half_price_1->formatPattern());
        }

        // Check field name 'due_date_pay_half_price_1' first before field var 'x_due_date_pay_half_price_1'
        $val = $CurrentForm->hasValue("due_date_pay_half_price_1") ? $CurrentForm->getValue("due_date_pay_half_price_1") : $CurrentForm->getValue("x_due_date_pay_half_price_1");
        if (!$this->due_date_pay_half_price_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->due_date_pay_half_price_1->Visible = false; // Disable update for API request
            } else {
                $this->due_date_pay_half_price_1->setFormValue($val, true, $validate);
            }
            $this->due_date_pay_half_price_1->CurrentValue = UnFormatDateTime($this->due_date_pay_half_price_1->CurrentValue, $this->due_date_pay_half_price_1->formatPattern());
        }

        // Check field name 'half_price_2' first before field var 'x_half_price_2'
        $val = $CurrentForm->hasValue("half_price_2") ? $CurrentForm->getValue("half_price_2") : $CurrentForm->getValue("x_half_price_2");
        if (!$this->half_price_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->half_price_2->Visible = false; // Disable update for API request
            } else {
                $this->half_price_2->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'status_pay_half_price_2' first before field var 'x_status_pay_half_price_2'
        $val = $CurrentForm->hasValue("status_pay_half_price_2") ? $CurrentForm->getValue("status_pay_half_price_2") : $CurrentForm->getValue("x_status_pay_half_price_2");
        if (!$this->status_pay_half_price_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_pay_half_price_2->Visible = false; // Disable update for API request
            } else {
                $this->status_pay_half_price_2->setFormValue($val);
            }
        }

        // Check field name 'pay_number_half_price_2' first before field var 'x_pay_number_half_price_2'
        $val = $CurrentForm->hasValue("pay_number_half_price_2") ? $CurrentForm->getValue("pay_number_half_price_2") : $CurrentForm->getValue("x_pay_number_half_price_2");
        if (!$this->pay_number_half_price_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pay_number_half_price_2->Visible = false; // Disable update for API request
            } else {
                $this->pay_number_half_price_2->setFormValue($val);
            }
        }

        // Check field name 'date_pay_half_price_2' first before field var 'x_date_pay_half_price_2'
        $val = $CurrentForm->hasValue("date_pay_half_price_2") ? $CurrentForm->getValue("date_pay_half_price_2") : $CurrentForm->getValue("x_date_pay_half_price_2");
        if (!$this->date_pay_half_price_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->date_pay_half_price_2->Visible = false; // Disable update for API request
            } else {
                $this->date_pay_half_price_2->setFormValue($val, true, $validate);
            }
            $this->date_pay_half_price_2->CurrentValue = UnFormatDateTime($this->date_pay_half_price_2->CurrentValue, $this->date_pay_half_price_2->formatPattern());
        }

        // Check field name 'due_date_pay_half_price_2' first before field var 'x_due_date_pay_half_price_2'
        $val = $CurrentForm->hasValue("due_date_pay_half_price_2") ? $CurrentForm->getValue("due_date_pay_half_price_2") : $CurrentForm->getValue("x_due_date_pay_half_price_2");
        if (!$this->due_date_pay_half_price_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->due_date_pay_half_price_2->Visible = false; // Disable update for API request
            } else {
                $this->due_date_pay_half_price_2->setFormValue($val, true, $validate);
            }
            $this->due_date_pay_half_price_2->CurrentValue = UnFormatDateTime($this->due_date_pay_half_price_2->CurrentValue, $this->due_date_pay_half_price_2->formatPattern());
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

        // Check field name 'cuser' first before field var 'x_cuser'
        $val = $CurrentForm->hasValue("cuser") ? $CurrentForm->getValue("cuser") : $CurrentForm->getValue("x_cuser");
        if (!$this->cuser->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cuser->Visible = false; // Disable update for API request
            } else {
                $this->cuser->setFormValue($val);
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

        // Check field name 'buyer_asset_rent_id' first before field var 'x_buyer_asset_rent_id'
        $val = $CurrentForm->hasValue("buyer_asset_rent_id") ? $CurrentForm->getValue("buyer_asset_rent_id") : $CurrentForm->getValue("x_buyer_asset_rent_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->asset_id->CurrentValue = $this->asset_id->FormValue;
        $this->member_id->CurrentValue = $this->member_id->FormValue;
        $this->one_time_status->CurrentValue = $this->one_time_status->FormValue;
        $this->half_price_1->CurrentValue = $this->half_price_1->FormValue;
        $this->status_pay_half_price_1->CurrentValue = $this->status_pay_half_price_1->FormValue;
        $this->pay_number_half_price_1->CurrentValue = $this->pay_number_half_price_1->FormValue;
        $this->date_pay_half_price_1->CurrentValue = $this->date_pay_half_price_1->FormValue;
        $this->date_pay_half_price_1->CurrentValue = UnFormatDateTime($this->date_pay_half_price_1->CurrentValue, $this->date_pay_half_price_1->formatPattern());
        $this->due_date_pay_half_price_1->CurrentValue = $this->due_date_pay_half_price_1->FormValue;
        $this->due_date_pay_half_price_1->CurrentValue = UnFormatDateTime($this->due_date_pay_half_price_1->CurrentValue, $this->due_date_pay_half_price_1->formatPattern());
        $this->half_price_2->CurrentValue = $this->half_price_2->FormValue;
        $this->status_pay_half_price_2->CurrentValue = $this->status_pay_half_price_2->FormValue;
        $this->pay_number_half_price_2->CurrentValue = $this->pay_number_half_price_2->FormValue;
        $this->date_pay_half_price_2->CurrentValue = $this->date_pay_half_price_2->FormValue;
        $this->date_pay_half_price_2->CurrentValue = UnFormatDateTime($this->date_pay_half_price_2->CurrentValue, $this->date_pay_half_price_2->formatPattern());
        $this->due_date_pay_half_price_2->CurrentValue = $this->due_date_pay_half_price_2->FormValue;
        $this->due_date_pay_half_price_2->CurrentValue = UnFormatDateTime($this->due_date_pay_half_price_2->CurrentValue, $this->due_date_pay_half_price_2->formatPattern());
        $this->cdate->CurrentValue = $this->cdate->FormValue;
        $this->cdate->CurrentValue = UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
        $this->cip->CurrentValue = $this->cip->FormValue;
        $this->cuser->CurrentValue = $this->cuser->FormValue;
        $this->uuser->CurrentValue = $this->uuser->FormValue;
        $this->uip->CurrentValue = $this->uip->FormValue;
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
        $this->buyer_asset_rent_id->setDbValue($row['buyer_asset_rent_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->one_time_status->setDbValue($row['one_time_status']);
        $this->half_price_1->setDbValue($row['half_price_1']);
        $this->status_pay_half_price_1->setDbValue($row['status_pay_half_price_1']);
        $this->pay_number_half_price_1->setDbValue($row['pay_number_half_price_1']);
        $this->date_pay_half_price_1->setDbValue($row['date_pay_half_price_1']);
        $this->due_date_pay_half_price_1->setDbValue($row['due_date_pay_half_price_1']);
        $this->half_price_2->setDbValue($row['half_price_2']);
        $this->status_pay_half_price_2->setDbValue($row['status_pay_half_price_2']);
        $this->pay_number_half_price_2->setDbValue($row['pay_number_half_price_2']);
        $this->date_pay_half_price_2->setDbValue($row['date_pay_half_price_2']);
        $this->due_date_pay_half_price_2->setDbValue($row['due_date_pay_half_price_2']);
        $this->transaction_datetime1->setDbValue($row['transaction_datetime1']);
        $this->payment_scheme1->setDbValue($row['payment_scheme1']);
        $this->transaction_ref1->setDbValue($row['transaction_ref1']);
        $this->channel_response_desc1->setDbValue($row['channel_response_desc1']);
        $this->res_status1->setDbValue($row['res_status1']);
        $this->res_referenceNo1->setDbValue($row['res_referenceNo1']);
        $this->transaction_datetime2->setDbValue($row['transaction_datetime2']);
        $this->payment_scheme2->setDbValue($row['payment_scheme2']);
        $this->transaction_ref2->setDbValue($row['transaction_ref2']);
        $this->channel_response_desc2->setDbValue($row['channel_response_desc2']);
        $this->res_status2->setDbValue($row['res_status2']);
        $this->res_referenceNo2->setDbValue($row['res_referenceNo2']);
        $this->status_approve->setDbValue($row['status_approve']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cip->setDbValue($row['cip']);
        $this->cuser->setDbValue($row['cuser']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->udate->setDbValue($row['udate']);
        $this->res_paidAgent1->setDbValue($row['res_paidAgent1']);
        $this->res_paidChannel1->setDbValue($row['res_paidChannel1']);
        $this->res_maskedPan1->setDbValue($row['res_maskedPan1']);
        $this->res_paidAgent2->setDbValue($row['res_paidAgent2']);
        $this->res_paidChannel2->setDbValue($row['res_paidChannel2']);
        $this->res_maskedPan2->setDbValue($row['res_maskedPan2']);
        $this->is_email1->setDbValue($row['is_email1']);
        $this->is_email2->setDbValue($row['is_email2']);
        $this->receipt_status1->setDbValue($row['receipt_status1']);
        $this->receipt_status2->setDbValue($row['receipt_status2']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['buyer_asset_rent_id'] = $this->buyer_asset_rent_id->CurrentValue;
        $row['asset_id'] = $this->asset_id->CurrentValue;
        $row['member_id'] = $this->member_id->CurrentValue;
        $row['one_time_status'] = $this->one_time_status->CurrentValue;
        $row['half_price_1'] = $this->half_price_1->CurrentValue;
        $row['status_pay_half_price_1'] = $this->status_pay_half_price_1->CurrentValue;
        $row['pay_number_half_price_1'] = $this->pay_number_half_price_1->CurrentValue;
        $row['date_pay_half_price_1'] = $this->date_pay_half_price_1->CurrentValue;
        $row['due_date_pay_half_price_1'] = $this->due_date_pay_half_price_1->CurrentValue;
        $row['half_price_2'] = $this->half_price_2->CurrentValue;
        $row['status_pay_half_price_2'] = $this->status_pay_half_price_2->CurrentValue;
        $row['pay_number_half_price_2'] = $this->pay_number_half_price_2->CurrentValue;
        $row['date_pay_half_price_2'] = $this->date_pay_half_price_2->CurrentValue;
        $row['due_date_pay_half_price_2'] = $this->due_date_pay_half_price_2->CurrentValue;
        $row['transaction_datetime1'] = $this->transaction_datetime1->CurrentValue;
        $row['payment_scheme1'] = $this->payment_scheme1->CurrentValue;
        $row['transaction_ref1'] = $this->transaction_ref1->CurrentValue;
        $row['channel_response_desc1'] = $this->channel_response_desc1->CurrentValue;
        $row['res_status1'] = $this->res_status1->CurrentValue;
        $row['res_referenceNo1'] = $this->res_referenceNo1->CurrentValue;
        $row['transaction_datetime2'] = $this->transaction_datetime2->CurrentValue;
        $row['payment_scheme2'] = $this->payment_scheme2->CurrentValue;
        $row['transaction_ref2'] = $this->transaction_ref2->CurrentValue;
        $row['channel_response_desc2'] = $this->channel_response_desc2->CurrentValue;
        $row['res_status2'] = $this->res_status2->CurrentValue;
        $row['res_referenceNo2'] = $this->res_referenceNo2->CurrentValue;
        $row['status_approve'] = $this->status_approve->CurrentValue;
        $row['cdate'] = $this->cdate->CurrentValue;
        $row['cip'] = $this->cip->CurrentValue;
        $row['cuser'] = $this->cuser->CurrentValue;
        $row['uuser'] = $this->uuser->CurrentValue;
        $row['uip'] = $this->uip->CurrentValue;
        $row['udate'] = $this->udate->CurrentValue;
        $row['res_paidAgent1'] = $this->res_paidAgent1->CurrentValue;
        $row['res_paidChannel1'] = $this->res_paidChannel1->CurrentValue;
        $row['res_maskedPan1'] = $this->res_maskedPan1->CurrentValue;
        $row['res_paidAgent2'] = $this->res_paidAgent2->CurrentValue;
        $row['res_paidChannel2'] = $this->res_paidChannel2->CurrentValue;
        $row['res_maskedPan2'] = $this->res_maskedPan2->CurrentValue;
        $row['is_email1'] = $this->is_email1->CurrentValue;
        $row['is_email2'] = $this->is_email2->CurrentValue;
        $row['receipt_status1'] = $this->receipt_status1->CurrentValue;
        $row['receipt_status2'] = $this->receipt_status2->CurrentValue;
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

        // buyer_asset_rent_id
        $this->buyer_asset_rent_id->RowCssClass = "row";

        // asset_id
        $this->asset_id->RowCssClass = "row";

        // member_id
        $this->member_id->RowCssClass = "row";

        // one_time_status
        $this->one_time_status->RowCssClass = "row";

        // half_price_1
        $this->half_price_1->RowCssClass = "row";

        // status_pay_half_price_1
        $this->status_pay_half_price_1->RowCssClass = "row";

        // pay_number_half_price_1
        $this->pay_number_half_price_1->RowCssClass = "row";

        // date_pay_half_price_1
        $this->date_pay_half_price_1->RowCssClass = "row";

        // due_date_pay_half_price_1
        $this->due_date_pay_half_price_1->RowCssClass = "row";

        // half_price_2
        $this->half_price_2->RowCssClass = "row";

        // status_pay_half_price_2
        $this->status_pay_half_price_2->RowCssClass = "row";

        // pay_number_half_price_2
        $this->pay_number_half_price_2->RowCssClass = "row";

        // date_pay_half_price_2
        $this->date_pay_half_price_2->RowCssClass = "row";

        // due_date_pay_half_price_2
        $this->due_date_pay_half_price_2->RowCssClass = "row";

        // transaction_datetime1
        $this->transaction_datetime1->RowCssClass = "row";

        // payment_scheme1
        $this->payment_scheme1->RowCssClass = "row";

        // transaction_ref1
        $this->transaction_ref1->RowCssClass = "row";

        // channel_response_desc1
        $this->channel_response_desc1->RowCssClass = "row";

        // res_status1
        $this->res_status1->RowCssClass = "row";

        // res_referenceNo1
        $this->res_referenceNo1->RowCssClass = "row";

        // transaction_datetime2
        $this->transaction_datetime2->RowCssClass = "row";

        // payment_scheme2
        $this->payment_scheme2->RowCssClass = "row";

        // transaction_ref2
        $this->transaction_ref2->RowCssClass = "row";

        // channel_response_desc2
        $this->channel_response_desc2->RowCssClass = "row";

        // res_status2
        $this->res_status2->RowCssClass = "row";

        // res_referenceNo2
        $this->res_referenceNo2->RowCssClass = "row";

        // status_approve
        $this->status_approve->RowCssClass = "row";

        // cdate
        $this->cdate->RowCssClass = "row";

        // cip
        $this->cip->RowCssClass = "row";

        // cuser
        $this->cuser->RowCssClass = "row";

        // uuser
        $this->uuser->RowCssClass = "row";

        // uip
        $this->uip->RowCssClass = "row";

        // udate
        $this->udate->RowCssClass = "row";

        // res_paidAgent1
        $this->res_paidAgent1->RowCssClass = "row";

        // res_paidChannel1
        $this->res_paidChannel1->RowCssClass = "row";

        // res_maskedPan1
        $this->res_maskedPan1->RowCssClass = "row";

        // res_paidAgent2
        $this->res_paidAgent2->RowCssClass = "row";

        // res_paidChannel2
        $this->res_paidChannel2->RowCssClass = "row";

        // res_maskedPan2
        $this->res_maskedPan2->RowCssClass = "row";

        // is_email1
        $this->is_email1->RowCssClass = "row";

        // is_email2
        $this->is_email2->RowCssClass = "row";

        // receipt_status1
        $this->receipt_status1->RowCssClass = "row";

        // receipt_status2
        $this->receipt_status2->RowCssClass = "row";

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

            // one_time_status
            if (ConvertToBool($this->one_time_status->CurrentValue)) {
                $this->one_time_status->ViewValue = $this->one_time_status->tagCaption(1) != "" ? $this->one_time_status->tagCaption(1) : "Yes";
            } else {
                $this->one_time_status->ViewValue = $this->one_time_status->tagCaption(2) != "" ? $this->one_time_status->tagCaption(2) : "No";
            }
            $this->one_time_status->ViewCustomAttributes = "";

            // half_price_1
            $this->half_price_1->ViewValue = $this->half_price_1->CurrentValue;
            $this->half_price_1->ViewValue = FormatCurrency($this->half_price_1->ViewValue, $this->half_price_1->formatPattern());
            $this->half_price_1->ViewCustomAttributes = "";

            // status_pay_half_price_1
            if (strval($this->status_pay_half_price_1->CurrentValue) != "") {
                $this->status_pay_half_price_1->ViewValue = $this->status_pay_half_price_1->optionCaption($this->status_pay_half_price_1->CurrentValue);
            } else {
                $this->status_pay_half_price_1->ViewValue = null;
            }
            $this->status_pay_half_price_1->ViewCustomAttributes = "";

            // pay_number_half_price_1
            $this->pay_number_half_price_1->ViewValue = $this->pay_number_half_price_1->CurrentValue;
            $this->pay_number_half_price_1->ViewCustomAttributes = "";

            // date_pay_half_price_1
            $this->date_pay_half_price_1->ViewValue = $this->date_pay_half_price_1->CurrentValue;
            $this->date_pay_half_price_1->ViewValue = FormatDateTime($this->date_pay_half_price_1->ViewValue, $this->date_pay_half_price_1->formatPattern());
            $this->date_pay_half_price_1->ViewCustomAttributes = "";

            // due_date_pay_half_price_1
            $this->due_date_pay_half_price_1->ViewValue = $this->due_date_pay_half_price_1->CurrentValue;
            $this->due_date_pay_half_price_1->ViewValue = FormatDateTime($this->due_date_pay_half_price_1->ViewValue, $this->due_date_pay_half_price_1->formatPattern());
            $this->due_date_pay_half_price_1->ViewCustomAttributes = "";

            // half_price_2
            $this->half_price_2->ViewValue = $this->half_price_2->CurrentValue;
            $this->half_price_2->ViewValue = FormatCurrency($this->half_price_2->ViewValue, $this->half_price_2->formatPattern());
            $this->half_price_2->ViewCustomAttributes = "";

            // status_pay_half_price_2
            if (strval($this->status_pay_half_price_2->CurrentValue) != "") {
                $this->status_pay_half_price_2->ViewValue = $this->status_pay_half_price_2->optionCaption($this->status_pay_half_price_2->CurrentValue);
            } else {
                $this->status_pay_half_price_2->ViewValue = null;
            }
            $this->status_pay_half_price_2->ViewCustomAttributes = "";

            // pay_number_half_price_2
            $this->pay_number_half_price_2->ViewValue = $this->pay_number_half_price_2->CurrentValue;
            $this->pay_number_half_price_2->ViewCustomAttributes = "";

            // date_pay_half_price_2
            $this->date_pay_half_price_2->ViewValue = $this->date_pay_half_price_2->CurrentValue;
            $this->date_pay_half_price_2->ViewValue = FormatDateTime($this->date_pay_half_price_2->ViewValue, $this->date_pay_half_price_2->formatPattern());
            $this->date_pay_half_price_2->ViewCustomAttributes = "";

            // due_date_pay_half_price_2
            $this->due_date_pay_half_price_2->ViewValue = $this->due_date_pay_half_price_2->CurrentValue;
            $this->due_date_pay_half_price_2->ViewValue = FormatDateTime($this->due_date_pay_half_price_2->ViewValue, $this->due_date_pay_half_price_2->formatPattern());
            $this->due_date_pay_half_price_2->ViewCustomAttributes = "";

            // cdate
            $this->cdate->ViewValue = $this->cdate->CurrentValue;
            $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
            $this->cdate->ViewCustomAttributes = "";

            // cip
            $this->cip->ViewValue = $this->cip->CurrentValue;
            $this->cip->ViewCustomAttributes = "";

            // cuser
            $this->cuser->ViewValue = $this->cuser->CurrentValue;
            $this->cuser->ViewCustomAttributes = "";

            // uuser
            $this->uuser->ViewValue = $this->uuser->CurrentValue;
            $this->uuser->ViewCustomAttributes = "";

            // uip
            $this->uip->ViewValue = $this->uip->CurrentValue;
            $this->uip->ViewCustomAttributes = "";

            // udate
            $this->udate->ViewValue = $this->udate->CurrentValue;
            $this->udate->ViewValue = FormatDateTime($this->udate->ViewValue, $this->udate->formatPattern());
            $this->udate->ViewCustomAttributes = "";

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";
            $this->asset_id->TooltipValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // one_time_status
            $this->one_time_status->LinkCustomAttributes = "";
            $this->one_time_status->HrefValue = "";

            // half_price_1
            $this->half_price_1->LinkCustomAttributes = "";
            $this->half_price_1->HrefValue = "";

            // status_pay_half_price_1
            $this->status_pay_half_price_1->LinkCustomAttributes = "";
            $this->status_pay_half_price_1->HrefValue = "";

            // pay_number_half_price_1
            $this->pay_number_half_price_1->LinkCustomAttributes = "";
            $this->pay_number_half_price_1->HrefValue = "";

            // date_pay_half_price_1
            $this->date_pay_half_price_1->LinkCustomAttributes = "";
            $this->date_pay_half_price_1->HrefValue = "";

            // due_date_pay_half_price_1
            $this->due_date_pay_half_price_1->LinkCustomAttributes = "";
            $this->due_date_pay_half_price_1->HrefValue = "";

            // half_price_2
            $this->half_price_2->LinkCustomAttributes = "";
            $this->half_price_2->HrefValue = "";

            // status_pay_half_price_2
            $this->status_pay_half_price_2->LinkCustomAttributes = "";
            $this->status_pay_half_price_2->HrefValue = "";

            // pay_number_half_price_2
            $this->pay_number_half_price_2->LinkCustomAttributes = "";
            $this->pay_number_half_price_2->HrefValue = "";

            // date_pay_half_price_2
            $this->date_pay_half_price_2->LinkCustomAttributes = "";
            $this->date_pay_half_price_2->HrefValue = "";

            // due_date_pay_half_price_2
            $this->due_date_pay_half_price_2->LinkCustomAttributes = "";
            $this->due_date_pay_half_price_2->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // asset_id
            $this->asset_id->setupEditAttributes();
            $this->asset_id->EditCustomAttributes = "";
            if ($this->asset_id->getSessionValue() != "") {
                $this->asset_id->CurrentValue = GetForeignKeyValue($this->asset_id->getSessionValue());
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
            } else {
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
            }

            // member_id
            $this->member_id->setupEditAttributes();
            $this->member_id->EditCustomAttributes = "";
            if ($this->member_id->getSessionValue() != "") {
                $this->member_id->CurrentValue = GetForeignKeyValue($this->member_id->getSessionValue());
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
            } else {
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
            }

            // one_time_status
            $this->one_time_status->EditCustomAttributes = "";
            $this->one_time_status->EditValue = $this->one_time_status->options(false);
            $this->one_time_status->PlaceHolder = RemoveHtml($this->one_time_status->caption());

            // half_price_1
            $this->half_price_1->setupEditAttributes();
            $this->half_price_1->EditCustomAttributes = "";
            $this->half_price_1->EditValue = HtmlEncode($this->half_price_1->CurrentValue);
            $this->half_price_1->PlaceHolder = RemoveHtml($this->half_price_1->caption());
            if (strval($this->half_price_1->EditValue) != "" && is_numeric($this->half_price_1->EditValue)) {
                $this->half_price_1->EditValue = FormatNumber($this->half_price_1->EditValue, null);
            }

            // status_pay_half_price_1
            $this->status_pay_half_price_1->setupEditAttributes();
            $this->status_pay_half_price_1->EditCustomAttributes = "";
            $this->status_pay_half_price_1->EditValue = $this->status_pay_half_price_1->options(true);
            $this->status_pay_half_price_1->PlaceHolder = RemoveHtml($this->status_pay_half_price_1->caption());

            // pay_number_half_price_1
            $this->pay_number_half_price_1->setupEditAttributes();
            $this->pay_number_half_price_1->EditCustomAttributes = "";
            if (!$this->pay_number_half_price_1->Raw) {
                $this->pay_number_half_price_1->CurrentValue = HtmlDecode($this->pay_number_half_price_1->CurrentValue);
            }
            $this->pay_number_half_price_1->EditValue = HtmlEncode($this->pay_number_half_price_1->CurrentValue);
            $this->pay_number_half_price_1->PlaceHolder = RemoveHtml($this->pay_number_half_price_1->caption());

            // date_pay_half_price_1
            $this->date_pay_half_price_1->setupEditAttributes();
            $this->date_pay_half_price_1->EditCustomAttributes = "";
            $this->date_pay_half_price_1->EditValue = HtmlEncode(FormatDateTime($this->date_pay_half_price_1->CurrentValue, $this->date_pay_half_price_1->formatPattern()));
            $this->date_pay_half_price_1->PlaceHolder = RemoveHtml($this->date_pay_half_price_1->caption());

            // due_date_pay_half_price_1
            $this->due_date_pay_half_price_1->setupEditAttributes();
            $this->due_date_pay_half_price_1->EditCustomAttributes = "";
            $this->due_date_pay_half_price_1->EditValue = HtmlEncode(FormatDateTime($this->due_date_pay_half_price_1->CurrentValue, $this->due_date_pay_half_price_1->formatPattern()));
            $this->due_date_pay_half_price_1->PlaceHolder = RemoveHtml($this->due_date_pay_half_price_1->caption());

            // half_price_2
            $this->half_price_2->setupEditAttributes();
            $this->half_price_2->EditCustomAttributes = "";
            $this->half_price_2->EditValue = HtmlEncode($this->half_price_2->CurrentValue);
            $this->half_price_2->PlaceHolder = RemoveHtml($this->half_price_2->caption());
            if (strval($this->half_price_2->EditValue) != "" && is_numeric($this->half_price_2->EditValue)) {
                $this->half_price_2->EditValue = FormatNumber($this->half_price_2->EditValue, null);
            }

            // status_pay_half_price_2
            $this->status_pay_half_price_2->setupEditAttributes();
            $this->status_pay_half_price_2->EditCustomAttributes = "";
            $this->status_pay_half_price_2->EditValue = $this->status_pay_half_price_2->options(true);
            $this->status_pay_half_price_2->PlaceHolder = RemoveHtml($this->status_pay_half_price_2->caption());

            // pay_number_half_price_2
            $this->pay_number_half_price_2->setupEditAttributes();
            $this->pay_number_half_price_2->EditCustomAttributes = "";
            if (!$this->pay_number_half_price_2->Raw) {
                $this->pay_number_half_price_2->CurrentValue = HtmlDecode($this->pay_number_half_price_2->CurrentValue);
            }
            $this->pay_number_half_price_2->EditValue = HtmlEncode($this->pay_number_half_price_2->CurrentValue);
            $this->pay_number_half_price_2->PlaceHolder = RemoveHtml($this->pay_number_half_price_2->caption());

            // date_pay_half_price_2
            $this->date_pay_half_price_2->setupEditAttributes();
            $this->date_pay_half_price_2->EditCustomAttributes = "";
            $this->date_pay_half_price_2->EditValue = HtmlEncode(FormatDateTime($this->date_pay_half_price_2->CurrentValue, $this->date_pay_half_price_2->formatPattern()));
            $this->date_pay_half_price_2->PlaceHolder = RemoveHtml($this->date_pay_half_price_2->caption());

            // due_date_pay_half_price_2
            $this->due_date_pay_half_price_2->setupEditAttributes();
            $this->due_date_pay_half_price_2->EditCustomAttributes = "";
            $this->due_date_pay_half_price_2->EditValue = HtmlEncode(FormatDateTime($this->due_date_pay_half_price_2->CurrentValue, $this->due_date_pay_half_price_2->formatPattern()));
            $this->due_date_pay_half_price_2->PlaceHolder = RemoveHtml($this->due_date_pay_half_price_2->caption());

            // cdate

            // cip

            // cuser

            // uuser

            // uip

            // udate

            // Add refer script

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";

            // one_time_status
            $this->one_time_status->LinkCustomAttributes = "";
            $this->one_time_status->HrefValue = "";

            // half_price_1
            $this->half_price_1->LinkCustomAttributes = "";
            $this->half_price_1->HrefValue = "";

            // status_pay_half_price_1
            $this->status_pay_half_price_1->LinkCustomAttributes = "";
            $this->status_pay_half_price_1->HrefValue = "";

            // pay_number_half_price_1
            $this->pay_number_half_price_1->LinkCustomAttributes = "";
            $this->pay_number_half_price_1->HrefValue = "";

            // date_pay_half_price_1
            $this->date_pay_half_price_1->LinkCustomAttributes = "";
            $this->date_pay_half_price_1->HrefValue = "";

            // due_date_pay_half_price_1
            $this->due_date_pay_half_price_1->LinkCustomAttributes = "";
            $this->due_date_pay_half_price_1->HrefValue = "";

            // half_price_2
            $this->half_price_2->LinkCustomAttributes = "";
            $this->half_price_2->HrefValue = "";

            // status_pay_half_price_2
            $this->status_pay_half_price_2->LinkCustomAttributes = "";
            $this->status_pay_half_price_2->HrefValue = "";

            // pay_number_half_price_2
            $this->pay_number_half_price_2->LinkCustomAttributes = "";
            $this->pay_number_half_price_2->HrefValue = "";

            // date_pay_half_price_2
            $this->date_pay_half_price_2->LinkCustomAttributes = "";
            $this->date_pay_half_price_2->HrefValue = "";

            // due_date_pay_half_price_2
            $this->due_date_pay_half_price_2->LinkCustomAttributes = "";
            $this->due_date_pay_half_price_2->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";

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
        if ($this->one_time_status->Required) {
            if ($this->one_time_status->FormValue == "") {
                $this->one_time_status->addErrorMessage(str_replace("%s", $this->one_time_status->caption(), $this->one_time_status->RequiredErrorMessage));
            }
        }
        if ($this->half_price_1->Required) {
            if (!$this->half_price_1->IsDetailKey && EmptyValue($this->half_price_1->FormValue)) {
                $this->half_price_1->addErrorMessage(str_replace("%s", $this->half_price_1->caption(), $this->half_price_1->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->half_price_1->FormValue)) {
            $this->half_price_1->addErrorMessage($this->half_price_1->getErrorMessage(false));
        }
        if ($this->status_pay_half_price_1->Required) {
            if (!$this->status_pay_half_price_1->IsDetailKey && EmptyValue($this->status_pay_half_price_1->FormValue)) {
                $this->status_pay_half_price_1->addErrorMessage(str_replace("%s", $this->status_pay_half_price_1->caption(), $this->status_pay_half_price_1->RequiredErrorMessage));
            }
        }
        if ($this->pay_number_half_price_1->Required) {
            if (!$this->pay_number_half_price_1->IsDetailKey && EmptyValue($this->pay_number_half_price_1->FormValue)) {
                $this->pay_number_half_price_1->addErrorMessage(str_replace("%s", $this->pay_number_half_price_1->caption(), $this->pay_number_half_price_1->RequiredErrorMessage));
            }
        }
        if ($this->date_pay_half_price_1->Required) {
            if (!$this->date_pay_half_price_1->IsDetailKey && EmptyValue($this->date_pay_half_price_1->FormValue)) {
                $this->date_pay_half_price_1->addErrorMessage(str_replace("%s", $this->date_pay_half_price_1->caption(), $this->date_pay_half_price_1->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->date_pay_half_price_1->FormValue, $this->date_pay_half_price_1->formatPattern())) {
            $this->date_pay_half_price_1->addErrorMessage($this->date_pay_half_price_1->getErrorMessage(false));
        }
        if ($this->due_date_pay_half_price_1->Required) {
            if (!$this->due_date_pay_half_price_1->IsDetailKey && EmptyValue($this->due_date_pay_half_price_1->FormValue)) {
                $this->due_date_pay_half_price_1->addErrorMessage(str_replace("%s", $this->due_date_pay_half_price_1->caption(), $this->due_date_pay_half_price_1->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->due_date_pay_half_price_1->FormValue, $this->due_date_pay_half_price_1->formatPattern())) {
            $this->due_date_pay_half_price_1->addErrorMessage($this->due_date_pay_half_price_1->getErrorMessage(false));
        }
        if ($this->half_price_2->Required) {
            if (!$this->half_price_2->IsDetailKey && EmptyValue($this->half_price_2->FormValue)) {
                $this->half_price_2->addErrorMessage(str_replace("%s", $this->half_price_2->caption(), $this->half_price_2->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->half_price_2->FormValue)) {
            $this->half_price_2->addErrorMessage($this->half_price_2->getErrorMessage(false));
        }
        if ($this->status_pay_half_price_2->Required) {
            if (!$this->status_pay_half_price_2->IsDetailKey && EmptyValue($this->status_pay_half_price_2->FormValue)) {
                $this->status_pay_half_price_2->addErrorMessage(str_replace("%s", $this->status_pay_half_price_2->caption(), $this->status_pay_half_price_2->RequiredErrorMessage));
            }
        }
        if ($this->pay_number_half_price_2->Required) {
            if (!$this->pay_number_half_price_2->IsDetailKey && EmptyValue($this->pay_number_half_price_2->FormValue)) {
                $this->pay_number_half_price_2->addErrorMessage(str_replace("%s", $this->pay_number_half_price_2->caption(), $this->pay_number_half_price_2->RequiredErrorMessage));
            }
        }
        if ($this->date_pay_half_price_2->Required) {
            if (!$this->date_pay_half_price_2->IsDetailKey && EmptyValue($this->date_pay_half_price_2->FormValue)) {
                $this->date_pay_half_price_2->addErrorMessage(str_replace("%s", $this->date_pay_half_price_2->caption(), $this->date_pay_half_price_2->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->date_pay_half_price_2->FormValue, $this->date_pay_half_price_2->formatPattern())) {
            $this->date_pay_half_price_2->addErrorMessage($this->date_pay_half_price_2->getErrorMessage(false));
        }
        if ($this->due_date_pay_half_price_2->Required) {
            if (!$this->due_date_pay_half_price_2->IsDetailKey && EmptyValue($this->due_date_pay_half_price_2->FormValue)) {
                $this->due_date_pay_half_price_2->addErrorMessage(str_replace("%s", $this->due_date_pay_half_price_2->caption(), $this->due_date_pay_half_price_2->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->due_date_pay_half_price_2->FormValue, $this->due_date_pay_half_price_2->formatPattern())) {
            $this->due_date_pay_half_price_2->addErrorMessage($this->due_date_pay_half_price_2->getErrorMessage(false));
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
        if ($this->cuser->Required) {
            if (!$this->cuser->IsDetailKey && EmptyValue($this->cuser->FormValue)) {
                $this->cuser->addErrorMessage(str_replace("%s", $this->cuser->caption(), $this->cuser->RequiredErrorMessage));
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Check referential integrity for master table 'buyer_asset_rent'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["asset_id"] = $this->asset_id->CurrentValue;
        $detailKeys["member_id"] = $this->member_id->CurrentValue;
        $masterTable = Container("buyer_asset");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "buyer_asset", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
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

        // one_time_status
        $tmpBool = $this->one_time_status->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->one_time_status->setDbValueDef($rsnew, $tmpBool, 0, strval($this->one_time_status->CurrentValue) == "");

        // half_price_1
        $this->half_price_1->setDbValueDef($rsnew, $this->half_price_1->CurrentValue, null, false);

        // status_pay_half_price_1
        $this->status_pay_half_price_1->setDbValueDef($rsnew, $this->status_pay_half_price_1->CurrentValue, null, strval($this->status_pay_half_price_1->CurrentValue) == "");

        // pay_number_half_price_1
        $this->pay_number_half_price_1->setDbValueDef($rsnew, $this->pay_number_half_price_1->CurrentValue, null, false);

        // date_pay_half_price_1
        $this->date_pay_half_price_1->setDbValueDef($rsnew, UnFormatDateTime($this->date_pay_half_price_1->CurrentValue, $this->date_pay_half_price_1->formatPattern()), null, false);

        // due_date_pay_half_price_1
        $this->due_date_pay_half_price_1->setDbValueDef($rsnew, UnFormatDateTime($this->due_date_pay_half_price_1->CurrentValue, $this->due_date_pay_half_price_1->formatPattern()), null, false);

        // half_price_2
        $this->half_price_2->setDbValueDef($rsnew, $this->half_price_2->CurrentValue, null, false);

        // status_pay_half_price_2
        $this->status_pay_half_price_2->setDbValueDef($rsnew, $this->status_pay_half_price_2->CurrentValue, null, strval($this->status_pay_half_price_2->CurrentValue) == "");

        // pay_number_half_price_2
        $this->pay_number_half_price_2->setDbValueDef($rsnew, $this->pay_number_half_price_2->CurrentValue, null, false);

        // date_pay_half_price_2
        $this->date_pay_half_price_2->setDbValueDef($rsnew, UnFormatDateTime($this->date_pay_half_price_2->CurrentValue, $this->date_pay_half_price_2->formatPattern()), null, false);

        // due_date_pay_half_price_2
        $this->due_date_pay_half_price_2->setDbValueDef($rsnew, UnFormatDateTime($this->due_date_pay_half_price_2->CurrentValue, $this->due_date_pay_half_price_2->formatPattern()), null, false);

        // cdate
        $this->cdate->CurrentValue = CurrentDateTime();
        $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

        // cip
        $this->cip->CurrentValue = CurrentUserIP();
        $this->cip->setDbValueDef($rsnew, $this->cip->CurrentValue, null);

        // cuser
        $this->cuser->CurrentValue = CurrentUserID();
        $this->cuser->setDbValueDef($rsnew, $this->cuser->CurrentValue, null);

        // uuser
        $this->uuser->CurrentValue = CurrentUserID();
        $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, null);

        // uip
        $this->uip->CurrentValue = CurrentUserIP();
        $this->uip->setDbValueDef($rsnew, $this->uip->CurrentValue, null);

        // udate
        $this->udate->CurrentValue = CurrentDateTime();
        $this->udate->setDbValueDef($rsnew, $this->udate->CurrentValue, null);

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
            if ($masterTblVar == "buyer_asset") {
                $validMaster = true;
                $masterTbl = Container("buyer_asset");
                if (($parm = Get("fk_asset_id", Get("asset_id"))) !== null) {
                    $masterTbl->asset_id->setQueryStringValue($parm);
                    $this->asset_id->setQueryStringValue($masterTbl->asset_id->QueryStringValue);
                    $this->asset_id->setSessionValue($this->asset_id->QueryStringValue);
                    if (!is_numeric($masterTbl->asset_id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
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
            if ($masterTblVar == "buyer_asset") {
                $validMaster = true;
                $masterTbl = Container("buyer_asset");
                if (($parm = Post("fk_asset_id", Post("asset_id"))) !== null) {
                    $masterTbl->asset_id->setFormValue($parm);
                    $this->asset_id->setFormValue($masterTbl->asset_id->FormValue);
                    $this->asset_id->setSessionValue($this->asset_id->FormValue);
                    if (!is_numeric($masterTbl->asset_id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
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

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "buyer_asset") {
                if ($this->asset_id->CurrentValue == "") {
                    $this->asset_id->setSessionValue("");
                }
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("buyerassetrentlist"), "", $this->TableVar, true);
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
                    break;
                case "x_member_id":
                    break;
                case "x_one_time_status":
                    break;
                case "x_status_pay_half_price_1":
                    break;
                case "x_status_pay_half_price_2":
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
