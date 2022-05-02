<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class DocJuzmatch2Grid extends DocJuzmatch2
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'doc_juzmatch2';

    // Page object name
    public $PageObjName = "DocJuzmatch2Grid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fdoc_juzmatch2grid";
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

        // Table object (doc_juzmatch2)
        if (!isset($GLOBALS["doc_juzmatch2"]) || get_class($GLOBALS["doc_juzmatch2"]) == PROJECT_NAMESPACE . "doc_juzmatch2") {
            $GLOBALS["doc_juzmatch2"] = &$this;
        }
        $this->AddUrl = "docjuzmatch2add";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'doc_juzmatch2');
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
                $tbl = Container("doc_juzmatch2");
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
		        $this->file_loan->OldUploadPath = "/upload/";
		        $this->file_loan->UploadPath = $this->file_loan->OldUploadPath;
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
        if ($this->isAddOrEdit()) {
            $this->doc_date->Visible = false;
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
        $this->asset_project->setVisibility();
        $this->asset_deed->setVisibility();
        $this->asset_area->setVisibility();
        $this->investor_name->Visible = false;
        $this->investor_lname->setVisibility();
        $this->investor_email->setVisibility();
        $this->investor_idcard->setVisibility();
        $this->investor_homeno->setVisibility();
        $this->investment_money->setVisibility();
        $this->investment_money_txt->Visible = false;
        $this->loan_contact_date->setVisibility();
        $this->contract_expired->setVisibility();
        $this->first_benefits_month->setVisibility();
        $this->one_installment_amount->setVisibility();
        $this->two_installment_amount1->setVisibility();
        $this->two_installment_amount2->setVisibility();
        $this->investor_paid_amount->setVisibility();
        $this->first_benefits_date->setVisibility();
        $this->one_benefit_amount->setVisibility();
        $this->two_benefit_amount1->setVisibility();
        $this->two_benefit_amount2->setVisibility();
        $this->management_agent_date->setVisibility();
        $this->begin_date->setVisibility();
        $this->investor_witness_name->Visible = false;
        $this->investor_witness_lname->setVisibility();
        $this->investor_witness_email->setVisibility();
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
        $this->file_idcard->Visible = false;
        $this->file_house_regis->Visible = false;
        $this->file_loan->setVisibility();
        $this->file_other->Visible = false;
        $this->contact_address->setVisibility();
        $this->contact_address2->setVisibility();
        $this->contact_email->setVisibility();
        $this->contact_lineid->setVisibility();
        $this->contact_phone->setVisibility();
        $this->attach_file->Visible = false;
        $this->status->Visible = false;
        $this->doc_creden_id->Visible = false;
        $this->cdate->setVisibility();
        $this->cuser->Visible = false;
        $this->cip->Visible = false;
        $this->udate->Visible = false;
        $this->uuser->Visible = false;
        $this->uip->Visible = false;
        $this->doc_date->Visible = false;
        $this->investor_booking_id->Visible = false;
        $this->first_down->Visible = false;
        $this->first_down_txt->Visible = false;
        $this->second_down->Visible = false;
        $this->second_down_txt->Visible = false;
        $this->service_price->Visible = false;
        $this->service_price_txt->Visible = false;
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
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "invertor_all_booking") {
            $masterTbl = Container("invertor_all_booking");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = count($rsmaster) > 0;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("invertorallbookinglist"); // Return to master page
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
        $this->investment_money->FormValue = ""; // Clear form value
        $this->one_installment_amount->FormValue = ""; // Clear form value
        $this->two_installment_amount1->FormValue = ""; // Clear form value
        $this->two_installment_amount2->FormValue = ""; // Clear form value
        $this->investor_paid_amount->FormValue = ""; // Clear form value
        $this->one_benefit_amount->FormValue = ""; // Clear form value
        $this->two_benefit_amount1->FormValue = ""; // Clear form value
        $this->two_benefit_amount2->FormValue = ""; // Clear form value
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
        if ($CurrentForm->hasValue("x_asset_project") && $CurrentForm->hasValue("o_asset_project") && $this->asset_project->CurrentValue != $this->asset_project->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_asset_deed") && $CurrentForm->hasValue("o_asset_deed") && $this->asset_deed->CurrentValue != $this->asset_deed->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_asset_area") && $CurrentForm->hasValue("o_asset_area") && $this->asset_area->CurrentValue != $this->asset_area->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_investor_lname") && $CurrentForm->hasValue("o_investor_lname") && $this->investor_lname->CurrentValue != $this->investor_lname->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_investor_email") && $CurrentForm->hasValue("o_investor_email") && $this->investor_email->CurrentValue != $this->investor_email->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_investor_idcard") && $CurrentForm->hasValue("o_investor_idcard") && $this->investor_idcard->CurrentValue != $this->investor_idcard->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_investor_homeno") && $CurrentForm->hasValue("o_investor_homeno") && $this->investor_homeno->CurrentValue != $this->investor_homeno->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_investment_money") && $CurrentForm->hasValue("o_investment_money") && $this->investment_money->CurrentValue != $this->investment_money->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_loan_contact_date") && $CurrentForm->hasValue("o_loan_contact_date") && $this->loan_contact_date->CurrentValue != $this->loan_contact_date->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_contract_expired") && $CurrentForm->hasValue("o_contract_expired") && $this->contract_expired->CurrentValue != $this->contract_expired->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_first_benefits_month") && $CurrentForm->hasValue("o_first_benefits_month") && $this->first_benefits_month->CurrentValue != $this->first_benefits_month->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_one_installment_amount") && $CurrentForm->hasValue("o_one_installment_amount") && $this->one_installment_amount->CurrentValue != $this->one_installment_amount->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_two_installment_amount1") && $CurrentForm->hasValue("o_two_installment_amount1") && $this->two_installment_amount1->CurrentValue != $this->two_installment_amount1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_two_installment_amount2") && $CurrentForm->hasValue("o_two_installment_amount2") && $this->two_installment_amount2->CurrentValue != $this->two_installment_amount2->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_investor_paid_amount") && $CurrentForm->hasValue("o_investor_paid_amount") && $this->investor_paid_amount->CurrentValue != $this->investor_paid_amount->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_first_benefits_date") && $CurrentForm->hasValue("o_first_benefits_date") && $this->first_benefits_date->CurrentValue != $this->first_benefits_date->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_one_benefit_amount") && $CurrentForm->hasValue("o_one_benefit_amount") && $this->one_benefit_amount->CurrentValue != $this->one_benefit_amount->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_two_benefit_amount1") && $CurrentForm->hasValue("o_two_benefit_amount1") && $this->two_benefit_amount1->CurrentValue != $this->two_benefit_amount1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_two_benefit_amount2") && $CurrentForm->hasValue("o_two_benefit_amount2") && $this->two_benefit_amount2->CurrentValue != $this->two_benefit_amount2->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_management_agent_date") && $CurrentForm->hasValue("o_management_agent_date") && $this->management_agent_date->CurrentValue != $this->management_agent_date->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_begin_date") && $CurrentForm->hasValue("o_begin_date") && $this->begin_date->CurrentValue != $this->begin_date->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_investor_witness_lname") && $CurrentForm->hasValue("o_investor_witness_lname") && $this->investor_witness_lname->CurrentValue != $this->investor_witness_lname->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_investor_witness_email") && $CurrentForm->hasValue("o_investor_witness_email") && $this->investor_witness_email->CurrentValue != $this->investor_witness_email->OldValue) {
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
        if (!EmptyValue($this->file_loan->Upload->Value)) {
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
        $this->asset_project->clearErrorMessage();
        $this->asset_deed->clearErrorMessage();
        $this->asset_area->clearErrorMessage();
        $this->investor_lname->clearErrorMessage();
        $this->investor_email->clearErrorMessage();
        $this->investor_idcard->clearErrorMessage();
        $this->investor_homeno->clearErrorMessage();
        $this->investment_money->clearErrorMessage();
        $this->loan_contact_date->clearErrorMessage();
        $this->contract_expired->clearErrorMessage();
        $this->first_benefits_month->clearErrorMessage();
        $this->one_installment_amount->clearErrorMessage();
        $this->two_installment_amount1->clearErrorMessage();
        $this->two_installment_amount2->clearErrorMessage();
        $this->investor_paid_amount->clearErrorMessage();
        $this->first_benefits_date->clearErrorMessage();
        $this->one_benefit_amount->clearErrorMessage();
        $this->two_benefit_amount1->clearErrorMessage();
        $this->two_benefit_amount2->clearErrorMessage();
        $this->management_agent_date->clearErrorMessage();
        $this->begin_date->clearErrorMessage();
        $this->investor_witness_lname->clearErrorMessage();
        $this->investor_witness_email->clearErrorMessage();
        $this->juzmatch_authority_lname->clearErrorMessage();
        $this->juzmatch_authority_email->clearErrorMessage();
        $this->juzmatch_authority_witness_lname->clearErrorMessage();
        $this->juzmatch_authority_witness_email->clearErrorMessage();
        $this->juzmatch_authority2_name->clearErrorMessage();
        $this->juzmatch_authority2_lname->clearErrorMessage();
        $this->juzmatch_authority2_email->clearErrorMessage();
        $this->company_seal_name->clearErrorMessage();
        $this->company_seal_email->clearErrorMessage();
        $this->file_loan->clearErrorMessage();
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
                        $this->investor_booking_id->setSessionValue("");
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
        $this->file_loan->Upload->Index = $CurrentForm->Index;
        $this->file_loan->Upload->uploadFile();
        $this->file_loan->CurrentValue = $this->file_loan->Upload->FileName;
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
        $this->asset_project->CurrentValue = null;
        $this->asset_project->OldValue = $this->asset_project->CurrentValue;
        $this->asset_deed->CurrentValue = null;
        $this->asset_deed->OldValue = $this->asset_deed->CurrentValue;
        $this->asset_area->CurrentValue = null;
        $this->asset_area->OldValue = $this->asset_area->CurrentValue;
        $this->investor_name->CurrentValue = null;
        $this->investor_name->OldValue = $this->investor_name->CurrentValue;
        $this->investor_lname->CurrentValue = null;
        $this->investor_lname->OldValue = $this->investor_lname->CurrentValue;
        $this->investor_email->CurrentValue = null;
        $this->investor_email->OldValue = $this->investor_email->CurrentValue;
        $this->investor_idcard->CurrentValue = null;
        $this->investor_idcard->OldValue = $this->investor_idcard->CurrentValue;
        $this->investor_homeno->CurrentValue = null;
        $this->investor_homeno->OldValue = $this->investor_homeno->CurrentValue;
        $this->investment_money->CurrentValue = null;
        $this->investment_money->OldValue = $this->investment_money->CurrentValue;
        $this->investment_money_txt->CurrentValue = null;
        $this->investment_money_txt->OldValue = $this->investment_money_txt->CurrentValue;
        $this->loan_contact_date->CurrentValue = null;
        $this->loan_contact_date->OldValue = $this->loan_contact_date->CurrentValue;
        $this->contract_expired->CurrentValue = null;
        $this->contract_expired->OldValue = $this->contract_expired->CurrentValue;
        $this->first_benefits_month->CurrentValue = null;
        $this->first_benefits_month->OldValue = $this->first_benefits_month->CurrentValue;
        $this->one_installment_amount->CurrentValue = null;
        $this->one_installment_amount->OldValue = $this->one_installment_amount->CurrentValue;
        $this->two_installment_amount1->CurrentValue = null;
        $this->two_installment_amount1->OldValue = $this->two_installment_amount1->CurrentValue;
        $this->two_installment_amount2->CurrentValue = null;
        $this->two_installment_amount2->OldValue = $this->two_installment_amount2->CurrentValue;
        $this->investor_paid_amount->CurrentValue = null;
        $this->investor_paid_amount->OldValue = $this->investor_paid_amount->CurrentValue;
        $this->first_benefits_date->CurrentValue = null;
        $this->first_benefits_date->OldValue = $this->first_benefits_date->CurrentValue;
        $this->one_benefit_amount->CurrentValue = null;
        $this->one_benefit_amount->OldValue = $this->one_benefit_amount->CurrentValue;
        $this->two_benefit_amount1->CurrentValue = null;
        $this->two_benefit_amount1->OldValue = $this->two_benefit_amount1->CurrentValue;
        $this->two_benefit_amount2->CurrentValue = null;
        $this->two_benefit_amount2->OldValue = $this->two_benefit_amount2->CurrentValue;
        $this->management_agent_date->CurrentValue = null;
        $this->management_agent_date->OldValue = $this->management_agent_date->CurrentValue;
        $this->begin_date->CurrentValue = null;
        $this->begin_date->OldValue = $this->begin_date->CurrentValue;
        $this->investor_witness_name->CurrentValue = null;
        $this->investor_witness_name->OldValue = $this->investor_witness_name->CurrentValue;
        $this->investor_witness_lname->CurrentValue = null;
        $this->investor_witness_lname->OldValue = $this->investor_witness_lname->CurrentValue;
        $this->investor_witness_email->CurrentValue = null;
        $this->investor_witness_email->OldValue = $this->investor_witness_email->CurrentValue;
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
        $this->file_idcard->Upload->DbValue = null;
        $this->file_idcard->OldValue = $this->file_idcard->Upload->DbValue;
        $this->file_idcard->Upload->Index = $this->RowIndex;
        $this->file_house_regis->Upload->DbValue = null;
        $this->file_house_regis->OldValue = $this->file_house_regis->Upload->DbValue;
        $this->file_house_regis->Upload->Index = $this->RowIndex;
        $this->file_loan->Upload->DbValue = null;
        $this->file_loan->OldValue = $this->file_loan->Upload->DbValue;
        $this->file_loan->Upload->Index = $this->RowIndex;
        $this->file_other->Upload->DbValue = null;
        $this->file_other->OldValue = $this->file_other->Upload->DbValue;
        $this->file_other->Upload->Index = $this->RowIndex;
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
        $this->attach_file->CurrentValue = null;
        $this->attach_file->OldValue = $this->attach_file->CurrentValue;
        $this->status->CurrentValue = 0;
        $this->status->OldValue = $this->status->CurrentValue;
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
        $this->doc_date->CurrentValue = null;
        $this->doc_date->OldValue = $this->doc_date->CurrentValue;
        $this->investor_booking_id->CurrentValue = null;
        $this->investor_booking_id->OldValue = $this->investor_booking_id->CurrentValue;
        $this->first_down->CurrentValue = null;
        $this->first_down->OldValue = $this->first_down->CurrentValue;
        $this->first_down_txt->CurrentValue = null;
        $this->first_down_txt->OldValue = $this->first_down_txt->CurrentValue;
        $this->second_down->CurrentValue = null;
        $this->second_down->OldValue = $this->second_down->CurrentValue;
        $this->second_down_txt->CurrentValue = null;
        $this->second_down_txt->OldValue = $this->second_down_txt->CurrentValue;
        $this->service_price->CurrentValue = null;
        $this->service_price->OldValue = $this->service_price->CurrentValue;
        $this->service_price_txt->CurrentValue = null;
        $this->service_price_txt->OldValue = $this->service_price_txt->CurrentValue;
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

        // Check field name 'investor_lname' first before field var 'x_investor_lname'
        $val = $CurrentForm->hasValue("investor_lname") ? $CurrentForm->getValue("investor_lname") : $CurrentForm->getValue("x_investor_lname");
        if (!$this->investor_lname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_lname->Visible = false; // Disable update for API request
            } else {
                $this->investor_lname->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_investor_lname")) {
            $this->investor_lname->setOldValue($CurrentForm->getValue("o_investor_lname"));
        }

        // Check field name 'investor_email' first before field var 'x_investor_email'
        $val = $CurrentForm->hasValue("investor_email") ? $CurrentForm->getValue("investor_email") : $CurrentForm->getValue("x_investor_email");
        if (!$this->investor_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_email->Visible = false; // Disable update for API request
            } else {
                $this->investor_email->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_investor_email")) {
            $this->investor_email->setOldValue($CurrentForm->getValue("o_investor_email"));
        }

        // Check field name 'investor_idcard' first before field var 'x_investor_idcard'
        $val = $CurrentForm->hasValue("investor_idcard") ? $CurrentForm->getValue("investor_idcard") : $CurrentForm->getValue("x_investor_idcard");
        if (!$this->investor_idcard->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_idcard->Visible = false; // Disable update for API request
            } else {
                $this->investor_idcard->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_investor_idcard")) {
            $this->investor_idcard->setOldValue($CurrentForm->getValue("o_investor_idcard"));
        }

        // Check field name 'investor_homeno' first before field var 'x_investor_homeno'
        $val = $CurrentForm->hasValue("investor_homeno") ? $CurrentForm->getValue("investor_homeno") : $CurrentForm->getValue("x_investor_homeno");
        if (!$this->investor_homeno->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_homeno->Visible = false; // Disable update for API request
            } else {
                $this->investor_homeno->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_investor_homeno")) {
            $this->investor_homeno->setOldValue($CurrentForm->getValue("o_investor_homeno"));
        }

        // Check field name 'investment_money' first before field var 'x_investment_money'
        $val = $CurrentForm->hasValue("investment_money") ? $CurrentForm->getValue("investment_money") : $CurrentForm->getValue("x_investment_money");
        if (!$this->investment_money->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investment_money->Visible = false; // Disable update for API request
            } else {
                $this->investment_money->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_investment_money")) {
            $this->investment_money->setOldValue($CurrentForm->getValue("o_investment_money"));
        }

        // Check field name 'loan_contact_date' first before field var 'x_loan_contact_date'
        $val = $CurrentForm->hasValue("loan_contact_date") ? $CurrentForm->getValue("loan_contact_date") : $CurrentForm->getValue("x_loan_contact_date");
        if (!$this->loan_contact_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->loan_contact_date->Visible = false; // Disable update for API request
            } else {
                $this->loan_contact_date->setFormValue($val, true, $validate);
            }
            $this->loan_contact_date->CurrentValue = UnFormatDateTime($this->loan_contact_date->CurrentValue, $this->loan_contact_date->formatPattern());
        }
        if ($CurrentForm->hasValue("o_loan_contact_date")) {
            $this->loan_contact_date->setOldValue($CurrentForm->getValue("o_loan_contact_date"));
        }

        // Check field name 'contract_expired' first before field var 'x_contract_expired'
        $val = $CurrentForm->hasValue("contract_expired") ? $CurrentForm->getValue("contract_expired") : $CurrentForm->getValue("x_contract_expired");
        if (!$this->contract_expired->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contract_expired->Visible = false; // Disable update for API request
            } else {
                $this->contract_expired->setFormValue($val, true, $validate);
            }
            $this->contract_expired->CurrentValue = UnFormatDateTime($this->contract_expired->CurrentValue, $this->contract_expired->formatPattern());
        }
        if ($CurrentForm->hasValue("o_contract_expired")) {
            $this->contract_expired->setOldValue($CurrentForm->getValue("o_contract_expired"));
        }

        // Check field name 'first_benefits_month' first before field var 'x_first_benefits_month'
        $val = $CurrentForm->hasValue("first_benefits_month") ? $CurrentForm->getValue("first_benefits_month") : $CurrentForm->getValue("x_first_benefits_month");
        if (!$this->first_benefits_month->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->first_benefits_month->Visible = false; // Disable update for API request
            } else {
                $this->first_benefits_month->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_first_benefits_month")) {
            $this->first_benefits_month->setOldValue($CurrentForm->getValue("o_first_benefits_month"));
        }

        // Check field name 'one_installment_amount' first before field var 'x_one_installment_amount'
        $val = $CurrentForm->hasValue("one_installment_amount") ? $CurrentForm->getValue("one_installment_amount") : $CurrentForm->getValue("x_one_installment_amount");
        if (!$this->one_installment_amount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->one_installment_amount->Visible = false; // Disable update for API request
            } else {
                $this->one_installment_amount->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_one_installment_amount")) {
            $this->one_installment_amount->setOldValue($CurrentForm->getValue("o_one_installment_amount"));
        }

        // Check field name 'two_installment_amount1' first before field var 'x_two_installment_amount1'
        $val = $CurrentForm->hasValue("two_installment_amount1") ? $CurrentForm->getValue("two_installment_amount1") : $CurrentForm->getValue("x_two_installment_amount1");
        if (!$this->two_installment_amount1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->two_installment_amount1->Visible = false; // Disable update for API request
            } else {
                $this->two_installment_amount1->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_two_installment_amount1")) {
            $this->two_installment_amount1->setOldValue($CurrentForm->getValue("o_two_installment_amount1"));
        }

        // Check field name 'two_installment_amount2' first before field var 'x_two_installment_amount2'
        $val = $CurrentForm->hasValue("two_installment_amount2") ? $CurrentForm->getValue("two_installment_amount2") : $CurrentForm->getValue("x_two_installment_amount2");
        if (!$this->two_installment_amount2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->two_installment_amount2->Visible = false; // Disable update for API request
            } else {
                $this->two_installment_amount2->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_two_installment_amount2")) {
            $this->two_installment_amount2->setOldValue($CurrentForm->getValue("o_two_installment_amount2"));
        }

        // Check field name 'investor_paid_amount' first before field var 'x_investor_paid_amount'
        $val = $CurrentForm->hasValue("investor_paid_amount") ? $CurrentForm->getValue("investor_paid_amount") : $CurrentForm->getValue("x_investor_paid_amount");
        if (!$this->investor_paid_amount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_paid_amount->Visible = false; // Disable update for API request
            } else {
                $this->investor_paid_amount->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_investor_paid_amount")) {
            $this->investor_paid_amount->setOldValue($CurrentForm->getValue("o_investor_paid_amount"));
        }

        // Check field name 'first_benefits_date' first before field var 'x_first_benefits_date'
        $val = $CurrentForm->hasValue("first_benefits_date") ? $CurrentForm->getValue("first_benefits_date") : $CurrentForm->getValue("x_first_benefits_date");
        if (!$this->first_benefits_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->first_benefits_date->Visible = false; // Disable update for API request
            } else {
                $this->first_benefits_date->setFormValue($val, true, $validate);
            }
            $this->first_benefits_date->CurrentValue = UnFormatDateTime($this->first_benefits_date->CurrentValue, $this->first_benefits_date->formatPattern());
        }
        if ($CurrentForm->hasValue("o_first_benefits_date")) {
            $this->first_benefits_date->setOldValue($CurrentForm->getValue("o_first_benefits_date"));
        }

        // Check field name 'one_benefit_amount' first before field var 'x_one_benefit_amount'
        $val = $CurrentForm->hasValue("one_benefit_amount") ? $CurrentForm->getValue("one_benefit_amount") : $CurrentForm->getValue("x_one_benefit_amount");
        if (!$this->one_benefit_amount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->one_benefit_amount->Visible = false; // Disable update for API request
            } else {
                $this->one_benefit_amount->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_one_benefit_amount")) {
            $this->one_benefit_amount->setOldValue($CurrentForm->getValue("o_one_benefit_amount"));
        }

        // Check field name 'two_benefit_amount1' first before field var 'x_two_benefit_amount1'
        $val = $CurrentForm->hasValue("two_benefit_amount1") ? $CurrentForm->getValue("two_benefit_amount1") : $CurrentForm->getValue("x_two_benefit_amount1");
        if (!$this->two_benefit_amount1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->two_benefit_amount1->Visible = false; // Disable update for API request
            } else {
                $this->two_benefit_amount1->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_two_benefit_amount1")) {
            $this->two_benefit_amount1->setOldValue($CurrentForm->getValue("o_two_benefit_amount1"));
        }

        // Check field name 'two_benefit_amount2' first before field var 'x_two_benefit_amount2'
        $val = $CurrentForm->hasValue("two_benefit_amount2") ? $CurrentForm->getValue("two_benefit_amount2") : $CurrentForm->getValue("x_two_benefit_amount2");
        if (!$this->two_benefit_amount2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->two_benefit_amount2->Visible = false; // Disable update for API request
            } else {
                $this->two_benefit_amount2->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_two_benefit_amount2")) {
            $this->two_benefit_amount2->setOldValue($CurrentForm->getValue("o_two_benefit_amount2"));
        }

        // Check field name 'management_agent_date' first before field var 'x_management_agent_date'
        $val = $CurrentForm->hasValue("management_agent_date") ? $CurrentForm->getValue("management_agent_date") : $CurrentForm->getValue("x_management_agent_date");
        if (!$this->management_agent_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->management_agent_date->Visible = false; // Disable update for API request
            } else {
                $this->management_agent_date->setFormValue($val, true, $validate);
            }
            $this->management_agent_date->CurrentValue = UnFormatDateTime($this->management_agent_date->CurrentValue, $this->management_agent_date->formatPattern());
        }
        if ($CurrentForm->hasValue("o_management_agent_date")) {
            $this->management_agent_date->setOldValue($CurrentForm->getValue("o_management_agent_date"));
        }

        // Check field name 'begin_date' first before field var 'x_begin_date'
        $val = $CurrentForm->hasValue("begin_date") ? $CurrentForm->getValue("begin_date") : $CurrentForm->getValue("x_begin_date");
        if (!$this->begin_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->begin_date->Visible = false; // Disable update for API request
            } else {
                $this->begin_date->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_begin_date")) {
            $this->begin_date->setOldValue($CurrentForm->getValue("o_begin_date"));
        }

        // Check field name 'investor_witness_lname' first before field var 'x_investor_witness_lname'
        $val = $CurrentForm->hasValue("investor_witness_lname") ? $CurrentForm->getValue("investor_witness_lname") : $CurrentForm->getValue("x_investor_witness_lname");
        if (!$this->investor_witness_lname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_witness_lname->Visible = false; // Disable update for API request
            } else {
                $this->investor_witness_lname->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_investor_witness_lname")) {
            $this->investor_witness_lname->setOldValue($CurrentForm->getValue("o_investor_witness_lname"));
        }

        // Check field name 'investor_witness_email' first before field var 'x_investor_witness_email'
        $val = $CurrentForm->hasValue("investor_witness_email") ? $CurrentForm->getValue("investor_witness_email") : $CurrentForm->getValue("x_investor_witness_email");
        if (!$this->investor_witness_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_witness_email->Visible = false; // Disable update for API request
            } else {
                $this->investor_witness_email->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_investor_witness_email")) {
            $this->investor_witness_email->setOldValue($CurrentForm->getValue("o_investor_witness_email"));
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
		$this->file_idcard->OldUploadPath = "/upload/";
		$this->file_idcard->UploadPath = $this->file_idcard->OldUploadPath;
		$this->file_house_regis->OldUploadPath = "/upload/";
		$this->file_house_regis->UploadPath = $this->file_house_regis->OldUploadPath;
		$this->file_loan->OldUploadPath = "/upload/";
		$this->file_loan->UploadPath = $this->file_loan->OldUploadPath;
		$this->file_other->OldUploadPath = "/upload/";
		$this->file_other->UploadPath = $this->file_other->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
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
        $this->asset_project->CurrentValue = $this->asset_project->FormValue;
        $this->asset_deed->CurrentValue = $this->asset_deed->FormValue;
        $this->asset_area->CurrentValue = $this->asset_area->FormValue;
        $this->investor_lname->CurrentValue = $this->investor_lname->FormValue;
        $this->investor_email->CurrentValue = $this->investor_email->FormValue;
        $this->investor_idcard->CurrentValue = $this->investor_idcard->FormValue;
        $this->investor_homeno->CurrentValue = $this->investor_homeno->FormValue;
        $this->investment_money->CurrentValue = $this->investment_money->FormValue;
        $this->loan_contact_date->CurrentValue = $this->loan_contact_date->FormValue;
        $this->loan_contact_date->CurrentValue = UnFormatDateTime($this->loan_contact_date->CurrentValue, $this->loan_contact_date->formatPattern());
        $this->contract_expired->CurrentValue = $this->contract_expired->FormValue;
        $this->contract_expired->CurrentValue = UnFormatDateTime($this->contract_expired->CurrentValue, $this->contract_expired->formatPattern());
        $this->first_benefits_month->CurrentValue = $this->first_benefits_month->FormValue;
        $this->one_installment_amount->CurrentValue = $this->one_installment_amount->FormValue;
        $this->two_installment_amount1->CurrentValue = $this->two_installment_amount1->FormValue;
        $this->two_installment_amount2->CurrentValue = $this->two_installment_amount2->FormValue;
        $this->investor_paid_amount->CurrentValue = $this->investor_paid_amount->FormValue;
        $this->first_benefits_date->CurrentValue = $this->first_benefits_date->FormValue;
        $this->first_benefits_date->CurrentValue = UnFormatDateTime($this->first_benefits_date->CurrentValue, $this->first_benefits_date->formatPattern());
        $this->one_benefit_amount->CurrentValue = $this->one_benefit_amount->FormValue;
        $this->two_benefit_amount1->CurrentValue = $this->two_benefit_amount1->FormValue;
        $this->two_benefit_amount2->CurrentValue = $this->two_benefit_amount2->FormValue;
        $this->management_agent_date->CurrentValue = $this->management_agent_date->FormValue;
        $this->management_agent_date->CurrentValue = UnFormatDateTime($this->management_agent_date->CurrentValue, $this->management_agent_date->formatPattern());
        $this->begin_date->CurrentValue = $this->begin_date->FormValue;
        $this->investor_witness_lname->CurrentValue = $this->investor_witness_lname->FormValue;
        $this->investor_witness_email->CurrentValue = $this->investor_witness_email->FormValue;
        $this->juzmatch_authority_lname->CurrentValue = $this->juzmatch_authority_lname->FormValue;
        $this->juzmatch_authority_email->CurrentValue = $this->juzmatch_authority_email->FormValue;
        $this->juzmatch_authority_witness_lname->CurrentValue = $this->juzmatch_authority_witness_lname->FormValue;
        $this->juzmatch_authority_witness_email->CurrentValue = $this->juzmatch_authority_witness_email->FormValue;
        $this->juzmatch_authority2_name->CurrentValue = $this->juzmatch_authority2_name->FormValue;
        $this->juzmatch_authority2_lname->CurrentValue = $this->juzmatch_authority2_lname->FormValue;
        $this->juzmatch_authority2_email->CurrentValue = $this->juzmatch_authority2_email->FormValue;
        $this->company_seal_name->CurrentValue = $this->company_seal_name->FormValue;
        $this->company_seal_email->CurrentValue = $this->company_seal_email->FormValue;
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
        $this->asset_project->setDbValue($row['asset_project']);
        $this->asset_deed->setDbValue($row['asset_deed']);
        $this->asset_area->setDbValue($row['asset_area']);
        $this->investor_name->setDbValue($row['investor_name']);
        $this->investor_lname->setDbValue($row['investor_lname']);
        $this->investor_email->setDbValue($row['investor_email']);
        $this->investor_idcard->setDbValue($row['investor_idcard']);
        $this->investor_homeno->setDbValue($row['investor_homeno']);
        $this->investment_money->setDbValue($row['investment_money']);
        $this->investment_money_txt->setDbValue($row['investment_money_txt']);
        $this->loan_contact_date->setDbValue($row['loan_contact_date']);
        $this->contract_expired->setDbValue($row['contract_expired']);
        $this->first_benefits_month->setDbValue($row['first_benefits_month']);
        $this->one_installment_amount->setDbValue($row['one_installment_amount']);
        $this->two_installment_amount1->setDbValue($row['two_installment_amount1']);
        $this->two_installment_amount2->setDbValue($row['two_installment_amount2']);
        $this->investor_paid_amount->setDbValue($row['investor_paid_amount']);
        $this->first_benefits_date->setDbValue($row['first_benefits_date']);
        $this->one_benefit_amount->setDbValue($row['one_benefit_amount']);
        $this->two_benefit_amount1->setDbValue($row['two_benefit_amount1']);
        $this->two_benefit_amount2->setDbValue($row['two_benefit_amount2']);
        $this->management_agent_date->setDbValue($row['management_agent_date']);
        $this->begin_date->setDbValue($row['begin_date']);
        $this->investor_witness_name->setDbValue($row['investor_witness_name']);
        $this->investor_witness_lname->setDbValue($row['investor_witness_lname']);
        $this->investor_witness_email->setDbValue($row['investor_witness_email']);
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
        $this->file_idcard->Upload->DbValue = $row['file_idcard'];
        $this->file_idcard->setDbValue($this->file_idcard->Upload->DbValue);
        $this->file_idcard->Upload->Index = $this->RowIndex;
        $this->file_house_regis->Upload->DbValue = $row['file_house_regis'];
        $this->file_house_regis->setDbValue($this->file_house_regis->Upload->DbValue);
        $this->file_house_regis->Upload->Index = $this->RowIndex;
        $this->file_loan->Upload->DbValue = $row['file_loan'];
        $this->file_loan->setDbValue($this->file_loan->Upload->DbValue);
        $this->file_loan->Upload->Index = $this->RowIndex;
        $this->file_other->Upload->DbValue = $row['file_other'];
        $this->file_other->setDbValue($this->file_other->Upload->DbValue);
        $this->file_other->Upload->Index = $this->RowIndex;
        $this->contact_address->setDbValue($row['contact_address']);
        $this->contact_address2->setDbValue($row['contact_address2']);
        $this->contact_email->setDbValue($row['contact_email']);
        $this->contact_lineid->setDbValue($row['contact_lineid']);
        $this->contact_phone->setDbValue($row['contact_phone']);
        $this->attach_file->setDbValue($row['attach_file']);
        $this->status->setDbValue($row['status']);
        $this->doc_creden_id->setDbValue($row['doc_creden_id']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->doc_date->setDbValue($row['doc_date']);
        $this->investor_booking_id->setDbValue($row['investor_booking_id']);
        $this->first_down->setDbValue($row['first_down']);
        $this->first_down_txt->setDbValue($row['first_down_txt']);
        $this->second_down->setDbValue($row['second_down']);
        $this->second_down_txt->setDbValue($row['second_down_txt']);
        $this->service_price->setDbValue($row['service_price']);
        $this->service_price_txt->setDbValue($row['service_price_txt']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['document_date'] = $this->document_date->CurrentValue;
        $row['asset_code'] = $this->asset_code->CurrentValue;
        $row['asset_project'] = $this->asset_project->CurrentValue;
        $row['asset_deed'] = $this->asset_deed->CurrentValue;
        $row['asset_area'] = $this->asset_area->CurrentValue;
        $row['investor_name'] = $this->investor_name->CurrentValue;
        $row['investor_lname'] = $this->investor_lname->CurrentValue;
        $row['investor_email'] = $this->investor_email->CurrentValue;
        $row['investor_idcard'] = $this->investor_idcard->CurrentValue;
        $row['investor_homeno'] = $this->investor_homeno->CurrentValue;
        $row['investment_money'] = $this->investment_money->CurrentValue;
        $row['investment_money_txt'] = $this->investment_money_txt->CurrentValue;
        $row['loan_contact_date'] = $this->loan_contact_date->CurrentValue;
        $row['contract_expired'] = $this->contract_expired->CurrentValue;
        $row['first_benefits_month'] = $this->first_benefits_month->CurrentValue;
        $row['one_installment_amount'] = $this->one_installment_amount->CurrentValue;
        $row['two_installment_amount1'] = $this->two_installment_amount1->CurrentValue;
        $row['two_installment_amount2'] = $this->two_installment_amount2->CurrentValue;
        $row['investor_paid_amount'] = $this->investor_paid_amount->CurrentValue;
        $row['first_benefits_date'] = $this->first_benefits_date->CurrentValue;
        $row['one_benefit_amount'] = $this->one_benefit_amount->CurrentValue;
        $row['two_benefit_amount1'] = $this->two_benefit_amount1->CurrentValue;
        $row['two_benefit_amount2'] = $this->two_benefit_amount2->CurrentValue;
        $row['management_agent_date'] = $this->management_agent_date->CurrentValue;
        $row['begin_date'] = $this->begin_date->CurrentValue;
        $row['investor_witness_name'] = $this->investor_witness_name->CurrentValue;
        $row['investor_witness_lname'] = $this->investor_witness_lname->CurrentValue;
        $row['investor_witness_email'] = $this->investor_witness_email->CurrentValue;
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
        $row['file_idcard'] = $this->file_idcard->Upload->DbValue;
        $row['file_house_regis'] = $this->file_house_regis->Upload->DbValue;
        $row['file_loan'] = $this->file_loan->Upload->DbValue;
        $row['file_other'] = $this->file_other->Upload->DbValue;
        $row['contact_address'] = $this->contact_address->CurrentValue;
        $row['contact_address2'] = $this->contact_address2->CurrentValue;
        $row['contact_email'] = $this->contact_email->CurrentValue;
        $row['contact_lineid'] = $this->contact_lineid->CurrentValue;
        $row['contact_phone'] = $this->contact_phone->CurrentValue;
        $row['attach_file'] = $this->attach_file->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['doc_creden_id'] = $this->doc_creden_id->CurrentValue;
        $row['cdate'] = $this->cdate->CurrentValue;
        $row['cuser'] = $this->cuser->CurrentValue;
        $row['cip'] = $this->cip->CurrentValue;
        $row['udate'] = $this->udate->CurrentValue;
        $row['uuser'] = $this->uuser->CurrentValue;
        $row['uip'] = $this->uip->CurrentValue;
        $row['doc_date'] = $this->doc_date->CurrentValue;
        $row['investor_booking_id'] = $this->investor_booking_id->CurrentValue;
        $row['first_down'] = $this->first_down->CurrentValue;
        $row['first_down_txt'] = $this->first_down_txt->CurrentValue;
        $row['second_down'] = $this->second_down->CurrentValue;
        $row['second_down_txt'] = $this->second_down_txt->CurrentValue;
        $row['service_price'] = $this->service_price->CurrentValue;
        $row['service_price_txt'] = $this->service_price_txt->CurrentValue;
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

        // asset_project

        // asset_deed

        // asset_area

        // investor_name

        // investor_lname

        // investor_email

        // investor_idcard

        // investor_homeno

        // investment_money

        // investment_money_txt

        // loan_contact_date

        // contract_expired

        // first_benefits_month

        // one_installment_amount

        // two_installment_amount1

        // two_installment_amount2

        // investor_paid_amount

        // first_benefits_date

        // one_benefit_amount

        // two_benefit_amount1

        // two_benefit_amount2

        // management_agent_date

        // begin_date

        // investor_witness_name

        // investor_witness_lname

        // investor_witness_email

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

        // file_idcard

        // file_house_regis

        // file_loan

        // file_other

        // contact_address

        // contact_address2

        // contact_email

        // contact_lineid

        // contact_phone

        // attach_file
        $this->attach_file->CellCssStyle = "white-space: nowrap;";

        // status
        $this->status->CellCssStyle = "white-space: nowrap;";

        // doc_creden_id
        $this->doc_creden_id->CellCssStyle = "white-space: nowrap;";

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // doc_date
        $this->doc_date->CellCssStyle = "white-space: nowrap;";

        // investor_booking_id
        $this->investor_booking_id->CellCssStyle = "white-space: nowrap;";

        // first_down
        $this->first_down->CellCssStyle = "white-space: nowrap;";

        // first_down_txt
        $this->first_down_txt->CellCssStyle = "white-space: nowrap;";

        // second_down
        $this->second_down->CellCssStyle = "white-space: nowrap;";

        // second_down_txt
        $this->second_down_txt->CellCssStyle = "white-space: nowrap;";

        // service_price
        $this->service_price->CellCssStyle = "white-space: nowrap;";

        // service_price_txt
        $this->service_price_txt->CellCssStyle = "white-space: nowrap;";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // document_date
            $this->document_date->ViewValue = $this->document_date->CurrentValue;
            $this->document_date->ViewValue = FormatDateTime($this->document_date->ViewValue, $this->document_date->formatPattern());
            $this->document_date->ViewCustomAttributes = "";

            // asset_code
            $this->asset_code->ViewValue = $this->asset_code->CurrentValue;
            $this->asset_code->ViewCustomAttributes = "";

            // asset_project
            $this->asset_project->ViewValue = $this->asset_project->CurrentValue;
            $this->asset_project->ViewCustomAttributes = "";

            // asset_deed
            $this->asset_deed->ViewValue = $this->asset_deed->CurrentValue;
            $this->asset_deed->ViewCustomAttributes = "";

            // asset_area
            $this->asset_area->ViewValue = $this->asset_area->CurrentValue;
            $this->asset_area->ViewCustomAttributes = "";

            // investor_lname
            $this->investor_lname->ViewValue = $this->investor_lname->CurrentValue;
            $this->investor_lname->ViewCustomAttributes = "";

            // investor_email
            $this->investor_email->ViewValue = $this->investor_email->CurrentValue;
            $this->investor_email->ViewCustomAttributes = "";

            // investor_idcard
            $this->investor_idcard->ViewValue = $this->investor_idcard->CurrentValue;
            $this->investor_idcard->ViewCustomAttributes = "";

            // investor_homeno
            $this->investor_homeno->ViewValue = $this->investor_homeno->CurrentValue;
            $this->investor_homeno->ViewCustomAttributes = "";

            // investment_money
            $this->investment_money->ViewValue = $this->investment_money->CurrentValue;
            $this->investment_money->ViewValue = FormatNumber($this->investment_money->ViewValue, $this->investment_money->formatPattern());
            $this->investment_money->ViewCustomAttributes = "";

            // loan_contact_date
            $this->loan_contact_date->ViewValue = $this->loan_contact_date->CurrentValue;
            $this->loan_contact_date->ViewValue = FormatDateTime($this->loan_contact_date->ViewValue, $this->loan_contact_date->formatPattern());
            $this->loan_contact_date->ViewCustomAttributes = "";

            // contract_expired
            $this->contract_expired->ViewValue = $this->contract_expired->CurrentValue;
            $this->contract_expired->ViewValue = FormatDateTime($this->contract_expired->ViewValue, $this->contract_expired->formatPattern());
            $this->contract_expired->ViewCustomAttributes = "";

            // first_benefits_month
            $this->first_benefits_month->ViewValue = $this->first_benefits_month->CurrentValue;
            $this->first_benefits_month->ViewValue = FormatNumber($this->first_benefits_month->ViewValue, $this->first_benefits_month->formatPattern());
            $this->first_benefits_month->ViewCustomAttributes = "";

            // one_installment_amount
            $this->one_installment_amount->ViewValue = $this->one_installment_amount->CurrentValue;
            $this->one_installment_amount->ViewValue = FormatNumber($this->one_installment_amount->ViewValue, $this->one_installment_amount->formatPattern());
            $this->one_installment_amount->ViewCustomAttributes = "";

            // two_installment_amount1
            $this->two_installment_amount1->ViewValue = $this->two_installment_amount1->CurrentValue;
            $this->two_installment_amount1->ViewValue = FormatNumber($this->two_installment_amount1->ViewValue, $this->two_installment_amount1->formatPattern());
            $this->two_installment_amount1->ViewCustomAttributes = "";

            // two_installment_amount2
            $this->two_installment_amount2->ViewValue = $this->two_installment_amount2->CurrentValue;
            $this->two_installment_amount2->ViewValue = FormatNumber($this->two_installment_amount2->ViewValue, $this->two_installment_amount2->formatPattern());
            $this->two_installment_amount2->ViewCustomAttributes = "";

            // investor_paid_amount
            $this->investor_paid_amount->ViewValue = $this->investor_paid_amount->CurrentValue;
            $this->investor_paid_amount->ViewValue = FormatNumber($this->investor_paid_amount->ViewValue, $this->investor_paid_amount->formatPattern());
            $this->investor_paid_amount->ViewCustomAttributes = "";

            // first_benefits_date
            $this->first_benefits_date->ViewValue = $this->first_benefits_date->CurrentValue;
            $this->first_benefits_date->ViewValue = FormatDateTime($this->first_benefits_date->ViewValue, $this->first_benefits_date->formatPattern());
            $this->first_benefits_date->ViewCustomAttributes = "";

            // one_benefit_amount
            $this->one_benefit_amount->ViewValue = $this->one_benefit_amount->CurrentValue;
            $this->one_benefit_amount->ViewValue = FormatNumber($this->one_benefit_amount->ViewValue, $this->one_benefit_amount->formatPattern());
            $this->one_benefit_amount->ViewCustomAttributes = "";

            // two_benefit_amount1
            $this->two_benefit_amount1->ViewValue = $this->two_benefit_amount1->CurrentValue;
            $this->two_benefit_amount1->ViewValue = FormatNumber($this->two_benefit_amount1->ViewValue, $this->two_benefit_amount1->formatPattern());
            $this->two_benefit_amount1->ViewCustomAttributes = "";

            // two_benefit_amount2
            $this->two_benefit_amount2->ViewValue = $this->two_benefit_amount2->CurrentValue;
            $this->two_benefit_amount2->ViewValue = FormatNumber($this->two_benefit_amount2->ViewValue, $this->two_benefit_amount2->formatPattern());
            $this->two_benefit_amount2->ViewCustomAttributes = "";

            // management_agent_date
            $this->management_agent_date->ViewValue = $this->management_agent_date->CurrentValue;
            $this->management_agent_date->ViewValue = FormatDateTime($this->management_agent_date->ViewValue, $this->management_agent_date->formatPattern());
            $this->management_agent_date->ViewCustomAttributes = "";

            // begin_date
            $this->begin_date->ViewValue = $this->begin_date->CurrentValue;
            $this->begin_date->ViewValue = FormatNumber($this->begin_date->ViewValue, $this->begin_date->formatPattern());
            $this->begin_date->ViewCustomAttributes = "";

            // investor_witness_lname
            $this->investor_witness_lname->ViewValue = $this->investor_witness_lname->CurrentValue;
            $this->investor_witness_lname->ViewCustomAttributes = "";

            // investor_witness_email
            $this->investor_witness_email->ViewValue = $this->investor_witness_email->CurrentValue;
            $this->investor_witness_email->ViewCustomAttributes = "";

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

            // file_loan
            $this->file_loan->UploadPath = "/upload/";
            if (!EmptyValue($this->file_loan->Upload->DbValue)) {
                $this->file_loan->ViewValue = $this->file_loan->Upload->DbValue;
            } else {
                $this->file_loan->ViewValue = "";
            }
            $this->file_loan->ViewCustomAttributes = "";

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

            // asset_project
            $this->asset_project->LinkCustomAttributes = "";
            $this->asset_project->HrefValue = "";
            $this->asset_project->TooltipValue = "";

            // asset_deed
            $this->asset_deed->LinkCustomAttributes = "";
            $this->asset_deed->HrefValue = "";
            $this->asset_deed->TooltipValue = "";

            // asset_area
            $this->asset_area->LinkCustomAttributes = "";
            $this->asset_area->HrefValue = "";
            $this->asset_area->TooltipValue = "";

            // investor_lname
            $this->investor_lname->LinkCustomAttributes = "";
            $this->investor_lname->HrefValue = "";
            $this->investor_lname->TooltipValue = "";

            // investor_email
            $this->investor_email->LinkCustomAttributes = "";
            $this->investor_email->HrefValue = "";
            $this->investor_email->TooltipValue = "";

            // investor_idcard
            $this->investor_idcard->LinkCustomAttributes = "";
            $this->investor_idcard->HrefValue = "";
            $this->investor_idcard->TooltipValue = "";

            // investor_homeno
            $this->investor_homeno->LinkCustomAttributes = "";
            $this->investor_homeno->HrefValue = "";
            $this->investor_homeno->TooltipValue = "";

            // investment_money
            $this->investment_money->LinkCustomAttributes = "";
            $this->investment_money->HrefValue = "";
            $this->investment_money->TooltipValue = "";

            // loan_contact_date
            $this->loan_contact_date->LinkCustomAttributes = "";
            $this->loan_contact_date->HrefValue = "";
            $this->loan_contact_date->TooltipValue = "";

            // contract_expired
            $this->contract_expired->LinkCustomAttributes = "";
            $this->contract_expired->HrefValue = "";
            $this->contract_expired->TooltipValue = "";

            // first_benefits_month
            $this->first_benefits_month->LinkCustomAttributes = "";
            $this->first_benefits_month->HrefValue = "";
            $this->first_benefits_month->TooltipValue = "";

            // one_installment_amount
            $this->one_installment_amount->LinkCustomAttributes = "";
            $this->one_installment_amount->HrefValue = "";
            $this->one_installment_amount->TooltipValue = "";

            // two_installment_amount1
            $this->two_installment_amount1->LinkCustomAttributes = "";
            $this->two_installment_amount1->HrefValue = "";
            $this->two_installment_amount1->TooltipValue = "";

            // two_installment_amount2
            $this->two_installment_amount2->LinkCustomAttributes = "";
            $this->two_installment_amount2->HrefValue = "";
            $this->two_installment_amount2->TooltipValue = "";

            // investor_paid_amount
            $this->investor_paid_amount->LinkCustomAttributes = "";
            $this->investor_paid_amount->HrefValue = "";
            $this->investor_paid_amount->TooltipValue = "";

            // first_benefits_date
            $this->first_benefits_date->LinkCustomAttributes = "";
            $this->first_benefits_date->HrefValue = "";
            $this->first_benefits_date->TooltipValue = "";

            // one_benefit_amount
            $this->one_benefit_amount->LinkCustomAttributes = "";
            $this->one_benefit_amount->HrefValue = "";
            $this->one_benefit_amount->TooltipValue = "";

            // two_benefit_amount1
            $this->two_benefit_amount1->LinkCustomAttributes = "";
            $this->two_benefit_amount1->HrefValue = "";
            $this->two_benefit_amount1->TooltipValue = "";

            // two_benefit_amount2
            $this->two_benefit_amount2->LinkCustomAttributes = "";
            $this->two_benefit_amount2->HrefValue = "";
            $this->two_benefit_amount2->TooltipValue = "";

            // management_agent_date
            $this->management_agent_date->LinkCustomAttributes = "";
            $this->management_agent_date->HrefValue = "";
            $this->management_agent_date->TooltipValue = "";

            // begin_date
            $this->begin_date->LinkCustomAttributes = "";
            $this->begin_date->HrefValue = "";
            $this->begin_date->TooltipValue = "";

            // investor_witness_lname
            $this->investor_witness_lname->LinkCustomAttributes = "";
            $this->investor_witness_lname->HrefValue = "";
            $this->investor_witness_lname->TooltipValue = "";

            // investor_witness_email
            $this->investor_witness_email->LinkCustomAttributes = "";
            $this->investor_witness_email->HrefValue = "";
            $this->investor_witness_email->TooltipValue = "";

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

            // file_loan
            $this->file_loan->LinkCustomAttributes = "";
            $this->file_loan->HrefValue = "";
            $this->file_loan->ExportHrefValue = $this->file_loan->UploadPath . $this->file_loan->Upload->DbValue;
            $this->file_loan->TooltipValue = "";

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

            // asset_project
            $this->asset_project->setupEditAttributes();
            $this->asset_project->EditCustomAttributes = "";
            if (!$this->asset_project->Raw) {
                $this->asset_project->CurrentValue = HtmlDecode($this->asset_project->CurrentValue);
            }
            $this->asset_project->EditValue = HtmlEncode($this->asset_project->CurrentValue);
            $this->asset_project->PlaceHolder = RemoveHtml($this->asset_project->caption());

            // asset_deed
            $this->asset_deed->setupEditAttributes();
            $this->asset_deed->EditCustomAttributes = "";
            if (!$this->asset_deed->Raw) {
                $this->asset_deed->CurrentValue = HtmlDecode($this->asset_deed->CurrentValue);
            }
            $this->asset_deed->EditValue = HtmlEncode($this->asset_deed->CurrentValue);
            $this->asset_deed->PlaceHolder = RemoveHtml($this->asset_deed->caption());

            // asset_area
            $this->asset_area->setupEditAttributes();
            $this->asset_area->EditCustomAttributes = "";
            if (!$this->asset_area->Raw) {
                $this->asset_area->CurrentValue = HtmlDecode($this->asset_area->CurrentValue);
            }
            $this->asset_area->EditValue = HtmlEncode($this->asset_area->CurrentValue);
            $this->asset_area->PlaceHolder = RemoveHtml($this->asset_area->caption());

            // investor_lname
            $this->investor_lname->setupEditAttributes();
            $this->investor_lname->EditCustomAttributes = "";
            if (!$this->investor_lname->Raw) {
                $this->investor_lname->CurrentValue = HtmlDecode($this->investor_lname->CurrentValue);
            }
            $this->investor_lname->EditValue = HtmlEncode($this->investor_lname->CurrentValue);
            $this->investor_lname->PlaceHolder = RemoveHtml($this->investor_lname->caption());

            // investor_email
            $this->investor_email->setupEditAttributes();
            $this->investor_email->EditCustomAttributes = "";
            if (!$this->investor_email->Raw) {
                $this->investor_email->CurrentValue = HtmlDecode($this->investor_email->CurrentValue);
            }
            $this->investor_email->EditValue = HtmlEncode($this->investor_email->CurrentValue);
            $this->investor_email->PlaceHolder = RemoveHtml($this->investor_email->caption());

            // investor_idcard
            $this->investor_idcard->setupEditAttributes();
            $this->investor_idcard->EditCustomAttributes = "";
            if (!$this->investor_idcard->Raw) {
                $this->investor_idcard->CurrentValue = HtmlDecode($this->investor_idcard->CurrentValue);
            }
            $this->investor_idcard->EditValue = HtmlEncode($this->investor_idcard->CurrentValue);
            $this->investor_idcard->PlaceHolder = RemoveHtml($this->investor_idcard->caption());

            // investor_homeno
            $this->investor_homeno->setupEditAttributes();
            $this->investor_homeno->EditCustomAttributes = "";
            if (!$this->investor_homeno->Raw) {
                $this->investor_homeno->CurrentValue = HtmlDecode($this->investor_homeno->CurrentValue);
            }
            $this->investor_homeno->EditValue = HtmlEncode($this->investor_homeno->CurrentValue);
            $this->investor_homeno->PlaceHolder = RemoveHtml($this->investor_homeno->caption());

            // investment_money
            $this->investment_money->setupEditAttributes();
            $this->investment_money->EditCustomAttributes = "";
            $this->investment_money->EditValue = HtmlEncode($this->investment_money->CurrentValue);
            $this->investment_money->PlaceHolder = RemoveHtml($this->investment_money->caption());
            if (strval($this->investment_money->EditValue) != "" && is_numeric($this->investment_money->EditValue)) {
                $this->investment_money->EditValue = FormatNumber($this->investment_money->EditValue, null);
                $this->investment_money->OldValue = $this->investment_money->EditValue;
            }

            // loan_contact_date
            $this->loan_contact_date->setupEditAttributes();
            $this->loan_contact_date->EditCustomAttributes = "";
            $this->loan_contact_date->EditValue = HtmlEncode(FormatDateTime($this->loan_contact_date->CurrentValue, $this->loan_contact_date->formatPattern()));
            $this->loan_contact_date->PlaceHolder = RemoveHtml($this->loan_contact_date->caption());

            // contract_expired
            $this->contract_expired->setupEditAttributes();
            $this->contract_expired->EditCustomAttributes = "";
            $this->contract_expired->EditValue = HtmlEncode(FormatDateTime($this->contract_expired->CurrentValue, $this->contract_expired->formatPattern()));
            $this->contract_expired->PlaceHolder = RemoveHtml($this->contract_expired->caption());

            // first_benefits_month
            $this->first_benefits_month->setupEditAttributes();
            $this->first_benefits_month->EditCustomAttributes = "";
            $this->first_benefits_month->EditValue = HtmlEncode($this->first_benefits_month->CurrentValue);
            $this->first_benefits_month->PlaceHolder = RemoveHtml($this->first_benefits_month->caption());
            if (strval($this->first_benefits_month->EditValue) != "" && is_numeric($this->first_benefits_month->EditValue)) {
                $this->first_benefits_month->EditValue = FormatNumber($this->first_benefits_month->EditValue, null);
                $this->first_benefits_month->OldValue = $this->first_benefits_month->EditValue;
            }

            // one_installment_amount
            $this->one_installment_amount->setupEditAttributes();
            $this->one_installment_amount->EditCustomAttributes = "";
            $this->one_installment_amount->EditValue = HtmlEncode($this->one_installment_amount->CurrentValue);
            $this->one_installment_amount->PlaceHolder = RemoveHtml($this->one_installment_amount->caption());
            if (strval($this->one_installment_amount->EditValue) != "" && is_numeric($this->one_installment_amount->EditValue)) {
                $this->one_installment_amount->EditValue = FormatNumber($this->one_installment_amount->EditValue, null);
                $this->one_installment_amount->OldValue = $this->one_installment_amount->EditValue;
            }

            // two_installment_amount1
            $this->two_installment_amount1->setupEditAttributes();
            $this->two_installment_amount1->EditCustomAttributes = "";
            $this->two_installment_amount1->EditValue = HtmlEncode($this->two_installment_amount1->CurrentValue);
            $this->two_installment_amount1->PlaceHolder = RemoveHtml($this->two_installment_amount1->caption());
            if (strval($this->two_installment_amount1->EditValue) != "" && is_numeric($this->two_installment_amount1->EditValue)) {
                $this->two_installment_amount1->EditValue = FormatNumber($this->two_installment_amount1->EditValue, null);
                $this->two_installment_amount1->OldValue = $this->two_installment_amount1->EditValue;
            }

            // two_installment_amount2
            $this->two_installment_amount2->setupEditAttributes();
            $this->two_installment_amount2->EditCustomAttributes = "";
            $this->two_installment_amount2->EditValue = HtmlEncode($this->two_installment_amount2->CurrentValue);
            $this->two_installment_amount2->PlaceHolder = RemoveHtml($this->two_installment_amount2->caption());
            if (strval($this->two_installment_amount2->EditValue) != "" && is_numeric($this->two_installment_amount2->EditValue)) {
                $this->two_installment_amount2->EditValue = FormatNumber($this->two_installment_amount2->EditValue, null);
                $this->two_installment_amount2->OldValue = $this->two_installment_amount2->EditValue;
            }

            // investor_paid_amount
            $this->investor_paid_amount->setupEditAttributes();
            $this->investor_paid_amount->EditCustomAttributes = "";
            $this->investor_paid_amount->EditValue = HtmlEncode($this->investor_paid_amount->CurrentValue);
            $this->investor_paid_amount->PlaceHolder = RemoveHtml($this->investor_paid_amount->caption());
            if (strval($this->investor_paid_amount->EditValue) != "" && is_numeric($this->investor_paid_amount->EditValue)) {
                $this->investor_paid_amount->EditValue = FormatNumber($this->investor_paid_amount->EditValue, null);
                $this->investor_paid_amount->OldValue = $this->investor_paid_amount->EditValue;
            }

            // first_benefits_date
            $this->first_benefits_date->setupEditAttributes();
            $this->first_benefits_date->EditCustomAttributes = "";
            $this->first_benefits_date->EditValue = HtmlEncode(FormatDateTime($this->first_benefits_date->CurrentValue, $this->first_benefits_date->formatPattern()));
            $this->first_benefits_date->PlaceHolder = RemoveHtml($this->first_benefits_date->caption());

            // one_benefit_amount
            $this->one_benefit_amount->setupEditAttributes();
            $this->one_benefit_amount->EditCustomAttributes = "";
            $this->one_benefit_amount->EditValue = HtmlEncode($this->one_benefit_amount->CurrentValue);
            $this->one_benefit_amount->PlaceHolder = RemoveHtml($this->one_benefit_amount->caption());
            if (strval($this->one_benefit_amount->EditValue) != "" && is_numeric($this->one_benefit_amount->EditValue)) {
                $this->one_benefit_amount->EditValue = FormatNumber($this->one_benefit_amount->EditValue, null);
                $this->one_benefit_amount->OldValue = $this->one_benefit_amount->EditValue;
            }

            // two_benefit_amount1
            $this->two_benefit_amount1->setupEditAttributes();
            $this->two_benefit_amount1->EditCustomAttributes = "";
            $this->two_benefit_amount1->EditValue = HtmlEncode($this->two_benefit_amount1->CurrentValue);
            $this->two_benefit_amount1->PlaceHolder = RemoveHtml($this->two_benefit_amount1->caption());
            if (strval($this->two_benefit_amount1->EditValue) != "" && is_numeric($this->two_benefit_amount1->EditValue)) {
                $this->two_benefit_amount1->EditValue = FormatNumber($this->two_benefit_amount1->EditValue, null);
                $this->two_benefit_amount1->OldValue = $this->two_benefit_amount1->EditValue;
            }

            // two_benefit_amount2
            $this->two_benefit_amount2->setupEditAttributes();
            $this->two_benefit_amount2->EditCustomAttributes = "";
            $this->two_benefit_amount2->EditValue = HtmlEncode($this->two_benefit_amount2->CurrentValue);
            $this->two_benefit_amount2->PlaceHolder = RemoveHtml($this->two_benefit_amount2->caption());
            if (strval($this->two_benefit_amount2->EditValue) != "" && is_numeric($this->two_benefit_amount2->EditValue)) {
                $this->two_benefit_amount2->EditValue = FormatNumber($this->two_benefit_amount2->EditValue, null);
                $this->two_benefit_amount2->OldValue = $this->two_benefit_amount2->EditValue;
            }

            // management_agent_date
            $this->management_agent_date->setupEditAttributes();
            $this->management_agent_date->EditCustomAttributes = "";
            $this->management_agent_date->EditValue = HtmlEncode(FormatDateTime($this->management_agent_date->CurrentValue, $this->management_agent_date->formatPattern()));
            $this->management_agent_date->PlaceHolder = RemoveHtml($this->management_agent_date->caption());

            // begin_date
            $this->begin_date->setupEditAttributes();
            $this->begin_date->EditCustomAttributes = "";
            $this->begin_date->EditValue = HtmlEncode($this->begin_date->CurrentValue);
            $this->begin_date->PlaceHolder = RemoveHtml($this->begin_date->caption());
            if (strval($this->begin_date->EditValue) != "" && is_numeric($this->begin_date->EditValue)) {
                $this->begin_date->EditValue = FormatNumber($this->begin_date->EditValue, null);
                $this->begin_date->OldValue = $this->begin_date->EditValue;
            }

            // investor_witness_lname
            $this->investor_witness_lname->setupEditAttributes();
            $this->investor_witness_lname->EditCustomAttributes = "";
            if (!$this->investor_witness_lname->Raw) {
                $this->investor_witness_lname->CurrentValue = HtmlDecode($this->investor_witness_lname->CurrentValue);
            }
            $this->investor_witness_lname->EditValue = HtmlEncode($this->investor_witness_lname->CurrentValue);
            $this->investor_witness_lname->PlaceHolder = RemoveHtml($this->investor_witness_lname->caption());

            // investor_witness_email
            $this->investor_witness_email->setupEditAttributes();
            $this->investor_witness_email->EditCustomAttributes = "";
            if (!$this->investor_witness_email->Raw) {
                $this->investor_witness_email->CurrentValue = HtmlDecode($this->investor_witness_email->CurrentValue);
            }
            $this->investor_witness_email->EditValue = HtmlEncode($this->investor_witness_email->CurrentValue);
            $this->investor_witness_email->PlaceHolder = RemoveHtml($this->investor_witness_email->caption());

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

            // file_loan
            $this->file_loan->setupEditAttributes();
            $this->file_loan->EditCustomAttributes = "";
            $this->file_loan->UploadPath = "/upload/";
            if (!EmptyValue($this->file_loan->Upload->DbValue)) {
                $this->file_loan->EditValue = $this->file_loan->Upload->DbValue;
            } else {
                $this->file_loan->EditValue = "";
            }
            if (!EmptyValue($this->file_loan->CurrentValue)) {
                if ($this->RowIndex == '$rowindex$') {
                    $this->file_loan->Upload->FileName = "";
                } else {
                    $this->file_loan->Upload->FileName = $this->file_loan->CurrentValue;
                }
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->file_loan, $this->RowIndex);
            }

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

            // asset_project
            $this->asset_project->LinkCustomAttributes = "";
            $this->asset_project->HrefValue = "";

            // asset_deed
            $this->asset_deed->LinkCustomAttributes = "";
            $this->asset_deed->HrefValue = "";

            // asset_area
            $this->asset_area->LinkCustomAttributes = "";
            $this->asset_area->HrefValue = "";

            // investor_lname
            $this->investor_lname->LinkCustomAttributes = "";
            $this->investor_lname->HrefValue = "";

            // investor_email
            $this->investor_email->LinkCustomAttributes = "";
            $this->investor_email->HrefValue = "";

            // investor_idcard
            $this->investor_idcard->LinkCustomAttributes = "";
            $this->investor_idcard->HrefValue = "";

            // investor_homeno
            $this->investor_homeno->LinkCustomAttributes = "";
            $this->investor_homeno->HrefValue = "";

            // investment_money
            $this->investment_money->LinkCustomAttributes = "";
            $this->investment_money->HrefValue = "";

            // loan_contact_date
            $this->loan_contact_date->LinkCustomAttributes = "";
            $this->loan_contact_date->HrefValue = "";

            // contract_expired
            $this->contract_expired->LinkCustomAttributes = "";
            $this->contract_expired->HrefValue = "";

            // first_benefits_month
            $this->first_benefits_month->LinkCustomAttributes = "";
            $this->first_benefits_month->HrefValue = "";

            // one_installment_amount
            $this->one_installment_amount->LinkCustomAttributes = "";
            $this->one_installment_amount->HrefValue = "";

            // two_installment_amount1
            $this->two_installment_amount1->LinkCustomAttributes = "";
            $this->two_installment_amount1->HrefValue = "";

            // two_installment_amount2
            $this->two_installment_amount2->LinkCustomAttributes = "";
            $this->two_installment_amount2->HrefValue = "";

            // investor_paid_amount
            $this->investor_paid_amount->LinkCustomAttributes = "";
            $this->investor_paid_amount->HrefValue = "";

            // first_benefits_date
            $this->first_benefits_date->LinkCustomAttributes = "";
            $this->first_benefits_date->HrefValue = "";

            // one_benefit_amount
            $this->one_benefit_amount->LinkCustomAttributes = "";
            $this->one_benefit_amount->HrefValue = "";

            // two_benefit_amount1
            $this->two_benefit_amount1->LinkCustomAttributes = "";
            $this->two_benefit_amount1->HrefValue = "";

            // two_benefit_amount2
            $this->two_benefit_amount2->LinkCustomAttributes = "";
            $this->two_benefit_amount2->HrefValue = "";

            // management_agent_date
            $this->management_agent_date->LinkCustomAttributes = "";
            $this->management_agent_date->HrefValue = "";

            // begin_date
            $this->begin_date->LinkCustomAttributes = "";
            $this->begin_date->HrefValue = "";

            // investor_witness_lname
            $this->investor_witness_lname->LinkCustomAttributes = "";
            $this->investor_witness_lname->HrefValue = "";

            // investor_witness_email
            $this->investor_witness_email->LinkCustomAttributes = "";
            $this->investor_witness_email->HrefValue = "";

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

            // file_loan
            $this->file_loan->LinkCustomAttributes = "";
            $this->file_loan->HrefValue = "";
            $this->file_loan->ExportHrefValue = $this->file_loan->UploadPath . $this->file_loan->Upload->DbValue;

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

            // asset_project
            $this->asset_project->setupEditAttributes();
            $this->asset_project->EditCustomAttributes = "";
            if (!$this->asset_project->Raw) {
                $this->asset_project->CurrentValue = HtmlDecode($this->asset_project->CurrentValue);
            }
            $this->asset_project->EditValue = HtmlEncode($this->asset_project->CurrentValue);
            $this->asset_project->PlaceHolder = RemoveHtml($this->asset_project->caption());

            // asset_deed
            $this->asset_deed->setupEditAttributes();
            $this->asset_deed->EditCustomAttributes = "";
            if (!$this->asset_deed->Raw) {
                $this->asset_deed->CurrentValue = HtmlDecode($this->asset_deed->CurrentValue);
            }
            $this->asset_deed->EditValue = HtmlEncode($this->asset_deed->CurrentValue);
            $this->asset_deed->PlaceHolder = RemoveHtml($this->asset_deed->caption());

            // asset_area
            $this->asset_area->setupEditAttributes();
            $this->asset_area->EditCustomAttributes = "";
            if (!$this->asset_area->Raw) {
                $this->asset_area->CurrentValue = HtmlDecode($this->asset_area->CurrentValue);
            }
            $this->asset_area->EditValue = HtmlEncode($this->asset_area->CurrentValue);
            $this->asset_area->PlaceHolder = RemoveHtml($this->asset_area->caption());

            // investor_lname
            $this->investor_lname->setupEditAttributes();
            $this->investor_lname->EditCustomAttributes = "";
            if (!$this->investor_lname->Raw) {
                $this->investor_lname->CurrentValue = HtmlDecode($this->investor_lname->CurrentValue);
            }
            $this->investor_lname->EditValue = HtmlEncode($this->investor_lname->CurrentValue);
            $this->investor_lname->PlaceHolder = RemoveHtml($this->investor_lname->caption());

            // investor_email
            $this->investor_email->setupEditAttributes();
            $this->investor_email->EditCustomAttributes = "";
            if (!$this->investor_email->Raw) {
                $this->investor_email->CurrentValue = HtmlDecode($this->investor_email->CurrentValue);
            }
            $this->investor_email->EditValue = HtmlEncode($this->investor_email->CurrentValue);
            $this->investor_email->PlaceHolder = RemoveHtml($this->investor_email->caption());

            // investor_idcard
            $this->investor_idcard->setupEditAttributes();
            $this->investor_idcard->EditCustomAttributes = "";
            if (!$this->investor_idcard->Raw) {
                $this->investor_idcard->CurrentValue = HtmlDecode($this->investor_idcard->CurrentValue);
            }
            $this->investor_idcard->EditValue = HtmlEncode($this->investor_idcard->CurrentValue);
            $this->investor_idcard->PlaceHolder = RemoveHtml($this->investor_idcard->caption());

            // investor_homeno
            $this->investor_homeno->setupEditAttributes();
            $this->investor_homeno->EditCustomAttributes = "";
            if (!$this->investor_homeno->Raw) {
                $this->investor_homeno->CurrentValue = HtmlDecode($this->investor_homeno->CurrentValue);
            }
            $this->investor_homeno->EditValue = HtmlEncode($this->investor_homeno->CurrentValue);
            $this->investor_homeno->PlaceHolder = RemoveHtml($this->investor_homeno->caption());

            // investment_money
            $this->investment_money->setupEditAttributes();
            $this->investment_money->EditCustomAttributes = "";
            $this->investment_money->EditValue = HtmlEncode($this->investment_money->CurrentValue);
            $this->investment_money->PlaceHolder = RemoveHtml($this->investment_money->caption());
            if (strval($this->investment_money->EditValue) != "" && is_numeric($this->investment_money->EditValue)) {
                $this->investment_money->EditValue = FormatNumber($this->investment_money->EditValue, null);
                $this->investment_money->OldValue = $this->investment_money->EditValue;
            }

            // loan_contact_date
            $this->loan_contact_date->setupEditAttributes();
            $this->loan_contact_date->EditCustomAttributes = "";
            $this->loan_contact_date->EditValue = HtmlEncode(FormatDateTime($this->loan_contact_date->CurrentValue, $this->loan_contact_date->formatPattern()));
            $this->loan_contact_date->PlaceHolder = RemoveHtml($this->loan_contact_date->caption());

            // contract_expired
            $this->contract_expired->setupEditAttributes();
            $this->contract_expired->EditCustomAttributes = "";
            $this->contract_expired->EditValue = HtmlEncode(FormatDateTime($this->contract_expired->CurrentValue, $this->contract_expired->formatPattern()));
            $this->contract_expired->PlaceHolder = RemoveHtml($this->contract_expired->caption());

            // first_benefits_month
            $this->first_benefits_month->setupEditAttributes();
            $this->first_benefits_month->EditCustomAttributes = "";
            $this->first_benefits_month->EditValue = HtmlEncode($this->first_benefits_month->CurrentValue);
            $this->first_benefits_month->PlaceHolder = RemoveHtml($this->first_benefits_month->caption());
            if (strval($this->first_benefits_month->EditValue) != "" && is_numeric($this->first_benefits_month->EditValue)) {
                $this->first_benefits_month->EditValue = FormatNumber($this->first_benefits_month->EditValue, null);
                $this->first_benefits_month->OldValue = $this->first_benefits_month->EditValue;
            }

            // one_installment_amount
            $this->one_installment_amount->setupEditAttributes();
            $this->one_installment_amount->EditCustomAttributes = "";
            $this->one_installment_amount->EditValue = HtmlEncode($this->one_installment_amount->CurrentValue);
            $this->one_installment_amount->PlaceHolder = RemoveHtml($this->one_installment_amount->caption());
            if (strval($this->one_installment_amount->EditValue) != "" && is_numeric($this->one_installment_amount->EditValue)) {
                $this->one_installment_amount->EditValue = FormatNumber($this->one_installment_amount->EditValue, null);
                $this->one_installment_amount->OldValue = $this->one_installment_amount->EditValue;
            }

            // two_installment_amount1
            $this->two_installment_amount1->setupEditAttributes();
            $this->two_installment_amount1->EditCustomAttributes = "";
            $this->two_installment_amount1->EditValue = HtmlEncode($this->two_installment_amount1->CurrentValue);
            $this->two_installment_amount1->PlaceHolder = RemoveHtml($this->two_installment_amount1->caption());
            if (strval($this->two_installment_amount1->EditValue) != "" && is_numeric($this->two_installment_amount1->EditValue)) {
                $this->two_installment_amount1->EditValue = FormatNumber($this->two_installment_amount1->EditValue, null);
                $this->two_installment_amount1->OldValue = $this->two_installment_amount1->EditValue;
            }

            // two_installment_amount2
            $this->two_installment_amount2->setupEditAttributes();
            $this->two_installment_amount2->EditCustomAttributes = "";
            $this->two_installment_amount2->EditValue = HtmlEncode($this->two_installment_amount2->CurrentValue);
            $this->two_installment_amount2->PlaceHolder = RemoveHtml($this->two_installment_amount2->caption());
            if (strval($this->two_installment_amount2->EditValue) != "" && is_numeric($this->two_installment_amount2->EditValue)) {
                $this->two_installment_amount2->EditValue = FormatNumber($this->two_installment_amount2->EditValue, null);
                $this->two_installment_amount2->OldValue = $this->two_installment_amount2->EditValue;
            }

            // investor_paid_amount
            $this->investor_paid_amount->setupEditAttributes();
            $this->investor_paid_amount->EditCustomAttributes = "";
            $this->investor_paid_amount->EditValue = HtmlEncode($this->investor_paid_amount->CurrentValue);
            $this->investor_paid_amount->PlaceHolder = RemoveHtml($this->investor_paid_amount->caption());
            if (strval($this->investor_paid_amount->EditValue) != "" && is_numeric($this->investor_paid_amount->EditValue)) {
                $this->investor_paid_amount->EditValue = FormatNumber($this->investor_paid_amount->EditValue, null);
                $this->investor_paid_amount->OldValue = $this->investor_paid_amount->EditValue;
            }

            // first_benefits_date
            $this->first_benefits_date->setupEditAttributes();
            $this->first_benefits_date->EditCustomAttributes = "";
            $this->first_benefits_date->EditValue = HtmlEncode(FormatDateTime($this->first_benefits_date->CurrentValue, $this->first_benefits_date->formatPattern()));
            $this->first_benefits_date->PlaceHolder = RemoveHtml($this->first_benefits_date->caption());

            // one_benefit_amount
            $this->one_benefit_amount->setupEditAttributes();
            $this->one_benefit_amount->EditCustomAttributes = "";
            $this->one_benefit_amount->EditValue = HtmlEncode($this->one_benefit_amount->CurrentValue);
            $this->one_benefit_amount->PlaceHolder = RemoveHtml($this->one_benefit_amount->caption());
            if (strval($this->one_benefit_amount->EditValue) != "" && is_numeric($this->one_benefit_amount->EditValue)) {
                $this->one_benefit_amount->EditValue = FormatNumber($this->one_benefit_amount->EditValue, null);
                $this->one_benefit_amount->OldValue = $this->one_benefit_amount->EditValue;
            }

            // two_benefit_amount1
            $this->two_benefit_amount1->setupEditAttributes();
            $this->two_benefit_amount1->EditCustomAttributes = "";
            $this->two_benefit_amount1->EditValue = HtmlEncode($this->two_benefit_amount1->CurrentValue);
            $this->two_benefit_amount1->PlaceHolder = RemoveHtml($this->two_benefit_amount1->caption());
            if (strval($this->two_benefit_amount1->EditValue) != "" && is_numeric($this->two_benefit_amount1->EditValue)) {
                $this->two_benefit_amount1->EditValue = FormatNumber($this->two_benefit_amount1->EditValue, null);
                $this->two_benefit_amount1->OldValue = $this->two_benefit_amount1->EditValue;
            }

            // two_benefit_amount2
            $this->two_benefit_amount2->setupEditAttributes();
            $this->two_benefit_amount2->EditCustomAttributes = "";
            $this->two_benefit_amount2->EditValue = HtmlEncode($this->two_benefit_amount2->CurrentValue);
            $this->two_benefit_amount2->PlaceHolder = RemoveHtml($this->two_benefit_amount2->caption());
            if (strval($this->two_benefit_amount2->EditValue) != "" && is_numeric($this->two_benefit_amount2->EditValue)) {
                $this->two_benefit_amount2->EditValue = FormatNumber($this->two_benefit_amount2->EditValue, null);
                $this->two_benefit_amount2->OldValue = $this->two_benefit_amount2->EditValue;
            }

            // management_agent_date
            $this->management_agent_date->setupEditAttributes();
            $this->management_agent_date->EditCustomAttributes = "";
            $this->management_agent_date->EditValue = HtmlEncode(FormatDateTime($this->management_agent_date->CurrentValue, $this->management_agent_date->formatPattern()));
            $this->management_agent_date->PlaceHolder = RemoveHtml($this->management_agent_date->caption());

            // begin_date
            $this->begin_date->setupEditAttributes();
            $this->begin_date->EditCustomAttributes = "";
            $this->begin_date->EditValue = HtmlEncode($this->begin_date->CurrentValue);
            $this->begin_date->PlaceHolder = RemoveHtml($this->begin_date->caption());
            if (strval($this->begin_date->EditValue) != "" && is_numeric($this->begin_date->EditValue)) {
                $this->begin_date->EditValue = FormatNumber($this->begin_date->EditValue, null);
                $this->begin_date->OldValue = $this->begin_date->EditValue;
            }

            // investor_witness_lname
            $this->investor_witness_lname->setupEditAttributes();
            $this->investor_witness_lname->EditCustomAttributes = "";
            if (!$this->investor_witness_lname->Raw) {
                $this->investor_witness_lname->CurrentValue = HtmlDecode($this->investor_witness_lname->CurrentValue);
            }
            $this->investor_witness_lname->EditValue = HtmlEncode($this->investor_witness_lname->CurrentValue);
            $this->investor_witness_lname->PlaceHolder = RemoveHtml($this->investor_witness_lname->caption());

            // investor_witness_email
            $this->investor_witness_email->setupEditAttributes();
            $this->investor_witness_email->EditCustomAttributes = "";
            if (!$this->investor_witness_email->Raw) {
                $this->investor_witness_email->CurrentValue = HtmlDecode($this->investor_witness_email->CurrentValue);
            }
            $this->investor_witness_email->EditValue = HtmlEncode($this->investor_witness_email->CurrentValue);
            $this->investor_witness_email->PlaceHolder = RemoveHtml($this->investor_witness_email->caption());

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

            // file_loan
            $this->file_loan->setupEditAttributes();
            $this->file_loan->EditCustomAttributes = "";
            $this->file_loan->UploadPath = "/upload/";
            if (!EmptyValue($this->file_loan->Upload->DbValue)) {
                $this->file_loan->EditValue = $this->file_loan->Upload->DbValue;
            } else {
                $this->file_loan->EditValue = "";
            }
            if (!EmptyValue($this->file_loan->CurrentValue)) {
                if ($this->RowIndex == '$rowindex$') {
                    $this->file_loan->Upload->FileName = "";
                } else {
                    $this->file_loan->Upload->FileName = $this->file_loan->CurrentValue;
                }
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->file_loan, $this->RowIndex);
            }

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

            // asset_project
            $this->asset_project->LinkCustomAttributes = "";
            $this->asset_project->HrefValue = "";

            // asset_deed
            $this->asset_deed->LinkCustomAttributes = "";
            $this->asset_deed->HrefValue = "";

            // asset_area
            $this->asset_area->LinkCustomAttributes = "";
            $this->asset_area->HrefValue = "";

            // investor_lname
            $this->investor_lname->LinkCustomAttributes = "";
            $this->investor_lname->HrefValue = "";

            // investor_email
            $this->investor_email->LinkCustomAttributes = "";
            $this->investor_email->HrefValue = "";

            // investor_idcard
            $this->investor_idcard->LinkCustomAttributes = "";
            $this->investor_idcard->HrefValue = "";

            // investor_homeno
            $this->investor_homeno->LinkCustomAttributes = "";
            $this->investor_homeno->HrefValue = "";

            // investment_money
            $this->investment_money->LinkCustomAttributes = "";
            $this->investment_money->HrefValue = "";

            // loan_contact_date
            $this->loan_contact_date->LinkCustomAttributes = "";
            $this->loan_contact_date->HrefValue = "";

            // contract_expired
            $this->contract_expired->LinkCustomAttributes = "";
            $this->contract_expired->HrefValue = "";

            // first_benefits_month
            $this->first_benefits_month->LinkCustomAttributes = "";
            $this->first_benefits_month->HrefValue = "";

            // one_installment_amount
            $this->one_installment_amount->LinkCustomAttributes = "";
            $this->one_installment_amount->HrefValue = "";

            // two_installment_amount1
            $this->two_installment_amount1->LinkCustomAttributes = "";
            $this->two_installment_amount1->HrefValue = "";

            // two_installment_amount2
            $this->two_installment_amount2->LinkCustomAttributes = "";
            $this->two_installment_amount2->HrefValue = "";

            // investor_paid_amount
            $this->investor_paid_amount->LinkCustomAttributes = "";
            $this->investor_paid_amount->HrefValue = "";

            // first_benefits_date
            $this->first_benefits_date->LinkCustomAttributes = "";
            $this->first_benefits_date->HrefValue = "";

            // one_benefit_amount
            $this->one_benefit_amount->LinkCustomAttributes = "";
            $this->one_benefit_amount->HrefValue = "";

            // two_benefit_amount1
            $this->two_benefit_amount1->LinkCustomAttributes = "";
            $this->two_benefit_amount1->HrefValue = "";

            // two_benefit_amount2
            $this->two_benefit_amount2->LinkCustomAttributes = "";
            $this->two_benefit_amount2->HrefValue = "";

            // management_agent_date
            $this->management_agent_date->LinkCustomAttributes = "";
            $this->management_agent_date->HrefValue = "";

            // begin_date
            $this->begin_date->LinkCustomAttributes = "";
            $this->begin_date->HrefValue = "";

            // investor_witness_lname
            $this->investor_witness_lname->LinkCustomAttributes = "";
            $this->investor_witness_lname->HrefValue = "";

            // investor_witness_email
            $this->investor_witness_email->LinkCustomAttributes = "";
            $this->investor_witness_email->HrefValue = "";

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

            // file_loan
            $this->file_loan->LinkCustomAttributes = "";
            $this->file_loan->HrefValue = "";
            $this->file_loan->ExportHrefValue = $this->file_loan->UploadPath . $this->file_loan->Upload->DbValue;

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
        if ($this->asset_project->Required) {
            if (!$this->asset_project->IsDetailKey && EmptyValue($this->asset_project->FormValue)) {
                $this->asset_project->addErrorMessage(str_replace("%s", $this->asset_project->caption(), $this->asset_project->RequiredErrorMessage));
            }
        }
        if ($this->asset_deed->Required) {
            if (!$this->asset_deed->IsDetailKey && EmptyValue($this->asset_deed->FormValue)) {
                $this->asset_deed->addErrorMessage(str_replace("%s", $this->asset_deed->caption(), $this->asset_deed->RequiredErrorMessage));
            }
        }
        if ($this->asset_area->Required) {
            if (!$this->asset_area->IsDetailKey && EmptyValue($this->asset_area->FormValue)) {
                $this->asset_area->addErrorMessage(str_replace("%s", $this->asset_area->caption(), $this->asset_area->RequiredErrorMessage));
            }
        }
        if ($this->investor_lname->Required) {
            if (!$this->investor_lname->IsDetailKey && EmptyValue($this->investor_lname->FormValue)) {
                $this->investor_lname->addErrorMessage(str_replace("%s", $this->investor_lname->caption(), $this->investor_lname->RequiredErrorMessage));
            }
        }
        if ($this->investor_email->Required) {
            if (!$this->investor_email->IsDetailKey && EmptyValue($this->investor_email->FormValue)) {
                $this->investor_email->addErrorMessage(str_replace("%s", $this->investor_email->caption(), $this->investor_email->RequiredErrorMessage));
            }
        }
        if ($this->investor_idcard->Required) {
            if (!$this->investor_idcard->IsDetailKey && EmptyValue($this->investor_idcard->FormValue)) {
                $this->investor_idcard->addErrorMessage(str_replace("%s", $this->investor_idcard->caption(), $this->investor_idcard->RequiredErrorMessage));
            }
        }
        if ($this->investor_homeno->Required) {
            if (!$this->investor_homeno->IsDetailKey && EmptyValue($this->investor_homeno->FormValue)) {
                $this->investor_homeno->addErrorMessage(str_replace("%s", $this->investor_homeno->caption(), $this->investor_homeno->RequiredErrorMessage));
            }
        }
        if ($this->investment_money->Required) {
            if (!$this->investment_money->IsDetailKey && EmptyValue($this->investment_money->FormValue)) {
                $this->investment_money->addErrorMessage(str_replace("%s", $this->investment_money->caption(), $this->investment_money->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->investment_money->FormValue)) {
            $this->investment_money->addErrorMessage($this->investment_money->getErrorMessage(false));
        }
        if ($this->loan_contact_date->Required) {
            if (!$this->loan_contact_date->IsDetailKey && EmptyValue($this->loan_contact_date->FormValue)) {
                $this->loan_contact_date->addErrorMessage(str_replace("%s", $this->loan_contact_date->caption(), $this->loan_contact_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->loan_contact_date->FormValue, $this->loan_contact_date->formatPattern())) {
            $this->loan_contact_date->addErrorMessage($this->loan_contact_date->getErrorMessage(false));
        }
        if ($this->contract_expired->Required) {
            if (!$this->contract_expired->IsDetailKey && EmptyValue($this->contract_expired->FormValue)) {
                $this->contract_expired->addErrorMessage(str_replace("%s", $this->contract_expired->caption(), $this->contract_expired->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->contract_expired->FormValue, $this->contract_expired->formatPattern())) {
            $this->contract_expired->addErrorMessage($this->contract_expired->getErrorMessage(false));
        }
        if ($this->first_benefits_month->Required) {
            if (!$this->first_benefits_month->IsDetailKey && EmptyValue($this->first_benefits_month->FormValue)) {
                $this->first_benefits_month->addErrorMessage(str_replace("%s", $this->first_benefits_month->caption(), $this->first_benefits_month->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->first_benefits_month->FormValue)) {
            $this->first_benefits_month->addErrorMessage($this->first_benefits_month->getErrorMessage(false));
        }
        if ($this->one_installment_amount->Required) {
            if (!$this->one_installment_amount->IsDetailKey && EmptyValue($this->one_installment_amount->FormValue)) {
                $this->one_installment_amount->addErrorMessage(str_replace("%s", $this->one_installment_amount->caption(), $this->one_installment_amount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->one_installment_amount->FormValue)) {
            $this->one_installment_amount->addErrorMessage($this->one_installment_amount->getErrorMessage(false));
        }
        if ($this->two_installment_amount1->Required) {
            if (!$this->two_installment_amount1->IsDetailKey && EmptyValue($this->two_installment_amount1->FormValue)) {
                $this->two_installment_amount1->addErrorMessage(str_replace("%s", $this->two_installment_amount1->caption(), $this->two_installment_amount1->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->two_installment_amount1->FormValue)) {
            $this->two_installment_amount1->addErrorMessage($this->two_installment_amount1->getErrorMessage(false));
        }
        if ($this->two_installment_amount2->Required) {
            if (!$this->two_installment_amount2->IsDetailKey && EmptyValue($this->two_installment_amount2->FormValue)) {
                $this->two_installment_amount2->addErrorMessage(str_replace("%s", $this->two_installment_amount2->caption(), $this->two_installment_amount2->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->two_installment_amount2->FormValue)) {
            $this->two_installment_amount2->addErrorMessage($this->two_installment_amount2->getErrorMessage(false));
        }
        if ($this->investor_paid_amount->Required) {
            if (!$this->investor_paid_amount->IsDetailKey && EmptyValue($this->investor_paid_amount->FormValue)) {
                $this->investor_paid_amount->addErrorMessage(str_replace("%s", $this->investor_paid_amount->caption(), $this->investor_paid_amount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->investor_paid_amount->FormValue)) {
            $this->investor_paid_amount->addErrorMessage($this->investor_paid_amount->getErrorMessage(false));
        }
        if ($this->first_benefits_date->Required) {
            if (!$this->first_benefits_date->IsDetailKey && EmptyValue($this->first_benefits_date->FormValue)) {
                $this->first_benefits_date->addErrorMessage(str_replace("%s", $this->first_benefits_date->caption(), $this->first_benefits_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->first_benefits_date->FormValue, $this->first_benefits_date->formatPattern())) {
            $this->first_benefits_date->addErrorMessage($this->first_benefits_date->getErrorMessage(false));
        }
        if ($this->one_benefit_amount->Required) {
            if (!$this->one_benefit_amount->IsDetailKey && EmptyValue($this->one_benefit_amount->FormValue)) {
                $this->one_benefit_amount->addErrorMessage(str_replace("%s", $this->one_benefit_amount->caption(), $this->one_benefit_amount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->one_benefit_amount->FormValue)) {
            $this->one_benefit_amount->addErrorMessage($this->one_benefit_amount->getErrorMessage(false));
        }
        if ($this->two_benefit_amount1->Required) {
            if (!$this->two_benefit_amount1->IsDetailKey && EmptyValue($this->two_benefit_amount1->FormValue)) {
                $this->two_benefit_amount1->addErrorMessage(str_replace("%s", $this->two_benefit_amount1->caption(), $this->two_benefit_amount1->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->two_benefit_amount1->FormValue)) {
            $this->two_benefit_amount1->addErrorMessage($this->two_benefit_amount1->getErrorMessage(false));
        }
        if ($this->two_benefit_amount2->Required) {
            if (!$this->two_benefit_amount2->IsDetailKey && EmptyValue($this->two_benefit_amount2->FormValue)) {
                $this->two_benefit_amount2->addErrorMessage(str_replace("%s", $this->two_benefit_amount2->caption(), $this->two_benefit_amount2->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->two_benefit_amount2->FormValue)) {
            $this->two_benefit_amount2->addErrorMessage($this->two_benefit_amount2->getErrorMessage(false));
        }
        if ($this->management_agent_date->Required) {
            if (!$this->management_agent_date->IsDetailKey && EmptyValue($this->management_agent_date->FormValue)) {
                $this->management_agent_date->addErrorMessage(str_replace("%s", $this->management_agent_date->caption(), $this->management_agent_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->management_agent_date->FormValue, $this->management_agent_date->formatPattern())) {
            $this->management_agent_date->addErrorMessage($this->management_agent_date->getErrorMessage(false));
        }
        if ($this->begin_date->Required) {
            if (!$this->begin_date->IsDetailKey && EmptyValue($this->begin_date->FormValue)) {
                $this->begin_date->addErrorMessage(str_replace("%s", $this->begin_date->caption(), $this->begin_date->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->begin_date->FormValue)) {
            $this->begin_date->addErrorMessage($this->begin_date->getErrorMessage(false));
        }
        if ($this->investor_witness_lname->Required) {
            if (!$this->investor_witness_lname->IsDetailKey && EmptyValue($this->investor_witness_lname->FormValue)) {
                $this->investor_witness_lname->addErrorMessage(str_replace("%s", $this->investor_witness_lname->caption(), $this->investor_witness_lname->RequiredErrorMessage));
            }
        }
        if ($this->investor_witness_email->Required) {
            if (!$this->investor_witness_email->IsDetailKey && EmptyValue($this->investor_witness_email->FormValue)) {
                $this->investor_witness_email->addErrorMessage(str_replace("%s", $this->investor_witness_email->caption(), $this->investor_witness_email->RequiredErrorMessage));
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
        if ($this->file_loan->Required) {
            if ($this->file_loan->Upload->FileName == "" && !$this->file_loan->Upload->KeepFile) {
                $this->file_loan->addErrorMessage(str_replace("%s", $this->file_loan->caption(), $this->file_loan->RequiredErrorMessage));
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
            $this->file_loan->OldUploadPath = "/upload/";
            $this->file_loan->UploadPath = $this->file_loan->OldUploadPath;
            $this->file_other->OldUploadPath = "/upload/";
            $this->file_other->UploadPath = $this->file_other->OldUploadPath;
            $rsnew = [];

            // document_date
            $this->document_date->CurrentValue = CurrentDateTime();
            $this->document_date->setDbValueDef($rsnew, $this->document_date->CurrentValue, null);

            // asset_code
            $this->asset_code->setDbValueDef($rsnew, $this->asset_code->CurrentValue, null, $this->asset_code->ReadOnly);

            // asset_project
            $this->asset_project->setDbValueDef($rsnew, $this->asset_project->CurrentValue, null, $this->asset_project->ReadOnly);

            // asset_deed
            $this->asset_deed->setDbValueDef($rsnew, $this->asset_deed->CurrentValue, null, $this->asset_deed->ReadOnly);

            // asset_area
            $this->asset_area->setDbValueDef($rsnew, $this->asset_area->CurrentValue, null, $this->asset_area->ReadOnly);

            // investor_lname
            $this->investor_lname->setDbValueDef($rsnew, $this->investor_lname->CurrentValue, null, $this->investor_lname->ReadOnly);

            // investor_email
            $this->investor_email->setDbValueDef($rsnew, $this->investor_email->CurrentValue, null, $this->investor_email->ReadOnly);

            // investor_idcard
            $this->investor_idcard->setDbValueDef($rsnew, $this->investor_idcard->CurrentValue, null, $this->investor_idcard->ReadOnly);

            // investor_homeno
            $this->investor_homeno->setDbValueDef($rsnew, $this->investor_homeno->CurrentValue, null, $this->investor_homeno->ReadOnly);

            // investment_money
            $this->investment_money->setDbValueDef($rsnew, $this->investment_money->CurrentValue, null, $this->investment_money->ReadOnly);

            // loan_contact_date
            $this->loan_contact_date->setDbValueDef($rsnew, UnFormatDateTime($this->loan_contact_date->CurrentValue, $this->loan_contact_date->formatPattern()), null, $this->loan_contact_date->ReadOnly);

            // contract_expired
            $this->contract_expired->setDbValueDef($rsnew, UnFormatDateTime($this->contract_expired->CurrentValue, $this->contract_expired->formatPattern()), null, $this->contract_expired->ReadOnly);

            // first_benefits_month
            $this->first_benefits_month->setDbValueDef($rsnew, $this->first_benefits_month->CurrentValue, null, $this->first_benefits_month->ReadOnly);

            // one_installment_amount
            $this->one_installment_amount->setDbValueDef($rsnew, $this->one_installment_amount->CurrentValue, null, $this->one_installment_amount->ReadOnly);

            // two_installment_amount1
            $this->two_installment_amount1->setDbValueDef($rsnew, $this->two_installment_amount1->CurrentValue, null, $this->two_installment_amount1->ReadOnly);

            // two_installment_amount2
            $this->two_installment_amount2->setDbValueDef($rsnew, $this->two_installment_amount2->CurrentValue, null, $this->two_installment_amount2->ReadOnly);

            // investor_paid_amount
            $this->investor_paid_amount->setDbValueDef($rsnew, $this->investor_paid_amount->CurrentValue, null, $this->investor_paid_amount->ReadOnly);

            // first_benefits_date
            $this->first_benefits_date->setDbValueDef($rsnew, UnFormatDateTime($this->first_benefits_date->CurrentValue, $this->first_benefits_date->formatPattern()), null, $this->first_benefits_date->ReadOnly);

            // one_benefit_amount
            $this->one_benefit_amount->setDbValueDef($rsnew, $this->one_benefit_amount->CurrentValue, null, $this->one_benefit_amount->ReadOnly);

            // two_benefit_amount1
            $this->two_benefit_amount1->setDbValueDef($rsnew, $this->two_benefit_amount1->CurrentValue, null, $this->two_benefit_amount1->ReadOnly);

            // two_benefit_amount2
            $this->two_benefit_amount2->setDbValueDef($rsnew, $this->two_benefit_amount2->CurrentValue, null, $this->two_benefit_amount2->ReadOnly);

            // management_agent_date
            $this->management_agent_date->setDbValueDef($rsnew, UnFormatDateTime($this->management_agent_date->CurrentValue, $this->management_agent_date->formatPattern()), null, $this->management_agent_date->ReadOnly);

            // begin_date
            $this->begin_date->setDbValueDef($rsnew, $this->begin_date->CurrentValue, null, $this->begin_date->ReadOnly);

            // investor_witness_lname
            $this->investor_witness_lname->setDbValueDef($rsnew, $this->investor_witness_lname->CurrentValue, null, $this->investor_witness_lname->ReadOnly);

            // investor_witness_email
            $this->investor_witness_email->setDbValueDef($rsnew, $this->investor_witness_email->CurrentValue, null, $this->investor_witness_email->ReadOnly);

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

            // file_loan
            if ($this->file_loan->Visible && !$this->file_loan->ReadOnly && !$this->file_loan->Upload->KeepFile) {
                $this->file_loan->Upload->DbValue = $rsold['file_loan']; // Get original value
                if ($this->file_loan->Upload->FileName == "") {
                    $rsnew['file_loan'] = null;
                } else {
                    $rsnew['file_loan'] = $this->file_loan->Upload->FileName;
                }
            }

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
            if ($this->file_loan->Visible && !$this->file_loan->Upload->KeepFile) {
                $this->file_loan->UploadPath = "/upload/";
                $oldFiles = EmptyValue($this->file_loan->Upload->DbValue) ? [] : [$this->file_loan->htmlDecode($this->file_loan->Upload->DbValue)];
                if (!EmptyValue($this->file_loan->Upload->FileName)) {
                    $newFiles = [$this->file_loan->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->file_loan, $this->file_loan->Upload->Index);
                            if (file_exists($tempPath . $file)) {
                                if (Config("DELETE_UPLOADED_FILES")) {
                                    $oldFileFound = false;
                                    $oldFileCount = count($oldFiles);
                                    for ($j = 0; $j < $oldFileCount; $j++) {
                                        $oldFile = $oldFiles[$j];
                                        if ($oldFile == $file) { // Old file found, no need to delete anymore
                                            array_splice($oldFiles, $j, 1);
                                            $oldFileFound = true;
                                            break;
                                        }
                                    }
                                    if ($oldFileFound) { // No need to check if file exists further
                                        continue;
                                    }
                                }
                                $file1 = UniqueFilename($this->file_loan->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->file_loan->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->file_loan->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->file_loan->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->file_loan->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->file_loan->setDbValueDef($rsnew, $this->file_loan->Upload->FileName, null, $this->file_loan->ReadOnly);
                }
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
                    if ($this->file_loan->Visible && !$this->file_loan->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->file_loan->Upload->DbValue) ? [] : [$this->file_loan->htmlDecode($this->file_loan->Upload->DbValue)];
                        if (!EmptyValue($this->file_loan->Upload->FileName)) {
                            $newFiles = [$this->file_loan->Upload->FileName];
                            $newFiles2 = [$this->file_loan->htmlDecode($rsnew['file_loan'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->file_loan, $this->file_loan->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->file_loan->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                            $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                            return false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $newFiles = [];
                        }
                        if (Config("DELETE_UPLOADED_FILES")) {
                            foreach ($oldFiles as $oldFile) {
                                if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                    @unlink($this->file_loan->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
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
            // file_loan
            CleanUploadTempPath($this->file_loan, $this->file_loan->Upload->Index);
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
        if ($this->getCurrentMasterTable() == "invertor_all_booking") {
            $this->investor_booking_id->CurrentValue = $this->investor_booking_id->getSessionValue();
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
            $this->file_idcard->OldUploadPath = "/upload/";
            $this->file_idcard->UploadPath = $this->file_idcard->OldUploadPath;
            $this->file_house_regis->OldUploadPath = "/upload/";
            $this->file_house_regis->UploadPath = $this->file_house_regis->OldUploadPath;
            $this->file_loan->OldUploadPath = "/upload/";
            $this->file_loan->UploadPath = $this->file_loan->OldUploadPath;
            $this->file_other->OldUploadPath = "/upload/";
            $this->file_other->UploadPath = $this->file_other->OldUploadPath;
        }
        $rsnew = [];

        // document_date
        $this->document_date->CurrentValue = CurrentDateTime();
        $this->document_date->setDbValueDef($rsnew, $this->document_date->CurrentValue, null);

        // asset_code
        $this->asset_code->setDbValueDef($rsnew, $this->asset_code->CurrentValue, null, false);

        // asset_project
        $this->asset_project->setDbValueDef($rsnew, $this->asset_project->CurrentValue, null, false);

        // asset_deed
        $this->asset_deed->setDbValueDef($rsnew, $this->asset_deed->CurrentValue, null, false);

        // asset_area
        $this->asset_area->setDbValueDef($rsnew, $this->asset_area->CurrentValue, null, false);

        // investor_lname
        $this->investor_lname->setDbValueDef($rsnew, $this->investor_lname->CurrentValue, null, false);

        // investor_email
        $this->investor_email->setDbValueDef($rsnew, $this->investor_email->CurrentValue, null, false);

        // investor_idcard
        $this->investor_idcard->setDbValueDef($rsnew, $this->investor_idcard->CurrentValue, null, false);

        // investor_homeno
        $this->investor_homeno->setDbValueDef($rsnew, $this->investor_homeno->CurrentValue, null, false);

        // investment_money
        $this->investment_money->setDbValueDef($rsnew, $this->investment_money->CurrentValue, null, false);

        // loan_contact_date
        $this->loan_contact_date->setDbValueDef($rsnew, UnFormatDateTime($this->loan_contact_date->CurrentValue, $this->loan_contact_date->formatPattern()), null, false);

        // contract_expired
        $this->contract_expired->setDbValueDef($rsnew, UnFormatDateTime($this->contract_expired->CurrentValue, $this->contract_expired->formatPattern()), null, false);

        // first_benefits_month
        $this->first_benefits_month->setDbValueDef($rsnew, $this->first_benefits_month->CurrentValue, null, false);

        // one_installment_amount
        $this->one_installment_amount->setDbValueDef($rsnew, $this->one_installment_amount->CurrentValue, null, false);

        // two_installment_amount1
        $this->two_installment_amount1->setDbValueDef($rsnew, $this->two_installment_amount1->CurrentValue, null, false);

        // two_installment_amount2
        $this->two_installment_amount2->setDbValueDef($rsnew, $this->two_installment_amount2->CurrentValue, null, false);

        // investor_paid_amount
        $this->investor_paid_amount->setDbValueDef($rsnew, $this->investor_paid_amount->CurrentValue, null, false);

        // first_benefits_date
        $this->first_benefits_date->setDbValueDef($rsnew, UnFormatDateTime($this->first_benefits_date->CurrentValue, $this->first_benefits_date->formatPattern()), null, false);

        // one_benefit_amount
        $this->one_benefit_amount->setDbValueDef($rsnew, $this->one_benefit_amount->CurrentValue, null, false);

        // two_benefit_amount1
        $this->two_benefit_amount1->setDbValueDef($rsnew, $this->two_benefit_amount1->CurrentValue, null, false);

        // two_benefit_amount2
        $this->two_benefit_amount2->setDbValueDef($rsnew, $this->two_benefit_amount2->CurrentValue, null, false);

        // management_agent_date
        $this->management_agent_date->setDbValueDef($rsnew, UnFormatDateTime($this->management_agent_date->CurrentValue, $this->management_agent_date->formatPattern()), null, false);

        // begin_date
        $this->begin_date->setDbValueDef($rsnew, $this->begin_date->CurrentValue, null, false);

        // investor_witness_lname
        $this->investor_witness_lname->setDbValueDef($rsnew, $this->investor_witness_lname->CurrentValue, null, false);

        // investor_witness_email
        $this->investor_witness_email->setDbValueDef($rsnew, $this->investor_witness_email->CurrentValue, null, false);

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

        // file_loan
        if ($this->file_loan->Visible && !$this->file_loan->Upload->KeepFile) {
            $this->file_loan->Upload->DbValue = ""; // No need to delete old file
            if ($this->file_loan->Upload->FileName == "") {
                $rsnew['file_loan'] = null;
            } else {
                $rsnew['file_loan'] = $this->file_loan->Upload->FileName;
            }
        }

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

        // investor_booking_id
        if ($this->investor_booking_id->getSessionValue() != "") {
            $rsnew['investor_booking_id'] = $this->investor_booking_id->getSessionValue();
        }
        if ($this->file_loan->Visible && !$this->file_loan->Upload->KeepFile) {
            $this->file_loan->UploadPath = "/upload/";
            $oldFiles = EmptyValue($this->file_loan->Upload->DbValue) ? [] : [$this->file_loan->htmlDecode($this->file_loan->Upload->DbValue)];
            if (!EmptyValue($this->file_loan->Upload->FileName)) {
                $newFiles = [$this->file_loan->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->file_loan, $this->file_loan->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->file_loan->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->file_loan->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->file_loan->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->file_loan->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->file_loan->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->file_loan->setDbValueDef($rsnew, $this->file_loan->Upload->FileName, null, false);
            }
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->file_loan->Visible && !$this->file_loan->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->file_loan->Upload->DbValue) ? [] : [$this->file_loan->htmlDecode($this->file_loan->Upload->DbValue)];
                    if (!EmptyValue($this->file_loan->Upload->FileName)) {
                        $newFiles = [$this->file_loan->Upload->FileName];
                        $newFiles2 = [$this->file_loan->htmlDecode($rsnew['file_loan'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->file_loan, $this->file_loan->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->file_loan->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->file_loan->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
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
            // file_loan
            CleanUploadTempPath($this->file_loan, $this->file_loan->Upload->Index);
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
        if ($masterTblVar == "invertor_all_booking") {
            $masterTbl = Container("invertor_all_booking");
            $this->investor_booking_id->Visible = false;
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
