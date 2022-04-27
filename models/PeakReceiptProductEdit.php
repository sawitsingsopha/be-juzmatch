<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class PeakReceiptProductEdit extends PeakReceiptProduct
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'peak_receipt_product';

    // Page object name
    public $PageObjName = "PeakReceiptProductEdit";

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

        // Table object (peak_receipt_product)
        if (!isset($GLOBALS["peak_receipt_product"]) || get_class($GLOBALS["peak_receipt_product"]) == PROJECT_NAMESPACE . "peak_receipt_product") {
            $GLOBALS["peak_receipt_product"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'peak_receipt_product');
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
                $tbl = Container("peak_receipt_product");
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
                    if ($pageName == "peakreceiptproductview") {
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
        $this->id->setVisibility();
        $this->peak_receipt_id->setVisibility();
        $this->products_id->setVisibility();
        $this->productid->setVisibility();
        $this->productcode->setVisibility();
        $this->producttemplate->setVisibility();
        $this->description->setVisibility();
        $this->accountcode->setVisibility();
        $this->accountSubId->setVisibility();
        $this->accountSubCode->setVisibility();
        $this->quantity->setVisibility();
        $this->price->setVisibility();
        $this->discount->setVisibility();
        $this->vatType->setVisibility();
        $this->note->setVisibility();
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
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
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
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
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
                        $this->terminate("peakreceiptproductlist"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "peakreceiptproductlist") {
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

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }

        // Check field name 'peak_receipt_id' first before field var 'x_peak_receipt_id'
        $val = $CurrentForm->hasValue("peak_receipt_id") ? $CurrentForm->getValue("peak_receipt_id") : $CurrentForm->getValue("x_peak_receipt_id");
        if (!$this->peak_receipt_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->peak_receipt_id->Visible = false; // Disable update for API request
            } else {
                $this->peak_receipt_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'products_id' first before field var 'x_products_id'
        $val = $CurrentForm->hasValue("products_id") ? $CurrentForm->getValue("products_id") : $CurrentForm->getValue("x_products_id");
        if (!$this->products_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->products_id->Visible = false; // Disable update for API request
            } else {
                $this->products_id->setFormValue($val);
            }
        }

        // Check field name 'productid' first before field var 'x_productid'
        $val = $CurrentForm->hasValue("productid") ? $CurrentForm->getValue("productid") : $CurrentForm->getValue("x_productid");
        if (!$this->productid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->productid->Visible = false; // Disable update for API request
            } else {
                $this->productid->setFormValue($val);
            }
        }

        // Check field name 'productcode' first before field var 'x_productcode'
        $val = $CurrentForm->hasValue("productcode") ? $CurrentForm->getValue("productcode") : $CurrentForm->getValue("x_productcode");
        if (!$this->productcode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->productcode->Visible = false; // Disable update for API request
            } else {
                $this->productcode->setFormValue($val);
            }
        }

        // Check field name 'producttemplate' first before field var 'x_producttemplate'
        $val = $CurrentForm->hasValue("producttemplate") ? $CurrentForm->getValue("producttemplate") : $CurrentForm->getValue("x_producttemplate");
        if (!$this->producttemplate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->producttemplate->Visible = false; // Disable update for API request
            } else {
                $this->producttemplate->setFormValue($val);
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

        // Check field name 'accountcode' first before field var 'x_accountcode'
        $val = $CurrentForm->hasValue("accountcode") ? $CurrentForm->getValue("accountcode") : $CurrentForm->getValue("x_accountcode");
        if (!$this->accountcode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->accountcode->Visible = false; // Disable update for API request
            } else {
                $this->accountcode->setFormValue($val);
            }
        }

        // Check field name 'accountSubId' first before field var 'x_accountSubId'
        $val = $CurrentForm->hasValue("accountSubId") ? $CurrentForm->getValue("accountSubId") : $CurrentForm->getValue("x_accountSubId");
        if (!$this->accountSubId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->accountSubId->Visible = false; // Disable update for API request
            } else {
                $this->accountSubId->setFormValue($val);
            }
        }

        // Check field name 'accountSubCode' first before field var 'x_accountSubCode'
        $val = $CurrentForm->hasValue("accountSubCode") ? $CurrentForm->getValue("accountSubCode") : $CurrentForm->getValue("x_accountSubCode");
        if (!$this->accountSubCode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->accountSubCode->Visible = false; // Disable update for API request
            } else {
                $this->accountSubCode->setFormValue($val);
            }
        }

        // Check field name 'quantity' first before field var 'x_quantity'
        $val = $CurrentForm->hasValue("quantity") ? $CurrentForm->getValue("quantity") : $CurrentForm->getValue("x_quantity");
        if (!$this->quantity->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->quantity->Visible = false; // Disable update for API request
            } else {
                $this->quantity->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'price' first before field var 'x_price'
        $val = $CurrentForm->hasValue("price") ? $CurrentForm->getValue("price") : $CurrentForm->getValue("x_price");
        if (!$this->price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price->Visible = false; // Disable update for API request
            } else {
                $this->price->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'discount' first before field var 'x_discount'
        $val = $CurrentForm->hasValue("discount") ? $CurrentForm->getValue("discount") : $CurrentForm->getValue("x_discount");
        if (!$this->discount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->discount->Visible = false; // Disable update for API request
            } else {
                $this->discount->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'vatType' first before field var 'x_vatType'
        $val = $CurrentForm->hasValue("vatType") ? $CurrentForm->getValue("vatType") : $CurrentForm->getValue("x_vatType");
        if (!$this->vatType->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->vatType->Visible = false; // Disable update for API request
            } else {
                $this->vatType->setFormValue($val);
            }
        }

        // Check field name 'note' first before field var 'x_note'
        $val = $CurrentForm->hasValue("note") ? $CurrentForm->getValue("note") : $CurrentForm->getValue("x_note");
        if (!$this->note->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->note->Visible = false; // Disable update for API request
            } else {
                $this->note->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->peak_receipt_id->CurrentValue = $this->peak_receipt_id->FormValue;
        $this->products_id->CurrentValue = $this->products_id->FormValue;
        $this->productid->CurrentValue = $this->productid->FormValue;
        $this->productcode->CurrentValue = $this->productcode->FormValue;
        $this->producttemplate->CurrentValue = $this->producttemplate->FormValue;
        $this->description->CurrentValue = $this->description->FormValue;
        $this->accountcode->CurrentValue = $this->accountcode->FormValue;
        $this->accountSubId->CurrentValue = $this->accountSubId->FormValue;
        $this->accountSubCode->CurrentValue = $this->accountSubCode->FormValue;
        $this->quantity->CurrentValue = $this->quantity->FormValue;
        $this->price->CurrentValue = $this->price->FormValue;
        $this->discount->CurrentValue = $this->discount->FormValue;
        $this->vatType->CurrentValue = $this->vatType->FormValue;
        $this->note->CurrentValue = $this->note->FormValue;
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
        $this->peak_receipt_id->setDbValue($row['peak_receipt_id']);
        $this->products_id->setDbValue($row['products_id']);
        $this->productid->setDbValue($row['productid']);
        $this->productcode->setDbValue($row['productcode']);
        $this->producttemplate->setDbValue($row['producttemplate']);
        $this->description->setDbValue($row['description']);
        $this->accountcode->setDbValue($row['accountcode']);
        $this->accountSubId->setDbValue($row['accountSubId']);
        $this->accountSubCode->setDbValue($row['accountSubCode']);
        $this->quantity->setDbValue($row['quantity']);
        $this->price->setDbValue($row['price']);
        $this->discount->setDbValue($row['discount']);
        $this->vatType->setDbValue($row['vatType']);
        $this->note->setDbValue($row['note']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['peak_receipt_id'] = null;
        $row['products_id'] = null;
        $row['productid'] = null;
        $row['productcode'] = null;
        $row['producttemplate'] = null;
        $row['description'] = null;
        $row['accountcode'] = null;
        $row['accountSubId'] = null;
        $row['accountSubCode'] = null;
        $row['quantity'] = null;
        $row['price'] = null;
        $row['discount'] = null;
        $row['vatType'] = null;
        $row['note'] = null;
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

        // peak_receipt_id
        $this->peak_receipt_id->RowCssClass = "row";

        // products_id
        $this->products_id->RowCssClass = "row";

        // productid
        $this->productid->RowCssClass = "row";

        // productcode
        $this->productcode->RowCssClass = "row";

        // producttemplate
        $this->producttemplate->RowCssClass = "row";

        // description
        $this->description->RowCssClass = "row";

        // accountcode
        $this->accountcode->RowCssClass = "row";

        // accountSubId
        $this->accountSubId->RowCssClass = "row";

        // accountSubCode
        $this->accountSubCode->RowCssClass = "row";

        // quantity
        $this->quantity->RowCssClass = "row";

        // price
        $this->price->RowCssClass = "row";

        // discount
        $this->discount->RowCssClass = "row";

        // vatType
        $this->vatType->RowCssClass = "row";

        // note
        $this->note->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // peak_receipt_id
            $this->peak_receipt_id->ViewValue = $this->peak_receipt_id->CurrentValue;
            $this->peak_receipt_id->ViewValue = FormatNumber($this->peak_receipt_id->ViewValue, $this->peak_receipt_id->formatPattern());
            $this->peak_receipt_id->ViewCustomAttributes = "";

            // products_id
            $this->products_id->ViewValue = $this->products_id->CurrentValue;
            $this->products_id->ViewCustomAttributes = "";

            // productid
            $this->productid->ViewValue = $this->productid->CurrentValue;
            $this->productid->ViewCustomAttributes = "";

            // productcode
            $this->productcode->ViewValue = $this->productcode->CurrentValue;
            $this->productcode->ViewCustomAttributes = "";

            // producttemplate
            $this->producttemplate->ViewValue = $this->producttemplate->CurrentValue;
            $this->producttemplate->ViewCustomAttributes = "";

            // description
            $this->description->ViewValue = $this->description->CurrentValue;
            $this->description->ViewCustomAttributes = "";

            // accountcode
            $this->accountcode->ViewValue = $this->accountcode->CurrentValue;
            $this->accountcode->ViewCustomAttributes = "";

            // accountSubId
            $this->accountSubId->ViewValue = $this->accountSubId->CurrentValue;
            $this->accountSubId->ViewCustomAttributes = "";

            // accountSubCode
            $this->accountSubCode->ViewValue = $this->accountSubCode->CurrentValue;
            $this->accountSubCode->ViewCustomAttributes = "";

            // quantity
            $this->quantity->ViewValue = $this->quantity->CurrentValue;
            $this->quantity->ViewValue = FormatNumber($this->quantity->ViewValue, $this->quantity->formatPattern());
            $this->quantity->ViewCustomAttributes = "";

            // price
            $this->price->ViewValue = $this->price->CurrentValue;
            $this->price->ViewValue = FormatNumber($this->price->ViewValue, $this->price->formatPattern());
            $this->price->ViewCustomAttributes = "";

            // discount
            $this->discount->ViewValue = $this->discount->CurrentValue;
            $this->discount->ViewValue = FormatNumber($this->discount->ViewValue, $this->discount->formatPattern());
            $this->discount->ViewCustomAttributes = "";

            // vatType
            $this->vatType->ViewValue = $this->vatType->CurrentValue;
            $this->vatType->ViewCustomAttributes = "";

            // note
            $this->note->ViewValue = $this->note->CurrentValue;
            $this->note->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // peak_receipt_id
            $this->peak_receipt_id->LinkCustomAttributes = "";
            $this->peak_receipt_id->HrefValue = "";

            // products_id
            $this->products_id->LinkCustomAttributes = "";
            $this->products_id->HrefValue = "";

            // productid
            $this->productid->LinkCustomAttributes = "";
            $this->productid->HrefValue = "";

            // productcode
            $this->productcode->LinkCustomAttributes = "";
            $this->productcode->HrefValue = "";

            // producttemplate
            $this->producttemplate->LinkCustomAttributes = "";
            $this->producttemplate->HrefValue = "";

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";

            // accountcode
            $this->accountcode->LinkCustomAttributes = "";
            $this->accountcode->HrefValue = "";

            // accountSubId
            $this->accountSubId->LinkCustomAttributes = "";
            $this->accountSubId->HrefValue = "";

            // accountSubCode
            $this->accountSubCode->LinkCustomAttributes = "";
            $this->accountSubCode->HrefValue = "";

            // quantity
            $this->quantity->LinkCustomAttributes = "";
            $this->quantity->HrefValue = "";

            // price
            $this->price->LinkCustomAttributes = "";
            $this->price->HrefValue = "";

            // discount
            $this->discount->LinkCustomAttributes = "";
            $this->discount->HrefValue = "";

            // vatType
            $this->vatType->LinkCustomAttributes = "";
            $this->vatType->HrefValue = "";

            // note
            $this->note->LinkCustomAttributes = "";
            $this->note->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // peak_receipt_id
            $this->peak_receipt_id->setupEditAttributes();
            $this->peak_receipt_id->EditCustomAttributes = "";
            $this->peak_receipt_id->EditValue = HtmlEncode($this->peak_receipt_id->CurrentValue);
            $this->peak_receipt_id->PlaceHolder = RemoveHtml($this->peak_receipt_id->caption());
            if (strval($this->peak_receipt_id->EditValue) != "" && is_numeric($this->peak_receipt_id->EditValue)) {
                $this->peak_receipt_id->EditValue = FormatNumber($this->peak_receipt_id->EditValue, null);
            }

            // products_id
            $this->products_id->setupEditAttributes();
            $this->products_id->EditCustomAttributes = "";
            if (!$this->products_id->Raw) {
                $this->products_id->CurrentValue = HtmlDecode($this->products_id->CurrentValue);
            }
            $this->products_id->EditValue = HtmlEncode($this->products_id->CurrentValue);
            $this->products_id->PlaceHolder = RemoveHtml($this->products_id->caption());

            // productid
            $this->productid->setupEditAttributes();
            $this->productid->EditCustomAttributes = "";
            if (!$this->productid->Raw) {
                $this->productid->CurrentValue = HtmlDecode($this->productid->CurrentValue);
            }
            $this->productid->EditValue = HtmlEncode($this->productid->CurrentValue);
            $this->productid->PlaceHolder = RemoveHtml($this->productid->caption());

            // productcode
            $this->productcode->setupEditAttributes();
            $this->productcode->EditCustomAttributes = "";
            if (!$this->productcode->Raw) {
                $this->productcode->CurrentValue = HtmlDecode($this->productcode->CurrentValue);
            }
            $this->productcode->EditValue = HtmlEncode($this->productcode->CurrentValue);
            $this->productcode->PlaceHolder = RemoveHtml($this->productcode->caption());

            // producttemplate
            $this->producttemplate->setupEditAttributes();
            $this->producttemplate->EditCustomAttributes = "";
            if (!$this->producttemplate->Raw) {
                $this->producttemplate->CurrentValue = HtmlDecode($this->producttemplate->CurrentValue);
            }
            $this->producttemplate->EditValue = HtmlEncode($this->producttemplate->CurrentValue);
            $this->producttemplate->PlaceHolder = RemoveHtml($this->producttemplate->caption());

            // description
            $this->description->setupEditAttributes();
            $this->description->EditCustomAttributes = "";
            $this->description->EditValue = HtmlEncode($this->description->CurrentValue);
            $this->description->PlaceHolder = RemoveHtml($this->description->caption());

            // accountcode
            $this->accountcode->setupEditAttributes();
            $this->accountcode->EditCustomAttributes = "";
            if (!$this->accountcode->Raw) {
                $this->accountcode->CurrentValue = HtmlDecode($this->accountcode->CurrentValue);
            }
            $this->accountcode->EditValue = HtmlEncode($this->accountcode->CurrentValue);
            $this->accountcode->PlaceHolder = RemoveHtml($this->accountcode->caption());

            // accountSubId
            $this->accountSubId->setupEditAttributes();
            $this->accountSubId->EditCustomAttributes = "";
            if (!$this->accountSubId->Raw) {
                $this->accountSubId->CurrentValue = HtmlDecode($this->accountSubId->CurrentValue);
            }
            $this->accountSubId->EditValue = HtmlEncode($this->accountSubId->CurrentValue);
            $this->accountSubId->PlaceHolder = RemoveHtml($this->accountSubId->caption());

            // accountSubCode
            $this->accountSubCode->setupEditAttributes();
            $this->accountSubCode->EditCustomAttributes = "";
            if (!$this->accountSubCode->Raw) {
                $this->accountSubCode->CurrentValue = HtmlDecode($this->accountSubCode->CurrentValue);
            }
            $this->accountSubCode->EditValue = HtmlEncode($this->accountSubCode->CurrentValue);
            $this->accountSubCode->PlaceHolder = RemoveHtml($this->accountSubCode->caption());

            // quantity
            $this->quantity->setupEditAttributes();
            $this->quantity->EditCustomAttributes = "";
            $this->quantity->EditValue = HtmlEncode($this->quantity->CurrentValue);
            $this->quantity->PlaceHolder = RemoveHtml($this->quantity->caption());
            if (strval($this->quantity->EditValue) != "" && is_numeric($this->quantity->EditValue)) {
                $this->quantity->EditValue = FormatNumber($this->quantity->EditValue, null);
            }

            // price
            $this->price->setupEditAttributes();
            $this->price->EditCustomAttributes = "";
            $this->price->EditValue = HtmlEncode($this->price->CurrentValue);
            $this->price->PlaceHolder = RemoveHtml($this->price->caption());
            if (strval($this->price->EditValue) != "" && is_numeric($this->price->EditValue)) {
                $this->price->EditValue = FormatNumber($this->price->EditValue, null);
            }

            // discount
            $this->discount->setupEditAttributes();
            $this->discount->EditCustomAttributes = "";
            $this->discount->EditValue = HtmlEncode($this->discount->CurrentValue);
            $this->discount->PlaceHolder = RemoveHtml($this->discount->caption());
            if (strval($this->discount->EditValue) != "" && is_numeric($this->discount->EditValue)) {
                $this->discount->EditValue = FormatNumber($this->discount->EditValue, null);
            }

            // vatType
            $this->vatType->setupEditAttributes();
            $this->vatType->EditCustomAttributes = "";
            if (!$this->vatType->Raw) {
                $this->vatType->CurrentValue = HtmlDecode($this->vatType->CurrentValue);
            }
            $this->vatType->EditValue = HtmlEncode($this->vatType->CurrentValue);
            $this->vatType->PlaceHolder = RemoveHtml($this->vatType->caption());

            // note
            $this->note->setupEditAttributes();
            $this->note->EditCustomAttributes = "";
            $this->note->EditValue = HtmlEncode($this->note->CurrentValue);
            $this->note->PlaceHolder = RemoveHtml($this->note->caption());

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // peak_receipt_id
            $this->peak_receipt_id->LinkCustomAttributes = "";
            $this->peak_receipt_id->HrefValue = "";

            // products_id
            $this->products_id->LinkCustomAttributes = "";
            $this->products_id->HrefValue = "";

            // productid
            $this->productid->LinkCustomAttributes = "";
            $this->productid->HrefValue = "";

            // productcode
            $this->productcode->LinkCustomAttributes = "";
            $this->productcode->HrefValue = "";

            // producttemplate
            $this->producttemplate->LinkCustomAttributes = "";
            $this->producttemplate->HrefValue = "";

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";

            // accountcode
            $this->accountcode->LinkCustomAttributes = "";
            $this->accountcode->HrefValue = "";

            // accountSubId
            $this->accountSubId->LinkCustomAttributes = "";
            $this->accountSubId->HrefValue = "";

            // accountSubCode
            $this->accountSubCode->LinkCustomAttributes = "";
            $this->accountSubCode->HrefValue = "";

            // quantity
            $this->quantity->LinkCustomAttributes = "";
            $this->quantity->HrefValue = "";

            // price
            $this->price->LinkCustomAttributes = "";
            $this->price->HrefValue = "";

            // discount
            $this->discount->LinkCustomAttributes = "";
            $this->discount->HrefValue = "";

            // vatType
            $this->vatType->LinkCustomAttributes = "";
            $this->vatType->HrefValue = "";

            // note
            $this->note->LinkCustomAttributes = "";
            $this->note->HrefValue = "";
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
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if ($this->peak_receipt_id->Required) {
            if (!$this->peak_receipt_id->IsDetailKey && EmptyValue($this->peak_receipt_id->FormValue)) {
                $this->peak_receipt_id->addErrorMessage(str_replace("%s", $this->peak_receipt_id->caption(), $this->peak_receipt_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->peak_receipt_id->FormValue)) {
            $this->peak_receipt_id->addErrorMessage($this->peak_receipt_id->getErrorMessage(false));
        }
        if ($this->products_id->Required) {
            if (!$this->products_id->IsDetailKey && EmptyValue($this->products_id->FormValue)) {
                $this->products_id->addErrorMessage(str_replace("%s", $this->products_id->caption(), $this->products_id->RequiredErrorMessage));
            }
        }
        if ($this->productid->Required) {
            if (!$this->productid->IsDetailKey && EmptyValue($this->productid->FormValue)) {
                $this->productid->addErrorMessage(str_replace("%s", $this->productid->caption(), $this->productid->RequiredErrorMessage));
            }
        }
        if ($this->productcode->Required) {
            if (!$this->productcode->IsDetailKey && EmptyValue($this->productcode->FormValue)) {
                $this->productcode->addErrorMessage(str_replace("%s", $this->productcode->caption(), $this->productcode->RequiredErrorMessage));
            }
        }
        if ($this->producttemplate->Required) {
            if (!$this->producttemplate->IsDetailKey && EmptyValue($this->producttemplate->FormValue)) {
                $this->producttemplate->addErrorMessage(str_replace("%s", $this->producttemplate->caption(), $this->producttemplate->RequiredErrorMessage));
            }
        }
        if ($this->description->Required) {
            if (!$this->description->IsDetailKey && EmptyValue($this->description->FormValue)) {
                $this->description->addErrorMessage(str_replace("%s", $this->description->caption(), $this->description->RequiredErrorMessage));
            }
        }
        if ($this->accountcode->Required) {
            if (!$this->accountcode->IsDetailKey && EmptyValue($this->accountcode->FormValue)) {
                $this->accountcode->addErrorMessage(str_replace("%s", $this->accountcode->caption(), $this->accountcode->RequiredErrorMessage));
            }
        }
        if ($this->accountSubId->Required) {
            if (!$this->accountSubId->IsDetailKey && EmptyValue($this->accountSubId->FormValue)) {
                $this->accountSubId->addErrorMessage(str_replace("%s", $this->accountSubId->caption(), $this->accountSubId->RequiredErrorMessage));
            }
        }
        if ($this->accountSubCode->Required) {
            if (!$this->accountSubCode->IsDetailKey && EmptyValue($this->accountSubCode->FormValue)) {
                $this->accountSubCode->addErrorMessage(str_replace("%s", $this->accountSubCode->caption(), $this->accountSubCode->RequiredErrorMessage));
            }
        }
        if ($this->quantity->Required) {
            if (!$this->quantity->IsDetailKey && EmptyValue($this->quantity->FormValue)) {
                $this->quantity->addErrorMessage(str_replace("%s", $this->quantity->caption(), $this->quantity->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->quantity->FormValue)) {
            $this->quantity->addErrorMessage($this->quantity->getErrorMessage(false));
        }
        if ($this->price->Required) {
            if (!$this->price->IsDetailKey && EmptyValue($this->price->FormValue)) {
                $this->price->addErrorMessage(str_replace("%s", $this->price->caption(), $this->price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->price->FormValue)) {
            $this->price->addErrorMessage($this->price->getErrorMessage(false));
        }
        if ($this->discount->Required) {
            if (!$this->discount->IsDetailKey && EmptyValue($this->discount->FormValue)) {
                $this->discount->addErrorMessage(str_replace("%s", $this->discount->caption(), $this->discount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->discount->FormValue)) {
            $this->discount->addErrorMessage($this->discount->getErrorMessage(false));
        }
        if ($this->vatType->Required) {
            if (!$this->vatType->IsDetailKey && EmptyValue($this->vatType->FormValue)) {
                $this->vatType->addErrorMessage(str_replace("%s", $this->vatType->caption(), $this->vatType->RequiredErrorMessage));
            }
        }
        if ($this->note->Required) {
            if (!$this->note->IsDetailKey && EmptyValue($this->note->FormValue)) {
                $this->note->addErrorMessage(str_replace("%s", $this->note->caption(), $this->note->RequiredErrorMessage));
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

            // peak_receipt_id
            $this->peak_receipt_id->setDbValueDef($rsnew, $this->peak_receipt_id->CurrentValue, null, $this->peak_receipt_id->ReadOnly);

            // products_id
            $this->products_id->setDbValueDef($rsnew, $this->products_id->CurrentValue, null, $this->products_id->ReadOnly);

            // productid
            $this->productid->setDbValueDef($rsnew, $this->productid->CurrentValue, null, $this->productid->ReadOnly);

            // productcode
            $this->productcode->setDbValueDef($rsnew, $this->productcode->CurrentValue, null, $this->productcode->ReadOnly);

            // producttemplate
            $this->producttemplate->setDbValueDef($rsnew, $this->producttemplate->CurrentValue, null, $this->producttemplate->ReadOnly);

            // description
            $this->description->setDbValueDef($rsnew, $this->description->CurrentValue, null, $this->description->ReadOnly);

            // accountcode
            $this->accountcode->setDbValueDef($rsnew, $this->accountcode->CurrentValue, null, $this->accountcode->ReadOnly);

            // accountSubId
            $this->accountSubId->setDbValueDef($rsnew, $this->accountSubId->CurrentValue, null, $this->accountSubId->ReadOnly);

            // accountSubCode
            $this->accountSubCode->setDbValueDef($rsnew, $this->accountSubCode->CurrentValue, null, $this->accountSubCode->ReadOnly);

            // quantity
            $this->quantity->setDbValueDef($rsnew, $this->quantity->CurrentValue, null, $this->quantity->ReadOnly);

            // price
            $this->price->setDbValueDef($rsnew, $this->price->CurrentValue, null, $this->price->ReadOnly);

            // discount
            $this->discount->setDbValueDef($rsnew, $this->discount->CurrentValue, null, $this->discount->ReadOnly);

            // vatType
            $this->vatType->setDbValueDef($rsnew, $this->vatType->CurrentValue, null, $this->vatType->ReadOnly);

            // note
            $this->note->setDbValueDef($rsnew, $this->note->CurrentValue, null, $this->note->ReadOnly);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("peakreceiptproductlist"), "", $this->TableVar, true);
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
