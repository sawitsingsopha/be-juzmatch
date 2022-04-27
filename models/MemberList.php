<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class MemberList extends Member
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'member';

    // Page object name
    public $PageObjName = "MemberList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fmemberlist";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "memberadd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "memberdelete";
        $this->MultiUpdateUrl = "memberupdate";

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

        // List options
        $this->ListOptions = new ListOptions(["Tag" => "td", "TableVar" => $this->TableVar]);

        // Export options
        $this->ExportOptions = new ListOptions(["TagClassName" => "ew-export-option"]);

        // Import options
        $this->ImportOptions = new ListOptions(["TagClassName" => "ew-import-option"]);

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }

        // Grid-Add/Edit
        $this->OtherOptions["addedit"] = new ListOptions([
            "TagClassName" => "ew-add-edit-option",
            "UseDropDownButton" => false,
            "DropDownButtonPhrase" => $Language->phrase("ButtonAddEdit"),
            "UseButtonGroup" => true
        ]);

        // Detail tables
        $this->OtherOptions["detail"] = new ListOptions(["TagClassName" => "ew-detail-option"]);
        // Actions
        $this->OtherOptions["action"] = new ListOptions(["TagClassName" => "ew-action-option"]);

        // Column visibility
        $this->OtherOptions["column"] = new ListOptions([
            "TableVar" => $this->TableVar,
            "TagClassName" => "ew-column-option",
            "ButtonGroupClass" => "ew-column-dropdown",
            "UseDropDownButton" => true,
            "DropDownButtonPhrase" => $Language->phrase("Columns"),
            "DropDownAutoClose" => "outside",
            "UseButtonGroup" => false
        ]);

        // Filter options
        $this->FilterOptions = new ListOptions(["TagClassName" => "ew-filter-option"]);

        // List actions
        $this->ListActions = new ListActions();
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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
                        if ($fld->DataType == DATATYPE_MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
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
        if ($this->isAddOrEdit()) {
            $this->cdate->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->cip->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->cuser->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->udate->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->uip->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->uuser->Visible = false;
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

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $DisplayRecords = 25;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = ""; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $MultiColumnGridClass = "row-cols-md";
    public $MultiColumnEditClass = "col-12 w-100";
    public $MultiColumnCardClass = "card h-100 ew-card";
    public $MultiColumnListOptionsPosition = "bottom-start";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $UserAction; // User action
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Multi column button position
        $this->MultiColumnListOptionsPosition = Config("MULTI_COLUMN_LIST_OPTIONS_POSITION");

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Update last accessed time
        if (!IsSysAdmin() && !$UserProfile->isValidUser(CurrentUserName(), session_id())) {
            Write($Language->phrase("UserProfileCorrupted"));
            $this->terminate();
            return;
        }

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        } elseif (IsPost()) {
            if (Post("exporttype") !== null) {
                $this->Export = Post("exporttype");
            }
            $custom = Post("custom", "");
        } elseif (Get("cmd") == "json") {
            $this->Export = Get("cmd");
        } else {
            $this->setExportReturnUrl(CurrentUrl());
        }
        $ExportFileName = $this->TableVar; // Get export file, used in header

        // Get custom export parameters
        if ($this->isExport() && $custom != "") {
            $this->CustomExport = $this->Export;
            $this->Export = "print";
        }
        $CustomExportType = $this->CustomExport;
        $ExportType = $this->Export; // Get export parameter, used in header
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();

        // Setup export options
        $this->setupExportOptions();
        $this->member_id->Visible = false;
        $this->first_name->setVisibility();
        $this->last_name->setVisibility();
        $this->idcardnumber->setVisibility();
        $this->_email->setVisibility();
        $this->phone->setVisibility();
        $this->facebook_id->Visible = false;
        $this->line_id->Visible = false;
        $this->google_id->Visible = false;
        $this->_password->Visible = false;
        $this->type->Visible = false;
        $this->isactive->Visible = false;
        $this->isbuyer->setVisibility();
        $this->isinvertor->setVisibility();
        $this->issale->setVisibility();
        $this->isnotification->Visible = false;
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
        $this->cdate->setVisibility();
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

        // Setup other options
        $this->setupOtherOptions();

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->type);
        $this->setupLookupOptions($this->isactive);
        $this->setupLookupOptions($this->isbuyer);
        $this->setupLookupOptions($this->isinvertor);
        $this->setupLookupOptions($this->issale);
        $this->setupLookupOptions($this->isnotification);

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Process list action first
            if ($this->processListAction()) { // Ajax request
                $this->terminate();
                return;
            }

            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Set up Breadcrumb
            if (!$this->isExport()) {
                $this->setupBreadcrumb();
            }

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
                $this->ListOptions->hideAllOptions();
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            }

            // Hide options
            if ($this->isExport() || $this->CurrentAction) {
                $this->ExportOptions->hideAllOptions();
                $this->FilterOptions->hideAllOptions();
                $this->ImportOptions->hideAllOptions();
            }

            // Hide other options
            if ($this->isExport()) {
                $this->OtherOptions->hideAllOptions();
            }

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(true));

            // Get and validate search values for advanced search
            if (EmptyValue($this->UserAction)) { // Skip if user action
                $this->loadSearchValues();
            }

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
            }
            if (!$this->validateSearch()) {
                // Nothing to do
            }

            // Restore search parms from Session if not searching / reset / export
            if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
                $this->restoreSearchParms();
            }

            // Call Recordset SearchValidated event
            $this->recordsetSearchValidated();

            // Set up sorting order
            $this->setupSortOrder();

            // Get search criteria for advanced search
            if (!$this->hasInvalidFields()) {
                $srchAdvanced = $this->advancedSearchWhere();
            }
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 25; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms()) {
            // Load advanced search from default
            if ($this->loadAdvancedSearchDefault()) {
                $srchAdvanced = $this->advancedSearchWhere();
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Build search criteria
        AddFilter($this->SearchWhere, $srchAdvanced);
        AddFilter($this->SearchWhere, $srchBasic);

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json") {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }

        // Export data only
        if (!$this->CustomExport && in_array($this->Export, array_keys(Config("EXPORT_CLASSES")))) {
            $this->exportData();
            $this->terminate();
            return;
        }
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if (!$this->CurrentAction && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }

            // Audit trail on search
            if ($this->AuditTrailOnSearch && $this->Command == "search" && !$this->RestoreSearch) {
                $searchParm = ServerVar("QUERY_STRING");
                $searchSql = $this->getSessionWhere();
                $this->writeAuditTrailOnSearch($searchParm, $searchSql);
            }
        }

        // Set up list action columns
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Allow) {
                if ($listaction->Select == ACTION_MULTIPLE) { // Show checkbox column if multiple action
                    $this->ListOptions["checkbox"]->Visible = true;
                } elseif ($listaction->Select == ACTION_SINGLE) { // Show list action column
                        $this->ListOptions["listactions"]->Visible = true; // Set visible if any list action is allowed
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new NumericPager($this->TableVar, $this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

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

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 25; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Load server side filters
        if (Config("SEARCH_FILTER_OPTION") == "Server" && isset($UserProfile)) {
            $savedFilterList = $UserProfile->getSearchFilters(CurrentUserName(), "fmembersrch");
        }
        $filterList = Concat($filterList, $this->member_id->AdvancedSearch->toJson(), ","); // Field member_id
        $filterList = Concat($filterList, $this->first_name->AdvancedSearch->toJson(), ","); // Field first_name
        $filterList = Concat($filterList, $this->last_name->AdvancedSearch->toJson(), ","); // Field last_name
        $filterList = Concat($filterList, $this->idcardnumber->AdvancedSearch->toJson(), ","); // Field idcardnumber
        $filterList = Concat($filterList, $this->_email->AdvancedSearch->toJson(), ","); // Field email
        $filterList = Concat($filterList, $this->phone->AdvancedSearch->toJson(), ","); // Field phone
        $filterList = Concat($filterList, $this->facebook_id->AdvancedSearch->toJson(), ","); // Field facebook_id
        $filterList = Concat($filterList, $this->line_id->AdvancedSearch->toJson(), ","); // Field line_id
        $filterList = Concat($filterList, $this->google_id->AdvancedSearch->toJson(), ","); // Field google_id
        $filterList = Concat($filterList, $this->type->AdvancedSearch->toJson(), ","); // Field type
        $filterList = Concat($filterList, $this->isactive->AdvancedSearch->toJson(), ","); // Field isactive
        $filterList = Concat($filterList, $this->isbuyer->AdvancedSearch->toJson(), ","); // Field isbuyer
        $filterList = Concat($filterList, $this->isinvertor->AdvancedSearch->toJson(), ","); // Field isinvertor
        $filterList = Concat($filterList, $this->issale->AdvancedSearch->toJson(), ","); // Field issale
        $filterList = Concat($filterList, $this->isnotification->AdvancedSearch->toJson(), ","); // Field isnotification
        $filterList = Concat($filterList, $this->image_profile->AdvancedSearch->toJson(), ","); // Field image_profile
        $filterList = Concat($filterList, $this->customer_id->AdvancedSearch->toJson(), ","); // Field customer_id
        $filterList = Concat($filterList, $this->verify_key->AdvancedSearch->toJson(), ","); // Field verify_key
        $filterList = Concat($filterList, $this->verify_status->AdvancedSearch->toJson(), ","); // Field verify_status
        $filterList = Concat($filterList, $this->verify_date->AdvancedSearch->toJson(), ","); // Field verify_date
        $filterList = Concat($filterList, $this->verify_ip->AdvancedSearch->toJson(), ","); // Field verify_ip
        $filterList = Concat($filterList, $this->reset_password_date->AdvancedSearch->toJson(), ","); // Field reset_password_date
        $filterList = Concat($filterList, $this->reset_password_ip->AdvancedSearch->toJson(), ","); // Field reset_password_ip
        $filterList = Concat($filterList, $this->reset_password_email_code->AdvancedSearch->toJson(), ","); // Field reset_password_email_code
        $filterList = Concat($filterList, $this->reset_password_email_date->AdvancedSearch->toJson(), ","); // Field reset_password_email_date
        $filterList = Concat($filterList, $this->reset_password_email_ip->AdvancedSearch->toJson(), ","); // Field reset_password_email_ip
        $filterList = Concat($filterList, $this->resetTimestamp->AdvancedSearch->toJson(), ","); // Field resetTimestamp
        $filterList = Concat($filterList, $this->resetKeyTimestamp->AdvancedSearch->toJson(), ","); // Field resetKeyTimestamp
        $filterList = Concat($filterList, $this->reset_password_code->AdvancedSearch->toJson(), ","); // Field reset_password_code
        $filterList = Concat($filterList, $this->pipedrive_people_id->AdvancedSearch->toJson(), ","); // Field pipedrive_people_id
        $filterList = Concat($filterList, $this->cdate->AdvancedSearch->toJson(), ","); // Field cdate
        $filterList = Concat($filterList, $this->cip->AdvancedSearch->toJson(), ","); // Field cip
        $filterList = Concat($filterList, $this->cuser->AdvancedSearch->toJson(), ","); // Field cuser
        $filterList = Concat($filterList, $this->udate->AdvancedSearch->toJson(), ","); // Field udate
        $filterList = Concat($filterList, $this->uip->AdvancedSearch->toJson(), ","); // Field uip
        $filterList = Concat($filterList, $this->uuser->AdvancedSearch->toJson(), ","); // Field uuser

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        global $UserProfile;
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            $UserProfile->setSearchFilters(CurrentUserName(), "fmembersrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field member_id
        $this->member_id->AdvancedSearch->SearchValue = @$filter["x_member_id"];
        $this->member_id->AdvancedSearch->SearchOperator = @$filter["z_member_id"];
        $this->member_id->AdvancedSearch->SearchCondition = @$filter["v_member_id"];
        $this->member_id->AdvancedSearch->SearchValue2 = @$filter["y_member_id"];
        $this->member_id->AdvancedSearch->SearchOperator2 = @$filter["w_member_id"];
        $this->member_id->AdvancedSearch->save();

        // Field first_name
        $this->first_name->AdvancedSearch->SearchValue = @$filter["x_first_name"];
        $this->first_name->AdvancedSearch->SearchOperator = @$filter["z_first_name"];
        $this->first_name->AdvancedSearch->SearchCondition = @$filter["v_first_name"];
        $this->first_name->AdvancedSearch->SearchValue2 = @$filter["y_first_name"];
        $this->first_name->AdvancedSearch->SearchOperator2 = @$filter["w_first_name"];
        $this->first_name->AdvancedSearch->save();

        // Field last_name
        $this->last_name->AdvancedSearch->SearchValue = @$filter["x_last_name"];
        $this->last_name->AdvancedSearch->SearchOperator = @$filter["z_last_name"];
        $this->last_name->AdvancedSearch->SearchCondition = @$filter["v_last_name"];
        $this->last_name->AdvancedSearch->SearchValue2 = @$filter["y_last_name"];
        $this->last_name->AdvancedSearch->SearchOperator2 = @$filter["w_last_name"];
        $this->last_name->AdvancedSearch->save();

        // Field idcardnumber
        $this->idcardnumber->AdvancedSearch->SearchValue = @$filter["x_idcardnumber"];
        $this->idcardnumber->AdvancedSearch->SearchOperator = @$filter["z_idcardnumber"];
        $this->idcardnumber->AdvancedSearch->SearchCondition = @$filter["v_idcardnumber"];
        $this->idcardnumber->AdvancedSearch->SearchValue2 = @$filter["y_idcardnumber"];
        $this->idcardnumber->AdvancedSearch->SearchOperator2 = @$filter["w_idcardnumber"];
        $this->idcardnumber->AdvancedSearch->save();

        // Field email
        $this->_email->AdvancedSearch->SearchValue = @$filter["x__email"];
        $this->_email->AdvancedSearch->SearchOperator = @$filter["z__email"];
        $this->_email->AdvancedSearch->SearchCondition = @$filter["v__email"];
        $this->_email->AdvancedSearch->SearchValue2 = @$filter["y__email"];
        $this->_email->AdvancedSearch->SearchOperator2 = @$filter["w__email"];
        $this->_email->AdvancedSearch->save();

        // Field phone
        $this->phone->AdvancedSearch->SearchValue = @$filter["x_phone"];
        $this->phone->AdvancedSearch->SearchOperator = @$filter["z_phone"];
        $this->phone->AdvancedSearch->SearchCondition = @$filter["v_phone"];
        $this->phone->AdvancedSearch->SearchValue2 = @$filter["y_phone"];
        $this->phone->AdvancedSearch->SearchOperator2 = @$filter["w_phone"];
        $this->phone->AdvancedSearch->save();

        // Field facebook_id
        $this->facebook_id->AdvancedSearch->SearchValue = @$filter["x_facebook_id"];
        $this->facebook_id->AdvancedSearch->SearchOperator = @$filter["z_facebook_id"];
        $this->facebook_id->AdvancedSearch->SearchCondition = @$filter["v_facebook_id"];
        $this->facebook_id->AdvancedSearch->SearchValue2 = @$filter["y_facebook_id"];
        $this->facebook_id->AdvancedSearch->SearchOperator2 = @$filter["w_facebook_id"];
        $this->facebook_id->AdvancedSearch->save();

        // Field line_id
        $this->line_id->AdvancedSearch->SearchValue = @$filter["x_line_id"];
        $this->line_id->AdvancedSearch->SearchOperator = @$filter["z_line_id"];
        $this->line_id->AdvancedSearch->SearchCondition = @$filter["v_line_id"];
        $this->line_id->AdvancedSearch->SearchValue2 = @$filter["y_line_id"];
        $this->line_id->AdvancedSearch->SearchOperator2 = @$filter["w_line_id"];
        $this->line_id->AdvancedSearch->save();

        // Field google_id
        $this->google_id->AdvancedSearch->SearchValue = @$filter["x_google_id"];
        $this->google_id->AdvancedSearch->SearchOperator = @$filter["z_google_id"];
        $this->google_id->AdvancedSearch->SearchCondition = @$filter["v_google_id"];
        $this->google_id->AdvancedSearch->SearchValue2 = @$filter["y_google_id"];
        $this->google_id->AdvancedSearch->SearchOperator2 = @$filter["w_google_id"];
        $this->google_id->AdvancedSearch->save();

        // Field type
        $this->type->AdvancedSearch->SearchValue = @$filter["x_type"];
        $this->type->AdvancedSearch->SearchOperator = @$filter["z_type"];
        $this->type->AdvancedSearch->SearchCondition = @$filter["v_type"];
        $this->type->AdvancedSearch->SearchValue2 = @$filter["y_type"];
        $this->type->AdvancedSearch->SearchOperator2 = @$filter["w_type"];
        $this->type->AdvancedSearch->save();

        // Field isactive
        $this->isactive->AdvancedSearch->SearchValue = @$filter["x_isactive"];
        $this->isactive->AdvancedSearch->SearchOperator = @$filter["z_isactive"];
        $this->isactive->AdvancedSearch->SearchCondition = @$filter["v_isactive"];
        $this->isactive->AdvancedSearch->SearchValue2 = @$filter["y_isactive"];
        $this->isactive->AdvancedSearch->SearchOperator2 = @$filter["w_isactive"];
        $this->isactive->AdvancedSearch->save();

        // Field isbuyer
        $this->isbuyer->AdvancedSearch->SearchValue = @$filter["x_isbuyer"];
        $this->isbuyer->AdvancedSearch->SearchOperator = @$filter["z_isbuyer"];
        $this->isbuyer->AdvancedSearch->SearchCondition = @$filter["v_isbuyer"];
        $this->isbuyer->AdvancedSearch->SearchValue2 = @$filter["y_isbuyer"];
        $this->isbuyer->AdvancedSearch->SearchOperator2 = @$filter["w_isbuyer"];
        $this->isbuyer->AdvancedSearch->save();

        // Field isinvertor
        $this->isinvertor->AdvancedSearch->SearchValue = @$filter["x_isinvertor"];
        $this->isinvertor->AdvancedSearch->SearchOperator = @$filter["z_isinvertor"];
        $this->isinvertor->AdvancedSearch->SearchCondition = @$filter["v_isinvertor"];
        $this->isinvertor->AdvancedSearch->SearchValue2 = @$filter["y_isinvertor"];
        $this->isinvertor->AdvancedSearch->SearchOperator2 = @$filter["w_isinvertor"];
        $this->isinvertor->AdvancedSearch->save();

        // Field issale
        $this->issale->AdvancedSearch->SearchValue = @$filter["x_issale"];
        $this->issale->AdvancedSearch->SearchOperator = @$filter["z_issale"];
        $this->issale->AdvancedSearch->SearchCondition = @$filter["v_issale"];
        $this->issale->AdvancedSearch->SearchValue2 = @$filter["y_issale"];
        $this->issale->AdvancedSearch->SearchOperator2 = @$filter["w_issale"];
        $this->issale->AdvancedSearch->save();

        // Field isnotification
        $this->isnotification->AdvancedSearch->SearchValue = @$filter["x_isnotification"];
        $this->isnotification->AdvancedSearch->SearchOperator = @$filter["z_isnotification"];
        $this->isnotification->AdvancedSearch->SearchCondition = @$filter["v_isnotification"];
        $this->isnotification->AdvancedSearch->SearchValue2 = @$filter["y_isnotification"];
        $this->isnotification->AdvancedSearch->SearchOperator2 = @$filter["w_isnotification"];
        $this->isnotification->AdvancedSearch->save();

        // Field image_profile
        $this->image_profile->AdvancedSearch->SearchValue = @$filter["x_image_profile"];
        $this->image_profile->AdvancedSearch->SearchOperator = @$filter["z_image_profile"];
        $this->image_profile->AdvancedSearch->SearchCondition = @$filter["v_image_profile"];
        $this->image_profile->AdvancedSearch->SearchValue2 = @$filter["y_image_profile"];
        $this->image_profile->AdvancedSearch->SearchOperator2 = @$filter["w_image_profile"];
        $this->image_profile->AdvancedSearch->save();

        // Field customer_id
        $this->customer_id->AdvancedSearch->SearchValue = @$filter["x_customer_id"];
        $this->customer_id->AdvancedSearch->SearchOperator = @$filter["z_customer_id"];
        $this->customer_id->AdvancedSearch->SearchCondition = @$filter["v_customer_id"];
        $this->customer_id->AdvancedSearch->SearchValue2 = @$filter["y_customer_id"];
        $this->customer_id->AdvancedSearch->SearchOperator2 = @$filter["w_customer_id"];
        $this->customer_id->AdvancedSearch->save();

        // Field verify_key
        $this->verify_key->AdvancedSearch->SearchValue = @$filter["x_verify_key"];
        $this->verify_key->AdvancedSearch->SearchOperator = @$filter["z_verify_key"];
        $this->verify_key->AdvancedSearch->SearchCondition = @$filter["v_verify_key"];
        $this->verify_key->AdvancedSearch->SearchValue2 = @$filter["y_verify_key"];
        $this->verify_key->AdvancedSearch->SearchOperator2 = @$filter["w_verify_key"];
        $this->verify_key->AdvancedSearch->save();

        // Field verify_status
        $this->verify_status->AdvancedSearch->SearchValue = @$filter["x_verify_status"];
        $this->verify_status->AdvancedSearch->SearchOperator = @$filter["z_verify_status"];
        $this->verify_status->AdvancedSearch->SearchCondition = @$filter["v_verify_status"];
        $this->verify_status->AdvancedSearch->SearchValue2 = @$filter["y_verify_status"];
        $this->verify_status->AdvancedSearch->SearchOperator2 = @$filter["w_verify_status"];
        $this->verify_status->AdvancedSearch->save();

        // Field verify_date
        $this->verify_date->AdvancedSearch->SearchValue = @$filter["x_verify_date"];
        $this->verify_date->AdvancedSearch->SearchOperator = @$filter["z_verify_date"];
        $this->verify_date->AdvancedSearch->SearchCondition = @$filter["v_verify_date"];
        $this->verify_date->AdvancedSearch->SearchValue2 = @$filter["y_verify_date"];
        $this->verify_date->AdvancedSearch->SearchOperator2 = @$filter["w_verify_date"];
        $this->verify_date->AdvancedSearch->save();

        // Field verify_ip
        $this->verify_ip->AdvancedSearch->SearchValue = @$filter["x_verify_ip"];
        $this->verify_ip->AdvancedSearch->SearchOperator = @$filter["z_verify_ip"];
        $this->verify_ip->AdvancedSearch->SearchCondition = @$filter["v_verify_ip"];
        $this->verify_ip->AdvancedSearch->SearchValue2 = @$filter["y_verify_ip"];
        $this->verify_ip->AdvancedSearch->SearchOperator2 = @$filter["w_verify_ip"];
        $this->verify_ip->AdvancedSearch->save();

        // Field reset_password_date
        $this->reset_password_date->AdvancedSearch->SearchValue = @$filter["x_reset_password_date"];
        $this->reset_password_date->AdvancedSearch->SearchOperator = @$filter["z_reset_password_date"];
        $this->reset_password_date->AdvancedSearch->SearchCondition = @$filter["v_reset_password_date"];
        $this->reset_password_date->AdvancedSearch->SearchValue2 = @$filter["y_reset_password_date"];
        $this->reset_password_date->AdvancedSearch->SearchOperator2 = @$filter["w_reset_password_date"];
        $this->reset_password_date->AdvancedSearch->save();

        // Field reset_password_ip
        $this->reset_password_ip->AdvancedSearch->SearchValue = @$filter["x_reset_password_ip"];
        $this->reset_password_ip->AdvancedSearch->SearchOperator = @$filter["z_reset_password_ip"];
        $this->reset_password_ip->AdvancedSearch->SearchCondition = @$filter["v_reset_password_ip"];
        $this->reset_password_ip->AdvancedSearch->SearchValue2 = @$filter["y_reset_password_ip"];
        $this->reset_password_ip->AdvancedSearch->SearchOperator2 = @$filter["w_reset_password_ip"];
        $this->reset_password_ip->AdvancedSearch->save();

        // Field reset_password_email_code
        $this->reset_password_email_code->AdvancedSearch->SearchValue = @$filter["x_reset_password_email_code"];
        $this->reset_password_email_code->AdvancedSearch->SearchOperator = @$filter["z_reset_password_email_code"];
        $this->reset_password_email_code->AdvancedSearch->SearchCondition = @$filter["v_reset_password_email_code"];
        $this->reset_password_email_code->AdvancedSearch->SearchValue2 = @$filter["y_reset_password_email_code"];
        $this->reset_password_email_code->AdvancedSearch->SearchOperator2 = @$filter["w_reset_password_email_code"];
        $this->reset_password_email_code->AdvancedSearch->save();

        // Field reset_password_email_date
        $this->reset_password_email_date->AdvancedSearch->SearchValue = @$filter["x_reset_password_email_date"];
        $this->reset_password_email_date->AdvancedSearch->SearchOperator = @$filter["z_reset_password_email_date"];
        $this->reset_password_email_date->AdvancedSearch->SearchCondition = @$filter["v_reset_password_email_date"];
        $this->reset_password_email_date->AdvancedSearch->SearchValue2 = @$filter["y_reset_password_email_date"];
        $this->reset_password_email_date->AdvancedSearch->SearchOperator2 = @$filter["w_reset_password_email_date"];
        $this->reset_password_email_date->AdvancedSearch->save();

        // Field reset_password_email_ip
        $this->reset_password_email_ip->AdvancedSearch->SearchValue = @$filter["x_reset_password_email_ip"];
        $this->reset_password_email_ip->AdvancedSearch->SearchOperator = @$filter["z_reset_password_email_ip"];
        $this->reset_password_email_ip->AdvancedSearch->SearchCondition = @$filter["v_reset_password_email_ip"];
        $this->reset_password_email_ip->AdvancedSearch->SearchValue2 = @$filter["y_reset_password_email_ip"];
        $this->reset_password_email_ip->AdvancedSearch->SearchOperator2 = @$filter["w_reset_password_email_ip"];
        $this->reset_password_email_ip->AdvancedSearch->save();

        // Field resetTimestamp
        $this->resetTimestamp->AdvancedSearch->SearchValue = @$filter["x_resetTimestamp"];
        $this->resetTimestamp->AdvancedSearch->SearchOperator = @$filter["z_resetTimestamp"];
        $this->resetTimestamp->AdvancedSearch->SearchCondition = @$filter["v_resetTimestamp"];
        $this->resetTimestamp->AdvancedSearch->SearchValue2 = @$filter["y_resetTimestamp"];
        $this->resetTimestamp->AdvancedSearch->SearchOperator2 = @$filter["w_resetTimestamp"];
        $this->resetTimestamp->AdvancedSearch->save();

        // Field resetKeyTimestamp
        $this->resetKeyTimestamp->AdvancedSearch->SearchValue = @$filter["x_resetKeyTimestamp"];
        $this->resetKeyTimestamp->AdvancedSearch->SearchOperator = @$filter["z_resetKeyTimestamp"];
        $this->resetKeyTimestamp->AdvancedSearch->SearchCondition = @$filter["v_resetKeyTimestamp"];
        $this->resetKeyTimestamp->AdvancedSearch->SearchValue2 = @$filter["y_resetKeyTimestamp"];
        $this->resetKeyTimestamp->AdvancedSearch->SearchOperator2 = @$filter["w_resetKeyTimestamp"];
        $this->resetKeyTimestamp->AdvancedSearch->save();

        // Field reset_password_code
        $this->reset_password_code->AdvancedSearch->SearchValue = @$filter["x_reset_password_code"];
        $this->reset_password_code->AdvancedSearch->SearchOperator = @$filter["z_reset_password_code"];
        $this->reset_password_code->AdvancedSearch->SearchCondition = @$filter["v_reset_password_code"];
        $this->reset_password_code->AdvancedSearch->SearchValue2 = @$filter["y_reset_password_code"];
        $this->reset_password_code->AdvancedSearch->SearchOperator2 = @$filter["w_reset_password_code"];
        $this->reset_password_code->AdvancedSearch->save();

        // Field pipedrive_people_id
        $this->pipedrive_people_id->AdvancedSearch->SearchValue = @$filter["x_pipedrive_people_id"];
        $this->pipedrive_people_id->AdvancedSearch->SearchOperator = @$filter["z_pipedrive_people_id"];
        $this->pipedrive_people_id->AdvancedSearch->SearchCondition = @$filter["v_pipedrive_people_id"];
        $this->pipedrive_people_id->AdvancedSearch->SearchValue2 = @$filter["y_pipedrive_people_id"];
        $this->pipedrive_people_id->AdvancedSearch->SearchOperator2 = @$filter["w_pipedrive_people_id"];
        $this->pipedrive_people_id->AdvancedSearch->save();

        // Field cdate
        $this->cdate->AdvancedSearch->SearchValue = @$filter["x_cdate"];
        $this->cdate->AdvancedSearch->SearchOperator = @$filter["z_cdate"];
        $this->cdate->AdvancedSearch->SearchCondition = @$filter["v_cdate"];
        $this->cdate->AdvancedSearch->SearchValue2 = @$filter["y_cdate"];
        $this->cdate->AdvancedSearch->SearchOperator2 = @$filter["w_cdate"];
        $this->cdate->AdvancedSearch->save();

        // Field cip
        $this->cip->AdvancedSearch->SearchValue = @$filter["x_cip"];
        $this->cip->AdvancedSearch->SearchOperator = @$filter["z_cip"];
        $this->cip->AdvancedSearch->SearchCondition = @$filter["v_cip"];
        $this->cip->AdvancedSearch->SearchValue2 = @$filter["y_cip"];
        $this->cip->AdvancedSearch->SearchOperator2 = @$filter["w_cip"];
        $this->cip->AdvancedSearch->save();

        // Field cuser
        $this->cuser->AdvancedSearch->SearchValue = @$filter["x_cuser"];
        $this->cuser->AdvancedSearch->SearchOperator = @$filter["z_cuser"];
        $this->cuser->AdvancedSearch->SearchCondition = @$filter["v_cuser"];
        $this->cuser->AdvancedSearch->SearchValue2 = @$filter["y_cuser"];
        $this->cuser->AdvancedSearch->SearchOperator2 = @$filter["w_cuser"];
        $this->cuser->AdvancedSearch->save();

        // Field udate
        $this->udate->AdvancedSearch->SearchValue = @$filter["x_udate"];
        $this->udate->AdvancedSearch->SearchOperator = @$filter["z_udate"];
        $this->udate->AdvancedSearch->SearchCondition = @$filter["v_udate"];
        $this->udate->AdvancedSearch->SearchValue2 = @$filter["y_udate"];
        $this->udate->AdvancedSearch->SearchOperator2 = @$filter["w_udate"];
        $this->udate->AdvancedSearch->save();

        // Field uip
        $this->uip->AdvancedSearch->SearchValue = @$filter["x_uip"];
        $this->uip->AdvancedSearch->SearchOperator = @$filter["z_uip"];
        $this->uip->AdvancedSearch->SearchCondition = @$filter["v_uip"];
        $this->uip->AdvancedSearch->SearchValue2 = @$filter["y_uip"];
        $this->uip->AdvancedSearch->SearchOperator2 = @$filter["w_uip"];
        $this->uip->AdvancedSearch->save();

        // Field uuser
        $this->uuser->AdvancedSearch->SearchValue = @$filter["x_uuser"];
        $this->uuser->AdvancedSearch->SearchOperator = @$filter["z_uuser"];
        $this->uuser->AdvancedSearch->SearchCondition = @$filter["v_uuser"];
        $this->uuser->AdvancedSearch->SearchValue2 = @$filter["y_uuser"];
        $this->uuser->AdvancedSearch->SearchOperator2 = @$filter["w_uuser"];
        $this->uuser->AdvancedSearch->save();
    }

    // Advanced search WHERE clause based on QueryString
    protected function advancedSearchWhere($default = false)
    {
        global $Security;
        $where = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $this->buildSearchSql($where, $this->member_id, $default, false); // member_id
        $this->buildSearchSql($where, $this->first_name, $default, false); // first_name
        $this->buildSearchSql($where, $this->last_name, $default, false); // last_name
        $this->buildSearchSql($where, $this->idcardnumber, $default, false); // idcardnumber
        $this->buildSearchSql($where, $this->_email, $default, false); // email
        $this->buildSearchSql($where, $this->phone, $default, false); // phone
        $this->buildSearchSql($where, $this->facebook_id, $default, false); // facebook_id
        $this->buildSearchSql($where, $this->line_id, $default, false); // line_id
        $this->buildSearchSql($where, $this->google_id, $default, false); // google_id
        $this->buildSearchSql($where, $this->type, $default, false); // type
        $this->buildSearchSql($where, $this->isactive, $default, false); // isactive
        $this->buildSearchSql($where, $this->isbuyer, $default, false); // isbuyer
        $this->buildSearchSql($where, $this->isinvertor, $default, false); // isinvertor
        $this->buildSearchSql($where, $this->issale, $default, false); // issale
        $this->buildSearchSql($where, $this->isnotification, $default, false); // isnotification
        $this->buildSearchSql($where, $this->image_profile, $default, false); // image_profile
        $this->buildSearchSql($where, $this->customer_id, $default, false); // customer_id
        $this->buildSearchSql($where, $this->verify_key, $default, false); // verify_key
        $this->buildSearchSql($where, $this->verify_status, $default, false); // verify_status
        $this->buildSearchSql($where, $this->verify_date, $default, false); // verify_date
        $this->buildSearchSql($where, $this->verify_ip, $default, false); // verify_ip
        $this->buildSearchSql($where, $this->reset_password_date, $default, false); // reset_password_date
        $this->buildSearchSql($where, $this->reset_password_ip, $default, false); // reset_password_ip
        $this->buildSearchSql($where, $this->reset_password_email_code, $default, false); // reset_password_email_code
        $this->buildSearchSql($where, $this->reset_password_email_date, $default, false); // reset_password_email_date
        $this->buildSearchSql($where, $this->reset_password_email_ip, $default, false); // reset_password_email_ip
        $this->buildSearchSql($where, $this->resetTimestamp, $default, false); // resetTimestamp
        $this->buildSearchSql($where, $this->resetKeyTimestamp, $default, false); // resetKeyTimestamp
        $this->buildSearchSql($where, $this->reset_password_code, $default, false); // reset_password_code
        $this->buildSearchSql($where, $this->pipedrive_people_id, $default, false); // pipedrive_people_id
        $this->buildSearchSql($where, $this->cdate, $default, false); // cdate
        $this->buildSearchSql($where, $this->cip, $default, false); // cip
        $this->buildSearchSql($where, $this->cuser, $default, false); // cuser
        $this->buildSearchSql($where, $this->udate, $default, false); // udate
        $this->buildSearchSql($where, $this->uip, $default, false); // uip
        $this->buildSearchSql($where, $this->uuser, $default, false); // uuser

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->member_id->AdvancedSearch->save(); // member_id
            $this->first_name->AdvancedSearch->save(); // first_name
            $this->last_name->AdvancedSearch->save(); // last_name
            $this->idcardnumber->AdvancedSearch->save(); // idcardnumber
            $this->_email->AdvancedSearch->save(); // email
            $this->phone->AdvancedSearch->save(); // phone
            $this->facebook_id->AdvancedSearch->save(); // facebook_id
            $this->line_id->AdvancedSearch->save(); // line_id
            $this->google_id->AdvancedSearch->save(); // google_id
            $this->type->AdvancedSearch->save(); // type
            $this->isactive->AdvancedSearch->save(); // isactive
            $this->isbuyer->AdvancedSearch->save(); // isbuyer
            $this->isinvertor->AdvancedSearch->save(); // isinvertor
            $this->issale->AdvancedSearch->save(); // issale
            $this->isnotification->AdvancedSearch->save(); // isnotification
            $this->image_profile->AdvancedSearch->save(); // image_profile
            $this->customer_id->AdvancedSearch->save(); // customer_id
            $this->verify_key->AdvancedSearch->save(); // verify_key
            $this->verify_status->AdvancedSearch->save(); // verify_status
            $this->verify_date->AdvancedSearch->save(); // verify_date
            $this->verify_ip->AdvancedSearch->save(); // verify_ip
            $this->reset_password_date->AdvancedSearch->save(); // reset_password_date
            $this->reset_password_ip->AdvancedSearch->save(); // reset_password_ip
            $this->reset_password_email_code->AdvancedSearch->save(); // reset_password_email_code
            $this->reset_password_email_date->AdvancedSearch->save(); // reset_password_email_date
            $this->reset_password_email_ip->AdvancedSearch->save(); // reset_password_email_ip
            $this->resetTimestamp->AdvancedSearch->save(); // resetTimestamp
            $this->resetKeyTimestamp->AdvancedSearch->save(); // resetKeyTimestamp
            $this->reset_password_code->AdvancedSearch->save(); // reset_password_code
            $this->pipedrive_people_id->AdvancedSearch->save(); // pipedrive_people_id
            $this->cdate->AdvancedSearch->save(); // cdate
            $this->cip->AdvancedSearch->save(); // cip
            $this->cuser->AdvancedSearch->save(); // cuser
            $this->udate->AdvancedSearch->save(); // udate
            $this->uip->AdvancedSearch->save(); // uip
            $this->uuser->AdvancedSearch->save(); // uuser
        }
        return $where;
    }

    // Build search SQL
    protected function buildSearchSql(&$where, &$fld, $default, $multiValue)
    {
        $fldParm = $fld->Param;
        $fldVal = $default ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = $default ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldCond = $default ? $fld->AdvancedSearch->SearchConditionDefault : $fld->AdvancedSearch->SearchCondition;
        $fldVal2 = $default ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        $fldOpr2 = $default ? $fld->AdvancedSearch->SearchOperator2Default : $fld->AdvancedSearch->SearchOperator2;
        $wrk = "";
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldOpr = strtoupper(trim($fldOpr));
        if ($fldOpr == "") {
            $fldOpr = "=";
        }
        $fldOpr2 = strtoupper(trim($fldOpr2));
        if ($fldOpr2 == "") {
            $fldOpr2 = "=";
        }
        if (Config("SEARCH_MULTI_VALUE_OPTION") == 1 && !$fld->UseFilter || !IsMultiSearchOperator($fldOpr)) {
            $multiValue = false;
        }
        if ($multiValue) {
            $wrk = $fldVal != "" ? GetMultiSearchSql($fld, $fldOpr, $fldVal, $this->Dbid) : ""; // Field value 1
            $wrk2 = $fldVal2 != "" ? GetMultiSearchSql($fld, $fldOpr2, $fldVal2, $this->Dbid) : ""; // Field value 2
            AddFilter($wrk, $wrk2, $fldCond);
        } else {
            $fldVal = $this->convertSearchValue($fld, $fldVal);
            $fldVal2 = $this->convertSearchValue($fld, $fldVal2);
            $wrk = GetSearchSql($fld, $fldVal, $fldOpr, $fldCond, $fldVal2, $fldOpr2, $this->Dbid);
        }
        if ($this->SearchOption == "AUTO" && in_array($this->BasicSearch->getType(), ["AND", "OR"])) {
            $cond = $this->BasicSearch->getType();
        } else {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
        }
        AddFilter($where, $wrk, $cond);
    }

    // Convert search value
    protected function convertSearchValue(&$fld, $fldVal)
    {
        if ($fldVal == Config("NULL_VALUE") || $fldVal == Config("NOT_NULL_VALUE")) {
            return $fldVal;
        }
        $value = $fldVal;
        if ($fld->isBoolean()) {
            if ($fldVal != "") {
                $value = (SameText($fldVal, "1") || SameText($fldVal, "y") || SameText($fldVal, "t")) ? $fld->TrueValue : $fld->FalseValue;
            }
        } elseif ($fld->DataType == DATATYPE_DATE || $fld->DataType == DATATYPE_TIME) {
            if ($fldVal != "") {
                $value = UnFormatDateTime($fldVal, $fld->formatPattern());
            }
        }
        return $value;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        if ($this->member_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->first_name->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->last_name->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->idcardnumber->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_email->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->phone->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->facebook_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->line_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->google_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->type->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->isactive->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->isbuyer->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->isinvertor->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->issale->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->isnotification->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->image_profile->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->customer_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->verify_key->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->verify_status->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->verify_date->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->verify_ip->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->reset_password_date->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->reset_password_ip->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->reset_password_email_code->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->reset_password_email_date->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->reset_password_email_ip->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->resetTimestamp->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->resetKeyTimestamp->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->reset_password_code->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->pipedrive_people_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cdate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cip->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cuser->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->udate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->uip->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->uuser->AdvancedSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear advanced search parameters
        $this->resetAdvancedSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all advanced search parameters
    protected function resetAdvancedSearchParms()
    {
        $this->member_id->AdvancedSearch->unsetSession();
        $this->first_name->AdvancedSearch->unsetSession();
        $this->last_name->AdvancedSearch->unsetSession();
        $this->idcardnumber->AdvancedSearch->unsetSession();
        $this->_email->AdvancedSearch->unsetSession();
        $this->phone->AdvancedSearch->unsetSession();
        $this->facebook_id->AdvancedSearch->unsetSession();
        $this->line_id->AdvancedSearch->unsetSession();
        $this->google_id->AdvancedSearch->unsetSession();
        $this->type->AdvancedSearch->unsetSession();
        $this->isactive->AdvancedSearch->unsetSession();
        $this->isbuyer->AdvancedSearch->unsetSession();
        $this->isinvertor->AdvancedSearch->unsetSession();
        $this->issale->AdvancedSearch->unsetSession();
        $this->isnotification->AdvancedSearch->unsetSession();
        $this->image_profile->AdvancedSearch->unsetSession();
        $this->customer_id->AdvancedSearch->unsetSession();
        $this->verify_key->AdvancedSearch->unsetSession();
        $this->verify_status->AdvancedSearch->unsetSession();
        $this->verify_date->AdvancedSearch->unsetSession();
        $this->verify_ip->AdvancedSearch->unsetSession();
        $this->reset_password_date->AdvancedSearch->unsetSession();
        $this->reset_password_ip->AdvancedSearch->unsetSession();
        $this->reset_password_email_code->AdvancedSearch->unsetSession();
        $this->reset_password_email_date->AdvancedSearch->unsetSession();
        $this->reset_password_email_ip->AdvancedSearch->unsetSession();
        $this->resetTimestamp->AdvancedSearch->unsetSession();
        $this->resetKeyTimestamp->AdvancedSearch->unsetSession();
        $this->reset_password_code->AdvancedSearch->unsetSession();
        $this->pipedrive_people_id->AdvancedSearch->unsetSession();
        $this->cdate->AdvancedSearch->unsetSession();
        $this->cip->AdvancedSearch->unsetSession();
        $this->cuser->AdvancedSearch->unsetSession();
        $this->udate->AdvancedSearch->unsetSession();
        $this->uip->AdvancedSearch->unsetSession();
        $this->uuser->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore advanced search values
        $this->member_id->AdvancedSearch->load();
        $this->first_name->AdvancedSearch->load();
        $this->last_name->AdvancedSearch->load();
        $this->idcardnumber->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->phone->AdvancedSearch->load();
        $this->facebook_id->AdvancedSearch->load();
        $this->line_id->AdvancedSearch->load();
        $this->google_id->AdvancedSearch->load();
        $this->type->AdvancedSearch->load();
        $this->isactive->AdvancedSearch->load();
        $this->isbuyer->AdvancedSearch->load();
        $this->isinvertor->AdvancedSearch->load();
        $this->issale->AdvancedSearch->load();
        $this->isnotification->AdvancedSearch->load();
        $this->image_profile->AdvancedSearch->load();
        $this->customer_id->AdvancedSearch->load();
        $this->verify_key->AdvancedSearch->load();
        $this->verify_status->AdvancedSearch->load();
        $this->verify_date->AdvancedSearch->load();
        $this->verify_ip->AdvancedSearch->load();
        $this->reset_password_date->AdvancedSearch->load();
        $this->reset_password_ip->AdvancedSearch->load();
        $this->reset_password_email_code->AdvancedSearch->load();
        $this->reset_password_email_date->AdvancedSearch->load();
        $this->reset_password_email_ip->AdvancedSearch->load();
        $this->resetTimestamp->AdvancedSearch->load();
        $this->resetKeyTimestamp->AdvancedSearch->load();
        $this->reset_password_code->AdvancedSearch->load();
        $this->pipedrive_people_id->AdvancedSearch->load();
        $this->cdate->AdvancedSearch->load();
        $this->cip->AdvancedSearch->load();
        $this->cuser->AdvancedSearch->load();
        $this->udate->AdvancedSearch->load();
        $this->uip->AdvancedSearch->load();
        $this->uuser->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for Ctrl pressed
        $ctrl = Get("ctrl") !== null;

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->first_name, $ctrl); // first_name
            $this->updateSort($this->last_name, $ctrl); // last_name
            $this->updateSort($this->idcardnumber, $ctrl); // idcardnumber
            $this->updateSort($this->_email, $ctrl); // email
            $this->updateSort($this->phone, $ctrl); // phone
            $this->updateSort($this->isbuyer, $ctrl); // isbuyer
            $this->updateSort($this->isinvertor, $ctrl); // isinvertor
            $this->updateSort($this->issale, $ctrl); // issale
            $this->updateSort($this->image_profile, $ctrl); // image_profile
            $this->updateSort($this->cdate, $ctrl); // cdate
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "`first_name` ASC";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($this->first_name->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($useDefaultSort) {
                    $this->first_name->setSort("ASC");
                    $orderBy = $this->getSqlOrderBy();
                    $this->setSessionOrderBy($orderBy);
                } else {
                    $this->setSessionOrderBy("");
                }
            }
        }
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->member_id->setSort("");
                $this->first_name->setSort("");
                $this->last_name->setSort("");
                $this->idcardnumber->setSort("");
                $this->_email->setSort("");
                $this->phone->setSort("");
                $this->facebook_id->setSort("");
                $this->line_id->setSort("");
                $this->google_id->setSort("");
                $this->_password->setSort("");
                $this->type->setSort("");
                $this->isactive->setSort("");
                $this->isbuyer->setSort("");
                $this->isinvertor->setSort("");
                $this->issale->setSort("");
                $this->isnotification->setSort("");
                $this->code_phone->setSort("");
                $this->image_profile->setSort("");
                $this->customer_id->setSort("");
                $this->verify_key->setSort("");
                $this->verify_status->setSort("");
                $this->verify_date->setSort("");
                $this->verify_ip->setSort("");
                $this->reset_password_date->setSort("");
                $this->reset_password_ip->setSort("");
                $this->reset_password_email_code->setSort("");
                $this->reset_password_email_date->setSort("");
                $this->reset_password_email_ip->setSort("");
                $this->resetTimestamp->setSort("");
                $this->resetKeyTimestamp->setSort("");
                $this->reset_password_code->setSort("");
                $this->pipedrive_people_id->setSort("");
                $this->last_login->setSort("");
                $this->cdate->setSort("");
                $this->cip->setSort("");
                $this->cuser->setSort("");
                $this->udate->setSort("");
                $this->uip->setSort("");
                $this->uuser->setSort("");
                $this->verify_phone_status->setSort("");
                $this->verify_phone_date->setSort("");
                $this->verify_phone_ip->setSort("");
                $this->is_peak_contact->setSort("");
                $this->last_change_password->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // Add group option item ("button")
        $item = &$this->ListOptions->addGroupOption();
        $item->Body = "";
        $item->OnLeft = false;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = false;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = false;

        // "detail_address"
        $item = &$this->ListOptions->add("detail_address");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'address');
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_asset_favorite"
        $item = &$this->ListOptions->add("detail_asset_favorite");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'asset_favorite');
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_appointment"
        $item = &$this->ListOptions->add("detail_appointment");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'appointment');
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // Multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$this->ListOptions->add("details");
            $item->CssClass = "text-nowrap";
            $item->Visible = $this->ShowMultipleDetails && $this->ListOptions->detailVisible();
            $item->OnLeft = false;
            $item->ShowInButtonGroup = false;
            $this->ListOptions->hideDetailItems();
        }

        // Set up detail pages
        $pages = new SubPages();
        $pages->add("address");
        $pages->add("asset_favorite");
        $pages->add("appointment");
        $this->DetailPages = $pages;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = false;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = false;
        $item->Header = "<div class=\"form-check\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"form-check-input\" data-ew-action=\"select-all-keys\"></div>";
        if ($item->OnLeft) {
            $item->moveTo(0);
        }
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // "sequence"
        $item = &$this->ListOptions->add("sequence");
        $item->CssClass = "text-nowrap";
        $item->Visible = true;
        $item->OnLeft = true; // Always on left
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Set up list options (extensions)
    protected function setupListOptionsExt()
    {
            // Set up list options (to be implemented by extensions)
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm, $UserProfile;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();

        // "sequence"
        $opt = $this->ListOptions["sequence"];
        $opt->Body = FormatSequenceNumber($this->RecordCount);
        $pageUrl = $this->pageUrl(false);
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions->Items as $listaction) {
                $action = $listaction->Action;
                $allowed = $listaction->Allow;
                if ($listaction->Select == ACTION_SINGLE && $allowed) {
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listaction->Icon)) . "\" data-caption=\"" . HtmlTitle($caption) . "\"></i> " : "";
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fmemberlist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button></li>";
                    if ($link != "") {
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fmemberlist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button>";
                        }
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = "";
                foreach ($links as $link) {
                    $content .= "<li>" . $link . "</li>";
                }
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
            }
        }
        $detailViewTblVar = "";
        $detailCopyTblVar = "";
        $detailEditTblVar = "";

        // "detail_address"
        $opt = $this->ListOptions["detail_address"];
        if ($Security->allowList(CurrentProjectID() . 'address')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("address", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("addresslist?" . Config("TABLE_SHOW_MASTER") . "=member&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("AddressGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'member')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=address");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "address";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'member')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=address");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "address";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_asset_favorite"
        $opt = $this->ListOptions["detail_asset_favorite"];
        if ($Security->allowList(CurrentProjectID() . 'asset_favorite')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("asset_favorite", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("assetfavoritelist?" . Config("TABLE_SHOW_MASTER") . "=member&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("AssetFavoriteGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'member')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=asset_favorite");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "asset_favorite";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'member')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=asset_favorite");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "asset_favorite";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_appointment"
        $opt = $this->ListOptions["detail_appointment"];
        if ($Security->allowList(CurrentProjectID() . 'appointment')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("appointment", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("appointmentlist?" . Config("TABLE_SHOW_MASTER") . "=member&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("AppointmentGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'member')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=appointment");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "appointment";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'member')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=appointment");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "appointment";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }
        if ($this->ShowMultipleDetails) {
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
            $links = "";
            if ($detailViewTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailViewLink", true)) . "\" href=\"" . HtmlEncode($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar)) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            }
            if ($detailEditTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailEditLink", true)) . "\" href=\"" . HtmlEncode($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar)) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            }
            if ($detailCopyTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailCopyLink", true)) . "\" href=\"" . HtmlEncode($this->GetCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar)) . "\">" . $Language->phrase("MasterDetailCopyLink", null) . "</a></li>";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlEncode($Language->phrase("MultipleMasterDetails", true)) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
                $body .= "<ul class=\"dropdown-menu ew-menu\">" . $links . "</ul>";
            }
            $body .= "</div>";
            // Multiple details
            $opt = $this->ListOptions["details"];
            $opt->Body = $body;
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->member_id->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Render list options (extensions)
    protected function renderListOptionsExt()
    {
        // Render list options (to be implemented by extensions)
        global $Security, $Language;
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $option->add("first_name", $this->createColumnOption("first_name"));
            $option->add("last_name", $this->createColumnOption("last_name"));
            $option->add("idcardnumber", $this->createColumnOption("idcardnumber"));
            $option->add("email", $this->createColumnOption("email"));
            $option->add("phone", $this->createColumnOption("phone"));
            $option->add("isbuyer", $this->createColumnOption("isbuyer"));
            $option->add("isinvertor", $this->createColumnOption("isinvertor"));
            $option->add("issale", $this->createColumnOption("issale"));
            $option->add("image_profile", $this->createColumnOption("image_profile"));
            $option->add("cdate", $this->createColumnOption("cdate"));
        }

        // Set up options default
        foreach ($options as $name => $option) {
            if ($name != "column") { // Always use dropdown for column
                $option->UseDropDownButton = false;
                $option->UseButtonGroup = true;
            }
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fmembersrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fmembersrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
    }

    // Create new column option
    public function createColumnOption($name)
    {
        $field = $this->Fields[$name] ?? false;
        if ($field && $field->Visible) {
            $item = new ListOption($field->Name);
            $item->Body = '<button class="dropdown-item">' .
                '<div class="form-check ew-dropdown-checkbox">' .
                '<div class="form-check-input ew-dropdown-check-input" data-field="' . $field->Param . '"></div>' .
                '<label class="form-check-label ew-dropdown-check-label">' . $field->caption() . '</label></div></button>';
            return $item;
        }
        return null;
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];
        // Set up list action buttons
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE) {
                $item = &$option->add("custom_" . $listaction->Action);
                $caption = $listaction->Caption;
                $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fmemberlist"' . $listaction->toDataAttrs() . '>' . $icon . '</button>';
                $item->Visible = $listaction->Allow;
            }
        }

        // Hide grid edit and other options
        if ($this->TotalRecords <= 0) {
            $option = $options["addedit"];
            $item = $option["gridedit"];
            if ($item) {
                $item->Visible = false;
            }
            $option = $options["action"];
            $option->hideAllOptions();
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security, $Response;
        $userlist = "";
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("useraction", "");
        if ($filter != "" && $userAction != "") {
            // Check permission first
            $actionCaption = $userAction;
            if (array_key_exists($userAction, $this->ListActions->Items)) {
                $actionCaption = $this->ListActions[$userAction]->Caption;
                if (!$this->ListActions[$userAction]->Allow) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            }
            $this->CurrentFilter = $filter;
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = LoadRecordset($sql, $conn);
            $this->UserAction = $userAction;
            $this->ActionValue = Post("actionvalue");

            // Call row action event
            if ($rs) {
                if ($this->UseTransaction) {
                    $conn->beginTransaction();
                }
                $this->SelectedCount = $rs->recordCount();
                $this->SelectedIndex = 0;
                while (!$rs->EOF) {
                    $this->SelectedIndex++;
                    $row = $rs->fields;
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                    $rs->moveNext();
                }
                if ($processed) {
                    if ($this->UseTransaction) { // Commit transaction
                        $conn->commit();
                    }
                    if ($this->getSuccessMessage() == "" && !ob_get_length() && !$Response->getBody()->getSize()) { // No output
                        $this->setSuccessMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    if ($this->UseTransaction) { // Rollback transaction
                        $conn->rollback();
                    }

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if ($rs) {
                $rs->close();
            }
            if (Post("ajax") == $userAction) { // Ajax
                if ($this->getSuccessMessage() != "") {
                    echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                    $this->clearSuccessMessage(); // Clear message
                }
                if ($this->getFailureMessage() != "") {
                    echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                    $this->clearFailureMessage(); // Clear message
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // member_id
        if ($this->member_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->member_id->AdvancedSearch->SearchValue != "" || $this->member_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // first_name
        if ($this->first_name->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->first_name->AdvancedSearch->SearchValue != "" || $this->first_name->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // last_name
        if ($this->last_name->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->last_name->AdvancedSearch->SearchValue != "" || $this->last_name->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // idcardnumber
        if ($this->idcardnumber->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->idcardnumber->AdvancedSearch->SearchValue != "" || $this->idcardnumber->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // email
        if ($this->_email->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->_email->AdvancedSearch->SearchValue != "" || $this->_email->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // phone
        if ($this->phone->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->phone->AdvancedSearch->SearchValue != "" || $this->phone->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // facebook_id
        if ($this->facebook_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->facebook_id->AdvancedSearch->SearchValue != "" || $this->facebook_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // line_id
        if ($this->line_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->line_id->AdvancedSearch->SearchValue != "" || $this->line_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // google_id
        if ($this->google_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->google_id->AdvancedSearch->SearchValue != "" || $this->google_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // type
        if ($this->type->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->type->AdvancedSearch->SearchValue != "" || $this->type->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // isactive
        if ($this->isactive->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->isactive->AdvancedSearch->SearchValue != "" || $this->isactive->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // isbuyer
        if ($this->isbuyer->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->isbuyer->AdvancedSearch->SearchValue != "" || $this->isbuyer->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->isbuyer->AdvancedSearch->SearchValue)) {
            $this->isbuyer->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->isbuyer->AdvancedSearch->SearchValue);
        }
        if (is_array($this->isbuyer->AdvancedSearch->SearchValue2)) {
            $this->isbuyer->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->isbuyer->AdvancedSearch->SearchValue2);
        }

        // isinvertor
        if ($this->isinvertor->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->isinvertor->AdvancedSearch->SearchValue != "" || $this->isinvertor->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->isinvertor->AdvancedSearch->SearchValue)) {
            $this->isinvertor->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->isinvertor->AdvancedSearch->SearchValue);
        }
        if (is_array($this->isinvertor->AdvancedSearch->SearchValue2)) {
            $this->isinvertor->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->isinvertor->AdvancedSearch->SearchValue2);
        }

        // issale
        if ($this->issale->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->issale->AdvancedSearch->SearchValue != "" || $this->issale->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->issale->AdvancedSearch->SearchValue)) {
            $this->issale->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->issale->AdvancedSearch->SearchValue);
        }
        if (is_array($this->issale->AdvancedSearch->SearchValue2)) {
            $this->issale->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->issale->AdvancedSearch->SearchValue2);
        }

        // isnotification
        if ($this->isnotification->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->isnotification->AdvancedSearch->SearchValue != "" || $this->isnotification->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->isnotification->AdvancedSearch->SearchValue)) {
            $this->isnotification->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->isnotification->AdvancedSearch->SearchValue);
        }
        if (is_array($this->isnotification->AdvancedSearch->SearchValue2)) {
            $this->isnotification->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->isnotification->AdvancedSearch->SearchValue2);
        }

        // image_profile
        if ($this->image_profile->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->image_profile->AdvancedSearch->SearchValue != "" || $this->image_profile->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // customer_id
        if ($this->customer_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->customer_id->AdvancedSearch->SearchValue != "" || $this->customer_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // verify_key
        if ($this->verify_key->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->verify_key->AdvancedSearch->SearchValue != "" || $this->verify_key->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // verify_status
        if ($this->verify_status->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->verify_status->AdvancedSearch->SearchValue != "" || $this->verify_status->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // verify_date
        if ($this->verify_date->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->verify_date->AdvancedSearch->SearchValue != "" || $this->verify_date->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // verify_ip
        if ($this->verify_ip->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->verify_ip->AdvancedSearch->SearchValue != "" || $this->verify_ip->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // reset_password_date
        if ($this->reset_password_date->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->reset_password_date->AdvancedSearch->SearchValue != "" || $this->reset_password_date->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // reset_password_ip
        if ($this->reset_password_ip->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->reset_password_ip->AdvancedSearch->SearchValue != "" || $this->reset_password_ip->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // reset_password_email_code
        if ($this->reset_password_email_code->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->reset_password_email_code->AdvancedSearch->SearchValue != "" || $this->reset_password_email_code->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // reset_password_email_date
        if ($this->reset_password_email_date->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->reset_password_email_date->AdvancedSearch->SearchValue != "" || $this->reset_password_email_date->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // reset_password_email_ip
        if ($this->reset_password_email_ip->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->reset_password_email_ip->AdvancedSearch->SearchValue != "" || $this->reset_password_email_ip->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // resetTimestamp
        if ($this->resetTimestamp->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->resetTimestamp->AdvancedSearch->SearchValue != "" || $this->resetTimestamp->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // resetKeyTimestamp
        if ($this->resetKeyTimestamp->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->resetKeyTimestamp->AdvancedSearch->SearchValue != "" || $this->resetKeyTimestamp->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // reset_password_code
        if ($this->reset_password_code->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->reset_password_code->AdvancedSearch->SearchValue != "" || $this->reset_password_code->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // pipedrive_people_id
        if ($this->pipedrive_people_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->pipedrive_people_id->AdvancedSearch->SearchValue != "" || $this->pipedrive_people_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cdate
        if ($this->cdate->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cdate->AdvancedSearch->SearchValue != "" || $this->cdate->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cip
        if ($this->cip->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cip->AdvancedSearch->SearchValue != "" || $this->cip->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cuser
        if ($this->cuser->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cuser->AdvancedSearch->SearchValue != "" || $this->cuser->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // udate
        if ($this->udate->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->udate->AdvancedSearch->SearchValue != "" || $this->udate->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // uip
        if ($this->uip->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->uip->AdvancedSearch->SearchValue != "" || $this->uip->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // uuser
        if ($this->uuser->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->uuser->AdvancedSearch->SearchValue != "" || $this->uuser->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        return $hasValue;
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->execute();
        $rs = new Recordset($result, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
    }

    // Load records as associative array
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->execute();
        return $result->fetchAll(FetchMode::ASSOCIATIVE);
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // member_id
        $this->member_id->CellCssStyle = "white-space: nowrap;";

        // first_name

        // last_name

        // idcardnumber

        // email

        // phone

        // facebook_id
        $this->facebook_id->CellCssStyle = "white-space: nowrap;";

        // line_id
        $this->line_id->CellCssStyle = "white-space: nowrap;";

        // google_id
        $this->google_id->CellCssStyle = "white-space: nowrap;";

        // password
        $this->_password->CellCssStyle = "white-space: nowrap;";

        // type

        // isactive

        // isbuyer

        // isinvertor

        // issale

        // isnotification

        // code_phone
        $this->code_phone->CellCssStyle = "white-space: nowrap;";

        // image_profile

        // customer_id

        // verify_key

        // verify_status

        // verify_date

        // verify_ip

        // reset_password_date

        // reset_password_ip

        // reset_password_email_code

        // reset_password_email_date

        // reset_password_email_ip

        // resetTimestamp

        // resetKeyTimestamp

        // reset_password_code

        // pipedrive_people_id

        // last_login
        $this->last_login->CellCssStyle = "white-space: nowrap;";

        // cdate

        // cip

        // cuser

        // udate

        // uip

        // uuser

        // verify_phone_status
        $this->verify_phone_status->CellCssStyle = "white-space: nowrap;";

        // verify_phone_date
        $this->verify_phone_date->CellCssStyle = "white-space: nowrap;";

        // verify_phone_ip
        $this->verify_phone_ip->CellCssStyle = "white-space: nowrap;";

        // is_peak_contact
        $this->is_peak_contact->CellCssStyle = "white-space: nowrap;";

        // last_change_password
        $this->last_change_password->CellCssStyle = "white-space: nowrap;";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
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

            // first_name
            $this->first_name->LinkCustomAttributes = "";
            $this->first_name->HrefValue = "";
            $this->first_name->TooltipValue = "";
            if (!$this->isExport()) {
                $this->first_name->ViewValue = $this->highlightValue($this->first_name);
            }

            // last_name
            $this->last_name->LinkCustomAttributes = "";
            $this->last_name->HrefValue = "";
            $this->last_name->TooltipValue = "";
            if (!$this->isExport()) {
                $this->last_name->ViewValue = $this->highlightValue($this->last_name);
            }

            // idcardnumber
            $this->idcardnumber->LinkCustomAttributes = "";
            $this->idcardnumber->HrefValue = "";
            $this->idcardnumber->TooltipValue = "";
            if (!$this->isExport()) {
                $this->idcardnumber->ViewValue = $this->highlightValue($this->idcardnumber);
            }

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";
            $this->_email->TooltipValue = "";
            if (!$this->isExport()) {
                $this->_email->ViewValue = $this->highlightValue($this->_email);
            }

            // phone
            $this->phone->LinkCustomAttributes = "";
            $this->phone->HrefValue = "";
            $this->phone->TooltipValue = "";
            if (!$this->isExport()) {
                $this->phone->ViewValue = $this->highlightValue($this->phone);
            }

            // isbuyer
            $this->isbuyer->LinkCustomAttributes = "";
            $this->isbuyer->HrefValue = "";
            $this->isbuyer->TooltipValue = "";

            // isinvertor
            $this->isinvertor->LinkCustomAttributes = "";
            $this->isinvertor->HrefValue = "";
            $this->isinvertor->TooltipValue = "";

            // issale
            $this->issale->LinkCustomAttributes = "";
            $this->issale->HrefValue = "";
            $this->issale->TooltipValue = "";

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
            $this->image_profile->TooltipValue = "";
            if ($this->image_profile->UseColorbox) {
                if (EmptyValue($this->image_profile->TooltipValue)) {
                    $this->image_profile->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->image_profile->LinkAttrs["data-rel"] = "member_x" . $this->RowCount . "_image_profile";
                $this->image_profile->LinkAttrs->appendClass("ew-lightbox");
            }

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
            $this->cdate->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // first_name
            $this->first_name->setupEditAttributes();
            $this->first_name->EditCustomAttributes = "";
            if (!$this->first_name->Raw) {
                $this->first_name->AdvancedSearch->SearchValue = HtmlDecode($this->first_name->AdvancedSearch->SearchValue);
            }
            $this->first_name->EditValue = HtmlEncode($this->first_name->AdvancedSearch->SearchValue);
            $this->first_name->PlaceHolder = RemoveHtml($this->first_name->caption());

            // last_name
            $this->last_name->setupEditAttributes();
            $this->last_name->EditCustomAttributes = "";
            if (!$this->last_name->Raw) {
                $this->last_name->AdvancedSearch->SearchValue = HtmlDecode($this->last_name->AdvancedSearch->SearchValue);
            }
            $this->last_name->EditValue = HtmlEncode($this->last_name->AdvancedSearch->SearchValue);
            $this->last_name->PlaceHolder = RemoveHtml($this->last_name->caption());

            // idcardnumber
            $this->idcardnumber->setupEditAttributes();
            $this->idcardnumber->EditCustomAttributes = "";
            if (!$this->idcardnumber->Raw) {
                $this->idcardnumber->AdvancedSearch->SearchValue = HtmlDecode($this->idcardnumber->AdvancedSearch->SearchValue);
            }
            $this->idcardnumber->EditValue = HtmlEncode($this->idcardnumber->AdvancedSearch->SearchValue);
            $this->idcardnumber->PlaceHolder = RemoveHtml($this->idcardnumber->caption());

            // email
            $this->_email->setupEditAttributes();
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->AdvancedSearch->SearchValue = HtmlDecode($this->_email->AdvancedSearch->SearchValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->AdvancedSearch->SearchValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // phone
            $this->phone->setupEditAttributes();
            $this->phone->EditCustomAttributes = "";
            if (!$this->phone->Raw) {
                $this->phone->AdvancedSearch->SearchValue = HtmlDecode($this->phone->AdvancedSearch->SearchValue);
            }
            $this->phone->EditValue = HtmlEncode($this->phone->AdvancedSearch->SearchValue);
            $this->phone->PlaceHolder = RemoveHtml($this->phone->caption());

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

            // image_profile
            $this->image_profile->setupEditAttributes();
            $this->image_profile->EditCustomAttributes = "";
            if (!$this->image_profile->Raw) {
                $this->image_profile->AdvancedSearch->SearchValue = HtmlDecode($this->image_profile->AdvancedSearch->SearchValue);
            }
            $this->image_profile->EditValue = HtmlEncode($this->image_profile->AdvancedSearch->SearchValue);
            $this->image_profile->PlaceHolder = RemoveHtml($this->image_profile->caption());

            // cdate
            $this->cdate->setupEditAttributes();
            $this->cdate->EditCustomAttributes = "";
            $this->cdate->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->cdate->AdvancedSearch->SearchValue, $this->cdate->formatPattern()), $this->cdate->formatPattern()));
            $this->cdate->PlaceHolder = RemoveHtml($this->cdate->caption());
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if (!CheckDate($this->cdate->AdvancedSearch->SearchValue, $this->cdate->formatPattern())) {
            $this->cdate->addErrorMessage($this->cdate->getErrorMessage(false));
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->member_id->AdvancedSearch->load();
        $this->first_name->AdvancedSearch->load();
        $this->last_name->AdvancedSearch->load();
        $this->idcardnumber->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->phone->AdvancedSearch->load();
        $this->facebook_id->AdvancedSearch->load();
        $this->line_id->AdvancedSearch->load();
        $this->google_id->AdvancedSearch->load();
        $this->type->AdvancedSearch->load();
        $this->isactive->AdvancedSearch->load();
        $this->isbuyer->AdvancedSearch->load();
        $this->isinvertor->AdvancedSearch->load();
        $this->issale->AdvancedSearch->load();
        $this->isnotification->AdvancedSearch->load();
        $this->image_profile->AdvancedSearch->load();
        $this->customer_id->AdvancedSearch->load();
        $this->verify_key->AdvancedSearch->load();
        $this->verify_status->AdvancedSearch->load();
        $this->verify_date->AdvancedSearch->load();
        $this->verify_ip->AdvancedSearch->load();
        $this->reset_password_date->AdvancedSearch->load();
        $this->reset_password_ip->AdvancedSearch->load();
        $this->reset_password_email_code->AdvancedSearch->load();
        $this->reset_password_email_date->AdvancedSearch->load();
        $this->reset_password_email_ip->AdvancedSearch->load();
        $this->resetTimestamp->AdvancedSearch->load();
        $this->resetKeyTimestamp->AdvancedSearch->load();
        $this->reset_password_code->AdvancedSearch->load();
        $this->pipedrive_people_id->AdvancedSearch->load();
        $this->cdate->AdvancedSearch->load();
        $this->cip->AdvancedSearch->load();
        $this->cuser->AdvancedSearch->load();
        $this->udate->AdvancedSearch->load();
        $this->uip->AdvancedSearch->load();
        $this->uuser->AdvancedSearch->load();
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" form=\"fmemberlist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" form=\"fmemberlist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" form=\"fmemberlist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\">" . $Language->phrase("ExportToPdf") . "</a>";
            }
        } elseif (SameText($type, "html")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-html\" title=\"" . HtmlEncode($Language->phrase("ExportToHtmlText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToHtmlText")) . "\">" . $Language->phrase("ExportToHtml") . "</a>";
        } elseif (SameText($type, "xml")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-xml\" title=\"" . HtmlEncode($Language->phrase("ExportToXmlText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToXmlText")) . "\">" . $Language->phrase("ExportToXml") . "</a>";
        } elseif (SameText($type, "csv")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-csv\" title=\"" . HtmlEncode($Language->phrase("ExportToCsvText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToCsvText")) . "\">" . $Language->phrase("ExportToCsv") . "</a>";
        } elseif (SameText($type, "email")) {
            $url = $custom ? ' data-url="' . $exportUrl . '"' : '';
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" form="fmemberlist" data-ew-action="email" data-hdr="' . $Language->phrase("ExportToEmailText") . '" data-sel="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("ExportToPrintText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPrintText")) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = false;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = true;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = false;

        // Export to HTML
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html");
        $item->Visible = false;

        // Export to XML
        $item = &$this->ExportOptions->add("xml");
        $item->Body = $this->getExportTag("xml");
        $item->Visible = false;

        // Export to CSV
        $item = &$this->ExportOptions->add("csv");
        $item->Body = $this->getExportTag("csv");
        $item->Visible = false;

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = false;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = false;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl();
        $this->SearchOptions = new ListOptions(["TagClassName" => "ew-search-option"]);

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fmembersrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Search highlight button
        $item = &$this->SearchOptions->add("searchhighlight");
        $item->Body = "<a class=\"btn btn-default ew-highlight active\" role=\"button\" title=\"" . $Language->phrase("Highlight") . "\" data-caption=\"" . $Language->phrase("Highlight") . "\" data-ew-action=\"highlight\" data-form=\"fmembersrch\" data-name=\"" . $this->highlightName() . "\">" . $Language->phrase("HighlightBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != "" && $this->TotalRecords > 0);

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction) {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Check if any search fields
    public function hasSearchFields()
    {
        return $this->first_name->Visible || $this->last_name->Visible || $this->idcardnumber->Visible || $this->_email->Visible || $this->phone->Visible || $this->isbuyer->Visible || $this->isinvertor->Visible || $this->issale->Visible || $this->cdate->Visible;
    }

    // Render search options
    protected function renderSearchOptions()
    {
        if (!$this->hasSearchFields() && $this->SearchOptions["searchtoggle"]) {
            $this->SearchOptions["searchtoggle"]->Visible = false;
        }
    }

    /**
    * Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
    *
    * @param bool $return Return the data rather than output it
    * @return mixed
    */
    public function exportData($return = false)
    {
        global $Language;
        $utf8 = SameText(Config("PROJECT_CHARSET"), "utf-8");

        // Load recordset
        $this->TotalRecords = $this->listRecordCount();
        $this->StartRecord = 1;

        // Export all
        if ($this->ExportAll) {
            if (Config("EXPORT_ALL_TIME_LIMIT") >= 0) {
                @set_time_limit(Config("EXPORT_ALL_TIME_LIMIT"));
            }
            $this->DisplayRecords = $this->TotalRecords;
            $this->StopRecord = $this->TotalRecords;
        } else { // Export one page only
            $this->setupStartRecord(); // Set up start record position
            // Set the last record to display
            if ($this->DisplayRecords <= 0) {
                $this->StopRecord = $this->TotalRecords;
            } else {
                $this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
            }
        }
        $rs = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords);
        $this->ExportDoc = GetExportDocument($this, "h");
        $doc = &$this->ExportDoc;
        if (!$doc) {
            $this->setFailureMessage($Language->phrase("ExportClassNotFound")); // Export class not found
        }
        if (!$rs || !$doc) {
            RemoveHeader("Content-Type"); // Remove header
            RemoveHeader("Content-Disposition");
            $this->showMessage();
            return;
        }
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords;

        // Call Page Exporting server event
        $this->ExportDoc->ExportCustom = !$this->pageExporting();
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        $doc->Text .= $header;
        $this->exportDocument($doc, $rs, $this->StartRecord, $this->StopRecord, "");
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        $doc->Text .= $footer;

        // Close recordset
        $rs->close();

        // Call Page Exported server event
        $this->pageExported();

        // Export header and footer
        $doc->exportHeaderAndFooter();

        // Clean output buffer (without destroying output buffer)
        $buffer = ob_get_contents(); // Save the output buffer
        if (!Config("DEBUG") && $buffer) {
            ob_clean();
        }

        // Write debug message if enabled
        if (Config("DEBUG") && !$this->isExport("pdf")) {
            echo GetDebugMessage();
        }

        // Output data
        if ($this->isExport("email")) {
            // Export-to-email disabled
        } else {
            $doc->export();
            if ($return) {
                RemoveHeader("Content-Type"); // Remove header
                RemoveHeader("Content-Disposition");
                $content = ob_get_contents();
                if ($content) {
                    ob_clean();
                }
                if ($buffer) {
                    echo $buffer; // Resume the output buffer
                }
                return $content;
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
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

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }

    // Page Importing event
    public function pageImporting($reader, &$options)
    {
        //var_dump($reader); // Import data reader
        //var_dump($options); // Show all options for importing
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($reader, $results)
    {
        //var_dump($reader); // Import data reader
        //var_dump($results); // Import results
    }
}
