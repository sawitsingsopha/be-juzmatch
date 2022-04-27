<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class BuyerAllAssetRentView extends BuyerAllAssetRent
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'buyer_all_asset_rent';

    // Page object name
    public $PageObjName = "BuyerAllAssetRentView";

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

        // Table object (buyer_all_asset_rent)
        if (!isset($GLOBALS["buyer_all_asset_rent"]) || get_class($GLOBALS["buyer_all_asset_rent"]) == PROJECT_NAMESPACE . "buyer_all_asset_rent") {
            $GLOBALS["buyer_all_asset_rent"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();
        if (($keyValue = Get("buyer_asset_rent_id") ?? Route("buyer_asset_rent_id")) !== null) {
            $this->RecKey["buyer_asset_rent_id"] = $keyValue;
        }

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
                    if ($pageName == "buyerallassetrentview") {
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
        $this->buyer_asset_rent_id->setVisibility();
        $this->asset_id->setVisibility();
        $this->member_id->setVisibility();
        $this->one_time_status->setVisibility();
        $this->half_price_1->setVisibility();
        $this->pay_number_half_price_1->setVisibility();
        $this->status_pay_half_price_1->setVisibility();
        $this->date_pay_half_price_1->setVisibility();
        $this->due_date_pay_half_price_1->setVisibility();
        $this->half_price_2->setVisibility();
        $this->pay_number_half_price_2->setVisibility();
        $this->status_pay_half_price_2->setVisibility();
        $this->date_pay_half_price_2->setVisibility();
        $this->due_date_pay_half_price_2->setVisibility();
        $this->cdate->setVisibility();
        $this->cip->setVisibility();
        $this->cuser->setVisibility();
        $this->uuser->setVisibility();
        $this->uip->setVisibility();
        $this->udate->setVisibility();
        $this->transaction_datetime1->setVisibility();
        $this->payment_scheme1->setVisibility();
        $this->transaction_ref1->setVisibility();
        $this->channel_response_desc1->setVisibility();
        $this->res_status1->setVisibility();
        $this->res_referenceNo1->setVisibility();
        $this->transaction_datetime2->setVisibility();
        $this->payment_scheme2->setVisibility();
        $this->transaction_ref2->setVisibility();
        $this->channel_response_desc2->setVisibility();
        $this->res_status2->setVisibility();
        $this->res_referenceNo2->setVisibility();
        $this->status_approve->setVisibility();
        $this->res_paidAgent1->setVisibility();
        $this->res_paidChannel1->setVisibility();
        $this->res_maskedPan1->setVisibility();
        $this->res_paidAgent2->setVisibility();
        $this->res_paidChannel2->setVisibility();
        $this->res_maskedPan2->setVisibility();
        $this->is_email1->setVisibility();
        $this->is_email2->setVisibility();
        $this->receipt_status1->setVisibility();
        $this->receipt_status2->setVisibility();
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
        $this->setupLookupOptions($this->asset_id);
        $this->setupLookupOptions($this->member_id);
        $this->setupLookupOptions($this->one_time_status);
        $this->setupLookupOptions($this->status_pay_half_price_1);
        $this->setupLookupOptions($this->status_pay_half_price_2);

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
            if (($keyValue = Get("buyer_asset_rent_id") ?? Route("buyer_asset_rent_id")) !== null) {
                $this->buyer_asset_rent_id->setQueryStringValue($keyValue);
                $this->RecKey["buyer_asset_rent_id"] = $this->buyer_asset_rent_id->QueryStringValue;
            } elseif (Post("buyer_asset_rent_id") !== null) {
                $this->buyer_asset_rent_id->setFormValue(Post("buyer_asset_rent_id"));
                $this->RecKey["buyer_asset_rent_id"] = $this->buyer_asset_rent_id->FormValue;
            } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
                $this->buyer_asset_rent_id->setQueryStringValue($keyValue);
                $this->RecKey["buyer_asset_rent_id"] = $this->buyer_asset_rent_id->QueryStringValue;
            } else {
                $returnUrl = "buyerallassetrentlist"; // Return to list
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
                            $returnUrl = "buyerallassetrentlist"; // No matching record, return to list
                        }
                    break;
            }
        } else {
            $returnUrl = "buyerallassetrentlist"; // Not page request, return to list
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
        $row = [];
        $row['buyer_asset_rent_id'] = null;
        $row['asset_id'] = null;
        $row['member_id'] = null;
        $row['one_time_status'] = null;
        $row['half_price_1'] = null;
        $row['pay_number_half_price_1'] = null;
        $row['status_pay_half_price_1'] = null;
        $row['date_pay_half_price_1'] = null;
        $row['due_date_pay_half_price_1'] = null;
        $row['half_price_2'] = null;
        $row['pay_number_half_price_2'] = null;
        $row['status_pay_half_price_2'] = null;
        $row['date_pay_half_price_2'] = null;
        $row['due_date_pay_half_price_2'] = null;
        $row['cdate'] = null;
        $row['cip'] = null;
        $row['cuser'] = null;
        $row['uuser'] = null;
        $row['uip'] = null;
        $row['udate'] = null;
        $row['transaction_datetime1'] = null;
        $row['payment_scheme1'] = null;
        $row['transaction_ref1'] = null;
        $row['channel_response_desc1'] = null;
        $row['res_status1'] = null;
        $row['res_referenceNo1'] = null;
        $row['transaction_datetime2'] = null;
        $row['payment_scheme2'] = null;
        $row['transaction_ref2'] = null;
        $row['channel_response_desc2'] = null;
        $row['res_status2'] = null;
        $row['res_referenceNo2'] = null;
        $row['status_approve'] = null;
        $row['res_paidAgent1'] = null;
        $row['res_paidChannel1'] = null;
        $row['res_maskedPan1'] = null;
        $row['res_paidAgent2'] = null;
        $row['res_paidChannel2'] = null;
        $row['res_maskedPan2'] = null;
        $row['is_email1'] = null;
        $row['is_email2'] = null;
        $row['receipt_status1'] = null;
        $row['receipt_status2'] = null;
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

        // buyer_asset_rent_id

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

        // payment_scheme1

        // transaction_ref1

        // channel_response_desc1

        // res_status1

        // res_referenceNo1

        // transaction_datetime2

        // payment_scheme2

        // transaction_ref2

        // channel_response_desc2

        // res_status2

        // res_referenceNo2

        // status_approve

        // res_paidAgent1

        // res_paidChannel1

        // res_maskedPan1

        // res_paidAgent2

        // res_paidChannel2

        // res_maskedPan2

        // is_email1

        // is_email2

        // receipt_status1

        // receipt_status2

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

            // pay_number_half_price_1
            $this->pay_number_half_price_1->LinkCustomAttributes = "";
            $this->pay_number_half_price_1->HrefValue = "";
            $this->pay_number_half_price_1->TooltipValue = "";

            // status_pay_half_price_1
            $this->status_pay_half_price_1->LinkCustomAttributes = "";
            $this->status_pay_half_price_1->HrefValue = "";
            $this->status_pay_half_price_1->TooltipValue = "";

            // date_pay_half_price_1
            $this->date_pay_half_price_1->LinkCustomAttributes = "";
            $this->date_pay_half_price_1->HrefValue = "";
            $this->date_pay_half_price_1->TooltipValue = "";

            // due_date_pay_half_price_1
            $this->due_date_pay_half_price_1->LinkCustomAttributes = "";
            $this->due_date_pay_half_price_1->HrefValue = "";
            $this->due_date_pay_half_price_1->TooltipValue = "";

            // half_price_2
            $this->half_price_2->LinkCustomAttributes = "";
            $this->half_price_2->HrefValue = "";
            $this->half_price_2->TooltipValue = "";

            // pay_number_half_price_2
            $this->pay_number_half_price_2->LinkCustomAttributes = "";
            $this->pay_number_half_price_2->HrefValue = "";
            $this->pay_number_half_price_2->TooltipValue = "";

            // status_pay_half_price_2
            $this->status_pay_half_price_2->LinkCustomAttributes = "";
            $this->status_pay_half_price_2->HrefValue = "";
            $this->status_pay_half_price_2->TooltipValue = "";

            // date_pay_half_price_2
            $this->date_pay_half_price_2->LinkCustomAttributes = "";
            $this->date_pay_half_price_2->HrefValue = "";
            $this->date_pay_half_price_2->TooltipValue = "";

            // due_date_pay_half_price_2
            $this->due_date_pay_half_price_2->LinkCustomAttributes = "";
            $this->due_date_pay_half_price_2->HrefValue = "";
            $this->due_date_pay_half_price_2->TooltipValue = "";

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
                if (($parm = Get("fk_asset_id", Get("asset_id"))) !== null) {
                    $masterTbl->asset_id->setQueryStringValue($parm);
                    $this->asset_id->setQueryStringValue($masterTbl->asset_id->QueryStringValue);
                    $this->asset_id->setSessionValue($this->asset_id->QueryStringValue);
                    if (!is_numeric($masterTbl->asset_id->QueryStringValue)) {
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
                if (($parm = Post("fk_asset_id", Post("asset_id"))) !== null) {
                    $masterTbl->asset_id->setFormValue($parm);
                    $this->asset_id->setFormValue($masterTbl->asset_id->FormValue);
                    $this->asset_id->setSessionValue($this->asset_id->FormValue);
                    if (!is_numeric($masterTbl->asset_id->FormValue)) {
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
                if ($this->asset_id->CurrentValue == "") {
                    $this->asset_id->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("buyerallassetrentlist"), "", $this->TableVar, true);
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
