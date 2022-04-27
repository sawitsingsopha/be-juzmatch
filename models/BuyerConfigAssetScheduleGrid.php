<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class BuyerConfigAssetScheduleGrid extends BuyerConfigAssetSchedule
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'buyer_config_asset_schedule';

    // Page object name
    public $PageObjName = "BuyerConfigAssetScheduleGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fbuyer_config_asset_schedulegrid";
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

        // Table object (buyer_config_asset_schedule)
        if (!isset($GLOBALS["buyer_config_asset_schedule"]) || get_class($GLOBALS["buyer_config_asset_schedule"]) == PROJECT_NAMESPACE . "buyer_config_asset_schedule") {
            $GLOBALS["buyer_config_asset_schedule"] = &$this;
        }
        $this->AddUrl = "buyerconfigassetscheduleadd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'buyer_config_asset_schedule');
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
                $tbl = Container("buyer_config_asset_schedule");
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
            $key .= @$ar['buyer_config_asset_schedule_id'];
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
            $this->buyer_config_asset_schedule_id->Visible = false;
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
        $this->buyer_config_asset_schedule_id->Visible = false;
        $this->member_id->Visible = false;
        $this->asset_id->Visible = false;
        $this->installment_all->setVisibility();
        $this->installment_price_per->setVisibility();
        $this->date_start_installment->setVisibility();
        $this->status_approve->setVisibility();
        $this->asset_price->setVisibility();
        $this->booking_price->setVisibility();
        $this->down_price->setVisibility();
        $this->move_in_on_20th->setVisibility();
        $this->number_days_pay_first_month->setVisibility();
        $this->number_days_in_first_month->setVisibility();
        $this->cdate->setVisibility();
        $this->cuser->Visible = false;
        $this->cip->Visible = false;
        $this->uuser->Visible = false;
        $this->uip->Visible = false;
        $this->udate->Visible = false;
        $this->annual_interest->Visible = false;
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
        $this->setupLookupOptions($this->asset_id);
        $this->setupLookupOptions($this->status_approve);
        $this->setupLookupOptions($this->move_in_on_20th);

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
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "buyer_asset") {
            $masterTbl = Container("buyer_asset");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = count($rsmaster) > 0;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("buyerassetlist"); // Return to master page
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
        $this->installment_price_per->FormValue = ""; // Clear form value
        $this->asset_price->FormValue = ""; // Clear form value
        $this->booking_price->FormValue = ""; // Clear form value
        $this->down_price->FormValue = ""; // Clear form value
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
                    $key .= $this->buyer_config_asset_schedule_id->CurrentValue;

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
        if ($CurrentForm->hasValue("x_installment_all") && $CurrentForm->hasValue("o_installment_all") && $this->installment_all->CurrentValue != $this->installment_all->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_installment_price_per") && $CurrentForm->hasValue("o_installment_price_per") && $this->installment_price_per->CurrentValue != $this->installment_price_per->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_date_start_installment") && $CurrentForm->hasValue("o_date_start_installment") && $this->date_start_installment->CurrentValue != $this->date_start_installment->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_status_approve") && $CurrentForm->hasValue("o_status_approve") && $this->status_approve->CurrentValue != $this->status_approve->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_asset_price") && $CurrentForm->hasValue("o_asset_price") && $this->asset_price->CurrentValue != $this->asset_price->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_booking_price") && $CurrentForm->hasValue("o_booking_price") && $this->booking_price->CurrentValue != $this->booking_price->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_down_price") && $CurrentForm->hasValue("o_down_price") && $this->down_price->CurrentValue != $this->down_price->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_move_in_on_20th") && $CurrentForm->hasValue("o_move_in_on_20th") && ConvertToBool($this->move_in_on_20th->CurrentValue) != ConvertToBool($this->move_in_on_20th->OldValue)) {
            return false;
        }
        if ($CurrentForm->hasValue("x_number_days_pay_first_month") && $CurrentForm->hasValue("o_number_days_pay_first_month") && $this->number_days_pay_first_month->CurrentValue != $this->number_days_pay_first_month->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_number_days_in_first_month") && $CurrentForm->hasValue("o_number_days_in_first_month") && $this->number_days_in_first_month->CurrentValue != $this->number_days_in_first_month->OldValue) {
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
        $this->installment_all->clearErrorMessage();
        $this->installment_price_per->clearErrorMessage();
        $this->date_start_installment->clearErrorMessage();
        $this->status_approve->clearErrorMessage();
        $this->asset_price->clearErrorMessage();
        $this->booking_price->clearErrorMessage();
        $this->down_price->clearErrorMessage();
        $this->move_in_on_20th->clearErrorMessage();
        $this->number_days_pay_first_month->clearErrorMessage();
        $this->number_days_in_first_month->clearErrorMessage();
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
                        $this->asset_id->setSessionValue("");
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

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = false;

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
                if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-ew-action=\"delete-grid-row\" data-rowindex=\"" . $this->RowIndex . "\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }

        // "sequence"
        $opt = $this->ListOptions["sequence"];
        $opt->Body = FormatSequenceNumber($this->RecordCount);
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

        // Add
        if ($this->CurrentMode == "view") { // Check view mode
            $item = &$option->add("add");
            $addcaption = HtmlTitle($Language->phrase("AddLink"));
            $this->AddUrl = $this->getAddUrl();
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
            $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        }
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
                    $item->Visible = $Security->canAdd();
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
        $this->buyer_config_asset_schedule_id->CurrentValue = null;
        $this->buyer_config_asset_schedule_id->OldValue = $this->buyer_config_asset_schedule_id->CurrentValue;
        $this->member_id->CurrentValue = null;
        $this->member_id->OldValue = $this->member_id->CurrentValue;
        $this->asset_id->CurrentValue = null;
        $this->asset_id->OldValue = $this->asset_id->CurrentValue;
        $this->installment_all->CurrentValue = null;
        $this->installment_all->OldValue = $this->installment_all->CurrentValue;
        $this->installment_price_per->CurrentValue = null;
        $this->installment_price_per->OldValue = $this->installment_price_per->CurrentValue;
        $this->date_start_installment->CurrentValue = null;
        $this->date_start_installment->OldValue = $this->date_start_installment->CurrentValue;
        $this->status_approve->CurrentValue = 0;
        $this->status_approve->OldValue = $this->status_approve->CurrentValue;
        $this->asset_price->CurrentValue = null;
        $this->asset_price->OldValue = $this->asset_price->CurrentValue;
        $this->booking_price->CurrentValue = null;
        $this->booking_price->OldValue = $this->booking_price->CurrentValue;
        $this->down_price->CurrentValue = null;
        $this->down_price->OldValue = $this->down_price->CurrentValue;
        $this->move_in_on_20th->CurrentValue = 0;
        $this->move_in_on_20th->OldValue = $this->move_in_on_20th->CurrentValue;
        $this->number_days_pay_first_month->CurrentValue = 0;
        $this->number_days_pay_first_month->OldValue = $this->number_days_pay_first_month->CurrentValue;
        $this->number_days_in_first_month->CurrentValue = null;
        $this->number_days_in_first_month->OldValue = $this->number_days_in_first_month->CurrentValue;
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
        $this->annual_interest->CurrentValue = null;
        $this->annual_interest->OldValue = $this->annual_interest->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'installment_all' first before field var 'x_installment_all'
        $val = $CurrentForm->hasValue("installment_all") ? $CurrentForm->getValue("installment_all") : $CurrentForm->getValue("x_installment_all");
        if (!$this->installment_all->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->installment_all->Visible = false; // Disable update for API request
            } else {
                $this->installment_all->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_installment_all")) {
            $this->installment_all->setOldValue($CurrentForm->getValue("o_installment_all"));
        }

        // Check field name 'installment_price_per' first before field var 'x_installment_price_per'
        $val = $CurrentForm->hasValue("installment_price_per") ? $CurrentForm->getValue("installment_price_per") : $CurrentForm->getValue("x_installment_price_per");
        if (!$this->installment_price_per->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->installment_price_per->Visible = false; // Disable update for API request
            } else {
                $this->installment_price_per->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_installment_price_per")) {
            $this->installment_price_per->setOldValue($CurrentForm->getValue("o_installment_price_per"));
        }

        // Check field name 'date_start_installment' first before field var 'x_date_start_installment'
        $val = $CurrentForm->hasValue("date_start_installment") ? $CurrentForm->getValue("date_start_installment") : $CurrentForm->getValue("x_date_start_installment");
        if (!$this->date_start_installment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->date_start_installment->Visible = false; // Disable update for API request
            } else {
                $this->date_start_installment->setFormValue($val, true, $validate);
            }
            $this->date_start_installment->CurrentValue = UnFormatDateTime($this->date_start_installment->CurrentValue, $this->date_start_installment->formatPattern());
        }
        if ($CurrentForm->hasValue("o_date_start_installment")) {
            $this->date_start_installment->setOldValue($CurrentForm->getValue("o_date_start_installment"));
        }

        // Check field name 'status_approve' first before field var 'x_status_approve'
        $val = $CurrentForm->hasValue("status_approve") ? $CurrentForm->getValue("status_approve") : $CurrentForm->getValue("x_status_approve");
        if (!$this->status_approve->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_approve->Visible = false; // Disable update for API request
            } else {
                $this->status_approve->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_status_approve")) {
            $this->status_approve->setOldValue($CurrentForm->getValue("o_status_approve"));
        }

        // Check field name 'asset_price' first before field var 'x_asset_price'
        $val = $CurrentForm->hasValue("asset_price") ? $CurrentForm->getValue("asset_price") : $CurrentForm->getValue("x_asset_price");
        if (!$this->asset_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_price->Visible = false; // Disable update for API request
            } else {
                $this->asset_price->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_asset_price")) {
            $this->asset_price->setOldValue($CurrentForm->getValue("o_asset_price"));
        }

        // Check field name 'booking_price' first before field var 'x_booking_price'
        $val = $CurrentForm->hasValue("booking_price") ? $CurrentForm->getValue("booking_price") : $CurrentForm->getValue("x_booking_price");
        if (!$this->booking_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->booking_price->Visible = false; // Disable update for API request
            } else {
                $this->booking_price->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_booking_price")) {
            $this->booking_price->setOldValue($CurrentForm->getValue("o_booking_price"));
        }

        // Check field name 'down_price' first before field var 'x_down_price'
        $val = $CurrentForm->hasValue("down_price") ? $CurrentForm->getValue("down_price") : $CurrentForm->getValue("x_down_price");
        if (!$this->down_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->down_price->Visible = false; // Disable update for API request
            } else {
                $this->down_price->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_down_price")) {
            $this->down_price->setOldValue($CurrentForm->getValue("o_down_price"));
        }

        // Check field name 'move_in_on_20th' first before field var 'x_move_in_on_20th'
        $val = $CurrentForm->hasValue("move_in_on_20th") ? $CurrentForm->getValue("move_in_on_20th") : $CurrentForm->getValue("x_move_in_on_20th");
        if (!$this->move_in_on_20th->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->move_in_on_20th->Visible = false; // Disable update for API request
            } else {
                $this->move_in_on_20th->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_move_in_on_20th")) {
            $this->move_in_on_20th->setOldValue($CurrentForm->getValue("o_move_in_on_20th"));
        }

        // Check field name 'number_days_pay_first_month' first before field var 'x_number_days_pay_first_month'
        $val = $CurrentForm->hasValue("number_days_pay_first_month") ? $CurrentForm->getValue("number_days_pay_first_month") : $CurrentForm->getValue("x_number_days_pay_first_month");
        if (!$this->number_days_pay_first_month->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->number_days_pay_first_month->Visible = false; // Disable update for API request
            } else {
                $this->number_days_pay_first_month->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_number_days_pay_first_month")) {
            $this->number_days_pay_first_month->setOldValue($CurrentForm->getValue("o_number_days_pay_first_month"));
        }

        // Check field name 'number_days_in_first_month' first before field var 'x_number_days_in_first_month'
        $val = $CurrentForm->hasValue("number_days_in_first_month") ? $CurrentForm->getValue("number_days_in_first_month") : $CurrentForm->getValue("x_number_days_in_first_month");
        if (!$this->number_days_in_first_month->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->number_days_in_first_month->Visible = false; // Disable update for API request
            } else {
                $this->number_days_in_first_month->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_number_days_in_first_month")) {
            $this->number_days_in_first_month->setOldValue($CurrentForm->getValue("o_number_days_in_first_month"));
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

        // Check field name 'buyer_config_asset_schedule_id' first before field var 'x_buyer_config_asset_schedule_id'
        $val = $CurrentForm->hasValue("buyer_config_asset_schedule_id") ? $CurrentForm->getValue("buyer_config_asset_schedule_id") : $CurrentForm->getValue("x_buyer_config_asset_schedule_id");
        if (!$this->buyer_config_asset_schedule_id->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->buyer_config_asset_schedule_id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->buyer_config_asset_schedule_id->CurrentValue = $this->buyer_config_asset_schedule_id->FormValue;
        }
        $this->installment_all->CurrentValue = $this->installment_all->FormValue;
        $this->installment_price_per->CurrentValue = $this->installment_price_per->FormValue;
        $this->date_start_installment->CurrentValue = $this->date_start_installment->FormValue;
        $this->date_start_installment->CurrentValue = UnFormatDateTime($this->date_start_installment->CurrentValue, $this->date_start_installment->formatPattern());
        $this->status_approve->CurrentValue = $this->status_approve->FormValue;
        $this->asset_price->CurrentValue = $this->asset_price->FormValue;
        $this->booking_price->CurrentValue = $this->booking_price->FormValue;
        $this->down_price->CurrentValue = $this->down_price->FormValue;
        $this->move_in_on_20th->CurrentValue = $this->move_in_on_20th->FormValue;
        $this->number_days_pay_first_month->CurrentValue = $this->number_days_pay_first_month->FormValue;
        $this->number_days_in_first_month->CurrentValue = $this->number_days_in_first_month->FormValue;
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
        $this->buyer_config_asset_schedule_id->setDbValue($row['buyer_config_asset_schedule_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->installment_all->setDbValue($row['installment_all']);
        $this->installment_price_per->setDbValue($row['installment_price_per']);
        $this->date_start_installment->setDbValue($row['date_start_installment']);
        $this->status_approve->setDbValue($row['status_approve']);
        $this->asset_price->setDbValue($row['asset_price']);
        $this->booking_price->setDbValue($row['booking_price']);
        $this->down_price->setDbValue($row['down_price']);
        $this->move_in_on_20th->setDbValue($row['move_in_on_20th']);
        $this->number_days_pay_first_month->setDbValue($row['number_days_pay_first_month']);
        $this->number_days_in_first_month->setDbValue($row['number_days_in_first_month']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->udate->setDbValue($row['udate']);
        $this->annual_interest->setDbValue($row['annual_interest']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['buyer_config_asset_schedule_id'] = $this->buyer_config_asset_schedule_id->CurrentValue;
        $row['member_id'] = $this->member_id->CurrentValue;
        $row['asset_id'] = $this->asset_id->CurrentValue;
        $row['installment_all'] = $this->installment_all->CurrentValue;
        $row['installment_price_per'] = $this->installment_price_per->CurrentValue;
        $row['date_start_installment'] = $this->date_start_installment->CurrentValue;
        $row['status_approve'] = $this->status_approve->CurrentValue;
        $row['asset_price'] = $this->asset_price->CurrentValue;
        $row['booking_price'] = $this->booking_price->CurrentValue;
        $row['down_price'] = $this->down_price->CurrentValue;
        $row['move_in_on_20th'] = $this->move_in_on_20th->CurrentValue;
        $row['number_days_pay_first_month'] = $this->number_days_pay_first_month->CurrentValue;
        $row['number_days_in_first_month'] = $this->number_days_in_first_month->CurrentValue;
        $row['cdate'] = $this->cdate->CurrentValue;
        $row['cuser'] = $this->cuser->CurrentValue;
        $row['cip'] = $this->cip->CurrentValue;
        $row['uuser'] = $this->uuser->CurrentValue;
        $row['uip'] = $this->uip->CurrentValue;
        $row['udate'] = $this->udate->CurrentValue;
        $row['annual_interest'] = $this->annual_interest->CurrentValue;
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

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->CellCssStyle = "white-space: nowrap;";

        // member_id

        // asset_id

        // installment_all

        // installment_price_per

        // date_start_installment

        // status_approve
        $this->status_approve->CellCssStyle = "white-space: nowrap;";

        // asset_price

        // booking_price

        // down_price

        // move_in_on_20th

        // number_days_pay_first_month

        // number_days_in_first_month

        // cdate

        // cuser
        $this->cuser->CellCssStyle = "white-space: nowrap;";

        // cip
        $this->cip->CellCssStyle = "white-space: nowrap;";

        // uuser
        $this->uuser->CellCssStyle = "white-space: nowrap;";

        // uip
        $this->uip->CellCssStyle = "white-space: nowrap;";

        // udate
        $this->udate->CellCssStyle = "white-space: nowrap;";

        // annual_interest
        $this->annual_interest->CellCssStyle = "white-space: nowrap;";

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

            // installment_all
            $this->installment_all->ViewValue = $this->installment_all->CurrentValue;
            $this->installment_all->ViewValue = FormatNumber($this->installment_all->ViewValue, $this->installment_all->formatPattern());
            $this->installment_all->ViewCustomAttributes = "";

            // installment_price_per
            $this->installment_price_per->ViewValue = $this->installment_price_per->CurrentValue;
            $this->installment_price_per->ViewValue = FormatCurrency($this->installment_price_per->ViewValue, $this->installment_price_per->formatPattern());
            $this->installment_price_per->ViewCustomAttributes = "";

            // date_start_installment
            $this->date_start_installment->ViewValue = $this->date_start_installment->CurrentValue;
            $this->date_start_installment->ViewValue = FormatDateTime($this->date_start_installment->ViewValue, $this->date_start_installment->formatPattern());
            $this->date_start_installment->ViewCustomAttributes = "";

            // status_approve
            if (strval($this->status_approve->CurrentValue) != "") {
                $this->status_approve->ViewValue = $this->status_approve->optionCaption($this->status_approve->CurrentValue);
            } else {
                $this->status_approve->ViewValue = null;
            }
            $this->status_approve->ViewCustomAttributes = "";

            // asset_price
            $this->asset_price->ViewValue = $this->asset_price->CurrentValue;
            $this->asset_price->ViewValue = FormatNumber($this->asset_price->ViewValue, $this->asset_price->formatPattern());
            $this->asset_price->ViewCustomAttributes = "";

            // booking_price
            $this->booking_price->ViewValue = $this->booking_price->CurrentValue;
            $this->booking_price->ViewValue = FormatNumber($this->booking_price->ViewValue, $this->booking_price->formatPattern());
            $this->booking_price->ViewCustomAttributes = "";

            // down_price
            $this->down_price->ViewValue = $this->down_price->CurrentValue;
            $this->down_price->ViewValue = FormatNumber($this->down_price->ViewValue, $this->down_price->formatPattern());
            $this->down_price->ViewCustomAttributes = "";

            // move_in_on_20th
            if (ConvertToBool($this->move_in_on_20th->CurrentValue)) {
                $this->move_in_on_20th->ViewValue = $this->move_in_on_20th->tagCaption(1) != "" ? $this->move_in_on_20th->tagCaption(1) : "Yes";
            } else {
                $this->move_in_on_20th->ViewValue = $this->move_in_on_20th->tagCaption(2) != "" ? $this->move_in_on_20th->tagCaption(2) : "No";
            }
            $this->move_in_on_20th->ViewCustomAttributes = "";

            // number_days_pay_first_month
            $this->number_days_pay_first_month->ViewValue = $this->number_days_pay_first_month->CurrentValue;
            $this->number_days_pay_first_month->ViewValue = FormatNumber($this->number_days_pay_first_month->ViewValue, $this->number_days_pay_first_month->formatPattern());
            $this->number_days_pay_first_month->ViewCustomAttributes = "";

            // number_days_in_first_month
            $this->number_days_in_first_month->ViewValue = $this->number_days_in_first_month->CurrentValue;
            $this->number_days_in_first_month->ViewValue = FormatNumber($this->number_days_in_first_month->ViewValue, $this->number_days_in_first_month->formatPattern());
            $this->number_days_in_first_month->ViewCustomAttributes = "";

            // cdate
            $this->cdate->ViewValue = $this->cdate->CurrentValue;
            $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
            $this->cdate->ViewCustomAttributes = "";

            // installment_all
            $this->installment_all->LinkCustomAttributes = "";
            $this->installment_all->HrefValue = "";
            $this->installment_all->TooltipValue = "";

            // installment_price_per
            $this->installment_price_per->LinkCustomAttributes = "";
            $this->installment_price_per->HrefValue = "";
            $this->installment_price_per->TooltipValue = "";

            // date_start_installment
            $this->date_start_installment->LinkCustomAttributes = "";
            $this->date_start_installment->HrefValue = "";
            $this->date_start_installment->TooltipValue = "";

            // status_approve
            $this->status_approve->LinkCustomAttributes = "";
            $this->status_approve->HrefValue = "";
            $this->status_approve->TooltipValue = "";

            // asset_price
            $this->asset_price->LinkCustomAttributes = "";
            $this->asset_price->HrefValue = "";
            $this->asset_price->TooltipValue = "";

            // booking_price
            $this->booking_price->LinkCustomAttributes = "";
            $this->booking_price->HrefValue = "";
            $this->booking_price->TooltipValue = "";

            // down_price
            $this->down_price->LinkCustomAttributes = "";
            $this->down_price->HrefValue = "";
            $this->down_price->TooltipValue = "";

            // move_in_on_20th
            $this->move_in_on_20th->LinkCustomAttributes = "";
            $this->move_in_on_20th->HrefValue = "";
            $this->move_in_on_20th->TooltipValue = "";

            // number_days_pay_first_month
            $this->number_days_pay_first_month->LinkCustomAttributes = "";
            $this->number_days_pay_first_month->HrefValue = "";
            $this->number_days_pay_first_month->TooltipValue = "";

            // number_days_in_first_month
            $this->number_days_in_first_month->LinkCustomAttributes = "";
            $this->number_days_in_first_month->HrefValue = "";
            $this->number_days_in_first_month->TooltipValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
            $this->cdate->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // installment_all
            $this->installment_all->setupEditAttributes();
            $this->installment_all->EditCustomAttributes = "";
            $this->installment_all->EditValue = HtmlEncode($this->installment_all->CurrentValue);
            $this->installment_all->PlaceHolder = RemoveHtml($this->installment_all->caption());
            if (strval($this->installment_all->EditValue) != "" && is_numeric($this->installment_all->EditValue)) {
                $this->installment_all->EditValue = FormatNumber($this->installment_all->EditValue, null);
                $this->installment_all->OldValue = $this->installment_all->EditValue;
            }

            // installment_price_per
            $this->installment_price_per->setupEditAttributes();
            $this->installment_price_per->EditCustomAttributes = "";
            $this->installment_price_per->EditValue = HtmlEncode($this->installment_price_per->CurrentValue);
            $this->installment_price_per->PlaceHolder = RemoveHtml($this->installment_price_per->caption());
            if (strval($this->installment_price_per->EditValue) != "" && is_numeric($this->installment_price_per->EditValue)) {
                $this->installment_price_per->EditValue = FormatNumber($this->installment_price_per->EditValue, null);
                $this->installment_price_per->OldValue = $this->installment_price_per->EditValue;
            }

            // date_start_installment
            $this->date_start_installment->setupEditAttributes();
            $this->date_start_installment->EditCustomAttributes = "";
            $this->date_start_installment->EditValue = HtmlEncode(FormatDateTime($this->date_start_installment->CurrentValue, $this->date_start_installment->formatPattern()));
            $this->date_start_installment->PlaceHolder = RemoveHtml($this->date_start_installment->caption());

            // status_approve
            $this->status_approve->setupEditAttributes();
            $this->status_approve->EditCustomAttributes = "";
            $this->status_approve->EditValue = $this->status_approve->options(true);
            $this->status_approve->PlaceHolder = RemoveHtml($this->status_approve->caption());

            // asset_price
            $this->asset_price->setupEditAttributes();
            $this->asset_price->EditCustomAttributes = "";
            $this->asset_price->EditValue = HtmlEncode($this->asset_price->CurrentValue);
            $this->asset_price->PlaceHolder = RemoveHtml($this->asset_price->caption());
            if (strval($this->asset_price->EditValue) != "" && is_numeric($this->asset_price->EditValue)) {
                $this->asset_price->EditValue = FormatNumber($this->asset_price->EditValue, null);
                $this->asset_price->OldValue = $this->asset_price->EditValue;
            }

            // booking_price
            $this->booking_price->setupEditAttributes();
            $this->booking_price->EditCustomAttributes = "";
            $this->booking_price->EditValue = HtmlEncode($this->booking_price->CurrentValue);
            $this->booking_price->PlaceHolder = RemoveHtml($this->booking_price->caption());
            if (strval($this->booking_price->EditValue) != "" && is_numeric($this->booking_price->EditValue)) {
                $this->booking_price->EditValue = FormatNumber($this->booking_price->EditValue, null);
                $this->booking_price->OldValue = $this->booking_price->EditValue;
            }

            // down_price
            $this->down_price->setupEditAttributes();
            $this->down_price->EditCustomAttributes = "";
            $this->down_price->EditValue = HtmlEncode($this->down_price->CurrentValue);
            $this->down_price->PlaceHolder = RemoveHtml($this->down_price->caption());
            if (strval($this->down_price->EditValue) != "" && is_numeric($this->down_price->EditValue)) {
                $this->down_price->EditValue = FormatNumber($this->down_price->EditValue, null);
                $this->down_price->OldValue = $this->down_price->EditValue;
            }

            // move_in_on_20th
            $this->move_in_on_20th->EditCustomAttributes = "";
            $this->move_in_on_20th->EditValue = $this->move_in_on_20th->options(false);
            $this->move_in_on_20th->PlaceHolder = RemoveHtml($this->move_in_on_20th->caption());

            // number_days_pay_first_month
            $this->number_days_pay_first_month->setupEditAttributes();
            $this->number_days_pay_first_month->EditCustomAttributes = "";
            $this->number_days_pay_first_month->EditValue = HtmlEncode($this->number_days_pay_first_month->CurrentValue);
            $this->number_days_pay_first_month->PlaceHolder = RemoveHtml($this->number_days_pay_first_month->caption());
            if (strval($this->number_days_pay_first_month->EditValue) != "" && is_numeric($this->number_days_pay_first_month->EditValue)) {
                $this->number_days_pay_first_month->EditValue = FormatNumber($this->number_days_pay_first_month->EditValue, null);
                $this->number_days_pay_first_month->OldValue = $this->number_days_pay_first_month->EditValue;
            }

            // number_days_in_first_month
            $this->number_days_in_first_month->setupEditAttributes();
            $this->number_days_in_first_month->EditCustomAttributes = "";
            $this->number_days_in_first_month->EditValue = HtmlEncode($this->number_days_in_first_month->CurrentValue);
            $this->number_days_in_first_month->PlaceHolder = RemoveHtml($this->number_days_in_first_month->caption());
            if (strval($this->number_days_in_first_month->EditValue) != "" && is_numeric($this->number_days_in_first_month->EditValue)) {
                $this->number_days_in_first_month->EditValue = FormatNumber($this->number_days_in_first_month->EditValue, null);
                $this->number_days_in_first_month->OldValue = $this->number_days_in_first_month->EditValue;
            }

            // cdate

            // Add refer script

            // installment_all
            $this->installment_all->LinkCustomAttributes = "";
            $this->installment_all->HrefValue = "";

            // installment_price_per
            $this->installment_price_per->LinkCustomAttributes = "";
            $this->installment_price_per->HrefValue = "";

            // date_start_installment
            $this->date_start_installment->LinkCustomAttributes = "";
            $this->date_start_installment->HrefValue = "";

            // status_approve
            $this->status_approve->LinkCustomAttributes = "";
            $this->status_approve->HrefValue = "";

            // asset_price
            $this->asset_price->LinkCustomAttributes = "";
            $this->asset_price->HrefValue = "";

            // booking_price
            $this->booking_price->LinkCustomAttributes = "";
            $this->booking_price->HrefValue = "";

            // down_price
            $this->down_price->LinkCustomAttributes = "";
            $this->down_price->HrefValue = "";

            // move_in_on_20th
            $this->move_in_on_20th->LinkCustomAttributes = "";
            $this->move_in_on_20th->HrefValue = "";

            // number_days_pay_first_month
            $this->number_days_pay_first_month->LinkCustomAttributes = "";
            $this->number_days_pay_first_month->HrefValue = "";

            // number_days_in_first_month
            $this->number_days_in_first_month->LinkCustomAttributes = "";
            $this->number_days_in_first_month->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // installment_all
            $this->installment_all->setupEditAttributes();
            $this->installment_all->EditCustomAttributes = "";
            $this->installment_all->EditValue = HtmlEncode($this->installment_all->CurrentValue);
            $this->installment_all->PlaceHolder = RemoveHtml($this->installment_all->caption());
            if (strval($this->installment_all->EditValue) != "" && is_numeric($this->installment_all->EditValue)) {
                $this->installment_all->EditValue = FormatNumber($this->installment_all->EditValue, null);
                $this->installment_all->OldValue = $this->installment_all->EditValue;
            }

            // installment_price_per
            $this->installment_price_per->setupEditAttributes();
            $this->installment_price_per->EditCustomAttributes = "";
            $this->installment_price_per->EditValue = HtmlEncode($this->installment_price_per->CurrentValue);
            $this->installment_price_per->PlaceHolder = RemoveHtml($this->installment_price_per->caption());
            if (strval($this->installment_price_per->EditValue) != "" && is_numeric($this->installment_price_per->EditValue)) {
                $this->installment_price_per->EditValue = FormatNumber($this->installment_price_per->EditValue, null);
                $this->installment_price_per->OldValue = $this->installment_price_per->EditValue;
            }

            // date_start_installment
            $this->date_start_installment->setupEditAttributes();
            $this->date_start_installment->EditCustomAttributes = "";
            $this->date_start_installment->EditValue = HtmlEncode(FormatDateTime($this->date_start_installment->CurrentValue, $this->date_start_installment->formatPattern()));
            $this->date_start_installment->PlaceHolder = RemoveHtml($this->date_start_installment->caption());

            // status_approve
            $this->status_approve->setupEditAttributes();
            $this->status_approve->EditCustomAttributes = "";
            $this->status_approve->EditValue = $this->status_approve->options(true);
            $this->status_approve->PlaceHolder = RemoveHtml($this->status_approve->caption());

            // asset_price
            $this->asset_price->setupEditAttributes();
            $this->asset_price->EditCustomAttributes = "";
            $this->asset_price->EditValue = HtmlEncode($this->asset_price->CurrentValue);
            $this->asset_price->PlaceHolder = RemoveHtml($this->asset_price->caption());
            if (strval($this->asset_price->EditValue) != "" && is_numeric($this->asset_price->EditValue)) {
                $this->asset_price->EditValue = FormatNumber($this->asset_price->EditValue, null);
                $this->asset_price->OldValue = $this->asset_price->EditValue;
            }

            // booking_price
            $this->booking_price->setupEditAttributes();
            $this->booking_price->EditCustomAttributes = "";
            $this->booking_price->EditValue = HtmlEncode($this->booking_price->CurrentValue);
            $this->booking_price->PlaceHolder = RemoveHtml($this->booking_price->caption());
            if (strval($this->booking_price->EditValue) != "" && is_numeric($this->booking_price->EditValue)) {
                $this->booking_price->EditValue = FormatNumber($this->booking_price->EditValue, null);
                $this->booking_price->OldValue = $this->booking_price->EditValue;
            }

            // down_price
            $this->down_price->setupEditAttributes();
            $this->down_price->EditCustomAttributes = "";
            $this->down_price->EditValue = HtmlEncode($this->down_price->CurrentValue);
            $this->down_price->PlaceHolder = RemoveHtml($this->down_price->caption());
            if (strval($this->down_price->EditValue) != "" && is_numeric($this->down_price->EditValue)) {
                $this->down_price->EditValue = FormatNumber($this->down_price->EditValue, null);
                $this->down_price->OldValue = $this->down_price->EditValue;
            }

            // move_in_on_20th
            $this->move_in_on_20th->EditCustomAttributes = "";
            $this->move_in_on_20th->EditValue = $this->move_in_on_20th->options(false);
            $this->move_in_on_20th->PlaceHolder = RemoveHtml($this->move_in_on_20th->caption());

            // number_days_pay_first_month
            $this->number_days_pay_first_month->setupEditAttributes();
            $this->number_days_pay_first_month->EditCustomAttributes = "";
            $this->number_days_pay_first_month->EditValue = HtmlEncode($this->number_days_pay_first_month->CurrentValue);
            $this->number_days_pay_first_month->PlaceHolder = RemoveHtml($this->number_days_pay_first_month->caption());
            if (strval($this->number_days_pay_first_month->EditValue) != "" && is_numeric($this->number_days_pay_first_month->EditValue)) {
                $this->number_days_pay_first_month->EditValue = FormatNumber($this->number_days_pay_first_month->EditValue, null);
                $this->number_days_pay_first_month->OldValue = $this->number_days_pay_first_month->EditValue;
            }

            // number_days_in_first_month
            $this->number_days_in_first_month->setupEditAttributes();
            $this->number_days_in_first_month->EditCustomAttributes = "";
            $this->number_days_in_first_month->EditValue = HtmlEncode($this->number_days_in_first_month->CurrentValue);
            $this->number_days_in_first_month->PlaceHolder = RemoveHtml($this->number_days_in_first_month->caption());
            if (strval($this->number_days_in_first_month->EditValue) != "" && is_numeric($this->number_days_in_first_month->EditValue)) {
                $this->number_days_in_first_month->EditValue = FormatNumber($this->number_days_in_first_month->EditValue, null);
                $this->number_days_in_first_month->OldValue = $this->number_days_in_first_month->EditValue;
            }

            // cdate

            // Edit refer script

            // installment_all
            $this->installment_all->LinkCustomAttributes = "";
            $this->installment_all->HrefValue = "";

            // installment_price_per
            $this->installment_price_per->LinkCustomAttributes = "";
            $this->installment_price_per->HrefValue = "";

            // date_start_installment
            $this->date_start_installment->LinkCustomAttributes = "";
            $this->date_start_installment->HrefValue = "";

            // status_approve
            $this->status_approve->LinkCustomAttributes = "";
            $this->status_approve->HrefValue = "";

            // asset_price
            $this->asset_price->LinkCustomAttributes = "";
            $this->asset_price->HrefValue = "";

            // booking_price
            $this->booking_price->LinkCustomAttributes = "";
            $this->booking_price->HrefValue = "";

            // down_price
            $this->down_price->LinkCustomAttributes = "";
            $this->down_price->HrefValue = "";

            // move_in_on_20th
            $this->move_in_on_20th->LinkCustomAttributes = "";
            $this->move_in_on_20th->HrefValue = "";

            // number_days_pay_first_month
            $this->number_days_pay_first_month->LinkCustomAttributes = "";
            $this->number_days_pay_first_month->HrefValue = "";

            // number_days_in_first_month
            $this->number_days_in_first_month->LinkCustomAttributes = "";
            $this->number_days_in_first_month->HrefValue = "";

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
        if ($this->installment_all->Required) {
            if (!$this->installment_all->IsDetailKey && EmptyValue($this->installment_all->FormValue)) {
                $this->installment_all->addErrorMessage(str_replace("%s", $this->installment_all->caption(), $this->installment_all->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->installment_all->FormValue)) {
            $this->installment_all->addErrorMessage($this->installment_all->getErrorMessage(false));
        }
        if ($this->installment_price_per->Required) {
            if (!$this->installment_price_per->IsDetailKey && EmptyValue($this->installment_price_per->FormValue)) {
                $this->installment_price_per->addErrorMessage(str_replace("%s", $this->installment_price_per->caption(), $this->installment_price_per->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->installment_price_per->FormValue)) {
            $this->installment_price_per->addErrorMessage($this->installment_price_per->getErrorMessage(false));
        }
        if ($this->date_start_installment->Required) {
            if (!$this->date_start_installment->IsDetailKey && EmptyValue($this->date_start_installment->FormValue)) {
                $this->date_start_installment->addErrorMessage(str_replace("%s", $this->date_start_installment->caption(), $this->date_start_installment->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->date_start_installment->FormValue, $this->date_start_installment->formatPattern())) {
            $this->date_start_installment->addErrorMessage($this->date_start_installment->getErrorMessage(false));
        }
        if ($this->status_approve->Required) {
            if (!$this->status_approve->IsDetailKey && EmptyValue($this->status_approve->FormValue)) {
                $this->status_approve->addErrorMessage(str_replace("%s", $this->status_approve->caption(), $this->status_approve->RequiredErrorMessage));
            }
        }
        if ($this->asset_price->Required) {
            if (!$this->asset_price->IsDetailKey && EmptyValue($this->asset_price->FormValue)) {
                $this->asset_price->addErrorMessage(str_replace("%s", $this->asset_price->caption(), $this->asset_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->asset_price->FormValue)) {
            $this->asset_price->addErrorMessage($this->asset_price->getErrorMessage(false));
        }
        if ($this->booking_price->Required) {
            if (!$this->booking_price->IsDetailKey && EmptyValue($this->booking_price->FormValue)) {
                $this->booking_price->addErrorMessage(str_replace("%s", $this->booking_price->caption(), $this->booking_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->booking_price->FormValue)) {
            $this->booking_price->addErrorMessage($this->booking_price->getErrorMessage(false));
        }
        if ($this->down_price->Required) {
            if (!$this->down_price->IsDetailKey && EmptyValue($this->down_price->FormValue)) {
                $this->down_price->addErrorMessage(str_replace("%s", $this->down_price->caption(), $this->down_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->down_price->FormValue)) {
            $this->down_price->addErrorMessage($this->down_price->getErrorMessage(false));
        }
        if ($this->move_in_on_20th->Required) {
            if ($this->move_in_on_20th->FormValue == "") {
                $this->move_in_on_20th->addErrorMessage(str_replace("%s", $this->move_in_on_20th->caption(), $this->move_in_on_20th->RequiredErrorMessage));
            }
        }
        if ($this->number_days_pay_first_month->Required) {
            if (!$this->number_days_pay_first_month->IsDetailKey && EmptyValue($this->number_days_pay_first_month->FormValue)) {
                $this->number_days_pay_first_month->addErrorMessage(str_replace("%s", $this->number_days_pay_first_month->caption(), $this->number_days_pay_first_month->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->number_days_pay_first_month->FormValue)) {
            $this->number_days_pay_first_month->addErrorMessage($this->number_days_pay_first_month->getErrorMessage(false));
        }
        if ($this->number_days_in_first_month->Required) {
            if (!$this->number_days_in_first_month->IsDetailKey && EmptyValue($this->number_days_in_first_month->FormValue)) {
                $this->number_days_in_first_month->addErrorMessage(str_replace("%s", $this->number_days_in_first_month->caption(), $this->number_days_in_first_month->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->number_days_in_first_month->FormValue)) {
            $this->number_days_in_first_month->addErrorMessage($this->number_days_in_first_month->getErrorMessage(false));
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
            $thisKey .= $row['buyer_config_asset_schedule_id'];

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

            // installment_all
            $this->installment_all->setDbValueDef($rsnew, $this->installment_all->CurrentValue, null, $this->installment_all->ReadOnly);

            // installment_price_per
            $this->installment_price_per->setDbValueDef($rsnew, $this->installment_price_per->CurrentValue, null, $this->installment_price_per->ReadOnly);

            // date_start_installment
            $this->date_start_installment->setDbValueDef($rsnew, UnFormatDateTime($this->date_start_installment->CurrentValue, $this->date_start_installment->formatPattern()), null, $this->date_start_installment->ReadOnly);

            // status_approve
            $this->status_approve->setDbValueDef($rsnew, $this->status_approve->CurrentValue, null, $this->status_approve->ReadOnly);

            // asset_price
            $this->asset_price->setDbValueDef($rsnew, $this->asset_price->CurrentValue, null, $this->asset_price->ReadOnly);

            // booking_price
            $this->booking_price->setDbValueDef($rsnew, $this->booking_price->CurrentValue, null, $this->booking_price->ReadOnly);

            // down_price
            $this->down_price->setDbValueDef($rsnew, $this->down_price->CurrentValue, null, $this->down_price->ReadOnly);

            // move_in_on_20th
            $tmpBool = $this->move_in_on_20th->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->move_in_on_20th->setDbValueDef($rsnew, $tmpBool, 0, $this->move_in_on_20th->ReadOnly);

            // number_days_pay_first_month
            $this->number_days_pay_first_month->setDbValueDef($rsnew, $this->number_days_pay_first_month->CurrentValue, 0, $this->number_days_pay_first_month->ReadOnly);

            // number_days_in_first_month
            $this->number_days_in_first_month->setDbValueDef($rsnew, $this->number_days_in_first_month->CurrentValue, null, $this->number_days_in_first_month->ReadOnly);

            // cdate
            $this->cdate->CurrentValue = CurrentDateTime();
            $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

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
        if ($this->getCurrentMasterTable() == "buyer_asset") {
            $this->asset_id->CurrentValue = $this->asset_id->getSessionValue();
            $this->member_id->CurrentValue = $this->member_id->getSessionValue();
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // installment_all
        $this->installment_all->setDbValueDef($rsnew, $this->installment_all->CurrentValue, null, false);

        // installment_price_per
        $this->installment_price_per->setDbValueDef($rsnew, $this->installment_price_per->CurrentValue, null, false);

        // date_start_installment
        $this->date_start_installment->setDbValueDef($rsnew, UnFormatDateTime($this->date_start_installment->CurrentValue, $this->date_start_installment->formatPattern()), null, false);

        // status_approve
        $this->status_approve->setDbValueDef($rsnew, $this->status_approve->CurrentValue, null, strval($this->status_approve->CurrentValue) == "");

        // asset_price
        $this->asset_price->setDbValueDef($rsnew, $this->asset_price->CurrentValue, null, false);

        // booking_price
        $this->booking_price->setDbValueDef($rsnew, $this->booking_price->CurrentValue, null, false);

        // down_price
        $this->down_price->setDbValueDef($rsnew, $this->down_price->CurrentValue, null, false);

        // move_in_on_20th
        $tmpBool = $this->move_in_on_20th->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->move_in_on_20th->setDbValueDef($rsnew, $tmpBool, 0, strval($this->move_in_on_20th->CurrentValue) == "");

        // number_days_pay_first_month
        $this->number_days_pay_first_month->setDbValueDef($rsnew, $this->number_days_pay_first_month->CurrentValue, 0, strval($this->number_days_pay_first_month->CurrentValue) == "");

        // number_days_in_first_month
        $this->number_days_in_first_month->setDbValueDef($rsnew, $this->number_days_in_first_month->CurrentValue, null, false);

        // cdate
        $this->cdate->CurrentValue = CurrentDateTime();
        $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

        // member_id
        if ($this->member_id->getSessionValue() != "") {
            $rsnew['member_id'] = $this->member_id->getSessionValue();
        }

        // asset_id
        if ($this->asset_id->getSessionValue() != "") {
            $rsnew['asset_id'] = $this->asset_id->getSessionValue();
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
        if ($masterTblVar == "buyer_asset") {
            $masterTbl = Container("buyer_asset");
            $this->asset_id->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
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
                case "x_asset_id":
                    break;
                case "x_status_approve":
                    break;
                case "x_move_in_on_20th":
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
