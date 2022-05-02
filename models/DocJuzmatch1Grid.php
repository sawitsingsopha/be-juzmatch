<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class DocJuzmatch1Grid extends DocJuzmatch1
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'doc_juzmatch1';

    // Page object name
    public $PageObjName = "DocJuzmatch1Grid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fdoc_juzmatch1grid";
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

        // Table object (doc_juzmatch1)
        if (!isset($GLOBALS["doc_juzmatch1"]) || get_class($GLOBALS["doc_juzmatch1"]) == PROJECT_NAMESPACE . "doc_juzmatch1") {
            $GLOBALS["doc_juzmatch1"] = &$this;
        }
        $this->AddUrl = "docjuzmatch1add";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'doc_juzmatch1');
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
                $tbl = Container("doc_juzmatch1");
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
		        $this->file_idcard->OldUploadPath = "/upload/";
		        $this->file_idcard->UploadPath = $this->file_idcard->OldUploadPath;
		        $this->file_house_regis->OldUploadPath = "/upload/";
		        $this->file_house_regis->UploadPath = $this->file_house_regis->OldUploadPath;
		        $this->file_titledeed->OldUploadPath = "/upload/";
		        $this->file_titledeed->UploadPath = $this->file_titledeed->OldUploadPath;
		        $this->file_other->OldUploadPath = "/upload/";
		        $this->file_other->UploadPath = $this->file_other->OldUploadPath;
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
        if ($this->isAddOrEdit()) {
            $this->document_date->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->doc_date->Visible = false;
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
        $this->id->Visible = false;
        $this->document_date->setVisibility();
        $this->asset_code->setVisibility();
        $this->asset_deed->setVisibility();
        $this->asset_project->setVisibility();
        $this->asset_area->setVisibility();
        $this->buyer_name->Visible = false;
        $this->buyer_lname->setVisibility();
        $this->buyer_email->setVisibility();
        $this->buyer_idcard->setVisibility();
        $this->buyer_homeno->setVisibility();
        $this->buyer_witness_name->Visible = false;
        $this->buyer_witness_lname->setVisibility();
        $this->buyer_witness_email->setVisibility();
        $this->juzmatch_authority_name->Visible = false;
        $this->juzmatch_authority_lname->setVisibility();
        $this->juzmatch_authority_email->setVisibility();
        $this->juzmatch_authority_witness_name->Visible = false;
        $this->juzmatch_authority_witness_lname->setVisibility();
        $this->juzmatch_authority_witness_email->setVisibility();
        $this->juzmatch_authority2_name->setVisibility();
        $this->juzmatch_authority2_lname->setVisibility();
        $this->juzmatch_authority2_email->setVisibility();
        $this->company_seal_name->setVisibility();
        $this->company_seal_email->setVisibility();
        $this->service_price->setVisibility();
        $this->service_price_txt->setVisibility();
        $this->first_down->setVisibility();
        $this->first_down_txt->setVisibility();
        $this->second_down->setVisibility();
        $this->second_down_txt->setVisibility();
        $this->contact_address->setVisibility();
        $this->contact_address2->setVisibility();
        $this->contact_email->setVisibility();
        $this->contact_lineid->setVisibility();
        $this->contact_phone->setVisibility();
        $this->file_idcard->Visible = false;
        $this->file_house_regis->Visible = false;
        $this->file_titledeed->Visible = false;
        $this->file_other->Visible = false;
        $this->attach_file->Visible = false;
        $this->status->Visible = false;
        $this->doc_date->Visible = false;
        $this->buyer_booking_asset_id->Visible = false;
        $this->doc_creden_id->Visible = false;
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
        $this->setupLookupOptions($this->status);

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
        $this->service_price->FormValue = ""; // Clear form value
        $this->first_down->FormValue = ""; // Clear form value
        $this->second_down->FormValue = ""; // Clear form value
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
                    $key .= $this->id->CurrentValue;

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
        if ($CurrentForm->hasValue("x_asset_code") && $CurrentForm->hasValue("o_asset_code") && $this->asset_code->CurrentValue != $this->asset_code->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_asset_deed") && $CurrentForm->hasValue("o_asset_deed") && $this->asset_deed->CurrentValue != $this->asset_deed->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_asset_project") && $CurrentForm->hasValue("o_asset_project") && $this->asset_project->CurrentValue != $this->asset_project->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_asset_area") && $CurrentForm->hasValue("o_asset_area") && $this->asset_area->CurrentValue != $this->asset_area->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_buyer_lname") && $CurrentForm->hasValue("o_buyer_lname") && $this->buyer_lname->CurrentValue != $this->buyer_lname->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_buyer_email") && $CurrentForm->hasValue("o_buyer_email") && $this->buyer_email->CurrentValue != $this->buyer_email->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_buyer_idcard") && $CurrentForm->hasValue("o_buyer_idcard") && $this->buyer_idcard->CurrentValue != $this->buyer_idcard->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_buyer_homeno") && $CurrentForm->hasValue("o_buyer_homeno") && $this->buyer_homeno->CurrentValue != $this->buyer_homeno->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_buyer_witness_lname") && $CurrentForm->hasValue("o_buyer_witness_lname") && $this->buyer_witness_lname->CurrentValue != $this->buyer_witness_lname->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_buyer_witness_email") && $CurrentForm->hasValue("o_buyer_witness_email") && $this->buyer_witness_email->CurrentValue != $this->buyer_witness_email->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_juzmatch_authority_lname") && $CurrentForm->hasValue("o_juzmatch_authority_lname") && $this->juzmatch_authority_lname->CurrentValue != $this->juzmatch_authority_lname->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_juzmatch_authority_email") && $CurrentForm->hasValue("o_juzmatch_authority_email") && $this->juzmatch_authority_email->CurrentValue != $this->juzmatch_authority_email->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_juzmatch_authority_witness_lname") && $CurrentForm->hasValue("o_juzmatch_authority_witness_lname") && $this->juzmatch_authority_witness_lname->CurrentValue != $this->juzmatch_authority_witness_lname->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_juzmatch_authority_witness_email") && $CurrentForm->hasValue("o_juzmatch_authority_witness_email") && $this->juzmatch_authority_witness_email->CurrentValue != $this->juzmatch_authority_witness_email->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_juzmatch_authority2_name") && $CurrentForm->hasValue("o_juzmatch_authority2_name") && $this->juzmatch_authority2_name->CurrentValue != $this->juzmatch_authority2_name->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_juzmatch_authority2_lname") && $CurrentForm->hasValue("o_juzmatch_authority2_lname") && $this->juzmatch_authority2_lname->CurrentValue != $this->juzmatch_authority2_lname->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_juzmatch_authority2_email") && $CurrentForm->hasValue("o_juzmatch_authority2_email") && $this->juzmatch_authority2_email->CurrentValue != $this->juzmatch_authority2_email->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_company_seal_name") && $CurrentForm->hasValue("o_company_seal_name") && $this->company_seal_name->CurrentValue != $this->company_seal_name->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_company_seal_email") && $CurrentForm->hasValue("o_company_seal_email") && $this->company_seal_email->CurrentValue != $this->company_seal_email->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_service_price") && $CurrentForm->hasValue("o_service_price") && $this->service_price->CurrentValue != $this->service_price->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_service_price_txt") && $CurrentForm->hasValue("o_service_price_txt") && $this->service_price_txt->CurrentValue != $this->service_price_txt->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_first_down") && $CurrentForm->hasValue("o_first_down") && $this->first_down->CurrentValue != $this->first_down->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_first_down_txt") && $CurrentForm->hasValue("o_first_down_txt") && $this->first_down_txt->CurrentValue != $this->first_down_txt->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_second_down") && $CurrentForm->hasValue("o_second_down") && $this->second_down->CurrentValue != $this->second_down->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_second_down_txt") && $CurrentForm->hasValue("o_second_down_txt") && $this->second_down_txt->CurrentValue != $this->second_down_txt->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_contact_address") && $CurrentForm->hasValue("o_contact_address") && $this->contact_address->CurrentValue != $this->contact_address->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_contact_address2") && $CurrentForm->hasValue("o_contact_address2") && $this->contact_address2->CurrentValue != $this->contact_address2->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_contact_email") && $CurrentForm->hasValue("o_contact_email") && $this->contact_email->CurrentValue != $this->contact_email->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_contact_lineid") && $CurrentForm->hasValue("o_contact_lineid") && $this->contact_lineid->CurrentValue != $this->contact_lineid->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_contact_phone") && $CurrentForm->hasValue("o_contact_phone") && $this->contact_phone->CurrentValue != $this->contact_phone->OldValue) {
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
        $this->document_date->clearErrorMessage();
        $this->asset_code->clearErrorMessage();
        $this->asset_deed->clearErrorMessage();
        $this->asset_project->clearErrorMessage();
        $this->asset_area->clearErrorMessage();
        $this->buyer_lname->clearErrorMessage();
        $this->buyer_email->clearErrorMessage();
        $this->buyer_idcard->clearErrorMessage();
        $this->buyer_homeno->clearErrorMessage();
        $this->buyer_witness_lname->clearErrorMessage();
        $this->buyer_witness_email->clearErrorMessage();
        $this->juzmatch_authority_lname->clearErrorMessage();
        $this->juzmatch_authority_email->clearErrorMessage();
        $this->juzmatch_authority_witness_lname->clearErrorMessage();
        $this->juzmatch_authority_witness_email->clearErrorMessage();
        $this->juzmatch_authority2_name->clearErrorMessage();
        $this->juzmatch_authority2_lname->clearErrorMessage();
        $this->juzmatch_authority2_email->clearErrorMessage();
        $this->company_seal_name->clearErrorMessage();
        $this->company_seal_email->clearErrorMessage();
        $this->service_price->clearErrorMessage();
        $this->service_price_txt->clearErrorMessage();
        $this->first_down->clearErrorMessage();
        $this->first_down_txt->clearErrorMessage();
        $this->second_down->clearErrorMessage();
        $this->second_down_txt->clearErrorMessage();
        $this->contact_address->clearErrorMessage();
        $this->contact_address2->clearErrorMessage();
        $this->contact_email->clearErrorMessage();
        $this->contact_lineid->clearErrorMessage();
        $this->contact_phone->clearErrorMessage();
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
                        $this->buyer_booking_asset_id->setSessionValue("");
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
        // Preview extension
        $this->ListOptions->hideDetailItemsForDropDown(); // Hide detail items for dropdown if necessary
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
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->document_date->CurrentValue = null;
        $this->document_date->OldValue = $this->document_date->CurrentValue;
        $this->asset_code->CurrentValue = null;
        $this->asset_code->OldValue = $this->asset_code->CurrentValue;
        $this->asset_deed->CurrentValue = null;
        $this->asset_deed->OldValue = $this->asset_deed->CurrentValue;
        $this->asset_project->CurrentValue = null;
        $this->asset_project->OldValue = $this->asset_project->CurrentValue;
        $this->asset_area->CurrentValue = null;
        $this->asset_area->OldValue = $this->asset_area->CurrentValue;
        $this->buyer_name->CurrentValue = null;
        $this->buyer_name->OldValue = $this->buyer_name->CurrentValue;
        $this->buyer_lname->CurrentValue = null;
        $this->buyer_lname->OldValue = $this->buyer_lname->CurrentValue;
        $this->buyer_email->CurrentValue = null;
        $this->buyer_email->OldValue = $this->buyer_email->CurrentValue;
        $this->buyer_idcard->CurrentValue = null;
        $this->buyer_idcard->OldValue = $this->buyer_idcard->CurrentValue;
        $this->buyer_homeno->CurrentValue = null;
        $this->buyer_homeno->OldValue = $this->buyer_homeno->CurrentValue;
        $this->buyer_witness_name->CurrentValue = null;
        $this->buyer_witness_name->OldValue = $this->buyer_witness_name->CurrentValue;
        $this->buyer_witness_lname->CurrentValue = null;
        $this->buyer_witness_lname->OldValue = $this->buyer_witness_lname->CurrentValue;
        $this->buyer_witness_email->CurrentValue = null;
        $this->buyer_witness_email->OldValue = $this->buyer_witness_email->CurrentValue;
        $this->juzmatch_authority_name->CurrentValue = null;
        $this->juzmatch_authority_name->OldValue = $this->juzmatch_authority_name->CurrentValue;
        $this->juzmatch_authority_lname->CurrentValue = null;
        $this->juzmatch_authority_lname->OldValue = $this->juzmatch_authority_lname->CurrentValue;
        $this->juzmatch_authority_email->CurrentValue = null;
        $this->juzmatch_authority_email->OldValue = $this->juzmatch_authority_email->CurrentValue;
        $this->juzmatch_authority_witness_name->CurrentValue = null;
        $this->juzmatch_authority_witness_name->OldValue = $this->juzmatch_authority_witness_name->CurrentValue;
        $this->juzmatch_authority_witness_lname->CurrentValue = null;
        $this->juzmatch_authority_witness_lname->OldValue = $this->juzmatch_authority_witness_lname->CurrentValue;
        $this->juzmatch_authority_witness_email->CurrentValue = null;
        $this->juzmatch_authority_witness_email->OldValue = $this->juzmatch_authority_witness_email->CurrentValue;
        $this->juzmatch_authority2_name->CurrentValue = null;
        $this->juzmatch_authority2_name->OldValue = $this->juzmatch_authority2_name->CurrentValue;
        $this->juzmatch_authority2_lname->CurrentValue = null;
        $this->juzmatch_authority2_lname->OldValue = $this->juzmatch_authority2_lname->CurrentValue;
        $this->juzmatch_authority2_email->CurrentValue = null;
        $this->juzmatch_authority2_email->OldValue = $this->juzmatch_authority2_email->CurrentValue;
        $this->company_seal_name->CurrentValue = null;
        $this->company_seal_name->OldValue = $this->company_seal_name->CurrentValue;
        $this->company_seal_email->CurrentValue = null;
        $this->company_seal_email->OldValue = $this->company_seal_email->CurrentValue;
        $this->service_price->CurrentValue = null;
        $this->service_price->OldValue = $this->service_price->CurrentValue;
        $this->service_price_txt->CurrentValue = null;
        $this->service_price_txt->OldValue = $this->service_price_txt->CurrentValue;
        $this->first_down->CurrentValue = null;
        $this->first_down->OldValue = $this->first_down->CurrentValue;
        $this->first_down_txt->CurrentValue = null;
        $this->first_down_txt->OldValue = $this->first_down_txt->CurrentValue;
        $this->second_down->CurrentValue = null;
        $this->second_down->OldValue = $this->second_down->CurrentValue;
        $this->second_down_txt->CurrentValue = null;
        $this->second_down_txt->OldValue = $this->second_down_txt->CurrentValue;
        $this->contact_address->CurrentValue = null;
        $this->contact_address->OldValue = $this->contact_address->CurrentValue;
        $this->contact_address2->CurrentValue = null;
        $this->contact_address2->OldValue = $this->contact_address2->CurrentValue;
        $this->contact_email->CurrentValue = null;
        $this->contact_email->OldValue = $this->contact_email->CurrentValue;
        $this->contact_lineid->CurrentValue = null;
        $this->contact_lineid->OldValue = $this->contact_lineid->CurrentValue;
        $this->contact_phone->CurrentValue = null;
        $this->contact_phone->OldValue = $this->contact_phone->CurrentValue;
        $this->file_idcard->Upload->DbValue = null;
        $this->file_idcard->OldValue = $this->file_idcard->Upload->DbValue;
        $this->file_idcard->Upload->Index = $this->RowIndex;
        $this->file_house_regis->Upload->DbValue = null;
        $this->file_house_regis->OldValue = $this->file_house_regis->Upload->DbValue;
        $this->file_house_regis->Upload->Index = $this->RowIndex;
        $this->file_titledeed->Upload->DbValue = null;
        $this->file_titledeed->OldValue = $this->file_titledeed->Upload->DbValue;
        $this->file_titledeed->Upload->Index = $this->RowIndex;
        $this->file_other->Upload->DbValue = null;
        $this->file_other->OldValue = $this->file_other->Upload->DbValue;
        $this->file_other->Upload->Index = $this->RowIndex;
        $this->attach_file->CurrentValue = null;
        $this->attach_file->OldValue = $this->attach_file->CurrentValue;
        $this->status->CurrentValue = 0;
        $this->status->OldValue = $this->status->CurrentValue;
        $this->doc_date->CurrentValue = null;
        $this->doc_date->OldValue = $this->doc_date->CurrentValue;
        $this->buyer_booking_asset_id->CurrentValue = null;
        $this->buyer_booking_asset_id->OldValue = $this->buyer_booking_asset_id->CurrentValue;
        $this->doc_creden_id->CurrentValue = null;
        $this->doc_creden_id->OldValue = $this->doc_creden_id->CurrentValue;
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

        // Check field name 'document_date' first before field var 'x_document_date'
        $val = $CurrentForm->hasValue("document_date") ? $CurrentForm->getValue("document_date") : $CurrentForm->getValue("x_document_date");
        if (!$this->document_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->document_date->Visible = false; // Disable update for API request
            } else {
                $this->document_date->setFormValue($val);
            }
            $this->document_date->CurrentValue = UnFormatDateTime($this->document_date->CurrentValue, $this->document_date->formatPattern());
        }
        if ($CurrentForm->hasValue("o_document_date")) {
            $this->document_date->setOldValue($CurrentForm->getValue("o_document_date"));
        }

        // Check field name 'asset_code' first before field var 'x_asset_code'
        $val = $CurrentForm->hasValue("asset_code") ? $CurrentForm->getValue("asset_code") : $CurrentForm->getValue("x_asset_code");
        if (!$this->asset_code->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_code->Visible = false; // Disable update for API request
            } else {
                $this->asset_code->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_asset_code")) {
            $this->asset_code->setOldValue($CurrentForm->getValue("o_asset_code"));
        }

        // Check field name 'asset_deed' first before field var 'x_asset_deed'
        $val = $CurrentForm->hasValue("asset_deed") ? $CurrentForm->getValue("asset_deed") : $CurrentForm->getValue("x_asset_deed");
        if (!$this->asset_deed->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_deed->Visible = false; // Disable update for API request
            } else {
                $this->asset_deed->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_asset_deed")) {
            $this->asset_deed->setOldValue($CurrentForm->getValue("o_asset_deed"));
        }

        // Check field name 'asset_project' first before field var 'x_asset_project'
        $val = $CurrentForm->hasValue("asset_project") ? $CurrentForm->getValue("asset_project") : $CurrentForm->getValue("x_asset_project");
        if (!$this->asset_project->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_project->Visible = false; // Disable update for API request
            } else {
                $this->asset_project->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_asset_project")) {
            $this->asset_project->setOldValue($CurrentForm->getValue("o_asset_project"));
        }

        // Check field name 'asset_area' first before field var 'x_asset_area'
        $val = $CurrentForm->hasValue("asset_area") ? $CurrentForm->getValue("asset_area") : $CurrentForm->getValue("x_asset_area");
        if (!$this->asset_area->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_area->Visible = false; // Disable update for API request
            } else {
                $this->asset_area->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_asset_area")) {
            $this->asset_area->setOldValue($CurrentForm->getValue("o_asset_area"));
        }

        // Check field name 'buyer_lname' first before field var 'x_buyer_lname'
        $val = $CurrentForm->hasValue("buyer_lname") ? $CurrentForm->getValue("buyer_lname") : $CurrentForm->getValue("x_buyer_lname");
        if (!$this->buyer_lname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->buyer_lname->Visible = false; // Disable update for API request
            } else {
                $this->buyer_lname->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_buyer_lname")) {
            $this->buyer_lname->setOldValue($CurrentForm->getValue("o_buyer_lname"));
        }

        // Check field name 'buyer_email' first before field var 'x_buyer_email'
        $val = $CurrentForm->hasValue("buyer_email") ? $CurrentForm->getValue("buyer_email") : $CurrentForm->getValue("x_buyer_email");
        if (!$this->buyer_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->buyer_email->Visible = false; // Disable update for API request
            } else {
                $this->buyer_email->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_buyer_email")) {
            $this->buyer_email->setOldValue($CurrentForm->getValue("o_buyer_email"));
        }

        // Check field name 'buyer_idcard' first before field var 'x_buyer_idcard'
        $val = $CurrentForm->hasValue("buyer_idcard") ? $CurrentForm->getValue("buyer_idcard") : $CurrentForm->getValue("x_buyer_idcard");
        if (!$this->buyer_idcard->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->buyer_idcard->Visible = false; // Disable update for API request
            } else {
                $this->buyer_idcard->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_buyer_idcard")) {
            $this->buyer_idcard->setOldValue($CurrentForm->getValue("o_buyer_idcard"));
        }

        // Check field name 'buyer_homeno' first before field var 'x_buyer_homeno'
        $val = $CurrentForm->hasValue("buyer_homeno") ? $CurrentForm->getValue("buyer_homeno") : $CurrentForm->getValue("x_buyer_homeno");
        if (!$this->buyer_homeno->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->buyer_homeno->Visible = false; // Disable update for API request
            } else {
                $this->buyer_homeno->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_buyer_homeno")) {
            $this->buyer_homeno->setOldValue($CurrentForm->getValue("o_buyer_homeno"));
        }

        // Check field name 'buyer_witness_lname' first before field var 'x_buyer_witness_lname'
        $val = $CurrentForm->hasValue("buyer_witness_lname") ? $CurrentForm->getValue("buyer_witness_lname") : $CurrentForm->getValue("x_buyer_witness_lname");
        if (!$this->buyer_witness_lname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->buyer_witness_lname->Visible = false; // Disable update for API request
            } else {
                $this->buyer_witness_lname->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_buyer_witness_lname")) {
            $this->buyer_witness_lname->setOldValue($CurrentForm->getValue("o_buyer_witness_lname"));
        }

        // Check field name 'buyer_witness_email' first before field var 'x_buyer_witness_email'
        $val = $CurrentForm->hasValue("buyer_witness_email") ? $CurrentForm->getValue("buyer_witness_email") : $CurrentForm->getValue("x_buyer_witness_email");
        if (!$this->buyer_witness_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->buyer_witness_email->Visible = false; // Disable update for API request
            } else {
                $this->buyer_witness_email->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_buyer_witness_email")) {
            $this->buyer_witness_email->setOldValue($CurrentForm->getValue("o_buyer_witness_email"));
        }

        // Check field name 'juzmatch_authority_lname' first before field var 'x_juzmatch_authority_lname'
        $val = $CurrentForm->hasValue("juzmatch_authority_lname") ? $CurrentForm->getValue("juzmatch_authority_lname") : $CurrentForm->getValue("x_juzmatch_authority_lname");
        if (!$this->juzmatch_authority_lname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority_lname->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority_lname->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_juzmatch_authority_lname")) {
            $this->juzmatch_authority_lname->setOldValue($CurrentForm->getValue("o_juzmatch_authority_lname"));
        }

        // Check field name 'juzmatch_authority_email' first before field var 'x_juzmatch_authority_email'
        $val = $CurrentForm->hasValue("juzmatch_authority_email") ? $CurrentForm->getValue("juzmatch_authority_email") : $CurrentForm->getValue("x_juzmatch_authority_email");
        if (!$this->juzmatch_authority_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority_email->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority_email->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_juzmatch_authority_email")) {
            $this->juzmatch_authority_email->setOldValue($CurrentForm->getValue("o_juzmatch_authority_email"));
        }

        // Check field name 'juzmatch_authority_witness_lname' first before field var 'x_juzmatch_authority_witness_lname'
        $val = $CurrentForm->hasValue("juzmatch_authority_witness_lname") ? $CurrentForm->getValue("juzmatch_authority_witness_lname") : $CurrentForm->getValue("x_juzmatch_authority_witness_lname");
        if (!$this->juzmatch_authority_witness_lname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority_witness_lname->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority_witness_lname->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_juzmatch_authority_witness_lname")) {
            $this->juzmatch_authority_witness_lname->setOldValue($CurrentForm->getValue("o_juzmatch_authority_witness_lname"));
        }

        // Check field name 'juzmatch_authority_witness_email' first before field var 'x_juzmatch_authority_witness_email'
        $val = $CurrentForm->hasValue("juzmatch_authority_witness_email") ? $CurrentForm->getValue("juzmatch_authority_witness_email") : $CurrentForm->getValue("x_juzmatch_authority_witness_email");
        if (!$this->juzmatch_authority_witness_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority_witness_email->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority_witness_email->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_juzmatch_authority_witness_email")) {
            $this->juzmatch_authority_witness_email->setOldValue($CurrentForm->getValue("o_juzmatch_authority_witness_email"));
        }

        // Check field name 'juzmatch_authority2_name' first before field var 'x_juzmatch_authority2_name'
        $val = $CurrentForm->hasValue("juzmatch_authority2_name") ? $CurrentForm->getValue("juzmatch_authority2_name") : $CurrentForm->getValue("x_juzmatch_authority2_name");
        if (!$this->juzmatch_authority2_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority2_name->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority2_name->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_juzmatch_authority2_name")) {
            $this->juzmatch_authority2_name->setOldValue($CurrentForm->getValue("o_juzmatch_authority2_name"));
        }

        // Check field name 'juzmatch_authority2_lname' first before field var 'x_juzmatch_authority2_lname'
        $val = $CurrentForm->hasValue("juzmatch_authority2_lname") ? $CurrentForm->getValue("juzmatch_authority2_lname") : $CurrentForm->getValue("x_juzmatch_authority2_lname");
        if (!$this->juzmatch_authority2_lname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority2_lname->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority2_lname->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_juzmatch_authority2_lname")) {
            $this->juzmatch_authority2_lname->setOldValue($CurrentForm->getValue("o_juzmatch_authority2_lname"));
        }

        // Check field name 'juzmatch_authority2_email' first before field var 'x_juzmatch_authority2_email'
        $val = $CurrentForm->hasValue("juzmatch_authority2_email") ? $CurrentForm->getValue("juzmatch_authority2_email") : $CurrentForm->getValue("x_juzmatch_authority2_email");
        if (!$this->juzmatch_authority2_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority2_email->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority2_email->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_juzmatch_authority2_email")) {
            $this->juzmatch_authority2_email->setOldValue($CurrentForm->getValue("o_juzmatch_authority2_email"));
        }

        // Check field name 'company_seal_name' first before field var 'x_company_seal_name'
        $val = $CurrentForm->hasValue("company_seal_name") ? $CurrentForm->getValue("company_seal_name") : $CurrentForm->getValue("x_company_seal_name");
        if (!$this->company_seal_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->company_seal_name->Visible = false; // Disable update for API request
            } else {
                $this->company_seal_name->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_company_seal_name")) {
            $this->company_seal_name->setOldValue($CurrentForm->getValue("o_company_seal_name"));
        }

        // Check field name 'company_seal_email' first before field var 'x_company_seal_email'
        $val = $CurrentForm->hasValue("company_seal_email") ? $CurrentForm->getValue("company_seal_email") : $CurrentForm->getValue("x_company_seal_email");
        if (!$this->company_seal_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->company_seal_email->Visible = false; // Disable update for API request
            } else {
                $this->company_seal_email->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_company_seal_email")) {
            $this->company_seal_email->setOldValue($CurrentForm->getValue("o_company_seal_email"));
        }

        // Check field name 'service_price' first before field var 'x_service_price'
        $val = $CurrentForm->hasValue("service_price") ? $CurrentForm->getValue("service_price") : $CurrentForm->getValue("x_service_price");
        if (!$this->service_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->service_price->Visible = false; // Disable update for API request
            } else {
                $this->service_price->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_service_price")) {
            $this->service_price->setOldValue($CurrentForm->getValue("o_service_price"));
        }

        // Check field name 'service_price_txt' first before field var 'x_service_price_txt'
        $val = $CurrentForm->hasValue("service_price_txt") ? $CurrentForm->getValue("service_price_txt") : $CurrentForm->getValue("x_service_price_txt");
        if (!$this->service_price_txt->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->service_price_txt->Visible = false; // Disable update for API request
            } else {
                $this->service_price_txt->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_service_price_txt")) {
            $this->service_price_txt->setOldValue($CurrentForm->getValue("o_service_price_txt"));
        }

        // Check field name 'first_down' first before field var 'x_first_down'
        $val = $CurrentForm->hasValue("first_down") ? $CurrentForm->getValue("first_down") : $CurrentForm->getValue("x_first_down");
        if (!$this->first_down->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->first_down->Visible = false; // Disable update for API request
            } else {
                $this->first_down->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_first_down")) {
            $this->first_down->setOldValue($CurrentForm->getValue("o_first_down"));
        }

        // Check field name 'first_down_txt' first before field var 'x_first_down_txt'
        $val = $CurrentForm->hasValue("first_down_txt") ? $CurrentForm->getValue("first_down_txt") : $CurrentForm->getValue("x_first_down_txt");
        if (!$this->first_down_txt->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->first_down_txt->Visible = false; // Disable update for API request
            } else {
                $this->first_down_txt->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_first_down_txt")) {
            $this->first_down_txt->setOldValue($CurrentForm->getValue("o_first_down_txt"));
        }

        // Check field name 'second_down' first before field var 'x_second_down'
        $val = $CurrentForm->hasValue("second_down") ? $CurrentForm->getValue("second_down") : $CurrentForm->getValue("x_second_down");
        if (!$this->second_down->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->second_down->Visible = false; // Disable update for API request
            } else {
                $this->second_down->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_second_down")) {
            $this->second_down->setOldValue($CurrentForm->getValue("o_second_down"));
        }

        // Check field name 'second_down_txt' first before field var 'x_second_down_txt'
        $val = $CurrentForm->hasValue("second_down_txt") ? $CurrentForm->getValue("second_down_txt") : $CurrentForm->getValue("x_second_down_txt");
        if (!$this->second_down_txt->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->second_down_txt->Visible = false; // Disable update for API request
            } else {
                $this->second_down_txt->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_second_down_txt")) {
            $this->second_down_txt->setOldValue($CurrentForm->getValue("o_second_down_txt"));
        }

        // Check field name 'contact_address' first before field var 'x_contact_address'
        $val = $CurrentForm->hasValue("contact_address") ? $CurrentForm->getValue("contact_address") : $CurrentForm->getValue("x_contact_address");
        if (!$this->contact_address->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_address->Visible = false; // Disable update for API request
            } else {
                $this->contact_address->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_contact_address")) {
            $this->contact_address->setOldValue($CurrentForm->getValue("o_contact_address"));
        }

        // Check field name 'contact_address2' first before field var 'x_contact_address2'
        $val = $CurrentForm->hasValue("contact_address2") ? $CurrentForm->getValue("contact_address2") : $CurrentForm->getValue("x_contact_address2");
        if (!$this->contact_address2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_address2->Visible = false; // Disable update for API request
            } else {
                $this->contact_address2->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_contact_address2")) {
            $this->contact_address2->setOldValue($CurrentForm->getValue("o_contact_address2"));
        }

        // Check field name 'contact_email' first before field var 'x_contact_email'
        $val = $CurrentForm->hasValue("contact_email") ? $CurrentForm->getValue("contact_email") : $CurrentForm->getValue("x_contact_email");
        if (!$this->contact_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_email->Visible = false; // Disable update for API request
            } else {
                $this->contact_email->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_contact_email")) {
            $this->contact_email->setOldValue($CurrentForm->getValue("o_contact_email"));
        }

        // Check field name 'contact_lineid' first before field var 'x_contact_lineid'
        $val = $CurrentForm->hasValue("contact_lineid") ? $CurrentForm->getValue("contact_lineid") : $CurrentForm->getValue("x_contact_lineid");
        if (!$this->contact_lineid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_lineid->Visible = false; // Disable update for API request
            } else {
                $this->contact_lineid->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_contact_lineid")) {
            $this->contact_lineid->setOldValue($CurrentForm->getValue("o_contact_lineid"));
        }

        // Check field name 'contact_phone' first before field var 'x_contact_phone'
        $val = $CurrentForm->hasValue("contact_phone") ? $CurrentForm->getValue("contact_phone") : $CurrentForm->getValue("x_contact_phone");
        if (!$this->contact_phone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_phone->Visible = false; // Disable update for API request
            } else {
                $this->contact_phone->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_contact_phone")) {
            $this->contact_phone->setOldValue($CurrentForm->getValue("o_contact_phone"));
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

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id->CurrentValue = $this->id->FormValue;
        }
        $this->document_date->CurrentValue = $this->document_date->FormValue;
        $this->document_date->CurrentValue = UnFormatDateTime($this->document_date->CurrentValue, $this->document_date->formatPattern());
        $this->asset_code->CurrentValue = $this->asset_code->FormValue;
        $this->asset_deed->CurrentValue = $this->asset_deed->FormValue;
        $this->asset_project->CurrentValue = $this->asset_project->FormValue;
        $this->asset_area->CurrentValue = $this->asset_area->FormValue;
        $this->buyer_lname->CurrentValue = $this->buyer_lname->FormValue;
        $this->buyer_email->CurrentValue = $this->buyer_email->FormValue;
        $this->buyer_idcard->CurrentValue = $this->buyer_idcard->FormValue;
        $this->buyer_homeno->CurrentValue = $this->buyer_homeno->FormValue;
        $this->buyer_witness_lname->CurrentValue = $this->buyer_witness_lname->FormValue;
        $this->buyer_witness_email->CurrentValue = $this->buyer_witness_email->FormValue;
        $this->juzmatch_authority_lname->CurrentValue = $this->juzmatch_authority_lname->FormValue;
        $this->juzmatch_authority_email->CurrentValue = $this->juzmatch_authority_email->FormValue;
        $this->juzmatch_authority_witness_lname->CurrentValue = $this->juzmatch_authority_witness_lname->FormValue;
        $this->juzmatch_authority_witness_email->CurrentValue = $this->juzmatch_authority_witness_email->FormValue;
        $this->juzmatch_authority2_name->CurrentValue = $this->juzmatch_authority2_name->FormValue;
        $this->juzmatch_authority2_lname->CurrentValue = $this->juzmatch_authority2_lname->FormValue;
        $this->juzmatch_authority2_email->CurrentValue = $this->juzmatch_authority2_email->FormValue;
        $this->company_seal_name->CurrentValue = $this->company_seal_name->FormValue;
        $this->company_seal_email->CurrentValue = $this->company_seal_email->FormValue;
        $this->service_price->CurrentValue = $this->service_price->FormValue;
        $this->service_price_txt->CurrentValue = $this->service_price_txt->FormValue;
        $this->first_down->CurrentValue = $this->first_down->FormValue;
        $this->first_down_txt->CurrentValue = $this->first_down_txt->FormValue;
        $this->second_down->CurrentValue = $this->second_down->FormValue;
        $this->second_down_txt->CurrentValue = $this->second_down_txt->FormValue;
        $this->contact_address->CurrentValue = $this->contact_address->FormValue;
        $this->contact_address2->CurrentValue = $this->contact_address2->FormValue;
        $this->contact_email->CurrentValue = $this->contact_email->FormValue;
        $this->contact_lineid->CurrentValue = $this->contact_lineid->FormValue;
        $this->contact_phone->CurrentValue = $this->contact_phone->FormValue;
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
        $this->id->setDbValue($row['id']);
        $this->document_date->setDbValue($row['document_date']);
        $this->asset_code->setDbValue($row['asset_code']);
        $this->asset_deed->setDbValue($row['asset_deed']);
        $this->asset_project->setDbValue($row['asset_project']);
        $this->asset_area->setDbValue($row['asset_area']);
        $this->buyer_name->setDbValue($row['buyer_name']);
        $this->buyer_lname->setDbValue($row['buyer_lname']);
        $this->buyer_email->setDbValue($row['buyer_email']);
        $this->buyer_idcard->setDbValue($row['buyer_idcard']);
        $this->buyer_homeno->setDbValue($row['buyer_homeno']);
        $this->buyer_witness_name->setDbValue($row['buyer_witness_name']);
        $this->buyer_witness_lname->setDbValue($row['buyer_witness_lname']);
        $this->buyer_witness_email->setDbValue($row['buyer_witness_email']);
        $this->juzmatch_authority_name->setDbValue($row['juzmatch_authority_name']);
        $this->juzmatch_authority_lname->setDbValue($row['juzmatch_authority_lname']);
        $this->juzmatch_authority_email->setDbValue($row['juzmatch_authority_email']);
        $this->juzmatch_authority_witness_name->setDbValue($row['juzmatch_authority_witness_name']);
        $this->juzmatch_authority_witness_lname->setDbValue($row['juzmatch_authority_witness_lname']);
        $this->juzmatch_authority_witness_email->setDbValue($row['juzmatch_authority_witness_email']);
        $this->juzmatch_authority2_name->setDbValue($row['juzmatch_authority2_name']);
        $this->juzmatch_authority2_lname->setDbValue($row['juzmatch_authority2_lname']);
        $this->juzmatch_authority2_email->setDbValue($row['juzmatch_authority2_email']);
        $this->company_seal_name->setDbValue($row['company_seal_name']);
        $this->company_seal_email->setDbValue($row['company_seal_email']);
        $this->service_price->setDbValue($row['service_price']);
        $this->service_price_txt->setDbValue($row['service_price_txt']);
        $this->first_down->setDbValue($row['first_down']);
        $this->first_down_txt->setDbValue($row['first_down_txt']);
        $this->second_down->setDbValue($row['second_down']);
        $this->second_down_txt->setDbValue($row['second_down_txt']);
        $this->contact_address->setDbValue($row['contact_address']);
        $this->contact_address2->setDbValue($row['contact_address2']);
        $this->contact_email->setDbValue($row['contact_email']);
        $this->contact_lineid->setDbValue($row['contact_lineid']);
        $this->contact_phone->setDbValue($row['contact_phone']);
        $this->file_idcard->Upload->DbValue = $row['file_idcard'];
        $this->file_idcard->setDbValue($this->file_idcard->Upload->DbValue);
        $this->file_idcard->Upload->Index = $this->RowIndex;
        $this->file_house_regis->Upload->DbValue = $row['file_house_regis'];
        $this->file_house_regis->setDbValue($this->file_house_regis->Upload->DbValue);
        $this->file_house_regis->Upload->Index = $this->RowIndex;
        $this->file_titledeed->Upload->DbValue = $row['file_titledeed'];
        $this->file_titledeed->setDbValue($this->file_titledeed->Upload->DbValue);
        $this->file_titledeed->Upload->Index = $this->RowIndex;
        $this->file_other->Upload->DbValue = $row['file_other'];
        $this->file_other->setDbValue($this->file_other->Upload->DbValue);
        $this->file_other->Upload->Index = $this->RowIndex;
        $this->attach_file->setDbValue($row['attach_file']);
        $this->status->setDbValue($row['status']);
        $this->doc_date->setDbValue($row['doc_date']);
        $this->buyer_booking_asset_id->setDbValue($row['buyer_booking_asset_id']);
        $this->doc_creden_id->setDbValue($row['doc_creden_id']);
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
        $row['id'] = $this->id->CurrentValue;
        $row['document_date'] = $this->document_date->CurrentValue;
        $row['asset_code'] = $this->asset_code->CurrentValue;
        $row['asset_deed'] = $this->asset_deed->CurrentValue;
        $row['asset_project'] = $this->asset_project->CurrentValue;
        $row['asset_area'] = $this->asset_area->CurrentValue;
        $row['buyer_name'] = $this->buyer_name->CurrentValue;
        $row['buyer_lname'] = $this->buyer_lname->CurrentValue;
        $row['buyer_email'] = $this->buyer_email->CurrentValue;
        $row['buyer_idcard'] = $this->buyer_idcard->CurrentValue;
        $row['buyer_homeno'] = $this->buyer_homeno->CurrentValue;
        $row['buyer_witness_name'] = $this->buyer_witness_name->CurrentValue;
        $row['buyer_witness_lname'] = $this->buyer_witness_lname->CurrentValue;
        $row['buyer_witness_email'] = $this->buyer_witness_email->CurrentValue;
        $row['juzmatch_authority_name'] = $this->juzmatch_authority_name->CurrentValue;
        $row['juzmatch_authority_lname'] = $this->juzmatch_authority_lname->CurrentValue;
        $row['juzmatch_authority_email'] = $this->juzmatch_authority_email->CurrentValue;
        $row['juzmatch_authority_witness_name'] = $this->juzmatch_authority_witness_name->CurrentValue;
        $row['juzmatch_authority_witness_lname'] = $this->juzmatch_authority_witness_lname->CurrentValue;
        $row['juzmatch_authority_witness_email'] = $this->juzmatch_authority_witness_email->CurrentValue;
        $row['juzmatch_authority2_name'] = $this->juzmatch_authority2_name->CurrentValue;
        $row['juzmatch_authority2_lname'] = $this->juzmatch_authority2_lname->CurrentValue;
        $row['juzmatch_authority2_email'] = $this->juzmatch_authority2_email->CurrentValue;
        $row['company_seal_name'] = $this->company_seal_name->CurrentValue;
        $row['company_seal_email'] = $this->company_seal_email->CurrentValue;
        $row['service_price'] = $this->service_price->CurrentValue;
        $row['service_price_txt'] = $this->service_price_txt->CurrentValue;
        $row['first_down'] = $this->first_down->CurrentValue;
        $row['first_down_txt'] = $this->first_down_txt->CurrentValue;
        $row['second_down'] = $this->second_down->CurrentValue;
        $row['second_down_txt'] = $this->second_down_txt->CurrentValue;
        $row['contact_address'] = $this->contact_address->CurrentValue;
        $row['contact_address2'] = $this->contact_address2->CurrentValue;
        $row['contact_email'] = $this->contact_email->CurrentValue;
        $row['contact_lineid'] = $this->contact_lineid->CurrentValue;
        $row['contact_phone'] = $this->contact_phone->CurrentValue;
        $row['file_idcard'] = $this->file_idcard->Upload->DbValue;
        $row['file_house_regis'] = $this->file_house_regis->Upload->DbValue;
        $row['file_titledeed'] = $this->file_titledeed->Upload->DbValue;
        $row['file_other'] = $this->file_other->Upload->DbValue;
        $row['attach_file'] = $this->attach_file->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['doc_date'] = $this->doc_date->CurrentValue;
        $row['buyer_booking_asset_id'] = $this->buyer_booking_asset_id->CurrentValue;
        $row['doc_creden_id'] = $this->doc_creden_id->CurrentValue;
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

        // id
        $this->id->CellCssStyle = "white-space: nowrap;";

        // document_date

        // asset_code

        // asset_deed

        // asset_project

        // asset_area

        // buyer_name

        // buyer_lname

        // buyer_email

        // buyer_idcard

        // buyer_homeno

        // buyer_witness_name

        // buyer_witness_lname

        // buyer_witness_email

        // juzmatch_authority_name

        // juzmatch_authority_lname

        // juzmatch_authority_email

        // juzmatch_authority_witness_name

        // juzmatch_authority_witness_lname

        // juzmatch_authority_witness_email

        // juzmatch_authority2_name

        // juzmatch_authority2_lname

        // juzmatch_authority2_email

        // company_seal_name

        // company_seal_email

        // service_price

        // service_price_txt

        // first_down

        // first_down_txt

        // second_down

        // second_down_txt

        // contact_address

        // contact_address2

        // contact_email

        // contact_lineid

        // contact_phone

        // file_idcard

        // file_house_regis

        // file_titledeed

        // file_other

        // attach_file
        $this->attach_file->CellCssStyle = "white-space: nowrap;";

        // status
        $this->status->CellCssStyle = "white-space: nowrap;";

        // doc_date
        $this->doc_date->CellCssStyle = "white-space: nowrap;";

        // buyer_booking_asset_id
        $this->buyer_booking_asset_id->CellCssStyle = "white-space: nowrap;";

        // doc_creden_id
        $this->doc_creden_id->CellCssStyle = "white-space: nowrap;";

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // document_date
            $this->document_date->ViewValue = $this->document_date->CurrentValue;
            $this->document_date->ViewValue = FormatDateTime($this->document_date->ViewValue, $this->document_date->formatPattern());
            $this->document_date->ViewCustomAttributes = "";

            // asset_code
            $this->asset_code->ViewValue = $this->asset_code->CurrentValue;
            $this->asset_code->ViewCustomAttributes = "";

            // asset_deed
            $this->asset_deed->ViewValue = $this->asset_deed->CurrentValue;
            $this->asset_deed->ViewCustomAttributes = "";

            // asset_project
            $this->asset_project->ViewValue = $this->asset_project->CurrentValue;
            $this->asset_project->ViewCustomAttributes = "";

            // asset_area
            $this->asset_area->ViewValue = $this->asset_area->CurrentValue;
            $this->asset_area->ViewCustomAttributes = "";

            // buyer_lname
            $this->buyer_lname->ViewValue = $this->buyer_lname->CurrentValue;
            $this->buyer_lname->ViewCustomAttributes = "";

            // buyer_email
            $this->buyer_email->ViewValue = $this->buyer_email->CurrentValue;
            $this->buyer_email->ViewCustomAttributes = "";

            // buyer_idcard
            $this->buyer_idcard->ViewValue = $this->buyer_idcard->CurrentValue;
            $this->buyer_idcard->ViewCustomAttributes = "";

            // buyer_homeno
            $this->buyer_homeno->ViewValue = $this->buyer_homeno->CurrentValue;
            $this->buyer_homeno->ViewCustomAttributes = "";

            // buyer_witness_lname
            $this->buyer_witness_lname->ViewValue = $this->buyer_witness_lname->CurrentValue;
            $this->buyer_witness_lname->ViewCustomAttributes = "";

            // buyer_witness_email
            $this->buyer_witness_email->ViewValue = $this->buyer_witness_email->CurrentValue;
            $this->buyer_witness_email->ViewCustomAttributes = "";

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->ViewValue = $this->juzmatch_authority_lname->CurrentValue;
            $this->juzmatch_authority_lname->ViewCustomAttributes = "";

            // juzmatch_authority_email
            $this->juzmatch_authority_email->ViewValue = $this->juzmatch_authority_email->CurrentValue;
            $this->juzmatch_authority_email->ViewCustomAttributes = "";

            // juzmatch_authority_witness_lname
            $this->juzmatch_authority_witness_lname->ViewValue = $this->juzmatch_authority_witness_lname->CurrentValue;
            $this->juzmatch_authority_witness_lname->ViewCustomAttributes = "";

            // juzmatch_authority_witness_email
            $this->juzmatch_authority_witness_email->ViewValue = $this->juzmatch_authority_witness_email->CurrentValue;
            $this->juzmatch_authority_witness_email->ViewCustomAttributes = "";

            // juzmatch_authority2_name
            $this->juzmatch_authority2_name->ViewValue = $this->juzmatch_authority2_name->CurrentValue;
            $this->juzmatch_authority2_name->ViewCustomAttributes = "";

            // juzmatch_authority2_lname
            $this->juzmatch_authority2_lname->ViewValue = $this->juzmatch_authority2_lname->CurrentValue;
            $this->juzmatch_authority2_lname->ViewCustomAttributes = "";

            // juzmatch_authority2_email
            $this->juzmatch_authority2_email->ViewValue = $this->juzmatch_authority2_email->CurrentValue;
            $this->juzmatch_authority2_email->ViewCustomAttributes = "";

            // company_seal_name
            $this->company_seal_name->ViewValue = $this->company_seal_name->CurrentValue;
            $this->company_seal_name->ViewCustomAttributes = "";

            // company_seal_email
            $this->company_seal_email->ViewValue = $this->company_seal_email->CurrentValue;
            $this->company_seal_email->ViewCustomAttributes = "";

            // service_price
            $this->service_price->ViewValue = $this->service_price->CurrentValue;
            $this->service_price->ViewValue = FormatNumber($this->service_price->ViewValue, $this->service_price->formatPattern());
            $this->service_price->ViewCustomAttributes = "";

            // service_price_txt
            $this->service_price_txt->ViewValue = $this->service_price_txt->CurrentValue;
            $this->service_price_txt->ViewCustomAttributes = "";

            // first_down
            $this->first_down->ViewValue = $this->first_down->CurrentValue;
            $this->first_down->ViewValue = FormatNumber($this->first_down->ViewValue, $this->first_down->formatPattern());
            $this->first_down->ViewCustomAttributes = "";

            // first_down_txt
            $this->first_down_txt->ViewValue = $this->first_down_txt->CurrentValue;
            $this->first_down_txt->ViewCustomAttributes = "";

            // second_down
            $this->second_down->ViewValue = $this->second_down->CurrentValue;
            $this->second_down->ViewValue = FormatNumber($this->second_down->ViewValue, $this->second_down->formatPattern());
            $this->second_down->ViewCustomAttributes = "";

            // second_down_txt
            $this->second_down_txt->ViewValue = $this->second_down_txt->CurrentValue;
            $this->second_down_txt->ViewCustomAttributes = "";

            // contact_address
            $this->contact_address->ViewValue = $this->contact_address->CurrentValue;
            $this->contact_address->ViewCustomAttributes = "";

            // contact_address2
            $this->contact_address2->ViewValue = $this->contact_address2->CurrentValue;
            $this->contact_address2->ViewCustomAttributes = "";

            // contact_email
            $this->contact_email->ViewValue = $this->contact_email->CurrentValue;
            $this->contact_email->ViewCustomAttributes = "";

            // contact_lineid
            $this->contact_lineid->ViewValue = $this->contact_lineid->CurrentValue;
            $this->contact_lineid->ViewCustomAttributes = "";

            // contact_phone
            $this->contact_phone->ViewValue = $this->contact_phone->CurrentValue;
            $this->contact_phone->ViewCustomAttributes = "";

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

            // document_date
            $this->document_date->LinkCustomAttributes = "";
            $this->document_date->HrefValue = "";
            $this->document_date->TooltipValue = "";

            // asset_code
            $this->asset_code->LinkCustomAttributes = "";
            $this->asset_code->HrefValue = "";
            $this->asset_code->TooltipValue = "";

            // asset_deed
            $this->asset_deed->LinkCustomAttributes = "";
            $this->asset_deed->HrefValue = "";
            $this->asset_deed->TooltipValue = "";

            // asset_project
            $this->asset_project->LinkCustomAttributes = "";
            $this->asset_project->HrefValue = "";
            $this->asset_project->TooltipValue = "";

            // asset_area
            $this->asset_area->LinkCustomAttributes = "";
            $this->asset_area->HrefValue = "";
            $this->asset_area->TooltipValue = "";

            // buyer_lname
            $this->buyer_lname->LinkCustomAttributes = "";
            $this->buyer_lname->HrefValue = "";
            $this->buyer_lname->TooltipValue = "";

            // buyer_email
            $this->buyer_email->LinkCustomAttributes = "";
            $this->buyer_email->HrefValue = "";
            $this->buyer_email->TooltipValue = "";

            // buyer_idcard
            $this->buyer_idcard->LinkCustomAttributes = "";
            $this->buyer_idcard->HrefValue = "";
            $this->buyer_idcard->TooltipValue = "";

            // buyer_homeno
            $this->buyer_homeno->LinkCustomAttributes = "";
            $this->buyer_homeno->HrefValue = "";
            $this->buyer_homeno->TooltipValue = "";

            // buyer_witness_lname
            $this->buyer_witness_lname->LinkCustomAttributes = "";
            $this->buyer_witness_lname->HrefValue = "";
            $this->buyer_witness_lname->TooltipValue = "";

            // buyer_witness_email
            $this->buyer_witness_email->LinkCustomAttributes = "";
            $this->buyer_witness_email->HrefValue = "";
            $this->buyer_witness_email->TooltipValue = "";

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority_lname->HrefValue = "";
            $this->juzmatch_authority_lname->TooltipValue = "";

            // juzmatch_authority_email
            $this->juzmatch_authority_email->LinkCustomAttributes = "";
            $this->juzmatch_authority_email->HrefValue = "";
            $this->juzmatch_authority_email->TooltipValue = "";

            // juzmatch_authority_witness_lname
            $this->juzmatch_authority_witness_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_lname->HrefValue = "";
            $this->juzmatch_authority_witness_lname->TooltipValue = "";

            // juzmatch_authority_witness_email
            $this->juzmatch_authority_witness_email->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_email->HrefValue = "";
            $this->juzmatch_authority_witness_email->TooltipValue = "";

            // juzmatch_authority2_name
            $this->juzmatch_authority2_name->LinkCustomAttributes = "";
            $this->juzmatch_authority2_name->HrefValue = "";
            $this->juzmatch_authority2_name->TooltipValue = "";

            // juzmatch_authority2_lname
            $this->juzmatch_authority2_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority2_lname->HrefValue = "";
            $this->juzmatch_authority2_lname->TooltipValue = "";

            // juzmatch_authority2_email
            $this->juzmatch_authority2_email->LinkCustomAttributes = "";
            $this->juzmatch_authority2_email->HrefValue = "";
            $this->juzmatch_authority2_email->TooltipValue = "";

            // company_seal_name
            $this->company_seal_name->LinkCustomAttributes = "";
            $this->company_seal_name->HrefValue = "";
            $this->company_seal_name->TooltipValue = "";

            // company_seal_email
            $this->company_seal_email->LinkCustomAttributes = "";
            $this->company_seal_email->HrefValue = "";
            $this->company_seal_email->TooltipValue = "";

            // service_price
            $this->service_price->LinkCustomAttributes = "";
            $this->service_price->HrefValue = "";
            $this->service_price->TooltipValue = "";

            // service_price_txt
            $this->service_price_txt->LinkCustomAttributes = "";
            $this->service_price_txt->HrefValue = "";
            $this->service_price_txt->TooltipValue = "";

            // first_down
            $this->first_down->LinkCustomAttributes = "";
            $this->first_down->HrefValue = "";
            $this->first_down->TooltipValue = "";

            // first_down_txt
            $this->first_down_txt->LinkCustomAttributes = "";
            $this->first_down_txt->HrefValue = "";
            $this->first_down_txt->TooltipValue = "";

            // second_down
            $this->second_down->LinkCustomAttributes = "";
            $this->second_down->HrefValue = "";
            $this->second_down->TooltipValue = "";

            // second_down_txt
            $this->second_down_txt->LinkCustomAttributes = "";
            $this->second_down_txt->HrefValue = "";
            $this->second_down_txt->TooltipValue = "";

            // contact_address
            $this->contact_address->LinkCustomAttributes = "";
            $this->contact_address->HrefValue = "";
            $this->contact_address->TooltipValue = "";

            // contact_address2
            $this->contact_address2->LinkCustomAttributes = "";
            $this->contact_address2->HrefValue = "";
            $this->contact_address2->TooltipValue = "";

            // contact_email
            $this->contact_email->LinkCustomAttributes = "";
            $this->contact_email->HrefValue = "";
            $this->contact_email->TooltipValue = "";

            // contact_lineid
            $this->contact_lineid->LinkCustomAttributes = "";
            $this->contact_lineid->HrefValue = "";
            $this->contact_lineid->TooltipValue = "";

            // contact_phone
            $this->contact_phone->LinkCustomAttributes = "";
            $this->contact_phone->HrefValue = "";
            $this->contact_phone->TooltipValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
            $this->cdate->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // document_date

            // asset_code
            $this->asset_code->setupEditAttributes();
            $this->asset_code->EditCustomAttributes = "";
            if (!$this->asset_code->Raw) {
                $this->asset_code->CurrentValue = HtmlDecode($this->asset_code->CurrentValue);
            }
            $this->asset_code->EditValue = HtmlEncode($this->asset_code->CurrentValue);
            $this->asset_code->PlaceHolder = RemoveHtml($this->asset_code->caption());

            // asset_deed
            $this->asset_deed->setupEditAttributes();
            $this->asset_deed->EditCustomAttributes = "";
            if (!$this->asset_deed->Raw) {
                $this->asset_deed->CurrentValue = HtmlDecode($this->asset_deed->CurrentValue);
            }
            $this->asset_deed->EditValue = HtmlEncode($this->asset_deed->CurrentValue);
            $this->asset_deed->PlaceHolder = RemoveHtml($this->asset_deed->caption());

            // asset_project
            $this->asset_project->setupEditAttributes();
            $this->asset_project->EditCustomAttributes = "";
            if (!$this->asset_project->Raw) {
                $this->asset_project->CurrentValue = HtmlDecode($this->asset_project->CurrentValue);
            }
            $this->asset_project->EditValue = HtmlEncode($this->asset_project->CurrentValue);
            $this->asset_project->PlaceHolder = RemoveHtml($this->asset_project->caption());

            // asset_area
            $this->asset_area->setupEditAttributes();
            $this->asset_area->EditCustomAttributes = "";
            if (!$this->asset_area->Raw) {
                $this->asset_area->CurrentValue = HtmlDecode($this->asset_area->CurrentValue);
            }
            $this->asset_area->EditValue = HtmlEncode($this->asset_area->CurrentValue);
            $this->asset_area->PlaceHolder = RemoveHtml($this->asset_area->caption());

            // buyer_lname
            $this->buyer_lname->setupEditAttributes();
            $this->buyer_lname->EditCustomAttributes = "";
            if (!$this->buyer_lname->Raw) {
                $this->buyer_lname->CurrentValue = HtmlDecode($this->buyer_lname->CurrentValue);
            }
            $this->buyer_lname->EditValue = HtmlEncode($this->buyer_lname->CurrentValue);
            $this->buyer_lname->PlaceHolder = RemoveHtml($this->buyer_lname->caption());

            // buyer_email
            $this->buyer_email->setupEditAttributes();
            $this->buyer_email->EditCustomAttributes = "";
            if (!$this->buyer_email->Raw) {
                $this->buyer_email->CurrentValue = HtmlDecode($this->buyer_email->CurrentValue);
            }
            $this->buyer_email->EditValue = HtmlEncode($this->buyer_email->CurrentValue);
            $this->buyer_email->PlaceHolder = RemoveHtml($this->buyer_email->caption());

            // buyer_idcard
            $this->buyer_idcard->setupEditAttributes();
            $this->buyer_idcard->EditCustomAttributes = "";
            if (!$this->buyer_idcard->Raw) {
                $this->buyer_idcard->CurrentValue = HtmlDecode($this->buyer_idcard->CurrentValue);
            }
            $this->buyer_idcard->EditValue = HtmlEncode($this->buyer_idcard->CurrentValue);
            $this->buyer_idcard->PlaceHolder = RemoveHtml($this->buyer_idcard->caption());

            // buyer_homeno
            $this->buyer_homeno->setupEditAttributes();
            $this->buyer_homeno->EditCustomAttributes = "";
            if (!$this->buyer_homeno->Raw) {
                $this->buyer_homeno->CurrentValue = HtmlDecode($this->buyer_homeno->CurrentValue);
            }
            $this->buyer_homeno->EditValue = HtmlEncode($this->buyer_homeno->CurrentValue);
            $this->buyer_homeno->PlaceHolder = RemoveHtml($this->buyer_homeno->caption());

            // buyer_witness_lname
            $this->buyer_witness_lname->setupEditAttributes();
            $this->buyer_witness_lname->EditCustomAttributes = "";
            if (!$this->buyer_witness_lname->Raw) {
                $this->buyer_witness_lname->CurrentValue = HtmlDecode($this->buyer_witness_lname->CurrentValue);
            }
            $this->buyer_witness_lname->EditValue = HtmlEncode($this->buyer_witness_lname->CurrentValue);
            $this->buyer_witness_lname->PlaceHolder = RemoveHtml($this->buyer_witness_lname->caption());

            // buyer_witness_email
            $this->buyer_witness_email->setupEditAttributes();
            $this->buyer_witness_email->EditCustomAttributes = "";
            if (!$this->buyer_witness_email->Raw) {
                $this->buyer_witness_email->CurrentValue = HtmlDecode($this->buyer_witness_email->CurrentValue);
            }
            $this->buyer_witness_email->EditValue = HtmlEncode($this->buyer_witness_email->CurrentValue);
            $this->buyer_witness_email->PlaceHolder = RemoveHtml($this->buyer_witness_email->caption());

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->setupEditAttributes();
            $this->juzmatch_authority_lname->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_lname->Raw) {
                $this->juzmatch_authority_lname->CurrentValue = HtmlDecode($this->juzmatch_authority_lname->CurrentValue);
            }
            $this->juzmatch_authority_lname->EditValue = HtmlEncode($this->juzmatch_authority_lname->CurrentValue);
            $this->juzmatch_authority_lname->PlaceHolder = RemoveHtml($this->juzmatch_authority_lname->caption());

            // juzmatch_authority_email
            $this->juzmatch_authority_email->setupEditAttributes();
            $this->juzmatch_authority_email->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_email->Raw) {
                $this->juzmatch_authority_email->CurrentValue = HtmlDecode($this->juzmatch_authority_email->CurrentValue);
            }
            $this->juzmatch_authority_email->EditValue = HtmlEncode($this->juzmatch_authority_email->CurrentValue);
            $this->juzmatch_authority_email->PlaceHolder = RemoveHtml($this->juzmatch_authority_email->caption());

            // juzmatch_authority_witness_lname
            $this->juzmatch_authority_witness_lname->setupEditAttributes();
            $this->juzmatch_authority_witness_lname->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_witness_lname->Raw) {
                $this->juzmatch_authority_witness_lname->CurrentValue = HtmlDecode($this->juzmatch_authority_witness_lname->CurrentValue);
            }
            $this->juzmatch_authority_witness_lname->EditValue = HtmlEncode($this->juzmatch_authority_witness_lname->CurrentValue);
            $this->juzmatch_authority_witness_lname->PlaceHolder = RemoveHtml($this->juzmatch_authority_witness_lname->caption());

            // juzmatch_authority_witness_email
            $this->juzmatch_authority_witness_email->setupEditAttributes();
            $this->juzmatch_authority_witness_email->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_witness_email->Raw) {
                $this->juzmatch_authority_witness_email->CurrentValue = HtmlDecode($this->juzmatch_authority_witness_email->CurrentValue);
            }
            $this->juzmatch_authority_witness_email->EditValue = HtmlEncode($this->juzmatch_authority_witness_email->CurrentValue);
            $this->juzmatch_authority_witness_email->PlaceHolder = RemoveHtml($this->juzmatch_authority_witness_email->caption());

            // juzmatch_authority2_name
            $this->juzmatch_authority2_name->setupEditAttributes();
            $this->juzmatch_authority2_name->EditCustomAttributes = "";
            if (!$this->juzmatch_authority2_name->Raw) {
                $this->juzmatch_authority2_name->CurrentValue = HtmlDecode($this->juzmatch_authority2_name->CurrentValue);
            }
            $this->juzmatch_authority2_name->EditValue = HtmlEncode($this->juzmatch_authority2_name->CurrentValue);
            $this->juzmatch_authority2_name->PlaceHolder = RemoveHtml($this->juzmatch_authority2_name->caption());

            // juzmatch_authority2_lname
            $this->juzmatch_authority2_lname->setupEditAttributes();
            $this->juzmatch_authority2_lname->EditCustomAttributes = "";
            if (!$this->juzmatch_authority2_lname->Raw) {
                $this->juzmatch_authority2_lname->CurrentValue = HtmlDecode($this->juzmatch_authority2_lname->CurrentValue);
            }
            $this->juzmatch_authority2_lname->EditValue = HtmlEncode($this->juzmatch_authority2_lname->CurrentValue);
            $this->juzmatch_authority2_lname->PlaceHolder = RemoveHtml($this->juzmatch_authority2_lname->caption());

            // juzmatch_authority2_email
            $this->juzmatch_authority2_email->setupEditAttributes();
            $this->juzmatch_authority2_email->EditCustomAttributes = "";
            if (!$this->juzmatch_authority2_email->Raw) {
                $this->juzmatch_authority2_email->CurrentValue = HtmlDecode($this->juzmatch_authority2_email->CurrentValue);
            }
            $this->juzmatch_authority2_email->EditValue = HtmlEncode($this->juzmatch_authority2_email->CurrentValue);
            $this->juzmatch_authority2_email->PlaceHolder = RemoveHtml($this->juzmatch_authority2_email->caption());

            // company_seal_name
            $this->company_seal_name->setupEditAttributes();
            $this->company_seal_name->EditCustomAttributes = "";
            if (!$this->company_seal_name->Raw) {
                $this->company_seal_name->CurrentValue = HtmlDecode($this->company_seal_name->CurrentValue);
            }
            $this->company_seal_name->EditValue = HtmlEncode($this->company_seal_name->CurrentValue);
            $this->company_seal_name->PlaceHolder = RemoveHtml($this->company_seal_name->caption());

            // company_seal_email
            $this->company_seal_email->setupEditAttributes();
            $this->company_seal_email->EditCustomAttributes = "";
            if (!$this->company_seal_email->Raw) {
                $this->company_seal_email->CurrentValue = HtmlDecode($this->company_seal_email->CurrentValue);
            }
            $this->company_seal_email->EditValue = HtmlEncode($this->company_seal_email->CurrentValue);
            $this->company_seal_email->PlaceHolder = RemoveHtml($this->company_seal_email->caption());

            // service_price
            $this->service_price->setupEditAttributes();
            $this->service_price->EditCustomAttributes = "";
            $this->service_price->EditValue = HtmlEncode($this->service_price->CurrentValue);
            $this->service_price->PlaceHolder = RemoveHtml($this->service_price->caption());
            if (strval($this->service_price->EditValue) != "" && is_numeric($this->service_price->EditValue)) {
                $this->service_price->EditValue = FormatNumber($this->service_price->EditValue, null);
                $this->service_price->OldValue = $this->service_price->EditValue;
            }

            // service_price_txt
            $this->service_price_txt->setupEditAttributes();
            $this->service_price_txt->EditCustomAttributes = "";
            if (!$this->service_price_txt->Raw) {
                $this->service_price_txt->CurrentValue = HtmlDecode($this->service_price_txt->CurrentValue);
            }
            $this->service_price_txt->EditValue = HtmlEncode($this->service_price_txt->CurrentValue);
            $this->service_price_txt->PlaceHolder = RemoveHtml($this->service_price_txt->caption());

            // first_down
            $this->first_down->setupEditAttributes();
            $this->first_down->EditCustomAttributes = "";
            $this->first_down->EditValue = HtmlEncode($this->first_down->CurrentValue);
            $this->first_down->PlaceHolder = RemoveHtml($this->first_down->caption());
            if (strval($this->first_down->EditValue) != "" && is_numeric($this->first_down->EditValue)) {
                $this->first_down->EditValue = FormatNumber($this->first_down->EditValue, null);
                $this->first_down->OldValue = $this->first_down->EditValue;
            }

            // first_down_txt
            $this->first_down_txt->setupEditAttributes();
            $this->first_down_txt->EditCustomAttributes = "";
            if (!$this->first_down_txt->Raw) {
                $this->first_down_txt->CurrentValue = HtmlDecode($this->first_down_txt->CurrentValue);
            }
            $this->first_down_txt->EditValue = HtmlEncode($this->first_down_txt->CurrentValue);
            $this->first_down_txt->PlaceHolder = RemoveHtml($this->first_down_txt->caption());

            // second_down
            $this->second_down->setupEditAttributes();
            $this->second_down->EditCustomAttributes = "";
            $this->second_down->EditValue = HtmlEncode($this->second_down->CurrentValue);
            $this->second_down->PlaceHolder = RemoveHtml($this->second_down->caption());
            if (strval($this->second_down->EditValue) != "" && is_numeric($this->second_down->EditValue)) {
                $this->second_down->EditValue = FormatNumber($this->second_down->EditValue, null);
                $this->second_down->OldValue = $this->second_down->EditValue;
            }

            // second_down_txt
            $this->second_down_txt->setupEditAttributes();
            $this->second_down_txt->EditCustomAttributes = "";
            if (!$this->second_down_txt->Raw) {
                $this->second_down_txt->CurrentValue = HtmlDecode($this->second_down_txt->CurrentValue);
            }
            $this->second_down_txt->EditValue = HtmlEncode($this->second_down_txt->CurrentValue);
            $this->second_down_txt->PlaceHolder = RemoveHtml($this->second_down_txt->caption());

            // contact_address
            $this->contact_address->setupEditAttributes();
            $this->contact_address->EditCustomAttributes = "";
            if (!$this->contact_address->Raw) {
                $this->contact_address->CurrentValue = HtmlDecode($this->contact_address->CurrentValue);
            }
            $this->contact_address->EditValue = HtmlEncode($this->contact_address->CurrentValue);
            $this->contact_address->PlaceHolder = RemoveHtml($this->contact_address->caption());

            // contact_address2
            $this->contact_address2->setupEditAttributes();
            $this->contact_address2->EditCustomAttributes = "";
            if (!$this->contact_address2->Raw) {
                $this->contact_address2->CurrentValue = HtmlDecode($this->contact_address2->CurrentValue);
            }
            $this->contact_address2->EditValue = HtmlEncode($this->contact_address2->CurrentValue);
            $this->contact_address2->PlaceHolder = RemoveHtml($this->contact_address2->caption());

            // contact_email
            $this->contact_email->setupEditAttributes();
            $this->contact_email->EditCustomAttributes = "";
            if (!$this->contact_email->Raw) {
                $this->contact_email->CurrentValue = HtmlDecode($this->contact_email->CurrentValue);
            }
            $this->contact_email->EditValue = HtmlEncode($this->contact_email->CurrentValue);
            $this->contact_email->PlaceHolder = RemoveHtml($this->contact_email->caption());

            // contact_lineid
            $this->contact_lineid->setupEditAttributes();
            $this->contact_lineid->EditCustomAttributes = "";
            if (!$this->contact_lineid->Raw) {
                $this->contact_lineid->CurrentValue = HtmlDecode($this->contact_lineid->CurrentValue);
            }
            $this->contact_lineid->EditValue = HtmlEncode($this->contact_lineid->CurrentValue);
            $this->contact_lineid->PlaceHolder = RemoveHtml($this->contact_lineid->caption());

            // contact_phone
            $this->contact_phone->setupEditAttributes();
            $this->contact_phone->EditCustomAttributes = "";
            if (!$this->contact_phone->Raw) {
                $this->contact_phone->CurrentValue = HtmlDecode($this->contact_phone->CurrentValue);
            }
            $this->contact_phone->EditValue = HtmlEncode($this->contact_phone->CurrentValue);
            $this->contact_phone->PlaceHolder = RemoveHtml($this->contact_phone->caption());

            // cdate

            // Add refer script

            // document_date
            $this->document_date->LinkCustomAttributes = "";
            $this->document_date->HrefValue = "";

            // asset_code
            $this->asset_code->LinkCustomAttributes = "";
            $this->asset_code->HrefValue = "";

            // asset_deed
            $this->asset_deed->LinkCustomAttributes = "";
            $this->asset_deed->HrefValue = "";

            // asset_project
            $this->asset_project->LinkCustomAttributes = "";
            $this->asset_project->HrefValue = "";

            // asset_area
            $this->asset_area->LinkCustomAttributes = "";
            $this->asset_area->HrefValue = "";

            // buyer_lname
            $this->buyer_lname->LinkCustomAttributes = "";
            $this->buyer_lname->HrefValue = "";

            // buyer_email
            $this->buyer_email->LinkCustomAttributes = "";
            $this->buyer_email->HrefValue = "";

            // buyer_idcard
            $this->buyer_idcard->LinkCustomAttributes = "";
            $this->buyer_idcard->HrefValue = "";

            // buyer_homeno
            $this->buyer_homeno->LinkCustomAttributes = "";
            $this->buyer_homeno->HrefValue = "";

            // buyer_witness_lname
            $this->buyer_witness_lname->LinkCustomAttributes = "";
            $this->buyer_witness_lname->HrefValue = "";

            // buyer_witness_email
            $this->buyer_witness_email->LinkCustomAttributes = "";
            $this->buyer_witness_email->HrefValue = "";

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority_lname->HrefValue = "";

            // juzmatch_authority_email
            $this->juzmatch_authority_email->LinkCustomAttributes = "";
            $this->juzmatch_authority_email->HrefValue = "";

            // juzmatch_authority_witness_lname
            $this->juzmatch_authority_witness_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_lname->HrefValue = "";

            // juzmatch_authority_witness_email
            $this->juzmatch_authority_witness_email->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_email->HrefValue = "";

            // juzmatch_authority2_name
            $this->juzmatch_authority2_name->LinkCustomAttributes = "";
            $this->juzmatch_authority2_name->HrefValue = "";

            // juzmatch_authority2_lname
            $this->juzmatch_authority2_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority2_lname->HrefValue = "";

            // juzmatch_authority2_email
            $this->juzmatch_authority2_email->LinkCustomAttributes = "";
            $this->juzmatch_authority2_email->HrefValue = "";

            // company_seal_name
            $this->company_seal_name->LinkCustomAttributes = "";
            $this->company_seal_name->HrefValue = "";

            // company_seal_email
            $this->company_seal_email->LinkCustomAttributes = "";
            $this->company_seal_email->HrefValue = "";

            // service_price
            $this->service_price->LinkCustomAttributes = "";
            $this->service_price->HrefValue = "";

            // service_price_txt
            $this->service_price_txt->LinkCustomAttributes = "";
            $this->service_price_txt->HrefValue = "";

            // first_down
            $this->first_down->LinkCustomAttributes = "";
            $this->first_down->HrefValue = "";

            // first_down_txt
            $this->first_down_txt->LinkCustomAttributes = "";
            $this->first_down_txt->HrefValue = "";

            // second_down
            $this->second_down->LinkCustomAttributes = "";
            $this->second_down->HrefValue = "";

            // second_down_txt
            $this->second_down_txt->LinkCustomAttributes = "";
            $this->second_down_txt->HrefValue = "";

            // contact_address
            $this->contact_address->LinkCustomAttributes = "";
            $this->contact_address->HrefValue = "";

            // contact_address2
            $this->contact_address2->LinkCustomAttributes = "";
            $this->contact_address2->HrefValue = "";

            // contact_email
            $this->contact_email->LinkCustomAttributes = "";
            $this->contact_email->HrefValue = "";

            // contact_lineid
            $this->contact_lineid->LinkCustomAttributes = "";
            $this->contact_lineid->HrefValue = "";

            // contact_phone
            $this->contact_phone->LinkCustomAttributes = "";
            $this->contact_phone->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // document_date

            // asset_code
            $this->asset_code->setupEditAttributes();
            $this->asset_code->EditCustomAttributes = "";
            if (!$this->asset_code->Raw) {
                $this->asset_code->CurrentValue = HtmlDecode($this->asset_code->CurrentValue);
            }
            $this->asset_code->EditValue = HtmlEncode($this->asset_code->CurrentValue);
            $this->asset_code->PlaceHolder = RemoveHtml($this->asset_code->caption());

            // asset_deed
            $this->asset_deed->setupEditAttributes();
            $this->asset_deed->EditCustomAttributes = "";
            if (!$this->asset_deed->Raw) {
                $this->asset_deed->CurrentValue = HtmlDecode($this->asset_deed->CurrentValue);
            }
            $this->asset_deed->EditValue = HtmlEncode($this->asset_deed->CurrentValue);
            $this->asset_deed->PlaceHolder = RemoveHtml($this->asset_deed->caption());

            // asset_project
            $this->asset_project->setupEditAttributes();
            $this->asset_project->EditCustomAttributes = "";
            if (!$this->asset_project->Raw) {
                $this->asset_project->CurrentValue = HtmlDecode($this->asset_project->CurrentValue);
            }
            $this->asset_project->EditValue = HtmlEncode($this->asset_project->CurrentValue);
            $this->asset_project->PlaceHolder = RemoveHtml($this->asset_project->caption());

            // asset_area
            $this->asset_area->setupEditAttributes();
            $this->asset_area->EditCustomAttributes = "";
            if (!$this->asset_area->Raw) {
                $this->asset_area->CurrentValue = HtmlDecode($this->asset_area->CurrentValue);
            }
            $this->asset_area->EditValue = HtmlEncode($this->asset_area->CurrentValue);
            $this->asset_area->PlaceHolder = RemoveHtml($this->asset_area->caption());

            // buyer_lname
            $this->buyer_lname->setupEditAttributes();
            $this->buyer_lname->EditCustomAttributes = "";
            if (!$this->buyer_lname->Raw) {
                $this->buyer_lname->CurrentValue = HtmlDecode($this->buyer_lname->CurrentValue);
            }
            $this->buyer_lname->EditValue = HtmlEncode($this->buyer_lname->CurrentValue);
            $this->buyer_lname->PlaceHolder = RemoveHtml($this->buyer_lname->caption());

            // buyer_email
            $this->buyer_email->setupEditAttributes();
            $this->buyer_email->EditCustomAttributes = "";
            if (!$this->buyer_email->Raw) {
                $this->buyer_email->CurrentValue = HtmlDecode($this->buyer_email->CurrentValue);
            }
            $this->buyer_email->EditValue = HtmlEncode($this->buyer_email->CurrentValue);
            $this->buyer_email->PlaceHolder = RemoveHtml($this->buyer_email->caption());

            // buyer_idcard
            $this->buyer_idcard->setupEditAttributes();
            $this->buyer_idcard->EditCustomAttributes = "";
            if (!$this->buyer_idcard->Raw) {
                $this->buyer_idcard->CurrentValue = HtmlDecode($this->buyer_idcard->CurrentValue);
            }
            $this->buyer_idcard->EditValue = HtmlEncode($this->buyer_idcard->CurrentValue);
            $this->buyer_idcard->PlaceHolder = RemoveHtml($this->buyer_idcard->caption());

            // buyer_homeno
            $this->buyer_homeno->setupEditAttributes();
            $this->buyer_homeno->EditCustomAttributes = "";
            if (!$this->buyer_homeno->Raw) {
                $this->buyer_homeno->CurrentValue = HtmlDecode($this->buyer_homeno->CurrentValue);
            }
            $this->buyer_homeno->EditValue = HtmlEncode($this->buyer_homeno->CurrentValue);
            $this->buyer_homeno->PlaceHolder = RemoveHtml($this->buyer_homeno->caption());

            // buyer_witness_lname
            $this->buyer_witness_lname->setupEditAttributes();
            $this->buyer_witness_lname->EditCustomAttributes = "";
            if (!$this->buyer_witness_lname->Raw) {
                $this->buyer_witness_lname->CurrentValue = HtmlDecode($this->buyer_witness_lname->CurrentValue);
            }
            $this->buyer_witness_lname->EditValue = HtmlEncode($this->buyer_witness_lname->CurrentValue);
            $this->buyer_witness_lname->PlaceHolder = RemoveHtml($this->buyer_witness_lname->caption());

            // buyer_witness_email
            $this->buyer_witness_email->setupEditAttributes();
            $this->buyer_witness_email->EditCustomAttributes = "";
            if (!$this->buyer_witness_email->Raw) {
                $this->buyer_witness_email->CurrentValue = HtmlDecode($this->buyer_witness_email->CurrentValue);
            }
            $this->buyer_witness_email->EditValue = HtmlEncode($this->buyer_witness_email->CurrentValue);
            $this->buyer_witness_email->PlaceHolder = RemoveHtml($this->buyer_witness_email->caption());

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->setupEditAttributes();
            $this->juzmatch_authority_lname->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_lname->Raw) {
                $this->juzmatch_authority_lname->CurrentValue = HtmlDecode($this->juzmatch_authority_lname->CurrentValue);
            }
            $this->juzmatch_authority_lname->EditValue = HtmlEncode($this->juzmatch_authority_lname->CurrentValue);
            $this->juzmatch_authority_lname->PlaceHolder = RemoveHtml($this->juzmatch_authority_lname->caption());

            // juzmatch_authority_email
            $this->juzmatch_authority_email->setupEditAttributes();
            $this->juzmatch_authority_email->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_email->Raw) {
                $this->juzmatch_authority_email->CurrentValue = HtmlDecode($this->juzmatch_authority_email->CurrentValue);
            }
            $this->juzmatch_authority_email->EditValue = HtmlEncode($this->juzmatch_authority_email->CurrentValue);
            $this->juzmatch_authority_email->PlaceHolder = RemoveHtml($this->juzmatch_authority_email->caption());

            // juzmatch_authority_witness_lname
            $this->juzmatch_authority_witness_lname->setupEditAttributes();
            $this->juzmatch_authority_witness_lname->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_witness_lname->Raw) {
                $this->juzmatch_authority_witness_lname->CurrentValue = HtmlDecode($this->juzmatch_authority_witness_lname->CurrentValue);
            }
            $this->juzmatch_authority_witness_lname->EditValue = HtmlEncode($this->juzmatch_authority_witness_lname->CurrentValue);
            $this->juzmatch_authority_witness_lname->PlaceHolder = RemoveHtml($this->juzmatch_authority_witness_lname->caption());

            // juzmatch_authority_witness_email
            $this->juzmatch_authority_witness_email->setupEditAttributes();
            $this->juzmatch_authority_witness_email->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_witness_email->Raw) {
                $this->juzmatch_authority_witness_email->CurrentValue = HtmlDecode($this->juzmatch_authority_witness_email->CurrentValue);
            }
            $this->juzmatch_authority_witness_email->EditValue = HtmlEncode($this->juzmatch_authority_witness_email->CurrentValue);
            $this->juzmatch_authority_witness_email->PlaceHolder = RemoveHtml($this->juzmatch_authority_witness_email->caption());

            // juzmatch_authority2_name
            $this->juzmatch_authority2_name->setupEditAttributes();
            $this->juzmatch_authority2_name->EditCustomAttributes = "";
            if (!$this->juzmatch_authority2_name->Raw) {
                $this->juzmatch_authority2_name->CurrentValue = HtmlDecode($this->juzmatch_authority2_name->CurrentValue);
            }
            $this->juzmatch_authority2_name->EditValue = HtmlEncode($this->juzmatch_authority2_name->CurrentValue);
            $this->juzmatch_authority2_name->PlaceHolder = RemoveHtml($this->juzmatch_authority2_name->caption());

            // juzmatch_authority2_lname
            $this->juzmatch_authority2_lname->setupEditAttributes();
            $this->juzmatch_authority2_lname->EditCustomAttributes = "";
            if (!$this->juzmatch_authority2_lname->Raw) {
                $this->juzmatch_authority2_lname->CurrentValue = HtmlDecode($this->juzmatch_authority2_lname->CurrentValue);
            }
            $this->juzmatch_authority2_lname->EditValue = HtmlEncode($this->juzmatch_authority2_lname->CurrentValue);
            $this->juzmatch_authority2_lname->PlaceHolder = RemoveHtml($this->juzmatch_authority2_lname->caption());

            // juzmatch_authority2_email
            $this->juzmatch_authority2_email->setupEditAttributes();
            $this->juzmatch_authority2_email->EditCustomAttributes = "";
            if (!$this->juzmatch_authority2_email->Raw) {
                $this->juzmatch_authority2_email->CurrentValue = HtmlDecode($this->juzmatch_authority2_email->CurrentValue);
            }
            $this->juzmatch_authority2_email->EditValue = HtmlEncode($this->juzmatch_authority2_email->CurrentValue);
            $this->juzmatch_authority2_email->PlaceHolder = RemoveHtml($this->juzmatch_authority2_email->caption());

            // company_seal_name
            $this->company_seal_name->setupEditAttributes();
            $this->company_seal_name->EditCustomAttributes = "";
            if (!$this->company_seal_name->Raw) {
                $this->company_seal_name->CurrentValue = HtmlDecode($this->company_seal_name->CurrentValue);
            }
            $this->company_seal_name->EditValue = HtmlEncode($this->company_seal_name->CurrentValue);
            $this->company_seal_name->PlaceHolder = RemoveHtml($this->company_seal_name->caption());

            // company_seal_email
            $this->company_seal_email->setupEditAttributes();
            $this->company_seal_email->EditCustomAttributes = "";
            if (!$this->company_seal_email->Raw) {
                $this->company_seal_email->CurrentValue = HtmlDecode($this->company_seal_email->CurrentValue);
            }
            $this->company_seal_email->EditValue = HtmlEncode($this->company_seal_email->CurrentValue);
            $this->company_seal_email->PlaceHolder = RemoveHtml($this->company_seal_email->caption());

            // service_price
            $this->service_price->setupEditAttributes();
            $this->service_price->EditCustomAttributes = "";
            $this->service_price->EditValue = HtmlEncode($this->service_price->CurrentValue);
            $this->service_price->PlaceHolder = RemoveHtml($this->service_price->caption());
            if (strval($this->service_price->EditValue) != "" && is_numeric($this->service_price->EditValue)) {
                $this->service_price->EditValue = FormatNumber($this->service_price->EditValue, null);
                $this->service_price->OldValue = $this->service_price->EditValue;
            }

            // service_price_txt
            $this->service_price_txt->setupEditAttributes();
            $this->service_price_txt->EditCustomAttributes = "";
            if (!$this->service_price_txt->Raw) {
                $this->service_price_txt->CurrentValue = HtmlDecode($this->service_price_txt->CurrentValue);
            }
            $this->service_price_txt->EditValue = HtmlEncode($this->service_price_txt->CurrentValue);
            $this->service_price_txt->PlaceHolder = RemoveHtml($this->service_price_txt->caption());

            // first_down
            $this->first_down->setupEditAttributes();
            $this->first_down->EditCustomAttributes = "";
            $this->first_down->EditValue = HtmlEncode($this->first_down->CurrentValue);
            $this->first_down->PlaceHolder = RemoveHtml($this->first_down->caption());
            if (strval($this->first_down->EditValue) != "" && is_numeric($this->first_down->EditValue)) {
                $this->first_down->EditValue = FormatNumber($this->first_down->EditValue, null);
                $this->first_down->OldValue = $this->first_down->EditValue;
            }

            // first_down_txt
            $this->first_down_txt->setupEditAttributes();
            $this->first_down_txt->EditCustomAttributes = "";
            if (!$this->first_down_txt->Raw) {
                $this->first_down_txt->CurrentValue = HtmlDecode($this->first_down_txt->CurrentValue);
            }
            $this->first_down_txt->EditValue = HtmlEncode($this->first_down_txt->CurrentValue);
            $this->first_down_txt->PlaceHolder = RemoveHtml($this->first_down_txt->caption());

            // second_down
            $this->second_down->setupEditAttributes();
            $this->second_down->EditCustomAttributes = "";
            $this->second_down->EditValue = HtmlEncode($this->second_down->CurrentValue);
            $this->second_down->PlaceHolder = RemoveHtml($this->second_down->caption());
            if (strval($this->second_down->EditValue) != "" && is_numeric($this->second_down->EditValue)) {
                $this->second_down->EditValue = FormatNumber($this->second_down->EditValue, null);
                $this->second_down->OldValue = $this->second_down->EditValue;
            }

            // second_down_txt
            $this->second_down_txt->setupEditAttributes();
            $this->second_down_txt->EditCustomAttributes = "";
            if (!$this->second_down_txt->Raw) {
                $this->second_down_txt->CurrentValue = HtmlDecode($this->second_down_txt->CurrentValue);
            }
            $this->second_down_txt->EditValue = HtmlEncode($this->second_down_txt->CurrentValue);
            $this->second_down_txt->PlaceHolder = RemoveHtml($this->second_down_txt->caption());

            // contact_address
            $this->contact_address->setupEditAttributes();
            $this->contact_address->EditCustomAttributes = "";
            if (!$this->contact_address->Raw) {
                $this->contact_address->CurrentValue = HtmlDecode($this->contact_address->CurrentValue);
            }
            $this->contact_address->EditValue = HtmlEncode($this->contact_address->CurrentValue);
            $this->contact_address->PlaceHolder = RemoveHtml($this->contact_address->caption());

            // contact_address2
            $this->contact_address2->setupEditAttributes();
            $this->contact_address2->EditCustomAttributes = "";
            if (!$this->contact_address2->Raw) {
                $this->contact_address2->CurrentValue = HtmlDecode($this->contact_address2->CurrentValue);
            }
            $this->contact_address2->EditValue = HtmlEncode($this->contact_address2->CurrentValue);
            $this->contact_address2->PlaceHolder = RemoveHtml($this->contact_address2->caption());

            // contact_email
            $this->contact_email->setupEditAttributes();
            $this->contact_email->EditCustomAttributes = "";
            if (!$this->contact_email->Raw) {
                $this->contact_email->CurrentValue = HtmlDecode($this->contact_email->CurrentValue);
            }
            $this->contact_email->EditValue = HtmlEncode($this->contact_email->CurrentValue);
            $this->contact_email->PlaceHolder = RemoveHtml($this->contact_email->caption());

            // contact_lineid
            $this->contact_lineid->setupEditAttributes();
            $this->contact_lineid->EditCustomAttributes = "";
            if (!$this->contact_lineid->Raw) {
                $this->contact_lineid->CurrentValue = HtmlDecode($this->contact_lineid->CurrentValue);
            }
            $this->contact_lineid->EditValue = HtmlEncode($this->contact_lineid->CurrentValue);
            $this->contact_lineid->PlaceHolder = RemoveHtml($this->contact_lineid->caption());

            // contact_phone
            $this->contact_phone->setupEditAttributes();
            $this->contact_phone->EditCustomAttributes = "";
            if (!$this->contact_phone->Raw) {
                $this->contact_phone->CurrentValue = HtmlDecode($this->contact_phone->CurrentValue);
            }
            $this->contact_phone->EditValue = HtmlEncode($this->contact_phone->CurrentValue);
            $this->contact_phone->PlaceHolder = RemoveHtml($this->contact_phone->caption());

            // cdate

            // Edit refer script

            // document_date
            $this->document_date->LinkCustomAttributes = "";
            $this->document_date->HrefValue = "";

            // asset_code
            $this->asset_code->LinkCustomAttributes = "";
            $this->asset_code->HrefValue = "";

            // asset_deed
            $this->asset_deed->LinkCustomAttributes = "";
            $this->asset_deed->HrefValue = "";

            // asset_project
            $this->asset_project->LinkCustomAttributes = "";
            $this->asset_project->HrefValue = "";

            // asset_area
            $this->asset_area->LinkCustomAttributes = "";
            $this->asset_area->HrefValue = "";

            // buyer_lname
            $this->buyer_lname->LinkCustomAttributes = "";
            $this->buyer_lname->HrefValue = "";

            // buyer_email
            $this->buyer_email->LinkCustomAttributes = "";
            $this->buyer_email->HrefValue = "";

            // buyer_idcard
            $this->buyer_idcard->LinkCustomAttributes = "";
            $this->buyer_idcard->HrefValue = "";

            // buyer_homeno
            $this->buyer_homeno->LinkCustomAttributes = "";
            $this->buyer_homeno->HrefValue = "";

            // buyer_witness_lname
            $this->buyer_witness_lname->LinkCustomAttributes = "";
            $this->buyer_witness_lname->HrefValue = "";

            // buyer_witness_email
            $this->buyer_witness_email->LinkCustomAttributes = "";
            $this->buyer_witness_email->HrefValue = "";

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority_lname->HrefValue = "";

            // juzmatch_authority_email
            $this->juzmatch_authority_email->LinkCustomAttributes = "";
            $this->juzmatch_authority_email->HrefValue = "";

            // juzmatch_authority_witness_lname
            $this->juzmatch_authority_witness_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_lname->HrefValue = "";

            // juzmatch_authority_witness_email
            $this->juzmatch_authority_witness_email->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_email->HrefValue = "";

            // juzmatch_authority2_name
            $this->juzmatch_authority2_name->LinkCustomAttributes = "";
            $this->juzmatch_authority2_name->HrefValue = "";

            // juzmatch_authority2_lname
            $this->juzmatch_authority2_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority2_lname->HrefValue = "";

            // juzmatch_authority2_email
            $this->juzmatch_authority2_email->LinkCustomAttributes = "";
            $this->juzmatch_authority2_email->HrefValue = "";

            // company_seal_name
            $this->company_seal_name->LinkCustomAttributes = "";
            $this->company_seal_name->HrefValue = "";

            // company_seal_email
            $this->company_seal_email->LinkCustomAttributes = "";
            $this->company_seal_email->HrefValue = "";

            // service_price
            $this->service_price->LinkCustomAttributes = "";
            $this->service_price->HrefValue = "";

            // service_price_txt
            $this->service_price_txt->LinkCustomAttributes = "";
            $this->service_price_txt->HrefValue = "";

            // first_down
            $this->first_down->LinkCustomAttributes = "";
            $this->first_down->HrefValue = "";

            // first_down_txt
            $this->first_down_txt->LinkCustomAttributes = "";
            $this->first_down_txt->HrefValue = "";

            // second_down
            $this->second_down->LinkCustomAttributes = "";
            $this->second_down->HrefValue = "";

            // second_down_txt
            $this->second_down_txt->LinkCustomAttributes = "";
            $this->second_down_txt->HrefValue = "";

            // contact_address
            $this->contact_address->LinkCustomAttributes = "";
            $this->contact_address->HrefValue = "";

            // contact_address2
            $this->contact_address2->LinkCustomAttributes = "";
            $this->contact_address2->HrefValue = "";

            // contact_email
            $this->contact_email->LinkCustomAttributes = "";
            $this->contact_email->HrefValue = "";

            // contact_lineid
            $this->contact_lineid->LinkCustomAttributes = "";
            $this->contact_lineid->HrefValue = "";

            // contact_phone
            $this->contact_phone->LinkCustomAttributes = "";
            $this->contact_phone->HrefValue = "";

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
        if ($this->document_date->Required) {
            if (!$this->document_date->IsDetailKey && EmptyValue($this->document_date->FormValue)) {
                $this->document_date->addErrorMessage(str_replace("%s", $this->document_date->caption(), $this->document_date->RequiredErrorMessage));
            }
        }
        if ($this->asset_code->Required) {
            if (!$this->asset_code->IsDetailKey && EmptyValue($this->asset_code->FormValue)) {
                $this->asset_code->addErrorMessage(str_replace("%s", $this->asset_code->caption(), $this->asset_code->RequiredErrorMessage));
            }
        }
        if ($this->asset_deed->Required) {
            if (!$this->asset_deed->IsDetailKey && EmptyValue($this->asset_deed->FormValue)) {
                $this->asset_deed->addErrorMessage(str_replace("%s", $this->asset_deed->caption(), $this->asset_deed->RequiredErrorMessage));
            }
        }
        if ($this->asset_project->Required) {
            if (!$this->asset_project->IsDetailKey && EmptyValue($this->asset_project->FormValue)) {
                $this->asset_project->addErrorMessage(str_replace("%s", $this->asset_project->caption(), $this->asset_project->RequiredErrorMessage));
            }
        }
        if ($this->asset_area->Required) {
            if (!$this->asset_area->IsDetailKey && EmptyValue($this->asset_area->FormValue)) {
                $this->asset_area->addErrorMessage(str_replace("%s", $this->asset_area->caption(), $this->asset_area->RequiredErrorMessage));
            }
        }
        if ($this->buyer_lname->Required) {
            if (!$this->buyer_lname->IsDetailKey && EmptyValue($this->buyer_lname->FormValue)) {
                $this->buyer_lname->addErrorMessage(str_replace("%s", $this->buyer_lname->caption(), $this->buyer_lname->RequiredErrorMessage));
            }
        }
        if ($this->buyer_email->Required) {
            if (!$this->buyer_email->IsDetailKey && EmptyValue($this->buyer_email->FormValue)) {
                $this->buyer_email->addErrorMessage(str_replace("%s", $this->buyer_email->caption(), $this->buyer_email->RequiredErrorMessage));
            }
        }
        if ($this->buyer_idcard->Required) {
            if (!$this->buyer_idcard->IsDetailKey && EmptyValue($this->buyer_idcard->FormValue)) {
                $this->buyer_idcard->addErrorMessage(str_replace("%s", $this->buyer_idcard->caption(), $this->buyer_idcard->RequiredErrorMessage));
            }
        }
        if ($this->buyer_homeno->Required) {
            if (!$this->buyer_homeno->IsDetailKey && EmptyValue($this->buyer_homeno->FormValue)) {
                $this->buyer_homeno->addErrorMessage(str_replace("%s", $this->buyer_homeno->caption(), $this->buyer_homeno->RequiredErrorMessage));
            }
        }
        if ($this->buyer_witness_lname->Required) {
            if (!$this->buyer_witness_lname->IsDetailKey && EmptyValue($this->buyer_witness_lname->FormValue)) {
                $this->buyer_witness_lname->addErrorMessage(str_replace("%s", $this->buyer_witness_lname->caption(), $this->buyer_witness_lname->RequiredErrorMessage));
            }
        }
        if ($this->buyer_witness_email->Required) {
            if (!$this->buyer_witness_email->IsDetailKey && EmptyValue($this->buyer_witness_email->FormValue)) {
                $this->buyer_witness_email->addErrorMessage(str_replace("%s", $this->buyer_witness_email->caption(), $this->buyer_witness_email->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority_lname->Required) {
            if (!$this->juzmatch_authority_lname->IsDetailKey && EmptyValue($this->juzmatch_authority_lname->FormValue)) {
                $this->juzmatch_authority_lname->addErrorMessage(str_replace("%s", $this->juzmatch_authority_lname->caption(), $this->juzmatch_authority_lname->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority_email->Required) {
            if (!$this->juzmatch_authority_email->IsDetailKey && EmptyValue($this->juzmatch_authority_email->FormValue)) {
                $this->juzmatch_authority_email->addErrorMessage(str_replace("%s", $this->juzmatch_authority_email->caption(), $this->juzmatch_authority_email->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority_witness_lname->Required) {
            if (!$this->juzmatch_authority_witness_lname->IsDetailKey && EmptyValue($this->juzmatch_authority_witness_lname->FormValue)) {
                $this->juzmatch_authority_witness_lname->addErrorMessage(str_replace("%s", $this->juzmatch_authority_witness_lname->caption(), $this->juzmatch_authority_witness_lname->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority_witness_email->Required) {
            if (!$this->juzmatch_authority_witness_email->IsDetailKey && EmptyValue($this->juzmatch_authority_witness_email->FormValue)) {
                $this->juzmatch_authority_witness_email->addErrorMessage(str_replace("%s", $this->juzmatch_authority_witness_email->caption(), $this->juzmatch_authority_witness_email->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority2_name->Required) {
            if (!$this->juzmatch_authority2_name->IsDetailKey && EmptyValue($this->juzmatch_authority2_name->FormValue)) {
                $this->juzmatch_authority2_name->addErrorMessage(str_replace("%s", $this->juzmatch_authority2_name->caption(), $this->juzmatch_authority2_name->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority2_lname->Required) {
            if (!$this->juzmatch_authority2_lname->IsDetailKey && EmptyValue($this->juzmatch_authority2_lname->FormValue)) {
                $this->juzmatch_authority2_lname->addErrorMessage(str_replace("%s", $this->juzmatch_authority2_lname->caption(), $this->juzmatch_authority2_lname->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority2_email->Required) {
            if (!$this->juzmatch_authority2_email->IsDetailKey && EmptyValue($this->juzmatch_authority2_email->FormValue)) {
                $this->juzmatch_authority2_email->addErrorMessage(str_replace("%s", $this->juzmatch_authority2_email->caption(), $this->juzmatch_authority2_email->RequiredErrorMessage));
            }
        }
        if ($this->company_seal_name->Required) {
            if (!$this->company_seal_name->IsDetailKey && EmptyValue($this->company_seal_name->FormValue)) {
                $this->company_seal_name->addErrorMessage(str_replace("%s", $this->company_seal_name->caption(), $this->company_seal_name->RequiredErrorMessage));
            }
        }
        if ($this->company_seal_email->Required) {
            if (!$this->company_seal_email->IsDetailKey && EmptyValue($this->company_seal_email->FormValue)) {
                $this->company_seal_email->addErrorMessage(str_replace("%s", $this->company_seal_email->caption(), $this->company_seal_email->RequiredErrorMessage));
            }
        }
        if ($this->service_price->Required) {
            if (!$this->service_price->IsDetailKey && EmptyValue($this->service_price->FormValue)) {
                $this->service_price->addErrorMessage(str_replace("%s", $this->service_price->caption(), $this->service_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->service_price->FormValue)) {
            $this->service_price->addErrorMessage($this->service_price->getErrorMessage(false));
        }
        if ($this->service_price_txt->Required) {
            if (!$this->service_price_txt->IsDetailKey && EmptyValue($this->service_price_txt->FormValue)) {
                $this->service_price_txt->addErrorMessage(str_replace("%s", $this->service_price_txt->caption(), $this->service_price_txt->RequiredErrorMessage));
            }
        }
        if ($this->first_down->Required) {
            if (!$this->first_down->IsDetailKey && EmptyValue($this->first_down->FormValue)) {
                $this->first_down->addErrorMessage(str_replace("%s", $this->first_down->caption(), $this->first_down->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->first_down->FormValue)) {
            $this->first_down->addErrorMessage($this->first_down->getErrorMessage(false));
        }
        if ($this->first_down_txt->Required) {
            if (!$this->first_down_txt->IsDetailKey && EmptyValue($this->first_down_txt->FormValue)) {
                $this->first_down_txt->addErrorMessage(str_replace("%s", $this->first_down_txt->caption(), $this->first_down_txt->RequiredErrorMessage));
            }
        }
        if ($this->second_down->Required) {
            if (!$this->second_down->IsDetailKey && EmptyValue($this->second_down->FormValue)) {
                $this->second_down->addErrorMessage(str_replace("%s", $this->second_down->caption(), $this->second_down->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->second_down->FormValue)) {
            $this->second_down->addErrorMessage($this->second_down->getErrorMessage(false));
        }
        if ($this->second_down_txt->Required) {
            if (!$this->second_down_txt->IsDetailKey && EmptyValue($this->second_down_txt->FormValue)) {
                $this->second_down_txt->addErrorMessage(str_replace("%s", $this->second_down_txt->caption(), $this->second_down_txt->RequiredErrorMessage));
            }
        }
        if ($this->contact_address->Required) {
            if (!$this->contact_address->IsDetailKey && EmptyValue($this->contact_address->FormValue)) {
                $this->contact_address->addErrorMessage(str_replace("%s", $this->contact_address->caption(), $this->contact_address->RequiredErrorMessage));
            }
        }
        if ($this->contact_address2->Required) {
            if (!$this->contact_address2->IsDetailKey && EmptyValue($this->contact_address2->FormValue)) {
                $this->contact_address2->addErrorMessage(str_replace("%s", $this->contact_address2->caption(), $this->contact_address2->RequiredErrorMessage));
            }
        }
        if ($this->contact_email->Required) {
            if (!$this->contact_email->IsDetailKey && EmptyValue($this->contact_email->FormValue)) {
                $this->contact_email->addErrorMessage(str_replace("%s", $this->contact_email->caption(), $this->contact_email->RequiredErrorMessage));
            }
        }
        if ($this->contact_lineid->Required) {
            if (!$this->contact_lineid->IsDetailKey && EmptyValue($this->contact_lineid->FormValue)) {
                $this->contact_lineid->addErrorMessage(str_replace("%s", $this->contact_lineid->caption(), $this->contact_lineid->RequiredErrorMessage));
            }
        }
        if ($this->contact_phone->Required) {
            if (!$this->contact_phone->IsDetailKey && EmptyValue($this->contact_phone->FormValue)) {
                $this->contact_phone->addErrorMessage(str_replace("%s", $this->contact_phone->caption(), $this->contact_phone->RequiredErrorMessage));
            }
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
            $thisKey .= $row['id'];

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
            $this->file_idcard->OldUploadPath = "/upload/";
            $this->file_idcard->UploadPath = $this->file_idcard->OldUploadPath;
            $this->file_house_regis->OldUploadPath = "/upload/";
            $this->file_house_regis->UploadPath = $this->file_house_regis->OldUploadPath;
            $this->file_titledeed->OldUploadPath = "/upload/";
            $this->file_titledeed->UploadPath = $this->file_titledeed->OldUploadPath;
            $this->file_other->OldUploadPath = "/upload/";
            $this->file_other->UploadPath = $this->file_other->OldUploadPath;
            $rsnew = [];

            // document_date
            $this->document_date->CurrentValue = CurrentDateTime();
            $this->document_date->setDbValueDef($rsnew, $this->document_date->CurrentValue, null);

            // asset_code
            $this->asset_code->setDbValueDef($rsnew, $this->asset_code->CurrentValue, null, $this->asset_code->ReadOnly);

            // asset_deed
            $this->asset_deed->setDbValueDef($rsnew, $this->asset_deed->CurrentValue, null, $this->asset_deed->ReadOnly);

            // asset_project
            $this->asset_project->setDbValueDef($rsnew, $this->asset_project->CurrentValue, null, $this->asset_project->ReadOnly);

            // asset_area
            $this->asset_area->setDbValueDef($rsnew, $this->asset_area->CurrentValue, null, $this->asset_area->ReadOnly);

            // buyer_lname
            $this->buyer_lname->setDbValueDef($rsnew, $this->buyer_lname->CurrentValue, null, $this->buyer_lname->ReadOnly);

            // buyer_email
            $this->buyer_email->setDbValueDef($rsnew, $this->buyer_email->CurrentValue, null, $this->buyer_email->ReadOnly);

            // buyer_idcard
            $this->buyer_idcard->setDbValueDef($rsnew, $this->buyer_idcard->CurrentValue, null, $this->buyer_idcard->ReadOnly);

            // buyer_homeno
            $this->buyer_homeno->setDbValueDef($rsnew, $this->buyer_homeno->CurrentValue, null, $this->buyer_homeno->ReadOnly);

            // buyer_witness_lname
            $this->buyer_witness_lname->setDbValueDef($rsnew, $this->buyer_witness_lname->CurrentValue, null, $this->buyer_witness_lname->ReadOnly);

            // buyer_witness_email
            $this->buyer_witness_email->setDbValueDef($rsnew, $this->buyer_witness_email->CurrentValue, null, $this->buyer_witness_email->ReadOnly);

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->setDbValueDef($rsnew, $this->juzmatch_authority_lname->CurrentValue, null, $this->juzmatch_authority_lname->ReadOnly);

            // juzmatch_authority_email
            $this->juzmatch_authority_email->setDbValueDef($rsnew, $this->juzmatch_authority_email->CurrentValue, null, $this->juzmatch_authority_email->ReadOnly);

            // juzmatch_authority_witness_lname
            $this->juzmatch_authority_witness_lname->setDbValueDef($rsnew, $this->juzmatch_authority_witness_lname->CurrentValue, null, $this->juzmatch_authority_witness_lname->ReadOnly);

            // juzmatch_authority_witness_email
            $this->juzmatch_authority_witness_email->setDbValueDef($rsnew, $this->juzmatch_authority_witness_email->CurrentValue, null, $this->juzmatch_authority_witness_email->ReadOnly);

            // juzmatch_authority2_name
            $this->juzmatch_authority2_name->setDbValueDef($rsnew, $this->juzmatch_authority2_name->CurrentValue, null, $this->juzmatch_authority2_name->ReadOnly);

            // juzmatch_authority2_lname
            $this->juzmatch_authority2_lname->setDbValueDef($rsnew, $this->juzmatch_authority2_lname->CurrentValue, null, $this->juzmatch_authority2_lname->ReadOnly);

            // juzmatch_authority2_email
            $this->juzmatch_authority2_email->setDbValueDef($rsnew, $this->juzmatch_authority2_email->CurrentValue, null, $this->juzmatch_authority2_email->ReadOnly);

            // company_seal_name
            $this->company_seal_name->setDbValueDef($rsnew, $this->company_seal_name->CurrentValue, null, $this->company_seal_name->ReadOnly);

            // company_seal_email
            $this->company_seal_email->setDbValueDef($rsnew, $this->company_seal_email->CurrentValue, null, $this->company_seal_email->ReadOnly);

            // service_price
            $this->service_price->setDbValueDef($rsnew, $this->service_price->CurrentValue, null, $this->service_price->ReadOnly);

            // service_price_txt
            $this->service_price_txt->setDbValueDef($rsnew, $this->service_price_txt->CurrentValue, null, $this->service_price_txt->ReadOnly);

            // first_down
            $this->first_down->setDbValueDef($rsnew, $this->first_down->CurrentValue, null, $this->first_down->ReadOnly);

            // first_down_txt
            $this->first_down_txt->setDbValueDef($rsnew, $this->first_down_txt->CurrentValue, null, $this->first_down_txt->ReadOnly);

            // second_down
            $this->second_down->setDbValueDef($rsnew, $this->second_down->CurrentValue, null, $this->second_down->ReadOnly);

            // second_down_txt
            $this->second_down_txt->setDbValueDef($rsnew, $this->second_down_txt->CurrentValue, null, $this->second_down_txt->ReadOnly);

            // contact_address
            $this->contact_address->setDbValueDef($rsnew, $this->contact_address->CurrentValue, null, $this->contact_address->ReadOnly);

            // contact_address2
            $this->contact_address2->setDbValueDef($rsnew, $this->contact_address2->CurrentValue, null, $this->contact_address2->ReadOnly);

            // contact_email
            $this->contact_email->setDbValueDef($rsnew, $this->contact_email->CurrentValue, null, $this->contact_email->ReadOnly);

            // contact_lineid
            $this->contact_lineid->setDbValueDef($rsnew, $this->contact_lineid->CurrentValue, null, $this->contact_lineid->ReadOnly);

            // contact_phone
            $this->contact_phone->setDbValueDef($rsnew, $this->contact_phone->CurrentValue, null, $this->contact_phone->ReadOnly);

            // cdate
            $this->cdate->CurrentValue = CurrentDateTime();
            $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

            // Check referential integrity for master table 'buyer_all_booking_asset'
            $detailKeys = [];
            $keyValue = $rsnew['buyer_booking_asset_id'] ?? $rsold['buyer_booking_asset_id'];
            $detailKeys['buyer_booking_asset_id'] = $keyValue;
            $masterTable = Container("buyer_all_booking_asset");
            $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
            if (!EmptyValue($masterFilter)) {
                $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
                $validMasterRecord = $rsmaster !== false;
            } else { // Allow null value if not required field
                $validMasterRecord = $masterFilter === null;
            }
            if (!$validMasterRecord) {
                $relatedRecordMsg = str_replace("%t", "buyer_all_booking_asset", $Language->phrase("RelatedRecordRequired"));
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
        if ($this->getCurrentMasterTable() == "buyer_all_booking_asset") {
            $this->buyer_booking_asset_id->CurrentValue = $this->buyer_booking_asset_id->getSessionValue();
        }

        // Check referential integrity for master table 'doc_juzmatch1'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["buyer_booking_asset_id"] = $this->buyer_booking_asset_id->getSessionValue();
        $masterTable = Container("buyer_all_booking_asset");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "buyer_all_booking_asset", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
            $this->file_idcard->OldUploadPath = "/upload/";
            $this->file_idcard->UploadPath = $this->file_idcard->OldUploadPath;
            $this->file_house_regis->OldUploadPath = "/upload/";
            $this->file_house_regis->UploadPath = $this->file_house_regis->OldUploadPath;
            $this->file_titledeed->OldUploadPath = "/upload/";
            $this->file_titledeed->UploadPath = $this->file_titledeed->OldUploadPath;
            $this->file_other->OldUploadPath = "/upload/";
            $this->file_other->UploadPath = $this->file_other->OldUploadPath;
        }
        $rsnew = [];

        // document_date
        $this->document_date->CurrentValue = CurrentDateTime();
        $this->document_date->setDbValueDef($rsnew, $this->document_date->CurrentValue, null);

        // asset_code
        $this->asset_code->setDbValueDef($rsnew, $this->asset_code->CurrentValue, null, false);

        // asset_deed
        $this->asset_deed->setDbValueDef($rsnew, $this->asset_deed->CurrentValue, null, false);

        // asset_project
        $this->asset_project->setDbValueDef($rsnew, $this->asset_project->CurrentValue, null, false);

        // asset_area
        $this->asset_area->setDbValueDef($rsnew, $this->asset_area->CurrentValue, null, false);

        // buyer_lname
        $this->buyer_lname->setDbValueDef($rsnew, $this->buyer_lname->CurrentValue, null, false);

        // buyer_email
        $this->buyer_email->setDbValueDef($rsnew, $this->buyer_email->CurrentValue, null, false);

        // buyer_idcard
        $this->buyer_idcard->setDbValueDef($rsnew, $this->buyer_idcard->CurrentValue, null, false);

        // buyer_homeno
        $this->buyer_homeno->setDbValueDef($rsnew, $this->buyer_homeno->CurrentValue, null, false);

        // buyer_witness_lname
        $this->buyer_witness_lname->setDbValueDef($rsnew, $this->buyer_witness_lname->CurrentValue, null, false);

        // buyer_witness_email
        $this->buyer_witness_email->setDbValueDef($rsnew, $this->buyer_witness_email->CurrentValue, null, false);

        // juzmatch_authority_lname
        $this->juzmatch_authority_lname->setDbValueDef($rsnew, $this->juzmatch_authority_lname->CurrentValue, null, false);

        // juzmatch_authority_email
        $this->juzmatch_authority_email->setDbValueDef($rsnew, $this->juzmatch_authority_email->CurrentValue, null, false);

        // juzmatch_authority_witness_lname
        $this->juzmatch_authority_witness_lname->setDbValueDef($rsnew, $this->juzmatch_authority_witness_lname->CurrentValue, null, false);

        // juzmatch_authority_witness_email
        $this->juzmatch_authority_witness_email->setDbValueDef($rsnew, $this->juzmatch_authority_witness_email->CurrentValue, null, false);

        // juzmatch_authority2_name
        $this->juzmatch_authority2_name->setDbValueDef($rsnew, $this->juzmatch_authority2_name->CurrentValue, null, false);

        // juzmatch_authority2_lname
        $this->juzmatch_authority2_lname->setDbValueDef($rsnew, $this->juzmatch_authority2_lname->CurrentValue, null, false);

        // juzmatch_authority2_email
        $this->juzmatch_authority2_email->setDbValueDef($rsnew, $this->juzmatch_authority2_email->CurrentValue, null, false);

        // company_seal_name
        $this->company_seal_name->setDbValueDef($rsnew, $this->company_seal_name->CurrentValue, null, false);

        // company_seal_email
        $this->company_seal_email->setDbValueDef($rsnew, $this->company_seal_email->CurrentValue, null, false);

        // service_price
        $this->service_price->setDbValueDef($rsnew, $this->service_price->CurrentValue, null, false);

        // service_price_txt
        $this->service_price_txt->setDbValueDef($rsnew, $this->service_price_txt->CurrentValue, null, false);

        // first_down
        $this->first_down->setDbValueDef($rsnew, $this->first_down->CurrentValue, null, false);

        // first_down_txt
        $this->first_down_txt->setDbValueDef($rsnew, $this->first_down_txt->CurrentValue, null, false);

        // second_down
        $this->second_down->setDbValueDef($rsnew, $this->second_down->CurrentValue, null, false);

        // second_down_txt
        $this->second_down_txt->setDbValueDef($rsnew, $this->second_down_txt->CurrentValue, null, false);

        // contact_address
        $this->contact_address->setDbValueDef($rsnew, $this->contact_address->CurrentValue, null, false);

        // contact_address2
        $this->contact_address2->setDbValueDef($rsnew, $this->contact_address2->CurrentValue, null, false);

        // contact_email
        $this->contact_email->setDbValueDef($rsnew, $this->contact_email->CurrentValue, null, false);

        // contact_lineid
        $this->contact_lineid->setDbValueDef($rsnew, $this->contact_lineid->CurrentValue, null, false);

        // contact_phone
        $this->contact_phone->setDbValueDef($rsnew, $this->contact_phone->CurrentValue, null, false);

        // cdate
        $this->cdate->CurrentValue = CurrentDateTime();
        $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

        // buyer_booking_asset_id
        if ($this->buyer_booking_asset_id->getSessionValue() != "") {
            $rsnew['buyer_booking_asset_id'] = $this->buyer_booking_asset_id->getSessionValue();
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
        if ($masterTblVar == "buyer_all_booking_asset") {
            $masterTbl = Container("buyer_all_booking_asset");
            $this->buyer_booking_asset_id->Visible = false;
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
                case "x_status":
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
