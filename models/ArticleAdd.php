<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class ArticleAdd extends Article
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'article';

    // Page object name
    public $PageObjName = "ArticleAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

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

        // Table object (article)
        if (!isset($GLOBALS["article"]) || get_class($GLOBALS["article"]) == PROJECT_NAMESPACE . "article") {
            $GLOBALS["article"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'article');
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
                $tbl = Container("article");
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
                    if ($pageName == "articleview") {
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
		        $this->image->OldUploadPath = './upload/Juzhightlight';
		        $this->image->UploadPath = $this->image->OldUploadPath;
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
            $key .= @$ar['article_id'];
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
            $this->article_id->Visible = false;
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
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

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
        $this->article_id->Visible = false;
        $this->article_category_id->setVisibility();
        $this->_title->setVisibility();
        $this->title_en->setVisibility();
        $this->detail->setVisibility();
        $this->detail_en->setVisibility();
        $this->image->setVisibility();
        $this->order_by->setVisibility();
        $this->tag->setVisibility();
        $this->highlight->setVisibility();
        $this->count_view->Visible = false;
        $this->count_share_facebook->Visible = false;
        $this->count_share_line->Visible = false;
        $this->count_share_twitter->Visible = false;
        $this->count_share_email->Visible = false;
        $this->active_status->setVisibility();
        $this->meta_title->setVisibility();
        $this->meta_title_en->setVisibility();
        $this->meta_description->setVisibility();
        $this->meta_description_en->setVisibility();
        $this->meta_keyword->setVisibility();
        $this->meta_keyword_en->setVisibility();
        $this->og_tag_title->Visible = false;
        $this->og_tag_title_en->Visible = false;
        $this->og_tag_type->Visible = false;
        $this->og_tag_url->Visible = false;
        $this->og_tag_description->Visible = false;
        $this->og_tag_description_en->Visible = false;
        $this->og_tag_image->Visible = false;
        $this->cdate->setVisibility();
        $this->cuser->setVisibility();
        $this->cip->setVisibility();
        $this->udate->setVisibility();
        $this->uuser->setVisibility();
        $this->uip->setVisibility();
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
        $this->setupLookupOptions($this->article_category_id);
        $this->setupLookupOptions($this->highlight);
        $this->setupLookupOptions($this->active_status);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("article_id") ?? Route("article_id")) !== null) {
                $this->article_id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("articlelist"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "articlelist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "articleview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
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
        $this->image->Upload->Index = $CurrentForm->Index;
        $this->image->Upload->uploadFile();
        $this->image->CurrentValue = $this->image->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->article_id->CurrentValue = null;
        $this->article_id->OldValue = $this->article_id->CurrentValue;
        $this->article_category_id->CurrentValue = null;
        $this->article_category_id->OldValue = $this->article_category_id->CurrentValue;
        $this->_title->CurrentValue = null;
        $this->_title->OldValue = $this->_title->CurrentValue;
        $this->title_en->CurrentValue = null;
        $this->title_en->OldValue = $this->title_en->CurrentValue;
        $this->detail->CurrentValue = null;
        $this->detail->OldValue = $this->detail->CurrentValue;
        $this->detail_en->CurrentValue = null;
        $this->detail_en->OldValue = $this->detail_en->CurrentValue;
        $this->image->Upload->DbValue = null;
        $this->image->OldValue = $this->image->Upload->DbValue;
        $this->image->CurrentValue = null; // Clear file related field
        $this->order_by->CurrentValue = 0;
        $this->tag->CurrentValue = null;
        $this->tag->OldValue = $this->tag->CurrentValue;
        $this->highlight->CurrentValue = 0;
        $this->count_view->CurrentValue = 0;
        $this->count_share_facebook->CurrentValue = null;
        $this->count_share_facebook->OldValue = $this->count_share_facebook->CurrentValue;
        $this->count_share_line->CurrentValue = null;
        $this->count_share_line->OldValue = $this->count_share_line->CurrentValue;
        $this->count_share_twitter->CurrentValue = null;
        $this->count_share_twitter->OldValue = $this->count_share_twitter->CurrentValue;
        $this->count_share_email->CurrentValue = null;
        $this->count_share_email->OldValue = $this->count_share_email->CurrentValue;
        $this->active_status->CurrentValue = 1;
        $this->meta_title->CurrentValue = null;
        $this->meta_title->OldValue = $this->meta_title->CurrentValue;
        $this->meta_title_en->CurrentValue = null;
        $this->meta_title_en->OldValue = $this->meta_title_en->CurrentValue;
        $this->meta_description->CurrentValue = null;
        $this->meta_description->OldValue = $this->meta_description->CurrentValue;
        $this->meta_description_en->CurrentValue = null;
        $this->meta_description_en->OldValue = $this->meta_description_en->CurrentValue;
        $this->meta_keyword->CurrentValue = null;
        $this->meta_keyword->OldValue = $this->meta_keyword->CurrentValue;
        $this->meta_keyword_en->CurrentValue = null;
        $this->meta_keyword_en->OldValue = $this->meta_keyword_en->CurrentValue;
        $this->og_tag_title->CurrentValue = null;
        $this->og_tag_title->OldValue = $this->og_tag_title->CurrentValue;
        $this->og_tag_title_en->CurrentValue = null;
        $this->og_tag_title_en->OldValue = $this->og_tag_title_en->CurrentValue;
        $this->og_tag_type->CurrentValue = null;
        $this->og_tag_type->OldValue = $this->og_tag_type->CurrentValue;
        $this->og_tag_url->CurrentValue = null;
        $this->og_tag_url->OldValue = $this->og_tag_url->CurrentValue;
        $this->og_tag_description->CurrentValue = null;
        $this->og_tag_description->OldValue = $this->og_tag_description->CurrentValue;
        $this->og_tag_description_en->CurrentValue = null;
        $this->og_tag_description_en->OldValue = $this->og_tag_description_en->CurrentValue;
        $this->og_tag_image->CurrentValue = null;
        $this->og_tag_image->OldValue = $this->og_tag_image->CurrentValue;
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
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'article_category_id' first before field var 'x_article_category_id'
        $val = $CurrentForm->hasValue("article_category_id") ? $CurrentForm->getValue("article_category_id") : $CurrentForm->getValue("x_article_category_id");
        if (!$this->article_category_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->article_category_id->Visible = false; // Disable update for API request
            } else {
                $this->article_category_id->setFormValue($val);
            }
        }

        // Check field name 'title' first before field var 'x__title'
        $val = $CurrentForm->hasValue("title") ? $CurrentForm->getValue("title") : $CurrentForm->getValue("x__title");
        if (!$this->_title->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_title->Visible = false; // Disable update for API request
            } else {
                $this->_title->setFormValue($val);
            }
        }

        // Check field name 'title_en' first before field var 'x_title_en'
        $val = $CurrentForm->hasValue("title_en") ? $CurrentForm->getValue("title_en") : $CurrentForm->getValue("x_title_en");
        if (!$this->title_en->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->title_en->Visible = false; // Disable update for API request
            } else {
                $this->title_en->setFormValue($val);
            }
        }

        // Check field name 'detail' first before field var 'x_detail'
        $val = $CurrentForm->hasValue("detail") ? $CurrentForm->getValue("detail") : $CurrentForm->getValue("x_detail");
        if (!$this->detail->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->detail->Visible = false; // Disable update for API request
            } else {
                $this->detail->setFormValue($val);
            }
        }

        // Check field name 'detail_en' first before field var 'x_detail_en'
        $val = $CurrentForm->hasValue("detail_en") ? $CurrentForm->getValue("detail_en") : $CurrentForm->getValue("x_detail_en");
        if (!$this->detail_en->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->detail_en->Visible = false; // Disable update for API request
            } else {
                $this->detail_en->setFormValue($val);
            }
        }

        // Check field name 'order_by' first before field var 'x_order_by'
        $val = $CurrentForm->hasValue("order_by") ? $CurrentForm->getValue("order_by") : $CurrentForm->getValue("x_order_by");
        if (!$this->order_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->order_by->Visible = false; // Disable update for API request
            } else {
                $this->order_by->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'tag' first before field var 'x_tag'
        $val = $CurrentForm->hasValue("tag") ? $CurrentForm->getValue("tag") : $CurrentForm->getValue("x_tag");
        if (!$this->tag->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tag->Visible = false; // Disable update for API request
            } else {
                $this->tag->setFormValue($val);
            }
        }

        // Check field name 'highlight' first before field var 'x_highlight'
        $val = $CurrentForm->hasValue("highlight") ? $CurrentForm->getValue("highlight") : $CurrentForm->getValue("x_highlight");
        if (!$this->highlight->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->highlight->Visible = false; // Disable update for API request
            } else {
                $this->highlight->setFormValue($val);
            }
        }

        // Check field name 'active_status' first before field var 'x_active_status'
        $val = $CurrentForm->hasValue("active_status") ? $CurrentForm->getValue("active_status") : $CurrentForm->getValue("x_active_status");
        if (!$this->active_status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->active_status->Visible = false; // Disable update for API request
            } else {
                $this->active_status->setFormValue($val);
            }
        }

        // Check field name 'meta_title' first before field var 'x_meta_title'
        $val = $CurrentForm->hasValue("meta_title") ? $CurrentForm->getValue("meta_title") : $CurrentForm->getValue("x_meta_title");
        if (!$this->meta_title->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->meta_title->Visible = false; // Disable update for API request
            } else {
                $this->meta_title->setFormValue($val);
            }
        }

        // Check field name 'meta_title_en' first before field var 'x_meta_title_en'
        $val = $CurrentForm->hasValue("meta_title_en") ? $CurrentForm->getValue("meta_title_en") : $CurrentForm->getValue("x_meta_title_en");
        if (!$this->meta_title_en->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->meta_title_en->Visible = false; // Disable update for API request
            } else {
                $this->meta_title_en->setFormValue($val);
            }
        }

        // Check field name 'meta_description' first before field var 'x_meta_description'
        $val = $CurrentForm->hasValue("meta_description") ? $CurrentForm->getValue("meta_description") : $CurrentForm->getValue("x_meta_description");
        if (!$this->meta_description->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->meta_description->Visible = false; // Disable update for API request
            } else {
                $this->meta_description->setFormValue($val);
            }
        }

        // Check field name 'meta_description_en' first before field var 'x_meta_description_en'
        $val = $CurrentForm->hasValue("meta_description_en") ? $CurrentForm->getValue("meta_description_en") : $CurrentForm->getValue("x_meta_description_en");
        if (!$this->meta_description_en->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->meta_description_en->Visible = false; // Disable update for API request
            } else {
                $this->meta_description_en->setFormValue($val);
            }
        }

        // Check field name 'meta_keyword' first before field var 'x_meta_keyword'
        $val = $CurrentForm->hasValue("meta_keyword") ? $CurrentForm->getValue("meta_keyword") : $CurrentForm->getValue("x_meta_keyword");
        if (!$this->meta_keyword->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->meta_keyword->Visible = false; // Disable update for API request
            } else {
                $this->meta_keyword->setFormValue($val);
            }
        }

        // Check field name 'meta_keyword_en' first before field var 'x_meta_keyword_en'
        $val = $CurrentForm->hasValue("meta_keyword_en") ? $CurrentForm->getValue("meta_keyword_en") : $CurrentForm->getValue("x_meta_keyword_en");
        if (!$this->meta_keyword_en->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->meta_keyword_en->Visible = false; // Disable update for API request
            } else {
                $this->meta_keyword_en->setFormValue($val);
            }
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

        // Check field name 'cuser' first before field var 'x_cuser'
        $val = $CurrentForm->hasValue("cuser") ? $CurrentForm->getValue("cuser") : $CurrentForm->getValue("x_cuser");
        if (!$this->cuser->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cuser->Visible = false; // Disable update for API request
            } else {
                $this->cuser->setFormValue($val);
            }
        }

        // Check field name 'cip' first before field var 'x_cip'
        $val = $CurrentForm->hasValue("cip") ? $CurrentForm->getValue("cip") : $CurrentForm->getValue("x_cip");
        if (!$this->cip->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cip->Visible = false; // Disable update for API request
            } else {
                $this->cip->setFormValue($val);
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

        // Check field name 'article_id' first before field var 'x_article_id'
        $val = $CurrentForm->hasValue("article_id") ? $CurrentForm->getValue("article_id") : $CurrentForm->getValue("x_article_id");
		$this->image->OldUploadPath = './upload/Juzhightlight';
		$this->image->UploadPath = $this->image->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->article_category_id->CurrentValue = $this->article_category_id->FormValue;
        $this->_title->CurrentValue = $this->_title->FormValue;
        $this->title_en->CurrentValue = $this->title_en->FormValue;
        $this->detail->CurrentValue = $this->detail->FormValue;
        $this->detail_en->CurrentValue = $this->detail_en->FormValue;
        $this->order_by->CurrentValue = $this->order_by->FormValue;
        $this->tag->CurrentValue = $this->tag->FormValue;
        $this->highlight->CurrentValue = $this->highlight->FormValue;
        $this->active_status->CurrentValue = $this->active_status->FormValue;
        $this->meta_title->CurrentValue = $this->meta_title->FormValue;
        $this->meta_title_en->CurrentValue = $this->meta_title_en->FormValue;
        $this->meta_description->CurrentValue = $this->meta_description->FormValue;
        $this->meta_description_en->CurrentValue = $this->meta_description_en->FormValue;
        $this->meta_keyword->CurrentValue = $this->meta_keyword->FormValue;
        $this->meta_keyword_en->CurrentValue = $this->meta_keyword_en->FormValue;
        $this->cdate->CurrentValue = $this->cdate->FormValue;
        $this->cdate->CurrentValue = UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
        $this->cuser->CurrentValue = $this->cuser->FormValue;
        $this->cip->CurrentValue = $this->cip->FormValue;
        $this->udate->CurrentValue = $this->udate->FormValue;
        $this->udate->CurrentValue = UnFormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern());
        $this->uuser->CurrentValue = $this->uuser->FormValue;
        $this->uip->CurrentValue = $this->uip->FormValue;
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
        $this->article_id->setDbValue($row['article_id']);
        $this->article_category_id->setDbValue($row['article_category_id']);
        $this->_title->setDbValue($row['title']);
        $this->title_en->setDbValue($row['title_en']);
        $this->detail->setDbValue($row['detail']);
        $this->detail_en->setDbValue($row['detail_en']);
        $this->image->Upload->DbValue = $row['image'];
        $this->image->setDbValue($this->image->Upload->DbValue);
        $this->order_by->setDbValue($row['order_by']);
        $this->tag->setDbValue($row['tag']);
        $this->highlight->setDbValue($row['highlight']);
        $this->count_view->setDbValue($row['count_view']);
        $this->count_share_facebook->setDbValue($row['count_share_facebook']);
        $this->count_share_line->setDbValue($row['count_share_line']);
        $this->count_share_twitter->setDbValue($row['count_share_twitter']);
        $this->count_share_email->setDbValue($row['count_share_email']);
        $this->active_status->setDbValue($row['active_status']);
        $this->meta_title->setDbValue($row['meta_title']);
        $this->meta_title_en->setDbValue($row['meta_title_en']);
        $this->meta_description->setDbValue($row['meta_description']);
        $this->meta_description_en->setDbValue($row['meta_description_en']);
        $this->meta_keyword->setDbValue($row['meta_keyword']);
        $this->meta_keyword_en->setDbValue($row['meta_keyword_en']);
        $this->og_tag_title->setDbValue($row['og_tag_title']);
        $this->og_tag_title_en->setDbValue($row['og_tag_title_en']);
        $this->og_tag_type->setDbValue($row['og_tag_type']);
        $this->og_tag_url->setDbValue($row['og_tag_url']);
        $this->og_tag_description->setDbValue($row['og_tag_description']);
        $this->og_tag_description_en->setDbValue($row['og_tag_description_en']);
        $this->og_tag_image->setDbValue($row['og_tag_image']);
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
        $row['article_id'] = $this->article_id->CurrentValue;
        $row['article_category_id'] = $this->article_category_id->CurrentValue;
        $row['title'] = $this->_title->CurrentValue;
        $row['title_en'] = $this->title_en->CurrentValue;
        $row['detail'] = $this->detail->CurrentValue;
        $row['detail_en'] = $this->detail_en->CurrentValue;
        $row['image'] = $this->image->Upload->DbValue;
        $row['order_by'] = $this->order_by->CurrentValue;
        $row['tag'] = $this->tag->CurrentValue;
        $row['highlight'] = $this->highlight->CurrentValue;
        $row['count_view'] = $this->count_view->CurrentValue;
        $row['count_share_facebook'] = $this->count_share_facebook->CurrentValue;
        $row['count_share_line'] = $this->count_share_line->CurrentValue;
        $row['count_share_twitter'] = $this->count_share_twitter->CurrentValue;
        $row['count_share_email'] = $this->count_share_email->CurrentValue;
        $row['active_status'] = $this->active_status->CurrentValue;
        $row['meta_title'] = $this->meta_title->CurrentValue;
        $row['meta_title_en'] = $this->meta_title_en->CurrentValue;
        $row['meta_description'] = $this->meta_description->CurrentValue;
        $row['meta_description_en'] = $this->meta_description_en->CurrentValue;
        $row['meta_keyword'] = $this->meta_keyword->CurrentValue;
        $row['meta_keyword_en'] = $this->meta_keyword_en->CurrentValue;
        $row['og_tag_title'] = $this->og_tag_title->CurrentValue;
        $row['og_tag_title_en'] = $this->og_tag_title_en->CurrentValue;
        $row['og_tag_type'] = $this->og_tag_type->CurrentValue;
        $row['og_tag_url'] = $this->og_tag_url->CurrentValue;
        $row['og_tag_description'] = $this->og_tag_description->CurrentValue;
        $row['og_tag_description_en'] = $this->og_tag_description_en->CurrentValue;
        $row['og_tag_image'] = $this->og_tag_image->CurrentValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // article_id
        $this->article_id->RowCssClass = "row";

        // article_category_id
        $this->article_category_id->RowCssClass = "row";

        // title
        $this->_title->RowCssClass = "row";

        // title_en
        $this->title_en->RowCssClass = "row";

        // detail
        $this->detail->RowCssClass = "row";

        // detail_en
        $this->detail_en->RowCssClass = "row";

        // image
        $this->image->RowCssClass = "row";

        // order_by
        $this->order_by->RowCssClass = "row";

        // tag
        $this->tag->RowCssClass = "row";

        // highlight
        $this->highlight->RowCssClass = "row";

        // count_view
        $this->count_view->RowCssClass = "row";

        // count_share_facebook
        $this->count_share_facebook->RowCssClass = "row";

        // count_share_line
        $this->count_share_line->RowCssClass = "row";

        // count_share_twitter
        $this->count_share_twitter->RowCssClass = "row";

        // count_share_email
        $this->count_share_email->RowCssClass = "row";

        // active_status
        $this->active_status->RowCssClass = "row";

        // meta_title
        $this->meta_title->RowCssClass = "row";

        // meta_title_en
        $this->meta_title_en->RowCssClass = "row";

        // meta_description
        $this->meta_description->RowCssClass = "row";

        // meta_description_en
        $this->meta_description_en->RowCssClass = "row";

        // meta_keyword
        $this->meta_keyword->RowCssClass = "row";

        // meta_keyword_en
        $this->meta_keyword_en->RowCssClass = "row";

        // og_tag_title
        $this->og_tag_title->RowCssClass = "row";

        // og_tag_title_en
        $this->og_tag_title_en->RowCssClass = "row";

        // og_tag_type
        $this->og_tag_type->RowCssClass = "row";

        // og_tag_url
        $this->og_tag_url->RowCssClass = "row";

        // og_tag_description
        $this->og_tag_description->RowCssClass = "row";

        // og_tag_description_en
        $this->og_tag_description_en->RowCssClass = "row";

        // og_tag_image
        $this->og_tag_image->RowCssClass = "row";

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

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // article_category_id
            $curVal = strval($this->article_category_id->CurrentValue);
            if ($curVal != "") {
                $this->article_category_id->ViewValue = $this->article_category_id->lookupCacheOption($curVal);
                if ($this->article_category_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`article_category_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`active_status` = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->article_category_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->article_category_id->Lookup->renderViewRow($rswrk[0]);
                        $this->article_category_id->ViewValue = $this->article_category_id->displayValue($arwrk);
                    } else {
                        $this->article_category_id->ViewValue = FormatNumber($this->article_category_id->CurrentValue, $this->article_category_id->formatPattern());
                    }
                }
            } else {
                $this->article_category_id->ViewValue = null;
            }
            $this->article_category_id->ViewCustomAttributes = "";

            // title
            $this->_title->ViewValue = $this->_title->CurrentValue;
            $this->_title->ViewCustomAttributes = "";

            // title_en
            $this->title_en->ViewValue = $this->title_en->CurrentValue;
            $this->title_en->ViewCustomAttributes = "";

            // detail
            $this->detail->ViewValue = $this->detail->CurrentValue;
            $this->detail->ViewCustomAttributes = "";

            // detail_en
            $this->detail_en->ViewValue = $this->detail_en->CurrentValue;
            $this->detail_en->ViewCustomAttributes = "";

            // image
            $this->image->UploadPath = './upload/Juzhightlight';
            if (!EmptyValue($this->image->Upload->DbValue)) {
                $this->image->ImageWidth = 100;
                $this->image->ImageHeight = 100;
                $this->image->ImageAlt = $this->image->alt();
                $this->image->ImageCssClass = "ew-image";
                $this->image->ViewValue = $this->image->Upload->DbValue;
            } else {
                $this->image->ViewValue = "";
            }
            $this->image->ViewCustomAttributes = "";

            // order_by
            $this->order_by->ViewValue = $this->order_by->CurrentValue;
            $this->order_by->ViewValue = FormatNumber($this->order_by->ViewValue, $this->order_by->formatPattern());
            $this->order_by->ViewCustomAttributes = "";

            // tag
            $this->tag->ViewValue = $this->tag->CurrentValue;
            $this->tag->ViewCustomAttributes = "";

            // highlight
            if (strval($this->highlight->CurrentValue) != "") {
                $this->highlight->ViewValue = $this->highlight->optionCaption($this->highlight->CurrentValue);
            } else {
                $this->highlight->ViewValue = null;
            }
            $this->highlight->ViewCustomAttributes = "";

            // count_view
            $this->count_view->ViewValue = $this->count_view->CurrentValue;
            $this->count_view->ViewValue = FormatNumber($this->count_view->ViewValue, $this->count_view->formatPattern());
            $this->count_view->ViewCustomAttributes = "";

            // count_share_facebook
            $this->count_share_facebook->ViewValue = $this->count_share_facebook->CurrentValue;
            $this->count_share_facebook->ViewValue = FormatNumber($this->count_share_facebook->ViewValue, $this->count_share_facebook->formatPattern());
            $this->count_share_facebook->ViewCustomAttributes = "";

            // count_share_line
            $this->count_share_line->ViewValue = $this->count_share_line->CurrentValue;
            $this->count_share_line->ViewValue = FormatNumber($this->count_share_line->ViewValue, $this->count_share_line->formatPattern());
            $this->count_share_line->ViewCustomAttributes = "";

            // count_share_twitter
            $this->count_share_twitter->ViewValue = $this->count_share_twitter->CurrentValue;
            $this->count_share_twitter->ViewValue = FormatNumber($this->count_share_twitter->ViewValue, $this->count_share_twitter->formatPattern());
            $this->count_share_twitter->ViewCustomAttributes = "";

            // count_share_email
            $this->count_share_email->ViewValue = $this->count_share_email->CurrentValue;
            $this->count_share_email->ViewValue = FormatNumber($this->count_share_email->ViewValue, $this->count_share_email->formatPattern());
            $this->count_share_email->ViewCustomAttributes = "";

            // active_status
            if (strval($this->active_status->CurrentValue) != "") {
                $this->active_status->ViewValue = $this->active_status->optionCaption($this->active_status->CurrentValue);
            } else {
                $this->active_status->ViewValue = null;
            }
            $this->active_status->ViewCustomAttributes = "";

            // meta_title
            $this->meta_title->ViewValue = $this->meta_title->CurrentValue;
            $this->meta_title->ViewCustomAttributes = "";

            // meta_title_en
            $this->meta_title_en->ViewValue = $this->meta_title_en->CurrentValue;
            $this->meta_title_en->ViewCustomAttributes = "";

            // meta_description
            $this->meta_description->ViewValue = $this->meta_description->CurrentValue;
            $this->meta_description->ViewCustomAttributes = "";

            // meta_description_en
            $this->meta_description_en->ViewValue = $this->meta_description_en->CurrentValue;
            $this->meta_description_en->ViewCustomAttributes = "";

            // meta_keyword
            $this->meta_keyword->ViewValue = $this->meta_keyword->CurrentValue;
            $this->meta_keyword->ViewCustomAttributes = "";

            // meta_keyword_en
            $this->meta_keyword_en->ViewValue = $this->meta_keyword_en->CurrentValue;
            $this->meta_keyword_en->ViewCustomAttributes = "";

            // cdate
            $this->cdate->ViewValue = $this->cdate->CurrentValue;
            $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
            $this->cdate->ViewCustomAttributes = "";

            // cuser
            $this->cuser->ViewValue = $this->cuser->CurrentValue;
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
            $this->uuser->ViewCustomAttributes = "";

            // uip
            $this->uip->ViewValue = $this->uip->CurrentValue;
            $this->uip->ViewCustomAttributes = "";

            // article_category_id
            $this->article_category_id->LinkCustomAttributes = "";
            $this->article_category_id->HrefValue = "";

            // title
            $this->_title->LinkCustomAttributes = "";
            $this->_title->HrefValue = "";

            // title_en
            $this->title_en->LinkCustomAttributes = "";
            $this->title_en->HrefValue = "";

            // detail
            $this->detail->LinkCustomAttributes = "";
            $this->detail->HrefValue = "";

            // detail_en
            $this->detail_en->LinkCustomAttributes = "";
            $this->detail_en->HrefValue = "";

            // image
            $this->image->LinkCustomAttributes = "";
            $this->image->UploadPath = './upload/Juzhightlight';
            if (!EmptyValue($this->image->Upload->DbValue)) {
                $this->image->HrefValue = GetFileUploadUrl($this->image, $this->image->htmlDecode($this->image->Upload->DbValue)); // Add prefix/suffix
                $this->image->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->image->HrefValue = FullUrl($this->image->HrefValue, "href");
                }
            } else {
                $this->image->HrefValue = "";
            }
            $this->image->ExportHrefValue = $this->image->UploadPath . $this->image->Upload->DbValue;

            // order_by
            $this->order_by->LinkCustomAttributes = "";
            $this->order_by->HrefValue = "";

            // tag
            $this->tag->LinkCustomAttributes = "";
            $this->tag->HrefValue = "";

            // highlight
            $this->highlight->LinkCustomAttributes = "";
            $this->highlight->HrefValue = "";

            // active_status
            $this->active_status->LinkCustomAttributes = "";
            $this->active_status->HrefValue = "";

            // meta_title
            $this->meta_title->LinkCustomAttributes = "";
            $this->meta_title->HrefValue = "";

            // meta_title_en
            $this->meta_title_en->LinkCustomAttributes = "";
            $this->meta_title_en->HrefValue = "";

            // meta_description
            $this->meta_description->LinkCustomAttributes = "";
            $this->meta_description->HrefValue = "";

            // meta_description_en
            $this->meta_description_en->LinkCustomAttributes = "";
            $this->meta_description_en->HrefValue = "";

            // meta_keyword
            $this->meta_keyword->LinkCustomAttributes = "";
            $this->meta_keyword->HrefValue = "";

            // meta_keyword_en
            $this->meta_keyword_en->LinkCustomAttributes = "";
            $this->meta_keyword_en->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // article_category_id
            $this->article_category_id->setupEditAttributes();
            $this->article_category_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->article_category_id->CurrentValue));
            if ($curVal != "") {
                $this->article_category_id->ViewValue = $this->article_category_id->lookupCacheOption($curVal);
            } else {
                $this->article_category_id->ViewValue = $this->article_category_id->Lookup !== null && is_array($this->article_category_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->article_category_id->ViewValue !== null) { // Load from cache
                $this->article_category_id->EditValue = array_values($this->article_category_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`article_category_id`" . SearchString("=", $this->article_category_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return "`active_status` = 1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->article_category_id->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->article_category_id->EditValue = $arwrk;
            }
            $this->article_category_id->PlaceHolder = RemoveHtml($this->article_category_id->caption());

            // title
            $this->_title->setupEditAttributes();
            $this->_title->EditCustomAttributes = "";
            if (!$this->_title->Raw) {
                $this->_title->CurrentValue = HtmlDecode($this->_title->CurrentValue);
            }
            $this->_title->EditValue = HtmlEncode($this->_title->CurrentValue);
            $this->_title->PlaceHolder = RemoveHtml($this->_title->caption());

            // title_en
            $this->title_en->setupEditAttributes();
            $this->title_en->EditCustomAttributes = "";
            if (!$this->title_en->Raw) {
                $this->title_en->CurrentValue = HtmlDecode($this->title_en->CurrentValue);
            }
            $this->title_en->EditValue = HtmlEncode($this->title_en->CurrentValue);
            $this->title_en->PlaceHolder = RemoveHtml($this->title_en->caption());

            // detail
            $this->detail->setupEditAttributes();
            $this->detail->EditCustomAttributes = "";
            $this->detail->EditValue = HtmlEncode($this->detail->CurrentValue);
            $this->detail->PlaceHolder = RemoveHtml($this->detail->caption());

            // detail_en
            $this->detail_en->setupEditAttributes();
            $this->detail_en->EditCustomAttributes = "";
            $this->detail_en->EditValue = HtmlEncode($this->detail_en->CurrentValue);
            $this->detail_en->PlaceHolder = RemoveHtml($this->detail_en->caption());

            // image
            $this->image->setupEditAttributes();
            $this->image->EditCustomAttributes = "";
            $this->image->UploadPath = './upload/Juzhightlight';
            if (!EmptyValue($this->image->Upload->DbValue)) {
                $this->image->ImageWidth = 100;
                $this->image->ImageHeight = 100;
                $this->image->ImageAlt = $this->image->alt();
                $this->image->ImageCssClass = "ew-image";
                $this->image->EditValue = $this->image->Upload->DbValue;
            } else {
                $this->image->EditValue = "";
            }
            if (!EmptyValue($this->image->CurrentValue)) {
                $this->image->Upload->FileName = $this->image->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->image);
            }

            // order_by
            $this->order_by->setupEditAttributes();
            $this->order_by->EditCustomAttributes = "";
            $this->order_by->EditValue = HtmlEncode($this->order_by->CurrentValue);
            $this->order_by->PlaceHolder = RemoveHtml($this->order_by->caption());
            if (strval($this->order_by->EditValue) != "" && is_numeric($this->order_by->EditValue)) {
                $this->order_by->EditValue = FormatNumber($this->order_by->EditValue, null);
            }

            // tag
            $this->tag->setupEditAttributes();
            $this->tag->EditCustomAttributes = "";
            if (!$this->tag->Raw) {
                $this->tag->CurrentValue = HtmlDecode($this->tag->CurrentValue);
            }
            $this->tag->EditValue = HtmlEncode($this->tag->CurrentValue);
            $this->tag->PlaceHolder = RemoveHtml($this->tag->caption());

            // highlight
            $this->highlight->EditCustomAttributes = "";
            $this->highlight->EditValue = $this->highlight->options(false);
            $this->highlight->PlaceHolder = RemoveHtml($this->highlight->caption());

            // active_status
            $this->active_status->EditCustomAttributes = "";
            $this->active_status->EditValue = $this->active_status->options(false);
            $this->active_status->PlaceHolder = RemoveHtml($this->active_status->caption());

            // meta_title
            $this->meta_title->setupEditAttributes();
            $this->meta_title->EditCustomAttributes = "";
            if (!$this->meta_title->Raw) {
                $this->meta_title->CurrentValue = HtmlDecode($this->meta_title->CurrentValue);
            }
            $this->meta_title->EditValue = HtmlEncode($this->meta_title->CurrentValue);
            $this->meta_title->PlaceHolder = RemoveHtml($this->meta_title->caption());

            // meta_title_en
            $this->meta_title_en->setupEditAttributes();
            $this->meta_title_en->EditCustomAttributes = "";
            if (!$this->meta_title_en->Raw) {
                $this->meta_title_en->CurrentValue = HtmlDecode($this->meta_title_en->CurrentValue);
            }
            $this->meta_title_en->EditValue = HtmlEncode($this->meta_title_en->CurrentValue);
            $this->meta_title_en->PlaceHolder = RemoveHtml($this->meta_title_en->caption());

            // meta_description
            $this->meta_description->setupEditAttributes();
            $this->meta_description->EditCustomAttributes = "";
            if (!$this->meta_description->Raw) {
                $this->meta_description->CurrentValue = HtmlDecode($this->meta_description->CurrentValue);
            }
            $this->meta_description->EditValue = HtmlEncode($this->meta_description->CurrentValue);
            $this->meta_description->PlaceHolder = RemoveHtml($this->meta_description->caption());

            // meta_description_en
            $this->meta_description_en->setupEditAttributes();
            $this->meta_description_en->EditCustomAttributes = "";
            if (!$this->meta_description_en->Raw) {
                $this->meta_description_en->CurrentValue = HtmlDecode($this->meta_description_en->CurrentValue);
            }
            $this->meta_description_en->EditValue = HtmlEncode($this->meta_description_en->CurrentValue);
            $this->meta_description_en->PlaceHolder = RemoveHtml($this->meta_description_en->caption());

            // meta_keyword
            $this->meta_keyword->setupEditAttributes();
            $this->meta_keyword->EditCustomAttributes = "";
            $this->meta_keyword->EditValue = HtmlEncode($this->meta_keyword->CurrentValue);
            $this->meta_keyword->PlaceHolder = RemoveHtml($this->meta_keyword->caption());

            // meta_keyword_en
            $this->meta_keyword_en->setupEditAttributes();
            $this->meta_keyword_en->EditCustomAttributes = "";
            $this->meta_keyword_en->EditValue = HtmlEncode($this->meta_keyword_en->CurrentValue);
            $this->meta_keyword_en->PlaceHolder = RemoveHtml($this->meta_keyword_en->caption());

            // cdate

            // cuser

            // cip

            // udate

            // uuser

            // uip

            // Add refer script

            // article_category_id
            $this->article_category_id->LinkCustomAttributes = "";
            $this->article_category_id->HrefValue = "";

            // title
            $this->_title->LinkCustomAttributes = "";
            $this->_title->HrefValue = "";

            // title_en
            $this->title_en->LinkCustomAttributes = "";
            $this->title_en->HrefValue = "";

            // detail
            $this->detail->LinkCustomAttributes = "";
            $this->detail->HrefValue = "";

            // detail_en
            $this->detail_en->LinkCustomAttributes = "";
            $this->detail_en->HrefValue = "";

            // image
            $this->image->LinkCustomAttributes = "";
            $this->image->UploadPath = './upload/Juzhightlight';
            if (!EmptyValue($this->image->Upload->DbValue)) {
                $this->image->HrefValue = GetFileUploadUrl($this->image, $this->image->htmlDecode($this->image->Upload->DbValue)); // Add prefix/suffix
                $this->image->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->image->HrefValue = FullUrl($this->image->HrefValue, "href");
                }
            } else {
                $this->image->HrefValue = "";
            }
            $this->image->ExportHrefValue = $this->image->UploadPath . $this->image->Upload->DbValue;

            // order_by
            $this->order_by->LinkCustomAttributes = "";
            $this->order_by->HrefValue = "";

            // tag
            $this->tag->LinkCustomAttributes = "";
            $this->tag->HrefValue = "";

            // highlight
            $this->highlight->LinkCustomAttributes = "";
            $this->highlight->HrefValue = "";

            // active_status
            $this->active_status->LinkCustomAttributes = "";
            $this->active_status->HrefValue = "";

            // meta_title
            $this->meta_title->LinkCustomAttributes = "";
            $this->meta_title->HrefValue = "";

            // meta_title_en
            $this->meta_title_en->LinkCustomAttributes = "";
            $this->meta_title_en->HrefValue = "";

            // meta_description
            $this->meta_description->LinkCustomAttributes = "";
            $this->meta_description->HrefValue = "";

            // meta_description_en
            $this->meta_description_en->LinkCustomAttributes = "";
            $this->meta_description_en->HrefValue = "";

            // meta_keyword
            $this->meta_keyword->LinkCustomAttributes = "";
            $this->meta_keyword->HrefValue = "";

            // meta_keyword_en
            $this->meta_keyword_en->LinkCustomAttributes = "";
            $this->meta_keyword_en->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";
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
        if ($this->article_category_id->Required) {
            if (!$this->article_category_id->IsDetailKey && EmptyValue($this->article_category_id->FormValue)) {
                $this->article_category_id->addErrorMessage(str_replace("%s", $this->article_category_id->caption(), $this->article_category_id->RequiredErrorMessage));
            }
        }
        if ($this->_title->Required) {
            if (!$this->_title->IsDetailKey && EmptyValue($this->_title->FormValue)) {
                $this->_title->addErrorMessage(str_replace("%s", $this->_title->caption(), $this->_title->RequiredErrorMessage));
            }
        }
        if ($this->title_en->Required) {
            if (!$this->title_en->IsDetailKey && EmptyValue($this->title_en->FormValue)) {
                $this->title_en->addErrorMessage(str_replace("%s", $this->title_en->caption(), $this->title_en->RequiredErrorMessage));
            }
        }
        if ($this->detail->Required) {
            if (!$this->detail->IsDetailKey && EmptyValue($this->detail->FormValue)) {
                $this->detail->addErrorMessage(str_replace("%s", $this->detail->caption(), $this->detail->RequiredErrorMessage));
            }
        }
        if ($this->detail_en->Required) {
            if (!$this->detail_en->IsDetailKey && EmptyValue($this->detail_en->FormValue)) {
                $this->detail_en->addErrorMessage(str_replace("%s", $this->detail_en->caption(), $this->detail_en->RequiredErrorMessage));
            }
        }
        if ($this->image->Required) {
            if ($this->image->Upload->FileName == "" && !$this->image->Upload->KeepFile) {
                $this->image->addErrorMessage(str_replace("%s", $this->image->caption(), $this->image->RequiredErrorMessage));
            }
        }
        if ($this->order_by->Required) {
            if (!$this->order_by->IsDetailKey && EmptyValue($this->order_by->FormValue)) {
                $this->order_by->addErrorMessage(str_replace("%s", $this->order_by->caption(), $this->order_by->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->order_by->FormValue)) {
            $this->order_by->addErrorMessage($this->order_by->getErrorMessage(false));
        }
        if ($this->tag->Required) {
            if (!$this->tag->IsDetailKey && EmptyValue($this->tag->FormValue)) {
                $this->tag->addErrorMessage(str_replace("%s", $this->tag->caption(), $this->tag->RequiredErrorMessage));
            }
        }
        if ($this->highlight->Required) {
            if ($this->highlight->FormValue == "") {
                $this->highlight->addErrorMessage(str_replace("%s", $this->highlight->caption(), $this->highlight->RequiredErrorMessage));
            }
        }
        if ($this->active_status->Required) {
            if ($this->active_status->FormValue == "") {
                $this->active_status->addErrorMessage(str_replace("%s", $this->active_status->caption(), $this->active_status->RequiredErrorMessage));
            }
        }
        if ($this->meta_title->Required) {
            if (!$this->meta_title->IsDetailKey && EmptyValue($this->meta_title->FormValue)) {
                $this->meta_title->addErrorMessage(str_replace("%s", $this->meta_title->caption(), $this->meta_title->RequiredErrorMessage));
            }
        }
        if ($this->meta_title_en->Required) {
            if (!$this->meta_title_en->IsDetailKey && EmptyValue($this->meta_title_en->FormValue)) {
                $this->meta_title_en->addErrorMessage(str_replace("%s", $this->meta_title_en->caption(), $this->meta_title_en->RequiredErrorMessage));
            }
        }
        if ($this->meta_description->Required) {
            if (!$this->meta_description->IsDetailKey && EmptyValue($this->meta_description->FormValue)) {
                $this->meta_description->addErrorMessage(str_replace("%s", $this->meta_description->caption(), $this->meta_description->RequiredErrorMessage));
            }
        }
        if ($this->meta_description_en->Required) {
            if (!$this->meta_description_en->IsDetailKey && EmptyValue($this->meta_description_en->FormValue)) {
                $this->meta_description_en->addErrorMessage(str_replace("%s", $this->meta_description_en->caption(), $this->meta_description_en->RequiredErrorMessage));
            }
        }
        if ($this->meta_keyword->Required) {
            if (!$this->meta_keyword->IsDetailKey && EmptyValue($this->meta_keyword->FormValue)) {
                $this->meta_keyword->addErrorMessage(str_replace("%s", $this->meta_keyword->caption(), $this->meta_keyword->RequiredErrorMessage));
            }
        }
        if ($this->meta_keyword_en->Required) {
            if (!$this->meta_keyword_en->IsDetailKey && EmptyValue($this->meta_keyword_en->FormValue)) {
                $this->meta_keyword_en->addErrorMessage(str_replace("%s", $this->meta_keyword_en->caption(), $this->meta_keyword_en->RequiredErrorMessage));
            }
        }
        if ($this->cdate->Required) {
            if (!$this->cdate->IsDetailKey && EmptyValue($this->cdate->FormValue)) {
                $this->cdate->addErrorMessage(str_replace("%s", $this->cdate->caption(), $this->cdate->RequiredErrorMessage));
            }
        }
        if ($this->cuser->Required) {
            if (!$this->cuser->IsDetailKey && EmptyValue($this->cuser->FormValue)) {
                $this->cuser->addErrorMessage(str_replace("%s", $this->cuser->caption(), $this->cuser->RequiredErrorMessage));
            }
        }
        if ($this->cip->Required) {
            if (!$this->cip->IsDetailKey && EmptyValue($this->cip->FormValue)) {
                $this->cip->addErrorMessage(str_replace("%s", $this->cip->caption(), $this->cip->RequiredErrorMessage));
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
            $this->image->OldUploadPath = './upload/Juzhightlight';
            $this->image->UploadPath = $this->image->OldUploadPath;
        }
        $rsnew = [];

        // article_category_id
        $this->article_category_id->setDbValueDef($rsnew, $this->article_category_id->CurrentValue, 0, false);

        // title
        $this->_title->setDbValueDef($rsnew, $this->_title->CurrentValue, "", false);

        // title_en
        $this->title_en->setDbValueDef($rsnew, $this->title_en->CurrentValue, "", false);

        // detail
        $this->detail->setDbValueDef($rsnew, $this->detail->CurrentValue, "", false);

        // detail_en
        $this->detail_en->setDbValueDef($rsnew, $this->detail_en->CurrentValue, "", false);

        // image
        if ($this->image->Visible && !$this->image->Upload->KeepFile) {
            $this->image->Upload->DbValue = ""; // No need to delete old file
            if ($this->image->Upload->FileName == "") {
                $rsnew['image'] = null;
            } else {
                $rsnew['image'] = $this->image->Upload->FileName;
            }
        }

        // order_by
        $this->order_by->setDbValueDef($rsnew, $this->order_by->CurrentValue, 0, false);

        // tag
        $this->tag->setDbValueDef($rsnew, $this->tag->CurrentValue, null, false);

        // highlight
        $this->highlight->setDbValueDef($rsnew, $this->highlight->CurrentValue, null, strval($this->highlight->CurrentValue) == "");

        // active_status
        $this->active_status->setDbValueDef($rsnew, $this->active_status->CurrentValue, null, false);

        // meta_title
        $this->meta_title->setDbValueDef($rsnew, $this->meta_title->CurrentValue, null, false);

        // meta_title_en
        $this->meta_title_en->setDbValueDef($rsnew, $this->meta_title_en->CurrentValue, null, false);

        // meta_description
        $this->meta_description->setDbValueDef($rsnew, $this->meta_description->CurrentValue, null, false);

        // meta_description_en
        $this->meta_description_en->setDbValueDef($rsnew, $this->meta_description_en->CurrentValue, null, false);

        // meta_keyword
        $this->meta_keyword->setDbValueDef($rsnew, $this->meta_keyword->CurrentValue, null, false);

        // meta_keyword_en
        $this->meta_keyword_en->setDbValueDef($rsnew, $this->meta_keyword_en->CurrentValue, null, false);

        // cdate
        $this->cdate->CurrentValue = CurrentDateTime();
        $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

        // cuser
        $this->cuser->CurrentValue = CurrentUserID();
        $this->cuser->setDbValueDef($rsnew, $this->cuser->CurrentValue, null);

        // cip
        $this->cip->CurrentValue = CurrentUserIP();
        $this->cip->setDbValueDef($rsnew, $this->cip->CurrentValue, null);

        // udate
        $this->udate->CurrentValue = CurrentDateTime();
        $this->udate->setDbValueDef($rsnew, $this->udate->CurrentValue, null);

        // uuser
        $this->uuser->CurrentValue = CurrentUserID();
        $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, null);

        // uip
        $this->uip->CurrentValue = CurrentUserIP();
        $this->uip->setDbValueDef($rsnew, $this->uip->CurrentValue, null);
        if ($this->image->Visible && !$this->image->Upload->KeepFile) {
            $this->image->UploadPath = './upload/Juzhightlight';
            $oldFiles = EmptyValue($this->image->Upload->DbValue) ? [] : [$this->image->htmlDecode($this->image->Upload->DbValue)];
            if (!EmptyValue($this->image->Upload->FileName)) {
                $newFiles = [$this->image->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->image, $this->image->Upload->Index);
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
                            $file1 = UniqueFilename($this->image->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->image->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->image->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->image->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->image->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->image->setDbValueDef($rsnew, $this->image->Upload->FileName, null, false);
            }
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->image->Visible && !$this->image->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->image->Upload->DbValue) ? [] : [$this->image->htmlDecode($this->image->Upload->DbValue)];
                    if (!EmptyValue($this->image->Upload->FileName)) {
                        $newFiles = [$this->image->Upload->FileName];
                        $newFiles2 = [$this->image->htmlDecode($rsnew['image'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->image, $this->image->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->image->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->image->oldPhysicalUploadPath() . $oldFile);
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
            // image
            CleanUploadTempPath($this->image, $this->image->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("articlelist"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                case "x_article_category_id":
                    $lookupFilter = function () {
                        return "`active_status` = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_highlight":
                    break;
                case "x_active_status":
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
}
