<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class SaveLogSearchNonmemberEdit extends SaveLogSearchNonmember
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'save_log_search_nonmember';

    // Page object name
    public $PageObjName = "SaveLogSearchNonmemberEdit";

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

        // Table object (save_log_search_nonmember)
        if (!isset($GLOBALS["save_log_search_nonmember"]) || get_class($GLOBALS["save_log_search_nonmember"]) == PROJECT_NAMESPACE . "save_log_search_nonmember") {
            $GLOBALS["save_log_search_nonmember"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'save_log_search_nonmember');
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
                $tbl = Container("save_log_search_nonmember");
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
                    if ($pageName == "savelogsearchnonmemberview") {
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
            $key .= @$ar['save_log_search_nonmember_id'];
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
            $this->save_log_search_nonmember_id->Visible = false;
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
        $this->save_log_search_nonmember_id->setVisibility();
        $this->category_id->setVisibility();
        $this->min_installment->setVisibility();
        $this->max_installment->setVisibility();
        $this->attribute_detail_id->setVisibility();
        $this->latitude->setVisibility();
        $this->longitude->setVisibility();
        $this->_email->setVisibility();
        $this->phone->setVisibility();
        $this->cdate->setVisibility();
        $this->cip->setVisibility();
        $this->cuser->setVisibility();
        $this->first_name->setVisibility();
        $this->last_name->setVisibility();
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
            if (($keyValue = Get("save_log_search_nonmember_id") ?? Key(0) ?? Route(2)) !== null) {
                $this->save_log_search_nonmember_id->setQueryStringValue($keyValue);
                $this->save_log_search_nonmember_id->setOldValue($this->save_log_search_nonmember_id->QueryStringValue);
            } elseif (Post("save_log_search_nonmember_id") !== null) {
                $this->save_log_search_nonmember_id->setFormValue(Post("save_log_search_nonmember_id"));
                $this->save_log_search_nonmember_id->setOldValue($this->save_log_search_nonmember_id->FormValue);
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
                if (($keyValue = Get("save_log_search_nonmember_id") ?? Route("save_log_search_nonmember_id")) !== null) {
                    $this->save_log_search_nonmember_id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->save_log_search_nonmember_id->CurrentValue = null;
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
                        $this->terminate("savelogsearchnonmemberlist"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "savelogsearchnonmemberlist") {
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

        // Check field name 'save_log_search_nonmember_id' first before field var 'x_save_log_search_nonmember_id'
        $val = $CurrentForm->hasValue("save_log_search_nonmember_id") ? $CurrentForm->getValue("save_log_search_nonmember_id") : $CurrentForm->getValue("x_save_log_search_nonmember_id");
        if (!$this->save_log_search_nonmember_id->IsDetailKey) {
            $this->save_log_search_nonmember_id->setFormValue($val);
        }

        // Check field name 'category_id' first before field var 'x_category_id'
        $val = $CurrentForm->hasValue("category_id") ? $CurrentForm->getValue("category_id") : $CurrentForm->getValue("x_category_id");
        if (!$this->category_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->category_id->Visible = false; // Disable update for API request
            } else {
                $this->category_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'min_installment' first before field var 'x_min_installment'
        $val = $CurrentForm->hasValue("min_installment") ? $CurrentForm->getValue("min_installment") : $CurrentForm->getValue("x_min_installment");
        if (!$this->min_installment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->min_installment->Visible = false; // Disable update for API request
            } else {
                $this->min_installment->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'max_installment' first before field var 'x_max_installment'
        $val = $CurrentForm->hasValue("max_installment") ? $CurrentForm->getValue("max_installment") : $CurrentForm->getValue("x_max_installment");
        if (!$this->max_installment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->max_installment->Visible = false; // Disable update for API request
            } else {
                $this->max_installment->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'attribute_detail_id' first before field var 'x_attribute_detail_id'
        $val = $CurrentForm->hasValue("attribute_detail_id") ? $CurrentForm->getValue("attribute_detail_id") : $CurrentForm->getValue("x_attribute_detail_id");
        if (!$this->attribute_detail_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->attribute_detail_id->Visible = false; // Disable update for API request
            } else {
                $this->attribute_detail_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'latitude' first before field var 'x_latitude'
        $val = $CurrentForm->hasValue("latitude") ? $CurrentForm->getValue("latitude") : $CurrentForm->getValue("x_latitude");
        if (!$this->latitude->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->latitude->Visible = false; // Disable update for API request
            } else {
                $this->latitude->setFormValue($val);
            }
        }

        // Check field name 'longitude' first before field var 'x_longitude'
        $val = $CurrentForm->hasValue("longitude") ? $CurrentForm->getValue("longitude") : $CurrentForm->getValue("x_longitude");
        if (!$this->longitude->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->longitude->Visible = false; // Disable update for API request
            } else {
                $this->longitude->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
            }
        }

        // Check field name 'phone' first before field var 'x_phone'
        $val = $CurrentForm->hasValue("phone") ? $CurrentForm->getValue("phone") : $CurrentForm->getValue("x_phone");
        if (!$this->phone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->phone->Visible = false; // Disable update for API request
            } else {
                $this->phone->setFormValue($val);
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

        // Check field name 'first_name' first before field var 'x_first_name'
        $val = $CurrentForm->hasValue("first_name") ? $CurrentForm->getValue("first_name") : $CurrentForm->getValue("x_first_name");
        if (!$this->first_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->first_name->Visible = false; // Disable update for API request
            } else {
                $this->first_name->setFormValue($val);
            }
        }

        // Check field name 'last_name' first before field var 'x_last_name'
        $val = $CurrentForm->hasValue("last_name") ? $CurrentForm->getValue("last_name") : $CurrentForm->getValue("x_last_name");
        if (!$this->last_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->last_name->Visible = false; // Disable update for API request
            } else {
                $this->last_name->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->save_log_search_nonmember_id->CurrentValue = $this->save_log_search_nonmember_id->FormValue;
        $this->category_id->CurrentValue = $this->category_id->FormValue;
        $this->min_installment->CurrentValue = $this->min_installment->FormValue;
        $this->max_installment->CurrentValue = $this->max_installment->FormValue;
        $this->attribute_detail_id->CurrentValue = $this->attribute_detail_id->FormValue;
        $this->latitude->CurrentValue = $this->latitude->FormValue;
        $this->longitude->CurrentValue = $this->longitude->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->phone->CurrentValue = $this->phone->FormValue;
        $this->cdate->CurrentValue = $this->cdate->FormValue;
        $this->cdate->CurrentValue = UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
        $this->cip->CurrentValue = $this->cip->FormValue;
        $this->cuser->CurrentValue = $this->cuser->FormValue;
        $this->first_name->CurrentValue = $this->first_name->FormValue;
        $this->last_name->CurrentValue = $this->last_name->FormValue;
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
        $this->save_log_search_nonmember_id->setDbValue($row['save_log_search_nonmember_id']);
        $this->category_id->setDbValue($row['category_id']);
        $this->min_installment->setDbValue($row['min_installment']);
        $this->max_installment->setDbValue($row['max_installment']);
        $this->attribute_detail_id->setDbValue($row['attribute_detail_id']);
        $this->latitude->setDbValue($row['latitude']);
        $this->longitude->setDbValue($row['longitude']);
        $this->_email->setDbValue($row['email']);
        $this->phone->setDbValue($row['phone']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cip->setDbValue($row['cip']);
        $this->cuser->setDbValue($row['cuser']);
        $this->first_name->setDbValue($row['first_name']);
        $this->last_name->setDbValue($row['last_name']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['save_log_search_nonmember_id'] = null;
        $row['category_id'] = null;
        $row['min_installment'] = null;
        $row['max_installment'] = null;
        $row['attribute_detail_id'] = null;
        $row['latitude'] = null;
        $row['longitude'] = null;
        $row['email'] = null;
        $row['phone'] = null;
        $row['cdate'] = null;
        $row['cip'] = null;
        $row['cuser'] = null;
        $row['first_name'] = null;
        $row['last_name'] = null;
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

        // save_log_search_nonmember_id
        $this->save_log_search_nonmember_id->RowCssClass = "row";

        // category_id
        $this->category_id->RowCssClass = "row";

        // min_installment
        $this->min_installment->RowCssClass = "row";

        // max_installment
        $this->max_installment->RowCssClass = "row";

        // attribute_detail_id
        $this->attribute_detail_id->RowCssClass = "row";

        // latitude
        $this->latitude->RowCssClass = "row";

        // longitude
        $this->longitude->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // phone
        $this->phone->RowCssClass = "row";

        // cdate
        $this->cdate->RowCssClass = "row";

        // cip
        $this->cip->RowCssClass = "row";

        // cuser
        $this->cuser->RowCssClass = "row";

        // first_name
        $this->first_name->RowCssClass = "row";

        // last_name
        $this->last_name->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // save_log_search_nonmember_id
            $this->save_log_search_nonmember_id->ViewValue = $this->save_log_search_nonmember_id->CurrentValue;
            $this->save_log_search_nonmember_id->ViewCustomAttributes = "";

            // category_id
            $this->category_id->ViewValue = $this->category_id->CurrentValue;
            $this->category_id->ViewValue = FormatNumber($this->category_id->ViewValue, $this->category_id->formatPattern());
            $this->category_id->ViewCustomAttributes = "";

            // min_installment
            $this->min_installment->ViewValue = $this->min_installment->CurrentValue;
            $this->min_installment->ViewValue = FormatNumber($this->min_installment->ViewValue, $this->min_installment->formatPattern());
            $this->min_installment->ViewCustomAttributes = "";

            // max_installment
            $this->max_installment->ViewValue = $this->max_installment->CurrentValue;
            $this->max_installment->ViewValue = FormatNumber($this->max_installment->ViewValue, $this->max_installment->formatPattern());
            $this->max_installment->ViewCustomAttributes = "";

            // attribute_detail_id
            $this->attribute_detail_id->ViewValue = $this->attribute_detail_id->CurrentValue;
            $this->attribute_detail_id->ViewValue = FormatNumber($this->attribute_detail_id->ViewValue, $this->attribute_detail_id->formatPattern());
            $this->attribute_detail_id->ViewCustomAttributes = "";

            // latitude
            $this->latitude->ViewValue = $this->latitude->CurrentValue;
            $this->latitude->ViewCustomAttributes = "";

            // longitude
            $this->longitude->ViewValue = $this->longitude->CurrentValue;
            $this->longitude->ViewCustomAttributes = "";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

            // phone
            $this->phone->ViewValue = $this->phone->CurrentValue;
            $this->phone->ViewCustomAttributes = "";

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

            // first_name
            $this->first_name->ViewValue = $this->first_name->CurrentValue;
            $this->first_name->ViewCustomAttributes = "";

            // last_name
            $this->last_name->ViewValue = $this->last_name->CurrentValue;
            $this->last_name->ViewCustomAttributes = "";

            // save_log_search_nonmember_id
            $this->save_log_search_nonmember_id->LinkCustomAttributes = "";
            $this->save_log_search_nonmember_id->HrefValue = "";

            // category_id
            $this->category_id->LinkCustomAttributes = "";
            $this->category_id->HrefValue = "";

            // min_installment
            $this->min_installment->LinkCustomAttributes = "";
            $this->min_installment->HrefValue = "";

            // max_installment
            $this->max_installment->LinkCustomAttributes = "";
            $this->max_installment->HrefValue = "";

            // attribute_detail_id
            $this->attribute_detail_id->LinkCustomAttributes = "";
            $this->attribute_detail_id->HrefValue = "";

            // latitude
            $this->latitude->LinkCustomAttributes = "";
            $this->latitude->HrefValue = "";

            // longitude
            $this->longitude->LinkCustomAttributes = "";
            $this->longitude->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // phone
            $this->phone->LinkCustomAttributes = "";
            $this->phone->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // first_name
            $this->first_name->LinkCustomAttributes = "";
            $this->first_name->HrefValue = "";

            // last_name
            $this->last_name->LinkCustomAttributes = "";
            $this->last_name->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // save_log_search_nonmember_id
            $this->save_log_search_nonmember_id->setupEditAttributes();
            $this->save_log_search_nonmember_id->EditCustomAttributes = "";
            $this->save_log_search_nonmember_id->EditValue = $this->save_log_search_nonmember_id->CurrentValue;
            $this->save_log_search_nonmember_id->ViewCustomAttributes = "";

            // category_id
            $this->category_id->setupEditAttributes();
            $this->category_id->EditCustomAttributes = "";
            $this->category_id->EditValue = HtmlEncode($this->category_id->CurrentValue);
            $this->category_id->PlaceHolder = RemoveHtml($this->category_id->caption());
            if (strval($this->category_id->EditValue) != "" && is_numeric($this->category_id->EditValue)) {
                $this->category_id->EditValue = FormatNumber($this->category_id->EditValue, null);
            }

            // min_installment
            $this->min_installment->setupEditAttributes();
            $this->min_installment->EditCustomAttributes = "";
            $this->min_installment->EditValue = HtmlEncode($this->min_installment->CurrentValue);
            $this->min_installment->PlaceHolder = RemoveHtml($this->min_installment->caption());
            if (strval($this->min_installment->EditValue) != "" && is_numeric($this->min_installment->EditValue)) {
                $this->min_installment->EditValue = FormatNumber($this->min_installment->EditValue, null);
            }

            // max_installment
            $this->max_installment->setupEditAttributes();
            $this->max_installment->EditCustomAttributes = "";
            $this->max_installment->EditValue = HtmlEncode($this->max_installment->CurrentValue);
            $this->max_installment->PlaceHolder = RemoveHtml($this->max_installment->caption());
            if (strval($this->max_installment->EditValue) != "" && is_numeric($this->max_installment->EditValue)) {
                $this->max_installment->EditValue = FormatNumber($this->max_installment->EditValue, null);
            }

            // attribute_detail_id
            $this->attribute_detail_id->setupEditAttributes();
            $this->attribute_detail_id->EditCustomAttributes = "";
            $this->attribute_detail_id->EditValue = HtmlEncode($this->attribute_detail_id->CurrentValue);
            $this->attribute_detail_id->PlaceHolder = RemoveHtml($this->attribute_detail_id->caption());
            if (strval($this->attribute_detail_id->EditValue) != "" && is_numeric($this->attribute_detail_id->EditValue)) {
                $this->attribute_detail_id->EditValue = FormatNumber($this->attribute_detail_id->EditValue, null);
            }

            // latitude
            $this->latitude->setupEditAttributes();
            $this->latitude->EditCustomAttributes = "";
            $this->latitude->EditValue = HtmlEncode($this->latitude->CurrentValue);
            $this->latitude->PlaceHolder = RemoveHtml($this->latitude->caption());

            // longitude
            $this->longitude->setupEditAttributes();
            $this->longitude->EditCustomAttributes = "";
            $this->longitude->EditValue = HtmlEncode($this->longitude->CurrentValue);
            $this->longitude->PlaceHolder = RemoveHtml($this->longitude->caption());

            // email
            $this->_email->setupEditAttributes();
            $this->_email->EditCustomAttributes = "";
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // phone
            $this->phone->setupEditAttributes();
            $this->phone->EditCustomAttributes = "";
            $this->phone->EditValue = HtmlEncode($this->phone->CurrentValue);
            $this->phone->PlaceHolder = RemoveHtml($this->phone->caption());

            // cdate
            $this->cdate->setupEditAttributes();
            $this->cdate->EditCustomAttributes = "";
            $this->cdate->EditValue = HtmlEncode(FormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern()));
            $this->cdate->PlaceHolder = RemoveHtml($this->cdate->caption());

            // cip
            $this->cip->setupEditAttributes();
            $this->cip->EditCustomAttributes = "";
            if (!$this->cip->Raw) {
                $this->cip->CurrentValue = HtmlDecode($this->cip->CurrentValue);
            }
            $this->cip->EditValue = HtmlEncode($this->cip->CurrentValue);
            $this->cip->PlaceHolder = RemoveHtml($this->cip->caption());

            // cuser
            $this->cuser->setupEditAttributes();
            $this->cuser->EditCustomAttributes = "";
            if (!$this->cuser->Raw) {
                $this->cuser->CurrentValue = HtmlDecode($this->cuser->CurrentValue);
            }
            $this->cuser->EditValue = HtmlEncode($this->cuser->CurrentValue);
            $this->cuser->PlaceHolder = RemoveHtml($this->cuser->caption());

            // first_name
            $this->first_name->setupEditAttributes();
            $this->first_name->EditCustomAttributes = "";
            if (!$this->first_name->Raw) {
                $this->first_name->CurrentValue = HtmlDecode($this->first_name->CurrentValue);
            }
            $this->first_name->EditValue = HtmlEncode($this->first_name->CurrentValue);
            $this->first_name->PlaceHolder = RemoveHtml($this->first_name->caption());

            // last_name
            $this->last_name->setupEditAttributes();
            $this->last_name->EditCustomAttributes = "";
            if (!$this->last_name->Raw) {
                $this->last_name->CurrentValue = HtmlDecode($this->last_name->CurrentValue);
            }
            $this->last_name->EditValue = HtmlEncode($this->last_name->CurrentValue);
            $this->last_name->PlaceHolder = RemoveHtml($this->last_name->caption());

            // Edit refer script

            // save_log_search_nonmember_id
            $this->save_log_search_nonmember_id->LinkCustomAttributes = "";
            $this->save_log_search_nonmember_id->HrefValue = "";

            // category_id
            $this->category_id->LinkCustomAttributes = "";
            $this->category_id->HrefValue = "";

            // min_installment
            $this->min_installment->LinkCustomAttributes = "";
            $this->min_installment->HrefValue = "";

            // max_installment
            $this->max_installment->LinkCustomAttributes = "";
            $this->max_installment->HrefValue = "";

            // attribute_detail_id
            $this->attribute_detail_id->LinkCustomAttributes = "";
            $this->attribute_detail_id->HrefValue = "";

            // latitude
            $this->latitude->LinkCustomAttributes = "";
            $this->latitude->HrefValue = "";

            // longitude
            $this->longitude->LinkCustomAttributes = "";
            $this->longitude->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // phone
            $this->phone->LinkCustomAttributes = "";
            $this->phone->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // first_name
            $this->first_name->LinkCustomAttributes = "";
            $this->first_name->HrefValue = "";

            // last_name
            $this->last_name->LinkCustomAttributes = "";
            $this->last_name->HrefValue = "";
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
        if ($this->save_log_search_nonmember_id->Required) {
            if (!$this->save_log_search_nonmember_id->IsDetailKey && EmptyValue($this->save_log_search_nonmember_id->FormValue)) {
                $this->save_log_search_nonmember_id->addErrorMessage(str_replace("%s", $this->save_log_search_nonmember_id->caption(), $this->save_log_search_nonmember_id->RequiredErrorMessage));
            }
        }
        if ($this->category_id->Required) {
            if (!$this->category_id->IsDetailKey && EmptyValue($this->category_id->FormValue)) {
                $this->category_id->addErrorMessage(str_replace("%s", $this->category_id->caption(), $this->category_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->category_id->FormValue)) {
            $this->category_id->addErrorMessage($this->category_id->getErrorMessage(false));
        }
        if ($this->min_installment->Required) {
            if (!$this->min_installment->IsDetailKey && EmptyValue($this->min_installment->FormValue)) {
                $this->min_installment->addErrorMessage(str_replace("%s", $this->min_installment->caption(), $this->min_installment->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->min_installment->FormValue)) {
            $this->min_installment->addErrorMessage($this->min_installment->getErrorMessage(false));
        }
        if ($this->max_installment->Required) {
            if (!$this->max_installment->IsDetailKey && EmptyValue($this->max_installment->FormValue)) {
                $this->max_installment->addErrorMessage(str_replace("%s", $this->max_installment->caption(), $this->max_installment->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->max_installment->FormValue)) {
            $this->max_installment->addErrorMessage($this->max_installment->getErrorMessage(false));
        }
        if ($this->attribute_detail_id->Required) {
            if (!$this->attribute_detail_id->IsDetailKey && EmptyValue($this->attribute_detail_id->FormValue)) {
                $this->attribute_detail_id->addErrorMessage(str_replace("%s", $this->attribute_detail_id->caption(), $this->attribute_detail_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->attribute_detail_id->FormValue)) {
            $this->attribute_detail_id->addErrorMessage($this->attribute_detail_id->getErrorMessage(false));
        }
        if ($this->latitude->Required) {
            if (!$this->latitude->IsDetailKey && EmptyValue($this->latitude->FormValue)) {
                $this->latitude->addErrorMessage(str_replace("%s", $this->latitude->caption(), $this->latitude->RequiredErrorMessage));
            }
        }
        if ($this->longitude->Required) {
            if (!$this->longitude->IsDetailKey && EmptyValue($this->longitude->FormValue)) {
                $this->longitude->addErrorMessage(str_replace("%s", $this->longitude->caption(), $this->longitude->RequiredErrorMessage));
            }
        }
        if ($this->_email->Required) {
            if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
            }
        }
        if ($this->phone->Required) {
            if (!$this->phone->IsDetailKey && EmptyValue($this->phone->FormValue)) {
                $this->phone->addErrorMessage(str_replace("%s", $this->phone->caption(), $this->phone->RequiredErrorMessage));
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
        if ($this->first_name->Required) {
            if (!$this->first_name->IsDetailKey && EmptyValue($this->first_name->FormValue)) {
                $this->first_name->addErrorMessage(str_replace("%s", $this->first_name->caption(), $this->first_name->RequiredErrorMessage));
            }
        }
        if ($this->last_name->Required) {
            if (!$this->last_name->IsDetailKey && EmptyValue($this->last_name->FormValue)) {
                $this->last_name->addErrorMessage(str_replace("%s", $this->last_name->caption(), $this->last_name->RequiredErrorMessage));
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

            // category_id
            $this->category_id->setDbValueDef($rsnew, $this->category_id->CurrentValue, null, $this->category_id->ReadOnly);

            // min_installment
            $this->min_installment->setDbValueDef($rsnew, $this->min_installment->CurrentValue, null, $this->min_installment->ReadOnly);

            // max_installment
            $this->max_installment->setDbValueDef($rsnew, $this->max_installment->CurrentValue, null, $this->max_installment->ReadOnly);

            // attribute_detail_id
            $this->attribute_detail_id->setDbValueDef($rsnew, $this->attribute_detail_id->CurrentValue, null, $this->attribute_detail_id->ReadOnly);

            // latitude
            $this->latitude->setDbValueDef($rsnew, $this->latitude->CurrentValue, null, $this->latitude->ReadOnly);

            // longitude
            $this->longitude->setDbValueDef($rsnew, $this->longitude->CurrentValue, null, $this->longitude->ReadOnly);

            // email
            $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, $this->_email->ReadOnly);

            // phone
            $this->phone->setDbValueDef($rsnew, $this->phone->CurrentValue, null, $this->phone->ReadOnly);

            // cdate
            $this->cdate->setDbValueDef($rsnew, UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern()), null, $this->cdate->ReadOnly);

            // cip
            $this->cip->setDbValueDef($rsnew, $this->cip->CurrentValue, null, $this->cip->ReadOnly);

            // cuser
            $this->cuser->setDbValueDef($rsnew, $this->cuser->CurrentValue, null, $this->cuser->ReadOnly);

            // first_name
            $this->first_name->setDbValueDef($rsnew, $this->first_name->CurrentValue, "", $this->first_name->ReadOnly);

            // last_name
            $this->last_name->setDbValueDef($rsnew, $this->last_name->CurrentValue, "", $this->last_name->ReadOnly);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("savelogsearchnonmemberlist"), "", $this->TableVar, true);
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
