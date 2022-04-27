<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class AssetList extends Asset
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'asset';

    // Page object name
    public $PageObjName = "AssetList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fassetlist";
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

        // Table object (asset)
        if (!isset($GLOBALS["asset"]) || get_class($GLOBALS["asset"]) == PROJECT_NAMESPACE . "asset") {
            $GLOBALS["asset"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "assetadd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "assetdelete";
        $this->MultiUpdateUrl = "assetupdate";

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

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
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

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(true));

            // Get and validate search values for advanced search
            if (EmptyValue($this->UserAction)) { // Skip if user action
                $this->loadSearchValues();
            }

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
            }
            if (!$this->validateSearch()) {
                // Nothing to do
            }

            // Restore search parms from Session if not searching / reset / export
            if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
                $this->restoreSearchParms();
            }

            // Call Recordset SearchValidated event
            $this->recordsetSearchValidated();

            // Set up sorting order
            $this->setupSortOrder();

            // Get search criteria for advanced search
            if (!$this->hasInvalidFields()) {
                $srchAdvanced = $this->advancedSearchWhere();
            }
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

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms()) {
            // Load advanced search from default
            if ($this->loadAdvancedSearchDefault()) {
                $srchAdvanced = $this->advancedSearchWhere();
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Build search criteria
        AddFilter($this->SearchWhere, $srchAdvanced);
        AddFilter($this->SearchWhere, $srchBasic);

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json") {
            $this->SearchWhere = $this->getSearchWhere();
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

            // Audit trail on search
            if ($this->AuditTrailOnSearch && $this->Command == "search" && !$this->RestoreSearch) {
                $searchParm = ServerVar("QUERY_STRING");
                $searchSql = $this->getSessionWhere();
                $this->writeAuditTrailOnSearch($searchParm, $searchSql);
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

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Load server side filters
        if (Config("SEARCH_FILTER_OPTION") == "Server" && isset($UserProfile)) {
            $savedFilterList = $UserProfile->getSearchFilters(CurrentUserName(), "fassetsrch");
        }
        $filterList = Concat($filterList, $this->_title->AdvancedSearch->toJson(), ","); // Field title
        $filterList = Concat($filterList, $this->title_en->AdvancedSearch->toJson(), ","); // Field title_en
        $filterList = Concat($filterList, $this->brand_id->AdvancedSearch->toJson(), ","); // Field brand_id
        $filterList = Concat($filterList, $this->detail->AdvancedSearch->toJson(), ","); // Field detail
        $filterList = Concat($filterList, $this->detail_en->AdvancedSearch->toJson(), ","); // Field detail_en
        $filterList = Concat($filterList, $this->asset_code->AdvancedSearch->toJson(), ","); // Field asset_code
        $filterList = Concat($filterList, $this->asset_status->AdvancedSearch->toJson(), ","); // Field asset_status
        $filterList = Concat($filterList, $this->latitude->AdvancedSearch->toJson(), ","); // Field latitude
        $filterList = Concat($filterList, $this->longitude->AdvancedSearch->toJson(), ","); // Field longitude
        $filterList = Concat($filterList, $this->num_buildings->AdvancedSearch->toJson(), ","); // Field num_buildings
        $filterList = Concat($filterList, $this->num_unit->AdvancedSearch->toJson(), ","); // Field num_unit
        $filterList = Concat($filterList, $this->num_floors->AdvancedSearch->toJson(), ","); // Field num_floors
        $filterList = Concat($filterList, $this->floors->AdvancedSearch->toJson(), ","); // Field floors
        $filterList = Concat($filterList, $this->asset_year_developer->AdvancedSearch->toJson(), ","); // Field asset_year_developer
        $filterList = Concat($filterList, $this->num_parking_spaces->AdvancedSearch->toJson(), ","); // Field num_parking_spaces
        $filterList = Concat($filterList, $this->num_bathrooms->AdvancedSearch->toJson(), ","); // Field num_bathrooms
        $filterList = Concat($filterList, $this->num_bedrooms->AdvancedSearch->toJson(), ","); // Field num_bedrooms
        $filterList = Concat($filterList, $this->address->AdvancedSearch->toJson(), ","); // Field address
        $filterList = Concat($filterList, $this->address_en->AdvancedSearch->toJson(), ","); // Field address_en
        $filterList = Concat($filterList, $this->province_id->AdvancedSearch->toJson(), ","); // Field province_id
        $filterList = Concat($filterList, $this->amphur_id->AdvancedSearch->toJson(), ","); // Field amphur_id
        $filterList = Concat($filterList, $this->district_id->AdvancedSearch->toJson(), ","); // Field district_id
        $filterList = Concat($filterList, $this->postcode->AdvancedSearch->toJson(), ","); // Field postcode
        $filterList = Concat($filterList, $this->floor_plan->AdvancedSearch->toJson(), ","); // Field floor_plan
        $filterList = Concat($filterList, $this->layout_unit->AdvancedSearch->toJson(), ","); // Field layout_unit
        $filterList = Concat($filterList, $this->asset_website->AdvancedSearch->toJson(), ","); // Field asset_website
        $filterList = Concat($filterList, $this->asset_review->AdvancedSearch->toJson(), ","); // Field asset_review
        $filterList = Concat($filterList, $this->isactive->AdvancedSearch->toJson(), ","); // Field isactive
        $filterList = Concat($filterList, $this->is_recommend->AdvancedSearch->toJson(), ","); // Field is_recommend
        $filterList = Concat($filterList, $this->order_by->AdvancedSearch->toJson(), ","); // Field order_by
        $filterList = Concat($filterList, $this->type_pay->AdvancedSearch->toJson(), ","); // Field type_pay
        $filterList = Concat($filterList, $this->type_pay_2->AdvancedSearch->toJson(), ","); // Field type_pay_2
        $filterList = Concat($filterList, $this->price_mark->AdvancedSearch->toJson(), ","); // Field price_mark
        $filterList = Concat($filterList, $this->holding_property->AdvancedSearch->toJson(), ","); // Field holding_property
        $filterList = Concat($filterList, $this->common_fee->AdvancedSearch->toJson(), ","); // Field common_fee
        $filterList = Concat($filterList, $this->usable_area->AdvancedSearch->toJson(), ","); // Field usable_area
        $filterList = Concat($filterList, $this->usable_area_price->AdvancedSearch->toJson(), ","); // Field usable_area_price
        $filterList = Concat($filterList, $this->land_size->AdvancedSearch->toJson(), ","); // Field land_size
        $filterList = Concat($filterList, $this->land_size_price->AdvancedSearch->toJson(), ","); // Field land_size_price
        $filterList = Concat($filterList, $this->commission->AdvancedSearch->toJson(), ","); // Field commission
        $filterList = Concat($filterList, $this->transfer_day_expenses_with_business_tax->AdvancedSearch->toJson(), ","); // Field transfer_day_expenses_with_business_tax
        $filterList = Concat($filterList, $this->transfer_day_expenses_without_business_tax->AdvancedSearch->toJson(), ","); // Field transfer_day_expenses_without_business_tax
        $filterList = Concat($filterList, $this->price->AdvancedSearch->toJson(), ","); // Field price
        $filterList = Concat($filterList, $this->discount->AdvancedSearch->toJson(), ","); // Field discount
        $filterList = Concat($filterList, $this->price_special->AdvancedSearch->toJson(), ","); // Field price_special
        $filterList = Concat($filterList, $this->reservation_price_model_a->AdvancedSearch->toJson(), ","); // Field reservation_price_model_a
        $filterList = Concat($filterList, $this->minimum_down_payment_model_a->AdvancedSearch->toJson(), ","); // Field minimum_down_payment_model_a
        $filterList = Concat($filterList, $this->down_price_min_a->AdvancedSearch->toJson(), ","); // Field down_price_min_a
        $filterList = Concat($filterList, $this->down_price_model_a->AdvancedSearch->toJson(), ","); // Field down_price_model_a
        $filterList = Concat($filterList, $this->factor_monthly_installment_over_down->AdvancedSearch->toJson(), ","); // Field factor_monthly_installment_over_down
        $filterList = Concat($filterList, $this->fee_a->AdvancedSearch->toJson(), ","); // Field fee_a
        $filterList = Concat($filterList, $this->monthly_payment_buyer->AdvancedSearch->toJson(), ","); // Field monthly_payment_buyer
        $filterList = Concat($filterList, $this->annual_interest_buyer_model_a->AdvancedSearch->toJson(), ","); // Field annual_interest_buyer_model_a
        $filterList = Concat($filterList, $this->monthly_expenses_a->AdvancedSearch->toJson(), ","); // Field monthly_expenses_a
        $filterList = Concat($filterList, $this->average_rent_a->AdvancedSearch->toJson(), ","); // Field average_rent_a
        $filterList = Concat($filterList, $this->average_down_payment_a->AdvancedSearch->toJson(), ","); // Field average_down_payment_a
        $filterList = Concat($filterList, $this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->toJson(), ","); // Field transfer_day_expenses_without_business_tax_max_min
        $filterList = Concat($filterList, $this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->toJson(), ","); // Field transfer_day_expenses_with_business_tax_max_min
        $filterList = Concat($filterList, $this->bank_appraisal_price->AdvancedSearch->toJson(), ","); // Field bank_appraisal_price
        $filterList = Concat($filterList, $this->mark_up_price->AdvancedSearch->toJson(), ","); // Field mark_up_price
        $filterList = Concat($filterList, $this->required_gap->AdvancedSearch->toJson(), ","); // Field required_gap
        $filterList = Concat($filterList, $this->minimum_down_payment->AdvancedSearch->toJson(), ","); // Field minimum_down_payment
        $filterList = Concat($filterList, $this->price_down_max->AdvancedSearch->toJson(), ","); // Field price_down_max
        $filterList = Concat($filterList, $this->discount_max->AdvancedSearch->toJson(), ","); // Field discount_max
        $filterList = Concat($filterList, $this->price_down_special_max->AdvancedSearch->toJson(), ","); // Field price_down_special_max
        $filterList = Concat($filterList, $this->usable_area_price_max->AdvancedSearch->toJson(), ","); // Field usable_area_price_max
        $filterList = Concat($filterList, $this->land_size_price_max->AdvancedSearch->toJson(), ","); // Field land_size_price_max
        $filterList = Concat($filterList, $this->reservation_price_max->AdvancedSearch->toJson(), ","); // Field reservation_price_max
        $filterList = Concat($filterList, $this->minimum_down_payment_max->AdvancedSearch->toJson(), ","); // Field minimum_down_payment_max
        $filterList = Concat($filterList, $this->down_price_max->AdvancedSearch->toJson(), ","); // Field down_price_max
        $filterList = Concat($filterList, $this->down_price->AdvancedSearch->toJson(), ","); // Field down_price
        $filterList = Concat($filterList, $this->factor_monthly_installment_over_down_max->AdvancedSearch->toJson(), ","); // Field factor_monthly_installment_over_down_max
        $filterList = Concat($filterList, $this->fee_max->AdvancedSearch->toJson(), ","); // Field fee_max
        $filterList = Concat($filterList, $this->monthly_payment_max->AdvancedSearch->toJson(), ","); // Field monthly_payment_max
        $filterList = Concat($filterList, $this->annual_interest_buyer->AdvancedSearch->toJson(), ","); // Field annual_interest_buyer
        $filterList = Concat($filterList, $this->monthly_expense_max->AdvancedSearch->toJson(), ","); // Field monthly_expense_max
        $filterList = Concat($filterList, $this->average_rent_max->AdvancedSearch->toJson(), ","); // Field average_rent_max
        $filterList = Concat($filterList, $this->average_down_payment_max->AdvancedSearch->toJson(), ","); // Field average_down_payment_max
        $filterList = Concat($filterList, $this->min_down->AdvancedSearch->toJson(), ","); // Field min_down
        $filterList = Concat($filterList, $this->remaining_down->AdvancedSearch->toJson(), ","); // Field remaining_down
        $filterList = Concat($filterList, $this->factor_financing->AdvancedSearch->toJson(), ","); // Field factor_financing
        $filterList = Concat($filterList, $this->credit_limit_down->AdvancedSearch->toJson(), ","); // Field credit_limit_down
        $filterList = Concat($filterList, $this->price_down_min->AdvancedSearch->toJson(), ","); // Field price_down_min
        $filterList = Concat($filterList, $this->discount_min->AdvancedSearch->toJson(), ","); // Field discount_min
        $filterList = Concat($filterList, $this->price_down_special_min->AdvancedSearch->toJson(), ","); // Field price_down_special_min
        $filterList = Concat($filterList, $this->usable_area_price_min->AdvancedSearch->toJson(), ","); // Field usable_area_price_min
        $filterList = Concat($filterList, $this->land_size_price_min->AdvancedSearch->toJson(), ","); // Field land_size_price_min
        $filterList = Concat($filterList, $this->reservation_price_min->AdvancedSearch->toJson(), ","); // Field reservation_price_min
        $filterList = Concat($filterList, $this->minimum_down_payment_min->AdvancedSearch->toJson(), ","); // Field minimum_down_payment_min
        $filterList = Concat($filterList, $this->down_price_min->AdvancedSearch->toJson(), ","); // Field down_price_min
        $filterList = Concat($filterList, $this->remaining_credit_limit_down->AdvancedSearch->toJson(), ","); // Field remaining_credit_limit_down
        $filterList = Concat($filterList, $this->fee_min->AdvancedSearch->toJson(), ","); // Field fee_min
        $filterList = Concat($filterList, $this->monthly_payment_min->AdvancedSearch->toJson(), ","); // Field monthly_payment_min
        $filterList = Concat($filterList, $this->annual_interest_buyer_model_min->AdvancedSearch->toJson(), ","); // Field annual_interest_buyer_model_min
        $filterList = Concat($filterList, $this->interest_downpayment_financing->AdvancedSearch->toJson(), ","); // Field interest_down-payment_financing
        $filterList = Concat($filterList, $this->monthly_expenses_min->AdvancedSearch->toJson(), ","); // Field monthly_expenses_min
        $filterList = Concat($filterList, $this->average_rent_min->AdvancedSearch->toJson(), ","); // Field average_rent_min
        $filterList = Concat($filterList, $this->average_down_payment_min->AdvancedSearch->toJson(), ","); // Field average_down_payment_min
        $filterList = Concat($filterList, $this->installment_down_payment_loan->AdvancedSearch->toJson(), ","); // Field installment_down_payment_loan
        $filterList = Concat($filterList, $this->count_view->AdvancedSearch->toJson(), ","); // Field count_view
        $filterList = Concat($filterList, $this->count_favorite->AdvancedSearch->toJson(), ","); // Field count_favorite
        $filterList = Concat($filterList, $this->price_invertor->AdvancedSearch->toJson(), ","); // Field price_invertor
        $filterList = Concat($filterList, $this->expired_date->AdvancedSearch->toJson(), ","); // Field expired_date
        $filterList = Concat($filterList, $this->cdate->AdvancedSearch->toJson(), ","); // Field cdate
        $filterList = Concat($filterList, $this->cuser->AdvancedSearch->toJson(), ","); // Field cuser
        $filterList = Concat($filterList, $this->cip->AdvancedSearch->toJson(), ","); // Field cip
        $filterList = Concat($filterList, $this->uip->AdvancedSearch->toJson(), ","); // Field uip
        $filterList = Concat($filterList, $this->udate->AdvancedSearch->toJson(), ","); // Field udate
        $filterList = Concat($filterList, $this->uuser->AdvancedSearch->toJson(), ","); // Field uuser

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        global $UserProfile;
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            $UserProfile->setSearchFilters(CurrentUserName(), "fassetsrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field title
        $this->_title->AdvancedSearch->SearchValue = @$filter["x__title"];
        $this->_title->AdvancedSearch->SearchOperator = @$filter["z__title"];
        $this->_title->AdvancedSearch->SearchCondition = @$filter["v__title"];
        $this->_title->AdvancedSearch->SearchValue2 = @$filter["y__title"];
        $this->_title->AdvancedSearch->SearchOperator2 = @$filter["w__title"];
        $this->_title->AdvancedSearch->save();

        // Field title_en
        $this->title_en->AdvancedSearch->SearchValue = @$filter["x_title_en"];
        $this->title_en->AdvancedSearch->SearchOperator = @$filter["z_title_en"];
        $this->title_en->AdvancedSearch->SearchCondition = @$filter["v_title_en"];
        $this->title_en->AdvancedSearch->SearchValue2 = @$filter["y_title_en"];
        $this->title_en->AdvancedSearch->SearchOperator2 = @$filter["w_title_en"];
        $this->title_en->AdvancedSearch->save();

        // Field brand_id
        $this->brand_id->AdvancedSearch->SearchValue = @$filter["x_brand_id"];
        $this->brand_id->AdvancedSearch->SearchOperator = @$filter["z_brand_id"];
        $this->brand_id->AdvancedSearch->SearchCondition = @$filter["v_brand_id"];
        $this->brand_id->AdvancedSearch->SearchValue2 = @$filter["y_brand_id"];
        $this->brand_id->AdvancedSearch->SearchOperator2 = @$filter["w_brand_id"];
        $this->brand_id->AdvancedSearch->save();

        // Field detail
        $this->detail->AdvancedSearch->SearchValue = @$filter["x_detail"];
        $this->detail->AdvancedSearch->SearchOperator = @$filter["z_detail"];
        $this->detail->AdvancedSearch->SearchCondition = @$filter["v_detail"];
        $this->detail->AdvancedSearch->SearchValue2 = @$filter["y_detail"];
        $this->detail->AdvancedSearch->SearchOperator2 = @$filter["w_detail"];
        $this->detail->AdvancedSearch->save();

        // Field detail_en
        $this->detail_en->AdvancedSearch->SearchValue = @$filter["x_detail_en"];
        $this->detail_en->AdvancedSearch->SearchOperator = @$filter["z_detail_en"];
        $this->detail_en->AdvancedSearch->SearchCondition = @$filter["v_detail_en"];
        $this->detail_en->AdvancedSearch->SearchValue2 = @$filter["y_detail_en"];
        $this->detail_en->AdvancedSearch->SearchOperator2 = @$filter["w_detail_en"];
        $this->detail_en->AdvancedSearch->save();

        // Field asset_code
        $this->asset_code->AdvancedSearch->SearchValue = @$filter["x_asset_code"];
        $this->asset_code->AdvancedSearch->SearchOperator = @$filter["z_asset_code"];
        $this->asset_code->AdvancedSearch->SearchCondition = @$filter["v_asset_code"];
        $this->asset_code->AdvancedSearch->SearchValue2 = @$filter["y_asset_code"];
        $this->asset_code->AdvancedSearch->SearchOperator2 = @$filter["w_asset_code"];
        $this->asset_code->AdvancedSearch->save();

        // Field asset_status
        $this->asset_status->AdvancedSearch->SearchValue = @$filter["x_asset_status"];
        $this->asset_status->AdvancedSearch->SearchOperator = @$filter["z_asset_status"];
        $this->asset_status->AdvancedSearch->SearchCondition = @$filter["v_asset_status"];
        $this->asset_status->AdvancedSearch->SearchValue2 = @$filter["y_asset_status"];
        $this->asset_status->AdvancedSearch->SearchOperator2 = @$filter["w_asset_status"];
        $this->asset_status->AdvancedSearch->save();

        // Field latitude
        $this->latitude->AdvancedSearch->SearchValue = @$filter["x_latitude"];
        $this->latitude->AdvancedSearch->SearchOperator = @$filter["z_latitude"];
        $this->latitude->AdvancedSearch->SearchCondition = @$filter["v_latitude"];
        $this->latitude->AdvancedSearch->SearchValue2 = @$filter["y_latitude"];
        $this->latitude->AdvancedSearch->SearchOperator2 = @$filter["w_latitude"];
        $this->latitude->AdvancedSearch->save();

        // Field longitude
        $this->longitude->AdvancedSearch->SearchValue = @$filter["x_longitude"];
        $this->longitude->AdvancedSearch->SearchOperator = @$filter["z_longitude"];
        $this->longitude->AdvancedSearch->SearchCondition = @$filter["v_longitude"];
        $this->longitude->AdvancedSearch->SearchValue2 = @$filter["y_longitude"];
        $this->longitude->AdvancedSearch->SearchOperator2 = @$filter["w_longitude"];
        $this->longitude->AdvancedSearch->save();

        // Field num_buildings
        $this->num_buildings->AdvancedSearch->SearchValue = @$filter["x_num_buildings"];
        $this->num_buildings->AdvancedSearch->SearchOperator = @$filter["z_num_buildings"];
        $this->num_buildings->AdvancedSearch->SearchCondition = @$filter["v_num_buildings"];
        $this->num_buildings->AdvancedSearch->SearchValue2 = @$filter["y_num_buildings"];
        $this->num_buildings->AdvancedSearch->SearchOperator2 = @$filter["w_num_buildings"];
        $this->num_buildings->AdvancedSearch->save();

        // Field num_unit
        $this->num_unit->AdvancedSearch->SearchValue = @$filter["x_num_unit"];
        $this->num_unit->AdvancedSearch->SearchOperator = @$filter["z_num_unit"];
        $this->num_unit->AdvancedSearch->SearchCondition = @$filter["v_num_unit"];
        $this->num_unit->AdvancedSearch->SearchValue2 = @$filter["y_num_unit"];
        $this->num_unit->AdvancedSearch->SearchOperator2 = @$filter["w_num_unit"];
        $this->num_unit->AdvancedSearch->save();

        // Field num_floors
        $this->num_floors->AdvancedSearch->SearchValue = @$filter["x_num_floors"];
        $this->num_floors->AdvancedSearch->SearchOperator = @$filter["z_num_floors"];
        $this->num_floors->AdvancedSearch->SearchCondition = @$filter["v_num_floors"];
        $this->num_floors->AdvancedSearch->SearchValue2 = @$filter["y_num_floors"];
        $this->num_floors->AdvancedSearch->SearchOperator2 = @$filter["w_num_floors"];
        $this->num_floors->AdvancedSearch->save();

        // Field floors
        $this->floors->AdvancedSearch->SearchValue = @$filter["x_floors"];
        $this->floors->AdvancedSearch->SearchOperator = @$filter["z_floors"];
        $this->floors->AdvancedSearch->SearchCondition = @$filter["v_floors"];
        $this->floors->AdvancedSearch->SearchValue2 = @$filter["y_floors"];
        $this->floors->AdvancedSearch->SearchOperator2 = @$filter["w_floors"];
        $this->floors->AdvancedSearch->save();

        // Field asset_year_developer
        $this->asset_year_developer->AdvancedSearch->SearchValue = @$filter["x_asset_year_developer"];
        $this->asset_year_developer->AdvancedSearch->SearchOperator = @$filter["z_asset_year_developer"];
        $this->asset_year_developer->AdvancedSearch->SearchCondition = @$filter["v_asset_year_developer"];
        $this->asset_year_developer->AdvancedSearch->SearchValue2 = @$filter["y_asset_year_developer"];
        $this->asset_year_developer->AdvancedSearch->SearchOperator2 = @$filter["w_asset_year_developer"];
        $this->asset_year_developer->AdvancedSearch->save();

        // Field num_parking_spaces
        $this->num_parking_spaces->AdvancedSearch->SearchValue = @$filter["x_num_parking_spaces"];
        $this->num_parking_spaces->AdvancedSearch->SearchOperator = @$filter["z_num_parking_spaces"];
        $this->num_parking_spaces->AdvancedSearch->SearchCondition = @$filter["v_num_parking_spaces"];
        $this->num_parking_spaces->AdvancedSearch->SearchValue2 = @$filter["y_num_parking_spaces"];
        $this->num_parking_spaces->AdvancedSearch->SearchOperator2 = @$filter["w_num_parking_spaces"];
        $this->num_parking_spaces->AdvancedSearch->save();

        // Field num_bathrooms
        $this->num_bathrooms->AdvancedSearch->SearchValue = @$filter["x_num_bathrooms"];
        $this->num_bathrooms->AdvancedSearch->SearchOperator = @$filter["z_num_bathrooms"];
        $this->num_bathrooms->AdvancedSearch->SearchCondition = @$filter["v_num_bathrooms"];
        $this->num_bathrooms->AdvancedSearch->SearchValue2 = @$filter["y_num_bathrooms"];
        $this->num_bathrooms->AdvancedSearch->SearchOperator2 = @$filter["w_num_bathrooms"];
        $this->num_bathrooms->AdvancedSearch->save();

        // Field num_bedrooms
        $this->num_bedrooms->AdvancedSearch->SearchValue = @$filter["x_num_bedrooms"];
        $this->num_bedrooms->AdvancedSearch->SearchOperator = @$filter["z_num_bedrooms"];
        $this->num_bedrooms->AdvancedSearch->SearchCondition = @$filter["v_num_bedrooms"];
        $this->num_bedrooms->AdvancedSearch->SearchValue2 = @$filter["y_num_bedrooms"];
        $this->num_bedrooms->AdvancedSearch->SearchOperator2 = @$filter["w_num_bedrooms"];
        $this->num_bedrooms->AdvancedSearch->save();

        // Field address
        $this->address->AdvancedSearch->SearchValue = @$filter["x_address"];
        $this->address->AdvancedSearch->SearchOperator = @$filter["z_address"];
        $this->address->AdvancedSearch->SearchCondition = @$filter["v_address"];
        $this->address->AdvancedSearch->SearchValue2 = @$filter["y_address"];
        $this->address->AdvancedSearch->SearchOperator2 = @$filter["w_address"];
        $this->address->AdvancedSearch->save();

        // Field address_en
        $this->address_en->AdvancedSearch->SearchValue = @$filter["x_address_en"];
        $this->address_en->AdvancedSearch->SearchOperator = @$filter["z_address_en"];
        $this->address_en->AdvancedSearch->SearchCondition = @$filter["v_address_en"];
        $this->address_en->AdvancedSearch->SearchValue2 = @$filter["y_address_en"];
        $this->address_en->AdvancedSearch->SearchOperator2 = @$filter["w_address_en"];
        $this->address_en->AdvancedSearch->save();

        // Field province_id
        $this->province_id->AdvancedSearch->SearchValue = @$filter["x_province_id"];
        $this->province_id->AdvancedSearch->SearchOperator = @$filter["z_province_id"];
        $this->province_id->AdvancedSearch->SearchCondition = @$filter["v_province_id"];
        $this->province_id->AdvancedSearch->SearchValue2 = @$filter["y_province_id"];
        $this->province_id->AdvancedSearch->SearchOperator2 = @$filter["w_province_id"];
        $this->province_id->AdvancedSearch->save();

        // Field amphur_id
        $this->amphur_id->AdvancedSearch->SearchValue = @$filter["x_amphur_id"];
        $this->amphur_id->AdvancedSearch->SearchOperator = @$filter["z_amphur_id"];
        $this->amphur_id->AdvancedSearch->SearchCondition = @$filter["v_amphur_id"];
        $this->amphur_id->AdvancedSearch->SearchValue2 = @$filter["y_amphur_id"];
        $this->amphur_id->AdvancedSearch->SearchOperator2 = @$filter["w_amphur_id"];
        $this->amphur_id->AdvancedSearch->save();

        // Field district_id
        $this->district_id->AdvancedSearch->SearchValue = @$filter["x_district_id"];
        $this->district_id->AdvancedSearch->SearchOperator = @$filter["z_district_id"];
        $this->district_id->AdvancedSearch->SearchCondition = @$filter["v_district_id"];
        $this->district_id->AdvancedSearch->SearchValue2 = @$filter["y_district_id"];
        $this->district_id->AdvancedSearch->SearchOperator2 = @$filter["w_district_id"];
        $this->district_id->AdvancedSearch->save();

        // Field postcode
        $this->postcode->AdvancedSearch->SearchValue = @$filter["x_postcode"];
        $this->postcode->AdvancedSearch->SearchOperator = @$filter["z_postcode"];
        $this->postcode->AdvancedSearch->SearchCondition = @$filter["v_postcode"];
        $this->postcode->AdvancedSearch->SearchValue2 = @$filter["y_postcode"];
        $this->postcode->AdvancedSearch->SearchOperator2 = @$filter["w_postcode"];
        $this->postcode->AdvancedSearch->save();

        // Field floor_plan
        $this->floor_plan->AdvancedSearch->SearchValue = @$filter["x_floor_plan"];
        $this->floor_plan->AdvancedSearch->SearchOperator = @$filter["z_floor_plan"];
        $this->floor_plan->AdvancedSearch->SearchCondition = @$filter["v_floor_plan"];
        $this->floor_plan->AdvancedSearch->SearchValue2 = @$filter["y_floor_plan"];
        $this->floor_plan->AdvancedSearch->SearchOperator2 = @$filter["w_floor_plan"];
        $this->floor_plan->AdvancedSearch->save();

        // Field layout_unit
        $this->layout_unit->AdvancedSearch->SearchValue = @$filter["x_layout_unit"];
        $this->layout_unit->AdvancedSearch->SearchOperator = @$filter["z_layout_unit"];
        $this->layout_unit->AdvancedSearch->SearchCondition = @$filter["v_layout_unit"];
        $this->layout_unit->AdvancedSearch->SearchValue2 = @$filter["y_layout_unit"];
        $this->layout_unit->AdvancedSearch->SearchOperator2 = @$filter["w_layout_unit"];
        $this->layout_unit->AdvancedSearch->save();

        // Field asset_website
        $this->asset_website->AdvancedSearch->SearchValue = @$filter["x_asset_website"];
        $this->asset_website->AdvancedSearch->SearchOperator = @$filter["z_asset_website"];
        $this->asset_website->AdvancedSearch->SearchCondition = @$filter["v_asset_website"];
        $this->asset_website->AdvancedSearch->SearchValue2 = @$filter["y_asset_website"];
        $this->asset_website->AdvancedSearch->SearchOperator2 = @$filter["w_asset_website"];
        $this->asset_website->AdvancedSearch->save();

        // Field asset_review
        $this->asset_review->AdvancedSearch->SearchValue = @$filter["x_asset_review"];
        $this->asset_review->AdvancedSearch->SearchOperator = @$filter["z_asset_review"];
        $this->asset_review->AdvancedSearch->SearchCondition = @$filter["v_asset_review"];
        $this->asset_review->AdvancedSearch->SearchValue2 = @$filter["y_asset_review"];
        $this->asset_review->AdvancedSearch->SearchOperator2 = @$filter["w_asset_review"];
        $this->asset_review->AdvancedSearch->save();

        // Field isactive
        $this->isactive->AdvancedSearch->SearchValue = @$filter["x_isactive"];
        $this->isactive->AdvancedSearch->SearchOperator = @$filter["z_isactive"];
        $this->isactive->AdvancedSearch->SearchCondition = @$filter["v_isactive"];
        $this->isactive->AdvancedSearch->SearchValue2 = @$filter["y_isactive"];
        $this->isactive->AdvancedSearch->SearchOperator2 = @$filter["w_isactive"];
        $this->isactive->AdvancedSearch->save();

        // Field is_recommend
        $this->is_recommend->AdvancedSearch->SearchValue = @$filter["x_is_recommend"];
        $this->is_recommend->AdvancedSearch->SearchOperator = @$filter["z_is_recommend"];
        $this->is_recommend->AdvancedSearch->SearchCondition = @$filter["v_is_recommend"];
        $this->is_recommend->AdvancedSearch->SearchValue2 = @$filter["y_is_recommend"];
        $this->is_recommend->AdvancedSearch->SearchOperator2 = @$filter["w_is_recommend"];
        $this->is_recommend->AdvancedSearch->save();

        // Field order_by
        $this->order_by->AdvancedSearch->SearchValue = @$filter["x_order_by"];
        $this->order_by->AdvancedSearch->SearchOperator = @$filter["z_order_by"];
        $this->order_by->AdvancedSearch->SearchCondition = @$filter["v_order_by"];
        $this->order_by->AdvancedSearch->SearchValue2 = @$filter["y_order_by"];
        $this->order_by->AdvancedSearch->SearchOperator2 = @$filter["w_order_by"];
        $this->order_by->AdvancedSearch->save();

        // Field type_pay
        $this->type_pay->AdvancedSearch->SearchValue = @$filter["x_type_pay"];
        $this->type_pay->AdvancedSearch->SearchOperator = @$filter["z_type_pay"];
        $this->type_pay->AdvancedSearch->SearchCondition = @$filter["v_type_pay"];
        $this->type_pay->AdvancedSearch->SearchValue2 = @$filter["y_type_pay"];
        $this->type_pay->AdvancedSearch->SearchOperator2 = @$filter["w_type_pay"];
        $this->type_pay->AdvancedSearch->save();

        // Field type_pay_2
        $this->type_pay_2->AdvancedSearch->SearchValue = @$filter["x_type_pay_2"];
        $this->type_pay_2->AdvancedSearch->SearchOperator = @$filter["z_type_pay_2"];
        $this->type_pay_2->AdvancedSearch->SearchCondition = @$filter["v_type_pay_2"];
        $this->type_pay_2->AdvancedSearch->SearchValue2 = @$filter["y_type_pay_2"];
        $this->type_pay_2->AdvancedSearch->SearchOperator2 = @$filter["w_type_pay_2"];
        $this->type_pay_2->AdvancedSearch->save();

        // Field price_mark
        $this->price_mark->AdvancedSearch->SearchValue = @$filter["x_price_mark"];
        $this->price_mark->AdvancedSearch->SearchOperator = @$filter["z_price_mark"];
        $this->price_mark->AdvancedSearch->SearchCondition = @$filter["v_price_mark"];
        $this->price_mark->AdvancedSearch->SearchValue2 = @$filter["y_price_mark"];
        $this->price_mark->AdvancedSearch->SearchOperator2 = @$filter["w_price_mark"];
        $this->price_mark->AdvancedSearch->save();

        // Field holding_property
        $this->holding_property->AdvancedSearch->SearchValue = @$filter["x_holding_property"];
        $this->holding_property->AdvancedSearch->SearchOperator = @$filter["z_holding_property"];
        $this->holding_property->AdvancedSearch->SearchCondition = @$filter["v_holding_property"];
        $this->holding_property->AdvancedSearch->SearchValue2 = @$filter["y_holding_property"];
        $this->holding_property->AdvancedSearch->SearchOperator2 = @$filter["w_holding_property"];
        $this->holding_property->AdvancedSearch->save();

        // Field common_fee
        $this->common_fee->AdvancedSearch->SearchValue = @$filter["x_common_fee"];
        $this->common_fee->AdvancedSearch->SearchOperator = @$filter["z_common_fee"];
        $this->common_fee->AdvancedSearch->SearchCondition = @$filter["v_common_fee"];
        $this->common_fee->AdvancedSearch->SearchValue2 = @$filter["y_common_fee"];
        $this->common_fee->AdvancedSearch->SearchOperator2 = @$filter["w_common_fee"];
        $this->common_fee->AdvancedSearch->save();

        // Field usable_area
        $this->usable_area->AdvancedSearch->SearchValue = @$filter["x_usable_area"];
        $this->usable_area->AdvancedSearch->SearchOperator = @$filter["z_usable_area"];
        $this->usable_area->AdvancedSearch->SearchCondition = @$filter["v_usable_area"];
        $this->usable_area->AdvancedSearch->SearchValue2 = @$filter["y_usable_area"];
        $this->usable_area->AdvancedSearch->SearchOperator2 = @$filter["w_usable_area"];
        $this->usable_area->AdvancedSearch->save();

        // Field usable_area_price
        $this->usable_area_price->AdvancedSearch->SearchValue = @$filter["x_usable_area_price"];
        $this->usable_area_price->AdvancedSearch->SearchOperator = @$filter["z_usable_area_price"];
        $this->usable_area_price->AdvancedSearch->SearchCondition = @$filter["v_usable_area_price"];
        $this->usable_area_price->AdvancedSearch->SearchValue2 = @$filter["y_usable_area_price"];
        $this->usable_area_price->AdvancedSearch->SearchOperator2 = @$filter["w_usable_area_price"];
        $this->usable_area_price->AdvancedSearch->save();

        // Field land_size
        $this->land_size->AdvancedSearch->SearchValue = @$filter["x_land_size"];
        $this->land_size->AdvancedSearch->SearchOperator = @$filter["z_land_size"];
        $this->land_size->AdvancedSearch->SearchCondition = @$filter["v_land_size"];
        $this->land_size->AdvancedSearch->SearchValue2 = @$filter["y_land_size"];
        $this->land_size->AdvancedSearch->SearchOperator2 = @$filter["w_land_size"];
        $this->land_size->AdvancedSearch->save();

        // Field land_size_price
        $this->land_size_price->AdvancedSearch->SearchValue = @$filter["x_land_size_price"];
        $this->land_size_price->AdvancedSearch->SearchOperator = @$filter["z_land_size_price"];
        $this->land_size_price->AdvancedSearch->SearchCondition = @$filter["v_land_size_price"];
        $this->land_size_price->AdvancedSearch->SearchValue2 = @$filter["y_land_size_price"];
        $this->land_size_price->AdvancedSearch->SearchOperator2 = @$filter["w_land_size_price"];
        $this->land_size_price->AdvancedSearch->save();

        // Field commission
        $this->commission->AdvancedSearch->SearchValue = @$filter["x_commission"];
        $this->commission->AdvancedSearch->SearchOperator = @$filter["z_commission"];
        $this->commission->AdvancedSearch->SearchCondition = @$filter["v_commission"];
        $this->commission->AdvancedSearch->SearchValue2 = @$filter["y_commission"];
        $this->commission->AdvancedSearch->SearchOperator2 = @$filter["w_commission"];
        $this->commission->AdvancedSearch->save();

        // Field transfer_day_expenses_with_business_tax
        $this->transfer_day_expenses_with_business_tax->AdvancedSearch->SearchValue = @$filter["x_transfer_day_expenses_with_business_tax"];
        $this->transfer_day_expenses_with_business_tax->AdvancedSearch->SearchOperator = @$filter["z_transfer_day_expenses_with_business_tax"];
        $this->transfer_day_expenses_with_business_tax->AdvancedSearch->SearchCondition = @$filter["v_transfer_day_expenses_with_business_tax"];
        $this->transfer_day_expenses_with_business_tax->AdvancedSearch->SearchValue2 = @$filter["y_transfer_day_expenses_with_business_tax"];
        $this->transfer_day_expenses_with_business_tax->AdvancedSearch->SearchOperator2 = @$filter["w_transfer_day_expenses_with_business_tax"];
        $this->transfer_day_expenses_with_business_tax->AdvancedSearch->save();

        // Field transfer_day_expenses_without_business_tax
        $this->transfer_day_expenses_without_business_tax->AdvancedSearch->SearchValue = @$filter["x_transfer_day_expenses_without_business_tax"];
        $this->transfer_day_expenses_without_business_tax->AdvancedSearch->SearchOperator = @$filter["z_transfer_day_expenses_without_business_tax"];
        $this->transfer_day_expenses_without_business_tax->AdvancedSearch->SearchCondition = @$filter["v_transfer_day_expenses_without_business_tax"];
        $this->transfer_day_expenses_without_business_tax->AdvancedSearch->SearchValue2 = @$filter["y_transfer_day_expenses_without_business_tax"];
        $this->transfer_day_expenses_without_business_tax->AdvancedSearch->SearchOperator2 = @$filter["w_transfer_day_expenses_without_business_tax"];
        $this->transfer_day_expenses_without_business_tax->AdvancedSearch->save();

        // Field price
        $this->price->AdvancedSearch->SearchValue = @$filter["x_price"];
        $this->price->AdvancedSearch->SearchOperator = @$filter["z_price"];
        $this->price->AdvancedSearch->SearchCondition = @$filter["v_price"];
        $this->price->AdvancedSearch->SearchValue2 = @$filter["y_price"];
        $this->price->AdvancedSearch->SearchOperator2 = @$filter["w_price"];
        $this->price->AdvancedSearch->save();

        // Field discount
        $this->discount->AdvancedSearch->SearchValue = @$filter["x_discount"];
        $this->discount->AdvancedSearch->SearchOperator = @$filter["z_discount"];
        $this->discount->AdvancedSearch->SearchCondition = @$filter["v_discount"];
        $this->discount->AdvancedSearch->SearchValue2 = @$filter["y_discount"];
        $this->discount->AdvancedSearch->SearchOperator2 = @$filter["w_discount"];
        $this->discount->AdvancedSearch->save();

        // Field price_special
        $this->price_special->AdvancedSearch->SearchValue = @$filter["x_price_special"];
        $this->price_special->AdvancedSearch->SearchOperator = @$filter["z_price_special"];
        $this->price_special->AdvancedSearch->SearchCondition = @$filter["v_price_special"];
        $this->price_special->AdvancedSearch->SearchValue2 = @$filter["y_price_special"];
        $this->price_special->AdvancedSearch->SearchOperator2 = @$filter["w_price_special"];
        $this->price_special->AdvancedSearch->save();

        // Field reservation_price_model_a
        $this->reservation_price_model_a->AdvancedSearch->SearchValue = @$filter["x_reservation_price_model_a"];
        $this->reservation_price_model_a->AdvancedSearch->SearchOperator = @$filter["z_reservation_price_model_a"];
        $this->reservation_price_model_a->AdvancedSearch->SearchCondition = @$filter["v_reservation_price_model_a"];
        $this->reservation_price_model_a->AdvancedSearch->SearchValue2 = @$filter["y_reservation_price_model_a"];
        $this->reservation_price_model_a->AdvancedSearch->SearchOperator2 = @$filter["w_reservation_price_model_a"];
        $this->reservation_price_model_a->AdvancedSearch->save();

        // Field minimum_down_payment_model_a
        $this->minimum_down_payment_model_a->AdvancedSearch->SearchValue = @$filter["x_minimum_down_payment_model_a"];
        $this->minimum_down_payment_model_a->AdvancedSearch->SearchOperator = @$filter["z_minimum_down_payment_model_a"];
        $this->minimum_down_payment_model_a->AdvancedSearch->SearchCondition = @$filter["v_minimum_down_payment_model_a"];
        $this->minimum_down_payment_model_a->AdvancedSearch->SearchValue2 = @$filter["y_minimum_down_payment_model_a"];
        $this->minimum_down_payment_model_a->AdvancedSearch->SearchOperator2 = @$filter["w_minimum_down_payment_model_a"];
        $this->minimum_down_payment_model_a->AdvancedSearch->save();

        // Field down_price_min_a
        $this->down_price_min_a->AdvancedSearch->SearchValue = @$filter["x_down_price_min_a"];
        $this->down_price_min_a->AdvancedSearch->SearchOperator = @$filter["z_down_price_min_a"];
        $this->down_price_min_a->AdvancedSearch->SearchCondition = @$filter["v_down_price_min_a"];
        $this->down_price_min_a->AdvancedSearch->SearchValue2 = @$filter["y_down_price_min_a"];
        $this->down_price_min_a->AdvancedSearch->SearchOperator2 = @$filter["w_down_price_min_a"];
        $this->down_price_min_a->AdvancedSearch->save();

        // Field down_price_model_a
        $this->down_price_model_a->AdvancedSearch->SearchValue = @$filter["x_down_price_model_a"];
        $this->down_price_model_a->AdvancedSearch->SearchOperator = @$filter["z_down_price_model_a"];
        $this->down_price_model_a->AdvancedSearch->SearchCondition = @$filter["v_down_price_model_a"];
        $this->down_price_model_a->AdvancedSearch->SearchValue2 = @$filter["y_down_price_model_a"];
        $this->down_price_model_a->AdvancedSearch->SearchOperator2 = @$filter["w_down_price_model_a"];
        $this->down_price_model_a->AdvancedSearch->save();

        // Field factor_monthly_installment_over_down
        $this->factor_monthly_installment_over_down->AdvancedSearch->SearchValue = @$filter["x_factor_monthly_installment_over_down"];
        $this->factor_monthly_installment_over_down->AdvancedSearch->SearchOperator = @$filter["z_factor_monthly_installment_over_down"];
        $this->factor_monthly_installment_over_down->AdvancedSearch->SearchCondition = @$filter["v_factor_monthly_installment_over_down"];
        $this->factor_monthly_installment_over_down->AdvancedSearch->SearchValue2 = @$filter["y_factor_monthly_installment_over_down"];
        $this->factor_monthly_installment_over_down->AdvancedSearch->SearchOperator2 = @$filter["w_factor_monthly_installment_over_down"];
        $this->factor_monthly_installment_over_down->AdvancedSearch->save();

        // Field fee_a
        $this->fee_a->AdvancedSearch->SearchValue = @$filter["x_fee_a"];
        $this->fee_a->AdvancedSearch->SearchOperator = @$filter["z_fee_a"];
        $this->fee_a->AdvancedSearch->SearchCondition = @$filter["v_fee_a"];
        $this->fee_a->AdvancedSearch->SearchValue2 = @$filter["y_fee_a"];
        $this->fee_a->AdvancedSearch->SearchOperator2 = @$filter["w_fee_a"];
        $this->fee_a->AdvancedSearch->save();

        // Field monthly_payment_buyer
        $this->monthly_payment_buyer->AdvancedSearch->SearchValue = @$filter["x_monthly_payment_buyer"];
        $this->monthly_payment_buyer->AdvancedSearch->SearchOperator = @$filter["z_monthly_payment_buyer"];
        $this->monthly_payment_buyer->AdvancedSearch->SearchCondition = @$filter["v_monthly_payment_buyer"];
        $this->monthly_payment_buyer->AdvancedSearch->SearchValue2 = @$filter["y_monthly_payment_buyer"];
        $this->monthly_payment_buyer->AdvancedSearch->SearchOperator2 = @$filter["w_monthly_payment_buyer"];
        $this->monthly_payment_buyer->AdvancedSearch->save();

        // Field annual_interest_buyer_model_a
        $this->annual_interest_buyer_model_a->AdvancedSearch->SearchValue = @$filter["x_annual_interest_buyer_model_a"];
        $this->annual_interest_buyer_model_a->AdvancedSearch->SearchOperator = @$filter["z_annual_interest_buyer_model_a"];
        $this->annual_interest_buyer_model_a->AdvancedSearch->SearchCondition = @$filter["v_annual_interest_buyer_model_a"];
        $this->annual_interest_buyer_model_a->AdvancedSearch->SearchValue2 = @$filter["y_annual_interest_buyer_model_a"];
        $this->annual_interest_buyer_model_a->AdvancedSearch->SearchOperator2 = @$filter["w_annual_interest_buyer_model_a"];
        $this->annual_interest_buyer_model_a->AdvancedSearch->save();

        // Field monthly_expenses_a
        $this->monthly_expenses_a->AdvancedSearch->SearchValue = @$filter["x_monthly_expenses_a"];
        $this->monthly_expenses_a->AdvancedSearch->SearchOperator = @$filter["z_monthly_expenses_a"];
        $this->monthly_expenses_a->AdvancedSearch->SearchCondition = @$filter["v_monthly_expenses_a"];
        $this->monthly_expenses_a->AdvancedSearch->SearchValue2 = @$filter["y_monthly_expenses_a"];
        $this->monthly_expenses_a->AdvancedSearch->SearchOperator2 = @$filter["w_monthly_expenses_a"];
        $this->monthly_expenses_a->AdvancedSearch->save();

        // Field average_rent_a
        $this->average_rent_a->AdvancedSearch->SearchValue = @$filter["x_average_rent_a"];
        $this->average_rent_a->AdvancedSearch->SearchOperator = @$filter["z_average_rent_a"];
        $this->average_rent_a->AdvancedSearch->SearchCondition = @$filter["v_average_rent_a"];
        $this->average_rent_a->AdvancedSearch->SearchValue2 = @$filter["y_average_rent_a"];
        $this->average_rent_a->AdvancedSearch->SearchOperator2 = @$filter["w_average_rent_a"];
        $this->average_rent_a->AdvancedSearch->save();

        // Field average_down_payment_a
        $this->average_down_payment_a->AdvancedSearch->SearchValue = @$filter["x_average_down_payment_a"];
        $this->average_down_payment_a->AdvancedSearch->SearchOperator = @$filter["z_average_down_payment_a"];
        $this->average_down_payment_a->AdvancedSearch->SearchCondition = @$filter["v_average_down_payment_a"];
        $this->average_down_payment_a->AdvancedSearch->SearchValue2 = @$filter["y_average_down_payment_a"];
        $this->average_down_payment_a->AdvancedSearch->SearchOperator2 = @$filter["w_average_down_payment_a"];
        $this->average_down_payment_a->AdvancedSearch->save();

        // Field transfer_day_expenses_without_business_tax_max_min
        $this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->SearchValue = @$filter["x_transfer_day_expenses_without_business_tax_max_min"];
        $this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->SearchOperator = @$filter["z_transfer_day_expenses_without_business_tax_max_min"];
        $this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->SearchCondition = @$filter["v_transfer_day_expenses_without_business_tax_max_min"];
        $this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->SearchValue2 = @$filter["y_transfer_day_expenses_without_business_tax_max_min"];
        $this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->SearchOperator2 = @$filter["w_transfer_day_expenses_without_business_tax_max_min"];
        $this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->save();

        // Field transfer_day_expenses_with_business_tax_max_min
        $this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->SearchValue = @$filter["x_transfer_day_expenses_with_business_tax_max_min"];
        $this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->SearchOperator = @$filter["z_transfer_day_expenses_with_business_tax_max_min"];
        $this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->SearchCondition = @$filter["v_transfer_day_expenses_with_business_tax_max_min"];
        $this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->SearchValue2 = @$filter["y_transfer_day_expenses_with_business_tax_max_min"];
        $this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->SearchOperator2 = @$filter["w_transfer_day_expenses_with_business_tax_max_min"];
        $this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->save();

        // Field bank_appraisal_price
        $this->bank_appraisal_price->AdvancedSearch->SearchValue = @$filter["x_bank_appraisal_price"];
        $this->bank_appraisal_price->AdvancedSearch->SearchOperator = @$filter["z_bank_appraisal_price"];
        $this->bank_appraisal_price->AdvancedSearch->SearchCondition = @$filter["v_bank_appraisal_price"];
        $this->bank_appraisal_price->AdvancedSearch->SearchValue2 = @$filter["y_bank_appraisal_price"];
        $this->bank_appraisal_price->AdvancedSearch->SearchOperator2 = @$filter["w_bank_appraisal_price"];
        $this->bank_appraisal_price->AdvancedSearch->save();

        // Field mark_up_price
        $this->mark_up_price->AdvancedSearch->SearchValue = @$filter["x_mark_up_price"];
        $this->mark_up_price->AdvancedSearch->SearchOperator = @$filter["z_mark_up_price"];
        $this->mark_up_price->AdvancedSearch->SearchCondition = @$filter["v_mark_up_price"];
        $this->mark_up_price->AdvancedSearch->SearchValue2 = @$filter["y_mark_up_price"];
        $this->mark_up_price->AdvancedSearch->SearchOperator2 = @$filter["w_mark_up_price"];
        $this->mark_up_price->AdvancedSearch->save();

        // Field required_gap
        $this->required_gap->AdvancedSearch->SearchValue = @$filter["x_required_gap"];
        $this->required_gap->AdvancedSearch->SearchOperator = @$filter["z_required_gap"];
        $this->required_gap->AdvancedSearch->SearchCondition = @$filter["v_required_gap"];
        $this->required_gap->AdvancedSearch->SearchValue2 = @$filter["y_required_gap"];
        $this->required_gap->AdvancedSearch->SearchOperator2 = @$filter["w_required_gap"];
        $this->required_gap->AdvancedSearch->save();

        // Field minimum_down_payment
        $this->minimum_down_payment->AdvancedSearch->SearchValue = @$filter["x_minimum_down_payment"];
        $this->minimum_down_payment->AdvancedSearch->SearchOperator = @$filter["z_minimum_down_payment"];
        $this->minimum_down_payment->AdvancedSearch->SearchCondition = @$filter["v_minimum_down_payment"];
        $this->minimum_down_payment->AdvancedSearch->SearchValue2 = @$filter["y_minimum_down_payment"];
        $this->minimum_down_payment->AdvancedSearch->SearchOperator2 = @$filter["w_minimum_down_payment"];
        $this->minimum_down_payment->AdvancedSearch->save();

        // Field price_down_max
        $this->price_down_max->AdvancedSearch->SearchValue = @$filter["x_price_down_max"];
        $this->price_down_max->AdvancedSearch->SearchOperator = @$filter["z_price_down_max"];
        $this->price_down_max->AdvancedSearch->SearchCondition = @$filter["v_price_down_max"];
        $this->price_down_max->AdvancedSearch->SearchValue2 = @$filter["y_price_down_max"];
        $this->price_down_max->AdvancedSearch->SearchOperator2 = @$filter["w_price_down_max"];
        $this->price_down_max->AdvancedSearch->save();

        // Field discount_max
        $this->discount_max->AdvancedSearch->SearchValue = @$filter["x_discount_max"];
        $this->discount_max->AdvancedSearch->SearchOperator = @$filter["z_discount_max"];
        $this->discount_max->AdvancedSearch->SearchCondition = @$filter["v_discount_max"];
        $this->discount_max->AdvancedSearch->SearchValue2 = @$filter["y_discount_max"];
        $this->discount_max->AdvancedSearch->SearchOperator2 = @$filter["w_discount_max"];
        $this->discount_max->AdvancedSearch->save();

        // Field price_down_special_max
        $this->price_down_special_max->AdvancedSearch->SearchValue = @$filter["x_price_down_special_max"];
        $this->price_down_special_max->AdvancedSearch->SearchOperator = @$filter["z_price_down_special_max"];
        $this->price_down_special_max->AdvancedSearch->SearchCondition = @$filter["v_price_down_special_max"];
        $this->price_down_special_max->AdvancedSearch->SearchValue2 = @$filter["y_price_down_special_max"];
        $this->price_down_special_max->AdvancedSearch->SearchOperator2 = @$filter["w_price_down_special_max"];
        $this->price_down_special_max->AdvancedSearch->save();

        // Field usable_area_price_max
        $this->usable_area_price_max->AdvancedSearch->SearchValue = @$filter["x_usable_area_price_max"];
        $this->usable_area_price_max->AdvancedSearch->SearchOperator = @$filter["z_usable_area_price_max"];
        $this->usable_area_price_max->AdvancedSearch->SearchCondition = @$filter["v_usable_area_price_max"];
        $this->usable_area_price_max->AdvancedSearch->SearchValue2 = @$filter["y_usable_area_price_max"];
        $this->usable_area_price_max->AdvancedSearch->SearchOperator2 = @$filter["w_usable_area_price_max"];
        $this->usable_area_price_max->AdvancedSearch->save();

        // Field land_size_price_max
        $this->land_size_price_max->AdvancedSearch->SearchValue = @$filter["x_land_size_price_max"];
        $this->land_size_price_max->AdvancedSearch->SearchOperator = @$filter["z_land_size_price_max"];
        $this->land_size_price_max->AdvancedSearch->SearchCondition = @$filter["v_land_size_price_max"];
        $this->land_size_price_max->AdvancedSearch->SearchValue2 = @$filter["y_land_size_price_max"];
        $this->land_size_price_max->AdvancedSearch->SearchOperator2 = @$filter["w_land_size_price_max"];
        $this->land_size_price_max->AdvancedSearch->save();

        // Field reservation_price_max
        $this->reservation_price_max->AdvancedSearch->SearchValue = @$filter["x_reservation_price_max"];
        $this->reservation_price_max->AdvancedSearch->SearchOperator = @$filter["z_reservation_price_max"];
        $this->reservation_price_max->AdvancedSearch->SearchCondition = @$filter["v_reservation_price_max"];
        $this->reservation_price_max->AdvancedSearch->SearchValue2 = @$filter["y_reservation_price_max"];
        $this->reservation_price_max->AdvancedSearch->SearchOperator2 = @$filter["w_reservation_price_max"];
        $this->reservation_price_max->AdvancedSearch->save();

        // Field minimum_down_payment_max
        $this->minimum_down_payment_max->AdvancedSearch->SearchValue = @$filter["x_minimum_down_payment_max"];
        $this->minimum_down_payment_max->AdvancedSearch->SearchOperator = @$filter["z_minimum_down_payment_max"];
        $this->minimum_down_payment_max->AdvancedSearch->SearchCondition = @$filter["v_minimum_down_payment_max"];
        $this->minimum_down_payment_max->AdvancedSearch->SearchValue2 = @$filter["y_minimum_down_payment_max"];
        $this->minimum_down_payment_max->AdvancedSearch->SearchOperator2 = @$filter["w_minimum_down_payment_max"];
        $this->minimum_down_payment_max->AdvancedSearch->save();

        // Field down_price_max
        $this->down_price_max->AdvancedSearch->SearchValue = @$filter["x_down_price_max"];
        $this->down_price_max->AdvancedSearch->SearchOperator = @$filter["z_down_price_max"];
        $this->down_price_max->AdvancedSearch->SearchCondition = @$filter["v_down_price_max"];
        $this->down_price_max->AdvancedSearch->SearchValue2 = @$filter["y_down_price_max"];
        $this->down_price_max->AdvancedSearch->SearchOperator2 = @$filter["w_down_price_max"];
        $this->down_price_max->AdvancedSearch->save();

        // Field down_price
        $this->down_price->AdvancedSearch->SearchValue = @$filter["x_down_price"];
        $this->down_price->AdvancedSearch->SearchOperator = @$filter["z_down_price"];
        $this->down_price->AdvancedSearch->SearchCondition = @$filter["v_down_price"];
        $this->down_price->AdvancedSearch->SearchValue2 = @$filter["y_down_price"];
        $this->down_price->AdvancedSearch->SearchOperator2 = @$filter["w_down_price"];
        $this->down_price->AdvancedSearch->save();

        // Field factor_monthly_installment_over_down_max
        $this->factor_monthly_installment_over_down_max->AdvancedSearch->SearchValue = @$filter["x_factor_monthly_installment_over_down_max"];
        $this->factor_monthly_installment_over_down_max->AdvancedSearch->SearchOperator = @$filter["z_factor_monthly_installment_over_down_max"];
        $this->factor_monthly_installment_over_down_max->AdvancedSearch->SearchCondition = @$filter["v_factor_monthly_installment_over_down_max"];
        $this->factor_monthly_installment_over_down_max->AdvancedSearch->SearchValue2 = @$filter["y_factor_monthly_installment_over_down_max"];
        $this->factor_monthly_installment_over_down_max->AdvancedSearch->SearchOperator2 = @$filter["w_factor_monthly_installment_over_down_max"];
        $this->factor_monthly_installment_over_down_max->AdvancedSearch->save();

        // Field fee_max
        $this->fee_max->AdvancedSearch->SearchValue = @$filter["x_fee_max"];
        $this->fee_max->AdvancedSearch->SearchOperator = @$filter["z_fee_max"];
        $this->fee_max->AdvancedSearch->SearchCondition = @$filter["v_fee_max"];
        $this->fee_max->AdvancedSearch->SearchValue2 = @$filter["y_fee_max"];
        $this->fee_max->AdvancedSearch->SearchOperator2 = @$filter["w_fee_max"];
        $this->fee_max->AdvancedSearch->save();

        // Field monthly_payment_max
        $this->monthly_payment_max->AdvancedSearch->SearchValue = @$filter["x_monthly_payment_max"];
        $this->monthly_payment_max->AdvancedSearch->SearchOperator = @$filter["z_monthly_payment_max"];
        $this->monthly_payment_max->AdvancedSearch->SearchCondition = @$filter["v_monthly_payment_max"];
        $this->monthly_payment_max->AdvancedSearch->SearchValue2 = @$filter["y_monthly_payment_max"];
        $this->monthly_payment_max->AdvancedSearch->SearchOperator2 = @$filter["w_monthly_payment_max"];
        $this->monthly_payment_max->AdvancedSearch->save();

        // Field annual_interest_buyer
        $this->annual_interest_buyer->AdvancedSearch->SearchValue = @$filter["x_annual_interest_buyer"];
        $this->annual_interest_buyer->AdvancedSearch->SearchOperator = @$filter["z_annual_interest_buyer"];
        $this->annual_interest_buyer->AdvancedSearch->SearchCondition = @$filter["v_annual_interest_buyer"];
        $this->annual_interest_buyer->AdvancedSearch->SearchValue2 = @$filter["y_annual_interest_buyer"];
        $this->annual_interest_buyer->AdvancedSearch->SearchOperator2 = @$filter["w_annual_interest_buyer"];
        $this->annual_interest_buyer->AdvancedSearch->save();

        // Field monthly_expense_max
        $this->monthly_expense_max->AdvancedSearch->SearchValue = @$filter["x_monthly_expense_max"];
        $this->monthly_expense_max->AdvancedSearch->SearchOperator = @$filter["z_monthly_expense_max"];
        $this->monthly_expense_max->AdvancedSearch->SearchCondition = @$filter["v_monthly_expense_max"];
        $this->monthly_expense_max->AdvancedSearch->SearchValue2 = @$filter["y_monthly_expense_max"];
        $this->monthly_expense_max->AdvancedSearch->SearchOperator2 = @$filter["w_monthly_expense_max"];
        $this->monthly_expense_max->AdvancedSearch->save();

        // Field average_rent_max
        $this->average_rent_max->AdvancedSearch->SearchValue = @$filter["x_average_rent_max"];
        $this->average_rent_max->AdvancedSearch->SearchOperator = @$filter["z_average_rent_max"];
        $this->average_rent_max->AdvancedSearch->SearchCondition = @$filter["v_average_rent_max"];
        $this->average_rent_max->AdvancedSearch->SearchValue2 = @$filter["y_average_rent_max"];
        $this->average_rent_max->AdvancedSearch->SearchOperator2 = @$filter["w_average_rent_max"];
        $this->average_rent_max->AdvancedSearch->save();

        // Field average_down_payment_max
        $this->average_down_payment_max->AdvancedSearch->SearchValue = @$filter["x_average_down_payment_max"];
        $this->average_down_payment_max->AdvancedSearch->SearchOperator = @$filter["z_average_down_payment_max"];
        $this->average_down_payment_max->AdvancedSearch->SearchCondition = @$filter["v_average_down_payment_max"];
        $this->average_down_payment_max->AdvancedSearch->SearchValue2 = @$filter["y_average_down_payment_max"];
        $this->average_down_payment_max->AdvancedSearch->SearchOperator2 = @$filter["w_average_down_payment_max"];
        $this->average_down_payment_max->AdvancedSearch->save();

        // Field min_down
        $this->min_down->AdvancedSearch->SearchValue = @$filter["x_min_down"];
        $this->min_down->AdvancedSearch->SearchOperator = @$filter["z_min_down"];
        $this->min_down->AdvancedSearch->SearchCondition = @$filter["v_min_down"];
        $this->min_down->AdvancedSearch->SearchValue2 = @$filter["y_min_down"];
        $this->min_down->AdvancedSearch->SearchOperator2 = @$filter["w_min_down"];
        $this->min_down->AdvancedSearch->save();

        // Field remaining_down
        $this->remaining_down->AdvancedSearch->SearchValue = @$filter["x_remaining_down"];
        $this->remaining_down->AdvancedSearch->SearchOperator = @$filter["z_remaining_down"];
        $this->remaining_down->AdvancedSearch->SearchCondition = @$filter["v_remaining_down"];
        $this->remaining_down->AdvancedSearch->SearchValue2 = @$filter["y_remaining_down"];
        $this->remaining_down->AdvancedSearch->SearchOperator2 = @$filter["w_remaining_down"];
        $this->remaining_down->AdvancedSearch->save();

        // Field factor_financing
        $this->factor_financing->AdvancedSearch->SearchValue = @$filter["x_factor_financing"];
        $this->factor_financing->AdvancedSearch->SearchOperator = @$filter["z_factor_financing"];
        $this->factor_financing->AdvancedSearch->SearchCondition = @$filter["v_factor_financing"];
        $this->factor_financing->AdvancedSearch->SearchValue2 = @$filter["y_factor_financing"];
        $this->factor_financing->AdvancedSearch->SearchOperator2 = @$filter["w_factor_financing"];
        $this->factor_financing->AdvancedSearch->save();

        // Field credit_limit_down
        $this->credit_limit_down->AdvancedSearch->SearchValue = @$filter["x_credit_limit_down"];
        $this->credit_limit_down->AdvancedSearch->SearchOperator = @$filter["z_credit_limit_down"];
        $this->credit_limit_down->AdvancedSearch->SearchCondition = @$filter["v_credit_limit_down"];
        $this->credit_limit_down->AdvancedSearch->SearchValue2 = @$filter["y_credit_limit_down"];
        $this->credit_limit_down->AdvancedSearch->SearchOperator2 = @$filter["w_credit_limit_down"];
        $this->credit_limit_down->AdvancedSearch->save();

        // Field price_down_min
        $this->price_down_min->AdvancedSearch->SearchValue = @$filter["x_price_down_min"];
        $this->price_down_min->AdvancedSearch->SearchOperator = @$filter["z_price_down_min"];
        $this->price_down_min->AdvancedSearch->SearchCondition = @$filter["v_price_down_min"];
        $this->price_down_min->AdvancedSearch->SearchValue2 = @$filter["y_price_down_min"];
        $this->price_down_min->AdvancedSearch->SearchOperator2 = @$filter["w_price_down_min"];
        $this->price_down_min->AdvancedSearch->save();

        // Field discount_min
        $this->discount_min->AdvancedSearch->SearchValue = @$filter["x_discount_min"];
        $this->discount_min->AdvancedSearch->SearchOperator = @$filter["z_discount_min"];
        $this->discount_min->AdvancedSearch->SearchCondition = @$filter["v_discount_min"];
        $this->discount_min->AdvancedSearch->SearchValue2 = @$filter["y_discount_min"];
        $this->discount_min->AdvancedSearch->SearchOperator2 = @$filter["w_discount_min"];
        $this->discount_min->AdvancedSearch->save();

        // Field price_down_special_min
        $this->price_down_special_min->AdvancedSearch->SearchValue = @$filter["x_price_down_special_min"];
        $this->price_down_special_min->AdvancedSearch->SearchOperator = @$filter["z_price_down_special_min"];
        $this->price_down_special_min->AdvancedSearch->SearchCondition = @$filter["v_price_down_special_min"];
        $this->price_down_special_min->AdvancedSearch->SearchValue2 = @$filter["y_price_down_special_min"];
        $this->price_down_special_min->AdvancedSearch->SearchOperator2 = @$filter["w_price_down_special_min"];
        $this->price_down_special_min->AdvancedSearch->save();

        // Field usable_area_price_min
        $this->usable_area_price_min->AdvancedSearch->SearchValue = @$filter["x_usable_area_price_min"];
        $this->usable_area_price_min->AdvancedSearch->SearchOperator = @$filter["z_usable_area_price_min"];
        $this->usable_area_price_min->AdvancedSearch->SearchCondition = @$filter["v_usable_area_price_min"];
        $this->usable_area_price_min->AdvancedSearch->SearchValue2 = @$filter["y_usable_area_price_min"];
        $this->usable_area_price_min->AdvancedSearch->SearchOperator2 = @$filter["w_usable_area_price_min"];
        $this->usable_area_price_min->AdvancedSearch->save();

        // Field land_size_price_min
        $this->land_size_price_min->AdvancedSearch->SearchValue = @$filter["x_land_size_price_min"];
        $this->land_size_price_min->AdvancedSearch->SearchOperator = @$filter["z_land_size_price_min"];
        $this->land_size_price_min->AdvancedSearch->SearchCondition = @$filter["v_land_size_price_min"];
        $this->land_size_price_min->AdvancedSearch->SearchValue2 = @$filter["y_land_size_price_min"];
        $this->land_size_price_min->AdvancedSearch->SearchOperator2 = @$filter["w_land_size_price_min"];
        $this->land_size_price_min->AdvancedSearch->save();

        // Field reservation_price_min
        $this->reservation_price_min->AdvancedSearch->SearchValue = @$filter["x_reservation_price_min"];
        $this->reservation_price_min->AdvancedSearch->SearchOperator = @$filter["z_reservation_price_min"];
        $this->reservation_price_min->AdvancedSearch->SearchCondition = @$filter["v_reservation_price_min"];
        $this->reservation_price_min->AdvancedSearch->SearchValue2 = @$filter["y_reservation_price_min"];
        $this->reservation_price_min->AdvancedSearch->SearchOperator2 = @$filter["w_reservation_price_min"];
        $this->reservation_price_min->AdvancedSearch->save();

        // Field minimum_down_payment_min
        $this->minimum_down_payment_min->AdvancedSearch->SearchValue = @$filter["x_minimum_down_payment_min"];
        $this->minimum_down_payment_min->AdvancedSearch->SearchOperator = @$filter["z_minimum_down_payment_min"];
        $this->minimum_down_payment_min->AdvancedSearch->SearchCondition = @$filter["v_minimum_down_payment_min"];
        $this->minimum_down_payment_min->AdvancedSearch->SearchValue2 = @$filter["y_minimum_down_payment_min"];
        $this->minimum_down_payment_min->AdvancedSearch->SearchOperator2 = @$filter["w_minimum_down_payment_min"];
        $this->minimum_down_payment_min->AdvancedSearch->save();

        // Field down_price_min
        $this->down_price_min->AdvancedSearch->SearchValue = @$filter["x_down_price_min"];
        $this->down_price_min->AdvancedSearch->SearchOperator = @$filter["z_down_price_min"];
        $this->down_price_min->AdvancedSearch->SearchCondition = @$filter["v_down_price_min"];
        $this->down_price_min->AdvancedSearch->SearchValue2 = @$filter["y_down_price_min"];
        $this->down_price_min->AdvancedSearch->SearchOperator2 = @$filter["w_down_price_min"];
        $this->down_price_min->AdvancedSearch->save();

        // Field remaining_credit_limit_down
        $this->remaining_credit_limit_down->AdvancedSearch->SearchValue = @$filter["x_remaining_credit_limit_down"];
        $this->remaining_credit_limit_down->AdvancedSearch->SearchOperator = @$filter["z_remaining_credit_limit_down"];
        $this->remaining_credit_limit_down->AdvancedSearch->SearchCondition = @$filter["v_remaining_credit_limit_down"];
        $this->remaining_credit_limit_down->AdvancedSearch->SearchValue2 = @$filter["y_remaining_credit_limit_down"];
        $this->remaining_credit_limit_down->AdvancedSearch->SearchOperator2 = @$filter["w_remaining_credit_limit_down"];
        $this->remaining_credit_limit_down->AdvancedSearch->save();

        // Field fee_min
        $this->fee_min->AdvancedSearch->SearchValue = @$filter["x_fee_min"];
        $this->fee_min->AdvancedSearch->SearchOperator = @$filter["z_fee_min"];
        $this->fee_min->AdvancedSearch->SearchCondition = @$filter["v_fee_min"];
        $this->fee_min->AdvancedSearch->SearchValue2 = @$filter["y_fee_min"];
        $this->fee_min->AdvancedSearch->SearchOperator2 = @$filter["w_fee_min"];
        $this->fee_min->AdvancedSearch->save();

        // Field monthly_payment_min
        $this->monthly_payment_min->AdvancedSearch->SearchValue = @$filter["x_monthly_payment_min"];
        $this->monthly_payment_min->AdvancedSearch->SearchOperator = @$filter["z_monthly_payment_min"];
        $this->monthly_payment_min->AdvancedSearch->SearchCondition = @$filter["v_monthly_payment_min"];
        $this->monthly_payment_min->AdvancedSearch->SearchValue2 = @$filter["y_monthly_payment_min"];
        $this->monthly_payment_min->AdvancedSearch->SearchOperator2 = @$filter["w_monthly_payment_min"];
        $this->monthly_payment_min->AdvancedSearch->save();

        // Field annual_interest_buyer_model_min
        $this->annual_interest_buyer_model_min->AdvancedSearch->SearchValue = @$filter["x_annual_interest_buyer_model_min"];
        $this->annual_interest_buyer_model_min->AdvancedSearch->SearchOperator = @$filter["z_annual_interest_buyer_model_min"];
        $this->annual_interest_buyer_model_min->AdvancedSearch->SearchCondition = @$filter["v_annual_interest_buyer_model_min"];
        $this->annual_interest_buyer_model_min->AdvancedSearch->SearchValue2 = @$filter["y_annual_interest_buyer_model_min"];
        $this->annual_interest_buyer_model_min->AdvancedSearch->SearchOperator2 = @$filter["w_annual_interest_buyer_model_min"];
        $this->annual_interest_buyer_model_min->AdvancedSearch->save();

        // Field interest_down-payment_financing
        $this->interest_downpayment_financing->AdvancedSearch->SearchValue = @$filter["x_interest_downpayment_financing"];
        $this->interest_downpayment_financing->AdvancedSearch->SearchOperator = @$filter["z_interest_downpayment_financing"];
        $this->interest_downpayment_financing->AdvancedSearch->SearchCondition = @$filter["v_interest_downpayment_financing"];
        $this->interest_downpayment_financing->AdvancedSearch->SearchValue2 = @$filter["y_interest_downpayment_financing"];
        $this->interest_downpayment_financing->AdvancedSearch->SearchOperator2 = @$filter["w_interest_downpayment_financing"];
        $this->interest_downpayment_financing->AdvancedSearch->save();

        // Field monthly_expenses_min
        $this->monthly_expenses_min->AdvancedSearch->SearchValue = @$filter["x_monthly_expenses_min"];
        $this->monthly_expenses_min->AdvancedSearch->SearchOperator = @$filter["z_monthly_expenses_min"];
        $this->monthly_expenses_min->AdvancedSearch->SearchCondition = @$filter["v_monthly_expenses_min"];
        $this->monthly_expenses_min->AdvancedSearch->SearchValue2 = @$filter["y_monthly_expenses_min"];
        $this->monthly_expenses_min->AdvancedSearch->SearchOperator2 = @$filter["w_monthly_expenses_min"];
        $this->monthly_expenses_min->AdvancedSearch->save();

        // Field average_rent_min
        $this->average_rent_min->AdvancedSearch->SearchValue = @$filter["x_average_rent_min"];
        $this->average_rent_min->AdvancedSearch->SearchOperator = @$filter["z_average_rent_min"];
        $this->average_rent_min->AdvancedSearch->SearchCondition = @$filter["v_average_rent_min"];
        $this->average_rent_min->AdvancedSearch->SearchValue2 = @$filter["y_average_rent_min"];
        $this->average_rent_min->AdvancedSearch->SearchOperator2 = @$filter["w_average_rent_min"];
        $this->average_rent_min->AdvancedSearch->save();

        // Field average_down_payment_min
        $this->average_down_payment_min->AdvancedSearch->SearchValue = @$filter["x_average_down_payment_min"];
        $this->average_down_payment_min->AdvancedSearch->SearchOperator = @$filter["z_average_down_payment_min"];
        $this->average_down_payment_min->AdvancedSearch->SearchCondition = @$filter["v_average_down_payment_min"];
        $this->average_down_payment_min->AdvancedSearch->SearchValue2 = @$filter["y_average_down_payment_min"];
        $this->average_down_payment_min->AdvancedSearch->SearchOperator2 = @$filter["w_average_down_payment_min"];
        $this->average_down_payment_min->AdvancedSearch->save();

        // Field installment_down_payment_loan
        $this->installment_down_payment_loan->AdvancedSearch->SearchValue = @$filter["x_installment_down_payment_loan"];
        $this->installment_down_payment_loan->AdvancedSearch->SearchOperator = @$filter["z_installment_down_payment_loan"];
        $this->installment_down_payment_loan->AdvancedSearch->SearchCondition = @$filter["v_installment_down_payment_loan"];
        $this->installment_down_payment_loan->AdvancedSearch->SearchValue2 = @$filter["y_installment_down_payment_loan"];
        $this->installment_down_payment_loan->AdvancedSearch->SearchOperator2 = @$filter["w_installment_down_payment_loan"];
        $this->installment_down_payment_loan->AdvancedSearch->save();

        // Field count_view
        $this->count_view->AdvancedSearch->SearchValue = @$filter["x_count_view"];
        $this->count_view->AdvancedSearch->SearchOperator = @$filter["z_count_view"];
        $this->count_view->AdvancedSearch->SearchCondition = @$filter["v_count_view"];
        $this->count_view->AdvancedSearch->SearchValue2 = @$filter["y_count_view"];
        $this->count_view->AdvancedSearch->SearchOperator2 = @$filter["w_count_view"];
        $this->count_view->AdvancedSearch->save();

        // Field count_favorite
        $this->count_favorite->AdvancedSearch->SearchValue = @$filter["x_count_favorite"];
        $this->count_favorite->AdvancedSearch->SearchOperator = @$filter["z_count_favorite"];
        $this->count_favorite->AdvancedSearch->SearchCondition = @$filter["v_count_favorite"];
        $this->count_favorite->AdvancedSearch->SearchValue2 = @$filter["y_count_favorite"];
        $this->count_favorite->AdvancedSearch->SearchOperator2 = @$filter["w_count_favorite"];
        $this->count_favorite->AdvancedSearch->save();

        // Field price_invertor
        $this->price_invertor->AdvancedSearch->SearchValue = @$filter["x_price_invertor"];
        $this->price_invertor->AdvancedSearch->SearchOperator = @$filter["z_price_invertor"];
        $this->price_invertor->AdvancedSearch->SearchCondition = @$filter["v_price_invertor"];
        $this->price_invertor->AdvancedSearch->SearchValue2 = @$filter["y_price_invertor"];
        $this->price_invertor->AdvancedSearch->SearchOperator2 = @$filter["w_price_invertor"];
        $this->price_invertor->AdvancedSearch->save();

        // Field expired_date
        $this->expired_date->AdvancedSearch->SearchValue = @$filter["x_expired_date"];
        $this->expired_date->AdvancedSearch->SearchOperator = @$filter["z_expired_date"];
        $this->expired_date->AdvancedSearch->SearchCondition = @$filter["v_expired_date"];
        $this->expired_date->AdvancedSearch->SearchValue2 = @$filter["y_expired_date"];
        $this->expired_date->AdvancedSearch->SearchOperator2 = @$filter["w_expired_date"];
        $this->expired_date->AdvancedSearch->save();

        // Field cdate
        $this->cdate->AdvancedSearch->SearchValue = @$filter["x_cdate"];
        $this->cdate->AdvancedSearch->SearchOperator = @$filter["z_cdate"];
        $this->cdate->AdvancedSearch->SearchCondition = @$filter["v_cdate"];
        $this->cdate->AdvancedSearch->SearchValue2 = @$filter["y_cdate"];
        $this->cdate->AdvancedSearch->SearchOperator2 = @$filter["w_cdate"];
        $this->cdate->AdvancedSearch->save();

        // Field cuser
        $this->cuser->AdvancedSearch->SearchValue = @$filter["x_cuser"];
        $this->cuser->AdvancedSearch->SearchOperator = @$filter["z_cuser"];
        $this->cuser->AdvancedSearch->SearchCondition = @$filter["v_cuser"];
        $this->cuser->AdvancedSearch->SearchValue2 = @$filter["y_cuser"];
        $this->cuser->AdvancedSearch->SearchOperator2 = @$filter["w_cuser"];
        $this->cuser->AdvancedSearch->save();

        // Field cip
        $this->cip->AdvancedSearch->SearchValue = @$filter["x_cip"];
        $this->cip->AdvancedSearch->SearchOperator = @$filter["z_cip"];
        $this->cip->AdvancedSearch->SearchCondition = @$filter["v_cip"];
        $this->cip->AdvancedSearch->SearchValue2 = @$filter["y_cip"];
        $this->cip->AdvancedSearch->SearchOperator2 = @$filter["w_cip"];
        $this->cip->AdvancedSearch->save();

        // Field uip
        $this->uip->AdvancedSearch->SearchValue = @$filter["x_uip"];
        $this->uip->AdvancedSearch->SearchOperator = @$filter["z_uip"];
        $this->uip->AdvancedSearch->SearchCondition = @$filter["v_uip"];
        $this->uip->AdvancedSearch->SearchValue2 = @$filter["y_uip"];
        $this->uip->AdvancedSearch->SearchOperator2 = @$filter["w_uip"];
        $this->uip->AdvancedSearch->save();

        // Field udate
        $this->udate->AdvancedSearch->SearchValue = @$filter["x_udate"];
        $this->udate->AdvancedSearch->SearchOperator = @$filter["z_udate"];
        $this->udate->AdvancedSearch->SearchCondition = @$filter["v_udate"];
        $this->udate->AdvancedSearch->SearchValue2 = @$filter["y_udate"];
        $this->udate->AdvancedSearch->SearchOperator2 = @$filter["w_udate"];
        $this->udate->AdvancedSearch->save();

        // Field uuser
        $this->uuser->AdvancedSearch->SearchValue = @$filter["x_uuser"];
        $this->uuser->AdvancedSearch->SearchOperator = @$filter["z_uuser"];
        $this->uuser->AdvancedSearch->SearchCondition = @$filter["v_uuser"];
        $this->uuser->AdvancedSearch->SearchValue2 = @$filter["y_uuser"];
        $this->uuser->AdvancedSearch->SearchOperator2 = @$filter["w_uuser"];
        $this->uuser->AdvancedSearch->save();
    }

    // Advanced search WHERE clause based on QueryString
    protected function advancedSearchWhere($default = false)
    {
        global $Security;
        $where = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $this->buildSearchSql($where, $this->_title, $default, false); // title
        $this->buildSearchSql($where, $this->title_en, $default, false); // title_en
        $this->buildSearchSql($where, $this->brand_id, $default, false); // brand_id
        $this->buildSearchSql($where, $this->detail, $default, false); // detail
        $this->buildSearchSql($where, $this->detail_en, $default, false); // detail_en
        $this->buildSearchSql($where, $this->asset_code, $default, false); // asset_code
        $this->buildSearchSql($where, $this->asset_status, $default, false); // asset_status
        $this->buildSearchSql($where, $this->latitude, $default, false); // latitude
        $this->buildSearchSql($where, $this->longitude, $default, false); // longitude
        $this->buildSearchSql($where, $this->num_buildings, $default, false); // num_buildings
        $this->buildSearchSql($where, $this->num_unit, $default, false); // num_unit
        $this->buildSearchSql($where, $this->num_floors, $default, false); // num_floors
        $this->buildSearchSql($where, $this->floors, $default, false); // floors
        $this->buildSearchSql($where, $this->asset_year_developer, $default, false); // asset_year_developer
        $this->buildSearchSql($where, $this->num_parking_spaces, $default, false); // num_parking_spaces
        $this->buildSearchSql($where, $this->num_bathrooms, $default, false); // num_bathrooms
        $this->buildSearchSql($where, $this->num_bedrooms, $default, false); // num_bedrooms
        $this->buildSearchSql($where, $this->address, $default, false); // address
        $this->buildSearchSql($where, $this->address_en, $default, false); // address_en
        $this->buildSearchSql($where, $this->province_id, $default, false); // province_id
        $this->buildSearchSql($where, $this->amphur_id, $default, false); // amphur_id
        $this->buildSearchSql($where, $this->district_id, $default, false); // district_id
        $this->buildSearchSql($where, $this->postcode, $default, false); // postcode
        $this->buildSearchSql($where, $this->floor_plan, $default, false); // floor_plan
        $this->buildSearchSql($where, $this->layout_unit, $default, false); // layout_unit
        $this->buildSearchSql($where, $this->asset_website, $default, false); // asset_website
        $this->buildSearchSql($where, $this->asset_review, $default, false); // asset_review
        $this->buildSearchSql($where, $this->isactive, $default, false); // isactive
        $this->buildSearchSql($where, $this->is_recommend, $default, false); // is_recommend
        $this->buildSearchSql($where, $this->order_by, $default, false); // order_by
        $this->buildSearchSql($where, $this->type_pay, $default, false); // type_pay
        $this->buildSearchSql($where, $this->type_pay_2, $default, false); // type_pay_2
        $this->buildSearchSql($where, $this->price_mark, $default, false); // price_mark
        $this->buildSearchSql($where, $this->holding_property, $default, false); // holding_property
        $this->buildSearchSql($where, $this->common_fee, $default, false); // common_fee
        $this->buildSearchSql($where, $this->usable_area, $default, false); // usable_area
        $this->buildSearchSql($where, $this->usable_area_price, $default, false); // usable_area_price
        $this->buildSearchSql($where, $this->land_size, $default, false); // land_size
        $this->buildSearchSql($where, $this->land_size_price, $default, false); // land_size_price
        $this->buildSearchSql($where, $this->commission, $default, false); // commission
        $this->buildSearchSql($where, $this->transfer_day_expenses_with_business_tax, $default, false); // transfer_day_expenses_with_business_tax
        $this->buildSearchSql($where, $this->transfer_day_expenses_without_business_tax, $default, false); // transfer_day_expenses_without_business_tax
        $this->buildSearchSql($where, $this->price, $default, false); // price
        $this->buildSearchSql($where, $this->discount, $default, false); // discount
        $this->buildSearchSql($where, $this->price_special, $default, false); // price_special
        $this->buildSearchSql($where, $this->reservation_price_model_a, $default, false); // reservation_price_model_a
        $this->buildSearchSql($where, $this->minimum_down_payment_model_a, $default, false); // minimum_down_payment_model_a
        $this->buildSearchSql($where, $this->down_price_min_a, $default, false); // down_price_min_a
        $this->buildSearchSql($where, $this->down_price_model_a, $default, false); // down_price_model_a
        $this->buildSearchSql($where, $this->factor_monthly_installment_over_down, $default, false); // factor_monthly_installment_over_down
        $this->buildSearchSql($where, $this->fee_a, $default, false); // fee_a
        $this->buildSearchSql($where, $this->monthly_payment_buyer, $default, false); // monthly_payment_buyer
        $this->buildSearchSql($where, $this->annual_interest_buyer_model_a, $default, false); // annual_interest_buyer_model_a
        $this->buildSearchSql($where, $this->monthly_expenses_a, $default, false); // monthly_expenses_a
        $this->buildSearchSql($where, $this->average_rent_a, $default, false); // average_rent_a
        $this->buildSearchSql($where, $this->average_down_payment_a, $default, false); // average_down_payment_a
        $this->buildSearchSql($where, $this->transfer_day_expenses_without_business_tax_max_min, $default, false); // transfer_day_expenses_without_business_tax_max_min
        $this->buildSearchSql($where, $this->transfer_day_expenses_with_business_tax_max_min, $default, false); // transfer_day_expenses_with_business_tax_max_min
        $this->buildSearchSql($where, $this->bank_appraisal_price, $default, false); // bank_appraisal_price
        $this->buildSearchSql($where, $this->mark_up_price, $default, false); // mark_up_price
        $this->buildSearchSql($where, $this->required_gap, $default, false); // required_gap
        $this->buildSearchSql($where, $this->minimum_down_payment, $default, false); // minimum_down_payment
        $this->buildSearchSql($where, $this->price_down_max, $default, false); // price_down_max
        $this->buildSearchSql($where, $this->discount_max, $default, false); // discount_max
        $this->buildSearchSql($where, $this->price_down_special_max, $default, false); // price_down_special_max
        $this->buildSearchSql($where, $this->usable_area_price_max, $default, false); // usable_area_price_max
        $this->buildSearchSql($where, $this->land_size_price_max, $default, false); // land_size_price_max
        $this->buildSearchSql($where, $this->reservation_price_max, $default, false); // reservation_price_max
        $this->buildSearchSql($where, $this->minimum_down_payment_max, $default, false); // minimum_down_payment_max
        $this->buildSearchSql($where, $this->down_price_max, $default, false); // down_price_max
        $this->buildSearchSql($where, $this->down_price, $default, false); // down_price
        $this->buildSearchSql($where, $this->factor_monthly_installment_over_down_max, $default, false); // factor_monthly_installment_over_down_max
        $this->buildSearchSql($where, $this->fee_max, $default, false); // fee_max
        $this->buildSearchSql($where, $this->monthly_payment_max, $default, false); // monthly_payment_max
        $this->buildSearchSql($where, $this->annual_interest_buyer, $default, false); // annual_interest_buyer
        $this->buildSearchSql($where, $this->monthly_expense_max, $default, false); // monthly_expense_max
        $this->buildSearchSql($where, $this->average_rent_max, $default, false); // average_rent_max
        $this->buildSearchSql($where, $this->average_down_payment_max, $default, false); // average_down_payment_max
        $this->buildSearchSql($where, $this->min_down, $default, false); // min_down
        $this->buildSearchSql($where, $this->remaining_down, $default, false); // remaining_down
        $this->buildSearchSql($where, $this->factor_financing, $default, false); // factor_financing
        $this->buildSearchSql($where, $this->credit_limit_down, $default, false); // credit_limit_down
        $this->buildSearchSql($where, $this->price_down_min, $default, false); // price_down_min
        $this->buildSearchSql($where, $this->discount_min, $default, false); // discount_min
        $this->buildSearchSql($where, $this->price_down_special_min, $default, false); // price_down_special_min
        $this->buildSearchSql($where, $this->usable_area_price_min, $default, false); // usable_area_price_min
        $this->buildSearchSql($where, $this->land_size_price_min, $default, false); // land_size_price_min
        $this->buildSearchSql($where, $this->reservation_price_min, $default, false); // reservation_price_min
        $this->buildSearchSql($where, $this->minimum_down_payment_min, $default, false); // minimum_down_payment_min
        $this->buildSearchSql($where, $this->down_price_min, $default, false); // down_price_min
        $this->buildSearchSql($where, $this->remaining_credit_limit_down, $default, false); // remaining_credit_limit_down
        $this->buildSearchSql($where, $this->fee_min, $default, false); // fee_min
        $this->buildSearchSql($where, $this->monthly_payment_min, $default, false); // monthly_payment_min
        $this->buildSearchSql($where, $this->annual_interest_buyer_model_min, $default, false); // annual_interest_buyer_model_min
        $this->buildSearchSql($where, $this->interest_downpayment_financing, $default, false); // interest_down-payment_financing
        $this->buildSearchSql($where, $this->monthly_expenses_min, $default, false); // monthly_expenses_min
        $this->buildSearchSql($where, $this->average_rent_min, $default, false); // average_rent_min
        $this->buildSearchSql($where, $this->average_down_payment_min, $default, false); // average_down_payment_min
        $this->buildSearchSql($where, $this->installment_down_payment_loan, $default, false); // installment_down_payment_loan
        $this->buildSearchSql($where, $this->count_view, $default, false); // count_view
        $this->buildSearchSql($where, $this->count_favorite, $default, false); // count_favorite
        $this->buildSearchSql($where, $this->price_invertor, $default, false); // price_invertor
        $this->buildSearchSql($where, $this->expired_date, $default, false); // expired_date
        $this->buildSearchSql($where, $this->cdate, $default, false); // cdate
        $this->buildSearchSql($where, $this->cuser, $default, false); // cuser
        $this->buildSearchSql($where, $this->cip, $default, false); // cip
        $this->buildSearchSql($where, $this->uip, $default, false); // uip
        $this->buildSearchSql($where, $this->udate, $default, false); // udate
        $this->buildSearchSql($where, $this->uuser, $default, false); // uuser

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->_title->AdvancedSearch->save(); // title
            $this->title_en->AdvancedSearch->save(); // title_en
            $this->brand_id->AdvancedSearch->save(); // brand_id
            $this->detail->AdvancedSearch->save(); // detail
            $this->detail_en->AdvancedSearch->save(); // detail_en
            $this->asset_code->AdvancedSearch->save(); // asset_code
            $this->asset_status->AdvancedSearch->save(); // asset_status
            $this->latitude->AdvancedSearch->save(); // latitude
            $this->longitude->AdvancedSearch->save(); // longitude
            $this->num_buildings->AdvancedSearch->save(); // num_buildings
            $this->num_unit->AdvancedSearch->save(); // num_unit
            $this->num_floors->AdvancedSearch->save(); // num_floors
            $this->floors->AdvancedSearch->save(); // floors
            $this->asset_year_developer->AdvancedSearch->save(); // asset_year_developer
            $this->num_parking_spaces->AdvancedSearch->save(); // num_parking_spaces
            $this->num_bathrooms->AdvancedSearch->save(); // num_bathrooms
            $this->num_bedrooms->AdvancedSearch->save(); // num_bedrooms
            $this->address->AdvancedSearch->save(); // address
            $this->address_en->AdvancedSearch->save(); // address_en
            $this->province_id->AdvancedSearch->save(); // province_id
            $this->amphur_id->AdvancedSearch->save(); // amphur_id
            $this->district_id->AdvancedSearch->save(); // district_id
            $this->postcode->AdvancedSearch->save(); // postcode
            $this->floor_plan->AdvancedSearch->save(); // floor_plan
            $this->layout_unit->AdvancedSearch->save(); // layout_unit
            $this->asset_website->AdvancedSearch->save(); // asset_website
            $this->asset_review->AdvancedSearch->save(); // asset_review
            $this->isactive->AdvancedSearch->save(); // isactive
            $this->is_recommend->AdvancedSearch->save(); // is_recommend
            $this->order_by->AdvancedSearch->save(); // order_by
            $this->type_pay->AdvancedSearch->save(); // type_pay
            $this->type_pay_2->AdvancedSearch->save(); // type_pay_2
            $this->price_mark->AdvancedSearch->save(); // price_mark
            $this->holding_property->AdvancedSearch->save(); // holding_property
            $this->common_fee->AdvancedSearch->save(); // common_fee
            $this->usable_area->AdvancedSearch->save(); // usable_area
            $this->usable_area_price->AdvancedSearch->save(); // usable_area_price
            $this->land_size->AdvancedSearch->save(); // land_size
            $this->land_size_price->AdvancedSearch->save(); // land_size_price
            $this->commission->AdvancedSearch->save(); // commission
            $this->transfer_day_expenses_with_business_tax->AdvancedSearch->save(); // transfer_day_expenses_with_business_tax
            $this->transfer_day_expenses_without_business_tax->AdvancedSearch->save(); // transfer_day_expenses_without_business_tax
            $this->price->AdvancedSearch->save(); // price
            $this->discount->AdvancedSearch->save(); // discount
            $this->price_special->AdvancedSearch->save(); // price_special
            $this->reservation_price_model_a->AdvancedSearch->save(); // reservation_price_model_a
            $this->minimum_down_payment_model_a->AdvancedSearch->save(); // minimum_down_payment_model_a
            $this->down_price_min_a->AdvancedSearch->save(); // down_price_min_a
            $this->down_price_model_a->AdvancedSearch->save(); // down_price_model_a
            $this->factor_monthly_installment_over_down->AdvancedSearch->save(); // factor_monthly_installment_over_down
            $this->fee_a->AdvancedSearch->save(); // fee_a
            $this->monthly_payment_buyer->AdvancedSearch->save(); // monthly_payment_buyer
            $this->annual_interest_buyer_model_a->AdvancedSearch->save(); // annual_interest_buyer_model_a
            $this->monthly_expenses_a->AdvancedSearch->save(); // monthly_expenses_a
            $this->average_rent_a->AdvancedSearch->save(); // average_rent_a
            $this->average_down_payment_a->AdvancedSearch->save(); // average_down_payment_a
            $this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->save(); // transfer_day_expenses_without_business_tax_max_min
            $this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->save(); // transfer_day_expenses_with_business_tax_max_min
            $this->bank_appraisal_price->AdvancedSearch->save(); // bank_appraisal_price
            $this->mark_up_price->AdvancedSearch->save(); // mark_up_price
            $this->required_gap->AdvancedSearch->save(); // required_gap
            $this->minimum_down_payment->AdvancedSearch->save(); // minimum_down_payment
            $this->price_down_max->AdvancedSearch->save(); // price_down_max
            $this->discount_max->AdvancedSearch->save(); // discount_max
            $this->price_down_special_max->AdvancedSearch->save(); // price_down_special_max
            $this->usable_area_price_max->AdvancedSearch->save(); // usable_area_price_max
            $this->land_size_price_max->AdvancedSearch->save(); // land_size_price_max
            $this->reservation_price_max->AdvancedSearch->save(); // reservation_price_max
            $this->minimum_down_payment_max->AdvancedSearch->save(); // minimum_down_payment_max
            $this->down_price_max->AdvancedSearch->save(); // down_price_max
            $this->down_price->AdvancedSearch->save(); // down_price
            $this->factor_monthly_installment_over_down_max->AdvancedSearch->save(); // factor_monthly_installment_over_down_max
            $this->fee_max->AdvancedSearch->save(); // fee_max
            $this->monthly_payment_max->AdvancedSearch->save(); // monthly_payment_max
            $this->annual_interest_buyer->AdvancedSearch->save(); // annual_interest_buyer
            $this->monthly_expense_max->AdvancedSearch->save(); // monthly_expense_max
            $this->average_rent_max->AdvancedSearch->save(); // average_rent_max
            $this->average_down_payment_max->AdvancedSearch->save(); // average_down_payment_max
            $this->min_down->AdvancedSearch->save(); // min_down
            $this->remaining_down->AdvancedSearch->save(); // remaining_down
            $this->factor_financing->AdvancedSearch->save(); // factor_financing
            $this->credit_limit_down->AdvancedSearch->save(); // credit_limit_down
            $this->price_down_min->AdvancedSearch->save(); // price_down_min
            $this->discount_min->AdvancedSearch->save(); // discount_min
            $this->price_down_special_min->AdvancedSearch->save(); // price_down_special_min
            $this->usable_area_price_min->AdvancedSearch->save(); // usable_area_price_min
            $this->land_size_price_min->AdvancedSearch->save(); // land_size_price_min
            $this->reservation_price_min->AdvancedSearch->save(); // reservation_price_min
            $this->minimum_down_payment_min->AdvancedSearch->save(); // minimum_down_payment_min
            $this->down_price_min->AdvancedSearch->save(); // down_price_min
            $this->remaining_credit_limit_down->AdvancedSearch->save(); // remaining_credit_limit_down
            $this->fee_min->AdvancedSearch->save(); // fee_min
            $this->monthly_payment_min->AdvancedSearch->save(); // monthly_payment_min
            $this->annual_interest_buyer_model_min->AdvancedSearch->save(); // annual_interest_buyer_model_min
            $this->interest_downpayment_financing->AdvancedSearch->save(); // interest_down-payment_financing
            $this->monthly_expenses_min->AdvancedSearch->save(); // monthly_expenses_min
            $this->average_rent_min->AdvancedSearch->save(); // average_rent_min
            $this->average_down_payment_min->AdvancedSearch->save(); // average_down_payment_min
            $this->installment_down_payment_loan->AdvancedSearch->save(); // installment_down_payment_loan
            $this->count_view->AdvancedSearch->save(); // count_view
            $this->count_favorite->AdvancedSearch->save(); // count_favorite
            $this->price_invertor->AdvancedSearch->save(); // price_invertor
            $this->expired_date->AdvancedSearch->save(); // expired_date
            $this->cdate->AdvancedSearch->save(); // cdate
            $this->cuser->AdvancedSearch->save(); // cuser
            $this->cip->AdvancedSearch->save(); // cip
            $this->uip->AdvancedSearch->save(); // uip
            $this->udate->AdvancedSearch->save(); // udate
            $this->uuser->AdvancedSearch->save(); // uuser
        }
        return $where;
    }

    // Build search SQL
    protected function buildSearchSql(&$where, &$fld, $default, $multiValue)
    {
        $fldParm = $fld->Param;
        $fldVal = $default ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = $default ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldCond = $default ? $fld->AdvancedSearch->SearchConditionDefault : $fld->AdvancedSearch->SearchCondition;
        $fldVal2 = $default ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        $fldOpr2 = $default ? $fld->AdvancedSearch->SearchOperator2Default : $fld->AdvancedSearch->SearchOperator2;
        $wrk = "";
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldOpr = strtoupper(trim($fldOpr));
        if ($fldOpr == "") {
            $fldOpr = "=";
        }
        $fldOpr2 = strtoupper(trim($fldOpr2));
        if ($fldOpr2 == "") {
            $fldOpr2 = "=";
        }
        if (Config("SEARCH_MULTI_VALUE_OPTION") == 1 && !$fld->UseFilter || !IsMultiSearchOperator($fldOpr)) {
            $multiValue = false;
        }
        if ($multiValue) {
            $wrk = $fldVal != "" ? GetMultiSearchSql($fld, $fldOpr, $fldVal, $this->Dbid) : ""; // Field value 1
            $wrk2 = $fldVal2 != "" ? GetMultiSearchSql($fld, $fldOpr2, $fldVal2, $this->Dbid) : ""; // Field value 2
            AddFilter($wrk, $wrk2, $fldCond);
        } else {
            $fldVal = $this->convertSearchValue($fld, $fldVal);
            $fldVal2 = $this->convertSearchValue($fld, $fldVal2);
            $wrk = GetSearchSql($fld, $fldVal, $fldOpr, $fldCond, $fldVal2, $fldOpr2, $this->Dbid);
        }
        if ($this->SearchOption == "AUTO" && in_array($this->BasicSearch->getType(), ["AND", "OR"])) {
            $cond = $this->BasicSearch->getType();
        } else {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
        }
        AddFilter($where, $wrk, $cond);
    }

    // Convert search value
    protected function convertSearchValue(&$fld, $fldVal)
    {
        if ($fldVal == Config("NULL_VALUE") || $fldVal == Config("NOT_NULL_VALUE")) {
            return $fldVal;
        }
        $value = $fldVal;
        if ($fld->isBoolean()) {
            if ($fldVal != "") {
                $value = (SameText($fldVal, "1") || SameText($fldVal, "y") || SameText($fldVal, "t")) ? $fld->TrueValue : $fld->FalseValue;
            }
        } elseif ($fld->DataType == DATATYPE_DATE || $fld->DataType == DATATYPE_TIME) {
            if ($fldVal != "") {
                $value = UnFormatDateTime($fldVal, $fld->formatPattern());
            }
        }
        return $value;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        if ($this->_title->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->title_en->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->brand_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->detail->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->detail_en->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->asset_code->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->asset_status->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->latitude->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->longitude->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->num_buildings->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->num_unit->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->num_floors->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->floors->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->asset_year_developer->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->num_parking_spaces->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->num_bathrooms->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->num_bedrooms->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->address->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->address_en->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->province_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->amphur_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->district_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->postcode->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->floor_plan->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->layout_unit->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->asset_website->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->asset_review->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->isactive->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->is_recommend->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->order_by->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->type_pay->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->type_pay_2->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->price_mark->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->holding_property->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->common_fee->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->usable_area->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->usable_area_price->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->land_size->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->land_size_price->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->commission->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->transfer_day_expenses_with_business_tax->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->transfer_day_expenses_without_business_tax->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->price->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->discount->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->price_special->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->reservation_price_model_a->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->minimum_down_payment_model_a->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->down_price_min_a->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->down_price_model_a->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->factor_monthly_installment_over_down->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fee_a->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->monthly_payment_buyer->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->annual_interest_buyer_model_a->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->monthly_expenses_a->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->average_rent_a->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->average_down_payment_a->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->bank_appraisal_price->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->mark_up_price->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->required_gap->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->minimum_down_payment->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->price_down_max->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->discount_max->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->price_down_special_max->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->usable_area_price_max->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->land_size_price_max->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->reservation_price_max->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->minimum_down_payment_max->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->down_price_max->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->down_price->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->factor_monthly_installment_over_down_max->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fee_max->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->monthly_payment_max->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->annual_interest_buyer->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->monthly_expense_max->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->average_rent_max->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->average_down_payment_max->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->min_down->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->remaining_down->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->factor_financing->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->credit_limit_down->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->price_down_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->discount_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->price_down_special_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->usable_area_price_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->land_size_price_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->reservation_price_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->minimum_down_payment_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->down_price_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->remaining_credit_limit_down->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fee_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->monthly_payment_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->annual_interest_buyer_model_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->interest_downpayment_financing->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->monthly_expenses_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->average_rent_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->average_down_payment_min->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->installment_down_payment_loan->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->count_view->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->count_favorite->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->price_invertor->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->expired_date->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cdate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cuser->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cip->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->uip->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->udate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->uuser->AdvancedSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear advanced search parameters
        $this->resetAdvancedSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all advanced search parameters
    protected function resetAdvancedSearchParms()
    {
        $this->_title->AdvancedSearch->unsetSession();
        $this->title_en->AdvancedSearch->unsetSession();
        $this->brand_id->AdvancedSearch->unsetSession();
        $this->detail->AdvancedSearch->unsetSession();
        $this->detail_en->AdvancedSearch->unsetSession();
        $this->asset_code->AdvancedSearch->unsetSession();
        $this->asset_status->AdvancedSearch->unsetSession();
        $this->latitude->AdvancedSearch->unsetSession();
        $this->longitude->AdvancedSearch->unsetSession();
        $this->num_buildings->AdvancedSearch->unsetSession();
        $this->num_unit->AdvancedSearch->unsetSession();
        $this->num_floors->AdvancedSearch->unsetSession();
        $this->floors->AdvancedSearch->unsetSession();
        $this->asset_year_developer->AdvancedSearch->unsetSession();
        $this->num_parking_spaces->AdvancedSearch->unsetSession();
        $this->num_bathrooms->AdvancedSearch->unsetSession();
        $this->num_bedrooms->AdvancedSearch->unsetSession();
        $this->address->AdvancedSearch->unsetSession();
        $this->address_en->AdvancedSearch->unsetSession();
        $this->province_id->AdvancedSearch->unsetSession();
        $this->amphur_id->AdvancedSearch->unsetSession();
        $this->district_id->AdvancedSearch->unsetSession();
        $this->postcode->AdvancedSearch->unsetSession();
        $this->floor_plan->AdvancedSearch->unsetSession();
        $this->layout_unit->AdvancedSearch->unsetSession();
        $this->asset_website->AdvancedSearch->unsetSession();
        $this->asset_review->AdvancedSearch->unsetSession();
        $this->isactive->AdvancedSearch->unsetSession();
        $this->is_recommend->AdvancedSearch->unsetSession();
        $this->order_by->AdvancedSearch->unsetSession();
        $this->type_pay->AdvancedSearch->unsetSession();
        $this->type_pay_2->AdvancedSearch->unsetSession();
        $this->price_mark->AdvancedSearch->unsetSession();
        $this->holding_property->AdvancedSearch->unsetSession();
        $this->common_fee->AdvancedSearch->unsetSession();
        $this->usable_area->AdvancedSearch->unsetSession();
        $this->usable_area_price->AdvancedSearch->unsetSession();
        $this->land_size->AdvancedSearch->unsetSession();
        $this->land_size_price->AdvancedSearch->unsetSession();
        $this->commission->AdvancedSearch->unsetSession();
        $this->transfer_day_expenses_with_business_tax->AdvancedSearch->unsetSession();
        $this->transfer_day_expenses_without_business_tax->AdvancedSearch->unsetSession();
        $this->price->AdvancedSearch->unsetSession();
        $this->discount->AdvancedSearch->unsetSession();
        $this->price_special->AdvancedSearch->unsetSession();
        $this->reservation_price_model_a->AdvancedSearch->unsetSession();
        $this->minimum_down_payment_model_a->AdvancedSearch->unsetSession();
        $this->down_price_min_a->AdvancedSearch->unsetSession();
        $this->down_price_model_a->AdvancedSearch->unsetSession();
        $this->factor_monthly_installment_over_down->AdvancedSearch->unsetSession();
        $this->fee_a->AdvancedSearch->unsetSession();
        $this->monthly_payment_buyer->AdvancedSearch->unsetSession();
        $this->annual_interest_buyer_model_a->AdvancedSearch->unsetSession();
        $this->monthly_expenses_a->AdvancedSearch->unsetSession();
        $this->average_rent_a->AdvancedSearch->unsetSession();
        $this->average_down_payment_a->AdvancedSearch->unsetSession();
        $this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->unsetSession();
        $this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->unsetSession();
        $this->bank_appraisal_price->AdvancedSearch->unsetSession();
        $this->mark_up_price->AdvancedSearch->unsetSession();
        $this->required_gap->AdvancedSearch->unsetSession();
        $this->minimum_down_payment->AdvancedSearch->unsetSession();
        $this->price_down_max->AdvancedSearch->unsetSession();
        $this->discount_max->AdvancedSearch->unsetSession();
        $this->price_down_special_max->AdvancedSearch->unsetSession();
        $this->usable_area_price_max->AdvancedSearch->unsetSession();
        $this->land_size_price_max->AdvancedSearch->unsetSession();
        $this->reservation_price_max->AdvancedSearch->unsetSession();
        $this->minimum_down_payment_max->AdvancedSearch->unsetSession();
        $this->down_price_max->AdvancedSearch->unsetSession();
        $this->down_price->AdvancedSearch->unsetSession();
        $this->factor_monthly_installment_over_down_max->AdvancedSearch->unsetSession();
        $this->fee_max->AdvancedSearch->unsetSession();
        $this->monthly_payment_max->AdvancedSearch->unsetSession();
        $this->annual_interest_buyer->AdvancedSearch->unsetSession();
        $this->monthly_expense_max->AdvancedSearch->unsetSession();
        $this->average_rent_max->AdvancedSearch->unsetSession();
        $this->average_down_payment_max->AdvancedSearch->unsetSession();
        $this->min_down->AdvancedSearch->unsetSession();
        $this->remaining_down->AdvancedSearch->unsetSession();
        $this->factor_financing->AdvancedSearch->unsetSession();
        $this->credit_limit_down->AdvancedSearch->unsetSession();
        $this->price_down_min->AdvancedSearch->unsetSession();
        $this->discount_min->AdvancedSearch->unsetSession();
        $this->price_down_special_min->AdvancedSearch->unsetSession();
        $this->usable_area_price_min->AdvancedSearch->unsetSession();
        $this->land_size_price_min->AdvancedSearch->unsetSession();
        $this->reservation_price_min->AdvancedSearch->unsetSession();
        $this->minimum_down_payment_min->AdvancedSearch->unsetSession();
        $this->down_price_min->AdvancedSearch->unsetSession();
        $this->remaining_credit_limit_down->AdvancedSearch->unsetSession();
        $this->fee_min->AdvancedSearch->unsetSession();
        $this->monthly_payment_min->AdvancedSearch->unsetSession();
        $this->annual_interest_buyer_model_min->AdvancedSearch->unsetSession();
        $this->interest_downpayment_financing->AdvancedSearch->unsetSession();
        $this->monthly_expenses_min->AdvancedSearch->unsetSession();
        $this->average_rent_min->AdvancedSearch->unsetSession();
        $this->average_down_payment_min->AdvancedSearch->unsetSession();
        $this->installment_down_payment_loan->AdvancedSearch->unsetSession();
        $this->count_view->AdvancedSearch->unsetSession();
        $this->count_favorite->AdvancedSearch->unsetSession();
        $this->price_invertor->AdvancedSearch->unsetSession();
        $this->expired_date->AdvancedSearch->unsetSession();
        $this->cdate->AdvancedSearch->unsetSession();
        $this->cuser->AdvancedSearch->unsetSession();
        $this->cip->AdvancedSearch->unsetSession();
        $this->uip->AdvancedSearch->unsetSession();
        $this->udate->AdvancedSearch->unsetSession();
        $this->uuser->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore advanced search values
        $this->_title->AdvancedSearch->load();
        $this->title_en->AdvancedSearch->load();
        $this->brand_id->AdvancedSearch->load();
        $this->detail->AdvancedSearch->load();
        $this->detail_en->AdvancedSearch->load();
        $this->asset_code->AdvancedSearch->load();
        $this->asset_status->AdvancedSearch->load();
        $this->latitude->AdvancedSearch->load();
        $this->longitude->AdvancedSearch->load();
        $this->num_buildings->AdvancedSearch->load();
        $this->num_unit->AdvancedSearch->load();
        $this->num_floors->AdvancedSearch->load();
        $this->floors->AdvancedSearch->load();
        $this->asset_year_developer->AdvancedSearch->load();
        $this->num_parking_spaces->AdvancedSearch->load();
        $this->num_bathrooms->AdvancedSearch->load();
        $this->num_bedrooms->AdvancedSearch->load();
        $this->address->AdvancedSearch->load();
        $this->address_en->AdvancedSearch->load();
        $this->province_id->AdvancedSearch->load();
        $this->amphur_id->AdvancedSearch->load();
        $this->district_id->AdvancedSearch->load();
        $this->postcode->AdvancedSearch->load();
        $this->floor_plan->AdvancedSearch->load();
        $this->layout_unit->AdvancedSearch->load();
        $this->asset_website->AdvancedSearch->load();
        $this->asset_review->AdvancedSearch->load();
        $this->isactive->AdvancedSearch->load();
        $this->is_recommend->AdvancedSearch->load();
        $this->order_by->AdvancedSearch->load();
        $this->type_pay->AdvancedSearch->load();
        $this->type_pay_2->AdvancedSearch->load();
        $this->price_mark->AdvancedSearch->load();
        $this->holding_property->AdvancedSearch->load();
        $this->common_fee->AdvancedSearch->load();
        $this->usable_area->AdvancedSearch->load();
        $this->usable_area_price->AdvancedSearch->load();
        $this->land_size->AdvancedSearch->load();
        $this->land_size_price->AdvancedSearch->load();
        $this->commission->AdvancedSearch->load();
        $this->transfer_day_expenses_with_business_tax->AdvancedSearch->load();
        $this->transfer_day_expenses_without_business_tax->AdvancedSearch->load();
        $this->price->AdvancedSearch->load();
        $this->discount->AdvancedSearch->load();
        $this->price_special->AdvancedSearch->load();
        $this->reservation_price_model_a->AdvancedSearch->load();
        $this->minimum_down_payment_model_a->AdvancedSearch->load();
        $this->down_price_min_a->AdvancedSearch->load();
        $this->down_price_model_a->AdvancedSearch->load();
        $this->factor_monthly_installment_over_down->AdvancedSearch->load();
        $this->fee_a->AdvancedSearch->load();
        $this->monthly_payment_buyer->AdvancedSearch->load();
        $this->annual_interest_buyer_model_a->AdvancedSearch->load();
        $this->monthly_expenses_a->AdvancedSearch->load();
        $this->average_rent_a->AdvancedSearch->load();
        $this->average_down_payment_a->AdvancedSearch->load();
        $this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->load();
        $this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->load();
        $this->bank_appraisal_price->AdvancedSearch->load();
        $this->mark_up_price->AdvancedSearch->load();
        $this->required_gap->AdvancedSearch->load();
        $this->minimum_down_payment->AdvancedSearch->load();
        $this->price_down_max->AdvancedSearch->load();
        $this->discount_max->AdvancedSearch->load();
        $this->price_down_special_max->AdvancedSearch->load();
        $this->usable_area_price_max->AdvancedSearch->load();
        $this->land_size_price_max->AdvancedSearch->load();
        $this->reservation_price_max->AdvancedSearch->load();
        $this->minimum_down_payment_max->AdvancedSearch->load();
        $this->down_price_max->AdvancedSearch->load();
        $this->down_price->AdvancedSearch->load();
        $this->factor_monthly_installment_over_down_max->AdvancedSearch->load();
        $this->fee_max->AdvancedSearch->load();
        $this->monthly_payment_max->AdvancedSearch->load();
        $this->annual_interest_buyer->AdvancedSearch->load();
        $this->monthly_expense_max->AdvancedSearch->load();
        $this->average_rent_max->AdvancedSearch->load();
        $this->average_down_payment_max->AdvancedSearch->load();
        $this->min_down->AdvancedSearch->load();
        $this->remaining_down->AdvancedSearch->load();
        $this->factor_financing->AdvancedSearch->load();
        $this->credit_limit_down->AdvancedSearch->load();
        $this->price_down_min->AdvancedSearch->load();
        $this->discount_min->AdvancedSearch->load();
        $this->price_down_special_min->AdvancedSearch->load();
        $this->usable_area_price_min->AdvancedSearch->load();
        $this->land_size_price_min->AdvancedSearch->load();
        $this->reservation_price_min->AdvancedSearch->load();
        $this->minimum_down_payment_min->AdvancedSearch->load();
        $this->down_price_min->AdvancedSearch->load();
        $this->remaining_credit_limit_down->AdvancedSearch->load();
        $this->fee_min->AdvancedSearch->load();
        $this->monthly_payment_min->AdvancedSearch->load();
        $this->annual_interest_buyer_model_min->AdvancedSearch->load();
        $this->interest_downpayment_financing->AdvancedSearch->load();
        $this->monthly_expenses_min->AdvancedSearch->load();
        $this->average_rent_min->AdvancedSearch->load();
        $this->average_down_payment_min->AdvancedSearch->load();
        $this->installment_down_payment_loan->AdvancedSearch->load();
        $this->count_view->AdvancedSearch->load();
        $this->count_favorite->AdvancedSearch->load();
        $this->price_invertor->AdvancedSearch->load();
        $this->expired_date->AdvancedSearch->load();
        $this->cdate->AdvancedSearch->load();
        $this->cuser->AdvancedSearch->load();
        $this->cip->AdvancedSearch->load();
        $this->uip->AdvancedSearch->load();
        $this->udate->AdvancedSearch->load();
        $this->uuser->AdvancedSearch->load();
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
            $this->updateSort($this->_title, $ctrl); // title
            $this->updateSort($this->brand_id, $ctrl); // brand_id
            $this->updateSort($this->asset_code, $ctrl); // asset_code
            $this->updateSort($this->asset_status, $ctrl); // asset_status
            $this->updateSort($this->isactive, $ctrl); // isactive
            $this->updateSort($this->price_mark, $ctrl); // price_mark
            $this->updateSort($this->usable_area, $ctrl); // usable_area
            $this->updateSort($this->land_size, $ctrl); // land_size
            $this->updateSort($this->count_view, $ctrl); // count_view
            $this->updateSort($this->count_favorite, $ctrl); // count_favorite
            $this->updateSort($this->expired_date, $ctrl); // expired_date
            $this->updateSort($this->cdate, $ctrl); // cdate
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
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

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
                $this->asset_id->setSort("");
                $this->_title->setSort("");
                $this->title_en->setSort("");
                $this->brand_id->setSort("");
                $this->asset_short_detail->setSort("");
                $this->asset_short_detail_en->setSort("");
                $this->detail->setSort("");
                $this->detail_en->setSort("");
                $this->asset_code->setSort("");
                $this->asset_status->setSort("");
                $this->latitude->setSort("");
                $this->longitude->setSort("");
                $this->num_buildings->setSort("");
                $this->num_unit->setSort("");
                $this->num_floors->setSort("");
                $this->floors->setSort("");
                $this->asset_year_developer->setSort("");
                $this->num_parking_spaces->setSort("");
                $this->num_bathrooms->setSort("");
                $this->num_bedrooms->setSort("");
                $this->address->setSort("");
                $this->address_en->setSort("");
                $this->province_id->setSort("");
                $this->amphur_id->setSort("");
                $this->district_id->setSort("");
                $this->postcode->setSort("");
                $this->floor_plan->setSort("");
                $this->layout_unit->setSort("");
                $this->asset_website->setSort("");
                $this->asset_review->setSort("");
                $this->isactive->setSort("");
                $this->is_recommend->setSort("");
                $this->order_by->setSort("");
                $this->type_pay->setSort("");
                $this->type_pay_2->setSort("");
                $this->price_mark->setSort("");
                $this->holding_property->setSort("");
                $this->common_fee->setSort("");
                $this->usable_area->setSort("");
                $this->usable_area_price->setSort("");
                $this->land_size->setSort("");
                $this->land_size_price->setSort("");
                $this->commission->setSort("");
                $this->transfer_day_expenses_with_business_tax->setSort("");
                $this->transfer_day_expenses_without_business_tax->setSort("");
                $this->price->setSort("");
                $this->discount->setSort("");
                $this->price_special->setSort("");
                $this->reservation_price_model_a->setSort("");
                $this->minimum_down_payment_model_a->setSort("");
                $this->down_price_min_a->setSort("");
                $this->down_price_model_a->setSort("");
                $this->factor_monthly_installment_over_down->setSort("");
                $this->fee_a->setSort("");
                $this->monthly_payment_buyer->setSort("");
                $this->annual_interest_buyer_model_a->setSort("");
                $this->monthly_expenses_a->setSort("");
                $this->average_rent_a->setSort("");
                $this->average_down_payment_a->setSort("");
                $this->transfer_day_expenses_without_business_tax_max_min->setSort("");
                $this->transfer_day_expenses_with_business_tax_max_min->setSort("");
                $this->bank_appraisal_price->setSort("");
                $this->mark_up_price->setSort("");
                $this->required_gap->setSort("");
                $this->minimum_down_payment->setSort("");
                $this->price_down_max->setSort("");
                $this->discount_max->setSort("");
                $this->price_down_special_max->setSort("");
                $this->usable_area_price_max->setSort("");
                $this->land_size_price_max->setSort("");
                $this->reservation_price_max->setSort("");
                $this->minimum_down_payment_max->setSort("");
                $this->down_price_max->setSort("");
                $this->down_price->setSort("");
                $this->factor_monthly_installment_over_down_max->setSort("");
                $this->fee_max->setSort("");
                $this->monthly_payment_max->setSort("");
                $this->annual_interest_buyer->setSort("");
                $this->monthly_expense_max->setSort("");
                $this->average_rent_max->setSort("");
                $this->average_down_payment_max->setSort("");
                $this->min_down->setSort("");
                $this->remaining_down->setSort("");
                $this->factor_financing->setSort("");
                $this->credit_limit_down->setSort("");
                $this->price_down_min->setSort("");
                $this->discount_min->setSort("");
                $this->price_down_special_min->setSort("");
                $this->usable_area_price_min->setSort("");
                $this->land_size_price_min->setSort("");
                $this->reservation_price_min->setSort("");
                $this->minimum_down_payment_min->setSort("");
                $this->down_price_min->setSort("");
                $this->remaining_credit_limit_down->setSort("");
                $this->fee_min->setSort("");
                $this->monthly_payment_min->setSort("");
                $this->annual_interest_buyer_model_min->setSort("");
                $this->interest_downpayment_financing->setSort("");
                $this->monthly_expenses_min->setSort("");
                $this->average_rent_min->setSort("");
                $this->average_down_payment_min->setSort("");
                $this->installment_down_payment_loan->setSort("");
                $this->count_view->setSort("");
                $this->count_favorite->setSort("");
                $this->price_invertor->setSort("");
                $this->installment_price->setSort("");
                $this->installment_all->setSort("");
                $this->master_calculator->setSort("");
                $this->expired_date->setSort("");
                $this->tag->setSort("");
                $this->cdate->setSort("");
                $this->cuser->setSort("");
                $this->cip->setSort("");
                $this->uip->setSort("");
                $this->udate->setSort("");
                $this->uuser->setSort("");
                $this->update_expired_key->setSort("");
                $this->update_expired_status->setSort("");
                $this->update_expired_date->setSort("");
                $this->update_expired_ip->setSort("");
                $this->is_cancel_contract->setSort("");
                $this->cancel_contract_reason->setSort("");
                $this->cancel_contract_reason_detail->setSort("");
                $this->cancel_contract_date->setSort("");
                $this->cancel_contract_user->setSort("");
                $this->cancel_contract_ip->setSort("");
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

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = false;

        // "detail_asset_facilities"
        $item = &$this->ListOptions->add("detail_asset_facilities");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'asset_facilities');
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_asset_pros_detail"
        $item = &$this->ListOptions->add("detail_asset_pros_detail");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'asset_pros_detail');
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_asset_banner"
        $item = &$this->ListOptions->add("detail_asset_banner");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'asset_banner');
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_asset_category"
        $item = &$this->ListOptions->add("detail_asset_category");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'asset_category');
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_asset_warning"
        $item = &$this->ListOptions->add("detail_asset_warning");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'asset_warning');
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // Multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$this->ListOptions->add("details");
            $item->CssClass = "text-nowrap";
            $item->Visible = $this->ShowMultipleDetails && $this->ListOptions->detailVisible();
            $item->OnLeft = false;
            $item->ShowInButtonGroup = false;
            $this->ListOptions->hideDetailItems();
        }

        // Set up detail pages
        $pages = new SubPages();
        $pages->add("asset_facilities");
        $pages->add("asset_pros_detail");
        $pages->add("asset_banner");
        $pages->add("asset_category");
        $pages->add("asset_warning");
        $this->DetailPages = $pages;

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
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        // $item->Visible = $this->ListOptions->groupOptionVisible();
        $item->Visible = false;
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

        // "sequence"
        $opt = $this->ListOptions["sequence"];
        $opt->Body = FormatSequenceNumber($this->RecordCount);
        $pageUrl = $this->pageUrl(false);
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) ."asset_facilities,asset_pros_detail,asset_banner,asset_category". "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) ."asset_facilities,asset_pros_detail,asset_banner,asset_category". "\">" . $Language->phrase("EditLink") . "</a>";
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
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fassetlist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button></li>";
                    if ($link != "") {
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fassetlist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button>";
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
        $detailViewTblVar = "";
        $detailCopyTblVar = "";
        $detailEditTblVar = "";

        // "detail_asset_facilities"
        $opt = $this->ListOptions["detail_asset_facilities"];
        if ($Security->allowList(CurrentProjectID() . 'asset_facilities')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("asset_facilities", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("assetfacilitieslist?" . Config("TABLE_SHOW_MASTER") . "=asset&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("AssetFacilitiesGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'asset')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=asset_facilities");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "asset_facilities";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'asset')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=asset_facilities");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
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
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_asset_pros_detail"
        $opt = $this->ListOptions["detail_asset_pros_detail"];
        if ($Security->allowList(CurrentProjectID() . 'asset_pros_detail')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("asset_pros_detail", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("assetprosdetaillist?" . Config("TABLE_SHOW_MASTER") . "=asset&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("AssetProsDetailGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'asset')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=asset_pros_detail");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "asset_pros_detail";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'asset')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=asset_pros_detail");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
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
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_asset_banner"
        $opt = $this->ListOptions["detail_asset_banner"];
        if ($Security->allowList(CurrentProjectID() . 'asset_banner')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("asset_banner", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("assetbannerlist?" . Config("TABLE_SHOW_MASTER") . "=asset&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("AssetBannerGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'asset')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=asset_banner");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "asset_banner";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'asset')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=asset_banner");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
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
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_asset_category"
        $opt = $this->ListOptions["detail_asset_category"];
        if ($Security->allowList(CurrentProjectID() . 'asset_category')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("asset_category", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("assetcategorylist?" . Config("TABLE_SHOW_MASTER") . "=asset&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("AssetCategoryGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'asset')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=asset_category");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "asset_category";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'asset')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=asset_category");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
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
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_asset_warning"
        $opt = $this->ListOptions["detail_asset_warning"];
        if ($Security->allowList(CurrentProjectID() . 'asset_warning')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("asset_warning", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("assetwarninglist?" . Config("TABLE_SHOW_MASTER") . "=asset&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("AssetWarningGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'asset')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=asset_warning");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "asset_warning";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'asset')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=asset_warning");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
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
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }
        if ($this->ShowMultipleDetails) {
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
            $links = "";
            if ($detailViewTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailViewLink", true)) . "\" href=\"" . HtmlEncode($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar)) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            }
            if ($detailEditTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailEditLink", true)) . "\" href=\"" . HtmlEncode($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar)) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            }
            if ($detailCopyTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailCopyLink", true)) . "\" href=\"" . HtmlEncode($this->GetCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar)) . "\">" . $Language->phrase("MasterDetailCopyLink", null) . "</a></li>";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlEncode($Language->phrase("MultipleMasterDetails", true)) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
                $body .= "<ul class=\"dropdown-menu ew-menu\">" . $links . "</ul>";
            }
            $body .= "</div>";
            // Multiple details
            $opt = $this->ListOptions["details"];
            $opt->Body = $body;
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->asset_id->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
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
        $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl))."asset_facilities,asset_pros_detail,asset_banner,asset_category" . "\">" . $Language->phrase("AddLink") . "</a>";

        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $option = $options["detail"];
        $detailTableLink = "";
                $item = &$option->add("detailadd_asset_facilities");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=asset_facilities");
                $detailPage = Container("AssetFacilitiesGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'asset') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "asset_facilities";
                }
                $item = &$option->add("detailadd_asset_pros_detail");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=asset_pros_detail");
                $detailPage = Container("AssetProsDetailGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'asset') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "asset_pros_detail";
                }
                $item = &$option->add("detailadd_asset_banner");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=asset_banner");
                $detailPage = Container("AssetBannerGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'asset') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "asset_banner";
                }
                $item = &$option->add("detailadd_asset_category");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=asset_category");
                $detailPage = Container("AssetCategoryGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'asset') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "asset_category";
                }
                $item = &$option->add("detailadd_asset_warning");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=asset_warning");
                $detailPage = Container("AssetWarningGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'asset') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "asset_warning";
                }

        // Add multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$option->add("detailsadd");
            $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailTableLink);
            $caption = $Language->phrase("AddMasterDetailLink");
            $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
            // $item->Visible = $detailTableLink != "" && $Security->canAdd();
            $item->Visible = false;
            // Hide single master/detail items
            $ar = explode(",", $detailTableLink);
            $cnt = count($ar);
            for ($i = 0; $i < $cnt; $i++) {
                if ($item = $option["detailadd_" . $ar[$i]]) {
                    $item->Visible = false;
                }
            }
        }
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $option->add("title", $this->createColumnOption("title"));
            $option->add("brand_id", $this->createColumnOption("brand_id"));
            $option->add("asset_code", $this->createColumnOption("asset_code"));
            $option->add("asset_status", $this->createColumnOption("asset_status"));
            $option->add("isactive", $this->createColumnOption("isactive"));
            $option->add("price_mark", $this->createColumnOption("price_mark"));
            $option->add("usable_area", $this->createColumnOption("usable_area"));
            $option->add("land_size", $this->createColumnOption("land_size"));
            $option->add("count_view", $this->createColumnOption("count_view"));
            $option->add("count_favorite", $this->createColumnOption("count_favorite"));
            $option->add("expired_date", $this->createColumnOption("expired_date"));
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fassetsrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fassetsrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fassetlist"' . $listaction->toDataAttrs() . '>' . $icon . '</button>';
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

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // title
        if ($this->_title->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->_title->AdvancedSearch->SearchValue != "" || $this->_title->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // title_en
        if ($this->title_en->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->title_en->AdvancedSearch->SearchValue != "" || $this->title_en->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // brand_id
        if ($this->brand_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->brand_id->AdvancedSearch->SearchValue != "" || $this->brand_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // detail
        if ($this->detail->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->detail->AdvancedSearch->SearchValue != "" || $this->detail->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // detail_en
        if ($this->detail_en->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->detail_en->AdvancedSearch->SearchValue != "" || $this->detail_en->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // asset_code
        if ($this->asset_code->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->asset_code->AdvancedSearch->SearchValue != "" || $this->asset_code->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // asset_status
        if ($this->asset_status->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->asset_status->AdvancedSearch->SearchValue != "" || $this->asset_status->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // latitude
        if ($this->latitude->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->latitude->AdvancedSearch->SearchValue != "" || $this->latitude->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // longitude
        if ($this->longitude->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->longitude->AdvancedSearch->SearchValue != "" || $this->longitude->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // num_buildings
        if ($this->num_buildings->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->num_buildings->AdvancedSearch->SearchValue != "" || $this->num_buildings->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // num_unit
        if ($this->num_unit->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->num_unit->AdvancedSearch->SearchValue != "" || $this->num_unit->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // num_floors
        if ($this->num_floors->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->num_floors->AdvancedSearch->SearchValue != "" || $this->num_floors->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // floors
        if ($this->floors->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->floors->AdvancedSearch->SearchValue != "" || $this->floors->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // asset_year_developer
        if ($this->asset_year_developer->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->asset_year_developer->AdvancedSearch->SearchValue != "" || $this->asset_year_developer->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // num_parking_spaces
        if ($this->num_parking_spaces->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->num_parking_spaces->AdvancedSearch->SearchValue != "" || $this->num_parking_spaces->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // num_bathrooms
        if ($this->num_bathrooms->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->num_bathrooms->AdvancedSearch->SearchValue != "" || $this->num_bathrooms->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // num_bedrooms
        if ($this->num_bedrooms->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->num_bedrooms->AdvancedSearch->SearchValue != "" || $this->num_bedrooms->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // address
        if ($this->address->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->address->AdvancedSearch->SearchValue != "" || $this->address->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // address_en
        if ($this->address_en->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->address_en->AdvancedSearch->SearchValue != "" || $this->address_en->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // province_id
        if ($this->province_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->province_id->AdvancedSearch->SearchValue != "" || $this->province_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // amphur_id
        if ($this->amphur_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->amphur_id->AdvancedSearch->SearchValue != "" || $this->amphur_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // district_id
        if ($this->district_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->district_id->AdvancedSearch->SearchValue != "" || $this->district_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // postcode
        if ($this->postcode->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->postcode->AdvancedSearch->SearchValue != "" || $this->postcode->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // floor_plan
        if ($this->floor_plan->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->floor_plan->AdvancedSearch->SearchValue != "" || $this->floor_plan->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // layout_unit
        if ($this->layout_unit->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->layout_unit->AdvancedSearch->SearchValue != "" || $this->layout_unit->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // asset_website
        if ($this->asset_website->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->asset_website->AdvancedSearch->SearchValue != "" || $this->asset_website->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // asset_review
        if ($this->asset_review->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->asset_review->AdvancedSearch->SearchValue != "" || $this->asset_review->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // isactive
        if ($this->isactive->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->isactive->AdvancedSearch->SearchValue != "" || $this->isactive->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // is_recommend
        if ($this->is_recommend->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->is_recommend->AdvancedSearch->SearchValue != "" || $this->is_recommend->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // order_by
        if ($this->order_by->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->order_by->AdvancedSearch->SearchValue != "" || $this->order_by->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // type_pay
        if ($this->type_pay->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->type_pay->AdvancedSearch->SearchValue != "" || $this->type_pay->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->type_pay->AdvancedSearch->SearchValue)) {
            $this->type_pay->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->type_pay->AdvancedSearch->SearchValue);
        }
        if (is_array($this->type_pay->AdvancedSearch->SearchValue2)) {
            $this->type_pay->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->type_pay->AdvancedSearch->SearchValue2);
        }

        // type_pay_2
        if ($this->type_pay_2->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->type_pay_2->AdvancedSearch->SearchValue != "" || $this->type_pay_2->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->type_pay_2->AdvancedSearch->SearchValue)) {
            $this->type_pay_2->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->type_pay_2->AdvancedSearch->SearchValue);
        }
        if (is_array($this->type_pay_2->AdvancedSearch->SearchValue2)) {
            $this->type_pay_2->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->type_pay_2->AdvancedSearch->SearchValue2);
        }

        // price_mark
        if ($this->price_mark->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->price_mark->AdvancedSearch->SearchValue != "" || $this->price_mark->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // holding_property
        if ($this->holding_property->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->holding_property->AdvancedSearch->SearchValue != "" || $this->holding_property->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->holding_property->AdvancedSearch->SearchValue)) {
            $this->holding_property->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->holding_property->AdvancedSearch->SearchValue);
        }
        if (is_array($this->holding_property->AdvancedSearch->SearchValue2)) {
            $this->holding_property->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->holding_property->AdvancedSearch->SearchValue2);
        }

        // common_fee
        if ($this->common_fee->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->common_fee->AdvancedSearch->SearchValue != "" || $this->common_fee->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // usable_area
        if ($this->usable_area->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->usable_area->AdvancedSearch->SearchValue != "" || $this->usable_area->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // usable_area_price
        if ($this->usable_area_price->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->usable_area_price->AdvancedSearch->SearchValue != "" || $this->usable_area_price->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // land_size
        if ($this->land_size->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->land_size->AdvancedSearch->SearchValue != "" || $this->land_size->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // land_size_price
        if ($this->land_size_price->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->land_size_price->AdvancedSearch->SearchValue != "" || $this->land_size_price->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // commission
        if ($this->commission->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->commission->AdvancedSearch->SearchValue != "" || $this->commission->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // transfer_day_expenses_with_business_tax
        if ($this->transfer_day_expenses_with_business_tax->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->transfer_day_expenses_with_business_tax->AdvancedSearch->SearchValue != "" || $this->transfer_day_expenses_with_business_tax->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // transfer_day_expenses_without_business_tax
        if ($this->transfer_day_expenses_without_business_tax->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->transfer_day_expenses_without_business_tax->AdvancedSearch->SearchValue != "" || $this->transfer_day_expenses_without_business_tax->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // price
        if ($this->price->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->price->AdvancedSearch->SearchValue != "" || $this->price->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // discount
        if ($this->discount->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->discount->AdvancedSearch->SearchValue != "" || $this->discount->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // price_special
        if ($this->price_special->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->price_special->AdvancedSearch->SearchValue != "" || $this->price_special->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // reservation_price_model_a
        if ($this->reservation_price_model_a->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->reservation_price_model_a->AdvancedSearch->SearchValue != "" || $this->reservation_price_model_a->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // minimum_down_payment_model_a
        if ($this->minimum_down_payment_model_a->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->minimum_down_payment_model_a->AdvancedSearch->SearchValue != "" || $this->minimum_down_payment_model_a->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // down_price_min_a
        if ($this->down_price_min_a->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->down_price_min_a->AdvancedSearch->SearchValue != "" || $this->down_price_min_a->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // down_price_model_a
        if ($this->down_price_model_a->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->down_price_model_a->AdvancedSearch->SearchValue != "" || $this->down_price_model_a->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // factor_monthly_installment_over_down
        if ($this->factor_monthly_installment_over_down->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->factor_monthly_installment_over_down->AdvancedSearch->SearchValue != "" || $this->factor_monthly_installment_over_down->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fee_a
        if ($this->fee_a->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fee_a->AdvancedSearch->SearchValue != "" || $this->fee_a->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // monthly_payment_buyer
        if ($this->monthly_payment_buyer->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->monthly_payment_buyer->AdvancedSearch->SearchValue != "" || $this->monthly_payment_buyer->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // annual_interest_buyer_model_a
        if ($this->annual_interest_buyer_model_a->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->annual_interest_buyer_model_a->AdvancedSearch->SearchValue != "" || $this->annual_interest_buyer_model_a->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // monthly_expenses_a
        if ($this->monthly_expenses_a->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->monthly_expenses_a->AdvancedSearch->SearchValue != "" || $this->monthly_expenses_a->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // average_rent_a
        if ($this->average_rent_a->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->average_rent_a->AdvancedSearch->SearchValue != "" || $this->average_rent_a->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // average_down_payment_a
        if ($this->average_down_payment_a->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->average_down_payment_a->AdvancedSearch->SearchValue != "" || $this->average_down_payment_a->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // transfer_day_expenses_without_business_tax_max_min
        if ($this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->SearchValue != "" || $this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // transfer_day_expenses_with_business_tax_max_min
        if ($this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->SearchValue != "" || $this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // bank_appraisal_price
        if ($this->bank_appraisal_price->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->bank_appraisal_price->AdvancedSearch->SearchValue != "" || $this->bank_appraisal_price->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // mark_up_price
        if ($this->mark_up_price->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->mark_up_price->AdvancedSearch->SearchValue != "" || $this->mark_up_price->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // required_gap
        if ($this->required_gap->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->required_gap->AdvancedSearch->SearchValue != "" || $this->required_gap->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // minimum_down_payment
        if ($this->minimum_down_payment->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->minimum_down_payment->AdvancedSearch->SearchValue != "" || $this->minimum_down_payment->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // price_down_max
        if ($this->price_down_max->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->price_down_max->AdvancedSearch->SearchValue != "" || $this->price_down_max->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // discount_max
        if ($this->discount_max->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->discount_max->AdvancedSearch->SearchValue != "" || $this->discount_max->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // price_down_special_max
        if ($this->price_down_special_max->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->price_down_special_max->AdvancedSearch->SearchValue != "" || $this->price_down_special_max->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // usable_area_price_max
        if ($this->usable_area_price_max->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->usable_area_price_max->AdvancedSearch->SearchValue != "" || $this->usable_area_price_max->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // land_size_price_max
        if ($this->land_size_price_max->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->land_size_price_max->AdvancedSearch->SearchValue != "" || $this->land_size_price_max->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // reservation_price_max
        if ($this->reservation_price_max->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->reservation_price_max->AdvancedSearch->SearchValue != "" || $this->reservation_price_max->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // minimum_down_payment_max
        if ($this->minimum_down_payment_max->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->minimum_down_payment_max->AdvancedSearch->SearchValue != "" || $this->minimum_down_payment_max->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // down_price_max
        if ($this->down_price_max->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->down_price_max->AdvancedSearch->SearchValue != "" || $this->down_price_max->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // down_price
        if ($this->down_price->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->down_price->AdvancedSearch->SearchValue != "" || $this->down_price->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // factor_monthly_installment_over_down_max
        if ($this->factor_monthly_installment_over_down_max->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->factor_monthly_installment_over_down_max->AdvancedSearch->SearchValue != "" || $this->factor_monthly_installment_over_down_max->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fee_max
        if ($this->fee_max->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fee_max->AdvancedSearch->SearchValue != "" || $this->fee_max->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // monthly_payment_max
        if ($this->monthly_payment_max->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->monthly_payment_max->AdvancedSearch->SearchValue != "" || $this->monthly_payment_max->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // annual_interest_buyer
        if ($this->annual_interest_buyer->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->annual_interest_buyer->AdvancedSearch->SearchValue != "" || $this->annual_interest_buyer->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // monthly_expense_max
        if ($this->monthly_expense_max->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->monthly_expense_max->AdvancedSearch->SearchValue != "" || $this->monthly_expense_max->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // average_rent_max
        if ($this->average_rent_max->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->average_rent_max->AdvancedSearch->SearchValue != "" || $this->average_rent_max->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // average_down_payment_max
        if ($this->average_down_payment_max->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->average_down_payment_max->AdvancedSearch->SearchValue != "" || $this->average_down_payment_max->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // min_down
        if ($this->min_down->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->min_down->AdvancedSearch->SearchValue != "" || $this->min_down->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // remaining_down
        if ($this->remaining_down->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->remaining_down->AdvancedSearch->SearchValue != "" || $this->remaining_down->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // factor_financing
        if ($this->factor_financing->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->factor_financing->AdvancedSearch->SearchValue != "" || $this->factor_financing->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // credit_limit_down
        if ($this->credit_limit_down->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->credit_limit_down->AdvancedSearch->SearchValue != "" || $this->credit_limit_down->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // price_down_min
        if ($this->price_down_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->price_down_min->AdvancedSearch->SearchValue != "" || $this->price_down_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // discount_min
        if ($this->discount_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->discount_min->AdvancedSearch->SearchValue != "" || $this->discount_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // price_down_special_min
        if ($this->price_down_special_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->price_down_special_min->AdvancedSearch->SearchValue != "" || $this->price_down_special_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // usable_area_price_min
        if ($this->usable_area_price_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->usable_area_price_min->AdvancedSearch->SearchValue != "" || $this->usable_area_price_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // land_size_price_min
        if ($this->land_size_price_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->land_size_price_min->AdvancedSearch->SearchValue != "" || $this->land_size_price_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // reservation_price_min
        if ($this->reservation_price_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->reservation_price_min->AdvancedSearch->SearchValue != "" || $this->reservation_price_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // minimum_down_payment_min
        if ($this->minimum_down_payment_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->minimum_down_payment_min->AdvancedSearch->SearchValue != "" || $this->minimum_down_payment_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // down_price_min
        if ($this->down_price_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->down_price_min->AdvancedSearch->SearchValue != "" || $this->down_price_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // remaining_credit_limit_down
        if ($this->remaining_credit_limit_down->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->remaining_credit_limit_down->AdvancedSearch->SearchValue != "" || $this->remaining_credit_limit_down->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fee_min
        if ($this->fee_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fee_min->AdvancedSearch->SearchValue != "" || $this->fee_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // monthly_payment_min
        if ($this->monthly_payment_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->monthly_payment_min->AdvancedSearch->SearchValue != "" || $this->monthly_payment_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // annual_interest_buyer_model_min
        if ($this->annual_interest_buyer_model_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->annual_interest_buyer_model_min->AdvancedSearch->SearchValue != "" || $this->annual_interest_buyer_model_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // interest_down-payment_financing
        if ($this->interest_downpayment_financing->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->interest_downpayment_financing->AdvancedSearch->SearchValue != "" || $this->interest_downpayment_financing->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // monthly_expenses_min
        if ($this->monthly_expenses_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->monthly_expenses_min->AdvancedSearch->SearchValue != "" || $this->monthly_expenses_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // average_rent_min
        if ($this->average_rent_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->average_rent_min->AdvancedSearch->SearchValue != "" || $this->average_rent_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // average_down_payment_min
        if ($this->average_down_payment_min->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->average_down_payment_min->AdvancedSearch->SearchValue != "" || $this->average_down_payment_min->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // installment_down_payment_loan
        if ($this->installment_down_payment_loan->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->installment_down_payment_loan->AdvancedSearch->SearchValue != "" || $this->installment_down_payment_loan->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // count_view
        if ($this->count_view->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->count_view->AdvancedSearch->SearchValue != "" || $this->count_view->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // count_favorite
        if ($this->count_favorite->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->count_favorite->AdvancedSearch->SearchValue != "" || $this->count_favorite->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // price_invertor
        if ($this->price_invertor->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->price_invertor->AdvancedSearch->SearchValue != "" || $this->price_invertor->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // expired_date
        if ($this->expired_date->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->expired_date->AdvancedSearch->SearchValue != "" || $this->expired_date->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cdate
        if ($this->cdate->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cdate->AdvancedSearch->SearchValue != "" || $this->cdate->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cuser
        if ($this->cuser->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cuser->AdvancedSearch->SearchValue != "" || $this->cuser->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cip
        if ($this->cip->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cip->AdvancedSearch->SearchValue != "" || $this->cip->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // uip
        if ($this->uip->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->uip->AdvancedSearch->SearchValue != "" || $this->uip->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // udate
        if ($this->udate->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->udate->AdvancedSearch->SearchValue != "" || $this->udate->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // uuser
        if ($this->uuser->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->uuser->AdvancedSearch->SearchValue != "" || $this->uuser->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        return $hasValue;
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
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // title
            $this->_title->setupEditAttributes();
            $this->_title->EditCustomAttributes = "";
            if (!$this->_title->Raw) {
                $this->_title->AdvancedSearch->SearchValue = HtmlDecode($this->_title->AdvancedSearch->SearchValue);
            }
            $this->_title->EditValue = HtmlEncode($this->_title->AdvancedSearch->SearchValue);
            $this->_title->PlaceHolder = RemoveHtml($this->_title->caption());

            // brand_id
            $this->brand_id->setupEditAttributes();
            $this->brand_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->brand_id->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->brand_id->AdvancedSearch->ViewValue = $this->brand_id->lookupCacheOption($curVal);
            } else {
                $this->brand_id->AdvancedSearch->ViewValue = $this->brand_id->Lookup !== null && is_array($this->brand_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->brand_id->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->brand_id->EditValue = array_values($this->brand_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`brand_id`" . SearchString("=", $this->brand_id->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
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
                $this->asset_code->AdvancedSearch->SearchValue = HtmlDecode($this->asset_code->AdvancedSearch->SearchValue);
            }
            $this->asset_code->EditValue = HtmlEncode($this->asset_code->AdvancedSearch->SearchValue);
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
            $this->price_mark->EditValue = HtmlEncode($this->price_mark->AdvancedSearch->SearchValue);
            $this->price_mark->PlaceHolder = RemoveHtml($this->price_mark->caption());

            // usable_area
            $this->usable_area->setupEditAttributes();
            $this->usable_area->EditCustomAttributes = "";
            if (!$this->usable_area->Raw) {
                $this->usable_area->AdvancedSearch->SearchValue = HtmlDecode($this->usable_area->AdvancedSearch->SearchValue);
            }
            $this->usable_area->EditValue = HtmlEncode($this->usable_area->AdvancedSearch->SearchValue);
            $this->usable_area->PlaceHolder = RemoveHtml($this->usable_area->caption());

            // land_size
            $this->land_size->setupEditAttributes();
            $this->land_size->EditCustomAttributes = "";
            if (!$this->land_size->Raw) {
                $this->land_size->AdvancedSearch->SearchValue = HtmlDecode($this->land_size->AdvancedSearch->SearchValue);
            }
            $this->land_size->EditValue = HtmlEncode($this->land_size->AdvancedSearch->SearchValue);
            $this->land_size->PlaceHolder = RemoveHtml($this->land_size->caption());

            // count_view
            $this->count_view->setupEditAttributes();
            $this->count_view->EditCustomAttributes = "";
            $this->count_view->EditValue = HtmlEncode($this->count_view->AdvancedSearch->SearchValue);
            $this->count_view->PlaceHolder = RemoveHtml($this->count_view->caption());

            // count_favorite
            $this->count_favorite->setupEditAttributes();
            $this->count_favorite->EditCustomAttributes = "";
            $this->count_favorite->EditValue = HtmlEncode($this->count_favorite->AdvancedSearch->SearchValue);
            $this->count_favorite->PlaceHolder = RemoveHtml($this->count_favorite->caption());

            // expired_date
            $this->expired_date->setupEditAttributes();
            $this->expired_date->EditCustomAttributes = "";
            $this->expired_date->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->expired_date->AdvancedSearch->SearchValue, $this->expired_date->formatPattern()), $this->expired_date->formatPattern()));
            $this->expired_date->PlaceHolder = RemoveHtml($this->expired_date->caption());
            $this->expired_date->setupEditAttributes();
            $this->expired_date->EditCustomAttributes = "";
            $this->expired_date->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->expired_date->AdvancedSearch->SearchValue2, $this->expired_date->formatPattern()), $this->expired_date->formatPattern()));
            $this->expired_date->PlaceHolder = RemoveHtml($this->expired_date->caption());

            // cdate
            $this->cdate->setupEditAttributes();
            $this->cdate->EditCustomAttributes = "";
            $this->cdate->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->cdate->AdvancedSearch->SearchValue, $this->cdate->formatPattern()), $this->cdate->formatPattern()));
            $this->cdate->PlaceHolder = RemoveHtml($this->cdate->caption());
            $this->cdate->setupEditAttributes();
            $this->cdate->EditCustomAttributes = "";
            $this->cdate->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->cdate->AdvancedSearch->SearchValue2, $this->cdate->formatPattern()), $this->cdate->formatPattern()));
            $this->cdate->PlaceHolder = RemoveHtml($this->cdate->caption());
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if (!CheckDate($this->expired_date->AdvancedSearch->SearchValue, $this->expired_date->formatPattern())) {
            $this->expired_date->addErrorMessage($this->expired_date->getErrorMessage(false));
        }
        if (!CheckDate($this->expired_date->AdvancedSearch->SearchValue2, $this->expired_date->formatPattern())) {
            $this->expired_date->addErrorMessage($this->expired_date->getErrorMessage(false));
        }
        if (!CheckDate($this->cdate->AdvancedSearch->SearchValue, $this->cdate->formatPattern())) {
            $this->cdate->addErrorMessage($this->cdate->getErrorMessage(false));
        }
        if (!CheckDate($this->cdate->AdvancedSearch->SearchValue2, $this->cdate->formatPattern())) {
            $this->cdate->addErrorMessage($this->cdate->getErrorMessage(false));
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->_title->AdvancedSearch->load();
        $this->title_en->AdvancedSearch->load();
        $this->brand_id->AdvancedSearch->load();
        $this->detail->AdvancedSearch->load();
        $this->detail_en->AdvancedSearch->load();
        $this->asset_code->AdvancedSearch->load();
        $this->asset_status->AdvancedSearch->load();
        $this->latitude->AdvancedSearch->load();
        $this->longitude->AdvancedSearch->load();
        $this->num_buildings->AdvancedSearch->load();
        $this->num_unit->AdvancedSearch->load();
        $this->num_floors->AdvancedSearch->load();
        $this->floors->AdvancedSearch->load();
        $this->asset_year_developer->AdvancedSearch->load();
        $this->num_parking_spaces->AdvancedSearch->load();
        $this->num_bathrooms->AdvancedSearch->load();
        $this->num_bedrooms->AdvancedSearch->load();
        $this->address->AdvancedSearch->load();
        $this->address_en->AdvancedSearch->load();
        $this->province_id->AdvancedSearch->load();
        $this->amphur_id->AdvancedSearch->load();
        $this->district_id->AdvancedSearch->load();
        $this->postcode->AdvancedSearch->load();
        $this->floor_plan->AdvancedSearch->load();
        $this->layout_unit->AdvancedSearch->load();
        $this->asset_website->AdvancedSearch->load();
        $this->asset_review->AdvancedSearch->load();
        $this->isactive->AdvancedSearch->load();
        $this->is_recommend->AdvancedSearch->load();
        $this->order_by->AdvancedSearch->load();
        $this->type_pay->AdvancedSearch->load();
        $this->type_pay_2->AdvancedSearch->load();
        $this->price_mark->AdvancedSearch->load();
        $this->holding_property->AdvancedSearch->load();
        $this->common_fee->AdvancedSearch->load();
        $this->usable_area->AdvancedSearch->load();
        $this->usable_area_price->AdvancedSearch->load();
        $this->land_size->AdvancedSearch->load();
        $this->land_size_price->AdvancedSearch->load();
        $this->commission->AdvancedSearch->load();
        $this->transfer_day_expenses_with_business_tax->AdvancedSearch->load();
        $this->transfer_day_expenses_without_business_tax->AdvancedSearch->load();
        $this->price->AdvancedSearch->load();
        $this->discount->AdvancedSearch->load();
        $this->price_special->AdvancedSearch->load();
        $this->reservation_price_model_a->AdvancedSearch->load();
        $this->minimum_down_payment_model_a->AdvancedSearch->load();
        $this->down_price_min_a->AdvancedSearch->load();
        $this->down_price_model_a->AdvancedSearch->load();
        $this->factor_monthly_installment_over_down->AdvancedSearch->load();
        $this->fee_a->AdvancedSearch->load();
        $this->monthly_payment_buyer->AdvancedSearch->load();
        $this->annual_interest_buyer_model_a->AdvancedSearch->load();
        $this->monthly_expenses_a->AdvancedSearch->load();
        $this->average_rent_a->AdvancedSearch->load();
        $this->average_down_payment_a->AdvancedSearch->load();
        $this->transfer_day_expenses_without_business_tax_max_min->AdvancedSearch->load();
        $this->transfer_day_expenses_with_business_tax_max_min->AdvancedSearch->load();
        $this->bank_appraisal_price->AdvancedSearch->load();
        $this->mark_up_price->AdvancedSearch->load();
        $this->required_gap->AdvancedSearch->load();
        $this->minimum_down_payment->AdvancedSearch->load();
        $this->price_down_max->AdvancedSearch->load();
        $this->discount_max->AdvancedSearch->load();
        $this->price_down_special_max->AdvancedSearch->load();
        $this->usable_area_price_max->AdvancedSearch->load();
        $this->land_size_price_max->AdvancedSearch->load();
        $this->reservation_price_max->AdvancedSearch->load();
        $this->minimum_down_payment_max->AdvancedSearch->load();
        $this->down_price_max->AdvancedSearch->load();
        $this->down_price->AdvancedSearch->load();
        $this->factor_monthly_installment_over_down_max->AdvancedSearch->load();
        $this->fee_max->AdvancedSearch->load();
        $this->monthly_payment_max->AdvancedSearch->load();
        $this->annual_interest_buyer->AdvancedSearch->load();
        $this->monthly_expense_max->AdvancedSearch->load();
        $this->average_rent_max->AdvancedSearch->load();
        $this->average_down_payment_max->AdvancedSearch->load();
        $this->min_down->AdvancedSearch->load();
        $this->remaining_down->AdvancedSearch->load();
        $this->factor_financing->AdvancedSearch->load();
        $this->credit_limit_down->AdvancedSearch->load();
        $this->price_down_min->AdvancedSearch->load();
        $this->discount_min->AdvancedSearch->load();
        $this->price_down_special_min->AdvancedSearch->load();
        $this->usable_area_price_min->AdvancedSearch->load();
        $this->land_size_price_min->AdvancedSearch->load();
        $this->reservation_price_min->AdvancedSearch->load();
        $this->minimum_down_payment_min->AdvancedSearch->load();
        $this->down_price_min->AdvancedSearch->load();
        $this->remaining_credit_limit_down->AdvancedSearch->load();
        $this->fee_min->AdvancedSearch->load();
        $this->monthly_payment_min->AdvancedSearch->load();
        $this->annual_interest_buyer_model_min->AdvancedSearch->load();
        $this->interest_downpayment_financing->AdvancedSearch->load();
        $this->monthly_expenses_min->AdvancedSearch->load();
        $this->average_rent_min->AdvancedSearch->load();
        $this->average_down_payment_min->AdvancedSearch->load();
        $this->installment_down_payment_loan->AdvancedSearch->load();
        $this->count_view->AdvancedSearch->load();
        $this->count_favorite->AdvancedSearch->load();
        $this->price_invertor->AdvancedSearch->load();
        $this->expired_date->AdvancedSearch->load();
        $this->cdate->AdvancedSearch->load();
        $this->cuser->AdvancedSearch->load();
        $this->cip->AdvancedSearch->load();
        $this->uip->AdvancedSearch->load();
        $this->udate->AdvancedSearch->load();
        $this->uuser->AdvancedSearch->load();
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" form=\"fassetlist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" form=\"fassetlist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" form=\"fassetlist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" form="fassetlist" data-ew-action="email" data-hdr="' . $Language->phrase("ExportToEmailText") . '" data-sel="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fassetsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Search highlight button
        $item = &$this->SearchOptions->add("searchhighlight");
        $item->Body = "<a class=\"btn btn-default ew-highlight active\" role=\"button\" title=\"" . $Language->phrase("Highlight") . "\" data-caption=\"" . $Language->phrase("Highlight") . "\" data-ew-action=\"highlight\" data-form=\"fassetsrch\" data-name=\"" . $this->highlightName() . "\">" . $Language->phrase("HighlightBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != "" && $this->TotalRecords > 0);

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
        return $this->_title->Visible || $this->brand_id->Visible || $this->asset_code->Visible || $this->asset_status->Visible || $this->isactive->Visible || $this->usable_area->Visible || $this->land_size->Visible || $this->expired_date->Visible || $this->cdate->Visible;
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
        if (Config("EXPORT_MASTER_RECORD") && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "sale_asset") {
            $sale_asset = Container("sale_asset");
            $rsmaster = $sale_asset->loadRs($this->DbMasterFilter); // Load master record
            if ($rsmaster) {
                $exportStyle = $doc->Style;
                $doc->setStyle("v"); // Change to vertical
                if (!$this->isExport("csv") || Config("EXPORT_MASTER_RECORD_FOR_CSV")) {
                    $doc->Table = $sale_asset;
                    $sale_asset->exportDocument($doc, new Recordset($rsmaster));
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
            if ($masterTblVar != "sale_asset") {
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
