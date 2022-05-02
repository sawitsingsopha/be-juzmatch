<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class DocJuzmatch2View extends DocJuzmatch2
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'doc_juzmatch2';

    // Page object name
    public $PageObjName = "DocJuzmatch2View";

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

        // Table object (doc_juzmatch2)
        if (!isset($GLOBALS["doc_juzmatch2"]) || get_class($GLOBALS["doc_juzmatch2"]) == PROJECT_NAMESPACE . "doc_juzmatch2") {
            $GLOBALS["doc_juzmatch2"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();
        if (($keyValue = Get("id") ?? Route("id")) !== null) {
            $this->RecKey["id"] = $keyValue;
        }

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
                    if ($pageName == "docjuzmatch2view") {
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
        $this->asset_code->setVisibility();
        $this->asset_project->setVisibility();
        $this->asset_deed->setVisibility();
        $this->asset_area->setVisibility();
        $this->investor_name->setVisibility();
        $this->investor_lname->setVisibility();
        $this->investor_email->setVisibility();
        $this->investor_idcard->setVisibility();
        $this->investor_homeno->setVisibility();
        $this->investment_money->setVisibility();
        $this->investment_money_txt->setVisibility();
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
        $this->investor_witness_name->setVisibility();
        $this->investor_witness_lname->setVisibility();
        $this->investor_witness_email->setVisibility();
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
        $this->file_idcard->setVisibility();
        $this->file_house_regis->setVisibility();
        $this->file_loan->setVisibility();
        $this->file_other->setVisibility();
        $this->contact_address->setVisibility();
        $this->contact_address2->setVisibility();
        $this->contact_email->setVisibility();
        $this->contact_lineid->setVisibility();
        $this->contact_phone->setVisibility();
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
        $this->investor_booking_id->setVisibility();
        $this->first_down->setVisibility();
        $this->first_down_txt->setVisibility();
        $this->second_down->setVisibility();
        $this->second_down_txt->setVisibility();
        $this->service_price->setVisibility();
        $this->service_price_txt->setVisibility();
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
                $returnUrl = "docjuzmatch2list"; // Return to list
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
                            $returnUrl = "docjuzmatch2list"; // No matching record, return to list
                        }
                    break;
            }
        } else {
            $returnUrl = "docjuzmatch2list"; // Not page request, return to list
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
        $this->file_house_regis->Upload->DbValue = $row['file_house_regis'];
        $this->file_house_regis->setDbValue($this->file_house_regis->Upload->DbValue);
        $this->file_loan->Upload->DbValue = $row['file_loan'];
        $this->file_loan->setDbValue($this->file_loan->Upload->DbValue);
        $this->file_other->Upload->DbValue = $row['file_other'];
        $this->file_other->setDbValue($this->file_other->Upload->DbValue);
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
        $row = [];
        $row['id'] = null;
        $row['document_date'] = null;
        $row['asset_code'] = null;
        $row['asset_project'] = null;
        $row['asset_deed'] = null;
        $row['asset_area'] = null;
        $row['investor_name'] = null;
        $row['investor_lname'] = null;
        $row['investor_email'] = null;
        $row['investor_idcard'] = null;
        $row['investor_homeno'] = null;
        $row['investment_money'] = null;
        $row['investment_money_txt'] = null;
        $row['loan_contact_date'] = null;
        $row['contract_expired'] = null;
        $row['first_benefits_month'] = null;
        $row['one_installment_amount'] = null;
        $row['two_installment_amount1'] = null;
        $row['two_installment_amount2'] = null;
        $row['investor_paid_amount'] = null;
        $row['first_benefits_date'] = null;
        $row['one_benefit_amount'] = null;
        $row['two_benefit_amount1'] = null;
        $row['two_benefit_amount2'] = null;
        $row['management_agent_date'] = null;
        $row['begin_date'] = null;
        $row['investor_witness_name'] = null;
        $row['investor_witness_lname'] = null;
        $row['investor_witness_email'] = null;
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
        $row['file_idcard'] = null;
        $row['file_house_regis'] = null;
        $row['file_loan'] = null;
        $row['file_other'] = null;
        $row['contact_address'] = null;
        $row['contact_address2'] = null;
        $row['contact_email'] = null;
        $row['contact_lineid'] = null;
        $row['contact_phone'] = null;
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
        $row['investor_booking_id'] = null;
        $row['first_down'] = null;
        $row['first_down_txt'] = null;
        $row['second_down'] = null;
        $row['second_down_txt'] = null;
        $row['service_price'] = null;
        $row['service_price_txt'] = null;
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

        // status

        // doc_creden_id

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // doc_date

        // investor_booking_id

        // first_down

        // first_down_txt

        // second_down

        // second_down_txt

        // service_price

        // service_price_txt

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

            // investor_name
            $this->investor_name->ViewValue = $this->investor_name->CurrentValue;
            $this->investor_name->ViewCustomAttributes = "";

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

            // investment_money_txt
            $this->investment_money_txt->ViewValue = $this->investment_money_txt->CurrentValue;
            $this->investment_money_txt->ViewCustomAttributes = "";

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

            // investor_witness_name
            $this->investor_witness_name->ViewValue = $this->investor_witness_name->CurrentValue;
            $this->investor_witness_name->ViewCustomAttributes = "";

            // investor_witness_lname
            $this->investor_witness_lname->ViewValue = $this->investor_witness_lname->CurrentValue;
            $this->investor_witness_lname->ViewCustomAttributes = "";

            // investor_witness_email
            $this->investor_witness_email->ViewValue = $this->investor_witness_email->CurrentValue;
            $this->investor_witness_email->ViewCustomAttributes = "";

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

            // file_loan
            $this->file_loan->UploadPath = "/upload/";
            if (!EmptyValue($this->file_loan->Upload->DbValue)) {
                $this->file_loan->ViewValue = $this->file_loan->Upload->DbValue;
            } else {
                $this->file_loan->ViewValue = "";
            }
            $this->file_loan->ViewCustomAttributes = "";

            // file_other
            $this->file_other->UploadPath = "/upload/";
            if (!EmptyValue($this->file_other->Upload->DbValue)) {
                $this->file_other->ViewValue = $this->file_other->Upload->DbValue;
            } else {
                $this->file_other->ViewValue = "";
            }
            $this->file_other->ViewCustomAttributes = "";

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

            // investment_money_txt
            $this->investment_money_txt->LinkCustomAttributes = "";
            $this->investment_money_txt->HrefValue = "";
            $this->investment_money_txt->TooltipValue = "";

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

            // investor_witness_name
            $this->investor_witness_name->LinkCustomAttributes = "";
            $this->investor_witness_name->HrefValue = "";
            $this->investor_witness_name->TooltipValue = "";

            // investor_witness_lname
            $this->investor_witness_lname->LinkCustomAttributes = "";
            $this->investor_witness_lname->HrefValue = "";
            $this->investor_witness_lname->TooltipValue = "";

            // investor_witness_email
            $this->investor_witness_email->LinkCustomAttributes = "";
            $this->investor_witness_email->HrefValue = "";
            $this->investor_witness_email->TooltipValue = "";

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

            // file_loan
            $this->file_loan->LinkCustomAttributes = "";
            $this->file_loan->HrefValue = "";
            $this->file_loan->ExportHrefValue = $this->file_loan->UploadPath . $this->file_loan->Upload->DbValue;
            $this->file_loan->TooltipValue = "";

            // file_other
            $this->file_other->LinkCustomAttributes = "";
            $this->file_other->HrefValue = "";
            $this->file_other->ExportHrefValue = $this->file_other->UploadPath . $this->file_other->Upload->DbValue;
            $this->file_other->TooltipValue = "";

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
            if ($masterTblVar == "invertor_all_booking") {
                $validMaster = true;
                $masterTbl = Container("invertor_all_booking");
                if (($parm = Get("fk_invertor_booking_id", Get("investor_booking_id"))) !== null) {
                    $masterTbl->invertor_booking_id->setQueryStringValue($parm);
                    $this->investor_booking_id->setQueryStringValue($masterTbl->invertor_booking_id->QueryStringValue);
                    $this->investor_booking_id->setSessionValue($this->investor_booking_id->QueryStringValue);
                    if (!is_numeric($masterTbl->invertor_booking_id->QueryStringValue)) {
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
            if ($masterTblVar == "invertor_all_booking") {
                $validMaster = true;
                $masterTbl = Container("invertor_all_booking");
                if (($parm = Post("fk_invertor_booking_id", Post("investor_booking_id"))) !== null) {
                    $masterTbl->invertor_booking_id->setFormValue($parm);
                    $this->investor_booking_id->setFormValue($masterTbl->invertor_booking_id->FormValue);
                    $this->investor_booking_id->setSessionValue($this->investor_booking_id->FormValue);
                    if (!is_numeric($masterTbl->invertor_booking_id->FormValue)) {
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
            if ($masterTblVar != "invertor_all_booking") {
                if ($this->investor_booking_id->CurrentValue == "") {
                    $this->investor_booking_id->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("docjuzmatch2list"), "", $this->TableVar, true);
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
