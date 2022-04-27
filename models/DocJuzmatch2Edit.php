<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class DocJuzmatch2Edit extends DocJuzmatch2
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'doc_juzmatch2';

    // Page object name
    public $PageObjName = "DocJuzmatch2Edit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

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

    // Properties
    public $FormClassName = "ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
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
        $this->file_other->setVisibility();
        $this->contact_address->setVisibility();
        $this->contact_address2->setVisibility();
        $this->contact_email->setVisibility();
        $this->contact_lineid->setVisibility();
        $this->contact_phone->setVisibility();
        $this->file_loan->setVisibility();
        $this->attach_file->setVisibility();
        $this->status->setVisibility();
        $this->doc_creden_id->Visible = false;
        $this->cdate->Visible = false;
        $this->cuser->Visible = false;
        $this->cip->Visible = false;
        $this->udate->setVisibility();
        $this->uuser->setVisibility();
        $this->uip->setVisibility();
        $this->doc_date->setVisibility();
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

        // Set up lookup cache
        $this->setupLookupOptions($this->status);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
            }

            // Set up master detail parameters
            $this->setupMasterParms();

            // Load recordset
            if ($this->isShow()) {
                    // Load current record
                    $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("docjuzmatch2list"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "docjuzmatch2list") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->file_idcard->Upload->Index = $CurrentForm->Index;
        $this->file_idcard->Upload->uploadFile();
        $this->file_idcard->CurrentValue = $this->file_idcard->Upload->FileName;
        $this->file_house_regis->Upload->Index = $CurrentForm->Index;
        $this->file_house_regis->Upload->uploadFile();
        $this->file_house_regis->CurrentValue = $this->file_house_regis->Upload->FileName;
        $this->file_other->Upload->Index = $CurrentForm->Index;
        $this->file_other->Upload->uploadFile();
        $this->file_other->CurrentValue = $this->file_other->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
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

        // Check field name 'asset_code' first before field var 'x_asset_code'
        $val = $CurrentForm->hasValue("asset_code") ? $CurrentForm->getValue("asset_code") : $CurrentForm->getValue("x_asset_code");
        if (!$this->asset_code->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_code->Visible = false; // Disable update for API request
            } else {
                $this->asset_code->setFormValue($val);
            }
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

        // Check field name 'asset_deed' first before field var 'x_asset_deed'
        $val = $CurrentForm->hasValue("asset_deed") ? $CurrentForm->getValue("asset_deed") : $CurrentForm->getValue("x_asset_deed");
        if (!$this->asset_deed->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_deed->Visible = false; // Disable update for API request
            } else {
                $this->asset_deed->setFormValue($val);
            }
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

        // Check field name 'investor_name' first before field var 'x_investor_name'
        $val = $CurrentForm->hasValue("investor_name") ? $CurrentForm->getValue("investor_name") : $CurrentForm->getValue("x_investor_name");
        if (!$this->investor_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_name->Visible = false; // Disable update for API request
            } else {
                $this->investor_name->setFormValue($val);
            }
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

        // Check field name 'investor_email' first before field var 'x_investor_email'
        $val = $CurrentForm->hasValue("investor_email") ? $CurrentForm->getValue("investor_email") : $CurrentForm->getValue("x_investor_email");
        if (!$this->investor_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_email->Visible = false; // Disable update for API request
            } else {
                $this->investor_email->setFormValue($val);
            }
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

        // Check field name 'investor_homeno' first before field var 'x_investor_homeno'
        $val = $CurrentForm->hasValue("investor_homeno") ? $CurrentForm->getValue("investor_homeno") : $CurrentForm->getValue("x_investor_homeno");
        if (!$this->investor_homeno->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_homeno->Visible = false; // Disable update for API request
            } else {
                $this->investor_homeno->setFormValue($val);
            }
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

        // Check field name 'investment_money_txt' first before field var 'x_investment_money_txt'
        $val = $CurrentForm->hasValue("investment_money_txt") ? $CurrentForm->getValue("investment_money_txt") : $CurrentForm->getValue("x_investment_money_txt");
        if (!$this->investment_money_txt->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investment_money_txt->Visible = false; // Disable update for API request
            } else {
                $this->investment_money_txt->setFormValue($val);
            }
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

        // Check field name 'first_benefits_month' first before field var 'x_first_benefits_month'
        $val = $CurrentForm->hasValue("first_benefits_month") ? $CurrentForm->getValue("first_benefits_month") : $CurrentForm->getValue("x_first_benefits_month");
        if (!$this->first_benefits_month->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->first_benefits_month->Visible = false; // Disable update for API request
            } else {
                $this->first_benefits_month->setFormValue($val, true, $validate);
            }
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

        // Check field name 'two_installment_amount1' first before field var 'x_two_installment_amount1'
        $val = $CurrentForm->hasValue("two_installment_amount1") ? $CurrentForm->getValue("two_installment_amount1") : $CurrentForm->getValue("x_two_installment_amount1");
        if (!$this->two_installment_amount1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->two_installment_amount1->Visible = false; // Disable update for API request
            } else {
                $this->two_installment_amount1->setFormValue($val, true, $validate);
            }
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

        // Check field name 'investor_paid_amount' first before field var 'x_investor_paid_amount'
        $val = $CurrentForm->hasValue("investor_paid_amount") ? $CurrentForm->getValue("investor_paid_amount") : $CurrentForm->getValue("x_investor_paid_amount");
        if (!$this->investor_paid_amount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_paid_amount->Visible = false; // Disable update for API request
            } else {
                $this->investor_paid_amount->setFormValue($val, true, $validate);
            }
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

        // Check field name 'one_benefit_amount' first before field var 'x_one_benefit_amount'
        $val = $CurrentForm->hasValue("one_benefit_amount") ? $CurrentForm->getValue("one_benefit_amount") : $CurrentForm->getValue("x_one_benefit_amount");
        if (!$this->one_benefit_amount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->one_benefit_amount->Visible = false; // Disable update for API request
            } else {
                $this->one_benefit_amount->setFormValue($val, true, $validate);
            }
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

        // Check field name 'two_benefit_amount2' first before field var 'x_two_benefit_amount2'
        $val = $CurrentForm->hasValue("two_benefit_amount2") ? $CurrentForm->getValue("two_benefit_amount2") : $CurrentForm->getValue("x_two_benefit_amount2");
        if (!$this->two_benefit_amount2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->two_benefit_amount2->Visible = false; // Disable update for API request
            } else {
                $this->two_benefit_amount2->setFormValue($val, true, $validate);
            }
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

        // Check field name 'begin_date' first before field var 'x_begin_date'
        $val = $CurrentForm->hasValue("begin_date") ? $CurrentForm->getValue("begin_date") : $CurrentForm->getValue("x_begin_date");
        if (!$this->begin_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->begin_date->Visible = false; // Disable update for API request
            } else {
                $this->begin_date->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'investor_witness_name' first before field var 'x_investor_witness_name'
        $val = $CurrentForm->hasValue("investor_witness_name") ? $CurrentForm->getValue("investor_witness_name") : $CurrentForm->getValue("x_investor_witness_name");
        if (!$this->investor_witness_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_witness_name->Visible = false; // Disable update for API request
            } else {
                $this->investor_witness_name->setFormValue($val);
            }
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

        // Check field name 'investor_witness_email' first before field var 'x_investor_witness_email'
        $val = $CurrentForm->hasValue("investor_witness_email") ? $CurrentForm->getValue("investor_witness_email") : $CurrentForm->getValue("x_investor_witness_email");
        if (!$this->investor_witness_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_witness_email->Visible = false; // Disable update for API request
            } else {
                $this->investor_witness_email->setFormValue($val);
            }
        }

        // Check field name 'juzmatch_authority_name' first before field var 'x_juzmatch_authority_name'
        $val = $CurrentForm->hasValue("juzmatch_authority_name") ? $CurrentForm->getValue("juzmatch_authority_name") : $CurrentForm->getValue("x_juzmatch_authority_name");
        if (!$this->juzmatch_authority_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority_name->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority_name->setFormValue($val);
            }
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

        // Check field name 'juzmatch_authority_email' first before field var 'x_juzmatch_authority_email'
        $val = $CurrentForm->hasValue("juzmatch_authority_email") ? $CurrentForm->getValue("juzmatch_authority_email") : $CurrentForm->getValue("x_juzmatch_authority_email");
        if (!$this->juzmatch_authority_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority_email->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority_email->setFormValue($val);
            }
        }

        // Check field name 'juzmatch_authority_witness_name' first before field var 'x_juzmatch_authority_witness_name'
        $val = $CurrentForm->hasValue("juzmatch_authority_witness_name") ? $CurrentForm->getValue("juzmatch_authority_witness_name") : $CurrentForm->getValue("x_juzmatch_authority_witness_name");
        if (!$this->juzmatch_authority_witness_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority_witness_name->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority_witness_name->setFormValue($val);
            }
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

        // Check field name 'juzmatch_authority_witness_email' first before field var 'x_juzmatch_authority_witness_email'
        $val = $CurrentForm->hasValue("juzmatch_authority_witness_email") ? $CurrentForm->getValue("juzmatch_authority_witness_email") : $CurrentForm->getValue("x_juzmatch_authority_witness_email");
        if (!$this->juzmatch_authority_witness_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority_witness_email->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority_witness_email->setFormValue($val);
            }
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

        // Check field name 'juzmatch_authority2_lname' first before field var 'x_juzmatch_authority2_lname'
        $val = $CurrentForm->hasValue("juzmatch_authority2_lname") ? $CurrentForm->getValue("juzmatch_authority2_lname") : $CurrentForm->getValue("x_juzmatch_authority2_lname");
        if (!$this->juzmatch_authority2_lname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority2_lname->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority2_lname->setFormValue($val);
            }
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

        // Check field name 'company_seal_name' first before field var 'x_company_seal_name'
        $val = $CurrentForm->hasValue("company_seal_name") ? $CurrentForm->getValue("company_seal_name") : $CurrentForm->getValue("x_company_seal_name");
        if (!$this->company_seal_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->company_seal_name->Visible = false; // Disable update for API request
            } else {
                $this->company_seal_name->setFormValue($val);
            }
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

        // Check field name 'contact_address' first before field var 'x_contact_address'
        $val = $CurrentForm->hasValue("contact_address") ? $CurrentForm->getValue("contact_address") : $CurrentForm->getValue("x_contact_address");
        if (!$this->contact_address->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_address->Visible = false; // Disable update for API request
            } else {
                $this->contact_address->setFormValue($val);
            }
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

        // Check field name 'contact_email' first before field var 'x_contact_email'
        $val = $CurrentForm->hasValue("contact_email") ? $CurrentForm->getValue("contact_email") : $CurrentForm->getValue("x_contact_email");
        if (!$this->contact_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_email->Visible = false; // Disable update for API request
            } else {
                $this->contact_email->setFormValue($val);
            }
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

        // Check field name 'contact_phone' first before field var 'x_contact_phone'
        $val = $CurrentForm->hasValue("contact_phone") ? $CurrentForm->getValue("contact_phone") : $CurrentForm->getValue("x_contact_phone");
        if (!$this->contact_phone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_phone->Visible = false; // Disable update for API request
            } else {
                $this->contact_phone->setFormValue($val);
            }
        }

        // Check field name 'file_loan' first before field var 'x_file_loan'
        $val = $CurrentForm->hasValue("file_loan") ? $CurrentForm->getValue("file_loan") : $CurrentForm->getValue("x_file_loan");
        if (!$this->file_loan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->file_loan->Visible = false; // Disable update for API request
            } else {
                $this->file_loan->setFormValue($val);
            }
        }

        // Check field name 'attach_file' first before field var 'x_attach_file'
        $val = $CurrentForm->hasValue("attach_file") ? $CurrentForm->getValue("attach_file") : $CurrentForm->getValue("x_attach_file");
        if (!$this->attach_file->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->attach_file->Visible = false; // Disable update for API request
            } else {
                $this->attach_file->setFormValue($val);
            }
        }

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
            }
        }

        // Check field name 'udate' first before field var 'x_udate'
        $val = $CurrentForm->hasValue("udate") ? $CurrentForm->getValue("udate") : $CurrentForm->getValue("x_udate");
        if (!$this->udate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->udate->Visible = false; // Disable update for API request
            } else {
                $this->udate->setFormValue($val);
            }
            $this->udate->CurrentValue = UnFormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern());
        }

        // Check field name 'uuser' first before field var 'x_uuser'
        $val = $CurrentForm->hasValue("uuser") ? $CurrentForm->getValue("uuser") : $CurrentForm->getValue("x_uuser");
        if (!$this->uuser->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->uuser->Visible = false; // Disable update for API request
            } else {
                $this->uuser->setFormValue($val);
            }
        }

        // Check field name 'uip' first before field var 'x_uip'
        $val = $CurrentForm->hasValue("uip") ? $CurrentForm->getValue("uip") : $CurrentForm->getValue("x_uip");
        if (!$this->uip->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->uip->Visible = false; // Disable update for API request
            } else {
                $this->uip->setFormValue($val);
            }
        }

        // Check field name 'doc_date' first before field var 'x_doc_date'
        $val = $CurrentForm->hasValue("doc_date") ? $CurrentForm->getValue("doc_date") : $CurrentForm->getValue("x_doc_date");
        if (!$this->doc_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->doc_date->Visible = false; // Disable update for API request
            } else {
                $this->doc_date->setFormValue($val);
            }
            $this->doc_date->CurrentValue = UnFormatDateTime($this->doc_date->CurrentValue, $this->doc_date->formatPattern());
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }
		$this->file_idcard->OldUploadPath = "/upload/";
		$this->file_idcard->UploadPath = $this->file_idcard->OldUploadPath;
		$this->file_house_regis->OldUploadPath = "/upload/";
		$this->file_house_regis->UploadPath = $this->file_house_regis->OldUploadPath;
		$this->file_other->OldUploadPath = "/upload/";
		$this->file_other->UploadPath = $this->file_other->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->document_date->CurrentValue = $this->document_date->FormValue;
        $this->document_date->CurrentValue = UnFormatDateTime($this->document_date->CurrentValue, $this->document_date->formatPattern());
        $this->asset_code->CurrentValue = $this->asset_code->FormValue;
        $this->asset_project->CurrentValue = $this->asset_project->FormValue;
        $this->asset_deed->CurrentValue = $this->asset_deed->FormValue;
        $this->asset_area->CurrentValue = $this->asset_area->FormValue;
        $this->investor_name->CurrentValue = $this->investor_name->FormValue;
        $this->investor_lname->CurrentValue = $this->investor_lname->FormValue;
        $this->investor_email->CurrentValue = $this->investor_email->FormValue;
        $this->investor_idcard->CurrentValue = $this->investor_idcard->FormValue;
        $this->investor_homeno->CurrentValue = $this->investor_homeno->FormValue;
        $this->investment_money->CurrentValue = $this->investment_money->FormValue;
        $this->investment_money_txt->CurrentValue = $this->investment_money_txt->FormValue;
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
        $this->investor_witness_name->CurrentValue = $this->investor_witness_name->FormValue;
        $this->investor_witness_lname->CurrentValue = $this->investor_witness_lname->FormValue;
        $this->investor_witness_email->CurrentValue = $this->investor_witness_email->FormValue;
        $this->juzmatch_authority_name->CurrentValue = $this->juzmatch_authority_name->FormValue;
        $this->juzmatch_authority_lname->CurrentValue = $this->juzmatch_authority_lname->FormValue;
        $this->juzmatch_authority_email->CurrentValue = $this->juzmatch_authority_email->FormValue;
        $this->juzmatch_authority_witness_name->CurrentValue = $this->juzmatch_authority_witness_name->FormValue;
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
        $this->file_loan->CurrentValue = $this->file_loan->FormValue;
        $this->attach_file->CurrentValue = $this->attach_file->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->udate->CurrentValue = $this->udate->FormValue;
        $this->udate->CurrentValue = UnFormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern());
        $this->uuser->CurrentValue = $this->uuser->FormValue;
        $this->uip->CurrentValue = $this->uip->FormValue;
        $this->doc_date->CurrentValue = $this->doc_date->FormValue;
        $this->doc_date->CurrentValue = UnFormatDateTime($this->doc_date->CurrentValue, $this->doc_date->formatPattern());
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
        $this->file_house_regis->Upload->DbValue = $row['file_house_regis'];
        $this->file_house_regis->setDbValue($this->file_house_regis->Upload->DbValue);
        $this->file_other->Upload->DbValue = $row['file_other'];
        $this->file_other->setDbValue($this->file_other->Upload->DbValue);
        $this->contact_address->setDbValue($row['contact_address']);
        $this->contact_address2->setDbValue($row['contact_address2']);
        $this->contact_email->setDbValue($row['contact_email']);
        $this->contact_lineid->setDbValue($row['contact_lineid']);
        $this->contact_phone->setDbValue($row['contact_phone']);
        $this->file_loan->setDbValue($row['file_loan']);
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
        $row['file_other'] = null;
        $row['contact_address'] = null;
        $row['contact_address2'] = null;
        $row['contact_email'] = null;
        $row['contact_lineid'] = null;
        $row['contact_phone'] = null;
        $row['file_loan'] = null;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id
        $this->id->RowCssClass = "row";

        // document_date
        $this->document_date->RowCssClass = "row";

        // asset_code
        $this->asset_code->RowCssClass = "row";

        // asset_project
        $this->asset_project->RowCssClass = "row";

        // asset_deed
        $this->asset_deed->RowCssClass = "row";

        // asset_area
        $this->asset_area->RowCssClass = "row";

        // investor_name
        $this->investor_name->RowCssClass = "row";

        // investor_lname
        $this->investor_lname->RowCssClass = "row";

        // investor_email
        $this->investor_email->RowCssClass = "row";

        // investor_idcard
        $this->investor_idcard->RowCssClass = "row";

        // investor_homeno
        $this->investor_homeno->RowCssClass = "row";

        // investment_money
        $this->investment_money->RowCssClass = "row";

        // investment_money_txt
        $this->investment_money_txt->RowCssClass = "row";

        // loan_contact_date
        $this->loan_contact_date->RowCssClass = "row";

        // contract_expired
        $this->contract_expired->RowCssClass = "row";

        // first_benefits_month
        $this->first_benefits_month->RowCssClass = "row";

        // one_installment_amount
        $this->one_installment_amount->RowCssClass = "row";

        // two_installment_amount1
        $this->two_installment_amount1->RowCssClass = "row";

        // two_installment_amount2
        $this->two_installment_amount2->RowCssClass = "row";

        // investor_paid_amount
        $this->investor_paid_amount->RowCssClass = "row";

        // first_benefits_date
        $this->first_benefits_date->RowCssClass = "row";

        // one_benefit_amount
        $this->one_benefit_amount->RowCssClass = "row";

        // two_benefit_amount1
        $this->two_benefit_amount1->RowCssClass = "row";

        // two_benefit_amount2
        $this->two_benefit_amount2->RowCssClass = "row";

        // management_agent_date
        $this->management_agent_date->RowCssClass = "row";

        // begin_date
        $this->begin_date->RowCssClass = "row";

        // investor_witness_name
        $this->investor_witness_name->RowCssClass = "row";

        // investor_witness_lname
        $this->investor_witness_lname->RowCssClass = "row";

        // investor_witness_email
        $this->investor_witness_email->RowCssClass = "row";

        // juzmatch_authority_name
        $this->juzmatch_authority_name->RowCssClass = "row";

        // juzmatch_authority_lname
        $this->juzmatch_authority_lname->RowCssClass = "row";

        // juzmatch_authority_email
        $this->juzmatch_authority_email->RowCssClass = "row";

        // juzmatch_authority_witness_name
        $this->juzmatch_authority_witness_name->RowCssClass = "row";

        // juzmatch_authority_witness_lname
        $this->juzmatch_authority_witness_lname->RowCssClass = "row";

        // juzmatch_authority_witness_email
        $this->juzmatch_authority_witness_email->RowCssClass = "row";

        // juzmatch_authority2_name
        $this->juzmatch_authority2_name->RowCssClass = "row";

        // juzmatch_authority2_lname
        $this->juzmatch_authority2_lname->RowCssClass = "row";

        // juzmatch_authority2_email
        $this->juzmatch_authority2_email->RowCssClass = "row";

        // company_seal_name
        $this->company_seal_name->RowCssClass = "row";

        // company_seal_email
        $this->company_seal_email->RowCssClass = "row";

        // file_idcard
        $this->file_idcard->RowCssClass = "row";

        // file_house_regis
        $this->file_house_regis->RowCssClass = "row";

        // file_other
        $this->file_other->RowCssClass = "row";

        // contact_address
        $this->contact_address->RowCssClass = "row";

        // contact_address2
        $this->contact_address2->RowCssClass = "row";

        // contact_email
        $this->contact_email->RowCssClass = "row";

        // contact_lineid
        $this->contact_lineid->RowCssClass = "row";

        // contact_phone
        $this->contact_phone->RowCssClass = "row";

        // file_loan
        $this->file_loan->RowCssClass = "row";

        // attach_file
        $this->attach_file->RowCssClass = "row";

        // status
        $this->status->RowCssClass = "row";

        // doc_creden_id
        $this->doc_creden_id->RowCssClass = "row";

        // cdate
        $this->cdate->RowCssClass = "row";

        // cuser
        $this->cuser->RowCssClass = "row";

        // cip
        $this->cip->RowCssClass = "row";

        // udate
        $this->udate->RowCssClass = "row";

        // uuser
        $this->uuser->RowCssClass = "row";

        // uip
        $this->uip->RowCssClass = "row";

        // doc_date
        $this->doc_date->RowCssClass = "row";

        // investor_booking_id
        $this->investor_booking_id->RowCssClass = "row";

        // first_down
        $this->first_down->RowCssClass = "row";

        // first_down_txt
        $this->first_down_txt->RowCssClass = "row";

        // second_down
        $this->second_down->RowCssClass = "row";

        // second_down_txt
        $this->second_down_txt->RowCssClass = "row";

        // service_price
        $this->service_price->RowCssClass = "row";

        // service_price_txt
        $this->service_price_txt->RowCssClass = "row";

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

            // file_loan
            $this->file_loan->ViewValue = $this->file_loan->CurrentValue;
            $this->file_loan->ViewCustomAttributes = "";

            // attach_file
            $this->attach_file->ViewValue = $this->attach_file->CurrentValue;
            $this->attach_file->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

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

            // doc_date
            $this->doc_date->ViewValue = $this->doc_date->CurrentValue;
            $this->doc_date->ViewValue = FormatDateTime($this->doc_date->ViewValue, $this->doc_date->formatPattern());
            $this->doc_date->ViewCustomAttributes = "";

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

            // investor_name
            $this->investor_name->LinkCustomAttributes = "";
            $this->investor_name->HrefValue = "";

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

            // investment_money_txt
            $this->investment_money_txt->LinkCustomAttributes = "";
            $this->investment_money_txt->HrefValue = "";

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

            // investor_witness_name
            $this->investor_witness_name->LinkCustomAttributes = "";
            $this->investor_witness_name->HrefValue = "";

            // investor_witness_lname
            $this->investor_witness_lname->LinkCustomAttributes = "";
            $this->investor_witness_lname->HrefValue = "";

            // investor_witness_email
            $this->investor_witness_email->LinkCustomAttributes = "";
            $this->investor_witness_email->HrefValue = "";

            // juzmatch_authority_name
            $this->juzmatch_authority_name->LinkCustomAttributes = "";
            $this->juzmatch_authority_name->HrefValue = "";

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority_lname->HrefValue = "";

            // juzmatch_authority_email
            $this->juzmatch_authority_email->LinkCustomAttributes = "";
            $this->juzmatch_authority_email->HrefValue = "";

            // juzmatch_authority_witness_name
            $this->juzmatch_authority_witness_name->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_name->HrefValue = "";

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

            // file_idcard
            $this->file_idcard->LinkCustomAttributes = "";
            $this->file_idcard->HrefValue = "";
            $this->file_idcard->ExportHrefValue = $this->file_idcard->UploadPath . $this->file_idcard->Upload->DbValue;

            // file_house_regis
            $this->file_house_regis->LinkCustomAttributes = "";
            $this->file_house_regis->HrefValue = "";
            $this->file_house_regis->ExportHrefValue = $this->file_house_regis->UploadPath . $this->file_house_regis->Upload->DbValue;

            // file_other
            $this->file_other->LinkCustomAttributes = "";
            $this->file_other->HrefValue = "";
            $this->file_other->ExportHrefValue = $this->file_other->UploadPath . $this->file_other->Upload->DbValue;

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

            // file_loan
            $this->file_loan->LinkCustomAttributes = "";
            $this->file_loan->HrefValue = "";

            // attach_file
            $this->attach_file->LinkCustomAttributes = "";
            $this->attach_file->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";

            // doc_date
            $this->doc_date->LinkCustomAttributes = "";
            $this->doc_date->HrefValue = "";
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

            // investor_name
            $this->investor_name->setupEditAttributes();
            $this->investor_name->EditCustomAttributes = "";
            if (!$this->investor_name->Raw) {
                $this->investor_name->CurrentValue = HtmlDecode($this->investor_name->CurrentValue);
            }
            $this->investor_name->EditValue = HtmlEncode($this->investor_name->CurrentValue);
            $this->investor_name->PlaceHolder = RemoveHtml($this->investor_name->caption());

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
            }

            // investment_money_txt
            $this->investment_money_txt->setupEditAttributes();
            $this->investment_money_txt->EditCustomAttributes = "";
            if (!$this->investment_money_txt->Raw) {
                $this->investment_money_txt->CurrentValue = HtmlDecode($this->investment_money_txt->CurrentValue);
            }
            $this->investment_money_txt->EditValue = HtmlEncode($this->investment_money_txt->CurrentValue);
            $this->investment_money_txt->PlaceHolder = RemoveHtml($this->investment_money_txt->caption());

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
            }

            // one_installment_amount
            $this->one_installment_amount->setupEditAttributes();
            $this->one_installment_amount->EditCustomAttributes = "";
            $this->one_installment_amount->EditValue = HtmlEncode($this->one_installment_amount->CurrentValue);
            $this->one_installment_amount->PlaceHolder = RemoveHtml($this->one_installment_amount->caption());
            if (strval($this->one_installment_amount->EditValue) != "" && is_numeric($this->one_installment_amount->EditValue)) {
                $this->one_installment_amount->EditValue = FormatNumber($this->one_installment_amount->EditValue, null);
            }

            // two_installment_amount1
            $this->two_installment_amount1->setupEditAttributes();
            $this->two_installment_amount1->EditCustomAttributes = "";
            $this->two_installment_amount1->EditValue = HtmlEncode($this->two_installment_amount1->CurrentValue);
            $this->two_installment_amount1->PlaceHolder = RemoveHtml($this->two_installment_amount1->caption());
            if (strval($this->two_installment_amount1->EditValue) != "" && is_numeric($this->two_installment_amount1->EditValue)) {
                $this->two_installment_amount1->EditValue = FormatNumber($this->two_installment_amount1->EditValue, null);
            }

            // two_installment_amount2
            $this->two_installment_amount2->setupEditAttributes();
            $this->two_installment_amount2->EditCustomAttributes = "";
            $this->two_installment_amount2->EditValue = HtmlEncode($this->two_installment_amount2->CurrentValue);
            $this->two_installment_amount2->PlaceHolder = RemoveHtml($this->two_installment_amount2->caption());
            if (strval($this->two_installment_amount2->EditValue) != "" && is_numeric($this->two_installment_amount2->EditValue)) {
                $this->two_installment_amount2->EditValue = FormatNumber($this->two_installment_amount2->EditValue, null);
            }

            // investor_paid_amount
            $this->investor_paid_amount->setupEditAttributes();
            $this->investor_paid_amount->EditCustomAttributes = "";
            $this->investor_paid_amount->EditValue = HtmlEncode($this->investor_paid_amount->CurrentValue);
            $this->investor_paid_amount->PlaceHolder = RemoveHtml($this->investor_paid_amount->caption());
            if (strval($this->investor_paid_amount->EditValue) != "" && is_numeric($this->investor_paid_amount->EditValue)) {
                $this->investor_paid_amount->EditValue = FormatNumber($this->investor_paid_amount->EditValue, null);
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
            }

            // two_benefit_amount1
            $this->two_benefit_amount1->setupEditAttributes();
            $this->two_benefit_amount1->EditCustomAttributes = "";
            $this->two_benefit_amount1->EditValue = HtmlEncode($this->two_benefit_amount1->CurrentValue);
            $this->two_benefit_amount1->PlaceHolder = RemoveHtml($this->two_benefit_amount1->caption());
            if (strval($this->two_benefit_amount1->EditValue) != "" && is_numeric($this->two_benefit_amount1->EditValue)) {
                $this->two_benefit_amount1->EditValue = FormatNumber($this->two_benefit_amount1->EditValue, null);
            }

            // two_benefit_amount2
            $this->two_benefit_amount2->setupEditAttributes();
            $this->two_benefit_amount2->EditCustomAttributes = "";
            $this->two_benefit_amount2->EditValue = HtmlEncode($this->two_benefit_amount2->CurrentValue);
            $this->two_benefit_amount2->PlaceHolder = RemoveHtml($this->two_benefit_amount2->caption());
            if (strval($this->two_benefit_amount2->EditValue) != "" && is_numeric($this->two_benefit_amount2->EditValue)) {
                $this->two_benefit_amount2->EditValue = FormatNumber($this->two_benefit_amount2->EditValue, null);
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
            }

            // investor_witness_name
            $this->investor_witness_name->setupEditAttributes();
            $this->investor_witness_name->EditCustomAttributes = "";
            if (!$this->investor_witness_name->Raw) {
                $this->investor_witness_name->CurrentValue = HtmlDecode($this->investor_witness_name->CurrentValue);
            }
            $this->investor_witness_name->EditValue = HtmlEncode($this->investor_witness_name->CurrentValue);
            $this->investor_witness_name->PlaceHolder = RemoveHtml($this->investor_witness_name->caption());

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

            // juzmatch_authority_name
            $this->juzmatch_authority_name->setupEditAttributes();
            $this->juzmatch_authority_name->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_name->Raw) {
                $this->juzmatch_authority_name->CurrentValue = HtmlDecode($this->juzmatch_authority_name->CurrentValue);
            }
            $this->juzmatch_authority_name->EditValue = HtmlEncode($this->juzmatch_authority_name->CurrentValue);
            $this->juzmatch_authority_name->PlaceHolder = RemoveHtml($this->juzmatch_authority_name->caption());

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

            // juzmatch_authority_witness_name
            $this->juzmatch_authority_witness_name->setupEditAttributes();
            $this->juzmatch_authority_witness_name->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_witness_name->Raw) {
                $this->juzmatch_authority_witness_name->CurrentValue = HtmlDecode($this->juzmatch_authority_witness_name->CurrentValue);
            }
            $this->juzmatch_authority_witness_name->EditValue = HtmlEncode($this->juzmatch_authority_witness_name->CurrentValue);
            $this->juzmatch_authority_witness_name->PlaceHolder = RemoveHtml($this->juzmatch_authority_witness_name->caption());

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

            // file_idcard
            $this->file_idcard->setupEditAttributes();
            $this->file_idcard->EditCustomAttributes = "";
            $this->file_idcard->UploadPath = "/upload/";
            if (!EmptyValue($this->file_idcard->Upload->DbValue)) {
                $this->file_idcard->EditValue = $this->file_idcard->Upload->DbValue;
            } else {
                $this->file_idcard->EditValue = "";
            }
            if (!EmptyValue($this->file_idcard->CurrentValue)) {
                $this->file_idcard->Upload->FileName = $this->file_idcard->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->file_idcard);
            }

            // file_house_regis
            $this->file_house_regis->setupEditAttributes();
            $this->file_house_regis->EditCustomAttributes = "";
            $this->file_house_regis->UploadPath = "/upload/";
            if (!EmptyValue($this->file_house_regis->Upload->DbValue)) {
                $this->file_house_regis->EditValue = $this->file_house_regis->Upload->DbValue;
            } else {
                $this->file_house_regis->EditValue = "";
            }
            if (!EmptyValue($this->file_house_regis->CurrentValue)) {
                $this->file_house_regis->Upload->FileName = $this->file_house_regis->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->file_house_regis);
            }

            // file_other
            $this->file_other->setupEditAttributes();
            $this->file_other->EditCustomAttributes = "";
            $this->file_other->UploadPath = "/upload/";
            if (!EmptyValue($this->file_other->Upload->DbValue)) {
                $this->file_other->EditValue = $this->file_other->Upload->DbValue;
            } else {
                $this->file_other->EditValue = "";
            }
            if (!EmptyValue($this->file_other->CurrentValue)) {
                $this->file_other->Upload->FileName = $this->file_other->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->file_other);
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

            // file_loan
            $this->file_loan->setupEditAttributes();
            $this->file_loan->EditCustomAttributes = "";
            if (!$this->file_loan->Raw) {
                $this->file_loan->CurrentValue = HtmlDecode($this->file_loan->CurrentValue);
            }
            $this->file_loan->EditValue = HtmlEncode($this->file_loan->CurrentValue);
            $this->file_loan->PlaceHolder = RemoveHtml($this->file_loan->caption());

            // attach_file
            $this->attach_file->setupEditAttributes();
            $this->attach_file->EditCustomAttributes = "";
            if (!$this->attach_file->Raw) {
                $this->attach_file->CurrentValue = HtmlDecode($this->attach_file->CurrentValue);
            }
            $this->attach_file->EditValue = HtmlEncode($this->attach_file->CurrentValue);
            $this->attach_file->PlaceHolder = RemoveHtml($this->attach_file->caption());

            // status
            $this->status->setupEditAttributes();
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(true);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // udate

            // uuser

            // uip

            // doc_date

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

            // investor_name
            $this->investor_name->LinkCustomAttributes = "";
            $this->investor_name->HrefValue = "";

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

            // investment_money_txt
            $this->investment_money_txt->LinkCustomAttributes = "";
            $this->investment_money_txt->HrefValue = "";

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

            // investor_witness_name
            $this->investor_witness_name->LinkCustomAttributes = "";
            $this->investor_witness_name->HrefValue = "";

            // investor_witness_lname
            $this->investor_witness_lname->LinkCustomAttributes = "";
            $this->investor_witness_lname->HrefValue = "";

            // investor_witness_email
            $this->investor_witness_email->LinkCustomAttributes = "";
            $this->investor_witness_email->HrefValue = "";

            // juzmatch_authority_name
            $this->juzmatch_authority_name->LinkCustomAttributes = "";
            $this->juzmatch_authority_name->HrefValue = "";

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority_lname->HrefValue = "";

            // juzmatch_authority_email
            $this->juzmatch_authority_email->LinkCustomAttributes = "";
            $this->juzmatch_authority_email->HrefValue = "";

            // juzmatch_authority_witness_name
            $this->juzmatch_authority_witness_name->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_name->HrefValue = "";

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

            // file_idcard
            $this->file_idcard->LinkCustomAttributes = "";
            $this->file_idcard->HrefValue = "";
            $this->file_idcard->ExportHrefValue = $this->file_idcard->UploadPath . $this->file_idcard->Upload->DbValue;

            // file_house_regis
            $this->file_house_regis->LinkCustomAttributes = "";
            $this->file_house_regis->HrefValue = "";
            $this->file_house_regis->ExportHrefValue = $this->file_house_regis->UploadPath . $this->file_house_regis->Upload->DbValue;

            // file_other
            $this->file_other->LinkCustomAttributes = "";
            $this->file_other->HrefValue = "";
            $this->file_other->ExportHrefValue = $this->file_other->UploadPath . $this->file_other->Upload->DbValue;

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

            // file_loan
            $this->file_loan->LinkCustomAttributes = "";
            $this->file_loan->HrefValue = "";

            // attach_file
            $this->attach_file->LinkCustomAttributes = "";
            $this->attach_file->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";

            // doc_date
            $this->doc_date->LinkCustomAttributes = "";
            $this->doc_date->HrefValue = "";
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
        if ($this->investor_name->Required) {
            if (!$this->investor_name->IsDetailKey && EmptyValue($this->investor_name->FormValue)) {
                $this->investor_name->addErrorMessage(str_replace("%s", $this->investor_name->caption(), $this->investor_name->RequiredErrorMessage));
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
        if ($this->investment_money_txt->Required) {
            if (!$this->investment_money_txt->IsDetailKey && EmptyValue($this->investment_money_txt->FormValue)) {
                $this->investment_money_txt->addErrorMessage(str_replace("%s", $this->investment_money_txt->caption(), $this->investment_money_txt->RequiredErrorMessage));
            }
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
        if ($this->investor_witness_name->Required) {
            if (!$this->investor_witness_name->IsDetailKey && EmptyValue($this->investor_witness_name->FormValue)) {
                $this->investor_witness_name->addErrorMessage(str_replace("%s", $this->investor_witness_name->caption(), $this->investor_witness_name->RequiredErrorMessage));
            }
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
        if ($this->juzmatch_authority_name->Required) {
            if (!$this->juzmatch_authority_name->IsDetailKey && EmptyValue($this->juzmatch_authority_name->FormValue)) {
                $this->juzmatch_authority_name->addErrorMessage(str_replace("%s", $this->juzmatch_authority_name->caption(), $this->juzmatch_authority_name->RequiredErrorMessage));
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
        if ($this->juzmatch_authority_witness_name->Required) {
            if (!$this->juzmatch_authority_witness_name->IsDetailKey && EmptyValue($this->juzmatch_authority_witness_name->FormValue)) {
                $this->juzmatch_authority_witness_name->addErrorMessage(str_replace("%s", $this->juzmatch_authority_witness_name->caption(), $this->juzmatch_authority_witness_name->RequiredErrorMessage));
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
        if ($this->file_idcard->Required) {
            if ($this->file_idcard->Upload->FileName == "" && !$this->file_idcard->Upload->KeepFile) {
                $this->file_idcard->addErrorMessage(str_replace("%s", $this->file_idcard->caption(), $this->file_idcard->RequiredErrorMessage));
            }
        }
        if ($this->file_house_regis->Required) {
            if ($this->file_house_regis->Upload->FileName == "" && !$this->file_house_regis->Upload->KeepFile) {
                $this->file_house_regis->addErrorMessage(str_replace("%s", $this->file_house_regis->caption(), $this->file_house_regis->RequiredErrorMessage));
            }
        }
        if ($this->file_other->Required) {
            if ($this->file_other->Upload->FileName == "" && !$this->file_other->Upload->KeepFile) {
                $this->file_other->addErrorMessage(str_replace("%s", $this->file_other->caption(), $this->file_other->RequiredErrorMessage));
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
        if ($this->file_loan->Required) {
            if (!$this->file_loan->IsDetailKey && EmptyValue($this->file_loan->FormValue)) {
                $this->file_loan->addErrorMessage(str_replace("%s", $this->file_loan->caption(), $this->file_loan->RequiredErrorMessage));
            }
        }
        if ($this->attach_file->Required) {
            if (!$this->attach_file->IsDetailKey && EmptyValue($this->attach_file->FormValue)) {
                $this->attach_file->addErrorMessage(str_replace("%s", $this->attach_file->caption(), $this->attach_file->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->udate->Required) {
            if (!$this->udate->IsDetailKey && EmptyValue($this->udate->FormValue)) {
                $this->udate->addErrorMessage(str_replace("%s", $this->udate->caption(), $this->udate->RequiredErrorMessage));
            }
        }
        if ($this->uuser->Required) {
            if (!$this->uuser->IsDetailKey && EmptyValue($this->uuser->FormValue)) {
                $this->uuser->addErrorMessage(str_replace("%s", $this->uuser->caption(), $this->uuser->RequiredErrorMessage));
            }
        }
        if ($this->uip->Required) {
            if (!$this->uip->IsDetailKey && EmptyValue($this->uip->FormValue)) {
                $this->uip->addErrorMessage(str_replace("%s", $this->uip->caption(), $this->uip->RequiredErrorMessage));
            }
        }
        if ($this->doc_date->Required) {
            if (!$this->doc_date->IsDetailKey && EmptyValue($this->doc_date->FormValue)) {
                $this->doc_date->addErrorMessage(str_replace("%s", $this->doc_date->caption(), $this->doc_date->RequiredErrorMessage));
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

            // investor_name
            $this->investor_name->setDbValueDef($rsnew, $this->investor_name->CurrentValue, null, $this->investor_name->ReadOnly);

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

            // investment_money_txt
            $this->investment_money_txt->setDbValueDef($rsnew, $this->investment_money_txt->CurrentValue, null, $this->investment_money_txt->ReadOnly);

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

            // investor_witness_name
            $this->investor_witness_name->setDbValueDef($rsnew, $this->investor_witness_name->CurrentValue, null, $this->investor_witness_name->ReadOnly);

            // investor_witness_lname
            $this->investor_witness_lname->setDbValueDef($rsnew, $this->investor_witness_lname->CurrentValue, null, $this->investor_witness_lname->ReadOnly);

            // investor_witness_email
            $this->investor_witness_email->setDbValueDef($rsnew, $this->investor_witness_email->CurrentValue, null, $this->investor_witness_email->ReadOnly);

            // juzmatch_authority_name
            $this->juzmatch_authority_name->setDbValueDef($rsnew, $this->juzmatch_authority_name->CurrentValue, null, $this->juzmatch_authority_name->ReadOnly);

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->setDbValueDef($rsnew, $this->juzmatch_authority_lname->CurrentValue, null, $this->juzmatch_authority_lname->ReadOnly);

            // juzmatch_authority_email
            $this->juzmatch_authority_email->setDbValueDef($rsnew, $this->juzmatch_authority_email->CurrentValue, null, $this->juzmatch_authority_email->ReadOnly);

            // juzmatch_authority_witness_name
            $this->juzmatch_authority_witness_name->setDbValueDef($rsnew, $this->juzmatch_authority_witness_name->CurrentValue, null, $this->juzmatch_authority_witness_name->ReadOnly);

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

            // file_idcard
            if ($this->file_idcard->Visible && !$this->file_idcard->ReadOnly && !$this->file_idcard->Upload->KeepFile) {
                $this->file_idcard->Upload->DbValue = $rsold['file_idcard']; // Get original value
                if ($this->file_idcard->Upload->FileName == "") {
                    $rsnew['file_idcard'] = null;
                } else {
                    $rsnew['file_idcard'] = $this->file_idcard->Upload->FileName;
                }
            }

            // file_house_regis
            if ($this->file_house_regis->Visible && !$this->file_house_regis->ReadOnly && !$this->file_house_regis->Upload->KeepFile) {
                $this->file_house_regis->Upload->DbValue = $rsold['file_house_regis']; // Get original value
                if ($this->file_house_regis->Upload->FileName == "") {
                    $rsnew['file_house_regis'] = null;
                } else {
                    $rsnew['file_house_regis'] = $this->file_house_regis->Upload->FileName;
                }
            }

            // file_other
            if ($this->file_other->Visible && !$this->file_other->ReadOnly && !$this->file_other->Upload->KeepFile) {
                $this->file_other->Upload->DbValue = $rsold['file_other']; // Get original value
                if ($this->file_other->Upload->FileName == "") {
                    $rsnew['file_other'] = null;
                } else {
                    $rsnew['file_other'] = $this->file_other->Upload->FileName;
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

            // file_loan
            $this->file_loan->setDbValueDef($rsnew, $this->file_loan->CurrentValue, null, $this->file_loan->ReadOnly);

            // attach_file
            $this->attach_file->setDbValueDef($rsnew, $this->attach_file->CurrentValue, null, $this->attach_file->ReadOnly);

            // status
            $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, $this->status->ReadOnly);

            // udate
            $this->udate->CurrentValue = CurrentDateTime();
            $this->udate->setDbValueDef($rsnew, $this->udate->CurrentValue, null);

            // uuser
            $this->uuser->CurrentValue = CurrentUserID();
            $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, null);

            // uip
            $this->uip->CurrentValue = CurrentUserIP();
            $this->uip->setDbValueDef($rsnew, $this->uip->CurrentValue, null);

            // doc_date
            $this->doc_date->CurrentValue = CurrentDateTime();
            $this->doc_date->setDbValueDef($rsnew, $this->doc_date->CurrentValue, null);
            if ($this->file_idcard->Visible && !$this->file_idcard->Upload->KeepFile) {
                $this->file_idcard->UploadPath = "/upload/";
                $oldFiles = EmptyValue($this->file_idcard->Upload->DbValue) ? [] : [$this->file_idcard->htmlDecode($this->file_idcard->Upload->DbValue)];
                if (!EmptyValue($this->file_idcard->Upload->FileName)) {
                    $newFiles = [$this->file_idcard->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->file_idcard, $this->file_idcard->Upload->Index);
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
                                $file1 = UniqueFilename($this->file_idcard->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->file_idcard->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->file_idcard->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->file_idcard->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->file_idcard->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->file_idcard->setDbValueDef($rsnew, $this->file_idcard->Upload->FileName, null, $this->file_idcard->ReadOnly);
                }
            }
            if ($this->file_house_regis->Visible && !$this->file_house_regis->Upload->KeepFile) {
                $this->file_house_regis->UploadPath = "/upload/";
                $oldFiles = EmptyValue($this->file_house_regis->Upload->DbValue) ? [] : [$this->file_house_regis->htmlDecode($this->file_house_regis->Upload->DbValue)];
                if (!EmptyValue($this->file_house_regis->Upload->FileName)) {
                    $newFiles = [$this->file_house_regis->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->file_house_regis, $this->file_house_regis->Upload->Index);
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
                                $file1 = UniqueFilename($this->file_house_regis->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->file_house_regis->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->file_house_regis->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->file_house_regis->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->file_house_regis->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->file_house_regis->setDbValueDef($rsnew, $this->file_house_regis->Upload->FileName, null, $this->file_house_regis->ReadOnly);
                }
            }
            if ($this->file_other->Visible && !$this->file_other->Upload->KeepFile) {
                $this->file_other->UploadPath = "/upload/";
                $oldFiles = EmptyValue($this->file_other->Upload->DbValue) ? [] : [$this->file_other->htmlDecode($this->file_other->Upload->DbValue)];
                if (!EmptyValue($this->file_other->Upload->FileName)) {
                    $newFiles = [$this->file_other->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->file_other, $this->file_other->Upload->Index);
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
                                $file1 = UniqueFilename($this->file_other->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->file_other->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->file_other->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->file_other->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->file_other->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->file_other->setDbValueDef($rsnew, $this->file_other->Upload->FileName, null, $this->file_other->ReadOnly);
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
                    if ($this->file_idcard->Visible && !$this->file_idcard->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->file_idcard->Upload->DbValue) ? [] : [$this->file_idcard->htmlDecode($this->file_idcard->Upload->DbValue)];
                        if (!EmptyValue($this->file_idcard->Upload->FileName)) {
                            $newFiles = [$this->file_idcard->Upload->FileName];
                            $newFiles2 = [$this->file_idcard->htmlDecode($rsnew['file_idcard'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->file_idcard, $this->file_idcard->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->file_idcard->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                    @unlink($this->file_idcard->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                    if ($this->file_house_regis->Visible && !$this->file_house_regis->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->file_house_regis->Upload->DbValue) ? [] : [$this->file_house_regis->htmlDecode($this->file_house_regis->Upload->DbValue)];
                        if (!EmptyValue($this->file_house_regis->Upload->FileName)) {
                            $newFiles = [$this->file_house_regis->Upload->FileName];
                            $newFiles2 = [$this->file_house_regis->htmlDecode($rsnew['file_house_regis'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->file_house_regis, $this->file_house_regis->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->file_house_regis->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                    @unlink($this->file_house_regis->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                    if ($this->file_other->Visible && !$this->file_other->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->file_other->Upload->DbValue) ? [] : [$this->file_other->htmlDecode($this->file_other->Upload->DbValue)];
                        if (!EmptyValue($this->file_other->Upload->FileName)) {
                            $newFiles = [$this->file_other->Upload->FileName];
                            $newFiles2 = [$this->file_other->htmlDecode($rsnew['file_other'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->file_other, $this->file_other->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->file_other->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                    @unlink($this->file_other->oldPhysicalUploadPath() . $oldFile);
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
            // file_idcard
            CleanUploadTempPath($this->file_idcard, $this->file_idcard->Upload->Index);

            // file_house_regis
            CleanUploadTempPath($this->file_house_regis, $this->file_house_regis->Upload->Index);

            // file_other
            CleanUploadTempPath($this->file_other, $this->file_other->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
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
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
}
