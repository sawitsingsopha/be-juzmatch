<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class DocJuzmatch3List extends DocJuzmatch3
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'doc_juzmatch3';

    // Page object name
    public $PageObjName = "DocJuzmatch3List";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fdoc_juzmatch3list";
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

        // Table object (doc_juzmatch3)
        if (!isset($GLOBALS["doc_juzmatch3"]) || get_class($GLOBALS["doc_juzmatch3"]) == PROJECT_NAMESPACE . "doc_juzmatch3") {
            $GLOBALS["doc_juzmatch3"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "docjuzmatch3add";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "docjuzmatch3delete";
        $this->MultiUpdateUrl = "docjuzmatch3update";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'doc_juzmatch3');
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
                $tbl = Container("doc_juzmatch3");
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
        $this->id->Visible = false;
        $this->document_date->setVisibility();
        $this->years->setVisibility();
        $this->start_date->setVisibility();
        $this->end_date->setVisibility();
        $this->asset_code->setVisibility();
        $this->asset_project->setVisibility();
        $this->asset_deed->setVisibility();
        $this->asset_area->setVisibility();
        $this->appoint_agent_date->setVisibility();
        $this->buyer_name->Visible = false;
        $this->buyer_lname->setVisibility();
        $this->buyer_email->setVisibility();
        $this->buyer_idcard->setVisibility();
        $this->buyer_homeno->setVisibility();
        $this->buyer_witness_name->Visible = false;
        $this->buyer_witness_lname->setVisibility();
        $this->buyer_witness_email->setVisibility();
        $this->investor_name->Visible = false;
        $this->investor_lname->setVisibility();
        $this->investor_email->setVisibility();
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
        $this->total->setVisibility();
        $this->total_txt->setVisibility();
        $this->next_pay_date->setVisibility();
        $this->next_pay_date_txt->setVisibility();
        $this->service_price->setVisibility();
        $this->service_price_txt->setVisibility();
        $this->provide_service_date->setVisibility();
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
        $this->doc_creden_id->Visible = false;
        $this->cdate->setVisibility();
        $this->cuser->Visible = false;
        $this->cip->Visible = false;
        $this->udate->Visible = false;
        $this->uuser->Visible = false;
        $this->uip->Visible = false;
        $this->doc_date->Visible = false;
        $this->buyer_booking_asset_id->Visible = false;
        $this->first_down->Visible = false;
        $this->first_down_txt->Visible = false;
        $this->second_down->Visible = false;
        $this->second_down_txt->Visible = false;
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

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->status);

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

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for Ctrl pressed
        $ctrl = Get("ctrl") !== null;

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->document_date, $ctrl); // document_date
            $this->updateSort($this->years, $ctrl); // years
            $this->updateSort($this->start_date, $ctrl); // start_date
            $this->updateSort($this->end_date, $ctrl); // end_date
            $this->updateSort($this->asset_code, $ctrl); // asset_code
            $this->updateSort($this->asset_project, $ctrl); // asset_project
            $this->updateSort($this->asset_deed, $ctrl); // asset_deed
            $this->updateSort($this->asset_area, $ctrl); // asset_area
            $this->updateSort($this->appoint_agent_date, $ctrl); // appoint_agent_date
            $this->updateSort($this->buyer_lname, $ctrl); // buyer_lname
            $this->updateSort($this->buyer_email, $ctrl); // buyer_email
            $this->updateSort($this->buyer_idcard, $ctrl); // buyer_idcard
            $this->updateSort($this->buyer_homeno, $ctrl); // buyer_homeno
            $this->updateSort($this->buyer_witness_lname, $ctrl); // buyer_witness_lname
            $this->updateSort($this->buyer_witness_email, $ctrl); // buyer_witness_email
            $this->updateSort($this->investor_lname, $ctrl); // investor_lname
            $this->updateSort($this->investor_email, $ctrl); // investor_email
            $this->updateSort($this->juzmatch_authority_lname, $ctrl); // juzmatch_authority_lname
            $this->updateSort($this->juzmatch_authority_email, $ctrl); // juzmatch_authority_email
            $this->updateSort($this->juzmatch_authority_witness_lname, $ctrl); // juzmatch_authority_witness_lname
            $this->updateSort($this->juzmatch_authority_witness_email, $ctrl); // juzmatch_authority_witness_email
            $this->updateSort($this->juzmatch_authority2_name, $ctrl); // juzmatch_authority2_name
            $this->updateSort($this->juzmatch_authority2_lname, $ctrl); // juzmatch_authority2_lname
            $this->updateSort($this->juzmatch_authority2_email, $ctrl); // juzmatch_authority2_email
            $this->updateSort($this->company_seal_name, $ctrl); // company_seal_name
            $this->updateSort($this->company_seal_email, $ctrl); // company_seal_email
            $this->updateSort($this->total, $ctrl); // total
            $this->updateSort($this->total_txt, $ctrl); // total_txt
            $this->updateSort($this->next_pay_date, $ctrl); // next_pay_date
            $this->updateSort($this->next_pay_date_txt, $ctrl); // next_pay_date_txt
            $this->updateSort($this->service_price, $ctrl); // service_price
            $this->updateSort($this->service_price_txt, $ctrl); // service_price_txt
            $this->updateSort($this->provide_service_date, $ctrl); // provide_service_date
            $this->updateSort($this->contact_address, $ctrl); // contact_address
            $this->updateSort($this->contact_address2, $ctrl); // contact_address2
            $this->updateSort($this->contact_email, $ctrl); // contact_email
            $this->updateSort($this->contact_lineid, $ctrl); // contact_lineid
            $this->updateSort($this->contact_phone, $ctrl); // contact_phone
            $this->updateSort($this->cdate, $ctrl); // cdate
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
                $this->id->setSort("");
                $this->document_date->setSort("");
                $this->years->setSort("");
                $this->start_date->setSort("");
                $this->end_date->setSort("");
                $this->asset_code->setSort("");
                $this->asset_project->setSort("");
                $this->asset_deed->setSort("");
                $this->asset_area->setSort("");
                $this->appoint_agent_date->setSort("");
                $this->buyer_name->setSort("");
                $this->buyer_lname->setSort("");
                $this->buyer_email->setSort("");
                $this->buyer_idcard->setSort("");
                $this->buyer_homeno->setSort("");
                $this->buyer_witness_name->setSort("");
                $this->buyer_witness_lname->setSort("");
                $this->buyer_witness_email->setSort("");
                $this->investor_name->setSort("");
                $this->investor_lname->setSort("");
                $this->investor_email->setSort("");
                $this->juzmatch_authority_name->setSort("");
                $this->juzmatch_authority_lname->setSort("");
                $this->juzmatch_authority_email->setSort("");
                $this->juzmatch_authority_witness_name->setSort("");
                $this->juzmatch_authority_witness_lname->setSort("");
                $this->juzmatch_authority_witness_email->setSort("");
                $this->juzmatch_authority2_name->setSort("");
                $this->juzmatch_authority2_lname->setSort("");
                $this->juzmatch_authority2_email->setSort("");
                $this->company_seal_name->setSort("");
                $this->company_seal_email->setSort("");
                $this->total->setSort("");
                $this->total_txt->setSort("");
                $this->next_pay_date->setSort("");
                $this->next_pay_date_txt->setSort("");
                $this->service_price->setSort("");
                $this->service_price_txt->setSort("");
                $this->provide_service_date->setSort("");
                $this->contact_address->setSort("");
                $this->contact_address2->setSort("");
                $this->contact_email->setSort("");
                $this->contact_lineid->setSort("");
                $this->contact_phone->setSort("");
                $this->file_idcard->setSort("");
                $this->file_house_regis->setSort("");
                $this->file_titledeed->setSort("");
                $this->file_other->setSort("");
                $this->attach_file->setSort("");
                $this->status->setSort("");
                $this->doc_creden_id->setSort("");
                $this->cdate->setSort("");
                $this->cuser->setSort("");
                $this->cip->setSort("");
                $this->udate->setSort("");
                $this->uuser->setSort("");
                $this->uip->setSort("");
                $this->doc_date->setSort("");
                $this->buyer_booking_asset_id->setSort("");
                $this->first_down->setSort("");
                $this->first_down_txt->setSort("");
                $this->second_down->setSort("");
                $this->second_down_txt->setSort("");
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
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fdoc_juzmatch3list\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button></li>";
                    if ($link != "") {
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fdoc_juzmatch3list\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button>";
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
            $option->add("document_date", $this->createColumnOption("document_date"));
            $option->add("years", $this->createColumnOption("years"));
            $option->add("start_date", $this->createColumnOption("start_date"));
            $option->add("end_date", $this->createColumnOption("end_date"));
            $option->add("asset_code", $this->createColumnOption("asset_code"));
            $option->add("asset_project", $this->createColumnOption("asset_project"));
            $option->add("asset_deed", $this->createColumnOption("asset_deed"));
            $option->add("asset_area", $this->createColumnOption("asset_area"));
            $option->add("appoint_agent_date", $this->createColumnOption("appoint_agent_date"));
            $option->add("buyer_lname", $this->createColumnOption("buyer_lname"));
            $option->add("buyer_email", $this->createColumnOption("buyer_email"));
            $option->add("buyer_idcard", $this->createColumnOption("buyer_idcard"));
            $option->add("buyer_homeno", $this->createColumnOption("buyer_homeno"));
            $option->add("buyer_witness_lname", $this->createColumnOption("buyer_witness_lname"));
            $option->add("buyer_witness_email", $this->createColumnOption("buyer_witness_email"));
            $option->add("investor_lname", $this->createColumnOption("investor_lname"));
            $option->add("investor_email", $this->createColumnOption("investor_email"));
            $option->add("juzmatch_authority_lname", $this->createColumnOption("juzmatch_authority_lname"));
            $option->add("juzmatch_authority_email", $this->createColumnOption("juzmatch_authority_email"));
            $option->add("juzmatch_authority_witness_lname", $this->createColumnOption("juzmatch_authority_witness_lname"));
            $option->add("juzmatch_authority_witness_email", $this->createColumnOption("juzmatch_authority_witness_email"));
            $option->add("juzmatch_authority2_name", $this->createColumnOption("juzmatch_authority2_name"));
            $option->add("juzmatch_authority2_lname", $this->createColumnOption("juzmatch_authority2_lname"));
            $option->add("juzmatch_authority2_email", $this->createColumnOption("juzmatch_authority2_email"));
            $option->add("company_seal_name", $this->createColumnOption("company_seal_name"));
            $option->add("company_seal_email", $this->createColumnOption("company_seal_email"));
            $option->add("total", $this->createColumnOption("total"));
            $option->add("total_txt", $this->createColumnOption("total_txt"));
            $option->add("next_pay_date", $this->createColumnOption("next_pay_date"));
            $option->add("next_pay_date_txt", $this->createColumnOption("next_pay_date_txt"));
            $option->add("service_price", $this->createColumnOption("service_price"));
            $option->add("service_price_txt", $this->createColumnOption("service_price_txt"));
            $option->add("provide_service_date", $this->createColumnOption("provide_service_date"));
            $option->add("contact_address", $this->createColumnOption("contact_address"));
            $option->add("contact_address2", $this->createColumnOption("contact_address2"));
            $option->add("contact_email", $this->createColumnOption("contact_email"));
            $option->add("contact_lineid", $this->createColumnOption("contact_lineid"));
            $option->add("contact_phone", $this->createColumnOption("contact_phone"));
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fdoc_juzmatch3srch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = false;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fdoc_juzmatch3srch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = false;
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fdoc_juzmatch3list"' . $listaction->toDataAttrs() . '>' . $icon . '</button>';
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
        $this->years->setDbValue($row['years']);
        $this->start_date->setDbValue($row['start_date']);
        $this->end_date->setDbValue($row['end_date']);
        $this->asset_code->setDbValue($row['asset_code']);
        $this->asset_project->setDbValue($row['asset_project']);
        $this->asset_deed->setDbValue($row['asset_deed']);
        $this->asset_area->setDbValue($row['asset_area']);
        $this->appoint_agent_date->setDbValue($row['appoint_agent_date']);
        $this->buyer_name->setDbValue($row['buyer_name']);
        $this->buyer_lname->setDbValue($row['buyer_lname']);
        $this->buyer_email->setDbValue($row['buyer_email']);
        $this->buyer_idcard->setDbValue($row['buyer_idcard']);
        $this->buyer_homeno->setDbValue($row['buyer_homeno']);
        $this->buyer_witness_name->setDbValue($row['buyer_witness_name']);
        $this->buyer_witness_lname->setDbValue($row['buyer_witness_lname']);
        $this->buyer_witness_email->setDbValue($row['buyer_witness_email']);
        $this->investor_name->setDbValue($row['investor_name']);
        $this->investor_lname->setDbValue($row['investor_lname']);
        $this->investor_email->setDbValue($row['investor_email']);
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
        $this->total->setDbValue($row['total']);
        $this->total_txt->setDbValue($row['total_txt']);
        $this->next_pay_date->setDbValue($row['next_pay_date']);
        $this->next_pay_date_txt->setDbValue($row['next_pay_date_txt']);
        $this->service_price->setDbValue($row['service_price']);
        $this->service_price_txt->setDbValue($row['service_price_txt']);
        $this->provide_service_date->setDbValue($row['provide_service_date']);
        $this->contact_address->setDbValue($row['contact_address']);
        $this->contact_address2->setDbValue($row['contact_address2']);
        $this->contact_email->setDbValue($row['contact_email']);
        $this->contact_lineid->setDbValue($row['contact_lineid']);
        $this->contact_phone->setDbValue($row['contact_phone']);
        $this->file_idcard->Upload->DbValue = $row['file_idcard'];
        $this->file_idcard->setDbValue($this->file_idcard->Upload->DbValue);
        $this->file_house_regis->Upload->DbValue = $row['file_house_regis'];
        $this->file_house_regis->setDbValue($this->file_house_regis->Upload->DbValue);
        $this->file_titledeed->Upload->DbValue = $row['file_titledeed'];
        $this->file_titledeed->setDbValue($this->file_titledeed->Upload->DbValue);
        $this->file_other->Upload->DbValue = $row['file_other'];
        $this->file_other->setDbValue($this->file_other->Upload->DbValue);
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
        $this->buyer_booking_asset_id->setDbValue($row['buyer_booking_asset_id']);
        $this->first_down->setDbValue($row['first_down']);
        $this->first_down_txt->setDbValue($row['first_down_txt']);
        $this->second_down->setDbValue($row['second_down']);
        $this->second_down_txt->setDbValue($row['second_down_txt']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['document_date'] = null;
        $row['years'] = null;
        $row['start_date'] = null;
        $row['end_date'] = null;
        $row['asset_code'] = null;
        $row['asset_project'] = null;
        $row['asset_deed'] = null;
        $row['asset_area'] = null;
        $row['appoint_agent_date'] = null;
        $row['buyer_name'] = null;
        $row['buyer_lname'] = null;
        $row['buyer_email'] = null;
        $row['buyer_idcard'] = null;
        $row['buyer_homeno'] = null;
        $row['buyer_witness_name'] = null;
        $row['buyer_witness_lname'] = null;
        $row['buyer_witness_email'] = null;
        $row['investor_name'] = null;
        $row['investor_lname'] = null;
        $row['investor_email'] = null;
        $row['juzmatch_authority_name'] = null;
        $row['juzmatch_authority_lname'] = null;
        $row['juzmatch_authority_email'] = null;
        $row['juzmatch_authority_witness_name'] = null;
        $row['juzmatch_authority_witness_lname'] = null;
        $row['juzmatch_authority_witness_email'] = null;
        $row['juzmatch_authority2_name'] = null;
        $row['juzmatch_authority2_lname'] = null;
        $row['juzmatch_authority2_email'] = null;
        $row['company_seal_name'] = null;
        $row['company_seal_email'] = null;
        $row['total'] = null;
        $row['total_txt'] = null;
        $row['next_pay_date'] = null;
        $row['next_pay_date_txt'] = null;
        $row['service_price'] = null;
        $row['service_price_txt'] = null;
        $row['provide_service_date'] = null;
        $row['contact_address'] = null;
        $row['contact_address2'] = null;
        $row['contact_email'] = null;
        $row['contact_lineid'] = null;
        $row['contact_phone'] = null;
        $row['file_idcard'] = null;
        $row['file_house_regis'] = null;
        $row['file_titledeed'] = null;
        $row['file_other'] = null;
        $row['attach_file'] = null;
        $row['status'] = null;
        $row['doc_creden_id'] = null;
        $row['cdate'] = null;
        $row['cuser'] = null;
        $row['cip'] = null;
        $row['udate'] = null;
        $row['uuser'] = null;
        $row['uip'] = null;
        $row['doc_date'] = null;
        $row['buyer_booking_asset_id'] = null;
        $row['first_down'] = null;
        $row['first_down_txt'] = null;
        $row['second_down'] = null;
        $row['second_down_txt'] = null;
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
        $this->id->CellCssStyle = "white-space: nowrap;";

        // document_date

        // years

        // start_date

        // end_date

        // asset_code

        // asset_project

        // asset_deed

        // asset_area

        // appoint_agent_date

        // buyer_name

        // buyer_lname

        // buyer_email

        // buyer_idcard

        // buyer_homeno

        // buyer_witness_name

        // buyer_witness_lname

        // buyer_witness_email

        // investor_name

        // investor_lname

        // investor_email

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

        // total

        // total_txt

        // next_pay_date

        // next_pay_date_txt

        // service_price

        // service_price_txt

        // provide_service_date

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

        // buyer_booking_asset_id
        $this->buyer_booking_asset_id->CellCssStyle = "white-space: nowrap;";

        // first_down
        $this->first_down->CellCssStyle = "white-space: nowrap;";

        // first_down_txt
        $this->first_down_txt->CellCssStyle = "white-space: nowrap;";

        // second_down
        $this->second_down->CellCssStyle = "white-space: nowrap;";

        // second_down_txt
        $this->second_down_txt->CellCssStyle = "white-space: nowrap;";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // document_date
            $this->document_date->ViewValue = $this->document_date->CurrentValue;
            $this->document_date->ViewValue = FormatDateTime($this->document_date->ViewValue, $this->document_date->formatPattern());
            $this->document_date->ViewCustomAttributes = "";

            // years
            $this->years->ViewValue = $this->years->CurrentValue;
            $this->years->ViewValue = FormatNumber($this->years->ViewValue, $this->years->formatPattern());
            $this->years->ViewCustomAttributes = "";

            // start_date
            $this->start_date->ViewValue = $this->start_date->CurrentValue;
            $this->start_date->ViewValue = FormatDateTime($this->start_date->ViewValue, $this->start_date->formatPattern());
            $this->start_date->ViewCustomAttributes = "";

            // end_date
            $this->end_date->ViewValue = $this->end_date->CurrentValue;
            $this->end_date->ViewValue = FormatDateTime($this->end_date->ViewValue, $this->end_date->formatPattern());
            $this->end_date->ViewCustomAttributes = "";

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

            // appoint_agent_date
            $this->appoint_agent_date->ViewValue = $this->appoint_agent_date->CurrentValue;
            $this->appoint_agent_date->ViewValue = FormatDateTime($this->appoint_agent_date->ViewValue, $this->appoint_agent_date->formatPattern());
            $this->appoint_agent_date->ViewCustomAttributes = "";

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

            // investor_lname
            $this->investor_lname->ViewValue = $this->investor_lname->CurrentValue;
            $this->investor_lname->ViewCustomAttributes = "";

            // investor_email
            $this->investor_email->ViewValue = $this->investor_email->CurrentValue;
            $this->investor_email->ViewCustomAttributes = "";

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

            // total
            $this->total->ViewValue = $this->total->CurrentValue;
            $this->total->ViewValue = FormatNumber($this->total->ViewValue, $this->total->formatPattern());
            $this->total->ViewCustomAttributes = "";

            // total_txt
            $this->total_txt->ViewValue = $this->total_txt->CurrentValue;
            $this->total_txt->ViewCustomAttributes = "";

            // next_pay_date
            $this->next_pay_date->ViewValue = $this->next_pay_date->CurrentValue;
            $this->next_pay_date->ViewValue = FormatDateTime($this->next_pay_date->ViewValue, $this->next_pay_date->formatPattern());
            $this->next_pay_date->ViewCustomAttributes = "";

            // next_pay_date_txt
            $this->next_pay_date_txt->ViewValue = $this->next_pay_date_txt->CurrentValue;
            $this->next_pay_date_txt->ViewCustomAttributes = "";

            // service_price
            $this->service_price->ViewValue = $this->service_price->CurrentValue;
            $this->service_price->ViewValue = FormatNumber($this->service_price->ViewValue, $this->service_price->formatPattern());
            $this->service_price->ViewCustomAttributes = "";

            // service_price_txt
            $this->service_price_txt->ViewValue = $this->service_price_txt->CurrentValue;
            $this->service_price_txt->ViewCustomAttributes = "";

            // provide_service_date
            $this->provide_service_date->ViewValue = $this->provide_service_date->CurrentValue;
            $this->provide_service_date->ViewValue = FormatDateTime($this->provide_service_date->ViewValue, $this->provide_service_date->formatPattern());
            $this->provide_service_date->ViewCustomAttributes = "";

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

            // years
            $this->years->LinkCustomAttributes = "";
            $this->years->HrefValue = "";
            $this->years->TooltipValue = "";

            // start_date
            $this->start_date->LinkCustomAttributes = "";
            $this->start_date->HrefValue = "";
            $this->start_date->TooltipValue = "";

            // end_date
            $this->end_date->LinkCustomAttributes = "";
            $this->end_date->HrefValue = "";
            $this->end_date->TooltipValue = "";

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

            // appoint_agent_date
            $this->appoint_agent_date->LinkCustomAttributes = "";
            $this->appoint_agent_date->HrefValue = "";
            $this->appoint_agent_date->TooltipValue = "";

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

            // investor_lname
            $this->investor_lname->LinkCustomAttributes = "";
            $this->investor_lname->HrefValue = "";
            $this->investor_lname->TooltipValue = "";

            // investor_email
            $this->investor_email->LinkCustomAttributes = "";
            $this->investor_email->HrefValue = "";
            $this->investor_email->TooltipValue = "";

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

            // total
            $this->total->LinkCustomAttributes = "";
            $this->total->HrefValue = "";
            $this->total->TooltipValue = "";

            // total_txt
            $this->total_txt->LinkCustomAttributes = "";
            $this->total_txt->HrefValue = "";
            $this->total_txt->TooltipValue = "";

            // next_pay_date
            $this->next_pay_date->LinkCustomAttributes = "";
            $this->next_pay_date->HrefValue = "";
            $this->next_pay_date->TooltipValue = "";

            // next_pay_date_txt
            $this->next_pay_date_txt->LinkCustomAttributes = "";
            $this->next_pay_date_txt->HrefValue = "";
            $this->next_pay_date_txt->TooltipValue = "";

            // service_price
            $this->service_price->LinkCustomAttributes = "";
            $this->service_price->HrefValue = "";
            $this->service_price->TooltipValue = "";

            // service_price_txt
            $this->service_price_txt->LinkCustomAttributes = "";
            $this->service_price_txt->HrefValue = "";
            $this->service_price_txt->TooltipValue = "";

            // provide_service_date
            $this->provide_service_date->LinkCustomAttributes = "";
            $this->provide_service_date->HrefValue = "";
            $this->provide_service_date->TooltipValue = "";

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
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" form=\"fdoc_juzmatch3list\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" form=\"fdoc_juzmatch3list\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" form=\"fdoc_juzmatch3list\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" form="fdoc_juzmatch3list" data-ew-action="email" data-hdr="' . $Language->phrase("ExportToEmailText") . '" data-sel="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        return false;
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

        // Export master record
        if (Config("EXPORT_MASTER_RECORD") && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "buyer_all_booking_asset") {
            $buyer_all_booking_asset = Container("buyer_all_booking_asset");
            $rsmaster = $buyer_all_booking_asset->loadRs($this->DbMasterFilter); // Load master record
            if ($rsmaster) {
                $exportStyle = $doc->Style;
                $doc->setStyle("v"); // Change to vertical
                if (!$this->isExport("csv") || Config("EXPORT_MASTER_RECORD_FOR_CSV")) {
                    $doc->Table = $buyer_all_booking_asset;
                    $buyer_all_booking_asset->exportDocument($doc, new Recordset($rsmaster));
                    $doc->exportEmptyRow();
                    $doc->Table = &$this;
                }
                $doc->setStyle($exportStyle); // Restore
            }
        }
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

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "buyer_all_booking_asset") {
                $validMaster = true;
                $masterTbl = Container("buyer_all_booking_asset");
                if (($parm = Get("fk_buyer_booking_asset_id", Get("buyer_booking_asset_id"))) !== null) {
                    $masterTbl->buyer_booking_asset_id->setQueryStringValue($parm);
                    $this->buyer_booking_asset_id->setQueryStringValue($masterTbl->buyer_booking_asset_id->QueryStringValue);
                    $this->buyer_booking_asset_id->setSessionValue($this->buyer_booking_asset_id->QueryStringValue);
                    if (!is_numeric($masterTbl->buyer_booking_asset_id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "buyer_all_booking_asset") {
                $validMaster = true;
                $masterTbl = Container("buyer_all_booking_asset");
                if (($parm = Post("fk_buyer_booking_asset_id", Post("buyer_booking_asset_id"))) !== null) {
                    $masterTbl->buyer_booking_asset_id->setFormValue($parm);
                    $this->buyer_booking_asset_id->setFormValue($masterTbl->buyer_booking_asset_id->FormValue);
                    $this->buyer_booking_asset_id->setSessionValue($this->buyer_booking_asset_id->FormValue);
                    if (!is_numeric($masterTbl->buyer_booking_asset_id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Update URL
            $this->AddUrl = $this->addMasterUrl($this->AddUrl);
            $this->InlineAddUrl = $this->addMasterUrl($this->InlineAddUrl);
            $this->GridAddUrl = $this->addMasterUrl($this->GridAddUrl);
            $this->GridEditUrl = $this->addMasterUrl($this->GridEditUrl);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "buyer_all_booking_asset") {
                if ($this->buyer_booking_asset_id->CurrentValue == "") {
                    $this->buyer_booking_asset_id->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
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
