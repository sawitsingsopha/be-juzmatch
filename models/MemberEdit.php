<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class MemberEdit extends Member
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'member';

    // Page object name
    public $PageObjName = "MemberEdit";

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

        // Table object (member)
        if (!isset($GLOBALS["member"]) || get_class($GLOBALS["member"]) == PROJECT_NAMESPACE . "member") {
            $GLOBALS["member"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'member');
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
                $tbl = Container("member");
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
                    if ($pageName == "memberview") {
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
		        $this->image_profile->OldUploadPath = "./upload/image_profile";
		        $this->image_profile->UploadPath = $this->image_profile->OldUploadPath;
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
            $key .= @$ar['member_id'];
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
            $this->member_id->Visible = false;
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
        $this->member_id->setVisibility();
        $this->first_name->setVisibility();
        $this->last_name->setVisibility();
        $this->idcardnumber->Visible = false;
        $this->_email->setVisibility();
        $this->phone->setVisibility();
        $this->facebook_id->setVisibility();
        $this->line_id->setVisibility();
        $this->google_id->setVisibility();
        $this->_password->Visible = false;
        $this->type->setVisibility();
        $this->isactive->setVisibility();
        $this->isbuyer->setVisibility();
        $this->isinvertor->setVisibility();
        $this->issale->setVisibility();
        $this->isnotification->setVisibility();
        $this->code_phone->Visible = false;
        $this->image_profile->setVisibility();
        $this->customer_id->Visible = false;
        $this->verify_key->Visible = false;
        $this->verify_status->Visible = false;
        $this->verify_date->Visible = false;
        $this->verify_ip->Visible = false;
        $this->reset_password_date->Visible = false;
        $this->reset_password_ip->Visible = false;
        $this->reset_password_email_code->Visible = false;
        $this->reset_password_email_date->Visible = false;
        $this->reset_password_email_ip->Visible = false;
        $this->resetTimestamp->Visible = false;
        $this->resetKeyTimestamp->Visible = false;
        $this->reset_password_code->Visible = false;
        $this->pipedrive_people_id->Visible = false;
        $this->last_login->Visible = false;
        $this->cdate->Visible = false;
        $this->cip->Visible = false;
        $this->cuser->Visible = false;
        $this->udate->Visible = false;
        $this->uip->Visible = false;
        $this->uuser->Visible = false;
        $this->verify_phone_status->Visible = false;
        $this->verify_phone_date->Visible = false;
        $this->verify_phone_ip->Visible = false;
        $this->is_peak_contact->Visible = false;
        $this->last_change_password->Visible = false;
        $this->hideFieldsForAddEdit();
        $this->type->Required = false;

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
        $this->setupLookupOptions($this->type);
        $this->setupLookupOptions($this->isactive);
        $this->setupLookupOptions($this->isbuyer);
        $this->setupLookupOptions($this->isinvertor);
        $this->setupLookupOptions($this->issale);
        $this->setupLookupOptions($this->isnotification);

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
            if (($keyValue = Get("member_id") ?? Key(0) ?? Route(2)) !== null) {
                $this->member_id->setQueryStringValue($keyValue);
                $this->member_id->setOldValue($this->member_id->QueryStringValue);
            } elseif (Post("member_id") !== null) {
                $this->member_id->setFormValue(Post("member_id"));
                $this->member_id->setOldValue($this->member_id->FormValue);
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
                if (($keyValue = Get("member_id") ?? Route("member_id")) !== null) {
                    $this->member_id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->member_id->CurrentValue = null;
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
                        $this->terminate("memberlist"); // No matching record, return to list
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
                if (GetPageName($returnUrl) == "memberlist") {
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
        $this->image_profile->Upload->Index = $CurrentForm->Index;
        $this->image_profile->Upload->uploadFile();
        $this->image_profile->CurrentValue = $this->image_profile->Upload->FileName;
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
            $this->member_id->setFormValue($val);
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

        // Check field name 'facebook_id' first before field var 'x_facebook_id'
        $val = $CurrentForm->hasValue("facebook_id") ? $CurrentForm->getValue("facebook_id") : $CurrentForm->getValue("x_facebook_id");
        if (!$this->facebook_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->facebook_id->Visible = false; // Disable update for API request
            } else {
                $this->facebook_id->setFormValue($val);
            }
        }

        // Check field name 'line_id' first before field var 'x_line_id'
        $val = $CurrentForm->hasValue("line_id") ? $CurrentForm->getValue("line_id") : $CurrentForm->getValue("x_line_id");
        if (!$this->line_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->line_id->Visible = false; // Disable update for API request
            } else {
                $this->line_id->setFormValue($val);
            }
        }

        // Check field name 'google_id' first before field var 'x_google_id'
        $val = $CurrentForm->hasValue("google_id") ? $CurrentForm->getValue("google_id") : $CurrentForm->getValue("x_google_id");
        if (!$this->google_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->google_id->Visible = false; // Disable update for API request
            } else {
                $this->google_id->setFormValue($val);
            }
        }

        // Check field name 'type' first before field var 'x_type'
        $val = $CurrentForm->hasValue("type") ? $CurrentForm->getValue("type") : $CurrentForm->getValue("x_type");
        if (!$this->type->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->type->Visible = false; // Disable update for API request
            } else {
                $this->type->setFormValue($val);
            }
        }

        // Check field name 'isactive' first before field var 'x_isactive'
        $val = $CurrentForm->hasValue("isactive") ? $CurrentForm->getValue("isactive") : $CurrentForm->getValue("x_isactive");
        if (!$this->isactive->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isactive->Visible = false; // Disable update for API request
            } else {
                $this->isactive->setFormValue($val);
            }
        }

        // Check field name 'isbuyer' first before field var 'x_isbuyer'
        $val = $CurrentForm->hasValue("isbuyer") ? $CurrentForm->getValue("isbuyer") : $CurrentForm->getValue("x_isbuyer");
        if (!$this->isbuyer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isbuyer->Visible = false; // Disable update for API request
            } else {
                $this->isbuyer->setFormValue($val);
            }
        }

        // Check field name 'isinvertor' first before field var 'x_isinvertor'
        $val = $CurrentForm->hasValue("isinvertor") ? $CurrentForm->getValue("isinvertor") : $CurrentForm->getValue("x_isinvertor");
        if (!$this->isinvertor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isinvertor->Visible = false; // Disable update for API request
            } else {
                $this->isinvertor->setFormValue($val);
            }
        }

        // Check field name 'issale' first before field var 'x_issale'
        $val = $CurrentForm->hasValue("issale") ? $CurrentForm->getValue("issale") : $CurrentForm->getValue("x_issale");
        if (!$this->issale->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->issale->Visible = false; // Disable update for API request
            } else {
                $this->issale->setFormValue($val);
            }
        }

        // Check field name 'isnotification' first before field var 'x_isnotification'
        $val = $CurrentForm->hasValue("isnotification") ? $CurrentForm->getValue("isnotification") : $CurrentForm->getValue("x_isnotification");
        if (!$this->isnotification->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isnotification->Visible = false; // Disable update for API request
            } else {
                $this->isnotification->setFormValue($val);
            }
        }
		$this->image_profile->OldUploadPath = "./upload/image_profile";
		$this->image_profile->UploadPath = $this->image_profile->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->member_id->CurrentValue = $this->member_id->FormValue;
        $this->first_name->CurrentValue = $this->first_name->FormValue;
        $this->last_name->CurrentValue = $this->last_name->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->phone->CurrentValue = $this->phone->FormValue;
        $this->facebook_id->CurrentValue = $this->facebook_id->FormValue;
        $this->line_id->CurrentValue = $this->line_id->FormValue;
        $this->google_id->CurrentValue = $this->google_id->FormValue;
        $this->type->CurrentValue = $this->type->FormValue;
        $this->isactive->CurrentValue = $this->isactive->FormValue;
        $this->isbuyer->CurrentValue = $this->isbuyer->FormValue;
        $this->isinvertor->CurrentValue = $this->isinvertor->FormValue;
        $this->issale->CurrentValue = $this->issale->FormValue;
        $this->isnotification->CurrentValue = $this->isnotification->FormValue;
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
        $this->member_id->setDbValue($row['member_id']);
        $this->first_name->setDbValue($row['first_name']);
        $this->last_name->setDbValue($row['last_name']);
        $this->idcardnumber->setDbValue($row['idcardnumber']);
        $this->_email->setDbValue($row['email']);
        $this->phone->setDbValue($row['phone']);
        $this->facebook_id->setDbValue($row['facebook_id']);
        $this->line_id->setDbValue($row['line_id']);
        $this->google_id->setDbValue($row['google_id']);
        $this->_password->setDbValue($row['password']);
        $this->type->setDbValue($row['type']);
        $this->isactive->setDbValue($row['isactive']);
        $this->isbuyer->setDbValue($row['isbuyer']);
        $this->isinvertor->setDbValue($row['isinvertor']);
        $this->issale->setDbValue($row['issale']);
        $this->isnotification->setDbValue($row['isnotification']);
        $this->code_phone->setDbValue($row['code_phone']);
        $this->image_profile->Upload->DbValue = $row['image_profile'];
        $this->image_profile->setDbValue($this->image_profile->Upload->DbValue);
        $this->customer_id->setDbValue($row['customer_id']);
        $this->verify_key->setDbValue($row['verify_key']);
        $this->verify_status->setDbValue($row['verify_status']);
        $this->verify_date->setDbValue($row['verify_date']);
        $this->verify_ip->setDbValue($row['verify_ip']);
        $this->reset_password_date->setDbValue($row['reset_password_date']);
        $this->reset_password_ip->setDbValue($row['reset_password_ip']);
        $this->reset_password_email_code->setDbValue($row['reset_password_email_code']);
        $this->reset_password_email_date->setDbValue($row['reset_password_email_date']);
        $this->reset_password_email_ip->setDbValue($row['reset_password_email_ip']);
        $this->resetTimestamp->setDbValue($row['resetTimestamp']);
        $this->resetKeyTimestamp->setDbValue($row['resetKeyTimestamp']);
        $this->reset_password_code->setDbValue($row['reset_password_code']);
        $this->pipedrive_people_id->setDbValue($row['pipedrive_people_id']);
        $this->last_login->setDbValue($row['last_login']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cip->setDbValue($row['cip']);
        $this->cuser->setDbValue($row['cuser']);
        $this->udate->setDbValue($row['udate']);
        $this->uip->setDbValue($row['uip']);
        $this->uuser->setDbValue($row['uuser']);
        $this->verify_phone_status->setDbValue($row['verify_phone_status']);
        $this->verify_phone_date->setDbValue($row['verify_phone_date']);
        $this->verify_phone_ip->setDbValue($row['verify_phone_ip']);
        $this->is_peak_contact->setDbValue($row['is_peak_contact']);
        $this->last_change_password->setDbValue($row['last_change_password']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['member_id'] = null;
        $row['first_name'] = null;
        $row['last_name'] = null;
        $row['idcardnumber'] = null;
        $row['email'] = null;
        $row['phone'] = null;
        $row['facebook_id'] = null;
        $row['line_id'] = null;
        $row['google_id'] = null;
        $row['password'] = null;
        $row['type'] = null;
        $row['isactive'] = null;
        $row['isbuyer'] = null;
        $row['isinvertor'] = null;
        $row['issale'] = null;
        $row['isnotification'] = null;
        $row['code_phone'] = null;
        $row['image_profile'] = null;
        $row['customer_id'] = null;
        $row['verify_key'] = null;
        $row['verify_status'] = null;
        $row['verify_date'] = null;
        $row['verify_ip'] = null;
        $row['reset_password_date'] = null;
        $row['reset_password_ip'] = null;
        $row['reset_password_email_code'] = null;
        $row['reset_password_email_date'] = null;
        $row['reset_password_email_ip'] = null;
        $row['resetTimestamp'] = null;
        $row['resetKeyTimestamp'] = null;
        $row['reset_password_code'] = null;
        $row['pipedrive_people_id'] = null;
        $row['last_login'] = null;
        $row['cdate'] = null;
        $row['cip'] = null;
        $row['cuser'] = null;
        $row['udate'] = null;
        $row['uip'] = null;
        $row['uuser'] = null;
        $row['verify_phone_status'] = null;
        $row['verify_phone_date'] = null;
        $row['verify_phone_ip'] = null;
        $row['is_peak_contact'] = null;
        $row['last_change_password'] = null;
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

        // member_id
        $this->member_id->RowCssClass = "row";

        // first_name
        $this->first_name->RowCssClass = "row";

        // last_name
        $this->last_name->RowCssClass = "row";

        // idcardnumber
        $this->idcardnumber->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // phone
        $this->phone->RowCssClass = "row";

        // facebook_id
        $this->facebook_id->RowCssClass = "row";

        // line_id
        $this->line_id->RowCssClass = "row";

        // google_id
        $this->google_id->RowCssClass = "row";

        // password
        $this->_password->RowCssClass = "row";

        // type
        $this->type->RowCssClass = "row";

        // isactive
        $this->isactive->RowCssClass = "row";

        // isbuyer
        $this->isbuyer->RowCssClass = "row";

        // isinvertor
        $this->isinvertor->RowCssClass = "row";

        // issale
        $this->issale->RowCssClass = "row";

        // isnotification
        $this->isnotification->RowCssClass = "row";

        // code_phone
        $this->code_phone->RowCssClass = "row";

        // image_profile
        $this->image_profile->RowCssClass = "row";

        // customer_id
        $this->customer_id->RowCssClass = "row";

        // verify_key
        $this->verify_key->RowCssClass = "row";

        // verify_status
        $this->verify_status->RowCssClass = "row";

        // verify_date
        $this->verify_date->RowCssClass = "row";

        // verify_ip
        $this->verify_ip->RowCssClass = "row";

        // reset_password_date
        $this->reset_password_date->RowCssClass = "row";

        // reset_password_ip
        $this->reset_password_ip->RowCssClass = "row";

        // reset_password_email_code
        $this->reset_password_email_code->RowCssClass = "row";

        // reset_password_email_date
        $this->reset_password_email_date->RowCssClass = "row";

        // reset_password_email_ip
        $this->reset_password_email_ip->RowCssClass = "row";

        // resetTimestamp
        $this->resetTimestamp->RowCssClass = "row";

        // resetKeyTimestamp
        $this->resetKeyTimestamp->RowCssClass = "row";

        // reset_password_code
        $this->reset_password_code->RowCssClass = "row";

        // pipedrive_people_id
        $this->pipedrive_people_id->RowCssClass = "row";

        // last_login
        $this->last_login->RowCssClass = "row";

        // cdate
        $this->cdate->RowCssClass = "row";

        // cip
        $this->cip->RowCssClass = "row";

        // cuser
        $this->cuser->RowCssClass = "row";

        // udate
        $this->udate->RowCssClass = "row";

        // uip
        $this->uip->RowCssClass = "row";

        // uuser
        $this->uuser->RowCssClass = "row";

        // verify_phone_status
        $this->verify_phone_status->RowCssClass = "row";

        // verify_phone_date
        $this->verify_phone_date->RowCssClass = "row";

        // verify_phone_ip
        $this->verify_phone_ip->RowCssClass = "row";

        // is_peak_contact
        $this->is_peak_contact->RowCssClass = "row";

        // last_change_password
        $this->last_change_password->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // member_id
            $this->member_id->ViewValue = $this->member_id->CurrentValue;
            $this->member_id->ViewValue = FormatNumber($this->member_id->ViewValue, $this->member_id->formatPattern());
            $this->member_id->ViewCustomAttributes = "";

            // first_name
            $this->first_name->ViewValue = $this->first_name->CurrentValue;
            $this->first_name->ViewCustomAttributes = "";

            // last_name
            $this->last_name->ViewValue = $this->last_name->CurrentValue;
            $this->last_name->ViewCustomAttributes = "";

            // idcardnumber
            $this->idcardnumber->ViewValue = $this->idcardnumber->CurrentValue;
            $this->idcardnumber->ViewCustomAttributes = "";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

            // phone
            $this->phone->ViewValue = $this->phone->CurrentValue;
            $this->phone->ViewCustomAttributes = "";

            // facebook_id
            $this->facebook_id->ViewValue = $this->facebook_id->CurrentValue;
            $this->facebook_id->ViewCustomAttributes = "";

            // line_id
            $this->line_id->ViewValue = $this->line_id->CurrentValue;
            $this->line_id->ViewCustomAttributes = "";

            // google_id
            $this->google_id->ViewValue = $this->google_id->CurrentValue;
            $this->google_id->ViewCustomAttributes = "";

            // type
            if (strval($this->type->CurrentValue) != "") {
                $this->type->ViewValue = $this->type->optionCaption($this->type->CurrentValue);
            } else {
                $this->type->ViewValue = null;
            }
            $this->type->ViewCustomAttributes = "";

            // isactive
            if (strval($this->isactive->CurrentValue) != "") {
                $this->isactive->ViewValue = $this->isactive->optionCaption($this->isactive->CurrentValue);
            } else {
                $this->isactive->ViewValue = null;
            }
            $this->isactive->ViewCustomAttributes = "";

            // isbuyer
            if (strval($this->isbuyer->CurrentValue) != "") {
                $this->isbuyer->ViewValue = new OptionValues();
                $arwrk = explode(",", strval($this->isbuyer->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->isbuyer->ViewValue->add($this->isbuyer->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->isbuyer->ViewValue = null;
            }
            $this->isbuyer->ViewCustomAttributes = "";

            // isinvertor
            if (strval($this->isinvertor->CurrentValue) != "") {
                $this->isinvertor->ViewValue = new OptionValues();
                $arwrk = explode(",", strval($this->isinvertor->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->isinvertor->ViewValue->add($this->isinvertor->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->isinvertor->ViewValue = null;
            }
            $this->isinvertor->ViewCustomAttributes = "";

            // issale
            if (strval($this->issale->CurrentValue) != "") {
                $this->issale->ViewValue = new OptionValues();
                $arwrk = explode(",", strval($this->issale->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->issale->ViewValue->add($this->issale->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->issale->ViewValue = null;
            }
            $this->issale->ViewCustomAttributes = "";

            // isnotification
            if (strval($this->isnotification->CurrentValue) != "") {
                $this->isnotification->ViewValue = new OptionValues();
                $arwrk = explode(",", strval($this->isnotification->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->isnotification->ViewValue->add($this->isnotification->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->isnotification->ViewValue = null;
            }
            $this->isnotification->ViewCustomAttributes = "";

            // image_profile
            $this->image_profile->UploadPath = "./upload/image_profile";
            if (!EmptyValue($this->image_profile->Upload->DbValue)) {
                $this->image_profile->ImageWidth = 100;
                $this->image_profile->ImageHeight = 0;
                $this->image_profile->ImageAlt = $this->image_profile->alt();
                $this->image_profile->ImageCssClass = "ew-image";
                $this->image_profile->ViewValue = $this->image_profile->Upload->DbValue;
            } else {
                $this->image_profile->ViewValue = "";
            }
            $this->image_profile->ViewCustomAttributes = "";

            // cdate
            $this->cdate->ViewValue = $this->cdate->CurrentValue;
            $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
            $this->cdate->ViewCustomAttributes = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // first_name
            $this->first_name->LinkCustomAttributes = "";
            $this->first_name->HrefValue = "";

            // last_name
            $this->last_name->LinkCustomAttributes = "";
            $this->last_name->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";
            $this->_email->TooltipValue = "";

            // phone
            $this->phone->LinkCustomAttributes = "";
            $this->phone->HrefValue = "";
            $this->phone->TooltipValue = "";

            // facebook_id
            $this->facebook_id->LinkCustomAttributes = "";
            $this->facebook_id->HrefValue = "";
            $this->facebook_id->TooltipValue = "";

            // line_id
            $this->line_id->LinkCustomAttributes = "";
            $this->line_id->HrefValue = "";
            $this->line_id->TooltipValue = "";

            // google_id
            $this->google_id->LinkCustomAttributes = "";
            $this->google_id->HrefValue = "";
            $this->google_id->TooltipValue = "";

            // type
            $this->type->LinkCustomAttributes = "";
            $this->type->HrefValue = "";
            $this->type->TooltipValue = "";

            // isactive
            $this->isactive->LinkCustomAttributes = "";
            $this->isactive->HrefValue = "";

            // isbuyer
            $this->isbuyer->LinkCustomAttributes = "";
            $this->isbuyer->HrefValue = "";

            // isinvertor
            $this->isinvertor->LinkCustomAttributes = "";
            $this->isinvertor->HrefValue = "";

            // issale
            $this->issale->LinkCustomAttributes = "";
            $this->issale->HrefValue = "";

            // isnotification
            $this->isnotification->LinkCustomAttributes = "";
            $this->isnotification->HrefValue = "";

            // image_profile
            $this->image_profile->LinkCustomAttributes = "";
            $this->image_profile->UploadPath = "./upload/image_profile";
            if (!EmptyValue($this->image_profile->Upload->DbValue)) {
                $this->image_profile->HrefValue = GetFileUploadUrl($this->image_profile, $this->image_profile->htmlDecode($this->image_profile->Upload->DbValue)); // Add prefix/suffix
                $this->image_profile->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->image_profile->HrefValue = FullUrl($this->image_profile->HrefValue, "href");
                }
            } else {
                $this->image_profile->HrefValue = "";
            }
            $this->image_profile->ExportHrefValue = $this->image_profile->UploadPath . $this->image_profile->Upload->DbValue;
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // member_id
            $this->member_id->setupEditAttributes();
            $this->member_id->EditCustomAttributes = "";
            $this->member_id->EditValue = $this->member_id->CurrentValue;
            $this->member_id->EditValue = FormatNumber($this->member_id->EditValue, $this->member_id->formatPattern());
            $this->member_id->ViewCustomAttributes = "";

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

            // email
            $this->_email->setupEditAttributes();
            $this->_email->EditCustomAttributes = "";
            $this->_email->EditValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

            // phone
            $this->phone->setupEditAttributes();
            $this->phone->EditCustomAttributes = "";
            $this->phone->EditValue = $this->phone->CurrentValue;
            $this->phone->ViewCustomAttributes = "";

            // facebook_id
            $this->facebook_id->setupEditAttributes();
            $this->facebook_id->EditCustomAttributes = "";
            $this->facebook_id->EditValue = $this->facebook_id->CurrentValue;
            $this->facebook_id->ViewCustomAttributes = "";

            // line_id
            $this->line_id->setupEditAttributes();
            $this->line_id->EditCustomAttributes = "";
            $this->line_id->EditValue = $this->line_id->CurrentValue;
            $this->line_id->ViewCustomAttributes = "";

            // google_id
            $this->google_id->setupEditAttributes();
            $this->google_id->EditCustomAttributes = "";
            $this->google_id->EditValue = $this->google_id->CurrentValue;
            $this->google_id->ViewCustomAttributes = "";

            // type
            $this->type->setupEditAttributes();
            $this->type->EditCustomAttributes = "";
            if (strval($this->type->CurrentValue) != "") {
                $this->type->EditValue = $this->type->optionCaption($this->type->CurrentValue);
            } else {
                $this->type->EditValue = null;
            }
            $this->type->ViewCustomAttributes = "";

            // isactive
            $this->isactive->EditCustomAttributes = "";
            $this->isactive->EditValue = $this->isactive->options(false);
            $this->isactive->PlaceHolder = RemoveHtml($this->isactive->caption());

            // isbuyer
            $this->isbuyer->EditCustomAttributes = "";
            $this->isbuyer->EditValue = $this->isbuyer->options(false);
            $this->isbuyer->PlaceHolder = RemoveHtml($this->isbuyer->caption());

            // isinvertor
            $this->isinvertor->EditCustomAttributes = "";
            $this->isinvertor->EditValue = $this->isinvertor->options(false);
            $this->isinvertor->PlaceHolder = RemoveHtml($this->isinvertor->caption());

            // issale
            $this->issale->EditCustomAttributes = "";
            $this->issale->EditValue = $this->issale->options(false);
            $this->issale->PlaceHolder = RemoveHtml($this->issale->caption());

            // isnotification
            $this->isnotification->EditCustomAttributes = "";
            $this->isnotification->EditValue = $this->isnotification->options(false);
            $this->isnotification->PlaceHolder = RemoveHtml($this->isnotification->caption());

            // image_profile
            $this->image_profile->setupEditAttributes();
            $this->image_profile->EditCustomAttributes = "";
            $this->image_profile->UploadPath = "./upload/image_profile";
            if (!EmptyValue($this->image_profile->Upload->DbValue)) {
                $this->image_profile->ImageWidth = 100;
                $this->image_profile->ImageHeight = 0;
                $this->image_profile->ImageAlt = $this->image_profile->alt();
                $this->image_profile->ImageCssClass = "ew-image";
                $this->image_profile->EditValue = $this->image_profile->Upload->DbValue;
            } else {
                $this->image_profile->EditValue = "";
            }
            if (!EmptyValue($this->image_profile->CurrentValue)) {
                $this->image_profile->Upload->FileName = $this->image_profile->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->image_profile);
            }

            // Edit refer script

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // first_name
            $this->first_name->LinkCustomAttributes = "";
            $this->first_name->HrefValue = "";

            // last_name
            $this->last_name->LinkCustomAttributes = "";
            $this->last_name->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";
            $this->_email->TooltipValue = "";

            // phone
            $this->phone->LinkCustomAttributes = "";
            $this->phone->HrefValue = "";
            $this->phone->TooltipValue = "";

            // facebook_id
            $this->facebook_id->LinkCustomAttributes = "";
            $this->facebook_id->HrefValue = "";
            $this->facebook_id->TooltipValue = "";

            // line_id
            $this->line_id->LinkCustomAttributes = "";
            $this->line_id->HrefValue = "";
            $this->line_id->TooltipValue = "";

            // google_id
            $this->google_id->LinkCustomAttributes = "";
            $this->google_id->HrefValue = "";
            $this->google_id->TooltipValue = "";

            // type
            $this->type->LinkCustomAttributes = "";
            $this->type->HrefValue = "";
            $this->type->TooltipValue = "";

            // isactive
            $this->isactive->LinkCustomAttributes = "";
            $this->isactive->HrefValue = "";

            // isbuyer
            $this->isbuyer->LinkCustomAttributes = "";
            $this->isbuyer->HrefValue = "";

            // isinvertor
            $this->isinvertor->LinkCustomAttributes = "";
            $this->isinvertor->HrefValue = "";

            // issale
            $this->issale->LinkCustomAttributes = "";
            $this->issale->HrefValue = "";

            // isnotification
            $this->isnotification->LinkCustomAttributes = "";
            $this->isnotification->HrefValue = "";

            // image_profile
            $this->image_profile->LinkCustomAttributes = "";
            $this->image_profile->UploadPath = "./upload/image_profile";
            if (!EmptyValue($this->image_profile->Upload->DbValue)) {
                $this->image_profile->HrefValue = GetFileUploadUrl($this->image_profile, $this->image_profile->htmlDecode($this->image_profile->Upload->DbValue)); // Add prefix/suffix
                $this->image_profile->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->image_profile->HrefValue = FullUrl($this->image_profile->HrefValue, "href");
                }
            } else {
                $this->image_profile->HrefValue = "";
            }
            $this->image_profile->ExportHrefValue = $this->image_profile->UploadPath . $this->image_profile->Upload->DbValue;
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
        if ($this->facebook_id->Required) {
            if (!$this->facebook_id->IsDetailKey && EmptyValue($this->facebook_id->FormValue)) {
                $this->facebook_id->addErrorMessage(str_replace("%s", $this->facebook_id->caption(), $this->facebook_id->RequiredErrorMessage));
            }
        }
        if ($this->line_id->Required) {
            if (!$this->line_id->IsDetailKey && EmptyValue($this->line_id->FormValue)) {
                $this->line_id->addErrorMessage(str_replace("%s", $this->line_id->caption(), $this->line_id->RequiredErrorMessage));
            }
        }
        if ($this->google_id->Required) {
            if (!$this->google_id->IsDetailKey && EmptyValue($this->google_id->FormValue)) {
                $this->google_id->addErrorMessage(str_replace("%s", $this->google_id->caption(), $this->google_id->RequiredErrorMessage));
            }
        }
        if ($this->type->Required) {
            if (!$this->type->IsDetailKey && EmptyValue($this->type->FormValue)) {
                $this->type->addErrorMessage(str_replace("%s", $this->type->caption(), $this->type->RequiredErrorMessage));
            }
        }
        if ($this->isactive->Required) {
            if ($this->isactive->FormValue == "") {
                $this->isactive->addErrorMessage(str_replace("%s", $this->isactive->caption(), $this->isactive->RequiredErrorMessage));
            }
        }
        if ($this->isbuyer->Required) {
            if ($this->isbuyer->FormValue == "") {
                $this->isbuyer->addErrorMessage(str_replace("%s", $this->isbuyer->caption(), $this->isbuyer->RequiredErrorMessage));
            }
        }
        if ($this->isinvertor->Required) {
            if ($this->isinvertor->FormValue == "") {
                $this->isinvertor->addErrorMessage(str_replace("%s", $this->isinvertor->caption(), $this->isinvertor->RequiredErrorMessage));
            }
        }
        if ($this->issale->Required) {
            if ($this->issale->FormValue == "") {
                $this->issale->addErrorMessage(str_replace("%s", $this->issale->caption(), $this->issale->RequiredErrorMessage));
            }
        }
        if ($this->isnotification->Required) {
            if ($this->isnotification->FormValue == "") {
                $this->isnotification->addErrorMessage(str_replace("%s", $this->isnotification->caption(), $this->isnotification->RequiredErrorMessage));
            }
        }
        if ($this->image_profile->Required) {
            if ($this->image_profile->Upload->FileName == "" && !$this->image_profile->Upload->KeepFile) {
                $this->image_profile->addErrorMessage(str_replace("%s", $this->image_profile->caption(), $this->image_profile->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("AddressGrid");
        if (in_array("address", $detailTblVar) && $detailPage->DetailEdit) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("AssetFavoriteGrid");
        if (in_array("asset_favorite", $detailTblVar) && $detailPage->DetailEdit) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("AppointmentGrid");
        if (in_array("appointment", $detailTblVar) && $detailPage->DetailEdit) {
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
            $this->image_profile->OldUploadPath = "./upload/image_profile";
            $this->image_profile->UploadPath = $this->image_profile->OldUploadPath;
            $rsnew = [];

            // first_name
            $this->first_name->setDbValueDef($rsnew, $this->first_name->CurrentValue, null, $this->first_name->ReadOnly);

            // last_name
            $this->last_name->setDbValueDef($rsnew, $this->last_name->CurrentValue, null, $this->last_name->ReadOnly);

            // isactive
            $this->isactive->setDbValueDef($rsnew, $this->isactive->CurrentValue, null, $this->isactive->ReadOnly);

            // isbuyer
            $this->isbuyer->setDbValueDef($rsnew, $this->isbuyer->CurrentValue, null, $this->isbuyer->ReadOnly);

            // isinvertor
            $this->isinvertor->setDbValueDef($rsnew, $this->isinvertor->CurrentValue, null, $this->isinvertor->ReadOnly);

            // issale
            $this->issale->setDbValueDef($rsnew, $this->issale->CurrentValue, null, $this->issale->ReadOnly);

            // isnotification
            $this->isnotification->setDbValueDef($rsnew, $this->isnotification->CurrentValue, null, $this->isnotification->ReadOnly);

            // image_profile
            if ($this->image_profile->Visible && !$this->image_profile->ReadOnly && !$this->image_profile->Upload->KeepFile) {
                $this->image_profile->Upload->DbValue = $rsold['image_profile']; // Get original value
                if ($this->image_profile->Upload->FileName == "") {
                    $rsnew['image_profile'] = null;
                } else {
                    $rsnew['image_profile'] = $this->image_profile->Upload->FileName;
                }
            }
            if ($this->image_profile->Visible && !$this->image_profile->Upload->KeepFile) {
                $this->image_profile->UploadPath = "./upload/image_profile";
                $oldFiles = EmptyValue($this->image_profile->Upload->DbValue) ? [] : [$this->image_profile->htmlDecode($this->image_profile->Upload->DbValue)];
                if (!EmptyValue($this->image_profile->Upload->FileName)) {
                    $newFiles = [$this->image_profile->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->image_profile, $this->image_profile->Upload->Index);
                            if (file_exists($tempPath . $file)) {
                                if (Config("DELETE_UPLOADED_FILES")) {
                                    $oldFileFound = false;
                                    $oldFileCount = count($oldFiles);
                                    for ($j = 0; $j < $oldFileCount; $j++) {
                                        $oldFile = $oldFiles[$j];
                                        if ($oldFile == $file) { // Old file found, no need to delete anymore
                                            array_splice($oldFiles, $j, 1);
                                            $oldFileFound = true;
                                            break;
                                        }
                                    }
                                    if ($oldFileFound) { // No need to check if file exists further
                                        continue;
                                    }
                                }
                                $file1 = UniqueFilename($this->image_profile->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->image_profile->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->image_profile->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->image_profile->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->image_profile->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->image_profile->setDbValueDef($rsnew, $this->image_profile->Upload->FileName, "", $this->image_profile->ReadOnly);
                }
            }

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    $editRow = $this->update($rsnew, "", $rsold);
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                    if ($this->image_profile->Visible && !$this->image_profile->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->image_profile->Upload->DbValue) ? [] : [$this->image_profile->htmlDecode($this->image_profile->Upload->DbValue)];
                        if (!EmptyValue($this->image_profile->Upload->FileName)) {
                            $newFiles = [$this->image_profile->Upload->FileName];
                            $newFiles2 = [$this->image_profile->htmlDecode($rsnew['image_profile'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->image_profile, $this->image_profile->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->image_profile->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                            $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                            return false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $newFiles = [];
                        }
                        if (Config("DELETE_UPLOADED_FILES")) {
                            foreach ($oldFiles as $oldFile) {
                                if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                    @unlink($this->image_profile->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                }

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("AddressGrid");
                    if (in_array("address", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "address"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("AssetFavoriteGrid");
                    if (in_array("asset_favorite", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "asset_favorite"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("AppointmentGrid");
                    if (in_array("appointment", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "appointment"); // Load user level of detail table
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
            // image_profile
            CleanUploadTempPath($this->image_profile, $this->image_profile->Upload->Index);
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
            if (in_array("address", $detailTblVar)) {
                $detailPageObj = Container("AddressGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->member_id->IsDetailKey = true;
                    $detailPageObj->member_id->CurrentValue = $this->member_id->CurrentValue;
                    $detailPageObj->member_id->setSessionValue($detailPageObj->member_id->CurrentValue);
                }
            }
            if (in_array("asset_favorite", $detailTblVar)) {
                $detailPageObj = Container("AssetFavoriteGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->member_id->IsDetailKey = true;
                    $detailPageObj->member_id->CurrentValue = $this->member_id->CurrentValue;
                    $detailPageObj->member_id->setSessionValue($detailPageObj->member_id->CurrentValue);
                }
            }
            if (in_array("appointment", $detailTblVar)) {
                $detailPageObj = Container("AppointmentGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->member_id->IsDetailKey = true;
                    $detailPageObj->member_id->CurrentValue = $this->member_id->CurrentValue;
                    $detailPageObj->member_id->setSessionValue($detailPageObj->member_id->CurrentValue);
                    $detailPageObj->asset_id->setSessionValue(""); // Clear session key
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("memberlist"), "", $this->TableVar, true);
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
                case "x_type":
                    break;
                case "x_isactive":
                    break;
                case "x_isbuyer":
                    break;
                case "x_isinvertor":
                    break;
                case "x_issale":
                    break;
                case "x_isnotification":
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
