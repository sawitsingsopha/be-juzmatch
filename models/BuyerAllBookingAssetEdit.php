<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class BuyerAllBookingAssetEdit extends BuyerAllBookingAsset
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'buyer_all_booking_asset';

    // Page object name
    public $PageObjName = "BuyerAllBookingAssetEdit";

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

        // Table object (buyer_all_booking_asset)
        if (!isset($GLOBALS["buyer_all_booking_asset"]) || get_class($GLOBALS["buyer_all_booking_asset"]) == PROJECT_NAMESPACE . "buyer_all_booking_asset") {
            $GLOBALS["buyer_all_booking_asset"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'buyer_all_booking_asset');
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
                $tbl = Container("buyer_all_booking_asset");
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
                    if ($pageName == "buyerallbookingassetview") {
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
            $key .= @$ar['buyer_booking_asset_id'];
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
            $this->buyer_booking_asset_id->Visible = false;
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
        $this->buyer_booking_asset_id->Visible = false;
        $this->asset_id->setVisibility();
        $this->member_id->setVisibility();
        $this->booking_price->setVisibility();
        $this->pay_number->setVisibility();
        $this->status_payment->setVisibility();
        $this->date_booking->setVisibility();
        $this->date_payment->setVisibility();
        $this->due_date->setVisibility();
        $this->status_expire->setVisibility();
        $this->status_expire_reason->setVisibility();
        $this->cdate->Visible = false;
        $this->cuser->Visible = false;
        $this->cip->Visible = false;
        $this->udate->setVisibility();
        $this->uuser->setVisibility();
        $this->uip->setVisibility();
        $this->type->Visible = false;
        $this->transaction_datetime->Visible = false;
        $this->payment_scheme->Visible = false;
        $this->transaction_ref->Visible = false;
        $this->channel_response_desc->Visible = false;
        $this->res_status->Visible = false;
        $this->res_referenceNo->Visible = false;
        $this->res_paidAgent->Visible = false;
        $this->res_paidChannel->Visible = false;
        $this->res_maskedPan->Visible = false;
        $this->receipt_status->Visible = false;
        $this->is_email->Visible = false;
        $this->authorize_url->Visible = false;
        $this->amount_net->Visible = false;
        $this->amount_cust_fee->Visible = false;
        $this->hideFieldsForAddEdit();
        $this->asset_id->Required = false;
        $this->member_id->Required = false;
        $this->booking_price->Required = false;
        $this->pay_number->Required = false;
        $this->date_booking->Required = false;
        $this->date_payment->Required = false;

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
        $this->setupLookupOptions($this->status_expire);

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
            if (($keyValue = Get("buyer_booking_asset_id") ?? Key(0) ?? Route(2)) !== null) {
                $this->buyer_booking_asset_id->setQueryStringValue($keyValue);
                $this->buyer_booking_asset_id->setOldValue($this->buyer_booking_asset_id->QueryStringValue);
            } elseif (Post("buyer_booking_asset_id") !== null) {
                $this->buyer_booking_asset_id->setFormValue(Post("buyer_booking_asset_id"));
                $this->buyer_booking_asset_id->setOldValue($this->buyer_booking_asset_id->FormValue);
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
                if (($keyValue = Get("buyer_booking_asset_id") ?? Route("buyer_booking_asset_id")) !== null) {
                    $this->buyer_booking_asset_id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->buyer_booking_asset_id->CurrentValue = null;
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

            // Set up detail parameters
            $this->setupDetailParms();
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
                        $this->terminate("buyerallbookingassetlist"); // No matching record, return to list
                        return;
                    }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "buyerallbookingassetlist") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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

        // Check field name 'booking_price' first before field var 'x_booking_price'
        $val = $CurrentForm->hasValue("booking_price") ? $CurrentForm->getValue("booking_price") : $CurrentForm->getValue("x_booking_price");
        if (!$this->booking_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->booking_price->Visible = false; // Disable update for API request
            } else {
                $this->booking_price->setFormValue($val);
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
                $this->status_payment->setFormValue($val);
            }
        }

        // Check field name 'date_booking' first before field var 'x_date_booking'
        $val = $CurrentForm->hasValue("date_booking") ? $CurrentForm->getValue("date_booking") : $CurrentForm->getValue("x_date_booking");
        if (!$this->date_booking->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->date_booking->Visible = false; // Disable update for API request
            } else {
                $this->date_booking->setFormValue($val);
            }
            $this->date_booking->CurrentValue = UnFormatDateTime($this->date_booking->CurrentValue, $this->date_booking->formatPattern());
        }

        // Check field name 'date_payment' first before field var 'x_date_payment'
        $val = $CurrentForm->hasValue("date_payment") ? $CurrentForm->getValue("date_payment") : $CurrentForm->getValue("x_date_payment");
        if (!$this->date_payment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->date_payment->Visible = false; // Disable update for API request
            } else {
                $this->date_payment->setFormValue($val);
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

        // Check field name 'status_expire' first before field var 'x_status_expire'
        $val = $CurrentForm->hasValue("status_expire") ? $CurrentForm->getValue("status_expire") : $CurrentForm->getValue("x_status_expire");
        if (!$this->status_expire->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_expire->Visible = false; // Disable update for API request
            } else {
                $this->status_expire->setFormValue($val);
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

        // Check field name 'buyer_booking_asset_id' first before field var 'x_buyer_booking_asset_id'
        $val = $CurrentForm->hasValue("buyer_booking_asset_id") ? $CurrentForm->getValue("buyer_booking_asset_id") : $CurrentForm->getValue("x_buyer_booking_asset_id");
        if (!$this->buyer_booking_asset_id->IsDetailKey) {
            $this->buyer_booking_asset_id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->buyer_booking_asset_id->CurrentValue = $this->buyer_booking_asset_id->FormValue;
        $this->asset_id->CurrentValue = $this->asset_id->FormValue;
        $this->member_id->CurrentValue = $this->member_id->FormValue;
        $this->booking_price->CurrentValue = $this->booking_price->FormValue;
        $this->pay_number->CurrentValue = $this->pay_number->FormValue;
        $this->status_payment->CurrentValue = $this->status_payment->FormValue;
        $this->date_booking->CurrentValue = $this->date_booking->FormValue;
        $this->date_booking->CurrentValue = UnFormatDateTime($this->date_booking->CurrentValue, $this->date_booking->formatPattern());
        $this->date_payment->CurrentValue = $this->date_payment->FormValue;
        $this->date_payment->CurrentValue = UnFormatDateTime($this->date_payment->CurrentValue, $this->date_payment->formatPattern());
        $this->due_date->CurrentValue = $this->due_date->FormValue;
        $this->due_date->CurrentValue = UnFormatDateTime($this->due_date->CurrentValue, $this->due_date->formatPattern());
        $this->status_expire->CurrentValue = $this->status_expire->FormValue;
        $this->status_expire_reason->CurrentValue = $this->status_expire_reason->FormValue;
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
        $this->buyer_booking_asset_id->setDbValue($row['buyer_booking_asset_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->booking_price->setDbValue($row['booking_price']);
        $this->pay_number->setDbValue($row['pay_number']);
        $this->status_payment->setDbValue($row['status_payment']);
        $this->date_booking->setDbValue($row['date_booking']);
        $this->date_payment->setDbValue($row['date_payment']);
        $this->due_date->setDbValue($row['due_date']);
        $this->status_expire->setDbValue($row['status_expire']);
        $this->status_expire_reason->setDbValue($row['status_expire_reason']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->type->setDbValue($row['type']);
        $this->transaction_datetime->setDbValue($row['transaction_datetime']);
        $this->payment_scheme->setDbValue($row['payment_scheme']);
        $this->transaction_ref->setDbValue($row['transaction_ref']);
        $this->channel_response_desc->setDbValue($row['channel_response_desc']);
        $this->res_status->setDbValue($row['res_status']);
        $this->res_referenceNo->setDbValue($row['res_referenceNo']);
        $this->res_paidAgent->setDbValue($row['res_paidAgent']);
        $this->res_paidChannel->setDbValue($row['res_paidChannel']);
        $this->res_maskedPan->setDbValue($row['res_maskedPan']);
        $this->receipt_status->setDbValue($row['receipt_status']);
        $this->is_email->setDbValue($row['is_email']);
        $this->authorize_url->setDbValue($row['authorize_url']);
        $this->amount_net->setDbValue($row['amount_net']);
        $this->amount_cust_fee->setDbValue($row['amount_cust_fee']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['buyer_booking_asset_id'] = null;
        $row['asset_id'] = null;
        $row['member_id'] = null;
        $row['booking_price'] = null;
        $row['pay_number'] = null;
        $row['status_payment'] = null;
        $row['date_booking'] = null;
        $row['date_payment'] = null;
        $row['due_date'] = null;
        $row['status_expire'] = null;
        $row['status_expire_reason'] = null;
        $row['cdate'] = null;
        $row['cuser'] = null;
        $row['cip'] = null;
        $row['udate'] = null;
        $row['uuser'] = null;
        $row['uip'] = null;
        $row['type'] = null;
        $row['transaction_datetime'] = null;
        $row['payment_scheme'] = null;
        $row['transaction_ref'] = null;
        $row['channel_response_desc'] = null;
        $row['res_status'] = null;
        $row['res_referenceNo'] = null;
        $row['res_paidAgent'] = null;
        $row['res_paidChannel'] = null;
        $row['res_maskedPan'] = null;
        $row['receipt_status'] = null;
        $row['is_email'] = null;
        $row['authorize_url'] = null;
        $row['amount_net'] = null;
        $row['amount_cust_fee'] = null;
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

        // buyer_booking_asset_id
        $this->buyer_booking_asset_id->RowCssClass = "row";

        // asset_id
        $this->asset_id->RowCssClass = "row";

        // member_id
        $this->member_id->RowCssClass = "row";

        // booking_price
        $this->booking_price->RowCssClass = "row";

        // pay_number
        $this->pay_number->RowCssClass = "row";

        // status_payment
        $this->status_payment->RowCssClass = "row";

        // date_booking
        $this->date_booking->RowCssClass = "row";

        // date_payment
        $this->date_payment->RowCssClass = "row";

        // due_date
        $this->due_date->RowCssClass = "row";

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

        // type
        $this->type->RowCssClass = "row";

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

        // receipt_status
        $this->receipt_status->RowCssClass = "row";

        // is_email
        $this->is_email->RowCssClass = "row";

        // authorize_url
        $this->authorize_url->RowCssClass = "row";

        // amount_net
        $this->amount_net->RowCssClass = "row";

        // amount_cust_fee
        $this->amount_cust_fee->RowCssClass = "row";

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
                    $lookupFilter = function() {
                        return "`isactive` = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->member_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // booking_price
            $this->booking_price->ViewValue = $this->booking_price->CurrentValue;
            $this->booking_price->ViewValue = FormatNumber($this->booking_price->ViewValue, $this->booking_price->formatPattern());
            $this->booking_price->ViewCustomAttributes = "";

            // pay_number
            $this->pay_number->ViewValue = $this->pay_number->CurrentValue;
            $this->pay_number->ViewCustomAttributes = "";

            // status_payment
            if (strval($this->status_payment->CurrentValue) != "") {
                $this->status_payment->ViewValue = $this->status_payment->optionCaption($this->status_payment->CurrentValue);
            } else {
                $this->status_payment->ViewValue = null;
            }
            $this->status_payment->ViewCustomAttributes = "";

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

            // status_expire
            if (strval($this->status_expire->CurrentValue) != "") {
                $this->status_expire->ViewValue = $this->status_expire->optionCaption($this->status_expire->CurrentValue);
            } else {
                $this->status_expire->ViewValue = null;
            }
            $this->status_expire->ViewCustomAttributes = "";

            // status_expire_reason
            $this->status_expire_reason->ViewValue = $this->status_expire_reason->CurrentValue;
            $this->status_expire_reason->ViewCustomAttributes = "";

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

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";
            $this->asset_id->TooltipValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // booking_price
            $this->booking_price->LinkCustomAttributes = "";
            $this->booking_price->HrefValue = "";
            $this->booking_price->TooltipValue = "";

            // pay_number
            $this->pay_number->LinkCustomAttributes = "";
            $this->pay_number->HrefValue = "";
            $this->pay_number->TooltipValue = "";

            // status_payment
            $this->status_payment->LinkCustomAttributes = "";
            $this->status_payment->HrefValue = "";
            $this->status_payment->TooltipValue = "";

            // date_booking
            $this->date_booking->LinkCustomAttributes = "";
            $this->date_booking->HrefValue = "";
            $this->date_booking->TooltipValue = "";

            // date_payment
            $this->date_payment->LinkCustomAttributes = "";
            $this->date_payment->HrefValue = "";
            $this->date_payment->TooltipValue = "";

            // due_date
            $this->due_date->LinkCustomAttributes = "";
            $this->due_date->HrefValue = "";

            // status_expire
            $this->status_expire->LinkCustomAttributes = "";
            $this->status_expire->HrefValue = "";

            // status_expire_reason
            $this->status_expire_reason->LinkCustomAttributes = "";
            $this->status_expire_reason->HrefValue = "";

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
                    $lookupFilter = function() {
                        return "`isactive` = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->member_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // booking_price
            $this->booking_price->setupEditAttributes();
            $this->booking_price->EditCustomAttributes = "";
            $this->booking_price->EditValue = $this->booking_price->CurrentValue;
            $this->booking_price->EditValue = FormatNumber($this->booking_price->EditValue, $this->booking_price->formatPattern());
            $this->booking_price->ViewCustomAttributes = "";

            // pay_number
            $this->pay_number->setupEditAttributes();
            $this->pay_number->EditCustomAttributes = "";
            $this->pay_number->EditValue = $this->pay_number->CurrentValue;
            $this->pay_number->ViewCustomAttributes = "";

            // status_payment
            $this->status_payment->setupEditAttributes();
            $this->status_payment->EditCustomAttributes = "";
            if (strval($this->status_payment->CurrentValue) != "") {
                $this->status_payment->EditValue = $this->status_payment->optionCaption($this->status_payment->CurrentValue);
            } else {
                $this->status_payment->EditValue = null;
            }
            $this->status_payment->ViewCustomAttributes = "";

            // date_booking
            $this->date_booking->setupEditAttributes();
            $this->date_booking->EditCustomAttributes = "";
            $this->date_booking->EditValue = $this->date_booking->CurrentValue;
            $this->date_booking->EditValue = FormatDateTime($this->date_booking->EditValue, $this->date_booking->formatPattern());
            $this->date_booking->ViewCustomAttributes = "";

            // date_payment
            $this->date_payment->setupEditAttributes();
            $this->date_payment->EditCustomAttributes = "";
            $this->date_payment->EditValue = $this->date_payment->CurrentValue;
            $this->date_payment->EditValue = FormatDateTime($this->date_payment->EditValue, $this->date_payment->formatPattern());
            $this->date_payment->ViewCustomAttributes = "";

            // due_date
            $this->due_date->setupEditAttributes();
            $this->due_date->EditCustomAttributes = "";
            $this->due_date->EditValue = HtmlEncode(FormatDateTime($this->due_date->CurrentValue, $this->due_date->formatPattern()));
            $this->due_date->PlaceHolder = RemoveHtml($this->due_date->caption());

            // status_expire
            $this->status_expire->EditCustomAttributes = "";
            $this->status_expire->EditValue = $this->status_expire->options(false);
            $this->status_expire->PlaceHolder = RemoveHtml($this->status_expire->caption());

            // status_expire_reason
            $this->status_expire_reason->setupEditAttributes();
            $this->status_expire_reason->EditCustomAttributes = "";
            if (!$this->status_expire_reason->Raw) {
                $this->status_expire_reason->CurrentValue = HtmlDecode($this->status_expire_reason->CurrentValue);
            }
            $this->status_expire_reason->EditValue = HtmlEncode($this->status_expire_reason->CurrentValue);
            $this->status_expire_reason->PlaceHolder = RemoveHtml($this->status_expire_reason->caption());

            // udate

            // uuser

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

            // booking_price
            $this->booking_price->LinkCustomAttributes = "";
            $this->booking_price->HrefValue = "";
            $this->booking_price->TooltipValue = "";

            // pay_number
            $this->pay_number->LinkCustomAttributes = "";
            $this->pay_number->HrefValue = "";
            $this->pay_number->TooltipValue = "";

            // status_payment
            $this->status_payment->LinkCustomAttributes = "";
            $this->status_payment->HrefValue = "";
            $this->status_payment->TooltipValue = "";

            // date_booking
            $this->date_booking->LinkCustomAttributes = "";
            $this->date_booking->HrefValue = "";
            $this->date_booking->TooltipValue = "";

            // date_payment
            $this->date_payment->LinkCustomAttributes = "";
            $this->date_payment->HrefValue = "";
            $this->date_payment->TooltipValue = "";

            // due_date
            $this->due_date->LinkCustomAttributes = "";
            $this->due_date->HrefValue = "";

            // status_expire
            $this->status_expire->LinkCustomAttributes = "";
            $this->status_expire->HrefValue = "";

            // status_expire_reason
            $this->status_expire_reason->LinkCustomAttributes = "";
            $this->status_expire_reason->HrefValue = "";

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
        if ($this->booking_price->Required) {
            if (!$this->booking_price->IsDetailKey && EmptyValue($this->booking_price->FormValue)) {
                $this->booking_price->addErrorMessage(str_replace("%s", $this->booking_price->caption(), $this->booking_price->RequiredErrorMessage));
            }
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
        if ($this->date_booking->Required) {
            if (!$this->date_booking->IsDetailKey && EmptyValue($this->date_booking->FormValue)) {
                $this->date_booking->addErrorMessage(str_replace("%s", $this->date_booking->caption(), $this->date_booking->RequiredErrorMessage));
            }
        }
        if ($this->date_payment->Required) {
            if (!$this->date_payment->IsDetailKey && EmptyValue($this->date_payment->FormValue)) {
                $this->date_payment->addErrorMessage(str_replace("%s", $this->date_payment->caption(), $this->date_payment->RequiredErrorMessage));
            }
        }
        if ($this->due_date->Required) {
            if (!$this->due_date->IsDetailKey && EmptyValue($this->due_date->FormValue)) {
                $this->due_date->addErrorMessage(str_replace("%s", $this->due_date->caption(), $this->due_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->due_date->FormValue, $this->due_date->formatPattern())) {
            $this->due_date->addErrorMessage($this->due_date->getErrorMessage(false));
        }
        if ($this->status_expire->Required) {
            if ($this->status_expire->FormValue == "") {
                $this->status_expire->addErrorMessage(str_replace("%s", $this->status_expire->caption(), $this->status_expire->RequiredErrorMessage));
            }
        }
        if ($this->status_expire_reason->Required) {
            if (!$this->status_expire_reason->IsDetailKey && EmptyValue($this->status_expire_reason->FormValue)) {
                $this->status_expire_reason->addErrorMessage(str_replace("%s", $this->status_expire_reason->caption(), $this->status_expire_reason->RequiredErrorMessage));
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
        $detailPage = Container("BuyerAllAssetRentGrid");
        if (in_array("buyer_all_asset_rent", $detailTblVar) && $detailPage->DetailEdit) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("AllBuyerConfigAssetScheduleGrid");
        if (in_array("all_buyer_config_asset_schedule", $detailTblVar) && $detailPage->DetailEdit) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("DocJuzmatch1Grid");
        if (in_array("doc_juzmatch1", $detailTblVar) && $detailPage->DetailEdit) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("DocJuzmatch3Grid");
        if (in_array("doc_juzmatch3", $detailTblVar) && $detailPage->DetailEdit) {
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
            // Begin transaction
            if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
                $conn->beginTransaction();
            }

            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // due_date
            $this->due_date->setDbValueDef($rsnew, UnFormatDateTime($this->due_date->CurrentValue, $this->due_date->formatPattern()), null, $this->due_date->ReadOnly);

            // status_expire
            $this->status_expire->setDbValueDef($rsnew, $this->status_expire->CurrentValue, 0, $this->status_expire->ReadOnly);

            // status_expire_reason
            $this->status_expire_reason->setDbValueDef($rsnew, $this->status_expire_reason->CurrentValue, null, $this->status_expire_reason->ReadOnly);

            // udate
            $this->udate->CurrentValue = CurrentDateTime();
            $this->udate->setDbValueDef($rsnew, $this->udate->CurrentValue, null);

            // uuser
            $this->uuser->CurrentValue = CurrentUserID();
            $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, null);

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

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("BuyerAllAssetRentGrid");
                    if (in_array("buyer_all_asset_rent", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "buyer_all_asset_rent"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("AllBuyerConfigAssetScheduleGrid");
                    if (in_array("all_buyer_config_asset_schedule", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "all_buyer_config_asset_schedule"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("DocJuzmatch1Grid");
                    if (in_array("doc_juzmatch1", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "doc_juzmatch1"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("DocJuzmatch3Grid");
                    if (in_array("doc_juzmatch3", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "doc_juzmatch3"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }

                // Commit/Rollback transaction
                if ($this->getCurrentDetailTable() != "") {
                    if ($editRow) {
                        if ($this->UseTransaction) { // Commit transaction
                            $conn->commit();
                        }
                    } else {
                        if ($this->UseTransaction) { // Rollback transaction
                            $conn->rollback();
                        }
                    }
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
            if (in_array("buyer_all_asset_rent", $detailTblVar)) {
                $detailPageObj = Container("BuyerAllAssetRentGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->asset_id->IsDetailKey = true;
                    $detailPageObj->asset_id->CurrentValue = $this->asset_id->CurrentValue;
                    $detailPageObj->asset_id->setSessionValue($detailPageObj->asset_id->CurrentValue);
                }
            }
            if (in_array("all_buyer_config_asset_schedule", $detailTblVar)) {
                $detailPageObj = Container("AllBuyerConfigAssetScheduleGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->asset_id->IsDetailKey = true;
                    $detailPageObj->asset_id->CurrentValue = $this->asset_id->CurrentValue;
                    $detailPageObj->asset_id->setSessionValue($detailPageObj->asset_id->CurrentValue);
                }
            }
            if (in_array("doc_juzmatch1", $detailTblVar)) {
                $detailPageObj = Container("DocJuzmatch1Grid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->buyer_booking_asset_id->IsDetailKey = true;
                    $detailPageObj->buyer_booking_asset_id->CurrentValue = $this->buyer_booking_asset_id->CurrentValue;
                    $detailPageObj->buyer_booking_asset_id->setSessionValue($detailPageObj->buyer_booking_asset_id->CurrentValue);
                }
            }
            if (in_array("doc_juzmatch3", $detailTblVar)) {
                $detailPageObj = Container("DocJuzmatch3Grid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->buyer_booking_asset_id->IsDetailKey = true;
                    $detailPageObj->buyer_booking_asset_id->CurrentValue = $this->buyer_booking_asset_id->CurrentValue;
                    $detailPageObj->buyer_booking_asset_id->setSessionValue($detailPageObj->buyer_booking_asset_id->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("buyerallbookingassetlist"), "", $this->TableVar, true);
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
                    $lookupFilter = function () {
                        return "`isactive` = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_status_payment":
                    break;
                case "x_status_expire":
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
