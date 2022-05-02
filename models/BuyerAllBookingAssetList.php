<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class BuyerAllBookingAssetList extends BuyerAllBookingAsset
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'buyer_all_booking_asset';

    // Page object name
    public $PageObjName = "BuyerAllBookingAssetList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fbuyer_all_booking_assetlist";
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

        // Table object (buyer_all_booking_asset)
        if (!isset($GLOBALS["buyer_all_booking_asset"]) || get_class($GLOBALS["buyer_all_booking_asset"]) == PROJECT_NAMESPACE . "buyer_all_booking_asset") {
            $GLOBALS["buyer_all_booking_asset"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "buyerallbookingassetadd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "buyerallbookingassetdelete";
        $this->MultiUpdateUrl = "buyerallbookingassetupdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'buyer_all_booking_asset');
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
                $tbl = Container("buyer_all_booking_asset");
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
            $key .= @$ar['buyer_booking_asset_id'];
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
            $this->buyer_booking_asset_id->Visible = false;
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
        $this->buyer_booking_asset_id->Visible = false;
        $this->asset_id->setVisibility();
        $this->member_id->setVisibility();
        $this->booking_price->setVisibility();
        $this->pay_number->setVisibility();
        $this->status_payment->setVisibility();
        $this->date_booking->setVisibility();
        $this->date_payment->setVisibility();
        $this->due_date->setVisibility();
        $this->status_expire->setVisibility();
        $this->status_expire_reason->setVisibility();
        $this->cdate->Visible = false;
        $this->cuser->Visible = false;
        $this->cip->Visible = false;
        $this->udate->Visible = false;
        $this->uuser->Visible = false;
        $this->uip->Visible = false;
        $this->type->Visible = false;
        $this->transaction_datetime->Visible = false;
        $this->payment_scheme->Visible = false;
        $this->transaction_ref->Visible = false;
        $this->channel_response_desc->Visible = false;
        $this->res_status->Visible = false;
        $this->res_referenceNo->Visible = false;
        $this->res_paidAgent->Visible = false;
        $this->res_paidChannel->Visible = false;
        $this->res_maskedPan->Visible = false;
        $this->receipt_status->Visible = false;
        $this->is_email->Visible = false;
        $this->authorize_url->Visible = false;
        $this->amount_net->Visible = false;
        $this->amount_cust_fee->Visible = false;
        $this->count_show_signer_3->Visible = false;
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
        $this->setupLookupOptions($this->asset_id);
        $this->setupLookupOptions($this->member_id);
        $this->setupLookupOptions($this->status_payment);
        $this->setupLookupOptions($this->status_expire);

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
            $savedFilterList = $UserProfile->getSearchFilters(CurrentUserName(), "fbuyer_all_booking_assetsrch");
        }
        $filterList = Concat($filterList, $this->buyer_booking_asset_id->AdvancedSearch->toJson(), ","); // Field buyer_booking_asset_id
        $filterList = Concat($filterList, $this->asset_id->AdvancedSearch->toJson(), ","); // Field asset_id
        $filterList = Concat($filterList, $this->member_id->AdvancedSearch->toJson(), ","); // Field member_id
        $filterList = Concat($filterList, $this->booking_price->AdvancedSearch->toJson(), ","); // Field booking_price
        $filterList = Concat($filterList, $this->pay_number->AdvancedSearch->toJson(), ","); // Field pay_number
        $filterList = Concat($filterList, $this->status_payment->AdvancedSearch->toJson(), ","); // Field status_payment
        $filterList = Concat($filterList, $this->date_booking->AdvancedSearch->toJson(), ","); // Field date_booking
        $filterList = Concat($filterList, $this->date_payment->AdvancedSearch->toJson(), ","); // Field date_payment
        $filterList = Concat($filterList, $this->due_date->AdvancedSearch->toJson(), ","); // Field due_date
        $filterList = Concat($filterList, $this->status_expire->AdvancedSearch->toJson(), ","); // Field status_expire
        $filterList = Concat($filterList, $this->status_expire_reason->AdvancedSearch->toJson(), ","); // Field status_expire_reason
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fbuyer_all_booking_assetsrch", $filters);
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

        // Field buyer_booking_asset_id
        $this->buyer_booking_asset_id->AdvancedSearch->SearchValue = @$filter["x_buyer_booking_asset_id"];
        $this->buyer_booking_asset_id->AdvancedSearch->SearchOperator = @$filter["z_buyer_booking_asset_id"];
        $this->buyer_booking_asset_id->AdvancedSearch->SearchCondition = @$filter["v_buyer_booking_asset_id"];
        $this->buyer_booking_asset_id->AdvancedSearch->SearchValue2 = @$filter["y_buyer_booking_asset_id"];
        $this->buyer_booking_asset_id->AdvancedSearch->SearchOperator2 = @$filter["w_buyer_booking_asset_id"];
        $this->buyer_booking_asset_id->AdvancedSearch->save();

        // Field asset_id
        $this->asset_id->AdvancedSearch->SearchValue = @$filter["x_asset_id"];
        $this->asset_id->AdvancedSearch->SearchOperator = @$filter["z_asset_id"];
        $this->asset_id->AdvancedSearch->SearchCondition = @$filter["v_asset_id"];
        $this->asset_id->AdvancedSearch->SearchValue2 = @$filter["y_asset_id"];
        $this->asset_id->AdvancedSearch->SearchOperator2 = @$filter["w_asset_id"];
        $this->asset_id->AdvancedSearch->save();

        // Field member_id
        $this->member_id->AdvancedSearch->SearchValue = @$filter["x_member_id"];
        $this->member_id->AdvancedSearch->SearchOperator = @$filter["z_member_id"];
        $this->member_id->AdvancedSearch->SearchCondition = @$filter["v_member_id"];
        $this->member_id->AdvancedSearch->SearchValue2 = @$filter["y_member_id"];
        $this->member_id->AdvancedSearch->SearchOperator2 = @$filter["w_member_id"];
        $this->member_id->AdvancedSearch->save();

        // Field booking_price
        $this->booking_price->AdvancedSearch->SearchValue = @$filter["x_booking_price"];
        $this->booking_price->AdvancedSearch->SearchOperator = @$filter["z_booking_price"];
        $this->booking_price->AdvancedSearch->SearchCondition = @$filter["v_booking_price"];
        $this->booking_price->AdvancedSearch->SearchValue2 = @$filter["y_booking_price"];
        $this->booking_price->AdvancedSearch->SearchOperator2 = @$filter["w_booking_price"];
        $this->booking_price->AdvancedSearch->save();

        // Field pay_number
        $this->pay_number->AdvancedSearch->SearchValue = @$filter["x_pay_number"];
        $this->pay_number->AdvancedSearch->SearchOperator = @$filter["z_pay_number"];
        $this->pay_number->AdvancedSearch->SearchCondition = @$filter["v_pay_number"];
        $this->pay_number->AdvancedSearch->SearchValue2 = @$filter["y_pay_number"];
        $this->pay_number->AdvancedSearch->SearchOperator2 = @$filter["w_pay_number"];
        $this->pay_number->AdvancedSearch->save();

        // Field status_payment
        $this->status_payment->AdvancedSearch->SearchValue = @$filter["x_status_payment"];
        $this->status_payment->AdvancedSearch->SearchOperator = @$filter["z_status_payment"];
        $this->status_payment->AdvancedSearch->SearchCondition = @$filter["v_status_payment"];
        $this->status_payment->AdvancedSearch->SearchValue2 = @$filter["y_status_payment"];
        $this->status_payment->AdvancedSearch->SearchOperator2 = @$filter["w_status_payment"];
        $this->status_payment->AdvancedSearch->save();

        // Field date_booking
        $this->date_booking->AdvancedSearch->SearchValue = @$filter["x_date_booking"];
        $this->date_booking->AdvancedSearch->SearchOperator = @$filter["z_date_booking"];
        $this->date_booking->AdvancedSearch->SearchCondition = @$filter["v_date_booking"];
        $this->date_booking->AdvancedSearch->SearchValue2 = @$filter["y_date_booking"];
        $this->date_booking->AdvancedSearch->SearchOperator2 = @$filter["w_date_booking"];
        $this->date_booking->AdvancedSearch->save();

        // Field date_payment
        $this->date_payment->AdvancedSearch->SearchValue = @$filter["x_date_payment"];
        $this->date_payment->AdvancedSearch->SearchOperator = @$filter["z_date_payment"];
        $this->date_payment->AdvancedSearch->SearchCondition = @$filter["v_date_payment"];
        $this->date_payment->AdvancedSearch->SearchValue2 = @$filter["y_date_payment"];
        $this->date_payment->AdvancedSearch->SearchOperator2 = @$filter["w_date_payment"];
        $this->date_payment->AdvancedSearch->save();

        // Field due_date
        $this->due_date->AdvancedSearch->SearchValue = @$filter["x_due_date"];
        $this->due_date->AdvancedSearch->SearchOperator = @$filter["z_due_date"];
        $this->due_date->AdvancedSearch->SearchCondition = @$filter["v_due_date"];
        $this->due_date->AdvancedSearch->SearchValue2 = @$filter["y_due_date"];
        $this->due_date->AdvancedSearch->SearchOperator2 = @$filter["w_due_date"];
        $this->due_date->AdvancedSearch->save();

        // Field status_expire
        $this->status_expire->AdvancedSearch->SearchValue = @$filter["x_status_expire"];
        $this->status_expire->AdvancedSearch->SearchOperator = @$filter["z_status_expire"];
        $this->status_expire->AdvancedSearch->SearchCondition = @$filter["v_status_expire"];
        $this->status_expire->AdvancedSearch->SearchValue2 = @$filter["y_status_expire"];
        $this->status_expire->AdvancedSearch->SearchOperator2 = @$filter["w_status_expire"];
        $this->status_expire->AdvancedSearch->save();

        // Field status_expire_reason
        $this->status_expire_reason->AdvancedSearch->SearchValue = @$filter["x_status_expire_reason"];
        $this->status_expire_reason->AdvancedSearch->SearchOperator = @$filter["z_status_expire_reason"];
        $this->status_expire_reason->AdvancedSearch->SearchCondition = @$filter["v_status_expire_reason"];
        $this->status_expire_reason->AdvancedSearch->SearchValue2 = @$filter["y_status_expire_reason"];
        $this->status_expire_reason->AdvancedSearch->SearchOperator2 = @$filter["w_status_expire_reason"];
        $this->status_expire_reason->AdvancedSearch->save();

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
        $this->buildSearchSql($where, $this->buyer_booking_asset_id, $default, false); // buyer_booking_asset_id
        $this->buildSearchSql($where, $this->asset_id, $default, false); // asset_id
        $this->buildSearchSql($where, $this->member_id, $default, false); // member_id
        $this->buildSearchSql($where, $this->booking_price, $default, false); // booking_price
        $this->buildSearchSql($where, $this->pay_number, $default, false); // pay_number
        $this->buildSearchSql($where, $this->status_payment, $default, false); // status_payment
        $this->buildSearchSql($where, $this->date_booking, $default, false); // date_booking
        $this->buildSearchSql($where, $this->date_payment, $default, false); // date_payment
        $this->buildSearchSql($where, $this->due_date, $default, false); // due_date
        $this->buildSearchSql($where, $this->status_expire, $default, false); // status_expire
        $this->buildSearchSql($where, $this->status_expire_reason, $default, false); // status_expire_reason
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
            $this->buyer_booking_asset_id->AdvancedSearch->save(); // buyer_booking_asset_id
            $this->asset_id->AdvancedSearch->save(); // asset_id
            $this->member_id->AdvancedSearch->save(); // member_id
            $this->booking_price->AdvancedSearch->save(); // booking_price
            $this->pay_number->AdvancedSearch->save(); // pay_number
            $this->status_payment->AdvancedSearch->save(); // status_payment
            $this->date_booking->AdvancedSearch->save(); // date_booking
            $this->date_payment->AdvancedSearch->save(); // date_payment
            $this->due_date->AdvancedSearch->save(); // due_date
            $this->status_expire->AdvancedSearch->save(); // status_expire
            $this->status_expire_reason->AdvancedSearch->save(); // status_expire_reason
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
        if ($this->buyer_booking_asset_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->asset_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->member_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->booking_price->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->pay_number->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->status_payment->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->date_booking->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->date_payment->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->due_date->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->status_expire->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->status_expire_reason->AdvancedSearch->issetSession()) {
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
        $this->buyer_booking_asset_id->AdvancedSearch->unsetSession();
        $this->asset_id->AdvancedSearch->unsetSession();
        $this->member_id->AdvancedSearch->unsetSession();
        $this->booking_price->AdvancedSearch->unsetSession();
        $this->pay_number->AdvancedSearch->unsetSession();
        $this->status_payment->AdvancedSearch->unsetSession();
        $this->date_booking->AdvancedSearch->unsetSession();
        $this->date_payment->AdvancedSearch->unsetSession();
        $this->due_date->AdvancedSearch->unsetSession();
        $this->status_expire->AdvancedSearch->unsetSession();
        $this->status_expire_reason->AdvancedSearch->unsetSession();
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
        $this->buyer_booking_asset_id->AdvancedSearch->load();
        $this->asset_id->AdvancedSearch->load();
        $this->member_id->AdvancedSearch->load();
        $this->booking_price->AdvancedSearch->load();
        $this->pay_number->AdvancedSearch->load();
        $this->status_payment->AdvancedSearch->load();
        $this->date_booking->AdvancedSearch->load();
        $this->date_payment->AdvancedSearch->load();
        $this->due_date->AdvancedSearch->load();
        $this->status_expire->AdvancedSearch->load();
        $this->status_expire_reason->AdvancedSearch->load();
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
            $this->updateSort($this->asset_id, $ctrl); // asset_id
            $this->updateSort($this->member_id, $ctrl); // member_id
            $this->updateSort($this->booking_price, $ctrl); // booking_price
            $this->updateSort($this->pay_number, $ctrl); // pay_number
            $this->updateSort($this->status_payment, $ctrl); // status_payment
            $this->updateSort($this->date_booking, $ctrl); // date_booking
            $this->updateSort($this->date_payment, $ctrl); // date_payment
            $this->updateSort($this->due_date, $ctrl); // due_date
            $this->updateSort($this->status_expire, $ctrl); // status_expire
            $this->updateSort($this->status_expire_reason, $ctrl); // status_expire_reason
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "`date_booking` DESC";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($this->date_booking->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($useDefaultSort) {
                    $this->date_booking->setSort("DESC");
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
                $this->buyer_booking_asset_id->setSort("");
                $this->asset_id->setSort("");
                $this->member_id->setSort("");
                $this->booking_price->setSort("");
                $this->pay_number->setSort("");
                $this->status_payment->setSort("");
                $this->date_booking->setSort("");
                $this->date_payment->setSort("");
                $this->due_date->setSort("");
                $this->status_expire->setSort("");
                $this->status_expire_reason->setSort("");
                $this->cdate->setSort("");
                $this->cuser->setSort("");
                $this->cip->setSort("");
                $this->udate->setSort("");
                $this->uuser->setSort("");
                $this->uip->setSort("");
                $this->type->setSort("");
                $this->transaction_datetime->setSort("");
                $this->payment_scheme->setSort("");
                $this->transaction_ref->setSort("");
                $this->channel_response_desc->setSort("");
                $this->res_status->setSort("");
                $this->res_referenceNo->setSort("");
                $this->res_paidAgent->setSort("");
                $this->res_paidChannel->setSort("");
                $this->res_maskedPan->setSort("");
                $this->receipt_status->setSort("");
                $this->is_email->setSort("");
                $this->authorize_url->setSort("");
                $this->amount_net->setSort("");
                $this->amount_cust_fee->setSort("");
                $this->count_show_signer_3->setSort("");
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

        // "detail_buyer_all_asset_rent"
        $item = &$this->ListOptions->add("detail_buyer_all_asset_rent");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'buyer_all_asset_rent');
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_all_buyer_config_asset_schedule"
        $item = &$this->ListOptions->add("detail_all_buyer_config_asset_schedule");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'all_buyer_config_asset_schedule');
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_doc_juzmatch1"
        $item = &$this->ListOptions->add("detail_doc_juzmatch1");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'doc_juzmatch1');
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_doc_juzmatch3"
        $item = &$this->ListOptions->add("detail_doc_juzmatch3");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'doc_juzmatch3');
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
        $pages->add("buyer_all_asset_rent");
        $pages->add("all_buyer_config_asset_schedule");
        $pages->add("doc_juzmatch1");
        $pages->add("doc_juzmatch3");
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
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fbuyer_all_booking_assetlist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button></li>";
                    if ($link != "") {
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fbuyer_all_booking_assetlist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button>";
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

        // "detail_buyer_all_asset_rent"
        $opt = $this->ListOptions["detail_buyer_all_asset_rent"];
        if ($Security->allowList(CurrentProjectID() . 'buyer_all_asset_rent')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("buyer_all_asset_rent", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("buyerallassetrentlist?" . Config("TABLE_SHOW_MASTER") . "=buyer_all_booking_asset&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("BuyerAllAssetRentGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'buyer_all_booking_asset')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=buyer_all_asset_rent");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "buyer_all_asset_rent";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'buyer_all_booking_asset')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=buyer_all_asset_rent");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "buyer_all_asset_rent";
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

        // "detail_all_buyer_config_asset_schedule"
        $opt = $this->ListOptions["detail_all_buyer_config_asset_schedule"];
        if ($Security->allowList(CurrentProjectID() . 'all_buyer_config_asset_schedule')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("all_buyer_config_asset_schedule", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("allbuyerconfigassetschedulelist?" . Config("TABLE_SHOW_MASTER") . "=buyer_all_booking_asset&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("AllBuyerConfigAssetScheduleGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'buyer_all_booking_asset')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=all_buyer_config_asset_schedule");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "all_buyer_config_asset_schedule";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'buyer_all_booking_asset')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=all_buyer_config_asset_schedule");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "all_buyer_config_asset_schedule";
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

        // "detail_doc_juzmatch1"
        $opt = $this->ListOptions["detail_doc_juzmatch1"];
        if ($Security->allowList(CurrentProjectID() . 'doc_juzmatch1')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("doc_juzmatch1", "TblCaption");
            // old
            // $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("docjuzmatch1list?" . Config("TABLE_SHOW_MASTER") . "=buyer_all_booking_asset&" . GetForeignKeyUrl("fk_buyer_booking_asset_id", $this->buyer_booking_asset_id->CurrentValue) . "") . "\">" . $body . "</a>";
            // docjuzmatch1list?showmaster=buyer_all_booking_asset&fk_buyer_booking_asset_id=2

            // new
            if ($this->buyer_booking_asset_id->CurrentValue == "" || $this->buyer_booking_asset_id->CurrentValue == null) {
            } else {

                // check จ่ายเงินดาวน์งวดแรก
                $sql_check_down1 = "SELECT buyer_booking_asset.buyer_booking_asset_id,buyer_asset_rent.asset_id,buyer_asset_rent.status_pay_half_price_1 FROM `buyer_asset_rent` LEFT JOIN buyer_booking_asset ON buyer_booking_asset.asset_id = buyer_asset_rent.asset_id WHERE buyer_booking_asset.buyer_booking_asset_id = ".$this->buyer_booking_asset_id->CurrentValue." ORDER BY buyer_asset_rent.buyer_asset_rent_id DESC LIMIT 0,1";
                $res_check_down1 = ExecuteRow($sql_check_down1);

                if (!empty($res_check_down1)) {

                    $check_down1 = $res_check_down1['status_pay_half_price_1'];
                    if ($check_down1 == 2) {
                        // check prefix_asset_code
                        $docjuzmatch1Id = '';
                        $sql_check_doc1 = "SELECT id FROM `doc_juzmatch1` WHERE buyer_booking_asset_id = ".$this->buyer_booking_asset_id->CurrentValue;
                        $res_check_doc1 = ExecuteRow($sql_check_doc1);

                        $docjuzmatch1Id = $res_check_doc1['id'];

                        if (!empty($res_check_doc1)) {
                            // Edit
                            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("docjuzmatch1edit/".$docjuzmatch1Id."?" . Config("TABLE_SHOW_MASTER") . "=buyer_all_booking_asset&" . GetForeignKeyUrl("fk_buyer_booking_asset_id", $this->buyer_booking_asset_id->CurrentValue) . "") . "\">" . $body . "</a>";
                            // /docjuzmatch1edit/1?showmaster=buyer_all_booking_asset&fk_buyer_booking_asset_id=2
                        } else {
                            // Add
                            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("docjuzmatch1add?" . Config("TABLE_SHOW_MASTER") . "=buyer_all_booking_asset&" . GetForeignKeyUrl("fk_buyer_booking_asset_id", $this->buyer_booking_asset_id->CurrentValue) . "") . "\">" . $body . "</a>";
                            // /docjuzmatch1add?showmaster=buyer_all_booking_asset&fk_buyer_booking_asset_id=2
                        }
                    }else{
                        $body = "";   
                    }
                } else {
                    $body = "";   
                }
            }
            $links = "";
            $detailPage = Container("DocJuzmatch1Grid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'buyer_all_booking_asset')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=doc_juzmatch1");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "doc_juzmatch1";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'buyer_all_booking_asset')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=doc_juzmatch1");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "doc_juzmatch1";
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

        // "detail_doc_juzmatch3"
        $opt = $this->ListOptions["detail_doc_juzmatch3"];
        if ($Security->allowList(CurrentProjectID() . 'doc_juzmatch3')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("doc_juzmatch3", "TblCaption");
            // old
            // $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("docjuzmatch3list?" . Config("TABLE_SHOW_MASTER") . "=buyer_all_booking_asset&" . GetForeignKeyUrl("fk_buyer_booking_asset_id", $this->buyer_booking_asset_id->CurrentValue) . "") . "\">" . $body . "</a>";

            // new
            if ($this->buyer_booking_asset_id->CurrentValue == "" || $this->buyer_booking_asset_id->CurrentValue == null) {
            } else {

                // check สัญญา 1 สำเร็จ
                $sql_count_show_signer_3 = "SELECT count_show_signer_3 FROM `buyer_booking_asset` WHERE buyer_booking_asset_id = ".$this->buyer_booking_asset_id->CurrentValue;
                $res_count_show_signer_3 = ExecuteRow($sql_count_show_signer_3);

                if (!empty($res_count_show_signer_3)) {
                    $show_signer_3 = $res_count_show_signer_3['count_show_signer_3'];

                    $count_email_signer_3 = -1;
                    if ($docjuzmatch1Id == "") {
                        $count_email_signer_3 = -1;
                    }else{

                    $sql_count_email_signer_3 = "SELECT COUNT(*) AS count FROM ( SELECT doc_juzmatch1.id,doc_creden_signer.doc_creden_id,COUNT(doc_creden_signer.doc_creden_signer_email) as count_signer_email FROM `doc_juzmatch1` LEFT JOIN doc_creden ON doc_creden.doc_creden_id = doc_juzmatch1.doc_creden_id LEFT JOIN doc_creden_signer ON doc_creden.doc_creden_id = doc_creden_signer.doc_creden_id WHERE doc_juzmatch1.id = ".$docjuzmatch1Id." AND doc_juzmatch1.doc_creden_id is NOT NULL GROUP BY doc_creden_signer.doc_creden_signer_email) as tem";
                        $res_count_email_signer_3 = ExecuteRow($sql_count_email_signer_3);
                        $count_email_signer_3 = $res_count_email_signer_3['count'];
                        if($count_email_signer_3 <= 0){
                            $count_email_signer_3 = -1; 
                        }
                    }
                    // echo $count_email_signer_3;
                    if ($show_signer_3 == $count_email_signer_3) {
                        // check prefix_asset_code
                        $docjuzmatch3Id = '';
                        $sql_check_doc3 = "SELECT id FROM `doc_juzmatch3` WHERE buyer_booking_asset_id = ".$this->buyer_booking_asset_id->CurrentValue;
                        $res_check_doc3 = ExecuteRow($sql_check_doc3);

                        $docjuzmatch3Id = $res_check_doc3['id'];

                        if (!empty($res_check_doc3)) {
                            // Edit
                            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("docjuzmatch3edit/".$docjuzmatch3Id."?" . Config("TABLE_SHOW_MASTER") . "=buyer_all_booking_asset&" . GetForeignKeyUrl("fk_buyer_booking_asset_id", $this->buyer_booking_asset_id->CurrentValue) . "") . "\">" . $body . "</a>";
                            // /docjuzmatch1edit/1?showmaster=buyer_all_booking_asset&fk_buyer_booking_asset_id=2
                        } else {
                            // Add
                            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("docjuzmatch3add?" . Config("TABLE_SHOW_MASTER") . "=buyer_all_booking_asset&" . GetForeignKeyUrl("fk_buyer_booking_asset_id", $this->buyer_booking_asset_id->CurrentValue) . "") . "\">" . $body . "</a>";
                            // /docjuzmatch1add?showmaster=buyer_all_booking_asset&fk_buyer_booking_asset_id=2
                        }
                    }else{
                        $body = "";   
                    }
                } else {
                    $body = "";   
                }
            }
            $links = "";
            $detailPage = Container("DocJuzmatch3Grid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'buyer_all_booking_asset')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=doc_juzmatch3");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "doc_juzmatch3";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'buyer_all_booking_asset')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=doc_juzmatch3");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "doc_juzmatch3";
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
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->buyer_booking_asset_id->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
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
            $option->add("asset_id", $this->createColumnOption("asset_id"));
            $option->add("member_id", $this->createColumnOption("member_id"));
            $option->add("booking_price", $this->createColumnOption("booking_price"));
            $option->add("pay_number", $this->createColumnOption("pay_number"));
            $option->add("status_payment", $this->createColumnOption("status_payment"));
            $option->add("date_booking", $this->createColumnOption("date_booking"));
            $option->add("date_payment", $this->createColumnOption("date_payment"));
            $option->add("due_date", $this->createColumnOption("due_date"));
            $option->add("status_expire", $this->createColumnOption("status_expire"));
            $option->add("status_expire_reason", $this->createColumnOption("status_expire_reason"));
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fbuyer_all_booking_assetsrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fbuyer_all_booking_assetsrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fbuyer_all_booking_assetlist"' . $listaction->toDataAttrs() . '>' . $icon . '</button>';
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

        // buyer_booking_asset_id
        if ($this->buyer_booking_asset_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->buyer_booking_asset_id->AdvancedSearch->SearchValue != "" || $this->buyer_booking_asset_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // member_id
        if ($this->member_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->member_id->AdvancedSearch->SearchValue != "" || $this->member_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // booking_price
        if ($this->booking_price->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->booking_price->AdvancedSearch->SearchValue != "" || $this->booking_price->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // pay_number
        if ($this->pay_number->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->pay_number->AdvancedSearch->SearchValue != "" || $this->pay_number->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // status_payment
        if ($this->status_payment->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->status_payment->AdvancedSearch->SearchValue != "" || $this->status_payment->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // date_booking
        if ($this->date_booking->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->date_booking->AdvancedSearch->SearchValue != "" || $this->date_booking->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // date_payment
        if ($this->date_payment->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->date_payment->AdvancedSearch->SearchValue != "" || $this->date_payment->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // status_expire
        if ($this->status_expire->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->status_expire->AdvancedSearch->SearchValue != "" || $this->status_expire->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // status_expire_reason
        if ($this->status_expire_reason->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->status_expire_reason->AdvancedSearch->SearchValue != "" || $this->status_expire_reason->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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
        $this->buyer_booking_asset_id->setDbValue($row['buyer_booking_asset_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->booking_price->setDbValue($row['booking_price']);
        $this->pay_number->setDbValue($row['pay_number']);
        $this->status_payment->setDbValue($row['status_payment']);
        $this->date_booking->setDbValue($row['date_booking']);
        $this->date_payment->setDbValue($row['date_payment']);
        $this->due_date->setDbValue($row['due_date']);
        $this->status_expire->setDbValue($row['status_expire']);
        $this->status_expire_reason->setDbValue($row['status_expire_reason']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->type->setDbValue($row['type']);
        $this->transaction_datetime->setDbValue($row['transaction_datetime']);
        $this->payment_scheme->setDbValue($row['payment_scheme']);
        $this->transaction_ref->setDbValue($row['transaction_ref']);
        $this->channel_response_desc->setDbValue($row['channel_response_desc']);
        $this->res_status->setDbValue($row['res_status']);
        $this->res_referenceNo->setDbValue($row['res_referenceNo']);
        $this->res_paidAgent->setDbValue($row['res_paidAgent']);
        $this->res_paidChannel->setDbValue($row['res_paidChannel']);
        $this->res_maskedPan->setDbValue($row['res_maskedPan']);
        $this->receipt_status->setDbValue($row['receipt_status']);
        $this->is_email->setDbValue($row['is_email']);
        $this->authorize_url->setDbValue($row['authorize_url']);
        $this->amount_net->setDbValue($row['amount_net']);
        $this->amount_cust_fee->setDbValue($row['amount_cust_fee']);
        $this->count_show_signer_3->setDbValue($row['count_show_signer_3']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['buyer_booking_asset_id'] = null;
        $row['asset_id'] = null;
        $row['member_id'] = null;
        $row['booking_price'] = null;
        $row['pay_number'] = null;
        $row['status_payment'] = null;
        $row['date_booking'] = null;
        $row['date_payment'] = null;
        $row['due_date'] = null;
        $row['status_expire'] = null;
        $row['status_expire_reason'] = null;
        $row['cdate'] = null;
        $row['cuser'] = null;
        $row['cip'] = null;
        $row['udate'] = null;
        $row['uuser'] = null;
        $row['uip'] = null;
        $row['type'] = null;
        $row['transaction_datetime'] = null;
        $row['payment_scheme'] = null;
        $row['transaction_ref'] = null;
        $row['channel_response_desc'] = null;
        $row['res_status'] = null;
        $row['res_referenceNo'] = null;
        $row['res_paidAgent'] = null;
        $row['res_paidChannel'] = null;
        $row['res_maskedPan'] = null;
        $row['receipt_status'] = null;
        $row['is_email'] = null;
        $row['authorize_url'] = null;
        $row['amount_net'] = null;
        $row['amount_cust_fee'] = null;
        $row['count_show_signer_3'] = null;
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

        // buyer_booking_asset_id
        $this->buyer_booking_asset_id->CellCssStyle = "white-space: nowrap;";

        // asset_id

        // member_id

        // booking_price

        // pay_number

        // status_payment

        // date_booking

        // date_payment

        // due_date

        // status_expire

        // status_expire_reason

        // cdate
        $this->cdate->CellCssStyle = "white-space: nowrap;";

        // cuser
        $this->cuser->CellCssStyle = "white-space: nowrap;";

        // cip
        $this->cip->CellCssStyle = "white-space: nowrap;";

        // udate
        $this->udate->CellCssStyle = "white-space: nowrap;";

        // uuser
        $this->uuser->CellCssStyle = "white-space: nowrap;";

        // uip
        $this->uip->CellCssStyle = "white-space: nowrap;";

        // type
        $this->type->CellCssStyle = "white-space: nowrap;";

        // transaction_datetime
        $this->transaction_datetime->CellCssStyle = "white-space: nowrap;";

        // payment_scheme
        $this->payment_scheme->CellCssStyle = "white-space: nowrap;";

        // transaction_ref
        $this->transaction_ref->CellCssStyle = "white-space: nowrap;";

        // channel_response_desc
        $this->channel_response_desc->CellCssStyle = "white-space: nowrap;";

        // res_status
        $this->res_status->CellCssStyle = "white-space: nowrap;";

        // res_referenceNo
        $this->res_referenceNo->CellCssStyle = "white-space: nowrap;";

        // res_paidAgent
        $this->res_paidAgent->CellCssStyle = "white-space: nowrap;";

        // res_paidChannel
        $this->res_paidChannel->CellCssStyle = "white-space: nowrap;";

        // res_maskedPan
        $this->res_maskedPan->CellCssStyle = "white-space: nowrap;";

        // receipt_status
        $this->receipt_status->CellCssStyle = "white-space: nowrap;";

        // is_email
        $this->is_email->CellCssStyle = "white-space: nowrap;";

        // authorize_url
        $this->authorize_url->CellCssStyle = "white-space: nowrap;";

        // amount_net
        $this->amount_net->CellCssStyle = "white-space: nowrap;";

        // amount_cust_fee
        $this->amount_cust_fee->CellCssStyle = "white-space: nowrap;";

        // count_show_signer_3
        $this->count_show_signer_3->CellCssStyle = "white-space: nowrap;";

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

            // booking_price
            $this->booking_price->ViewValue = $this->booking_price->CurrentValue;
            $this->booking_price->ViewValue = FormatNumber($this->booking_price->ViewValue, $this->booking_price->formatPattern());
            $this->booking_price->ViewCustomAttributes = "";

            // pay_number
            $this->pay_number->ViewValue = $this->pay_number->CurrentValue;
            $this->pay_number->ViewCustomAttributes = "";

            // status_payment
            if (strval($this->status_payment->CurrentValue) != "") {
                $this->status_payment->ViewValue = $this->status_payment->optionCaption($this->status_payment->CurrentValue);
            } else {
                $this->status_payment->ViewValue = null;
            }
            $this->status_payment->ViewCustomAttributes = "";

            // date_booking
            $this->date_booking->ViewValue = $this->date_booking->CurrentValue;
            $this->date_booking->ViewValue = FormatDateTime($this->date_booking->ViewValue, $this->date_booking->formatPattern());
            $this->date_booking->ViewCustomAttributes = "";

            // date_payment
            $this->date_payment->ViewValue = $this->date_payment->CurrentValue;
            $this->date_payment->ViewValue = FormatDateTime($this->date_payment->ViewValue, $this->date_payment->formatPattern());
            $this->date_payment->ViewCustomAttributes = "";

            // due_date
            $this->due_date->ViewValue = $this->due_date->CurrentValue;
            $this->due_date->ViewValue = FormatDateTime($this->due_date->ViewValue, $this->due_date->formatPattern());
            $this->due_date->ViewCustomAttributes = "";

            // status_expire
            if (strval($this->status_expire->CurrentValue) != "") {
                $this->status_expire->ViewValue = $this->status_expire->optionCaption($this->status_expire->CurrentValue);
            } else {
                $this->status_expire->ViewValue = null;
            }
            $this->status_expire->ViewCustomAttributes = "";

            // status_expire_reason
            $this->status_expire_reason->ViewValue = $this->status_expire_reason->CurrentValue;
            $this->status_expire_reason->ViewCustomAttributes = "";

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";
            $this->asset_id->TooltipValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // booking_price
            $this->booking_price->LinkCustomAttributes = "";
            $this->booking_price->HrefValue = "";
            $this->booking_price->TooltipValue = "";

            // pay_number
            $this->pay_number->LinkCustomAttributes = "";
            $this->pay_number->HrefValue = "";
            $this->pay_number->TooltipValue = "";
            if (!$this->isExport()) {
                $this->pay_number->ViewValue = $this->highlightValue($this->pay_number);
            }

            // status_payment
            $this->status_payment->LinkCustomAttributes = "";
            $this->status_payment->HrefValue = "";
            $this->status_payment->TooltipValue = "";

            // date_booking
            $this->date_booking->LinkCustomAttributes = "";
            $this->date_booking->HrefValue = "";
            $this->date_booking->TooltipValue = "";

            // date_payment
            $this->date_payment->LinkCustomAttributes = "";
            $this->date_payment->HrefValue = "";
            $this->date_payment->TooltipValue = "";

            // due_date
            $this->due_date->LinkCustomAttributes = "";
            $this->due_date->HrefValue = "";
            $this->due_date->TooltipValue = "";

            // status_expire
            $this->status_expire->LinkCustomAttributes = "";
            $this->status_expire->HrefValue = "";
            $this->status_expire->TooltipValue = "";

            // status_expire_reason
            $this->status_expire_reason->LinkCustomAttributes = "";
            $this->status_expire_reason->HrefValue = "";
            $this->status_expire_reason->TooltipValue = "";
            if (!$this->isExport()) {
                $this->status_expire_reason->ViewValue = $this->highlightValue($this->status_expire_reason);
            }
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
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

            // booking_price
            $this->booking_price->setupEditAttributes();
            $this->booking_price->EditCustomAttributes = "";
            $this->booking_price->EditValue = HtmlEncode($this->booking_price->AdvancedSearch->SearchValue);
            $this->booking_price->PlaceHolder = RemoveHtml($this->booking_price->caption());

            // pay_number
            $this->pay_number->setupEditAttributes();
            $this->pay_number->EditCustomAttributes = "";
            if (!$this->pay_number->Raw) {
                $this->pay_number->AdvancedSearch->SearchValue = HtmlDecode($this->pay_number->AdvancedSearch->SearchValue);
            }
            $this->pay_number->EditValue = HtmlEncode($this->pay_number->AdvancedSearch->SearchValue);
            $this->pay_number->PlaceHolder = RemoveHtml($this->pay_number->caption());

            // status_payment
            $this->status_payment->setupEditAttributes();
            $this->status_payment->EditCustomAttributes = "";
            $this->status_payment->EditValue = $this->status_payment->options(true);
            $this->status_payment->PlaceHolder = RemoveHtml($this->status_payment->caption());

            // date_booking
            $this->date_booking->setupEditAttributes();
            $this->date_booking->EditCustomAttributes = "";
            $this->date_booking->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->date_booking->AdvancedSearch->SearchValue, $this->date_booking->formatPattern()), $this->date_booking->formatPattern()));
            $this->date_booking->PlaceHolder = RemoveHtml($this->date_booking->caption());
            $this->date_booking->setupEditAttributes();
            $this->date_booking->EditCustomAttributes = "";
            $this->date_booking->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->date_booking->AdvancedSearch->SearchValue2, $this->date_booking->formatPattern()), $this->date_booking->formatPattern()));
            $this->date_booking->PlaceHolder = RemoveHtml($this->date_booking->caption());

            // date_payment
            $this->date_payment->setupEditAttributes();
            $this->date_payment->EditCustomAttributes = "";
            $this->date_payment->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->date_payment->AdvancedSearch->SearchValue, $this->date_payment->formatPattern()), $this->date_payment->formatPattern()));
            $this->date_payment->PlaceHolder = RemoveHtml($this->date_payment->caption());
            $this->date_payment->setupEditAttributes();
            $this->date_payment->EditCustomAttributes = "";
            $this->date_payment->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->date_payment->AdvancedSearch->SearchValue2, $this->date_payment->formatPattern()), $this->date_payment->formatPattern()));
            $this->date_payment->PlaceHolder = RemoveHtml($this->date_payment->caption());

            // due_date
            $this->due_date->setupEditAttributes();
            $this->due_date->EditCustomAttributes = "";
            $this->due_date->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->due_date->AdvancedSearch->SearchValue, $this->due_date->formatPattern()), $this->due_date->formatPattern()));
            $this->due_date->PlaceHolder = RemoveHtml($this->due_date->caption());
            $this->due_date->setupEditAttributes();
            $this->due_date->EditCustomAttributes = "";
            $this->due_date->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->due_date->AdvancedSearch->SearchValue2, $this->due_date->formatPattern()), $this->due_date->formatPattern()));
            $this->due_date->PlaceHolder = RemoveHtml($this->due_date->caption());

            // status_expire
            $this->status_expire->EditCustomAttributes = "";
            $this->status_expire->EditValue = $this->status_expire->options(false);
            $this->status_expire->PlaceHolder = RemoveHtml($this->status_expire->caption());

            // status_expire_reason
            $this->status_expire_reason->setupEditAttributes();
            $this->status_expire_reason->EditCustomAttributes = "";
            if (!$this->status_expire_reason->Raw) {
                $this->status_expire_reason->AdvancedSearch->SearchValue = HtmlDecode($this->status_expire_reason->AdvancedSearch->SearchValue);
            }
            $this->status_expire_reason->EditValue = HtmlEncode($this->status_expire_reason->AdvancedSearch->SearchValue);
            $this->status_expire_reason->PlaceHolder = RemoveHtml($this->status_expire_reason->caption());
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
        if (!CheckNumber($this->booking_price->AdvancedSearch->SearchValue)) {
            $this->booking_price->addErrorMessage($this->booking_price->getErrorMessage(false));
        }
        if (!CheckDate($this->date_booking->AdvancedSearch->SearchValue, $this->date_booking->formatPattern())) {
            $this->date_booking->addErrorMessage($this->date_booking->getErrorMessage(false));
        }
        if (!CheckDate($this->date_booking->AdvancedSearch->SearchValue2, $this->date_booking->formatPattern())) {
            $this->date_booking->addErrorMessage($this->date_booking->getErrorMessage(false));
        }
        if (!CheckDate($this->date_payment->AdvancedSearch->SearchValue, $this->date_payment->formatPattern())) {
            $this->date_payment->addErrorMessage($this->date_payment->getErrorMessage(false));
        }
        if (!CheckDate($this->date_payment->AdvancedSearch->SearchValue2, $this->date_payment->formatPattern())) {
            $this->date_payment->addErrorMessage($this->date_payment->getErrorMessage(false));
        }
        if (!CheckDate($this->due_date->AdvancedSearch->SearchValue, $this->due_date->formatPattern())) {
            $this->due_date->addErrorMessage($this->due_date->getErrorMessage(false));
        }
        if (!CheckDate($this->due_date->AdvancedSearch->SearchValue2, $this->due_date->formatPattern())) {
            $this->due_date->addErrorMessage($this->due_date->getErrorMessage(false));
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
        $this->buyer_booking_asset_id->AdvancedSearch->load();
        $this->asset_id->AdvancedSearch->load();
        $this->member_id->AdvancedSearch->load();
        $this->booking_price->AdvancedSearch->load();
        $this->pay_number->AdvancedSearch->load();
        $this->status_payment->AdvancedSearch->load();
        $this->date_booking->AdvancedSearch->load();
        $this->date_payment->AdvancedSearch->load();
        $this->due_date->AdvancedSearch->load();
        $this->status_expire->AdvancedSearch->load();
        $this->status_expire_reason->AdvancedSearch->load();
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
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" form=\"fbuyer_all_booking_assetlist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" form=\"fbuyer_all_booking_assetlist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" form=\"fbuyer_all_booking_assetlist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" form="fbuyer_all_booking_assetlist" data-ew-action="email" data-hdr="' . $Language->phrase("ExportToEmailText") . '" data-sel="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fbuyer_all_booking_assetsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Search highlight button
        $item = &$this->SearchOptions->add("searchhighlight");
        $item->Body = "<a class=\"btn btn-default ew-highlight active\" role=\"button\" title=\"" . $Language->phrase("Highlight") . "\" data-caption=\"" . $Language->phrase("Highlight") . "\" data-ew-action=\"highlight\" data-form=\"fbuyer_all_booking_assetsrch\" data-name=\"" . $this->highlightName() . "\">" . $Language->phrase("HighlightBtn") . "</a>";
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
        return $this->asset_id->Visible || $this->member_id->Visible || $this->booking_price->Visible || $this->pay_number->Visible || $this->status_payment->Visible || $this->date_booking->Visible || $this->date_payment->Visible || $this->due_date->Visible || $this->status_expire->Visible || $this->status_expire_reason->Visible;
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
                case "x_asset_id":
                    $conn = Conn("DB");
                    break;
                case "x_member_id":
                    $conn = Conn("DB");
                    $lookupFilter = function () {
                        return "`isactive` = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_status_payment":
                    break;
                case "x_status_expire":
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
