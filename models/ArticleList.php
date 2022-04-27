<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class ArticleList extends Article
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'article';

    // Page object name
    public $PageObjName = "ArticleList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "farticlelist";
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

        // Table object (article)
        if (!isset($GLOBALS["article"]) || get_class($GLOBALS["article"]) == PROJECT_NAMESPACE . "article") {
            $GLOBALS["article"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "articleadd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "articledelete";
        $this->MultiUpdateUrl = "articleupdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'article');
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
                $tbl = Container("article");
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
		        $this->image->OldUploadPath = './upload/Juzhightlight';
		        $this->image->UploadPath = $this->image->OldUploadPath;
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
            $key .= @$ar['article_id'];
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
            $this->article_id->Visible = false;
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
        $this->article_id->Visible = false;
        $this->article_category_id->setVisibility();
        $this->_title->setVisibility();
        $this->title_en->Visible = false;
        $this->detail->Visible = false;
        $this->detail_en->Visible = false;
        $this->image->setVisibility();
        $this->order_by->setVisibility();
        $this->tag->Visible = false;
        $this->highlight->setVisibility();
        $this->count_view->Visible = false;
        $this->count_share_facebook->Visible = false;
        $this->count_share_line->Visible = false;
        $this->count_share_twitter->Visible = false;
        $this->count_share_email->Visible = false;
        $this->active_status->Visible = false;
        $this->meta_title->Visible = false;
        $this->meta_title_en->Visible = false;
        $this->meta_description->Visible = false;
        $this->meta_description_en->Visible = false;
        $this->meta_keyword->Visible = false;
        $this->meta_keyword_en->Visible = false;
        $this->og_tag_title->Visible = false;
        $this->og_tag_title_en->Visible = false;
        $this->og_tag_type->Visible = false;
        $this->og_tag_url->Visible = false;
        $this->og_tag_description->Visible = false;
        $this->og_tag_description_en->Visible = false;
        $this->og_tag_image->Visible = false;
        $this->cdate->setVisibility();
        $this->cuser->Visible = false;
        $this->cip->Visible = false;
        $this->udate->Visible = false;
        $this->uuser->Visible = false;
        $this->uip->Visible = false;
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
        $this->setupLookupOptions($this->article_category_id);
        $this->setupLookupOptions($this->highlight);
        $this->setupLookupOptions($this->active_status);

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
            $savedFilterList = $UserProfile->getSearchFilters(CurrentUserName(), "farticlesrch");
        }
        $filterList = Concat($filterList, $this->article_category_id->AdvancedSearch->toJson(), ","); // Field article_category_id
        $filterList = Concat($filterList, $this->_title->AdvancedSearch->toJson(), ","); // Field title
        $filterList = Concat($filterList, $this->title_en->AdvancedSearch->toJson(), ","); // Field title_en
        $filterList = Concat($filterList, $this->detail->AdvancedSearch->toJson(), ","); // Field detail
        $filterList = Concat($filterList, $this->detail_en->AdvancedSearch->toJson(), ","); // Field detail_en
        $filterList = Concat($filterList, $this->image->AdvancedSearch->toJson(), ","); // Field image
        $filterList = Concat($filterList, $this->order_by->AdvancedSearch->toJson(), ","); // Field order_by
        $filterList = Concat($filterList, $this->tag->AdvancedSearch->toJson(), ","); // Field tag
        $filterList = Concat($filterList, $this->highlight->AdvancedSearch->toJson(), ","); // Field highlight
        $filterList = Concat($filterList, $this->count_view->AdvancedSearch->toJson(), ","); // Field count_view
        $filterList = Concat($filterList, $this->count_share_facebook->AdvancedSearch->toJson(), ","); // Field count_share_facebook
        $filterList = Concat($filterList, $this->count_share_line->AdvancedSearch->toJson(), ","); // Field count_share_line
        $filterList = Concat($filterList, $this->count_share_twitter->AdvancedSearch->toJson(), ","); // Field count_share_twitter
        $filterList = Concat($filterList, $this->count_share_email->AdvancedSearch->toJson(), ","); // Field count_share_email
        $filterList = Concat($filterList, $this->active_status->AdvancedSearch->toJson(), ","); // Field active_status
        $filterList = Concat($filterList, $this->meta_title->AdvancedSearch->toJson(), ","); // Field meta_title
        $filterList = Concat($filterList, $this->meta_title_en->AdvancedSearch->toJson(), ","); // Field meta_title_en
        $filterList = Concat($filterList, $this->meta_description->AdvancedSearch->toJson(), ","); // Field meta_description
        $filterList = Concat($filterList, $this->meta_description_en->AdvancedSearch->toJson(), ","); // Field meta_description_en
        $filterList = Concat($filterList, $this->meta_keyword->AdvancedSearch->toJson(), ","); // Field meta_keyword
        $filterList = Concat($filterList, $this->meta_keyword_en->AdvancedSearch->toJson(), ","); // Field meta_keyword_en
        $filterList = Concat($filterList, $this->cdate->AdvancedSearch->toJson(), ","); // Field cdate
        $filterList = Concat($filterList, $this->cuser->AdvancedSearch->toJson(), ","); // Field cuser
        $filterList = Concat($filterList, $this->cip->AdvancedSearch->toJson(), ","); // Field cip
        $filterList = Concat($filterList, $this->udate->AdvancedSearch->toJson(), ","); // Field udate
        $filterList = Concat($filterList, $this->uuser->AdvancedSearch->toJson(), ","); // Field uuser
        $filterList = Concat($filterList, $this->uip->AdvancedSearch->toJson(), ","); // Field uip

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
            $UserProfile->setSearchFilters(CurrentUserName(), "farticlesrch", $filters);
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

        // Field article_category_id
        $this->article_category_id->AdvancedSearch->SearchValue = @$filter["x_article_category_id"];
        $this->article_category_id->AdvancedSearch->SearchOperator = @$filter["z_article_category_id"];
        $this->article_category_id->AdvancedSearch->SearchCondition = @$filter["v_article_category_id"];
        $this->article_category_id->AdvancedSearch->SearchValue2 = @$filter["y_article_category_id"];
        $this->article_category_id->AdvancedSearch->SearchOperator2 = @$filter["w_article_category_id"];
        $this->article_category_id->AdvancedSearch->save();

        // Field title
        $this->_title->AdvancedSearch->SearchValue = @$filter["x__title"];
        $this->_title->AdvancedSearch->SearchOperator = @$filter["z__title"];
        $this->_title->AdvancedSearch->SearchCondition = @$filter["v__title"];
        $this->_title->AdvancedSearch->SearchValue2 = @$filter["y__title"];
        $this->_title->AdvancedSearch->SearchOperator2 = @$filter["w__title"];
        $this->_title->AdvancedSearch->save();

        // Field title_en
        $this->title_en->AdvancedSearch->SearchValue = @$filter["x_title_en"];
        $this->title_en->AdvancedSearch->SearchOperator = @$filter["z_title_en"];
        $this->title_en->AdvancedSearch->SearchCondition = @$filter["v_title_en"];
        $this->title_en->AdvancedSearch->SearchValue2 = @$filter["y_title_en"];
        $this->title_en->AdvancedSearch->SearchOperator2 = @$filter["w_title_en"];
        $this->title_en->AdvancedSearch->save();

        // Field detail
        $this->detail->AdvancedSearch->SearchValue = @$filter["x_detail"];
        $this->detail->AdvancedSearch->SearchOperator = @$filter["z_detail"];
        $this->detail->AdvancedSearch->SearchCondition = @$filter["v_detail"];
        $this->detail->AdvancedSearch->SearchValue2 = @$filter["y_detail"];
        $this->detail->AdvancedSearch->SearchOperator2 = @$filter["w_detail"];
        $this->detail->AdvancedSearch->save();

        // Field detail_en
        $this->detail_en->AdvancedSearch->SearchValue = @$filter["x_detail_en"];
        $this->detail_en->AdvancedSearch->SearchOperator = @$filter["z_detail_en"];
        $this->detail_en->AdvancedSearch->SearchCondition = @$filter["v_detail_en"];
        $this->detail_en->AdvancedSearch->SearchValue2 = @$filter["y_detail_en"];
        $this->detail_en->AdvancedSearch->SearchOperator2 = @$filter["w_detail_en"];
        $this->detail_en->AdvancedSearch->save();

        // Field image
        $this->image->AdvancedSearch->SearchValue = @$filter["x_image"];
        $this->image->AdvancedSearch->SearchOperator = @$filter["z_image"];
        $this->image->AdvancedSearch->SearchCondition = @$filter["v_image"];
        $this->image->AdvancedSearch->SearchValue2 = @$filter["y_image"];
        $this->image->AdvancedSearch->SearchOperator2 = @$filter["w_image"];
        $this->image->AdvancedSearch->save();

        // Field order_by
        $this->order_by->AdvancedSearch->SearchValue = @$filter["x_order_by"];
        $this->order_by->AdvancedSearch->SearchOperator = @$filter["z_order_by"];
        $this->order_by->AdvancedSearch->SearchCondition = @$filter["v_order_by"];
        $this->order_by->AdvancedSearch->SearchValue2 = @$filter["y_order_by"];
        $this->order_by->AdvancedSearch->SearchOperator2 = @$filter["w_order_by"];
        $this->order_by->AdvancedSearch->save();

        // Field tag
        $this->tag->AdvancedSearch->SearchValue = @$filter["x_tag"];
        $this->tag->AdvancedSearch->SearchOperator = @$filter["z_tag"];
        $this->tag->AdvancedSearch->SearchCondition = @$filter["v_tag"];
        $this->tag->AdvancedSearch->SearchValue2 = @$filter["y_tag"];
        $this->tag->AdvancedSearch->SearchOperator2 = @$filter["w_tag"];
        $this->tag->AdvancedSearch->save();

        // Field highlight
        $this->highlight->AdvancedSearch->SearchValue = @$filter["x_highlight"];
        $this->highlight->AdvancedSearch->SearchOperator = @$filter["z_highlight"];
        $this->highlight->AdvancedSearch->SearchCondition = @$filter["v_highlight"];
        $this->highlight->AdvancedSearch->SearchValue2 = @$filter["y_highlight"];
        $this->highlight->AdvancedSearch->SearchOperator2 = @$filter["w_highlight"];
        $this->highlight->AdvancedSearch->save();

        // Field count_view
        $this->count_view->AdvancedSearch->SearchValue = @$filter["x_count_view"];
        $this->count_view->AdvancedSearch->SearchOperator = @$filter["z_count_view"];
        $this->count_view->AdvancedSearch->SearchCondition = @$filter["v_count_view"];
        $this->count_view->AdvancedSearch->SearchValue2 = @$filter["y_count_view"];
        $this->count_view->AdvancedSearch->SearchOperator2 = @$filter["w_count_view"];
        $this->count_view->AdvancedSearch->save();

        // Field count_share_facebook
        $this->count_share_facebook->AdvancedSearch->SearchValue = @$filter["x_count_share_facebook"];
        $this->count_share_facebook->AdvancedSearch->SearchOperator = @$filter["z_count_share_facebook"];
        $this->count_share_facebook->AdvancedSearch->SearchCondition = @$filter["v_count_share_facebook"];
        $this->count_share_facebook->AdvancedSearch->SearchValue2 = @$filter["y_count_share_facebook"];
        $this->count_share_facebook->AdvancedSearch->SearchOperator2 = @$filter["w_count_share_facebook"];
        $this->count_share_facebook->AdvancedSearch->save();

        // Field count_share_line
        $this->count_share_line->AdvancedSearch->SearchValue = @$filter["x_count_share_line"];
        $this->count_share_line->AdvancedSearch->SearchOperator = @$filter["z_count_share_line"];
        $this->count_share_line->AdvancedSearch->SearchCondition = @$filter["v_count_share_line"];
        $this->count_share_line->AdvancedSearch->SearchValue2 = @$filter["y_count_share_line"];
        $this->count_share_line->AdvancedSearch->SearchOperator2 = @$filter["w_count_share_line"];
        $this->count_share_line->AdvancedSearch->save();

        // Field count_share_twitter
        $this->count_share_twitter->AdvancedSearch->SearchValue = @$filter["x_count_share_twitter"];
        $this->count_share_twitter->AdvancedSearch->SearchOperator = @$filter["z_count_share_twitter"];
        $this->count_share_twitter->AdvancedSearch->SearchCondition = @$filter["v_count_share_twitter"];
        $this->count_share_twitter->AdvancedSearch->SearchValue2 = @$filter["y_count_share_twitter"];
        $this->count_share_twitter->AdvancedSearch->SearchOperator2 = @$filter["w_count_share_twitter"];
        $this->count_share_twitter->AdvancedSearch->save();

        // Field count_share_email
        $this->count_share_email->AdvancedSearch->SearchValue = @$filter["x_count_share_email"];
        $this->count_share_email->AdvancedSearch->SearchOperator = @$filter["z_count_share_email"];
        $this->count_share_email->AdvancedSearch->SearchCondition = @$filter["v_count_share_email"];
        $this->count_share_email->AdvancedSearch->SearchValue2 = @$filter["y_count_share_email"];
        $this->count_share_email->AdvancedSearch->SearchOperator2 = @$filter["w_count_share_email"];
        $this->count_share_email->AdvancedSearch->save();

        // Field active_status
        $this->active_status->AdvancedSearch->SearchValue = @$filter["x_active_status"];
        $this->active_status->AdvancedSearch->SearchOperator = @$filter["z_active_status"];
        $this->active_status->AdvancedSearch->SearchCondition = @$filter["v_active_status"];
        $this->active_status->AdvancedSearch->SearchValue2 = @$filter["y_active_status"];
        $this->active_status->AdvancedSearch->SearchOperator2 = @$filter["w_active_status"];
        $this->active_status->AdvancedSearch->save();

        // Field meta_title
        $this->meta_title->AdvancedSearch->SearchValue = @$filter["x_meta_title"];
        $this->meta_title->AdvancedSearch->SearchOperator = @$filter["z_meta_title"];
        $this->meta_title->AdvancedSearch->SearchCondition = @$filter["v_meta_title"];
        $this->meta_title->AdvancedSearch->SearchValue2 = @$filter["y_meta_title"];
        $this->meta_title->AdvancedSearch->SearchOperator2 = @$filter["w_meta_title"];
        $this->meta_title->AdvancedSearch->save();

        // Field meta_title_en
        $this->meta_title_en->AdvancedSearch->SearchValue = @$filter["x_meta_title_en"];
        $this->meta_title_en->AdvancedSearch->SearchOperator = @$filter["z_meta_title_en"];
        $this->meta_title_en->AdvancedSearch->SearchCondition = @$filter["v_meta_title_en"];
        $this->meta_title_en->AdvancedSearch->SearchValue2 = @$filter["y_meta_title_en"];
        $this->meta_title_en->AdvancedSearch->SearchOperator2 = @$filter["w_meta_title_en"];
        $this->meta_title_en->AdvancedSearch->save();

        // Field meta_description
        $this->meta_description->AdvancedSearch->SearchValue = @$filter["x_meta_description"];
        $this->meta_description->AdvancedSearch->SearchOperator = @$filter["z_meta_description"];
        $this->meta_description->AdvancedSearch->SearchCondition = @$filter["v_meta_description"];
        $this->meta_description->AdvancedSearch->SearchValue2 = @$filter["y_meta_description"];
        $this->meta_description->AdvancedSearch->SearchOperator2 = @$filter["w_meta_description"];
        $this->meta_description->AdvancedSearch->save();

        // Field meta_description_en
        $this->meta_description_en->AdvancedSearch->SearchValue = @$filter["x_meta_description_en"];
        $this->meta_description_en->AdvancedSearch->SearchOperator = @$filter["z_meta_description_en"];
        $this->meta_description_en->AdvancedSearch->SearchCondition = @$filter["v_meta_description_en"];
        $this->meta_description_en->AdvancedSearch->SearchValue2 = @$filter["y_meta_description_en"];
        $this->meta_description_en->AdvancedSearch->SearchOperator2 = @$filter["w_meta_description_en"];
        $this->meta_description_en->AdvancedSearch->save();

        // Field meta_keyword
        $this->meta_keyword->AdvancedSearch->SearchValue = @$filter["x_meta_keyword"];
        $this->meta_keyword->AdvancedSearch->SearchOperator = @$filter["z_meta_keyword"];
        $this->meta_keyword->AdvancedSearch->SearchCondition = @$filter["v_meta_keyword"];
        $this->meta_keyword->AdvancedSearch->SearchValue2 = @$filter["y_meta_keyword"];
        $this->meta_keyword->AdvancedSearch->SearchOperator2 = @$filter["w_meta_keyword"];
        $this->meta_keyword->AdvancedSearch->save();

        // Field meta_keyword_en
        $this->meta_keyword_en->AdvancedSearch->SearchValue = @$filter["x_meta_keyword_en"];
        $this->meta_keyword_en->AdvancedSearch->SearchOperator = @$filter["z_meta_keyword_en"];
        $this->meta_keyword_en->AdvancedSearch->SearchCondition = @$filter["v_meta_keyword_en"];
        $this->meta_keyword_en->AdvancedSearch->SearchValue2 = @$filter["y_meta_keyword_en"];
        $this->meta_keyword_en->AdvancedSearch->SearchOperator2 = @$filter["w_meta_keyword_en"];
        $this->meta_keyword_en->AdvancedSearch->save();

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
    }

    // Advanced search WHERE clause based on QueryString
    protected function advancedSearchWhere($default = false)
    {
        global $Security;
        $where = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $this->buildSearchSql($where, $this->article_category_id, $default, false); // article_category_id
        $this->buildSearchSql($where, $this->_title, $default, false); // title
        $this->buildSearchSql($where, $this->title_en, $default, false); // title_en
        $this->buildSearchSql($where, $this->detail, $default, false); // detail
        $this->buildSearchSql($where, $this->detail_en, $default, false); // detail_en
        $this->buildSearchSql($where, $this->image, $default, false); // image
        $this->buildSearchSql($where, $this->order_by, $default, false); // order_by
        $this->buildSearchSql($where, $this->tag, $default, false); // tag
        $this->buildSearchSql($where, $this->highlight, $default, false); // highlight
        $this->buildSearchSql($where, $this->count_view, $default, false); // count_view
        $this->buildSearchSql($where, $this->count_share_facebook, $default, false); // count_share_facebook
        $this->buildSearchSql($where, $this->count_share_line, $default, false); // count_share_line
        $this->buildSearchSql($where, $this->count_share_twitter, $default, false); // count_share_twitter
        $this->buildSearchSql($where, $this->count_share_email, $default, false); // count_share_email
        $this->buildSearchSql($where, $this->active_status, $default, false); // active_status
        $this->buildSearchSql($where, $this->meta_title, $default, false); // meta_title
        $this->buildSearchSql($where, $this->meta_title_en, $default, false); // meta_title_en
        $this->buildSearchSql($where, $this->meta_description, $default, false); // meta_description
        $this->buildSearchSql($where, $this->meta_description_en, $default, false); // meta_description_en
        $this->buildSearchSql($where, $this->meta_keyword, $default, false); // meta_keyword
        $this->buildSearchSql($where, $this->meta_keyword_en, $default, false); // meta_keyword_en
        $this->buildSearchSql($where, $this->cdate, $default, false); // cdate
        $this->buildSearchSql($where, $this->cuser, $default, false); // cuser
        $this->buildSearchSql($where, $this->cip, $default, false); // cip
        $this->buildSearchSql($where, $this->udate, $default, false); // udate
        $this->buildSearchSql($where, $this->uuser, $default, false); // uuser
        $this->buildSearchSql($where, $this->uip, $default, false); // uip

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->article_category_id->AdvancedSearch->save(); // article_category_id
            $this->_title->AdvancedSearch->save(); // title
            $this->title_en->AdvancedSearch->save(); // title_en
            $this->detail->AdvancedSearch->save(); // detail
            $this->detail_en->AdvancedSearch->save(); // detail_en
            $this->image->AdvancedSearch->save(); // image
            $this->order_by->AdvancedSearch->save(); // order_by
            $this->tag->AdvancedSearch->save(); // tag
            $this->highlight->AdvancedSearch->save(); // highlight
            $this->count_view->AdvancedSearch->save(); // count_view
            $this->count_share_facebook->AdvancedSearch->save(); // count_share_facebook
            $this->count_share_line->AdvancedSearch->save(); // count_share_line
            $this->count_share_twitter->AdvancedSearch->save(); // count_share_twitter
            $this->count_share_email->AdvancedSearch->save(); // count_share_email
            $this->active_status->AdvancedSearch->save(); // active_status
            $this->meta_title->AdvancedSearch->save(); // meta_title
            $this->meta_title_en->AdvancedSearch->save(); // meta_title_en
            $this->meta_description->AdvancedSearch->save(); // meta_description
            $this->meta_description_en->AdvancedSearch->save(); // meta_description_en
            $this->meta_keyword->AdvancedSearch->save(); // meta_keyword
            $this->meta_keyword_en->AdvancedSearch->save(); // meta_keyword_en
            $this->cdate->AdvancedSearch->save(); // cdate
            $this->cuser->AdvancedSearch->save(); // cuser
            $this->cip->AdvancedSearch->save(); // cip
            $this->udate->AdvancedSearch->save(); // udate
            $this->uuser->AdvancedSearch->save(); // uuser
            $this->uip->AdvancedSearch->save(); // uip
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
        if ($this->article_category_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_title->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->title_en->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->detail->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->detail_en->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->image->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->order_by->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tag->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->highlight->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->count_view->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->count_share_facebook->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->count_share_line->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->count_share_twitter->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->count_share_email->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->active_status->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->meta_title->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->meta_title_en->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->meta_description->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->meta_description_en->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->meta_keyword->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->meta_keyword_en->AdvancedSearch->issetSession()) {
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
        $this->article_category_id->AdvancedSearch->unsetSession();
        $this->_title->AdvancedSearch->unsetSession();
        $this->title_en->AdvancedSearch->unsetSession();
        $this->detail->AdvancedSearch->unsetSession();
        $this->detail_en->AdvancedSearch->unsetSession();
        $this->image->AdvancedSearch->unsetSession();
        $this->order_by->AdvancedSearch->unsetSession();
        $this->tag->AdvancedSearch->unsetSession();
        $this->highlight->AdvancedSearch->unsetSession();
        $this->count_view->AdvancedSearch->unsetSession();
        $this->count_share_facebook->AdvancedSearch->unsetSession();
        $this->count_share_line->AdvancedSearch->unsetSession();
        $this->count_share_twitter->AdvancedSearch->unsetSession();
        $this->count_share_email->AdvancedSearch->unsetSession();
        $this->active_status->AdvancedSearch->unsetSession();
        $this->meta_title->AdvancedSearch->unsetSession();
        $this->meta_title_en->AdvancedSearch->unsetSession();
        $this->meta_description->AdvancedSearch->unsetSession();
        $this->meta_description_en->AdvancedSearch->unsetSession();
        $this->meta_keyword->AdvancedSearch->unsetSession();
        $this->meta_keyword_en->AdvancedSearch->unsetSession();
        $this->cdate->AdvancedSearch->unsetSession();
        $this->cuser->AdvancedSearch->unsetSession();
        $this->cip->AdvancedSearch->unsetSession();
        $this->udate->AdvancedSearch->unsetSession();
        $this->uuser->AdvancedSearch->unsetSession();
        $this->uip->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore advanced search values
        $this->article_category_id->AdvancedSearch->load();
        $this->_title->AdvancedSearch->load();
        $this->title_en->AdvancedSearch->load();
        $this->detail->AdvancedSearch->load();
        $this->detail_en->AdvancedSearch->load();
        $this->image->AdvancedSearch->load();
        $this->order_by->AdvancedSearch->load();
        $this->tag->AdvancedSearch->load();
        $this->highlight->AdvancedSearch->load();
        $this->count_view->AdvancedSearch->load();
        $this->count_share_facebook->AdvancedSearch->load();
        $this->count_share_line->AdvancedSearch->load();
        $this->count_share_twitter->AdvancedSearch->load();
        $this->count_share_email->AdvancedSearch->load();
        $this->active_status->AdvancedSearch->load();
        $this->meta_title->AdvancedSearch->load();
        $this->meta_title_en->AdvancedSearch->load();
        $this->meta_description->AdvancedSearch->load();
        $this->meta_description_en->AdvancedSearch->load();
        $this->meta_keyword->AdvancedSearch->load();
        $this->meta_keyword_en->AdvancedSearch->load();
        $this->cdate->AdvancedSearch->load();
        $this->cuser->AdvancedSearch->load();
        $this->cip->AdvancedSearch->load();
        $this->udate->AdvancedSearch->load();
        $this->uuser->AdvancedSearch->load();
        $this->uip->AdvancedSearch->load();
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
            $this->updateSort($this->article_category_id, $ctrl); // article_category_id
            $this->updateSort($this->_title, $ctrl); // title
            $this->updateSort($this->image, $ctrl); // image
            $this->updateSort($this->order_by, $ctrl); // order_by
            $this->updateSort($this->highlight, $ctrl); // highlight
            $this->updateSort($this->cdate, $ctrl); // cdate
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "`order_by` ASC";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($this->order_by->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($useDefaultSort) {
                    $this->order_by->setSort("ASC");
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
                $this->article_id->setSort("");
                $this->article_category_id->setSort("");
                $this->_title->setSort("");
                $this->title_en->setSort("");
                $this->detail->setSort("");
                $this->detail_en->setSort("");
                $this->image->setSort("");
                $this->order_by->setSort("");
                $this->tag->setSort("");
                $this->highlight->setSort("");
                $this->count_view->setSort("");
                $this->count_share_facebook->setSort("");
                $this->count_share_line->setSort("");
                $this->count_share_twitter->setSort("");
                $this->count_share_email->setSort("");
                $this->active_status->setSort("");
                $this->meta_title->setSort("");
                $this->meta_title_en->setSort("");
                $this->meta_description->setSort("");
                $this->meta_description_en->setSort("");
                $this->meta_keyword->setSort("");
                $this->meta_keyword_en->setSort("");
                $this->og_tag_title->setSort("");
                $this->og_tag_title_en->setSort("");
                $this->og_tag_type->setSort("");
                $this->og_tag_url->setSort("");
                $this->og_tag_description->setSort("");
                $this->og_tag_description_en->setSort("");
                $this->og_tag_image->setSort("");
                $this->cdate->setSort("");
                $this->cuser->setSort("");
                $this->cip->setSort("");
                $this->udate->setSort("");
                $this->uuser->setSort("");
                $this->uip->setSort("");
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

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
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

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
                $opt->Body = "<a class=\"ew-row-link ew-delete\" data-ew-action=\"\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("DeleteLink") . "</a>";
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
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"farticlelist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button></li>";
                    if ($link != "") {
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"farticlelist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button>";
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
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->article_id->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
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
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $option->add("article_category_id", $this->createColumnOption("article_category_id"));
            $option->add("title", $this->createColumnOption("title"));
            $option->add("image", $this->createColumnOption("image"));
            $option->add("order_by", $this->createColumnOption("order_by"));
            $option->add("highlight", $this->createColumnOption("highlight"));
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"farticlesrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"farticlesrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="farticlelist"' . $listaction->toDataAttrs() . '>' . $icon . '</button>';
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

        // article_category_id
        if ($this->article_category_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->article_category_id->AdvancedSearch->SearchValue != "" || $this->article_category_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // title
        if ($this->_title->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->_title->AdvancedSearch->SearchValue != "" || $this->_title->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // title_en
        if ($this->title_en->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->title_en->AdvancedSearch->SearchValue != "" || $this->title_en->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // detail
        if ($this->detail->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->detail->AdvancedSearch->SearchValue != "" || $this->detail->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // detail_en
        if ($this->detail_en->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->detail_en->AdvancedSearch->SearchValue != "" || $this->detail_en->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // image
        if ($this->image->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->image->AdvancedSearch->SearchValue != "" || $this->image->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // order_by
        if ($this->order_by->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->order_by->AdvancedSearch->SearchValue != "" || $this->order_by->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tag
        if ($this->tag->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tag->AdvancedSearch->SearchValue != "" || $this->tag->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // highlight
        if ($this->highlight->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->highlight->AdvancedSearch->SearchValue != "" || $this->highlight->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // count_view
        if ($this->count_view->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->count_view->AdvancedSearch->SearchValue != "" || $this->count_view->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // count_share_facebook
        if ($this->count_share_facebook->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->count_share_facebook->AdvancedSearch->SearchValue != "" || $this->count_share_facebook->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // count_share_line
        if ($this->count_share_line->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->count_share_line->AdvancedSearch->SearchValue != "" || $this->count_share_line->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // count_share_twitter
        if ($this->count_share_twitter->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->count_share_twitter->AdvancedSearch->SearchValue != "" || $this->count_share_twitter->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // count_share_email
        if ($this->count_share_email->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->count_share_email->AdvancedSearch->SearchValue != "" || $this->count_share_email->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // active_status
        if ($this->active_status->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->active_status->AdvancedSearch->SearchValue != "" || $this->active_status->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // meta_title
        if ($this->meta_title->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->meta_title->AdvancedSearch->SearchValue != "" || $this->meta_title->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // meta_title_en
        if ($this->meta_title_en->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->meta_title_en->AdvancedSearch->SearchValue != "" || $this->meta_title_en->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // meta_description
        if ($this->meta_description->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->meta_description->AdvancedSearch->SearchValue != "" || $this->meta_description->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // meta_description_en
        if ($this->meta_description_en->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->meta_description_en->AdvancedSearch->SearchValue != "" || $this->meta_description_en->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // meta_keyword
        if ($this->meta_keyword->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->meta_keyword->AdvancedSearch->SearchValue != "" || $this->meta_keyword->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // meta_keyword_en
        if ($this->meta_keyword_en->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->meta_keyword_en->AdvancedSearch->SearchValue != "" || $this->meta_keyword_en->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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
        $this->article_id->setDbValue($row['article_id']);
        $this->article_category_id->setDbValue($row['article_category_id']);
        $this->_title->setDbValue($row['title']);
        $this->title_en->setDbValue($row['title_en']);
        $this->detail->setDbValue($row['detail']);
        $this->detail_en->setDbValue($row['detail_en']);
        $this->image->Upload->DbValue = $row['image'];
        $this->image->setDbValue($this->image->Upload->DbValue);
        $this->order_by->setDbValue($row['order_by']);
        $this->tag->setDbValue($row['tag']);
        $this->highlight->setDbValue($row['highlight']);
        $this->count_view->setDbValue($row['count_view']);
        $this->count_share_facebook->setDbValue($row['count_share_facebook']);
        $this->count_share_line->setDbValue($row['count_share_line']);
        $this->count_share_twitter->setDbValue($row['count_share_twitter']);
        $this->count_share_email->setDbValue($row['count_share_email']);
        $this->active_status->setDbValue($row['active_status']);
        $this->meta_title->setDbValue($row['meta_title']);
        $this->meta_title_en->setDbValue($row['meta_title_en']);
        $this->meta_description->setDbValue($row['meta_description']);
        $this->meta_description_en->setDbValue($row['meta_description_en']);
        $this->meta_keyword->setDbValue($row['meta_keyword']);
        $this->meta_keyword_en->setDbValue($row['meta_keyword_en']);
        $this->og_tag_title->setDbValue($row['og_tag_title']);
        $this->og_tag_title_en->setDbValue($row['og_tag_title_en']);
        $this->og_tag_type->setDbValue($row['og_tag_type']);
        $this->og_tag_url->setDbValue($row['og_tag_url']);
        $this->og_tag_description->setDbValue($row['og_tag_description']);
        $this->og_tag_description_en->setDbValue($row['og_tag_description_en']);
        $this->og_tag_image->setDbValue($row['og_tag_image']);
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
        $row['article_id'] = null;
        $row['article_category_id'] = null;
        $row['title'] = null;
        $row['title_en'] = null;
        $row['detail'] = null;
        $row['detail_en'] = null;
        $row['image'] = null;
        $row['order_by'] = null;
        $row['tag'] = null;
        $row['highlight'] = null;
        $row['count_view'] = null;
        $row['count_share_facebook'] = null;
        $row['count_share_line'] = null;
        $row['count_share_twitter'] = null;
        $row['count_share_email'] = null;
        $row['active_status'] = null;
        $row['meta_title'] = null;
        $row['meta_title_en'] = null;
        $row['meta_description'] = null;
        $row['meta_description_en'] = null;
        $row['meta_keyword'] = null;
        $row['meta_keyword_en'] = null;
        $row['og_tag_title'] = null;
        $row['og_tag_title_en'] = null;
        $row['og_tag_type'] = null;
        $row['og_tag_url'] = null;
        $row['og_tag_description'] = null;
        $row['og_tag_description_en'] = null;
        $row['og_tag_image'] = null;
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // article_id

        // article_category_id

        // title

        // title_en

        // detail

        // detail_en

        // image

        // order_by

        // tag

        // highlight

        // count_view

        // count_share_facebook

        // count_share_line

        // count_share_twitter

        // count_share_email

        // active_status

        // meta_title

        // meta_title_en

        // meta_description

        // meta_description_en

        // meta_keyword

        // meta_keyword_en

        // og_tag_title
        $this->og_tag_title->CellCssStyle = "white-space: nowrap;";

        // og_tag_title_en
        $this->og_tag_title_en->CellCssStyle = "white-space: nowrap;";

        // og_tag_type
        $this->og_tag_type->CellCssStyle = "white-space: nowrap;";

        // og_tag_url
        $this->og_tag_url->CellCssStyle = "white-space: nowrap;";

        // og_tag_description
        $this->og_tag_description->CellCssStyle = "white-space: nowrap;";

        // og_tag_description_en
        $this->og_tag_description_en->CellCssStyle = "white-space: nowrap;";

        // og_tag_image
        $this->og_tag_image->CellCssStyle = "white-space: nowrap;";

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // article_category_id
            $curVal = strval($this->article_category_id->CurrentValue);
            if ($curVal != "") {
                $this->article_category_id->ViewValue = $this->article_category_id->lookupCacheOption($curVal);
                if ($this->article_category_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`article_category_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`active_status` = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->article_category_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->article_category_id->Lookup->renderViewRow($rswrk[0]);
                        $this->article_category_id->ViewValue = $this->article_category_id->displayValue($arwrk);
                    } else {
                        $this->article_category_id->ViewValue = FormatNumber($this->article_category_id->CurrentValue, $this->article_category_id->formatPattern());
                    }
                }
            } else {
                $this->article_category_id->ViewValue = null;
            }
            $this->article_category_id->ViewCustomAttributes = "";

            // title
            $this->_title->ViewValue = $this->_title->CurrentValue;
            $this->_title->ViewCustomAttributes = "";

            // title_en
            $this->title_en->ViewValue = $this->title_en->CurrentValue;
            $this->title_en->ViewCustomAttributes = "";

            // image
            $this->image->UploadPath = './upload/Juzhightlight';
            if (!EmptyValue($this->image->Upload->DbValue)) {
                $this->image->ImageWidth = 100;
                $this->image->ImageHeight = 100;
                $this->image->ImageAlt = $this->image->alt();
                $this->image->ImageCssClass = "ew-image";
                $this->image->ViewValue = $this->image->Upload->DbValue;
            } else {
                $this->image->ViewValue = "";
            }
            $this->image->ViewCustomAttributes = "";

            // order_by
            $this->order_by->ViewValue = $this->order_by->CurrentValue;
            $this->order_by->ViewValue = FormatNumber($this->order_by->ViewValue, $this->order_by->formatPattern());
            $this->order_by->ViewCustomAttributes = "";

            // tag
            $this->tag->ViewValue = $this->tag->CurrentValue;
            $this->tag->ViewCustomAttributes = "";

            // highlight
            if (strval($this->highlight->CurrentValue) != "") {
                $this->highlight->ViewValue = $this->highlight->optionCaption($this->highlight->CurrentValue);
            } else {
                $this->highlight->ViewValue = null;
            }
            $this->highlight->ViewCustomAttributes = "";

            // count_view
            $this->count_view->ViewValue = $this->count_view->CurrentValue;
            $this->count_view->ViewValue = FormatNumber($this->count_view->ViewValue, $this->count_view->formatPattern());
            $this->count_view->ViewCustomAttributes = "";

            // count_share_facebook
            $this->count_share_facebook->ViewValue = $this->count_share_facebook->CurrentValue;
            $this->count_share_facebook->ViewValue = FormatNumber($this->count_share_facebook->ViewValue, $this->count_share_facebook->formatPattern());
            $this->count_share_facebook->ViewCustomAttributes = "";

            // count_share_line
            $this->count_share_line->ViewValue = $this->count_share_line->CurrentValue;
            $this->count_share_line->ViewValue = FormatNumber($this->count_share_line->ViewValue, $this->count_share_line->formatPattern());
            $this->count_share_line->ViewCustomAttributes = "";

            // count_share_twitter
            $this->count_share_twitter->ViewValue = $this->count_share_twitter->CurrentValue;
            $this->count_share_twitter->ViewValue = FormatNumber($this->count_share_twitter->ViewValue, $this->count_share_twitter->formatPattern());
            $this->count_share_twitter->ViewCustomAttributes = "";

            // count_share_email
            $this->count_share_email->ViewValue = $this->count_share_email->CurrentValue;
            $this->count_share_email->ViewValue = FormatNumber($this->count_share_email->ViewValue, $this->count_share_email->formatPattern());
            $this->count_share_email->ViewCustomAttributes = "";

            // active_status
            if (strval($this->active_status->CurrentValue) != "") {
                $this->active_status->ViewValue = $this->active_status->optionCaption($this->active_status->CurrentValue);
            } else {
                $this->active_status->ViewValue = null;
            }
            $this->active_status->ViewCustomAttributes = "";

            // meta_title
            $this->meta_title->ViewValue = $this->meta_title->CurrentValue;
            $this->meta_title->ViewCustomAttributes = "";

            // meta_title_en
            $this->meta_title_en->ViewValue = $this->meta_title_en->CurrentValue;
            $this->meta_title_en->ViewCustomAttributes = "";

            // meta_description
            $this->meta_description->ViewValue = $this->meta_description->CurrentValue;
            $this->meta_description->ViewCustomAttributes = "";

            // meta_description_en
            $this->meta_description_en->ViewValue = $this->meta_description_en->CurrentValue;
            $this->meta_description_en->ViewCustomAttributes = "";

            // cdate
            $this->cdate->ViewValue = $this->cdate->CurrentValue;
            $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
            $this->cdate->ViewCustomAttributes = "";

            // cuser
            $this->cuser->ViewValue = $this->cuser->CurrentValue;
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
            $this->uuser->ViewCustomAttributes = "";

            // uip
            $this->uip->ViewValue = $this->uip->CurrentValue;
            $this->uip->ViewCustomAttributes = "";

            // article_category_id
            $this->article_category_id->LinkCustomAttributes = "";
            $this->article_category_id->HrefValue = "";
            $this->article_category_id->TooltipValue = "";

            // title
            $this->_title->LinkCustomAttributes = "";
            $this->_title->HrefValue = "";
            $this->_title->TooltipValue = "";
            if (!$this->isExport()) {
                $this->_title->ViewValue = $this->highlightValue($this->_title);
            }

            // image
            $this->image->LinkCustomAttributes = "";
            $this->image->UploadPath = './upload/Juzhightlight';
            if (!EmptyValue($this->image->Upload->DbValue)) {
                $this->image->HrefValue = GetFileUploadUrl($this->image, $this->image->htmlDecode($this->image->Upload->DbValue)); // Add prefix/suffix
                $this->image->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->image->HrefValue = FullUrl($this->image->HrefValue, "href");
                }
            } else {
                $this->image->HrefValue = "";
            }
            $this->image->ExportHrefValue = $this->image->UploadPath . $this->image->Upload->DbValue;
            $this->image->TooltipValue = "";
            if ($this->image->UseColorbox) {
                if (EmptyValue($this->image->TooltipValue)) {
                    $this->image->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->image->LinkAttrs["data-rel"] = "article_x" . $this->RowCount . "_image";
                $this->image->LinkAttrs->appendClass("ew-lightbox");
            }

            // order_by
            $this->order_by->LinkCustomAttributes = "";
            $this->order_by->HrefValue = "";
            $this->order_by->TooltipValue = "";

            // highlight
            $this->highlight->LinkCustomAttributes = "";
            $this->highlight->HrefValue = "";
            $this->highlight->TooltipValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
            $this->cdate->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // article_category_id
            $this->article_category_id->setupEditAttributes();
            $this->article_category_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->article_category_id->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->article_category_id->AdvancedSearch->ViewValue = $this->article_category_id->lookupCacheOption($curVal);
            } else {
                $this->article_category_id->AdvancedSearch->ViewValue = $this->article_category_id->Lookup !== null && is_array($this->article_category_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->article_category_id->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->article_category_id->EditValue = array_values($this->article_category_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`article_category_id`" . SearchString("=", $this->article_category_id->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return "`active_status` = 1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->article_category_id->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->article_category_id->EditValue = $arwrk;
            }
            $this->article_category_id->PlaceHolder = RemoveHtml($this->article_category_id->caption());

            // title
            $this->_title->setupEditAttributes();
            $this->_title->EditCustomAttributes = "";
            if (!$this->_title->Raw) {
                $this->_title->AdvancedSearch->SearchValue = HtmlDecode($this->_title->AdvancedSearch->SearchValue);
            }
            $this->_title->EditValue = HtmlEncode($this->_title->AdvancedSearch->SearchValue);
            $this->_title->PlaceHolder = RemoveHtml($this->_title->caption());

            // image
            $this->image->setupEditAttributes();
            $this->image->EditCustomAttributes = "";
            if (!$this->image->Raw) {
                $this->image->AdvancedSearch->SearchValue = HtmlDecode($this->image->AdvancedSearch->SearchValue);
            }
            $this->image->EditValue = HtmlEncode($this->image->AdvancedSearch->SearchValue);
            $this->image->PlaceHolder = RemoveHtml($this->image->caption());

            // order_by
            $this->order_by->setupEditAttributes();
            $this->order_by->EditCustomAttributes = "";
            $this->order_by->EditValue = HtmlEncode($this->order_by->AdvancedSearch->SearchValue);
            $this->order_by->PlaceHolder = RemoveHtml($this->order_by->caption());

            // highlight
            $this->highlight->EditCustomAttributes = "";
            $this->highlight->EditValue = $this->highlight->options(false);
            $this->highlight->PlaceHolder = RemoveHtml($this->highlight->caption());

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
        $this->article_category_id->AdvancedSearch->load();
        $this->_title->AdvancedSearch->load();
        $this->title_en->AdvancedSearch->load();
        $this->detail->AdvancedSearch->load();
        $this->detail_en->AdvancedSearch->load();
        $this->image->AdvancedSearch->load();
        $this->order_by->AdvancedSearch->load();
        $this->tag->AdvancedSearch->load();
        $this->highlight->AdvancedSearch->load();
        $this->count_view->AdvancedSearch->load();
        $this->count_share_facebook->AdvancedSearch->load();
        $this->count_share_line->AdvancedSearch->load();
        $this->count_share_twitter->AdvancedSearch->load();
        $this->count_share_email->AdvancedSearch->load();
        $this->active_status->AdvancedSearch->load();
        $this->meta_title->AdvancedSearch->load();
        $this->meta_title_en->AdvancedSearch->load();
        $this->meta_description->AdvancedSearch->load();
        $this->meta_description_en->AdvancedSearch->load();
        $this->meta_keyword->AdvancedSearch->load();
        $this->meta_keyword_en->AdvancedSearch->load();
        $this->cdate->AdvancedSearch->load();
        $this->cuser->AdvancedSearch->load();
        $this->cip->AdvancedSearch->load();
        $this->udate->AdvancedSearch->load();
        $this->uuser->AdvancedSearch->load();
        $this->uip->AdvancedSearch->load();
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" form=\"farticlelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" form=\"farticlelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" form=\"farticlelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" form="farticlelist" data-ew-action="email" data-hdr="' . $Language->phrase("ExportToEmailText") . '" data-sel="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"farticlesrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Search highlight button
        $item = &$this->SearchOptions->add("searchhighlight");
        $item->Body = "<a class=\"btn btn-default ew-highlight active\" role=\"button\" title=\"" . $Language->phrase("Highlight") . "\" data-caption=\"" . $Language->phrase("Highlight") . "\" data-ew-action=\"highlight\" data-form=\"farticlesrch\" data-name=\"" . $this->highlightName() . "\">" . $Language->phrase("HighlightBtn") . "</a>";
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
        return $this->article_category_id->Visible || $this->_title->Visible || $this->highlight->Visible;
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
                case "x_article_category_id":
                    $lookupFilter = function () {
                        return "`active_status` = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_highlight":
                    break;
                case "x_active_status":
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
