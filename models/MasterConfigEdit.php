<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class MasterConfigEdit extends MasterConfig
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'master_config';

    // Page object name
    public $PageObjName = "MasterConfigEdit";

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

        // Table object (master_config)
        if (!isset($GLOBALS["master_config"]) || get_class($GLOBALS["master_config"]) == PROJECT_NAMESPACE . "master_config") {
            $GLOBALS["master_config"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'master_config');
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
                $tbl = Container("master_config");
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
                    if ($pageName == "masterconfigview") {
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
            $key .= @$ar['master_config_id'];
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
            $this->master_config_id->Visible = false;
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
        $this->master_config_id->Visible = false;
        $this->price_booking_invertor->setVisibility();
        $this->price_booking_buyer->setVisibility();
        $this->down_payment_buyer->setVisibility();
        $this->code_asset_seller->setVisibility();
        $this->code_asset_buyer->setVisibility();
        $this->code_asset_juzmatch->setVisibility();
        $this->cdate->Visible = false;
        $this->cuser->Visible = false;
        $this->cip->Visible = false;
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
            if (($keyValue = Get("master_config_id") ?? Key(0) ?? Route(2)) !== null) {
                $this->master_config_id->setQueryStringValue($keyValue);
                $this->master_config_id->setOldValue($this->master_config_id->QueryStringValue);
            } elseif (Post("master_config_id") !== null) {
                $this->master_config_id->setFormValue(Post("master_config_id"));
                $this->master_config_id->setOldValue($this->master_config_id->FormValue);
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
                if (($keyValue = Get("master_config_id") ?? Route("master_config_id")) !== null) {
                    $this->master_config_id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->master_config_id->CurrentValue = null;
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
                        $this->terminate("masterconfiglist"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "masterconfiglist") {
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

        // Check field name 'price_booking_invertor' first before field var 'x_price_booking_invertor'
        $val = $CurrentForm->hasValue("price_booking_invertor") ? $CurrentForm->getValue("price_booking_invertor") : $CurrentForm->getValue("x_price_booking_invertor");
        if (!$this->price_booking_invertor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price_booking_invertor->Visible = false; // Disable update for API request
            } else {
                $this->price_booking_invertor->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'price_booking_buyer' first before field var 'x_price_booking_buyer'
        $val = $CurrentForm->hasValue("price_booking_buyer") ? $CurrentForm->getValue("price_booking_buyer") : $CurrentForm->getValue("x_price_booking_buyer");
        if (!$this->price_booking_buyer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price_booking_buyer->Visible = false; // Disable update for API request
            } else {
                $this->price_booking_buyer->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'down_payment_buyer' first before field var 'x_down_payment_buyer'
        $val = $CurrentForm->hasValue("down_payment_buyer") ? $CurrentForm->getValue("down_payment_buyer") : $CurrentForm->getValue("x_down_payment_buyer");
        if (!$this->down_payment_buyer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->down_payment_buyer->Visible = false; // Disable update for API request
            } else {
                $this->down_payment_buyer->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'code_asset_seller' first before field var 'x_code_asset_seller'
        $val = $CurrentForm->hasValue("code_asset_seller") ? $CurrentForm->getValue("code_asset_seller") : $CurrentForm->getValue("x_code_asset_seller");
        if (!$this->code_asset_seller->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->code_asset_seller->Visible = false; // Disable update for API request
            } else {
                $this->code_asset_seller->setFormValue($val);
            }
        }

        // Check field name 'code_asset_buyer' first before field var 'x_code_asset_buyer'
        $val = $CurrentForm->hasValue("code_asset_buyer") ? $CurrentForm->getValue("code_asset_buyer") : $CurrentForm->getValue("x_code_asset_buyer");
        if (!$this->code_asset_buyer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->code_asset_buyer->Visible = false; // Disable update for API request
            } else {
                $this->code_asset_buyer->setFormValue($val);
            }
        }

        // Check field name 'code_asset_juzmatch' first before field var 'x_code_asset_juzmatch'
        $val = $CurrentForm->hasValue("code_asset_juzmatch") ? $CurrentForm->getValue("code_asset_juzmatch") : $CurrentForm->getValue("x_code_asset_juzmatch");
        if (!$this->code_asset_juzmatch->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->code_asset_juzmatch->Visible = false; // Disable update for API request
            } else {
                $this->code_asset_juzmatch->setFormValue($val);
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

        // Check field name 'master_config_id' first before field var 'x_master_config_id'
        $val = $CurrentForm->hasValue("master_config_id") ? $CurrentForm->getValue("master_config_id") : $CurrentForm->getValue("x_master_config_id");
        if (!$this->master_config_id->IsDetailKey) {
            $this->master_config_id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->master_config_id->CurrentValue = $this->master_config_id->FormValue;
        $this->price_booking_invertor->CurrentValue = $this->price_booking_invertor->FormValue;
        $this->price_booking_buyer->CurrentValue = $this->price_booking_buyer->FormValue;
        $this->down_payment_buyer->CurrentValue = $this->down_payment_buyer->FormValue;
        $this->code_asset_seller->CurrentValue = $this->code_asset_seller->FormValue;
        $this->code_asset_buyer->CurrentValue = $this->code_asset_buyer->FormValue;
        $this->code_asset_juzmatch->CurrentValue = $this->code_asset_juzmatch->FormValue;
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
        $this->master_config_id->setDbValue($row['master_config_id']);
        $this->price_booking_invertor->setDbValue($row['price_booking_invertor']);
        $this->price_booking_buyer->setDbValue($row['price_booking_buyer']);
        $this->down_payment_buyer->setDbValue($row['down_payment_buyer']);
        $this->code_asset_seller->setDbValue($row['code_asset_seller']);
        $this->code_asset_buyer->setDbValue($row['code_asset_buyer']);
        $this->code_asset_juzmatch->setDbValue($row['code_asset_juzmatch']);
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
        $row['master_config_id'] = null;
        $row['price_booking_invertor'] = null;
        $row['price_booking_buyer'] = null;
        $row['down_payment_buyer'] = null;
        $row['code_asset_seller'] = null;
        $row['code_asset_buyer'] = null;
        $row['code_asset_juzmatch'] = null;
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

        // master_config_id
        $this->master_config_id->RowCssClass = "row";

        // price_booking_invertor
        $this->price_booking_invertor->RowCssClass = "row";

        // price_booking_buyer
        $this->price_booking_buyer->RowCssClass = "row";

        // down_payment_buyer
        $this->down_payment_buyer->RowCssClass = "row";

        // code_asset_seller
        $this->code_asset_seller->RowCssClass = "row";

        // code_asset_buyer
        $this->code_asset_buyer->RowCssClass = "row";

        // code_asset_juzmatch
        $this->code_asset_juzmatch->RowCssClass = "row";

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
            // price_booking_invertor
            $this->price_booking_invertor->ViewValue = $this->price_booking_invertor->CurrentValue;
            $this->price_booking_invertor->ViewValue = FormatNumber($this->price_booking_invertor->ViewValue, $this->price_booking_invertor->formatPattern());
            $this->price_booking_invertor->ViewCustomAttributes = "";

            // price_booking_buyer
            $this->price_booking_buyer->ViewValue = $this->price_booking_buyer->CurrentValue;
            $this->price_booking_buyer->ViewValue = FormatNumber($this->price_booking_buyer->ViewValue, $this->price_booking_buyer->formatPattern());
            $this->price_booking_buyer->ViewCustomAttributes = "";

            // down_payment_buyer
            $this->down_payment_buyer->ViewValue = $this->down_payment_buyer->CurrentValue;
            $this->down_payment_buyer->ViewValue = FormatNumber($this->down_payment_buyer->ViewValue, $this->down_payment_buyer->formatPattern());
            $this->down_payment_buyer->ViewCustomAttributes = "";

            // code_asset_seller
            $this->code_asset_seller->ViewValue = $this->code_asset_seller->CurrentValue;
            $this->code_asset_seller->ViewCustomAttributes = "";

            // code_asset_buyer
            $this->code_asset_buyer->ViewValue = $this->code_asset_buyer->CurrentValue;
            $this->code_asset_buyer->ViewCustomAttributes = "";

            // code_asset_juzmatch
            $this->code_asset_juzmatch->ViewValue = $this->code_asset_juzmatch->CurrentValue;
            $this->code_asset_juzmatch->ViewCustomAttributes = "";

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

            // price_booking_invertor
            $this->price_booking_invertor->LinkCustomAttributes = "";
            $this->price_booking_invertor->HrefValue = "";

            // price_booking_buyer
            $this->price_booking_buyer->LinkCustomAttributes = "";
            $this->price_booking_buyer->HrefValue = "";

            // down_payment_buyer
            $this->down_payment_buyer->LinkCustomAttributes = "";
            $this->down_payment_buyer->HrefValue = "";

            // code_asset_seller
            $this->code_asset_seller->LinkCustomAttributes = "";
            $this->code_asset_seller->HrefValue = "";

            // code_asset_buyer
            $this->code_asset_buyer->LinkCustomAttributes = "";
            $this->code_asset_buyer->HrefValue = "";

            // code_asset_juzmatch
            $this->code_asset_juzmatch->LinkCustomAttributes = "";
            $this->code_asset_juzmatch->HrefValue = "";

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
            // price_booking_invertor
            $this->price_booking_invertor->setupEditAttributes();
            $this->price_booking_invertor->EditCustomAttributes = "";
            $this->price_booking_invertor->EditValue = HtmlEncode($this->price_booking_invertor->CurrentValue);
            $this->price_booking_invertor->PlaceHolder = RemoveHtml($this->price_booking_invertor->caption());
            if (strval($this->price_booking_invertor->EditValue) != "" && is_numeric($this->price_booking_invertor->EditValue)) {
                $this->price_booking_invertor->EditValue = FormatNumber($this->price_booking_invertor->EditValue, null);
            }

            // price_booking_buyer
            $this->price_booking_buyer->setupEditAttributes();
            $this->price_booking_buyer->EditCustomAttributes = "";
            $this->price_booking_buyer->EditValue = HtmlEncode($this->price_booking_buyer->CurrentValue);
            $this->price_booking_buyer->PlaceHolder = RemoveHtml($this->price_booking_buyer->caption());
            if (strval($this->price_booking_buyer->EditValue) != "" && is_numeric($this->price_booking_buyer->EditValue)) {
                $this->price_booking_buyer->EditValue = FormatNumber($this->price_booking_buyer->EditValue, null);
            }

            // down_payment_buyer
            $this->down_payment_buyer->setupEditAttributes();
            $this->down_payment_buyer->EditCustomAttributes = "";
            $this->down_payment_buyer->EditValue = HtmlEncode($this->down_payment_buyer->CurrentValue);
            $this->down_payment_buyer->PlaceHolder = RemoveHtml($this->down_payment_buyer->caption());
            if (strval($this->down_payment_buyer->EditValue) != "" && is_numeric($this->down_payment_buyer->EditValue)) {
                $this->down_payment_buyer->EditValue = FormatNumber($this->down_payment_buyer->EditValue, null);
            }

            // code_asset_seller
            $this->code_asset_seller->setupEditAttributes();
            $this->code_asset_seller->EditCustomAttributes = "";
            if (!$this->code_asset_seller->Raw) {
                $this->code_asset_seller->CurrentValue = HtmlDecode($this->code_asset_seller->CurrentValue);
            }
            $this->code_asset_seller->EditValue = HtmlEncode($this->code_asset_seller->CurrentValue);
            $this->code_asset_seller->PlaceHolder = RemoveHtml($this->code_asset_seller->caption());

            // code_asset_buyer
            $this->code_asset_buyer->setupEditAttributes();
            $this->code_asset_buyer->EditCustomAttributes = "";
            if (!$this->code_asset_buyer->Raw) {
                $this->code_asset_buyer->CurrentValue = HtmlDecode($this->code_asset_buyer->CurrentValue);
            }
            $this->code_asset_buyer->EditValue = HtmlEncode($this->code_asset_buyer->CurrentValue);
            $this->code_asset_buyer->PlaceHolder = RemoveHtml($this->code_asset_buyer->caption());

            // code_asset_juzmatch
            $this->code_asset_juzmatch->setupEditAttributes();
            $this->code_asset_juzmatch->EditCustomAttributes = "";
            if (!$this->code_asset_juzmatch->Raw) {
                $this->code_asset_juzmatch->CurrentValue = HtmlDecode($this->code_asset_juzmatch->CurrentValue);
            }
            $this->code_asset_juzmatch->EditValue = HtmlEncode($this->code_asset_juzmatch->CurrentValue);
            $this->code_asset_juzmatch->PlaceHolder = RemoveHtml($this->code_asset_juzmatch->caption());

            // udate

            // uuser

            // uip

            // Edit refer script

            // price_booking_invertor
            $this->price_booking_invertor->LinkCustomAttributes = "";
            $this->price_booking_invertor->HrefValue = "";

            // price_booking_buyer
            $this->price_booking_buyer->LinkCustomAttributes = "";
            $this->price_booking_buyer->HrefValue = "";

            // down_payment_buyer
            $this->down_payment_buyer->LinkCustomAttributes = "";
            $this->down_payment_buyer->HrefValue = "";

            // code_asset_seller
            $this->code_asset_seller->LinkCustomAttributes = "";
            $this->code_asset_seller->HrefValue = "";

            // code_asset_buyer
            $this->code_asset_buyer->LinkCustomAttributes = "";
            $this->code_asset_buyer->HrefValue = "";

            // code_asset_juzmatch
            $this->code_asset_juzmatch->LinkCustomAttributes = "";
            $this->code_asset_juzmatch->HrefValue = "";

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
        if ($this->price_booking_invertor->Required) {
            if (!$this->price_booking_invertor->IsDetailKey && EmptyValue($this->price_booking_invertor->FormValue)) {
                $this->price_booking_invertor->addErrorMessage(str_replace("%s", $this->price_booking_invertor->caption(), $this->price_booking_invertor->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->price_booking_invertor->FormValue)) {
            $this->price_booking_invertor->addErrorMessage($this->price_booking_invertor->getErrorMessage(false));
        }
        if ($this->price_booking_buyer->Required) {
            if (!$this->price_booking_buyer->IsDetailKey && EmptyValue($this->price_booking_buyer->FormValue)) {
                $this->price_booking_buyer->addErrorMessage(str_replace("%s", $this->price_booking_buyer->caption(), $this->price_booking_buyer->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->price_booking_buyer->FormValue)) {
            $this->price_booking_buyer->addErrorMessage($this->price_booking_buyer->getErrorMessage(false));
        }
        if ($this->down_payment_buyer->Required) {
            if (!$this->down_payment_buyer->IsDetailKey && EmptyValue($this->down_payment_buyer->FormValue)) {
                $this->down_payment_buyer->addErrorMessage(str_replace("%s", $this->down_payment_buyer->caption(), $this->down_payment_buyer->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->down_payment_buyer->FormValue)) {
            $this->down_payment_buyer->addErrorMessage($this->down_payment_buyer->getErrorMessage(false));
        }
        if ($this->code_asset_seller->Required) {
            if (!$this->code_asset_seller->IsDetailKey && EmptyValue($this->code_asset_seller->FormValue)) {
                $this->code_asset_seller->addErrorMessage(str_replace("%s", $this->code_asset_seller->caption(), $this->code_asset_seller->RequiredErrorMessage));
            }
        }
        if ($this->code_asset_buyer->Required) {
            if (!$this->code_asset_buyer->IsDetailKey && EmptyValue($this->code_asset_buyer->FormValue)) {
                $this->code_asset_buyer->addErrorMessage(str_replace("%s", $this->code_asset_buyer->caption(), $this->code_asset_buyer->RequiredErrorMessage));
            }
        }
        if ($this->code_asset_juzmatch->Required) {
            if (!$this->code_asset_juzmatch->IsDetailKey && EmptyValue($this->code_asset_juzmatch->FormValue)) {
                $this->code_asset_juzmatch->addErrorMessage(str_replace("%s", $this->code_asset_juzmatch->caption(), $this->code_asset_juzmatch->RequiredErrorMessage));
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

            // price_booking_invertor
            $this->price_booking_invertor->setDbValueDef($rsnew, $this->price_booking_invertor->CurrentValue, 0, $this->price_booking_invertor->ReadOnly);

            // price_booking_buyer
            $this->price_booking_buyer->setDbValueDef($rsnew, $this->price_booking_buyer->CurrentValue, null, $this->price_booking_buyer->ReadOnly);

            // down_payment_buyer
            $this->down_payment_buyer->setDbValueDef($rsnew, $this->down_payment_buyer->CurrentValue, null, $this->down_payment_buyer->ReadOnly);

            // code_asset_seller
            $this->code_asset_seller->setDbValueDef($rsnew, $this->code_asset_seller->CurrentValue, "", $this->code_asset_seller->ReadOnly);

            // code_asset_buyer
            $this->code_asset_buyer->setDbValueDef($rsnew, $this->code_asset_buyer->CurrentValue, "", $this->code_asset_buyer->ReadOnly);

            // code_asset_juzmatch
            $this->code_asset_juzmatch->setDbValueDef($rsnew, $this->code_asset_juzmatch->CurrentValue, "", $this->code_asset_juzmatch->ReadOnly);

            // udate
            $this->udate->CurrentValue = CurrentDateTime();
            $this->udate->setDbValueDef($rsnew, $this->udate->CurrentValue, CurrentDate());

            // uuser
            $this->uuser->CurrentValue = CurrentUserID();
            $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, "");

            // uip
            $this->uip->CurrentValue = CurrentUserIP();
            $this->uip->setDbValueDef($rsnew, $this->uip->CurrentValue, "");

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("masterconfiglist"), "", $this->TableVar, true);
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
