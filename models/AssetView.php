<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class AssetView extends Asset
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'asset';

    // Page object name
    public $PageObjName = "AssetView";

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

        // Table object (asset)
        if (!isset($GLOBALS["asset"]) || get_class($GLOBALS["asset"]) == PROJECT_NAMESPACE . "asset") {
            $GLOBALS["asset"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();
        if (($keyValue = Get("asset_id") ?? Route("asset_id")) !== null) {
            $this->RecKey["asset_id"] = $keyValue;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'asset');
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
                $tbl = Container("asset");
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
                    if ($pageName == "assetview") {
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
		        $this->floor_plan->OldUploadPath = './upload/floor_plan';
		        $this->floor_plan->UploadPath = $this->floor_plan->OldUploadPath;
		        $this->layout_unit->OldUploadPath = './upload/layout_unit';
		        $this->layout_unit->UploadPath = $this->layout_unit->OldUploadPath;
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
            $key .= @$ar['asset_id'];
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
            $this->asset_id->Visible = false;
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
    public $DetailPages; // Detail pages object

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
        $this->asset_id->setVisibility();
        $this->_title->setVisibility();
        $this->title_en->setVisibility();
        $this->brand_id->setVisibility();
        $this->asset_short_detail->setVisibility();
        $this->asset_short_detail_en->setVisibility();
        $this->detail->setVisibility();
        $this->detail_en->setVisibility();
        $this->asset_code->setVisibility();
        $this->asset_status->setVisibility();
        $this->latitude->setVisibility();
        $this->longitude->setVisibility();
        $this->num_buildings->setVisibility();
        $this->num_unit->setVisibility();
        $this->num_floors->setVisibility();
        $this->floors->setVisibility();
        $this->asset_year_developer->setVisibility();
        $this->num_parking_spaces->setVisibility();
        $this->num_bathrooms->setVisibility();
        $this->num_bedrooms->setVisibility();
        $this->address->setVisibility();
        $this->address_en->setVisibility();
        $this->province_id->setVisibility();
        $this->amphur_id->setVisibility();
        $this->district_id->setVisibility();
        $this->postcode->setVisibility();
        $this->floor_plan->setVisibility();
        $this->layout_unit->setVisibility();
        $this->asset_website->setVisibility();
        $this->asset_review->setVisibility();
        $this->isactive->setVisibility();
        $this->is_recommend->setVisibility();
        $this->order_by->setVisibility();
        $this->type_pay->setVisibility();
        $this->type_pay_2->setVisibility();
        $this->price_mark->setVisibility();
        $this->holding_property->setVisibility();
        $this->common_fee->setVisibility();
        $this->usable_area->setVisibility();
        $this->usable_area_price->setVisibility();
        $this->land_size->setVisibility();
        $this->land_size_price->setVisibility();
        $this->commission->setVisibility();
        $this->transfer_day_expenses_with_business_tax->setVisibility();
        $this->transfer_day_expenses_without_business_tax->setVisibility();
        $this->price->setVisibility();
        $this->discount->setVisibility();
        $this->price_special->setVisibility();
        $this->reservation_price_model_a->setVisibility();
        $this->minimum_down_payment_model_a->setVisibility();
        $this->down_price_min_a->setVisibility();
        $this->down_price_model_a->setVisibility();
        $this->factor_monthly_installment_over_down->setVisibility();
        $this->fee_a->setVisibility();
        $this->monthly_payment_buyer->setVisibility();
        $this->annual_interest_buyer_model_a->setVisibility();
        $this->monthly_expenses_a->setVisibility();
        $this->average_rent_a->setVisibility();
        $this->average_down_payment_a->setVisibility();
        $this->transfer_day_expenses_without_business_tax_max_min->setVisibility();
        $this->transfer_day_expenses_with_business_tax_max_min->setVisibility();
        $this->bank_appraisal_price->setVisibility();
        $this->mark_up_price->setVisibility();
        $this->required_gap->setVisibility();
        $this->minimum_down_payment->setVisibility();
        $this->price_down_max->setVisibility();
        $this->discount_max->setVisibility();
        $this->price_down_special_max->setVisibility();
        $this->usable_area_price_max->setVisibility();
        $this->land_size_price_max->setVisibility();
        $this->reservation_price_max->setVisibility();
        $this->minimum_down_payment_max->setVisibility();
        $this->down_price_max->setVisibility();
        $this->down_price->setVisibility();
        $this->factor_monthly_installment_over_down_max->setVisibility();
        $this->fee_max->setVisibility();
        $this->monthly_payment_max->setVisibility();
        $this->annual_interest_buyer->setVisibility();
        $this->monthly_expense_max->setVisibility();
        $this->average_rent_max->setVisibility();
        $this->average_down_payment_max->setVisibility();
        $this->min_down->setVisibility();
        $this->remaining_down->setVisibility();
        $this->factor_financing->setVisibility();
        $this->credit_limit_down->setVisibility();
        $this->price_down_min->setVisibility();
        $this->discount_min->setVisibility();
        $this->price_down_special_min->setVisibility();
        $this->usable_area_price_min->setVisibility();
        $this->land_size_price_min->setVisibility();
        $this->reservation_price_min->setVisibility();
        $this->minimum_down_payment_min->setVisibility();
        $this->down_price_min->setVisibility();
        $this->remaining_credit_limit_down->setVisibility();
        $this->fee_min->setVisibility();
        $this->monthly_payment_min->setVisibility();
        $this->annual_interest_buyer_model_min->setVisibility();
        $this->interest_downpayment_financing->setVisibility();
        $this->monthly_expenses_min->setVisibility();
        $this->average_rent_min->setVisibility();
        $this->average_down_payment_min->setVisibility();
        $this->installment_down_payment_loan->setVisibility();
        $this->count_view->setVisibility();
        $this->count_favorite->setVisibility();
        $this->price_invertor->setVisibility();
        $this->installment_price->setVisibility();
        $this->installment_all->setVisibility();
        $this->master_calculator->setVisibility();
        $this->expired_date->setVisibility();
        $this->tag->setVisibility();
        $this->cdate->setVisibility();
        $this->cuser->setVisibility();
        $this->cip->setVisibility();
        $this->uip->setVisibility();
        $this->udate->setVisibility();
        $this->uuser->setVisibility();
        $this->update_expired_key->setVisibility();
        $this->update_expired_status->setVisibility();
        $this->update_expired_date->setVisibility();
        $this->update_expired_ip->setVisibility();
        $this->is_cancel_contract->setVisibility();
        $this->cancel_contract_reason->setVisibility();
        $this->cancel_contract_reason_detail->setVisibility();
        $this->cancel_contract_date->setVisibility();
        $this->cancel_contract_user->setVisibility();
        $this->cancel_contract_ip->setVisibility();
        $this->hideFieldsForAddEdit();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Set up detail page object
        $this->setupDetailPages();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->brand_id);
        $this->setupLookupOptions($this->asset_status);
        $this->setupLookupOptions($this->province_id);
        $this->setupLookupOptions($this->amphur_id);
        $this->setupLookupOptions($this->district_id);
        $this->setupLookupOptions($this->isactive);
        $this->setupLookupOptions($this->is_recommend);
        $this->setupLookupOptions($this->type_pay);
        $this->setupLookupOptions($this->type_pay_2);
        $this->setupLookupOptions($this->holding_property);
        $this->setupLookupOptions($this->is_cancel_contract);

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
            if (($keyValue = Get("asset_id") ?? Route("asset_id")) !== null) {
                $this->asset_id->setQueryStringValue($keyValue);
                $this->RecKey["asset_id"] = $this->asset_id->QueryStringValue;
            } elseif (Post("asset_id") !== null) {
                $this->asset_id->setFormValue(Post("asset_id"));
                $this->RecKey["asset_id"] = $this->asset_id->FormValue;
            } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
                $this->asset_id->setQueryStringValue($keyValue);
                $this->RecKey["asset_id"] = $this->asset_id->QueryStringValue;
            } else {
                $returnUrl = "assetlist"; // Return to list
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
                            $returnUrl = "assetlist"; // No matching record, return to list
                        }
                    break;
            }
        } else {
            $returnUrl = "assetlist"; // Not page request, return to list
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

        // Set up detail parameters
        $this->setupDetailParms();

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

        // Delete
        $item = &$option->add("delete");
        if ($this->IsModal) { // Handle as inline delete
            $item->Body = "<a data-ew-action=\"inline-delete\" class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(UrlAddQuery(GetUrl($this->DeleteUrl), "action=1")) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        }
        $item->Visible = ($this->DeleteUrl != "" && $Security->canDelete());
        $option = $options["detail"];
        $detailTableLink = "";
        $detailViewTblVar = "";
        $detailCopyTblVar = "";
        $detailEditTblVar = "";

        // "detail_asset_facilities"
        $item = &$option->add("detail_asset_facilities");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("asset_facilities", "TblCaption");
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("assetfacilitieslist?" . Config("TABLE_SHOW_MASTER") . "=asset&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("AssetFacilitiesGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'asset')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=asset_facilities"))) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "asset_facilities";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'asset')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=asset_facilities"))) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "asset_facilities";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'asset_facilities');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "asset_facilities";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // "detail_asset_pros_detail"
        $item = &$option->add("detail_asset_pros_detail");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("asset_pros_detail", "TblCaption");
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("assetprosdetaillist?" . Config("TABLE_SHOW_MASTER") . "=asset&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("AssetProsDetailGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'asset')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=asset_pros_detail"))) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "asset_pros_detail";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'asset')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=asset_pros_detail"))) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "asset_pros_detail";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'asset_pros_detail');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "asset_pros_detail";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // "detail_asset_banner"
        $item = &$option->add("detail_asset_banner");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("asset_banner", "TblCaption");
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("assetbannerlist?" . Config("TABLE_SHOW_MASTER") . "=asset&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("AssetBannerGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'asset')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=asset_banner"))) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "asset_banner";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'asset')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=asset_banner"))) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "asset_banner";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'asset_banner');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "asset_banner";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // "detail_asset_category"
        $item = &$option->add("detail_asset_category");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("asset_category", "TblCaption");
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("assetcategorylist?" . Config("TABLE_SHOW_MASTER") . "=asset&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("AssetCategoryGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'asset')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=asset_category"))) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "asset_category";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'asset')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=asset_category"))) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "asset_category";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'asset_category');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "asset_category";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // "detail_asset_warning"
        $item = &$option->add("detail_asset_warning");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("asset_warning", "TblCaption");
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("assetwarninglist?" . Config("TABLE_SHOW_MASTER") . "=asset&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("AssetWarningGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'asset')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=asset_warning"))) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "asset_warning";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'asset')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=asset_warning"))) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "asset_warning";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'asset_warning');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "asset_warning";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // Multiple details
        if ($this->ShowMultipleDetails) {
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
            $links = "";
            if ($detailViewTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailViewLink", true)) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar))) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            }
            if ($detailEditTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailEditLink", true)) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar))) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            }
            if ($detailCopyTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailCopyLink", true)) . "\" href=\"" . HtmlEncode(GetUrl($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar))) . "\">" . $Language->phrase("MasterDetailCopyLink", null) . "</a></li>";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlEncode($Language->phrase("MultipleMasterDetails", true)) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
                $body .= "<ul class=\"dropdown-menu ew-menu\">" . $links . "</ul>";
            }
            $body .= "</div>";
            // Multiple details
            $item = &$option->add("details");
            $item->Body = $body;
        }

        // Set up detail default
        $option = $options["detail"];
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $ar = explode(",", $detailTableLink);
        $cnt = count($ar);
        $option->UseDropDownButton = ($cnt > 1);
        $option->UseButtonGroup = true;
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

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
        $this->asset_id->setDbValue($row['asset_id']);
        $this->_title->setDbValue($row['title']);
        $this->title_en->setDbValue($row['title_en']);
        $this->brand_id->setDbValue($row['brand_id']);
        $this->asset_short_detail->setDbValue($row['asset_short_detail']);
        $this->asset_short_detail_en->setDbValue($row['asset_short_detail_en']);
        $this->detail->setDbValue($row['detail']);
        $this->detail_en->setDbValue($row['detail_en']);
        $this->asset_code->setDbValue($row['asset_code']);
        $this->asset_status->setDbValue($row['asset_status']);
        $this->latitude->setDbValue($row['latitude']);
        $this->longitude->setDbValue($row['longitude']);
        $this->num_buildings->setDbValue($row['num_buildings']);
        $this->num_unit->setDbValue($row['num_unit']);
        $this->num_floors->setDbValue($row['num_floors']);
        $this->floors->setDbValue($row['floors']);
        $this->asset_year_developer->setDbValue($row['asset_year_developer']);
        $this->num_parking_spaces->setDbValue($row['num_parking_spaces']);
        $this->num_bathrooms->setDbValue($row['num_bathrooms']);
        $this->num_bedrooms->setDbValue($row['num_bedrooms']);
        $this->address->setDbValue($row['address']);
        $this->address_en->setDbValue($row['address_en']);
        $this->province_id->setDbValue($row['province_id']);
        $this->amphur_id->setDbValue($row['amphur_id']);
        $this->district_id->setDbValue($row['district_id']);
        $this->postcode->setDbValue($row['postcode']);
        $this->floor_plan->Upload->DbValue = $row['floor_plan'];
        $this->floor_plan->setDbValue($this->floor_plan->Upload->DbValue);
        $this->layout_unit->Upload->DbValue = $row['layout_unit'];
        $this->layout_unit->setDbValue($this->layout_unit->Upload->DbValue);
        $this->asset_website->setDbValue($row['asset_website']);
        $this->asset_review->setDbValue($row['asset_review']);
        $this->isactive->setDbValue($row['isactive']);
        $this->is_recommend->setDbValue($row['is_recommend']);
        $this->order_by->setDbValue($row['order_by']);
        $this->type_pay->setDbValue($row['type_pay']);
        $this->type_pay_2->setDbValue($row['type_pay_2']);
        $this->price_mark->setDbValue($row['price_mark']);
        $this->holding_property->setDbValue($row['holding_property']);
        $this->common_fee->setDbValue($row['common_fee']);
        $this->usable_area->setDbValue($row['usable_area']);
        $this->usable_area_price->setDbValue($row['usable_area_price']);
        $this->land_size->setDbValue($row['land_size']);
        $this->land_size_price->setDbValue($row['land_size_price']);
        $this->commission->setDbValue($row['commission']);
        $this->transfer_day_expenses_with_business_tax->setDbValue($row['transfer_day_expenses_with_business_tax']);
        $this->transfer_day_expenses_without_business_tax->setDbValue($row['transfer_day_expenses_without_business_tax']);
        $this->price->setDbValue($row['price']);
        $this->discount->setDbValue($row['discount']);
        $this->price_special->setDbValue($row['price_special']);
        $this->reservation_price_model_a->setDbValue($row['reservation_price_model_a']);
        $this->minimum_down_payment_model_a->setDbValue($row['minimum_down_payment_model_a']);
        $this->down_price_min_a->setDbValue($row['down_price_min_a']);
        $this->down_price_model_a->setDbValue($row['down_price_model_a']);
        $this->factor_monthly_installment_over_down->setDbValue($row['factor_monthly_installment_over_down']);
        $this->fee_a->setDbValue($row['fee_a']);
        $this->monthly_payment_buyer->setDbValue($row['monthly_payment_buyer']);
        $this->annual_interest_buyer_model_a->setDbValue($row['annual_interest_buyer_model_a']);
        $this->monthly_expenses_a->setDbValue($row['monthly_expenses_a']);
        $this->average_rent_a->setDbValue($row['average_rent_a']);
        $this->average_down_payment_a->setDbValue($row['average_down_payment_a']);
        $this->transfer_day_expenses_without_business_tax_max_min->setDbValue($row['transfer_day_expenses_without_business_tax_max_min']);
        $this->transfer_day_expenses_with_business_tax_max_min->setDbValue($row['transfer_day_expenses_with_business_tax_max_min']);
        $this->bank_appraisal_price->setDbValue($row['bank_appraisal_price']);
        $this->mark_up_price->setDbValue($row['mark_up_price']);
        $this->required_gap->setDbValue($row['required_gap']);
        $this->minimum_down_payment->setDbValue($row['minimum_down_payment']);
        $this->price_down_max->setDbValue($row['price_down_max']);
        $this->discount_max->setDbValue($row['discount_max']);
        $this->price_down_special_max->setDbValue($row['price_down_special_max']);
        $this->usable_area_price_max->setDbValue($row['usable_area_price_max']);
        $this->land_size_price_max->setDbValue($row['land_size_price_max']);
        $this->reservation_price_max->setDbValue($row['reservation_price_max']);
        $this->minimum_down_payment_max->setDbValue($row['minimum_down_payment_max']);
        $this->down_price_max->setDbValue($row['down_price_max']);
        $this->down_price->setDbValue($row['down_price']);
        $this->factor_monthly_installment_over_down_max->setDbValue($row['factor_monthly_installment_over_down_max']);
        $this->fee_max->setDbValue($row['fee_max']);
        $this->monthly_payment_max->setDbValue($row['monthly_payment_max']);
        $this->annual_interest_buyer->setDbValue($row['annual_interest_buyer']);
        $this->monthly_expense_max->setDbValue($row['monthly_expense_max']);
        $this->average_rent_max->setDbValue($row['average_rent_max']);
        $this->average_down_payment_max->setDbValue($row['average_down_payment_max']);
        $this->min_down->setDbValue($row['min_down']);
        $this->remaining_down->setDbValue($row['remaining_down']);
        $this->factor_financing->setDbValue($row['factor_financing']);
        $this->credit_limit_down->setDbValue($row['credit_limit_down']);
        $this->price_down_min->setDbValue($row['price_down_min']);
        $this->discount_min->setDbValue($row['discount_min']);
        $this->price_down_special_min->setDbValue($row['price_down_special_min']);
        $this->usable_area_price_min->setDbValue($row['usable_area_price_min']);
        $this->land_size_price_min->setDbValue($row['land_size_price_min']);
        $this->reservation_price_min->setDbValue($row['reservation_price_min']);
        $this->minimum_down_payment_min->setDbValue($row['minimum_down_payment_min']);
        $this->down_price_min->setDbValue($row['down_price_min']);
        $this->remaining_credit_limit_down->setDbValue($row['remaining_credit_limit_down']);
        $this->fee_min->setDbValue($row['fee_min']);
        $this->monthly_payment_min->setDbValue($row['monthly_payment_min']);
        $this->annual_interest_buyer_model_min->setDbValue($row['annual_interest_buyer_model_min']);
        $this->interest_downpayment_financing->setDbValue($row['interest_down-payment_financing']);
        $this->monthly_expenses_min->setDbValue($row['monthly_expenses_min']);
        $this->average_rent_min->setDbValue($row['average_rent_min']);
        $this->average_down_payment_min->setDbValue($row['average_down_payment_min']);
        $this->installment_down_payment_loan->setDbValue($row['installment_down_payment_loan']);
        $this->count_view->setDbValue($row['count_view']);
        $this->count_favorite->setDbValue($row['count_favorite']);
        $this->price_invertor->setDbValue($row['price_invertor']);
        $this->installment_price->setDbValue($row['installment_price']);
        $this->installment_all->setDbValue($row['installment_all']);
        $this->master_calculator->setDbValue($row['master_calculator']);
        $this->expired_date->setDbValue($row['expired_date']);
        $this->tag->setDbValue($row['tag']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->uip->setDbValue($row['uip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->update_expired_key->setDbValue($row['update_expired_key']);
        $this->update_expired_status->setDbValue($row['update_expired_status']);
        $this->update_expired_date->setDbValue($row['update_expired_date']);
        $this->update_expired_ip->setDbValue($row['update_expired_ip']);
        $this->is_cancel_contract->setDbValue($row['is_cancel_contract']);
        $this->cancel_contract_reason->setDbValue($row['cancel_contract_reason']);
        $this->cancel_contract_reason_detail->setDbValue($row['cancel_contract_reason_detail']);
        $this->cancel_contract_date->setDbValue($row['cancel_contract_date']);
        $this->cancel_contract_user->setDbValue($row['cancel_contract_user']);
        $this->cancel_contract_ip->setDbValue($row['cancel_contract_ip']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['asset_id'] = null;
        $row['title'] = null;
        $row['title_en'] = null;
        $row['brand_id'] = null;
        $row['asset_short_detail'] = null;
        $row['asset_short_detail_en'] = null;
        $row['detail'] = null;
        $row['detail_en'] = null;
        $row['asset_code'] = null;
        $row['asset_status'] = null;
        $row['latitude'] = null;
        $row['longitude'] = null;
        $row['num_buildings'] = null;
        $row['num_unit'] = null;
        $row['num_floors'] = null;
        $row['floors'] = null;
        $row['asset_year_developer'] = null;
        $row['num_parking_spaces'] = null;
        $row['num_bathrooms'] = null;
        $row['num_bedrooms'] = null;
        $row['address'] = null;
        $row['address_en'] = null;
        $row['province_id'] = null;
        $row['amphur_id'] = null;
        $row['district_id'] = null;
        $row['postcode'] = null;
        $row['floor_plan'] = null;
        $row['layout_unit'] = null;
        $row['asset_website'] = null;
        $row['asset_review'] = null;
        $row['isactive'] = null;
        $row['is_recommend'] = null;
        $row['order_by'] = null;
        $row['type_pay'] = null;
        $row['type_pay_2'] = null;
        $row['price_mark'] = null;
        $row['holding_property'] = null;
        $row['common_fee'] = null;
        $row['usable_area'] = null;
        $row['usable_area_price'] = null;
        $row['land_size'] = null;
        $row['land_size_price'] = null;
        $row['commission'] = null;
        $row['transfer_day_expenses_with_business_tax'] = null;
        $row['transfer_day_expenses_without_business_tax'] = null;
        $row['price'] = null;
        $row['discount'] = null;
        $row['price_special'] = null;
        $row['reservation_price_model_a'] = null;
        $row['minimum_down_payment_model_a'] = null;
        $row['down_price_min_a'] = null;
        $row['down_price_model_a'] = null;
        $row['factor_monthly_installment_over_down'] = null;
        $row['fee_a'] = null;
        $row['monthly_payment_buyer'] = null;
        $row['annual_interest_buyer_model_a'] = null;
        $row['monthly_expenses_a'] = null;
        $row['average_rent_a'] = null;
        $row['average_down_payment_a'] = null;
        $row['transfer_day_expenses_without_business_tax_max_min'] = null;
        $row['transfer_day_expenses_with_business_tax_max_min'] = null;
        $row['bank_appraisal_price'] = null;
        $row['mark_up_price'] = null;
        $row['required_gap'] = null;
        $row['minimum_down_payment'] = null;
        $row['price_down_max'] = null;
        $row['discount_max'] = null;
        $row['price_down_special_max'] = null;
        $row['usable_area_price_max'] = null;
        $row['land_size_price_max'] = null;
        $row['reservation_price_max'] = null;
        $row['minimum_down_payment_max'] = null;
        $row['down_price_max'] = null;
        $row['down_price'] = null;
        $row['factor_monthly_installment_over_down_max'] = null;
        $row['fee_max'] = null;
        $row['monthly_payment_max'] = null;
        $row['annual_interest_buyer'] = null;
        $row['monthly_expense_max'] = null;
        $row['average_rent_max'] = null;
        $row['average_down_payment_max'] = null;
        $row['min_down'] = null;
        $row['remaining_down'] = null;
        $row['factor_financing'] = null;
        $row['credit_limit_down'] = null;
        $row['price_down_min'] = null;
        $row['discount_min'] = null;
        $row['price_down_special_min'] = null;
        $row['usable_area_price_min'] = null;
        $row['land_size_price_min'] = null;
        $row['reservation_price_min'] = null;
        $row['minimum_down_payment_min'] = null;
        $row['down_price_min'] = null;
        $row['remaining_credit_limit_down'] = null;
        $row['fee_min'] = null;
        $row['monthly_payment_min'] = null;
        $row['annual_interest_buyer_model_min'] = null;
        $row['interest_down-payment_financing'] = null;
        $row['monthly_expenses_min'] = null;
        $row['average_rent_min'] = null;
        $row['average_down_payment_min'] = null;
        $row['installment_down_payment_loan'] = null;
        $row['count_view'] = null;
        $row['count_favorite'] = null;
        $row['price_invertor'] = null;
        $row['installment_price'] = null;
        $row['installment_all'] = null;
        $row['master_calculator'] = null;
        $row['expired_date'] = null;
        $row['tag'] = null;
        $row['cdate'] = null;
        $row['cuser'] = null;
        $row['cip'] = null;
        $row['uip'] = null;
        $row['udate'] = null;
        $row['uuser'] = null;
        $row['update_expired_key'] = null;
        $row['update_expired_status'] = null;
        $row['update_expired_date'] = null;
        $row['update_expired_ip'] = null;
        $row['is_cancel_contract'] = null;
        $row['cancel_contract_reason'] = null;
        $row['cancel_contract_reason_detail'] = null;
        $row['cancel_contract_date'] = null;
        $row['cancel_contract_user'] = null;
        $row['cancel_contract_ip'] = null;
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

        // asset_id

        // title

        // title_en

        // brand_id

        // asset_short_detail

        // asset_short_detail_en

        // detail

        // detail_en

        // asset_code

        // asset_status

        // latitude

        // longitude

        // num_buildings

        // num_unit

        // num_floors

        // floors

        // asset_year_developer

        // num_parking_spaces

        // num_bathrooms

        // num_bedrooms

        // address

        // address_en

        // province_id

        // amphur_id

        // district_id

        // postcode

        // floor_plan

        // layout_unit

        // asset_website

        // asset_review

        // isactive

        // is_recommend

        // order_by

        // type_pay

        // type_pay_2

        // price_mark

        // holding_property

        // common_fee

        // usable_area

        // usable_area_price

        // land_size

        // land_size_price

        // commission

        // transfer_day_expenses_with_business_tax

        // transfer_day_expenses_without_business_tax

        // price

        // discount

        // price_special

        // reservation_price_model_a

        // minimum_down_payment_model_a

        // down_price_min_a

        // down_price_model_a

        // factor_monthly_installment_over_down

        // fee_a

        // monthly_payment_buyer

        // annual_interest_buyer_model_a

        // monthly_expenses_a

        // average_rent_a

        // average_down_payment_a

        // transfer_day_expenses_without_business_tax_max_min

        // transfer_day_expenses_with_business_tax_max_min

        // bank_appraisal_price

        // mark_up_price

        // required_gap

        // minimum_down_payment

        // price_down_max

        // discount_max

        // price_down_special_max

        // usable_area_price_max

        // land_size_price_max

        // reservation_price_max

        // minimum_down_payment_max

        // down_price_max

        // down_price

        // factor_monthly_installment_over_down_max

        // fee_max

        // monthly_payment_max

        // annual_interest_buyer

        // monthly_expense_max

        // average_rent_max

        // average_down_payment_max

        // min_down

        // remaining_down

        // factor_financing

        // credit_limit_down

        // price_down_min

        // discount_min

        // price_down_special_min

        // usable_area_price_min

        // land_size_price_min

        // reservation_price_min

        // minimum_down_payment_min

        // down_price_min

        // remaining_credit_limit_down

        // fee_min

        // monthly_payment_min

        // annual_interest_buyer_model_min

        // interest_down-payment_financing

        // monthly_expenses_min

        // average_rent_min

        // average_down_payment_min

        // installment_down_payment_loan

        // count_view

        // count_favorite

        // price_invertor

        // installment_price

        // installment_all

        // master_calculator

        // expired_date

        // tag

        // cdate

        // cuser

        // cip

        // uip

        // udate

        // uuser

        // update_expired_key

        // update_expired_status

        // update_expired_date

        // update_expired_ip

        // is_cancel_contract

        // cancel_contract_reason

        // cancel_contract_reason_detail

        // cancel_contract_date

        // cancel_contract_user

        // cancel_contract_ip

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // title
            $this->_title->ViewValue = $this->_title->CurrentValue;
            $this->_title->ViewCustomAttributes = "";

            // title_en
            $this->title_en->ViewValue = $this->title_en->CurrentValue;
            $this->title_en->ViewCustomAttributes = "";

            // brand_id
            $curVal = strval($this->brand_id->CurrentValue);
            if ($curVal != "") {
                $this->brand_id->ViewValue = $this->brand_id->lookupCacheOption($curVal);
                if ($this->brand_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`brand_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`isactive` =1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->brand_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->brand_id->Lookup->renderViewRow($rswrk[0]);
                        $this->brand_id->ViewValue = $this->brand_id->displayValue($arwrk);
                    } else {
                        $this->brand_id->ViewValue = FormatNumber($this->brand_id->CurrentValue, $this->brand_id->formatPattern());
                    }
                }
            } else {
                $this->brand_id->ViewValue = null;
            }
            $this->brand_id->ViewCustomAttributes = "";

            // asset_short_detail
            $this->asset_short_detail->ViewValue = $this->asset_short_detail->CurrentValue;
            $this->asset_short_detail->ViewCustomAttributes = "";

            // asset_short_detail_en
            $this->asset_short_detail_en->ViewValue = $this->asset_short_detail_en->CurrentValue;
            $this->asset_short_detail_en->ViewCustomAttributes = "";

            // detail
            $this->detail->ViewValue = $this->detail->CurrentValue;
            $this->detail->ViewCustomAttributes = "";

            // detail_en
            $this->detail_en->ViewValue = $this->detail_en->CurrentValue;
            $this->detail_en->ViewCustomAttributes = "";

            // asset_code
            $this->asset_code->ViewValue = $this->asset_code->CurrentValue;
            $this->asset_code->ViewCustomAttributes = "";

            // asset_status
            if (strval($this->asset_status->CurrentValue) != "") {
                $this->asset_status->ViewValue = $this->asset_status->optionCaption($this->asset_status->CurrentValue);
            } else {
                $this->asset_status->ViewValue = null;
            }
            $this->asset_status->ViewCustomAttributes = "";

            // latitude
            $this->latitude->ViewValue = $this->latitude->CurrentValue;
            $this->latitude->ViewCustomAttributes = "";

            // longitude
            $this->longitude->ViewValue = $this->longitude->CurrentValue;
            $this->longitude->ViewCustomAttributes = "";

            // num_buildings
            $this->num_buildings->ViewValue = $this->num_buildings->CurrentValue;
            $this->num_buildings->ViewValue = FormatNumber($this->num_buildings->ViewValue, $this->num_buildings->formatPattern());
            $this->num_buildings->ViewCustomAttributes = "";

            // num_unit
            $this->num_unit->ViewValue = $this->num_unit->CurrentValue;
            $this->num_unit->ViewValue = FormatNumber($this->num_unit->ViewValue, $this->num_unit->formatPattern());
            $this->num_unit->ViewCustomAttributes = "";

            // num_floors
            $this->num_floors->ViewValue = $this->num_floors->CurrentValue;
            $this->num_floors->ViewValue = FormatNumber($this->num_floors->ViewValue, $this->num_floors->formatPattern());
            $this->num_floors->ViewCustomAttributes = "";

            // floors
            $this->floors->ViewValue = $this->floors->CurrentValue;
            $this->floors->ViewValue = FormatNumber($this->floors->ViewValue, $this->floors->formatPattern());
            $this->floors->ViewCustomAttributes = "";

            // asset_year_developer
            $this->asset_year_developer->ViewValue = $this->asset_year_developer->CurrentValue;
            $this->asset_year_developer->ViewCustomAttributes = "";

            // num_parking_spaces
            $this->num_parking_spaces->ViewValue = $this->num_parking_spaces->CurrentValue;
            $this->num_parking_spaces->ViewCustomAttributes = "";

            // num_bathrooms
            $this->num_bathrooms->ViewValue = $this->num_bathrooms->CurrentValue;
            $this->num_bathrooms->ViewCustomAttributes = "";

            // num_bedrooms
            $this->num_bedrooms->ViewValue = $this->num_bedrooms->CurrentValue;
            $this->num_bedrooms->ViewCustomAttributes = "";

            // address
            $this->address->ViewValue = $this->address->CurrentValue;
            $this->address->ViewCustomAttributes = "";

            // address_en
            $this->address_en->ViewValue = $this->address_en->CurrentValue;
            $this->address_en->ViewCustomAttributes = "";

            // province_id
            $curVal = strval($this->province_id->CurrentValue);
            if ($curVal != "") {
                $this->province_id->ViewValue = $this->province_id->lookupCacheOption($curVal);
                if ($this->province_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`province_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->province_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->province_id->Lookup->renderViewRow($rswrk[0]);
                        $this->province_id->ViewValue = $this->province_id->displayValue($arwrk);
                    } else {
                        $this->province_id->ViewValue = FormatNumber($this->province_id->CurrentValue, $this->province_id->formatPattern());
                    }
                }
            } else {
                $this->province_id->ViewValue = null;
            }
            $this->province_id->ViewCustomAttributes = "";

            // amphur_id
            $curVal = strval($this->amphur_id->CurrentValue);
            if ($curVal != "") {
                $this->amphur_id->ViewValue = $this->amphur_id->lookupCacheOption($curVal);
                if ($this->amphur_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`amphur_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->amphur_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->amphur_id->Lookup->renderViewRow($rswrk[0]);
                        $this->amphur_id->ViewValue = $this->amphur_id->displayValue($arwrk);
                    } else {
                        $this->amphur_id->ViewValue = FormatNumber($this->amphur_id->CurrentValue, $this->amphur_id->formatPattern());
                    }
                }
            } else {
                $this->amphur_id->ViewValue = null;
            }
            $this->amphur_id->ViewCustomAttributes = "";

            // district_id
            $curVal = strval($this->district_id->CurrentValue);
            if ($curVal != "") {
                $this->district_id->ViewValue = $this->district_id->lookupCacheOption($curVal);
                if ($this->district_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`subdistrict_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->district_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->district_id->Lookup->renderViewRow($rswrk[0]);
                        $this->district_id->ViewValue = $this->district_id->displayValue($arwrk);
                    } else {
                        $this->district_id->ViewValue = FormatNumber($this->district_id->CurrentValue, $this->district_id->formatPattern());
                    }
                }
            } else {
                $this->district_id->ViewValue = null;
            }
            $this->district_id->ViewCustomAttributes = "";

            // postcode
            $this->postcode->ViewValue = $this->postcode->CurrentValue;
            $this->postcode->ViewCustomAttributes = "";

            // floor_plan
            $this->floor_plan->UploadPath = './upload/floor_plan';
            if (!EmptyValue($this->floor_plan->Upload->DbValue)) {
                $this->floor_plan->ImageWidth = 100;
                $this->floor_plan->ImageHeight = 100;
                $this->floor_plan->ImageAlt = $this->floor_plan->alt();
                $this->floor_plan->ImageCssClass = "ew-image";
                $this->floor_plan->ViewValue = $this->floor_plan->Upload->DbValue;
            } else {
                $this->floor_plan->ViewValue = "";
            }
            $this->floor_plan->ViewCustomAttributes = "";

            // layout_unit
            $this->layout_unit->UploadPath = './upload/layout_unit';
            if (!EmptyValue($this->layout_unit->Upload->DbValue)) {
                $this->layout_unit->ImageWidth = 100;
                $this->layout_unit->ImageHeight = 100;
                $this->layout_unit->ImageAlt = $this->layout_unit->alt();
                $this->layout_unit->ImageCssClass = "ew-image";
                $this->layout_unit->ViewValue = $this->layout_unit->Upload->DbValue;
            } else {
                $this->layout_unit->ViewValue = "";
            }
            $this->layout_unit->ViewCustomAttributes = "";

            // asset_website
            $this->asset_website->ViewValue = $this->asset_website->CurrentValue;
            $this->asset_website->ViewCustomAttributes = "";

            // asset_review
            $this->asset_review->ViewValue = $this->asset_review->CurrentValue;
            $this->asset_review->ViewCustomAttributes = "";

            // isactive
            if (strval($this->isactive->CurrentValue) != "") {
                $this->isactive->ViewValue = $this->isactive->optionCaption($this->isactive->CurrentValue);
            } else {
                $this->isactive->ViewValue = null;
            }
            $this->isactive->ViewCustomAttributes = "";

            // is_recommend
            if (strval($this->is_recommend->CurrentValue) != "") {
                $this->is_recommend->ViewValue = $this->is_recommend->optionCaption($this->is_recommend->CurrentValue);
            } else {
                $this->is_recommend->ViewValue = null;
            }
            $this->is_recommend->ViewCustomAttributes = "";

            // order_by
            $this->order_by->ViewValue = $this->order_by->CurrentValue;
            $this->order_by->ViewValue = FormatNumber($this->order_by->ViewValue, $this->order_by->formatPattern());
            $this->order_by->ViewCustomAttributes = "";

            // type_pay
            if (strval($this->type_pay->CurrentValue) != "") {
                $this->type_pay->ViewValue = new OptionValues();
                $arwrk = explode(",", strval($this->type_pay->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->type_pay->ViewValue->add($this->type_pay->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->type_pay->ViewValue = null;
            }
            $this->type_pay->ViewCustomAttributes = "";

            // type_pay_2
            if (strval($this->type_pay_2->CurrentValue) != "") {
                $this->type_pay_2->ViewValue = new OptionValues();
                $arwrk = explode(",", strval($this->type_pay_2->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->type_pay_2->ViewValue->add($this->type_pay_2->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->type_pay_2->ViewValue = null;
            }
            $this->type_pay_2->ViewCustomAttributes = "";

            // price_mark
            $this->price_mark->ViewValue = $this->price_mark->CurrentValue;
            $this->price_mark->ViewValue = FormatCurrency($this->price_mark->ViewValue, $this->price_mark->formatPattern());
            $this->price_mark->ViewCustomAttributes = "";

            // holding_property
            if (strval($this->holding_property->CurrentValue) != "") {
                $this->holding_property->ViewValue = new OptionValues();
                $arwrk = explode(",", strval($this->holding_property->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->holding_property->ViewValue->add($this->holding_property->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->holding_property->ViewValue = null;
            }
            $this->holding_property->ViewCustomAttributes = "";

            // common_fee
            $this->common_fee->ViewValue = $this->common_fee->CurrentValue;
            $this->common_fee->ViewValue = FormatCurrency($this->common_fee->ViewValue, $this->common_fee->formatPattern());
            $this->common_fee->ViewCustomAttributes = "";

            // usable_area
            $this->usable_area->ViewValue = $this->usable_area->CurrentValue;
            $this->usable_area->ViewCustomAttributes = "";

            // usable_area_price
            $this->usable_area_price->ViewValue = $this->usable_area_price->CurrentValue;
            $this->usable_area_price->ViewValue = FormatNumber($this->usable_area_price->ViewValue, $this->usable_area_price->formatPattern());
            $this->usable_area_price->ViewCustomAttributes = "";

            // land_size
            $this->land_size->ViewValue = $this->land_size->CurrentValue;
            $this->land_size->ViewCustomAttributes = "";

            // land_size_price
            $this->land_size_price->ViewValue = $this->land_size_price->CurrentValue;
            $this->land_size_price->ViewValue = FormatNumber($this->land_size_price->ViewValue, $this->land_size_price->formatPattern());
            $this->land_size_price->ViewCustomAttributes = "";

            // commission
            $this->commission->ViewValue = $this->commission->CurrentValue;
            $this->commission->ViewValue = FormatPercent($this->commission->ViewValue, $this->commission->formatPattern());
            $this->commission->ViewCustomAttributes = "";

            // transfer_day_expenses_with_business_tax
            $this->transfer_day_expenses_with_business_tax->ViewValue = $this->transfer_day_expenses_with_business_tax->CurrentValue;
            $this->transfer_day_expenses_with_business_tax->ViewValue = FormatPercent($this->transfer_day_expenses_with_business_tax->ViewValue, $this->transfer_day_expenses_with_business_tax->formatPattern());
            $this->transfer_day_expenses_with_business_tax->ViewCustomAttributes = "";

            // transfer_day_expenses_without_business_tax
            $this->transfer_day_expenses_without_business_tax->ViewValue = $this->transfer_day_expenses_without_business_tax->CurrentValue;
            $this->transfer_day_expenses_without_business_tax->ViewValue = FormatPercent($this->transfer_day_expenses_without_business_tax->ViewValue, $this->transfer_day_expenses_without_business_tax->formatPattern());
            $this->transfer_day_expenses_without_business_tax->ViewCustomAttributes = "";

            // price
            $this->price->ViewValue = $this->price->CurrentValue;
            $this->price->ViewValue = FormatCurrency($this->price->ViewValue, $this->price->formatPattern());
            $this->price->ViewCustomAttributes = "";

            // discount
            $this->discount->ViewValue = $this->discount->CurrentValue;
            $this->discount->ViewValue = FormatCurrency($this->discount->ViewValue, $this->discount->formatPattern());
            $this->discount->ViewCustomAttributes = "";

            // price_special
            $this->price_special->ViewValue = $this->price_special->CurrentValue;
            $this->price_special->ViewValue = FormatCurrency($this->price_special->ViewValue, $this->price_special->formatPattern());
            $this->price_special->ViewCustomAttributes = "";

            // reservation_price_model_a
            $this->reservation_price_model_a->ViewValue = $this->reservation_price_model_a->CurrentValue;
            $this->reservation_price_model_a->ViewValue = FormatCurrency($this->reservation_price_model_a->ViewValue, $this->reservation_price_model_a->formatPattern());
            $this->reservation_price_model_a->ViewCustomAttributes = "";

            // minimum_down_payment_model_a
            $this->minimum_down_payment_model_a->ViewValue = $this->minimum_down_payment_model_a->CurrentValue;
            $this->minimum_down_payment_model_a->ViewValue = FormatPercent($this->minimum_down_payment_model_a->ViewValue, $this->minimum_down_payment_model_a->formatPattern());
            $this->minimum_down_payment_model_a->ViewCustomAttributes = "";

            // down_price_min_a
            $this->down_price_min_a->ViewValue = $this->down_price_min_a->CurrentValue;
            $this->down_price_min_a->ViewValue = FormatCurrency($this->down_price_min_a->ViewValue, $this->down_price_min_a->formatPattern());
            $this->down_price_min_a->ViewCustomAttributes = "";

            // down_price_model_a
            $this->down_price_model_a->ViewValue = $this->down_price_model_a->CurrentValue;
            $this->down_price_model_a->ViewValue = FormatCurrency($this->down_price_model_a->ViewValue, $this->down_price_model_a->formatPattern());
            $this->down_price_model_a->ViewCustomAttributes = "";

            // factor_monthly_installment_over_down
            $this->factor_monthly_installment_over_down->ViewValue = $this->factor_monthly_installment_over_down->CurrentValue;
            $this->factor_monthly_installment_over_down->ViewValue = FormatPercent($this->factor_monthly_installment_over_down->ViewValue, $this->factor_monthly_installment_over_down->formatPattern());
            $this->factor_monthly_installment_over_down->ViewCustomAttributes = "";

            // fee_a
            $this->fee_a->ViewValue = $this->fee_a->CurrentValue;
            $this->fee_a->ViewValue = FormatNumber($this->fee_a->ViewValue, $this->fee_a->formatPattern());
            $this->fee_a->ViewCustomAttributes = "";

            // monthly_payment_buyer
            $this->monthly_payment_buyer->ViewValue = $this->monthly_payment_buyer->CurrentValue;
            $this->monthly_payment_buyer->ViewValue = FormatCurrency($this->monthly_payment_buyer->ViewValue, $this->monthly_payment_buyer->formatPattern());
            $this->monthly_payment_buyer->ViewCustomAttributes = "";

            // annual_interest_buyer_model_a
            $this->annual_interest_buyer_model_a->ViewValue = $this->annual_interest_buyer_model_a->CurrentValue;
            $this->annual_interest_buyer_model_a->ViewValue = FormatPercent($this->annual_interest_buyer_model_a->ViewValue, $this->annual_interest_buyer_model_a->formatPattern());
            $this->annual_interest_buyer_model_a->ViewCustomAttributes = "";

            // monthly_expenses_a
            $this->monthly_expenses_a->ViewValue = $this->monthly_expenses_a->CurrentValue;
            $this->monthly_expenses_a->ViewValue = FormatCurrency($this->monthly_expenses_a->ViewValue, $this->monthly_expenses_a->formatPattern());
            $this->monthly_expenses_a->ViewCustomAttributes = "";

            // average_rent_a
            $this->average_rent_a->ViewValue = $this->average_rent_a->CurrentValue;
            $this->average_rent_a->ViewValue = FormatCurrency($this->average_rent_a->ViewValue, $this->average_rent_a->formatPattern());
            $this->average_rent_a->ViewCustomAttributes = "";

            // average_down_payment_a
            $this->average_down_payment_a->ViewValue = $this->average_down_payment_a->CurrentValue;
            $this->average_down_payment_a->ViewValue = FormatCurrency($this->average_down_payment_a->ViewValue, $this->average_down_payment_a->formatPattern());
            $this->average_down_payment_a->ViewCustomAttributes = "";

            // transfer_day_expenses_without_business_tax_max_min
            $this->transfer_day_expenses_without_business_tax_max_min->ViewValue = $this->transfer_day_expenses_without_business_tax_max_min->CurrentValue;
            $this->transfer_day_expenses_without_business_tax_max_min->ViewValue = FormatPercent($this->transfer_day_expenses_without_business_tax_max_min->ViewValue, $this->transfer_day_expenses_without_business_tax_max_min->formatPattern());
            $this->transfer_day_expenses_without_business_tax_max_min->ViewCustomAttributes = "";

            // transfer_day_expenses_with_business_tax_max_min
            $this->transfer_day_expenses_with_business_tax_max_min->ViewValue = $this->transfer_day_expenses_with_business_tax_max_min->CurrentValue;
            $this->transfer_day_expenses_with_business_tax_max_min->ViewValue = FormatPercent($this->transfer_day_expenses_with_business_tax_max_min->ViewValue, $this->transfer_day_expenses_with_business_tax_max_min->formatPattern());
            $this->transfer_day_expenses_with_business_tax_max_min->ViewCustomAttributes = "";

            // bank_appraisal_price
            $this->bank_appraisal_price->ViewValue = $this->bank_appraisal_price->CurrentValue;
            $this->bank_appraisal_price->ViewValue = FormatCurrency($this->bank_appraisal_price->ViewValue, $this->bank_appraisal_price->formatPattern());
            $this->bank_appraisal_price->ViewCustomAttributes = "";

            // mark_up_price
            $this->mark_up_price->ViewValue = $this->mark_up_price->CurrentValue;
            $this->mark_up_price->ViewValue = FormatPercent($this->mark_up_price->ViewValue, $this->mark_up_price->formatPattern());
            $this->mark_up_price->ViewCustomAttributes = "";

            // required_gap
            $this->required_gap->ViewValue = $this->required_gap->CurrentValue;
            $this->required_gap->ViewValue = FormatPercent($this->required_gap->ViewValue, $this->required_gap->formatPattern());
            $this->required_gap->ViewCustomAttributes = "";

            // minimum_down_payment
            $this->minimum_down_payment->ViewValue = $this->minimum_down_payment->CurrentValue;
            $this->minimum_down_payment->ViewValue = FormatCurrency($this->minimum_down_payment->ViewValue, $this->minimum_down_payment->formatPattern());
            $this->minimum_down_payment->ViewCustomAttributes = "";

            // price_down_max
            $this->price_down_max->ViewValue = $this->price_down_max->CurrentValue;
            $this->price_down_max->ViewValue = FormatCurrency($this->price_down_max->ViewValue, $this->price_down_max->formatPattern());
            $this->price_down_max->ViewCustomAttributes = "";

            // discount_max
            $this->discount_max->ViewValue = $this->discount_max->CurrentValue;
            $this->discount_max->ViewValue = FormatCurrency($this->discount_max->ViewValue, $this->discount_max->formatPattern());
            $this->discount_max->ViewCustomAttributes = "";

            // price_down_special_max
            $this->price_down_special_max->ViewValue = $this->price_down_special_max->CurrentValue;
            $this->price_down_special_max->ViewValue = FormatNumber($this->price_down_special_max->ViewValue, $this->price_down_special_max->formatPattern());
            $this->price_down_special_max->ViewCustomAttributes = "";

            // usable_area_price_max
            $this->usable_area_price_max->ViewValue = $this->usable_area_price_max->CurrentValue;
            $this->usable_area_price_max->ViewValue = FormatCurrency($this->usable_area_price_max->ViewValue, $this->usable_area_price_max->formatPattern());
            $this->usable_area_price_max->ViewCustomAttributes = "";

            // land_size_price_max
            $this->land_size_price_max->ViewValue = $this->land_size_price_max->CurrentValue;
            $this->land_size_price_max->ViewValue = FormatCurrency($this->land_size_price_max->ViewValue, $this->land_size_price_max->formatPattern());
            $this->land_size_price_max->ViewCustomAttributes = "";

            // reservation_price_max
            $this->reservation_price_max->ViewValue = $this->reservation_price_max->CurrentValue;
            $this->reservation_price_max->ViewValue = FormatCurrency($this->reservation_price_max->ViewValue, $this->reservation_price_max->formatPattern());
            $this->reservation_price_max->ViewCustomAttributes = "";

            // minimum_down_payment_max
            $this->minimum_down_payment_max->ViewValue = $this->minimum_down_payment_max->CurrentValue;
            $this->minimum_down_payment_max->ViewValue = FormatPercent($this->minimum_down_payment_max->ViewValue, $this->minimum_down_payment_max->formatPattern());
            $this->minimum_down_payment_max->ViewCustomAttributes = "";

            // down_price_max
            $this->down_price_max->ViewValue = $this->down_price_max->CurrentValue;
            $this->down_price_max->ViewValue = FormatCurrency($this->down_price_max->ViewValue, $this->down_price_max->formatPattern());
            $this->down_price_max->ViewCustomAttributes = "";

            // down_price
            $this->down_price->ViewValue = $this->down_price->CurrentValue;
            $this->down_price->ViewValue = FormatCurrency($this->down_price->ViewValue, $this->down_price->formatPattern());
            $this->down_price->ViewCustomAttributes = "";

            // factor_monthly_installment_over_down_max
            $this->factor_monthly_installment_over_down_max->ViewValue = $this->factor_monthly_installment_over_down_max->CurrentValue;
            $this->factor_monthly_installment_over_down_max->ViewValue = FormatNumber($this->factor_monthly_installment_over_down_max->ViewValue, $this->factor_monthly_installment_over_down_max->formatPattern());
            $this->factor_monthly_installment_over_down_max->ViewCustomAttributes = "";

            // fee_max
            $this->fee_max->ViewValue = $this->fee_max->CurrentValue;
            $this->fee_max->ViewValue = FormatNumber($this->fee_max->ViewValue, $this->fee_max->formatPattern());
            $this->fee_max->ViewCustomAttributes = "";

            // monthly_payment_max
            $this->monthly_payment_max->ViewValue = $this->monthly_payment_max->CurrentValue;
            $this->monthly_payment_max->ViewValue = FormatCurrency($this->monthly_payment_max->ViewValue, $this->monthly_payment_max->formatPattern());
            $this->monthly_payment_max->ViewCustomAttributes = "";

            // annual_interest_buyer
            $this->annual_interest_buyer->ViewValue = $this->annual_interest_buyer->CurrentValue;
            $this->annual_interest_buyer->ViewValue = FormatPercent($this->annual_interest_buyer->ViewValue, $this->annual_interest_buyer->formatPattern());
            $this->annual_interest_buyer->ViewCustomAttributes = "";

            // monthly_expense_max
            $this->monthly_expense_max->ViewValue = $this->monthly_expense_max->CurrentValue;
            $this->monthly_expense_max->ViewValue = FormatCurrency($this->monthly_expense_max->ViewValue, $this->monthly_expense_max->formatPattern());
            $this->monthly_expense_max->ViewCustomAttributes = "";

            // average_rent_max
            $this->average_rent_max->ViewValue = $this->average_rent_max->CurrentValue;
            $this->average_rent_max->ViewValue = FormatCurrency($this->average_rent_max->ViewValue, $this->average_rent_max->formatPattern());
            $this->average_rent_max->ViewCustomAttributes = "";

            // average_down_payment_max
            $this->average_down_payment_max->ViewValue = $this->average_down_payment_max->CurrentValue;
            $this->average_down_payment_max->ViewValue = FormatCurrency($this->average_down_payment_max->ViewValue, $this->average_down_payment_max->formatPattern());
            $this->average_down_payment_max->ViewCustomAttributes = "";

            // min_down
            $this->min_down->ViewValue = $this->min_down->CurrentValue;
            $this->min_down->ViewValue = FormatPercent($this->min_down->ViewValue, $this->min_down->formatPattern());
            $this->min_down->ViewCustomAttributes = "";

            // remaining_down
            $this->remaining_down->ViewValue = $this->remaining_down->CurrentValue;
            $this->remaining_down->ViewValue = FormatPercent($this->remaining_down->ViewValue, $this->remaining_down->formatPattern());
            $this->remaining_down->ViewCustomAttributes = "";

            // factor_financing
            $this->factor_financing->ViewValue = $this->factor_financing->CurrentValue;
            $this->factor_financing->ViewValue = FormatPercent($this->factor_financing->ViewValue, $this->factor_financing->formatPattern());
            $this->factor_financing->ViewCustomAttributes = "";

            // credit_limit_down
            $this->credit_limit_down->ViewValue = $this->credit_limit_down->CurrentValue;
            $this->credit_limit_down->ViewValue = FormatCurrency($this->credit_limit_down->ViewValue, $this->credit_limit_down->formatPattern());
            $this->credit_limit_down->ViewCustomAttributes = "";

            // price_down_min
            $this->price_down_min->ViewValue = $this->price_down_min->CurrentValue;
            $this->price_down_min->ViewValue = FormatCurrency($this->price_down_min->ViewValue, $this->price_down_min->formatPattern());
            $this->price_down_min->ViewCustomAttributes = "";

            // discount_min
            $this->discount_min->ViewValue = $this->discount_min->CurrentValue;
            $this->discount_min->ViewValue = FormatCurrency($this->discount_min->ViewValue, $this->discount_min->formatPattern());
            $this->discount_min->ViewCustomAttributes = "";

            // price_down_special_min
            $this->price_down_special_min->ViewValue = $this->price_down_special_min->CurrentValue;
            $this->price_down_special_min->ViewValue = FormatCurrency($this->price_down_special_min->ViewValue, $this->price_down_special_min->formatPattern());
            $this->price_down_special_min->ViewCustomAttributes = "";

            // usable_area_price_min
            $this->usable_area_price_min->ViewValue = $this->usable_area_price_min->CurrentValue;
            $this->usable_area_price_min->ViewValue = FormatNumber($this->usable_area_price_min->ViewValue, $this->usable_area_price_min->formatPattern());
            $this->usable_area_price_min->ViewCustomAttributes = "";

            // land_size_price_min
            $this->land_size_price_min->ViewValue = $this->land_size_price_min->CurrentValue;
            $this->land_size_price_min->ViewValue = FormatPercent($this->land_size_price_min->ViewValue, $this->land_size_price_min->formatPattern());
            $this->land_size_price_min->ViewCustomAttributes = "";

            // reservation_price_min
            $this->reservation_price_min->ViewValue = $this->reservation_price_min->CurrentValue;
            $this->reservation_price_min->ViewValue = FormatCurrency($this->reservation_price_min->ViewValue, $this->reservation_price_min->formatPattern());
            $this->reservation_price_min->ViewCustomAttributes = "";

            // minimum_down_payment_min
            $this->minimum_down_payment_min->ViewValue = $this->minimum_down_payment_min->CurrentValue;
            $this->minimum_down_payment_min->ViewValue = FormatPercent($this->minimum_down_payment_min->ViewValue, $this->minimum_down_payment_min->formatPattern());
            $this->minimum_down_payment_min->ViewCustomAttributes = "";

            // down_price_min
            $this->down_price_min->ViewValue = $this->down_price_min->CurrentValue;
            $this->down_price_min->ViewValue = FormatCurrency($this->down_price_min->ViewValue, $this->down_price_min->formatPattern());
            $this->down_price_min->ViewCustomAttributes = "";

            // remaining_credit_limit_down
            $this->remaining_credit_limit_down->ViewValue = $this->remaining_credit_limit_down->CurrentValue;
            $this->remaining_credit_limit_down->ViewValue = FormatCurrency($this->remaining_credit_limit_down->ViewValue, $this->remaining_credit_limit_down->formatPattern());
            $this->remaining_credit_limit_down->ViewCustomAttributes = "";

            // fee_min
            $this->fee_min->ViewValue = $this->fee_min->CurrentValue;
            $this->fee_min->ViewValue = FormatNumber($this->fee_min->ViewValue, $this->fee_min->formatPattern());
            $this->fee_min->ViewCustomAttributes = "";

            // monthly_payment_min
            $this->monthly_payment_min->ViewValue = $this->monthly_payment_min->CurrentValue;
            $this->monthly_payment_min->ViewValue = FormatCurrency($this->monthly_payment_min->ViewValue, $this->monthly_payment_min->formatPattern());
            $this->monthly_payment_min->ViewCustomAttributes = "";

            // annual_interest_buyer_model_min
            $this->annual_interest_buyer_model_min->ViewValue = $this->annual_interest_buyer_model_min->CurrentValue;
            $this->annual_interest_buyer_model_min->ViewValue = FormatPercent($this->annual_interest_buyer_model_min->ViewValue, $this->annual_interest_buyer_model_min->formatPattern());
            $this->annual_interest_buyer_model_min->ViewCustomAttributes = "";

            // interest_down-payment_financing
            $this->interest_downpayment_financing->ViewValue = $this->interest_downpayment_financing->CurrentValue;
            $this->interest_downpayment_financing->ViewValue = FormatPercent($this->interest_downpayment_financing->ViewValue, $this->interest_downpayment_financing->formatPattern());
            $this->interest_downpayment_financing->ViewCustomAttributes = "";

            // monthly_expenses_min
            $this->monthly_expenses_min->ViewValue = $this->monthly_expenses_min->CurrentValue;
            $this->monthly_expenses_min->ViewValue = FormatNumber($this->monthly_expenses_min->ViewValue, $this->monthly_expenses_min->formatPattern());
            $this->monthly_expenses_min->ViewCustomAttributes = "";

            // average_rent_min
            $this->average_rent_min->ViewValue = $this->average_rent_min->CurrentValue;
            $this->average_rent_min->ViewValue = FormatNumber($this->average_rent_min->ViewValue, $this->average_rent_min->formatPattern());
            $this->average_rent_min->ViewCustomAttributes = "";

            // average_down_payment_min
            $this->average_down_payment_min->ViewValue = $this->average_down_payment_min->CurrentValue;
            $this->average_down_payment_min->ViewValue = FormatNumber($this->average_down_payment_min->ViewValue, $this->average_down_payment_min->formatPattern());
            $this->average_down_payment_min->ViewCustomAttributes = "";

            // installment_down_payment_loan
            $this->installment_down_payment_loan->ViewValue = $this->installment_down_payment_loan->CurrentValue;
            $this->installment_down_payment_loan->ViewValue = FormatNumber($this->installment_down_payment_loan->ViewValue, $this->installment_down_payment_loan->formatPattern());
            $this->installment_down_payment_loan->ViewCustomAttributes = "";

            // count_view
            $this->count_view->ViewValue = $this->count_view->CurrentValue;
            $this->count_view->ViewValue = FormatNumber($this->count_view->ViewValue, $this->count_view->formatPattern());
            $this->count_view->ViewCustomAttributes = "";

            // count_favorite
            $this->count_favorite->ViewValue = $this->count_favorite->CurrentValue;
            $this->count_favorite->ViewValue = FormatNumber($this->count_favorite->ViewValue, $this->count_favorite->formatPattern());
            $this->count_favorite->ViewCustomAttributes = "";

            // price_invertor
            $this->price_invertor->ViewValue = $this->price_invertor->CurrentValue;
            $this->price_invertor->ViewValue = FormatCurrency($this->price_invertor->ViewValue, $this->price_invertor->formatPattern());
            $this->price_invertor->ViewCustomAttributes = "";

            // expired_date
            $this->expired_date->ViewValue = $this->expired_date->CurrentValue;
            $this->expired_date->ViewValue = FormatDateTime($this->expired_date->ViewValue, $this->expired_date->formatPattern());
            $this->expired_date->ViewCustomAttributes = "";

            // cdate
            $this->cdate->ViewValue = $this->cdate->CurrentValue;
            $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
            $this->cdate->ViewCustomAttributes = "";

            // title
            $this->_title->LinkCustomAttributes = "";
            $this->_title->HrefValue = "";
            $this->_title->TooltipValue = "";

            // title_en
            $this->title_en->LinkCustomAttributes = "";
            $this->title_en->HrefValue = "";
            $this->title_en->TooltipValue = "";

            // brand_id
            $this->brand_id->LinkCustomAttributes = "";
            $this->brand_id->HrefValue = "";
            $this->brand_id->TooltipValue = "";

            // detail
            $this->detail->LinkCustomAttributes = "";
            $this->detail->HrefValue = "";
            $this->detail->TooltipValue = "";

            // detail_en
            $this->detail_en->LinkCustomAttributes = "";
            $this->detail_en->HrefValue = "";
            $this->detail_en->TooltipValue = "";

            // asset_code
            $this->asset_code->LinkCustomAttributes = "";
            $this->asset_code->HrefValue = "";
            $this->asset_code->TooltipValue = "";

            // asset_status
            $this->asset_status->LinkCustomAttributes = "";
            $this->asset_status->HrefValue = "";
            $this->asset_status->TooltipValue = "";

            // latitude
            $this->latitude->LinkCustomAttributes = "";
            $this->latitude->HrefValue = "";
            $this->latitude->TooltipValue = "";

            // longitude
            $this->longitude->LinkCustomAttributes = "";
            $this->longitude->HrefValue = "";
            $this->longitude->TooltipValue = "";

            // num_buildings
            $this->num_buildings->LinkCustomAttributes = "";
            $this->num_buildings->HrefValue = "";
            $this->num_buildings->TooltipValue = "";

            // num_unit
            $this->num_unit->LinkCustomAttributes = "";
            $this->num_unit->HrefValue = "";
            $this->num_unit->TooltipValue = "";

            // num_floors
            $this->num_floors->LinkCustomAttributes = "";
            $this->num_floors->HrefValue = "";
            $this->num_floors->TooltipValue = "";

            // floors
            $this->floors->LinkCustomAttributes = "";
            $this->floors->HrefValue = "";
            $this->floors->TooltipValue = "";

            // asset_year_developer
            $this->asset_year_developer->LinkCustomAttributes = "";
            $this->asset_year_developer->HrefValue = "";
            $this->asset_year_developer->TooltipValue = "";

            // num_parking_spaces
            $this->num_parking_spaces->LinkCustomAttributes = "";
            $this->num_parking_spaces->HrefValue = "";
            $this->num_parking_spaces->TooltipValue = "";

            // num_bathrooms
            $this->num_bathrooms->LinkCustomAttributes = "";
            $this->num_bathrooms->HrefValue = "";
            $this->num_bathrooms->TooltipValue = "";

            // num_bedrooms
            $this->num_bedrooms->LinkCustomAttributes = "";
            $this->num_bedrooms->HrefValue = "";
            $this->num_bedrooms->TooltipValue = "";

            // address
            $this->address->LinkCustomAttributes = "";
            $this->address->HrefValue = "";
            $this->address->TooltipValue = "";

            // address_en
            $this->address_en->LinkCustomAttributes = "";
            $this->address_en->HrefValue = "";
            $this->address_en->TooltipValue = "";

            // province_id
            $this->province_id->LinkCustomAttributes = "";
            $this->province_id->HrefValue = "";
            $this->province_id->TooltipValue = "";

            // amphur_id
            $this->amphur_id->LinkCustomAttributes = "";
            $this->amphur_id->HrefValue = "";
            $this->amphur_id->TooltipValue = "";

            // district_id
            $this->district_id->LinkCustomAttributes = "";
            $this->district_id->HrefValue = "";
            $this->district_id->TooltipValue = "";

            // postcode
            $this->postcode->LinkCustomAttributes = "";
            $this->postcode->HrefValue = "";
            $this->postcode->TooltipValue = "";

            // floor_plan
            $this->floor_plan->LinkCustomAttributes = "";
            $this->floor_plan->UploadPath = './upload/floor_plan';
            if (!EmptyValue($this->floor_plan->Upload->DbValue)) {
                $this->floor_plan->HrefValue = GetFileUploadUrl($this->floor_plan, $this->floor_plan->htmlDecode($this->floor_plan->Upload->DbValue)); // Add prefix/suffix
                $this->floor_plan->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->floor_plan->HrefValue = FullUrl($this->floor_plan->HrefValue, "href");
                }
            } else {
                $this->floor_plan->HrefValue = "";
            }
            $this->floor_plan->ExportHrefValue = $this->floor_plan->UploadPath . $this->floor_plan->Upload->DbValue;
            $this->floor_plan->TooltipValue = "";
            if ($this->floor_plan->UseColorbox) {
                if (EmptyValue($this->floor_plan->TooltipValue)) {
                    $this->floor_plan->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->floor_plan->LinkAttrs["data-rel"] = "asset_x_floor_plan";
                $this->floor_plan->LinkAttrs->appendClass("ew-lightbox");
            }

            // layout_unit
            $this->layout_unit->LinkCustomAttributes = "";
            $this->layout_unit->UploadPath = './upload/layout_unit';
            if (!EmptyValue($this->layout_unit->Upload->DbValue)) {
                $this->layout_unit->HrefValue = GetFileUploadUrl($this->layout_unit, $this->layout_unit->htmlDecode($this->layout_unit->Upload->DbValue)); // Add prefix/suffix
                $this->layout_unit->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->layout_unit->HrefValue = FullUrl($this->layout_unit->HrefValue, "href");
                }
            } else {
                $this->layout_unit->HrefValue = "";
            }
            $this->layout_unit->ExportHrefValue = $this->layout_unit->UploadPath . $this->layout_unit->Upload->DbValue;
            $this->layout_unit->TooltipValue = "";
            if ($this->layout_unit->UseColorbox) {
                if (EmptyValue($this->layout_unit->TooltipValue)) {
                    $this->layout_unit->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->layout_unit->LinkAttrs["data-rel"] = "asset_x_layout_unit";
                $this->layout_unit->LinkAttrs->appendClass("ew-lightbox");
            }

            // asset_website
            $this->asset_website->LinkCustomAttributes = "";
            $this->asset_website->HrefValue = "";
            $this->asset_website->TooltipValue = "";

            // asset_review
            $this->asset_review->LinkCustomAttributes = "";
            $this->asset_review->HrefValue = "";
            $this->asset_review->TooltipValue = "";

            // isactive
            $this->isactive->LinkCustomAttributes = "";
            $this->isactive->HrefValue = "";
            $this->isactive->TooltipValue = "";

            // is_recommend
            $this->is_recommend->LinkCustomAttributes = "";
            $this->is_recommend->HrefValue = "";
            $this->is_recommend->TooltipValue = "";

            // order_by
            $this->order_by->LinkCustomAttributes = "";
            $this->order_by->HrefValue = "";
            $this->order_by->TooltipValue = "";

            // type_pay
            $this->type_pay->LinkCustomAttributes = "";
            $this->type_pay->HrefValue = "";
            $this->type_pay->TooltipValue = "";

            // type_pay_2
            $this->type_pay_2->LinkCustomAttributes = "";
            $this->type_pay_2->HrefValue = "";
            $this->type_pay_2->TooltipValue = "";

            // price_mark
            $this->price_mark->LinkCustomAttributes = "";
            $this->price_mark->HrefValue = "";
            $this->price_mark->TooltipValue = "";

            // holding_property
            $this->holding_property->LinkCustomAttributes = "";
            $this->holding_property->HrefValue = "";
            $this->holding_property->TooltipValue = "";

            // common_fee
            $this->common_fee->LinkCustomAttributes = "";
            $this->common_fee->HrefValue = "";
            $this->common_fee->TooltipValue = "";

            // usable_area
            $this->usable_area->LinkCustomAttributes = "";
            $this->usable_area->HrefValue = "";
            $this->usable_area->TooltipValue = "";

            // usable_area_price
            $this->usable_area_price->LinkCustomAttributes = "";
            $this->usable_area_price->HrefValue = "";
            $this->usable_area_price->TooltipValue = "";

            // land_size
            $this->land_size->LinkCustomAttributes = "";
            $this->land_size->HrefValue = "";
            $this->land_size->TooltipValue = "";

            // land_size_price
            $this->land_size_price->LinkCustomAttributes = "";
            $this->land_size_price->HrefValue = "";
            $this->land_size_price->TooltipValue = "";

            // commission
            $this->commission->LinkCustomAttributes = "";
            $this->commission->HrefValue = "";
            $this->commission->TooltipValue = "";

            // transfer_day_expenses_with_business_tax
            $this->transfer_day_expenses_with_business_tax->LinkCustomAttributes = "";
            $this->transfer_day_expenses_with_business_tax->HrefValue = "";
            $this->transfer_day_expenses_with_business_tax->TooltipValue = "";

            // transfer_day_expenses_without_business_tax
            $this->transfer_day_expenses_without_business_tax->LinkCustomAttributes = "";
            $this->transfer_day_expenses_without_business_tax->HrefValue = "";
            $this->transfer_day_expenses_without_business_tax->TooltipValue = "";

            // price
            $this->price->LinkCustomAttributes = "";
            $this->price->HrefValue = "";
            $this->price->TooltipValue = "";

            // discount
            $this->discount->LinkCustomAttributes = "";
            $this->discount->HrefValue = "";
            $this->discount->TooltipValue = "";

            // price_special
            $this->price_special->LinkCustomAttributes = "";
            $this->price_special->HrefValue = "";
            $this->price_special->TooltipValue = "";

            // reservation_price_model_a
            $this->reservation_price_model_a->LinkCustomAttributes = "";
            $this->reservation_price_model_a->HrefValue = "";
            $this->reservation_price_model_a->TooltipValue = "";

            // minimum_down_payment_model_a
            $this->minimum_down_payment_model_a->LinkCustomAttributes = "";
            $this->minimum_down_payment_model_a->HrefValue = "";
            $this->minimum_down_payment_model_a->TooltipValue = "";

            // down_price_min_a
            $this->down_price_min_a->LinkCustomAttributes = "";
            $this->down_price_min_a->HrefValue = "";
            $this->down_price_min_a->TooltipValue = "";

            // down_price_model_a
            $this->down_price_model_a->LinkCustomAttributes = "";
            $this->down_price_model_a->HrefValue = "";
            $this->down_price_model_a->TooltipValue = "";

            // factor_monthly_installment_over_down
            $this->factor_monthly_installment_over_down->LinkCustomAttributes = "";
            $this->factor_monthly_installment_over_down->HrefValue = "";
            $this->factor_monthly_installment_over_down->TooltipValue = "";

            // fee_a
            $this->fee_a->LinkCustomAttributes = "";
            $this->fee_a->HrefValue = "";
            $this->fee_a->TooltipValue = "";

            // monthly_payment_buyer
            $this->monthly_payment_buyer->LinkCustomAttributes = "";
            $this->monthly_payment_buyer->HrefValue = "";
            $this->monthly_payment_buyer->TooltipValue = "";

            // annual_interest_buyer_model_a
            $this->annual_interest_buyer_model_a->LinkCustomAttributes = "";
            $this->annual_interest_buyer_model_a->HrefValue = "";
            $this->annual_interest_buyer_model_a->TooltipValue = "";

            // monthly_expenses_a
            $this->monthly_expenses_a->LinkCustomAttributes = "";
            $this->monthly_expenses_a->HrefValue = "";
            $this->monthly_expenses_a->TooltipValue = "";

            // average_rent_a
            $this->average_rent_a->LinkCustomAttributes = "";
            $this->average_rent_a->HrefValue = "";
            $this->average_rent_a->TooltipValue = "";

            // average_down_payment_a
            $this->average_down_payment_a->LinkCustomAttributes = "";
            $this->average_down_payment_a->HrefValue = "";
            $this->average_down_payment_a->TooltipValue = "";

            // transfer_day_expenses_without_business_tax_max_min
            $this->transfer_day_expenses_without_business_tax_max_min->LinkCustomAttributes = "";
            $this->transfer_day_expenses_without_business_tax_max_min->HrefValue = "";
            $this->transfer_day_expenses_without_business_tax_max_min->TooltipValue = "";

            // transfer_day_expenses_with_business_tax_max_min
            $this->transfer_day_expenses_with_business_tax_max_min->LinkCustomAttributes = "";
            $this->transfer_day_expenses_with_business_tax_max_min->HrefValue = "";
            $this->transfer_day_expenses_with_business_tax_max_min->TooltipValue = "";

            // bank_appraisal_price
            $this->bank_appraisal_price->LinkCustomAttributes = "";
            $this->bank_appraisal_price->HrefValue = "";
            $this->bank_appraisal_price->TooltipValue = "";

            // mark_up_price
            $this->mark_up_price->LinkCustomAttributes = "";
            $this->mark_up_price->HrefValue = "";
            $this->mark_up_price->TooltipValue = "";

            // required_gap
            $this->required_gap->LinkCustomAttributes = "";
            $this->required_gap->HrefValue = "";
            $this->required_gap->TooltipValue = "";

            // minimum_down_payment
            $this->minimum_down_payment->LinkCustomAttributes = "";
            $this->minimum_down_payment->HrefValue = "";
            $this->minimum_down_payment->TooltipValue = "";

            // price_down_max
            $this->price_down_max->LinkCustomAttributes = "";
            $this->price_down_max->HrefValue = "";
            $this->price_down_max->TooltipValue = "";

            // discount_max
            $this->discount_max->LinkCustomAttributes = "";
            $this->discount_max->HrefValue = "";
            $this->discount_max->TooltipValue = "";

            // price_down_special_max
            $this->price_down_special_max->LinkCustomAttributes = "";
            $this->price_down_special_max->HrefValue = "";
            $this->price_down_special_max->TooltipValue = "";

            // usable_area_price_max
            $this->usable_area_price_max->LinkCustomAttributes = "";
            $this->usable_area_price_max->HrefValue = "";
            $this->usable_area_price_max->TooltipValue = "";

            // land_size_price_max
            $this->land_size_price_max->LinkCustomAttributes = "";
            $this->land_size_price_max->HrefValue = "";
            $this->land_size_price_max->TooltipValue = "";

            // reservation_price_max
            $this->reservation_price_max->LinkCustomAttributes = "";
            $this->reservation_price_max->HrefValue = "";
            $this->reservation_price_max->TooltipValue = "";

            // minimum_down_payment_max
            $this->minimum_down_payment_max->LinkCustomAttributes = "";
            $this->minimum_down_payment_max->HrefValue = "";
            $this->minimum_down_payment_max->TooltipValue = "";

            // down_price_max
            $this->down_price_max->LinkCustomAttributes = "";
            $this->down_price_max->HrefValue = "";
            $this->down_price_max->TooltipValue = "";

            // down_price
            $this->down_price->LinkCustomAttributes = "";
            $this->down_price->HrefValue = "";
            $this->down_price->TooltipValue = "";

            // factor_monthly_installment_over_down_max
            $this->factor_monthly_installment_over_down_max->LinkCustomAttributes = "";
            $this->factor_monthly_installment_over_down_max->HrefValue = "";
            $this->factor_monthly_installment_over_down_max->TooltipValue = "";

            // fee_max
            $this->fee_max->LinkCustomAttributes = "";
            $this->fee_max->HrefValue = "";
            $this->fee_max->TooltipValue = "";

            // monthly_payment_max
            $this->monthly_payment_max->LinkCustomAttributes = "";
            $this->monthly_payment_max->HrefValue = "";
            $this->monthly_payment_max->TooltipValue = "";

            // annual_interest_buyer
            $this->annual_interest_buyer->LinkCustomAttributes = "";
            $this->annual_interest_buyer->HrefValue = "";
            $this->annual_interest_buyer->TooltipValue = "";

            // monthly_expense_max
            $this->monthly_expense_max->LinkCustomAttributes = "";
            $this->monthly_expense_max->HrefValue = "";
            $this->monthly_expense_max->TooltipValue = "";

            // average_rent_max
            $this->average_rent_max->LinkCustomAttributes = "";
            $this->average_rent_max->HrefValue = "";
            $this->average_rent_max->TooltipValue = "";

            // average_down_payment_max
            $this->average_down_payment_max->LinkCustomAttributes = "";
            $this->average_down_payment_max->HrefValue = "";
            $this->average_down_payment_max->TooltipValue = "";

            // min_down
            $this->min_down->LinkCustomAttributes = "";
            $this->min_down->HrefValue = "";
            $this->min_down->TooltipValue = "";

            // remaining_down
            $this->remaining_down->LinkCustomAttributes = "";
            $this->remaining_down->HrefValue = "";
            $this->remaining_down->TooltipValue = "";

            // factor_financing
            $this->factor_financing->LinkCustomAttributes = "";
            $this->factor_financing->HrefValue = "";
            $this->factor_financing->TooltipValue = "";

            // credit_limit_down
            $this->credit_limit_down->LinkCustomAttributes = "";
            $this->credit_limit_down->HrefValue = "";
            $this->credit_limit_down->TooltipValue = "";

            // price_down_min
            $this->price_down_min->LinkCustomAttributes = "";
            $this->price_down_min->HrefValue = "";
            $this->price_down_min->TooltipValue = "";

            // discount_min
            $this->discount_min->LinkCustomAttributes = "";
            $this->discount_min->HrefValue = "";
            $this->discount_min->TooltipValue = "";

            // price_down_special_min
            $this->price_down_special_min->LinkCustomAttributes = "";
            $this->price_down_special_min->HrefValue = "";
            $this->price_down_special_min->TooltipValue = "";

            // usable_area_price_min
            $this->usable_area_price_min->LinkCustomAttributes = "";
            $this->usable_area_price_min->HrefValue = "";
            $this->usable_area_price_min->TooltipValue = "";

            // land_size_price_min
            $this->land_size_price_min->LinkCustomAttributes = "";
            $this->land_size_price_min->HrefValue = "";
            $this->land_size_price_min->TooltipValue = "";

            // reservation_price_min
            $this->reservation_price_min->LinkCustomAttributes = "";
            $this->reservation_price_min->HrefValue = "";
            $this->reservation_price_min->TooltipValue = "";

            // minimum_down_payment_min
            $this->minimum_down_payment_min->LinkCustomAttributes = "";
            $this->minimum_down_payment_min->HrefValue = "";
            $this->minimum_down_payment_min->TooltipValue = "";

            // down_price_min
            $this->down_price_min->LinkCustomAttributes = "";
            $this->down_price_min->HrefValue = "";
            $this->down_price_min->TooltipValue = "";

            // remaining_credit_limit_down
            $this->remaining_credit_limit_down->LinkCustomAttributes = "";
            $this->remaining_credit_limit_down->HrefValue = "";
            $this->remaining_credit_limit_down->TooltipValue = "";

            // fee_min
            $this->fee_min->LinkCustomAttributes = "";
            $this->fee_min->HrefValue = "";
            $this->fee_min->TooltipValue = "";

            // monthly_payment_min
            $this->monthly_payment_min->LinkCustomAttributes = "";
            $this->monthly_payment_min->HrefValue = "";
            $this->monthly_payment_min->TooltipValue = "";

            // annual_interest_buyer_model_min
            $this->annual_interest_buyer_model_min->LinkCustomAttributes = "";
            $this->annual_interest_buyer_model_min->HrefValue = "";
            $this->annual_interest_buyer_model_min->TooltipValue = "";

            // interest_down-payment_financing
            $this->interest_downpayment_financing->LinkCustomAttributes = "";
            $this->interest_downpayment_financing->HrefValue = "";
            $this->interest_downpayment_financing->TooltipValue = "";

            // monthly_expenses_min
            $this->monthly_expenses_min->LinkCustomAttributes = "";
            $this->monthly_expenses_min->HrefValue = "";
            $this->monthly_expenses_min->TooltipValue = "";

            // average_rent_min
            $this->average_rent_min->LinkCustomAttributes = "";
            $this->average_rent_min->HrefValue = "";
            $this->average_rent_min->TooltipValue = "";

            // average_down_payment_min
            $this->average_down_payment_min->LinkCustomAttributes = "";
            $this->average_down_payment_min->HrefValue = "";
            $this->average_down_payment_min->TooltipValue = "";

            // installment_down_payment_loan
            $this->installment_down_payment_loan->LinkCustomAttributes = "";
            $this->installment_down_payment_loan->HrefValue = "";
            $this->installment_down_payment_loan->TooltipValue = "";

            // count_view
            $this->count_view->LinkCustomAttributes = "";
            $this->count_view->HrefValue = "";
            $this->count_view->TooltipValue = "";

            // count_favorite
            $this->count_favorite->LinkCustomAttributes = "";
            $this->count_favorite->HrefValue = "";
            $this->count_favorite->TooltipValue = "";

            // price_invertor
            $this->price_invertor->LinkCustomAttributes = "";
            $this->price_invertor->HrefValue = "";
            $this->price_invertor->TooltipValue = "";

            // expired_date
            $this->expired_date->LinkCustomAttributes = "";
            $this->expired_date->HrefValue = "";
            $this->expired_date->TooltipValue = "";

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
            if ($masterTblVar == "sale_asset") {
                $validMaster = true;
                $masterTbl = Container("sale_asset");
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
            if ($masterTblVar == "sale_asset") {
                $validMaster = true;
                $masterTbl = Container("sale_asset");
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
            if ($masterTblVar != "sale_asset") {
                if ($this->asset_id->CurrentValue == "") {
                    $this->asset_id->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("asset_facilities", $detailTblVar)) {
                $detailPageObj = Container("AssetFacilitiesGrid");
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->asset_id->IsDetailKey = true;
                    $detailPageObj->asset_id->CurrentValue = $this->asset_id->CurrentValue;
                    $detailPageObj->asset_id->setSessionValue($detailPageObj->asset_id->CurrentValue);
                }
            }
            if (in_array("asset_pros_detail", $detailTblVar)) {
                $detailPageObj = Container("AssetProsDetailGrid");
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->asset_id->IsDetailKey = true;
                    $detailPageObj->asset_id->CurrentValue = $this->asset_id->CurrentValue;
                    $detailPageObj->asset_id->setSessionValue($detailPageObj->asset_id->CurrentValue);
                }
            }
            if (in_array("asset_banner", $detailTblVar)) {
                $detailPageObj = Container("AssetBannerGrid");
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->asset_id->IsDetailKey = true;
                    $detailPageObj->asset_id->CurrentValue = $this->asset_id->CurrentValue;
                    $detailPageObj->asset_id->setSessionValue($detailPageObj->asset_id->CurrentValue);
                }
            }
            if (in_array("asset_category", $detailTblVar)) {
                $detailPageObj = Container("AssetCategoryGrid");
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->asset_id->IsDetailKey = true;
                    $detailPageObj->asset_id->CurrentValue = $this->asset_id->CurrentValue;
                    $detailPageObj->asset_id->setSessionValue($detailPageObj->asset_id->CurrentValue);
                    $detailPageObj->category_id->setSessionValue(""); // Clear session key
                }
            }
            if (in_array("asset_warning", $detailTblVar)) {
                $detailPageObj = Container("AssetWarningGrid");
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->asset_id->IsDetailKey = true;
                    $detailPageObj->asset_id->CurrentValue = $this->asset_id->CurrentValue;
                    $detailPageObj->asset_id->setSessionValue($detailPageObj->asset_id->CurrentValue);
                    $detailPageObj->member_id->setSessionValue(""); // Clear session key
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("assetlist"), "", $this->TableVar, true);
        $pageId = "view";
        $Breadcrumb->add("view", $pageId, $url);
    }

    // Set up detail pages
    protected function setupDetailPages()
    {
        $pages = new SubPages();
        $pages->Style = "pills";
        $pages->add('asset_facilities');
        $pages->add('asset_pros_detail');
        $pages->add('asset_banner');
        $pages->add('asset_category');
        $pages->add('asset_warning');
        $this->DetailPages = $pages;
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
                case "x_brand_id":
                    $lookupFilter = function () {
                        return "`isactive` =1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_asset_status":
                    break;
                case "x_province_id":
                    break;
                case "x_amphur_id":
                    break;
                case "x_district_id":
                    break;
                case "x_isactive":
                    break;
                case "x_is_recommend":
                    break;
                case "x_type_pay":
                    break;
                case "x_type_pay_2":
                    break;
                case "x_holding_property":
                    break;
                case "x_is_cancel_contract":
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
