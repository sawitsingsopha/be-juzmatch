<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class BuyerAllAssetRentGrid extends BuyerAllAssetRent
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'buyer_all_asset_rent';

    // Page object name
    public $PageObjName = "BuyerAllAssetRentGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fbuyer_all_asset_rentgrid";
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

        // Table object (buyer_all_asset_rent)
        if (!isset($GLOBALS["buyer_all_asset_rent"]) || get_class($GLOBALS["buyer_all_asset_rent"]) == PROJECT_NAMESPACE . "buyer_all_asset_rent") {
            $GLOBALS["buyer_all_asset_rent"] = &$this;
        }
        $this->AddUrl = "buyerallassetrentadd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'buyer_all_asset_rent');
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
                $tbl = Container("buyer_all_asset_rent");
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
            $key .= @$ar['buyer_asset_rent_id'];
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
            $this->buyer_asset_rent_id->Visible = false;
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
        $this->buyer_asset_rent_id->Visible = false;
        $this->asset_id->setVisibility();
        $this->member_id->setVisibility();
        $this->one_time_status->setVisibility();
        $this->half_price_1->setVisibility();
        $this->pay_number_half_price_1->Visible = false;
        $this->status_pay_half_price_1->setVisibility();
        $this->date_pay_half_price_1->Visible = false;
        $this->due_date_pay_half_price_1->setVisibility();
        $this->half_price_2->setVisibility();
        $this->pay_number_half_price_2->Visible = false;
        $this->status_pay_half_price_2->setVisibility();
        $this->date_pay_half_price_2->Visible = false;
        $this->due_date_pay_half_price_2->setVisibility();
        $this->cdate->Visible = false;
        $this->cip->Visible = false;
        $this->cuser->Visible = false;
        $this->uuser->Visible = false;
        $this->uip->Visible = false;
        $this->udate->Visible = false;
        $this->transaction_datetime1->Visible = false;
        $this->payment_scheme1->Visible = false;
        $this->transaction_ref1->Visible = false;
        $this->channel_response_desc1->Visible = false;
        $this->res_status1->Visible = false;
        $this->res_referenceNo1->Visible = false;
        $this->transaction_datetime2->Visible = false;
        $this->payment_scheme2->Visible = false;
        $this->transaction_ref2->Visible = false;
        $this->channel_response_desc2->Visible = false;
        $this->res_status2->Visible = false;
        $this->res_referenceNo2->Visible = false;
        $this->status_approve->Visible = false;
        $this->res_paidAgent1->Visible = false;
        $this->res_paidChannel1->Visible = false;
        $this->res_maskedPan1->Visible = false;
        $this->res_paidAgent2->Visible = false;
        $this->res_paidChannel2->Visible = false;
        $this->res_maskedPan2->Visible = false;
        $this->is_email1->Visible = false;
        $this->is_email2->Visible = false;
        $this->receipt_status1->Visible = false;
        $this->receipt_status2->Visible = false;
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
        $this->setupLookupOptions($this->asset_id);
        $this->setupLookupOptions($this->member_id);
        $this->setupLookupOptions($this->one_time_status);
        $this->setupLookupOptions($this->status_pay_half_price_1);
        $this->setupLookupOptions($this->status_pay_half_price_2);

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
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "buyer_all_booking_asset") {
            $masterTbl = Container("buyer_all_booking_asset");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = count($rsmaster) > 0;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("buyerallbookingassetlist"); // Return to master page
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
        $this->half_price_1->FormValue = ""; // Clear form value
        $this->half_price_2->FormValue = ""; // Clear form value
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
                    $key .= $this->buyer_asset_rent_id->CurrentValue;

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
        if ($CurrentForm->hasValue("x_asset_id") && $CurrentForm->hasValue("o_asset_id") && $this->asset_id->CurrentValue != $this->asset_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_member_id") && $CurrentForm->hasValue("o_member_id") && $this->member_id->CurrentValue != $this->member_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_one_time_status") && $CurrentForm->hasValue("o_one_time_status") && ConvertToBool($this->one_time_status->CurrentValue) != ConvertToBool($this->one_time_status->OldValue)) {
            return false;
        }
        if ($CurrentForm->hasValue("x_half_price_1") && $CurrentForm->hasValue("o_half_price_1") && $this->half_price_1->CurrentValue != $this->half_price_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_status_pay_half_price_1") && $CurrentForm->hasValue("o_status_pay_half_price_1") && $this->status_pay_half_price_1->CurrentValue != $this->status_pay_half_price_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_due_date_pay_half_price_1") && $CurrentForm->hasValue("o_due_date_pay_half_price_1") && $this->due_date_pay_half_price_1->CurrentValue != $this->due_date_pay_half_price_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_half_price_2") && $CurrentForm->hasValue("o_half_price_2") && $this->half_price_2->CurrentValue != $this->half_price_2->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_status_pay_half_price_2") && $CurrentForm->hasValue("o_status_pay_half_price_2") && $this->status_pay_half_price_2->CurrentValue != $this->status_pay_half_price_2->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_due_date_pay_half_price_2") && $CurrentForm->hasValue("o_due_date_pay_half_price_2") && $this->due_date_pay_half_price_2->CurrentValue != $this->due_date_pay_half_price_2->OldValue) {
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
        $this->asset_id->clearErrorMessage();
        $this->member_id->clearErrorMessage();
        $this->one_time_status->clearErrorMessage();
        $this->half_price_1->clearErrorMessage();
        $this->status_pay_half_price_1->clearErrorMessage();
        $this->due_date_pay_half_price_1->clearErrorMessage();
        $this->half_price_2->clearErrorMessage();
        $this->status_pay_half_price_2->clearErrorMessage();
        $this->due_date_pay_half_price_2->clearErrorMessage();
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
        $this->buyer_asset_rent_id->CurrentValue = null;
        $this->buyer_asset_rent_id->OldValue = $this->buyer_asset_rent_id->CurrentValue;
        $this->asset_id->CurrentValue = null;
        $this->asset_id->OldValue = $this->asset_id->CurrentValue;
        $this->member_id->CurrentValue = null;
        $this->member_id->OldValue = $this->member_id->CurrentValue;
        $this->one_time_status->CurrentValue = 0;
        $this->one_time_status->OldValue = $this->one_time_status->CurrentValue;
        $this->half_price_1->CurrentValue = null;
        $this->half_price_1->OldValue = $this->half_price_1->CurrentValue;
        $this->pay_number_half_price_1->CurrentValue = null;
        $this->pay_number_half_price_1->OldValue = $this->pay_number_half_price_1->CurrentValue;
        $this->status_pay_half_price_1->CurrentValue = 1;
        $this->status_pay_half_price_1->OldValue = $this->status_pay_half_price_1->CurrentValue;
        $this->date_pay_half_price_1->CurrentValue = null;
        $this->date_pay_half_price_1->OldValue = $this->date_pay_half_price_1->CurrentValue;
        $this->due_date_pay_half_price_1->CurrentValue = null;
        $this->due_date_pay_half_price_1->OldValue = $this->due_date_pay_half_price_1->CurrentValue;
        $this->half_price_2->CurrentValue = null;
        $this->half_price_2->OldValue = $this->half_price_2->CurrentValue;
        $this->pay_number_half_price_2->CurrentValue = null;
        $this->pay_number_half_price_2->OldValue = $this->pay_number_half_price_2->CurrentValue;
        $this->status_pay_half_price_2->CurrentValue = 1;
        $this->status_pay_half_price_2->OldValue = $this->status_pay_half_price_2->CurrentValue;
        $this->date_pay_half_price_2->CurrentValue = null;
        $this->date_pay_half_price_2->OldValue = $this->date_pay_half_price_2->CurrentValue;
        $this->due_date_pay_half_price_2->CurrentValue = null;
        $this->due_date_pay_half_price_2->OldValue = $this->due_date_pay_half_price_2->CurrentValue;
        $this->cdate->CurrentValue = null;
        $this->cdate->OldValue = $this->cdate->CurrentValue;
        $this->cip->CurrentValue = null;
        $this->cip->OldValue = $this->cip->CurrentValue;
        $this->cuser->CurrentValue = null;
        $this->cuser->OldValue = $this->cuser->CurrentValue;
        $this->uuser->CurrentValue = null;
        $this->uuser->OldValue = $this->uuser->CurrentValue;
        $this->uip->CurrentValue = null;
        $this->uip->OldValue = $this->uip->CurrentValue;
        $this->udate->CurrentValue = null;
        $this->udate->OldValue = $this->udate->CurrentValue;
        $this->transaction_datetime1->CurrentValue = null;
        $this->transaction_datetime1->OldValue = $this->transaction_datetime1->CurrentValue;
        $this->payment_scheme1->CurrentValue = null;
        $this->payment_scheme1->OldValue = $this->payment_scheme1->CurrentValue;
        $this->transaction_ref1->CurrentValue = null;
        $this->transaction_ref1->OldValue = $this->transaction_ref1->CurrentValue;
        $this->channel_response_desc1->CurrentValue = null;
        $this->channel_response_desc1->OldValue = $this->channel_response_desc1->CurrentValue;
        $this->res_status1->CurrentValue = null;
        $this->res_status1->OldValue = $this->res_status1->CurrentValue;
        $this->res_referenceNo1->CurrentValue = null;
        $this->res_referenceNo1->OldValue = $this->res_referenceNo1->CurrentValue;
        $this->transaction_datetime2->CurrentValue = null;
        $this->transaction_datetime2->OldValue = $this->transaction_datetime2->CurrentValue;
        $this->payment_scheme2->CurrentValue = null;
        $this->payment_scheme2->OldValue = $this->payment_scheme2->CurrentValue;
        $this->transaction_ref2->CurrentValue = null;
        $this->transaction_ref2->OldValue = $this->transaction_ref2->CurrentValue;
        $this->channel_response_desc2->CurrentValue = null;
        $this->channel_response_desc2->OldValue = $this->channel_response_desc2->CurrentValue;
        $this->res_status2->CurrentValue = null;
        $this->res_status2->OldValue = $this->res_status2->CurrentValue;
        $this->res_referenceNo2->CurrentValue = null;
        $this->res_referenceNo2->OldValue = $this->res_referenceNo2->CurrentValue;
        $this->status_approve->CurrentValue = 0;
        $this->status_approve->OldValue = $this->status_approve->CurrentValue;
        $this->res_paidAgent1->CurrentValue = null;
        $this->res_paidAgent1->OldValue = $this->res_paidAgent1->CurrentValue;
        $this->res_paidChannel1->CurrentValue = null;
        $this->res_paidChannel1->OldValue = $this->res_paidChannel1->CurrentValue;
        $this->res_maskedPan1->CurrentValue = null;
        $this->res_maskedPan1->OldValue = $this->res_maskedPan1->CurrentValue;
        $this->res_paidAgent2->CurrentValue = null;
        $this->res_paidAgent2->OldValue = $this->res_paidAgent2->CurrentValue;
        $this->res_paidChannel2->CurrentValue = null;
        $this->res_paidChannel2->OldValue = $this->res_paidChannel2->CurrentValue;
        $this->res_maskedPan2->CurrentValue = null;
        $this->res_maskedPan2->OldValue = $this->res_maskedPan2->CurrentValue;
        $this->is_email1->CurrentValue = null;
        $this->is_email1->OldValue = $this->is_email1->CurrentValue;
        $this->is_email2->CurrentValue = null;
        $this->is_email2->OldValue = $this->is_email2->CurrentValue;
        $this->receipt_status1->CurrentValue = null;
        $this->receipt_status1->OldValue = $this->receipt_status1->CurrentValue;
        $this->receipt_status2->CurrentValue = null;
        $this->receipt_status2->OldValue = $this->receipt_status2->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'asset_id' first before field var 'x_asset_id'
        $val = $CurrentForm->hasValue("asset_id") ? $CurrentForm->getValue("asset_id") : $CurrentForm->getValue("x_asset_id");
        if (!$this->asset_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_id->Visible = false; // Disable update for API request
            } else {
                $this->asset_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_asset_id")) {
            $this->asset_id->setOldValue($CurrentForm->getValue("o_asset_id"));
        }

        // Check field name 'member_id' first before field var 'x_member_id'
        $val = $CurrentForm->hasValue("member_id") ? $CurrentForm->getValue("member_id") : $CurrentForm->getValue("x_member_id");
        if (!$this->member_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->member_id->Visible = false; // Disable update for API request
            } else {
                $this->member_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_member_id")) {
            $this->member_id->setOldValue($CurrentForm->getValue("o_member_id"));
        }

        // Check field name 'one_time_status' first before field var 'x_one_time_status'
        $val = $CurrentForm->hasValue("one_time_status") ? $CurrentForm->getValue("one_time_status") : $CurrentForm->getValue("x_one_time_status");
        if (!$this->one_time_status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->one_time_status->Visible = false; // Disable update for API request
            } else {
                $this->one_time_status->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_one_time_status")) {
            $this->one_time_status->setOldValue($CurrentForm->getValue("o_one_time_status"));
        }

        // Check field name 'half_price_1' first before field var 'x_half_price_1'
        $val = $CurrentForm->hasValue("half_price_1") ? $CurrentForm->getValue("half_price_1") : $CurrentForm->getValue("x_half_price_1");
        if (!$this->half_price_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->half_price_1->Visible = false; // Disable update for API request
            } else {
                $this->half_price_1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_half_price_1")) {
            $this->half_price_1->setOldValue($CurrentForm->getValue("o_half_price_1"));
        }

        // Check field name 'status_pay_half_price_1' first before field var 'x_status_pay_half_price_1'
        $val = $CurrentForm->hasValue("status_pay_half_price_1") ? $CurrentForm->getValue("status_pay_half_price_1") : $CurrentForm->getValue("x_status_pay_half_price_1");
        if (!$this->status_pay_half_price_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_pay_half_price_1->Visible = false; // Disable update for API request
            } else {
                $this->status_pay_half_price_1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_status_pay_half_price_1")) {
            $this->status_pay_half_price_1->setOldValue($CurrentForm->getValue("o_status_pay_half_price_1"));
        }

        // Check field name 'due_date_pay_half_price_1' first before field var 'x_due_date_pay_half_price_1'
        $val = $CurrentForm->hasValue("due_date_pay_half_price_1") ? $CurrentForm->getValue("due_date_pay_half_price_1") : $CurrentForm->getValue("x_due_date_pay_half_price_1");
        if (!$this->due_date_pay_half_price_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->due_date_pay_half_price_1->Visible = false; // Disable update for API request
            } else {
                $this->due_date_pay_half_price_1->setFormValue($val, true, $validate);
            }
            $this->due_date_pay_half_price_1->CurrentValue = UnFormatDateTime($this->due_date_pay_half_price_1->CurrentValue, $this->due_date_pay_half_price_1->formatPattern());
        }
        if ($CurrentForm->hasValue("o_due_date_pay_half_price_1")) {
            $this->due_date_pay_half_price_1->setOldValue($CurrentForm->getValue("o_due_date_pay_half_price_1"));
        }

        // Check field name 'half_price_2' first before field var 'x_half_price_2'
        $val = $CurrentForm->hasValue("half_price_2") ? $CurrentForm->getValue("half_price_2") : $CurrentForm->getValue("x_half_price_2");
        if (!$this->half_price_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->half_price_2->Visible = false; // Disable update for API request
            } else {
                $this->half_price_2->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_half_price_2")) {
            $this->half_price_2->setOldValue($CurrentForm->getValue("o_half_price_2"));
        }

        // Check field name 'status_pay_half_price_2' first before field var 'x_status_pay_half_price_2'
        $val = $CurrentForm->hasValue("status_pay_half_price_2") ? $CurrentForm->getValue("status_pay_half_price_2") : $CurrentForm->getValue("x_status_pay_half_price_2");
        if (!$this->status_pay_half_price_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_pay_half_price_2->Visible = false; // Disable update for API request
            } else {
                $this->status_pay_half_price_2->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_status_pay_half_price_2")) {
            $this->status_pay_half_price_2->setOldValue($CurrentForm->getValue("o_status_pay_half_price_2"));
        }

        // Check field name 'due_date_pay_half_price_2' first before field var 'x_due_date_pay_half_price_2'
        $val = $CurrentForm->hasValue("due_date_pay_half_price_2") ? $CurrentForm->getValue("due_date_pay_half_price_2") : $CurrentForm->getValue("x_due_date_pay_half_price_2");
        if (!$this->due_date_pay_half_price_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->due_date_pay_half_price_2->Visible = false; // Disable update for API request
            } else {
                $this->due_date_pay_half_price_2->setFormValue($val, true, $validate);
            }
            $this->due_date_pay_half_price_2->CurrentValue = UnFormatDateTime($this->due_date_pay_half_price_2->CurrentValue, $this->due_date_pay_half_price_2->formatPattern());
        }
        if ($CurrentForm->hasValue("o_due_date_pay_half_price_2")) {
            $this->due_date_pay_half_price_2->setOldValue($CurrentForm->getValue("o_due_date_pay_half_price_2"));
        }

        // Check field name 'buyer_asset_rent_id' first before field var 'x_buyer_asset_rent_id'
        $val = $CurrentForm->hasValue("buyer_asset_rent_id") ? $CurrentForm->getValue("buyer_asset_rent_id") : $CurrentForm->getValue("x_buyer_asset_rent_id");
        if (!$this->buyer_asset_rent_id->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->buyer_asset_rent_id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->buyer_asset_rent_id->CurrentValue = $this->buyer_asset_rent_id->FormValue;
        }
        $this->asset_id->CurrentValue = $this->asset_id->FormValue;
        $this->member_id->CurrentValue = $this->member_id->FormValue;
        $this->one_time_status->CurrentValue = $this->one_time_status->FormValue;
        $this->half_price_1->CurrentValue = $this->half_price_1->FormValue;
        $this->status_pay_half_price_1->CurrentValue = $this->status_pay_half_price_1->FormValue;
        $this->due_date_pay_half_price_1->CurrentValue = $this->due_date_pay_half_price_1->FormValue;
        $this->due_date_pay_half_price_1->CurrentValue = UnFormatDateTime($this->due_date_pay_half_price_1->CurrentValue, $this->due_date_pay_half_price_1->formatPattern());
        $this->half_price_2->CurrentValue = $this->half_price_2->FormValue;
        $this->status_pay_half_price_2->CurrentValue = $this->status_pay_half_price_2->FormValue;
        $this->due_date_pay_half_price_2->CurrentValue = $this->due_date_pay_half_price_2->FormValue;
        $this->due_date_pay_half_price_2->CurrentValue = UnFormatDateTime($this->due_date_pay_half_price_2->CurrentValue, $this->due_date_pay_half_price_2->formatPattern());
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
        $this->buyer_asset_rent_id->setDbValue($row['buyer_asset_rent_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->one_time_status->setDbValue($row['one_time_status']);
        $this->half_price_1->setDbValue($row['half_price_1']);
        $this->pay_number_half_price_1->setDbValue($row['pay_number_half_price_1']);
        $this->status_pay_half_price_1->setDbValue($row['status_pay_half_price_1']);
        $this->date_pay_half_price_1->setDbValue($row['date_pay_half_price_1']);
        $this->due_date_pay_half_price_1->setDbValue($row['due_date_pay_half_price_1']);
        $this->half_price_2->setDbValue($row['half_price_2']);
        $this->pay_number_half_price_2->setDbValue($row['pay_number_half_price_2']);
        $this->status_pay_half_price_2->setDbValue($row['status_pay_half_price_2']);
        $this->date_pay_half_price_2->setDbValue($row['date_pay_half_price_2']);
        $this->due_date_pay_half_price_2->setDbValue($row['due_date_pay_half_price_2']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cip->setDbValue($row['cip']);
        $this->cuser->setDbValue($row['cuser']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->udate->setDbValue($row['udate']);
        $this->transaction_datetime1->setDbValue($row['transaction_datetime1']);
        $this->payment_scheme1->setDbValue($row['payment_scheme1']);
        $this->transaction_ref1->setDbValue($row['transaction_ref1']);
        $this->channel_response_desc1->setDbValue($row['channel_response_desc1']);
        $this->res_status1->setDbValue($row['res_status1']);
        $this->res_referenceNo1->setDbValue($row['res_referenceNo1']);
        $this->transaction_datetime2->setDbValue($row['transaction_datetime2']);
        $this->payment_scheme2->setDbValue($row['payment_scheme2']);
        $this->transaction_ref2->setDbValue($row['transaction_ref2']);
        $this->channel_response_desc2->setDbValue($row['channel_response_desc2']);
        $this->res_status2->setDbValue($row['res_status2']);
        $this->res_referenceNo2->setDbValue($row['res_referenceNo2']);
        $this->status_approve->setDbValue($row['status_approve']);
        $this->res_paidAgent1->setDbValue($row['res_paidAgent1']);
        $this->res_paidChannel1->setDbValue($row['res_paidChannel1']);
        $this->res_maskedPan1->setDbValue($row['res_maskedPan1']);
        $this->res_paidAgent2->setDbValue($row['res_paidAgent2']);
        $this->res_paidChannel2->setDbValue($row['res_paidChannel2']);
        $this->res_maskedPan2->setDbValue($row['res_maskedPan2']);
        $this->is_email1->setDbValue($row['is_email1']);
        $this->is_email2->setDbValue($row['is_email2']);
        $this->receipt_status1->setDbValue($row['receipt_status1']);
        $this->receipt_status2->setDbValue($row['receipt_status2']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['buyer_asset_rent_id'] = $this->buyer_asset_rent_id->CurrentValue;
        $row['asset_id'] = $this->asset_id->CurrentValue;
        $row['member_id'] = $this->member_id->CurrentValue;
        $row['one_time_status'] = $this->one_time_status->CurrentValue;
        $row['half_price_1'] = $this->half_price_1->CurrentValue;
        $row['pay_number_half_price_1'] = $this->pay_number_half_price_1->CurrentValue;
        $row['status_pay_half_price_1'] = $this->status_pay_half_price_1->CurrentValue;
        $row['date_pay_half_price_1'] = $this->date_pay_half_price_1->CurrentValue;
        $row['due_date_pay_half_price_1'] = $this->due_date_pay_half_price_1->CurrentValue;
        $row['half_price_2'] = $this->half_price_2->CurrentValue;
        $row['pay_number_half_price_2'] = $this->pay_number_half_price_2->CurrentValue;
        $row['status_pay_half_price_2'] = $this->status_pay_half_price_2->CurrentValue;
        $row['date_pay_half_price_2'] = $this->date_pay_half_price_2->CurrentValue;
        $row['due_date_pay_half_price_2'] = $this->due_date_pay_half_price_2->CurrentValue;
        $row['cdate'] = $this->cdate->CurrentValue;
        $row['cip'] = $this->cip->CurrentValue;
        $row['cuser'] = $this->cuser->CurrentValue;
        $row['uuser'] = $this->uuser->CurrentValue;
        $row['uip'] = $this->uip->CurrentValue;
        $row['udate'] = $this->udate->CurrentValue;
        $row['transaction_datetime1'] = $this->transaction_datetime1->CurrentValue;
        $row['payment_scheme1'] = $this->payment_scheme1->CurrentValue;
        $row['transaction_ref1'] = $this->transaction_ref1->CurrentValue;
        $row['channel_response_desc1'] = $this->channel_response_desc1->CurrentValue;
        $row['res_status1'] = $this->res_status1->CurrentValue;
        $row['res_referenceNo1'] = $this->res_referenceNo1->CurrentValue;
        $row['transaction_datetime2'] = $this->transaction_datetime2->CurrentValue;
        $row['payment_scheme2'] = $this->payment_scheme2->CurrentValue;
        $row['transaction_ref2'] = $this->transaction_ref2->CurrentValue;
        $row['channel_response_desc2'] = $this->channel_response_desc2->CurrentValue;
        $row['res_status2'] = $this->res_status2->CurrentValue;
        $row['res_referenceNo2'] = $this->res_referenceNo2->CurrentValue;
        $row['status_approve'] = $this->status_approve->CurrentValue;
        $row['res_paidAgent1'] = $this->res_paidAgent1->CurrentValue;
        $row['res_paidChannel1'] = $this->res_paidChannel1->CurrentValue;
        $row['res_maskedPan1'] = $this->res_maskedPan1->CurrentValue;
        $row['res_paidAgent2'] = $this->res_paidAgent2->CurrentValue;
        $row['res_paidChannel2'] = $this->res_paidChannel2->CurrentValue;
        $row['res_maskedPan2'] = $this->res_maskedPan2->CurrentValue;
        $row['is_email1'] = $this->is_email1->CurrentValue;
        $row['is_email2'] = $this->is_email2->CurrentValue;
        $row['receipt_status1'] = $this->receipt_status1->CurrentValue;
        $row['receipt_status2'] = $this->receipt_status2->CurrentValue;
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

        // buyer_asset_rent_id
        $this->buyer_asset_rent_id->CellCssStyle = "white-space: nowrap;";

        // asset_id

        // member_id

        // one_time_status

        // half_price_1

        // pay_number_half_price_1

        // status_pay_half_price_1

        // date_pay_half_price_1

        // due_date_pay_half_price_1

        // half_price_2

        // pay_number_half_price_2

        // status_pay_half_price_2

        // date_pay_half_price_2

        // due_date_pay_half_price_2

        // cdate

        // cip

        // cuser

        // uuser

        // uip

        // udate

        // transaction_datetime1
        $this->transaction_datetime1->CellCssStyle = "white-space: nowrap;";

        // payment_scheme1
        $this->payment_scheme1->CellCssStyle = "white-space: nowrap;";

        // transaction_ref1
        $this->transaction_ref1->CellCssStyle = "white-space: nowrap;";

        // channel_response_desc1
        $this->channel_response_desc1->CellCssStyle = "white-space: nowrap;";

        // res_status1
        $this->res_status1->CellCssStyle = "white-space: nowrap;";

        // res_referenceNo1
        $this->res_referenceNo1->CellCssStyle = "white-space: nowrap;";

        // transaction_datetime2
        $this->transaction_datetime2->CellCssStyle = "white-space: nowrap;";

        // payment_scheme2
        $this->payment_scheme2->CellCssStyle = "white-space: nowrap;";

        // transaction_ref2
        $this->transaction_ref2->CellCssStyle = "white-space: nowrap;";

        // channel_response_desc2
        $this->channel_response_desc2->CellCssStyle = "white-space: nowrap;";

        // res_status2
        $this->res_status2->CellCssStyle = "white-space: nowrap;";

        // res_referenceNo2
        $this->res_referenceNo2->CellCssStyle = "white-space: nowrap;";

        // status_approve
        $this->status_approve->CellCssStyle = "white-space: nowrap;";

        // res_paidAgent1
        $this->res_paidAgent1->CellCssStyle = "white-space: nowrap;";

        // res_paidChannel1
        $this->res_paidChannel1->CellCssStyle = "white-space: nowrap;";

        // res_maskedPan1
        $this->res_maskedPan1->CellCssStyle = "white-space: nowrap;";

        // res_paidAgent2
        $this->res_paidAgent2->CellCssStyle = "white-space: nowrap;";

        // res_paidChannel2
        $this->res_paidChannel2->CellCssStyle = "white-space: nowrap;";

        // res_maskedPan2
        $this->res_maskedPan2->CellCssStyle = "white-space: nowrap;";

        // is_email1
        $this->is_email1->CellCssStyle = "white-space: nowrap;";

        // is_email2
        $this->is_email2->CellCssStyle = "white-space: nowrap;";

        // receipt_status1
        $this->receipt_status1->CellCssStyle = "white-space: nowrap;";

        // receipt_status2
        $this->receipt_status2->CellCssStyle = "white-space: nowrap;";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
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

            // one_time_status
            if (ConvertToBool($this->one_time_status->CurrentValue)) {
                $this->one_time_status->ViewValue = $this->one_time_status->tagCaption(1) != "" ? $this->one_time_status->tagCaption(1) : "Yes";
            } else {
                $this->one_time_status->ViewValue = $this->one_time_status->tagCaption(2) != "" ? $this->one_time_status->tagCaption(2) : "No";
            }
            $this->one_time_status->ViewCustomAttributes = "";

            // half_price_1
            $this->half_price_1->ViewValue = $this->half_price_1->CurrentValue;
            $this->half_price_1->ViewValue = FormatCurrency($this->half_price_1->ViewValue, $this->half_price_1->formatPattern());
            $this->half_price_1->ViewCustomAttributes = "";

            // pay_number_half_price_1
            $this->pay_number_half_price_1->ViewValue = $this->pay_number_half_price_1->CurrentValue;
            $this->pay_number_half_price_1->ViewCustomAttributes = "";

            // status_pay_half_price_1
            if (strval($this->status_pay_half_price_1->CurrentValue) != "") {
                $this->status_pay_half_price_1->ViewValue = $this->status_pay_half_price_1->optionCaption($this->status_pay_half_price_1->CurrentValue);
            } else {
                $this->status_pay_half_price_1->ViewValue = null;
            }
            $this->status_pay_half_price_1->ViewCustomAttributes = "";

            // date_pay_half_price_1
            $this->date_pay_half_price_1->ViewValue = $this->date_pay_half_price_1->CurrentValue;
            $this->date_pay_half_price_1->ViewValue = FormatDateTime($this->date_pay_half_price_1->ViewValue, $this->date_pay_half_price_1->formatPattern());
            $this->date_pay_half_price_1->ViewCustomAttributes = "";

            // due_date_pay_half_price_1
            $this->due_date_pay_half_price_1->ViewValue = $this->due_date_pay_half_price_1->CurrentValue;
            $this->due_date_pay_half_price_1->ViewValue = FormatDateTime($this->due_date_pay_half_price_1->ViewValue, $this->due_date_pay_half_price_1->formatPattern());
            $this->due_date_pay_half_price_1->ViewCustomAttributes = "";

            // half_price_2
            $this->half_price_2->ViewValue = $this->half_price_2->CurrentValue;
            $this->half_price_2->ViewValue = FormatCurrency($this->half_price_2->ViewValue, $this->half_price_2->formatPattern());
            $this->half_price_2->ViewCustomAttributes = "";

            // pay_number_half_price_2
            $this->pay_number_half_price_2->ViewValue = $this->pay_number_half_price_2->CurrentValue;
            $this->pay_number_half_price_2->ViewCustomAttributes = "";

            // status_pay_half_price_2
            if (strval($this->status_pay_half_price_2->CurrentValue) != "") {
                $this->status_pay_half_price_2->ViewValue = $this->status_pay_half_price_2->optionCaption($this->status_pay_half_price_2->CurrentValue);
            } else {
                $this->status_pay_half_price_2->ViewValue = null;
            }
            $this->status_pay_half_price_2->ViewCustomAttributes = "";

            // date_pay_half_price_2
            $this->date_pay_half_price_2->ViewValue = $this->date_pay_half_price_2->CurrentValue;
            $this->date_pay_half_price_2->ViewValue = FormatDateTime($this->date_pay_half_price_2->ViewValue, $this->date_pay_half_price_2->formatPattern());
            $this->date_pay_half_price_2->ViewCustomAttributes = "";

            // due_date_pay_half_price_2
            $this->due_date_pay_half_price_2->ViewValue = $this->due_date_pay_half_price_2->CurrentValue;
            $this->due_date_pay_half_price_2->ViewValue = FormatDateTime($this->due_date_pay_half_price_2->ViewValue, $this->due_date_pay_half_price_2->formatPattern());
            $this->due_date_pay_half_price_2->ViewCustomAttributes = "";

            // cdate
            $this->cdate->ViewValue = $this->cdate->CurrentValue;
            $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
            $this->cdate->ViewCustomAttributes = "";

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";
            $this->asset_id->TooltipValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // one_time_status
            $this->one_time_status->LinkCustomAttributes = "";
            $this->one_time_status->HrefValue = "";
            $this->one_time_status->TooltipValue = "";

            // half_price_1
            $this->half_price_1->LinkCustomAttributes = "";
            $this->half_price_1->HrefValue = "";
            $this->half_price_1->TooltipValue = "";

            // status_pay_half_price_1
            $this->status_pay_half_price_1->LinkCustomAttributes = "";
            $this->status_pay_half_price_1->HrefValue = "";
            $this->status_pay_half_price_1->TooltipValue = "";

            // due_date_pay_half_price_1
            $this->due_date_pay_half_price_1->LinkCustomAttributes = "";
            $this->due_date_pay_half_price_1->HrefValue = "";
            $this->due_date_pay_half_price_1->TooltipValue = "";

            // half_price_2
            $this->half_price_2->LinkCustomAttributes = "";
            $this->half_price_2->HrefValue = "";
            $this->half_price_2->TooltipValue = "";

            // status_pay_half_price_2
            $this->status_pay_half_price_2->LinkCustomAttributes = "";
            $this->status_pay_half_price_2->HrefValue = "";
            $this->status_pay_half_price_2->TooltipValue = "";

            // due_date_pay_half_price_2
            $this->due_date_pay_half_price_2->LinkCustomAttributes = "";
            $this->due_date_pay_half_price_2->HrefValue = "";
            $this->due_date_pay_half_price_2->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // asset_id
            $this->asset_id->setupEditAttributes();
            $this->asset_id->EditCustomAttributes = "";
            if ($this->asset_id->getSessionValue() != "") {
                $this->asset_id->CurrentValue = GetForeignKeyValue($this->asset_id->getSessionValue());
                $this->asset_id->OldValue = $this->asset_id->CurrentValue;
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
            } else {
                $curVal = trim(strval($this->asset_id->CurrentValue));
                if ($curVal != "") {
                    $this->asset_id->ViewValue = $this->asset_id->lookupCacheOption($curVal);
                } else {
                    $this->asset_id->ViewValue = $this->asset_id->Lookup !== null && is_array($this->asset_id->lookupOptions()) ? $curVal : null;
                }
                if ($this->asset_id->ViewValue !== null) { // Load from cache
                    $this->asset_id->EditValue = array_values($this->asset_id->lookupOptions());
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`asset_id`" . SearchString("=", $this->asset_id->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->asset_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->asset_id->EditValue = $arwrk;
                }
                $this->asset_id->PlaceHolder = RemoveHtml($this->asset_id->caption());
            }

            // member_id
            $this->member_id->setupEditAttributes();
            $this->member_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->member_id->CurrentValue));
            if ($curVal != "") {
                $this->member_id->ViewValue = $this->member_id->lookupCacheOption($curVal);
            } else {
                $this->member_id->ViewValue = $this->member_id->Lookup !== null && is_array($this->member_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->member_id->ViewValue !== null) { // Load from cache
                $this->member_id->EditValue = array_values($this->member_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`member_id`" . SearchString("=", $this->member_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->member_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->member_id->EditValue = $arwrk;
            }
            $this->member_id->PlaceHolder = RemoveHtml($this->member_id->caption());

            // one_time_status
            $this->one_time_status->EditCustomAttributes = "";
            $this->one_time_status->EditValue = $this->one_time_status->options(false);
            $this->one_time_status->PlaceHolder = RemoveHtml($this->one_time_status->caption());

            // half_price_1
            $this->half_price_1->setupEditAttributes();
            $this->half_price_1->EditCustomAttributes = "";
            $this->half_price_1->EditValue = HtmlEncode($this->half_price_1->CurrentValue);
            $this->half_price_1->PlaceHolder = RemoveHtml($this->half_price_1->caption());
            if (strval($this->half_price_1->EditValue) != "" && is_numeric($this->half_price_1->EditValue)) {
                $this->half_price_1->EditValue = FormatNumber($this->half_price_1->EditValue, null);
                $this->half_price_1->OldValue = $this->half_price_1->EditValue;
            }

            // status_pay_half_price_1
            $this->status_pay_half_price_1->setupEditAttributes();
            $this->status_pay_half_price_1->EditCustomAttributes = "";
            $this->status_pay_half_price_1->EditValue = $this->status_pay_half_price_1->options(true);
            $this->status_pay_half_price_1->PlaceHolder = RemoveHtml($this->status_pay_half_price_1->caption());

            // due_date_pay_half_price_1
            $this->due_date_pay_half_price_1->setupEditAttributes();
            $this->due_date_pay_half_price_1->EditCustomAttributes = "";
            $this->due_date_pay_half_price_1->EditValue = HtmlEncode(FormatDateTime($this->due_date_pay_half_price_1->CurrentValue, $this->due_date_pay_half_price_1->formatPattern()));
            $this->due_date_pay_half_price_1->PlaceHolder = RemoveHtml($this->due_date_pay_half_price_1->caption());

            // half_price_2
            $this->half_price_2->setupEditAttributes();
            $this->half_price_2->EditCustomAttributes = "";
            $this->half_price_2->EditValue = HtmlEncode($this->half_price_2->CurrentValue);
            $this->half_price_2->PlaceHolder = RemoveHtml($this->half_price_2->caption());
            if (strval($this->half_price_2->EditValue) != "" && is_numeric($this->half_price_2->EditValue)) {
                $this->half_price_2->EditValue = FormatNumber($this->half_price_2->EditValue, null);
                $this->half_price_2->OldValue = $this->half_price_2->EditValue;
            }

            // status_pay_half_price_2
            $this->status_pay_half_price_2->setupEditAttributes();
            $this->status_pay_half_price_2->EditCustomAttributes = "";
            $this->status_pay_half_price_2->EditValue = $this->status_pay_half_price_2->options(true);
            $this->status_pay_half_price_2->PlaceHolder = RemoveHtml($this->status_pay_half_price_2->caption());

            // due_date_pay_half_price_2
            $this->due_date_pay_half_price_2->setupEditAttributes();
            $this->due_date_pay_half_price_2->EditCustomAttributes = "";
            $this->due_date_pay_half_price_2->EditValue = HtmlEncode(FormatDateTime($this->due_date_pay_half_price_2->CurrentValue, $this->due_date_pay_half_price_2->formatPattern()));
            $this->due_date_pay_half_price_2->PlaceHolder = RemoveHtml($this->due_date_pay_half_price_2->caption());

            // Add refer script

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";

            // one_time_status
            $this->one_time_status->LinkCustomAttributes = "";
            $this->one_time_status->HrefValue = "";

            // half_price_1
            $this->half_price_1->LinkCustomAttributes = "";
            $this->half_price_1->HrefValue = "";

            // status_pay_half_price_1
            $this->status_pay_half_price_1->LinkCustomAttributes = "";
            $this->status_pay_half_price_1->HrefValue = "";

            // due_date_pay_half_price_1
            $this->due_date_pay_half_price_1->LinkCustomAttributes = "";
            $this->due_date_pay_half_price_1->HrefValue = "";

            // half_price_2
            $this->half_price_2->LinkCustomAttributes = "";
            $this->half_price_2->HrefValue = "";

            // status_pay_half_price_2
            $this->status_pay_half_price_2->LinkCustomAttributes = "";
            $this->status_pay_half_price_2->HrefValue = "";

            // due_date_pay_half_price_2
            $this->due_date_pay_half_price_2->LinkCustomAttributes = "";
            $this->due_date_pay_half_price_2->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // asset_id
            $this->asset_id->setupEditAttributes();
            $this->asset_id->EditCustomAttributes = "";
            $curVal = strval($this->asset_id->CurrentValue);
            if ($curVal != "") {
                $this->asset_id->EditValue = $this->asset_id->lookupCacheOption($curVal);
                if ($this->asset_id->EditValue === null) { // Lookup from database
                    $filterWrk = "`asset_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->asset_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->asset_id->Lookup->renderViewRow($rswrk[0]);
                        $this->asset_id->EditValue = $this->asset_id->displayValue($arwrk);
                    } else {
                        $this->asset_id->EditValue = FormatNumber($this->asset_id->CurrentValue, $this->asset_id->formatPattern());
                    }
                }
            } else {
                $this->asset_id->EditValue = null;
            }
            $this->asset_id->ViewCustomAttributes = "";

            // member_id
            $this->member_id->setupEditAttributes();
            $this->member_id->EditCustomAttributes = "";
            $curVal = strval($this->member_id->CurrentValue);
            if ($curVal != "") {
                $this->member_id->EditValue = $this->member_id->lookupCacheOption($curVal);
                if ($this->member_id->EditValue === null) { // Lookup from database
                    $filterWrk = "`member_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->member_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->member_id->Lookup->renderViewRow($rswrk[0]);
                        $this->member_id->EditValue = $this->member_id->displayValue($arwrk);
                    } else {
                        $this->member_id->EditValue = FormatNumber($this->member_id->CurrentValue, $this->member_id->formatPattern());
                    }
                }
            } else {
                $this->member_id->EditValue = null;
            }
            $this->member_id->ViewCustomAttributes = "";

            // one_time_status
            $this->one_time_status->setupEditAttributes();
            $this->one_time_status->EditCustomAttributes = "";
            if (ConvertToBool($this->one_time_status->CurrentValue)) {
                $this->one_time_status->EditValue = $this->one_time_status->tagCaption(1) != "" ? $this->one_time_status->tagCaption(1) : "Yes";
            } else {
                $this->one_time_status->EditValue = $this->one_time_status->tagCaption(2) != "" ? $this->one_time_status->tagCaption(2) : "No";
            }
            $this->one_time_status->ViewCustomAttributes = "";

            // half_price_1
            $this->half_price_1->setupEditAttributes();
            $this->half_price_1->EditCustomAttributes = "";
            $this->half_price_1->EditValue = $this->half_price_1->CurrentValue;
            $this->half_price_1->EditValue = FormatCurrency($this->half_price_1->EditValue, $this->half_price_1->formatPattern());
            $this->half_price_1->ViewCustomAttributes = "";

            // status_pay_half_price_1
            $this->status_pay_half_price_1->setupEditAttributes();
            $this->status_pay_half_price_1->EditCustomAttributes = "";
            if (strval($this->status_pay_half_price_1->CurrentValue) != "") {
                $this->status_pay_half_price_1->EditValue = $this->status_pay_half_price_1->optionCaption($this->status_pay_half_price_1->CurrentValue);
            } else {
                $this->status_pay_half_price_1->EditValue = null;
            }
            $this->status_pay_half_price_1->ViewCustomAttributes = "";

            // due_date_pay_half_price_1
            $this->due_date_pay_half_price_1->setupEditAttributes();
            $this->due_date_pay_half_price_1->EditCustomAttributes = "";
            $this->due_date_pay_half_price_1->EditValue = HtmlEncode(FormatDateTime($this->due_date_pay_half_price_1->CurrentValue, $this->due_date_pay_half_price_1->formatPattern()));
            $this->due_date_pay_half_price_1->PlaceHolder = RemoveHtml($this->due_date_pay_half_price_1->caption());

            // half_price_2
            $this->half_price_2->setupEditAttributes();
            $this->half_price_2->EditCustomAttributes = "";
            $this->half_price_2->EditValue = $this->half_price_2->CurrentValue;
            $this->half_price_2->EditValue = FormatCurrency($this->half_price_2->EditValue, $this->half_price_2->formatPattern());
            $this->half_price_2->ViewCustomAttributes = "";

            // status_pay_half_price_2
            $this->status_pay_half_price_2->setupEditAttributes();
            $this->status_pay_half_price_2->EditCustomAttributes = "";
            if (strval($this->status_pay_half_price_2->CurrentValue) != "") {
                $this->status_pay_half_price_2->EditValue = $this->status_pay_half_price_2->optionCaption($this->status_pay_half_price_2->CurrentValue);
            } else {
                $this->status_pay_half_price_2->EditValue = null;
            }
            $this->status_pay_half_price_2->ViewCustomAttributes = "";

            // due_date_pay_half_price_2
            $this->due_date_pay_half_price_2->setupEditAttributes();
            $this->due_date_pay_half_price_2->EditCustomAttributes = "";
            $this->due_date_pay_half_price_2->EditValue = HtmlEncode(FormatDateTime($this->due_date_pay_half_price_2->CurrentValue, $this->due_date_pay_half_price_2->formatPattern()));
            $this->due_date_pay_half_price_2->PlaceHolder = RemoveHtml($this->due_date_pay_half_price_2->caption());

            // Edit refer script

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";
            $this->asset_id->TooltipValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // one_time_status
            $this->one_time_status->LinkCustomAttributes = "";
            $this->one_time_status->HrefValue = "";
            $this->one_time_status->TooltipValue = "";

            // half_price_1
            $this->half_price_1->LinkCustomAttributes = "";
            $this->half_price_1->HrefValue = "";
            $this->half_price_1->TooltipValue = "";

            // status_pay_half_price_1
            $this->status_pay_half_price_1->LinkCustomAttributes = "";
            $this->status_pay_half_price_1->HrefValue = "";
            $this->status_pay_half_price_1->TooltipValue = "";

            // due_date_pay_half_price_1
            $this->due_date_pay_half_price_1->LinkCustomAttributes = "";
            $this->due_date_pay_half_price_1->HrefValue = "";

            // half_price_2
            $this->half_price_2->LinkCustomAttributes = "";
            $this->half_price_2->HrefValue = "";
            $this->half_price_2->TooltipValue = "";

            // status_pay_half_price_2
            $this->status_pay_half_price_2->LinkCustomAttributes = "";
            $this->status_pay_half_price_2->HrefValue = "";
            $this->status_pay_half_price_2->TooltipValue = "";

            // due_date_pay_half_price_2
            $this->due_date_pay_half_price_2->LinkCustomAttributes = "";
            $this->due_date_pay_half_price_2->HrefValue = "";
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
        if ($this->asset_id->Required) {
            if (!$this->asset_id->IsDetailKey && EmptyValue($this->asset_id->FormValue)) {
                $this->asset_id->addErrorMessage(str_replace("%s", $this->asset_id->caption(), $this->asset_id->RequiredErrorMessage));
            }
        }
        if ($this->member_id->Required) {
            if (!$this->member_id->IsDetailKey && EmptyValue($this->member_id->FormValue)) {
                $this->member_id->addErrorMessage(str_replace("%s", $this->member_id->caption(), $this->member_id->RequiredErrorMessage));
            }
        }
        if ($this->one_time_status->Required) {
            if ($this->one_time_status->FormValue == "") {
                $this->one_time_status->addErrorMessage(str_replace("%s", $this->one_time_status->caption(), $this->one_time_status->RequiredErrorMessage));
            }
        }
        if ($this->half_price_1->Required) {
            if (!$this->half_price_1->IsDetailKey && EmptyValue($this->half_price_1->FormValue)) {
                $this->half_price_1->addErrorMessage(str_replace("%s", $this->half_price_1->caption(), $this->half_price_1->RequiredErrorMessage));
            }
        }
        if ($this->status_pay_half_price_1->Required) {
            if (!$this->status_pay_half_price_1->IsDetailKey && EmptyValue($this->status_pay_half_price_1->FormValue)) {
                $this->status_pay_half_price_1->addErrorMessage(str_replace("%s", $this->status_pay_half_price_1->caption(), $this->status_pay_half_price_1->RequiredErrorMessage));
            }
        }
        if ($this->due_date_pay_half_price_1->Required) {
            if (!$this->due_date_pay_half_price_1->IsDetailKey && EmptyValue($this->due_date_pay_half_price_1->FormValue)) {
                $this->due_date_pay_half_price_1->addErrorMessage(str_replace("%s", $this->due_date_pay_half_price_1->caption(), $this->due_date_pay_half_price_1->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->due_date_pay_half_price_1->FormValue, $this->due_date_pay_half_price_1->formatPattern())) {
            $this->due_date_pay_half_price_1->addErrorMessage($this->due_date_pay_half_price_1->getErrorMessage(false));
        }
        if ($this->half_price_2->Required) {
            if (!$this->half_price_2->IsDetailKey && EmptyValue($this->half_price_2->FormValue)) {
                $this->half_price_2->addErrorMessage(str_replace("%s", $this->half_price_2->caption(), $this->half_price_2->RequiredErrorMessage));
            }
        }
        if ($this->status_pay_half_price_2->Required) {
            if (!$this->status_pay_half_price_2->IsDetailKey && EmptyValue($this->status_pay_half_price_2->FormValue)) {
                $this->status_pay_half_price_2->addErrorMessage(str_replace("%s", $this->status_pay_half_price_2->caption(), $this->status_pay_half_price_2->RequiredErrorMessage));
            }
        }
        if ($this->due_date_pay_half_price_2->Required) {
            if (!$this->due_date_pay_half_price_2->IsDetailKey && EmptyValue($this->due_date_pay_half_price_2->FormValue)) {
                $this->due_date_pay_half_price_2->addErrorMessage(str_replace("%s", $this->due_date_pay_half_price_2->caption(), $this->due_date_pay_half_price_2->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->due_date_pay_half_price_2->FormValue, $this->due_date_pay_half_price_2->formatPattern())) {
            $this->due_date_pay_half_price_2->addErrorMessage($this->due_date_pay_half_price_2->getErrorMessage(false));
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
            $thisKey .= $row['buyer_asset_rent_id'];

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

            // due_date_pay_half_price_1
            $this->due_date_pay_half_price_1->setDbValueDef($rsnew, UnFormatDateTime($this->due_date_pay_half_price_1->CurrentValue, $this->due_date_pay_half_price_1->formatPattern()), null, $this->due_date_pay_half_price_1->ReadOnly);

            // due_date_pay_half_price_2
            $this->due_date_pay_half_price_2->setDbValueDef($rsnew, UnFormatDateTime($this->due_date_pay_half_price_2->CurrentValue, $this->due_date_pay_half_price_2->formatPattern()), null, $this->due_date_pay_half_price_2->ReadOnly);

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
        if ($this->getCurrentMasterTable() == "buyer_all_booking_asset") {
            $this->asset_id->CurrentValue = $this->asset_id->getSessionValue();
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // asset_id
        $this->asset_id->setDbValueDef($rsnew, $this->asset_id->CurrentValue, 0, false);

        // member_id
        $this->member_id->setDbValueDef($rsnew, $this->member_id->CurrentValue, 0, false);

        // one_time_status
        $tmpBool = $this->one_time_status->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->one_time_status->setDbValueDef($rsnew, $tmpBool, 0, strval($this->one_time_status->CurrentValue) == "");

        // half_price_1
        $this->half_price_1->setDbValueDef($rsnew, $this->half_price_1->CurrentValue, null, false);

        // status_pay_half_price_1
        $this->status_pay_half_price_1->setDbValueDef($rsnew, $this->status_pay_half_price_1->CurrentValue, null, strval($this->status_pay_half_price_1->CurrentValue) == "");

        // due_date_pay_half_price_1
        $this->due_date_pay_half_price_1->setDbValueDef($rsnew, UnFormatDateTime($this->due_date_pay_half_price_1->CurrentValue, $this->due_date_pay_half_price_1->formatPattern()), null, false);

        // half_price_2
        $this->half_price_2->setDbValueDef($rsnew, $this->half_price_2->CurrentValue, null, false);

        // status_pay_half_price_2
        $this->status_pay_half_price_2->setDbValueDef($rsnew, $this->status_pay_half_price_2->CurrentValue, null, strval($this->status_pay_half_price_2->CurrentValue) == "");

        // due_date_pay_half_price_2
        $this->due_date_pay_half_price_2->setDbValueDef($rsnew, UnFormatDateTime($this->due_date_pay_half_price_2->CurrentValue, $this->due_date_pay_half_price_2->formatPattern()), null, false);

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
        if ($masterTblVar == "buyer_all_booking_asset") {
            $masterTbl = Container("buyer_all_booking_asset");
            $this->asset_id->Visible = false;
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
                case "x_asset_id":
                    $conn = Conn("DB");
                    break;
                case "x_member_id":
                    $conn = Conn("DB");
                    break;
                case "x_one_time_status":
                    break;
                case "x_status_pay_half_price_1":
                    break;
                case "x_status_pay_half_price_2":
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
