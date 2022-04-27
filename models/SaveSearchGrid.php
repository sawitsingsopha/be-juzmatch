<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class SaveSearchGrid extends SaveSearch
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'save_search';

    // Page object name
    public $PageObjName = "SaveSearchGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fsave_searchgrid";
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
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (save_search)
        if (!isset($GLOBALS["save_search"]) || get_class($GLOBALS["save_search"]) == PROJECT_NAMESPACE . "save_search") {
            $GLOBALS["save_search"] = &$this;
        }
        $this->AddUrl = "savesearchadd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'save_search');
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

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $tbl = Container("save_search");
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
        unset($GLOBALS["Grid"]);
        if ($url === "") {
            return;
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

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
            $key .= @$ar['save_search_id'];
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
            $this->save_search_id->Visible = false;
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
            $this->uuser->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->uip->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->udate->Visible = false;
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
    public $ShowOtherOptions = false;
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

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->save_search_id->Visible = false;
        $this->member_id->Visible = false;
        $this->search_text->Visible = false;
        $this->category_id->setVisibility();
        $this->brand_id->setVisibility();
        $this->min_installment->setVisibility();
        $this->max_installment->setVisibility();
        $this->min_down->setVisibility();
        $this->max_down->setVisibility();
        $this->min_price->setVisibility();
        $this->max_price->setVisibility();
        $this->min_size->Visible = false;
        $this->max_size->Visible = false;
        $this->usable_area_min->setVisibility();
        $this->usable_area_max->setVisibility();
        $this->land_size_area_min->setVisibility();
        $this->land_size_area_max->setVisibility();
        $this->yer_installment_max->Visible = false;
        $this->bedroom->setVisibility();
        $this->latitude->setVisibility();
        $this->longitude->setVisibility();
        $this->group_type->Visible = false;
        $this->sort_id->Visible = false;
        $this->cdate->setVisibility();
        $this->cuser->Visible = false;
        $this->cip->Visible = false;
        $this->uuser->Visible = false;
        $this->uip->Visible = false;
        $this->udate->Visible = false;
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

        // Set up master detail parameters
        $this->setupMasterParms();

        // Setup other options
        $this->setupOtherOptions();

        // Set up lookup cache
        $this->setupLookupOptions($this->member_id);
        $this->setupLookupOptions($this->category_id);
        $this->setupLookupOptions($this->brand_id);
        $this->setupLookupOptions($this->bedroom);

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

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

            // Show grid delete link for grid add / grid edit
            if ($this->AllowAddDeleteRow) {
                if ($this->isGridAdd() || $this->isGridEdit()) {
                    $item = $this->ListOptions["griddelete"];
                    if ($item) {
                        $item->Visible = true;
                    }
                }
            }

            // Set up sorting order
            $this->setupSortOrder();
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

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }

        // Restore master/detail filter from session
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Restore master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Restore detail filter from session
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "buyer") {
            $masterTbl = Container("buyer");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = count($rsmaster) > 0;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("buyerlist"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }
        if ($this->isGridAdd()) {
            if ($this->CurrentMode == "copy") {
                $this->TotalRecords = $this->listRecordCount();
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->TotalRecords;
                $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
            } else {
                $this->CurrentFilter = "0=1";
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->GridAddRowCount;
            }
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->TotalRecords; // Display all records
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
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

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->latitude->FormValue = ""; // Clear form value
        $this->longitude->FormValue = ""; // Clear form value
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to Grid Add mode
    protected function gridAddMode()
    {
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
    }

    // Switch to Grid Edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old recordset
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAllAssociative();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            return false;
        }
        if ($this->AuditTrailOnEdit) {
            $this->writeAuditTrailDummy($Language->phrase("BatchUpdateBegin")); // Batch update begin
        }
        $key = "";

        // Update row index and get row key
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete") { // Skip insert then deleted rows
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    //} elseif (!$this->validateForm()) { // Already done in validateGridForm
                    //    $gridUpdate = false; // Form error, reset action
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    break;
                }
            }
        }
        if ($gridUpdate) {
            // Get new records
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            if ($this->AuditTrailOnEdit) {
                $this->writeAuditTrailDummy($Language->phrase("BatchUpdateSuccess")); // Batch update success
            }
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->AuditTrailOnEdit) {
                $this->writeAuditTrailDummy($Language->phrase("BatchUpdateRollback")); // Batch update rollback
            }
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
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

    // Perform Grid Add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            return false;
        }

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        if ($this->AuditTrailOnAdd) {
            $this->writeAuditTrailDummy($Language->phrase("BatchInsertBegin")); // Batch insert begin
        }
        $key = "";

        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success

                // Validate form // Already done in validateGridForm
                //if (!$this->validateForm()) {
                //    $gridInsert = false; // Form error, reset action
                //} else {
                    $gridInsert = $this->addRow($this->OldRecordset); // Insert this row
                //}
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->save_search_id->CurrentValue;

                    // Add filter for this record
                    $filter = $this->getRecordFilter();
                    if ($wrkfilter != "") {
                        $wrkfilter .= " OR ";
                    }
                    $wrkfilter .= $filter;
                } else {
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->clearInlineMode(); // Clear grid add mode and return
            return true;
        }
        if ($gridInsert) {
            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            if ($this->AuditTrailOnAdd) {
                $this->writeAuditTrailDummy($Language->phrase("BatchInsertSuccess")); // Batch insert success
            }
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            if ($this->AuditTrailOnAdd) {
                $this->writeAuditTrailDummy($Language->phrase("BatchInsertRollback")); // Batch insert rollback
            }
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if ($CurrentForm->hasValue("x_category_id") && $CurrentForm->hasValue("o_category_id") && $this->category_id->CurrentValue != $this->category_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_brand_id") && $CurrentForm->hasValue("o_brand_id") && $this->brand_id->CurrentValue != $this->brand_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_min_installment") && $CurrentForm->hasValue("o_min_installment") && $this->min_installment->CurrentValue != $this->min_installment->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_max_installment") && $CurrentForm->hasValue("o_max_installment") && $this->max_installment->CurrentValue != $this->max_installment->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_min_down") && $CurrentForm->hasValue("o_min_down") && $this->min_down->CurrentValue != $this->min_down->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_max_down") && $CurrentForm->hasValue("o_max_down") && $this->max_down->CurrentValue != $this->max_down->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_min_price") && $CurrentForm->hasValue("o_min_price") && $this->min_price->CurrentValue != $this->min_price->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_max_price") && $CurrentForm->hasValue("o_max_price") && $this->max_price->CurrentValue != $this->max_price->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_usable_area_min") && $CurrentForm->hasValue("o_usable_area_min") && $this->usable_area_min->CurrentValue != $this->usable_area_min->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_usable_area_max") && $CurrentForm->hasValue("o_usable_area_max") && $this->usable_area_max->CurrentValue != $this->usable_area_max->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_land_size_area_min") && $CurrentForm->hasValue("o_land_size_area_min") && $this->land_size_area_min->CurrentValue != $this->land_size_area_min->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_land_size_area_max") && $CurrentForm->hasValue("o_land_size_area_max") && $this->land_size_area_max->CurrentValue != $this->land_size_area_max->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_bedroom") && $CurrentForm->hasValue("o_bedroom") && $this->bedroom->CurrentValue != $this->bedroom->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_latitude") && $CurrentForm->hasValue("o_latitude") && $this->latitude->CurrentValue != $this->latitude->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_longitude") && $CurrentForm->hasValue("o_longitude") && $this->longitude->CurrentValue != $this->longitude->OldValue) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    $this->EventCancelled = true;
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        $this->category_id->clearErrorMessage();
        $this->brand_id->clearErrorMessage();
        $this->min_installment->clearErrorMessage();
        $this->max_installment->clearErrorMessage();
        $this->min_down->clearErrorMessage();
        $this->max_down->clearErrorMessage();
        $this->min_price->clearErrorMessage();
        $this->max_price->clearErrorMessage();
        $this->usable_area_min->clearErrorMessage();
        $this->usable_area_max->clearErrorMessage();
        $this->land_size_area_min->clearErrorMessage();
        $this->land_size_area_max->clearErrorMessage();
        $this->bedroom->clearErrorMessage();
        $this->latitude->clearErrorMessage();
        $this->longitude->clearErrorMessage();
        $this->cdate->clearErrorMessage();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
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
            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->member_id->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
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

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = false;
            $item->Visible = false; // Default hidden
        }

        // Add group option item ("button")
        $item = &$this->ListOptions->addGroupOption();
        $item->Body = "";
        $item->OnLeft = false;
        $item->Visible = false;

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

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-ew-action=\"delete-grid-row\" data-rowindex=\"" . $this->RowIndex . "\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }

        // "sequence"
        $opt = $this->ListOptions["sequence"];
        $opt->Body = FormatSequenceNumber($this->RecordCount);
        if ($this->CurrentMode == "view") { // Check view mode
        } // End View mode
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
        $option = $this->OtherOptions["addedit"];
        $item = &$option->addGroupOption();
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
            if (in_array($this->CurrentMode, ["add", "copy", "edit"]) && !$this->isConfirm()) { // Check add/copy/edit mode
                if ($this->AllowAddDeleteRow) {
                    $option = $options["addedit"];
                    $option->UseDropDownButton = false;
                    $item = &$option->add("addblankrow");
                    $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $Language->phrase("AddBlankRow") . "</a>";
                    $item->Visible = false;
                    $this->ShowOtherOptions = $item->Visible;
                }
            }
            if ($this->CurrentMode == "view") { // Check view mode
                $option = $options["addedit"];
                $item = $option["add"];
                $this->ShowOtherOptions = $item && $item->Visible;
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
        $this->save_search_id->CurrentValue = null;
        $this->save_search_id->OldValue = $this->save_search_id->CurrentValue;
        $this->member_id->CurrentValue = null;
        $this->member_id->OldValue = $this->member_id->CurrentValue;
        $this->search_text->CurrentValue = null;
        $this->search_text->OldValue = $this->search_text->CurrentValue;
        $this->category_id->CurrentValue = null;
        $this->category_id->OldValue = $this->category_id->CurrentValue;
        $this->brand_id->CurrentValue = null;
        $this->brand_id->OldValue = $this->brand_id->CurrentValue;
        $this->min_installment->CurrentValue = null;
        $this->min_installment->OldValue = $this->min_installment->CurrentValue;
        $this->max_installment->CurrentValue = null;
        $this->max_installment->OldValue = $this->max_installment->CurrentValue;
        $this->min_down->CurrentValue = null;
        $this->min_down->OldValue = $this->min_down->CurrentValue;
        $this->max_down->CurrentValue = null;
        $this->max_down->OldValue = $this->max_down->CurrentValue;
        $this->min_price->CurrentValue = null;
        $this->min_price->OldValue = $this->min_price->CurrentValue;
        $this->max_price->CurrentValue = null;
        $this->max_price->OldValue = $this->max_price->CurrentValue;
        $this->min_size->CurrentValue = null;
        $this->min_size->OldValue = $this->min_size->CurrentValue;
        $this->max_size->CurrentValue = null;
        $this->max_size->OldValue = $this->max_size->CurrentValue;
        $this->usable_area_min->CurrentValue = null;
        $this->usable_area_min->OldValue = $this->usable_area_min->CurrentValue;
        $this->usable_area_max->CurrentValue = null;
        $this->usable_area_max->OldValue = $this->usable_area_max->CurrentValue;
        $this->land_size_area_min->CurrentValue = null;
        $this->land_size_area_min->OldValue = $this->land_size_area_min->CurrentValue;
        $this->land_size_area_max->CurrentValue = null;
        $this->land_size_area_max->OldValue = $this->land_size_area_max->CurrentValue;
        $this->yer_installment_max->CurrentValue = null;
        $this->yer_installment_max->OldValue = $this->yer_installment_max->CurrentValue;
        $this->bedroom->CurrentValue = null;
        $this->bedroom->OldValue = $this->bedroom->CurrentValue;
        $this->latitude->CurrentValue = null;
        $this->latitude->OldValue = $this->latitude->CurrentValue;
        $this->longitude->CurrentValue = null;
        $this->longitude->OldValue = $this->longitude->CurrentValue;
        $this->group_type->CurrentValue = null;
        $this->group_type->OldValue = $this->group_type->CurrentValue;
        $this->sort_id->CurrentValue = null;
        $this->sort_id->OldValue = $this->sort_id->CurrentValue;
        $this->cdate->CurrentValue = null;
        $this->cdate->OldValue = $this->cdate->CurrentValue;
        $this->cuser->CurrentValue = null;
        $this->cuser->OldValue = $this->cuser->CurrentValue;
        $this->cip->CurrentValue = null;
        $this->cip->OldValue = $this->cip->CurrentValue;
        $this->uuser->CurrentValue = null;
        $this->uuser->OldValue = $this->uuser->CurrentValue;
        $this->uip->CurrentValue = null;
        $this->uip->OldValue = $this->uip->CurrentValue;
        $this->udate->CurrentValue = null;
        $this->udate->OldValue = $this->udate->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'category_id' first before field var 'x_category_id'
        $val = $CurrentForm->hasValue("category_id") ? $CurrentForm->getValue("category_id") : $CurrentForm->getValue("x_category_id");
        if (!$this->category_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->category_id->Visible = false; // Disable update for API request
            } else {
                $this->category_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_category_id")) {
            $this->category_id->setOldValue($CurrentForm->getValue("o_category_id"));
        }

        // Check field name 'brand_id' first before field var 'x_brand_id'
        $val = $CurrentForm->hasValue("brand_id") ? $CurrentForm->getValue("brand_id") : $CurrentForm->getValue("x_brand_id");
        if (!$this->brand_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->brand_id->Visible = false; // Disable update for API request
            } else {
                $this->brand_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_brand_id")) {
            $this->brand_id->setOldValue($CurrentForm->getValue("o_brand_id"));
        }

        // Check field name 'min_installment' first before field var 'x_min_installment'
        $val = $CurrentForm->hasValue("min_installment") ? $CurrentForm->getValue("min_installment") : $CurrentForm->getValue("x_min_installment");
        if (!$this->min_installment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->min_installment->Visible = false; // Disable update for API request
            } else {
                $this->min_installment->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_min_installment")) {
            $this->min_installment->setOldValue($CurrentForm->getValue("o_min_installment"));
        }

        // Check field name 'max_installment' first before field var 'x_max_installment'
        $val = $CurrentForm->hasValue("max_installment") ? $CurrentForm->getValue("max_installment") : $CurrentForm->getValue("x_max_installment");
        if (!$this->max_installment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->max_installment->Visible = false; // Disable update for API request
            } else {
                $this->max_installment->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_max_installment")) {
            $this->max_installment->setOldValue($CurrentForm->getValue("o_max_installment"));
        }

        // Check field name 'min_down' first before field var 'x_min_down'
        $val = $CurrentForm->hasValue("min_down") ? $CurrentForm->getValue("min_down") : $CurrentForm->getValue("x_min_down");
        if (!$this->min_down->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->min_down->Visible = false; // Disable update for API request
            } else {
                $this->min_down->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_min_down")) {
            $this->min_down->setOldValue($CurrentForm->getValue("o_min_down"));
        }

        // Check field name 'max_down' first before field var 'x_max_down'
        $val = $CurrentForm->hasValue("max_down") ? $CurrentForm->getValue("max_down") : $CurrentForm->getValue("x_max_down");
        if (!$this->max_down->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->max_down->Visible = false; // Disable update for API request
            } else {
                $this->max_down->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_max_down")) {
            $this->max_down->setOldValue($CurrentForm->getValue("o_max_down"));
        }

        // Check field name 'min_price' first before field var 'x_min_price'
        $val = $CurrentForm->hasValue("min_price") ? $CurrentForm->getValue("min_price") : $CurrentForm->getValue("x_min_price");
        if (!$this->min_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->min_price->Visible = false; // Disable update for API request
            } else {
                $this->min_price->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_min_price")) {
            $this->min_price->setOldValue($CurrentForm->getValue("o_min_price"));
        }

        // Check field name 'max_price' first before field var 'x_max_price'
        $val = $CurrentForm->hasValue("max_price") ? $CurrentForm->getValue("max_price") : $CurrentForm->getValue("x_max_price");
        if (!$this->max_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->max_price->Visible = false; // Disable update for API request
            } else {
                $this->max_price->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_max_price")) {
            $this->max_price->setOldValue($CurrentForm->getValue("o_max_price"));
        }

        // Check field name 'usable_area_min' first before field var 'x_usable_area_min'
        $val = $CurrentForm->hasValue("usable_area_min") ? $CurrentForm->getValue("usable_area_min") : $CurrentForm->getValue("x_usable_area_min");
        if (!$this->usable_area_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usable_area_min->Visible = false; // Disable update for API request
            } else {
                $this->usable_area_min->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_usable_area_min")) {
            $this->usable_area_min->setOldValue($CurrentForm->getValue("o_usable_area_min"));
        }

        // Check field name 'usable_area_max' first before field var 'x_usable_area_max'
        $val = $CurrentForm->hasValue("usable_area_max") ? $CurrentForm->getValue("usable_area_max") : $CurrentForm->getValue("x_usable_area_max");
        if (!$this->usable_area_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usable_area_max->Visible = false; // Disable update for API request
            } else {
                $this->usable_area_max->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_usable_area_max")) {
            $this->usable_area_max->setOldValue($CurrentForm->getValue("o_usable_area_max"));
        }

        // Check field name 'land_size_area_min' first before field var 'x_land_size_area_min'
        $val = $CurrentForm->hasValue("land_size_area_min") ? $CurrentForm->getValue("land_size_area_min") : $CurrentForm->getValue("x_land_size_area_min");
        if (!$this->land_size_area_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->land_size_area_min->Visible = false; // Disable update for API request
            } else {
                $this->land_size_area_min->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_land_size_area_min")) {
            $this->land_size_area_min->setOldValue($CurrentForm->getValue("o_land_size_area_min"));
        }

        // Check field name 'land_size_area_max' first before field var 'x_land_size_area_max'
        $val = $CurrentForm->hasValue("land_size_area_max") ? $CurrentForm->getValue("land_size_area_max") : $CurrentForm->getValue("x_land_size_area_max");
        if (!$this->land_size_area_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->land_size_area_max->Visible = false; // Disable update for API request
            } else {
                $this->land_size_area_max->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_land_size_area_max")) {
            $this->land_size_area_max->setOldValue($CurrentForm->getValue("o_land_size_area_max"));
        }

        // Check field name 'bedroom' first before field var 'x_bedroom'
        $val = $CurrentForm->hasValue("bedroom") ? $CurrentForm->getValue("bedroom") : $CurrentForm->getValue("x_bedroom");
        if (!$this->bedroom->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bedroom->Visible = false; // Disable update for API request
            } else {
                $this->bedroom->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_bedroom")) {
            $this->bedroom->setOldValue($CurrentForm->getValue("o_bedroom"));
        }

        // Check field name 'latitude' first before field var 'x_latitude'
        $val = $CurrentForm->hasValue("latitude") ? $CurrentForm->getValue("latitude") : $CurrentForm->getValue("x_latitude");
        if (!$this->latitude->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->latitude->Visible = false; // Disable update for API request
            } else {
                $this->latitude->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_latitude")) {
            $this->latitude->setOldValue($CurrentForm->getValue("o_latitude"));
        }

        // Check field name 'longitude' first before field var 'x_longitude'
        $val = $CurrentForm->hasValue("longitude") ? $CurrentForm->getValue("longitude") : $CurrentForm->getValue("x_longitude");
        if (!$this->longitude->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->longitude->Visible = false; // Disable update for API request
            } else {
                $this->longitude->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_longitude")) {
            $this->longitude->setOldValue($CurrentForm->getValue("o_longitude"));
        }

        // Check field name 'cdate' first before field var 'x_cdate'
        $val = $CurrentForm->hasValue("cdate") ? $CurrentForm->getValue("cdate") : $CurrentForm->getValue("x_cdate");
        if (!$this->cdate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cdate->Visible = false; // Disable update for API request
            } else {
                $this->cdate->setFormValue($val);
            }
            $this->cdate->CurrentValue = UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
        }
        if ($CurrentForm->hasValue("o_cdate")) {
            $this->cdate->setOldValue($CurrentForm->getValue("o_cdate"));
        }

        // Check field name 'save_search_id' first before field var 'x_save_search_id'
        $val = $CurrentForm->hasValue("save_search_id") ? $CurrentForm->getValue("save_search_id") : $CurrentForm->getValue("x_save_search_id");
        if (!$this->save_search_id->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->save_search_id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->save_search_id->CurrentValue = $this->save_search_id->FormValue;
        }
        $this->category_id->CurrentValue = $this->category_id->FormValue;
        $this->brand_id->CurrentValue = $this->brand_id->FormValue;
        $this->min_installment->CurrentValue = $this->min_installment->FormValue;
        $this->max_installment->CurrentValue = $this->max_installment->FormValue;
        $this->min_down->CurrentValue = $this->min_down->FormValue;
        $this->max_down->CurrentValue = $this->max_down->FormValue;
        $this->min_price->CurrentValue = $this->min_price->FormValue;
        $this->max_price->CurrentValue = $this->max_price->FormValue;
        $this->usable_area_min->CurrentValue = $this->usable_area_min->FormValue;
        $this->usable_area_max->CurrentValue = $this->usable_area_max->FormValue;
        $this->land_size_area_min->CurrentValue = $this->land_size_area_min->FormValue;
        $this->land_size_area_max->CurrentValue = $this->land_size_area_max->FormValue;
        $this->bedroom->CurrentValue = $this->bedroom->FormValue;
        $this->latitude->CurrentValue = $this->latitude->FormValue;
        $this->longitude->CurrentValue = $this->longitude->FormValue;
        $this->cdate->CurrentValue = $this->cdate->FormValue;
        $this->cdate->CurrentValue = UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
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
        $this->save_search_id->setDbValue($row['save_search_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->search_text->setDbValue($row['search_text']);
        $this->category_id->setDbValue($row['category_id']);
        $this->brand_id->setDbValue($row['brand_id']);
        $this->min_installment->setDbValue($row['min_installment']);
        $this->max_installment->setDbValue($row['max_installment']);
        $this->min_down->setDbValue($row['min_down']);
        $this->max_down->setDbValue($row['max_down']);
        $this->min_price->setDbValue($row['min_price']);
        $this->max_price->setDbValue($row['max_price']);
        $this->min_size->setDbValue($row['min_size']);
        $this->max_size->setDbValue($row['max_size']);
        $this->usable_area_min->setDbValue($row['usable_area_min']);
        $this->usable_area_max->setDbValue($row['usable_area_max']);
        $this->land_size_area_min->setDbValue($row['land_size_area_min']);
        $this->land_size_area_max->setDbValue($row['land_size_area_max']);
        $this->yer_installment_max->setDbValue($row['yer_installment_max']);
        $this->bedroom->setDbValue($row['bedroom']);
        $this->latitude->setDbValue($row['latitude']);
        $this->longitude->setDbValue($row['longitude']);
        $this->group_type->setDbValue($row['group_type']);
        $this->sort_id->setDbValue($row['sort_id']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->udate->setDbValue($row['udate']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['save_search_id'] = $this->save_search_id->CurrentValue;
        $row['member_id'] = $this->member_id->CurrentValue;
        $row['search_text'] = $this->search_text->CurrentValue;
        $row['category_id'] = $this->category_id->CurrentValue;
        $row['brand_id'] = $this->brand_id->CurrentValue;
        $row['min_installment'] = $this->min_installment->CurrentValue;
        $row['max_installment'] = $this->max_installment->CurrentValue;
        $row['min_down'] = $this->min_down->CurrentValue;
        $row['max_down'] = $this->max_down->CurrentValue;
        $row['min_price'] = $this->min_price->CurrentValue;
        $row['max_price'] = $this->max_price->CurrentValue;
        $row['min_size'] = $this->min_size->CurrentValue;
        $row['max_size'] = $this->max_size->CurrentValue;
        $row['usable_area_min'] = $this->usable_area_min->CurrentValue;
        $row['usable_area_max'] = $this->usable_area_max->CurrentValue;
        $row['land_size_area_min'] = $this->land_size_area_min->CurrentValue;
        $row['land_size_area_max'] = $this->land_size_area_max->CurrentValue;
        $row['yer_installment_max'] = $this->yer_installment_max->CurrentValue;
        $row['bedroom'] = $this->bedroom->CurrentValue;
        $row['latitude'] = $this->latitude->CurrentValue;
        $row['longitude'] = $this->longitude->CurrentValue;
        $row['group_type'] = $this->group_type->CurrentValue;
        $row['sort_id'] = $this->sort_id->CurrentValue;
        $row['cdate'] = $this->cdate->CurrentValue;
        $row['cuser'] = $this->cuser->CurrentValue;
        $row['cip'] = $this->cip->CurrentValue;
        $row['uuser'] = $this->uuser->CurrentValue;
        $row['uip'] = $this->uip->CurrentValue;
        $row['udate'] = $this->udate->CurrentValue;
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
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // save_search_id
        $this->save_search_id->CellCssStyle = "white-space: nowrap;";

        // member_id

        // search_text

        // category_id

        // brand_id

        // min_installment

        // max_installment

        // min_down

        // max_down

        // min_price

        // max_price

        // min_size
        $this->min_size->CellCssStyle = "white-space: nowrap;";

        // max_size
        $this->max_size->CellCssStyle = "white-space: nowrap;";

        // usable_area_min

        // usable_area_max

        // land_size_area_min

        // land_size_area_max

        // yer_installment_max
        $this->yer_installment_max->CellCssStyle = "white-space: nowrap;";

        // bedroom

        // latitude

        // longitude

        // group_type
        $this->group_type->CellCssStyle = "white-space: nowrap;";

        // sort_id

        // cdate

        // cuser

        // cip

        // uuser

        // uip

        // udate

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // member_id
            $curVal = strval($this->member_id->CurrentValue);
            if ($curVal != "") {
                $this->member_id->ViewValue = $this->member_id->lookupCacheOption($curVal);
                if ($this->member_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`member_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->member_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

            // category_id
            $this->category_id->ViewValue = $this->category_id->CurrentValue;
            $curVal = strval($this->category_id->CurrentValue);
            if ($curVal != "") {
                $this->category_id->ViewValue = $this->category_id->lookupCacheOption($curVal);
                if ($this->category_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`category_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`isactive`=1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->category_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->category_id->Lookup->renderViewRow($rswrk[0]);
                        $this->category_id->ViewValue = $this->category_id->displayValue($arwrk);
                    } else {
                        $this->category_id->ViewValue = $this->category_id->CurrentValue;
                    }
                }
            } else {
                $this->category_id->ViewValue = null;
            }
            $this->category_id->ViewCustomAttributes = "";

            // brand_id
            $curVal = strval($this->brand_id->CurrentValue);
            if ($curVal != "") {
                $this->brand_id->ViewValue = $this->brand_id->lookupCacheOption($curVal);
                if ($this->brand_id->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`brand_id`" . SearchString("=", trim($wrk), DATATYPE_NUMBER, "");
                    }
                    $lookupFilter = function() {
                        return "`isactive`=1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->brand_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->brand_id->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->brand_id->Lookup->renderViewRow($row);
                            $this->brand_id->ViewValue->add($this->brand_id->displayValue($arwrk));
                        }
                    } else {
                        $this->brand_id->ViewValue = $this->brand_id->CurrentValue;
                    }
                }
            } else {
                $this->brand_id->ViewValue = null;
            }
            $this->brand_id->ViewCustomAttributes = "";

            // min_installment
            $this->min_installment->ViewValue = $this->min_installment->CurrentValue;
            $this->min_installment->ViewCustomAttributes = "";

            // max_installment
            $this->max_installment->ViewValue = $this->max_installment->CurrentValue;
            $this->max_installment->ViewCustomAttributes = "";

            // min_down
            $this->min_down->ViewValue = $this->min_down->CurrentValue;
            $this->min_down->ViewCustomAttributes = "";

            // max_down
            $this->max_down->ViewValue = $this->max_down->CurrentValue;
            $this->max_down->ViewCustomAttributes = "";

            // min_price
            $this->min_price->ViewValue = $this->min_price->CurrentValue;
            $this->min_price->ViewCustomAttributes = "";

            // max_price
            $this->max_price->ViewValue = $this->max_price->CurrentValue;
            $this->max_price->ViewCustomAttributes = "";

            // usable_area_min
            $this->usable_area_min->ViewValue = $this->usable_area_min->CurrentValue;
            $this->usable_area_min->ViewCustomAttributes = "";

            // usable_area_max
            $this->usable_area_max->ViewValue = $this->usable_area_max->CurrentValue;
            $this->usable_area_max->ViewCustomAttributes = "";

            // land_size_area_min
            $this->land_size_area_min->ViewValue = $this->land_size_area_min->CurrentValue;
            $this->land_size_area_min->ViewCustomAttributes = "";

            // land_size_area_max
            $this->land_size_area_max->ViewValue = $this->land_size_area_max->CurrentValue;
            $this->land_size_area_max->ViewCustomAttributes = "";

            // bedroom
            if (strval($this->bedroom->CurrentValue) != "") {
                $this->bedroom->ViewValue = new OptionValues();
                $arwrk = explode(",", strval($this->bedroom->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->bedroom->ViewValue->add($this->bedroom->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->bedroom->ViewValue = null;
            }
            $this->bedroom->ViewCustomAttributes = "";

            // latitude
            $this->latitude->ViewValue = $this->latitude->CurrentValue;
            $this->latitude->ViewValue = FormatNumber($this->latitude->ViewValue, $this->latitude->formatPattern());
            $this->latitude->ViewCustomAttributes = "";

            // longitude
            $this->longitude->ViewValue = $this->longitude->CurrentValue;
            $this->longitude->ViewValue = FormatNumber($this->longitude->ViewValue, $this->longitude->formatPattern());
            $this->longitude->ViewCustomAttributes = "";

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

            // uuser
            $this->uuser->ViewValue = $this->uuser->CurrentValue;
            $this->uuser->ViewCustomAttributes = "";

            // uip
            $this->uip->ViewValue = $this->uip->CurrentValue;
            $this->uip->ViewCustomAttributes = "";

            // udate
            $this->udate->ViewValue = $this->udate->CurrentValue;
            $this->udate->ViewValue = FormatDateTime($this->udate->ViewValue, $this->udate->formatPattern());
            $this->udate->ViewCustomAttributes = "";

            // category_id
            $this->category_id->LinkCustomAttributes = "";
            $this->category_id->HrefValue = "";
            $this->category_id->TooltipValue = "";

            // brand_id
            $this->brand_id->LinkCustomAttributes = "";
            $this->brand_id->HrefValue = "";
            $this->brand_id->TooltipValue = "";

            // min_installment
            $this->min_installment->LinkCustomAttributes = "";
            $this->min_installment->HrefValue = "";
            $this->min_installment->TooltipValue = "";

            // max_installment
            $this->max_installment->LinkCustomAttributes = "";
            $this->max_installment->HrefValue = "";
            $this->max_installment->TooltipValue = "";

            // min_down
            $this->min_down->LinkCustomAttributes = "";
            $this->min_down->HrefValue = "";
            $this->min_down->TooltipValue = "";

            // max_down
            $this->max_down->LinkCustomAttributes = "";
            $this->max_down->HrefValue = "";
            $this->max_down->TooltipValue = "";

            // min_price
            $this->min_price->LinkCustomAttributes = "";
            $this->min_price->HrefValue = "";
            $this->min_price->TooltipValue = "";

            // max_price
            $this->max_price->LinkCustomAttributes = "";
            $this->max_price->HrefValue = "";
            $this->max_price->TooltipValue = "";

            // usable_area_min
            $this->usable_area_min->LinkCustomAttributes = "";
            $this->usable_area_min->HrefValue = "";
            $this->usable_area_min->TooltipValue = "";

            // usable_area_max
            $this->usable_area_max->LinkCustomAttributes = "";
            $this->usable_area_max->HrefValue = "";
            $this->usable_area_max->TooltipValue = "";

            // land_size_area_min
            $this->land_size_area_min->LinkCustomAttributes = "";
            $this->land_size_area_min->HrefValue = "";
            $this->land_size_area_min->TooltipValue = "";

            // land_size_area_max
            $this->land_size_area_max->LinkCustomAttributes = "";
            $this->land_size_area_max->HrefValue = "";
            $this->land_size_area_max->TooltipValue = "";

            // bedroom
            $this->bedroom->LinkCustomAttributes = "";
            $this->bedroom->HrefValue = "";
            $this->bedroom->TooltipValue = "";

            // latitude
            $this->latitude->LinkCustomAttributes = "";
            $this->latitude->HrefValue = "";
            $this->latitude->TooltipValue = "";

            // longitude
            $this->longitude->LinkCustomAttributes = "";
            $this->longitude->HrefValue = "";
            $this->longitude->TooltipValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
            $this->cdate->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // category_id
            $this->category_id->setupEditAttributes();
            $this->category_id->EditCustomAttributes = "";
            if (!$this->category_id->Raw) {
                $this->category_id->CurrentValue = HtmlDecode($this->category_id->CurrentValue);
            }
            $this->category_id->EditValue = HtmlEncode($this->category_id->CurrentValue);
            $curVal = strval($this->category_id->CurrentValue);
            if ($curVal != "") {
                $this->category_id->EditValue = $this->category_id->lookupCacheOption($curVal);
                if ($this->category_id->EditValue === null) { // Lookup from database
                    $filterWrk = "`category_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`isactive`=1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->category_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->category_id->Lookup->renderViewRow($rswrk[0]);
                        $this->category_id->EditValue = $this->category_id->displayValue($arwrk);
                    } else {
                        $this->category_id->EditValue = HtmlEncode($this->category_id->CurrentValue);
                    }
                }
            } else {
                $this->category_id->EditValue = null;
            }
            $this->category_id->PlaceHolder = RemoveHtml($this->category_id->caption());

            // brand_id
            $this->brand_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->brand_id->CurrentValue));
            if ($curVal != "") {
                $this->brand_id->ViewValue = $this->brand_id->lookupCacheOption($curVal);
            } else {
                $this->brand_id->ViewValue = $this->brand_id->Lookup !== null && is_array($this->brand_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->brand_id->ViewValue !== null) { // Load from cache
                $this->brand_id->EditValue = array_values($this->brand_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`brand_id`" . SearchString("=", trim($wrk), DATATYPE_NUMBER, "");
                    }
                }
                $lookupFilter = function() {
                    return "`isactive`=1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->brand_id->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->brand_id->EditValue = $arwrk;
            }
            $this->brand_id->PlaceHolder = RemoveHtml($this->brand_id->caption());

            // min_installment
            $this->min_installment->setupEditAttributes();
            $this->min_installment->EditCustomAttributes = "";
            if (!$this->min_installment->Raw) {
                $this->min_installment->CurrentValue = HtmlDecode($this->min_installment->CurrentValue);
            }
            $this->min_installment->EditValue = HtmlEncode($this->min_installment->CurrentValue);
            $this->min_installment->PlaceHolder = RemoveHtml($this->min_installment->caption());

            // max_installment
            $this->max_installment->setupEditAttributes();
            $this->max_installment->EditCustomAttributes = "";
            if (!$this->max_installment->Raw) {
                $this->max_installment->CurrentValue = HtmlDecode($this->max_installment->CurrentValue);
            }
            $this->max_installment->EditValue = HtmlEncode($this->max_installment->CurrentValue);
            $this->max_installment->PlaceHolder = RemoveHtml($this->max_installment->caption());

            // min_down
            $this->min_down->setupEditAttributes();
            $this->min_down->EditCustomAttributes = "";
            if (!$this->min_down->Raw) {
                $this->min_down->CurrentValue = HtmlDecode($this->min_down->CurrentValue);
            }
            $this->min_down->EditValue = HtmlEncode($this->min_down->CurrentValue);
            $this->min_down->PlaceHolder = RemoveHtml($this->min_down->caption());

            // max_down
            $this->max_down->setupEditAttributes();
            $this->max_down->EditCustomAttributes = "";
            if (!$this->max_down->Raw) {
                $this->max_down->CurrentValue = HtmlDecode($this->max_down->CurrentValue);
            }
            $this->max_down->EditValue = HtmlEncode($this->max_down->CurrentValue);
            $this->max_down->PlaceHolder = RemoveHtml($this->max_down->caption());

            // min_price
            $this->min_price->setupEditAttributes();
            $this->min_price->EditCustomAttributes = "";
            if (!$this->min_price->Raw) {
                $this->min_price->CurrentValue = HtmlDecode($this->min_price->CurrentValue);
            }
            $this->min_price->EditValue = HtmlEncode($this->min_price->CurrentValue);
            $this->min_price->PlaceHolder = RemoveHtml($this->min_price->caption());

            // max_price
            $this->max_price->setupEditAttributes();
            $this->max_price->EditCustomAttributes = "";
            if (!$this->max_price->Raw) {
                $this->max_price->CurrentValue = HtmlDecode($this->max_price->CurrentValue);
            }
            $this->max_price->EditValue = HtmlEncode($this->max_price->CurrentValue);
            $this->max_price->PlaceHolder = RemoveHtml($this->max_price->caption());

            // usable_area_min
            $this->usable_area_min->setupEditAttributes();
            $this->usable_area_min->EditCustomAttributes = "";
            if (!$this->usable_area_min->Raw) {
                $this->usable_area_min->CurrentValue = HtmlDecode($this->usable_area_min->CurrentValue);
            }
            $this->usable_area_min->EditValue = HtmlEncode($this->usable_area_min->CurrentValue);
            $this->usable_area_min->PlaceHolder = RemoveHtml($this->usable_area_min->caption());

            // usable_area_max
            $this->usable_area_max->setupEditAttributes();
            $this->usable_area_max->EditCustomAttributes = "";
            if (!$this->usable_area_max->Raw) {
                $this->usable_area_max->CurrentValue = HtmlDecode($this->usable_area_max->CurrentValue);
            }
            $this->usable_area_max->EditValue = HtmlEncode($this->usable_area_max->CurrentValue);
            $this->usable_area_max->PlaceHolder = RemoveHtml($this->usable_area_max->caption());

            // land_size_area_min
            $this->land_size_area_min->setupEditAttributes();
            $this->land_size_area_min->EditCustomAttributes = "";
            if (!$this->land_size_area_min->Raw) {
                $this->land_size_area_min->CurrentValue = HtmlDecode($this->land_size_area_min->CurrentValue);
            }
            $this->land_size_area_min->EditValue = HtmlEncode($this->land_size_area_min->CurrentValue);
            $this->land_size_area_min->PlaceHolder = RemoveHtml($this->land_size_area_min->caption());

            // land_size_area_max
            $this->land_size_area_max->setupEditAttributes();
            $this->land_size_area_max->EditCustomAttributes = "";
            if (!$this->land_size_area_max->Raw) {
                $this->land_size_area_max->CurrentValue = HtmlDecode($this->land_size_area_max->CurrentValue);
            }
            $this->land_size_area_max->EditValue = HtmlEncode($this->land_size_area_max->CurrentValue);
            $this->land_size_area_max->PlaceHolder = RemoveHtml($this->land_size_area_max->caption());

            // bedroom
            $this->bedroom->EditCustomAttributes = "";
            $this->bedroom->EditValue = $this->bedroom->options(false);
            $this->bedroom->PlaceHolder = RemoveHtml($this->bedroom->caption());

            // latitude
            $this->latitude->setupEditAttributes();
            $this->latitude->EditCustomAttributes = "";
            $this->latitude->EditValue = HtmlEncode($this->latitude->CurrentValue);
            $this->latitude->PlaceHolder = RemoveHtml($this->latitude->caption());
            if (strval($this->latitude->EditValue) != "" && is_numeric($this->latitude->EditValue)) {
                $this->latitude->EditValue = FormatNumber($this->latitude->EditValue, null);
                $this->latitude->OldValue = $this->latitude->EditValue;
            }

            // longitude
            $this->longitude->setupEditAttributes();
            $this->longitude->EditCustomAttributes = "";
            $this->longitude->EditValue = HtmlEncode($this->longitude->CurrentValue);
            $this->longitude->PlaceHolder = RemoveHtml($this->longitude->caption());
            if (strval($this->longitude->EditValue) != "" && is_numeric($this->longitude->EditValue)) {
                $this->longitude->EditValue = FormatNumber($this->longitude->EditValue, null);
                $this->longitude->OldValue = $this->longitude->EditValue;
            }

            // cdate

            // Add refer script

            // category_id
            $this->category_id->LinkCustomAttributes = "";
            $this->category_id->HrefValue = "";

            // brand_id
            $this->brand_id->LinkCustomAttributes = "";
            $this->brand_id->HrefValue = "";

            // min_installment
            $this->min_installment->LinkCustomAttributes = "";
            $this->min_installment->HrefValue = "";

            // max_installment
            $this->max_installment->LinkCustomAttributes = "";
            $this->max_installment->HrefValue = "";

            // min_down
            $this->min_down->LinkCustomAttributes = "";
            $this->min_down->HrefValue = "";

            // max_down
            $this->max_down->LinkCustomAttributes = "";
            $this->max_down->HrefValue = "";

            // min_price
            $this->min_price->LinkCustomAttributes = "";
            $this->min_price->HrefValue = "";

            // max_price
            $this->max_price->LinkCustomAttributes = "";
            $this->max_price->HrefValue = "";

            // usable_area_min
            $this->usable_area_min->LinkCustomAttributes = "";
            $this->usable_area_min->HrefValue = "";

            // usable_area_max
            $this->usable_area_max->LinkCustomAttributes = "";
            $this->usable_area_max->HrefValue = "";

            // land_size_area_min
            $this->land_size_area_min->LinkCustomAttributes = "";
            $this->land_size_area_min->HrefValue = "";

            // land_size_area_max
            $this->land_size_area_max->LinkCustomAttributes = "";
            $this->land_size_area_max->HrefValue = "";

            // bedroom
            $this->bedroom->LinkCustomAttributes = "";
            $this->bedroom->HrefValue = "";

            // latitude
            $this->latitude->LinkCustomAttributes = "";
            $this->latitude->HrefValue = "";

            // longitude
            $this->longitude->LinkCustomAttributes = "";
            $this->longitude->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // category_id
            $this->category_id->setupEditAttributes();
            $this->category_id->EditCustomAttributes = "";
            if (!$this->category_id->Raw) {
                $this->category_id->CurrentValue = HtmlDecode($this->category_id->CurrentValue);
            }
            $this->category_id->EditValue = HtmlEncode($this->category_id->CurrentValue);
            $curVal = strval($this->category_id->CurrentValue);
            if ($curVal != "") {
                $this->category_id->EditValue = $this->category_id->lookupCacheOption($curVal);
                if ($this->category_id->EditValue === null) { // Lookup from database
                    $filterWrk = "`category_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`isactive`=1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->category_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->category_id->Lookup->renderViewRow($rswrk[0]);
                        $this->category_id->EditValue = $this->category_id->displayValue($arwrk);
                    } else {
                        $this->category_id->EditValue = HtmlEncode($this->category_id->CurrentValue);
                    }
                }
            } else {
                $this->category_id->EditValue = null;
            }
            $this->category_id->PlaceHolder = RemoveHtml($this->category_id->caption());

            // brand_id
            $this->brand_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->brand_id->CurrentValue));
            if ($curVal != "") {
                $this->brand_id->ViewValue = $this->brand_id->lookupCacheOption($curVal);
            } else {
                $this->brand_id->ViewValue = $this->brand_id->Lookup !== null && is_array($this->brand_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->brand_id->ViewValue !== null) { // Load from cache
                $this->brand_id->EditValue = array_values($this->brand_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`brand_id`" . SearchString("=", trim($wrk), DATATYPE_NUMBER, "");
                    }
                }
                $lookupFilter = function() {
                    return "`isactive`=1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->brand_id->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->brand_id->EditValue = $arwrk;
            }
            $this->brand_id->PlaceHolder = RemoveHtml($this->brand_id->caption());

            // min_installment
            $this->min_installment->setupEditAttributes();
            $this->min_installment->EditCustomAttributes = "";
            if (!$this->min_installment->Raw) {
                $this->min_installment->CurrentValue = HtmlDecode($this->min_installment->CurrentValue);
            }
            $this->min_installment->EditValue = HtmlEncode($this->min_installment->CurrentValue);
            $this->min_installment->PlaceHolder = RemoveHtml($this->min_installment->caption());

            // max_installment
            $this->max_installment->setupEditAttributes();
            $this->max_installment->EditCustomAttributes = "";
            if (!$this->max_installment->Raw) {
                $this->max_installment->CurrentValue = HtmlDecode($this->max_installment->CurrentValue);
            }
            $this->max_installment->EditValue = HtmlEncode($this->max_installment->CurrentValue);
            $this->max_installment->PlaceHolder = RemoveHtml($this->max_installment->caption());

            // min_down
            $this->min_down->setupEditAttributes();
            $this->min_down->EditCustomAttributes = "";
            if (!$this->min_down->Raw) {
                $this->min_down->CurrentValue = HtmlDecode($this->min_down->CurrentValue);
            }
            $this->min_down->EditValue = HtmlEncode($this->min_down->CurrentValue);
            $this->min_down->PlaceHolder = RemoveHtml($this->min_down->caption());

            // max_down
            $this->max_down->setupEditAttributes();
            $this->max_down->EditCustomAttributes = "";
            if (!$this->max_down->Raw) {
                $this->max_down->CurrentValue = HtmlDecode($this->max_down->CurrentValue);
            }
            $this->max_down->EditValue = HtmlEncode($this->max_down->CurrentValue);
            $this->max_down->PlaceHolder = RemoveHtml($this->max_down->caption());

            // min_price
            $this->min_price->setupEditAttributes();
            $this->min_price->EditCustomAttributes = "";
            if (!$this->min_price->Raw) {
                $this->min_price->CurrentValue = HtmlDecode($this->min_price->CurrentValue);
            }
            $this->min_price->EditValue = HtmlEncode($this->min_price->CurrentValue);
            $this->min_price->PlaceHolder = RemoveHtml($this->min_price->caption());

            // max_price
            $this->max_price->setupEditAttributes();
            $this->max_price->EditCustomAttributes = "";
            if (!$this->max_price->Raw) {
                $this->max_price->CurrentValue = HtmlDecode($this->max_price->CurrentValue);
            }
            $this->max_price->EditValue = HtmlEncode($this->max_price->CurrentValue);
            $this->max_price->PlaceHolder = RemoveHtml($this->max_price->caption());

            // usable_area_min
            $this->usable_area_min->setupEditAttributes();
            $this->usable_area_min->EditCustomAttributes = "";
            if (!$this->usable_area_min->Raw) {
                $this->usable_area_min->CurrentValue = HtmlDecode($this->usable_area_min->CurrentValue);
            }
            $this->usable_area_min->EditValue = HtmlEncode($this->usable_area_min->CurrentValue);
            $this->usable_area_min->PlaceHolder = RemoveHtml($this->usable_area_min->caption());

            // usable_area_max
            $this->usable_area_max->setupEditAttributes();
            $this->usable_area_max->EditCustomAttributes = "";
            if (!$this->usable_area_max->Raw) {
                $this->usable_area_max->CurrentValue = HtmlDecode($this->usable_area_max->CurrentValue);
            }
            $this->usable_area_max->EditValue = HtmlEncode($this->usable_area_max->CurrentValue);
            $this->usable_area_max->PlaceHolder = RemoveHtml($this->usable_area_max->caption());

            // land_size_area_min
            $this->land_size_area_min->setupEditAttributes();
            $this->land_size_area_min->EditCustomAttributes = "";
            if (!$this->land_size_area_min->Raw) {
                $this->land_size_area_min->CurrentValue = HtmlDecode($this->land_size_area_min->CurrentValue);
            }
            $this->land_size_area_min->EditValue = HtmlEncode($this->land_size_area_min->CurrentValue);
            $this->land_size_area_min->PlaceHolder = RemoveHtml($this->land_size_area_min->caption());

            // land_size_area_max
            $this->land_size_area_max->setupEditAttributes();
            $this->land_size_area_max->EditCustomAttributes = "";
            if (!$this->land_size_area_max->Raw) {
                $this->land_size_area_max->CurrentValue = HtmlDecode($this->land_size_area_max->CurrentValue);
            }
            $this->land_size_area_max->EditValue = HtmlEncode($this->land_size_area_max->CurrentValue);
            $this->land_size_area_max->PlaceHolder = RemoveHtml($this->land_size_area_max->caption());

            // bedroom
            $this->bedroom->EditCustomAttributes = "";
            $this->bedroom->EditValue = $this->bedroom->options(false);
            $this->bedroom->PlaceHolder = RemoveHtml($this->bedroom->caption());

            // latitude
            $this->latitude->setupEditAttributes();
            $this->latitude->EditCustomAttributes = "";
            $this->latitude->EditValue = HtmlEncode($this->latitude->CurrentValue);
            $this->latitude->PlaceHolder = RemoveHtml($this->latitude->caption());
            if (strval($this->latitude->EditValue) != "" && is_numeric($this->latitude->EditValue)) {
                $this->latitude->EditValue = FormatNumber($this->latitude->EditValue, null);
                $this->latitude->OldValue = $this->latitude->EditValue;
            }

            // longitude
            $this->longitude->setupEditAttributes();
            $this->longitude->EditCustomAttributes = "";
            $this->longitude->EditValue = HtmlEncode($this->longitude->CurrentValue);
            $this->longitude->PlaceHolder = RemoveHtml($this->longitude->caption());
            if (strval($this->longitude->EditValue) != "" && is_numeric($this->longitude->EditValue)) {
                $this->longitude->EditValue = FormatNumber($this->longitude->EditValue, null);
                $this->longitude->OldValue = $this->longitude->EditValue;
            }

            // cdate

            // Edit refer script

            // category_id
            $this->category_id->LinkCustomAttributes = "";
            $this->category_id->HrefValue = "";

            // brand_id
            $this->brand_id->LinkCustomAttributes = "";
            $this->brand_id->HrefValue = "";

            // min_installment
            $this->min_installment->LinkCustomAttributes = "";
            $this->min_installment->HrefValue = "";

            // max_installment
            $this->max_installment->LinkCustomAttributes = "";
            $this->max_installment->HrefValue = "";

            // min_down
            $this->min_down->LinkCustomAttributes = "";
            $this->min_down->HrefValue = "";

            // max_down
            $this->max_down->LinkCustomAttributes = "";
            $this->max_down->HrefValue = "";

            // min_price
            $this->min_price->LinkCustomAttributes = "";
            $this->min_price->HrefValue = "";

            // max_price
            $this->max_price->LinkCustomAttributes = "";
            $this->max_price->HrefValue = "";

            // usable_area_min
            $this->usable_area_min->LinkCustomAttributes = "";
            $this->usable_area_min->HrefValue = "";

            // usable_area_max
            $this->usable_area_max->LinkCustomAttributes = "";
            $this->usable_area_max->HrefValue = "";

            // land_size_area_min
            $this->land_size_area_min->LinkCustomAttributes = "";
            $this->land_size_area_min->HrefValue = "";

            // land_size_area_max
            $this->land_size_area_max->LinkCustomAttributes = "";
            $this->land_size_area_max->HrefValue = "";

            // bedroom
            $this->bedroom->LinkCustomAttributes = "";
            $this->bedroom->HrefValue = "";

            // latitude
            $this->latitude->LinkCustomAttributes = "";
            $this->latitude->HrefValue = "";

            // longitude
            $this->longitude->LinkCustomAttributes = "";
            $this->longitude->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
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
        if ($this->category_id->Required) {
            if (!$this->category_id->IsDetailKey && EmptyValue($this->category_id->FormValue)) {
                $this->category_id->addErrorMessage(str_replace("%s", $this->category_id->caption(), $this->category_id->RequiredErrorMessage));
            }
        }
        if ($this->brand_id->Required) {
            if ($this->brand_id->FormValue == "") {
                $this->brand_id->addErrorMessage(str_replace("%s", $this->brand_id->caption(), $this->brand_id->RequiredErrorMessage));
            }
        }
        if ($this->min_installment->Required) {
            if (!$this->min_installment->IsDetailKey && EmptyValue($this->min_installment->FormValue)) {
                $this->min_installment->addErrorMessage(str_replace("%s", $this->min_installment->caption(), $this->min_installment->RequiredErrorMessage));
            }
        }
        if ($this->max_installment->Required) {
            if (!$this->max_installment->IsDetailKey && EmptyValue($this->max_installment->FormValue)) {
                $this->max_installment->addErrorMessage(str_replace("%s", $this->max_installment->caption(), $this->max_installment->RequiredErrorMessage));
            }
        }
        if ($this->min_down->Required) {
            if (!$this->min_down->IsDetailKey && EmptyValue($this->min_down->FormValue)) {
                $this->min_down->addErrorMessage(str_replace("%s", $this->min_down->caption(), $this->min_down->RequiredErrorMessage));
            }
        }
        if ($this->max_down->Required) {
            if (!$this->max_down->IsDetailKey && EmptyValue($this->max_down->FormValue)) {
                $this->max_down->addErrorMessage(str_replace("%s", $this->max_down->caption(), $this->max_down->RequiredErrorMessage));
            }
        }
        if ($this->min_price->Required) {
            if (!$this->min_price->IsDetailKey && EmptyValue($this->min_price->FormValue)) {
                $this->min_price->addErrorMessage(str_replace("%s", $this->min_price->caption(), $this->min_price->RequiredErrorMessage));
            }
        }
        if ($this->max_price->Required) {
            if (!$this->max_price->IsDetailKey && EmptyValue($this->max_price->FormValue)) {
                $this->max_price->addErrorMessage(str_replace("%s", $this->max_price->caption(), $this->max_price->RequiredErrorMessage));
            }
        }
        if ($this->usable_area_min->Required) {
            if (!$this->usable_area_min->IsDetailKey && EmptyValue($this->usable_area_min->FormValue)) {
                $this->usable_area_min->addErrorMessage(str_replace("%s", $this->usable_area_min->caption(), $this->usable_area_min->RequiredErrorMessage));
            }
        }
        if ($this->usable_area_max->Required) {
            if (!$this->usable_area_max->IsDetailKey && EmptyValue($this->usable_area_max->FormValue)) {
                $this->usable_area_max->addErrorMessage(str_replace("%s", $this->usable_area_max->caption(), $this->usable_area_max->RequiredErrorMessage));
            }
        }
        if ($this->land_size_area_min->Required) {
            if (!$this->land_size_area_min->IsDetailKey && EmptyValue($this->land_size_area_min->FormValue)) {
                $this->land_size_area_min->addErrorMessage(str_replace("%s", $this->land_size_area_min->caption(), $this->land_size_area_min->RequiredErrorMessage));
            }
        }
        if ($this->land_size_area_max->Required) {
            if (!$this->land_size_area_max->IsDetailKey && EmptyValue($this->land_size_area_max->FormValue)) {
                $this->land_size_area_max->addErrorMessage(str_replace("%s", $this->land_size_area_max->caption(), $this->land_size_area_max->RequiredErrorMessage));
            }
        }
        if ($this->bedroom->Required) {
            if ($this->bedroom->FormValue == "") {
                $this->bedroom->addErrorMessage(str_replace("%s", $this->bedroom->caption(), $this->bedroom->RequiredErrorMessage));
            }
        }
        if ($this->latitude->Required) {
            if (!$this->latitude->IsDetailKey && EmptyValue($this->latitude->FormValue)) {
                $this->latitude->addErrorMessage(str_replace("%s", $this->latitude->caption(), $this->latitude->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->latitude->FormValue)) {
            $this->latitude->addErrorMessage($this->latitude->getErrorMessage(false));
        }
        if ($this->longitude->Required) {
            if (!$this->longitude->IsDetailKey && EmptyValue($this->longitude->FormValue)) {
                $this->longitude->addErrorMessage(str_replace("%s", $this->longitude->caption(), $this->longitude->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->longitude->FormValue)) {
            $this->longitude->addErrorMessage($this->longitude->getErrorMessage(false));
        }
        if ($this->cdate->Required) {
            if (!$this->cdate->IsDetailKey && EmptyValue($this->cdate->FormValue)) {
                $this->cdate->addErrorMessage(str_replace("%s", $this->cdate->caption(), $this->cdate->RequiredErrorMessage));
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

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        if ($this->AuditTrailOnDelete) {
            $this->writeAuditTrailDummy($Language->phrase("BatchDeleteBegin")); // Batch delete begin
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['save_search_id'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
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

            // brand_id
            $this->brand_id->setDbValueDef($rsnew, $this->brand_id->CurrentValue, null, $this->brand_id->ReadOnly);

            // min_installment
            $this->min_installment->setDbValueDef($rsnew, $this->min_installment->CurrentValue, null, $this->min_installment->ReadOnly);

            // max_installment
            $this->max_installment->setDbValueDef($rsnew, $this->max_installment->CurrentValue, null, $this->max_installment->ReadOnly);

            // min_down
            $this->min_down->setDbValueDef($rsnew, $this->min_down->CurrentValue, null, $this->min_down->ReadOnly);

            // max_down
            $this->max_down->setDbValueDef($rsnew, $this->max_down->CurrentValue, null, $this->max_down->ReadOnly);

            // min_price
            $this->min_price->setDbValueDef($rsnew, $this->min_price->CurrentValue, null, $this->min_price->ReadOnly);

            // max_price
            $this->max_price->setDbValueDef($rsnew, $this->max_price->CurrentValue, null, $this->max_price->ReadOnly);

            // usable_area_min
            $this->usable_area_min->setDbValueDef($rsnew, $this->usable_area_min->CurrentValue, null, $this->usable_area_min->ReadOnly);

            // usable_area_max
            $this->usable_area_max->setDbValueDef($rsnew, $this->usable_area_max->CurrentValue, null, $this->usable_area_max->ReadOnly);

            // land_size_area_min
            $this->land_size_area_min->setDbValueDef($rsnew, $this->land_size_area_min->CurrentValue, null, $this->land_size_area_min->ReadOnly);

            // land_size_area_max
            $this->land_size_area_max->setDbValueDef($rsnew, $this->land_size_area_max->CurrentValue, null, $this->land_size_area_max->ReadOnly);

            // bedroom
            $this->bedroom->setDbValueDef($rsnew, $this->bedroom->CurrentValue, null, $this->bedroom->ReadOnly);

            // latitude
            $this->latitude->setDbValueDef($rsnew, $this->latitude->CurrentValue, null, $this->latitude->ReadOnly);

            // longitude
            $this->longitude->setDbValueDef($rsnew, $this->longitude->CurrentValue, null, $this->longitude->ReadOnly);

            // cdate
            $this->cdate->CurrentValue = CurrentDateTime();
            $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

            // Check referential integrity for master table 'buyer'
            $detailKeys = [];
            $keyValue = $rsnew['member_id'] ?? $rsold['member_id'];
            $detailKeys['member_id'] = $keyValue;
            $masterTable = Container("buyer");
            $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
            if (!EmptyValue($masterFilter)) {
                $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
                $validMasterRecord = $rsmaster !== false;
            } else { // Allow null value if not required field
                $validMasterRecord = $masterFilter === null;
            }
            if (!$validMasterRecord) {
                $relatedRecordMsg = str_replace("%t", "buyer", $Language->phrase("RelatedRecordRequired"));
                $this->setFailureMessage($relatedRecordMsg);
                return false;
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "buyer") {
            $this->member_id->CurrentValue = $this->member_id->getSessionValue();
        }

        // Check referential integrity for master table 'save_search'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["member_id"] = $this->member_id->getSessionValue();
        $masterTable = Container("buyer");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "buyer", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // category_id
        $this->category_id->setDbValueDef($rsnew, $this->category_id->CurrentValue, null, false);

        // brand_id
        $this->brand_id->setDbValueDef($rsnew, $this->brand_id->CurrentValue, null, false);

        // min_installment
        $this->min_installment->setDbValueDef($rsnew, $this->min_installment->CurrentValue, null, false);

        // max_installment
        $this->max_installment->setDbValueDef($rsnew, $this->max_installment->CurrentValue, null, false);

        // min_down
        $this->min_down->setDbValueDef($rsnew, $this->min_down->CurrentValue, null, false);

        // max_down
        $this->max_down->setDbValueDef($rsnew, $this->max_down->CurrentValue, null, false);

        // min_price
        $this->min_price->setDbValueDef($rsnew, $this->min_price->CurrentValue, null, false);

        // max_price
        $this->max_price->setDbValueDef($rsnew, $this->max_price->CurrentValue, null, false);

        // usable_area_min
        $this->usable_area_min->setDbValueDef($rsnew, $this->usable_area_min->CurrentValue, null, false);

        // usable_area_max
        $this->usable_area_max->setDbValueDef($rsnew, $this->usable_area_max->CurrentValue, null, false);

        // land_size_area_min
        $this->land_size_area_min->setDbValueDef($rsnew, $this->land_size_area_min->CurrentValue, null, false);

        // land_size_area_max
        $this->land_size_area_max->setDbValueDef($rsnew, $this->land_size_area_max->CurrentValue, null, false);

        // bedroom
        $this->bedroom->setDbValueDef($rsnew, $this->bedroom->CurrentValue, null, false);

        // latitude
        $this->latitude->setDbValueDef($rsnew, $this->latitude->CurrentValue, null, false);

        // longitude
        $this->longitude->setDbValueDef($rsnew, $this->longitude->CurrentValue, null, false);

        // cdate
        $this->cdate->CurrentValue = CurrentDateTime();
        $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

        // member_id
        if ($this->member_id->getSessionValue() != "") {
            $rsnew['member_id'] = $this->member_id->getSessionValue();
        }

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

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "buyer") {
            $masterTbl = Container("buyer");
            $this->member_id->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
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
                    break;
                case "x_category_id":
                    $lookupFilter = function () {
                        return "`isactive`=1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_brand_id":
                    $lookupFilter = function () {
                        return "`isactive`=1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_bedroom":
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
}
