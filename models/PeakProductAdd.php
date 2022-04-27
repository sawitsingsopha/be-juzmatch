<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class PeakProductAdd extends PeakProduct
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'peak_product';

    // Page object name
    public $PageObjName = "PeakProductAdd";

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

        // Table object (peak_product)
        if (!isset($GLOBALS["peak_product"]) || get_class($GLOBALS["peak_product"]) == PROJECT_NAMESPACE . "peak_product") {
            $GLOBALS["peak_product"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'peak_product');
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
                $tbl = Container("peak_product");
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
                    if ($pageName == "peakproductview") {
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
            $key .= @$ar['id'];
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
            $this->id->Visible = false;
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
        $this->id->Visible = false;
        $this->productid->setVisibility();
        $this->name->setVisibility();
        $this->code->setVisibility();
        $this->type->setVisibility();
        $this->purchaseValue->setVisibility();
        $this->purchaseVatType->setVisibility();
        $this->purchaseAccount->setVisibility();
        $this->sellValue->setVisibility();
        $this->sellVatType->setVisibility();
        $this->sellAccount->setVisibility();
        $this->description->setVisibility();
        $this->carryingBalanceValue->setVisibility();
        $this->carryingBalanceAmount->setVisibility();
        $this->remainingBalanceAmount->setVisibility();
        $this->create_date->setVisibility();
        $this->update_date->setVisibility();
        $this->post_message->setVisibility();
        $this->post_try_cnt->setVisibility();
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
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
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
                    $this->terminate("peakproductlist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "peakproductlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "peakproductview") {
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
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->productid->CurrentValue = null;
        $this->productid->OldValue = $this->productid->CurrentValue;
        $this->name->CurrentValue = null;
        $this->name->OldValue = $this->name->CurrentValue;
        $this->code->CurrentValue = null;
        $this->code->OldValue = $this->code->CurrentValue;
        $this->type->CurrentValue = null;
        $this->type->OldValue = $this->type->CurrentValue;
        $this->purchaseValue->CurrentValue = null;
        $this->purchaseValue->OldValue = $this->purchaseValue->CurrentValue;
        $this->purchaseVatType->CurrentValue = null;
        $this->purchaseVatType->OldValue = $this->purchaseVatType->CurrentValue;
        $this->purchaseAccount->CurrentValue = null;
        $this->purchaseAccount->OldValue = $this->purchaseAccount->CurrentValue;
        $this->sellValue->CurrentValue = null;
        $this->sellValue->OldValue = $this->sellValue->CurrentValue;
        $this->sellVatType->CurrentValue = null;
        $this->sellVatType->OldValue = $this->sellVatType->CurrentValue;
        $this->sellAccount->CurrentValue = null;
        $this->sellAccount->OldValue = $this->sellAccount->CurrentValue;
        $this->description->CurrentValue = null;
        $this->description->OldValue = $this->description->CurrentValue;
        $this->carryingBalanceValue->CurrentValue = null;
        $this->carryingBalanceValue->OldValue = $this->carryingBalanceValue->CurrentValue;
        $this->carryingBalanceAmount->CurrentValue = null;
        $this->carryingBalanceAmount->OldValue = $this->carryingBalanceAmount->CurrentValue;
        $this->remainingBalanceAmount->CurrentValue = null;
        $this->remainingBalanceAmount->OldValue = $this->remainingBalanceAmount->CurrentValue;
        $this->create_date->CurrentValue = null;
        $this->create_date->OldValue = $this->create_date->CurrentValue;
        $this->update_date->CurrentValue = null;
        $this->update_date->OldValue = $this->update_date->CurrentValue;
        $this->post_message->CurrentValue = null;
        $this->post_message->OldValue = $this->post_message->CurrentValue;
        $this->post_try_cnt->CurrentValue = null;
        $this->post_try_cnt->OldValue = $this->post_try_cnt->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'productid' first before field var 'x_productid'
        $val = $CurrentForm->hasValue("productid") ? $CurrentForm->getValue("productid") : $CurrentForm->getValue("x_productid");
        if (!$this->productid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->productid->Visible = false; // Disable update for API request
            } else {
                $this->productid->setFormValue($val);
            }
        }

        // Check field name 'name' first before field var 'x_name'
        $val = $CurrentForm->hasValue("name") ? $CurrentForm->getValue("name") : $CurrentForm->getValue("x_name");
        if (!$this->name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->name->Visible = false; // Disable update for API request
            } else {
                $this->name->setFormValue($val);
            }
        }

        // Check field name 'code' first before field var 'x_code'
        $val = $CurrentForm->hasValue("code") ? $CurrentForm->getValue("code") : $CurrentForm->getValue("x_code");
        if (!$this->code->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->code->Visible = false; // Disable update for API request
            } else {
                $this->code->setFormValue($val);
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

        // Check field name 'purchaseValue' first before field var 'x_purchaseValue'
        $val = $CurrentForm->hasValue("purchaseValue") ? $CurrentForm->getValue("purchaseValue") : $CurrentForm->getValue("x_purchaseValue");
        if (!$this->purchaseValue->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->purchaseValue->Visible = false; // Disable update for API request
            } else {
                $this->purchaseValue->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'purchaseVatType' first before field var 'x_purchaseVatType'
        $val = $CurrentForm->hasValue("purchaseVatType") ? $CurrentForm->getValue("purchaseVatType") : $CurrentForm->getValue("x_purchaseVatType");
        if (!$this->purchaseVatType->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->purchaseVatType->Visible = false; // Disable update for API request
            } else {
                $this->purchaseVatType->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'purchaseAccount' first before field var 'x_purchaseAccount'
        $val = $CurrentForm->hasValue("purchaseAccount") ? $CurrentForm->getValue("purchaseAccount") : $CurrentForm->getValue("x_purchaseAccount");
        if (!$this->purchaseAccount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->purchaseAccount->Visible = false; // Disable update for API request
            } else {
                $this->purchaseAccount->setFormValue($val);
            }
        }

        // Check field name 'sellValue' first before field var 'x_sellValue'
        $val = $CurrentForm->hasValue("sellValue") ? $CurrentForm->getValue("sellValue") : $CurrentForm->getValue("x_sellValue");
        if (!$this->sellValue->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sellValue->Visible = false; // Disable update for API request
            } else {
                $this->sellValue->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'sellVatType' first before field var 'x_sellVatType'
        $val = $CurrentForm->hasValue("sellVatType") ? $CurrentForm->getValue("sellVatType") : $CurrentForm->getValue("x_sellVatType");
        if (!$this->sellVatType->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sellVatType->Visible = false; // Disable update for API request
            } else {
                $this->sellVatType->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'sellAccount' first before field var 'x_sellAccount'
        $val = $CurrentForm->hasValue("sellAccount") ? $CurrentForm->getValue("sellAccount") : $CurrentForm->getValue("x_sellAccount");
        if (!$this->sellAccount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sellAccount->Visible = false; // Disable update for API request
            } else {
                $this->sellAccount->setFormValue($val);
            }
        }

        // Check field name 'description' first before field var 'x_description'
        $val = $CurrentForm->hasValue("description") ? $CurrentForm->getValue("description") : $CurrentForm->getValue("x_description");
        if (!$this->description->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->description->Visible = false; // Disable update for API request
            } else {
                $this->description->setFormValue($val);
            }
        }

        // Check field name 'carryingBalanceValue' first before field var 'x_carryingBalanceValue'
        $val = $CurrentForm->hasValue("carryingBalanceValue") ? $CurrentForm->getValue("carryingBalanceValue") : $CurrentForm->getValue("x_carryingBalanceValue");
        if (!$this->carryingBalanceValue->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->carryingBalanceValue->Visible = false; // Disable update for API request
            } else {
                $this->carryingBalanceValue->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'carryingBalanceAmount' first before field var 'x_carryingBalanceAmount'
        $val = $CurrentForm->hasValue("carryingBalanceAmount") ? $CurrentForm->getValue("carryingBalanceAmount") : $CurrentForm->getValue("x_carryingBalanceAmount");
        if (!$this->carryingBalanceAmount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->carryingBalanceAmount->Visible = false; // Disable update for API request
            } else {
                $this->carryingBalanceAmount->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'remainingBalanceAmount' first before field var 'x_remainingBalanceAmount'
        $val = $CurrentForm->hasValue("remainingBalanceAmount") ? $CurrentForm->getValue("remainingBalanceAmount") : $CurrentForm->getValue("x_remainingBalanceAmount");
        if (!$this->remainingBalanceAmount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->remainingBalanceAmount->Visible = false; // Disable update for API request
            } else {
                $this->remainingBalanceAmount->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'create_date' first before field var 'x_create_date'
        $val = $CurrentForm->hasValue("create_date") ? $CurrentForm->getValue("create_date") : $CurrentForm->getValue("x_create_date");
        if (!$this->create_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->create_date->Visible = false; // Disable update for API request
            } else {
                $this->create_date->setFormValue($val, true, $validate);
            }
            $this->create_date->CurrentValue = UnFormatDateTime($this->create_date->CurrentValue, $this->create_date->formatPattern());
        }

        // Check field name 'update_date' first before field var 'x_update_date'
        $val = $CurrentForm->hasValue("update_date") ? $CurrentForm->getValue("update_date") : $CurrentForm->getValue("x_update_date");
        if (!$this->update_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->update_date->Visible = false; // Disable update for API request
            } else {
                $this->update_date->setFormValue($val, true, $validate);
            }
            $this->update_date->CurrentValue = UnFormatDateTime($this->update_date->CurrentValue, $this->update_date->formatPattern());
        }

        // Check field name 'post_message' first before field var 'x_post_message'
        $val = $CurrentForm->hasValue("post_message") ? $CurrentForm->getValue("post_message") : $CurrentForm->getValue("x_post_message");
        if (!$this->post_message->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->post_message->Visible = false; // Disable update for API request
            } else {
                $this->post_message->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'post_try_cnt' first before field var 'x_post_try_cnt'
        $val = $CurrentForm->hasValue("post_try_cnt") ? $CurrentForm->getValue("post_try_cnt") : $CurrentForm->getValue("x_post_try_cnt");
        if (!$this->post_try_cnt->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->post_try_cnt->Visible = false; // Disable update for API request
            } else {
                $this->post_try_cnt->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->productid->CurrentValue = $this->productid->FormValue;
        $this->name->CurrentValue = $this->name->FormValue;
        $this->code->CurrentValue = $this->code->FormValue;
        $this->type->CurrentValue = $this->type->FormValue;
        $this->purchaseValue->CurrentValue = $this->purchaseValue->FormValue;
        $this->purchaseVatType->CurrentValue = $this->purchaseVatType->FormValue;
        $this->purchaseAccount->CurrentValue = $this->purchaseAccount->FormValue;
        $this->sellValue->CurrentValue = $this->sellValue->FormValue;
        $this->sellVatType->CurrentValue = $this->sellVatType->FormValue;
        $this->sellAccount->CurrentValue = $this->sellAccount->FormValue;
        $this->description->CurrentValue = $this->description->FormValue;
        $this->carryingBalanceValue->CurrentValue = $this->carryingBalanceValue->FormValue;
        $this->carryingBalanceAmount->CurrentValue = $this->carryingBalanceAmount->FormValue;
        $this->remainingBalanceAmount->CurrentValue = $this->remainingBalanceAmount->FormValue;
        $this->create_date->CurrentValue = $this->create_date->FormValue;
        $this->create_date->CurrentValue = UnFormatDateTime($this->create_date->CurrentValue, $this->create_date->formatPattern());
        $this->update_date->CurrentValue = $this->update_date->FormValue;
        $this->update_date->CurrentValue = UnFormatDateTime($this->update_date->CurrentValue, $this->update_date->formatPattern());
        $this->post_message->CurrentValue = $this->post_message->FormValue;
        $this->post_try_cnt->CurrentValue = $this->post_try_cnt->FormValue;
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
        $this->id->setDbValue($row['id']);
        $this->productid->setDbValue($row['productid']);
        $this->name->setDbValue($row['name']);
        $this->code->setDbValue($row['code']);
        $this->type->setDbValue($row['type']);
        $this->purchaseValue->setDbValue($row['purchaseValue']);
        $this->purchaseVatType->setDbValue($row['purchaseVatType']);
        $this->purchaseAccount->setDbValue($row['purchaseAccount']);
        $this->sellValue->setDbValue($row['sellValue']);
        $this->sellVatType->setDbValue($row['sellVatType']);
        $this->sellAccount->setDbValue($row['sellAccount']);
        $this->description->setDbValue($row['description']);
        $this->carryingBalanceValue->setDbValue($row['carryingBalanceValue']);
        $this->carryingBalanceAmount->setDbValue($row['carryingBalanceAmount']);
        $this->remainingBalanceAmount->setDbValue($row['remainingBalanceAmount']);
        $this->create_date->setDbValue($row['create_date']);
        $this->update_date->setDbValue($row['update_date']);
        $this->post_message->setDbValue($row['post_message']);
        $this->post_try_cnt->setDbValue($row['post_try_cnt']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['productid'] = $this->productid->CurrentValue;
        $row['name'] = $this->name->CurrentValue;
        $row['code'] = $this->code->CurrentValue;
        $row['type'] = $this->type->CurrentValue;
        $row['purchaseValue'] = $this->purchaseValue->CurrentValue;
        $row['purchaseVatType'] = $this->purchaseVatType->CurrentValue;
        $row['purchaseAccount'] = $this->purchaseAccount->CurrentValue;
        $row['sellValue'] = $this->sellValue->CurrentValue;
        $row['sellVatType'] = $this->sellVatType->CurrentValue;
        $row['sellAccount'] = $this->sellAccount->CurrentValue;
        $row['description'] = $this->description->CurrentValue;
        $row['carryingBalanceValue'] = $this->carryingBalanceValue->CurrentValue;
        $row['carryingBalanceAmount'] = $this->carryingBalanceAmount->CurrentValue;
        $row['remainingBalanceAmount'] = $this->remainingBalanceAmount->CurrentValue;
        $row['create_date'] = $this->create_date->CurrentValue;
        $row['update_date'] = $this->update_date->CurrentValue;
        $row['post_message'] = $this->post_message->CurrentValue;
        $row['post_try_cnt'] = $this->post_try_cnt->CurrentValue;
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

        // id
        $this->id->RowCssClass = "row";

        // productid
        $this->productid->RowCssClass = "row";

        // name
        $this->name->RowCssClass = "row";

        // code
        $this->code->RowCssClass = "row";

        // type
        $this->type->RowCssClass = "row";

        // purchaseValue
        $this->purchaseValue->RowCssClass = "row";

        // purchaseVatType
        $this->purchaseVatType->RowCssClass = "row";

        // purchaseAccount
        $this->purchaseAccount->RowCssClass = "row";

        // sellValue
        $this->sellValue->RowCssClass = "row";

        // sellVatType
        $this->sellVatType->RowCssClass = "row";

        // sellAccount
        $this->sellAccount->RowCssClass = "row";

        // description
        $this->description->RowCssClass = "row";

        // carryingBalanceValue
        $this->carryingBalanceValue->RowCssClass = "row";

        // carryingBalanceAmount
        $this->carryingBalanceAmount->RowCssClass = "row";

        // remainingBalanceAmount
        $this->remainingBalanceAmount->RowCssClass = "row";

        // create_date
        $this->create_date->RowCssClass = "row";

        // update_date
        $this->update_date->RowCssClass = "row";

        // post_message
        $this->post_message->RowCssClass = "row";

        // post_try_cnt
        $this->post_try_cnt->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // productid
            $this->productid->ViewValue = $this->productid->CurrentValue;
            $this->productid->ViewCustomAttributes = "";

            // name
            $this->name->ViewValue = $this->name->CurrentValue;
            $this->name->ViewCustomAttributes = "";

            // code
            $this->code->ViewValue = $this->code->CurrentValue;
            $this->code->ViewCustomAttributes = "";

            // type
            $this->type->ViewValue = $this->type->CurrentValue;
            $this->type->ViewValue = FormatNumber($this->type->ViewValue, $this->type->formatPattern());
            $this->type->ViewCustomAttributes = "";

            // purchaseValue
            $this->purchaseValue->ViewValue = $this->purchaseValue->CurrentValue;
            $this->purchaseValue->ViewValue = FormatNumber($this->purchaseValue->ViewValue, $this->purchaseValue->formatPattern());
            $this->purchaseValue->ViewCustomAttributes = "";

            // purchaseVatType
            $this->purchaseVatType->ViewValue = $this->purchaseVatType->CurrentValue;
            $this->purchaseVatType->ViewValue = FormatNumber($this->purchaseVatType->ViewValue, $this->purchaseVatType->formatPattern());
            $this->purchaseVatType->ViewCustomAttributes = "";

            // purchaseAccount
            $this->purchaseAccount->ViewValue = $this->purchaseAccount->CurrentValue;
            $this->purchaseAccount->ViewCustomAttributes = "";

            // sellValue
            $this->sellValue->ViewValue = $this->sellValue->CurrentValue;
            $this->sellValue->ViewValue = FormatNumber($this->sellValue->ViewValue, $this->sellValue->formatPattern());
            $this->sellValue->ViewCustomAttributes = "";

            // sellVatType
            $this->sellVatType->ViewValue = $this->sellVatType->CurrentValue;
            $this->sellVatType->ViewValue = FormatNumber($this->sellVatType->ViewValue, $this->sellVatType->formatPattern());
            $this->sellVatType->ViewCustomAttributes = "";

            // sellAccount
            $this->sellAccount->ViewValue = $this->sellAccount->CurrentValue;
            $this->sellAccount->ViewCustomAttributes = "";

            // description
            $this->description->ViewValue = $this->description->CurrentValue;
            $this->description->ViewCustomAttributes = "";

            // carryingBalanceValue
            $this->carryingBalanceValue->ViewValue = $this->carryingBalanceValue->CurrentValue;
            $this->carryingBalanceValue->ViewValue = FormatNumber($this->carryingBalanceValue->ViewValue, $this->carryingBalanceValue->formatPattern());
            $this->carryingBalanceValue->ViewCustomAttributes = "";

            // carryingBalanceAmount
            $this->carryingBalanceAmount->ViewValue = $this->carryingBalanceAmount->CurrentValue;
            $this->carryingBalanceAmount->ViewValue = FormatNumber($this->carryingBalanceAmount->ViewValue, $this->carryingBalanceAmount->formatPattern());
            $this->carryingBalanceAmount->ViewCustomAttributes = "";

            // remainingBalanceAmount
            $this->remainingBalanceAmount->ViewValue = $this->remainingBalanceAmount->CurrentValue;
            $this->remainingBalanceAmount->ViewValue = FormatNumber($this->remainingBalanceAmount->ViewValue, $this->remainingBalanceAmount->formatPattern());
            $this->remainingBalanceAmount->ViewCustomAttributes = "";

            // create_date
            $this->create_date->ViewValue = $this->create_date->CurrentValue;
            $this->create_date->ViewValue = FormatDateTime($this->create_date->ViewValue, $this->create_date->formatPattern());
            $this->create_date->ViewCustomAttributes = "";

            // update_date
            $this->update_date->ViewValue = $this->update_date->CurrentValue;
            $this->update_date->ViewValue = FormatDateTime($this->update_date->ViewValue, $this->update_date->formatPattern());
            $this->update_date->ViewCustomAttributes = "";

            // post_message
            $this->post_message->ViewValue = $this->post_message->CurrentValue;
            $this->post_message->ViewValue = FormatNumber($this->post_message->ViewValue, $this->post_message->formatPattern());
            $this->post_message->ViewCustomAttributes = "";

            // post_try_cnt
            $this->post_try_cnt->ViewValue = $this->post_try_cnt->CurrentValue;
            $this->post_try_cnt->ViewValue = FormatNumber($this->post_try_cnt->ViewValue, $this->post_try_cnt->formatPattern());
            $this->post_try_cnt->ViewCustomAttributes = "";

            // productid
            $this->productid->LinkCustomAttributes = "";
            $this->productid->HrefValue = "";

            // name
            $this->name->LinkCustomAttributes = "";
            $this->name->HrefValue = "";

            // code
            $this->code->LinkCustomAttributes = "";
            $this->code->HrefValue = "";

            // type
            $this->type->LinkCustomAttributes = "";
            $this->type->HrefValue = "";

            // purchaseValue
            $this->purchaseValue->LinkCustomAttributes = "";
            $this->purchaseValue->HrefValue = "";

            // purchaseVatType
            $this->purchaseVatType->LinkCustomAttributes = "";
            $this->purchaseVatType->HrefValue = "";

            // purchaseAccount
            $this->purchaseAccount->LinkCustomAttributes = "";
            $this->purchaseAccount->HrefValue = "";

            // sellValue
            $this->sellValue->LinkCustomAttributes = "";
            $this->sellValue->HrefValue = "";

            // sellVatType
            $this->sellVatType->LinkCustomAttributes = "";
            $this->sellVatType->HrefValue = "";

            // sellAccount
            $this->sellAccount->LinkCustomAttributes = "";
            $this->sellAccount->HrefValue = "";

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";

            // carryingBalanceValue
            $this->carryingBalanceValue->LinkCustomAttributes = "";
            $this->carryingBalanceValue->HrefValue = "";

            // carryingBalanceAmount
            $this->carryingBalanceAmount->LinkCustomAttributes = "";
            $this->carryingBalanceAmount->HrefValue = "";

            // remainingBalanceAmount
            $this->remainingBalanceAmount->LinkCustomAttributes = "";
            $this->remainingBalanceAmount->HrefValue = "";

            // create_date
            $this->create_date->LinkCustomAttributes = "";
            $this->create_date->HrefValue = "";

            // update_date
            $this->update_date->LinkCustomAttributes = "";
            $this->update_date->HrefValue = "";

            // post_message
            $this->post_message->LinkCustomAttributes = "";
            $this->post_message->HrefValue = "";

            // post_try_cnt
            $this->post_try_cnt->LinkCustomAttributes = "";
            $this->post_try_cnt->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // productid
            $this->productid->setupEditAttributes();
            $this->productid->EditCustomAttributes = "";
            if (!$this->productid->Raw) {
                $this->productid->CurrentValue = HtmlDecode($this->productid->CurrentValue);
            }
            $this->productid->EditValue = HtmlEncode($this->productid->CurrentValue);
            $this->productid->PlaceHolder = RemoveHtml($this->productid->caption());

            // name
            $this->name->setupEditAttributes();
            $this->name->EditCustomAttributes = "";
            if (!$this->name->Raw) {
                $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
            }
            $this->name->EditValue = HtmlEncode($this->name->CurrentValue);
            $this->name->PlaceHolder = RemoveHtml($this->name->caption());

            // code
            $this->code->setupEditAttributes();
            $this->code->EditCustomAttributes = "";
            if (!$this->code->Raw) {
                $this->code->CurrentValue = HtmlDecode($this->code->CurrentValue);
            }
            $this->code->EditValue = HtmlEncode($this->code->CurrentValue);
            $this->code->PlaceHolder = RemoveHtml($this->code->caption());

            // type
            $this->type->setupEditAttributes();
            $this->type->EditCustomAttributes = "";
            $this->type->EditValue = HtmlEncode($this->type->CurrentValue);
            $this->type->PlaceHolder = RemoveHtml($this->type->caption());
            if (strval($this->type->EditValue) != "" && is_numeric($this->type->EditValue)) {
                $this->type->EditValue = FormatNumber($this->type->EditValue, null);
            }

            // purchaseValue
            $this->purchaseValue->setupEditAttributes();
            $this->purchaseValue->EditCustomAttributes = "";
            $this->purchaseValue->EditValue = HtmlEncode($this->purchaseValue->CurrentValue);
            $this->purchaseValue->PlaceHolder = RemoveHtml($this->purchaseValue->caption());
            if (strval($this->purchaseValue->EditValue) != "" && is_numeric($this->purchaseValue->EditValue)) {
                $this->purchaseValue->EditValue = FormatNumber($this->purchaseValue->EditValue, null);
            }

            // purchaseVatType
            $this->purchaseVatType->setupEditAttributes();
            $this->purchaseVatType->EditCustomAttributes = "";
            $this->purchaseVatType->EditValue = HtmlEncode($this->purchaseVatType->CurrentValue);
            $this->purchaseVatType->PlaceHolder = RemoveHtml($this->purchaseVatType->caption());
            if (strval($this->purchaseVatType->EditValue) != "" && is_numeric($this->purchaseVatType->EditValue)) {
                $this->purchaseVatType->EditValue = FormatNumber($this->purchaseVatType->EditValue, null);
            }

            // purchaseAccount
            $this->purchaseAccount->setupEditAttributes();
            $this->purchaseAccount->EditCustomAttributes = "";
            if (!$this->purchaseAccount->Raw) {
                $this->purchaseAccount->CurrentValue = HtmlDecode($this->purchaseAccount->CurrentValue);
            }
            $this->purchaseAccount->EditValue = HtmlEncode($this->purchaseAccount->CurrentValue);
            $this->purchaseAccount->PlaceHolder = RemoveHtml($this->purchaseAccount->caption());

            // sellValue
            $this->sellValue->setupEditAttributes();
            $this->sellValue->EditCustomAttributes = "";
            $this->sellValue->EditValue = HtmlEncode($this->sellValue->CurrentValue);
            $this->sellValue->PlaceHolder = RemoveHtml($this->sellValue->caption());
            if (strval($this->sellValue->EditValue) != "" && is_numeric($this->sellValue->EditValue)) {
                $this->sellValue->EditValue = FormatNumber($this->sellValue->EditValue, null);
            }

            // sellVatType
            $this->sellVatType->setupEditAttributes();
            $this->sellVatType->EditCustomAttributes = "";
            $this->sellVatType->EditValue = HtmlEncode($this->sellVatType->CurrentValue);
            $this->sellVatType->PlaceHolder = RemoveHtml($this->sellVatType->caption());
            if (strval($this->sellVatType->EditValue) != "" && is_numeric($this->sellVatType->EditValue)) {
                $this->sellVatType->EditValue = FormatNumber($this->sellVatType->EditValue, null);
            }

            // sellAccount
            $this->sellAccount->setupEditAttributes();
            $this->sellAccount->EditCustomAttributes = "";
            if (!$this->sellAccount->Raw) {
                $this->sellAccount->CurrentValue = HtmlDecode($this->sellAccount->CurrentValue);
            }
            $this->sellAccount->EditValue = HtmlEncode($this->sellAccount->CurrentValue);
            $this->sellAccount->PlaceHolder = RemoveHtml($this->sellAccount->caption());

            // description
            $this->description->setupEditAttributes();
            $this->description->EditCustomAttributes = "";
            $this->description->EditValue = HtmlEncode($this->description->CurrentValue);
            $this->description->PlaceHolder = RemoveHtml($this->description->caption());

            // carryingBalanceValue
            $this->carryingBalanceValue->setupEditAttributes();
            $this->carryingBalanceValue->EditCustomAttributes = "";
            $this->carryingBalanceValue->EditValue = HtmlEncode($this->carryingBalanceValue->CurrentValue);
            $this->carryingBalanceValue->PlaceHolder = RemoveHtml($this->carryingBalanceValue->caption());
            if (strval($this->carryingBalanceValue->EditValue) != "" && is_numeric($this->carryingBalanceValue->EditValue)) {
                $this->carryingBalanceValue->EditValue = FormatNumber($this->carryingBalanceValue->EditValue, null);
            }

            // carryingBalanceAmount
            $this->carryingBalanceAmount->setupEditAttributes();
            $this->carryingBalanceAmount->EditCustomAttributes = "";
            $this->carryingBalanceAmount->EditValue = HtmlEncode($this->carryingBalanceAmount->CurrentValue);
            $this->carryingBalanceAmount->PlaceHolder = RemoveHtml($this->carryingBalanceAmount->caption());
            if (strval($this->carryingBalanceAmount->EditValue) != "" && is_numeric($this->carryingBalanceAmount->EditValue)) {
                $this->carryingBalanceAmount->EditValue = FormatNumber($this->carryingBalanceAmount->EditValue, null);
            }

            // remainingBalanceAmount
            $this->remainingBalanceAmount->setupEditAttributes();
            $this->remainingBalanceAmount->EditCustomAttributes = "";
            $this->remainingBalanceAmount->EditValue = HtmlEncode($this->remainingBalanceAmount->CurrentValue);
            $this->remainingBalanceAmount->PlaceHolder = RemoveHtml($this->remainingBalanceAmount->caption());
            if (strval($this->remainingBalanceAmount->EditValue) != "" && is_numeric($this->remainingBalanceAmount->EditValue)) {
                $this->remainingBalanceAmount->EditValue = FormatNumber($this->remainingBalanceAmount->EditValue, null);
            }

            // create_date
            $this->create_date->setupEditAttributes();
            $this->create_date->EditCustomAttributes = "";
            $this->create_date->EditValue = HtmlEncode(FormatDateTime($this->create_date->CurrentValue, $this->create_date->formatPattern()));
            $this->create_date->PlaceHolder = RemoveHtml($this->create_date->caption());

            // update_date
            $this->update_date->setupEditAttributes();
            $this->update_date->EditCustomAttributes = "";
            $this->update_date->EditValue = HtmlEncode(FormatDateTime($this->update_date->CurrentValue, $this->update_date->formatPattern()));
            $this->update_date->PlaceHolder = RemoveHtml($this->update_date->caption());

            // post_message
            $this->post_message->setupEditAttributes();
            $this->post_message->EditCustomAttributes = "";
            $this->post_message->EditValue = HtmlEncode($this->post_message->CurrentValue);
            $this->post_message->PlaceHolder = RemoveHtml($this->post_message->caption());
            if (strval($this->post_message->EditValue) != "" && is_numeric($this->post_message->EditValue)) {
                $this->post_message->EditValue = FormatNumber($this->post_message->EditValue, null);
            }

            // post_try_cnt
            $this->post_try_cnt->setupEditAttributes();
            $this->post_try_cnt->EditCustomAttributes = "";
            $this->post_try_cnt->EditValue = HtmlEncode($this->post_try_cnt->CurrentValue);
            $this->post_try_cnt->PlaceHolder = RemoveHtml($this->post_try_cnt->caption());
            if (strval($this->post_try_cnt->EditValue) != "" && is_numeric($this->post_try_cnt->EditValue)) {
                $this->post_try_cnt->EditValue = FormatNumber($this->post_try_cnt->EditValue, null);
            }

            // Add refer script

            // productid
            $this->productid->LinkCustomAttributes = "";
            $this->productid->HrefValue = "";

            // name
            $this->name->LinkCustomAttributes = "";
            $this->name->HrefValue = "";

            // code
            $this->code->LinkCustomAttributes = "";
            $this->code->HrefValue = "";

            // type
            $this->type->LinkCustomAttributes = "";
            $this->type->HrefValue = "";

            // purchaseValue
            $this->purchaseValue->LinkCustomAttributes = "";
            $this->purchaseValue->HrefValue = "";

            // purchaseVatType
            $this->purchaseVatType->LinkCustomAttributes = "";
            $this->purchaseVatType->HrefValue = "";

            // purchaseAccount
            $this->purchaseAccount->LinkCustomAttributes = "";
            $this->purchaseAccount->HrefValue = "";

            // sellValue
            $this->sellValue->LinkCustomAttributes = "";
            $this->sellValue->HrefValue = "";

            // sellVatType
            $this->sellVatType->LinkCustomAttributes = "";
            $this->sellVatType->HrefValue = "";

            // sellAccount
            $this->sellAccount->LinkCustomAttributes = "";
            $this->sellAccount->HrefValue = "";

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";

            // carryingBalanceValue
            $this->carryingBalanceValue->LinkCustomAttributes = "";
            $this->carryingBalanceValue->HrefValue = "";

            // carryingBalanceAmount
            $this->carryingBalanceAmount->LinkCustomAttributes = "";
            $this->carryingBalanceAmount->HrefValue = "";

            // remainingBalanceAmount
            $this->remainingBalanceAmount->LinkCustomAttributes = "";
            $this->remainingBalanceAmount->HrefValue = "";

            // create_date
            $this->create_date->LinkCustomAttributes = "";
            $this->create_date->HrefValue = "";

            // update_date
            $this->update_date->LinkCustomAttributes = "";
            $this->update_date->HrefValue = "";

            // post_message
            $this->post_message->LinkCustomAttributes = "";
            $this->post_message->HrefValue = "";

            // post_try_cnt
            $this->post_try_cnt->LinkCustomAttributes = "";
            $this->post_try_cnt->HrefValue = "";
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
        if ($this->productid->Required) {
            if (!$this->productid->IsDetailKey && EmptyValue($this->productid->FormValue)) {
                $this->productid->addErrorMessage(str_replace("%s", $this->productid->caption(), $this->productid->RequiredErrorMessage));
            }
        }
        if ($this->name->Required) {
            if (!$this->name->IsDetailKey && EmptyValue($this->name->FormValue)) {
                $this->name->addErrorMessage(str_replace("%s", $this->name->caption(), $this->name->RequiredErrorMessage));
            }
        }
        if ($this->code->Required) {
            if (!$this->code->IsDetailKey && EmptyValue($this->code->FormValue)) {
                $this->code->addErrorMessage(str_replace("%s", $this->code->caption(), $this->code->RequiredErrorMessage));
            }
        }
        if ($this->type->Required) {
            if (!$this->type->IsDetailKey && EmptyValue($this->type->FormValue)) {
                $this->type->addErrorMessage(str_replace("%s", $this->type->caption(), $this->type->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->type->FormValue)) {
            $this->type->addErrorMessage($this->type->getErrorMessage(false));
        }
        if ($this->purchaseValue->Required) {
            if (!$this->purchaseValue->IsDetailKey && EmptyValue($this->purchaseValue->FormValue)) {
                $this->purchaseValue->addErrorMessage(str_replace("%s", $this->purchaseValue->caption(), $this->purchaseValue->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->purchaseValue->FormValue)) {
            $this->purchaseValue->addErrorMessage($this->purchaseValue->getErrorMessage(false));
        }
        if ($this->purchaseVatType->Required) {
            if (!$this->purchaseVatType->IsDetailKey && EmptyValue($this->purchaseVatType->FormValue)) {
                $this->purchaseVatType->addErrorMessage(str_replace("%s", $this->purchaseVatType->caption(), $this->purchaseVatType->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->purchaseVatType->FormValue)) {
            $this->purchaseVatType->addErrorMessage($this->purchaseVatType->getErrorMessage(false));
        }
        if ($this->purchaseAccount->Required) {
            if (!$this->purchaseAccount->IsDetailKey && EmptyValue($this->purchaseAccount->FormValue)) {
                $this->purchaseAccount->addErrorMessage(str_replace("%s", $this->purchaseAccount->caption(), $this->purchaseAccount->RequiredErrorMessage));
            }
        }
        if ($this->sellValue->Required) {
            if (!$this->sellValue->IsDetailKey && EmptyValue($this->sellValue->FormValue)) {
                $this->sellValue->addErrorMessage(str_replace("%s", $this->sellValue->caption(), $this->sellValue->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->sellValue->FormValue)) {
            $this->sellValue->addErrorMessage($this->sellValue->getErrorMessage(false));
        }
        if ($this->sellVatType->Required) {
            if (!$this->sellVatType->IsDetailKey && EmptyValue($this->sellVatType->FormValue)) {
                $this->sellVatType->addErrorMessage(str_replace("%s", $this->sellVatType->caption(), $this->sellVatType->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->sellVatType->FormValue)) {
            $this->sellVatType->addErrorMessage($this->sellVatType->getErrorMessage(false));
        }
        if ($this->sellAccount->Required) {
            if (!$this->sellAccount->IsDetailKey && EmptyValue($this->sellAccount->FormValue)) {
                $this->sellAccount->addErrorMessage(str_replace("%s", $this->sellAccount->caption(), $this->sellAccount->RequiredErrorMessage));
            }
        }
        if ($this->description->Required) {
            if (!$this->description->IsDetailKey && EmptyValue($this->description->FormValue)) {
                $this->description->addErrorMessage(str_replace("%s", $this->description->caption(), $this->description->RequiredErrorMessage));
            }
        }
        if ($this->carryingBalanceValue->Required) {
            if (!$this->carryingBalanceValue->IsDetailKey && EmptyValue($this->carryingBalanceValue->FormValue)) {
                $this->carryingBalanceValue->addErrorMessage(str_replace("%s", $this->carryingBalanceValue->caption(), $this->carryingBalanceValue->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->carryingBalanceValue->FormValue)) {
            $this->carryingBalanceValue->addErrorMessage($this->carryingBalanceValue->getErrorMessage(false));
        }
        if ($this->carryingBalanceAmount->Required) {
            if (!$this->carryingBalanceAmount->IsDetailKey && EmptyValue($this->carryingBalanceAmount->FormValue)) {
                $this->carryingBalanceAmount->addErrorMessage(str_replace("%s", $this->carryingBalanceAmount->caption(), $this->carryingBalanceAmount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->carryingBalanceAmount->FormValue)) {
            $this->carryingBalanceAmount->addErrorMessage($this->carryingBalanceAmount->getErrorMessage(false));
        }
        if ($this->remainingBalanceAmount->Required) {
            if (!$this->remainingBalanceAmount->IsDetailKey && EmptyValue($this->remainingBalanceAmount->FormValue)) {
                $this->remainingBalanceAmount->addErrorMessage(str_replace("%s", $this->remainingBalanceAmount->caption(), $this->remainingBalanceAmount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->remainingBalanceAmount->FormValue)) {
            $this->remainingBalanceAmount->addErrorMessage($this->remainingBalanceAmount->getErrorMessage(false));
        }
        if ($this->create_date->Required) {
            if (!$this->create_date->IsDetailKey && EmptyValue($this->create_date->FormValue)) {
                $this->create_date->addErrorMessage(str_replace("%s", $this->create_date->caption(), $this->create_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->create_date->FormValue, $this->create_date->formatPattern())) {
            $this->create_date->addErrorMessage($this->create_date->getErrorMessage(false));
        }
        if ($this->update_date->Required) {
            if (!$this->update_date->IsDetailKey && EmptyValue($this->update_date->FormValue)) {
                $this->update_date->addErrorMessage(str_replace("%s", $this->update_date->caption(), $this->update_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->update_date->FormValue, $this->update_date->formatPattern())) {
            $this->update_date->addErrorMessage($this->update_date->getErrorMessage(false));
        }
        if ($this->post_message->Required) {
            if (!$this->post_message->IsDetailKey && EmptyValue($this->post_message->FormValue)) {
                $this->post_message->addErrorMessage(str_replace("%s", $this->post_message->caption(), $this->post_message->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->post_message->FormValue)) {
            $this->post_message->addErrorMessage($this->post_message->getErrorMessage(false));
        }
        if ($this->post_try_cnt->Required) {
            if (!$this->post_try_cnt->IsDetailKey && EmptyValue($this->post_try_cnt->FormValue)) {
                $this->post_try_cnt->addErrorMessage(str_replace("%s", $this->post_try_cnt->caption(), $this->post_try_cnt->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->post_try_cnt->FormValue)) {
            $this->post_try_cnt->addErrorMessage($this->post_try_cnt->getErrorMessage(false));
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

        // productid
        $this->productid->setDbValueDef($rsnew, $this->productid->CurrentValue, null, false);

        // name
        $this->name->setDbValueDef($rsnew, $this->name->CurrentValue, null, false);

        // code
        $this->code->setDbValueDef($rsnew, $this->code->CurrentValue, null, false);

        // type
        $this->type->setDbValueDef($rsnew, $this->type->CurrentValue, null, false);

        // purchaseValue
        $this->purchaseValue->setDbValueDef($rsnew, $this->purchaseValue->CurrentValue, null, false);

        // purchaseVatType
        $this->purchaseVatType->setDbValueDef($rsnew, $this->purchaseVatType->CurrentValue, null, false);

        // purchaseAccount
        $this->purchaseAccount->setDbValueDef($rsnew, $this->purchaseAccount->CurrentValue, null, false);

        // sellValue
        $this->sellValue->setDbValueDef($rsnew, $this->sellValue->CurrentValue, null, false);

        // sellVatType
        $this->sellVatType->setDbValueDef($rsnew, $this->sellVatType->CurrentValue, null, false);

        // sellAccount
        $this->sellAccount->setDbValueDef($rsnew, $this->sellAccount->CurrentValue, null, false);

        // description
        $this->description->setDbValueDef($rsnew, $this->description->CurrentValue, null, false);

        // carryingBalanceValue
        $this->carryingBalanceValue->setDbValueDef($rsnew, $this->carryingBalanceValue->CurrentValue, null, false);

        // carryingBalanceAmount
        $this->carryingBalanceAmount->setDbValueDef($rsnew, $this->carryingBalanceAmount->CurrentValue, null, false);

        // remainingBalanceAmount
        $this->remainingBalanceAmount->setDbValueDef($rsnew, $this->remainingBalanceAmount->CurrentValue, null, false);

        // create_date
        $this->create_date->setDbValueDef($rsnew, UnFormatDateTime($this->create_date->CurrentValue, $this->create_date->formatPattern()), null, false);

        // update_date
        $this->update_date->setDbValueDef($rsnew, UnFormatDateTime($this->update_date->CurrentValue, $this->update_date->formatPattern()), null, false);

        // post_message
        $this->post_message->setDbValueDef($rsnew, $this->post_message->CurrentValue, null, false);

        // post_try_cnt
        $this->post_try_cnt->setDbValueDef($rsnew, $this->post_try_cnt->CurrentValue, null, false);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("peakproductlist"), "", $this->TableVar, true);
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
