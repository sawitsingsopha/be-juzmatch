<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class MemberScbList extends MemberScb
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'member_scb';

    // Page object name
    public $PageObjName = "MemberScbList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fmember_scblist";
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

        // Table object (member_scb)
        if (!isset($GLOBALS["member_scb"]) || get_class($GLOBALS["member_scb"]) == PROJECT_NAMESPACE . "member_scb") {
            $GLOBALS["member_scb"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "memberscbadd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "memberscbdelete";
        $this->MultiUpdateUrl = "memberscbupdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'member_scb');
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
                $tbl = Container("member_scb");
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
            $key .= @$ar['member_scb_id'];
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
            $this->member_scb_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->cdate->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->cuser->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->cip->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->udate->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->uuser->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->uip->Visible = false;
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
        $this->member_scb_id->Visible = false;
        $this->member_id->setVisibility();
        $this->asset_id->setVisibility();
        $this->reference_id->setVisibility();
        $this->reference_url->setVisibility();
        $this->refreshtoken->Visible = false;
        $this->auth_code->Visible = false;
        $this->_token->Visible = false;
        $this->state->setVisibility();
        $this->status->setVisibility();
        $this->at_expire_in->Visible = false;
        $this->rt_expire_in->Visible = false;
        $this->decision_status->setVisibility();
        $this->decision_timestamp->Visible = false;
        $this->deposit_amount->Visible = false;
        $this->due_date->Visible = false;
        $this->rental_fee->Visible = false;
        $this->cdate->setVisibility();
        $this->cuser->Visible = false;
        $this->cip->Visible = false;
        $this->udate->Visible = false;
        $this->uuser->Visible = false;
        $this->uip->Visible = false;
        $this->fullName->setVisibility();
        $this->age->setVisibility();
        $this->maritalStatus->setVisibility();
        $this->noOfChildren->setVisibility();
        $this->educationLevel->setVisibility();
        $this->workplace->setVisibility();
        $this->occupation->setVisibility();
        $this->jobPosition->setVisibility();
        $this->submissionDate->setVisibility();
        $this->bankruptcy_tendency->setVisibility();
        $this->blacklist_tendency->setVisibility();
        $this->money_laundering_tendency->setVisibility();
        $this->mobile_fraud_behavior->setVisibility();
        $this->face_similarity_score->setVisibility();
        $this->identification_verification_matched_flag->setVisibility();
        $this->bankstatement_confident_score->setVisibility();
        $this->estimated_monthly_income->setVisibility();
        $this->estimated_monthly_debt->setVisibility();
        $this->income_stability->setVisibility();
        $this->customer_grade->setVisibility();
        $this->color_sign->setVisibility();
        $this->rental_period->setVisibility();
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
        $this->setupLookupOptions($this->member_id);
        $this->setupLookupOptions($this->asset_id);

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
            AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));
            AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(true));

            // Get basic search values
            $this->loadBasicSearchValues();

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

            // Get basic search criteria
            if (!$this->hasInvalidFields()) {
                $srchBasic = $this->basicSearchWhere();
            }

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
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere();
            }

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
            $savedFilterList = $UserProfile->getSearchFilters(CurrentUserName(), "fmember_scbsrch");
        }
        $filterList = Concat($filterList, $this->member_id->AdvancedSearch->toJson(), ","); // Field member_id
        $filterList = Concat($filterList, $this->asset_id->AdvancedSearch->toJson(), ","); // Field asset_id
        $filterList = Concat($filterList, $this->reference_id->AdvancedSearch->toJson(), ","); // Field reference_id
        $filterList = Concat($filterList, $this->reference_url->AdvancedSearch->toJson(), ","); // Field reference_url
        $filterList = Concat($filterList, $this->refreshtoken->AdvancedSearch->toJson(), ","); // Field refreshtoken
        $filterList = Concat($filterList, $this->auth_code->AdvancedSearch->toJson(), ","); // Field auth_code
        $filterList = Concat($filterList, $this->_token->AdvancedSearch->toJson(), ","); // Field token
        $filterList = Concat($filterList, $this->state->AdvancedSearch->toJson(), ","); // Field state
        $filterList = Concat($filterList, $this->status->AdvancedSearch->toJson(), ","); // Field status
        $filterList = Concat($filterList, $this->at_expire_in->AdvancedSearch->toJson(), ","); // Field at_expire_in
        $filterList = Concat($filterList, $this->rt_expire_in->AdvancedSearch->toJson(), ","); // Field rt_expire_in
        $filterList = Concat($filterList, $this->decision_status->AdvancedSearch->toJson(), ","); // Field decision_status
        $filterList = Concat($filterList, $this->decision_timestamp->AdvancedSearch->toJson(), ","); // Field decision_timestamp
        $filterList = Concat($filterList, $this->deposit_amount->AdvancedSearch->toJson(), ","); // Field deposit_amount
        $filterList = Concat($filterList, $this->due_date->AdvancedSearch->toJson(), ","); // Field due_date
        $filterList = Concat($filterList, $this->rental_fee->AdvancedSearch->toJson(), ","); // Field rental_fee
        $filterList = Concat($filterList, $this->cdate->AdvancedSearch->toJson(), ","); // Field cdate
        $filterList = Concat($filterList, $this->cuser->AdvancedSearch->toJson(), ","); // Field cuser
        $filterList = Concat($filterList, $this->cip->AdvancedSearch->toJson(), ","); // Field cip
        $filterList = Concat($filterList, $this->udate->AdvancedSearch->toJson(), ","); // Field udate
        $filterList = Concat($filterList, $this->uuser->AdvancedSearch->toJson(), ","); // Field uuser
        $filterList = Concat($filterList, $this->uip->AdvancedSearch->toJson(), ","); // Field uip
        $filterList = Concat($filterList, $this->fullName->AdvancedSearch->toJson(), ","); // Field fullName
        $filterList = Concat($filterList, $this->age->AdvancedSearch->toJson(), ","); // Field age
        $filterList = Concat($filterList, $this->maritalStatus->AdvancedSearch->toJson(), ","); // Field maritalStatus
        $filterList = Concat($filterList, $this->noOfChildren->AdvancedSearch->toJson(), ","); // Field noOfChildren
        $filterList = Concat($filterList, $this->educationLevel->AdvancedSearch->toJson(), ","); // Field educationLevel
        $filterList = Concat($filterList, $this->workplace->AdvancedSearch->toJson(), ","); // Field workplace
        $filterList = Concat($filterList, $this->occupation->AdvancedSearch->toJson(), ","); // Field occupation
        $filterList = Concat($filterList, $this->jobPosition->AdvancedSearch->toJson(), ","); // Field jobPosition
        $filterList = Concat($filterList, $this->submissionDate->AdvancedSearch->toJson(), ","); // Field submissionDate
        $filterList = Concat($filterList, $this->bankruptcy_tendency->AdvancedSearch->toJson(), ","); // Field bankruptcy_tendency
        $filterList = Concat($filterList, $this->blacklist_tendency->AdvancedSearch->toJson(), ","); // Field blacklist_tendency
        $filterList = Concat($filterList, $this->money_laundering_tendency->AdvancedSearch->toJson(), ","); // Field money_laundering_tendency
        $filterList = Concat($filterList, $this->mobile_fraud_behavior->AdvancedSearch->toJson(), ","); // Field mobile_fraud_behavior
        $filterList = Concat($filterList, $this->face_similarity_score->AdvancedSearch->toJson(), ","); // Field face_similarity_score
        $filterList = Concat($filterList, $this->identification_verification_matched_flag->AdvancedSearch->toJson(), ","); // Field identification_verification_matched_flag
        $filterList = Concat($filterList, $this->bankstatement_confident_score->AdvancedSearch->toJson(), ","); // Field bankstatement_confident_score
        $filterList = Concat($filterList, $this->estimated_monthly_income->AdvancedSearch->toJson(), ","); // Field estimated_monthly_income
        $filterList = Concat($filterList, $this->estimated_monthly_debt->AdvancedSearch->toJson(), ","); // Field estimated_monthly_debt
        $filterList = Concat($filterList, $this->income_stability->AdvancedSearch->toJson(), ","); // Field income_stability
        $filterList = Concat($filterList, $this->customer_grade->AdvancedSearch->toJson(), ","); // Field customer_grade
        $filterList = Concat($filterList, $this->color_sign->AdvancedSearch->toJson(), ","); // Field color_sign
        $filterList = Concat($filterList, $this->rental_period->AdvancedSearch->toJson(), ","); // Field rental_period
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

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
            $UserProfile->setSearchFilters(CurrentUserName(), "fmember_scbsrch", $filters);
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

        // Field asset_id
        $this->asset_id->AdvancedSearch->SearchValue = @$filter["x_asset_id"];
        $this->asset_id->AdvancedSearch->SearchOperator = @$filter["z_asset_id"];
        $this->asset_id->AdvancedSearch->SearchCondition = @$filter["v_asset_id"];
        $this->asset_id->AdvancedSearch->SearchValue2 = @$filter["y_asset_id"];
        $this->asset_id->AdvancedSearch->SearchOperator2 = @$filter["w_asset_id"];
        $this->asset_id->AdvancedSearch->save();

        // Field reference_id
        $this->reference_id->AdvancedSearch->SearchValue = @$filter["x_reference_id"];
        $this->reference_id->AdvancedSearch->SearchOperator = @$filter["z_reference_id"];
        $this->reference_id->AdvancedSearch->SearchCondition = @$filter["v_reference_id"];
        $this->reference_id->AdvancedSearch->SearchValue2 = @$filter["y_reference_id"];
        $this->reference_id->AdvancedSearch->SearchOperator2 = @$filter["w_reference_id"];
        $this->reference_id->AdvancedSearch->save();

        // Field reference_url
        $this->reference_url->AdvancedSearch->SearchValue = @$filter["x_reference_url"];
        $this->reference_url->AdvancedSearch->SearchOperator = @$filter["z_reference_url"];
        $this->reference_url->AdvancedSearch->SearchCondition = @$filter["v_reference_url"];
        $this->reference_url->AdvancedSearch->SearchValue2 = @$filter["y_reference_url"];
        $this->reference_url->AdvancedSearch->SearchOperator2 = @$filter["w_reference_url"];
        $this->reference_url->AdvancedSearch->save();

        // Field refreshtoken
        $this->refreshtoken->AdvancedSearch->SearchValue = @$filter["x_refreshtoken"];
        $this->refreshtoken->AdvancedSearch->SearchOperator = @$filter["z_refreshtoken"];
        $this->refreshtoken->AdvancedSearch->SearchCondition = @$filter["v_refreshtoken"];
        $this->refreshtoken->AdvancedSearch->SearchValue2 = @$filter["y_refreshtoken"];
        $this->refreshtoken->AdvancedSearch->SearchOperator2 = @$filter["w_refreshtoken"];
        $this->refreshtoken->AdvancedSearch->save();

        // Field auth_code
        $this->auth_code->AdvancedSearch->SearchValue = @$filter["x_auth_code"];
        $this->auth_code->AdvancedSearch->SearchOperator = @$filter["z_auth_code"];
        $this->auth_code->AdvancedSearch->SearchCondition = @$filter["v_auth_code"];
        $this->auth_code->AdvancedSearch->SearchValue2 = @$filter["y_auth_code"];
        $this->auth_code->AdvancedSearch->SearchOperator2 = @$filter["w_auth_code"];
        $this->auth_code->AdvancedSearch->save();

        // Field token
        $this->_token->AdvancedSearch->SearchValue = @$filter["x__token"];
        $this->_token->AdvancedSearch->SearchOperator = @$filter["z__token"];
        $this->_token->AdvancedSearch->SearchCondition = @$filter["v__token"];
        $this->_token->AdvancedSearch->SearchValue2 = @$filter["y__token"];
        $this->_token->AdvancedSearch->SearchOperator2 = @$filter["w__token"];
        $this->_token->AdvancedSearch->save();

        // Field state
        $this->state->AdvancedSearch->SearchValue = @$filter["x_state"];
        $this->state->AdvancedSearch->SearchOperator = @$filter["z_state"];
        $this->state->AdvancedSearch->SearchCondition = @$filter["v_state"];
        $this->state->AdvancedSearch->SearchValue2 = @$filter["y_state"];
        $this->state->AdvancedSearch->SearchOperator2 = @$filter["w_state"];
        $this->state->AdvancedSearch->save();

        // Field status
        $this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
        $this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
        $this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
        $this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
        $this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
        $this->status->AdvancedSearch->save();

        // Field at_expire_in
        $this->at_expire_in->AdvancedSearch->SearchValue = @$filter["x_at_expire_in"];
        $this->at_expire_in->AdvancedSearch->SearchOperator = @$filter["z_at_expire_in"];
        $this->at_expire_in->AdvancedSearch->SearchCondition = @$filter["v_at_expire_in"];
        $this->at_expire_in->AdvancedSearch->SearchValue2 = @$filter["y_at_expire_in"];
        $this->at_expire_in->AdvancedSearch->SearchOperator2 = @$filter["w_at_expire_in"];
        $this->at_expire_in->AdvancedSearch->save();

        // Field rt_expire_in
        $this->rt_expire_in->AdvancedSearch->SearchValue = @$filter["x_rt_expire_in"];
        $this->rt_expire_in->AdvancedSearch->SearchOperator = @$filter["z_rt_expire_in"];
        $this->rt_expire_in->AdvancedSearch->SearchCondition = @$filter["v_rt_expire_in"];
        $this->rt_expire_in->AdvancedSearch->SearchValue2 = @$filter["y_rt_expire_in"];
        $this->rt_expire_in->AdvancedSearch->SearchOperator2 = @$filter["w_rt_expire_in"];
        $this->rt_expire_in->AdvancedSearch->save();

        // Field decision_status
        $this->decision_status->AdvancedSearch->SearchValue = @$filter["x_decision_status"];
        $this->decision_status->AdvancedSearch->SearchOperator = @$filter["z_decision_status"];
        $this->decision_status->AdvancedSearch->SearchCondition = @$filter["v_decision_status"];
        $this->decision_status->AdvancedSearch->SearchValue2 = @$filter["y_decision_status"];
        $this->decision_status->AdvancedSearch->SearchOperator2 = @$filter["w_decision_status"];
        $this->decision_status->AdvancedSearch->save();

        // Field decision_timestamp
        $this->decision_timestamp->AdvancedSearch->SearchValue = @$filter["x_decision_timestamp"];
        $this->decision_timestamp->AdvancedSearch->SearchOperator = @$filter["z_decision_timestamp"];
        $this->decision_timestamp->AdvancedSearch->SearchCondition = @$filter["v_decision_timestamp"];
        $this->decision_timestamp->AdvancedSearch->SearchValue2 = @$filter["y_decision_timestamp"];
        $this->decision_timestamp->AdvancedSearch->SearchOperator2 = @$filter["w_decision_timestamp"];
        $this->decision_timestamp->AdvancedSearch->save();

        // Field deposit_amount
        $this->deposit_amount->AdvancedSearch->SearchValue = @$filter["x_deposit_amount"];
        $this->deposit_amount->AdvancedSearch->SearchOperator = @$filter["z_deposit_amount"];
        $this->deposit_amount->AdvancedSearch->SearchCondition = @$filter["v_deposit_amount"];
        $this->deposit_amount->AdvancedSearch->SearchValue2 = @$filter["y_deposit_amount"];
        $this->deposit_amount->AdvancedSearch->SearchOperator2 = @$filter["w_deposit_amount"];
        $this->deposit_amount->AdvancedSearch->save();

        // Field due_date
        $this->due_date->AdvancedSearch->SearchValue = @$filter["x_due_date"];
        $this->due_date->AdvancedSearch->SearchOperator = @$filter["z_due_date"];
        $this->due_date->AdvancedSearch->SearchCondition = @$filter["v_due_date"];
        $this->due_date->AdvancedSearch->SearchValue2 = @$filter["y_due_date"];
        $this->due_date->AdvancedSearch->SearchOperator2 = @$filter["w_due_date"];
        $this->due_date->AdvancedSearch->save();

        // Field rental_fee
        $this->rental_fee->AdvancedSearch->SearchValue = @$filter["x_rental_fee"];
        $this->rental_fee->AdvancedSearch->SearchOperator = @$filter["z_rental_fee"];
        $this->rental_fee->AdvancedSearch->SearchCondition = @$filter["v_rental_fee"];
        $this->rental_fee->AdvancedSearch->SearchValue2 = @$filter["y_rental_fee"];
        $this->rental_fee->AdvancedSearch->SearchOperator2 = @$filter["w_rental_fee"];
        $this->rental_fee->AdvancedSearch->save();

        // Field cdate
        $this->cdate->AdvancedSearch->SearchValue = @$filter["x_cdate"];
        $this->cdate->AdvancedSearch->SearchOperator = @$filter["z_cdate"];
        $this->cdate->AdvancedSearch->SearchCondition = @$filter["v_cdate"];
        $this->cdate->AdvancedSearch->SearchValue2 = @$filter["y_cdate"];
        $this->cdate->AdvancedSearch->SearchOperator2 = @$filter["w_cdate"];
        $this->cdate->AdvancedSearch->save();

        // Field cuser
        $this->cuser->AdvancedSearch->SearchValue = @$filter["x_cuser"];
        $this->cuser->AdvancedSearch->SearchOperator = @$filter["z_cuser"];
        $this->cuser->AdvancedSearch->SearchCondition = @$filter["v_cuser"];
        $this->cuser->AdvancedSearch->SearchValue2 = @$filter["y_cuser"];
        $this->cuser->AdvancedSearch->SearchOperator2 = @$filter["w_cuser"];
        $this->cuser->AdvancedSearch->save();

        // Field cip
        $this->cip->AdvancedSearch->SearchValue = @$filter["x_cip"];
        $this->cip->AdvancedSearch->SearchOperator = @$filter["z_cip"];
        $this->cip->AdvancedSearch->SearchCondition = @$filter["v_cip"];
        $this->cip->AdvancedSearch->SearchValue2 = @$filter["y_cip"];
        $this->cip->AdvancedSearch->SearchOperator2 = @$filter["w_cip"];
        $this->cip->AdvancedSearch->save();

        // Field udate
        $this->udate->AdvancedSearch->SearchValue = @$filter["x_udate"];
        $this->udate->AdvancedSearch->SearchOperator = @$filter["z_udate"];
        $this->udate->AdvancedSearch->SearchCondition = @$filter["v_udate"];
        $this->udate->AdvancedSearch->SearchValue2 = @$filter["y_udate"];
        $this->udate->AdvancedSearch->SearchOperator2 = @$filter["w_udate"];
        $this->udate->AdvancedSearch->save();

        // Field uuser
        $this->uuser->AdvancedSearch->SearchValue = @$filter["x_uuser"];
        $this->uuser->AdvancedSearch->SearchOperator = @$filter["z_uuser"];
        $this->uuser->AdvancedSearch->SearchCondition = @$filter["v_uuser"];
        $this->uuser->AdvancedSearch->SearchValue2 = @$filter["y_uuser"];
        $this->uuser->AdvancedSearch->SearchOperator2 = @$filter["w_uuser"];
        $this->uuser->AdvancedSearch->save();

        // Field uip
        $this->uip->AdvancedSearch->SearchValue = @$filter["x_uip"];
        $this->uip->AdvancedSearch->SearchOperator = @$filter["z_uip"];
        $this->uip->AdvancedSearch->SearchCondition = @$filter["v_uip"];
        $this->uip->AdvancedSearch->SearchValue2 = @$filter["y_uip"];
        $this->uip->AdvancedSearch->SearchOperator2 = @$filter["w_uip"];
        $this->uip->AdvancedSearch->save();

        // Field fullName
        $this->fullName->AdvancedSearch->SearchValue = @$filter["x_fullName"];
        $this->fullName->AdvancedSearch->SearchOperator = @$filter["z_fullName"];
        $this->fullName->AdvancedSearch->SearchCondition = @$filter["v_fullName"];
        $this->fullName->AdvancedSearch->SearchValue2 = @$filter["y_fullName"];
        $this->fullName->AdvancedSearch->SearchOperator2 = @$filter["w_fullName"];
        $this->fullName->AdvancedSearch->save();

        // Field age
        $this->age->AdvancedSearch->SearchValue = @$filter["x_age"];
        $this->age->AdvancedSearch->SearchOperator = @$filter["z_age"];
        $this->age->AdvancedSearch->SearchCondition = @$filter["v_age"];
        $this->age->AdvancedSearch->SearchValue2 = @$filter["y_age"];
        $this->age->AdvancedSearch->SearchOperator2 = @$filter["w_age"];
        $this->age->AdvancedSearch->save();

        // Field maritalStatus
        $this->maritalStatus->AdvancedSearch->SearchValue = @$filter["x_maritalStatus"];
        $this->maritalStatus->AdvancedSearch->SearchOperator = @$filter["z_maritalStatus"];
        $this->maritalStatus->AdvancedSearch->SearchCondition = @$filter["v_maritalStatus"];
        $this->maritalStatus->AdvancedSearch->SearchValue2 = @$filter["y_maritalStatus"];
        $this->maritalStatus->AdvancedSearch->SearchOperator2 = @$filter["w_maritalStatus"];
        $this->maritalStatus->AdvancedSearch->save();

        // Field noOfChildren
        $this->noOfChildren->AdvancedSearch->SearchValue = @$filter["x_noOfChildren"];
        $this->noOfChildren->AdvancedSearch->SearchOperator = @$filter["z_noOfChildren"];
        $this->noOfChildren->AdvancedSearch->SearchCondition = @$filter["v_noOfChildren"];
        $this->noOfChildren->AdvancedSearch->SearchValue2 = @$filter["y_noOfChildren"];
        $this->noOfChildren->AdvancedSearch->SearchOperator2 = @$filter["w_noOfChildren"];
        $this->noOfChildren->AdvancedSearch->save();

        // Field educationLevel
        $this->educationLevel->AdvancedSearch->SearchValue = @$filter["x_educationLevel"];
        $this->educationLevel->AdvancedSearch->SearchOperator = @$filter["z_educationLevel"];
        $this->educationLevel->AdvancedSearch->SearchCondition = @$filter["v_educationLevel"];
        $this->educationLevel->AdvancedSearch->SearchValue2 = @$filter["y_educationLevel"];
        $this->educationLevel->AdvancedSearch->SearchOperator2 = @$filter["w_educationLevel"];
        $this->educationLevel->AdvancedSearch->save();

        // Field workplace
        $this->workplace->AdvancedSearch->SearchValue = @$filter["x_workplace"];
        $this->workplace->AdvancedSearch->SearchOperator = @$filter["z_workplace"];
        $this->workplace->AdvancedSearch->SearchCondition = @$filter["v_workplace"];
        $this->workplace->AdvancedSearch->SearchValue2 = @$filter["y_workplace"];
        $this->workplace->AdvancedSearch->SearchOperator2 = @$filter["w_workplace"];
        $this->workplace->AdvancedSearch->save();

        // Field occupation
        $this->occupation->AdvancedSearch->SearchValue = @$filter["x_occupation"];
        $this->occupation->AdvancedSearch->SearchOperator = @$filter["z_occupation"];
        $this->occupation->AdvancedSearch->SearchCondition = @$filter["v_occupation"];
        $this->occupation->AdvancedSearch->SearchValue2 = @$filter["y_occupation"];
        $this->occupation->AdvancedSearch->SearchOperator2 = @$filter["w_occupation"];
        $this->occupation->AdvancedSearch->save();

        // Field jobPosition
        $this->jobPosition->AdvancedSearch->SearchValue = @$filter["x_jobPosition"];
        $this->jobPosition->AdvancedSearch->SearchOperator = @$filter["z_jobPosition"];
        $this->jobPosition->AdvancedSearch->SearchCondition = @$filter["v_jobPosition"];
        $this->jobPosition->AdvancedSearch->SearchValue2 = @$filter["y_jobPosition"];
        $this->jobPosition->AdvancedSearch->SearchOperator2 = @$filter["w_jobPosition"];
        $this->jobPosition->AdvancedSearch->save();

        // Field submissionDate
        $this->submissionDate->AdvancedSearch->SearchValue = @$filter["x_submissionDate"];
        $this->submissionDate->AdvancedSearch->SearchOperator = @$filter["z_submissionDate"];
        $this->submissionDate->AdvancedSearch->SearchCondition = @$filter["v_submissionDate"];
        $this->submissionDate->AdvancedSearch->SearchValue2 = @$filter["y_submissionDate"];
        $this->submissionDate->AdvancedSearch->SearchOperator2 = @$filter["w_submissionDate"];
        $this->submissionDate->AdvancedSearch->save();

        // Field bankruptcy_tendency
        $this->bankruptcy_tendency->AdvancedSearch->SearchValue = @$filter["x_bankruptcy_tendency"];
        $this->bankruptcy_tendency->AdvancedSearch->SearchOperator = @$filter["z_bankruptcy_tendency"];
        $this->bankruptcy_tendency->AdvancedSearch->SearchCondition = @$filter["v_bankruptcy_tendency"];
        $this->bankruptcy_tendency->AdvancedSearch->SearchValue2 = @$filter["y_bankruptcy_tendency"];
        $this->bankruptcy_tendency->AdvancedSearch->SearchOperator2 = @$filter["w_bankruptcy_tendency"];
        $this->bankruptcy_tendency->AdvancedSearch->save();

        // Field blacklist_tendency
        $this->blacklist_tendency->AdvancedSearch->SearchValue = @$filter["x_blacklist_tendency"];
        $this->blacklist_tendency->AdvancedSearch->SearchOperator = @$filter["z_blacklist_tendency"];
        $this->blacklist_tendency->AdvancedSearch->SearchCondition = @$filter["v_blacklist_tendency"];
        $this->blacklist_tendency->AdvancedSearch->SearchValue2 = @$filter["y_blacklist_tendency"];
        $this->blacklist_tendency->AdvancedSearch->SearchOperator2 = @$filter["w_blacklist_tendency"];
        $this->blacklist_tendency->AdvancedSearch->save();

        // Field money_laundering_tendency
        $this->money_laundering_tendency->AdvancedSearch->SearchValue = @$filter["x_money_laundering_tendency"];
        $this->money_laundering_tendency->AdvancedSearch->SearchOperator = @$filter["z_money_laundering_tendency"];
        $this->money_laundering_tendency->AdvancedSearch->SearchCondition = @$filter["v_money_laundering_tendency"];
        $this->money_laundering_tendency->AdvancedSearch->SearchValue2 = @$filter["y_money_laundering_tendency"];
        $this->money_laundering_tendency->AdvancedSearch->SearchOperator2 = @$filter["w_money_laundering_tendency"];
        $this->money_laundering_tendency->AdvancedSearch->save();

        // Field mobile_fraud_behavior
        $this->mobile_fraud_behavior->AdvancedSearch->SearchValue = @$filter["x_mobile_fraud_behavior"];
        $this->mobile_fraud_behavior->AdvancedSearch->SearchOperator = @$filter["z_mobile_fraud_behavior"];
        $this->mobile_fraud_behavior->AdvancedSearch->SearchCondition = @$filter["v_mobile_fraud_behavior"];
        $this->mobile_fraud_behavior->AdvancedSearch->SearchValue2 = @$filter["y_mobile_fraud_behavior"];
        $this->mobile_fraud_behavior->AdvancedSearch->SearchOperator2 = @$filter["w_mobile_fraud_behavior"];
        $this->mobile_fraud_behavior->AdvancedSearch->save();

        // Field face_similarity_score
        $this->face_similarity_score->AdvancedSearch->SearchValue = @$filter["x_face_similarity_score"];
        $this->face_similarity_score->AdvancedSearch->SearchOperator = @$filter["z_face_similarity_score"];
        $this->face_similarity_score->AdvancedSearch->SearchCondition = @$filter["v_face_similarity_score"];
        $this->face_similarity_score->AdvancedSearch->SearchValue2 = @$filter["y_face_similarity_score"];
        $this->face_similarity_score->AdvancedSearch->SearchOperator2 = @$filter["w_face_similarity_score"];
        $this->face_similarity_score->AdvancedSearch->save();

        // Field identification_verification_matched_flag
        $this->identification_verification_matched_flag->AdvancedSearch->SearchValue = @$filter["x_identification_verification_matched_flag"];
        $this->identification_verification_matched_flag->AdvancedSearch->SearchOperator = @$filter["z_identification_verification_matched_flag"];
        $this->identification_verification_matched_flag->AdvancedSearch->SearchCondition = @$filter["v_identification_verification_matched_flag"];
        $this->identification_verification_matched_flag->AdvancedSearch->SearchValue2 = @$filter["y_identification_verification_matched_flag"];
        $this->identification_verification_matched_flag->AdvancedSearch->SearchOperator2 = @$filter["w_identification_verification_matched_flag"];
        $this->identification_verification_matched_flag->AdvancedSearch->save();

        // Field bankstatement_confident_score
        $this->bankstatement_confident_score->AdvancedSearch->SearchValue = @$filter["x_bankstatement_confident_score"];
        $this->bankstatement_confident_score->AdvancedSearch->SearchOperator = @$filter["z_bankstatement_confident_score"];
        $this->bankstatement_confident_score->AdvancedSearch->SearchCondition = @$filter["v_bankstatement_confident_score"];
        $this->bankstatement_confident_score->AdvancedSearch->SearchValue2 = @$filter["y_bankstatement_confident_score"];
        $this->bankstatement_confident_score->AdvancedSearch->SearchOperator2 = @$filter["w_bankstatement_confident_score"];
        $this->bankstatement_confident_score->AdvancedSearch->save();

        // Field estimated_monthly_income
        $this->estimated_monthly_income->AdvancedSearch->SearchValue = @$filter["x_estimated_monthly_income"];
        $this->estimated_monthly_income->AdvancedSearch->SearchOperator = @$filter["z_estimated_monthly_income"];
        $this->estimated_monthly_income->AdvancedSearch->SearchCondition = @$filter["v_estimated_monthly_income"];
        $this->estimated_monthly_income->AdvancedSearch->SearchValue2 = @$filter["y_estimated_monthly_income"];
        $this->estimated_monthly_income->AdvancedSearch->SearchOperator2 = @$filter["w_estimated_monthly_income"];
        $this->estimated_monthly_income->AdvancedSearch->save();

        // Field estimated_monthly_debt
        $this->estimated_monthly_debt->AdvancedSearch->SearchValue = @$filter["x_estimated_monthly_debt"];
        $this->estimated_monthly_debt->AdvancedSearch->SearchOperator = @$filter["z_estimated_monthly_debt"];
        $this->estimated_monthly_debt->AdvancedSearch->SearchCondition = @$filter["v_estimated_monthly_debt"];
        $this->estimated_monthly_debt->AdvancedSearch->SearchValue2 = @$filter["y_estimated_monthly_debt"];
        $this->estimated_monthly_debt->AdvancedSearch->SearchOperator2 = @$filter["w_estimated_monthly_debt"];
        $this->estimated_monthly_debt->AdvancedSearch->save();

        // Field income_stability
        $this->income_stability->AdvancedSearch->SearchValue = @$filter["x_income_stability"];
        $this->income_stability->AdvancedSearch->SearchOperator = @$filter["z_income_stability"];
        $this->income_stability->AdvancedSearch->SearchCondition = @$filter["v_income_stability"];
        $this->income_stability->AdvancedSearch->SearchValue2 = @$filter["y_income_stability"];
        $this->income_stability->AdvancedSearch->SearchOperator2 = @$filter["w_income_stability"];
        $this->income_stability->AdvancedSearch->save();

        // Field customer_grade
        $this->customer_grade->AdvancedSearch->SearchValue = @$filter["x_customer_grade"];
        $this->customer_grade->AdvancedSearch->SearchOperator = @$filter["z_customer_grade"];
        $this->customer_grade->AdvancedSearch->SearchCondition = @$filter["v_customer_grade"];
        $this->customer_grade->AdvancedSearch->SearchValue2 = @$filter["y_customer_grade"];
        $this->customer_grade->AdvancedSearch->SearchOperator2 = @$filter["w_customer_grade"];
        $this->customer_grade->AdvancedSearch->save();

        // Field color_sign
        $this->color_sign->AdvancedSearch->SearchValue = @$filter["x_color_sign"];
        $this->color_sign->AdvancedSearch->SearchOperator = @$filter["z_color_sign"];
        $this->color_sign->AdvancedSearch->SearchCondition = @$filter["v_color_sign"];
        $this->color_sign->AdvancedSearch->SearchValue2 = @$filter["y_color_sign"];
        $this->color_sign->AdvancedSearch->SearchOperator2 = @$filter["w_color_sign"];
        $this->color_sign->AdvancedSearch->save();

        // Field rental_period
        $this->rental_period->AdvancedSearch->SearchValue = @$filter["x_rental_period"];
        $this->rental_period->AdvancedSearch->SearchOperator = @$filter["z_rental_period"];
        $this->rental_period->AdvancedSearch->SearchCondition = @$filter["v_rental_period"];
        $this->rental_period->AdvancedSearch->SearchValue2 = @$filter["y_rental_period"];
        $this->rental_period->AdvancedSearch->SearchOperator2 = @$filter["w_rental_period"];
        $this->rental_period->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
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
        $this->buildSearchSql($where, $this->asset_id, $default, false); // asset_id
        $this->buildSearchSql($where, $this->reference_id, $default, false); // reference_id
        $this->buildSearchSql($where, $this->reference_url, $default, false); // reference_url
        $this->buildSearchSql($where, $this->refreshtoken, $default, false); // refreshtoken
        $this->buildSearchSql($where, $this->auth_code, $default, false); // auth_code
        $this->buildSearchSql($where, $this->_token, $default, false); // token
        $this->buildSearchSql($where, $this->state, $default, false); // state
        $this->buildSearchSql($where, $this->status, $default, false); // status
        $this->buildSearchSql($where, $this->at_expire_in, $default, false); // at_expire_in
        $this->buildSearchSql($where, $this->rt_expire_in, $default, false); // rt_expire_in
        $this->buildSearchSql($where, $this->decision_status, $default, false); // decision_status
        $this->buildSearchSql($where, $this->decision_timestamp, $default, false); // decision_timestamp
        $this->buildSearchSql($where, $this->deposit_amount, $default, false); // deposit_amount
        $this->buildSearchSql($where, $this->due_date, $default, false); // due_date
        $this->buildSearchSql($where, $this->rental_fee, $default, false); // rental_fee
        $this->buildSearchSql($where, $this->cdate, $default, false); // cdate
        $this->buildSearchSql($where, $this->cuser, $default, false); // cuser
        $this->buildSearchSql($where, $this->cip, $default, false); // cip
        $this->buildSearchSql($where, $this->udate, $default, false); // udate
        $this->buildSearchSql($where, $this->uuser, $default, false); // uuser
        $this->buildSearchSql($where, $this->uip, $default, false); // uip
        $this->buildSearchSql($where, $this->fullName, $default, false); // fullName
        $this->buildSearchSql($where, $this->age, $default, false); // age
        $this->buildSearchSql($where, $this->maritalStatus, $default, false); // maritalStatus
        $this->buildSearchSql($where, $this->noOfChildren, $default, false); // noOfChildren
        $this->buildSearchSql($where, $this->educationLevel, $default, false); // educationLevel
        $this->buildSearchSql($where, $this->workplace, $default, false); // workplace
        $this->buildSearchSql($where, $this->occupation, $default, false); // occupation
        $this->buildSearchSql($where, $this->jobPosition, $default, false); // jobPosition
        $this->buildSearchSql($where, $this->submissionDate, $default, false); // submissionDate
        $this->buildSearchSql($where, $this->bankruptcy_tendency, $default, false); // bankruptcy_tendency
        $this->buildSearchSql($where, $this->blacklist_tendency, $default, false); // blacklist_tendency
        $this->buildSearchSql($where, $this->money_laundering_tendency, $default, false); // money_laundering_tendency
        $this->buildSearchSql($where, $this->mobile_fraud_behavior, $default, false); // mobile_fraud_behavior
        $this->buildSearchSql($where, $this->face_similarity_score, $default, false); // face_similarity_score
        $this->buildSearchSql($where, $this->identification_verification_matched_flag, $default, false); // identification_verification_matched_flag
        $this->buildSearchSql($where, $this->bankstatement_confident_score, $default, false); // bankstatement_confident_score
        $this->buildSearchSql($where, $this->estimated_monthly_income, $default, false); // estimated_monthly_income
        $this->buildSearchSql($where, $this->estimated_monthly_debt, $default, false); // estimated_monthly_debt
        $this->buildSearchSql($where, $this->income_stability, $default, false); // income_stability
        $this->buildSearchSql($where, $this->customer_grade, $default, false); // customer_grade
        $this->buildSearchSql($where, $this->color_sign, $default, false); // color_sign
        $this->buildSearchSql($where, $this->rental_period, $default, false); // rental_period

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->member_id->AdvancedSearch->save(); // member_id
            $this->asset_id->AdvancedSearch->save(); // asset_id
            $this->reference_id->AdvancedSearch->save(); // reference_id
            $this->reference_url->AdvancedSearch->save(); // reference_url
            $this->refreshtoken->AdvancedSearch->save(); // refreshtoken
            $this->auth_code->AdvancedSearch->save(); // auth_code
            $this->_token->AdvancedSearch->save(); // token
            $this->state->AdvancedSearch->save(); // state
            $this->status->AdvancedSearch->save(); // status
            $this->at_expire_in->AdvancedSearch->save(); // at_expire_in
            $this->rt_expire_in->AdvancedSearch->save(); // rt_expire_in
            $this->decision_status->AdvancedSearch->save(); // decision_status
            $this->decision_timestamp->AdvancedSearch->save(); // decision_timestamp
            $this->deposit_amount->AdvancedSearch->save(); // deposit_amount
            $this->due_date->AdvancedSearch->save(); // due_date
            $this->rental_fee->AdvancedSearch->save(); // rental_fee
            $this->cdate->AdvancedSearch->save(); // cdate
            $this->cuser->AdvancedSearch->save(); // cuser
            $this->cip->AdvancedSearch->save(); // cip
            $this->udate->AdvancedSearch->save(); // udate
            $this->uuser->AdvancedSearch->save(); // uuser
            $this->uip->AdvancedSearch->save(); // uip
            $this->fullName->AdvancedSearch->save(); // fullName
            $this->age->AdvancedSearch->save(); // age
            $this->maritalStatus->AdvancedSearch->save(); // maritalStatus
            $this->noOfChildren->AdvancedSearch->save(); // noOfChildren
            $this->educationLevel->AdvancedSearch->save(); // educationLevel
            $this->workplace->AdvancedSearch->save(); // workplace
            $this->occupation->AdvancedSearch->save(); // occupation
            $this->jobPosition->AdvancedSearch->save(); // jobPosition
            $this->submissionDate->AdvancedSearch->save(); // submissionDate
            $this->bankruptcy_tendency->AdvancedSearch->save(); // bankruptcy_tendency
            $this->blacklist_tendency->AdvancedSearch->save(); // blacklist_tendency
            $this->money_laundering_tendency->AdvancedSearch->save(); // money_laundering_tendency
            $this->mobile_fraud_behavior->AdvancedSearch->save(); // mobile_fraud_behavior
            $this->face_similarity_score->AdvancedSearch->save(); // face_similarity_score
            $this->identification_verification_matched_flag->AdvancedSearch->save(); // identification_verification_matched_flag
            $this->bankstatement_confident_score->AdvancedSearch->save(); // bankstatement_confident_score
            $this->estimated_monthly_income->AdvancedSearch->save(); // estimated_monthly_income
            $this->estimated_monthly_debt->AdvancedSearch->save(); // estimated_monthly_debt
            $this->income_stability->AdvancedSearch->save(); // income_stability
            $this->customer_grade->AdvancedSearch->save(); // customer_grade
            $this->color_sign->AdvancedSearch->save(); // color_sign
            $this->rental_period->AdvancedSearch->save(); // rental_period
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

    // Return basic search WHERE clause based on search keyword and type
    protected function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }

        // Fields to search
        $searchFlds = [];
        $searchFlds[] = &$this->reference_id;
        $searchFlds[] = &$this->reference_url;
        $searchFlds[] = &$this->state;
        $searchFlds[] = &$this->status;
        $searchFlds[] = &$this->decision_status;
        $searchFlds[] = &$this->fullName;
        $searchFlds[] = &$this->maritalStatus;
        $searchFlds[] = &$this->noOfChildren;
        $searchFlds[] = &$this->educationLevel;
        $searchFlds[] = &$this->workplace;
        $searchFlds[] = &$this->occupation;
        $searchFlds[] = &$this->jobPosition;
        $searchFlds[] = &$this->bankruptcy_tendency;
        $searchFlds[] = &$this->blacklist_tendency;
        $searchFlds[] = &$this->money_laundering_tendency;
        $searchFlds[] = &$this->mobile_fraud_behavior;
        $searchFlds[] = &$this->face_similarity_score;
        $searchFlds[] = &$this->identification_verification_matched_flag;
        $searchFlds[] = &$this->bankstatement_confident_score;
        $searchFlds[] = &$this->estimated_monthly_income;
        $searchFlds[] = &$this->estimated_monthly_debt;
        $searchFlds[] = &$this->income_stability;
        $searchFlds[] = &$this->customer_grade;
        $searchFlds[] = &$this->color_sign;
        $searchKeyword = $default ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = $default ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            $searchStr = GetQuickSearchFilter($searchFlds, $ar, $searchType, Config("BASIC_SEARCH_ANY_FIELDS"), $this->Dbid);
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        if ($this->member_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->asset_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->reference_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->reference_url->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->refreshtoken->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->auth_code->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_token->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->state->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->status->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->at_expire_in->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->rt_expire_in->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->decision_status->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->decision_timestamp->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->deposit_amount->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->due_date->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->rental_fee->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cdate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cuser->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cip->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->udate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->uuser->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->uip->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fullName->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->age->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->maritalStatus->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->noOfChildren->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->educationLevel->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->workplace->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->occupation->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->jobPosition->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->submissionDate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->bankruptcy_tendency->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->blacklist_tendency->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->money_laundering_tendency->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->mobile_fraud_behavior->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->face_similarity_score->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->identification_verification_matched_flag->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->bankstatement_confident_score->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->estimated_monthly_income->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->estimated_monthly_debt->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->income_stability->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->customer_grade->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->color_sign->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->rental_period->AdvancedSearch->issetSession()) {
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

        // Clear basic search parameters
        $this->resetBasicSearchParms();

        // Clear advanced search parameters
        $this->resetAdvancedSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Clear all advanced search parameters
    protected function resetAdvancedSearchParms()
    {
        $this->member_id->AdvancedSearch->unsetSession();
        $this->asset_id->AdvancedSearch->unsetSession();
        $this->reference_id->AdvancedSearch->unsetSession();
        $this->reference_url->AdvancedSearch->unsetSession();
        $this->refreshtoken->AdvancedSearch->unsetSession();
        $this->auth_code->AdvancedSearch->unsetSession();
        $this->_token->AdvancedSearch->unsetSession();
        $this->state->AdvancedSearch->unsetSession();
        $this->status->AdvancedSearch->unsetSession();
        $this->at_expire_in->AdvancedSearch->unsetSession();
        $this->rt_expire_in->AdvancedSearch->unsetSession();
        $this->decision_status->AdvancedSearch->unsetSession();
        $this->decision_timestamp->AdvancedSearch->unsetSession();
        $this->deposit_amount->AdvancedSearch->unsetSession();
        $this->due_date->AdvancedSearch->unsetSession();
        $this->rental_fee->AdvancedSearch->unsetSession();
        $this->cdate->AdvancedSearch->unsetSession();
        $this->cuser->AdvancedSearch->unsetSession();
        $this->cip->AdvancedSearch->unsetSession();
        $this->udate->AdvancedSearch->unsetSession();
        $this->uuser->AdvancedSearch->unsetSession();
        $this->uip->AdvancedSearch->unsetSession();
        $this->fullName->AdvancedSearch->unsetSession();
        $this->age->AdvancedSearch->unsetSession();
        $this->maritalStatus->AdvancedSearch->unsetSession();
        $this->noOfChildren->AdvancedSearch->unsetSession();
        $this->educationLevel->AdvancedSearch->unsetSession();
        $this->workplace->AdvancedSearch->unsetSession();
        $this->occupation->AdvancedSearch->unsetSession();
        $this->jobPosition->AdvancedSearch->unsetSession();
        $this->submissionDate->AdvancedSearch->unsetSession();
        $this->bankruptcy_tendency->AdvancedSearch->unsetSession();
        $this->blacklist_tendency->AdvancedSearch->unsetSession();
        $this->money_laundering_tendency->AdvancedSearch->unsetSession();
        $this->mobile_fraud_behavior->AdvancedSearch->unsetSession();
        $this->face_similarity_score->AdvancedSearch->unsetSession();
        $this->identification_verification_matched_flag->AdvancedSearch->unsetSession();
        $this->bankstatement_confident_score->AdvancedSearch->unsetSession();
        $this->estimated_monthly_income->AdvancedSearch->unsetSession();
        $this->estimated_monthly_debt->AdvancedSearch->unsetSession();
        $this->income_stability->AdvancedSearch->unsetSession();
        $this->customer_grade->AdvancedSearch->unsetSession();
        $this->color_sign->AdvancedSearch->unsetSession();
        $this->rental_period->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->member_id->AdvancedSearch->load();
        $this->asset_id->AdvancedSearch->load();
        $this->reference_id->AdvancedSearch->load();
        $this->reference_url->AdvancedSearch->load();
        $this->refreshtoken->AdvancedSearch->load();
        $this->auth_code->AdvancedSearch->load();
        $this->_token->AdvancedSearch->load();
        $this->state->AdvancedSearch->load();
        $this->status->AdvancedSearch->load();
        $this->at_expire_in->AdvancedSearch->load();
        $this->rt_expire_in->AdvancedSearch->load();
        $this->decision_status->AdvancedSearch->load();
        $this->decision_timestamp->AdvancedSearch->load();
        $this->deposit_amount->AdvancedSearch->load();
        $this->due_date->AdvancedSearch->load();
        $this->rental_fee->AdvancedSearch->load();
        $this->cdate->AdvancedSearch->load();
        $this->cuser->AdvancedSearch->load();
        $this->cip->AdvancedSearch->load();
        $this->udate->AdvancedSearch->load();
        $this->uuser->AdvancedSearch->load();
        $this->uip->AdvancedSearch->load();
        $this->fullName->AdvancedSearch->load();
        $this->age->AdvancedSearch->load();
        $this->maritalStatus->AdvancedSearch->load();
        $this->noOfChildren->AdvancedSearch->load();
        $this->educationLevel->AdvancedSearch->load();
        $this->workplace->AdvancedSearch->load();
        $this->occupation->AdvancedSearch->load();
        $this->jobPosition->AdvancedSearch->load();
        $this->submissionDate->AdvancedSearch->load();
        $this->bankruptcy_tendency->AdvancedSearch->load();
        $this->blacklist_tendency->AdvancedSearch->load();
        $this->money_laundering_tendency->AdvancedSearch->load();
        $this->mobile_fraud_behavior->AdvancedSearch->load();
        $this->face_similarity_score->AdvancedSearch->load();
        $this->identification_verification_matched_flag->AdvancedSearch->load();
        $this->bankstatement_confident_score->AdvancedSearch->load();
        $this->estimated_monthly_income->AdvancedSearch->load();
        $this->estimated_monthly_debt->AdvancedSearch->load();
        $this->income_stability->AdvancedSearch->load();
        $this->customer_grade->AdvancedSearch->load();
        $this->color_sign->AdvancedSearch->load();
        $this->rental_period->AdvancedSearch->load();
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
            $this->updateSort($this->member_id, $ctrl); // member_id
            $this->updateSort($this->asset_id, $ctrl); // asset_id
            $this->updateSort($this->reference_id, $ctrl); // reference_id
            $this->updateSort($this->reference_url, $ctrl); // reference_url
            $this->updateSort($this->state, $ctrl); // state
            $this->updateSort($this->status, $ctrl); // status
            $this->updateSort($this->decision_status, $ctrl); // decision_status
            $this->updateSort($this->cdate, $ctrl); // cdate
            $this->updateSort($this->fullName, $ctrl); // fullName
            $this->updateSort($this->age, $ctrl); // age
            $this->updateSort($this->maritalStatus, $ctrl); // maritalStatus
            $this->updateSort($this->noOfChildren, $ctrl); // noOfChildren
            $this->updateSort($this->educationLevel, $ctrl); // educationLevel
            $this->updateSort($this->workplace, $ctrl); // workplace
            $this->updateSort($this->occupation, $ctrl); // occupation
            $this->updateSort($this->jobPosition, $ctrl); // jobPosition
            $this->updateSort($this->submissionDate, $ctrl); // submissionDate
            $this->updateSort($this->bankruptcy_tendency, $ctrl); // bankruptcy_tendency
            $this->updateSort($this->blacklist_tendency, $ctrl); // blacklist_tendency
            $this->updateSort($this->money_laundering_tendency, $ctrl); // money_laundering_tendency
            $this->updateSort($this->mobile_fraud_behavior, $ctrl); // mobile_fraud_behavior
            $this->updateSort($this->face_similarity_score, $ctrl); // face_similarity_score
            $this->updateSort($this->identification_verification_matched_flag, $ctrl); // identification_verification_matched_flag
            $this->updateSort($this->bankstatement_confident_score, $ctrl); // bankstatement_confident_score
            $this->updateSort($this->estimated_monthly_income, $ctrl); // estimated_monthly_income
            $this->updateSort($this->estimated_monthly_debt, $ctrl); // estimated_monthly_debt
            $this->updateSort($this->income_stability, $ctrl); // income_stability
            $this->updateSort($this->customer_grade, $ctrl); // customer_grade
            $this->updateSort($this->color_sign, $ctrl); // color_sign
            $this->updateSort($this->rental_period, $ctrl); // rental_period
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($useDefaultSort) {
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
                $this->member_scb_id->setSort("");
                $this->member_id->setSort("");
                $this->asset_id->setSort("");
                $this->reference_id->setSort("");
                $this->reference_url->setSort("");
                $this->refreshtoken->setSort("");
                $this->auth_code->setSort("");
                $this->_token->setSort("");
                $this->state->setSort("");
                $this->status->setSort("");
                $this->at_expire_in->setSort("");
                $this->rt_expire_in->setSort("");
                $this->decision_status->setSort("");
                $this->decision_timestamp->setSort("");
                $this->deposit_amount->setSort("");
                $this->due_date->setSort("");
                $this->rental_fee->setSort("");
                $this->cdate->setSort("");
                $this->cuser->setSort("");
                $this->cip->setSort("");
                $this->udate->setSort("");
                $this->uuser->setSort("");
                $this->uip->setSort("");
                $this->fullName->setSort("");
                $this->age->setSort("");
                $this->maritalStatus->setSort("");
                $this->noOfChildren->setSort("");
                $this->educationLevel->setSort("");
                $this->workplace->setSort("");
                $this->occupation->setSort("");
                $this->jobPosition->setSort("");
                $this->submissionDate->setSort("");
                $this->bankruptcy_tendency->setSort("");
                $this->blacklist_tendency->setSort("");
                $this->money_laundering_tendency->setSort("");
                $this->mobile_fraud_behavior->setSort("");
                $this->face_similarity_score->setSort("");
                $this->identification_verification_matched_flag->setSort("");
                $this->bankstatement_confident_score->setSort("");
                $this->estimated_monthly_income->setSort("");
                $this->estimated_monthly_debt->setSort("");
                $this->income_stability->setSort("");
                $this->customer_grade->setSort("");
                $this->color_sign->setSort("");
                $this->rental_period->setSort("");
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
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fmember_scblist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button></li>";
                    if ($link != "") {
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fmember_scblist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button>";
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

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->member_scb_id->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
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
            $option->add("member_id", $this->createColumnOption("member_id"));
            $option->add("asset_id", $this->createColumnOption("asset_id"));
            $option->add("reference_id", $this->createColumnOption("reference_id"));
            $option->add("reference_url", $this->createColumnOption("reference_url"));
            $option->add("state", $this->createColumnOption("state"));
            $option->add("status", $this->createColumnOption("status"));
            $option->add("decision_status", $this->createColumnOption("decision_status"));
            $option->add("cdate", $this->createColumnOption("cdate"));
            $option->add("fullName", $this->createColumnOption("fullName"));
            $option->add("age", $this->createColumnOption("age"));
            $option->add("maritalStatus", $this->createColumnOption("maritalStatus"));
            $option->add("noOfChildren", $this->createColumnOption("noOfChildren"));
            $option->add("educationLevel", $this->createColumnOption("educationLevel"));
            $option->add("workplace", $this->createColumnOption("workplace"));
            $option->add("occupation", $this->createColumnOption("occupation"));
            $option->add("jobPosition", $this->createColumnOption("jobPosition"));
            $option->add("submissionDate", $this->createColumnOption("submissionDate"));
            $option->add("bankruptcy_tendency", $this->createColumnOption("bankruptcy_tendency"));
            $option->add("blacklist_tendency", $this->createColumnOption("blacklist_tendency"));
            $option->add("money_laundering_tendency", $this->createColumnOption("money_laundering_tendency"));
            $option->add("mobile_fraud_behavior", $this->createColumnOption("mobile_fraud_behavior"));
            $option->add("face_similarity_score", $this->createColumnOption("face_similarity_score"));
            $option->add("identification_verification_matched_flag", $this->createColumnOption("identification_verification_matched_flag"));
            $option->add("bankstatement_confident_score", $this->createColumnOption("bankstatement_confident_score"));
            $option->add("estimated_monthly_income", $this->createColumnOption("estimated_monthly_income"));
            $option->add("estimated_monthly_debt", $this->createColumnOption("estimated_monthly_debt"));
            $option->add("income_stability", $this->createColumnOption("income_stability"));
            $option->add("customer_grade", $this->createColumnOption("customer_grade"));
            $option->add("color_sign", $this->createColumnOption("color_sign"));
            $option->add("rental_period", $this->createColumnOption("rental_period"));
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fmember_scbsrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fmember_scbsrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fmember_scblist"' . $listaction->toDataAttrs() . '>' . $icon . '</button>';
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

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
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

        // asset_id
        if ($this->asset_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->asset_id->AdvancedSearch->SearchValue != "" || $this->asset_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // reference_id
        if ($this->reference_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->reference_id->AdvancedSearch->SearchValue != "" || $this->reference_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // reference_url
        if ($this->reference_url->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->reference_url->AdvancedSearch->SearchValue != "" || $this->reference_url->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // refreshtoken
        if ($this->refreshtoken->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->refreshtoken->AdvancedSearch->SearchValue != "" || $this->refreshtoken->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // auth_code
        if ($this->auth_code->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->auth_code->AdvancedSearch->SearchValue != "" || $this->auth_code->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // token
        if ($this->_token->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->_token->AdvancedSearch->SearchValue != "" || $this->_token->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // state
        if ($this->state->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->state->AdvancedSearch->SearchValue != "" || $this->state->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // status
        if ($this->status->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->status->AdvancedSearch->SearchValue != "" || $this->status->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // at_expire_in
        if ($this->at_expire_in->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->at_expire_in->AdvancedSearch->SearchValue != "" || $this->at_expire_in->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // rt_expire_in
        if ($this->rt_expire_in->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->rt_expire_in->AdvancedSearch->SearchValue != "" || $this->rt_expire_in->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // decision_status
        if ($this->decision_status->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->decision_status->AdvancedSearch->SearchValue != "" || $this->decision_status->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // decision_timestamp
        if ($this->decision_timestamp->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->decision_timestamp->AdvancedSearch->SearchValue != "" || $this->decision_timestamp->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // deposit_amount
        if ($this->deposit_amount->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->deposit_amount->AdvancedSearch->SearchValue != "" || $this->deposit_amount->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // due_date
        if ($this->due_date->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->due_date->AdvancedSearch->SearchValue != "" || $this->due_date->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // rental_fee
        if ($this->rental_fee->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->rental_fee->AdvancedSearch->SearchValue != "" || $this->rental_fee->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // cuser
        if ($this->cuser->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cuser->AdvancedSearch->SearchValue != "" || $this->cuser->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // udate
        if ($this->udate->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->udate->AdvancedSearch->SearchValue != "" || $this->udate->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // uip
        if ($this->uip->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->uip->AdvancedSearch->SearchValue != "" || $this->uip->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fullName
        if ($this->fullName->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fullName->AdvancedSearch->SearchValue != "" || $this->fullName->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // age
        if ($this->age->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->age->AdvancedSearch->SearchValue != "" || $this->age->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // maritalStatus
        if ($this->maritalStatus->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->maritalStatus->AdvancedSearch->SearchValue != "" || $this->maritalStatus->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // noOfChildren
        if ($this->noOfChildren->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->noOfChildren->AdvancedSearch->SearchValue != "" || $this->noOfChildren->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // educationLevel
        if ($this->educationLevel->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->educationLevel->AdvancedSearch->SearchValue != "" || $this->educationLevel->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // workplace
        if ($this->workplace->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->workplace->AdvancedSearch->SearchValue != "" || $this->workplace->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // occupation
        if ($this->occupation->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->occupation->AdvancedSearch->SearchValue != "" || $this->occupation->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // jobPosition
        if ($this->jobPosition->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->jobPosition->AdvancedSearch->SearchValue != "" || $this->jobPosition->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // submissionDate
        if ($this->submissionDate->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->submissionDate->AdvancedSearch->SearchValue != "" || $this->submissionDate->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // bankruptcy_tendency
        if ($this->bankruptcy_tendency->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->bankruptcy_tendency->AdvancedSearch->SearchValue != "" || $this->bankruptcy_tendency->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // blacklist_tendency
        if ($this->blacklist_tendency->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->blacklist_tendency->AdvancedSearch->SearchValue != "" || $this->blacklist_tendency->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // money_laundering_tendency
        if ($this->money_laundering_tendency->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->money_laundering_tendency->AdvancedSearch->SearchValue != "" || $this->money_laundering_tendency->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // mobile_fraud_behavior
        if ($this->mobile_fraud_behavior->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->mobile_fraud_behavior->AdvancedSearch->SearchValue != "" || $this->mobile_fraud_behavior->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // face_similarity_score
        if ($this->face_similarity_score->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->face_similarity_score->AdvancedSearch->SearchValue != "" || $this->face_similarity_score->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // identification_verification_matched_flag
        if ($this->identification_verification_matched_flag->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->identification_verification_matched_flag->AdvancedSearch->SearchValue != "" || $this->identification_verification_matched_flag->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // bankstatement_confident_score
        if ($this->bankstatement_confident_score->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->bankstatement_confident_score->AdvancedSearch->SearchValue != "" || $this->bankstatement_confident_score->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // estimated_monthly_income
        if ($this->estimated_monthly_income->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->estimated_monthly_income->AdvancedSearch->SearchValue != "" || $this->estimated_monthly_income->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // estimated_monthly_debt
        if ($this->estimated_monthly_debt->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->estimated_monthly_debt->AdvancedSearch->SearchValue != "" || $this->estimated_monthly_debt->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // income_stability
        if ($this->income_stability->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->income_stability->AdvancedSearch->SearchValue != "" || $this->income_stability->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // customer_grade
        if ($this->customer_grade->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->customer_grade->AdvancedSearch->SearchValue != "" || $this->customer_grade->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // color_sign
        if ($this->color_sign->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->color_sign->AdvancedSearch->SearchValue != "" || $this->color_sign->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // rental_period
        if ($this->rental_period->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->rental_period->AdvancedSearch->SearchValue != "" || $this->rental_period->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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
        $this->member_scb_id->setDbValue($row['member_scb_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->reference_id->setDbValue($row['reference_id']);
        $this->reference_url->setDbValue($row['reference_url']);
        $this->refreshtoken->setDbValue($row['refreshtoken']);
        $this->auth_code->setDbValue($row['auth_code']);
        $this->_token->setDbValue($row['token']);
        $this->state->setDbValue($row['state']);
        $this->status->setDbValue($row['status']);
        $this->at_expire_in->setDbValue($row['at_expire_in']);
        $this->rt_expire_in->setDbValue($row['rt_expire_in']);
        $this->decision_status->setDbValue($row['decision_status']);
        $this->decision_timestamp->setDbValue($row['decision_timestamp']);
        $this->deposit_amount->setDbValue($row['deposit_amount']);
        $this->due_date->setDbValue($row['due_date']);
        $this->rental_fee->setDbValue($row['rental_fee']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->fullName->setDbValue($row['fullName']);
        $this->age->setDbValue($row['age']);
        $this->maritalStatus->setDbValue($row['maritalStatus']);
        $this->noOfChildren->setDbValue($row['noOfChildren']);
        $this->educationLevel->setDbValue($row['educationLevel']);
        $this->workplace->setDbValue($row['workplace']);
        $this->occupation->setDbValue($row['occupation']);
        $this->jobPosition->setDbValue($row['jobPosition']);
        $this->submissionDate->setDbValue($row['submissionDate']);
        $this->bankruptcy_tendency->setDbValue($row['bankruptcy_tendency']);
        $this->blacklist_tendency->setDbValue($row['blacklist_tendency']);
        $this->money_laundering_tendency->setDbValue($row['money_laundering_tendency']);
        $this->mobile_fraud_behavior->setDbValue($row['mobile_fraud_behavior']);
        $this->face_similarity_score->setDbValue($row['face_similarity_score']);
        $this->identification_verification_matched_flag->setDbValue($row['identification_verification_matched_flag']);
        $this->bankstatement_confident_score->setDbValue($row['bankstatement_confident_score']);
        $this->estimated_monthly_income->setDbValue($row['estimated_monthly_income']);
        $this->estimated_monthly_debt->setDbValue($row['estimated_monthly_debt']);
        $this->income_stability->setDbValue($row['income_stability']);
        $this->customer_grade->setDbValue($row['customer_grade']);
        $this->color_sign->setDbValue($row['color_sign']);
        $this->rental_period->setDbValue($row['rental_period']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['member_scb_id'] = null;
        $row['member_id'] = null;
        $row['asset_id'] = null;
        $row['reference_id'] = null;
        $row['reference_url'] = null;
        $row['refreshtoken'] = null;
        $row['auth_code'] = null;
        $row['token'] = null;
        $row['state'] = null;
        $row['status'] = null;
        $row['at_expire_in'] = null;
        $row['rt_expire_in'] = null;
        $row['decision_status'] = null;
        $row['decision_timestamp'] = null;
        $row['deposit_amount'] = null;
        $row['due_date'] = null;
        $row['rental_fee'] = null;
        $row['cdate'] = null;
        $row['cuser'] = null;
        $row['cip'] = null;
        $row['udate'] = null;
        $row['uuser'] = null;
        $row['uip'] = null;
        $row['fullName'] = null;
        $row['age'] = null;
        $row['maritalStatus'] = null;
        $row['noOfChildren'] = null;
        $row['educationLevel'] = null;
        $row['workplace'] = null;
        $row['occupation'] = null;
        $row['jobPosition'] = null;
        $row['submissionDate'] = null;
        $row['bankruptcy_tendency'] = null;
        $row['blacklist_tendency'] = null;
        $row['money_laundering_tendency'] = null;
        $row['mobile_fraud_behavior'] = null;
        $row['face_similarity_score'] = null;
        $row['identification_verification_matched_flag'] = null;
        $row['bankstatement_confident_score'] = null;
        $row['estimated_monthly_income'] = null;
        $row['estimated_monthly_debt'] = null;
        $row['income_stability'] = null;
        $row['customer_grade'] = null;
        $row['color_sign'] = null;
        $row['rental_period'] = null;
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

        // member_scb_id
        $this->member_scb_id->CellCssStyle = "white-space: nowrap;";

        // member_id

        // asset_id

        // reference_id

        // reference_url

        // refreshtoken

        // auth_code

        // token

        // state

        // status

        // at_expire_in

        // rt_expire_in

        // decision_status

        // decision_timestamp

        // deposit_amount

        // due_date

        // rental_fee

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // fullName

        // age

        // maritalStatus

        // noOfChildren

        // educationLevel

        // workplace

        // occupation

        // jobPosition

        // submissionDate

        // bankruptcy_tendency

        // blacklist_tendency

        // money_laundering_tendency

        // mobile_fraud_behavior

        // face_similarity_score

        // identification_verification_matched_flag

        // bankstatement_confident_score

        // estimated_monthly_income

        // estimated_monthly_debt

        // income_stability

        // customer_grade

        // color_sign

        // rental_period

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
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

            // reference_id
            $this->reference_id->ViewValue = $this->reference_id->CurrentValue;
            $this->reference_id->ViewCustomAttributes = "";

            // reference_url
            $this->reference_url->ViewValue = $this->reference_url->CurrentValue;
            $this->reference_url->ViewCustomAttributes = "";

            // state
            $this->state->ViewValue = $this->state->CurrentValue;
            $this->state->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // decision_status
            $this->decision_status->ViewValue = $this->decision_status->CurrentValue;
            $this->decision_status->ViewCustomAttributes = "";

            // decision_timestamp
            $this->decision_timestamp->ViewValue = $this->decision_timestamp->CurrentValue;
            $this->decision_timestamp->ViewValue = FormatDateTime($this->decision_timestamp->ViewValue, $this->decision_timestamp->formatPattern());
            $this->decision_timestamp->ViewCustomAttributes = "";

            // deposit_amount
            $this->deposit_amount->ViewValue = $this->deposit_amount->CurrentValue;
            $this->deposit_amount->ViewValue = FormatNumber($this->deposit_amount->ViewValue, $this->deposit_amount->formatPattern());
            $this->deposit_amount->ViewCustomAttributes = "";

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

            // fullName
            $this->fullName->ViewValue = $this->fullName->CurrentValue;
            $this->fullName->ViewCustomAttributes = "";

            // age
            $this->age->ViewValue = $this->age->CurrentValue;
            $this->age->ViewValue = FormatNumber($this->age->ViewValue, $this->age->formatPattern());
            $this->age->ViewCustomAttributes = "";

            // maritalStatus
            $this->maritalStatus->ViewValue = $this->maritalStatus->CurrentValue;
            $this->maritalStatus->ViewCustomAttributes = "";

            // noOfChildren
            $this->noOfChildren->ViewValue = $this->noOfChildren->CurrentValue;
            $this->noOfChildren->ViewCustomAttributes = "";

            // educationLevel
            $this->educationLevel->ViewValue = $this->educationLevel->CurrentValue;
            $this->educationLevel->ViewCustomAttributes = "";

            // workplace
            $this->workplace->ViewValue = $this->workplace->CurrentValue;
            $this->workplace->ViewCustomAttributes = "";

            // occupation
            $this->occupation->ViewValue = $this->occupation->CurrentValue;
            $this->occupation->ViewCustomAttributes = "";

            // jobPosition
            $this->jobPosition->ViewValue = $this->jobPosition->CurrentValue;
            $this->jobPosition->ViewCustomAttributes = "";

            // submissionDate
            $this->submissionDate->ViewValue = $this->submissionDate->CurrentValue;
            $this->submissionDate->ViewValue = FormatDateTime($this->submissionDate->ViewValue, $this->submissionDate->formatPattern());
            $this->submissionDate->ViewCustomAttributes = "";

            // bankruptcy_tendency
            $this->bankruptcy_tendency->ViewValue = $this->bankruptcy_tendency->CurrentValue;
            $this->bankruptcy_tendency->ViewCustomAttributes = "";

            // blacklist_tendency
            $this->blacklist_tendency->ViewValue = $this->blacklist_tendency->CurrentValue;
            $this->blacklist_tendency->ViewCustomAttributes = "";

            // money_laundering_tendency
            $this->money_laundering_tendency->ViewValue = $this->money_laundering_tendency->CurrentValue;
            $this->money_laundering_tendency->ViewCustomAttributes = "";

            // mobile_fraud_behavior
            $this->mobile_fraud_behavior->ViewValue = $this->mobile_fraud_behavior->CurrentValue;
            $this->mobile_fraud_behavior->ViewCustomAttributes = "";

            // face_similarity_score
            $this->face_similarity_score->ViewValue = $this->face_similarity_score->CurrentValue;
            $this->face_similarity_score->ViewCustomAttributes = "";

            // identification_verification_matched_flag
            $this->identification_verification_matched_flag->ViewValue = $this->identification_verification_matched_flag->CurrentValue;
            $this->identification_verification_matched_flag->ViewCustomAttributes = "";

            // bankstatement_confident_score
            $this->bankstatement_confident_score->ViewValue = $this->bankstatement_confident_score->CurrentValue;
            $this->bankstatement_confident_score->ViewCustomAttributes = "";

            // estimated_monthly_income
            $this->estimated_monthly_income->ViewValue = $this->estimated_monthly_income->CurrentValue;
            $this->estimated_monthly_income->ViewCustomAttributes = "";

            // estimated_monthly_debt
            $this->estimated_monthly_debt->ViewValue = $this->estimated_monthly_debt->CurrentValue;
            $this->estimated_monthly_debt->ViewCustomAttributes = "";

            // income_stability
            $this->income_stability->ViewValue = $this->income_stability->CurrentValue;
            $this->income_stability->ViewCustomAttributes = "";

            // customer_grade
            $this->customer_grade->ViewValue = $this->customer_grade->CurrentValue;
            $this->customer_grade->ViewCustomAttributes = "";

            // color_sign
            $this->color_sign->ViewValue = $this->color_sign->CurrentValue;
            $this->color_sign->ViewCustomAttributes = "";

            // rental_period
            $this->rental_period->ViewValue = $this->rental_period->CurrentValue;
            $this->rental_period->ViewValue = FormatNumber($this->rental_period->ViewValue, $this->rental_period->formatPattern());
            $this->rental_period->ViewCustomAttributes = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";
            $this->asset_id->TooltipValue = "";

            // reference_id
            $this->reference_id->LinkCustomAttributes = "";
            $this->reference_id->HrefValue = "";
            $this->reference_id->TooltipValue = "";

            // reference_url
            $this->reference_url->LinkCustomAttributes = "";
            $this->reference_url->HrefValue = "";
            $this->reference_url->TooltipValue = "";

            // state
            $this->state->LinkCustomAttributes = "";
            $this->state->HrefValue = "";
            $this->state->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // decision_status
            $this->decision_status->LinkCustomAttributes = "";
            $this->decision_status->HrefValue = "";
            $this->decision_status->TooltipValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
            $this->cdate->TooltipValue = "";

            // fullName
            $this->fullName->LinkCustomAttributes = "";
            $this->fullName->HrefValue = "";
            $this->fullName->TooltipValue = "";

            // age
            $this->age->LinkCustomAttributes = "";
            $this->age->HrefValue = "";
            $this->age->TooltipValue = "";

            // maritalStatus
            $this->maritalStatus->LinkCustomAttributes = "";
            $this->maritalStatus->HrefValue = "";
            $this->maritalStatus->TooltipValue = "";

            // noOfChildren
            $this->noOfChildren->LinkCustomAttributes = "";
            $this->noOfChildren->HrefValue = "";
            $this->noOfChildren->TooltipValue = "";

            // educationLevel
            $this->educationLevel->LinkCustomAttributes = "";
            $this->educationLevel->HrefValue = "";
            $this->educationLevel->TooltipValue = "";

            // workplace
            $this->workplace->LinkCustomAttributes = "";
            $this->workplace->HrefValue = "";
            $this->workplace->TooltipValue = "";

            // occupation
            $this->occupation->LinkCustomAttributes = "";
            $this->occupation->HrefValue = "";
            $this->occupation->TooltipValue = "";

            // jobPosition
            $this->jobPosition->LinkCustomAttributes = "";
            $this->jobPosition->HrefValue = "";
            $this->jobPosition->TooltipValue = "";

            // submissionDate
            $this->submissionDate->LinkCustomAttributes = "";
            $this->submissionDate->HrefValue = "";
            $this->submissionDate->TooltipValue = "";

            // bankruptcy_tendency
            $this->bankruptcy_tendency->LinkCustomAttributes = "";
            $this->bankruptcy_tendency->HrefValue = "";
            $this->bankruptcy_tendency->TooltipValue = "";

            // blacklist_tendency
            $this->blacklist_tendency->LinkCustomAttributes = "";
            $this->blacklist_tendency->HrefValue = "";
            $this->blacklist_tendency->TooltipValue = "";

            // money_laundering_tendency
            $this->money_laundering_tendency->LinkCustomAttributes = "";
            $this->money_laundering_tendency->HrefValue = "";
            $this->money_laundering_tendency->TooltipValue = "";

            // mobile_fraud_behavior
            $this->mobile_fraud_behavior->LinkCustomAttributes = "";
            $this->mobile_fraud_behavior->HrefValue = "";
            $this->mobile_fraud_behavior->TooltipValue = "";

            // face_similarity_score
            $this->face_similarity_score->LinkCustomAttributes = "";
            $this->face_similarity_score->HrefValue = "";
            $this->face_similarity_score->TooltipValue = "";

            // identification_verification_matched_flag
            $this->identification_verification_matched_flag->LinkCustomAttributes = "";
            $this->identification_verification_matched_flag->HrefValue = "";
            $this->identification_verification_matched_flag->TooltipValue = "";

            // bankstatement_confident_score
            $this->bankstatement_confident_score->LinkCustomAttributes = "";
            $this->bankstatement_confident_score->HrefValue = "";
            $this->bankstatement_confident_score->TooltipValue = "";

            // estimated_monthly_income
            $this->estimated_monthly_income->LinkCustomAttributes = "";
            $this->estimated_monthly_income->HrefValue = "";
            $this->estimated_monthly_income->TooltipValue = "";

            // estimated_monthly_debt
            $this->estimated_monthly_debt->LinkCustomAttributes = "";
            $this->estimated_monthly_debt->HrefValue = "";
            $this->estimated_monthly_debt->TooltipValue = "";

            // income_stability
            $this->income_stability->LinkCustomAttributes = "";
            $this->income_stability->HrefValue = "";
            $this->income_stability->TooltipValue = "";

            // customer_grade
            $this->customer_grade->LinkCustomAttributes = "";
            $this->customer_grade->HrefValue = "";
            $this->customer_grade->TooltipValue = "";

            // color_sign
            $this->color_sign->LinkCustomAttributes = "";
            $this->color_sign->HrefValue = "";
            $this->color_sign->TooltipValue = "";

            // rental_period
            $this->rental_period->LinkCustomAttributes = "";
            $this->rental_period->HrefValue = "";
            $this->rental_period->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // member_id
            $this->member_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->member_id->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->member_id->AdvancedSearch->ViewValue = $this->member_id->lookupCacheOption($curVal);
            } else {
                $this->member_id->AdvancedSearch->ViewValue = $this->member_id->Lookup !== null && is_array($this->member_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->member_id->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->member_id->EditValue = array_values($this->member_id->lookupOptions());
                if ($this->member_id->AdvancedSearch->ViewValue == "") {
                    $this->member_id->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`member_id`" . SearchString("=", $this->member_id->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return "`isactive` = 1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->member_id->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->member_id->Lookup->renderViewRow($rswrk[0]);
                    $this->member_id->AdvancedSearch->ViewValue = $this->member_id->displayValue($arwrk);
                } else {
                    $this->member_id->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->member_id->EditValue = $arwrk;
            }
            $this->member_id->PlaceHolder = RemoveHtml($this->member_id->caption());

            // asset_id
            $this->asset_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->asset_id->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->asset_id->AdvancedSearch->ViewValue = $this->asset_id->lookupCacheOption($curVal);
            } else {
                $this->asset_id->AdvancedSearch->ViewValue = $this->asset_id->Lookup !== null && is_array($this->asset_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->asset_id->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->asset_id->EditValue = array_values($this->asset_id->lookupOptions());
                if ($this->asset_id->AdvancedSearch->ViewValue == "") {
                    $this->asset_id->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`asset_id`" . SearchString("=", $this->asset_id->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->asset_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->asset_id->Lookup->renderViewRow($rswrk[0]);
                    $this->asset_id->AdvancedSearch->ViewValue = $this->asset_id->displayValue($arwrk);
                } else {
                    $this->asset_id->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->asset_id->EditValue = $arwrk;
            }
            $this->asset_id->PlaceHolder = RemoveHtml($this->asset_id->caption());

            // reference_id
            $this->reference_id->setupEditAttributes();
            $this->reference_id->EditCustomAttributes = "";
            if (!$this->reference_id->Raw) {
                $this->reference_id->AdvancedSearch->SearchValue = HtmlDecode($this->reference_id->AdvancedSearch->SearchValue);
            }
            $this->reference_id->EditValue = HtmlEncode($this->reference_id->AdvancedSearch->SearchValue);
            $this->reference_id->PlaceHolder = RemoveHtml($this->reference_id->caption());

            // reference_url
            $this->reference_url->setupEditAttributes();
            $this->reference_url->EditCustomAttributes = "";
            $this->reference_url->EditValue = HtmlEncode($this->reference_url->AdvancedSearch->SearchValue);
            $this->reference_url->PlaceHolder = RemoveHtml($this->reference_url->caption());

            // state
            $this->state->setupEditAttributes();
            $this->state->EditCustomAttributes = "";
            $this->state->EditValue = HtmlEncode($this->state->AdvancedSearch->SearchValue);
            $this->state->PlaceHolder = RemoveHtml($this->state->caption());

            // status
            $this->status->setupEditAttributes();
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->AdvancedSearch->SearchValue = HtmlDecode($this->status->AdvancedSearch->SearchValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->AdvancedSearch->SearchValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // decision_status
            $this->decision_status->setupEditAttributes();
            $this->decision_status->EditCustomAttributes = "";
            if (!$this->decision_status->Raw) {
                $this->decision_status->AdvancedSearch->SearchValue = HtmlDecode($this->decision_status->AdvancedSearch->SearchValue);
            }
            $this->decision_status->EditValue = HtmlEncode($this->decision_status->AdvancedSearch->SearchValue);
            $this->decision_status->PlaceHolder = RemoveHtml($this->decision_status->caption());

            // cdate
            $this->cdate->setupEditAttributes();
            $this->cdate->EditCustomAttributes = "";
            $this->cdate->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->cdate->AdvancedSearch->SearchValue, $this->cdate->formatPattern()), $this->cdate->formatPattern()));
            $this->cdate->PlaceHolder = RemoveHtml($this->cdate->caption());
            $this->cdate->setupEditAttributes();
            $this->cdate->EditCustomAttributes = "";
            $this->cdate->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->cdate->AdvancedSearch->SearchValue2, $this->cdate->formatPattern()), $this->cdate->formatPattern()));
            $this->cdate->PlaceHolder = RemoveHtml($this->cdate->caption());

            // fullName
            $this->fullName->setupEditAttributes();
            $this->fullName->EditCustomAttributes = "";
            if (!$this->fullName->Raw) {
                $this->fullName->AdvancedSearch->SearchValue = HtmlDecode($this->fullName->AdvancedSearch->SearchValue);
            }
            $this->fullName->EditValue = HtmlEncode($this->fullName->AdvancedSearch->SearchValue);
            $this->fullName->PlaceHolder = RemoveHtml($this->fullName->caption());

            // age
            $this->age->setupEditAttributes();
            $this->age->EditCustomAttributes = "";
            $this->age->EditValue = HtmlEncode($this->age->AdvancedSearch->SearchValue);
            $this->age->PlaceHolder = RemoveHtml($this->age->caption());

            // maritalStatus
            $this->maritalStatus->setupEditAttributes();
            $this->maritalStatus->EditCustomAttributes = "";
            if (!$this->maritalStatus->Raw) {
                $this->maritalStatus->AdvancedSearch->SearchValue = HtmlDecode($this->maritalStatus->AdvancedSearch->SearchValue);
            }
            $this->maritalStatus->EditValue = HtmlEncode($this->maritalStatus->AdvancedSearch->SearchValue);
            $this->maritalStatus->PlaceHolder = RemoveHtml($this->maritalStatus->caption());

            // noOfChildren
            $this->noOfChildren->setupEditAttributes();
            $this->noOfChildren->EditCustomAttributes = "";
            if (!$this->noOfChildren->Raw) {
                $this->noOfChildren->AdvancedSearch->SearchValue = HtmlDecode($this->noOfChildren->AdvancedSearch->SearchValue);
            }
            $this->noOfChildren->EditValue = HtmlEncode($this->noOfChildren->AdvancedSearch->SearchValue);
            $this->noOfChildren->PlaceHolder = RemoveHtml($this->noOfChildren->caption());

            // educationLevel
            $this->educationLevel->setupEditAttributes();
            $this->educationLevel->EditCustomAttributes = "";
            if (!$this->educationLevel->Raw) {
                $this->educationLevel->AdvancedSearch->SearchValue = HtmlDecode($this->educationLevel->AdvancedSearch->SearchValue);
            }
            $this->educationLevel->EditValue = HtmlEncode($this->educationLevel->AdvancedSearch->SearchValue);
            $this->educationLevel->PlaceHolder = RemoveHtml($this->educationLevel->caption());

            // workplace
            $this->workplace->setupEditAttributes();
            $this->workplace->EditCustomAttributes = "";
            if (!$this->workplace->Raw) {
                $this->workplace->AdvancedSearch->SearchValue = HtmlDecode($this->workplace->AdvancedSearch->SearchValue);
            }
            $this->workplace->EditValue = HtmlEncode($this->workplace->AdvancedSearch->SearchValue);
            $this->workplace->PlaceHolder = RemoveHtml($this->workplace->caption());

            // occupation
            $this->occupation->setupEditAttributes();
            $this->occupation->EditCustomAttributes = "";
            if (!$this->occupation->Raw) {
                $this->occupation->AdvancedSearch->SearchValue = HtmlDecode($this->occupation->AdvancedSearch->SearchValue);
            }
            $this->occupation->EditValue = HtmlEncode($this->occupation->AdvancedSearch->SearchValue);
            $this->occupation->PlaceHolder = RemoveHtml($this->occupation->caption());

            // jobPosition
            $this->jobPosition->setupEditAttributes();
            $this->jobPosition->EditCustomAttributes = "";
            if (!$this->jobPosition->Raw) {
                $this->jobPosition->AdvancedSearch->SearchValue = HtmlDecode($this->jobPosition->AdvancedSearch->SearchValue);
            }
            $this->jobPosition->EditValue = HtmlEncode($this->jobPosition->AdvancedSearch->SearchValue);
            $this->jobPosition->PlaceHolder = RemoveHtml($this->jobPosition->caption());

            // submissionDate
            $this->submissionDate->setupEditAttributes();
            $this->submissionDate->EditCustomAttributes = "";
            $this->submissionDate->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->submissionDate->AdvancedSearch->SearchValue, $this->submissionDate->formatPattern()), $this->submissionDate->formatPattern()));
            $this->submissionDate->PlaceHolder = RemoveHtml($this->submissionDate->caption());

            // bankruptcy_tendency
            $this->bankruptcy_tendency->setupEditAttributes();
            $this->bankruptcy_tendency->EditCustomAttributes = "";
            if (!$this->bankruptcy_tendency->Raw) {
                $this->bankruptcy_tendency->AdvancedSearch->SearchValue = HtmlDecode($this->bankruptcy_tendency->AdvancedSearch->SearchValue);
            }
            $this->bankruptcy_tendency->EditValue = HtmlEncode($this->bankruptcy_tendency->AdvancedSearch->SearchValue);
            $this->bankruptcy_tendency->PlaceHolder = RemoveHtml($this->bankruptcy_tendency->caption());

            // blacklist_tendency
            $this->blacklist_tendency->setupEditAttributes();
            $this->blacklist_tendency->EditCustomAttributes = "";
            if (!$this->blacklist_tendency->Raw) {
                $this->blacklist_tendency->AdvancedSearch->SearchValue = HtmlDecode($this->blacklist_tendency->AdvancedSearch->SearchValue);
            }
            $this->blacklist_tendency->EditValue = HtmlEncode($this->blacklist_tendency->AdvancedSearch->SearchValue);
            $this->blacklist_tendency->PlaceHolder = RemoveHtml($this->blacklist_tendency->caption());

            // money_laundering_tendency
            $this->money_laundering_tendency->setupEditAttributes();
            $this->money_laundering_tendency->EditCustomAttributes = "";
            if (!$this->money_laundering_tendency->Raw) {
                $this->money_laundering_tendency->AdvancedSearch->SearchValue = HtmlDecode($this->money_laundering_tendency->AdvancedSearch->SearchValue);
            }
            $this->money_laundering_tendency->EditValue = HtmlEncode($this->money_laundering_tendency->AdvancedSearch->SearchValue);
            $this->money_laundering_tendency->PlaceHolder = RemoveHtml($this->money_laundering_tendency->caption());

            // mobile_fraud_behavior
            $this->mobile_fraud_behavior->setupEditAttributes();
            $this->mobile_fraud_behavior->EditCustomAttributes = "";
            if (!$this->mobile_fraud_behavior->Raw) {
                $this->mobile_fraud_behavior->AdvancedSearch->SearchValue = HtmlDecode($this->mobile_fraud_behavior->AdvancedSearch->SearchValue);
            }
            $this->mobile_fraud_behavior->EditValue = HtmlEncode($this->mobile_fraud_behavior->AdvancedSearch->SearchValue);
            $this->mobile_fraud_behavior->PlaceHolder = RemoveHtml($this->mobile_fraud_behavior->caption());

            // face_similarity_score
            $this->face_similarity_score->setupEditAttributes();
            $this->face_similarity_score->EditCustomAttributes = "";
            if (!$this->face_similarity_score->Raw) {
                $this->face_similarity_score->AdvancedSearch->SearchValue = HtmlDecode($this->face_similarity_score->AdvancedSearch->SearchValue);
            }
            $this->face_similarity_score->EditValue = HtmlEncode($this->face_similarity_score->AdvancedSearch->SearchValue);
            $this->face_similarity_score->PlaceHolder = RemoveHtml($this->face_similarity_score->caption());

            // identification_verification_matched_flag
            $this->identification_verification_matched_flag->setupEditAttributes();
            $this->identification_verification_matched_flag->EditCustomAttributes = "";
            if (!$this->identification_verification_matched_flag->Raw) {
                $this->identification_verification_matched_flag->AdvancedSearch->SearchValue = HtmlDecode($this->identification_verification_matched_flag->AdvancedSearch->SearchValue);
            }
            $this->identification_verification_matched_flag->EditValue = HtmlEncode($this->identification_verification_matched_flag->AdvancedSearch->SearchValue);
            $this->identification_verification_matched_flag->PlaceHolder = RemoveHtml($this->identification_verification_matched_flag->caption());

            // bankstatement_confident_score
            $this->bankstatement_confident_score->setupEditAttributes();
            $this->bankstatement_confident_score->EditCustomAttributes = "";
            if (!$this->bankstatement_confident_score->Raw) {
                $this->bankstatement_confident_score->AdvancedSearch->SearchValue = HtmlDecode($this->bankstatement_confident_score->AdvancedSearch->SearchValue);
            }
            $this->bankstatement_confident_score->EditValue = HtmlEncode($this->bankstatement_confident_score->AdvancedSearch->SearchValue);
            $this->bankstatement_confident_score->PlaceHolder = RemoveHtml($this->bankstatement_confident_score->caption());

            // estimated_monthly_income
            $this->estimated_monthly_income->setupEditAttributes();
            $this->estimated_monthly_income->EditCustomAttributes = "";
            if (!$this->estimated_monthly_income->Raw) {
                $this->estimated_monthly_income->AdvancedSearch->SearchValue = HtmlDecode($this->estimated_monthly_income->AdvancedSearch->SearchValue);
            }
            $this->estimated_monthly_income->EditValue = HtmlEncode($this->estimated_monthly_income->AdvancedSearch->SearchValue);
            $this->estimated_monthly_income->PlaceHolder = RemoveHtml($this->estimated_monthly_income->caption());

            // estimated_monthly_debt
            $this->estimated_monthly_debt->setupEditAttributes();
            $this->estimated_monthly_debt->EditCustomAttributes = "";
            if (!$this->estimated_monthly_debt->Raw) {
                $this->estimated_monthly_debt->AdvancedSearch->SearchValue = HtmlDecode($this->estimated_monthly_debt->AdvancedSearch->SearchValue);
            }
            $this->estimated_monthly_debt->EditValue = HtmlEncode($this->estimated_monthly_debt->AdvancedSearch->SearchValue);
            $this->estimated_monthly_debt->PlaceHolder = RemoveHtml($this->estimated_monthly_debt->caption());

            // income_stability
            $this->income_stability->setupEditAttributes();
            $this->income_stability->EditCustomAttributes = "";
            if (!$this->income_stability->Raw) {
                $this->income_stability->AdvancedSearch->SearchValue = HtmlDecode($this->income_stability->AdvancedSearch->SearchValue);
            }
            $this->income_stability->EditValue = HtmlEncode($this->income_stability->AdvancedSearch->SearchValue);
            $this->income_stability->PlaceHolder = RemoveHtml($this->income_stability->caption());

            // customer_grade
            $this->customer_grade->setupEditAttributes();
            $this->customer_grade->EditCustomAttributes = "";
            if (!$this->customer_grade->Raw) {
                $this->customer_grade->AdvancedSearch->SearchValue = HtmlDecode($this->customer_grade->AdvancedSearch->SearchValue);
            }
            $this->customer_grade->EditValue = HtmlEncode($this->customer_grade->AdvancedSearch->SearchValue);
            $this->customer_grade->PlaceHolder = RemoveHtml($this->customer_grade->caption());

            // color_sign
            $this->color_sign->setupEditAttributes();
            $this->color_sign->EditCustomAttributes = "";
            if (!$this->color_sign->Raw) {
                $this->color_sign->AdvancedSearch->SearchValue = HtmlDecode($this->color_sign->AdvancedSearch->SearchValue);
            }
            $this->color_sign->EditValue = HtmlEncode($this->color_sign->AdvancedSearch->SearchValue);
            $this->color_sign->PlaceHolder = RemoveHtml($this->color_sign->caption());

            // rental_period
            $this->rental_period->setupEditAttributes();
            $this->rental_period->EditCustomAttributes = "";
            $this->rental_period->EditValue = HtmlEncode($this->rental_period->AdvancedSearch->SearchValue);
            $this->rental_period->PlaceHolder = RemoveHtml($this->rental_period->caption());
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
        if (!CheckDate($this->cdate->AdvancedSearch->SearchValue2, $this->cdate->formatPattern())) {
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
        $this->asset_id->AdvancedSearch->load();
        $this->reference_id->AdvancedSearch->load();
        $this->reference_url->AdvancedSearch->load();
        $this->refreshtoken->AdvancedSearch->load();
        $this->auth_code->AdvancedSearch->load();
        $this->_token->AdvancedSearch->load();
        $this->state->AdvancedSearch->load();
        $this->status->AdvancedSearch->load();
        $this->at_expire_in->AdvancedSearch->load();
        $this->rt_expire_in->AdvancedSearch->load();
        $this->decision_status->AdvancedSearch->load();
        $this->decision_timestamp->AdvancedSearch->load();
        $this->deposit_amount->AdvancedSearch->load();
        $this->due_date->AdvancedSearch->load();
        $this->rental_fee->AdvancedSearch->load();
        $this->cdate->AdvancedSearch->load();
        $this->cuser->AdvancedSearch->load();
        $this->cip->AdvancedSearch->load();
        $this->udate->AdvancedSearch->load();
        $this->uuser->AdvancedSearch->load();
        $this->uip->AdvancedSearch->load();
        $this->fullName->AdvancedSearch->load();
        $this->age->AdvancedSearch->load();
        $this->maritalStatus->AdvancedSearch->load();
        $this->noOfChildren->AdvancedSearch->load();
        $this->educationLevel->AdvancedSearch->load();
        $this->workplace->AdvancedSearch->load();
        $this->occupation->AdvancedSearch->load();
        $this->jobPosition->AdvancedSearch->load();
        $this->submissionDate->AdvancedSearch->load();
        $this->bankruptcy_tendency->AdvancedSearch->load();
        $this->blacklist_tendency->AdvancedSearch->load();
        $this->money_laundering_tendency->AdvancedSearch->load();
        $this->mobile_fraud_behavior->AdvancedSearch->load();
        $this->face_similarity_score->AdvancedSearch->load();
        $this->identification_verification_matched_flag->AdvancedSearch->load();
        $this->bankstatement_confident_score->AdvancedSearch->load();
        $this->estimated_monthly_income->AdvancedSearch->load();
        $this->estimated_monthly_debt->AdvancedSearch->load();
        $this->income_stability->AdvancedSearch->load();
        $this->customer_grade->AdvancedSearch->load();
        $this->color_sign->AdvancedSearch->load();
        $this->rental_period->AdvancedSearch->load();
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" form=\"fmember_scblist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" form=\"fmember_scblist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" form=\"fmember_scblist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" form="fmember_scblist" data-ew-action="email" data-hdr="' . $Language->phrase("ExportToEmailText") . '" data-sel="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fmember_scbsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

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
        return true;
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
                case "x_member_id":
                    $lookupFilter = function () {
                        return "`isactive` = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_asset_id":
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
