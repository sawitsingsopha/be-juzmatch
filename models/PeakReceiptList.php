<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class PeakReceiptList extends PeakReceipt
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'peak_receipt';

    // Page object name
    public $PageObjName = "PeakReceiptList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fpeak_receiptlist";
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

        // Table object (peak_receipt)
        if (!isset($GLOBALS["peak_receipt"]) || get_class($GLOBALS["peak_receipt"]) == PROJECT_NAMESPACE . "peak_receipt") {
            $GLOBALS["peak_receipt"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "peakreceiptadd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "peakreceiptdelete";
        $this->MultiUpdateUrl = "peakreceiptupdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'peak_receipt');
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
                $tbl = Container("peak_receipt");
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
        $this->id->setVisibility();
        $this->create_date->setVisibility();
        $this->request_status->setVisibility();
        $this->request_date->setVisibility();
        $this->request_message->Visible = false;
        $this->issueddate->setVisibility();
        $this->duedate->setVisibility();
        $this->contactcode->setVisibility();
        $this->tag->Visible = false;
        $this->istaxinvoice->setVisibility();
        $this->taxstatus->setVisibility();
        $this->paymentdate->setVisibility();
        $this->paymentmethodid->setVisibility();
        $this->paymentMethodCode->setVisibility();
        $this->amount->setVisibility();
        $this->remark->setVisibility();
        $this->receipt_id->setVisibility();
        $this->receipt_code->setVisibility();
        $this->receipt_status->setVisibility();
        $this->preTaxAmount->setVisibility();
        $this->vatAmount->setVisibility();
        $this->netAmount->setVisibility();
        $this->whtAmount->setVisibility();
        $this->paymentAmount->setVisibility();
        $this->remainAmount->setVisibility();
        $this->remainWhtAmount->setVisibility();
        $this->onlineViewLink->Visible = false;
        $this->isPartialReceipt->setVisibility();
        $this->journals_id->setVisibility();
        $this->journals_code->setVisibility();
        $this->refid->setVisibility();
        $this->transition_type->setVisibility();
        $this->is_email->setVisibility();
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

            // Get basic search values
            $this->loadBasicSearchValues();

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
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
            $savedFilterList = $UserProfile->getSearchFilters(CurrentUserName(), "fpeak_receiptsrch");
        }
        $filterList = Concat($filterList, $this->id->AdvancedSearch->toJson(), ","); // Field id
        $filterList = Concat($filterList, $this->create_date->AdvancedSearch->toJson(), ","); // Field create_date
        $filterList = Concat($filterList, $this->request_status->AdvancedSearch->toJson(), ","); // Field request_status
        $filterList = Concat($filterList, $this->request_date->AdvancedSearch->toJson(), ","); // Field request_date
        $filterList = Concat($filterList, $this->request_message->AdvancedSearch->toJson(), ","); // Field request_message
        $filterList = Concat($filterList, $this->issueddate->AdvancedSearch->toJson(), ","); // Field issueddate
        $filterList = Concat($filterList, $this->duedate->AdvancedSearch->toJson(), ","); // Field duedate
        $filterList = Concat($filterList, $this->contactcode->AdvancedSearch->toJson(), ","); // Field contactcode
        $filterList = Concat($filterList, $this->tag->AdvancedSearch->toJson(), ","); // Field tag
        $filterList = Concat($filterList, $this->istaxinvoice->AdvancedSearch->toJson(), ","); // Field istaxinvoice
        $filterList = Concat($filterList, $this->taxstatus->AdvancedSearch->toJson(), ","); // Field taxstatus
        $filterList = Concat($filterList, $this->paymentdate->AdvancedSearch->toJson(), ","); // Field paymentdate
        $filterList = Concat($filterList, $this->paymentmethodid->AdvancedSearch->toJson(), ","); // Field paymentmethodid
        $filterList = Concat($filterList, $this->paymentMethodCode->AdvancedSearch->toJson(), ","); // Field paymentMethodCode
        $filterList = Concat($filterList, $this->amount->AdvancedSearch->toJson(), ","); // Field amount
        $filterList = Concat($filterList, $this->remark->AdvancedSearch->toJson(), ","); // Field remark
        $filterList = Concat($filterList, $this->receipt_id->AdvancedSearch->toJson(), ","); // Field receipt_id
        $filterList = Concat($filterList, $this->receipt_code->AdvancedSearch->toJson(), ","); // Field receipt_code
        $filterList = Concat($filterList, $this->receipt_status->AdvancedSearch->toJson(), ","); // Field receipt_status
        $filterList = Concat($filterList, $this->preTaxAmount->AdvancedSearch->toJson(), ","); // Field preTaxAmount
        $filterList = Concat($filterList, $this->vatAmount->AdvancedSearch->toJson(), ","); // Field vatAmount
        $filterList = Concat($filterList, $this->netAmount->AdvancedSearch->toJson(), ","); // Field netAmount
        $filterList = Concat($filterList, $this->whtAmount->AdvancedSearch->toJson(), ","); // Field whtAmount
        $filterList = Concat($filterList, $this->paymentAmount->AdvancedSearch->toJson(), ","); // Field paymentAmount
        $filterList = Concat($filterList, $this->remainAmount->AdvancedSearch->toJson(), ","); // Field remainAmount
        $filterList = Concat($filterList, $this->remainWhtAmount->AdvancedSearch->toJson(), ","); // Field remainWhtAmount
        $filterList = Concat($filterList, $this->onlineViewLink->AdvancedSearch->toJson(), ","); // Field onlineViewLink
        $filterList = Concat($filterList, $this->isPartialReceipt->AdvancedSearch->toJson(), ","); // Field isPartialReceipt
        $filterList = Concat($filterList, $this->journals_id->AdvancedSearch->toJson(), ","); // Field journals_id
        $filterList = Concat($filterList, $this->journals_code->AdvancedSearch->toJson(), ","); // Field journals_code
        $filterList = Concat($filterList, $this->refid->AdvancedSearch->toJson(), ","); // Field refid
        $filterList = Concat($filterList, $this->transition_type->AdvancedSearch->toJson(), ","); // Field transition_type
        $filterList = Concat($filterList, $this->is_email->AdvancedSearch->toJson(), ","); // Field is_email
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fpeak_receiptsrch", $filters);
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

        // Field id
        $this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
        $this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
        $this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
        $this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
        $this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
        $this->id->AdvancedSearch->save();

        // Field create_date
        $this->create_date->AdvancedSearch->SearchValue = @$filter["x_create_date"];
        $this->create_date->AdvancedSearch->SearchOperator = @$filter["z_create_date"];
        $this->create_date->AdvancedSearch->SearchCondition = @$filter["v_create_date"];
        $this->create_date->AdvancedSearch->SearchValue2 = @$filter["y_create_date"];
        $this->create_date->AdvancedSearch->SearchOperator2 = @$filter["w_create_date"];
        $this->create_date->AdvancedSearch->save();

        // Field request_status
        $this->request_status->AdvancedSearch->SearchValue = @$filter["x_request_status"];
        $this->request_status->AdvancedSearch->SearchOperator = @$filter["z_request_status"];
        $this->request_status->AdvancedSearch->SearchCondition = @$filter["v_request_status"];
        $this->request_status->AdvancedSearch->SearchValue2 = @$filter["y_request_status"];
        $this->request_status->AdvancedSearch->SearchOperator2 = @$filter["w_request_status"];
        $this->request_status->AdvancedSearch->save();

        // Field request_date
        $this->request_date->AdvancedSearch->SearchValue = @$filter["x_request_date"];
        $this->request_date->AdvancedSearch->SearchOperator = @$filter["z_request_date"];
        $this->request_date->AdvancedSearch->SearchCondition = @$filter["v_request_date"];
        $this->request_date->AdvancedSearch->SearchValue2 = @$filter["y_request_date"];
        $this->request_date->AdvancedSearch->SearchOperator2 = @$filter["w_request_date"];
        $this->request_date->AdvancedSearch->save();

        // Field request_message
        $this->request_message->AdvancedSearch->SearchValue = @$filter["x_request_message"];
        $this->request_message->AdvancedSearch->SearchOperator = @$filter["z_request_message"];
        $this->request_message->AdvancedSearch->SearchCondition = @$filter["v_request_message"];
        $this->request_message->AdvancedSearch->SearchValue2 = @$filter["y_request_message"];
        $this->request_message->AdvancedSearch->SearchOperator2 = @$filter["w_request_message"];
        $this->request_message->AdvancedSearch->save();

        // Field issueddate
        $this->issueddate->AdvancedSearch->SearchValue = @$filter["x_issueddate"];
        $this->issueddate->AdvancedSearch->SearchOperator = @$filter["z_issueddate"];
        $this->issueddate->AdvancedSearch->SearchCondition = @$filter["v_issueddate"];
        $this->issueddate->AdvancedSearch->SearchValue2 = @$filter["y_issueddate"];
        $this->issueddate->AdvancedSearch->SearchOperator2 = @$filter["w_issueddate"];
        $this->issueddate->AdvancedSearch->save();

        // Field duedate
        $this->duedate->AdvancedSearch->SearchValue = @$filter["x_duedate"];
        $this->duedate->AdvancedSearch->SearchOperator = @$filter["z_duedate"];
        $this->duedate->AdvancedSearch->SearchCondition = @$filter["v_duedate"];
        $this->duedate->AdvancedSearch->SearchValue2 = @$filter["y_duedate"];
        $this->duedate->AdvancedSearch->SearchOperator2 = @$filter["w_duedate"];
        $this->duedate->AdvancedSearch->save();

        // Field contactcode
        $this->contactcode->AdvancedSearch->SearchValue = @$filter["x_contactcode"];
        $this->contactcode->AdvancedSearch->SearchOperator = @$filter["z_contactcode"];
        $this->contactcode->AdvancedSearch->SearchCondition = @$filter["v_contactcode"];
        $this->contactcode->AdvancedSearch->SearchValue2 = @$filter["y_contactcode"];
        $this->contactcode->AdvancedSearch->SearchOperator2 = @$filter["w_contactcode"];
        $this->contactcode->AdvancedSearch->save();

        // Field tag
        $this->tag->AdvancedSearch->SearchValue = @$filter["x_tag"];
        $this->tag->AdvancedSearch->SearchOperator = @$filter["z_tag"];
        $this->tag->AdvancedSearch->SearchCondition = @$filter["v_tag"];
        $this->tag->AdvancedSearch->SearchValue2 = @$filter["y_tag"];
        $this->tag->AdvancedSearch->SearchOperator2 = @$filter["w_tag"];
        $this->tag->AdvancedSearch->save();

        // Field istaxinvoice
        $this->istaxinvoice->AdvancedSearch->SearchValue = @$filter["x_istaxinvoice"];
        $this->istaxinvoice->AdvancedSearch->SearchOperator = @$filter["z_istaxinvoice"];
        $this->istaxinvoice->AdvancedSearch->SearchCondition = @$filter["v_istaxinvoice"];
        $this->istaxinvoice->AdvancedSearch->SearchValue2 = @$filter["y_istaxinvoice"];
        $this->istaxinvoice->AdvancedSearch->SearchOperator2 = @$filter["w_istaxinvoice"];
        $this->istaxinvoice->AdvancedSearch->save();

        // Field taxstatus
        $this->taxstatus->AdvancedSearch->SearchValue = @$filter["x_taxstatus"];
        $this->taxstatus->AdvancedSearch->SearchOperator = @$filter["z_taxstatus"];
        $this->taxstatus->AdvancedSearch->SearchCondition = @$filter["v_taxstatus"];
        $this->taxstatus->AdvancedSearch->SearchValue2 = @$filter["y_taxstatus"];
        $this->taxstatus->AdvancedSearch->SearchOperator2 = @$filter["w_taxstatus"];
        $this->taxstatus->AdvancedSearch->save();

        // Field paymentdate
        $this->paymentdate->AdvancedSearch->SearchValue = @$filter["x_paymentdate"];
        $this->paymentdate->AdvancedSearch->SearchOperator = @$filter["z_paymentdate"];
        $this->paymentdate->AdvancedSearch->SearchCondition = @$filter["v_paymentdate"];
        $this->paymentdate->AdvancedSearch->SearchValue2 = @$filter["y_paymentdate"];
        $this->paymentdate->AdvancedSearch->SearchOperator2 = @$filter["w_paymentdate"];
        $this->paymentdate->AdvancedSearch->save();

        // Field paymentmethodid
        $this->paymentmethodid->AdvancedSearch->SearchValue = @$filter["x_paymentmethodid"];
        $this->paymentmethodid->AdvancedSearch->SearchOperator = @$filter["z_paymentmethodid"];
        $this->paymentmethodid->AdvancedSearch->SearchCondition = @$filter["v_paymentmethodid"];
        $this->paymentmethodid->AdvancedSearch->SearchValue2 = @$filter["y_paymentmethodid"];
        $this->paymentmethodid->AdvancedSearch->SearchOperator2 = @$filter["w_paymentmethodid"];
        $this->paymentmethodid->AdvancedSearch->save();

        // Field paymentMethodCode
        $this->paymentMethodCode->AdvancedSearch->SearchValue = @$filter["x_paymentMethodCode"];
        $this->paymentMethodCode->AdvancedSearch->SearchOperator = @$filter["z_paymentMethodCode"];
        $this->paymentMethodCode->AdvancedSearch->SearchCondition = @$filter["v_paymentMethodCode"];
        $this->paymentMethodCode->AdvancedSearch->SearchValue2 = @$filter["y_paymentMethodCode"];
        $this->paymentMethodCode->AdvancedSearch->SearchOperator2 = @$filter["w_paymentMethodCode"];
        $this->paymentMethodCode->AdvancedSearch->save();

        // Field amount
        $this->amount->AdvancedSearch->SearchValue = @$filter["x_amount"];
        $this->amount->AdvancedSearch->SearchOperator = @$filter["z_amount"];
        $this->amount->AdvancedSearch->SearchCondition = @$filter["v_amount"];
        $this->amount->AdvancedSearch->SearchValue2 = @$filter["y_amount"];
        $this->amount->AdvancedSearch->SearchOperator2 = @$filter["w_amount"];
        $this->amount->AdvancedSearch->save();

        // Field remark
        $this->remark->AdvancedSearch->SearchValue = @$filter["x_remark"];
        $this->remark->AdvancedSearch->SearchOperator = @$filter["z_remark"];
        $this->remark->AdvancedSearch->SearchCondition = @$filter["v_remark"];
        $this->remark->AdvancedSearch->SearchValue2 = @$filter["y_remark"];
        $this->remark->AdvancedSearch->SearchOperator2 = @$filter["w_remark"];
        $this->remark->AdvancedSearch->save();

        // Field receipt_id
        $this->receipt_id->AdvancedSearch->SearchValue = @$filter["x_receipt_id"];
        $this->receipt_id->AdvancedSearch->SearchOperator = @$filter["z_receipt_id"];
        $this->receipt_id->AdvancedSearch->SearchCondition = @$filter["v_receipt_id"];
        $this->receipt_id->AdvancedSearch->SearchValue2 = @$filter["y_receipt_id"];
        $this->receipt_id->AdvancedSearch->SearchOperator2 = @$filter["w_receipt_id"];
        $this->receipt_id->AdvancedSearch->save();

        // Field receipt_code
        $this->receipt_code->AdvancedSearch->SearchValue = @$filter["x_receipt_code"];
        $this->receipt_code->AdvancedSearch->SearchOperator = @$filter["z_receipt_code"];
        $this->receipt_code->AdvancedSearch->SearchCondition = @$filter["v_receipt_code"];
        $this->receipt_code->AdvancedSearch->SearchValue2 = @$filter["y_receipt_code"];
        $this->receipt_code->AdvancedSearch->SearchOperator2 = @$filter["w_receipt_code"];
        $this->receipt_code->AdvancedSearch->save();

        // Field receipt_status
        $this->receipt_status->AdvancedSearch->SearchValue = @$filter["x_receipt_status"];
        $this->receipt_status->AdvancedSearch->SearchOperator = @$filter["z_receipt_status"];
        $this->receipt_status->AdvancedSearch->SearchCondition = @$filter["v_receipt_status"];
        $this->receipt_status->AdvancedSearch->SearchValue2 = @$filter["y_receipt_status"];
        $this->receipt_status->AdvancedSearch->SearchOperator2 = @$filter["w_receipt_status"];
        $this->receipt_status->AdvancedSearch->save();

        // Field preTaxAmount
        $this->preTaxAmount->AdvancedSearch->SearchValue = @$filter["x_preTaxAmount"];
        $this->preTaxAmount->AdvancedSearch->SearchOperator = @$filter["z_preTaxAmount"];
        $this->preTaxAmount->AdvancedSearch->SearchCondition = @$filter["v_preTaxAmount"];
        $this->preTaxAmount->AdvancedSearch->SearchValue2 = @$filter["y_preTaxAmount"];
        $this->preTaxAmount->AdvancedSearch->SearchOperator2 = @$filter["w_preTaxAmount"];
        $this->preTaxAmount->AdvancedSearch->save();

        // Field vatAmount
        $this->vatAmount->AdvancedSearch->SearchValue = @$filter["x_vatAmount"];
        $this->vatAmount->AdvancedSearch->SearchOperator = @$filter["z_vatAmount"];
        $this->vatAmount->AdvancedSearch->SearchCondition = @$filter["v_vatAmount"];
        $this->vatAmount->AdvancedSearch->SearchValue2 = @$filter["y_vatAmount"];
        $this->vatAmount->AdvancedSearch->SearchOperator2 = @$filter["w_vatAmount"];
        $this->vatAmount->AdvancedSearch->save();

        // Field netAmount
        $this->netAmount->AdvancedSearch->SearchValue = @$filter["x_netAmount"];
        $this->netAmount->AdvancedSearch->SearchOperator = @$filter["z_netAmount"];
        $this->netAmount->AdvancedSearch->SearchCondition = @$filter["v_netAmount"];
        $this->netAmount->AdvancedSearch->SearchValue2 = @$filter["y_netAmount"];
        $this->netAmount->AdvancedSearch->SearchOperator2 = @$filter["w_netAmount"];
        $this->netAmount->AdvancedSearch->save();

        // Field whtAmount
        $this->whtAmount->AdvancedSearch->SearchValue = @$filter["x_whtAmount"];
        $this->whtAmount->AdvancedSearch->SearchOperator = @$filter["z_whtAmount"];
        $this->whtAmount->AdvancedSearch->SearchCondition = @$filter["v_whtAmount"];
        $this->whtAmount->AdvancedSearch->SearchValue2 = @$filter["y_whtAmount"];
        $this->whtAmount->AdvancedSearch->SearchOperator2 = @$filter["w_whtAmount"];
        $this->whtAmount->AdvancedSearch->save();

        // Field paymentAmount
        $this->paymentAmount->AdvancedSearch->SearchValue = @$filter["x_paymentAmount"];
        $this->paymentAmount->AdvancedSearch->SearchOperator = @$filter["z_paymentAmount"];
        $this->paymentAmount->AdvancedSearch->SearchCondition = @$filter["v_paymentAmount"];
        $this->paymentAmount->AdvancedSearch->SearchValue2 = @$filter["y_paymentAmount"];
        $this->paymentAmount->AdvancedSearch->SearchOperator2 = @$filter["w_paymentAmount"];
        $this->paymentAmount->AdvancedSearch->save();

        // Field remainAmount
        $this->remainAmount->AdvancedSearch->SearchValue = @$filter["x_remainAmount"];
        $this->remainAmount->AdvancedSearch->SearchOperator = @$filter["z_remainAmount"];
        $this->remainAmount->AdvancedSearch->SearchCondition = @$filter["v_remainAmount"];
        $this->remainAmount->AdvancedSearch->SearchValue2 = @$filter["y_remainAmount"];
        $this->remainAmount->AdvancedSearch->SearchOperator2 = @$filter["w_remainAmount"];
        $this->remainAmount->AdvancedSearch->save();

        // Field remainWhtAmount
        $this->remainWhtAmount->AdvancedSearch->SearchValue = @$filter["x_remainWhtAmount"];
        $this->remainWhtAmount->AdvancedSearch->SearchOperator = @$filter["z_remainWhtAmount"];
        $this->remainWhtAmount->AdvancedSearch->SearchCondition = @$filter["v_remainWhtAmount"];
        $this->remainWhtAmount->AdvancedSearch->SearchValue2 = @$filter["y_remainWhtAmount"];
        $this->remainWhtAmount->AdvancedSearch->SearchOperator2 = @$filter["w_remainWhtAmount"];
        $this->remainWhtAmount->AdvancedSearch->save();

        // Field onlineViewLink
        $this->onlineViewLink->AdvancedSearch->SearchValue = @$filter["x_onlineViewLink"];
        $this->onlineViewLink->AdvancedSearch->SearchOperator = @$filter["z_onlineViewLink"];
        $this->onlineViewLink->AdvancedSearch->SearchCondition = @$filter["v_onlineViewLink"];
        $this->onlineViewLink->AdvancedSearch->SearchValue2 = @$filter["y_onlineViewLink"];
        $this->onlineViewLink->AdvancedSearch->SearchOperator2 = @$filter["w_onlineViewLink"];
        $this->onlineViewLink->AdvancedSearch->save();

        // Field isPartialReceipt
        $this->isPartialReceipt->AdvancedSearch->SearchValue = @$filter["x_isPartialReceipt"];
        $this->isPartialReceipt->AdvancedSearch->SearchOperator = @$filter["z_isPartialReceipt"];
        $this->isPartialReceipt->AdvancedSearch->SearchCondition = @$filter["v_isPartialReceipt"];
        $this->isPartialReceipt->AdvancedSearch->SearchValue2 = @$filter["y_isPartialReceipt"];
        $this->isPartialReceipt->AdvancedSearch->SearchOperator2 = @$filter["w_isPartialReceipt"];
        $this->isPartialReceipt->AdvancedSearch->save();

        // Field journals_id
        $this->journals_id->AdvancedSearch->SearchValue = @$filter["x_journals_id"];
        $this->journals_id->AdvancedSearch->SearchOperator = @$filter["z_journals_id"];
        $this->journals_id->AdvancedSearch->SearchCondition = @$filter["v_journals_id"];
        $this->journals_id->AdvancedSearch->SearchValue2 = @$filter["y_journals_id"];
        $this->journals_id->AdvancedSearch->SearchOperator2 = @$filter["w_journals_id"];
        $this->journals_id->AdvancedSearch->save();

        // Field journals_code
        $this->journals_code->AdvancedSearch->SearchValue = @$filter["x_journals_code"];
        $this->journals_code->AdvancedSearch->SearchOperator = @$filter["z_journals_code"];
        $this->journals_code->AdvancedSearch->SearchCondition = @$filter["v_journals_code"];
        $this->journals_code->AdvancedSearch->SearchValue2 = @$filter["y_journals_code"];
        $this->journals_code->AdvancedSearch->SearchOperator2 = @$filter["w_journals_code"];
        $this->journals_code->AdvancedSearch->save();

        // Field refid
        $this->refid->AdvancedSearch->SearchValue = @$filter["x_refid"];
        $this->refid->AdvancedSearch->SearchOperator = @$filter["z_refid"];
        $this->refid->AdvancedSearch->SearchCondition = @$filter["v_refid"];
        $this->refid->AdvancedSearch->SearchValue2 = @$filter["y_refid"];
        $this->refid->AdvancedSearch->SearchOperator2 = @$filter["w_refid"];
        $this->refid->AdvancedSearch->save();

        // Field transition_type
        $this->transition_type->AdvancedSearch->SearchValue = @$filter["x_transition_type"];
        $this->transition_type->AdvancedSearch->SearchOperator = @$filter["z_transition_type"];
        $this->transition_type->AdvancedSearch->SearchCondition = @$filter["v_transition_type"];
        $this->transition_type->AdvancedSearch->SearchValue2 = @$filter["y_transition_type"];
        $this->transition_type->AdvancedSearch->SearchOperator2 = @$filter["w_transition_type"];
        $this->transition_type->AdvancedSearch->save();

        // Field is_email
        $this->is_email->AdvancedSearch->SearchValue = @$filter["x_is_email"];
        $this->is_email->AdvancedSearch->SearchOperator = @$filter["z_is_email"];
        $this->is_email->AdvancedSearch->SearchCondition = @$filter["v_is_email"];
        $this->is_email->AdvancedSearch->SearchValue2 = @$filter["y_is_email"];
        $this->is_email->AdvancedSearch->SearchOperator2 = @$filter["w_is_email"];
        $this->is_email->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
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
        $searchFlds[] = &$this->request_message;
        $searchFlds[] = &$this->contactcode;
        $searchFlds[] = &$this->tag;
        $searchFlds[] = &$this->paymentmethodid;
        $searchFlds[] = &$this->paymentMethodCode;
        $searchFlds[] = &$this->remark;
        $searchFlds[] = &$this->receipt_id;
        $searchFlds[] = &$this->receipt_code;
        $searchFlds[] = &$this->receipt_status;
        $searchFlds[] = &$this->onlineViewLink;
        $searchFlds[] = &$this->journals_id;
        $searchFlds[] = &$this->journals_code;
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

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();
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
            $this->updateSort($this->id, $ctrl); // id
            $this->updateSort($this->create_date, $ctrl); // create_date
            $this->updateSort($this->request_status, $ctrl); // request_status
            $this->updateSort($this->request_date, $ctrl); // request_date
            $this->updateSort($this->issueddate, $ctrl); // issueddate
            $this->updateSort($this->duedate, $ctrl); // duedate
            $this->updateSort($this->contactcode, $ctrl); // contactcode
            $this->updateSort($this->istaxinvoice, $ctrl); // istaxinvoice
            $this->updateSort($this->taxstatus, $ctrl); // taxstatus
            $this->updateSort($this->paymentdate, $ctrl); // paymentdate
            $this->updateSort($this->paymentmethodid, $ctrl); // paymentmethodid
            $this->updateSort($this->paymentMethodCode, $ctrl); // paymentMethodCode
            $this->updateSort($this->amount, $ctrl); // amount
            $this->updateSort($this->remark, $ctrl); // remark
            $this->updateSort($this->receipt_id, $ctrl); // receipt_id
            $this->updateSort($this->receipt_code, $ctrl); // receipt_code
            $this->updateSort($this->receipt_status, $ctrl); // receipt_status
            $this->updateSort($this->preTaxAmount, $ctrl); // preTaxAmount
            $this->updateSort($this->vatAmount, $ctrl); // vatAmount
            $this->updateSort($this->netAmount, $ctrl); // netAmount
            $this->updateSort($this->whtAmount, $ctrl); // whtAmount
            $this->updateSort($this->paymentAmount, $ctrl); // paymentAmount
            $this->updateSort($this->remainAmount, $ctrl); // remainAmount
            $this->updateSort($this->remainWhtAmount, $ctrl); // remainWhtAmount
            $this->updateSort($this->isPartialReceipt, $ctrl); // isPartialReceipt
            $this->updateSort($this->journals_id, $ctrl); // journals_id
            $this->updateSort($this->journals_code, $ctrl); // journals_code
            $this->updateSort($this->refid, $ctrl); // refid
            $this->updateSort($this->transition_type, $ctrl); // transition_type
            $this->updateSort($this->is_email, $ctrl); // is_email
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
                $this->id->setSort("");
                $this->create_date->setSort("");
                $this->request_status->setSort("");
                $this->request_date->setSort("");
                $this->request_message->setSort("");
                $this->issueddate->setSort("");
                $this->duedate->setSort("");
                $this->contactcode->setSort("");
                $this->tag->setSort("");
                $this->istaxinvoice->setSort("");
                $this->taxstatus->setSort("");
                $this->paymentdate->setSort("");
                $this->paymentmethodid->setSort("");
                $this->paymentMethodCode->setSort("");
                $this->amount->setSort("");
                $this->remark->setSort("");
                $this->receipt_id->setSort("");
                $this->receipt_code->setSort("");
                $this->receipt_status->setSort("");
                $this->preTaxAmount->setSort("");
                $this->vatAmount->setSort("");
                $this->netAmount->setSort("");
                $this->whtAmount->setSort("");
                $this->paymentAmount->setSort("");
                $this->remainAmount->setSort("");
                $this->remainWhtAmount->setSort("");
                $this->onlineViewLink->setSort("");
                $this->isPartialReceipt->setSort("");
                $this->journals_id->setSort("");
                $this->journals_code->setSort("");
                $this->refid->setSort("");
                $this->transition_type->setSort("");
                $this->is_email->setSort("");
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

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canAdd();
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

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if ($Security->canAdd()) {
                $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
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
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fpeak_receiptlist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button></li>";
                    if ($link != "") {
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fpeak_receiptlist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button>";
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
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->id->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
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
            $option->add("id", $this->createColumnOption("id"));
            $option->add("create_date", $this->createColumnOption("create_date"));
            $option->add("request_status", $this->createColumnOption("request_status"));
            $option->add("request_date", $this->createColumnOption("request_date"));
            $option->add("issueddate", $this->createColumnOption("issueddate"));
            $option->add("duedate", $this->createColumnOption("duedate"));
            $option->add("contactcode", $this->createColumnOption("contactcode"));
            $option->add("istaxinvoice", $this->createColumnOption("istaxinvoice"));
            $option->add("taxstatus", $this->createColumnOption("taxstatus"));
            $option->add("paymentdate", $this->createColumnOption("paymentdate"));
            $option->add("paymentmethodid", $this->createColumnOption("paymentmethodid"));
            $option->add("paymentMethodCode", $this->createColumnOption("paymentMethodCode"));
            $option->add("amount", $this->createColumnOption("amount"));
            $option->add("remark", $this->createColumnOption("remark"));
            $option->add("receipt_id", $this->createColumnOption("receipt_id"));
            $option->add("receipt_code", $this->createColumnOption("receipt_code"));
            $option->add("receipt_status", $this->createColumnOption("receipt_status"));
            $option->add("preTaxAmount", $this->createColumnOption("preTaxAmount"));
            $option->add("vatAmount", $this->createColumnOption("vatAmount"));
            $option->add("netAmount", $this->createColumnOption("netAmount"));
            $option->add("whtAmount", $this->createColumnOption("whtAmount"));
            $option->add("paymentAmount", $this->createColumnOption("paymentAmount"));
            $option->add("remainAmount", $this->createColumnOption("remainAmount"));
            $option->add("remainWhtAmount", $this->createColumnOption("remainWhtAmount"));
            $option->add("isPartialReceipt", $this->createColumnOption("isPartialReceipt"));
            $option->add("journals_id", $this->createColumnOption("journals_id"));
            $option->add("journals_code", $this->createColumnOption("journals_code"));
            $option->add("refid", $this->createColumnOption("refid"));
            $option->add("transition_type", $this->createColumnOption("transition_type"));
            $option->add("is_email", $this->createColumnOption("is_email"));
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fpeak_receiptsrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fpeak_receiptsrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fpeak_receiptlist"' . $listaction->toDataAttrs() . '>' . $icon . '</button>';
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
        $this->id->setDbValue($row['id']);
        $this->create_date->setDbValue($row['create_date']);
        $this->request_status->setDbValue($row['request_status']);
        $this->request_date->setDbValue($row['request_date']);
        $this->request_message->setDbValue($row['request_message']);
        $this->issueddate->setDbValue($row['issueddate']);
        $this->duedate->setDbValue($row['duedate']);
        $this->contactcode->setDbValue($row['contactcode']);
        $this->tag->setDbValue($row['tag']);
        $this->istaxinvoice->setDbValue($row['istaxinvoice']);
        $this->taxstatus->setDbValue($row['taxstatus']);
        $this->paymentdate->setDbValue($row['paymentdate']);
        $this->paymentmethodid->setDbValue($row['paymentmethodid']);
        $this->paymentMethodCode->setDbValue($row['paymentMethodCode']);
        $this->amount->setDbValue($row['amount']);
        $this->remark->setDbValue($row['remark']);
        $this->receipt_id->setDbValue($row['receipt_id']);
        $this->receipt_code->setDbValue($row['receipt_code']);
        $this->receipt_status->setDbValue($row['receipt_status']);
        $this->preTaxAmount->setDbValue($row['preTaxAmount']);
        $this->vatAmount->setDbValue($row['vatAmount']);
        $this->netAmount->setDbValue($row['netAmount']);
        $this->whtAmount->setDbValue($row['whtAmount']);
        $this->paymentAmount->setDbValue($row['paymentAmount']);
        $this->remainAmount->setDbValue($row['remainAmount']);
        $this->remainWhtAmount->setDbValue($row['remainWhtAmount']);
        $this->onlineViewLink->setDbValue($row['onlineViewLink']);
        $this->isPartialReceipt->setDbValue($row['isPartialReceipt']);
        $this->journals_id->setDbValue($row['journals_id']);
        $this->journals_code->setDbValue($row['journals_code']);
        $this->refid->setDbValue($row['refid']);
        $this->transition_type->setDbValue($row['transition_type']);
        $this->is_email->setDbValue($row['is_email']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['create_date'] = null;
        $row['request_status'] = null;
        $row['request_date'] = null;
        $row['request_message'] = null;
        $row['issueddate'] = null;
        $row['duedate'] = null;
        $row['contactcode'] = null;
        $row['tag'] = null;
        $row['istaxinvoice'] = null;
        $row['taxstatus'] = null;
        $row['paymentdate'] = null;
        $row['paymentmethodid'] = null;
        $row['paymentMethodCode'] = null;
        $row['amount'] = null;
        $row['remark'] = null;
        $row['receipt_id'] = null;
        $row['receipt_code'] = null;
        $row['receipt_status'] = null;
        $row['preTaxAmount'] = null;
        $row['vatAmount'] = null;
        $row['netAmount'] = null;
        $row['whtAmount'] = null;
        $row['paymentAmount'] = null;
        $row['remainAmount'] = null;
        $row['remainWhtAmount'] = null;
        $row['onlineViewLink'] = null;
        $row['isPartialReceipt'] = null;
        $row['journals_id'] = null;
        $row['journals_code'] = null;
        $row['refid'] = null;
        $row['transition_type'] = null;
        $row['is_email'] = null;
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

        // id

        // create_date

        // request_status

        // request_date

        // request_message

        // issueddate

        // duedate

        // contactcode

        // tag

        // istaxinvoice

        // taxstatus

        // paymentdate

        // paymentmethodid

        // paymentMethodCode

        // amount

        // remark

        // receipt_id

        // receipt_code

        // receipt_status

        // preTaxAmount

        // vatAmount

        // netAmount

        // whtAmount

        // paymentAmount

        // remainAmount

        // remainWhtAmount

        // onlineViewLink

        // isPartialReceipt

        // journals_id

        // journals_code

        // refid

        // transition_type

        // is_email

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // create_date
            $this->create_date->ViewValue = $this->create_date->CurrentValue;
            $this->create_date->ViewValue = FormatDateTime($this->create_date->ViewValue, $this->create_date->formatPattern());
            $this->create_date->ViewCustomAttributes = "";

            // request_status
            $this->request_status->ViewValue = $this->request_status->CurrentValue;
            $this->request_status->ViewValue = FormatNumber($this->request_status->ViewValue, $this->request_status->formatPattern());
            $this->request_status->ViewCustomAttributes = "";

            // request_date
            $this->request_date->ViewValue = $this->request_date->CurrentValue;
            $this->request_date->ViewValue = FormatDateTime($this->request_date->ViewValue, $this->request_date->formatPattern());
            $this->request_date->ViewCustomAttributes = "";

            // issueddate
            $this->issueddate->ViewValue = $this->issueddate->CurrentValue;
            $this->issueddate->ViewValue = FormatDateTime($this->issueddate->ViewValue, $this->issueddate->formatPattern());
            $this->issueddate->ViewCustomAttributes = "";

            // duedate
            $this->duedate->ViewValue = $this->duedate->CurrentValue;
            $this->duedate->ViewValue = FormatDateTime($this->duedate->ViewValue, $this->duedate->formatPattern());
            $this->duedate->ViewCustomAttributes = "";

            // contactcode
            $this->contactcode->ViewValue = $this->contactcode->CurrentValue;
            $this->contactcode->ViewCustomAttributes = "";

            // istaxinvoice
            $this->istaxinvoice->ViewValue = $this->istaxinvoice->CurrentValue;
            $this->istaxinvoice->ViewValue = FormatNumber($this->istaxinvoice->ViewValue, $this->istaxinvoice->formatPattern());
            $this->istaxinvoice->ViewCustomAttributes = "";

            // taxstatus
            $this->taxstatus->ViewValue = $this->taxstatus->CurrentValue;
            $this->taxstatus->ViewValue = FormatNumber($this->taxstatus->ViewValue, $this->taxstatus->formatPattern());
            $this->taxstatus->ViewCustomAttributes = "";

            // paymentdate
            $this->paymentdate->ViewValue = $this->paymentdate->CurrentValue;
            $this->paymentdate->ViewValue = FormatDateTime($this->paymentdate->ViewValue, $this->paymentdate->formatPattern());
            $this->paymentdate->ViewCustomAttributes = "";

            // paymentmethodid
            $this->paymentmethodid->ViewValue = $this->paymentmethodid->CurrentValue;
            $this->paymentmethodid->ViewCustomAttributes = "";

            // paymentMethodCode
            $this->paymentMethodCode->ViewValue = $this->paymentMethodCode->CurrentValue;
            $this->paymentMethodCode->ViewCustomAttributes = "";

            // amount
            $this->amount->ViewValue = $this->amount->CurrentValue;
            $this->amount->ViewValue = FormatNumber($this->amount->ViewValue, $this->amount->formatPattern());
            $this->amount->ViewCustomAttributes = "";

            // remark
            $this->remark->ViewValue = $this->remark->CurrentValue;
            $this->remark->ViewCustomAttributes = "";

            // receipt_id
            $this->receipt_id->ViewValue = $this->receipt_id->CurrentValue;
            $this->receipt_id->ViewCustomAttributes = "";

            // receipt_code
            $this->receipt_code->ViewValue = $this->receipt_code->CurrentValue;
            $this->receipt_code->ViewCustomAttributes = "";

            // receipt_status
            $this->receipt_status->ViewValue = $this->receipt_status->CurrentValue;
            $this->receipt_status->ViewCustomAttributes = "";

            // preTaxAmount
            $this->preTaxAmount->ViewValue = $this->preTaxAmount->CurrentValue;
            $this->preTaxAmount->ViewValue = FormatNumber($this->preTaxAmount->ViewValue, $this->preTaxAmount->formatPattern());
            $this->preTaxAmount->ViewCustomAttributes = "";

            // vatAmount
            $this->vatAmount->ViewValue = $this->vatAmount->CurrentValue;
            $this->vatAmount->ViewValue = FormatNumber($this->vatAmount->ViewValue, $this->vatAmount->formatPattern());
            $this->vatAmount->ViewCustomAttributes = "";

            // netAmount
            $this->netAmount->ViewValue = $this->netAmount->CurrentValue;
            $this->netAmount->ViewValue = FormatNumber($this->netAmount->ViewValue, $this->netAmount->formatPattern());
            $this->netAmount->ViewCustomAttributes = "";

            // whtAmount
            $this->whtAmount->ViewValue = $this->whtAmount->CurrentValue;
            $this->whtAmount->ViewValue = FormatNumber($this->whtAmount->ViewValue, $this->whtAmount->formatPattern());
            $this->whtAmount->ViewCustomAttributes = "";

            // paymentAmount
            $this->paymentAmount->ViewValue = $this->paymentAmount->CurrentValue;
            $this->paymentAmount->ViewValue = FormatNumber($this->paymentAmount->ViewValue, $this->paymentAmount->formatPattern());
            $this->paymentAmount->ViewCustomAttributes = "";

            // remainAmount
            $this->remainAmount->ViewValue = $this->remainAmount->CurrentValue;
            $this->remainAmount->ViewValue = FormatNumber($this->remainAmount->ViewValue, $this->remainAmount->formatPattern());
            $this->remainAmount->ViewCustomAttributes = "";

            // remainWhtAmount
            $this->remainWhtAmount->ViewValue = $this->remainWhtAmount->CurrentValue;
            $this->remainWhtAmount->ViewValue = FormatNumber($this->remainWhtAmount->ViewValue, $this->remainWhtAmount->formatPattern());
            $this->remainWhtAmount->ViewCustomAttributes = "";

            // isPartialReceipt
            $this->isPartialReceipt->ViewValue = $this->isPartialReceipt->CurrentValue;
            $this->isPartialReceipt->ViewValue = FormatNumber($this->isPartialReceipt->ViewValue, $this->isPartialReceipt->formatPattern());
            $this->isPartialReceipt->ViewCustomAttributes = "";

            // journals_id
            $this->journals_id->ViewValue = $this->journals_id->CurrentValue;
            $this->journals_id->ViewCustomAttributes = "";

            // journals_code
            $this->journals_code->ViewValue = $this->journals_code->CurrentValue;
            $this->journals_code->ViewCustomAttributes = "";

            // refid
            $this->refid->ViewValue = $this->refid->CurrentValue;
            $this->refid->ViewValue = FormatNumber($this->refid->ViewValue, $this->refid->formatPattern());
            $this->refid->ViewCustomAttributes = "";

            // transition_type
            $this->transition_type->ViewValue = $this->transition_type->CurrentValue;
            $this->transition_type->ViewValue = FormatNumber($this->transition_type->ViewValue, $this->transition_type->formatPattern());
            $this->transition_type->ViewCustomAttributes = "";

            // is_email
            $this->is_email->ViewValue = $this->is_email->CurrentValue;
            $this->is_email->ViewValue = FormatNumber($this->is_email->ViewValue, $this->is_email->formatPattern());
            $this->is_email->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // create_date
            $this->create_date->LinkCustomAttributes = "";
            $this->create_date->HrefValue = "";
            $this->create_date->TooltipValue = "";

            // request_status
            $this->request_status->LinkCustomAttributes = "";
            $this->request_status->HrefValue = "";
            $this->request_status->TooltipValue = "";

            // request_date
            $this->request_date->LinkCustomAttributes = "";
            $this->request_date->HrefValue = "";
            $this->request_date->TooltipValue = "";

            // issueddate
            $this->issueddate->LinkCustomAttributes = "";
            $this->issueddate->HrefValue = "";
            $this->issueddate->TooltipValue = "";

            // duedate
            $this->duedate->LinkCustomAttributes = "";
            $this->duedate->HrefValue = "";
            $this->duedate->TooltipValue = "";

            // contactcode
            $this->contactcode->LinkCustomAttributes = "";
            $this->contactcode->HrefValue = "";
            $this->contactcode->TooltipValue = "";

            // istaxinvoice
            $this->istaxinvoice->LinkCustomAttributes = "";
            $this->istaxinvoice->HrefValue = "";
            $this->istaxinvoice->TooltipValue = "";

            // taxstatus
            $this->taxstatus->LinkCustomAttributes = "";
            $this->taxstatus->HrefValue = "";
            $this->taxstatus->TooltipValue = "";

            // paymentdate
            $this->paymentdate->LinkCustomAttributes = "";
            $this->paymentdate->HrefValue = "";
            $this->paymentdate->TooltipValue = "";

            // paymentmethodid
            $this->paymentmethodid->LinkCustomAttributes = "";
            $this->paymentmethodid->HrefValue = "";
            $this->paymentmethodid->TooltipValue = "";

            // paymentMethodCode
            $this->paymentMethodCode->LinkCustomAttributes = "";
            $this->paymentMethodCode->HrefValue = "";
            $this->paymentMethodCode->TooltipValue = "";

            // amount
            $this->amount->LinkCustomAttributes = "";
            $this->amount->HrefValue = "";
            $this->amount->TooltipValue = "";

            // remark
            $this->remark->LinkCustomAttributes = "";
            $this->remark->HrefValue = "";
            $this->remark->TooltipValue = "";

            // receipt_id
            $this->receipt_id->LinkCustomAttributes = "";
            $this->receipt_id->HrefValue = "";
            $this->receipt_id->TooltipValue = "";

            // receipt_code
            $this->receipt_code->LinkCustomAttributes = "";
            $this->receipt_code->HrefValue = "";
            $this->receipt_code->TooltipValue = "";

            // receipt_status
            $this->receipt_status->LinkCustomAttributes = "";
            $this->receipt_status->HrefValue = "";
            $this->receipt_status->TooltipValue = "";

            // preTaxAmount
            $this->preTaxAmount->LinkCustomAttributes = "";
            $this->preTaxAmount->HrefValue = "";
            $this->preTaxAmount->TooltipValue = "";

            // vatAmount
            $this->vatAmount->LinkCustomAttributes = "";
            $this->vatAmount->HrefValue = "";
            $this->vatAmount->TooltipValue = "";

            // netAmount
            $this->netAmount->LinkCustomAttributes = "";
            $this->netAmount->HrefValue = "";
            $this->netAmount->TooltipValue = "";

            // whtAmount
            $this->whtAmount->LinkCustomAttributes = "";
            $this->whtAmount->HrefValue = "";
            $this->whtAmount->TooltipValue = "";

            // paymentAmount
            $this->paymentAmount->LinkCustomAttributes = "";
            $this->paymentAmount->HrefValue = "";
            $this->paymentAmount->TooltipValue = "";

            // remainAmount
            $this->remainAmount->LinkCustomAttributes = "";
            $this->remainAmount->HrefValue = "";
            $this->remainAmount->TooltipValue = "";

            // remainWhtAmount
            $this->remainWhtAmount->LinkCustomAttributes = "";
            $this->remainWhtAmount->HrefValue = "";
            $this->remainWhtAmount->TooltipValue = "";

            // isPartialReceipt
            $this->isPartialReceipt->LinkCustomAttributes = "";
            $this->isPartialReceipt->HrefValue = "";
            $this->isPartialReceipt->TooltipValue = "";

            // journals_id
            $this->journals_id->LinkCustomAttributes = "";
            $this->journals_id->HrefValue = "";
            $this->journals_id->TooltipValue = "";

            // journals_code
            $this->journals_code->LinkCustomAttributes = "";
            $this->journals_code->HrefValue = "";
            $this->journals_code->TooltipValue = "";

            // refid
            $this->refid->LinkCustomAttributes = "";
            $this->refid->HrefValue = "";
            $this->refid->TooltipValue = "";

            // transition_type
            $this->transition_type->LinkCustomAttributes = "";
            $this->transition_type->HrefValue = "";
            $this->transition_type->TooltipValue = "";

            // is_email
            $this->is_email->LinkCustomAttributes = "";
            $this->is_email->HrefValue = "";
            $this->is_email->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" form=\"fpeak_receiptlist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" form=\"fpeak_receiptlist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" form=\"fpeak_receiptlist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" form="fpeak_receiptlist" data-ew-action="email" data-hdr="' . $Language->phrase("ExportToEmailText") . '" data-sel="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fpeak_receiptsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
