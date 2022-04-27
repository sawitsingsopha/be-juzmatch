<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class InvestorVerifyGrid extends InvestorVerify
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'investor_verify';

    // Page object name
    public $PageObjName = "InvestorVerifyGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "finvestor_verifygrid";
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

        // Table object (investor_verify)
        if (!isset($GLOBALS["investor_verify"]) || get_class($GLOBALS["investor_verify"]) == PROJECT_NAMESPACE . "investor_verify") {
            $GLOBALS["investor_verify"] = &$this;
        }
        $this->AddUrl = "investorverifyadd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'investor_verify');
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
                $tbl = Container("investor_verify");
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
            $key .= @$ar['juzcalculator_id'];
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
            $this->juzcalculator_id->Visible = false;
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
        $this->juzcalculator_id->Visible = false;
        $this->member_id->Visible = false;
        $this->firstname->Visible = false;
        $this->lastname->Visible = false;
        $this->phone->Visible = false;
        $this->_email->Visible = false;
        $this->status->Visible = false;
        $this->income_all->Visible = false;
        $this->outcome_all->Visible = false;
        $this->investment->setVisibility();
        $this->credit_limit->setVisibility();
        $this->monthly_payments->setVisibility();
        $this->highest_rental_price->setVisibility();
        $this->transfer->setVisibility();
        $this->total_invertor_year->setVisibility();
        $this->invert_payoff_day->setVisibility();
        $this->type_invertor->setVisibility();
        $this->invest_amount->setVisibility();
        $this->rent_price->Visible = false;
        $this->asset_price->Visible = false;
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

        // Set up master detail parameters
        $this->setupMasterParms();

        // Setup other options
        $this->setupOtherOptions();

        // Set up lookup cache
        $this->setupLookupOptions($this->member_id);
        $this->setupLookupOptions($this->status);
        $this->setupLookupOptions($this->transfer);
        $this->setupLookupOptions($this->type_invertor);

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
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "investor") {
            $masterTbl = Container("investor");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = count($rsmaster) > 0;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("investorlist"); // Return to master page
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
        $this->investment->FormValue = ""; // Clear form value
        $this->credit_limit->FormValue = ""; // Clear form value
        $this->monthly_payments->FormValue = ""; // Clear form value
        $this->highest_rental_price->FormValue = ""; // Clear form value
        $this->total_invertor_year->FormValue = ""; // Clear form value
        $this->invert_payoff_day->FormValue = ""; // Clear form value
        $this->invest_amount->FormValue = ""; // Clear form value
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
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
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
                    $key .= $this->juzcalculator_id->CurrentValue;

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
            $this->clearInlineMode(); // Clear grid add mode
        } else {
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
        if ($CurrentForm->hasValue("x_investment") && $CurrentForm->hasValue("o_investment") && $this->investment->CurrentValue != $this->investment->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_credit_limit") && $CurrentForm->hasValue("o_credit_limit") && $this->credit_limit->CurrentValue != $this->credit_limit->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_monthly_payments") && $CurrentForm->hasValue("o_monthly_payments") && $this->monthly_payments->CurrentValue != $this->monthly_payments->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_highest_rental_price") && $CurrentForm->hasValue("o_highest_rental_price") && $this->highest_rental_price->CurrentValue != $this->highest_rental_price->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_transfer") && $CurrentForm->hasValue("o_transfer") && $this->transfer->CurrentValue != $this->transfer->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_total_invertor_year") && $CurrentForm->hasValue("o_total_invertor_year") && $this->total_invertor_year->CurrentValue != $this->total_invertor_year->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_invert_payoff_day") && $CurrentForm->hasValue("o_invert_payoff_day") && $this->invert_payoff_day->CurrentValue != $this->invert_payoff_day->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_type_invertor") && $CurrentForm->hasValue("o_type_invertor") && $this->type_invertor->CurrentValue != $this->type_invertor->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_invest_amount") && $CurrentForm->hasValue("o_invest_amount") && $this->invest_amount->CurrentValue != $this->invest_amount->OldValue) {
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
        $this->investment->clearErrorMessage();
        $this->credit_limit->clearErrorMessage();
        $this->monthly_payments->clearErrorMessage();
        $this->highest_rental_price->clearErrorMessage();
        $this->transfer->clearErrorMessage();
        $this->total_invertor_year->clearErrorMessage();
        $this->invert_payoff_day->clearErrorMessage();
        $this->type_invertor->clearErrorMessage();
        $this->invest_amount->clearErrorMessage();
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
        $this->juzcalculator_id->CurrentValue = null;
        $this->juzcalculator_id->OldValue = $this->juzcalculator_id->CurrentValue;
        $this->member_id->CurrentValue = null;
        $this->member_id->OldValue = $this->member_id->CurrentValue;
        $this->firstname->CurrentValue = null;
        $this->firstname->OldValue = $this->firstname->CurrentValue;
        $this->lastname->CurrentValue = null;
        $this->lastname->OldValue = $this->lastname->CurrentValue;
        $this->phone->CurrentValue = null;
        $this->phone->OldValue = $this->phone->CurrentValue;
        $this->_email->CurrentValue = null;
        $this->_email->OldValue = $this->_email->CurrentValue;
        $this->status->CurrentValue = null;
        $this->status->OldValue = $this->status->CurrentValue;
        $this->income_all->CurrentValue = null;
        $this->income_all->OldValue = $this->income_all->CurrentValue;
        $this->outcome_all->CurrentValue = null;
        $this->outcome_all->OldValue = $this->outcome_all->CurrentValue;
        $this->investment->CurrentValue = null;
        $this->investment->OldValue = $this->investment->CurrentValue;
        $this->credit_limit->CurrentValue = null;
        $this->credit_limit->OldValue = $this->credit_limit->CurrentValue;
        $this->monthly_payments->CurrentValue = null;
        $this->monthly_payments->OldValue = $this->monthly_payments->CurrentValue;
        $this->highest_rental_price->CurrentValue = null;
        $this->highest_rental_price->OldValue = $this->highest_rental_price->CurrentValue;
        $this->transfer->CurrentValue = null;
        $this->transfer->OldValue = $this->transfer->CurrentValue;
        $this->total_invertor_year->CurrentValue = null;
        $this->total_invertor_year->OldValue = $this->total_invertor_year->CurrentValue;
        $this->invert_payoff_day->CurrentValue = null;
        $this->invert_payoff_day->OldValue = $this->invert_payoff_day->CurrentValue;
        $this->type_invertor->CurrentValue = null;
        $this->type_invertor->OldValue = $this->type_invertor->CurrentValue;
        $this->invest_amount->CurrentValue = null;
        $this->invest_amount->OldValue = $this->invest_amount->CurrentValue;
        $this->rent_price->CurrentValue = null;
        $this->rent_price->OldValue = $this->rent_price->CurrentValue;
        $this->asset_price->CurrentValue = null;
        $this->asset_price->OldValue = $this->asset_price->CurrentValue;
        $this->cdate->CurrentValue = null;
        $this->cdate->OldValue = $this->cdate->CurrentValue;
        $this->cuser->CurrentValue = null;
        $this->cuser->OldValue = $this->cuser->CurrentValue;
        $this->cip->CurrentValue = null;
        $this->cip->OldValue = $this->cip->CurrentValue;
        $this->udate->CurrentValue = null;
        $this->udate->OldValue = $this->udate->CurrentValue;
        $this->uuser->CurrentValue = null;
        $this->uuser->OldValue = $this->uuser->CurrentValue;
        $this->uip->CurrentValue = null;
        $this->uip->OldValue = $this->uip->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'investment' first before field var 'x_investment'
        $val = $CurrentForm->hasValue("investment") ? $CurrentForm->getValue("investment") : $CurrentForm->getValue("x_investment");
        if (!$this->investment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investment->Visible = false; // Disable update for API request
            } else {
                $this->investment->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_investment")) {
            $this->investment->setOldValue($CurrentForm->getValue("o_investment"));
        }

        // Check field name 'credit_limit' first before field var 'x_credit_limit'
        $val = $CurrentForm->hasValue("credit_limit") ? $CurrentForm->getValue("credit_limit") : $CurrentForm->getValue("x_credit_limit");
        if (!$this->credit_limit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->credit_limit->Visible = false; // Disable update for API request
            } else {
                $this->credit_limit->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_credit_limit")) {
            $this->credit_limit->setOldValue($CurrentForm->getValue("o_credit_limit"));
        }

        // Check field name 'monthly_payments' first before field var 'x_monthly_payments'
        $val = $CurrentForm->hasValue("monthly_payments") ? $CurrentForm->getValue("monthly_payments") : $CurrentForm->getValue("x_monthly_payments");
        if (!$this->monthly_payments->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monthly_payments->Visible = false; // Disable update for API request
            } else {
                $this->monthly_payments->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_monthly_payments")) {
            $this->monthly_payments->setOldValue($CurrentForm->getValue("o_monthly_payments"));
        }

        // Check field name 'highest_rental_price' first before field var 'x_highest_rental_price'
        $val = $CurrentForm->hasValue("highest_rental_price") ? $CurrentForm->getValue("highest_rental_price") : $CurrentForm->getValue("x_highest_rental_price");
        if (!$this->highest_rental_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->highest_rental_price->Visible = false; // Disable update for API request
            } else {
                $this->highest_rental_price->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_highest_rental_price")) {
            $this->highest_rental_price->setOldValue($CurrentForm->getValue("o_highest_rental_price"));
        }

        // Check field name 'transfer' first before field var 'x_transfer'
        $val = $CurrentForm->hasValue("transfer") ? $CurrentForm->getValue("transfer") : $CurrentForm->getValue("x_transfer");
        if (!$this->transfer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->transfer->Visible = false; // Disable update for API request
            } else {
                $this->transfer->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_transfer")) {
            $this->transfer->setOldValue($CurrentForm->getValue("o_transfer"));
        }

        // Check field name 'total_invertor_year' first before field var 'x_total_invertor_year'
        $val = $CurrentForm->hasValue("total_invertor_year") ? $CurrentForm->getValue("total_invertor_year") : $CurrentForm->getValue("x_total_invertor_year");
        if (!$this->total_invertor_year->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->total_invertor_year->Visible = false; // Disable update for API request
            } else {
                $this->total_invertor_year->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_total_invertor_year")) {
            $this->total_invertor_year->setOldValue($CurrentForm->getValue("o_total_invertor_year"));
        }

        // Check field name 'invert_payoff_day' first before field var 'x_invert_payoff_day'
        $val = $CurrentForm->hasValue("invert_payoff_day") ? $CurrentForm->getValue("invert_payoff_day") : $CurrentForm->getValue("x_invert_payoff_day");
        if (!$this->invert_payoff_day->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->invert_payoff_day->Visible = false; // Disable update for API request
            } else {
                $this->invert_payoff_day->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_invert_payoff_day")) {
            $this->invert_payoff_day->setOldValue($CurrentForm->getValue("o_invert_payoff_day"));
        }

        // Check field name 'type_invertor' first before field var 'x_type_invertor'
        $val = $CurrentForm->hasValue("type_invertor") ? $CurrentForm->getValue("type_invertor") : $CurrentForm->getValue("x_type_invertor");
        if (!$this->type_invertor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->type_invertor->Visible = false; // Disable update for API request
            } else {
                $this->type_invertor->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_type_invertor")) {
            $this->type_invertor->setOldValue($CurrentForm->getValue("o_type_invertor"));
        }

        // Check field name 'invest_amount' first before field var 'x_invest_amount'
        $val = $CurrentForm->hasValue("invest_amount") ? $CurrentForm->getValue("invest_amount") : $CurrentForm->getValue("x_invest_amount");
        if (!$this->invest_amount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->invest_amount->Visible = false; // Disable update for API request
            } else {
                $this->invest_amount->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_invest_amount")) {
            $this->invest_amount->setOldValue($CurrentForm->getValue("o_invest_amount"));
        }

        // Check field name 'cdate' first before field var 'x_cdate'
        $val = $CurrentForm->hasValue("cdate") ? $CurrentForm->getValue("cdate") : $CurrentForm->getValue("x_cdate");
        if (!$this->cdate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cdate->Visible = false; // Disable update for API request
            } else {
                $this->cdate->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_cdate")) {
            $this->cdate->setOldValue($CurrentForm->getValue("o_cdate"));
        }

        // Check field name 'juzcalculator_id' first before field var 'x_juzcalculator_id'
        $val = $CurrentForm->hasValue("juzcalculator_id") ? $CurrentForm->getValue("juzcalculator_id") : $CurrentForm->getValue("x_juzcalculator_id");
        if (!$this->juzcalculator_id->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->juzcalculator_id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->juzcalculator_id->CurrentValue = $this->juzcalculator_id->FormValue;
        }
        $this->investment->CurrentValue = $this->investment->FormValue;
        $this->credit_limit->CurrentValue = $this->credit_limit->FormValue;
        $this->monthly_payments->CurrentValue = $this->monthly_payments->FormValue;
        $this->highest_rental_price->CurrentValue = $this->highest_rental_price->FormValue;
        $this->transfer->CurrentValue = $this->transfer->FormValue;
        $this->total_invertor_year->CurrentValue = $this->total_invertor_year->FormValue;
        $this->invert_payoff_day->CurrentValue = $this->invert_payoff_day->FormValue;
        $this->type_invertor->CurrentValue = $this->type_invertor->FormValue;
        $this->invest_amount->CurrentValue = $this->invest_amount->FormValue;
        $this->cdate->CurrentValue = $this->cdate->FormValue;
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
        $this->juzcalculator_id->setDbValue($row['juzcalculator_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->firstname->setDbValue($row['firstname']);
        $this->lastname->setDbValue($row['lastname']);
        $this->phone->setDbValue($row['phone']);
        $this->_email->setDbValue($row['email']);
        $this->status->setDbValue($row['status']);
        $this->income_all->setDbValue($row['income_all']);
        $this->outcome_all->setDbValue($row['outcome_all']);
        $this->investment->setDbValue($row['investment']);
        $this->credit_limit->setDbValue($row['credit_limit']);
        $this->monthly_payments->setDbValue($row['monthly_payments']);
        $this->highest_rental_price->setDbValue($row['highest_rental_price']);
        $this->transfer->setDbValue($row['transfer']);
        $this->total_invertor_year->setDbValue($row['total_invertor_year']);
        $this->invert_payoff_day->setDbValue($row['invert_payoff_day']);
        $this->type_invertor->setDbValue($row['type_invertor']);
        $this->invest_amount->setDbValue($row['invest_amount']);
        $this->rent_price->setDbValue($row['rent_price']);
        $this->asset_price->setDbValue($row['asset_price']);
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
        $this->loadDefaultValues();
        $row = [];
        $row['juzcalculator_id'] = $this->juzcalculator_id->CurrentValue;
        $row['member_id'] = $this->member_id->CurrentValue;
        $row['firstname'] = $this->firstname->CurrentValue;
        $row['lastname'] = $this->lastname->CurrentValue;
        $row['phone'] = $this->phone->CurrentValue;
        $row['email'] = $this->_email->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['income_all'] = $this->income_all->CurrentValue;
        $row['outcome_all'] = $this->outcome_all->CurrentValue;
        $row['investment'] = $this->investment->CurrentValue;
        $row['credit_limit'] = $this->credit_limit->CurrentValue;
        $row['monthly_payments'] = $this->monthly_payments->CurrentValue;
        $row['highest_rental_price'] = $this->highest_rental_price->CurrentValue;
        $row['transfer'] = $this->transfer->CurrentValue;
        $row['total_invertor_year'] = $this->total_invertor_year->CurrentValue;
        $row['invert_payoff_day'] = $this->invert_payoff_day->CurrentValue;
        $row['type_invertor'] = $this->type_invertor->CurrentValue;
        $row['invest_amount'] = $this->invest_amount->CurrentValue;
        $row['rent_price'] = $this->rent_price->CurrentValue;
        $row['asset_price'] = $this->asset_price->CurrentValue;
        $row['cdate'] = $this->cdate->CurrentValue;
        $row['cuser'] = $this->cuser->CurrentValue;
        $row['cip'] = $this->cip->CurrentValue;
        $row['udate'] = $this->udate->CurrentValue;
        $row['uuser'] = $this->uuser->CurrentValue;
        $row['uip'] = $this->uip->CurrentValue;
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

        // juzcalculator_id
        $this->juzcalculator_id->CellCssStyle = "white-space: nowrap;";

        // member_id
        $this->member_id->CellCssStyle = "white-space: nowrap;";

        // firstname
        $this->firstname->CellCssStyle = "white-space: nowrap;";

        // lastname
        $this->lastname->CellCssStyle = "white-space: nowrap;";

        // phone
        $this->phone->CellCssStyle = "white-space: nowrap;";

        // email
        $this->_email->CellCssStyle = "white-space: nowrap;";

        // status
        $this->status->CellCssStyle = "white-space: nowrap;";

        // income_all
        $this->income_all->CellCssStyle = "white-space: nowrap;";

        // outcome_all
        $this->outcome_all->CellCssStyle = "white-space: nowrap;";

        // investment
        $this->investment->CellCssStyle = "white-space: nowrap;";

        // credit_limit
        $this->credit_limit->CellCssStyle = "white-space: nowrap;";

        // monthly_payments
        $this->monthly_payments->CellCssStyle = "white-space: nowrap;";

        // highest_rental_price
        $this->highest_rental_price->CellCssStyle = "white-space: nowrap;";

        // transfer
        $this->transfer->CellCssStyle = "white-space: nowrap;";

        // total_invertor_year
        $this->total_invertor_year->CellCssStyle = "white-space: nowrap;";

        // invert_payoff_day
        $this->invert_payoff_day->CellCssStyle = "white-space: nowrap;";

        // type_invertor
        $this->type_invertor->CellCssStyle = "white-space: nowrap;";

        // invest_amount
        $this->invest_amount->CellCssStyle = "white-space: nowrap;";

        // rent_price
        $this->rent_price->CellCssStyle = "white-space: nowrap;";

        // asset_price
        $this->asset_price->CellCssStyle = "white-space: nowrap;";

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // investment
            $this->investment->ViewValue = $this->investment->CurrentValue;
            $this->investment->ViewValue = FormatNumber($this->investment->ViewValue, $this->investment->formatPattern());
            $this->investment->ViewCustomAttributes = "";

            // credit_limit
            $this->credit_limit->ViewValue = $this->credit_limit->CurrentValue;
            $this->credit_limit->ViewValue = FormatNumber($this->credit_limit->ViewValue, $this->credit_limit->formatPattern());
            $this->credit_limit->ViewCustomAttributes = "";

            // monthly_payments
            $this->monthly_payments->ViewValue = $this->monthly_payments->CurrentValue;
            $this->monthly_payments->ViewValue = FormatNumber($this->monthly_payments->ViewValue, $this->monthly_payments->formatPattern());
            $this->monthly_payments->ViewCustomAttributes = "";

            // highest_rental_price
            $this->highest_rental_price->ViewValue = $this->highest_rental_price->CurrentValue;
            $this->highest_rental_price->ViewValue = FormatNumber($this->highest_rental_price->ViewValue, $this->highest_rental_price->formatPattern());
            $this->highest_rental_price->ViewCustomAttributes = "";

            // transfer
            if (strval($this->transfer->CurrentValue) != "") {
                $this->transfer->ViewValue = $this->transfer->optionCaption($this->transfer->CurrentValue);
            } else {
                $this->transfer->ViewValue = null;
            }
            $this->transfer->ViewCustomAttributes = "";

            // total_invertor_year
            $this->total_invertor_year->ViewValue = $this->total_invertor_year->CurrentValue;
            $this->total_invertor_year->ViewValue = FormatNumber($this->total_invertor_year->ViewValue, $this->total_invertor_year->formatPattern());
            $this->total_invertor_year->ViewCustomAttributes = "";

            // invert_payoff_day
            $this->invert_payoff_day->ViewValue = $this->invert_payoff_day->CurrentValue;
            $this->invert_payoff_day->ViewValue = FormatNumber($this->invert_payoff_day->ViewValue, $this->invert_payoff_day->formatPattern());
            $this->invert_payoff_day->ViewCustomAttributes = "";

            // type_invertor
            if (strval($this->type_invertor->CurrentValue) != "") {
                $this->type_invertor->ViewValue = $this->type_invertor->optionCaption($this->type_invertor->CurrentValue);
            } else {
                $this->type_invertor->ViewValue = null;
            }
            $this->type_invertor->ViewCustomAttributes = "";

            // invest_amount
            $this->invest_amount->ViewValue = $this->invest_amount->CurrentValue;
            $this->invest_amount->ViewValue = FormatNumber($this->invest_amount->ViewValue, $this->invest_amount->formatPattern());
            $this->invest_amount->ViewCustomAttributes = "";

            // cdate
            $this->cdate->ViewValue = $this->cdate->CurrentValue;
            $this->cdate->ViewCustomAttributes = "";

            // cuser
            $this->cuser->ViewValue = $this->cuser->CurrentValue;
            $this->cuser->ViewCustomAttributes = "";

            // cip
            $this->cip->ViewValue = $this->cip->CurrentValue;
            $this->cip->ViewCustomAttributes = "";

            // udate
            $this->udate->ViewValue = $this->udate->CurrentValue;
            $this->udate->ViewCustomAttributes = "";

            // uuser
            $this->uuser->ViewValue = $this->uuser->CurrentValue;
            $this->uuser->ViewCustomAttributes = "";

            // uip
            $this->uip->ViewValue = $this->uip->CurrentValue;
            $this->uip->ViewCustomAttributes = "";

            // investment
            $this->investment->LinkCustomAttributes = "";
            $this->investment->HrefValue = "";
            $this->investment->TooltipValue = "";

            // credit_limit
            $this->credit_limit->LinkCustomAttributes = "";
            $this->credit_limit->HrefValue = "";
            $this->credit_limit->TooltipValue = "";

            // monthly_payments
            $this->monthly_payments->LinkCustomAttributes = "";
            $this->monthly_payments->HrefValue = "";
            $this->monthly_payments->TooltipValue = "";

            // highest_rental_price
            $this->highest_rental_price->LinkCustomAttributes = "";
            $this->highest_rental_price->HrefValue = "";
            $this->highest_rental_price->TooltipValue = "";

            // transfer
            $this->transfer->LinkCustomAttributes = "";
            $this->transfer->HrefValue = "";
            $this->transfer->TooltipValue = "";

            // total_invertor_year
            $this->total_invertor_year->LinkCustomAttributes = "";
            $this->total_invertor_year->HrefValue = "";
            $this->total_invertor_year->TooltipValue = "";

            // invert_payoff_day
            $this->invert_payoff_day->LinkCustomAttributes = "";
            $this->invert_payoff_day->HrefValue = "";
            $this->invert_payoff_day->TooltipValue = "";

            // type_invertor
            $this->type_invertor->LinkCustomAttributes = "";
            $this->type_invertor->HrefValue = "";
            $this->type_invertor->TooltipValue = "";

            // invest_amount
            $this->invest_amount->LinkCustomAttributes = "";
            $this->invest_amount->HrefValue = "";
            $this->invest_amount->TooltipValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
            $this->cdate->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // investment
            $this->investment->setupEditAttributes();
            $this->investment->EditCustomAttributes = "";
            $this->investment->EditValue = HtmlEncode($this->investment->CurrentValue);
            $this->investment->PlaceHolder = RemoveHtml($this->investment->caption());
            if (strval($this->investment->EditValue) != "" && is_numeric($this->investment->EditValue)) {
                $this->investment->EditValue = FormatNumber($this->investment->EditValue, null);
                $this->investment->OldValue = $this->investment->EditValue;
            }

            // credit_limit
            $this->credit_limit->setupEditAttributes();
            $this->credit_limit->EditCustomAttributes = "";
            $this->credit_limit->EditValue = HtmlEncode($this->credit_limit->CurrentValue);
            $this->credit_limit->PlaceHolder = RemoveHtml($this->credit_limit->caption());
            if (strval($this->credit_limit->EditValue) != "" && is_numeric($this->credit_limit->EditValue)) {
                $this->credit_limit->EditValue = FormatNumber($this->credit_limit->EditValue, null);
                $this->credit_limit->OldValue = $this->credit_limit->EditValue;
            }

            // monthly_payments
            $this->monthly_payments->setupEditAttributes();
            $this->monthly_payments->EditCustomAttributes = "";
            $this->monthly_payments->EditValue = HtmlEncode($this->monthly_payments->CurrentValue);
            $this->monthly_payments->PlaceHolder = RemoveHtml($this->monthly_payments->caption());
            if (strval($this->monthly_payments->EditValue) != "" && is_numeric($this->monthly_payments->EditValue)) {
                $this->monthly_payments->EditValue = FormatNumber($this->monthly_payments->EditValue, null);
                $this->monthly_payments->OldValue = $this->monthly_payments->EditValue;
            }

            // highest_rental_price
            $this->highest_rental_price->setupEditAttributes();
            $this->highest_rental_price->EditCustomAttributes = "";
            $this->highest_rental_price->EditValue = HtmlEncode($this->highest_rental_price->CurrentValue);
            $this->highest_rental_price->PlaceHolder = RemoveHtml($this->highest_rental_price->caption());
            if (strval($this->highest_rental_price->EditValue) != "" && is_numeric($this->highest_rental_price->EditValue)) {
                $this->highest_rental_price->EditValue = FormatNumber($this->highest_rental_price->EditValue, null);
                $this->highest_rental_price->OldValue = $this->highest_rental_price->EditValue;
            }

            // transfer
            $this->transfer->EditCustomAttributes = "";
            $this->transfer->EditValue = $this->transfer->options(false);
            $this->transfer->PlaceHolder = RemoveHtml($this->transfer->caption());

            // total_invertor_year
            $this->total_invertor_year->setupEditAttributes();
            $this->total_invertor_year->EditCustomAttributes = "";
            $this->total_invertor_year->EditValue = HtmlEncode($this->total_invertor_year->CurrentValue);
            $this->total_invertor_year->PlaceHolder = RemoveHtml($this->total_invertor_year->caption());
            if (strval($this->total_invertor_year->EditValue) != "" && is_numeric($this->total_invertor_year->EditValue)) {
                $this->total_invertor_year->EditValue = FormatNumber($this->total_invertor_year->EditValue, null);
                $this->total_invertor_year->OldValue = $this->total_invertor_year->EditValue;
            }

            // invert_payoff_day
            $this->invert_payoff_day->setupEditAttributes();
            $this->invert_payoff_day->EditCustomAttributes = "";
            $this->invert_payoff_day->EditValue = HtmlEncode($this->invert_payoff_day->CurrentValue);
            $this->invert_payoff_day->PlaceHolder = RemoveHtml($this->invert_payoff_day->caption());
            if (strval($this->invert_payoff_day->EditValue) != "" && is_numeric($this->invert_payoff_day->EditValue)) {
                $this->invert_payoff_day->EditValue = FormatNumber($this->invert_payoff_day->EditValue, null);
                $this->invert_payoff_day->OldValue = $this->invert_payoff_day->EditValue;
            }

            // type_invertor
            $this->type_invertor->setupEditAttributes();
            $this->type_invertor->EditCustomAttributes = "";
            $this->type_invertor->EditValue = $this->type_invertor->options(true);
            $this->type_invertor->PlaceHolder = RemoveHtml($this->type_invertor->caption());

            // invest_amount
            $this->invest_amount->setupEditAttributes();
            $this->invest_amount->EditCustomAttributes = "";
            $this->invest_amount->EditValue = HtmlEncode($this->invest_amount->CurrentValue);
            $this->invest_amount->PlaceHolder = RemoveHtml($this->invest_amount->caption());
            if (strval($this->invest_amount->EditValue) != "" && is_numeric($this->invest_amount->EditValue)) {
                $this->invest_amount->EditValue = FormatNumber($this->invest_amount->EditValue, null);
                $this->invest_amount->OldValue = $this->invest_amount->EditValue;
            }

            // cdate

            // Add refer script

            // investment
            $this->investment->LinkCustomAttributes = "";
            $this->investment->HrefValue = "";

            // credit_limit
            $this->credit_limit->LinkCustomAttributes = "";
            $this->credit_limit->HrefValue = "";

            // monthly_payments
            $this->monthly_payments->LinkCustomAttributes = "";
            $this->monthly_payments->HrefValue = "";

            // highest_rental_price
            $this->highest_rental_price->LinkCustomAttributes = "";
            $this->highest_rental_price->HrefValue = "";

            // transfer
            $this->transfer->LinkCustomAttributes = "";
            $this->transfer->HrefValue = "";

            // total_invertor_year
            $this->total_invertor_year->LinkCustomAttributes = "";
            $this->total_invertor_year->HrefValue = "";

            // invert_payoff_day
            $this->invert_payoff_day->LinkCustomAttributes = "";
            $this->invert_payoff_day->HrefValue = "";

            // type_invertor
            $this->type_invertor->LinkCustomAttributes = "";
            $this->type_invertor->HrefValue = "";

            // invest_amount
            $this->invest_amount->LinkCustomAttributes = "";
            $this->invest_amount->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // investment
            $this->investment->setupEditAttributes();
            $this->investment->EditCustomAttributes = "";
            $this->investment->EditValue = HtmlEncode($this->investment->CurrentValue);
            $this->investment->PlaceHolder = RemoveHtml($this->investment->caption());
            if (strval($this->investment->EditValue) != "" && is_numeric($this->investment->EditValue)) {
                $this->investment->EditValue = FormatNumber($this->investment->EditValue, null);
                $this->investment->OldValue = $this->investment->EditValue;
            }

            // credit_limit
            $this->credit_limit->setupEditAttributes();
            $this->credit_limit->EditCustomAttributes = "";
            $this->credit_limit->EditValue = HtmlEncode($this->credit_limit->CurrentValue);
            $this->credit_limit->PlaceHolder = RemoveHtml($this->credit_limit->caption());
            if (strval($this->credit_limit->EditValue) != "" && is_numeric($this->credit_limit->EditValue)) {
                $this->credit_limit->EditValue = FormatNumber($this->credit_limit->EditValue, null);
                $this->credit_limit->OldValue = $this->credit_limit->EditValue;
            }

            // monthly_payments
            $this->monthly_payments->setupEditAttributes();
            $this->monthly_payments->EditCustomAttributes = "";
            $this->monthly_payments->EditValue = HtmlEncode($this->monthly_payments->CurrentValue);
            $this->monthly_payments->PlaceHolder = RemoveHtml($this->monthly_payments->caption());
            if (strval($this->monthly_payments->EditValue) != "" && is_numeric($this->monthly_payments->EditValue)) {
                $this->monthly_payments->EditValue = FormatNumber($this->monthly_payments->EditValue, null);
                $this->monthly_payments->OldValue = $this->monthly_payments->EditValue;
            }

            // highest_rental_price
            $this->highest_rental_price->setupEditAttributes();
            $this->highest_rental_price->EditCustomAttributes = "";
            $this->highest_rental_price->EditValue = HtmlEncode($this->highest_rental_price->CurrentValue);
            $this->highest_rental_price->PlaceHolder = RemoveHtml($this->highest_rental_price->caption());
            if (strval($this->highest_rental_price->EditValue) != "" && is_numeric($this->highest_rental_price->EditValue)) {
                $this->highest_rental_price->EditValue = FormatNumber($this->highest_rental_price->EditValue, null);
                $this->highest_rental_price->OldValue = $this->highest_rental_price->EditValue;
            }

            // transfer
            $this->transfer->EditCustomAttributes = "";
            $this->transfer->EditValue = $this->transfer->options(false);
            $this->transfer->PlaceHolder = RemoveHtml($this->transfer->caption());

            // total_invertor_year
            $this->total_invertor_year->setupEditAttributes();
            $this->total_invertor_year->EditCustomAttributes = "";
            $this->total_invertor_year->EditValue = HtmlEncode($this->total_invertor_year->CurrentValue);
            $this->total_invertor_year->PlaceHolder = RemoveHtml($this->total_invertor_year->caption());
            if (strval($this->total_invertor_year->EditValue) != "" && is_numeric($this->total_invertor_year->EditValue)) {
                $this->total_invertor_year->EditValue = FormatNumber($this->total_invertor_year->EditValue, null);
                $this->total_invertor_year->OldValue = $this->total_invertor_year->EditValue;
            }

            // invert_payoff_day
            $this->invert_payoff_day->setupEditAttributes();
            $this->invert_payoff_day->EditCustomAttributes = "";
            $this->invert_payoff_day->EditValue = HtmlEncode($this->invert_payoff_day->CurrentValue);
            $this->invert_payoff_day->PlaceHolder = RemoveHtml($this->invert_payoff_day->caption());
            if (strval($this->invert_payoff_day->EditValue) != "" && is_numeric($this->invert_payoff_day->EditValue)) {
                $this->invert_payoff_day->EditValue = FormatNumber($this->invert_payoff_day->EditValue, null);
                $this->invert_payoff_day->OldValue = $this->invert_payoff_day->EditValue;
            }

            // type_invertor
            $this->type_invertor->setupEditAttributes();
            $this->type_invertor->EditCustomAttributes = "";
            $this->type_invertor->EditValue = $this->type_invertor->options(true);
            $this->type_invertor->PlaceHolder = RemoveHtml($this->type_invertor->caption());

            // invest_amount
            $this->invest_amount->setupEditAttributes();
            $this->invest_amount->EditCustomAttributes = "";
            $this->invest_amount->EditValue = HtmlEncode($this->invest_amount->CurrentValue);
            $this->invest_amount->PlaceHolder = RemoveHtml($this->invest_amount->caption());
            if (strval($this->invest_amount->EditValue) != "" && is_numeric($this->invest_amount->EditValue)) {
                $this->invest_amount->EditValue = FormatNumber($this->invest_amount->EditValue, null);
                $this->invest_amount->OldValue = $this->invest_amount->EditValue;
            }

            // cdate

            // Edit refer script

            // investment
            $this->investment->LinkCustomAttributes = "";
            $this->investment->HrefValue = "";

            // credit_limit
            $this->credit_limit->LinkCustomAttributes = "";
            $this->credit_limit->HrefValue = "";

            // monthly_payments
            $this->monthly_payments->LinkCustomAttributes = "";
            $this->monthly_payments->HrefValue = "";

            // highest_rental_price
            $this->highest_rental_price->LinkCustomAttributes = "";
            $this->highest_rental_price->HrefValue = "";

            // transfer
            $this->transfer->LinkCustomAttributes = "";
            $this->transfer->HrefValue = "";

            // total_invertor_year
            $this->total_invertor_year->LinkCustomAttributes = "";
            $this->total_invertor_year->HrefValue = "";

            // invert_payoff_day
            $this->invert_payoff_day->LinkCustomAttributes = "";
            $this->invert_payoff_day->HrefValue = "";

            // type_invertor
            $this->type_invertor->LinkCustomAttributes = "";
            $this->type_invertor->HrefValue = "";

            // invest_amount
            $this->invest_amount->LinkCustomAttributes = "";
            $this->invest_amount->HrefValue = "";

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
        if ($this->investment->Required) {
            if (!$this->investment->IsDetailKey && EmptyValue($this->investment->FormValue)) {
                $this->investment->addErrorMessage(str_replace("%s", $this->investment->caption(), $this->investment->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->investment->FormValue)) {
            $this->investment->addErrorMessage($this->investment->getErrorMessage(false));
        }
        if ($this->credit_limit->Required) {
            if (!$this->credit_limit->IsDetailKey && EmptyValue($this->credit_limit->FormValue)) {
                $this->credit_limit->addErrorMessage(str_replace("%s", $this->credit_limit->caption(), $this->credit_limit->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->credit_limit->FormValue)) {
            $this->credit_limit->addErrorMessage($this->credit_limit->getErrorMessage(false));
        }
        if ($this->monthly_payments->Required) {
            if (!$this->monthly_payments->IsDetailKey && EmptyValue($this->monthly_payments->FormValue)) {
                $this->monthly_payments->addErrorMessage(str_replace("%s", $this->monthly_payments->caption(), $this->monthly_payments->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->monthly_payments->FormValue)) {
            $this->monthly_payments->addErrorMessage($this->monthly_payments->getErrorMessage(false));
        }
        if ($this->highest_rental_price->Required) {
            if (!$this->highest_rental_price->IsDetailKey && EmptyValue($this->highest_rental_price->FormValue)) {
                $this->highest_rental_price->addErrorMessage(str_replace("%s", $this->highest_rental_price->caption(), $this->highest_rental_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->highest_rental_price->FormValue)) {
            $this->highest_rental_price->addErrorMessage($this->highest_rental_price->getErrorMessage(false));
        }
        if ($this->transfer->Required) {
            if ($this->transfer->FormValue == "") {
                $this->transfer->addErrorMessage(str_replace("%s", $this->transfer->caption(), $this->transfer->RequiredErrorMessage));
            }
        }
        if ($this->total_invertor_year->Required) {
            if (!$this->total_invertor_year->IsDetailKey && EmptyValue($this->total_invertor_year->FormValue)) {
                $this->total_invertor_year->addErrorMessage(str_replace("%s", $this->total_invertor_year->caption(), $this->total_invertor_year->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->total_invertor_year->FormValue)) {
            $this->total_invertor_year->addErrorMessage($this->total_invertor_year->getErrorMessage(false));
        }
        if ($this->invert_payoff_day->Required) {
            if (!$this->invert_payoff_day->IsDetailKey && EmptyValue($this->invert_payoff_day->FormValue)) {
                $this->invert_payoff_day->addErrorMessage(str_replace("%s", $this->invert_payoff_day->caption(), $this->invert_payoff_day->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->invert_payoff_day->FormValue)) {
            $this->invert_payoff_day->addErrorMessage($this->invert_payoff_day->getErrorMessage(false));
        }
        if ($this->type_invertor->Required) {
            if (!$this->type_invertor->IsDetailKey && EmptyValue($this->type_invertor->FormValue)) {
                $this->type_invertor->addErrorMessage(str_replace("%s", $this->type_invertor->caption(), $this->type_invertor->RequiredErrorMessage));
            }
        }
        if ($this->invest_amount->Required) {
            if (!$this->invest_amount->IsDetailKey && EmptyValue($this->invest_amount->FormValue)) {
                $this->invest_amount->addErrorMessage(str_replace("%s", $this->invest_amount->caption(), $this->invest_amount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->invest_amount->FormValue)) {
            $this->invest_amount->addErrorMessage($this->invest_amount->getErrorMessage(false));
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

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['juzcalculator_id'];

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

            // investment
            $this->investment->setDbValueDef($rsnew, $this->investment->CurrentValue, null, $this->investment->ReadOnly);

            // credit_limit
            $this->credit_limit->setDbValueDef($rsnew, $this->credit_limit->CurrentValue, null, $this->credit_limit->ReadOnly);

            // monthly_payments
            $this->monthly_payments->setDbValueDef($rsnew, $this->monthly_payments->CurrentValue, null, $this->monthly_payments->ReadOnly);

            // highest_rental_price
            $this->highest_rental_price->setDbValueDef($rsnew, $this->highest_rental_price->CurrentValue, null, $this->highest_rental_price->ReadOnly);

            // transfer
            $this->transfer->setDbValueDef($rsnew, $this->transfer->CurrentValue, null, $this->transfer->ReadOnly);

            // total_invertor_year
            $this->total_invertor_year->setDbValueDef($rsnew, $this->total_invertor_year->CurrentValue, null, $this->total_invertor_year->ReadOnly);

            // invert_payoff_day
            $this->invert_payoff_day->setDbValueDef($rsnew, $this->invert_payoff_day->CurrentValue, null, $this->invert_payoff_day->ReadOnly);

            // type_invertor
            $this->type_invertor->setDbValueDef($rsnew, $this->type_invertor->CurrentValue, null, $this->type_invertor->ReadOnly);

            // invest_amount
            $this->invest_amount->setDbValueDef($rsnew, $this->invest_amount->CurrentValue, null, $this->invest_amount->ReadOnly);

            // cdate
            $this->cdate->CurrentValue = CurrentDateTime();
            $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

            // Check referential integrity for master table 'investor'
            $detailKeys = [];
            $keyValue = $rsnew['member_id'] ?? $rsold['member_id'];
            $detailKeys['member_id'] = $keyValue;
            $masterTable = Container("investor");
            $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
            if (!EmptyValue($masterFilter)) {
                $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
                $validMasterRecord = $rsmaster !== false;
            } else { // Allow null value if not required field
                $validMasterRecord = $masterFilter === null;
            }
            if (!$validMasterRecord) {
                $relatedRecordMsg = str_replace("%t", "investor", $Language->phrase("RelatedRecordRequired"));
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
        if ($this->getCurrentMasterTable() == "investor") {
            $this->member_id->CurrentValue = $this->member_id->getSessionValue();
        }

        // Check referential integrity for master table 'investor_verify'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["member_id"] = $this->member_id->getSessionValue();
        $masterTable = Container("investor");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "investor", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // investment
        $this->investment->setDbValueDef($rsnew, $this->investment->CurrentValue, null, false);

        // credit_limit
        $this->credit_limit->setDbValueDef($rsnew, $this->credit_limit->CurrentValue, null, false);

        // monthly_payments
        $this->monthly_payments->setDbValueDef($rsnew, $this->monthly_payments->CurrentValue, null, false);

        // highest_rental_price
        $this->highest_rental_price->setDbValueDef($rsnew, $this->highest_rental_price->CurrentValue, null, false);

        // transfer
        $this->transfer->setDbValueDef($rsnew, $this->transfer->CurrentValue, null, false);

        // total_invertor_year
        $this->total_invertor_year->setDbValueDef($rsnew, $this->total_invertor_year->CurrentValue, null, false);

        // invert_payoff_day
        $this->invert_payoff_day->setDbValueDef($rsnew, $this->invert_payoff_day->CurrentValue, null, false);

        // type_invertor
        $this->type_invertor->setDbValueDef($rsnew, $this->type_invertor->CurrentValue, null, false);

        // invest_amount
        $this->invest_amount->setDbValueDef($rsnew, $this->invest_amount->CurrentValue, null, false);

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
        if ($masterTblVar == "investor") {
            $masterTbl = Container("investor");
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
                    $conn = Conn("DB");
                    break;
                case "x_status":
                    break;
                case "x_transfer":
                    break;
                case "x_type_invertor":
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
