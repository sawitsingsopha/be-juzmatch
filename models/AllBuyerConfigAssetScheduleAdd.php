<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class AllBuyerConfigAssetScheduleAdd extends AllBuyerConfigAssetSchedule
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'all_buyer_config_asset_schedule';

    // Page object name
    public $PageObjName = "AllBuyerConfigAssetScheduleAdd";

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

        // Table object (all_buyer_config_asset_schedule)
        if (!isset($GLOBALS["all_buyer_config_asset_schedule"]) || get_class($GLOBALS["all_buyer_config_asset_schedule"]) == PROJECT_NAMESPACE . "all_buyer_config_asset_schedule") {
            $GLOBALS["all_buyer_config_asset_schedule"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'all_buyer_config_asset_schedule');
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
                $tbl = Container("all_buyer_config_asset_schedule");
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
                    if ($pageName == "allbuyerconfigassetscheduleview") {
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
            $key .= @$ar['buyer_config_asset_schedule_id'];
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
            $this->buyer_config_asset_schedule_id->Visible = false;
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
        $this->buyer_config_asset_schedule_id->Visible = false;
        $this->member_id->setVisibility();
        $this->asset_id->setVisibility();
        $this->installment_all->setVisibility();
        $this->asset_price->setVisibility();
        $this->booking_price->setVisibility();
        $this->down_price->setVisibility();
        $this->installment_price_per->setVisibility();
        $this->annual_interest->setVisibility();
        $this->number_days_pay_first_month->setVisibility();
        $this->number_days_in_first_month->setVisibility();
        $this->move_in_on_20th->setVisibility();
        $this->date_start_installment->setVisibility();
        $this->status_approve->setVisibility();
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
        $this->setupLookupOptions($this->member_id);
        $this->setupLookupOptions($this->asset_id);
        $this->setupLookupOptions($this->move_in_on_20th);
        $this->setupLookupOptions($this->status_approve);

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
            if (($keyValue = Get("buyer_config_asset_schedule_id") ?? Route("buyer_config_asset_schedule_id")) !== null) {
                $this->buyer_config_asset_schedule_id->setQueryStringValue($keyValue);
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

        // Set up detail parameters
        $this->setupDetailParms();

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
                    $this->terminate("allbuyerconfigassetschedulelist"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = "allbuyerconfigassetschedulelist";
                    if (GetPageName($returnUrl) == "allbuyerconfigassetschedulelist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "allbuyerconfigassetscheduleview") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
        $this->buyer_config_asset_schedule_id->CurrentValue = null;
        $this->buyer_config_asset_schedule_id->OldValue = $this->buyer_config_asset_schedule_id->CurrentValue;
        $this->member_id->CurrentValue = null;
        $this->member_id->OldValue = $this->member_id->CurrentValue;
        $this->asset_id->CurrentValue = null;
        $this->asset_id->OldValue = $this->asset_id->CurrentValue;
        $this->installment_all->CurrentValue = null;
        $this->installment_all->OldValue = $this->installment_all->CurrentValue;
        $this->asset_price->CurrentValue = null;
        $this->asset_price->OldValue = $this->asset_price->CurrentValue;
        $this->booking_price->CurrentValue = null;
        $this->booking_price->OldValue = $this->booking_price->CurrentValue;
        $this->down_price->CurrentValue = null;
        $this->down_price->OldValue = $this->down_price->CurrentValue;
        $this->installment_price_per->CurrentValue = null;
        $this->installment_price_per->OldValue = $this->installment_price_per->CurrentValue;
        $this->annual_interest->CurrentValue = null;
        $this->annual_interest->OldValue = $this->annual_interest->CurrentValue;
        $this->number_days_pay_first_month->CurrentValue = 0;
        $this->number_days_in_first_month->CurrentValue = null;
        $this->number_days_in_first_month->OldValue = $this->number_days_in_first_month->CurrentValue;
        $this->move_in_on_20th->CurrentValue = 0;
        $this->date_start_installment->CurrentValue = null;
        $this->date_start_installment->OldValue = $this->date_start_installment->CurrentValue;
        $this->status_approve->CurrentValue = 0;
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

        // Check field name 'member_id' first before field var 'x_member_id'
        $val = $CurrentForm->hasValue("member_id") ? $CurrentForm->getValue("member_id") : $CurrentForm->getValue("x_member_id");
        if (!$this->member_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->member_id->Visible = false; // Disable update for API request
            } else {
                $this->member_id->setFormValue($val);
            }
        }

        // Check field name 'asset_id' first before field var 'x_asset_id'
        $val = $CurrentForm->hasValue("asset_id") ? $CurrentForm->getValue("asset_id") : $CurrentForm->getValue("x_asset_id");
        if (!$this->asset_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_id->Visible = false; // Disable update for API request
            } else {
                $this->asset_id->setFormValue($val);
            }
        }

        // Check field name 'installment_all' first before field var 'x_installment_all'
        $val = $CurrentForm->hasValue("installment_all") ? $CurrentForm->getValue("installment_all") : $CurrentForm->getValue("x_installment_all");
        if (!$this->installment_all->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->installment_all->Visible = false; // Disable update for API request
            } else {
                $this->installment_all->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'asset_price' first before field var 'x_asset_price'
        $val = $CurrentForm->hasValue("asset_price") ? $CurrentForm->getValue("asset_price") : $CurrentForm->getValue("x_asset_price");
        if (!$this->asset_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_price->Visible = false; // Disable update for API request
            } else {
                $this->asset_price->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'booking_price' first before field var 'x_booking_price'
        $val = $CurrentForm->hasValue("booking_price") ? $CurrentForm->getValue("booking_price") : $CurrentForm->getValue("x_booking_price");
        if (!$this->booking_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->booking_price->Visible = false; // Disable update for API request
            } else {
                $this->booking_price->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'down_price' first before field var 'x_down_price'
        $val = $CurrentForm->hasValue("down_price") ? $CurrentForm->getValue("down_price") : $CurrentForm->getValue("x_down_price");
        if (!$this->down_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->down_price->Visible = false; // Disable update for API request
            } else {
                $this->down_price->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'installment_price_per' first before field var 'x_installment_price_per'
        $val = $CurrentForm->hasValue("installment_price_per") ? $CurrentForm->getValue("installment_price_per") : $CurrentForm->getValue("x_installment_price_per");
        if (!$this->installment_price_per->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->installment_price_per->Visible = false; // Disable update for API request
            } else {
                $this->installment_price_per->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'annual_interest' first before field var 'x_annual_interest'
        $val = $CurrentForm->hasValue("annual_interest") ? $CurrentForm->getValue("annual_interest") : $CurrentForm->getValue("x_annual_interest");
        if (!$this->annual_interest->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->annual_interest->Visible = false; // Disable update for API request
            } else {
                $this->annual_interest->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'number_days_pay_first_month' first before field var 'x_number_days_pay_first_month'
        $val = $CurrentForm->hasValue("number_days_pay_first_month") ? $CurrentForm->getValue("number_days_pay_first_month") : $CurrentForm->getValue("x_number_days_pay_first_month");
        if (!$this->number_days_pay_first_month->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->number_days_pay_first_month->Visible = false; // Disable update for API request
            } else {
                $this->number_days_pay_first_month->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'number_days_in_first_month' first before field var 'x_number_days_in_first_month'
        $val = $CurrentForm->hasValue("number_days_in_first_month") ? $CurrentForm->getValue("number_days_in_first_month") : $CurrentForm->getValue("x_number_days_in_first_month");
        if (!$this->number_days_in_first_month->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->number_days_in_first_month->Visible = false; // Disable update for API request
            } else {
                $this->number_days_in_first_month->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'move_in_on_20th' first before field var 'x_move_in_on_20th'
        $val = $CurrentForm->hasValue("move_in_on_20th") ? $CurrentForm->getValue("move_in_on_20th") : $CurrentForm->getValue("x_move_in_on_20th");
        if (!$this->move_in_on_20th->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->move_in_on_20th->Visible = false; // Disable update for API request
            } else {
                $this->move_in_on_20th->setFormValue($val);
            }
        }

        // Check field name 'date_start_installment' first before field var 'x_date_start_installment'
        $val = $CurrentForm->hasValue("date_start_installment") ? $CurrentForm->getValue("date_start_installment") : $CurrentForm->getValue("x_date_start_installment");
        if (!$this->date_start_installment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->date_start_installment->Visible = false; // Disable update for API request
            } else {
                $this->date_start_installment->setFormValue($val, true, $validate);
            }
            $this->date_start_installment->CurrentValue = UnFormatDateTime($this->date_start_installment->CurrentValue, $this->date_start_installment->formatPattern());
        }

        // Check field name 'status_approve' first before field var 'x_status_approve'
        $val = $CurrentForm->hasValue("status_approve") ? $CurrentForm->getValue("status_approve") : $CurrentForm->getValue("x_status_approve");
        if (!$this->status_approve->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_approve->Visible = false; // Disable update for API request
            } else {
                $this->status_approve->setFormValue($val);
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

        // Check field name 'buyer_config_asset_schedule_id' first before field var 'x_buyer_config_asset_schedule_id'
        $val = $CurrentForm->hasValue("buyer_config_asset_schedule_id") ? $CurrentForm->getValue("buyer_config_asset_schedule_id") : $CurrentForm->getValue("x_buyer_config_asset_schedule_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->member_id->CurrentValue = $this->member_id->FormValue;
        $this->asset_id->CurrentValue = $this->asset_id->FormValue;
        $this->installment_all->CurrentValue = $this->installment_all->FormValue;
        $this->asset_price->CurrentValue = $this->asset_price->FormValue;
        $this->booking_price->CurrentValue = $this->booking_price->FormValue;
        $this->down_price->CurrentValue = $this->down_price->FormValue;
        $this->installment_price_per->CurrentValue = $this->installment_price_per->FormValue;
        $this->annual_interest->CurrentValue = $this->annual_interest->FormValue;
        $this->number_days_pay_first_month->CurrentValue = $this->number_days_pay_first_month->FormValue;
        $this->number_days_in_first_month->CurrentValue = $this->number_days_in_first_month->FormValue;
        $this->move_in_on_20th->CurrentValue = $this->move_in_on_20th->FormValue;
        $this->date_start_installment->CurrentValue = $this->date_start_installment->FormValue;
        $this->date_start_installment->CurrentValue = UnFormatDateTime($this->date_start_installment->CurrentValue, $this->date_start_installment->formatPattern());
        $this->status_approve->CurrentValue = $this->status_approve->FormValue;
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
        $this->buyer_config_asset_schedule_id->setDbValue($row['buyer_config_asset_schedule_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->installment_all->setDbValue($row['installment_all']);
        $this->asset_price->setDbValue($row['asset_price']);
        $this->booking_price->setDbValue($row['booking_price']);
        $this->down_price->setDbValue($row['down_price']);
        $this->installment_price_per->setDbValue($row['installment_price_per']);
        $this->annual_interest->setDbValue($row['annual_interest']);
        $this->number_days_pay_first_month->setDbValue($row['number_days_pay_first_month']);
        $this->number_days_in_first_month->setDbValue($row['number_days_in_first_month']);
        $this->move_in_on_20th->setDbValue($row['move_in_on_20th']);
        $this->date_start_installment->setDbValue($row['date_start_installment']);
        $this->status_approve->setDbValue($row['status_approve']);
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
        $row['buyer_config_asset_schedule_id'] = $this->buyer_config_asset_schedule_id->CurrentValue;
        $row['member_id'] = $this->member_id->CurrentValue;
        $row['asset_id'] = $this->asset_id->CurrentValue;
        $row['installment_all'] = $this->installment_all->CurrentValue;
        $row['asset_price'] = $this->asset_price->CurrentValue;
        $row['booking_price'] = $this->booking_price->CurrentValue;
        $row['down_price'] = $this->down_price->CurrentValue;
        $row['installment_price_per'] = $this->installment_price_per->CurrentValue;
        $row['annual_interest'] = $this->annual_interest->CurrentValue;
        $row['number_days_pay_first_month'] = $this->number_days_pay_first_month->CurrentValue;
        $row['number_days_in_first_month'] = $this->number_days_in_first_month->CurrentValue;
        $row['move_in_on_20th'] = $this->move_in_on_20th->CurrentValue;
        $row['date_start_installment'] = $this->date_start_installment->CurrentValue;
        $row['status_approve'] = $this->status_approve->CurrentValue;
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

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->RowCssClass = "row";

        // member_id
        $this->member_id->RowCssClass = "row";

        // asset_id
        $this->asset_id->RowCssClass = "row";

        // installment_all
        $this->installment_all->RowCssClass = "row";

        // asset_price
        $this->asset_price->RowCssClass = "row";

        // booking_price
        $this->booking_price->RowCssClass = "row";

        // down_price
        $this->down_price->RowCssClass = "row";

        // installment_price_per
        $this->installment_price_per->RowCssClass = "row";

        // annual_interest
        $this->annual_interest->RowCssClass = "row";

        // number_days_pay_first_month
        $this->number_days_pay_first_month->RowCssClass = "row";

        // number_days_in_first_month
        $this->number_days_in_first_month->RowCssClass = "row";

        // move_in_on_20th
        $this->move_in_on_20th->RowCssClass = "row";

        // date_start_installment
        $this->date_start_installment->RowCssClass = "row";

        // status_approve
        $this->status_approve->RowCssClass = "row";

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

            // installment_all
            $this->installment_all->ViewValue = $this->installment_all->CurrentValue;
            $this->installment_all->ViewValue = FormatNumber($this->installment_all->ViewValue, $this->installment_all->formatPattern());
            $this->installment_all->ViewCustomAttributes = "";

            // asset_price
            $this->asset_price->ViewValue = $this->asset_price->CurrentValue;
            $this->asset_price->ViewValue = FormatNumber($this->asset_price->ViewValue, $this->asset_price->formatPattern());
            $this->asset_price->ViewCustomAttributes = "";

            // booking_price
            $this->booking_price->ViewValue = $this->booking_price->CurrentValue;
            $this->booking_price->ViewValue = FormatNumber($this->booking_price->ViewValue, $this->booking_price->formatPattern());
            $this->booking_price->ViewCustomAttributes = "";

            // down_price
            $this->down_price->ViewValue = $this->down_price->CurrentValue;
            $this->down_price->ViewValue = FormatNumber($this->down_price->ViewValue, $this->down_price->formatPattern());
            $this->down_price->ViewCustomAttributes = "";

            // installment_price_per
            $this->installment_price_per->ViewValue = $this->installment_price_per->CurrentValue;
            $this->installment_price_per->ViewValue = FormatCurrency($this->installment_price_per->ViewValue, $this->installment_price_per->formatPattern());
            $this->installment_price_per->ViewCustomAttributes = "";

            // annual_interest
            $this->annual_interest->ViewValue = $this->annual_interest->CurrentValue;
            $this->annual_interest->ViewValue = FormatNumber($this->annual_interest->ViewValue, $this->annual_interest->formatPattern());
            $this->annual_interest->ViewCustomAttributes = "";

            // number_days_pay_first_month
            $this->number_days_pay_first_month->ViewValue = $this->number_days_pay_first_month->CurrentValue;
            $this->number_days_pay_first_month->ViewValue = FormatNumber($this->number_days_pay_first_month->ViewValue, $this->number_days_pay_first_month->formatPattern());
            $this->number_days_pay_first_month->ViewCustomAttributes = "";

            // number_days_in_first_month
            $this->number_days_in_first_month->ViewValue = $this->number_days_in_first_month->CurrentValue;
            $this->number_days_in_first_month->ViewValue = FormatNumber($this->number_days_in_first_month->ViewValue, $this->number_days_in_first_month->formatPattern());
            $this->number_days_in_first_month->ViewCustomAttributes = "";

            // move_in_on_20th
            if (ConvertToBool($this->move_in_on_20th->CurrentValue)) {
                $this->move_in_on_20th->ViewValue = $this->move_in_on_20th->tagCaption(1) != "" ? $this->move_in_on_20th->tagCaption(1) : "Yes";
            } else {
                $this->move_in_on_20th->ViewValue = $this->move_in_on_20th->tagCaption(2) != "" ? $this->move_in_on_20th->tagCaption(2) : "No";
            }
            $this->move_in_on_20th->ViewCustomAttributes = "";

            // date_start_installment
            $this->date_start_installment->ViewValue = $this->date_start_installment->CurrentValue;
            $this->date_start_installment->ViewValue = FormatDateTime($this->date_start_installment->ViewValue, $this->date_start_installment->formatPattern());
            $this->date_start_installment->ViewCustomAttributes = "";

            // status_approve
            if (strval($this->status_approve->CurrentValue) != "") {
                $this->status_approve->ViewValue = $this->status_approve->optionCaption($this->status_approve->CurrentValue);
            } else {
                $this->status_approve->ViewValue = null;
            }
            $this->status_approve->ViewCustomAttributes = "";

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

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";
            $this->asset_id->TooltipValue = "";

            // installment_all
            $this->installment_all->LinkCustomAttributes = "";
            $this->installment_all->HrefValue = "";

            // asset_price
            $this->asset_price->LinkCustomAttributes = "";
            $this->asset_price->HrefValue = "";

            // booking_price
            $this->booking_price->LinkCustomAttributes = "";
            $this->booking_price->HrefValue = "";

            // down_price
            $this->down_price->LinkCustomAttributes = "";
            $this->down_price->HrefValue = "";

            // installment_price_per
            $this->installment_price_per->LinkCustomAttributes = "";
            $this->installment_price_per->HrefValue = "";

            // annual_interest
            $this->annual_interest->LinkCustomAttributes = "";
            $this->annual_interest->HrefValue = "";

            // number_days_pay_first_month
            $this->number_days_pay_first_month->LinkCustomAttributes = "";
            $this->number_days_pay_first_month->HrefValue = "";

            // number_days_in_first_month
            $this->number_days_in_first_month->LinkCustomAttributes = "";
            $this->number_days_in_first_month->HrefValue = "";

            // move_in_on_20th
            $this->move_in_on_20th->LinkCustomAttributes = "";
            $this->move_in_on_20th->HrefValue = "";

            // date_start_installment
            $this->date_start_installment->LinkCustomAttributes = "";
            $this->date_start_installment->HrefValue = "";

            // status_approve
            $this->status_approve->LinkCustomAttributes = "";
            $this->status_approve->HrefValue = "";

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

            // installment_all
            $this->installment_all->setupEditAttributes();
            $this->installment_all->EditCustomAttributes = "";
            $this->installment_all->EditValue = HtmlEncode($this->installment_all->CurrentValue);
            $this->installment_all->PlaceHolder = RemoveHtml($this->installment_all->caption());
            if (strval($this->installment_all->EditValue) != "" && is_numeric($this->installment_all->EditValue)) {
                $this->installment_all->EditValue = FormatNumber($this->installment_all->EditValue, null);
            }

            // asset_price
            $this->asset_price->setupEditAttributes();
            $this->asset_price->EditCustomAttributes = "";
            $this->asset_price->EditValue = HtmlEncode($this->asset_price->CurrentValue);
            $this->asset_price->PlaceHolder = RemoveHtml($this->asset_price->caption());
            if (strval($this->asset_price->EditValue) != "" && is_numeric($this->asset_price->EditValue)) {
                $this->asset_price->EditValue = FormatNumber($this->asset_price->EditValue, null);
            }

            // booking_price
            $this->booking_price->setupEditAttributes();
            $this->booking_price->EditCustomAttributes = "";
            $this->booking_price->EditValue = HtmlEncode($this->booking_price->CurrentValue);
            $this->booking_price->PlaceHolder = RemoveHtml($this->booking_price->caption());
            if (strval($this->booking_price->EditValue) != "" && is_numeric($this->booking_price->EditValue)) {
                $this->booking_price->EditValue = FormatNumber($this->booking_price->EditValue, null);
            }

            // down_price
            $this->down_price->setupEditAttributes();
            $this->down_price->EditCustomAttributes = "";
            $this->down_price->EditValue = HtmlEncode($this->down_price->CurrentValue);
            $this->down_price->PlaceHolder = RemoveHtml($this->down_price->caption());
            if (strval($this->down_price->EditValue) != "" && is_numeric($this->down_price->EditValue)) {
                $this->down_price->EditValue = FormatNumber($this->down_price->EditValue, null);
            }

            // installment_price_per
            $this->installment_price_per->setupEditAttributes();
            $this->installment_price_per->EditCustomAttributes = "";
            $this->installment_price_per->EditValue = HtmlEncode($this->installment_price_per->CurrentValue);
            $this->installment_price_per->PlaceHolder = RemoveHtml($this->installment_price_per->caption());
            if (strval($this->installment_price_per->EditValue) != "" && is_numeric($this->installment_price_per->EditValue)) {
                $this->installment_price_per->EditValue = FormatNumber($this->installment_price_per->EditValue, null);
            }

            // annual_interest
            $this->annual_interest->setupEditAttributes();
            $this->annual_interest->EditCustomAttributes = "";
            $this->annual_interest->EditValue = HtmlEncode($this->annual_interest->CurrentValue);
            $this->annual_interest->PlaceHolder = RemoveHtml($this->annual_interest->caption());
            if (strval($this->annual_interest->EditValue) != "" && is_numeric($this->annual_interest->EditValue)) {
                $this->annual_interest->EditValue = FormatNumber($this->annual_interest->EditValue, null);
            }

            // number_days_pay_first_month
            $this->number_days_pay_first_month->setupEditAttributes();
            $this->number_days_pay_first_month->EditCustomAttributes = "";
            $this->number_days_pay_first_month->EditValue = HtmlEncode($this->number_days_pay_first_month->CurrentValue);
            $this->number_days_pay_first_month->PlaceHolder = RemoveHtml($this->number_days_pay_first_month->caption());
            if (strval($this->number_days_pay_first_month->EditValue) != "" && is_numeric($this->number_days_pay_first_month->EditValue)) {
                $this->number_days_pay_first_month->EditValue = FormatNumber($this->number_days_pay_first_month->EditValue, null);
            }

            // number_days_in_first_month
            $this->number_days_in_first_month->setupEditAttributes();
            $this->number_days_in_first_month->EditCustomAttributes = "";
            $this->number_days_in_first_month->EditValue = HtmlEncode($this->number_days_in_first_month->CurrentValue);
            $this->number_days_in_first_month->PlaceHolder = RemoveHtml($this->number_days_in_first_month->caption());
            if (strval($this->number_days_in_first_month->EditValue) != "" && is_numeric($this->number_days_in_first_month->EditValue)) {
                $this->number_days_in_first_month->EditValue = FormatNumber($this->number_days_in_first_month->EditValue, null);
            }

            // move_in_on_20th
            $this->move_in_on_20th->EditCustomAttributes = "";
            $this->move_in_on_20th->EditValue = $this->move_in_on_20th->options(false);
            $this->move_in_on_20th->PlaceHolder = RemoveHtml($this->move_in_on_20th->caption());

            // date_start_installment
            $this->date_start_installment->setupEditAttributes();
            $this->date_start_installment->EditCustomAttributes = "";
            $this->date_start_installment->EditValue = HtmlEncode(FormatDateTime($this->date_start_installment->CurrentValue, $this->date_start_installment->formatPattern()));
            $this->date_start_installment->PlaceHolder = RemoveHtml($this->date_start_installment->caption());

            // status_approve
            $this->status_approve->setupEditAttributes();
            $this->status_approve->EditCustomAttributes = "";
            $this->status_approve->EditValue = $this->status_approve->options(true);
            $this->status_approve->PlaceHolder = RemoveHtml($this->status_approve->caption());

            // cdate

            // cuser

            // cip

            // udate

            // uuser

            // uip

            // Add refer script

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";

            // installment_all
            $this->installment_all->LinkCustomAttributes = "";
            $this->installment_all->HrefValue = "";

            // asset_price
            $this->asset_price->LinkCustomAttributes = "";
            $this->asset_price->HrefValue = "";

            // booking_price
            $this->booking_price->LinkCustomAttributes = "";
            $this->booking_price->HrefValue = "";

            // down_price
            $this->down_price->LinkCustomAttributes = "";
            $this->down_price->HrefValue = "";

            // installment_price_per
            $this->installment_price_per->LinkCustomAttributes = "";
            $this->installment_price_per->HrefValue = "";

            // annual_interest
            $this->annual_interest->LinkCustomAttributes = "";
            $this->annual_interest->HrefValue = "";

            // number_days_pay_first_month
            $this->number_days_pay_first_month->LinkCustomAttributes = "";
            $this->number_days_pay_first_month->HrefValue = "";

            // number_days_in_first_month
            $this->number_days_in_first_month->LinkCustomAttributes = "";
            $this->number_days_in_first_month->HrefValue = "";

            // move_in_on_20th
            $this->move_in_on_20th->LinkCustomAttributes = "";
            $this->move_in_on_20th->HrefValue = "";

            // date_start_installment
            $this->date_start_installment->LinkCustomAttributes = "";
            $this->date_start_installment->HrefValue = "";

            // status_approve
            $this->status_approve->LinkCustomAttributes = "";
            $this->status_approve->HrefValue = "";

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
        if ($this->member_id->Required) {
            if (!$this->member_id->IsDetailKey && EmptyValue($this->member_id->FormValue)) {
                $this->member_id->addErrorMessage(str_replace("%s", $this->member_id->caption(), $this->member_id->RequiredErrorMessage));
            }
        }
        if ($this->asset_id->Required) {
            if (!$this->asset_id->IsDetailKey && EmptyValue($this->asset_id->FormValue)) {
                $this->asset_id->addErrorMessage(str_replace("%s", $this->asset_id->caption(), $this->asset_id->RequiredErrorMessage));
            }
        }
        if ($this->installment_all->Required) {
            if (!$this->installment_all->IsDetailKey && EmptyValue($this->installment_all->FormValue)) {
                $this->installment_all->addErrorMessage(str_replace("%s", $this->installment_all->caption(), $this->installment_all->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->installment_all->FormValue)) {
            $this->installment_all->addErrorMessage($this->installment_all->getErrorMessage(false));
        }
        if ($this->asset_price->Required) {
            if (!$this->asset_price->IsDetailKey && EmptyValue($this->asset_price->FormValue)) {
                $this->asset_price->addErrorMessage(str_replace("%s", $this->asset_price->caption(), $this->asset_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->asset_price->FormValue)) {
            $this->asset_price->addErrorMessage($this->asset_price->getErrorMessage(false));
        }
        if ($this->booking_price->Required) {
            if (!$this->booking_price->IsDetailKey && EmptyValue($this->booking_price->FormValue)) {
                $this->booking_price->addErrorMessage(str_replace("%s", $this->booking_price->caption(), $this->booking_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->booking_price->FormValue)) {
            $this->booking_price->addErrorMessage($this->booking_price->getErrorMessage(false));
        }
        if ($this->down_price->Required) {
            if (!$this->down_price->IsDetailKey && EmptyValue($this->down_price->FormValue)) {
                $this->down_price->addErrorMessage(str_replace("%s", $this->down_price->caption(), $this->down_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->down_price->FormValue)) {
            $this->down_price->addErrorMessage($this->down_price->getErrorMessage(false));
        }
        if ($this->installment_price_per->Required) {
            if (!$this->installment_price_per->IsDetailKey && EmptyValue($this->installment_price_per->FormValue)) {
                $this->installment_price_per->addErrorMessage(str_replace("%s", $this->installment_price_per->caption(), $this->installment_price_per->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->installment_price_per->FormValue)) {
            $this->installment_price_per->addErrorMessage($this->installment_price_per->getErrorMessage(false));
        }
        if ($this->annual_interest->Required) {
            if (!$this->annual_interest->IsDetailKey && EmptyValue($this->annual_interest->FormValue)) {
                $this->annual_interest->addErrorMessage(str_replace("%s", $this->annual_interest->caption(), $this->annual_interest->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->annual_interest->FormValue)) {
            $this->annual_interest->addErrorMessage($this->annual_interest->getErrorMessage(false));
        }
        if ($this->number_days_pay_first_month->Required) {
            if (!$this->number_days_pay_first_month->IsDetailKey && EmptyValue($this->number_days_pay_first_month->FormValue)) {
                $this->number_days_pay_first_month->addErrorMessage(str_replace("%s", $this->number_days_pay_first_month->caption(), $this->number_days_pay_first_month->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->number_days_pay_first_month->FormValue)) {
            $this->number_days_pay_first_month->addErrorMessage($this->number_days_pay_first_month->getErrorMessage(false));
        }
        if ($this->number_days_in_first_month->Required) {
            if (!$this->number_days_in_first_month->IsDetailKey && EmptyValue($this->number_days_in_first_month->FormValue)) {
                $this->number_days_in_first_month->addErrorMessage(str_replace("%s", $this->number_days_in_first_month->caption(), $this->number_days_in_first_month->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->number_days_in_first_month->FormValue)) {
            $this->number_days_in_first_month->addErrorMessage($this->number_days_in_first_month->getErrorMessage(false));
        }
        if ($this->move_in_on_20th->Required) {
            if ($this->move_in_on_20th->FormValue == "") {
                $this->move_in_on_20th->addErrorMessage(str_replace("%s", $this->move_in_on_20th->caption(), $this->move_in_on_20th->RequiredErrorMessage));
            }
        }
        if ($this->date_start_installment->Required) {
            if (!$this->date_start_installment->IsDetailKey && EmptyValue($this->date_start_installment->FormValue)) {
                $this->date_start_installment->addErrorMessage(str_replace("%s", $this->date_start_installment->caption(), $this->date_start_installment->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->date_start_installment->FormValue, $this->date_start_installment->formatPattern())) {
            $this->date_start_installment->addErrorMessage($this->date_start_installment->getErrorMessage(false));
        }
        if ($this->status_approve->Required) {
            if (!$this->status_approve->IsDetailKey && EmptyValue($this->status_approve->FormValue)) {
                $this->status_approve->addErrorMessage(str_replace("%s", $this->status_approve->caption(), $this->status_approve->RequiredErrorMessage));
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

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("AllBuyerAssetScheduleGrid");
        if (in_array("all_buyer_asset_schedule", $detailTblVar) && $detailPage->DetailAdd) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
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

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // member_id
        $this->member_id->setDbValueDef($rsnew, $this->member_id->CurrentValue, null, false);

        // asset_id
        $this->asset_id->setDbValueDef($rsnew, $this->asset_id->CurrentValue, 0, false);

        // installment_all
        $this->installment_all->setDbValueDef($rsnew, $this->installment_all->CurrentValue, null, false);

        // asset_price
        $this->asset_price->setDbValueDef($rsnew, $this->asset_price->CurrentValue, null, false);

        // booking_price
        $this->booking_price->setDbValueDef($rsnew, $this->booking_price->CurrentValue, null, false);

        // down_price
        $this->down_price->setDbValueDef($rsnew, $this->down_price->CurrentValue, null, false);

        // installment_price_per
        $this->installment_price_per->setDbValueDef($rsnew, $this->installment_price_per->CurrentValue, null, false);

        // annual_interest
        $this->annual_interest->setDbValueDef($rsnew, $this->annual_interest->CurrentValue, null, false);

        // number_days_pay_first_month
        $this->number_days_pay_first_month->setDbValueDef($rsnew, $this->number_days_pay_first_month->CurrentValue, 0, strval($this->number_days_pay_first_month->CurrentValue) == "");

        // number_days_in_first_month
        $this->number_days_in_first_month->setDbValueDef($rsnew, $this->number_days_in_first_month->CurrentValue, null, false);

        // move_in_on_20th
        $tmpBool = $this->move_in_on_20th->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->move_in_on_20th->setDbValueDef($rsnew, $tmpBool, 0, strval($this->move_in_on_20th->CurrentValue) == "");

        // date_start_installment
        $this->date_start_installment->setDbValueDef($rsnew, UnFormatDateTime($this->date_start_installment->CurrentValue, $this->date_start_installment->formatPattern()), null, false);

        // status_approve
        $this->status_approve->setDbValueDef($rsnew, $this->status_approve->CurrentValue, null, strval($this->status_approve->CurrentValue) == "");

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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("AllBuyerAssetScheduleGrid");
            if (in_array("all_buyer_asset_schedule", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->buyer_config_asset_schedule_id->setSessionValue($this->buyer_config_asset_schedule_id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "all_buyer_asset_schedule"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->buyer_config_asset_schedule_id->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                if ($this->UseTransaction) { // Commit transaction
                    $conn->commit();
                }
            } else {
                if ($this->UseTransaction) { // Rollback transaction
                    $conn->rollback();
                }
            }
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
            if ($masterTblVar == "buyer_all_booking_asset") {
                $validMaster = true;
                $masterTbl = Container("buyer_all_booking_asset");
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
                if ($this->asset_id->CurrentValue == "") {
                    $this->asset_id->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("all_buyer_asset_schedule", $detailTblVar)) {
                $detailPageObj = Container("AllBuyerAssetScheduleGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->buyer_config_asset_schedule_id->IsDetailKey = true;
                    $detailPageObj->buyer_config_asset_schedule_id->CurrentValue = $this->buyer_config_asset_schedule_id->CurrentValue;
                    $detailPageObj->buyer_config_asset_schedule_id->setSessionValue($detailPageObj->buyer_config_asset_schedule_id->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("allbuyerconfigassetschedulelist"), "", $this->TableVar, true);
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
                case "x_member_id":
                    $conn = Conn("DB");
                    break;
                case "x_asset_id":
                    $conn = Conn("DB");
                    break;
                case "x_move_in_on_20th":
                    break;
                case "x_status_approve":
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
        if(isset($_GET['fk_asset_id'])) {
            $asset_id = @$_GET['fk_asset_id'];
            $sql_buyer_booking = "SELECT * FROM `buyer_booking_asset` WHERE asset_id = ".$asset_id." ORDER BY buyer_booking_asset_id DESC LIMIT 0,1";
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
