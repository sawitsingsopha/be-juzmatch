<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class AssetGrid extends Asset
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'asset';

    // Page object name
    public $PageObjName = "AssetGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fassetgrid";
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

        // Table object (asset)
        if (!isset($GLOBALS["asset"]) || get_class($GLOBALS["asset"]) == PROJECT_NAMESPACE . "asset") {
            $GLOBALS["asset"] = &$this;
        }
        $this->AddUrl = "assetadd";

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
            $this->uip->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->udate->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->uuser->Visible = false;
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
        $this->asset_id->Visible = false;
        $this->_title->setVisibility();
        $this->title_en->Visible = false;
        $this->brand_id->setVisibility();
        $this->asset_short_detail->Visible = false;
        $this->asset_short_detail_en->Visible = false;
        $this->detail->Visible = false;
        $this->detail_en->Visible = false;
        $this->asset_code->setVisibility();
        $this->asset_status->setVisibility();
        $this->latitude->Visible = false;
        $this->longitude->Visible = false;
        $this->num_buildings->Visible = false;
        $this->num_unit->Visible = false;
        $this->num_floors->Visible = false;
        $this->floors->Visible = false;
        $this->asset_year_developer->Visible = false;
        $this->num_parking_spaces->Visible = false;
        $this->num_bathrooms->Visible = false;
        $this->num_bedrooms->Visible = false;
        $this->address->Visible = false;
        $this->address_en->Visible = false;
        $this->province_id->Visible = false;
        $this->amphur_id->Visible = false;
        $this->district_id->Visible = false;
        $this->postcode->Visible = false;
        $this->floor_plan->Visible = false;
        $this->layout_unit->Visible = false;
        $this->asset_website->Visible = false;
        $this->asset_review->Visible = false;
        $this->isactive->setVisibility();
        $this->is_recommend->Visible = false;
        $this->order_by->Visible = false;
        $this->type_pay->Visible = false;
        $this->type_pay_2->Visible = false;
        $this->price_mark->setVisibility();
        $this->holding_property->Visible = false;
        $this->common_fee->Visible = false;
        $this->usable_area->setVisibility();
        $this->usable_area_price->Visible = false;
        $this->land_size->setVisibility();
        $this->land_size_price->Visible = false;
        $this->commission->Visible = false;
        $this->transfer_day_expenses_with_business_tax->Visible = false;
        $this->transfer_day_expenses_without_business_tax->Visible = false;
        $this->price->Visible = false;
        $this->discount->Visible = false;
        $this->price_special->Visible = false;
        $this->reservation_price_model_a->Visible = false;
        $this->minimum_down_payment_model_a->Visible = false;
        $this->down_price_min_a->Visible = false;
        $this->down_price_model_a->Visible = false;
        $this->factor_monthly_installment_over_down->Visible = false;
        $this->fee_a->Visible = false;
        $this->monthly_payment_buyer->Visible = false;
        $this->annual_interest_buyer_model_a->Visible = false;
        $this->monthly_expenses_a->Visible = false;
        $this->average_rent_a->Visible = false;
        $this->average_down_payment_a->Visible = false;
        $this->transfer_day_expenses_without_business_tax_max_min->Visible = false;
        $this->transfer_day_expenses_with_business_tax_max_min->Visible = false;
        $this->bank_appraisal_price->Visible = false;
        $this->mark_up_price->Visible = false;
        $this->required_gap->Visible = false;
        $this->minimum_down_payment->Visible = false;
        $this->price_down_max->Visible = false;
        $this->discount_max->Visible = false;
        $this->price_down_special_max->Visible = false;
        $this->usable_area_price_max->Visible = false;
        $this->land_size_price_max->Visible = false;
        $this->reservation_price_max->Visible = false;
        $this->minimum_down_payment_max->Visible = false;
        $this->down_price_max->Visible = false;
        $this->down_price->Visible = false;
        $this->factor_monthly_installment_over_down_max->Visible = false;
        $this->fee_max->Visible = false;
        $this->monthly_payment_max->Visible = false;
        $this->annual_interest_buyer->Visible = false;
        $this->monthly_expense_max->Visible = false;
        $this->average_rent_max->Visible = false;
        $this->average_down_payment_max->Visible = false;
        $this->min_down->Visible = false;
        $this->remaining_down->Visible = false;
        $this->factor_financing->Visible = false;
        $this->credit_limit_down->Visible = false;
        $this->price_down_min->Visible = false;
        $this->discount_min->Visible = false;
        $this->price_down_special_min->Visible = false;
        $this->usable_area_price_min->Visible = false;
        $this->land_size_price_min->Visible = false;
        $this->reservation_price_min->Visible = false;
        $this->minimum_down_payment_min->Visible = false;
        $this->down_price_min->Visible = false;
        $this->remaining_credit_limit_down->Visible = false;
        $this->fee_min->Visible = false;
        $this->monthly_payment_min->Visible = false;
        $this->annual_interest_buyer_model_min->Visible = false;
        $this->interest_downpayment_financing->Visible = false;
        $this->monthly_expenses_min->Visible = false;
        $this->average_rent_min->Visible = false;
        $this->average_down_payment_min->Visible = false;
        $this->installment_down_payment_loan->Visible = false;
        $this->count_view->setVisibility();
        $this->count_favorite->setVisibility();
        $this->price_invertor->Visible = false;
        $this->installment_price->Visible = false;
        $this->installment_all->Visible = false;
        $this->master_calculator->Visible = false;
        $this->expired_date->setVisibility();
        $this->tag->Visible = false;
        $this->cdate->setVisibility();
        $this->cuser->Visible = false;
        $this->cip->Visible = false;
        $this->uip->Visible = false;
        $this->udate->Visible = false;
        $this->uuser->Visible = false;
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
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "sale_asset") {
            $masterTbl = Container("sale_asset");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = count($rsmaster) > 0;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("saleassetlist"); // Return to master page
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
        $this->price_mark->FormValue = ""; // Clear form value
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
                    $key .= $this->asset_id->CurrentValue;

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
        if ($CurrentForm->hasValue("x__title") && $CurrentForm->hasValue("o__title") && $this->_title->CurrentValue != $this->_title->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_brand_id") && $CurrentForm->hasValue("o_brand_id") && $this->brand_id->CurrentValue != $this->brand_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_asset_code") && $CurrentForm->hasValue("o_asset_code") && $this->asset_code->CurrentValue != $this->asset_code->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_asset_status") && $CurrentForm->hasValue("o_asset_status") && $this->asset_status->CurrentValue != $this->asset_status->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_isactive") && $CurrentForm->hasValue("o_isactive") && $this->isactive->CurrentValue != $this->isactive->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_price_mark") && $CurrentForm->hasValue("o_price_mark") && $this->price_mark->CurrentValue != $this->price_mark->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_usable_area") && $CurrentForm->hasValue("o_usable_area") && $this->usable_area->CurrentValue != $this->usable_area->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_land_size") && $CurrentForm->hasValue("o_land_size") && $this->land_size->CurrentValue != $this->land_size->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_count_view") && $CurrentForm->hasValue("o_count_view") && $this->count_view->CurrentValue != $this->count_view->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_count_favorite") && $CurrentForm->hasValue("o_count_favorite") && $this->count_favorite->CurrentValue != $this->count_favorite->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_expired_date") && $CurrentForm->hasValue("o_expired_date") && $this->expired_date->CurrentValue != $this->expired_date->OldValue) {
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
        $this->_title->clearErrorMessage();
        $this->brand_id->clearErrorMessage();
        $this->asset_code->clearErrorMessage();
        $this->asset_status->clearErrorMessage();
        $this->isactive->clearErrorMessage();
        $this->price_mark->clearErrorMessage();
        $this->usable_area->clearErrorMessage();
        $this->land_size->clearErrorMessage();
        $this->count_view->clearErrorMessage();
        $this->count_favorite->clearErrorMessage();
        $this->expired_date->clearErrorMessage();
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
            $this->DefaultSort = "`cdate` DESC";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($this->cdate->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($useDefaultSort) {
                    $this->cdate->setSort("DESC");
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
                        $this->asset_id->setSessionValue("");
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

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = false;

        // "sequence"
        $item = &$this->ListOptions->add("sequence");
        $item->CssClass = "text-nowrap";
        $item->Visible = true;
        $item->OnLeft = true; // Always on left
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
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Set up list options (extensions)
    protected function setupListOptionsExt()
    {
            // Set up list options (to be implemented by extensions)
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
                if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-ew-action=\"delete-grid-row\" data-rowindex=\"" . $this->RowIndex . "\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }

        // "sequence"
        $opt = $this->ListOptions["sequence"];
        $opt->Body = FormatSequenceNumber($this->RecordCount);
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

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
                $opt->Body = "<a class=\"ew-row-link ew-delete\" data-ew-action=\"\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("DeleteLink") . "</a>";
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
        $this->asset_status->OldValue = $this->asset_status->CurrentValue;
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
        $this->floor_plan->Upload->Index = $this->RowIndex;
        $this->layout_unit->Upload->DbValue = null;
        $this->layout_unit->OldValue = $this->layout_unit->Upload->DbValue;
        $this->layout_unit->Upload->Index = $this->RowIndex;
        $this->asset_website->CurrentValue = null;
        $this->asset_website->OldValue = $this->asset_website->CurrentValue;
        $this->asset_review->CurrentValue = null;
        $this->asset_review->OldValue = $this->asset_review->CurrentValue;
        $this->isactive->CurrentValue = 1;
        $this->isactive->OldValue = $this->isactive->CurrentValue;
        $this->is_recommend->CurrentValue = 0;
        $this->is_recommend->OldValue = $this->is_recommend->CurrentValue;
        $this->order_by->CurrentValue = null;
        $this->order_by->OldValue = $this->order_by->CurrentValue;
        $this->type_pay->CurrentValue = 0;
        $this->type_pay->OldValue = $this->type_pay->CurrentValue;
        $this->type_pay_2->CurrentValue = 0;
        $this->type_pay_2->OldValue = $this->type_pay_2->CurrentValue;
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
        $this->count_view->OldValue = $this->count_view->CurrentValue;
        $this->count_favorite->CurrentValue = 0;
        $this->count_favorite->OldValue = $this->count_favorite->CurrentValue;
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
        $this->update_expired_status->OldValue = $this->update_expired_status->CurrentValue;
        $this->update_expired_date->CurrentValue = null;
        $this->update_expired_date->OldValue = $this->update_expired_date->CurrentValue;
        $this->update_expired_ip->CurrentValue = null;
        $this->update_expired_ip->OldValue = $this->update_expired_ip->CurrentValue;
        $this->is_cancel_contract->CurrentValue = 0;
        $this->is_cancel_contract->OldValue = $this->is_cancel_contract->CurrentValue;
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
        $CurrentForm->FormName = $this->FormName;
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
        if ($CurrentForm->hasValue("o__title")) {
            $this->_title->setOldValue($CurrentForm->getValue("o__title"));
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
        if ($CurrentForm->hasValue("o_brand_id")) {
            $this->brand_id->setOldValue($CurrentForm->getValue("o_brand_id"));
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

        // Check field name 'asset_status' first before field var 'x_asset_status'
        $val = $CurrentForm->hasValue("asset_status") ? $CurrentForm->getValue("asset_status") : $CurrentForm->getValue("x_asset_status");
        if (!$this->asset_status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_status->Visible = false; // Disable update for API request
            } else {
                $this->asset_status->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_asset_status")) {
            $this->asset_status->setOldValue($CurrentForm->getValue("o_asset_status"));
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
        if ($CurrentForm->hasValue("o_isactive")) {
            $this->isactive->setOldValue($CurrentForm->getValue("o_isactive"));
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
        if ($CurrentForm->hasValue("o_price_mark")) {
            $this->price_mark->setOldValue($CurrentForm->getValue("o_price_mark"));
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
        if ($CurrentForm->hasValue("o_usable_area")) {
            $this->usable_area->setOldValue($CurrentForm->getValue("o_usable_area"));
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
        if ($CurrentForm->hasValue("o_land_size")) {
            $this->land_size->setOldValue($CurrentForm->getValue("o_land_size"));
        }

        // Check field name 'count_view' first before field var 'x_count_view'
        $val = $CurrentForm->hasValue("count_view") ? $CurrentForm->getValue("count_view") : $CurrentForm->getValue("x_count_view");
        if (!$this->count_view->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->count_view->Visible = false; // Disable update for API request
            } else {
                $this->count_view->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_count_view")) {
            $this->count_view->setOldValue($CurrentForm->getValue("o_count_view"));
        }

        // Check field name 'count_favorite' first before field var 'x_count_favorite'
        $val = $CurrentForm->hasValue("count_favorite") ? $CurrentForm->getValue("count_favorite") : $CurrentForm->getValue("x_count_favorite");
        if (!$this->count_favorite->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->count_favorite->Visible = false; // Disable update for API request
            } else {
                $this->count_favorite->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_count_favorite")) {
            $this->count_favorite->setOldValue($CurrentForm->getValue("o_count_favorite"));
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
        if ($CurrentForm->hasValue("o_expired_date")) {
            $this->expired_date->setOldValue($CurrentForm->getValue("o_expired_date"));
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

        // Check field name 'asset_id' first before field var 'x_asset_id'
        $val = $CurrentForm->hasValue("asset_id") ? $CurrentForm->getValue("asset_id") : $CurrentForm->getValue("x_asset_id");
        if (!$this->asset_id->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->asset_id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->asset_id->CurrentValue = $this->asset_id->FormValue;
        }
        $this->_title->CurrentValue = $this->_title->FormValue;
        $this->brand_id->CurrentValue = $this->brand_id->FormValue;
        $this->asset_code->CurrentValue = $this->asset_code->FormValue;
        $this->asset_status->CurrentValue = $this->asset_status->FormValue;
        $this->isactive->CurrentValue = $this->isactive->FormValue;
        $this->price_mark->CurrentValue = $this->price_mark->FormValue;
        $this->usable_area->CurrentValue = $this->usable_area->FormValue;
        $this->land_size->CurrentValue = $this->land_size->FormValue;
        $this->count_view->CurrentValue = $this->count_view->FormValue;
        $this->count_favorite->CurrentValue = $this->count_favorite->FormValue;
        $this->expired_date->CurrentValue = $this->expired_date->FormValue;
        $this->expired_date->CurrentValue = UnFormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern());
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
        $this->floor_plan->Upload->Index = $this->RowIndex;
        $this->layout_unit->Upload->DbValue = $row['layout_unit'];
        $this->layout_unit->setDbValue($this->layout_unit->Upload->DbValue);
        $this->layout_unit->Upload->Index = $this->RowIndex;
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // asset_id

        // title

        // title_en

        // brand_id

        // asset_short_detail
        $this->asset_short_detail->CellCssStyle = "white-space: nowrap;";

        // asset_short_detail_en
        $this->asset_short_detail_en->CellCssStyle = "white-space: nowrap;";

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
        $this->installment_price->CellCssStyle = "white-space: nowrap;";

        // installment_all
        $this->installment_all->CellCssStyle = "white-space: nowrap;";

        // master_calculator
        $this->master_calculator->CellCssStyle = "white-space: nowrap;";

        // expired_date

        // tag
        $this->tag->CellCssStyle = "white-space: nowrap;";

        // cdate

        // cuser

        // cip

        // uip

        // udate

        // uuser

        // update_expired_key
        $this->update_expired_key->CellCssStyle = "white-space: nowrap;";

        // update_expired_status
        $this->update_expired_status->CellCssStyle = "white-space: nowrap;";

        // update_expired_date
        $this->update_expired_date->CellCssStyle = "white-space: nowrap;";

        // update_expired_ip
        $this->update_expired_ip->CellCssStyle = "white-space: nowrap;";

        // is_cancel_contract
        $this->is_cancel_contract->CellCssStyle = "white-space: nowrap;";

        // cancel_contract_reason
        $this->cancel_contract_reason->CellCssStyle = "white-space: nowrap;";

        // cancel_contract_reason_detail
        $this->cancel_contract_reason_detail->CellCssStyle = "white-space: nowrap;";

        // cancel_contract_date
        $this->cancel_contract_date->CellCssStyle = "white-space: nowrap;";

        // cancel_contract_user
        $this->cancel_contract_user->CellCssStyle = "white-space: nowrap;";

        // cancel_contract_ip
        $this->cancel_contract_ip->CellCssStyle = "white-space: nowrap;";

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
            if (!$this->isExport()) {
                $this->_title->ViewValue = $this->highlightValue($this->_title);
            }

            // brand_id
            $this->brand_id->LinkCustomAttributes = "";
            $this->brand_id->HrefValue = "";
            $this->brand_id->TooltipValue = "";

            // asset_code
            $this->asset_code->LinkCustomAttributes = "";
            $this->asset_code->HrefValue = "";
            $this->asset_code->TooltipValue = "";
            if (!$this->isExport()) {
                $this->asset_code->ViewValue = $this->highlightValue($this->asset_code);
            }

            // asset_status
            $this->asset_status->LinkCustomAttributes = "";
            $this->asset_status->HrefValue = "";
            $this->asset_status->TooltipValue = "";

            // isactive
            $this->isactive->LinkCustomAttributes = "";
            $this->isactive->HrefValue = "";
            $this->isactive->TooltipValue = "";

            // price_mark
            $this->price_mark->LinkCustomAttributes = "";
            $this->price_mark->HrefValue = "";
            $this->price_mark->TooltipValue = "";

            // usable_area
            $this->usable_area->LinkCustomAttributes = "";
            $this->usable_area->HrefValue = "";
            $this->usable_area->TooltipValue = "";

            // land_size
            $this->land_size->LinkCustomAttributes = "";
            $this->land_size->HrefValue = "";
            $this->land_size->TooltipValue = "";

            // count_view
            $this->count_view->LinkCustomAttributes = "";
            $this->count_view->HrefValue = "";
            $this->count_view->TooltipValue = "";

            // count_favorite
            $this->count_favorite->LinkCustomAttributes = "";
            $this->count_favorite->HrefValue = "";
            $this->count_favorite->TooltipValue = "";

            // expired_date
            $this->expired_date->LinkCustomAttributes = "";
            $this->expired_date->HrefValue = "";
            $this->expired_date->TooltipValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
            $this->cdate->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // title
            $this->_title->setupEditAttributes();
            $this->_title->EditCustomAttributes = "";
            if (!$this->_title->Raw) {
                $this->_title->CurrentValue = HtmlDecode($this->_title->CurrentValue);
            }
            $this->_title->EditValue = HtmlEncode($this->_title->CurrentValue);
            $this->_title->PlaceHolder = RemoveHtml($this->_title->caption());

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

            // asset_code
            $this->asset_code->setupEditAttributes();
            $this->asset_code->EditCustomAttributes = "";
            if (!$this->asset_code->Raw) {
                $this->asset_code->CurrentValue = HtmlDecode($this->asset_code->CurrentValue);
            }
            $this->asset_code->EditValue = HtmlEncode($this->asset_code->CurrentValue);
            $this->asset_code->PlaceHolder = RemoveHtml($this->asset_code->caption());

            // asset_status
            $this->asset_status->setupEditAttributes();
            $this->asset_status->EditCustomAttributes = "";
            $this->asset_status->EditValue = $this->asset_status->options(true);
            $this->asset_status->PlaceHolder = RemoveHtml($this->asset_status->caption());

            // isactive
            $this->isactive->EditCustomAttributes = "";
            $this->isactive->EditValue = $this->isactive->options(false);
            $this->isactive->PlaceHolder = RemoveHtml($this->isactive->caption());

            // price_mark
            $this->price_mark->setupEditAttributes();
            $this->price_mark->EditCustomAttributes = "";
            $this->price_mark->EditValue = HtmlEncode($this->price_mark->CurrentValue);
            $this->price_mark->PlaceHolder = RemoveHtml($this->price_mark->caption());
            if (strval($this->price_mark->EditValue) != "" && is_numeric($this->price_mark->EditValue)) {
                $this->price_mark->EditValue = FormatNumber($this->price_mark->EditValue, null);
                $this->price_mark->OldValue = $this->price_mark->EditValue;
            }

            // usable_area
            $this->usable_area->setupEditAttributes();
            $this->usable_area->EditCustomAttributes = "";
            if (!$this->usable_area->Raw) {
                $this->usable_area->CurrentValue = HtmlDecode($this->usable_area->CurrentValue);
            }
            $this->usable_area->EditValue = HtmlEncode($this->usable_area->CurrentValue);
            $this->usable_area->PlaceHolder = RemoveHtml($this->usable_area->caption());

            // land_size
            $this->land_size->setupEditAttributes();
            $this->land_size->EditCustomAttributes = "";
            if (!$this->land_size->Raw) {
                $this->land_size->CurrentValue = HtmlDecode($this->land_size->CurrentValue);
            }
            $this->land_size->EditValue = HtmlEncode($this->land_size->CurrentValue);
            $this->land_size->PlaceHolder = RemoveHtml($this->land_size->caption());

            // count_view
            $this->count_view->setupEditAttributes();
            $this->count_view->EditCustomAttributes = "";
            $this->count_view->EditValue = HtmlEncode($this->count_view->CurrentValue);
            $this->count_view->PlaceHolder = RemoveHtml($this->count_view->caption());
            if (strval($this->count_view->EditValue) != "" && is_numeric($this->count_view->EditValue)) {
                $this->count_view->EditValue = FormatNumber($this->count_view->EditValue, null);
                $this->count_view->OldValue = $this->count_view->EditValue;
            }

            // count_favorite
            $this->count_favorite->setupEditAttributes();
            $this->count_favorite->EditCustomAttributes = "";
            $this->count_favorite->EditValue = HtmlEncode($this->count_favorite->CurrentValue);
            $this->count_favorite->PlaceHolder = RemoveHtml($this->count_favorite->caption());
            if (strval($this->count_favorite->EditValue) != "" && is_numeric($this->count_favorite->EditValue)) {
                $this->count_favorite->EditValue = FormatNumber($this->count_favorite->EditValue, null);
                $this->count_favorite->OldValue = $this->count_favorite->EditValue;
            }

            // expired_date
            $this->expired_date->setupEditAttributes();
            $this->expired_date->EditCustomAttributes = "";
            $this->expired_date->EditValue = HtmlEncode(FormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern()));
            $this->expired_date->PlaceHolder = RemoveHtml($this->expired_date->caption());

            // cdate

            // Add refer script

            // title
            $this->_title->LinkCustomAttributes = "";
            $this->_title->HrefValue = "";

            // brand_id
            $this->brand_id->LinkCustomAttributes = "";
            $this->brand_id->HrefValue = "";

            // asset_code
            $this->asset_code->LinkCustomAttributes = "";
            $this->asset_code->HrefValue = "";

            // asset_status
            $this->asset_status->LinkCustomAttributes = "";
            $this->asset_status->HrefValue = "";

            // isactive
            $this->isactive->LinkCustomAttributes = "";
            $this->isactive->HrefValue = "";

            // price_mark
            $this->price_mark->LinkCustomAttributes = "";
            $this->price_mark->HrefValue = "";

            // usable_area
            $this->usable_area->LinkCustomAttributes = "";
            $this->usable_area->HrefValue = "";

            // land_size
            $this->land_size->LinkCustomAttributes = "";
            $this->land_size->HrefValue = "";

            // count_view
            $this->count_view->LinkCustomAttributes = "";
            $this->count_view->HrefValue = "";

            // count_favorite
            $this->count_favorite->LinkCustomAttributes = "";
            $this->count_favorite->HrefValue = "";

            // expired_date
            $this->expired_date->LinkCustomAttributes = "";
            $this->expired_date->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // title
            $this->_title->setupEditAttributes();
            $this->_title->EditCustomAttributes = "";
            if (!$this->_title->Raw) {
                $this->_title->CurrentValue = HtmlDecode($this->_title->CurrentValue);
            }
            $this->_title->EditValue = HtmlEncode($this->_title->CurrentValue);
            $this->_title->PlaceHolder = RemoveHtml($this->_title->caption());

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

            // asset_code
            $this->asset_code->setupEditAttributes();
            $this->asset_code->EditCustomAttributes = "";
            $this->asset_code->EditValue = $this->asset_code->CurrentValue;
            $this->asset_code->ViewCustomAttributes = "";

            // asset_status
            $this->asset_status->setupEditAttributes();
            $this->asset_status->EditCustomAttributes = "";
            $this->asset_status->EditValue = $this->asset_status->options(true);
            $this->asset_status->PlaceHolder = RemoveHtml($this->asset_status->caption());

            // isactive
            $this->isactive->EditCustomAttributes = "";
            $this->isactive->EditValue = $this->isactive->options(false);
            $this->isactive->PlaceHolder = RemoveHtml($this->isactive->caption());

            // price_mark
            $this->price_mark->setupEditAttributes();
            $this->price_mark->EditCustomAttributes = "";
            $this->price_mark->EditValue = HtmlEncode($this->price_mark->CurrentValue);
            $this->price_mark->PlaceHolder = RemoveHtml($this->price_mark->caption());
            if (strval($this->price_mark->EditValue) != "" && is_numeric($this->price_mark->EditValue)) {
                $this->price_mark->EditValue = FormatNumber($this->price_mark->EditValue, null);
                $this->price_mark->OldValue = $this->price_mark->EditValue;
            }

            // usable_area
            $this->usable_area->setupEditAttributes();
            $this->usable_area->EditCustomAttributes = "";
            if (!$this->usable_area->Raw) {
                $this->usable_area->CurrentValue = HtmlDecode($this->usable_area->CurrentValue);
            }
            $this->usable_area->EditValue = HtmlEncode($this->usable_area->CurrentValue);
            $this->usable_area->PlaceHolder = RemoveHtml($this->usable_area->caption());

            // land_size
            $this->land_size->setupEditAttributes();
            $this->land_size->EditCustomAttributes = "";
            if (!$this->land_size->Raw) {
                $this->land_size->CurrentValue = HtmlDecode($this->land_size->CurrentValue);
            }
            $this->land_size->EditValue = HtmlEncode($this->land_size->CurrentValue);
            $this->land_size->PlaceHolder = RemoveHtml($this->land_size->caption());

            // count_view
            $this->count_view->setupEditAttributes();
            $this->count_view->EditCustomAttributes = "";
            $this->count_view->EditValue = $this->count_view->CurrentValue;
            $this->count_view->EditValue = FormatNumber($this->count_view->EditValue, $this->count_view->formatPattern());
            $this->count_view->ViewCustomAttributes = "";

            // count_favorite
            $this->count_favorite->setupEditAttributes();
            $this->count_favorite->EditCustomAttributes = "";
            $this->count_favorite->EditValue = $this->count_favorite->CurrentValue;
            $this->count_favorite->EditValue = FormatNumber($this->count_favorite->EditValue, $this->count_favorite->formatPattern());
            $this->count_favorite->ViewCustomAttributes = "";

            // expired_date
            $this->expired_date->setupEditAttributes();
            $this->expired_date->EditCustomAttributes = "";
            $this->expired_date->EditValue = HtmlEncode(FormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern()));
            $this->expired_date->PlaceHolder = RemoveHtml($this->expired_date->caption());

            // cdate

            // Edit refer script

            // title
            $this->_title->LinkCustomAttributes = "";
            $this->_title->HrefValue = "";

            // brand_id
            $this->brand_id->LinkCustomAttributes = "";
            $this->brand_id->HrefValue = "";

            // asset_code
            $this->asset_code->LinkCustomAttributes = "";
            $this->asset_code->HrefValue = "";
            $this->asset_code->TooltipValue = "";

            // asset_status
            $this->asset_status->LinkCustomAttributes = "";
            $this->asset_status->HrefValue = "";

            // isactive
            $this->isactive->LinkCustomAttributes = "";
            $this->isactive->HrefValue = "";

            // price_mark
            $this->price_mark->LinkCustomAttributes = "";
            $this->price_mark->HrefValue = "";

            // usable_area
            $this->usable_area->LinkCustomAttributes = "";
            $this->usable_area->HrefValue = "";

            // land_size
            $this->land_size->LinkCustomAttributes = "";
            $this->land_size->HrefValue = "";

            // count_view
            $this->count_view->LinkCustomAttributes = "";
            $this->count_view->HrefValue = "";
            $this->count_view->TooltipValue = "";

            // count_favorite
            $this->count_favorite->LinkCustomAttributes = "";
            $this->count_favorite->HrefValue = "";
            $this->count_favorite->TooltipValue = "";

            // expired_date
            $this->expired_date->LinkCustomAttributes = "";
            $this->expired_date->HrefValue = "";

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
        if ($this->_title->Required) {
            if (!$this->_title->IsDetailKey && EmptyValue($this->_title->FormValue)) {
                $this->_title->addErrorMessage(str_replace("%s", $this->_title->caption(), $this->_title->RequiredErrorMessage));
            }
        }
        if ($this->brand_id->Required) {
            if (!$this->brand_id->IsDetailKey && EmptyValue($this->brand_id->FormValue)) {
                $this->brand_id->addErrorMessage(str_replace("%s", $this->brand_id->caption(), $this->brand_id->RequiredErrorMessage));
            }
        }
        if ($this->asset_code->Required) {
            if (!$this->asset_code->IsDetailKey && EmptyValue($this->asset_code->FormValue)) {
                $this->asset_code->addErrorMessage(str_replace("%s", $this->asset_code->caption(), $this->asset_code->RequiredErrorMessage));
            }
        }
        if ($this->asset_status->Required) {
            if (!$this->asset_status->IsDetailKey && EmptyValue($this->asset_status->FormValue)) {
                $this->asset_status->addErrorMessage(str_replace("%s", $this->asset_status->caption(), $this->asset_status->RequiredErrorMessage));
            }
        }
        if ($this->isactive->Required) {
            if ($this->isactive->FormValue == "") {
                $this->isactive->addErrorMessage(str_replace("%s", $this->isactive->caption(), $this->isactive->RequiredErrorMessage));
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
        if ($this->usable_area->Required) {
            if (!$this->usable_area->IsDetailKey && EmptyValue($this->usable_area->FormValue)) {
                $this->usable_area->addErrorMessage(str_replace("%s", $this->usable_area->caption(), $this->usable_area->RequiredErrorMessage));
            }
        }
        if ($this->land_size->Required) {
            if (!$this->land_size->IsDetailKey && EmptyValue($this->land_size->FormValue)) {
                $this->land_size->addErrorMessage(str_replace("%s", $this->land_size->caption(), $this->land_size->RequiredErrorMessage));
            }
        }
        if ($this->count_view->Required) {
            if (!$this->count_view->IsDetailKey && EmptyValue($this->count_view->FormValue)) {
                $this->count_view->addErrorMessage(str_replace("%s", $this->count_view->caption(), $this->count_view->RequiredErrorMessage));
            }
        }
        if ($this->count_favorite->Required) {
            if (!$this->count_favorite->IsDetailKey && EmptyValue($this->count_favorite->FormValue)) {
                $this->count_favorite->addErrorMessage(str_replace("%s", $this->count_favorite->caption(), $this->count_favorite->RequiredErrorMessage));
            }
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
            $thisKey .= $row['asset_id'];

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
            $this->floor_plan->OldUploadPath = './upload/floor_plan';
            $this->floor_plan->UploadPath = $this->floor_plan->OldUploadPath;
            $this->layout_unit->OldUploadPath = './upload/layout_unit';
            $this->layout_unit->UploadPath = $this->layout_unit->OldUploadPath;
            $rsnew = [];

            // title
            $this->_title->setDbValueDef($rsnew, $this->_title->CurrentValue, "", $this->_title->ReadOnly);

            // brand_id
            $this->brand_id->setDbValueDef($rsnew, $this->brand_id->CurrentValue, 0, $this->brand_id->ReadOnly);

            // asset_status
            $this->asset_status->setDbValueDef($rsnew, $this->asset_status->CurrentValue, null, $this->asset_status->ReadOnly);

            // isactive
            $this->isactive->setDbValueDef($rsnew, $this->isactive->CurrentValue, null, $this->isactive->ReadOnly);

            // price_mark
            $this->price_mark->setDbValueDef($rsnew, $this->price_mark->CurrentValue, null, $this->price_mark->ReadOnly);

            // usable_area
            $this->usable_area->setDbValueDef($rsnew, $this->usable_area->CurrentValue, null, $this->usable_area->ReadOnly);

            // land_size
            $this->land_size->setDbValueDef($rsnew, $this->land_size->CurrentValue, null, $this->land_size->ReadOnly);

            // expired_date
            $this->expired_date->setDbValueDef($rsnew, UnFormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern()), null, $this->expired_date->ReadOnly);

            // cdate
            $this->cdate->CurrentValue = CurrentDateTime();
            $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

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
        if ($this->getCurrentMasterTable() == "sale_asset") {
            $this->asset_id->CurrentValue = $this->asset_id->getSessionValue();
        }
        $conn = $this->getConnection();

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

        // brand_id
        $this->brand_id->setDbValueDef($rsnew, $this->brand_id->CurrentValue, 0, false);

        // asset_code
        $this->asset_code->setDbValueDef($rsnew, $this->asset_code->CurrentValue, null, false);

        // asset_status
        $this->asset_status->setDbValueDef($rsnew, $this->asset_status->CurrentValue, null, strval($this->asset_status->CurrentValue) == "");

        // isactive
        $this->isactive->setDbValueDef($rsnew, $this->isactive->CurrentValue, null, false);

        // price_mark
        $this->price_mark->setDbValueDef($rsnew, $this->price_mark->CurrentValue, null, false);

        // usable_area
        $this->usable_area->setDbValueDef($rsnew, $this->usable_area->CurrentValue, null, false);

        // land_size
        $this->land_size->setDbValueDef($rsnew, $this->land_size->CurrentValue, null, false);

        // count_view
        $this->count_view->setDbValueDef($rsnew, $this->count_view->CurrentValue, null, strval($this->count_view->CurrentValue) == "");

        // count_favorite
        $this->count_favorite->setDbValueDef($rsnew, $this->count_favorite->CurrentValue, null, strval($this->count_favorite->CurrentValue) == "");

        // expired_date
        $this->expired_date->setDbValueDef($rsnew, UnFormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern()), null, false);

        // cdate
        $this->cdate->CurrentValue = CurrentDateTime();
        $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

        // asset_id
        if ($this->asset_id->getSessionValue() != "") {
            $rsnew['asset_id'] = $this->asset_id->getSessionValue();
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
        if ($masterTblVar == "sale_asset") {
            $masterTbl = Container("sale_asset");
            $this->asset_id->Visible = false;
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
