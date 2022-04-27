<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class AllAssetScheduleEdit extends AllAssetSchedule
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'all_asset_schedule';

    // Page object name
    public $PageObjName = "AllAssetScheduleEdit";

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

        // Table object (all_asset_schedule)
        if (!isset($GLOBALS["all_asset_schedule"]) || get_class($GLOBALS["all_asset_schedule"]) == PROJECT_NAMESPACE . "all_asset_schedule") {
            $GLOBALS["all_asset_schedule"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'all_asset_schedule');
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
                $tbl = Container("all_asset_schedule");
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
                    if ($pageName == "allassetscheduleview") {
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
            $key .= @$ar['asset_schedule_id'];
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
            $this->asset_schedule_id->Visible = false;
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
        $this->asset_schedule_id->Visible = false;
        $this->asset_id->setVisibility();
        $this->member_id->setVisibility();
        $this->installment_all->setVisibility();
        $this->num_installment->setVisibility();
        $this->installment_per_price->Visible = false;
        $this->receive_per_installment->Visible = false;
        $this->receive_per_installment_invertor->setVisibility();
        $this->pay_number->setVisibility();
        $this->expired_date->setVisibility();
        $this->date_payment->setVisibility();
        $this->status_payment->setVisibility();
        $this->cuser->Visible = false;
        $this->cdate->Visible = false;
        $this->cip->Visible = false;
        $this->uuser->setVisibility();
        $this->udate->setVisibility();
        $this->uip->setVisibility();
        $this->transaction_datetime->Visible = false;
        $this->payment_scheme->Visible = false;
        $this->transaction_ref->Visible = false;
        $this->channel_response_desc->Visible = false;
        $this->res_status->Visible = false;
        $this->res_referenceNo->Visible = false;
        $this->res_paidAgent->Visible = false;
        $this->res_paidChannel->Visible = false;
        $this->res_maskedPan->Visible = false;
        $this->hideFieldsForAddEdit();
        $this->asset_id->Required = false;
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
        $this->setupLookupOptions($this->asset_id);
        $this->setupLookupOptions($this->member_id);
        $this->setupLookupOptions($this->status_payment);

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
            if (($keyValue = Get("asset_schedule_id") ?? Key(0) ?? Route(2)) !== null) {
                $this->asset_schedule_id->setQueryStringValue($keyValue);
                $this->asset_schedule_id->setOldValue($this->asset_schedule_id->QueryStringValue);
            } elseif (Post("asset_schedule_id") !== null) {
                $this->asset_schedule_id->setFormValue(Post("asset_schedule_id"));
                $this->asset_schedule_id->setOldValue($this->asset_schedule_id->FormValue);
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
                if (($keyValue = Get("asset_schedule_id") ?? Route("asset_schedule_id")) !== null) {
                    $this->asset_schedule_id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->asset_schedule_id->CurrentValue = null;
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
                        $this->terminate("allassetschedulelist"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "allassetschedulelist") {
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

        // Check field name 'installment_all' first before field var 'x_installment_all'
        $val = $CurrentForm->hasValue("installment_all") ? $CurrentForm->getValue("installment_all") : $CurrentForm->getValue("x_installment_all");
        if (!$this->installment_all->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->installment_all->Visible = false; // Disable update for API request
            } else {
                $this->installment_all->setFormValue($val, true, $validate);
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

        // Check field name 'receive_per_installment_invertor' first before field var 'x_receive_per_installment_invertor'
        $val = $CurrentForm->hasValue("receive_per_installment_invertor") ? $CurrentForm->getValue("receive_per_installment_invertor") : $CurrentForm->getValue("x_receive_per_installment_invertor");
        if (!$this->receive_per_installment_invertor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->receive_per_installment_invertor->Visible = false; // Disable update for API request
            } else {
                $this->receive_per_installment_invertor->setFormValue($val, true, $validate);
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

        // Check field name 'asset_schedule_id' first before field var 'x_asset_schedule_id'
        $val = $CurrentForm->hasValue("asset_schedule_id") ? $CurrentForm->getValue("asset_schedule_id") : $CurrentForm->getValue("x_asset_schedule_id");
        if (!$this->asset_schedule_id->IsDetailKey) {
            $this->asset_schedule_id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->asset_schedule_id->CurrentValue = $this->asset_schedule_id->FormValue;
        $this->asset_id->CurrentValue = $this->asset_id->FormValue;
        $this->member_id->CurrentValue = $this->member_id->FormValue;
        $this->installment_all->CurrentValue = $this->installment_all->FormValue;
        $this->num_installment->CurrentValue = $this->num_installment->FormValue;
        $this->receive_per_installment_invertor->CurrentValue = $this->receive_per_installment_invertor->FormValue;
        $this->pay_number->CurrentValue = $this->pay_number->FormValue;
        $this->expired_date->CurrentValue = $this->expired_date->FormValue;
        $this->expired_date->CurrentValue = UnFormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern());
        $this->date_payment->CurrentValue = $this->date_payment->FormValue;
        $this->date_payment->CurrentValue = UnFormatDateTime($this->date_payment->CurrentValue, $this->date_payment->formatPattern());
        $this->status_payment->CurrentValue = $this->status_payment->FormValue;
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
        $this->asset_schedule_id->setDbValue($row['asset_schedule_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->installment_all->setDbValue($row['installment_all']);
        $this->num_installment->setDbValue($row['num_installment']);
        $this->installment_per_price->setDbValue($row['installment_per_price']);
        $this->receive_per_installment->setDbValue($row['receive_per_installment']);
        $this->receive_per_installment_invertor->setDbValue($row['receive_per_installment_invertor']);
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
        $this->res_paidAgent->setDbValue($row['res_paidAgent']);
        $this->res_paidChannel->setDbValue($row['res_paidChannel']);
        $this->res_maskedPan->setDbValue($row['res_maskedPan']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['asset_schedule_id'] = null;
        $row['asset_id'] = null;
        $row['member_id'] = null;
        $row['installment_all'] = null;
        $row['num_installment'] = null;
        $row['installment_per_price'] = null;
        $row['receive_per_installment'] = null;
        $row['receive_per_installment_invertor'] = null;
        $row['pay_number'] = null;
        $row['expired_date'] = null;
        $row['date_payment'] = null;
        $row['status_payment'] = null;
        $row['cuser'] = null;
        $row['cdate'] = null;
        $row['cip'] = null;
        $row['uuser'] = null;
        $row['udate'] = null;
        $row['uip'] = null;
        $row['transaction_datetime'] = null;
        $row['payment_scheme'] = null;
        $row['transaction_ref'] = null;
        $row['channel_response_desc'] = null;
        $row['res_status'] = null;
        $row['res_referenceNo'] = null;
        $row['res_paidAgent'] = null;
        $row['res_paidChannel'] = null;
        $row['res_maskedPan'] = null;
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

        // asset_schedule_id
        $this->asset_schedule_id->RowCssClass = "row";

        // asset_id
        $this->asset_id->RowCssClass = "row";

        // member_id
        $this->member_id->RowCssClass = "row";

        // installment_all
        $this->installment_all->RowCssClass = "row";

        // num_installment
        $this->num_installment->RowCssClass = "row";

        // installment_per_price
        $this->installment_per_price->RowCssClass = "row";

        // receive_per_installment
        $this->receive_per_installment->RowCssClass = "row";

        // receive_per_installment_invertor
        $this->receive_per_installment_invertor->RowCssClass = "row";

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

        // res_paidAgent
        $this->res_paidAgent->RowCssClass = "row";

        // res_paidChannel
        $this->res_paidChannel->RowCssClass = "row";

        // res_maskedPan
        $this->res_maskedPan->RowCssClass = "row";

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

            // installment_all
            $this->installment_all->ViewValue = $this->installment_all->CurrentValue;
            $this->installment_all->ViewValue = FormatNumber($this->installment_all->ViewValue, $this->installment_all->formatPattern());
            $this->installment_all->ViewCustomAttributes = "";

            // num_installment
            $this->num_installment->ViewValue = $this->num_installment->CurrentValue;
            $this->num_installment->ViewValue = FormatNumber($this->num_installment->ViewValue, $this->num_installment->formatPattern());
            $this->num_installment->ViewCustomAttributes = "";

            // receive_per_installment_invertor
            $this->receive_per_installment_invertor->ViewValue = $this->receive_per_installment_invertor->CurrentValue;
            $this->receive_per_installment_invertor->ViewValue = FormatCurrency($this->receive_per_installment_invertor->ViewValue, $this->receive_per_installment_invertor->formatPattern());
            $this->receive_per_installment_invertor->ViewCustomAttributes = "";

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

            // cdate
            $this->cdate->ViewValue = $this->cdate->CurrentValue;
            $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
            $this->cdate->ViewCustomAttributes = "";

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

            // installment_all
            $this->installment_all->LinkCustomAttributes = "";
            $this->installment_all->HrefValue = "";

            // num_installment
            $this->num_installment->LinkCustomAttributes = "";
            $this->num_installment->HrefValue = "";

            // receive_per_installment_invertor
            $this->receive_per_installment_invertor->LinkCustomAttributes = "";
            $this->receive_per_installment_invertor->HrefValue = "";

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

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // asset_id
            $this->asset_id->setupEditAttributes();
            $this->asset_id->EditCustomAttributes = "";
            $curVal = strval($this->asset_id->CurrentValue);
            if ($curVal != "") {
                $this->asset_id->EditValue = $this->asset_id->lookupCacheOption($curVal);
                if ($this->asset_id->EditValue === null) { // Lookup from database
                    $filterWrk = "`asset_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->asset_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->asset_id->Lookup->renderViewRow($rswrk[0]);
                        $this->asset_id->EditValue = $this->asset_id->displayValue($arwrk);
                    } else {
                        $this->asset_id->EditValue = FormatNumber($this->asset_id->CurrentValue, $this->asset_id->formatPattern());
                    }
                }
            } else {
                $this->asset_id->EditValue = null;
            }
            $this->asset_id->ViewCustomAttributes = "";

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

            // installment_all
            $this->installment_all->setupEditAttributes();
            $this->installment_all->EditCustomAttributes = "";
            $this->installment_all->EditValue = HtmlEncode($this->installment_all->CurrentValue);
            $this->installment_all->PlaceHolder = RemoveHtml($this->installment_all->caption());
            if (strval($this->installment_all->EditValue) != "" && is_numeric($this->installment_all->EditValue)) {
                $this->installment_all->EditValue = FormatNumber($this->installment_all->EditValue, null);
            }

            // num_installment
            $this->num_installment->setupEditAttributes();
            $this->num_installment->EditCustomAttributes = "";
            $this->num_installment->EditValue = HtmlEncode($this->num_installment->CurrentValue);
            $this->num_installment->PlaceHolder = RemoveHtml($this->num_installment->caption());
            if (strval($this->num_installment->EditValue) != "" && is_numeric($this->num_installment->EditValue)) {
                $this->num_installment->EditValue = FormatNumber($this->num_installment->EditValue, null);
            }

            // receive_per_installment_invertor
            $this->receive_per_installment_invertor->setupEditAttributes();
            $this->receive_per_installment_invertor->EditCustomAttributes = "";
            $this->receive_per_installment_invertor->EditValue = HtmlEncode($this->receive_per_installment_invertor->CurrentValue);
            $this->receive_per_installment_invertor->PlaceHolder = RemoveHtml($this->receive_per_installment_invertor->caption());
            if (strval($this->receive_per_installment_invertor->EditValue) != "" && is_numeric($this->receive_per_installment_invertor->EditValue)) {
                $this->receive_per_installment_invertor->EditValue = FormatNumber($this->receive_per_installment_invertor->EditValue, null);
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

            // uuser

            // udate

            // uip

            // Edit refer script

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";
            $this->asset_id->TooltipValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // installment_all
            $this->installment_all->LinkCustomAttributes = "";
            $this->installment_all->HrefValue = "";

            // num_installment
            $this->num_installment->LinkCustomAttributes = "";
            $this->num_installment->HrefValue = "";

            // receive_per_installment_invertor
            $this->receive_per_installment_invertor->LinkCustomAttributes = "";
            $this->receive_per_installment_invertor->HrefValue = "";

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
        if ($this->installment_all->Required) {
            if (!$this->installment_all->IsDetailKey && EmptyValue($this->installment_all->FormValue)) {
                $this->installment_all->addErrorMessage(str_replace("%s", $this->installment_all->caption(), $this->installment_all->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->installment_all->FormValue)) {
            $this->installment_all->addErrorMessage($this->installment_all->getErrorMessage(false));
        }
        if ($this->num_installment->Required) {
            if (!$this->num_installment->IsDetailKey && EmptyValue($this->num_installment->FormValue)) {
                $this->num_installment->addErrorMessage(str_replace("%s", $this->num_installment->caption(), $this->num_installment->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->num_installment->FormValue)) {
            $this->num_installment->addErrorMessage($this->num_installment->getErrorMessage(false));
        }
        if ($this->receive_per_installment_invertor->Required) {
            if (!$this->receive_per_installment_invertor->IsDetailKey && EmptyValue($this->receive_per_installment_invertor->FormValue)) {
                $this->receive_per_installment_invertor->addErrorMessage(str_replace("%s", $this->receive_per_installment_invertor->caption(), $this->receive_per_installment_invertor->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->receive_per_installment_invertor->FormValue)) {
            $this->receive_per_installment_invertor->addErrorMessage($this->receive_per_installment_invertor->getErrorMessage(false));
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

            // installment_all
            $this->installment_all->setDbValueDef($rsnew, $this->installment_all->CurrentValue, null, $this->installment_all->ReadOnly);

            // num_installment
            $this->num_installment->setDbValueDef($rsnew, $this->num_installment->CurrentValue, null, $this->num_installment->ReadOnly);

            // receive_per_installment_invertor
            $this->receive_per_installment_invertor->setDbValueDef($rsnew, $this->receive_per_installment_invertor->CurrentValue, null, $this->receive_per_installment_invertor->ReadOnly);

            // pay_number
            $this->pay_number->setDbValueDef($rsnew, $this->pay_number->CurrentValue, null, $this->pay_number->ReadOnly);

            // expired_date
            $this->expired_date->setDbValueDef($rsnew, UnFormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern()), null, $this->expired_date->ReadOnly);

            // date_payment
            $this->date_payment->setDbValueDef($rsnew, UnFormatDateTime($this->date_payment->CurrentValue, $this->date_payment->formatPattern()), null, $this->date_payment->ReadOnly);

            // status_payment
            $this->status_payment->setDbValueDef($rsnew, $this->status_payment->CurrentValue, null, $this->status_payment->ReadOnly);

            // uuser
            $this->uuser->CurrentValue = CurrentUserID();
            $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, null);

            // udate
            $this->udate->CurrentValue = CurrentDateTime();
            $this->udate->setDbValueDef($rsnew, $this->udate->CurrentValue, null);

            // uip
            $this->uip->CurrentValue = CurrentUserIP();
            $this->uip->setDbValueDef($rsnew, $this->uip->CurrentValue, null);

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
            if ($masterTblVar == "invertor_all_booking") {
                $validMaster = true;
                $masterTbl = Container("invertor_all_booking");
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
            if ($masterTblVar == "invertor_all_booking") {
                $validMaster = true;
                $masterTbl = Container("invertor_all_booking");
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
            $this->setSessionWhere($this->getDetailFilterFromSession());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "invertor_all_booking") {
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("allassetschedulelist"), "", $this->TableVar, true);
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
