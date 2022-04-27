<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class AssetAdd extends Asset
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'asset';

    // Page object name
    public $PageObjName = "AssetAdd";

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

        // Table object (asset)
        if (!isset($GLOBALS["asset"]) || get_class($GLOBALS["asset"]) == PROJECT_NAMESPACE . "asset") {
            $GLOBALS["asset"] = &$this;
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
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;
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

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->asset_id->Visible = false;
        $this->_title->setVisibility();
        $this->title_en->setVisibility();
        $this->brand_id->setVisibility();
        $this->asset_short_detail->Visible = false;
        $this->asset_short_detail_en->Visible = false;
        $this->detail->setVisibility();
        $this->detail_en->setVisibility();
        $this->asset_code->Visible = false;
        $this->asset_status->Visible = false;
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
        $this->count_view->Visible = false;
        $this->count_favorite->Visible = false;
        $this->price_invertor->setVisibility();
        $this->installment_price->Visible = false;
        $this->installment_all->Visible = false;
        $this->master_calculator->Visible = false;
        $this->expired_date->setVisibility();
        $this->tag->Visible = false;
        $this->cdate->setVisibility();
        $this->cuser->setVisibility();
        $this->cip->setVisibility();
        $this->uip->setVisibility();
        $this->udate->setVisibility();
        $this->uuser->setVisibility();
        $this->update_expired_key->Visible = false;
        $this->update_expired_status->Visible = false;
        $this->update_expired_date->Visible = false;
        $this->update_expired_ip->Visible = false;
        $this->is_cancel_contract->Visible = false;
        $this->cancel_contract_reason->Visible = false;
        $this->cancel_contract_reason_detail->Visible = false;
        $this->cancel_contract_date->Visible = false;
        $this->cancel_contract_user->Visible = false;
        $this->cancel_contract_ip->Visible = false;
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
            if (($keyValue = Get("asset_id") ?? Route("asset_id")) !== null) {
                $this->asset_id->setQueryStringValue($keyValue);
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

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Set up detail parameters
        $this->setupDetailParms();

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
                    $this->terminate("assetlist"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = "assetlist";
                    if (GetPageName($returnUrl) == "assetlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "assetview") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
        $this->floor_plan->Upload->Index = $CurrentForm->Index;
        $this->floor_plan->Upload->uploadFile();
        $this->floor_plan->CurrentValue = $this->floor_plan->Upload->FileName;
        $this->layout_unit->Upload->Index = $CurrentForm->Index;
        $this->layout_unit->Upload->uploadFile();
        $this->layout_unit->CurrentValue = $this->layout_unit->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->asset_id->CurrentValue = null;
        $this->asset_id->OldValue = $this->asset_id->CurrentValue;
        $this->_title->CurrentValue = null;
        $this->_title->OldValue = $this->_title->CurrentValue;
        $this->title_en->CurrentValue = null;
        $this->title_en->OldValue = $this->title_en->CurrentValue;
        $this->brand_id->CurrentValue = null;
        $this->brand_id->OldValue = $this->brand_id->CurrentValue;
        $this->asset_short_detail->CurrentValue = null;
        $this->asset_short_detail->OldValue = $this->asset_short_detail->CurrentValue;
        $this->asset_short_detail_en->CurrentValue = null;
        $this->asset_short_detail_en->OldValue = $this->asset_short_detail_en->CurrentValue;
        $this->detail->CurrentValue = null;
        $this->detail->OldValue = $this->detail->CurrentValue;
        $this->detail_en->CurrentValue = null;
        $this->detail_en->OldValue = $this->detail_en->CurrentValue;
        $this->asset_code->CurrentValue = null;
        $this->asset_code->OldValue = $this->asset_code->CurrentValue;
        $this->asset_status->CurrentValue = 0;
        $this->latitude->CurrentValue = null;
        $this->latitude->OldValue = $this->latitude->CurrentValue;
        $this->longitude->CurrentValue = null;
        $this->longitude->OldValue = $this->longitude->CurrentValue;
        $this->num_buildings->CurrentValue = null;
        $this->num_buildings->OldValue = $this->num_buildings->CurrentValue;
        $this->num_unit->CurrentValue = null;
        $this->num_unit->OldValue = $this->num_unit->CurrentValue;
        $this->num_floors->CurrentValue = null;
        $this->num_floors->OldValue = $this->num_floors->CurrentValue;
        $this->floors->CurrentValue = null;
        $this->floors->OldValue = $this->floors->CurrentValue;
        $this->asset_year_developer->CurrentValue = null;
        $this->asset_year_developer->OldValue = $this->asset_year_developer->CurrentValue;
        $this->num_parking_spaces->CurrentValue = null;
        $this->num_parking_spaces->OldValue = $this->num_parking_spaces->CurrentValue;
        $this->num_bathrooms->CurrentValue = null;
        $this->num_bathrooms->OldValue = $this->num_bathrooms->CurrentValue;
        $this->num_bedrooms->CurrentValue = null;
        $this->num_bedrooms->OldValue = $this->num_bedrooms->CurrentValue;
        $this->address->CurrentValue = null;
        $this->address->OldValue = $this->address->CurrentValue;
        $this->address_en->CurrentValue = null;
        $this->address_en->OldValue = $this->address_en->CurrentValue;
        $this->province_id->CurrentValue = null;
        $this->province_id->OldValue = $this->province_id->CurrentValue;
        $this->amphur_id->CurrentValue = null;
        $this->amphur_id->OldValue = $this->amphur_id->CurrentValue;
        $this->district_id->CurrentValue = null;
        $this->district_id->OldValue = $this->district_id->CurrentValue;
        $this->postcode->CurrentValue = null;
        $this->postcode->OldValue = $this->postcode->CurrentValue;
        $this->floor_plan->Upload->DbValue = null;
        $this->floor_plan->OldValue = $this->floor_plan->Upload->DbValue;
        $this->floor_plan->CurrentValue = null; // Clear file related field
        $this->layout_unit->Upload->DbValue = null;
        $this->layout_unit->OldValue = $this->layout_unit->Upload->DbValue;
        $this->layout_unit->CurrentValue = null; // Clear file related field
        $this->asset_website->CurrentValue = null;
        $this->asset_website->OldValue = $this->asset_website->CurrentValue;
        $this->asset_review->CurrentValue = null;
        $this->asset_review->OldValue = $this->asset_review->CurrentValue;
        $this->isactive->CurrentValue = 1;
        $this->is_recommend->CurrentValue = 0;
        $this->order_by->CurrentValue = null;
        $this->order_by->OldValue = $this->order_by->CurrentValue;
        $this->type_pay->CurrentValue = 0;
        $this->type_pay_2->CurrentValue = 0;
        $this->price_mark->CurrentValue = null;
        $this->price_mark->OldValue = $this->price_mark->CurrentValue;
        $this->holding_property->CurrentValue = null;
        $this->holding_property->OldValue = $this->holding_property->CurrentValue;
        $this->common_fee->CurrentValue = null;
        $this->common_fee->OldValue = $this->common_fee->CurrentValue;
        $this->usable_area->CurrentValue = null;
        $this->usable_area->OldValue = $this->usable_area->CurrentValue;
        $this->usable_area_price->CurrentValue = null;
        $this->usable_area_price->OldValue = $this->usable_area_price->CurrentValue;
        $this->land_size->CurrentValue = null;
        $this->land_size->OldValue = $this->land_size->CurrentValue;
        $this->land_size_price->CurrentValue = null;
        $this->land_size_price->OldValue = $this->land_size_price->CurrentValue;
        $this->commission->CurrentValue = null;
        $this->commission->OldValue = $this->commission->CurrentValue;
        $this->transfer_day_expenses_with_business_tax->CurrentValue = null;
        $this->transfer_day_expenses_with_business_tax->OldValue = $this->transfer_day_expenses_with_business_tax->CurrentValue;
        $this->transfer_day_expenses_without_business_tax->CurrentValue = null;
        $this->transfer_day_expenses_without_business_tax->OldValue = $this->transfer_day_expenses_without_business_tax->CurrentValue;
        $this->price->CurrentValue = null;
        $this->price->OldValue = $this->price->CurrentValue;
        $this->discount->CurrentValue = null;
        $this->discount->OldValue = $this->discount->CurrentValue;
        $this->price_special->CurrentValue = null;
        $this->price_special->OldValue = $this->price_special->CurrentValue;
        $this->reservation_price_model_a->CurrentValue = null;
        $this->reservation_price_model_a->OldValue = $this->reservation_price_model_a->CurrentValue;
        $this->minimum_down_payment_model_a->CurrentValue = null;
        $this->minimum_down_payment_model_a->OldValue = $this->minimum_down_payment_model_a->CurrentValue;
        $this->down_price_min_a->CurrentValue = null;
        $this->down_price_min_a->OldValue = $this->down_price_min_a->CurrentValue;
        $this->down_price_model_a->CurrentValue = null;
        $this->down_price_model_a->OldValue = $this->down_price_model_a->CurrentValue;
        $this->factor_monthly_installment_over_down->CurrentValue = null;
        $this->factor_monthly_installment_over_down->OldValue = $this->factor_monthly_installment_over_down->CurrentValue;
        $this->fee_a->CurrentValue = null;
        $this->fee_a->OldValue = $this->fee_a->CurrentValue;
        $this->monthly_payment_buyer->CurrentValue = null;
        $this->monthly_payment_buyer->OldValue = $this->monthly_payment_buyer->CurrentValue;
        $this->annual_interest_buyer_model_a->CurrentValue = null;
        $this->annual_interest_buyer_model_a->OldValue = $this->annual_interest_buyer_model_a->CurrentValue;
        $this->monthly_expenses_a->CurrentValue = null;
        $this->monthly_expenses_a->OldValue = $this->monthly_expenses_a->CurrentValue;
        $this->average_rent_a->CurrentValue = null;
        $this->average_rent_a->OldValue = $this->average_rent_a->CurrentValue;
        $this->average_down_payment_a->CurrentValue = null;
        $this->average_down_payment_a->OldValue = $this->average_down_payment_a->CurrentValue;
        $this->transfer_day_expenses_without_business_tax_max_min->CurrentValue = null;
        $this->transfer_day_expenses_without_business_tax_max_min->OldValue = $this->transfer_day_expenses_without_business_tax_max_min->CurrentValue;
        $this->transfer_day_expenses_with_business_tax_max_min->CurrentValue = null;
        $this->transfer_day_expenses_with_business_tax_max_min->OldValue = $this->transfer_day_expenses_with_business_tax_max_min->CurrentValue;
        $this->bank_appraisal_price->CurrentValue = null;
        $this->bank_appraisal_price->OldValue = $this->bank_appraisal_price->CurrentValue;
        $this->mark_up_price->CurrentValue = null;
        $this->mark_up_price->OldValue = $this->mark_up_price->CurrentValue;
        $this->required_gap->CurrentValue = null;
        $this->required_gap->OldValue = $this->required_gap->CurrentValue;
        $this->minimum_down_payment->CurrentValue = null;
        $this->minimum_down_payment->OldValue = $this->minimum_down_payment->CurrentValue;
        $this->price_down_max->CurrentValue = null;
        $this->price_down_max->OldValue = $this->price_down_max->CurrentValue;
        $this->discount_max->CurrentValue = null;
        $this->discount_max->OldValue = $this->discount_max->CurrentValue;
        $this->price_down_special_max->CurrentValue = null;
        $this->price_down_special_max->OldValue = $this->price_down_special_max->CurrentValue;
        $this->usable_area_price_max->CurrentValue = null;
        $this->usable_area_price_max->OldValue = $this->usable_area_price_max->CurrentValue;
        $this->land_size_price_max->CurrentValue = null;
        $this->land_size_price_max->OldValue = $this->land_size_price_max->CurrentValue;
        $this->reservation_price_max->CurrentValue = null;
        $this->reservation_price_max->OldValue = $this->reservation_price_max->CurrentValue;
        $this->minimum_down_payment_max->CurrentValue = null;
        $this->minimum_down_payment_max->OldValue = $this->minimum_down_payment_max->CurrentValue;
        $this->down_price_max->CurrentValue = null;
        $this->down_price_max->OldValue = $this->down_price_max->CurrentValue;
        $this->down_price->CurrentValue = null;
        $this->down_price->OldValue = $this->down_price->CurrentValue;
        $this->factor_monthly_installment_over_down_max->CurrentValue = null;
        $this->factor_monthly_installment_over_down_max->OldValue = $this->factor_monthly_installment_over_down_max->CurrentValue;
        $this->fee_max->CurrentValue = null;
        $this->fee_max->OldValue = $this->fee_max->CurrentValue;
        $this->monthly_payment_max->CurrentValue = null;
        $this->monthly_payment_max->OldValue = $this->monthly_payment_max->CurrentValue;
        $this->annual_interest_buyer->CurrentValue = null;
        $this->annual_interest_buyer->OldValue = $this->annual_interest_buyer->CurrentValue;
        $this->monthly_expense_max->CurrentValue = null;
        $this->monthly_expense_max->OldValue = $this->monthly_expense_max->CurrentValue;
        $this->average_rent_max->CurrentValue = null;
        $this->average_rent_max->OldValue = $this->average_rent_max->CurrentValue;
        $this->average_down_payment_max->CurrentValue = null;
        $this->average_down_payment_max->OldValue = $this->average_down_payment_max->CurrentValue;
        $this->min_down->CurrentValue = null;
        $this->min_down->OldValue = $this->min_down->CurrentValue;
        $this->remaining_down->CurrentValue = null;
        $this->remaining_down->OldValue = $this->remaining_down->CurrentValue;
        $this->factor_financing->CurrentValue = null;
        $this->factor_financing->OldValue = $this->factor_financing->CurrentValue;
        $this->credit_limit_down->CurrentValue = null;
        $this->credit_limit_down->OldValue = $this->credit_limit_down->CurrentValue;
        $this->price_down_min->CurrentValue = null;
        $this->price_down_min->OldValue = $this->price_down_min->CurrentValue;
        $this->discount_min->CurrentValue = null;
        $this->discount_min->OldValue = $this->discount_min->CurrentValue;
        $this->price_down_special_min->CurrentValue = null;
        $this->price_down_special_min->OldValue = $this->price_down_special_min->CurrentValue;
        $this->usable_area_price_min->CurrentValue = null;
        $this->usable_area_price_min->OldValue = $this->usable_area_price_min->CurrentValue;
        $this->land_size_price_min->CurrentValue = null;
        $this->land_size_price_min->OldValue = $this->land_size_price_min->CurrentValue;
        $this->reservation_price_min->CurrentValue = null;
        $this->reservation_price_min->OldValue = $this->reservation_price_min->CurrentValue;
        $this->minimum_down_payment_min->CurrentValue = null;
        $this->minimum_down_payment_min->OldValue = $this->minimum_down_payment_min->CurrentValue;
        $this->down_price_min->CurrentValue = null;
        $this->down_price_min->OldValue = $this->down_price_min->CurrentValue;
        $this->remaining_credit_limit_down->CurrentValue = null;
        $this->remaining_credit_limit_down->OldValue = $this->remaining_credit_limit_down->CurrentValue;
        $this->fee_min->CurrentValue = null;
        $this->fee_min->OldValue = $this->fee_min->CurrentValue;
        $this->monthly_payment_min->CurrentValue = null;
        $this->monthly_payment_min->OldValue = $this->monthly_payment_min->CurrentValue;
        $this->annual_interest_buyer_model_min->CurrentValue = null;
        $this->annual_interest_buyer_model_min->OldValue = $this->annual_interest_buyer_model_min->CurrentValue;
        $this->interest_downpayment_financing->CurrentValue = null;
        $this->interest_downpayment_financing->OldValue = $this->interest_downpayment_financing->CurrentValue;
        $this->monthly_expenses_min->CurrentValue = null;
        $this->monthly_expenses_min->OldValue = $this->monthly_expenses_min->CurrentValue;
        $this->average_rent_min->CurrentValue = null;
        $this->average_rent_min->OldValue = $this->average_rent_min->CurrentValue;
        $this->average_down_payment_min->CurrentValue = null;
        $this->average_down_payment_min->OldValue = $this->average_down_payment_min->CurrentValue;
        $this->installment_down_payment_loan->CurrentValue = null;
        $this->installment_down_payment_loan->OldValue = $this->installment_down_payment_loan->CurrentValue;
        $this->count_view->CurrentValue = 0;
        $this->count_favorite->CurrentValue = 0;
        $this->price_invertor->CurrentValue = null;
        $this->price_invertor->OldValue = $this->price_invertor->CurrentValue;
        $this->installment_price->CurrentValue = null;
        $this->installment_price->OldValue = $this->installment_price->CurrentValue;
        $this->installment_all->CurrentValue = null;
        $this->installment_all->OldValue = $this->installment_all->CurrentValue;
        $this->master_calculator->CurrentValue = null;
        $this->master_calculator->OldValue = $this->master_calculator->CurrentValue;
        $this->expired_date->CurrentValue = null;
        $this->expired_date->OldValue = $this->expired_date->CurrentValue;
        $this->tag->CurrentValue = null;
        $this->tag->OldValue = $this->tag->CurrentValue;
        $this->cdate->CurrentValue = null;
        $this->cdate->OldValue = $this->cdate->CurrentValue;
        $this->cuser->CurrentValue = null;
        $this->cuser->OldValue = $this->cuser->CurrentValue;
        $this->cip->CurrentValue = null;
        $this->cip->OldValue = $this->cip->CurrentValue;
        $this->uip->CurrentValue = null;
        $this->uip->OldValue = $this->uip->CurrentValue;
        $this->udate->CurrentValue = null;
        $this->udate->OldValue = $this->udate->CurrentValue;
        $this->uuser->CurrentValue = null;
        $this->uuser->OldValue = $this->uuser->CurrentValue;
        $this->update_expired_key->CurrentValue = null;
        $this->update_expired_key->OldValue = $this->update_expired_key->CurrentValue;
        $this->update_expired_status->CurrentValue = 0;
        $this->update_expired_date->CurrentValue = null;
        $this->update_expired_date->OldValue = $this->update_expired_date->CurrentValue;
        $this->update_expired_ip->CurrentValue = null;
        $this->update_expired_ip->OldValue = $this->update_expired_ip->CurrentValue;
        $this->is_cancel_contract->CurrentValue = 0;
        $this->cancel_contract_reason->CurrentValue = null;
        $this->cancel_contract_reason->OldValue = $this->cancel_contract_reason->CurrentValue;
        $this->cancel_contract_reason_detail->CurrentValue = null;
        $this->cancel_contract_reason_detail->OldValue = $this->cancel_contract_reason_detail->CurrentValue;
        $this->cancel_contract_date->CurrentValue = null;
        $this->cancel_contract_date->OldValue = $this->cancel_contract_date->CurrentValue;
        $this->cancel_contract_user->CurrentValue = null;
        $this->cancel_contract_user->OldValue = $this->cancel_contract_user->CurrentValue;
        $this->cancel_contract_ip->CurrentValue = null;
        $this->cancel_contract_ip->OldValue = $this->cancel_contract_ip->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

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

        // Check field name 'brand_id' first before field var 'x_brand_id'
        $val = $CurrentForm->hasValue("brand_id") ? $CurrentForm->getValue("brand_id") : $CurrentForm->getValue("x_brand_id");
        if (!$this->brand_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->brand_id->Visible = false; // Disable update for API request
            } else {
                $this->brand_id->setFormValue($val);
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

        // Check field name 'latitude' first before field var 'x_latitude'
        $val = $CurrentForm->hasValue("latitude") ? $CurrentForm->getValue("latitude") : $CurrentForm->getValue("x_latitude");
        if (!$this->latitude->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->latitude->Visible = false; // Disable update for API request
            } else {
                $this->latitude->setFormValue($val);
            }
        }

        // Check field name 'longitude' first before field var 'x_longitude'
        $val = $CurrentForm->hasValue("longitude") ? $CurrentForm->getValue("longitude") : $CurrentForm->getValue("x_longitude");
        if (!$this->longitude->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->longitude->Visible = false; // Disable update for API request
            } else {
                $this->longitude->setFormValue($val);
            }
        }

        // Check field name 'num_buildings' first before field var 'x_num_buildings'
        $val = $CurrentForm->hasValue("num_buildings") ? $CurrentForm->getValue("num_buildings") : $CurrentForm->getValue("x_num_buildings");
        if (!$this->num_buildings->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->num_buildings->Visible = false; // Disable update for API request
            } else {
                $this->num_buildings->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'num_unit' first before field var 'x_num_unit'
        $val = $CurrentForm->hasValue("num_unit") ? $CurrentForm->getValue("num_unit") : $CurrentForm->getValue("x_num_unit");
        if (!$this->num_unit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->num_unit->Visible = false; // Disable update for API request
            } else {
                $this->num_unit->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'num_floors' first before field var 'x_num_floors'
        $val = $CurrentForm->hasValue("num_floors") ? $CurrentForm->getValue("num_floors") : $CurrentForm->getValue("x_num_floors");
        if (!$this->num_floors->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->num_floors->Visible = false; // Disable update for API request
            } else {
                $this->num_floors->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'floors' first before field var 'x_floors'
        $val = $CurrentForm->hasValue("floors") ? $CurrentForm->getValue("floors") : $CurrentForm->getValue("x_floors");
        if (!$this->floors->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->floors->Visible = false; // Disable update for API request
            } else {
                $this->floors->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'asset_year_developer' first before field var 'x_asset_year_developer'
        $val = $CurrentForm->hasValue("asset_year_developer") ? $CurrentForm->getValue("asset_year_developer") : $CurrentForm->getValue("x_asset_year_developer");
        if (!$this->asset_year_developer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_year_developer->Visible = false; // Disable update for API request
            } else {
                $this->asset_year_developer->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'num_parking_spaces' first before field var 'x_num_parking_spaces'
        $val = $CurrentForm->hasValue("num_parking_spaces") ? $CurrentForm->getValue("num_parking_spaces") : $CurrentForm->getValue("x_num_parking_spaces");
        if (!$this->num_parking_spaces->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->num_parking_spaces->Visible = false; // Disable update for API request
            } else {
                $this->num_parking_spaces->setFormValue($val);
            }
        }

        // Check field name 'num_bathrooms' first before field var 'x_num_bathrooms'
        $val = $CurrentForm->hasValue("num_bathrooms") ? $CurrentForm->getValue("num_bathrooms") : $CurrentForm->getValue("x_num_bathrooms");
        if (!$this->num_bathrooms->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->num_bathrooms->Visible = false; // Disable update for API request
            } else {
                $this->num_bathrooms->setFormValue($val);
            }
        }

        // Check field name 'num_bedrooms' first before field var 'x_num_bedrooms'
        $val = $CurrentForm->hasValue("num_bedrooms") ? $CurrentForm->getValue("num_bedrooms") : $CurrentForm->getValue("x_num_bedrooms");
        if (!$this->num_bedrooms->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->num_bedrooms->Visible = false; // Disable update for API request
            } else {
                $this->num_bedrooms->setFormValue($val);
            }
        }

        // Check field name 'address' first before field var 'x_address'
        $val = $CurrentForm->hasValue("address") ? $CurrentForm->getValue("address") : $CurrentForm->getValue("x_address");
        if (!$this->address->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->address->Visible = false; // Disable update for API request
            } else {
                $this->address->setFormValue($val);
            }
        }

        // Check field name 'address_en' first before field var 'x_address_en'
        $val = $CurrentForm->hasValue("address_en") ? $CurrentForm->getValue("address_en") : $CurrentForm->getValue("x_address_en");
        if (!$this->address_en->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->address_en->Visible = false; // Disable update for API request
            } else {
                $this->address_en->setFormValue($val);
            }
        }

        // Check field name 'province_id' first before field var 'x_province_id'
        $val = $CurrentForm->hasValue("province_id") ? $CurrentForm->getValue("province_id") : $CurrentForm->getValue("x_province_id");
        if (!$this->province_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->province_id->Visible = false; // Disable update for API request
            } else {
                $this->province_id->setFormValue($val);
            }
        }

        // Check field name 'amphur_id' first before field var 'x_amphur_id'
        $val = $CurrentForm->hasValue("amphur_id") ? $CurrentForm->getValue("amphur_id") : $CurrentForm->getValue("x_amphur_id");
        if (!$this->amphur_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->amphur_id->Visible = false; // Disable update for API request
            } else {
                $this->amphur_id->setFormValue($val);
            }
        }

        // Check field name 'district_id' first before field var 'x_district_id'
        $val = $CurrentForm->hasValue("district_id") ? $CurrentForm->getValue("district_id") : $CurrentForm->getValue("x_district_id");
        if (!$this->district_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->district_id->Visible = false; // Disable update for API request
            } else {
                $this->district_id->setFormValue($val);
            }
        }

        // Check field name 'postcode' first before field var 'x_postcode'
        $val = $CurrentForm->hasValue("postcode") ? $CurrentForm->getValue("postcode") : $CurrentForm->getValue("x_postcode");
        if (!$this->postcode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->postcode->Visible = false; // Disable update for API request
            } else {
                $this->postcode->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'asset_website' first before field var 'x_asset_website'
        $val = $CurrentForm->hasValue("asset_website") ? $CurrentForm->getValue("asset_website") : $CurrentForm->getValue("x_asset_website");
        if (!$this->asset_website->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_website->Visible = false; // Disable update for API request
            } else {
                $this->asset_website->setFormValue($val);
            }
        }

        // Check field name 'asset_review' first before field var 'x_asset_review'
        $val = $CurrentForm->hasValue("asset_review") ? $CurrentForm->getValue("asset_review") : $CurrentForm->getValue("x_asset_review");
        if (!$this->asset_review->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_review->Visible = false; // Disable update for API request
            } else {
                $this->asset_review->setFormValue($val);
            }
        }

        // Check field name 'isactive' first before field var 'x_isactive'
        $val = $CurrentForm->hasValue("isactive") ? $CurrentForm->getValue("isactive") : $CurrentForm->getValue("x_isactive");
        if (!$this->isactive->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isactive->Visible = false; // Disable update for API request
            } else {
                $this->isactive->setFormValue($val);
            }
        }

        // Check field name 'is_recommend' first before field var 'x_is_recommend'
        $val = $CurrentForm->hasValue("is_recommend") ? $CurrentForm->getValue("is_recommend") : $CurrentForm->getValue("x_is_recommend");
        if (!$this->is_recommend->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->is_recommend->Visible = false; // Disable update for API request
            } else {
                $this->is_recommend->setFormValue($val);
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

        // Check field name 'type_pay' first before field var 'x_type_pay'
        $val = $CurrentForm->hasValue("type_pay") ? $CurrentForm->getValue("type_pay") : $CurrentForm->getValue("x_type_pay");
        if (!$this->type_pay->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->type_pay->Visible = false; // Disable update for API request
            } else {
                $this->type_pay->setFormValue($val);
            }
        }

        // Check field name 'type_pay_2' first before field var 'x_type_pay_2'
        $val = $CurrentForm->hasValue("type_pay_2") ? $CurrentForm->getValue("type_pay_2") : $CurrentForm->getValue("x_type_pay_2");
        if (!$this->type_pay_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->type_pay_2->Visible = false; // Disable update for API request
            } else {
                $this->type_pay_2->setFormValue($val);
            }
        }

        // Check field name 'price_mark' first before field var 'x_price_mark'
        $val = $CurrentForm->hasValue("price_mark") ? $CurrentForm->getValue("price_mark") : $CurrentForm->getValue("x_price_mark");
        if (!$this->price_mark->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price_mark->Visible = false; // Disable update for API request
            } else {
                $this->price_mark->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'holding_property' first before field var 'x_holding_property'
        $val = $CurrentForm->hasValue("holding_property") ? $CurrentForm->getValue("holding_property") : $CurrentForm->getValue("x_holding_property");
        if (!$this->holding_property->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->holding_property->Visible = false; // Disable update for API request
            } else {
                $this->holding_property->setFormValue($val);
            }
        }

        // Check field name 'common_fee' first before field var 'x_common_fee'
        $val = $CurrentForm->hasValue("common_fee") ? $CurrentForm->getValue("common_fee") : $CurrentForm->getValue("x_common_fee");
        if (!$this->common_fee->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->common_fee->Visible = false; // Disable update for API request
            } else {
                $this->common_fee->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'usable_area' first before field var 'x_usable_area'
        $val = $CurrentForm->hasValue("usable_area") ? $CurrentForm->getValue("usable_area") : $CurrentForm->getValue("x_usable_area");
        if (!$this->usable_area->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usable_area->Visible = false; // Disable update for API request
            } else {
                $this->usable_area->setFormValue($val);
            }
        }

        // Check field name 'usable_area_price' first before field var 'x_usable_area_price'
        $val = $CurrentForm->hasValue("usable_area_price") ? $CurrentForm->getValue("usable_area_price") : $CurrentForm->getValue("x_usable_area_price");
        if (!$this->usable_area_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usable_area_price->Visible = false; // Disable update for API request
            } else {
                $this->usable_area_price->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'land_size' first before field var 'x_land_size'
        $val = $CurrentForm->hasValue("land_size") ? $CurrentForm->getValue("land_size") : $CurrentForm->getValue("x_land_size");
        if (!$this->land_size->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->land_size->Visible = false; // Disable update for API request
            } else {
                $this->land_size->setFormValue($val);
            }
        }

        // Check field name 'land_size_price' first before field var 'x_land_size_price'
        $val = $CurrentForm->hasValue("land_size_price") ? $CurrentForm->getValue("land_size_price") : $CurrentForm->getValue("x_land_size_price");
        if (!$this->land_size_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->land_size_price->Visible = false; // Disable update for API request
            } else {
                $this->land_size_price->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'commission' first before field var 'x_commission'
        $val = $CurrentForm->hasValue("commission") ? $CurrentForm->getValue("commission") : $CurrentForm->getValue("x_commission");
        if (!$this->commission->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->commission->Visible = false; // Disable update for API request
            } else {
                $this->commission->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'transfer_day_expenses_with_business_tax' first before field var 'x_transfer_day_expenses_with_business_tax'
        $val = $CurrentForm->hasValue("transfer_day_expenses_with_business_tax") ? $CurrentForm->getValue("transfer_day_expenses_with_business_tax") : $CurrentForm->getValue("x_transfer_day_expenses_with_business_tax");
        if (!$this->transfer_day_expenses_with_business_tax->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->transfer_day_expenses_with_business_tax->Visible = false; // Disable update for API request
            } else {
                $this->transfer_day_expenses_with_business_tax->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'transfer_day_expenses_without_business_tax' first before field var 'x_transfer_day_expenses_without_business_tax'
        $val = $CurrentForm->hasValue("transfer_day_expenses_without_business_tax") ? $CurrentForm->getValue("transfer_day_expenses_without_business_tax") : $CurrentForm->getValue("x_transfer_day_expenses_without_business_tax");
        if (!$this->transfer_day_expenses_without_business_tax->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->transfer_day_expenses_without_business_tax->Visible = false; // Disable update for API request
            } else {
                $this->transfer_day_expenses_without_business_tax->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'price' first before field var 'x_price'
        $val = $CurrentForm->hasValue("price") ? $CurrentForm->getValue("price") : $CurrentForm->getValue("x_price");
        if (!$this->price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price->Visible = false; // Disable update for API request
            } else {
                $this->price->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'discount' first before field var 'x_discount'
        $val = $CurrentForm->hasValue("discount") ? $CurrentForm->getValue("discount") : $CurrentForm->getValue("x_discount");
        if (!$this->discount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->discount->Visible = false; // Disable update for API request
            } else {
                $this->discount->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'price_special' first before field var 'x_price_special'
        $val = $CurrentForm->hasValue("price_special") ? $CurrentForm->getValue("price_special") : $CurrentForm->getValue("x_price_special");
        if (!$this->price_special->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price_special->Visible = false; // Disable update for API request
            } else {
                $this->price_special->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'reservation_price_model_a' first before field var 'x_reservation_price_model_a'
        $val = $CurrentForm->hasValue("reservation_price_model_a") ? $CurrentForm->getValue("reservation_price_model_a") : $CurrentForm->getValue("x_reservation_price_model_a");
        if (!$this->reservation_price_model_a->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->reservation_price_model_a->Visible = false; // Disable update for API request
            } else {
                $this->reservation_price_model_a->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'minimum_down_payment_model_a' first before field var 'x_minimum_down_payment_model_a'
        $val = $CurrentForm->hasValue("minimum_down_payment_model_a") ? $CurrentForm->getValue("minimum_down_payment_model_a") : $CurrentForm->getValue("x_minimum_down_payment_model_a");
        if (!$this->minimum_down_payment_model_a->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->minimum_down_payment_model_a->Visible = false; // Disable update for API request
            } else {
                $this->minimum_down_payment_model_a->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'down_price_min_a' first before field var 'x_down_price_min_a'
        $val = $CurrentForm->hasValue("down_price_min_a") ? $CurrentForm->getValue("down_price_min_a") : $CurrentForm->getValue("x_down_price_min_a");
        if (!$this->down_price_min_a->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->down_price_min_a->Visible = false; // Disable update for API request
            } else {
                $this->down_price_min_a->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'down_price_model_a' first before field var 'x_down_price_model_a'
        $val = $CurrentForm->hasValue("down_price_model_a") ? $CurrentForm->getValue("down_price_model_a") : $CurrentForm->getValue("x_down_price_model_a");
        if (!$this->down_price_model_a->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->down_price_model_a->Visible = false; // Disable update for API request
            } else {
                $this->down_price_model_a->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'factor_monthly_installment_over_down' first before field var 'x_factor_monthly_installment_over_down'
        $val = $CurrentForm->hasValue("factor_monthly_installment_over_down") ? $CurrentForm->getValue("factor_monthly_installment_over_down") : $CurrentForm->getValue("x_factor_monthly_installment_over_down");
        if (!$this->factor_monthly_installment_over_down->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->factor_monthly_installment_over_down->Visible = false; // Disable update for API request
            } else {
                $this->factor_monthly_installment_over_down->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'fee_a' first before field var 'x_fee_a'
        $val = $CurrentForm->hasValue("fee_a") ? $CurrentForm->getValue("fee_a") : $CurrentForm->getValue("x_fee_a");
        if (!$this->fee_a->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fee_a->Visible = false; // Disable update for API request
            } else {
                $this->fee_a->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'monthly_payment_buyer' first before field var 'x_monthly_payment_buyer'
        $val = $CurrentForm->hasValue("monthly_payment_buyer") ? $CurrentForm->getValue("monthly_payment_buyer") : $CurrentForm->getValue("x_monthly_payment_buyer");
        if (!$this->monthly_payment_buyer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monthly_payment_buyer->Visible = false; // Disable update for API request
            } else {
                $this->monthly_payment_buyer->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'annual_interest_buyer_model_a' first before field var 'x_annual_interest_buyer_model_a'
        $val = $CurrentForm->hasValue("annual_interest_buyer_model_a") ? $CurrentForm->getValue("annual_interest_buyer_model_a") : $CurrentForm->getValue("x_annual_interest_buyer_model_a");
        if (!$this->annual_interest_buyer_model_a->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->annual_interest_buyer_model_a->Visible = false; // Disable update for API request
            } else {
                $this->annual_interest_buyer_model_a->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'monthly_expenses_a' first before field var 'x_monthly_expenses_a'
        $val = $CurrentForm->hasValue("monthly_expenses_a") ? $CurrentForm->getValue("monthly_expenses_a") : $CurrentForm->getValue("x_monthly_expenses_a");
        if (!$this->monthly_expenses_a->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monthly_expenses_a->Visible = false; // Disable update for API request
            } else {
                $this->monthly_expenses_a->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'average_rent_a' first before field var 'x_average_rent_a'
        $val = $CurrentForm->hasValue("average_rent_a") ? $CurrentForm->getValue("average_rent_a") : $CurrentForm->getValue("x_average_rent_a");
        if (!$this->average_rent_a->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->average_rent_a->Visible = false; // Disable update for API request
            } else {
                $this->average_rent_a->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'average_down_payment_a' first before field var 'x_average_down_payment_a'
        $val = $CurrentForm->hasValue("average_down_payment_a") ? $CurrentForm->getValue("average_down_payment_a") : $CurrentForm->getValue("x_average_down_payment_a");
        if (!$this->average_down_payment_a->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->average_down_payment_a->Visible = false; // Disable update for API request
            } else {
                $this->average_down_payment_a->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'transfer_day_expenses_without_business_tax_max_min' first before field var 'x_transfer_day_expenses_without_business_tax_max_min'
        $val = $CurrentForm->hasValue("transfer_day_expenses_without_business_tax_max_min") ? $CurrentForm->getValue("transfer_day_expenses_without_business_tax_max_min") : $CurrentForm->getValue("x_transfer_day_expenses_without_business_tax_max_min");
        if (!$this->transfer_day_expenses_without_business_tax_max_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->transfer_day_expenses_without_business_tax_max_min->Visible = false; // Disable update for API request
            } else {
                $this->transfer_day_expenses_without_business_tax_max_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'transfer_day_expenses_with_business_tax_max_min' first before field var 'x_transfer_day_expenses_with_business_tax_max_min'
        $val = $CurrentForm->hasValue("transfer_day_expenses_with_business_tax_max_min") ? $CurrentForm->getValue("transfer_day_expenses_with_business_tax_max_min") : $CurrentForm->getValue("x_transfer_day_expenses_with_business_tax_max_min");
        if (!$this->transfer_day_expenses_with_business_tax_max_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->transfer_day_expenses_with_business_tax_max_min->Visible = false; // Disable update for API request
            } else {
                $this->transfer_day_expenses_with_business_tax_max_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'bank_appraisal_price' first before field var 'x_bank_appraisal_price'
        $val = $CurrentForm->hasValue("bank_appraisal_price") ? $CurrentForm->getValue("bank_appraisal_price") : $CurrentForm->getValue("x_bank_appraisal_price");
        if (!$this->bank_appraisal_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bank_appraisal_price->Visible = false; // Disable update for API request
            } else {
                $this->bank_appraisal_price->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'mark_up_price' first before field var 'x_mark_up_price'
        $val = $CurrentForm->hasValue("mark_up_price") ? $CurrentForm->getValue("mark_up_price") : $CurrentForm->getValue("x_mark_up_price");
        if (!$this->mark_up_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->mark_up_price->Visible = false; // Disable update for API request
            } else {
                $this->mark_up_price->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'required_gap' first before field var 'x_required_gap'
        $val = $CurrentForm->hasValue("required_gap") ? $CurrentForm->getValue("required_gap") : $CurrentForm->getValue("x_required_gap");
        if (!$this->required_gap->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->required_gap->Visible = false; // Disable update for API request
            } else {
                $this->required_gap->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'minimum_down_payment' first before field var 'x_minimum_down_payment'
        $val = $CurrentForm->hasValue("minimum_down_payment") ? $CurrentForm->getValue("minimum_down_payment") : $CurrentForm->getValue("x_minimum_down_payment");
        if (!$this->minimum_down_payment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->minimum_down_payment->Visible = false; // Disable update for API request
            } else {
                $this->minimum_down_payment->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'price_down_max' first before field var 'x_price_down_max'
        $val = $CurrentForm->hasValue("price_down_max") ? $CurrentForm->getValue("price_down_max") : $CurrentForm->getValue("x_price_down_max");
        if (!$this->price_down_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price_down_max->Visible = false; // Disable update for API request
            } else {
                $this->price_down_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'discount_max' first before field var 'x_discount_max'
        $val = $CurrentForm->hasValue("discount_max") ? $CurrentForm->getValue("discount_max") : $CurrentForm->getValue("x_discount_max");
        if (!$this->discount_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->discount_max->Visible = false; // Disable update for API request
            } else {
                $this->discount_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'price_down_special_max' first before field var 'x_price_down_special_max'
        $val = $CurrentForm->hasValue("price_down_special_max") ? $CurrentForm->getValue("price_down_special_max") : $CurrentForm->getValue("x_price_down_special_max");
        if (!$this->price_down_special_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price_down_special_max->Visible = false; // Disable update for API request
            } else {
                $this->price_down_special_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'usable_area_price_max' first before field var 'x_usable_area_price_max'
        $val = $CurrentForm->hasValue("usable_area_price_max") ? $CurrentForm->getValue("usable_area_price_max") : $CurrentForm->getValue("x_usable_area_price_max");
        if (!$this->usable_area_price_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usable_area_price_max->Visible = false; // Disable update for API request
            } else {
                $this->usable_area_price_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'land_size_price_max' first before field var 'x_land_size_price_max'
        $val = $CurrentForm->hasValue("land_size_price_max") ? $CurrentForm->getValue("land_size_price_max") : $CurrentForm->getValue("x_land_size_price_max");
        if (!$this->land_size_price_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->land_size_price_max->Visible = false; // Disable update for API request
            } else {
                $this->land_size_price_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'reservation_price_max' first before field var 'x_reservation_price_max'
        $val = $CurrentForm->hasValue("reservation_price_max") ? $CurrentForm->getValue("reservation_price_max") : $CurrentForm->getValue("x_reservation_price_max");
        if (!$this->reservation_price_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->reservation_price_max->Visible = false; // Disable update for API request
            } else {
                $this->reservation_price_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'minimum_down_payment_max' first before field var 'x_minimum_down_payment_max'
        $val = $CurrentForm->hasValue("minimum_down_payment_max") ? $CurrentForm->getValue("minimum_down_payment_max") : $CurrentForm->getValue("x_minimum_down_payment_max");
        if (!$this->minimum_down_payment_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->minimum_down_payment_max->Visible = false; // Disable update for API request
            } else {
                $this->minimum_down_payment_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'down_price_max' first before field var 'x_down_price_max'
        $val = $CurrentForm->hasValue("down_price_max") ? $CurrentForm->getValue("down_price_max") : $CurrentForm->getValue("x_down_price_max");
        if (!$this->down_price_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->down_price_max->Visible = false; // Disable update for API request
            } else {
                $this->down_price_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'down_price' first before field var 'x_down_price'
        $val = $CurrentForm->hasValue("down_price") ? $CurrentForm->getValue("down_price") : $CurrentForm->getValue("x_down_price");
        if (!$this->down_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->down_price->Visible = false; // Disable update for API request
            } else {
                $this->down_price->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'factor_monthly_installment_over_down_max' first before field var 'x_factor_monthly_installment_over_down_max'
        $val = $CurrentForm->hasValue("factor_monthly_installment_over_down_max") ? $CurrentForm->getValue("factor_monthly_installment_over_down_max") : $CurrentForm->getValue("x_factor_monthly_installment_over_down_max");
        if (!$this->factor_monthly_installment_over_down_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->factor_monthly_installment_over_down_max->Visible = false; // Disable update for API request
            } else {
                $this->factor_monthly_installment_over_down_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'fee_max' first before field var 'x_fee_max'
        $val = $CurrentForm->hasValue("fee_max") ? $CurrentForm->getValue("fee_max") : $CurrentForm->getValue("x_fee_max");
        if (!$this->fee_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fee_max->Visible = false; // Disable update for API request
            } else {
                $this->fee_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'monthly_payment_max' first before field var 'x_monthly_payment_max'
        $val = $CurrentForm->hasValue("monthly_payment_max") ? $CurrentForm->getValue("monthly_payment_max") : $CurrentForm->getValue("x_monthly_payment_max");
        if (!$this->monthly_payment_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monthly_payment_max->Visible = false; // Disable update for API request
            } else {
                $this->monthly_payment_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'annual_interest_buyer' first before field var 'x_annual_interest_buyer'
        $val = $CurrentForm->hasValue("annual_interest_buyer") ? $CurrentForm->getValue("annual_interest_buyer") : $CurrentForm->getValue("x_annual_interest_buyer");
        if (!$this->annual_interest_buyer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->annual_interest_buyer->Visible = false; // Disable update for API request
            } else {
                $this->annual_interest_buyer->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'monthly_expense_max' first before field var 'x_monthly_expense_max'
        $val = $CurrentForm->hasValue("monthly_expense_max") ? $CurrentForm->getValue("monthly_expense_max") : $CurrentForm->getValue("x_monthly_expense_max");
        if (!$this->monthly_expense_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monthly_expense_max->Visible = false; // Disable update for API request
            } else {
                $this->monthly_expense_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'average_rent_max' first before field var 'x_average_rent_max'
        $val = $CurrentForm->hasValue("average_rent_max") ? $CurrentForm->getValue("average_rent_max") : $CurrentForm->getValue("x_average_rent_max");
        if (!$this->average_rent_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->average_rent_max->Visible = false; // Disable update for API request
            } else {
                $this->average_rent_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'average_down_payment_max' first before field var 'x_average_down_payment_max'
        $val = $CurrentForm->hasValue("average_down_payment_max") ? $CurrentForm->getValue("average_down_payment_max") : $CurrentForm->getValue("x_average_down_payment_max");
        if (!$this->average_down_payment_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->average_down_payment_max->Visible = false; // Disable update for API request
            } else {
                $this->average_down_payment_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'min_down' first before field var 'x_min_down'
        $val = $CurrentForm->hasValue("min_down") ? $CurrentForm->getValue("min_down") : $CurrentForm->getValue("x_min_down");
        if (!$this->min_down->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->min_down->Visible = false; // Disable update for API request
            } else {
                $this->min_down->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'remaining_down' first before field var 'x_remaining_down'
        $val = $CurrentForm->hasValue("remaining_down") ? $CurrentForm->getValue("remaining_down") : $CurrentForm->getValue("x_remaining_down");
        if (!$this->remaining_down->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->remaining_down->Visible = false; // Disable update for API request
            } else {
                $this->remaining_down->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'factor_financing' first before field var 'x_factor_financing'
        $val = $CurrentForm->hasValue("factor_financing") ? $CurrentForm->getValue("factor_financing") : $CurrentForm->getValue("x_factor_financing");
        if (!$this->factor_financing->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->factor_financing->Visible = false; // Disable update for API request
            } else {
                $this->factor_financing->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'credit_limit_down' first before field var 'x_credit_limit_down'
        $val = $CurrentForm->hasValue("credit_limit_down") ? $CurrentForm->getValue("credit_limit_down") : $CurrentForm->getValue("x_credit_limit_down");
        if (!$this->credit_limit_down->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->credit_limit_down->Visible = false; // Disable update for API request
            } else {
                $this->credit_limit_down->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'price_down_min' first before field var 'x_price_down_min'
        $val = $CurrentForm->hasValue("price_down_min") ? $CurrentForm->getValue("price_down_min") : $CurrentForm->getValue("x_price_down_min");
        if (!$this->price_down_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price_down_min->Visible = false; // Disable update for API request
            } else {
                $this->price_down_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'discount_min' first before field var 'x_discount_min'
        $val = $CurrentForm->hasValue("discount_min") ? $CurrentForm->getValue("discount_min") : $CurrentForm->getValue("x_discount_min");
        if (!$this->discount_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->discount_min->Visible = false; // Disable update for API request
            } else {
                $this->discount_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'price_down_special_min' first before field var 'x_price_down_special_min'
        $val = $CurrentForm->hasValue("price_down_special_min") ? $CurrentForm->getValue("price_down_special_min") : $CurrentForm->getValue("x_price_down_special_min");
        if (!$this->price_down_special_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price_down_special_min->Visible = false; // Disable update for API request
            } else {
                $this->price_down_special_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'usable_area_price_min' first before field var 'x_usable_area_price_min'
        $val = $CurrentForm->hasValue("usable_area_price_min") ? $CurrentForm->getValue("usable_area_price_min") : $CurrentForm->getValue("x_usable_area_price_min");
        if (!$this->usable_area_price_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usable_area_price_min->Visible = false; // Disable update for API request
            } else {
                $this->usable_area_price_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'land_size_price_min' first before field var 'x_land_size_price_min'
        $val = $CurrentForm->hasValue("land_size_price_min") ? $CurrentForm->getValue("land_size_price_min") : $CurrentForm->getValue("x_land_size_price_min");
        if (!$this->land_size_price_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->land_size_price_min->Visible = false; // Disable update for API request
            } else {
                $this->land_size_price_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'reservation_price_min' first before field var 'x_reservation_price_min'
        $val = $CurrentForm->hasValue("reservation_price_min") ? $CurrentForm->getValue("reservation_price_min") : $CurrentForm->getValue("x_reservation_price_min");
        if (!$this->reservation_price_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->reservation_price_min->Visible = false; // Disable update for API request
            } else {
                $this->reservation_price_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'minimum_down_payment_min' first before field var 'x_minimum_down_payment_min'
        $val = $CurrentForm->hasValue("minimum_down_payment_min") ? $CurrentForm->getValue("minimum_down_payment_min") : $CurrentForm->getValue("x_minimum_down_payment_min");
        if (!$this->minimum_down_payment_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->minimum_down_payment_min->Visible = false; // Disable update for API request
            } else {
                $this->minimum_down_payment_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'down_price_min' first before field var 'x_down_price_min'
        $val = $CurrentForm->hasValue("down_price_min") ? $CurrentForm->getValue("down_price_min") : $CurrentForm->getValue("x_down_price_min");
        if (!$this->down_price_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->down_price_min->Visible = false; // Disable update for API request
            } else {
                $this->down_price_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'remaining_credit_limit_down' first before field var 'x_remaining_credit_limit_down'
        $val = $CurrentForm->hasValue("remaining_credit_limit_down") ? $CurrentForm->getValue("remaining_credit_limit_down") : $CurrentForm->getValue("x_remaining_credit_limit_down");
        if (!$this->remaining_credit_limit_down->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->remaining_credit_limit_down->Visible = false; // Disable update for API request
            } else {
                $this->remaining_credit_limit_down->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'fee_min' first before field var 'x_fee_min'
        $val = $CurrentForm->hasValue("fee_min") ? $CurrentForm->getValue("fee_min") : $CurrentForm->getValue("x_fee_min");
        if (!$this->fee_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fee_min->Visible = false; // Disable update for API request
            } else {
                $this->fee_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'monthly_payment_min' first before field var 'x_monthly_payment_min'
        $val = $CurrentForm->hasValue("monthly_payment_min") ? $CurrentForm->getValue("monthly_payment_min") : $CurrentForm->getValue("x_monthly_payment_min");
        if (!$this->monthly_payment_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monthly_payment_min->Visible = false; // Disable update for API request
            } else {
                $this->monthly_payment_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'annual_interest_buyer_model_min' first before field var 'x_annual_interest_buyer_model_min'
        $val = $CurrentForm->hasValue("annual_interest_buyer_model_min") ? $CurrentForm->getValue("annual_interest_buyer_model_min") : $CurrentForm->getValue("x_annual_interest_buyer_model_min");
        if (!$this->annual_interest_buyer_model_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->annual_interest_buyer_model_min->Visible = false; // Disable update for API request
            } else {
                $this->annual_interest_buyer_model_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'interest_down-payment_financing' first before field var 'x_interest_downpayment_financing'
        $val = $CurrentForm->hasValue("interest_down-payment_financing") ? $CurrentForm->getValue("interest_down-payment_financing") : $CurrentForm->getValue("x_interest_downpayment_financing");
        if (!$this->interest_downpayment_financing->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->interest_downpayment_financing->Visible = false; // Disable update for API request
            } else {
                $this->interest_downpayment_financing->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'monthly_expenses_min' first before field var 'x_monthly_expenses_min'
        $val = $CurrentForm->hasValue("monthly_expenses_min") ? $CurrentForm->getValue("monthly_expenses_min") : $CurrentForm->getValue("x_monthly_expenses_min");
        if (!$this->monthly_expenses_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monthly_expenses_min->Visible = false; // Disable update for API request
            } else {
                $this->monthly_expenses_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'average_rent_min' first before field var 'x_average_rent_min'
        $val = $CurrentForm->hasValue("average_rent_min") ? $CurrentForm->getValue("average_rent_min") : $CurrentForm->getValue("x_average_rent_min");
        if (!$this->average_rent_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->average_rent_min->Visible = false; // Disable update for API request
            } else {
                $this->average_rent_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'average_down_payment_min' first before field var 'x_average_down_payment_min'
        $val = $CurrentForm->hasValue("average_down_payment_min") ? $CurrentForm->getValue("average_down_payment_min") : $CurrentForm->getValue("x_average_down_payment_min");
        if (!$this->average_down_payment_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->average_down_payment_min->Visible = false; // Disable update for API request
            } else {
                $this->average_down_payment_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'installment_down_payment_loan' first before field var 'x_installment_down_payment_loan'
        $val = $CurrentForm->hasValue("installment_down_payment_loan") ? $CurrentForm->getValue("installment_down_payment_loan") : $CurrentForm->getValue("x_installment_down_payment_loan");
        if (!$this->installment_down_payment_loan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->installment_down_payment_loan->Visible = false; // Disable update for API request
            } else {
                $this->installment_down_payment_loan->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'price_invertor' first before field var 'x_price_invertor'
        $val = $CurrentForm->hasValue("price_invertor") ? $CurrentForm->getValue("price_invertor") : $CurrentForm->getValue("x_price_invertor");
        if (!$this->price_invertor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->price_invertor->Visible = false; // Disable update for API request
            } else {
                $this->price_invertor->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'expired_date' first before field var 'x_expired_date'
        $val = $CurrentForm->hasValue("expired_date") ? $CurrentForm->getValue("expired_date") : $CurrentForm->getValue("x_expired_date");
        if (!$this->expired_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->expired_date->Visible = false; // Disable update for API request
            } else {
                $this->expired_date->setFormValue($val, true, $validate);
            }
            $this->expired_date->CurrentValue = UnFormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern());
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

        // Check field name 'uip' first before field var 'x_uip'
        $val = $CurrentForm->hasValue("uip") ? $CurrentForm->getValue("uip") : $CurrentForm->getValue("x_uip");
        if (!$this->uip->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->uip->Visible = false; // Disable update for API request
            } else {
                $this->uip->setFormValue($val);
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

        // Check field name 'asset_id' first before field var 'x_asset_id'
        $val = $CurrentForm->hasValue("asset_id") ? $CurrentForm->getValue("asset_id") : $CurrentForm->getValue("x_asset_id");
		$this->floor_plan->OldUploadPath = './upload/floor_plan';
		$this->floor_plan->UploadPath = $this->floor_plan->OldUploadPath;
		$this->layout_unit->OldUploadPath = './upload/layout_unit';
		$this->layout_unit->UploadPath = $this->layout_unit->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->_title->CurrentValue = $this->_title->FormValue;
        $this->title_en->CurrentValue = $this->title_en->FormValue;
        $this->brand_id->CurrentValue = $this->brand_id->FormValue;
        $this->detail->CurrentValue = $this->detail->FormValue;
        $this->detail_en->CurrentValue = $this->detail_en->FormValue;
        $this->latitude->CurrentValue = $this->latitude->FormValue;
        $this->longitude->CurrentValue = $this->longitude->FormValue;
        $this->num_buildings->CurrentValue = $this->num_buildings->FormValue;
        $this->num_unit->CurrentValue = $this->num_unit->FormValue;
        $this->num_floors->CurrentValue = $this->num_floors->FormValue;
        $this->floors->CurrentValue = $this->floors->FormValue;
        $this->asset_year_developer->CurrentValue = $this->asset_year_developer->FormValue;
        $this->num_parking_spaces->CurrentValue = $this->num_parking_spaces->FormValue;
        $this->num_bathrooms->CurrentValue = $this->num_bathrooms->FormValue;
        $this->num_bedrooms->CurrentValue = $this->num_bedrooms->FormValue;
        $this->address->CurrentValue = $this->address->FormValue;
        $this->address_en->CurrentValue = $this->address_en->FormValue;
        $this->province_id->CurrentValue = $this->province_id->FormValue;
        $this->amphur_id->CurrentValue = $this->amphur_id->FormValue;
        $this->district_id->CurrentValue = $this->district_id->FormValue;
        $this->postcode->CurrentValue = $this->postcode->FormValue;
        $this->asset_website->CurrentValue = $this->asset_website->FormValue;
        $this->asset_review->CurrentValue = $this->asset_review->FormValue;
        $this->isactive->CurrentValue = $this->isactive->FormValue;
        $this->is_recommend->CurrentValue = $this->is_recommend->FormValue;
        $this->order_by->CurrentValue = $this->order_by->FormValue;
        $this->type_pay->CurrentValue = $this->type_pay->FormValue;
        $this->type_pay_2->CurrentValue = $this->type_pay_2->FormValue;
        $this->price_mark->CurrentValue = $this->price_mark->FormValue;
        $this->holding_property->CurrentValue = $this->holding_property->FormValue;
        $this->common_fee->CurrentValue = $this->common_fee->FormValue;
        $this->usable_area->CurrentValue = $this->usable_area->FormValue;
        $this->usable_area_price->CurrentValue = $this->usable_area_price->FormValue;
        $this->land_size->CurrentValue = $this->land_size->FormValue;
        $this->land_size_price->CurrentValue = $this->land_size_price->FormValue;
        $this->commission->CurrentValue = $this->commission->FormValue;
        $this->transfer_day_expenses_with_business_tax->CurrentValue = $this->transfer_day_expenses_with_business_tax->FormValue;
        $this->transfer_day_expenses_without_business_tax->CurrentValue = $this->transfer_day_expenses_without_business_tax->FormValue;
        $this->price->CurrentValue = $this->price->FormValue;
        $this->discount->CurrentValue = $this->discount->FormValue;
        $this->price_special->CurrentValue = $this->price_special->FormValue;
        $this->reservation_price_model_a->CurrentValue = $this->reservation_price_model_a->FormValue;
        $this->minimum_down_payment_model_a->CurrentValue = $this->minimum_down_payment_model_a->FormValue;
        $this->down_price_min_a->CurrentValue = $this->down_price_min_a->FormValue;
        $this->down_price_model_a->CurrentValue = $this->down_price_model_a->FormValue;
        $this->factor_monthly_installment_over_down->CurrentValue = $this->factor_monthly_installment_over_down->FormValue;
        $this->fee_a->CurrentValue = $this->fee_a->FormValue;
        $this->monthly_payment_buyer->CurrentValue = $this->monthly_payment_buyer->FormValue;
        $this->annual_interest_buyer_model_a->CurrentValue = $this->annual_interest_buyer_model_a->FormValue;
        $this->monthly_expenses_a->CurrentValue = $this->monthly_expenses_a->FormValue;
        $this->average_rent_a->CurrentValue = $this->average_rent_a->FormValue;
        $this->average_down_payment_a->CurrentValue = $this->average_down_payment_a->FormValue;
        $this->transfer_day_expenses_without_business_tax_max_min->CurrentValue = $this->transfer_day_expenses_without_business_tax_max_min->FormValue;
        $this->transfer_day_expenses_with_business_tax_max_min->CurrentValue = $this->transfer_day_expenses_with_business_tax_max_min->FormValue;
        $this->bank_appraisal_price->CurrentValue = $this->bank_appraisal_price->FormValue;
        $this->mark_up_price->CurrentValue = $this->mark_up_price->FormValue;
        $this->required_gap->CurrentValue = $this->required_gap->FormValue;
        $this->minimum_down_payment->CurrentValue = $this->minimum_down_payment->FormValue;
        $this->price_down_max->CurrentValue = $this->price_down_max->FormValue;
        $this->discount_max->CurrentValue = $this->discount_max->FormValue;
        $this->price_down_special_max->CurrentValue = $this->price_down_special_max->FormValue;
        $this->usable_area_price_max->CurrentValue = $this->usable_area_price_max->FormValue;
        $this->land_size_price_max->CurrentValue = $this->land_size_price_max->FormValue;
        $this->reservation_price_max->CurrentValue = $this->reservation_price_max->FormValue;
        $this->minimum_down_payment_max->CurrentValue = $this->minimum_down_payment_max->FormValue;
        $this->down_price_max->CurrentValue = $this->down_price_max->FormValue;
        $this->down_price->CurrentValue = $this->down_price->FormValue;
        $this->factor_monthly_installment_over_down_max->CurrentValue = $this->factor_monthly_installment_over_down_max->FormValue;
        $this->fee_max->CurrentValue = $this->fee_max->FormValue;
        $this->monthly_payment_max->CurrentValue = $this->monthly_payment_max->FormValue;
        $this->annual_interest_buyer->CurrentValue = $this->annual_interest_buyer->FormValue;
        $this->monthly_expense_max->CurrentValue = $this->monthly_expense_max->FormValue;
        $this->average_rent_max->CurrentValue = $this->average_rent_max->FormValue;
        $this->average_down_payment_max->CurrentValue = $this->average_down_payment_max->FormValue;
        $this->min_down->CurrentValue = $this->min_down->FormValue;
        $this->remaining_down->CurrentValue = $this->remaining_down->FormValue;
        $this->factor_financing->CurrentValue = $this->factor_financing->FormValue;
        $this->credit_limit_down->CurrentValue = $this->credit_limit_down->FormValue;
        $this->price_down_min->CurrentValue = $this->price_down_min->FormValue;
        $this->discount_min->CurrentValue = $this->discount_min->FormValue;
        $this->price_down_special_min->CurrentValue = $this->price_down_special_min->FormValue;
        $this->usable_area_price_min->CurrentValue = $this->usable_area_price_min->FormValue;
        $this->land_size_price_min->CurrentValue = $this->land_size_price_min->FormValue;
        $this->reservation_price_min->CurrentValue = $this->reservation_price_min->FormValue;
        $this->minimum_down_payment_min->CurrentValue = $this->minimum_down_payment_min->FormValue;
        $this->down_price_min->CurrentValue = $this->down_price_min->FormValue;
        $this->remaining_credit_limit_down->CurrentValue = $this->remaining_credit_limit_down->FormValue;
        $this->fee_min->CurrentValue = $this->fee_min->FormValue;
        $this->monthly_payment_min->CurrentValue = $this->monthly_payment_min->FormValue;
        $this->annual_interest_buyer_model_min->CurrentValue = $this->annual_interest_buyer_model_min->FormValue;
        $this->interest_downpayment_financing->CurrentValue = $this->interest_downpayment_financing->FormValue;
        $this->monthly_expenses_min->CurrentValue = $this->monthly_expenses_min->FormValue;
        $this->average_rent_min->CurrentValue = $this->average_rent_min->FormValue;
        $this->average_down_payment_min->CurrentValue = $this->average_down_payment_min->FormValue;
        $this->installment_down_payment_loan->CurrentValue = $this->installment_down_payment_loan->FormValue;
        $this->price_invertor->CurrentValue = $this->price_invertor->FormValue;
        $this->expired_date->CurrentValue = $this->expired_date->FormValue;
        $this->expired_date->CurrentValue = UnFormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern());
        $this->cdate->CurrentValue = $this->cdate->FormValue;
        $this->cdate->CurrentValue = UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
        $this->cuser->CurrentValue = $this->cuser->FormValue;
        $this->cip->CurrentValue = $this->cip->FormValue;
        $this->uip->CurrentValue = $this->uip->FormValue;
        $this->udate->CurrentValue = $this->udate->FormValue;
        $this->udate->CurrentValue = UnFormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern());
        $this->uuser->CurrentValue = $this->uuser->FormValue;
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
        $this->loadDefaultValues();
        $row = [];
        $row['asset_id'] = $this->asset_id->CurrentValue;
        $row['title'] = $this->_title->CurrentValue;
        $row['title_en'] = $this->title_en->CurrentValue;
        $row['brand_id'] = $this->brand_id->CurrentValue;
        $row['asset_short_detail'] = $this->asset_short_detail->CurrentValue;
        $row['asset_short_detail_en'] = $this->asset_short_detail_en->CurrentValue;
        $row['detail'] = $this->detail->CurrentValue;
        $row['detail_en'] = $this->detail_en->CurrentValue;
        $row['asset_code'] = $this->asset_code->CurrentValue;
        $row['asset_status'] = $this->asset_status->CurrentValue;
        $row['latitude'] = $this->latitude->CurrentValue;
        $row['longitude'] = $this->longitude->CurrentValue;
        $row['num_buildings'] = $this->num_buildings->CurrentValue;
        $row['num_unit'] = $this->num_unit->CurrentValue;
        $row['num_floors'] = $this->num_floors->CurrentValue;
        $row['floors'] = $this->floors->CurrentValue;
        $row['asset_year_developer'] = $this->asset_year_developer->CurrentValue;
        $row['num_parking_spaces'] = $this->num_parking_spaces->CurrentValue;
        $row['num_bathrooms'] = $this->num_bathrooms->CurrentValue;
        $row['num_bedrooms'] = $this->num_bedrooms->CurrentValue;
        $row['address'] = $this->address->CurrentValue;
        $row['address_en'] = $this->address_en->CurrentValue;
        $row['province_id'] = $this->province_id->CurrentValue;
        $row['amphur_id'] = $this->amphur_id->CurrentValue;
        $row['district_id'] = $this->district_id->CurrentValue;
        $row['postcode'] = $this->postcode->CurrentValue;
        $row['floor_plan'] = $this->floor_plan->Upload->DbValue;
        $row['layout_unit'] = $this->layout_unit->Upload->DbValue;
        $row['asset_website'] = $this->asset_website->CurrentValue;
        $row['asset_review'] = $this->asset_review->CurrentValue;
        $row['isactive'] = $this->isactive->CurrentValue;
        $row['is_recommend'] = $this->is_recommend->CurrentValue;
        $row['order_by'] = $this->order_by->CurrentValue;
        $row['type_pay'] = $this->type_pay->CurrentValue;
        $row['type_pay_2'] = $this->type_pay_2->CurrentValue;
        $row['price_mark'] = $this->price_mark->CurrentValue;
        $row['holding_property'] = $this->holding_property->CurrentValue;
        $row['common_fee'] = $this->common_fee->CurrentValue;
        $row['usable_area'] = $this->usable_area->CurrentValue;
        $row['usable_area_price'] = $this->usable_area_price->CurrentValue;
        $row['land_size'] = $this->land_size->CurrentValue;
        $row['land_size_price'] = $this->land_size_price->CurrentValue;
        $row['commission'] = $this->commission->CurrentValue;
        $row['transfer_day_expenses_with_business_tax'] = $this->transfer_day_expenses_with_business_tax->CurrentValue;
        $row['transfer_day_expenses_without_business_tax'] = $this->transfer_day_expenses_without_business_tax->CurrentValue;
        $row['price'] = $this->price->CurrentValue;
        $row['discount'] = $this->discount->CurrentValue;
        $row['price_special'] = $this->price_special->CurrentValue;
        $row['reservation_price_model_a'] = $this->reservation_price_model_a->CurrentValue;
        $row['minimum_down_payment_model_a'] = $this->minimum_down_payment_model_a->CurrentValue;
        $row['down_price_min_a'] = $this->down_price_min_a->CurrentValue;
        $row['down_price_model_a'] = $this->down_price_model_a->CurrentValue;
        $row['factor_monthly_installment_over_down'] = $this->factor_monthly_installment_over_down->CurrentValue;
        $row['fee_a'] = $this->fee_a->CurrentValue;
        $row['monthly_payment_buyer'] = $this->monthly_payment_buyer->CurrentValue;
        $row['annual_interest_buyer_model_a'] = $this->annual_interest_buyer_model_a->CurrentValue;
        $row['monthly_expenses_a'] = $this->monthly_expenses_a->CurrentValue;
        $row['average_rent_a'] = $this->average_rent_a->CurrentValue;
        $row['average_down_payment_a'] = $this->average_down_payment_a->CurrentValue;
        $row['transfer_day_expenses_without_business_tax_max_min'] = $this->transfer_day_expenses_without_business_tax_max_min->CurrentValue;
        $row['transfer_day_expenses_with_business_tax_max_min'] = $this->transfer_day_expenses_with_business_tax_max_min->CurrentValue;
        $row['bank_appraisal_price'] = $this->bank_appraisal_price->CurrentValue;
        $row['mark_up_price'] = $this->mark_up_price->CurrentValue;
        $row['required_gap'] = $this->required_gap->CurrentValue;
        $row['minimum_down_payment'] = $this->minimum_down_payment->CurrentValue;
        $row['price_down_max'] = $this->price_down_max->CurrentValue;
        $row['discount_max'] = $this->discount_max->CurrentValue;
        $row['price_down_special_max'] = $this->price_down_special_max->CurrentValue;
        $row['usable_area_price_max'] = $this->usable_area_price_max->CurrentValue;
        $row['land_size_price_max'] = $this->land_size_price_max->CurrentValue;
        $row['reservation_price_max'] = $this->reservation_price_max->CurrentValue;
        $row['minimum_down_payment_max'] = $this->minimum_down_payment_max->CurrentValue;
        $row['down_price_max'] = $this->down_price_max->CurrentValue;
        $row['down_price'] = $this->down_price->CurrentValue;
        $row['factor_monthly_installment_over_down_max'] = $this->factor_monthly_installment_over_down_max->CurrentValue;
        $row['fee_max'] = $this->fee_max->CurrentValue;
        $row['monthly_payment_max'] = $this->monthly_payment_max->CurrentValue;
        $row['annual_interest_buyer'] = $this->annual_interest_buyer->CurrentValue;
        $row['monthly_expense_max'] = $this->monthly_expense_max->CurrentValue;
        $row['average_rent_max'] = $this->average_rent_max->CurrentValue;
        $row['average_down_payment_max'] = $this->average_down_payment_max->CurrentValue;
        $row['min_down'] = $this->min_down->CurrentValue;
        $row['remaining_down'] = $this->remaining_down->CurrentValue;
        $row['factor_financing'] = $this->factor_financing->CurrentValue;
        $row['credit_limit_down'] = $this->credit_limit_down->CurrentValue;
        $row['price_down_min'] = $this->price_down_min->CurrentValue;
        $row['discount_min'] = $this->discount_min->CurrentValue;
        $row['price_down_special_min'] = $this->price_down_special_min->CurrentValue;
        $row['usable_area_price_min'] = $this->usable_area_price_min->CurrentValue;
        $row['land_size_price_min'] = $this->land_size_price_min->CurrentValue;
        $row['reservation_price_min'] = $this->reservation_price_min->CurrentValue;
        $row['minimum_down_payment_min'] = $this->minimum_down_payment_min->CurrentValue;
        $row['down_price_min'] = $this->down_price_min->CurrentValue;
        $row['remaining_credit_limit_down'] = $this->remaining_credit_limit_down->CurrentValue;
        $row['fee_min'] = $this->fee_min->CurrentValue;
        $row['monthly_payment_min'] = $this->monthly_payment_min->CurrentValue;
        $row['annual_interest_buyer_model_min'] = $this->annual_interest_buyer_model_min->CurrentValue;
        $row['interest_down-payment_financing'] = $this->interest_downpayment_financing->CurrentValue;
        $row['monthly_expenses_min'] = $this->monthly_expenses_min->CurrentValue;
        $row['average_rent_min'] = $this->average_rent_min->CurrentValue;
        $row['average_down_payment_min'] = $this->average_down_payment_min->CurrentValue;
        $row['installment_down_payment_loan'] = $this->installment_down_payment_loan->CurrentValue;
        $row['count_view'] = $this->count_view->CurrentValue;
        $row['count_favorite'] = $this->count_favorite->CurrentValue;
        $row['price_invertor'] = $this->price_invertor->CurrentValue;
        $row['installment_price'] = $this->installment_price->CurrentValue;
        $row['installment_all'] = $this->installment_all->CurrentValue;
        $row['master_calculator'] = $this->master_calculator->CurrentValue;
        $row['expired_date'] = $this->expired_date->CurrentValue;
        $row['tag'] = $this->tag->CurrentValue;
        $row['cdate'] = $this->cdate->CurrentValue;
        $row['cuser'] = $this->cuser->CurrentValue;
        $row['cip'] = $this->cip->CurrentValue;
        $row['uip'] = $this->uip->CurrentValue;
        $row['udate'] = $this->udate->CurrentValue;
        $row['uuser'] = $this->uuser->CurrentValue;
        $row['update_expired_key'] = $this->update_expired_key->CurrentValue;
        $row['update_expired_status'] = $this->update_expired_status->CurrentValue;
        $row['update_expired_date'] = $this->update_expired_date->CurrentValue;
        $row['update_expired_ip'] = $this->update_expired_ip->CurrentValue;
        $row['is_cancel_contract'] = $this->is_cancel_contract->CurrentValue;
        $row['cancel_contract_reason'] = $this->cancel_contract_reason->CurrentValue;
        $row['cancel_contract_reason_detail'] = $this->cancel_contract_reason_detail->CurrentValue;
        $row['cancel_contract_date'] = $this->cancel_contract_date->CurrentValue;
        $row['cancel_contract_user'] = $this->cancel_contract_user->CurrentValue;
        $row['cancel_contract_ip'] = $this->cancel_contract_ip->CurrentValue;
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

        // asset_id
        $this->asset_id->RowCssClass = "row";

        // title
        $this->_title->RowCssClass = "row";

        // title_en
        $this->title_en->RowCssClass = "row";

        // brand_id
        $this->brand_id->RowCssClass = "row";

        // asset_short_detail
        $this->asset_short_detail->RowCssClass = "row";

        // asset_short_detail_en
        $this->asset_short_detail_en->RowCssClass = "row";

        // detail
        $this->detail->RowCssClass = "row";

        // detail_en
        $this->detail_en->RowCssClass = "row";

        // asset_code
        $this->asset_code->RowCssClass = "row";

        // asset_status
        $this->asset_status->RowCssClass = "row";

        // latitude
        $this->latitude->RowCssClass = "row";

        // longitude
        $this->longitude->RowCssClass = "row";

        // num_buildings
        $this->num_buildings->RowCssClass = "row";

        // num_unit
        $this->num_unit->RowCssClass = "row";

        // num_floors
        $this->num_floors->RowCssClass = "row";

        // floors
        $this->floors->RowCssClass = "row";

        // asset_year_developer
        $this->asset_year_developer->RowCssClass = "row";

        // num_parking_spaces
        $this->num_parking_spaces->RowCssClass = "row";

        // num_bathrooms
        $this->num_bathrooms->RowCssClass = "row";

        // num_bedrooms
        $this->num_bedrooms->RowCssClass = "row";

        // address
        $this->address->RowCssClass = "row";

        // address_en
        $this->address_en->RowCssClass = "row";

        // province_id
        $this->province_id->RowCssClass = "row";

        // amphur_id
        $this->amphur_id->RowCssClass = "row";

        // district_id
        $this->district_id->RowCssClass = "row";

        // postcode
        $this->postcode->RowCssClass = "row";

        // floor_plan
        $this->floor_plan->RowCssClass = "row";

        // layout_unit
        $this->layout_unit->RowCssClass = "row";

        // asset_website
        $this->asset_website->RowCssClass = "row";

        // asset_review
        $this->asset_review->RowCssClass = "row";

        // isactive
        $this->isactive->RowCssClass = "row";

        // is_recommend
        $this->is_recommend->RowCssClass = "row";

        // order_by
        $this->order_by->RowCssClass = "row";

        // type_pay
        $this->type_pay->RowCssClass = "row";

        // type_pay_2
        $this->type_pay_2->RowCssClass = "row";

        // price_mark
        $this->price_mark->RowCssClass = "row";

        // holding_property
        $this->holding_property->RowCssClass = "row";

        // common_fee
        $this->common_fee->RowCssClass = "row";

        // usable_area
        $this->usable_area->RowCssClass = "row";

        // usable_area_price
        $this->usable_area_price->RowCssClass = "row";

        // land_size
        $this->land_size->RowCssClass = "row";

        // land_size_price
        $this->land_size_price->RowCssClass = "row";

        // commission
        $this->commission->RowCssClass = "row";

        // transfer_day_expenses_with_business_tax
        $this->transfer_day_expenses_with_business_tax->RowCssClass = "row";

        // transfer_day_expenses_without_business_tax
        $this->transfer_day_expenses_without_business_tax->RowCssClass = "row";

        // price
        $this->price->RowCssClass = "row";

        // discount
        $this->discount->RowCssClass = "row";

        // price_special
        $this->price_special->RowCssClass = "row";

        // reservation_price_model_a
        $this->reservation_price_model_a->RowCssClass = "row";

        // minimum_down_payment_model_a
        $this->minimum_down_payment_model_a->RowCssClass = "row";

        // down_price_min_a
        $this->down_price_min_a->RowCssClass = "row";

        // down_price_model_a
        $this->down_price_model_a->RowCssClass = "row";

        // factor_monthly_installment_over_down
        $this->factor_monthly_installment_over_down->RowCssClass = "row";

        // fee_a
        $this->fee_a->RowCssClass = "row";

        // monthly_payment_buyer
        $this->monthly_payment_buyer->RowCssClass = "row";

        // annual_interest_buyer_model_a
        $this->annual_interest_buyer_model_a->RowCssClass = "row";

        // monthly_expenses_a
        $this->monthly_expenses_a->RowCssClass = "row";

        // average_rent_a
        $this->average_rent_a->RowCssClass = "row";

        // average_down_payment_a
        $this->average_down_payment_a->RowCssClass = "row";

        // transfer_day_expenses_without_business_tax_max_min
        $this->transfer_day_expenses_without_business_tax_max_min->RowCssClass = "row";

        // transfer_day_expenses_with_business_tax_max_min
        $this->transfer_day_expenses_with_business_tax_max_min->RowCssClass = "row";

        // bank_appraisal_price
        $this->bank_appraisal_price->RowCssClass = "row";

        // mark_up_price
        $this->mark_up_price->RowCssClass = "row";

        // required_gap
        $this->required_gap->RowCssClass = "row";

        // minimum_down_payment
        $this->minimum_down_payment->RowCssClass = "row";

        // price_down_max
        $this->price_down_max->RowCssClass = "row";

        // discount_max
        $this->discount_max->RowCssClass = "row";

        // price_down_special_max
        $this->price_down_special_max->RowCssClass = "row";

        // usable_area_price_max
        $this->usable_area_price_max->RowCssClass = "row";

        // land_size_price_max
        $this->land_size_price_max->RowCssClass = "row";

        // reservation_price_max
        $this->reservation_price_max->RowCssClass = "row";

        // minimum_down_payment_max
        $this->minimum_down_payment_max->RowCssClass = "row";

        // down_price_max
        $this->down_price_max->RowCssClass = "row";

        // down_price
        $this->down_price->RowCssClass = "row";

        // factor_monthly_installment_over_down_max
        $this->factor_monthly_installment_over_down_max->RowCssClass = "row";

        // fee_max
        $this->fee_max->RowCssClass = "row";

        // monthly_payment_max
        $this->monthly_payment_max->RowCssClass = "row";

        // annual_interest_buyer
        $this->annual_interest_buyer->RowCssClass = "row";

        // monthly_expense_max
        $this->monthly_expense_max->RowCssClass = "row";

        // average_rent_max
        $this->average_rent_max->RowCssClass = "row";

        // average_down_payment_max
        $this->average_down_payment_max->RowCssClass = "row";

        // min_down
        $this->min_down->RowCssClass = "row";

        // remaining_down
        $this->remaining_down->RowCssClass = "row";

        // factor_financing
        $this->factor_financing->RowCssClass = "row";

        // credit_limit_down
        $this->credit_limit_down->RowCssClass = "row";

        // price_down_min
        $this->price_down_min->RowCssClass = "row";

        // discount_min
        $this->discount_min->RowCssClass = "row";

        // price_down_special_min
        $this->price_down_special_min->RowCssClass = "row";

        // usable_area_price_min
        $this->usable_area_price_min->RowCssClass = "row";

        // land_size_price_min
        $this->land_size_price_min->RowCssClass = "row";

        // reservation_price_min
        $this->reservation_price_min->RowCssClass = "row";

        // minimum_down_payment_min
        $this->minimum_down_payment_min->RowCssClass = "row";

        // down_price_min
        $this->down_price_min->RowCssClass = "row";

        // remaining_credit_limit_down
        $this->remaining_credit_limit_down->RowCssClass = "row";

        // fee_min
        $this->fee_min->RowCssClass = "row";

        // monthly_payment_min
        $this->monthly_payment_min->RowCssClass = "row";

        // annual_interest_buyer_model_min
        $this->annual_interest_buyer_model_min->RowCssClass = "row";

        // interest_down-payment_financing
        $this->interest_downpayment_financing->RowCssClass = "row";

        // monthly_expenses_min
        $this->monthly_expenses_min->RowCssClass = "row";

        // average_rent_min
        $this->average_rent_min->RowCssClass = "row";

        // average_down_payment_min
        $this->average_down_payment_min->RowCssClass = "row";

        // installment_down_payment_loan
        $this->installment_down_payment_loan->RowCssClass = "row";

        // count_view
        $this->count_view->RowCssClass = "row";

        // count_favorite
        $this->count_favorite->RowCssClass = "row";

        // price_invertor
        $this->price_invertor->RowCssClass = "row";

        // installment_price
        $this->installment_price->RowCssClass = "row";

        // installment_all
        $this->installment_all->RowCssClass = "row";

        // master_calculator
        $this->master_calculator->RowCssClass = "row";

        // expired_date
        $this->expired_date->RowCssClass = "row";

        // tag
        $this->tag->RowCssClass = "row";

        // cdate
        $this->cdate->RowCssClass = "row";

        // cuser
        $this->cuser->RowCssClass = "row";

        // cip
        $this->cip->RowCssClass = "row";

        // uip
        $this->uip->RowCssClass = "row";

        // udate
        $this->udate->RowCssClass = "row";

        // uuser
        $this->uuser->RowCssClass = "row";

        // update_expired_key
        $this->update_expired_key->RowCssClass = "row";

        // update_expired_status
        $this->update_expired_status->RowCssClass = "row";

        // update_expired_date
        $this->update_expired_date->RowCssClass = "row";

        // update_expired_ip
        $this->update_expired_ip->RowCssClass = "row";

        // is_cancel_contract
        $this->is_cancel_contract->RowCssClass = "row";

        // cancel_contract_reason
        $this->cancel_contract_reason->RowCssClass = "row";

        // cancel_contract_reason_detail
        $this->cancel_contract_reason_detail->RowCssClass = "row";

        // cancel_contract_date
        $this->cancel_contract_date->RowCssClass = "row";

        // cancel_contract_user
        $this->cancel_contract_user->RowCssClass = "row";

        // cancel_contract_ip
        $this->cancel_contract_ip->RowCssClass = "row";

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

            // cuser
            $this->cuser->ViewValue = $this->cuser->CurrentValue;
            $this->cuser->ViewValue = FormatNumber($this->cuser->ViewValue, $this->cuser->formatPattern());
            $this->cuser->ViewCustomAttributes = "";

            // cip
            $this->cip->ViewValue = $this->cip->CurrentValue;
            $this->cip->ViewCustomAttributes = "";

            // uip
            $this->uip->ViewValue = $this->uip->CurrentValue;
            $this->uip->ViewCustomAttributes = "";

            // udate
            $this->udate->ViewValue = $this->udate->CurrentValue;
            $this->udate->ViewValue = FormatDateTime($this->udate->ViewValue, $this->udate->formatPattern());
            $this->udate->ViewCustomAttributes = "";

            // uuser
            $this->uuser->ViewValue = $this->uuser->CurrentValue;
            $this->uuser->ViewValue = FormatNumber($this->uuser->ViewValue, $this->uuser->formatPattern());
            $this->uuser->ViewCustomAttributes = "";

            // title
            $this->_title->LinkCustomAttributes = "";
            $this->_title->HrefValue = "";

            // title_en
            $this->title_en->LinkCustomAttributes = "";
            $this->title_en->HrefValue = "";

            // brand_id
            $this->brand_id->LinkCustomAttributes = "";
            $this->brand_id->HrefValue = "";

            // detail
            $this->detail->LinkCustomAttributes = "";
            $this->detail->HrefValue = "";

            // detail_en
            $this->detail_en->LinkCustomAttributes = "";
            $this->detail_en->HrefValue = "";

            // latitude
            $this->latitude->LinkCustomAttributes = "";
            $this->latitude->HrefValue = "";

            // longitude
            $this->longitude->LinkCustomAttributes = "";
            $this->longitude->HrefValue = "";

            // num_buildings
            $this->num_buildings->LinkCustomAttributes = "";
            $this->num_buildings->HrefValue = "";

            // num_unit
            $this->num_unit->LinkCustomAttributes = "";
            $this->num_unit->HrefValue = "";

            // num_floors
            $this->num_floors->LinkCustomAttributes = "";
            $this->num_floors->HrefValue = "";

            // floors
            $this->floors->LinkCustomAttributes = "";
            $this->floors->HrefValue = "";

            // asset_year_developer
            $this->asset_year_developer->LinkCustomAttributes = "";
            $this->asset_year_developer->HrefValue = "";

            // num_parking_spaces
            $this->num_parking_spaces->LinkCustomAttributes = "";
            $this->num_parking_spaces->HrefValue = "";

            // num_bathrooms
            $this->num_bathrooms->LinkCustomAttributes = "";
            $this->num_bathrooms->HrefValue = "";

            // num_bedrooms
            $this->num_bedrooms->LinkCustomAttributes = "";
            $this->num_bedrooms->HrefValue = "";

            // address
            $this->address->LinkCustomAttributes = "";
            $this->address->HrefValue = "";

            // address_en
            $this->address_en->LinkCustomAttributes = "";
            $this->address_en->HrefValue = "";

            // province_id
            $this->province_id->LinkCustomAttributes = "";
            $this->province_id->HrefValue = "";

            // amphur_id
            $this->amphur_id->LinkCustomAttributes = "";
            $this->amphur_id->HrefValue = "";

            // district_id
            $this->district_id->LinkCustomAttributes = "";
            $this->district_id->HrefValue = "";

            // postcode
            $this->postcode->LinkCustomAttributes = "";
            $this->postcode->HrefValue = "";

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

            // asset_website
            $this->asset_website->LinkCustomAttributes = "";
            $this->asset_website->HrefValue = "";

            // asset_review
            $this->asset_review->LinkCustomAttributes = "";
            $this->asset_review->HrefValue = "";

            // isactive
            $this->isactive->LinkCustomAttributes = "";
            $this->isactive->HrefValue = "";

            // is_recommend
            $this->is_recommend->LinkCustomAttributes = "";
            $this->is_recommend->HrefValue = "";

            // order_by
            $this->order_by->LinkCustomAttributes = "";
            $this->order_by->HrefValue = "";

            // type_pay
            $this->type_pay->LinkCustomAttributes = "";
            $this->type_pay->HrefValue = "";

            // type_pay_2
            $this->type_pay_2->LinkCustomAttributes = "";
            $this->type_pay_2->HrefValue = "";

            // price_mark
            $this->price_mark->LinkCustomAttributes = "";
            $this->price_mark->HrefValue = "";

            // holding_property
            $this->holding_property->LinkCustomAttributes = "";
            $this->holding_property->HrefValue = "";

            // common_fee
            $this->common_fee->LinkCustomAttributes = "";
            $this->common_fee->HrefValue = "";

            // usable_area
            $this->usable_area->LinkCustomAttributes = "";
            $this->usable_area->HrefValue = "";

            // usable_area_price
            $this->usable_area_price->LinkCustomAttributes = "";
            $this->usable_area_price->HrefValue = "";

            // land_size
            $this->land_size->LinkCustomAttributes = "";
            $this->land_size->HrefValue = "";

            // land_size_price
            $this->land_size_price->LinkCustomAttributes = "";
            $this->land_size_price->HrefValue = "";

            // commission
            $this->commission->LinkCustomAttributes = "";
            $this->commission->HrefValue = "";

            // transfer_day_expenses_with_business_tax
            $this->transfer_day_expenses_with_business_tax->LinkCustomAttributes = "";
            $this->transfer_day_expenses_with_business_tax->HrefValue = "";

            // transfer_day_expenses_without_business_tax
            $this->transfer_day_expenses_without_business_tax->LinkCustomAttributes = "";
            $this->transfer_day_expenses_without_business_tax->HrefValue = "";

            // price
            $this->price->LinkCustomAttributes = "";
            $this->price->HrefValue = "";

            // discount
            $this->discount->LinkCustomAttributes = "";
            $this->discount->HrefValue = "";

            // price_special
            $this->price_special->LinkCustomAttributes = "";
            $this->price_special->HrefValue = "";

            // reservation_price_model_a
            $this->reservation_price_model_a->LinkCustomAttributes = "";
            $this->reservation_price_model_a->HrefValue = "";

            // minimum_down_payment_model_a
            $this->minimum_down_payment_model_a->LinkCustomAttributes = "";
            $this->minimum_down_payment_model_a->HrefValue = "";

            // down_price_min_a
            $this->down_price_min_a->LinkCustomAttributes = "";
            $this->down_price_min_a->HrefValue = "";

            // down_price_model_a
            $this->down_price_model_a->LinkCustomAttributes = "";
            $this->down_price_model_a->HrefValue = "";

            // factor_monthly_installment_over_down
            $this->factor_monthly_installment_over_down->LinkCustomAttributes = "";
            $this->factor_monthly_installment_over_down->HrefValue = "";

            // fee_a
            $this->fee_a->LinkCustomAttributes = "";
            $this->fee_a->HrefValue = "";

            // monthly_payment_buyer
            $this->monthly_payment_buyer->LinkCustomAttributes = "";
            $this->monthly_payment_buyer->HrefValue = "";

            // annual_interest_buyer_model_a
            $this->annual_interest_buyer_model_a->LinkCustomAttributes = "";
            $this->annual_interest_buyer_model_a->HrefValue = "";

            // monthly_expenses_a
            $this->monthly_expenses_a->LinkCustomAttributes = "";
            $this->monthly_expenses_a->HrefValue = "";

            // average_rent_a
            $this->average_rent_a->LinkCustomAttributes = "";
            $this->average_rent_a->HrefValue = "";

            // average_down_payment_a
            $this->average_down_payment_a->LinkCustomAttributes = "";
            $this->average_down_payment_a->HrefValue = "";

            // transfer_day_expenses_without_business_tax_max_min
            $this->transfer_day_expenses_without_business_tax_max_min->LinkCustomAttributes = "";
            $this->transfer_day_expenses_without_business_tax_max_min->HrefValue = "";

            // transfer_day_expenses_with_business_tax_max_min
            $this->transfer_day_expenses_with_business_tax_max_min->LinkCustomAttributes = "";
            $this->transfer_day_expenses_with_business_tax_max_min->HrefValue = "";

            // bank_appraisal_price
            $this->bank_appraisal_price->LinkCustomAttributes = "";
            $this->bank_appraisal_price->HrefValue = "";

            // mark_up_price
            $this->mark_up_price->LinkCustomAttributes = "";
            $this->mark_up_price->HrefValue = "";

            // required_gap
            $this->required_gap->LinkCustomAttributes = "";
            $this->required_gap->HrefValue = "";

            // minimum_down_payment
            $this->minimum_down_payment->LinkCustomAttributes = "";
            $this->minimum_down_payment->HrefValue = "";

            // price_down_max
            $this->price_down_max->LinkCustomAttributes = "";
            $this->price_down_max->HrefValue = "";

            // discount_max
            $this->discount_max->LinkCustomAttributes = "";
            $this->discount_max->HrefValue = "";

            // price_down_special_max
            $this->price_down_special_max->LinkCustomAttributes = "";
            $this->price_down_special_max->HrefValue = "";

            // usable_area_price_max
            $this->usable_area_price_max->LinkCustomAttributes = "";
            $this->usable_area_price_max->HrefValue = "";

            // land_size_price_max
            $this->land_size_price_max->LinkCustomAttributes = "";
            $this->land_size_price_max->HrefValue = "";

            // reservation_price_max
            $this->reservation_price_max->LinkCustomAttributes = "";
            $this->reservation_price_max->HrefValue = "";

            // minimum_down_payment_max
            $this->minimum_down_payment_max->LinkCustomAttributes = "";
            $this->minimum_down_payment_max->HrefValue = "";

            // down_price_max
            $this->down_price_max->LinkCustomAttributes = "";
            $this->down_price_max->HrefValue = "";

            // down_price
            $this->down_price->LinkCustomAttributes = "";
            $this->down_price->HrefValue = "";

            // factor_monthly_installment_over_down_max
            $this->factor_monthly_installment_over_down_max->LinkCustomAttributes = "";
            $this->factor_monthly_installment_over_down_max->HrefValue = "";

            // fee_max
            $this->fee_max->LinkCustomAttributes = "";
            $this->fee_max->HrefValue = "";

            // monthly_payment_max
            $this->monthly_payment_max->LinkCustomAttributes = "";
            $this->monthly_payment_max->HrefValue = "";

            // annual_interest_buyer
            $this->annual_interest_buyer->LinkCustomAttributes = "";
            $this->annual_interest_buyer->HrefValue = "";

            // monthly_expense_max
            $this->monthly_expense_max->LinkCustomAttributes = "";
            $this->monthly_expense_max->HrefValue = "";

            // average_rent_max
            $this->average_rent_max->LinkCustomAttributes = "";
            $this->average_rent_max->HrefValue = "";

            // average_down_payment_max
            $this->average_down_payment_max->LinkCustomAttributes = "";
            $this->average_down_payment_max->HrefValue = "";

            // min_down
            $this->min_down->LinkCustomAttributes = "";
            $this->min_down->HrefValue = "";

            // remaining_down
            $this->remaining_down->LinkCustomAttributes = "";
            $this->remaining_down->HrefValue = "";

            // factor_financing
            $this->factor_financing->LinkCustomAttributes = "";
            $this->factor_financing->HrefValue = "";

            // credit_limit_down
            $this->credit_limit_down->LinkCustomAttributes = "";
            $this->credit_limit_down->HrefValue = "";

            // price_down_min
            $this->price_down_min->LinkCustomAttributes = "";
            $this->price_down_min->HrefValue = "";

            // discount_min
            $this->discount_min->LinkCustomAttributes = "";
            $this->discount_min->HrefValue = "";

            // price_down_special_min
            $this->price_down_special_min->LinkCustomAttributes = "";
            $this->price_down_special_min->HrefValue = "";

            // usable_area_price_min
            $this->usable_area_price_min->LinkCustomAttributes = "";
            $this->usable_area_price_min->HrefValue = "";

            // land_size_price_min
            $this->land_size_price_min->LinkCustomAttributes = "";
            $this->land_size_price_min->HrefValue = "";

            // reservation_price_min
            $this->reservation_price_min->LinkCustomAttributes = "";
            $this->reservation_price_min->HrefValue = "";

            // minimum_down_payment_min
            $this->minimum_down_payment_min->LinkCustomAttributes = "";
            $this->minimum_down_payment_min->HrefValue = "";

            // down_price_min
            $this->down_price_min->LinkCustomAttributes = "";
            $this->down_price_min->HrefValue = "";

            // remaining_credit_limit_down
            $this->remaining_credit_limit_down->LinkCustomAttributes = "";
            $this->remaining_credit_limit_down->HrefValue = "";

            // fee_min
            $this->fee_min->LinkCustomAttributes = "";
            $this->fee_min->HrefValue = "";

            // monthly_payment_min
            $this->monthly_payment_min->LinkCustomAttributes = "";
            $this->monthly_payment_min->HrefValue = "";

            // annual_interest_buyer_model_min
            $this->annual_interest_buyer_model_min->LinkCustomAttributes = "";
            $this->annual_interest_buyer_model_min->HrefValue = "";

            // interest_down-payment_financing
            $this->interest_downpayment_financing->LinkCustomAttributes = "";
            $this->interest_downpayment_financing->HrefValue = "";

            // monthly_expenses_min
            $this->monthly_expenses_min->LinkCustomAttributes = "";
            $this->monthly_expenses_min->HrefValue = "";

            // average_rent_min
            $this->average_rent_min->LinkCustomAttributes = "";
            $this->average_rent_min->HrefValue = "";

            // average_down_payment_min
            $this->average_down_payment_min->LinkCustomAttributes = "";
            $this->average_down_payment_min->HrefValue = "";

            // installment_down_payment_loan
            $this->installment_down_payment_loan->LinkCustomAttributes = "";
            $this->installment_down_payment_loan->HrefValue = "";

            // price_invertor
            $this->price_invertor->LinkCustomAttributes = "";
            $this->price_invertor->HrefValue = "";

            // expired_date
            $this->expired_date->LinkCustomAttributes = "";
            $this->expired_date->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
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

            // brand_id
            $this->brand_id->setupEditAttributes();
            $this->brand_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->brand_id->CurrentValue));
            if ($curVal != "") {
                $this->brand_id->ViewValue = $this->brand_id->lookupCacheOption($curVal);
            } else {
                $this->brand_id->ViewValue = $this->brand_id->Lookup !== null && is_array($this->brand_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->brand_id->ViewValue !== null) { // Load from cache
                $this->brand_id->EditValue = array_values($this->brand_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`brand_id`" . SearchString("=", $this->brand_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return "`isactive` =1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->brand_id->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->brand_id->EditValue = $arwrk;
            }
            $this->brand_id->PlaceHolder = RemoveHtml($this->brand_id->caption());

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

            // latitude
            $this->latitude->setupEditAttributes();
            $this->latitude->EditCustomAttributes = "";
            if (!$this->latitude->Raw) {
                $this->latitude->CurrentValue = HtmlDecode($this->latitude->CurrentValue);
            }
            $this->latitude->EditValue = HtmlEncode($this->latitude->CurrentValue);
            $this->latitude->PlaceHolder = RemoveHtml($this->latitude->caption());

            // longitude
            $this->longitude->setupEditAttributes();
            $this->longitude->EditCustomAttributes = "";
            if (!$this->longitude->Raw) {
                $this->longitude->CurrentValue = HtmlDecode($this->longitude->CurrentValue);
            }
            $this->longitude->EditValue = HtmlEncode($this->longitude->CurrentValue);
            $this->longitude->PlaceHolder = RemoveHtml($this->longitude->caption());

            // num_buildings
            $this->num_buildings->setupEditAttributes();
            $this->num_buildings->EditCustomAttributes = "";
            $this->num_buildings->EditValue = HtmlEncode($this->num_buildings->CurrentValue);
            $this->num_buildings->PlaceHolder = RemoveHtml($this->num_buildings->caption());
            if (strval($this->num_buildings->EditValue) != "" && is_numeric($this->num_buildings->EditValue)) {
                $this->num_buildings->EditValue = FormatNumber($this->num_buildings->EditValue, null);
            }

            // num_unit
            $this->num_unit->setupEditAttributes();
            $this->num_unit->EditCustomAttributes = "";
            $this->num_unit->EditValue = HtmlEncode($this->num_unit->CurrentValue);
            $this->num_unit->PlaceHolder = RemoveHtml($this->num_unit->caption());
            if (strval($this->num_unit->EditValue) != "" && is_numeric($this->num_unit->EditValue)) {
                $this->num_unit->EditValue = FormatNumber($this->num_unit->EditValue, null);
            }

            // num_floors
            $this->num_floors->setupEditAttributes();
            $this->num_floors->EditCustomAttributes = "";
            $this->num_floors->EditValue = HtmlEncode($this->num_floors->CurrentValue);
            $this->num_floors->PlaceHolder = RemoveHtml($this->num_floors->caption());
            if (strval($this->num_floors->EditValue) != "" && is_numeric($this->num_floors->EditValue)) {
                $this->num_floors->EditValue = FormatNumber($this->num_floors->EditValue, null);
            }

            // floors
            $this->floors->setupEditAttributes();
            $this->floors->EditCustomAttributes = "";
            $this->floors->EditValue = HtmlEncode($this->floors->CurrentValue);
            $this->floors->PlaceHolder = RemoveHtml($this->floors->caption());
            if (strval($this->floors->EditValue) != "" && is_numeric($this->floors->EditValue)) {
                $this->floors->EditValue = FormatNumber($this->floors->EditValue, null);
            }

            // asset_year_developer
            $this->asset_year_developer->setupEditAttributes();
            $this->asset_year_developer->EditCustomAttributes = "";
            $this->asset_year_developer->EditValue = HtmlEncode($this->asset_year_developer->CurrentValue);
            $this->asset_year_developer->PlaceHolder = RemoveHtml($this->asset_year_developer->caption());
            if (strval($this->asset_year_developer->EditValue) != "" && is_numeric($this->asset_year_developer->EditValue)) {
                $this->asset_year_developer->EditValue = $this->asset_year_developer->EditValue;
            }

            // num_parking_spaces
            $this->num_parking_spaces->setupEditAttributes();
            $this->num_parking_spaces->EditCustomAttributes = "";
            if (!$this->num_parking_spaces->Raw) {
                $this->num_parking_spaces->CurrentValue = HtmlDecode($this->num_parking_spaces->CurrentValue);
            }
            $this->num_parking_spaces->EditValue = HtmlEncode($this->num_parking_spaces->CurrentValue);
            $this->num_parking_spaces->PlaceHolder = RemoveHtml($this->num_parking_spaces->caption());

            // num_bathrooms
            $this->num_bathrooms->setupEditAttributes();
            $this->num_bathrooms->EditCustomAttributes = "";
            if (!$this->num_bathrooms->Raw) {
                $this->num_bathrooms->CurrentValue = HtmlDecode($this->num_bathrooms->CurrentValue);
            }
            $this->num_bathrooms->EditValue = HtmlEncode($this->num_bathrooms->CurrentValue);
            $this->num_bathrooms->PlaceHolder = RemoveHtml($this->num_bathrooms->caption());

            // num_bedrooms
            $this->num_bedrooms->setupEditAttributes();
            $this->num_bedrooms->EditCustomAttributes = "";
            if (!$this->num_bedrooms->Raw) {
                $this->num_bedrooms->CurrentValue = HtmlDecode($this->num_bedrooms->CurrentValue);
            }
            $this->num_bedrooms->EditValue = HtmlEncode($this->num_bedrooms->CurrentValue);
            $this->num_bedrooms->PlaceHolder = RemoveHtml($this->num_bedrooms->caption());

            // address
            $this->address->setupEditAttributes();
            $this->address->EditCustomAttributes = "";
            $this->address->EditValue = HtmlEncode($this->address->CurrentValue);
            $this->address->PlaceHolder = RemoveHtml($this->address->caption());

            // address_en
            $this->address_en->setupEditAttributes();
            $this->address_en->EditCustomAttributes = "";
            $this->address_en->EditValue = HtmlEncode($this->address_en->CurrentValue);
            $this->address_en->PlaceHolder = RemoveHtml($this->address_en->caption());

            // province_id
            $this->province_id->setupEditAttributes();
            $this->province_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->province_id->CurrentValue));
            if ($curVal != "") {
                $this->province_id->ViewValue = $this->province_id->lookupCacheOption($curVal);
            } else {
                $this->province_id->ViewValue = $this->province_id->Lookup !== null && is_array($this->province_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->province_id->ViewValue !== null) { // Load from cache
                $this->province_id->EditValue = array_values($this->province_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`province_id`" . SearchString("=", $this->province_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->province_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->province_id->EditValue = $arwrk;
            }
            $this->province_id->PlaceHolder = RemoveHtml($this->province_id->caption());

            // amphur_id
            $this->amphur_id->setupEditAttributes();
            $this->amphur_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->amphur_id->CurrentValue));
            if ($curVal != "") {
                $this->amphur_id->ViewValue = $this->amphur_id->lookupCacheOption($curVal);
            } else {
                $this->amphur_id->ViewValue = $this->amphur_id->Lookup !== null && is_array($this->amphur_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->amphur_id->ViewValue !== null) { // Load from cache
                $this->amphur_id->EditValue = array_values($this->amphur_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`amphur_id`" . SearchString("=", $this->amphur_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->amphur_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->amphur_id->EditValue = $arwrk;
            }
            $this->amphur_id->PlaceHolder = RemoveHtml($this->amphur_id->caption());

            // district_id
            $this->district_id->setupEditAttributes();
            $this->district_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->district_id->CurrentValue));
            if ($curVal != "") {
                $this->district_id->ViewValue = $this->district_id->lookupCacheOption($curVal);
            } else {
                $this->district_id->ViewValue = $this->district_id->Lookup !== null && is_array($this->district_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->district_id->ViewValue !== null) { // Load from cache
                $this->district_id->EditValue = array_values($this->district_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`subdistrict_id`" . SearchString("=", $this->district_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->district_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->district_id->EditValue = $arwrk;
            }
            $this->district_id->PlaceHolder = RemoveHtml($this->district_id->caption());

            // postcode
            $this->postcode->setupEditAttributes();
            $this->postcode->EditCustomAttributes = "";
            $this->postcode->EditValue = HtmlEncode($this->postcode->CurrentValue);
            $this->postcode->PlaceHolder = RemoveHtml($this->postcode->caption());
            if (strval($this->postcode->EditValue) != "" && is_numeric($this->postcode->EditValue)) {
                $this->postcode->EditValue = $this->postcode->EditValue;
            }

            // floor_plan
            $this->floor_plan->setupEditAttributes();
            $this->floor_plan->EditCustomAttributes = "";
            $this->floor_plan->UploadPath = './upload/floor_plan';
            if (!EmptyValue($this->floor_plan->Upload->DbValue)) {
                $this->floor_plan->ImageWidth = 100;
                $this->floor_plan->ImageHeight = 100;
                $this->floor_plan->ImageAlt = $this->floor_plan->alt();
                $this->floor_plan->ImageCssClass = "ew-image";
                $this->floor_plan->EditValue = $this->floor_plan->Upload->DbValue;
            } else {
                $this->floor_plan->EditValue = "";
            }
            if (!EmptyValue($this->floor_plan->CurrentValue)) {
                $this->floor_plan->Upload->FileName = $this->floor_plan->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->floor_plan);
            }

            // layout_unit
            $this->layout_unit->setupEditAttributes();
            $this->layout_unit->EditCustomAttributes = "";
            $this->layout_unit->UploadPath = './upload/layout_unit';
            if (!EmptyValue($this->layout_unit->Upload->DbValue)) {
                $this->layout_unit->ImageWidth = 100;
                $this->layout_unit->ImageHeight = 100;
                $this->layout_unit->ImageAlt = $this->layout_unit->alt();
                $this->layout_unit->ImageCssClass = "ew-image";
                $this->layout_unit->EditValue = $this->layout_unit->Upload->DbValue;
            } else {
                $this->layout_unit->EditValue = "";
            }
            if (!EmptyValue($this->layout_unit->CurrentValue)) {
                $this->layout_unit->Upload->FileName = $this->layout_unit->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->layout_unit);
            }

            // asset_website
            $this->asset_website->setupEditAttributes();
            $this->asset_website->EditCustomAttributes = "";
            $this->asset_website->EditValue = HtmlEncode($this->asset_website->CurrentValue);
            $this->asset_website->PlaceHolder = RemoveHtml($this->asset_website->caption());

            // asset_review
            $this->asset_review->setupEditAttributes();
            $this->asset_review->EditCustomAttributes = "";
            $this->asset_review->EditValue = HtmlEncode($this->asset_review->CurrentValue);
            $this->asset_review->PlaceHolder = RemoveHtml($this->asset_review->caption());

            // isactive
            $this->isactive->EditCustomAttributes = "";
            $this->isactive->EditValue = $this->isactive->options(false);
            $this->isactive->PlaceHolder = RemoveHtml($this->isactive->caption());

            // is_recommend
            $this->is_recommend->EditCustomAttributes = "";
            $this->is_recommend->EditValue = $this->is_recommend->options(false);
            $this->is_recommend->PlaceHolder = RemoveHtml($this->is_recommend->caption());

            // order_by
            $this->order_by->setupEditAttributes();
            $this->order_by->EditCustomAttributes = "";
            $this->order_by->EditValue = HtmlEncode($this->order_by->CurrentValue);
            $this->order_by->PlaceHolder = RemoveHtml($this->order_by->caption());
            if (strval($this->order_by->EditValue) != "" && is_numeric($this->order_by->EditValue)) {
                $this->order_by->EditValue = FormatNumber($this->order_by->EditValue, null);
            }

            // type_pay
            $this->type_pay->EditCustomAttributes = "";
            $this->type_pay->EditValue = $this->type_pay->options(false);
            $this->type_pay->PlaceHolder = RemoveHtml($this->type_pay->caption());

            // type_pay_2
            $this->type_pay_2->EditCustomAttributes = "";
            $this->type_pay_2->EditValue = $this->type_pay_2->options(false);
            $this->type_pay_2->PlaceHolder = RemoveHtml($this->type_pay_2->caption());

            // price_mark
            $this->price_mark->setupEditAttributes();
            $this->price_mark->EditCustomAttributes = "";
            $this->price_mark->EditValue = HtmlEncode($this->price_mark->CurrentValue);
            $this->price_mark->PlaceHolder = RemoveHtml($this->price_mark->caption());
            if (strval($this->price_mark->EditValue) != "" && is_numeric($this->price_mark->EditValue)) {
                $this->price_mark->EditValue = FormatNumber($this->price_mark->EditValue, null);
            }

            // holding_property
            $this->holding_property->EditCustomAttributes = "";
            $this->holding_property->EditValue = $this->holding_property->options(false);
            $this->holding_property->PlaceHolder = RemoveHtml($this->holding_property->caption());

            // common_fee
            $this->common_fee->setupEditAttributes();
            $this->common_fee->EditCustomAttributes = "";
            $this->common_fee->EditValue = HtmlEncode($this->common_fee->CurrentValue);
            $this->common_fee->PlaceHolder = RemoveHtml($this->common_fee->caption());
            if (strval($this->common_fee->EditValue) != "" && is_numeric($this->common_fee->EditValue)) {
                $this->common_fee->EditValue = FormatNumber($this->common_fee->EditValue, null);
            }

            // usable_area
            $this->usable_area->setupEditAttributes();
            $this->usable_area->EditCustomAttributes = "";
            if (!$this->usable_area->Raw) {
                $this->usable_area->CurrentValue = HtmlDecode($this->usable_area->CurrentValue);
            }
            $this->usable_area->EditValue = HtmlEncode($this->usable_area->CurrentValue);
            $this->usable_area->PlaceHolder = RemoveHtml($this->usable_area->caption());

            // usable_area_price
            $this->usable_area_price->setupEditAttributes();
            $this->usable_area_price->EditCustomAttributes = "";
            $this->usable_area_price->EditValue = HtmlEncode($this->usable_area_price->CurrentValue);
            $this->usable_area_price->PlaceHolder = RemoveHtml($this->usable_area_price->caption());
            if (strval($this->usable_area_price->EditValue) != "" && is_numeric($this->usable_area_price->EditValue)) {
                $this->usable_area_price->EditValue = FormatNumber($this->usable_area_price->EditValue, null);
            }

            // land_size
            $this->land_size->setupEditAttributes();
            $this->land_size->EditCustomAttributes = "";
            if (!$this->land_size->Raw) {
                $this->land_size->CurrentValue = HtmlDecode($this->land_size->CurrentValue);
            }
            $this->land_size->EditValue = HtmlEncode($this->land_size->CurrentValue);
            $this->land_size->PlaceHolder = RemoveHtml($this->land_size->caption());

            // land_size_price
            $this->land_size_price->setupEditAttributes();
            $this->land_size_price->EditCustomAttributes = "";
            $this->land_size_price->EditValue = HtmlEncode($this->land_size_price->CurrentValue);
            $this->land_size_price->PlaceHolder = RemoveHtml($this->land_size_price->caption());
            if (strval($this->land_size_price->EditValue) != "" && is_numeric($this->land_size_price->EditValue)) {
                $this->land_size_price->EditValue = FormatNumber($this->land_size_price->EditValue, null);
            }

            // commission
            $this->commission->setupEditAttributes();
            $this->commission->EditCustomAttributes = "";
            $this->commission->EditValue = HtmlEncode($this->commission->CurrentValue);
            $this->commission->PlaceHolder = RemoveHtml($this->commission->caption());
            if (strval($this->commission->EditValue) != "" && is_numeric($this->commission->EditValue)) {
                $this->commission->EditValue = FormatNumber($this->commission->EditValue, null);
            }

            // transfer_day_expenses_with_business_tax
            $this->transfer_day_expenses_with_business_tax->setupEditAttributes();
            $this->transfer_day_expenses_with_business_tax->EditCustomAttributes = "";
            $this->transfer_day_expenses_with_business_tax->EditValue = HtmlEncode($this->transfer_day_expenses_with_business_tax->CurrentValue);
            $this->transfer_day_expenses_with_business_tax->PlaceHolder = RemoveHtml($this->transfer_day_expenses_with_business_tax->caption());
            if (strval($this->transfer_day_expenses_with_business_tax->EditValue) != "" && is_numeric($this->transfer_day_expenses_with_business_tax->EditValue)) {
                $this->transfer_day_expenses_with_business_tax->EditValue = FormatNumber($this->transfer_day_expenses_with_business_tax->EditValue, null);
            }

            // transfer_day_expenses_without_business_tax
            $this->transfer_day_expenses_without_business_tax->setupEditAttributes();
            $this->transfer_day_expenses_without_business_tax->EditCustomAttributes = "";
            $this->transfer_day_expenses_without_business_tax->EditValue = HtmlEncode($this->transfer_day_expenses_without_business_tax->CurrentValue);
            $this->transfer_day_expenses_without_business_tax->PlaceHolder = RemoveHtml($this->transfer_day_expenses_without_business_tax->caption());
            if (strval($this->transfer_day_expenses_without_business_tax->EditValue) != "" && is_numeric($this->transfer_day_expenses_without_business_tax->EditValue)) {
                $this->transfer_day_expenses_without_business_tax->EditValue = FormatNumber($this->transfer_day_expenses_without_business_tax->EditValue, null);
            }

            // price
            $this->price->setupEditAttributes();
            $this->price->EditCustomAttributes = "";
            $this->price->EditValue = HtmlEncode($this->price->CurrentValue);
            $this->price->PlaceHolder = RemoveHtml($this->price->caption());
            if (strval($this->price->EditValue) != "" && is_numeric($this->price->EditValue)) {
                $this->price->EditValue = FormatNumber($this->price->EditValue, null);
            }

            // discount
            $this->discount->setupEditAttributes();
            $this->discount->EditCustomAttributes = "";
            $this->discount->EditValue = HtmlEncode($this->discount->CurrentValue);
            $this->discount->PlaceHolder = RemoveHtml($this->discount->caption());
            if (strval($this->discount->EditValue) != "" && is_numeric($this->discount->EditValue)) {
                $this->discount->EditValue = FormatNumber($this->discount->EditValue, null);
            }

            // price_special
            $this->price_special->setupEditAttributes();
            $this->price_special->EditCustomAttributes = "";
            $this->price_special->EditValue = HtmlEncode($this->price_special->CurrentValue);
            $this->price_special->PlaceHolder = RemoveHtml($this->price_special->caption());
            if (strval($this->price_special->EditValue) != "" && is_numeric($this->price_special->EditValue)) {
                $this->price_special->EditValue = FormatNumber($this->price_special->EditValue, null);
            }

            // reservation_price_model_a
            $this->reservation_price_model_a->setupEditAttributes();
            $this->reservation_price_model_a->EditCustomAttributes = "";
            $this->reservation_price_model_a->EditValue = HtmlEncode($this->reservation_price_model_a->CurrentValue);
            $this->reservation_price_model_a->PlaceHolder = RemoveHtml($this->reservation_price_model_a->caption());
            if (strval($this->reservation_price_model_a->EditValue) != "" && is_numeric($this->reservation_price_model_a->EditValue)) {
                $this->reservation_price_model_a->EditValue = FormatNumber($this->reservation_price_model_a->EditValue, null);
            }

            // minimum_down_payment_model_a
            $this->minimum_down_payment_model_a->setupEditAttributes();
            $this->minimum_down_payment_model_a->EditCustomAttributes = "";
            $this->minimum_down_payment_model_a->EditValue = HtmlEncode($this->minimum_down_payment_model_a->CurrentValue);
            $this->minimum_down_payment_model_a->PlaceHolder = RemoveHtml($this->minimum_down_payment_model_a->caption());
            if (strval($this->minimum_down_payment_model_a->EditValue) != "" && is_numeric($this->minimum_down_payment_model_a->EditValue)) {
                $this->minimum_down_payment_model_a->EditValue = FormatNumber($this->minimum_down_payment_model_a->EditValue, null);
            }

            // down_price_min_a
            $this->down_price_min_a->setupEditAttributes();
            $this->down_price_min_a->EditCustomAttributes = "";
            $this->down_price_min_a->EditValue = HtmlEncode($this->down_price_min_a->CurrentValue);
            $this->down_price_min_a->PlaceHolder = RemoveHtml($this->down_price_min_a->caption());
            if (strval($this->down_price_min_a->EditValue) != "" && is_numeric($this->down_price_min_a->EditValue)) {
                $this->down_price_min_a->EditValue = FormatNumber($this->down_price_min_a->EditValue, null);
            }

            // down_price_model_a
            $this->down_price_model_a->setupEditAttributes();
            $this->down_price_model_a->EditCustomAttributes = "";
            $this->down_price_model_a->EditValue = HtmlEncode($this->down_price_model_a->CurrentValue);
            $this->down_price_model_a->PlaceHolder = RemoveHtml($this->down_price_model_a->caption());
            if (strval($this->down_price_model_a->EditValue) != "" && is_numeric($this->down_price_model_a->EditValue)) {
                $this->down_price_model_a->EditValue = FormatNumber($this->down_price_model_a->EditValue, null);
            }

            // factor_monthly_installment_over_down
            $this->factor_monthly_installment_over_down->setupEditAttributes();
            $this->factor_monthly_installment_over_down->EditCustomAttributes = "";
            $this->factor_monthly_installment_over_down->EditValue = HtmlEncode($this->factor_monthly_installment_over_down->CurrentValue);
            $this->factor_monthly_installment_over_down->PlaceHolder = RemoveHtml($this->factor_monthly_installment_over_down->caption());
            if (strval($this->factor_monthly_installment_over_down->EditValue) != "" && is_numeric($this->factor_monthly_installment_over_down->EditValue)) {
                $this->factor_monthly_installment_over_down->EditValue = FormatNumber($this->factor_monthly_installment_over_down->EditValue, null);
            }

            // fee_a
            $this->fee_a->setupEditAttributes();
            $this->fee_a->EditCustomAttributes = "";
            $this->fee_a->EditValue = HtmlEncode($this->fee_a->CurrentValue);
            $this->fee_a->PlaceHolder = RemoveHtml($this->fee_a->caption());
            if (strval($this->fee_a->EditValue) != "" && is_numeric($this->fee_a->EditValue)) {
                $this->fee_a->EditValue = FormatNumber($this->fee_a->EditValue, null);
            }

            // monthly_payment_buyer
            $this->monthly_payment_buyer->setupEditAttributes();
            $this->monthly_payment_buyer->EditCustomAttributes = "";
            $this->monthly_payment_buyer->EditValue = HtmlEncode($this->monthly_payment_buyer->CurrentValue);
            $this->monthly_payment_buyer->PlaceHolder = RemoveHtml($this->monthly_payment_buyer->caption());
            if (strval($this->monthly_payment_buyer->EditValue) != "" && is_numeric($this->monthly_payment_buyer->EditValue)) {
                $this->monthly_payment_buyer->EditValue = FormatNumber($this->monthly_payment_buyer->EditValue, null);
            }

            // annual_interest_buyer_model_a
            $this->annual_interest_buyer_model_a->setupEditAttributes();
            $this->annual_interest_buyer_model_a->EditCustomAttributes = "";
            $this->annual_interest_buyer_model_a->EditValue = HtmlEncode($this->annual_interest_buyer_model_a->CurrentValue);
            $this->annual_interest_buyer_model_a->PlaceHolder = RemoveHtml($this->annual_interest_buyer_model_a->caption());
            if (strval($this->annual_interest_buyer_model_a->EditValue) != "" && is_numeric($this->annual_interest_buyer_model_a->EditValue)) {
                $this->annual_interest_buyer_model_a->EditValue = FormatNumber($this->annual_interest_buyer_model_a->EditValue, null);
            }

            // monthly_expenses_a
            $this->monthly_expenses_a->setupEditAttributes();
            $this->monthly_expenses_a->EditCustomAttributes = "";
            $this->monthly_expenses_a->EditValue = HtmlEncode($this->monthly_expenses_a->CurrentValue);
            $this->monthly_expenses_a->PlaceHolder = RemoveHtml($this->monthly_expenses_a->caption());
            if (strval($this->monthly_expenses_a->EditValue) != "" && is_numeric($this->monthly_expenses_a->EditValue)) {
                $this->monthly_expenses_a->EditValue = FormatNumber($this->monthly_expenses_a->EditValue, null);
            }

            // average_rent_a
            $this->average_rent_a->setupEditAttributes();
            $this->average_rent_a->EditCustomAttributes = "";
            $this->average_rent_a->EditValue = HtmlEncode($this->average_rent_a->CurrentValue);
            $this->average_rent_a->PlaceHolder = RemoveHtml($this->average_rent_a->caption());
            if (strval($this->average_rent_a->EditValue) != "" && is_numeric($this->average_rent_a->EditValue)) {
                $this->average_rent_a->EditValue = FormatNumber($this->average_rent_a->EditValue, null);
            }

            // average_down_payment_a
            $this->average_down_payment_a->setupEditAttributes();
            $this->average_down_payment_a->EditCustomAttributes = "";
            $this->average_down_payment_a->EditValue = HtmlEncode($this->average_down_payment_a->CurrentValue);
            $this->average_down_payment_a->PlaceHolder = RemoveHtml($this->average_down_payment_a->caption());
            if (strval($this->average_down_payment_a->EditValue) != "" && is_numeric($this->average_down_payment_a->EditValue)) {
                $this->average_down_payment_a->EditValue = FormatNumber($this->average_down_payment_a->EditValue, null);
            }

            // transfer_day_expenses_without_business_tax_max_min
            $this->transfer_day_expenses_without_business_tax_max_min->setupEditAttributes();
            $this->transfer_day_expenses_without_business_tax_max_min->EditCustomAttributes = "";
            $this->transfer_day_expenses_without_business_tax_max_min->EditValue = HtmlEncode($this->transfer_day_expenses_without_business_tax_max_min->CurrentValue);
            $this->transfer_day_expenses_without_business_tax_max_min->PlaceHolder = RemoveHtml($this->transfer_day_expenses_without_business_tax_max_min->caption());
            if (strval($this->transfer_day_expenses_without_business_tax_max_min->EditValue) != "" && is_numeric($this->transfer_day_expenses_without_business_tax_max_min->EditValue)) {
                $this->transfer_day_expenses_without_business_tax_max_min->EditValue = FormatNumber($this->transfer_day_expenses_without_business_tax_max_min->EditValue, null);
            }

            // transfer_day_expenses_with_business_tax_max_min
            $this->transfer_day_expenses_with_business_tax_max_min->setupEditAttributes();
            $this->transfer_day_expenses_with_business_tax_max_min->EditCustomAttributes = "";
            $this->transfer_day_expenses_with_business_tax_max_min->EditValue = HtmlEncode($this->transfer_day_expenses_with_business_tax_max_min->CurrentValue);
            $this->transfer_day_expenses_with_business_tax_max_min->PlaceHolder = RemoveHtml($this->transfer_day_expenses_with_business_tax_max_min->caption());
            if (strval($this->transfer_day_expenses_with_business_tax_max_min->EditValue) != "" && is_numeric($this->transfer_day_expenses_with_business_tax_max_min->EditValue)) {
                $this->transfer_day_expenses_with_business_tax_max_min->EditValue = FormatNumber($this->transfer_day_expenses_with_business_tax_max_min->EditValue, null);
            }

            // bank_appraisal_price
            $this->bank_appraisal_price->setupEditAttributes();
            $this->bank_appraisal_price->EditCustomAttributes = "";
            $this->bank_appraisal_price->EditValue = HtmlEncode($this->bank_appraisal_price->CurrentValue);
            $this->bank_appraisal_price->PlaceHolder = RemoveHtml($this->bank_appraisal_price->caption());
            if (strval($this->bank_appraisal_price->EditValue) != "" && is_numeric($this->bank_appraisal_price->EditValue)) {
                $this->bank_appraisal_price->EditValue = FormatNumber($this->bank_appraisal_price->EditValue, null);
            }

            // mark_up_price
            $this->mark_up_price->setupEditAttributes();
            $this->mark_up_price->EditCustomAttributes = "";
            $this->mark_up_price->EditValue = HtmlEncode($this->mark_up_price->CurrentValue);
            $this->mark_up_price->PlaceHolder = RemoveHtml($this->mark_up_price->caption());
            if (strval($this->mark_up_price->EditValue) != "" && is_numeric($this->mark_up_price->EditValue)) {
                $this->mark_up_price->EditValue = FormatNumber($this->mark_up_price->EditValue, null);
            }

            // required_gap
            $this->required_gap->setupEditAttributes();
            $this->required_gap->EditCustomAttributes = "";
            $this->required_gap->EditValue = HtmlEncode($this->required_gap->CurrentValue);
            $this->required_gap->PlaceHolder = RemoveHtml($this->required_gap->caption());
            if (strval($this->required_gap->EditValue) != "" && is_numeric($this->required_gap->EditValue)) {
                $this->required_gap->EditValue = FormatNumber($this->required_gap->EditValue, null);
            }

            // minimum_down_payment
            $this->minimum_down_payment->setupEditAttributes();
            $this->minimum_down_payment->EditCustomAttributes = "";
            $this->minimum_down_payment->EditValue = HtmlEncode($this->minimum_down_payment->CurrentValue);
            $this->minimum_down_payment->PlaceHolder = RemoveHtml($this->minimum_down_payment->caption());
            if (strval($this->minimum_down_payment->EditValue) != "" && is_numeric($this->minimum_down_payment->EditValue)) {
                $this->minimum_down_payment->EditValue = FormatNumber($this->minimum_down_payment->EditValue, null);
            }

            // price_down_max
            $this->price_down_max->setupEditAttributes();
            $this->price_down_max->EditCustomAttributes = "";
            $this->price_down_max->EditValue = HtmlEncode($this->price_down_max->CurrentValue);
            $this->price_down_max->PlaceHolder = RemoveHtml($this->price_down_max->caption());
            if (strval($this->price_down_max->EditValue) != "" && is_numeric($this->price_down_max->EditValue)) {
                $this->price_down_max->EditValue = FormatNumber($this->price_down_max->EditValue, null);
            }

            // discount_max
            $this->discount_max->setupEditAttributes();
            $this->discount_max->EditCustomAttributes = "";
            $this->discount_max->EditValue = HtmlEncode($this->discount_max->CurrentValue);
            $this->discount_max->PlaceHolder = RemoveHtml($this->discount_max->caption());
            if (strval($this->discount_max->EditValue) != "" && is_numeric($this->discount_max->EditValue)) {
                $this->discount_max->EditValue = FormatNumber($this->discount_max->EditValue, null);
            }

            // price_down_special_max
            $this->price_down_special_max->setupEditAttributes();
            $this->price_down_special_max->EditCustomAttributes = "";
            $this->price_down_special_max->EditValue = HtmlEncode($this->price_down_special_max->CurrentValue);
            $this->price_down_special_max->PlaceHolder = RemoveHtml($this->price_down_special_max->caption());
            if (strval($this->price_down_special_max->EditValue) != "" && is_numeric($this->price_down_special_max->EditValue)) {
                $this->price_down_special_max->EditValue = FormatNumber($this->price_down_special_max->EditValue, null);
            }

            // usable_area_price_max
            $this->usable_area_price_max->setupEditAttributes();
            $this->usable_area_price_max->EditCustomAttributes = "";
            $this->usable_area_price_max->EditValue = HtmlEncode($this->usable_area_price_max->CurrentValue);
            $this->usable_area_price_max->PlaceHolder = RemoveHtml($this->usable_area_price_max->caption());
            if (strval($this->usable_area_price_max->EditValue) != "" && is_numeric($this->usable_area_price_max->EditValue)) {
                $this->usable_area_price_max->EditValue = FormatNumber($this->usable_area_price_max->EditValue, null);
            }

            // land_size_price_max
            $this->land_size_price_max->setupEditAttributes();
            $this->land_size_price_max->EditCustomAttributes = "";
            $this->land_size_price_max->EditValue = HtmlEncode($this->land_size_price_max->CurrentValue);
            $this->land_size_price_max->PlaceHolder = RemoveHtml($this->land_size_price_max->caption());
            if (strval($this->land_size_price_max->EditValue) != "" && is_numeric($this->land_size_price_max->EditValue)) {
                $this->land_size_price_max->EditValue = FormatNumber($this->land_size_price_max->EditValue, null);
            }

            // reservation_price_max
            $this->reservation_price_max->setupEditAttributes();
            $this->reservation_price_max->EditCustomAttributes = "";
            $this->reservation_price_max->EditValue = HtmlEncode($this->reservation_price_max->CurrentValue);
            $this->reservation_price_max->PlaceHolder = RemoveHtml($this->reservation_price_max->caption());
            if (strval($this->reservation_price_max->EditValue) != "" && is_numeric($this->reservation_price_max->EditValue)) {
                $this->reservation_price_max->EditValue = FormatNumber($this->reservation_price_max->EditValue, null);
            }

            // minimum_down_payment_max
            $this->minimum_down_payment_max->setupEditAttributes();
            $this->minimum_down_payment_max->EditCustomAttributes = "";
            $this->minimum_down_payment_max->EditValue = HtmlEncode($this->minimum_down_payment_max->CurrentValue);
            $this->minimum_down_payment_max->PlaceHolder = RemoveHtml($this->minimum_down_payment_max->caption());
            if (strval($this->minimum_down_payment_max->EditValue) != "" && is_numeric($this->minimum_down_payment_max->EditValue)) {
                $this->minimum_down_payment_max->EditValue = FormatNumber($this->minimum_down_payment_max->EditValue, null);
            }

            // down_price_max
            $this->down_price_max->setupEditAttributes();
            $this->down_price_max->EditCustomAttributes = "";
            $this->down_price_max->EditValue = HtmlEncode($this->down_price_max->CurrentValue);
            $this->down_price_max->PlaceHolder = RemoveHtml($this->down_price_max->caption());
            if (strval($this->down_price_max->EditValue) != "" && is_numeric($this->down_price_max->EditValue)) {
                $this->down_price_max->EditValue = FormatNumber($this->down_price_max->EditValue, null);
            }

            // down_price
            $this->down_price->setupEditAttributes();
            $this->down_price->EditCustomAttributes = "";
            $this->down_price->EditValue = HtmlEncode($this->down_price->CurrentValue);
            $this->down_price->PlaceHolder = RemoveHtml($this->down_price->caption());
            if (strval($this->down_price->EditValue) != "" && is_numeric($this->down_price->EditValue)) {
                $this->down_price->EditValue = FormatNumber($this->down_price->EditValue, null);
            }

            // factor_monthly_installment_over_down_max
            $this->factor_monthly_installment_over_down_max->setupEditAttributes();
            $this->factor_monthly_installment_over_down_max->EditCustomAttributes = "";
            $this->factor_monthly_installment_over_down_max->EditValue = HtmlEncode($this->factor_monthly_installment_over_down_max->CurrentValue);
            $this->factor_monthly_installment_over_down_max->PlaceHolder = RemoveHtml($this->factor_monthly_installment_over_down_max->caption());
            if (strval($this->factor_monthly_installment_over_down_max->EditValue) != "" && is_numeric($this->factor_monthly_installment_over_down_max->EditValue)) {
                $this->factor_monthly_installment_over_down_max->EditValue = FormatNumber($this->factor_monthly_installment_over_down_max->EditValue, null);
            }

            // fee_max
            $this->fee_max->setupEditAttributes();
            $this->fee_max->EditCustomAttributes = "";
            $this->fee_max->EditValue = HtmlEncode($this->fee_max->CurrentValue);
            $this->fee_max->PlaceHolder = RemoveHtml($this->fee_max->caption());
            if (strval($this->fee_max->EditValue) != "" && is_numeric($this->fee_max->EditValue)) {
                $this->fee_max->EditValue = FormatNumber($this->fee_max->EditValue, null);
            }

            // monthly_payment_max
            $this->monthly_payment_max->setupEditAttributes();
            $this->monthly_payment_max->EditCustomAttributes = "";
            $this->monthly_payment_max->EditValue = HtmlEncode($this->monthly_payment_max->CurrentValue);
            $this->monthly_payment_max->PlaceHolder = RemoveHtml($this->monthly_payment_max->caption());
            if (strval($this->monthly_payment_max->EditValue) != "" && is_numeric($this->monthly_payment_max->EditValue)) {
                $this->monthly_payment_max->EditValue = FormatNumber($this->monthly_payment_max->EditValue, null);
            }

            // annual_interest_buyer
            $this->annual_interest_buyer->setupEditAttributes();
            $this->annual_interest_buyer->EditCustomAttributes = "";
            $this->annual_interest_buyer->EditValue = HtmlEncode($this->annual_interest_buyer->CurrentValue);
            $this->annual_interest_buyer->PlaceHolder = RemoveHtml($this->annual_interest_buyer->caption());
            if (strval($this->annual_interest_buyer->EditValue) != "" && is_numeric($this->annual_interest_buyer->EditValue)) {
                $this->annual_interest_buyer->EditValue = FormatNumber($this->annual_interest_buyer->EditValue, null);
            }

            // monthly_expense_max
            $this->monthly_expense_max->setupEditAttributes();
            $this->monthly_expense_max->EditCustomAttributes = "";
            $this->monthly_expense_max->EditValue = HtmlEncode($this->monthly_expense_max->CurrentValue);
            $this->monthly_expense_max->PlaceHolder = RemoveHtml($this->monthly_expense_max->caption());
            if (strval($this->monthly_expense_max->EditValue) != "" && is_numeric($this->monthly_expense_max->EditValue)) {
                $this->monthly_expense_max->EditValue = FormatNumber($this->monthly_expense_max->EditValue, null);
            }

            // average_rent_max
            $this->average_rent_max->setupEditAttributes();
            $this->average_rent_max->EditCustomAttributes = "";
            $this->average_rent_max->EditValue = HtmlEncode($this->average_rent_max->CurrentValue);
            $this->average_rent_max->PlaceHolder = RemoveHtml($this->average_rent_max->caption());
            if (strval($this->average_rent_max->EditValue) != "" && is_numeric($this->average_rent_max->EditValue)) {
                $this->average_rent_max->EditValue = FormatNumber($this->average_rent_max->EditValue, null);
            }

            // average_down_payment_max
            $this->average_down_payment_max->setupEditAttributes();
            $this->average_down_payment_max->EditCustomAttributes = "";
            $this->average_down_payment_max->EditValue = HtmlEncode($this->average_down_payment_max->CurrentValue);
            $this->average_down_payment_max->PlaceHolder = RemoveHtml($this->average_down_payment_max->caption());
            if (strval($this->average_down_payment_max->EditValue) != "" && is_numeric($this->average_down_payment_max->EditValue)) {
                $this->average_down_payment_max->EditValue = FormatNumber($this->average_down_payment_max->EditValue, null);
            }

            // min_down
            $this->min_down->setupEditAttributes();
            $this->min_down->EditCustomAttributes = "";
            $this->min_down->EditValue = HtmlEncode($this->min_down->CurrentValue);
            $this->min_down->PlaceHolder = RemoveHtml($this->min_down->caption());
            if (strval($this->min_down->EditValue) != "" && is_numeric($this->min_down->EditValue)) {
                $this->min_down->EditValue = FormatNumber($this->min_down->EditValue, null);
            }

            // remaining_down
            $this->remaining_down->setupEditAttributes();
            $this->remaining_down->EditCustomAttributes = "";
            $this->remaining_down->EditValue = HtmlEncode($this->remaining_down->CurrentValue);
            $this->remaining_down->PlaceHolder = RemoveHtml($this->remaining_down->caption());
            if (strval($this->remaining_down->EditValue) != "" && is_numeric($this->remaining_down->EditValue)) {
                $this->remaining_down->EditValue = FormatNumber($this->remaining_down->EditValue, null);
            }

            // factor_financing
            $this->factor_financing->setupEditAttributes();
            $this->factor_financing->EditCustomAttributes = "";
            $this->factor_financing->EditValue = HtmlEncode($this->factor_financing->CurrentValue);
            $this->factor_financing->PlaceHolder = RemoveHtml($this->factor_financing->caption());
            if (strval($this->factor_financing->EditValue) != "" && is_numeric($this->factor_financing->EditValue)) {
                $this->factor_financing->EditValue = FormatNumber($this->factor_financing->EditValue, null);
            }

            // credit_limit_down
            $this->credit_limit_down->setupEditAttributes();
            $this->credit_limit_down->EditCustomAttributes = "";
            $this->credit_limit_down->EditValue = HtmlEncode($this->credit_limit_down->CurrentValue);
            $this->credit_limit_down->PlaceHolder = RemoveHtml($this->credit_limit_down->caption());
            if (strval($this->credit_limit_down->EditValue) != "" && is_numeric($this->credit_limit_down->EditValue)) {
                $this->credit_limit_down->EditValue = FormatNumber($this->credit_limit_down->EditValue, null);
            }

            // price_down_min
            $this->price_down_min->setupEditAttributes();
            $this->price_down_min->EditCustomAttributes = "";
            $this->price_down_min->EditValue = HtmlEncode($this->price_down_min->CurrentValue);
            $this->price_down_min->PlaceHolder = RemoveHtml($this->price_down_min->caption());
            if (strval($this->price_down_min->EditValue) != "" && is_numeric($this->price_down_min->EditValue)) {
                $this->price_down_min->EditValue = FormatNumber($this->price_down_min->EditValue, null);
            }

            // discount_min
            $this->discount_min->setupEditAttributes();
            $this->discount_min->EditCustomAttributes = "";
            $this->discount_min->EditValue = HtmlEncode($this->discount_min->CurrentValue);
            $this->discount_min->PlaceHolder = RemoveHtml($this->discount_min->caption());
            if (strval($this->discount_min->EditValue) != "" && is_numeric($this->discount_min->EditValue)) {
                $this->discount_min->EditValue = FormatNumber($this->discount_min->EditValue, null);
            }

            // price_down_special_min
            $this->price_down_special_min->setupEditAttributes();
            $this->price_down_special_min->EditCustomAttributes = "";
            $this->price_down_special_min->EditValue = HtmlEncode($this->price_down_special_min->CurrentValue);
            $this->price_down_special_min->PlaceHolder = RemoveHtml($this->price_down_special_min->caption());
            if (strval($this->price_down_special_min->EditValue) != "" && is_numeric($this->price_down_special_min->EditValue)) {
                $this->price_down_special_min->EditValue = FormatNumber($this->price_down_special_min->EditValue, null);
            }

            // usable_area_price_min
            $this->usable_area_price_min->setupEditAttributes();
            $this->usable_area_price_min->EditCustomAttributes = "";
            $this->usable_area_price_min->EditValue = HtmlEncode($this->usable_area_price_min->CurrentValue);
            $this->usable_area_price_min->PlaceHolder = RemoveHtml($this->usable_area_price_min->caption());
            if (strval($this->usable_area_price_min->EditValue) != "" && is_numeric($this->usable_area_price_min->EditValue)) {
                $this->usable_area_price_min->EditValue = FormatNumber($this->usable_area_price_min->EditValue, null);
            }

            // land_size_price_min
            $this->land_size_price_min->setupEditAttributes();
            $this->land_size_price_min->EditCustomAttributes = "";
            $this->land_size_price_min->EditValue = HtmlEncode($this->land_size_price_min->CurrentValue);
            $this->land_size_price_min->PlaceHolder = RemoveHtml($this->land_size_price_min->caption());
            if (strval($this->land_size_price_min->EditValue) != "" && is_numeric($this->land_size_price_min->EditValue)) {
                $this->land_size_price_min->EditValue = FormatNumber($this->land_size_price_min->EditValue, null);
            }

            // reservation_price_min
            $this->reservation_price_min->setupEditAttributes();
            $this->reservation_price_min->EditCustomAttributes = "";
            $this->reservation_price_min->EditValue = HtmlEncode($this->reservation_price_min->CurrentValue);
            $this->reservation_price_min->PlaceHolder = RemoveHtml($this->reservation_price_min->caption());
            if (strval($this->reservation_price_min->EditValue) != "" && is_numeric($this->reservation_price_min->EditValue)) {
                $this->reservation_price_min->EditValue = FormatNumber($this->reservation_price_min->EditValue, null);
            }

            // minimum_down_payment_min
            $this->minimum_down_payment_min->setupEditAttributes();
            $this->minimum_down_payment_min->EditCustomAttributes = "";
            $this->minimum_down_payment_min->EditValue = HtmlEncode($this->minimum_down_payment_min->CurrentValue);
            $this->minimum_down_payment_min->PlaceHolder = RemoveHtml($this->minimum_down_payment_min->caption());
            if (strval($this->minimum_down_payment_min->EditValue) != "" && is_numeric($this->minimum_down_payment_min->EditValue)) {
                $this->minimum_down_payment_min->EditValue = FormatNumber($this->minimum_down_payment_min->EditValue, null);
            }

            // down_price_min
            $this->down_price_min->setupEditAttributes();
            $this->down_price_min->EditCustomAttributes = "";
            $this->down_price_min->EditValue = HtmlEncode($this->down_price_min->CurrentValue);
            $this->down_price_min->PlaceHolder = RemoveHtml($this->down_price_min->caption());
            if (strval($this->down_price_min->EditValue) != "" && is_numeric($this->down_price_min->EditValue)) {
                $this->down_price_min->EditValue = FormatNumber($this->down_price_min->EditValue, null);
            }

            // remaining_credit_limit_down
            $this->remaining_credit_limit_down->setupEditAttributes();
            $this->remaining_credit_limit_down->EditCustomAttributes = "";
            $this->remaining_credit_limit_down->EditValue = HtmlEncode($this->remaining_credit_limit_down->CurrentValue);
            $this->remaining_credit_limit_down->PlaceHolder = RemoveHtml($this->remaining_credit_limit_down->caption());
            if (strval($this->remaining_credit_limit_down->EditValue) != "" && is_numeric($this->remaining_credit_limit_down->EditValue)) {
                $this->remaining_credit_limit_down->EditValue = FormatNumber($this->remaining_credit_limit_down->EditValue, null);
            }

            // fee_min
            $this->fee_min->setupEditAttributes();
            $this->fee_min->EditCustomAttributes = "";
            $this->fee_min->EditValue = HtmlEncode($this->fee_min->CurrentValue);
            $this->fee_min->PlaceHolder = RemoveHtml($this->fee_min->caption());
            if (strval($this->fee_min->EditValue) != "" && is_numeric($this->fee_min->EditValue)) {
                $this->fee_min->EditValue = FormatNumber($this->fee_min->EditValue, null);
            }

            // monthly_payment_min
            $this->monthly_payment_min->setupEditAttributes();
            $this->monthly_payment_min->EditCustomAttributes = "";
            $this->monthly_payment_min->EditValue = HtmlEncode($this->monthly_payment_min->CurrentValue);
            $this->monthly_payment_min->PlaceHolder = RemoveHtml($this->monthly_payment_min->caption());
            if (strval($this->monthly_payment_min->EditValue) != "" && is_numeric($this->monthly_payment_min->EditValue)) {
                $this->monthly_payment_min->EditValue = FormatNumber($this->monthly_payment_min->EditValue, null);
            }

            // annual_interest_buyer_model_min
            $this->annual_interest_buyer_model_min->setupEditAttributes();
            $this->annual_interest_buyer_model_min->EditCustomAttributes = "";
            $this->annual_interest_buyer_model_min->EditValue = HtmlEncode($this->annual_interest_buyer_model_min->CurrentValue);
            $this->annual_interest_buyer_model_min->PlaceHolder = RemoveHtml($this->annual_interest_buyer_model_min->caption());
            if (strval($this->annual_interest_buyer_model_min->EditValue) != "" && is_numeric($this->annual_interest_buyer_model_min->EditValue)) {
                $this->annual_interest_buyer_model_min->EditValue = FormatNumber($this->annual_interest_buyer_model_min->EditValue, null);
            }

            // interest_down-payment_financing
            $this->interest_downpayment_financing->setupEditAttributes();
            $this->interest_downpayment_financing->EditCustomAttributes = "";
            $this->interest_downpayment_financing->EditValue = HtmlEncode($this->interest_downpayment_financing->CurrentValue);
            $this->interest_downpayment_financing->PlaceHolder = RemoveHtml($this->interest_downpayment_financing->caption());
            if (strval($this->interest_downpayment_financing->EditValue) != "" && is_numeric($this->interest_downpayment_financing->EditValue)) {
                $this->interest_downpayment_financing->EditValue = FormatNumber($this->interest_downpayment_financing->EditValue, null);
            }

            // monthly_expenses_min
            $this->monthly_expenses_min->setupEditAttributes();
            $this->monthly_expenses_min->EditCustomAttributes = "";
            $this->monthly_expenses_min->EditValue = HtmlEncode($this->monthly_expenses_min->CurrentValue);
            $this->monthly_expenses_min->PlaceHolder = RemoveHtml($this->monthly_expenses_min->caption());
            if (strval($this->monthly_expenses_min->EditValue) != "" && is_numeric($this->monthly_expenses_min->EditValue)) {
                $this->monthly_expenses_min->EditValue = FormatNumber($this->monthly_expenses_min->EditValue, null);
            }

            // average_rent_min
            $this->average_rent_min->setupEditAttributes();
            $this->average_rent_min->EditCustomAttributes = "";
            $this->average_rent_min->EditValue = HtmlEncode($this->average_rent_min->CurrentValue);
            $this->average_rent_min->PlaceHolder = RemoveHtml($this->average_rent_min->caption());
            if (strval($this->average_rent_min->EditValue) != "" && is_numeric($this->average_rent_min->EditValue)) {
                $this->average_rent_min->EditValue = FormatNumber($this->average_rent_min->EditValue, null);
            }

            // average_down_payment_min
            $this->average_down_payment_min->setupEditAttributes();
            $this->average_down_payment_min->EditCustomAttributes = "";
            $this->average_down_payment_min->EditValue = HtmlEncode($this->average_down_payment_min->CurrentValue);
            $this->average_down_payment_min->PlaceHolder = RemoveHtml($this->average_down_payment_min->caption());
            if (strval($this->average_down_payment_min->EditValue) != "" && is_numeric($this->average_down_payment_min->EditValue)) {
                $this->average_down_payment_min->EditValue = FormatNumber($this->average_down_payment_min->EditValue, null);
            }

            // installment_down_payment_loan
            $this->installment_down_payment_loan->setupEditAttributes();
            $this->installment_down_payment_loan->EditCustomAttributes = "";
            $this->installment_down_payment_loan->EditValue = HtmlEncode($this->installment_down_payment_loan->CurrentValue);
            $this->installment_down_payment_loan->PlaceHolder = RemoveHtml($this->installment_down_payment_loan->caption());
            if (strval($this->installment_down_payment_loan->EditValue) != "" && is_numeric($this->installment_down_payment_loan->EditValue)) {
                $this->installment_down_payment_loan->EditValue = FormatNumber($this->installment_down_payment_loan->EditValue, null);
            }

            // price_invertor
            $this->price_invertor->setupEditAttributes();
            $this->price_invertor->EditCustomAttributes = "";
            $this->price_invertor->EditValue = HtmlEncode($this->price_invertor->CurrentValue);
            $this->price_invertor->PlaceHolder = RemoveHtml($this->price_invertor->caption());
            if (strval($this->price_invertor->EditValue) != "" && is_numeric($this->price_invertor->EditValue)) {
                $this->price_invertor->EditValue = FormatNumber($this->price_invertor->EditValue, null);
            }

            // expired_date
            $this->expired_date->setupEditAttributes();
            $this->expired_date->EditCustomAttributes = "";
            $this->expired_date->EditValue = HtmlEncode(FormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern()));
            $this->expired_date->PlaceHolder = RemoveHtml($this->expired_date->caption());

            // cdate

            // cuser

            // cip

            // uip

            // udate

            // uuser

            // Add refer script

            // title
            $this->_title->LinkCustomAttributes = "";
            $this->_title->HrefValue = "";

            // title_en
            $this->title_en->LinkCustomAttributes = "";
            $this->title_en->HrefValue = "";

            // brand_id
            $this->brand_id->LinkCustomAttributes = "";
            $this->brand_id->HrefValue = "";

            // detail
            $this->detail->LinkCustomAttributes = "";
            $this->detail->HrefValue = "";

            // detail_en
            $this->detail_en->LinkCustomAttributes = "";
            $this->detail_en->HrefValue = "";

            // latitude
            $this->latitude->LinkCustomAttributes = "";
            $this->latitude->HrefValue = "";

            // longitude
            $this->longitude->LinkCustomAttributes = "";
            $this->longitude->HrefValue = "";

            // num_buildings
            $this->num_buildings->LinkCustomAttributes = "";
            $this->num_buildings->HrefValue = "";

            // num_unit
            $this->num_unit->LinkCustomAttributes = "";
            $this->num_unit->HrefValue = "";

            // num_floors
            $this->num_floors->LinkCustomAttributes = "";
            $this->num_floors->HrefValue = "";

            // floors
            $this->floors->LinkCustomAttributes = "";
            $this->floors->HrefValue = "";

            // asset_year_developer
            $this->asset_year_developer->LinkCustomAttributes = "";
            $this->asset_year_developer->HrefValue = "";

            // num_parking_spaces
            $this->num_parking_spaces->LinkCustomAttributes = "";
            $this->num_parking_spaces->HrefValue = "";

            // num_bathrooms
            $this->num_bathrooms->LinkCustomAttributes = "";
            $this->num_bathrooms->HrefValue = "";

            // num_bedrooms
            $this->num_bedrooms->LinkCustomAttributes = "";
            $this->num_bedrooms->HrefValue = "";

            // address
            $this->address->LinkCustomAttributes = "";
            $this->address->HrefValue = "";

            // address_en
            $this->address_en->LinkCustomAttributes = "";
            $this->address_en->HrefValue = "";

            // province_id
            $this->province_id->LinkCustomAttributes = "";
            $this->province_id->HrefValue = "";

            // amphur_id
            $this->amphur_id->LinkCustomAttributes = "";
            $this->amphur_id->HrefValue = "";

            // district_id
            $this->district_id->LinkCustomAttributes = "";
            $this->district_id->HrefValue = "";

            // postcode
            $this->postcode->LinkCustomAttributes = "";
            $this->postcode->HrefValue = "";

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

            // asset_website
            $this->asset_website->LinkCustomAttributes = "";
            $this->asset_website->HrefValue = "";

            // asset_review
            $this->asset_review->LinkCustomAttributes = "";
            $this->asset_review->HrefValue = "";

            // isactive
            $this->isactive->LinkCustomAttributes = "";
            $this->isactive->HrefValue = "";

            // is_recommend
            $this->is_recommend->LinkCustomAttributes = "";
            $this->is_recommend->HrefValue = "";

            // order_by
            $this->order_by->LinkCustomAttributes = "";
            $this->order_by->HrefValue = "";

            // type_pay
            $this->type_pay->LinkCustomAttributes = "";
            $this->type_pay->HrefValue = "";

            // type_pay_2
            $this->type_pay_2->LinkCustomAttributes = "";
            $this->type_pay_2->HrefValue = "";

            // price_mark
            $this->price_mark->LinkCustomAttributes = "";
            $this->price_mark->HrefValue = "";

            // holding_property
            $this->holding_property->LinkCustomAttributes = "";
            $this->holding_property->HrefValue = "";

            // common_fee
            $this->common_fee->LinkCustomAttributes = "";
            $this->common_fee->HrefValue = "";

            // usable_area
            $this->usable_area->LinkCustomAttributes = "";
            $this->usable_area->HrefValue = "";

            // usable_area_price
            $this->usable_area_price->LinkCustomAttributes = "";
            $this->usable_area_price->HrefValue = "";

            // land_size
            $this->land_size->LinkCustomAttributes = "";
            $this->land_size->HrefValue = "";

            // land_size_price
            $this->land_size_price->LinkCustomAttributes = "";
            $this->land_size_price->HrefValue = "";

            // commission
            $this->commission->LinkCustomAttributes = "";
            $this->commission->HrefValue = "";

            // transfer_day_expenses_with_business_tax
            $this->transfer_day_expenses_with_business_tax->LinkCustomAttributes = "";
            $this->transfer_day_expenses_with_business_tax->HrefValue = "";

            // transfer_day_expenses_without_business_tax
            $this->transfer_day_expenses_without_business_tax->LinkCustomAttributes = "";
            $this->transfer_day_expenses_without_business_tax->HrefValue = "";

            // price
            $this->price->LinkCustomAttributes = "";
            $this->price->HrefValue = "";

            // discount
            $this->discount->LinkCustomAttributes = "";
            $this->discount->HrefValue = "";

            // price_special
            $this->price_special->LinkCustomAttributes = "";
            $this->price_special->HrefValue = "";

            // reservation_price_model_a
            $this->reservation_price_model_a->LinkCustomAttributes = "";
            $this->reservation_price_model_a->HrefValue = "";

            // minimum_down_payment_model_a
            $this->minimum_down_payment_model_a->LinkCustomAttributes = "";
            $this->minimum_down_payment_model_a->HrefValue = "";

            // down_price_min_a
            $this->down_price_min_a->LinkCustomAttributes = "";
            $this->down_price_min_a->HrefValue = "";

            // down_price_model_a
            $this->down_price_model_a->LinkCustomAttributes = "";
            $this->down_price_model_a->HrefValue = "";

            // factor_monthly_installment_over_down
            $this->factor_monthly_installment_over_down->LinkCustomAttributes = "";
            $this->factor_monthly_installment_over_down->HrefValue = "";

            // fee_a
            $this->fee_a->LinkCustomAttributes = "";
            $this->fee_a->HrefValue = "";

            // monthly_payment_buyer
            $this->monthly_payment_buyer->LinkCustomAttributes = "";
            $this->monthly_payment_buyer->HrefValue = "";

            // annual_interest_buyer_model_a
            $this->annual_interest_buyer_model_a->LinkCustomAttributes = "";
            $this->annual_interest_buyer_model_a->HrefValue = "";

            // monthly_expenses_a
            $this->monthly_expenses_a->LinkCustomAttributes = "";
            $this->monthly_expenses_a->HrefValue = "";

            // average_rent_a
            $this->average_rent_a->LinkCustomAttributes = "";
            $this->average_rent_a->HrefValue = "";

            // average_down_payment_a
            $this->average_down_payment_a->LinkCustomAttributes = "";
            $this->average_down_payment_a->HrefValue = "";

            // transfer_day_expenses_without_business_tax_max_min
            $this->transfer_day_expenses_without_business_tax_max_min->LinkCustomAttributes = "";
            $this->transfer_day_expenses_without_business_tax_max_min->HrefValue = "";

            // transfer_day_expenses_with_business_tax_max_min
            $this->transfer_day_expenses_with_business_tax_max_min->LinkCustomAttributes = "";
            $this->transfer_day_expenses_with_business_tax_max_min->HrefValue = "";

            // bank_appraisal_price
            $this->bank_appraisal_price->LinkCustomAttributes = "";
            $this->bank_appraisal_price->HrefValue = "";

            // mark_up_price
            $this->mark_up_price->LinkCustomAttributes = "";
            $this->mark_up_price->HrefValue = "";

            // required_gap
            $this->required_gap->LinkCustomAttributes = "";
            $this->required_gap->HrefValue = "";

            // minimum_down_payment
            $this->minimum_down_payment->LinkCustomAttributes = "";
            $this->minimum_down_payment->HrefValue = "";

            // price_down_max
            $this->price_down_max->LinkCustomAttributes = "";
            $this->price_down_max->HrefValue = "";

            // discount_max
            $this->discount_max->LinkCustomAttributes = "";
            $this->discount_max->HrefValue = "";

            // price_down_special_max
            $this->price_down_special_max->LinkCustomAttributes = "";
            $this->price_down_special_max->HrefValue = "";

            // usable_area_price_max
            $this->usable_area_price_max->LinkCustomAttributes = "";
            $this->usable_area_price_max->HrefValue = "";

            // land_size_price_max
            $this->land_size_price_max->LinkCustomAttributes = "";
            $this->land_size_price_max->HrefValue = "";

            // reservation_price_max
            $this->reservation_price_max->LinkCustomAttributes = "";
            $this->reservation_price_max->HrefValue = "";

            // minimum_down_payment_max
            $this->minimum_down_payment_max->LinkCustomAttributes = "";
            $this->minimum_down_payment_max->HrefValue = "";

            // down_price_max
            $this->down_price_max->LinkCustomAttributes = "";
            $this->down_price_max->HrefValue = "";

            // down_price
            $this->down_price->LinkCustomAttributes = "";
            $this->down_price->HrefValue = "";

            // factor_monthly_installment_over_down_max
            $this->factor_monthly_installment_over_down_max->LinkCustomAttributes = "";
            $this->factor_monthly_installment_over_down_max->HrefValue = "";

            // fee_max
            $this->fee_max->LinkCustomAttributes = "";
            $this->fee_max->HrefValue = "";

            // monthly_payment_max
            $this->monthly_payment_max->LinkCustomAttributes = "";
            $this->monthly_payment_max->HrefValue = "";

            // annual_interest_buyer
            $this->annual_interest_buyer->LinkCustomAttributes = "";
            $this->annual_interest_buyer->HrefValue = "";

            // monthly_expense_max
            $this->monthly_expense_max->LinkCustomAttributes = "";
            $this->monthly_expense_max->HrefValue = "";

            // average_rent_max
            $this->average_rent_max->LinkCustomAttributes = "";
            $this->average_rent_max->HrefValue = "";

            // average_down_payment_max
            $this->average_down_payment_max->LinkCustomAttributes = "";
            $this->average_down_payment_max->HrefValue = "";

            // min_down
            $this->min_down->LinkCustomAttributes = "";
            $this->min_down->HrefValue = "";

            // remaining_down
            $this->remaining_down->LinkCustomAttributes = "";
            $this->remaining_down->HrefValue = "";

            // factor_financing
            $this->factor_financing->LinkCustomAttributes = "";
            $this->factor_financing->HrefValue = "";

            // credit_limit_down
            $this->credit_limit_down->LinkCustomAttributes = "";
            $this->credit_limit_down->HrefValue = "";

            // price_down_min
            $this->price_down_min->LinkCustomAttributes = "";
            $this->price_down_min->HrefValue = "";

            // discount_min
            $this->discount_min->LinkCustomAttributes = "";
            $this->discount_min->HrefValue = "";

            // price_down_special_min
            $this->price_down_special_min->LinkCustomAttributes = "";
            $this->price_down_special_min->HrefValue = "";

            // usable_area_price_min
            $this->usable_area_price_min->LinkCustomAttributes = "";
            $this->usable_area_price_min->HrefValue = "";

            // land_size_price_min
            $this->land_size_price_min->LinkCustomAttributes = "";
            $this->land_size_price_min->HrefValue = "";

            // reservation_price_min
            $this->reservation_price_min->LinkCustomAttributes = "";
            $this->reservation_price_min->HrefValue = "";

            // minimum_down_payment_min
            $this->minimum_down_payment_min->LinkCustomAttributes = "";
            $this->minimum_down_payment_min->HrefValue = "";

            // down_price_min
            $this->down_price_min->LinkCustomAttributes = "";
            $this->down_price_min->HrefValue = "";

            // remaining_credit_limit_down
            $this->remaining_credit_limit_down->LinkCustomAttributes = "";
            $this->remaining_credit_limit_down->HrefValue = "";

            // fee_min
            $this->fee_min->LinkCustomAttributes = "";
            $this->fee_min->HrefValue = "";

            // monthly_payment_min
            $this->monthly_payment_min->LinkCustomAttributes = "";
            $this->monthly_payment_min->HrefValue = "";

            // annual_interest_buyer_model_min
            $this->annual_interest_buyer_model_min->LinkCustomAttributes = "";
            $this->annual_interest_buyer_model_min->HrefValue = "";

            // interest_down-payment_financing
            $this->interest_downpayment_financing->LinkCustomAttributes = "";
            $this->interest_downpayment_financing->HrefValue = "";

            // monthly_expenses_min
            $this->monthly_expenses_min->LinkCustomAttributes = "";
            $this->monthly_expenses_min->HrefValue = "";

            // average_rent_min
            $this->average_rent_min->LinkCustomAttributes = "";
            $this->average_rent_min->HrefValue = "";

            // average_down_payment_min
            $this->average_down_payment_min->LinkCustomAttributes = "";
            $this->average_down_payment_min->HrefValue = "";

            // installment_down_payment_loan
            $this->installment_down_payment_loan->LinkCustomAttributes = "";
            $this->installment_down_payment_loan->HrefValue = "";

            // price_invertor
            $this->price_invertor->LinkCustomAttributes = "";
            $this->price_invertor->HrefValue = "";

            // expired_date
            $this->expired_date->LinkCustomAttributes = "";
            $this->expired_date->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";
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
        if ($this->brand_id->Required) {
            if (!$this->brand_id->IsDetailKey && EmptyValue($this->brand_id->FormValue)) {
                $this->brand_id->addErrorMessage(str_replace("%s", $this->brand_id->caption(), $this->brand_id->RequiredErrorMessage));
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
        if ($this->latitude->Required) {
            if (!$this->latitude->IsDetailKey && EmptyValue($this->latitude->FormValue)) {
                $this->latitude->addErrorMessage(str_replace("%s", $this->latitude->caption(), $this->latitude->RequiredErrorMessage));
            }
        }
        if ($this->longitude->Required) {
            if (!$this->longitude->IsDetailKey && EmptyValue($this->longitude->FormValue)) {
                $this->longitude->addErrorMessage(str_replace("%s", $this->longitude->caption(), $this->longitude->RequiredErrorMessage));
            }
        }
        if ($this->num_buildings->Required) {
            if (!$this->num_buildings->IsDetailKey && EmptyValue($this->num_buildings->FormValue)) {
                $this->num_buildings->addErrorMessage(str_replace("%s", $this->num_buildings->caption(), $this->num_buildings->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->num_buildings->FormValue)) {
            $this->num_buildings->addErrorMessage($this->num_buildings->getErrorMessage(false));
        }
        if ($this->num_unit->Required) {
            if (!$this->num_unit->IsDetailKey && EmptyValue($this->num_unit->FormValue)) {
                $this->num_unit->addErrorMessage(str_replace("%s", $this->num_unit->caption(), $this->num_unit->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->num_unit->FormValue)) {
            $this->num_unit->addErrorMessage($this->num_unit->getErrorMessage(false));
        }
        if ($this->num_floors->Required) {
            if (!$this->num_floors->IsDetailKey && EmptyValue($this->num_floors->FormValue)) {
                $this->num_floors->addErrorMessage(str_replace("%s", $this->num_floors->caption(), $this->num_floors->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->num_floors->FormValue)) {
            $this->num_floors->addErrorMessage($this->num_floors->getErrorMessage(false));
        }
        if ($this->floors->Required) {
            if (!$this->floors->IsDetailKey && EmptyValue($this->floors->FormValue)) {
                $this->floors->addErrorMessage(str_replace("%s", $this->floors->caption(), $this->floors->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->floors->FormValue)) {
            $this->floors->addErrorMessage($this->floors->getErrorMessage(false));
        }
        if ($this->asset_year_developer->Required) {
            if (!$this->asset_year_developer->IsDetailKey && EmptyValue($this->asset_year_developer->FormValue)) {
                $this->asset_year_developer->addErrorMessage(str_replace("%s", $this->asset_year_developer->caption(), $this->asset_year_developer->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->asset_year_developer->FormValue)) {
            $this->asset_year_developer->addErrorMessage($this->asset_year_developer->getErrorMessage(false));
        }
        if ($this->num_parking_spaces->Required) {
            if (!$this->num_parking_spaces->IsDetailKey && EmptyValue($this->num_parking_spaces->FormValue)) {
                $this->num_parking_spaces->addErrorMessage(str_replace("%s", $this->num_parking_spaces->caption(), $this->num_parking_spaces->RequiredErrorMessage));
            }
        }
        if ($this->num_bathrooms->Required) {
            if (!$this->num_bathrooms->IsDetailKey && EmptyValue($this->num_bathrooms->FormValue)) {
                $this->num_bathrooms->addErrorMessage(str_replace("%s", $this->num_bathrooms->caption(), $this->num_bathrooms->RequiredErrorMessage));
            }
        }
        if ($this->num_bedrooms->Required) {
            if (!$this->num_bedrooms->IsDetailKey && EmptyValue($this->num_bedrooms->FormValue)) {
                $this->num_bedrooms->addErrorMessage(str_replace("%s", $this->num_bedrooms->caption(), $this->num_bedrooms->RequiredErrorMessage));
            }
        }
        if ($this->address->Required) {
            if (!$this->address->IsDetailKey && EmptyValue($this->address->FormValue)) {
                $this->address->addErrorMessage(str_replace("%s", $this->address->caption(), $this->address->RequiredErrorMessage));
            }
        }
        if ($this->address_en->Required) {
            if (!$this->address_en->IsDetailKey && EmptyValue($this->address_en->FormValue)) {
                $this->address_en->addErrorMessage(str_replace("%s", $this->address_en->caption(), $this->address_en->RequiredErrorMessage));
            }
        }
        if ($this->province_id->Required) {
            if (!$this->province_id->IsDetailKey && EmptyValue($this->province_id->FormValue)) {
                $this->province_id->addErrorMessage(str_replace("%s", $this->province_id->caption(), $this->province_id->RequiredErrorMessage));
            }
        }
        if ($this->amphur_id->Required) {
            if (!$this->amphur_id->IsDetailKey && EmptyValue($this->amphur_id->FormValue)) {
                $this->amphur_id->addErrorMessage(str_replace("%s", $this->amphur_id->caption(), $this->amphur_id->RequiredErrorMessage));
            }
        }
        if ($this->district_id->Required) {
            if (!$this->district_id->IsDetailKey && EmptyValue($this->district_id->FormValue)) {
                $this->district_id->addErrorMessage(str_replace("%s", $this->district_id->caption(), $this->district_id->RequiredErrorMessage));
            }
        }
        if ($this->postcode->Required) {
            if (!$this->postcode->IsDetailKey && EmptyValue($this->postcode->FormValue)) {
                $this->postcode->addErrorMessage(str_replace("%s", $this->postcode->caption(), $this->postcode->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->postcode->FormValue)) {
            $this->postcode->addErrorMessage($this->postcode->getErrorMessage(false));
        }
        if ($this->floor_plan->Required) {
            if ($this->floor_plan->Upload->FileName == "" && !$this->floor_plan->Upload->KeepFile) {
                $this->floor_plan->addErrorMessage(str_replace("%s", $this->floor_plan->caption(), $this->floor_plan->RequiredErrorMessage));
            }
        }
        if ($this->layout_unit->Required) {
            if ($this->layout_unit->Upload->FileName == "" && !$this->layout_unit->Upload->KeepFile) {
                $this->layout_unit->addErrorMessage(str_replace("%s", $this->layout_unit->caption(), $this->layout_unit->RequiredErrorMessage));
            }
        }
        if ($this->asset_website->Required) {
            if (!$this->asset_website->IsDetailKey && EmptyValue($this->asset_website->FormValue)) {
                $this->asset_website->addErrorMessage(str_replace("%s", $this->asset_website->caption(), $this->asset_website->RequiredErrorMessage));
            }
        }
        if ($this->asset_review->Required) {
            if (!$this->asset_review->IsDetailKey && EmptyValue($this->asset_review->FormValue)) {
                $this->asset_review->addErrorMessage(str_replace("%s", $this->asset_review->caption(), $this->asset_review->RequiredErrorMessage));
            }
        }
        if ($this->isactive->Required) {
            if ($this->isactive->FormValue == "") {
                $this->isactive->addErrorMessage(str_replace("%s", $this->isactive->caption(), $this->isactive->RequiredErrorMessage));
            }
        }
        if ($this->is_recommend->Required) {
            if ($this->is_recommend->FormValue == "") {
                $this->is_recommend->addErrorMessage(str_replace("%s", $this->is_recommend->caption(), $this->is_recommend->RequiredErrorMessage));
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
        if ($this->type_pay->Required) {
            if ($this->type_pay->FormValue == "") {
                $this->type_pay->addErrorMessage(str_replace("%s", $this->type_pay->caption(), $this->type_pay->RequiredErrorMessage));
            }
        }
        if ($this->type_pay_2->Required) {
            if ($this->type_pay_2->FormValue == "") {
                $this->type_pay_2->addErrorMessage(str_replace("%s", $this->type_pay_2->caption(), $this->type_pay_2->RequiredErrorMessage));
            }
        }
        if ($this->price_mark->Required) {
            if (!$this->price_mark->IsDetailKey && EmptyValue($this->price_mark->FormValue)) {
                $this->price_mark->addErrorMessage(str_replace("%s", $this->price_mark->caption(), $this->price_mark->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->price_mark->FormValue)) {
            $this->price_mark->addErrorMessage($this->price_mark->getErrorMessage(false));
        }
        if ($this->holding_property->Required) {
            if ($this->holding_property->FormValue == "") {
                $this->holding_property->addErrorMessage(str_replace("%s", $this->holding_property->caption(), $this->holding_property->RequiredErrorMessage));
            }
        }
        if ($this->common_fee->Required) {
            if (!$this->common_fee->IsDetailKey && EmptyValue($this->common_fee->FormValue)) {
                $this->common_fee->addErrorMessage(str_replace("%s", $this->common_fee->caption(), $this->common_fee->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->common_fee->FormValue)) {
            $this->common_fee->addErrorMessage($this->common_fee->getErrorMessage(false));
        }
        if ($this->usable_area->Required) {
            if (!$this->usable_area->IsDetailKey && EmptyValue($this->usable_area->FormValue)) {
                $this->usable_area->addErrorMessage(str_replace("%s", $this->usable_area->caption(), $this->usable_area->RequiredErrorMessage));
            }
        }
        if ($this->usable_area_price->Required) {
            if (!$this->usable_area_price->IsDetailKey && EmptyValue($this->usable_area_price->FormValue)) {
                $this->usable_area_price->addErrorMessage(str_replace("%s", $this->usable_area_price->caption(), $this->usable_area_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->usable_area_price->FormValue)) {
            $this->usable_area_price->addErrorMessage($this->usable_area_price->getErrorMessage(false));
        }
        if ($this->land_size->Required) {
            if (!$this->land_size->IsDetailKey && EmptyValue($this->land_size->FormValue)) {
                $this->land_size->addErrorMessage(str_replace("%s", $this->land_size->caption(), $this->land_size->RequiredErrorMessage));
            }
        }
        if ($this->land_size_price->Required) {
            if (!$this->land_size_price->IsDetailKey && EmptyValue($this->land_size_price->FormValue)) {
                $this->land_size_price->addErrorMessage(str_replace("%s", $this->land_size_price->caption(), $this->land_size_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->land_size_price->FormValue)) {
            $this->land_size_price->addErrorMessage($this->land_size_price->getErrorMessage(false));
        }
        if ($this->commission->Required) {
            if (!$this->commission->IsDetailKey && EmptyValue($this->commission->FormValue)) {
                $this->commission->addErrorMessage(str_replace("%s", $this->commission->caption(), $this->commission->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->commission->FormValue)) {
            $this->commission->addErrorMessage($this->commission->getErrorMessage(false));
        }
        if ($this->transfer_day_expenses_with_business_tax->Required) {
            if (!$this->transfer_day_expenses_with_business_tax->IsDetailKey && EmptyValue($this->transfer_day_expenses_with_business_tax->FormValue)) {
                $this->transfer_day_expenses_with_business_tax->addErrorMessage(str_replace("%s", $this->transfer_day_expenses_with_business_tax->caption(), $this->transfer_day_expenses_with_business_tax->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->transfer_day_expenses_with_business_tax->FormValue)) {
            $this->transfer_day_expenses_with_business_tax->addErrorMessage($this->transfer_day_expenses_with_business_tax->getErrorMessage(false));
        }
        if ($this->transfer_day_expenses_without_business_tax->Required) {
            if (!$this->transfer_day_expenses_without_business_tax->IsDetailKey && EmptyValue($this->transfer_day_expenses_without_business_tax->FormValue)) {
                $this->transfer_day_expenses_without_business_tax->addErrorMessage(str_replace("%s", $this->transfer_day_expenses_without_business_tax->caption(), $this->transfer_day_expenses_without_business_tax->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->transfer_day_expenses_without_business_tax->FormValue)) {
            $this->transfer_day_expenses_without_business_tax->addErrorMessage($this->transfer_day_expenses_without_business_tax->getErrorMessage(false));
        }
        if ($this->price->Required) {
            if (!$this->price->IsDetailKey && EmptyValue($this->price->FormValue)) {
                $this->price->addErrorMessage(str_replace("%s", $this->price->caption(), $this->price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->price->FormValue)) {
            $this->price->addErrorMessage($this->price->getErrorMessage(false));
        }
        if ($this->discount->Required) {
            if (!$this->discount->IsDetailKey && EmptyValue($this->discount->FormValue)) {
                $this->discount->addErrorMessage(str_replace("%s", $this->discount->caption(), $this->discount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->discount->FormValue)) {
            $this->discount->addErrorMessage($this->discount->getErrorMessage(false));
        }
        if ($this->price_special->Required) {
            if (!$this->price_special->IsDetailKey && EmptyValue($this->price_special->FormValue)) {
                $this->price_special->addErrorMessage(str_replace("%s", $this->price_special->caption(), $this->price_special->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->price_special->FormValue)) {
            $this->price_special->addErrorMessage($this->price_special->getErrorMessage(false));
        }
        if ($this->reservation_price_model_a->Required) {
            if (!$this->reservation_price_model_a->IsDetailKey && EmptyValue($this->reservation_price_model_a->FormValue)) {
                $this->reservation_price_model_a->addErrorMessage(str_replace("%s", $this->reservation_price_model_a->caption(), $this->reservation_price_model_a->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->reservation_price_model_a->FormValue)) {
            $this->reservation_price_model_a->addErrorMessage($this->reservation_price_model_a->getErrorMessage(false));
        }
        if ($this->minimum_down_payment_model_a->Required) {
            if (!$this->minimum_down_payment_model_a->IsDetailKey && EmptyValue($this->minimum_down_payment_model_a->FormValue)) {
                $this->minimum_down_payment_model_a->addErrorMessage(str_replace("%s", $this->minimum_down_payment_model_a->caption(), $this->minimum_down_payment_model_a->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->minimum_down_payment_model_a->FormValue)) {
            $this->minimum_down_payment_model_a->addErrorMessage($this->minimum_down_payment_model_a->getErrorMessage(false));
        }
        if ($this->down_price_min_a->Required) {
            if (!$this->down_price_min_a->IsDetailKey && EmptyValue($this->down_price_min_a->FormValue)) {
                $this->down_price_min_a->addErrorMessage(str_replace("%s", $this->down_price_min_a->caption(), $this->down_price_min_a->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->down_price_min_a->FormValue)) {
            $this->down_price_min_a->addErrorMessage($this->down_price_min_a->getErrorMessage(false));
        }
        if ($this->down_price_model_a->Required) {
            if (!$this->down_price_model_a->IsDetailKey && EmptyValue($this->down_price_model_a->FormValue)) {
                $this->down_price_model_a->addErrorMessage(str_replace("%s", $this->down_price_model_a->caption(), $this->down_price_model_a->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->down_price_model_a->FormValue)) {
            $this->down_price_model_a->addErrorMessage($this->down_price_model_a->getErrorMessage(false));
        }
        if ($this->factor_monthly_installment_over_down->Required) {
            if (!$this->factor_monthly_installment_over_down->IsDetailKey && EmptyValue($this->factor_monthly_installment_over_down->FormValue)) {
                $this->factor_monthly_installment_over_down->addErrorMessage(str_replace("%s", $this->factor_monthly_installment_over_down->caption(), $this->factor_monthly_installment_over_down->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->factor_monthly_installment_over_down->FormValue)) {
            $this->factor_monthly_installment_over_down->addErrorMessage($this->factor_monthly_installment_over_down->getErrorMessage(false));
        }
        if ($this->fee_a->Required) {
            if (!$this->fee_a->IsDetailKey && EmptyValue($this->fee_a->FormValue)) {
                $this->fee_a->addErrorMessage(str_replace("%s", $this->fee_a->caption(), $this->fee_a->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->fee_a->FormValue)) {
            $this->fee_a->addErrorMessage($this->fee_a->getErrorMessage(false));
        }
        if ($this->monthly_payment_buyer->Required) {
            if (!$this->monthly_payment_buyer->IsDetailKey && EmptyValue($this->monthly_payment_buyer->FormValue)) {
                $this->monthly_payment_buyer->addErrorMessage(str_replace("%s", $this->monthly_payment_buyer->caption(), $this->monthly_payment_buyer->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->monthly_payment_buyer->FormValue)) {
            $this->monthly_payment_buyer->addErrorMessage($this->monthly_payment_buyer->getErrorMessage(false));
        }
        if ($this->annual_interest_buyer_model_a->Required) {
            if (!$this->annual_interest_buyer_model_a->IsDetailKey && EmptyValue($this->annual_interest_buyer_model_a->FormValue)) {
                $this->annual_interest_buyer_model_a->addErrorMessage(str_replace("%s", $this->annual_interest_buyer_model_a->caption(), $this->annual_interest_buyer_model_a->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->annual_interest_buyer_model_a->FormValue)) {
            $this->annual_interest_buyer_model_a->addErrorMessage($this->annual_interest_buyer_model_a->getErrorMessage(false));
        }
        if ($this->monthly_expenses_a->Required) {
            if (!$this->monthly_expenses_a->IsDetailKey && EmptyValue($this->monthly_expenses_a->FormValue)) {
                $this->monthly_expenses_a->addErrorMessage(str_replace("%s", $this->monthly_expenses_a->caption(), $this->monthly_expenses_a->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->monthly_expenses_a->FormValue)) {
            $this->monthly_expenses_a->addErrorMessage($this->monthly_expenses_a->getErrorMessage(false));
        }
        if ($this->average_rent_a->Required) {
            if (!$this->average_rent_a->IsDetailKey && EmptyValue($this->average_rent_a->FormValue)) {
                $this->average_rent_a->addErrorMessage(str_replace("%s", $this->average_rent_a->caption(), $this->average_rent_a->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->average_rent_a->FormValue)) {
            $this->average_rent_a->addErrorMessage($this->average_rent_a->getErrorMessage(false));
        }
        if ($this->average_down_payment_a->Required) {
            if (!$this->average_down_payment_a->IsDetailKey && EmptyValue($this->average_down_payment_a->FormValue)) {
                $this->average_down_payment_a->addErrorMessage(str_replace("%s", $this->average_down_payment_a->caption(), $this->average_down_payment_a->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->average_down_payment_a->FormValue)) {
            $this->average_down_payment_a->addErrorMessage($this->average_down_payment_a->getErrorMessage(false));
        }
        if ($this->transfer_day_expenses_without_business_tax_max_min->Required) {
            if (!$this->transfer_day_expenses_without_business_tax_max_min->IsDetailKey && EmptyValue($this->transfer_day_expenses_without_business_tax_max_min->FormValue)) {
                $this->transfer_day_expenses_without_business_tax_max_min->addErrorMessage(str_replace("%s", $this->transfer_day_expenses_without_business_tax_max_min->caption(), $this->transfer_day_expenses_without_business_tax_max_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->transfer_day_expenses_without_business_tax_max_min->FormValue)) {
            $this->transfer_day_expenses_without_business_tax_max_min->addErrorMessage($this->transfer_day_expenses_without_business_tax_max_min->getErrorMessage(false));
        }
        if ($this->transfer_day_expenses_with_business_tax_max_min->Required) {
            if (!$this->transfer_day_expenses_with_business_tax_max_min->IsDetailKey && EmptyValue($this->transfer_day_expenses_with_business_tax_max_min->FormValue)) {
                $this->transfer_day_expenses_with_business_tax_max_min->addErrorMessage(str_replace("%s", $this->transfer_day_expenses_with_business_tax_max_min->caption(), $this->transfer_day_expenses_with_business_tax_max_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->transfer_day_expenses_with_business_tax_max_min->FormValue)) {
            $this->transfer_day_expenses_with_business_tax_max_min->addErrorMessage($this->transfer_day_expenses_with_business_tax_max_min->getErrorMessage(false));
        }
        if ($this->bank_appraisal_price->Required) {
            if (!$this->bank_appraisal_price->IsDetailKey && EmptyValue($this->bank_appraisal_price->FormValue)) {
                $this->bank_appraisal_price->addErrorMessage(str_replace("%s", $this->bank_appraisal_price->caption(), $this->bank_appraisal_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->bank_appraisal_price->FormValue)) {
            $this->bank_appraisal_price->addErrorMessage($this->bank_appraisal_price->getErrorMessage(false));
        }
        if ($this->mark_up_price->Required) {
            if (!$this->mark_up_price->IsDetailKey && EmptyValue($this->mark_up_price->FormValue)) {
                $this->mark_up_price->addErrorMessage(str_replace("%s", $this->mark_up_price->caption(), $this->mark_up_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->mark_up_price->FormValue)) {
            $this->mark_up_price->addErrorMessage($this->mark_up_price->getErrorMessage(false));
        }
        if ($this->required_gap->Required) {
            if (!$this->required_gap->IsDetailKey && EmptyValue($this->required_gap->FormValue)) {
                $this->required_gap->addErrorMessage(str_replace("%s", $this->required_gap->caption(), $this->required_gap->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->required_gap->FormValue)) {
            $this->required_gap->addErrorMessage($this->required_gap->getErrorMessage(false));
        }
        if ($this->minimum_down_payment->Required) {
            if (!$this->minimum_down_payment->IsDetailKey && EmptyValue($this->minimum_down_payment->FormValue)) {
                $this->minimum_down_payment->addErrorMessage(str_replace("%s", $this->minimum_down_payment->caption(), $this->minimum_down_payment->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->minimum_down_payment->FormValue)) {
            $this->minimum_down_payment->addErrorMessage($this->minimum_down_payment->getErrorMessage(false));
        }
        if ($this->price_down_max->Required) {
            if (!$this->price_down_max->IsDetailKey && EmptyValue($this->price_down_max->FormValue)) {
                $this->price_down_max->addErrorMessage(str_replace("%s", $this->price_down_max->caption(), $this->price_down_max->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->price_down_max->FormValue)) {
            $this->price_down_max->addErrorMessage($this->price_down_max->getErrorMessage(false));
        }
        if ($this->discount_max->Required) {
            if (!$this->discount_max->IsDetailKey && EmptyValue($this->discount_max->FormValue)) {
                $this->discount_max->addErrorMessage(str_replace("%s", $this->discount_max->caption(), $this->discount_max->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->discount_max->FormValue)) {
            $this->discount_max->addErrorMessage($this->discount_max->getErrorMessage(false));
        }
        if ($this->price_down_special_max->Required) {
            if (!$this->price_down_special_max->IsDetailKey && EmptyValue($this->price_down_special_max->FormValue)) {
                $this->price_down_special_max->addErrorMessage(str_replace("%s", $this->price_down_special_max->caption(), $this->price_down_special_max->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->price_down_special_max->FormValue)) {
            $this->price_down_special_max->addErrorMessage($this->price_down_special_max->getErrorMessage(false));
        }
        if ($this->usable_area_price_max->Required) {
            if (!$this->usable_area_price_max->IsDetailKey && EmptyValue($this->usable_area_price_max->FormValue)) {
                $this->usable_area_price_max->addErrorMessage(str_replace("%s", $this->usable_area_price_max->caption(), $this->usable_area_price_max->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->usable_area_price_max->FormValue)) {
            $this->usable_area_price_max->addErrorMessage($this->usable_area_price_max->getErrorMessage(false));
        }
        if ($this->land_size_price_max->Required) {
            if (!$this->land_size_price_max->IsDetailKey && EmptyValue($this->land_size_price_max->FormValue)) {
                $this->land_size_price_max->addErrorMessage(str_replace("%s", $this->land_size_price_max->caption(), $this->land_size_price_max->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->land_size_price_max->FormValue)) {
            $this->land_size_price_max->addErrorMessage($this->land_size_price_max->getErrorMessage(false));
        }
        if ($this->reservation_price_max->Required) {
            if (!$this->reservation_price_max->IsDetailKey && EmptyValue($this->reservation_price_max->FormValue)) {
                $this->reservation_price_max->addErrorMessage(str_replace("%s", $this->reservation_price_max->caption(), $this->reservation_price_max->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->reservation_price_max->FormValue)) {
            $this->reservation_price_max->addErrorMessage($this->reservation_price_max->getErrorMessage(false));
        }
        if ($this->minimum_down_payment_max->Required) {
            if (!$this->minimum_down_payment_max->IsDetailKey && EmptyValue($this->minimum_down_payment_max->FormValue)) {
                $this->minimum_down_payment_max->addErrorMessage(str_replace("%s", $this->minimum_down_payment_max->caption(), $this->minimum_down_payment_max->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->minimum_down_payment_max->FormValue)) {
            $this->minimum_down_payment_max->addErrorMessage($this->minimum_down_payment_max->getErrorMessage(false));
        }
        if ($this->down_price_max->Required) {
            if (!$this->down_price_max->IsDetailKey && EmptyValue($this->down_price_max->FormValue)) {
                $this->down_price_max->addErrorMessage(str_replace("%s", $this->down_price_max->caption(), $this->down_price_max->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->down_price_max->FormValue)) {
            $this->down_price_max->addErrorMessage($this->down_price_max->getErrorMessage(false));
        }
        if ($this->down_price->Required) {
            if (!$this->down_price->IsDetailKey && EmptyValue($this->down_price->FormValue)) {
                $this->down_price->addErrorMessage(str_replace("%s", $this->down_price->caption(), $this->down_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->down_price->FormValue)) {
            $this->down_price->addErrorMessage($this->down_price->getErrorMessage(false));
        }
        if ($this->factor_monthly_installment_over_down_max->Required) {
            if (!$this->factor_monthly_installment_over_down_max->IsDetailKey && EmptyValue($this->factor_monthly_installment_over_down_max->FormValue)) {
                $this->factor_monthly_installment_over_down_max->addErrorMessage(str_replace("%s", $this->factor_monthly_installment_over_down_max->caption(), $this->factor_monthly_installment_over_down_max->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->factor_monthly_installment_over_down_max->FormValue)) {
            $this->factor_monthly_installment_over_down_max->addErrorMessage($this->factor_monthly_installment_over_down_max->getErrorMessage(false));
        }
        if ($this->fee_max->Required) {
            if (!$this->fee_max->IsDetailKey && EmptyValue($this->fee_max->FormValue)) {
                $this->fee_max->addErrorMessage(str_replace("%s", $this->fee_max->caption(), $this->fee_max->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->fee_max->FormValue)) {
            $this->fee_max->addErrorMessage($this->fee_max->getErrorMessage(false));
        }
        if ($this->monthly_payment_max->Required) {
            if (!$this->monthly_payment_max->IsDetailKey && EmptyValue($this->monthly_payment_max->FormValue)) {
                $this->monthly_payment_max->addErrorMessage(str_replace("%s", $this->monthly_payment_max->caption(), $this->monthly_payment_max->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->monthly_payment_max->FormValue)) {
            $this->monthly_payment_max->addErrorMessage($this->monthly_payment_max->getErrorMessage(false));
        }
        if ($this->annual_interest_buyer->Required) {
            if (!$this->annual_interest_buyer->IsDetailKey && EmptyValue($this->annual_interest_buyer->FormValue)) {
                $this->annual_interest_buyer->addErrorMessage(str_replace("%s", $this->annual_interest_buyer->caption(), $this->annual_interest_buyer->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->annual_interest_buyer->FormValue)) {
            $this->annual_interest_buyer->addErrorMessage($this->annual_interest_buyer->getErrorMessage(false));
        }
        if ($this->monthly_expense_max->Required) {
            if (!$this->monthly_expense_max->IsDetailKey && EmptyValue($this->monthly_expense_max->FormValue)) {
                $this->monthly_expense_max->addErrorMessage(str_replace("%s", $this->monthly_expense_max->caption(), $this->monthly_expense_max->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->monthly_expense_max->FormValue)) {
            $this->monthly_expense_max->addErrorMessage($this->monthly_expense_max->getErrorMessage(false));
        }
        if ($this->average_rent_max->Required) {
            if (!$this->average_rent_max->IsDetailKey && EmptyValue($this->average_rent_max->FormValue)) {
                $this->average_rent_max->addErrorMessage(str_replace("%s", $this->average_rent_max->caption(), $this->average_rent_max->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->average_rent_max->FormValue)) {
            $this->average_rent_max->addErrorMessage($this->average_rent_max->getErrorMessage(false));
        }
        if ($this->average_down_payment_max->Required) {
            if (!$this->average_down_payment_max->IsDetailKey && EmptyValue($this->average_down_payment_max->FormValue)) {
                $this->average_down_payment_max->addErrorMessage(str_replace("%s", $this->average_down_payment_max->caption(), $this->average_down_payment_max->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->average_down_payment_max->FormValue)) {
            $this->average_down_payment_max->addErrorMessage($this->average_down_payment_max->getErrorMessage(false));
        }
        if ($this->min_down->Required) {
            if (!$this->min_down->IsDetailKey && EmptyValue($this->min_down->FormValue)) {
                $this->min_down->addErrorMessage(str_replace("%s", $this->min_down->caption(), $this->min_down->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->min_down->FormValue)) {
            $this->min_down->addErrorMessage($this->min_down->getErrorMessage(false));
        }
        if ($this->remaining_down->Required) {
            if (!$this->remaining_down->IsDetailKey && EmptyValue($this->remaining_down->FormValue)) {
                $this->remaining_down->addErrorMessage(str_replace("%s", $this->remaining_down->caption(), $this->remaining_down->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->remaining_down->FormValue)) {
            $this->remaining_down->addErrorMessage($this->remaining_down->getErrorMessage(false));
        }
        if ($this->factor_financing->Required) {
            if (!$this->factor_financing->IsDetailKey && EmptyValue($this->factor_financing->FormValue)) {
                $this->factor_financing->addErrorMessage(str_replace("%s", $this->factor_financing->caption(), $this->factor_financing->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->factor_financing->FormValue)) {
            $this->factor_financing->addErrorMessage($this->factor_financing->getErrorMessage(false));
        }
        if ($this->credit_limit_down->Required) {
            if (!$this->credit_limit_down->IsDetailKey && EmptyValue($this->credit_limit_down->FormValue)) {
                $this->credit_limit_down->addErrorMessage(str_replace("%s", $this->credit_limit_down->caption(), $this->credit_limit_down->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->credit_limit_down->FormValue)) {
            $this->credit_limit_down->addErrorMessage($this->credit_limit_down->getErrorMessage(false));
        }
        if ($this->price_down_min->Required) {
            if (!$this->price_down_min->IsDetailKey && EmptyValue($this->price_down_min->FormValue)) {
                $this->price_down_min->addErrorMessage(str_replace("%s", $this->price_down_min->caption(), $this->price_down_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->price_down_min->FormValue)) {
            $this->price_down_min->addErrorMessage($this->price_down_min->getErrorMessage(false));
        }
        if ($this->discount_min->Required) {
            if (!$this->discount_min->IsDetailKey && EmptyValue($this->discount_min->FormValue)) {
                $this->discount_min->addErrorMessage(str_replace("%s", $this->discount_min->caption(), $this->discount_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->discount_min->FormValue)) {
            $this->discount_min->addErrorMessage($this->discount_min->getErrorMessage(false));
        }
        if ($this->price_down_special_min->Required) {
            if (!$this->price_down_special_min->IsDetailKey && EmptyValue($this->price_down_special_min->FormValue)) {
                $this->price_down_special_min->addErrorMessage(str_replace("%s", $this->price_down_special_min->caption(), $this->price_down_special_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->price_down_special_min->FormValue)) {
            $this->price_down_special_min->addErrorMessage($this->price_down_special_min->getErrorMessage(false));
        }
        if ($this->usable_area_price_min->Required) {
            if (!$this->usable_area_price_min->IsDetailKey && EmptyValue($this->usable_area_price_min->FormValue)) {
                $this->usable_area_price_min->addErrorMessage(str_replace("%s", $this->usable_area_price_min->caption(), $this->usable_area_price_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->usable_area_price_min->FormValue)) {
            $this->usable_area_price_min->addErrorMessage($this->usable_area_price_min->getErrorMessage(false));
        }
        if ($this->land_size_price_min->Required) {
            if (!$this->land_size_price_min->IsDetailKey && EmptyValue($this->land_size_price_min->FormValue)) {
                $this->land_size_price_min->addErrorMessage(str_replace("%s", $this->land_size_price_min->caption(), $this->land_size_price_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->land_size_price_min->FormValue)) {
            $this->land_size_price_min->addErrorMessage($this->land_size_price_min->getErrorMessage(false));
        }
        if ($this->reservation_price_min->Required) {
            if (!$this->reservation_price_min->IsDetailKey && EmptyValue($this->reservation_price_min->FormValue)) {
                $this->reservation_price_min->addErrorMessage(str_replace("%s", $this->reservation_price_min->caption(), $this->reservation_price_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->reservation_price_min->FormValue)) {
            $this->reservation_price_min->addErrorMessage($this->reservation_price_min->getErrorMessage(false));
        }
        if ($this->minimum_down_payment_min->Required) {
            if (!$this->minimum_down_payment_min->IsDetailKey && EmptyValue($this->minimum_down_payment_min->FormValue)) {
                $this->minimum_down_payment_min->addErrorMessage(str_replace("%s", $this->minimum_down_payment_min->caption(), $this->minimum_down_payment_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->minimum_down_payment_min->FormValue)) {
            $this->minimum_down_payment_min->addErrorMessage($this->minimum_down_payment_min->getErrorMessage(false));
        }
        if ($this->down_price_min->Required) {
            if (!$this->down_price_min->IsDetailKey && EmptyValue($this->down_price_min->FormValue)) {
                $this->down_price_min->addErrorMessage(str_replace("%s", $this->down_price_min->caption(), $this->down_price_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->down_price_min->FormValue)) {
            $this->down_price_min->addErrorMessage($this->down_price_min->getErrorMessage(false));
        }
        if ($this->remaining_credit_limit_down->Required) {
            if (!$this->remaining_credit_limit_down->IsDetailKey && EmptyValue($this->remaining_credit_limit_down->FormValue)) {
                $this->remaining_credit_limit_down->addErrorMessage(str_replace("%s", $this->remaining_credit_limit_down->caption(), $this->remaining_credit_limit_down->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->remaining_credit_limit_down->FormValue)) {
            $this->remaining_credit_limit_down->addErrorMessage($this->remaining_credit_limit_down->getErrorMessage(false));
        }
        if ($this->fee_min->Required) {
            if (!$this->fee_min->IsDetailKey && EmptyValue($this->fee_min->FormValue)) {
                $this->fee_min->addErrorMessage(str_replace("%s", $this->fee_min->caption(), $this->fee_min->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->fee_min->FormValue)) {
            $this->fee_min->addErrorMessage($this->fee_min->getErrorMessage(false));
        }
        if ($this->monthly_payment_min->Required) {
            if (!$this->monthly_payment_min->IsDetailKey && EmptyValue($this->monthly_payment_min->FormValue)) {
                $this->monthly_payment_min->addErrorMessage(str_replace("%s", $this->monthly_payment_min->caption(), $this->monthly_payment_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->monthly_payment_min->FormValue)) {
            $this->monthly_payment_min->addErrorMessage($this->monthly_payment_min->getErrorMessage(false));
        }
        if ($this->annual_interest_buyer_model_min->Required) {
            if (!$this->annual_interest_buyer_model_min->IsDetailKey && EmptyValue($this->annual_interest_buyer_model_min->FormValue)) {
                $this->annual_interest_buyer_model_min->addErrorMessage(str_replace("%s", $this->annual_interest_buyer_model_min->caption(), $this->annual_interest_buyer_model_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->annual_interest_buyer_model_min->FormValue)) {
            $this->annual_interest_buyer_model_min->addErrorMessage($this->annual_interest_buyer_model_min->getErrorMessage(false));
        }
        if ($this->interest_downpayment_financing->Required) {
            if (!$this->interest_downpayment_financing->IsDetailKey && EmptyValue($this->interest_downpayment_financing->FormValue)) {
                $this->interest_downpayment_financing->addErrorMessage(str_replace("%s", $this->interest_downpayment_financing->caption(), $this->interest_downpayment_financing->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->interest_downpayment_financing->FormValue)) {
            $this->interest_downpayment_financing->addErrorMessage($this->interest_downpayment_financing->getErrorMessage(false));
        }
        if ($this->monthly_expenses_min->Required) {
            if (!$this->monthly_expenses_min->IsDetailKey && EmptyValue($this->monthly_expenses_min->FormValue)) {
                $this->monthly_expenses_min->addErrorMessage(str_replace("%s", $this->monthly_expenses_min->caption(), $this->monthly_expenses_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->monthly_expenses_min->FormValue)) {
            $this->monthly_expenses_min->addErrorMessage($this->monthly_expenses_min->getErrorMessage(false));
        }
        if ($this->average_rent_min->Required) {
            if (!$this->average_rent_min->IsDetailKey && EmptyValue($this->average_rent_min->FormValue)) {
                $this->average_rent_min->addErrorMessage(str_replace("%s", $this->average_rent_min->caption(), $this->average_rent_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->average_rent_min->FormValue)) {
            $this->average_rent_min->addErrorMessage($this->average_rent_min->getErrorMessage(false));
        }
        if ($this->average_down_payment_min->Required) {
            if (!$this->average_down_payment_min->IsDetailKey && EmptyValue($this->average_down_payment_min->FormValue)) {
                $this->average_down_payment_min->addErrorMessage(str_replace("%s", $this->average_down_payment_min->caption(), $this->average_down_payment_min->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->average_down_payment_min->FormValue)) {
            $this->average_down_payment_min->addErrorMessage($this->average_down_payment_min->getErrorMessage(false));
        }
        if ($this->installment_down_payment_loan->Required) {
            if (!$this->installment_down_payment_loan->IsDetailKey && EmptyValue($this->installment_down_payment_loan->FormValue)) {
                $this->installment_down_payment_loan->addErrorMessage(str_replace("%s", $this->installment_down_payment_loan->caption(), $this->installment_down_payment_loan->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->installment_down_payment_loan->FormValue)) {
            $this->installment_down_payment_loan->addErrorMessage($this->installment_down_payment_loan->getErrorMessage(false));
        }
        if ($this->price_invertor->Required) {
            if (!$this->price_invertor->IsDetailKey && EmptyValue($this->price_invertor->FormValue)) {
                $this->price_invertor->addErrorMessage(str_replace("%s", $this->price_invertor->caption(), $this->price_invertor->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->price_invertor->FormValue)) {
            $this->price_invertor->addErrorMessage($this->price_invertor->getErrorMessage(false));
        }
        if ($this->expired_date->Required) {
            if (!$this->expired_date->IsDetailKey && EmptyValue($this->expired_date->FormValue)) {
                $this->expired_date->addErrorMessage(str_replace("%s", $this->expired_date->caption(), $this->expired_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->expired_date->FormValue, $this->expired_date->formatPattern())) {
            $this->expired_date->addErrorMessage($this->expired_date->getErrorMessage(false));
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
        if ($this->uip->Required) {
            if (!$this->uip->IsDetailKey && EmptyValue($this->uip->FormValue)) {
                $this->uip->addErrorMessage(str_replace("%s", $this->uip->caption(), $this->uip->RequiredErrorMessage));
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

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("AssetFacilitiesGrid");
        if (in_array("asset_facilities", $detailTblVar) && $detailPage->DetailAdd) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("AssetProsDetailGrid");
        if (in_array("asset_pros_detail", $detailTblVar) && $detailPage->DetailAdd) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("AssetBannerGrid");
        if (in_array("asset_banner", $detailTblVar) && $detailPage->DetailAdd) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("AssetCategoryGrid");
        if (in_array("asset_category", $detailTblVar) && $detailPage->DetailAdd) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("AssetWarningGrid");
        if (in_array("asset_warning", $detailTblVar) && $detailPage->DetailAdd) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
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

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
            $this->floor_plan->OldUploadPath = './upload/floor_plan';
            $this->floor_plan->UploadPath = $this->floor_plan->OldUploadPath;
            $this->layout_unit->OldUploadPath = './upload/layout_unit';
            $this->layout_unit->UploadPath = $this->layout_unit->OldUploadPath;
        }
        $rsnew = [];

        // title
        $this->_title->setDbValueDef($rsnew, $this->_title->CurrentValue, "", false);

        // title_en
        $this->title_en->setDbValueDef($rsnew, $this->title_en->CurrentValue, null, false);

        // brand_id
        $this->brand_id->setDbValueDef($rsnew, $this->brand_id->CurrentValue, 0, false);

        // detail
        $this->detail->setDbValueDef($rsnew, $this->detail->CurrentValue, null, false);

        // detail_en
        $this->detail_en->setDbValueDef($rsnew, $this->detail_en->CurrentValue, null, false);

        // latitude
        $this->latitude->setDbValueDef($rsnew, $this->latitude->CurrentValue, null, false);

        // longitude
        $this->longitude->setDbValueDef($rsnew, $this->longitude->CurrentValue, null, false);

        // num_buildings
        $this->num_buildings->setDbValueDef($rsnew, $this->num_buildings->CurrentValue, null, false);

        // num_unit
        $this->num_unit->setDbValueDef($rsnew, $this->num_unit->CurrentValue, null, false);

        // num_floors
        $this->num_floors->setDbValueDef($rsnew, $this->num_floors->CurrentValue, null, false);

        // floors
        $this->floors->setDbValueDef($rsnew, $this->floors->CurrentValue, null, false);

        // asset_year_developer
        $this->asset_year_developer->setDbValueDef($rsnew, $this->asset_year_developer->CurrentValue, null, false);

        // num_parking_spaces
        $this->num_parking_spaces->setDbValueDef($rsnew, $this->num_parking_spaces->CurrentValue, null, false);

        // num_bathrooms
        $this->num_bathrooms->setDbValueDef($rsnew, $this->num_bathrooms->CurrentValue, null, false);

        // num_bedrooms
        $this->num_bedrooms->setDbValueDef($rsnew, $this->num_bedrooms->CurrentValue, null, false);

        // address
        $this->address->setDbValueDef($rsnew, $this->address->CurrentValue, null, false);

        // address_en
        $this->address_en->setDbValueDef($rsnew, $this->address_en->CurrentValue, null, false);

        // province_id
        $this->province_id->setDbValueDef($rsnew, $this->province_id->CurrentValue, null, false);

        // amphur_id
        $this->amphur_id->setDbValueDef($rsnew, $this->amphur_id->CurrentValue, null, false);

        // district_id
        $this->district_id->setDbValueDef($rsnew, $this->district_id->CurrentValue, null, false);

        // postcode
        $this->postcode->setDbValueDef($rsnew, $this->postcode->CurrentValue, null, false);

        // floor_plan
        if ($this->floor_plan->Visible && !$this->floor_plan->Upload->KeepFile) {
            $this->floor_plan->Upload->DbValue = ""; // No need to delete old file
            if ($this->floor_plan->Upload->FileName == "") {
                $rsnew['floor_plan'] = null;
            } else {
                $rsnew['floor_plan'] = $this->floor_plan->Upload->FileName;
            }
        }

        // layout_unit
        if ($this->layout_unit->Visible && !$this->layout_unit->Upload->KeepFile) {
            $this->layout_unit->Upload->DbValue = ""; // No need to delete old file
            if ($this->layout_unit->Upload->FileName == "") {
                $rsnew['layout_unit'] = null;
            } else {
                $rsnew['layout_unit'] = $this->layout_unit->Upload->FileName;
            }
        }

        // asset_website
        $this->asset_website->setDbValueDef($rsnew, $this->asset_website->CurrentValue, null, false);

        // asset_review
        $this->asset_review->setDbValueDef($rsnew, $this->asset_review->CurrentValue, null, false);

        // isactive
        $this->isactive->setDbValueDef($rsnew, $this->isactive->CurrentValue, null, false);

        // is_recommend
        $this->is_recommend->setDbValueDef($rsnew, $this->is_recommend->CurrentValue, 0, strval($this->is_recommend->CurrentValue) == "");

        // order_by
        $this->order_by->setDbValueDef($rsnew, $this->order_by->CurrentValue, null, false);

        // type_pay
        $this->type_pay->setDbValueDef($rsnew, $this->type_pay->CurrentValue, null, strval($this->type_pay->CurrentValue) == "");

        // type_pay_2
        $this->type_pay_2->setDbValueDef($rsnew, $this->type_pay_2->CurrentValue, null, strval($this->type_pay_2->CurrentValue) == "");

        // price_mark
        $this->price_mark->setDbValueDef($rsnew, $this->price_mark->CurrentValue, null, false);

        // holding_property
        $this->holding_property->setDbValueDef($rsnew, $this->holding_property->CurrentValue, null, false);

        // common_fee
        $this->common_fee->setDbValueDef($rsnew, $this->common_fee->CurrentValue, null, false);

        // usable_area
        $this->usable_area->setDbValueDef($rsnew, $this->usable_area->CurrentValue, null, false);

        // usable_area_price
        $this->usable_area_price->setDbValueDef($rsnew, $this->usable_area_price->CurrentValue, null, false);

        // land_size
        $this->land_size->setDbValueDef($rsnew, $this->land_size->CurrentValue, null, false);

        // land_size_price
        $this->land_size_price->setDbValueDef($rsnew, $this->land_size_price->CurrentValue, null, false);

        // commission
        $this->commission->setDbValueDef($rsnew, $this->commission->CurrentValue, null, false);

        // transfer_day_expenses_with_business_tax
        $this->transfer_day_expenses_with_business_tax->setDbValueDef($rsnew, $this->transfer_day_expenses_with_business_tax->CurrentValue, null, false);

        // transfer_day_expenses_without_business_tax
        $this->transfer_day_expenses_without_business_tax->setDbValueDef($rsnew, $this->transfer_day_expenses_without_business_tax->CurrentValue, null, false);

        // price
        $this->price->setDbValueDef($rsnew, $this->price->CurrentValue, null, false);

        // discount
        $this->discount->setDbValueDef($rsnew, $this->discount->CurrentValue, null, false);

        // price_special
        $this->price_special->setDbValueDef($rsnew, $this->price_special->CurrentValue, null, false);

        // reservation_price_model_a
        $this->reservation_price_model_a->setDbValueDef($rsnew, $this->reservation_price_model_a->CurrentValue, null, false);

        // minimum_down_payment_model_a
        $this->minimum_down_payment_model_a->setDbValueDef($rsnew, $this->minimum_down_payment_model_a->CurrentValue, null, false);

        // down_price_min_a
        $this->down_price_min_a->setDbValueDef($rsnew, $this->down_price_min_a->CurrentValue, null, false);

        // down_price_model_a
        $this->down_price_model_a->setDbValueDef($rsnew, $this->down_price_model_a->CurrentValue, null, false);

        // factor_monthly_installment_over_down
        $this->factor_monthly_installment_over_down->setDbValueDef($rsnew, $this->factor_monthly_installment_over_down->CurrentValue, null, false);

        // fee_a
        $this->fee_a->setDbValueDef($rsnew, $this->fee_a->CurrentValue, null, false);

        // monthly_payment_buyer
        $this->monthly_payment_buyer->setDbValueDef($rsnew, $this->monthly_payment_buyer->CurrentValue, null, false);

        // annual_interest_buyer_model_a
        $this->annual_interest_buyer_model_a->setDbValueDef($rsnew, $this->annual_interest_buyer_model_a->CurrentValue, null, false);

        // monthly_expenses_a
        $this->monthly_expenses_a->setDbValueDef($rsnew, $this->monthly_expenses_a->CurrentValue, null, false);

        // average_rent_a
        $this->average_rent_a->setDbValueDef($rsnew, $this->average_rent_a->CurrentValue, null, false);

        // average_down_payment_a
        $this->average_down_payment_a->setDbValueDef($rsnew, $this->average_down_payment_a->CurrentValue, null, false);

        // transfer_day_expenses_without_business_tax_max_min
        $this->transfer_day_expenses_without_business_tax_max_min->setDbValueDef($rsnew, $this->transfer_day_expenses_without_business_tax_max_min->CurrentValue, null, false);

        // transfer_day_expenses_with_business_tax_max_min
        $this->transfer_day_expenses_with_business_tax_max_min->setDbValueDef($rsnew, $this->transfer_day_expenses_with_business_tax_max_min->CurrentValue, null, false);

        // bank_appraisal_price
        $this->bank_appraisal_price->setDbValueDef($rsnew, $this->bank_appraisal_price->CurrentValue, null, false);

        // mark_up_price
        $this->mark_up_price->setDbValueDef($rsnew, $this->mark_up_price->CurrentValue, null, false);

        // required_gap
        $this->required_gap->setDbValueDef($rsnew, $this->required_gap->CurrentValue, null, false);

        // minimum_down_payment
        $this->minimum_down_payment->setDbValueDef($rsnew, $this->minimum_down_payment->CurrentValue, null, false);

        // price_down_max
        $this->price_down_max->setDbValueDef($rsnew, $this->price_down_max->CurrentValue, null, false);

        // discount_max
        $this->discount_max->setDbValueDef($rsnew, $this->discount_max->CurrentValue, null, false);

        // price_down_special_max
        $this->price_down_special_max->setDbValueDef($rsnew, $this->price_down_special_max->CurrentValue, null, false);

        // usable_area_price_max
        $this->usable_area_price_max->setDbValueDef($rsnew, $this->usable_area_price_max->CurrentValue, null, false);

        // land_size_price_max
        $this->land_size_price_max->setDbValueDef($rsnew, $this->land_size_price_max->CurrentValue, null, false);

        // reservation_price_max
        $this->reservation_price_max->setDbValueDef($rsnew, $this->reservation_price_max->CurrentValue, null, false);

        // minimum_down_payment_max
        $this->minimum_down_payment_max->setDbValueDef($rsnew, $this->minimum_down_payment_max->CurrentValue, null, false);

        // down_price_max
        $this->down_price_max->setDbValueDef($rsnew, $this->down_price_max->CurrentValue, null, false);

        // down_price
        $this->down_price->setDbValueDef($rsnew, $this->down_price->CurrentValue, null, false);

        // factor_monthly_installment_over_down_max
        $this->factor_monthly_installment_over_down_max->setDbValueDef($rsnew, $this->factor_monthly_installment_over_down_max->CurrentValue, null, false);

        // fee_max
        $this->fee_max->setDbValueDef($rsnew, $this->fee_max->CurrentValue, null, false);

        // monthly_payment_max
        $this->monthly_payment_max->setDbValueDef($rsnew, $this->monthly_payment_max->CurrentValue, null, false);

        // annual_interest_buyer
        $this->annual_interest_buyer->setDbValueDef($rsnew, $this->annual_interest_buyer->CurrentValue, null, false);

        // monthly_expense_max
        $this->monthly_expense_max->setDbValueDef($rsnew, $this->monthly_expense_max->CurrentValue, null, false);

        // average_rent_max
        $this->average_rent_max->setDbValueDef($rsnew, $this->average_rent_max->CurrentValue, null, false);

        // average_down_payment_max
        $this->average_down_payment_max->setDbValueDef($rsnew, $this->average_down_payment_max->CurrentValue, null, false);

        // min_down
        $this->min_down->setDbValueDef($rsnew, $this->min_down->CurrentValue, null, false);

        // remaining_down
        $this->remaining_down->setDbValueDef($rsnew, $this->remaining_down->CurrentValue, null, false);

        // factor_financing
        $this->factor_financing->setDbValueDef($rsnew, $this->factor_financing->CurrentValue, null, false);

        // credit_limit_down
        $this->credit_limit_down->setDbValueDef($rsnew, $this->credit_limit_down->CurrentValue, null, false);

        // price_down_min
        $this->price_down_min->setDbValueDef($rsnew, $this->price_down_min->CurrentValue, null, false);

        // discount_min
        $this->discount_min->setDbValueDef($rsnew, $this->discount_min->CurrentValue, null, false);

        // price_down_special_min
        $this->price_down_special_min->setDbValueDef($rsnew, $this->price_down_special_min->CurrentValue, null, false);

        // usable_area_price_min
        $this->usable_area_price_min->setDbValueDef($rsnew, $this->usable_area_price_min->CurrentValue, null, false);

        // land_size_price_min
        $this->land_size_price_min->setDbValueDef($rsnew, $this->land_size_price_min->CurrentValue, null, false);

        // reservation_price_min
        $this->reservation_price_min->setDbValueDef($rsnew, $this->reservation_price_min->CurrentValue, null, false);

        // minimum_down_payment_min
        $this->minimum_down_payment_min->setDbValueDef($rsnew, $this->minimum_down_payment_min->CurrentValue, null, false);

        // down_price_min
        $this->down_price_min->setDbValueDef($rsnew, $this->down_price_min->CurrentValue, null, false);

        // remaining_credit_limit_down
        $this->remaining_credit_limit_down->setDbValueDef($rsnew, $this->remaining_credit_limit_down->CurrentValue, null, false);

        // fee_min
        $this->fee_min->setDbValueDef($rsnew, $this->fee_min->CurrentValue, null, false);

        // monthly_payment_min
        $this->monthly_payment_min->setDbValueDef($rsnew, $this->monthly_payment_min->CurrentValue, null, false);

        // annual_interest_buyer_model_min
        $this->annual_interest_buyer_model_min->setDbValueDef($rsnew, $this->annual_interest_buyer_model_min->CurrentValue, null, false);

        // interest_down-payment_financing
        $this->interest_downpayment_financing->setDbValueDef($rsnew, $this->interest_downpayment_financing->CurrentValue, null, false);

        // monthly_expenses_min
        $this->monthly_expenses_min->setDbValueDef($rsnew, $this->monthly_expenses_min->CurrentValue, null, false);

        // average_rent_min
        $this->average_rent_min->setDbValueDef($rsnew, $this->average_rent_min->CurrentValue, null, false);

        // average_down_payment_min
        $this->average_down_payment_min->setDbValueDef($rsnew, $this->average_down_payment_min->CurrentValue, null, false);

        // installment_down_payment_loan
        $this->installment_down_payment_loan->setDbValueDef($rsnew, $this->installment_down_payment_loan->CurrentValue, null, false);

        // price_invertor
        $this->price_invertor->setDbValueDef($rsnew, $this->price_invertor->CurrentValue, null, false);

        // expired_date
        $this->expired_date->setDbValueDef($rsnew, UnFormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern()), null, false);

        // cdate
        $this->cdate->CurrentValue = CurrentDateTime();
        $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

        // cuser
        $this->cuser->CurrentValue = CurrentUserID();
        $this->cuser->setDbValueDef($rsnew, $this->cuser->CurrentValue, null);

        // cip
        $this->cip->CurrentValue = CurrentUserIP();
        $this->cip->setDbValueDef($rsnew, $this->cip->CurrentValue, null);

        // uip
        $this->uip->CurrentValue = CurrentUserIP();
        $this->uip->setDbValueDef($rsnew, $this->uip->CurrentValue, null);

        // udate
        $this->udate->CurrentValue = CurrentDateTime();
        $this->udate->setDbValueDef($rsnew, $this->udate->CurrentValue, null);

        // uuser
        $this->uuser->CurrentValue = CurrentUserID();
        $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, null);

        // asset_id
        if ($this->asset_id->getSessionValue() != "") {
            $rsnew['asset_id'] = $this->asset_id->getSessionValue();
        }
        if ($this->floor_plan->Visible && !$this->floor_plan->Upload->KeepFile) {
            $this->floor_plan->UploadPath = './upload/floor_plan';
            $oldFiles = EmptyValue($this->floor_plan->Upload->DbValue) ? [] : [$this->floor_plan->htmlDecode($this->floor_plan->Upload->DbValue)];
            if (!EmptyValue($this->floor_plan->Upload->FileName)) {
                $newFiles = [$this->floor_plan->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->floor_plan, $this->floor_plan->Upload->Index);
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
                            $file1 = UniqueFilename($this->floor_plan->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->floor_plan->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->floor_plan->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->floor_plan->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->floor_plan->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->floor_plan->setDbValueDef($rsnew, $this->floor_plan->Upload->FileName, null, false);
            }
        }
        if ($this->layout_unit->Visible && !$this->layout_unit->Upload->KeepFile) {
            $this->layout_unit->UploadPath = './upload/layout_unit';
            $oldFiles = EmptyValue($this->layout_unit->Upload->DbValue) ? [] : [$this->layout_unit->htmlDecode($this->layout_unit->Upload->DbValue)];
            if (!EmptyValue($this->layout_unit->Upload->FileName)) {
                $newFiles = [$this->layout_unit->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->layout_unit, $this->layout_unit->Upload->Index);
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
                            $file1 = UniqueFilename($this->layout_unit->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->layout_unit->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->layout_unit->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->layout_unit->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->layout_unit->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->layout_unit->setDbValueDef($rsnew, $this->layout_unit->Upload->FileName, null, false);
            }
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->floor_plan->Visible && !$this->floor_plan->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->floor_plan->Upload->DbValue) ? [] : [$this->floor_plan->htmlDecode($this->floor_plan->Upload->DbValue)];
                    if (!EmptyValue($this->floor_plan->Upload->FileName)) {
                        $newFiles = [$this->floor_plan->Upload->FileName];
                        $newFiles2 = [$this->floor_plan->htmlDecode($rsnew['floor_plan'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->floor_plan, $this->floor_plan->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->floor_plan->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->floor_plan->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->layout_unit->Visible && !$this->layout_unit->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->layout_unit->Upload->DbValue) ? [] : [$this->layout_unit->htmlDecode($this->layout_unit->Upload->DbValue)];
                    if (!EmptyValue($this->layout_unit->Upload->FileName)) {
                        $newFiles = [$this->layout_unit->Upload->FileName];
                        $newFiles2 = [$this->layout_unit->htmlDecode($rsnew['layout_unit'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->layout_unit, $this->layout_unit->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->layout_unit->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->layout_unit->oldPhysicalUploadPath() . $oldFile);
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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("AssetFacilitiesGrid");
            if (in_array("asset_facilities", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->asset_id->setSessionValue($this->asset_id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "asset_facilities"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->asset_id->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("AssetProsDetailGrid");
            if (in_array("asset_pros_detail", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->asset_id->setSessionValue($this->asset_id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "asset_pros_detail"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->asset_id->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("AssetBannerGrid");
            if (in_array("asset_banner", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->asset_id->setSessionValue($this->asset_id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "asset_banner"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->asset_id->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("AssetCategoryGrid");
            if (in_array("asset_category", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->asset_id->setSessionValue($this->asset_id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "asset_category"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->asset_id->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("AssetWarningGrid");
            if (in_array("asset_warning", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->asset_id->setSessionValue($this->asset_id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "asset_warning"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->asset_id->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                if ($this->UseTransaction) { // Commit transaction
                    $conn->commit();
                }
            } else {
                if ($this->UseTransaction) { // Rollback transaction
                    $conn->rollback();
                }
            }
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // floor_plan
            CleanUploadTempPath($this->floor_plan, $this->floor_plan->Upload->Index);

            // layout_unit
            CleanUploadTempPath($this->layout_unit, $this->layout_unit->Upload->Index);
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
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

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
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

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
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

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
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

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
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

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
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
