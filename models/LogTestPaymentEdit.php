<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class LogTestPaymentEdit extends LogTestPayment
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'log_test_payment';

    // Page object name
    public $PageObjName = "LogTestPaymentEdit";

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

        // Table object (log_test_payment)
        if (!isset($GLOBALS["log_test_payment"]) || get_class($GLOBALS["log_test_payment"]) == PROJECT_NAMESPACE . "log_test_payment") {
            $GLOBALS["log_test_payment"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'log_test_payment');
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
                $tbl = Container("log_test_payment");
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
                    if ($pageName == "logtestpaymentview") {
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
            $key .= @$ar['log_test_payment_id'];
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
            $this->log_test_payment_id->Visible = false;
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
        $this->log_test_payment_id->setVisibility();
        $this->member_id->setVisibility();
        $this->asset_id->setVisibility();
        $this->type->setVisibility();
        $this->date_booking->setVisibility();
        $this->date_payment->setVisibility();
        $this->due_date->setVisibility();
        $this->booking_price->setVisibility();
        $this->pay_number->setVisibility();
        $this->status_payment->setVisibility();
        $this->transaction_datetime->setVisibility();
        $this->payment_scheme->setVisibility();
        $this->transaction_ref->setVisibility();
        $this->channel_response_desc->setVisibility();
        $this->res_status->setVisibility();
        $this->res_referenceNo->setVisibility();
        $this->res_paidAgent->setVisibility();
        $this->res_paidChannel->setVisibility();
        $this->res_maskedPan->setVisibility();
        $this->status_expire->setVisibility();
        $this->status_expire_reason->setVisibility();
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
            if (($keyValue = Get("log_test_payment_id") ?? Key(0) ?? Route(2)) !== null) {
                $this->log_test_payment_id->setQueryStringValue($keyValue);
                $this->log_test_payment_id->setOldValue($this->log_test_payment_id->QueryStringValue);
            } elseif (Post("log_test_payment_id") !== null) {
                $this->log_test_payment_id->setFormValue(Post("log_test_payment_id"));
                $this->log_test_payment_id->setOldValue($this->log_test_payment_id->FormValue);
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
                if (($keyValue = Get("log_test_payment_id") ?? Route("log_test_payment_id")) !== null) {
                    $this->log_test_payment_id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->log_test_payment_id->CurrentValue = null;
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
                        $this->terminate("logtestpaymentlist"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "logtestpaymentlist") {
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

        // Check field name 'log_test_payment_id' first before field var 'x_log_test_payment_id'
        $val = $CurrentForm->hasValue("log_test_payment_id") ? $CurrentForm->getValue("log_test_payment_id") : $CurrentForm->getValue("x_log_test_payment_id");
        if (!$this->log_test_payment_id->IsDetailKey) {
            $this->log_test_payment_id->setFormValue($val);
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

        // Check field name 'asset_id' first before field var 'x_asset_id'
        $val = $CurrentForm->hasValue("asset_id") ? $CurrentForm->getValue("asset_id") : $CurrentForm->getValue("x_asset_id");
        if (!$this->asset_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_id->Visible = false; // Disable update for API request
            } else {
                $this->asset_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'type' first before field var 'x_type'
        $val = $CurrentForm->hasValue("type") ? $CurrentForm->getValue("type") : $CurrentForm->getValue("x_type");
        if (!$this->type->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->type->Visible = false; // Disable update for API request
            } else {
                $this->type->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'date_booking' first before field var 'x_date_booking'
        $val = $CurrentForm->hasValue("date_booking") ? $CurrentForm->getValue("date_booking") : $CurrentForm->getValue("x_date_booking");
        if (!$this->date_booking->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->date_booking->Visible = false; // Disable update for API request
            } else {
                $this->date_booking->setFormValue($val, true, $validate);
            }
            $this->date_booking->CurrentValue = UnFormatDateTime($this->date_booking->CurrentValue, $this->date_booking->formatPattern());
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

        // Check field name 'due_date' first before field var 'x_due_date'
        $val = $CurrentForm->hasValue("due_date") ? $CurrentForm->getValue("due_date") : $CurrentForm->getValue("x_due_date");
        if (!$this->due_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->due_date->Visible = false; // Disable update for API request
            } else {
                $this->due_date->setFormValue($val, true, $validate);
            }
            $this->due_date->CurrentValue = UnFormatDateTime($this->due_date->CurrentValue, $this->due_date->formatPattern());
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

        // Check field name 'pay_number' first before field var 'x_pay_number'
        $val = $CurrentForm->hasValue("pay_number") ? $CurrentForm->getValue("pay_number") : $CurrentForm->getValue("x_pay_number");
        if (!$this->pay_number->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pay_number->Visible = false; // Disable update for API request
            } else {
                $this->pay_number->setFormValue($val);
            }
        }

        // Check field name 'status_payment' first before field var 'x_status_payment'
        $val = $CurrentForm->hasValue("status_payment") ? $CurrentForm->getValue("status_payment") : $CurrentForm->getValue("x_status_payment");
        if (!$this->status_payment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_payment->Visible = false; // Disable update for API request
            } else {
                $this->status_payment->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'transaction_datetime' first before field var 'x_transaction_datetime'
        $val = $CurrentForm->hasValue("transaction_datetime") ? $CurrentForm->getValue("transaction_datetime") : $CurrentForm->getValue("x_transaction_datetime");
        if (!$this->transaction_datetime->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->transaction_datetime->Visible = false; // Disable update for API request
            } else {
                $this->transaction_datetime->setFormValue($val, true, $validate);
            }
            $this->transaction_datetime->CurrentValue = UnFormatDateTime($this->transaction_datetime->CurrentValue, $this->transaction_datetime->formatPattern());
        }

        // Check field name 'payment_scheme' first before field var 'x_payment_scheme'
        $val = $CurrentForm->hasValue("payment_scheme") ? $CurrentForm->getValue("payment_scheme") : $CurrentForm->getValue("x_payment_scheme");
        if (!$this->payment_scheme->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->payment_scheme->Visible = false; // Disable update for API request
            } else {
                $this->payment_scheme->setFormValue($val);
            }
        }

        // Check field name 'transaction_ref' first before field var 'x_transaction_ref'
        $val = $CurrentForm->hasValue("transaction_ref") ? $CurrentForm->getValue("transaction_ref") : $CurrentForm->getValue("x_transaction_ref");
        if (!$this->transaction_ref->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->transaction_ref->Visible = false; // Disable update for API request
            } else {
                $this->transaction_ref->setFormValue($val);
            }
        }

        // Check field name 'channel_response_desc' first before field var 'x_channel_response_desc'
        $val = $CurrentForm->hasValue("channel_response_desc") ? $CurrentForm->getValue("channel_response_desc") : $CurrentForm->getValue("x_channel_response_desc");
        if (!$this->channel_response_desc->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->channel_response_desc->Visible = false; // Disable update for API request
            } else {
                $this->channel_response_desc->setFormValue($val);
            }
        }

        // Check field name 'res_status' first before field var 'x_res_status'
        $val = $CurrentForm->hasValue("res_status") ? $CurrentForm->getValue("res_status") : $CurrentForm->getValue("x_res_status");
        if (!$this->res_status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->res_status->Visible = false; // Disable update for API request
            } else {
                $this->res_status->setFormValue($val);
            }
        }

        // Check field name 'res_referenceNo' first before field var 'x_res_referenceNo'
        $val = $CurrentForm->hasValue("res_referenceNo") ? $CurrentForm->getValue("res_referenceNo") : $CurrentForm->getValue("x_res_referenceNo");
        if (!$this->res_referenceNo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->res_referenceNo->Visible = false; // Disable update for API request
            } else {
                $this->res_referenceNo->setFormValue($val);
            }
        }

        // Check field name 'res_paidAgent' first before field var 'x_res_paidAgent'
        $val = $CurrentForm->hasValue("res_paidAgent") ? $CurrentForm->getValue("res_paidAgent") : $CurrentForm->getValue("x_res_paidAgent");
        if (!$this->res_paidAgent->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->res_paidAgent->Visible = false; // Disable update for API request
            } else {
                $this->res_paidAgent->setFormValue($val);
            }
        }

        // Check field name 'res_paidChannel' first before field var 'x_res_paidChannel'
        $val = $CurrentForm->hasValue("res_paidChannel") ? $CurrentForm->getValue("res_paidChannel") : $CurrentForm->getValue("x_res_paidChannel");
        if (!$this->res_paidChannel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->res_paidChannel->Visible = false; // Disable update for API request
            } else {
                $this->res_paidChannel->setFormValue($val);
            }
        }

        // Check field name 'res_maskedPan' first before field var 'x_res_maskedPan'
        $val = $CurrentForm->hasValue("res_maskedPan") ? $CurrentForm->getValue("res_maskedPan") : $CurrentForm->getValue("x_res_maskedPan");
        if (!$this->res_maskedPan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->res_maskedPan->Visible = false; // Disable update for API request
            } else {
                $this->res_maskedPan->setFormValue($val);
            }
        }

        // Check field name 'status_expire' first before field var 'x_status_expire'
        $val = $CurrentForm->hasValue("status_expire") ? $CurrentForm->getValue("status_expire") : $CurrentForm->getValue("x_status_expire");
        if (!$this->status_expire->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_expire->Visible = false; // Disable update for API request
            } else {
                $this->status_expire->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'status_expire_reason' first before field var 'x_status_expire_reason'
        $val = $CurrentForm->hasValue("status_expire_reason") ? $CurrentForm->getValue("status_expire_reason") : $CurrentForm->getValue("x_status_expire_reason");
        if (!$this->status_expire_reason->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_expire_reason->Visible = false; // Disable update for API request
            } else {
                $this->status_expire_reason->setFormValue($val);
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
                $this->uuser->setFormValue($val, true, $validate);
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
        $this->log_test_payment_id->CurrentValue = $this->log_test_payment_id->FormValue;
        $this->member_id->CurrentValue = $this->member_id->FormValue;
        $this->asset_id->CurrentValue = $this->asset_id->FormValue;
        $this->type->CurrentValue = $this->type->FormValue;
        $this->date_booking->CurrentValue = $this->date_booking->FormValue;
        $this->date_booking->CurrentValue = UnFormatDateTime($this->date_booking->CurrentValue, $this->date_booking->formatPattern());
        $this->date_payment->CurrentValue = $this->date_payment->FormValue;
        $this->date_payment->CurrentValue = UnFormatDateTime($this->date_payment->CurrentValue, $this->date_payment->formatPattern());
        $this->due_date->CurrentValue = $this->due_date->FormValue;
        $this->due_date->CurrentValue = UnFormatDateTime($this->due_date->CurrentValue, $this->due_date->formatPattern());
        $this->booking_price->CurrentValue = $this->booking_price->FormValue;
        $this->pay_number->CurrentValue = $this->pay_number->FormValue;
        $this->status_payment->CurrentValue = $this->status_payment->FormValue;
        $this->transaction_datetime->CurrentValue = $this->transaction_datetime->FormValue;
        $this->transaction_datetime->CurrentValue = UnFormatDateTime($this->transaction_datetime->CurrentValue, $this->transaction_datetime->formatPattern());
        $this->payment_scheme->CurrentValue = $this->payment_scheme->FormValue;
        $this->transaction_ref->CurrentValue = $this->transaction_ref->FormValue;
        $this->channel_response_desc->CurrentValue = $this->channel_response_desc->FormValue;
        $this->res_status->CurrentValue = $this->res_status->FormValue;
        $this->res_referenceNo->CurrentValue = $this->res_referenceNo->FormValue;
        $this->res_paidAgent->CurrentValue = $this->res_paidAgent->FormValue;
        $this->res_paidChannel->CurrentValue = $this->res_paidChannel->FormValue;
        $this->res_maskedPan->CurrentValue = $this->res_maskedPan->FormValue;
        $this->status_expire->CurrentValue = $this->status_expire->FormValue;
        $this->status_expire_reason->CurrentValue = $this->status_expire_reason->FormValue;
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
        $this->log_test_payment_id->setDbValue($row['log_test_payment_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->type->setDbValue($row['type']);
        $this->date_booking->setDbValue($row['date_booking']);
        $this->date_payment->setDbValue($row['date_payment']);
        $this->due_date->setDbValue($row['due_date']);
        $this->booking_price->setDbValue($row['booking_price']);
        $this->pay_number->setDbValue($row['pay_number']);
        $this->status_payment->setDbValue($row['status_payment']);
        $this->transaction_datetime->setDbValue($row['transaction_datetime']);
        $this->payment_scheme->setDbValue($row['payment_scheme']);
        $this->transaction_ref->setDbValue($row['transaction_ref']);
        $this->channel_response_desc->setDbValue($row['channel_response_desc']);
        $this->res_status->setDbValue($row['res_status']);
        $this->res_referenceNo->setDbValue($row['res_referenceNo']);
        $this->res_paidAgent->setDbValue($row['res_paidAgent']);
        $this->res_paidChannel->setDbValue($row['res_paidChannel']);
        $this->res_maskedPan->setDbValue($row['res_maskedPan']);
        $this->status_expire->setDbValue($row['status_expire']);
        $this->status_expire_reason->setDbValue($row['status_expire_reason']);
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
        $row['log_test_payment_id'] = null;
        $row['member_id'] = null;
        $row['asset_id'] = null;
        $row['type'] = null;
        $row['date_booking'] = null;
        $row['date_payment'] = null;
        $row['due_date'] = null;
        $row['booking_price'] = null;
        $row['pay_number'] = null;
        $row['status_payment'] = null;
        $row['transaction_datetime'] = null;
        $row['payment_scheme'] = null;
        $row['transaction_ref'] = null;
        $row['channel_response_desc'] = null;
        $row['res_status'] = null;
        $row['res_referenceNo'] = null;
        $row['res_paidAgent'] = null;
        $row['res_paidChannel'] = null;
        $row['res_maskedPan'] = null;
        $row['status_expire'] = null;
        $row['status_expire_reason'] = null;
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

        // log_test_payment_id
        $this->log_test_payment_id->RowCssClass = "row";

        // member_id
        $this->member_id->RowCssClass = "row";

        // asset_id
        $this->asset_id->RowCssClass = "row";

        // type
        $this->type->RowCssClass = "row";

        // date_booking
        $this->date_booking->RowCssClass = "row";

        // date_payment
        $this->date_payment->RowCssClass = "row";

        // due_date
        $this->due_date->RowCssClass = "row";

        // booking_price
        $this->booking_price->RowCssClass = "row";

        // pay_number
        $this->pay_number->RowCssClass = "row";

        // status_payment
        $this->status_payment->RowCssClass = "row";

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

        // status_expire
        $this->status_expire->RowCssClass = "row";

        // status_expire_reason
        $this->status_expire_reason->RowCssClass = "row";

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
            // log_test_payment_id
            $this->log_test_payment_id->ViewValue = $this->log_test_payment_id->CurrentValue;
            $this->log_test_payment_id->ViewCustomAttributes = "";

            // member_id
            $this->member_id->ViewValue = $this->member_id->CurrentValue;
            $this->member_id->ViewValue = FormatNumber($this->member_id->ViewValue, $this->member_id->formatPattern());
            $this->member_id->ViewCustomAttributes = "";

            // asset_id
            $this->asset_id->ViewValue = $this->asset_id->CurrentValue;
            $this->asset_id->ViewValue = FormatNumber($this->asset_id->ViewValue, $this->asset_id->formatPattern());
            $this->asset_id->ViewCustomAttributes = "";

            // type
            $this->type->ViewValue = $this->type->CurrentValue;
            $this->type->ViewValue = FormatNumber($this->type->ViewValue, $this->type->formatPattern());
            $this->type->ViewCustomAttributes = "";

            // date_booking
            $this->date_booking->ViewValue = $this->date_booking->CurrentValue;
            $this->date_booking->ViewValue = FormatDateTime($this->date_booking->ViewValue, $this->date_booking->formatPattern());
            $this->date_booking->ViewCustomAttributes = "";

            // date_payment
            $this->date_payment->ViewValue = $this->date_payment->CurrentValue;
            $this->date_payment->ViewValue = FormatDateTime($this->date_payment->ViewValue, $this->date_payment->formatPattern());
            $this->date_payment->ViewCustomAttributes = "";

            // due_date
            $this->due_date->ViewValue = $this->due_date->CurrentValue;
            $this->due_date->ViewValue = FormatDateTime($this->due_date->ViewValue, $this->due_date->formatPattern());
            $this->due_date->ViewCustomAttributes = "";

            // booking_price
            $this->booking_price->ViewValue = $this->booking_price->CurrentValue;
            $this->booking_price->ViewValue = FormatNumber($this->booking_price->ViewValue, $this->booking_price->formatPattern());
            $this->booking_price->ViewCustomAttributes = "";

            // pay_number
            $this->pay_number->ViewValue = $this->pay_number->CurrentValue;
            $this->pay_number->ViewCustomAttributes = "";

            // status_payment
            $this->status_payment->ViewValue = $this->status_payment->CurrentValue;
            $this->status_payment->ViewValue = FormatNumber($this->status_payment->ViewValue, $this->status_payment->formatPattern());
            $this->status_payment->ViewCustomAttributes = "";

            // transaction_datetime
            $this->transaction_datetime->ViewValue = $this->transaction_datetime->CurrentValue;
            $this->transaction_datetime->ViewValue = FormatDateTime($this->transaction_datetime->ViewValue, $this->transaction_datetime->formatPattern());
            $this->transaction_datetime->ViewCustomAttributes = "";

            // payment_scheme
            $this->payment_scheme->ViewValue = $this->payment_scheme->CurrentValue;
            $this->payment_scheme->ViewCustomAttributes = "";

            // transaction_ref
            $this->transaction_ref->ViewValue = $this->transaction_ref->CurrentValue;
            $this->transaction_ref->ViewCustomAttributes = "";

            // channel_response_desc
            $this->channel_response_desc->ViewValue = $this->channel_response_desc->CurrentValue;
            $this->channel_response_desc->ViewCustomAttributes = "";

            // res_status
            $this->res_status->ViewValue = $this->res_status->CurrentValue;
            $this->res_status->ViewCustomAttributes = "";

            // res_referenceNo
            $this->res_referenceNo->ViewValue = $this->res_referenceNo->CurrentValue;
            $this->res_referenceNo->ViewCustomAttributes = "";

            // res_paidAgent
            $this->res_paidAgent->ViewValue = $this->res_paidAgent->CurrentValue;
            $this->res_paidAgent->ViewCustomAttributes = "";

            // res_paidChannel
            $this->res_paidChannel->ViewValue = $this->res_paidChannel->CurrentValue;
            $this->res_paidChannel->ViewCustomAttributes = "";

            // res_maskedPan
            $this->res_maskedPan->ViewValue = $this->res_maskedPan->CurrentValue;
            $this->res_maskedPan->ViewCustomAttributes = "";

            // status_expire
            $this->status_expire->ViewValue = $this->status_expire->CurrentValue;
            $this->status_expire->ViewValue = FormatNumber($this->status_expire->ViewValue, $this->status_expire->formatPattern());
            $this->status_expire->ViewCustomAttributes = "";

            // status_expire_reason
            $this->status_expire_reason->ViewValue = $this->status_expire_reason->CurrentValue;
            $this->status_expire_reason->ViewCustomAttributes = "";

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

            // udate
            $this->udate->ViewValue = $this->udate->CurrentValue;
            $this->udate->ViewValue = FormatDateTime($this->udate->ViewValue, $this->udate->formatPattern());
            $this->udate->ViewCustomAttributes = "";

            // uuser
            $this->uuser->ViewValue = $this->uuser->CurrentValue;
            $this->uuser->ViewValue = FormatNumber($this->uuser->ViewValue, $this->uuser->formatPattern());
            $this->uuser->ViewCustomAttributes = "";

            // uip
            $this->uip->ViewValue = $this->uip->CurrentValue;
            $this->uip->ViewCustomAttributes = "";

            // log_test_payment_id
            $this->log_test_payment_id->LinkCustomAttributes = "";
            $this->log_test_payment_id->HrefValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";

            // type
            $this->type->LinkCustomAttributes = "";
            $this->type->HrefValue = "";

            // date_booking
            $this->date_booking->LinkCustomAttributes = "";
            $this->date_booking->HrefValue = "";

            // date_payment
            $this->date_payment->LinkCustomAttributes = "";
            $this->date_payment->HrefValue = "";

            // due_date
            $this->due_date->LinkCustomAttributes = "";
            $this->due_date->HrefValue = "";

            // booking_price
            $this->booking_price->LinkCustomAttributes = "";
            $this->booking_price->HrefValue = "";

            // pay_number
            $this->pay_number->LinkCustomAttributes = "";
            $this->pay_number->HrefValue = "";

            // status_payment
            $this->status_payment->LinkCustomAttributes = "";
            $this->status_payment->HrefValue = "";

            // transaction_datetime
            $this->transaction_datetime->LinkCustomAttributes = "";
            $this->transaction_datetime->HrefValue = "";

            // payment_scheme
            $this->payment_scheme->LinkCustomAttributes = "";
            $this->payment_scheme->HrefValue = "";

            // transaction_ref
            $this->transaction_ref->LinkCustomAttributes = "";
            $this->transaction_ref->HrefValue = "";

            // channel_response_desc
            $this->channel_response_desc->LinkCustomAttributes = "";
            $this->channel_response_desc->HrefValue = "";

            // res_status
            $this->res_status->LinkCustomAttributes = "";
            $this->res_status->HrefValue = "";

            // res_referenceNo
            $this->res_referenceNo->LinkCustomAttributes = "";
            $this->res_referenceNo->HrefValue = "";

            // res_paidAgent
            $this->res_paidAgent->LinkCustomAttributes = "";
            $this->res_paidAgent->HrefValue = "";

            // res_paidChannel
            $this->res_paidChannel->LinkCustomAttributes = "";
            $this->res_paidChannel->HrefValue = "";

            // res_maskedPan
            $this->res_maskedPan->LinkCustomAttributes = "";
            $this->res_maskedPan->HrefValue = "";

            // status_expire
            $this->status_expire->LinkCustomAttributes = "";
            $this->status_expire->HrefValue = "";

            // status_expire_reason
            $this->status_expire_reason->LinkCustomAttributes = "";
            $this->status_expire_reason->HrefValue = "";

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
            // log_test_payment_id
            $this->log_test_payment_id->setupEditAttributes();
            $this->log_test_payment_id->EditCustomAttributes = "";
            $this->log_test_payment_id->EditValue = $this->log_test_payment_id->CurrentValue;
            $this->log_test_payment_id->ViewCustomAttributes = "";

            // member_id
            $this->member_id->setupEditAttributes();
            $this->member_id->EditCustomAttributes = "";
            $this->member_id->EditValue = HtmlEncode($this->member_id->CurrentValue);
            $this->member_id->PlaceHolder = RemoveHtml($this->member_id->caption());
            if (strval($this->member_id->EditValue) != "" && is_numeric($this->member_id->EditValue)) {
                $this->member_id->EditValue = FormatNumber($this->member_id->EditValue, null);
            }

            // asset_id
            $this->asset_id->setupEditAttributes();
            $this->asset_id->EditCustomAttributes = "";
            $this->asset_id->EditValue = HtmlEncode($this->asset_id->CurrentValue);
            $this->asset_id->PlaceHolder = RemoveHtml($this->asset_id->caption());
            if (strval($this->asset_id->EditValue) != "" && is_numeric($this->asset_id->EditValue)) {
                $this->asset_id->EditValue = FormatNumber($this->asset_id->EditValue, null);
            }

            // type
            $this->type->setupEditAttributes();
            $this->type->EditCustomAttributes = "";
            $this->type->EditValue = HtmlEncode($this->type->CurrentValue);
            $this->type->PlaceHolder = RemoveHtml($this->type->caption());
            if (strval($this->type->EditValue) != "" && is_numeric($this->type->EditValue)) {
                $this->type->EditValue = FormatNumber($this->type->EditValue, null);
            }

            // date_booking
            $this->date_booking->setupEditAttributes();
            $this->date_booking->EditCustomAttributes = "";
            $this->date_booking->EditValue = HtmlEncode(FormatDateTime($this->date_booking->CurrentValue, $this->date_booking->formatPattern()));
            $this->date_booking->PlaceHolder = RemoveHtml($this->date_booking->caption());

            // date_payment
            $this->date_payment->setupEditAttributes();
            $this->date_payment->EditCustomAttributes = "";
            $this->date_payment->EditValue = HtmlEncode(FormatDateTime($this->date_payment->CurrentValue, $this->date_payment->formatPattern()));
            $this->date_payment->PlaceHolder = RemoveHtml($this->date_payment->caption());

            // due_date
            $this->due_date->setupEditAttributes();
            $this->due_date->EditCustomAttributes = "";
            $this->due_date->EditValue = HtmlEncode(FormatDateTime($this->due_date->CurrentValue, $this->due_date->formatPattern()));
            $this->due_date->PlaceHolder = RemoveHtml($this->due_date->caption());

            // booking_price
            $this->booking_price->setupEditAttributes();
            $this->booking_price->EditCustomAttributes = "";
            $this->booking_price->EditValue = HtmlEncode($this->booking_price->CurrentValue);
            $this->booking_price->PlaceHolder = RemoveHtml($this->booking_price->caption());
            if (strval($this->booking_price->EditValue) != "" && is_numeric($this->booking_price->EditValue)) {
                $this->booking_price->EditValue = FormatNumber($this->booking_price->EditValue, null);
            }

            // pay_number
            $this->pay_number->setupEditAttributes();
            $this->pay_number->EditCustomAttributes = "";
            if (!$this->pay_number->Raw) {
                $this->pay_number->CurrentValue = HtmlDecode($this->pay_number->CurrentValue);
            }
            $this->pay_number->EditValue = HtmlEncode($this->pay_number->CurrentValue);
            $this->pay_number->PlaceHolder = RemoveHtml($this->pay_number->caption());

            // status_payment
            $this->status_payment->setupEditAttributes();
            $this->status_payment->EditCustomAttributes = "";
            $this->status_payment->EditValue = HtmlEncode($this->status_payment->CurrentValue);
            $this->status_payment->PlaceHolder = RemoveHtml($this->status_payment->caption());
            if (strval($this->status_payment->EditValue) != "" && is_numeric($this->status_payment->EditValue)) {
                $this->status_payment->EditValue = FormatNumber($this->status_payment->EditValue, null);
            }

            // transaction_datetime
            $this->transaction_datetime->setupEditAttributes();
            $this->transaction_datetime->EditCustomAttributes = "";
            $this->transaction_datetime->EditValue = HtmlEncode(FormatDateTime($this->transaction_datetime->CurrentValue, $this->transaction_datetime->formatPattern()));
            $this->transaction_datetime->PlaceHolder = RemoveHtml($this->transaction_datetime->caption());

            // payment_scheme
            $this->payment_scheme->setupEditAttributes();
            $this->payment_scheme->EditCustomAttributes = "";
            if (!$this->payment_scheme->Raw) {
                $this->payment_scheme->CurrentValue = HtmlDecode($this->payment_scheme->CurrentValue);
            }
            $this->payment_scheme->EditValue = HtmlEncode($this->payment_scheme->CurrentValue);
            $this->payment_scheme->PlaceHolder = RemoveHtml($this->payment_scheme->caption());

            // transaction_ref
            $this->transaction_ref->setupEditAttributes();
            $this->transaction_ref->EditCustomAttributes = "";
            if (!$this->transaction_ref->Raw) {
                $this->transaction_ref->CurrentValue = HtmlDecode($this->transaction_ref->CurrentValue);
            }
            $this->transaction_ref->EditValue = HtmlEncode($this->transaction_ref->CurrentValue);
            $this->transaction_ref->PlaceHolder = RemoveHtml($this->transaction_ref->caption());

            // channel_response_desc
            $this->channel_response_desc->setupEditAttributes();
            $this->channel_response_desc->EditCustomAttributes = "";
            if (!$this->channel_response_desc->Raw) {
                $this->channel_response_desc->CurrentValue = HtmlDecode($this->channel_response_desc->CurrentValue);
            }
            $this->channel_response_desc->EditValue = HtmlEncode($this->channel_response_desc->CurrentValue);
            $this->channel_response_desc->PlaceHolder = RemoveHtml($this->channel_response_desc->caption());

            // res_status
            $this->res_status->setupEditAttributes();
            $this->res_status->EditCustomAttributes = "";
            if (!$this->res_status->Raw) {
                $this->res_status->CurrentValue = HtmlDecode($this->res_status->CurrentValue);
            }
            $this->res_status->EditValue = HtmlEncode($this->res_status->CurrentValue);
            $this->res_status->PlaceHolder = RemoveHtml($this->res_status->caption());

            // res_referenceNo
            $this->res_referenceNo->setupEditAttributes();
            $this->res_referenceNo->EditCustomAttributes = "";
            if (!$this->res_referenceNo->Raw) {
                $this->res_referenceNo->CurrentValue = HtmlDecode($this->res_referenceNo->CurrentValue);
            }
            $this->res_referenceNo->EditValue = HtmlEncode($this->res_referenceNo->CurrentValue);
            $this->res_referenceNo->PlaceHolder = RemoveHtml($this->res_referenceNo->caption());

            // res_paidAgent
            $this->res_paidAgent->setupEditAttributes();
            $this->res_paidAgent->EditCustomAttributes = "";
            if (!$this->res_paidAgent->Raw) {
                $this->res_paidAgent->CurrentValue = HtmlDecode($this->res_paidAgent->CurrentValue);
            }
            $this->res_paidAgent->EditValue = HtmlEncode($this->res_paidAgent->CurrentValue);
            $this->res_paidAgent->PlaceHolder = RemoveHtml($this->res_paidAgent->caption());

            // res_paidChannel
            $this->res_paidChannel->setupEditAttributes();
            $this->res_paidChannel->EditCustomAttributes = "";
            if (!$this->res_paidChannel->Raw) {
                $this->res_paidChannel->CurrentValue = HtmlDecode($this->res_paidChannel->CurrentValue);
            }
            $this->res_paidChannel->EditValue = HtmlEncode($this->res_paidChannel->CurrentValue);
            $this->res_paidChannel->PlaceHolder = RemoveHtml($this->res_paidChannel->caption());

            // res_maskedPan
            $this->res_maskedPan->setupEditAttributes();
            $this->res_maskedPan->EditCustomAttributes = "";
            if (!$this->res_maskedPan->Raw) {
                $this->res_maskedPan->CurrentValue = HtmlDecode($this->res_maskedPan->CurrentValue);
            }
            $this->res_maskedPan->EditValue = HtmlEncode($this->res_maskedPan->CurrentValue);
            $this->res_maskedPan->PlaceHolder = RemoveHtml($this->res_maskedPan->caption());

            // status_expire
            $this->status_expire->setupEditAttributes();
            $this->status_expire->EditCustomAttributes = "";
            $this->status_expire->EditValue = HtmlEncode($this->status_expire->CurrentValue);
            $this->status_expire->PlaceHolder = RemoveHtml($this->status_expire->caption());
            if (strval($this->status_expire->EditValue) != "" && is_numeric($this->status_expire->EditValue)) {
                $this->status_expire->EditValue = FormatNumber($this->status_expire->EditValue, null);
            }

            // status_expire_reason
            $this->status_expire_reason->setupEditAttributes();
            $this->status_expire_reason->EditCustomAttributes = "";
            if (!$this->status_expire_reason->Raw) {
                $this->status_expire_reason->CurrentValue = HtmlDecode($this->status_expire_reason->CurrentValue);
            }
            $this->status_expire_reason->EditValue = HtmlEncode($this->status_expire_reason->CurrentValue);
            $this->status_expire_reason->PlaceHolder = RemoveHtml($this->status_expire_reason->caption());

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

            // udate
            $this->udate->setupEditAttributes();
            $this->udate->EditCustomAttributes = "";
            $this->udate->EditValue = HtmlEncode(FormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern()));
            $this->udate->PlaceHolder = RemoveHtml($this->udate->caption());

            // uuser
            $this->uuser->setupEditAttributes();
            $this->uuser->EditCustomAttributes = "";
            $this->uuser->EditValue = HtmlEncode($this->uuser->CurrentValue);
            $this->uuser->PlaceHolder = RemoveHtml($this->uuser->caption());
            if (strval($this->uuser->EditValue) != "" && is_numeric($this->uuser->EditValue)) {
                $this->uuser->EditValue = FormatNumber($this->uuser->EditValue, null);
            }

            // uip
            $this->uip->setupEditAttributes();
            $this->uip->EditCustomAttributes = "";
            if (!$this->uip->Raw) {
                $this->uip->CurrentValue = HtmlDecode($this->uip->CurrentValue);
            }
            $this->uip->EditValue = HtmlEncode($this->uip->CurrentValue);
            $this->uip->PlaceHolder = RemoveHtml($this->uip->caption());

            // Edit refer script

            // log_test_payment_id
            $this->log_test_payment_id->LinkCustomAttributes = "";
            $this->log_test_payment_id->HrefValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";

            // type
            $this->type->LinkCustomAttributes = "";
            $this->type->HrefValue = "";

            // date_booking
            $this->date_booking->LinkCustomAttributes = "";
            $this->date_booking->HrefValue = "";

            // date_payment
            $this->date_payment->LinkCustomAttributes = "";
            $this->date_payment->HrefValue = "";

            // due_date
            $this->due_date->LinkCustomAttributes = "";
            $this->due_date->HrefValue = "";

            // booking_price
            $this->booking_price->LinkCustomAttributes = "";
            $this->booking_price->HrefValue = "";

            // pay_number
            $this->pay_number->LinkCustomAttributes = "";
            $this->pay_number->HrefValue = "";

            // status_payment
            $this->status_payment->LinkCustomAttributes = "";
            $this->status_payment->HrefValue = "";

            // transaction_datetime
            $this->transaction_datetime->LinkCustomAttributes = "";
            $this->transaction_datetime->HrefValue = "";

            // payment_scheme
            $this->payment_scheme->LinkCustomAttributes = "";
            $this->payment_scheme->HrefValue = "";

            // transaction_ref
            $this->transaction_ref->LinkCustomAttributes = "";
            $this->transaction_ref->HrefValue = "";

            // channel_response_desc
            $this->channel_response_desc->LinkCustomAttributes = "";
            $this->channel_response_desc->HrefValue = "";

            // res_status
            $this->res_status->LinkCustomAttributes = "";
            $this->res_status->HrefValue = "";

            // res_referenceNo
            $this->res_referenceNo->LinkCustomAttributes = "";
            $this->res_referenceNo->HrefValue = "";

            // res_paidAgent
            $this->res_paidAgent->LinkCustomAttributes = "";
            $this->res_paidAgent->HrefValue = "";

            // res_paidChannel
            $this->res_paidChannel->LinkCustomAttributes = "";
            $this->res_paidChannel->HrefValue = "";

            // res_maskedPan
            $this->res_maskedPan->LinkCustomAttributes = "";
            $this->res_maskedPan->HrefValue = "";

            // status_expire
            $this->status_expire->LinkCustomAttributes = "";
            $this->status_expire->HrefValue = "";

            // status_expire_reason
            $this->status_expire_reason->LinkCustomAttributes = "";
            $this->status_expire_reason->HrefValue = "";

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
        if ($this->log_test_payment_id->Required) {
            if (!$this->log_test_payment_id->IsDetailKey && EmptyValue($this->log_test_payment_id->FormValue)) {
                $this->log_test_payment_id->addErrorMessage(str_replace("%s", $this->log_test_payment_id->caption(), $this->log_test_payment_id->RequiredErrorMessage));
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
        if ($this->asset_id->Required) {
            if (!$this->asset_id->IsDetailKey && EmptyValue($this->asset_id->FormValue)) {
                $this->asset_id->addErrorMessage(str_replace("%s", $this->asset_id->caption(), $this->asset_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->asset_id->FormValue)) {
            $this->asset_id->addErrorMessage($this->asset_id->getErrorMessage(false));
        }
        if ($this->type->Required) {
            if (!$this->type->IsDetailKey && EmptyValue($this->type->FormValue)) {
                $this->type->addErrorMessage(str_replace("%s", $this->type->caption(), $this->type->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->type->FormValue)) {
            $this->type->addErrorMessage($this->type->getErrorMessage(false));
        }
        if ($this->date_booking->Required) {
            if (!$this->date_booking->IsDetailKey && EmptyValue($this->date_booking->FormValue)) {
                $this->date_booking->addErrorMessage(str_replace("%s", $this->date_booking->caption(), $this->date_booking->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->date_booking->FormValue, $this->date_booking->formatPattern())) {
            $this->date_booking->addErrorMessage($this->date_booking->getErrorMessage(false));
        }
        if ($this->date_payment->Required) {
            if (!$this->date_payment->IsDetailKey && EmptyValue($this->date_payment->FormValue)) {
                $this->date_payment->addErrorMessage(str_replace("%s", $this->date_payment->caption(), $this->date_payment->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->date_payment->FormValue, $this->date_payment->formatPattern())) {
            $this->date_payment->addErrorMessage($this->date_payment->getErrorMessage(false));
        }
        if ($this->due_date->Required) {
            if (!$this->due_date->IsDetailKey && EmptyValue($this->due_date->FormValue)) {
                $this->due_date->addErrorMessage(str_replace("%s", $this->due_date->caption(), $this->due_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->due_date->FormValue, $this->due_date->formatPattern())) {
            $this->due_date->addErrorMessage($this->due_date->getErrorMessage(false));
        }
        if ($this->booking_price->Required) {
            if (!$this->booking_price->IsDetailKey && EmptyValue($this->booking_price->FormValue)) {
                $this->booking_price->addErrorMessage(str_replace("%s", $this->booking_price->caption(), $this->booking_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->booking_price->FormValue)) {
            $this->booking_price->addErrorMessage($this->booking_price->getErrorMessage(false));
        }
        if ($this->pay_number->Required) {
            if (!$this->pay_number->IsDetailKey && EmptyValue($this->pay_number->FormValue)) {
                $this->pay_number->addErrorMessage(str_replace("%s", $this->pay_number->caption(), $this->pay_number->RequiredErrorMessage));
            }
        }
        if ($this->status_payment->Required) {
            if (!$this->status_payment->IsDetailKey && EmptyValue($this->status_payment->FormValue)) {
                $this->status_payment->addErrorMessage(str_replace("%s", $this->status_payment->caption(), $this->status_payment->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->status_payment->FormValue)) {
            $this->status_payment->addErrorMessage($this->status_payment->getErrorMessage(false));
        }
        if ($this->transaction_datetime->Required) {
            if (!$this->transaction_datetime->IsDetailKey && EmptyValue($this->transaction_datetime->FormValue)) {
                $this->transaction_datetime->addErrorMessage(str_replace("%s", $this->transaction_datetime->caption(), $this->transaction_datetime->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->transaction_datetime->FormValue, $this->transaction_datetime->formatPattern())) {
            $this->transaction_datetime->addErrorMessage($this->transaction_datetime->getErrorMessage(false));
        }
        if ($this->payment_scheme->Required) {
            if (!$this->payment_scheme->IsDetailKey && EmptyValue($this->payment_scheme->FormValue)) {
                $this->payment_scheme->addErrorMessage(str_replace("%s", $this->payment_scheme->caption(), $this->payment_scheme->RequiredErrorMessage));
            }
        }
        if ($this->transaction_ref->Required) {
            if (!$this->transaction_ref->IsDetailKey && EmptyValue($this->transaction_ref->FormValue)) {
                $this->transaction_ref->addErrorMessage(str_replace("%s", $this->transaction_ref->caption(), $this->transaction_ref->RequiredErrorMessage));
            }
        }
        if ($this->channel_response_desc->Required) {
            if (!$this->channel_response_desc->IsDetailKey && EmptyValue($this->channel_response_desc->FormValue)) {
                $this->channel_response_desc->addErrorMessage(str_replace("%s", $this->channel_response_desc->caption(), $this->channel_response_desc->RequiredErrorMessage));
            }
        }
        if ($this->res_status->Required) {
            if (!$this->res_status->IsDetailKey && EmptyValue($this->res_status->FormValue)) {
                $this->res_status->addErrorMessage(str_replace("%s", $this->res_status->caption(), $this->res_status->RequiredErrorMessage));
            }
        }
        if ($this->res_referenceNo->Required) {
            if (!$this->res_referenceNo->IsDetailKey && EmptyValue($this->res_referenceNo->FormValue)) {
                $this->res_referenceNo->addErrorMessage(str_replace("%s", $this->res_referenceNo->caption(), $this->res_referenceNo->RequiredErrorMessage));
            }
        }
        if ($this->res_paidAgent->Required) {
            if (!$this->res_paidAgent->IsDetailKey && EmptyValue($this->res_paidAgent->FormValue)) {
                $this->res_paidAgent->addErrorMessage(str_replace("%s", $this->res_paidAgent->caption(), $this->res_paidAgent->RequiredErrorMessage));
            }
        }
        if ($this->res_paidChannel->Required) {
            if (!$this->res_paidChannel->IsDetailKey && EmptyValue($this->res_paidChannel->FormValue)) {
                $this->res_paidChannel->addErrorMessage(str_replace("%s", $this->res_paidChannel->caption(), $this->res_paidChannel->RequiredErrorMessage));
            }
        }
        if ($this->res_maskedPan->Required) {
            if (!$this->res_maskedPan->IsDetailKey && EmptyValue($this->res_maskedPan->FormValue)) {
                $this->res_maskedPan->addErrorMessage(str_replace("%s", $this->res_maskedPan->caption(), $this->res_maskedPan->RequiredErrorMessage));
            }
        }
        if ($this->status_expire->Required) {
            if (!$this->status_expire->IsDetailKey && EmptyValue($this->status_expire->FormValue)) {
                $this->status_expire->addErrorMessage(str_replace("%s", $this->status_expire->caption(), $this->status_expire->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->status_expire->FormValue)) {
            $this->status_expire->addErrorMessage($this->status_expire->getErrorMessage(false));
        }
        if ($this->status_expire_reason->Required) {
            if (!$this->status_expire_reason->IsDetailKey && EmptyValue($this->status_expire_reason->FormValue)) {
                $this->status_expire_reason->addErrorMessage(str_replace("%s", $this->status_expire_reason->caption(), $this->status_expire_reason->RequiredErrorMessage));
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
        if (!CheckInteger($this->uuser->FormValue)) {
            $this->uuser->addErrorMessage($this->uuser->getErrorMessage(false));
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

            // member_id
            $this->member_id->setDbValueDef($rsnew, $this->member_id->CurrentValue, null, $this->member_id->ReadOnly);

            // asset_id
            $this->asset_id->setDbValueDef($rsnew, $this->asset_id->CurrentValue, null, $this->asset_id->ReadOnly);

            // type
            $this->type->setDbValueDef($rsnew, $this->type->CurrentValue, null, $this->type->ReadOnly);

            // date_booking
            $this->date_booking->setDbValueDef($rsnew, UnFormatDateTime($this->date_booking->CurrentValue, $this->date_booking->formatPattern()), null, $this->date_booking->ReadOnly);

            // date_payment
            $this->date_payment->setDbValueDef($rsnew, UnFormatDateTime($this->date_payment->CurrentValue, $this->date_payment->formatPattern()), null, $this->date_payment->ReadOnly);

            // due_date
            $this->due_date->setDbValueDef($rsnew, UnFormatDateTime($this->due_date->CurrentValue, $this->due_date->formatPattern()), null, $this->due_date->ReadOnly);

            // booking_price
            $this->booking_price->setDbValueDef($rsnew, $this->booking_price->CurrentValue, null, $this->booking_price->ReadOnly);

            // pay_number
            $this->pay_number->setDbValueDef($rsnew, $this->pay_number->CurrentValue, null, $this->pay_number->ReadOnly);

            // status_payment
            $this->status_payment->setDbValueDef($rsnew, $this->status_payment->CurrentValue, null, $this->status_payment->ReadOnly);

            // transaction_datetime
            $this->transaction_datetime->setDbValueDef($rsnew, UnFormatDateTime($this->transaction_datetime->CurrentValue, $this->transaction_datetime->formatPattern()), null, $this->transaction_datetime->ReadOnly);

            // payment_scheme
            $this->payment_scheme->setDbValueDef($rsnew, $this->payment_scheme->CurrentValue, null, $this->payment_scheme->ReadOnly);

            // transaction_ref
            $this->transaction_ref->setDbValueDef($rsnew, $this->transaction_ref->CurrentValue, null, $this->transaction_ref->ReadOnly);

            // channel_response_desc
            $this->channel_response_desc->setDbValueDef($rsnew, $this->channel_response_desc->CurrentValue, null, $this->channel_response_desc->ReadOnly);

            // res_status
            $this->res_status->setDbValueDef($rsnew, $this->res_status->CurrentValue, null, $this->res_status->ReadOnly);

            // res_referenceNo
            $this->res_referenceNo->setDbValueDef($rsnew, $this->res_referenceNo->CurrentValue, null, $this->res_referenceNo->ReadOnly);

            // res_paidAgent
            $this->res_paidAgent->setDbValueDef($rsnew, $this->res_paidAgent->CurrentValue, null, $this->res_paidAgent->ReadOnly);

            // res_paidChannel
            $this->res_paidChannel->setDbValueDef($rsnew, $this->res_paidChannel->CurrentValue, null, $this->res_paidChannel->ReadOnly);

            // res_maskedPan
            $this->res_maskedPan->setDbValueDef($rsnew, $this->res_maskedPan->CurrentValue, null, $this->res_maskedPan->ReadOnly);

            // status_expire
            $this->status_expire->setDbValueDef($rsnew, $this->status_expire->CurrentValue, 0, $this->status_expire->ReadOnly);

            // status_expire_reason
            $this->status_expire_reason->setDbValueDef($rsnew, $this->status_expire_reason->CurrentValue, null, $this->status_expire_reason->ReadOnly);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("logtestpaymentlist"), "", $this->TableVar, true);
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
