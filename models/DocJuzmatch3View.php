<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class DocJuzmatch3View extends DocJuzmatch3
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'doc_juzmatch3';

    // Page object name
    public $PageObjName = "DocJuzmatch3View";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

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
        $pageUrl = $this->pageUrl();
        if (($keyValue = Get("id") ?? Route("id")) !== null) {
            $this->RecKey["id"] = $keyValue;
        }

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

        // Export options
        $this->ExportOptions = new ListOptions(["TagClassName" => "ew-export-option"]);

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }

        // Detail tables
        $this->OtherOptions["detail"] = new ListOptions(["TagClassName" => "ew-detail-option"]);
        // Actions
        $this->OtherOptions["action"] = new ListOptions(["TagClassName" => "ew-action-option"]);
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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "docjuzmatch3view") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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
    public $ExportOptions; // Export options
    public $OtherOptions; // Other options
    public $DisplayRecords = 1;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecKey = [];
    public $IsModal = false;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Update last accessed time
        if (!IsSysAdmin() && !$UserProfile->isValidUser(CurrentUserName(), session_id())) {
            Write($Language->phrase("UserProfileCorrupted"));
            $this->terminate();
            return;
        }
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->setVisibility();
        $this->document_date->setVisibility();
        $this->years->setVisibility();
        $this->start_date->setVisibility();
        $this->end_date->setVisibility();
        $this->asset_code->setVisibility();
        $this->asset_project->setVisibility();
        $this->asset_deed->setVisibility();
        $this->asset_area->setVisibility();
        $this->appoint_agent_date->setVisibility();
        $this->buyer_name->setVisibility();
        $this->buyer_lname->setVisibility();
        $this->buyer_email->setVisibility();
        $this->buyer_idcard->setVisibility();
        $this->buyer_homeno->setVisibility();
        $this->buyer_witness_name->setVisibility();
        $this->buyer_witness_lname->setVisibility();
        $this->buyer_witness_email->setVisibility();
        $this->investor_name->setVisibility();
        $this->investor_lname->setVisibility();
        $this->investor_email->setVisibility();
        $this->juzmatch_authority_name->setVisibility();
        $this->juzmatch_authority_lname->setVisibility();
        $this->juzmatch_authority_email->setVisibility();
        $this->juzmatch_authority_witness_name->setVisibility();
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
        $this->file_idcard->setVisibility();
        $this->file_house_regis->setVisibility();
        $this->file_titledeed->setVisibility();
        $this->file_other->setVisibility();
        $this->attach_file->setVisibility();
        $this->status->setVisibility();
        $this->doc_creden_id->setVisibility();
        $this->cdate->setVisibility();
        $this->cuser->setVisibility();
        $this->cip->setVisibility();
        $this->udate->setVisibility();
        $this->uuser->setVisibility();
        $this->uip->setVisibility();
        $this->doc_date->setVisibility();
        $this->buyer_booking_asset_id->setVisibility();
        $this->first_down->setVisibility();
        $this->first_down_txt->setVisibility();
        $this->second_down->setVisibility();
        $this->second_down_txt->setVisibility();
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

        // Set up lookup cache
        $this->setupLookupOptions($this->status);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }

        // Load current record
        $loadCurrentRecord = false;
        $returnUrl = "";
        $matchRecord = false;

        // Set up master/detail parameters
        $this->setupMasterParms();
        if ($this->isPageRequest()) { // Validate request
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->RecKey["id"] = $this->id->QueryStringValue;
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->RecKey["id"] = $this->id->FormValue;
            } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->RecKey["id"] = $this->id->QueryStringValue;
            } else {
                $returnUrl = "docjuzmatch3list"; // Return to list
            }

            // Get action
            $this->CurrentAction = "show"; // Display
            switch ($this->CurrentAction) {
                case "show": // Get a record to display

                        // Load record based on key
                        if (IsApi()) {
                            $filter = $this->getRecordFilter();
                            $this->CurrentFilter = $filter;
                            $sql = $this->getCurrentSql();
                            $conn = $this->getConnection();
                            $this->Recordset = LoadRecordset($sql, $conn);
                            $res = $this->Recordset && !$this->Recordset->EOF;
                        } else {
                            $res = $this->loadRow();
                        }
                        if (!$res) { // Load record based on key
                            if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                            }
                            $returnUrl = "docjuzmatch3list"; // No matching record, return to list
                        }
                    break;
            }
        } else {
            $returnUrl = "docjuzmatch3list"; // Not page request, return to list
        }
        if ($returnUrl != "") {
            $this->terminate($returnUrl);
            return;
        }

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Render row
        $this->RowType = ROWTYPE_VIEW;
        $this->resetAttributes();
        $this->renderRow();

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset, true); // Get current record only
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows]);
            $this->terminate(true);
            return;
        }

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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("ViewPageAddLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        }
        $item->Visible = ($this->AddUrl != "" && $Security->canAdd());

        // Edit
        $item = &$option->add("edit");
        $editcaption = HtmlTitle($Language->phrase("ViewPageEditLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        }
        $item->Visible = ($this->EditUrl != "" && $Security->canEdit());

        // Set up action default
        $option = $options["action"];
        $option->DropDownButtonPhrase = $Language->phrase("ButtonActions");
        $option->UseDropDownButton = false;
        $option->UseButtonGroup = true;
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
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
        if ($this->AuditTrailOnView) {
            $this->writeAuditTrailOnView($row);
        }
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

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->AddUrl = $this->getAddUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();
        $this->ListUrl = $this->getListUrl();
        $this->setupOtherOptions();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

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

        // status

        // doc_creden_id

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // doc_date

        // buyer_booking_asset_id

        // first_down

        // first_down_txt

        // second_down

        // second_down_txt

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

            // buyer_name
            $this->buyer_name->ViewValue = $this->buyer_name->CurrentValue;
            $this->buyer_name->ViewCustomAttributes = "";

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

            // buyer_witness_name
            $this->buyer_witness_name->ViewValue = $this->buyer_witness_name->CurrentValue;
            $this->buyer_witness_name->ViewCustomAttributes = "";

            // buyer_witness_lname
            $this->buyer_witness_lname->ViewValue = $this->buyer_witness_lname->CurrentValue;
            $this->buyer_witness_lname->ViewCustomAttributes = "";

            // buyer_witness_email
            $this->buyer_witness_email->ViewValue = $this->buyer_witness_email->CurrentValue;
            $this->buyer_witness_email->ViewCustomAttributes = "";

            // investor_name
            $this->investor_name->ViewValue = $this->investor_name->CurrentValue;
            $this->investor_name->ViewCustomAttributes = "";

            // investor_lname
            $this->investor_lname->ViewValue = $this->investor_lname->CurrentValue;
            $this->investor_lname->ViewCustomAttributes = "";

            // investor_email
            $this->investor_email->ViewValue = $this->investor_email->CurrentValue;
            $this->investor_email->ViewCustomAttributes = "";

            // juzmatch_authority_name
            $this->juzmatch_authority_name->ViewValue = $this->juzmatch_authority_name->CurrentValue;
            $this->juzmatch_authority_name->ViewCustomAttributes = "";

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->ViewValue = $this->juzmatch_authority_lname->CurrentValue;
            $this->juzmatch_authority_lname->ViewCustomAttributes = "";

            // juzmatch_authority_email
            $this->juzmatch_authority_email->ViewValue = $this->juzmatch_authority_email->CurrentValue;
            $this->juzmatch_authority_email->ViewCustomAttributes = "";

            // juzmatch_authority_witness_name
            $this->juzmatch_authority_witness_name->ViewValue = $this->juzmatch_authority_witness_name->CurrentValue;
            $this->juzmatch_authority_witness_name->ViewCustomAttributes = "";

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

            // file_idcard
            $this->file_idcard->UploadPath = "/upload/";
            if (!EmptyValue($this->file_idcard->Upload->DbValue)) {
                $this->file_idcard->ViewValue = $this->file_idcard->Upload->DbValue;
            } else {
                $this->file_idcard->ViewValue = "";
            }
            $this->file_idcard->ViewCustomAttributes = "";

            // file_house_regis
            $this->file_house_regis->UploadPath = "/upload/";
            if (!EmptyValue($this->file_house_regis->Upload->DbValue)) {
                $this->file_house_regis->ViewValue = $this->file_house_regis->Upload->DbValue;
            } else {
                $this->file_house_regis->ViewValue = "";
            }
            $this->file_house_regis->ViewCustomAttributes = "";

            // file_titledeed
            $this->file_titledeed->UploadPath = "/upload/";
            if (!EmptyValue($this->file_titledeed->Upload->DbValue)) {
                $this->file_titledeed->ViewValue = $this->file_titledeed->Upload->DbValue;
            } else {
                $this->file_titledeed->ViewValue = "";
            }
            $this->file_titledeed->ViewCustomAttributes = "";

            // file_other
            $this->file_other->UploadPath = "/upload/";
            if (!EmptyValue($this->file_other->Upload->DbValue)) {
                $this->file_other->ViewValue = $this->file_other->Upload->DbValue;
            } else {
                $this->file_other->ViewValue = "";
            }
            $this->file_other->ViewCustomAttributes = "";

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

            // buyer_name
            $this->buyer_name->LinkCustomAttributes = "";
            $this->buyer_name->HrefValue = "";
            $this->buyer_name->TooltipValue = "";

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

            // buyer_witness_name
            $this->buyer_witness_name->LinkCustomAttributes = "";
            $this->buyer_witness_name->HrefValue = "";
            $this->buyer_witness_name->TooltipValue = "";

            // buyer_witness_lname
            $this->buyer_witness_lname->LinkCustomAttributes = "";
            $this->buyer_witness_lname->HrefValue = "";
            $this->buyer_witness_lname->TooltipValue = "";

            // buyer_witness_email
            $this->buyer_witness_email->LinkCustomAttributes = "";
            $this->buyer_witness_email->HrefValue = "";
            $this->buyer_witness_email->TooltipValue = "";

            // investor_name
            $this->investor_name->LinkCustomAttributes = "";
            $this->investor_name->HrefValue = "";
            $this->investor_name->TooltipValue = "";

            // investor_lname
            $this->investor_lname->LinkCustomAttributes = "";
            $this->investor_lname->HrefValue = "";
            $this->investor_lname->TooltipValue = "";

            // investor_email
            $this->investor_email->LinkCustomAttributes = "";
            $this->investor_email->HrefValue = "";
            $this->investor_email->TooltipValue = "";

            // juzmatch_authority_name
            $this->juzmatch_authority_name->LinkCustomAttributes = "";
            $this->juzmatch_authority_name->HrefValue = "";
            $this->juzmatch_authority_name->TooltipValue = "";

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority_lname->HrefValue = "";
            $this->juzmatch_authority_lname->TooltipValue = "";

            // juzmatch_authority_email
            $this->juzmatch_authority_email->LinkCustomAttributes = "";
            $this->juzmatch_authority_email->HrefValue = "";
            $this->juzmatch_authority_email->TooltipValue = "";

            // juzmatch_authority_witness_name
            $this->juzmatch_authority_witness_name->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_name->HrefValue = "";
            $this->juzmatch_authority_witness_name->TooltipValue = "";

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

            // file_idcard
            $this->file_idcard->LinkCustomAttributes = "";
            $this->file_idcard->HrefValue = "";
            $this->file_idcard->ExportHrefValue = $this->file_idcard->UploadPath . $this->file_idcard->Upload->DbValue;
            $this->file_idcard->TooltipValue = "";

            // file_house_regis
            $this->file_house_regis->LinkCustomAttributes = "";
            $this->file_house_regis->HrefValue = "";
            $this->file_house_regis->ExportHrefValue = $this->file_house_regis->UploadPath . $this->file_house_regis->Upload->DbValue;
            $this->file_house_regis->TooltipValue = "";

            // file_titledeed
            $this->file_titledeed->LinkCustomAttributes = "";
            $this->file_titledeed->HrefValue = "";
            $this->file_titledeed->ExportHrefValue = $this->file_titledeed->UploadPath . $this->file_titledeed->Upload->DbValue;
            $this->file_titledeed->TooltipValue = "";

            // file_other
            $this->file_other->LinkCustomAttributes = "";
            $this->file_other->HrefValue = "";
            $this->file_other->ExportHrefValue = $this->file_other->UploadPath . $this->file_other->Upload->DbValue;
            $this->file_other->TooltipValue = "";

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
            $this->setSessionWhere($this->getDetailFilterFromSession());

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("docjuzmatch3list"), "", $this->TableVar, true);
        $pageId = "view";
        $Breadcrumb->add("view", $pageId, $url);
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
}
