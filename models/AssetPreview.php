<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class AssetPreview extends Asset
{
    use MessagesTrait;

    // Page ID
    public $PageID = "preview";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'asset';

    // Page object name
    public $PageObjName = "AssetPreview";

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
    public $Recordset;
    public $TotalRecords;
    public $RowCount;
    public $RecCount;
    public $ListOptions; // List options
    public $OtherOptions; // Other options
    public $StartRecord = 1;
    public $DisplayRecords = 0;
    public $UseModalLinks = false;
    public $IsModal = true;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Update last accessed time
        if (!IsSysAdmin() && !$UserProfile->isValidUser(CurrentUserName(), session_id())) {
            Write($Language->phrase("UserProfileCorrupted"));
            $this->terminate();
            return;
        }
        $this->CurrentAction = Param("action"); // Set up current action

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

        // Load filter
        $filter = Get("f", "");
        $filter = Decrypt($filter);
        if ($filter == "") {
            $filter = "0=1";
        }

        // Set up Sort Order
        $this->setupSortOrder();

        // Set up foreign keys from filter
        $this->setupForeignKeysFromFilter($filter);

        // Call Recordset Selecting event
        $this->recordsetSelecting($filter);

        // Load recordset
        $filter = $this->applyUserIDFilters($filter);
        $this->TotalRecords = $this->loadRecordCount($filter);
        if ($this->DisplayRecords <= 0) { // Show all records if page size not specified
            $this->DisplayRecords = $this->TotalRecords > 0 ? $this->TotalRecords : 10;
        }
        $sql = $this->previewSql($filter);
        if ($this->DisplayRecords > 0) {
            $sql->setFirstResult($this->StartRecord - 1)->setMaxResults($this->DisplayRecords);
        }
        $result = $sql->execute();
        $this->Recordset = new Recordset($result, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($this->Recordset);
        $this->renderOtherOptions();

        // Set up pager (always use PrevNextPager for preview page)
        $this->Pager = new PrevNextPager($this->TableVar, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, "", 10, $this->AutoHidePager, null, null, true);

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

    /**
     * Set up sort order
     *
     */
    protected function setupSortOrder()
    {
        // Check for Ctrl pressed
        $ctrl = Get("ctrl") !== null;
        if (SameText(Get("cmd"), "resetsort")) {
            $this->StartRecord = 1;
            $this->CurrentOrder = "";
            $this->CurrentOrderType = "";
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

            // Save sort to session
            $this->setSessionOrderBy("");
        } else {
            $this->StartRecord = (int)Get("start") ?: 1;
            $this->CurrentOrder = Get("sort", "");
            $this->CurrentOrderType = Get("sortorder", "");
        }

        // Check for sort field
        if ($this->CurrentOrder !== "") {
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
        }
    }

    /**
     * Get preview SQL
     *
     * @param string $filter
     * @return QueryBuilder
     */
    protected function previewSql($filter)
    {
        $sort = $this->getSessionOrderBy();
        if (!$sort) {
            $sort = "`cdate` DESC";
        }
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // Add group option item
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

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();
        $masterKeyUrl = $this->masterKeyUrl();

        // "view"
        $opt = $this->ListOptions["view"];
        if ($Security->canView()) {
            $viewCaption = $Language->phrase("ViewLink");
            $viewTitle = HtmlTitle($viewCaption);
            $viewUrl = $this->getViewUrl($masterKeyUrl);
            if ($this->UseModalLinks && !IsMobile()) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewTitle . "\" data-caption=\"" . $viewTitle . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode($viewUrl) . "\" data-btn=\"null\">" . $viewCaption . "</a>";
            } else {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewTitle . "\" data-caption=\"" . $viewTitle . "\" href=\"" . HtmlEncode($viewUrl) . "\">" . $viewCaption . "</a>";
            }
        } else {
            $opt->Body = "";
        }

        // "edit"
        $opt = $this->ListOptions["edit"];
        if ($Security->canEdit()) {
            $editCaption = $Language->phrase("EditLink");
            $editTitle = HtmlTitle($editCaption);
            $editUrl = $this->getEditUrl($masterKeyUrl);
            if ($this->UseModalLinks && !IsMobile()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editTitle . "\" data-caption=\"" . $editTitle . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode($editUrl) . "\" data-btn=\"SaveBtn\">" . $editCaption . "</a>";
            } else {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editTitle . "\" data-caption=\"" . $editTitle . "\" href=\"" . HtmlEncode($editUrl) . "\">" . $editCaption . "</a>";
            }
        } else {
            $opt->Body = "";
        }

        // "delete"
        $opt = $this->ListOptions["delete"];
        if ($Security->canDelete()) {
            $deleteCaption = $Language->phrase("DeleteLink");
            $deleteTitle = HtmlTitle($deleteCaption);
            $deleteUrl = $this->getDeleteUrl();
            if ($this->UseModalLinks && !IsMobile()) {
                $deleteUrl .= (ContainsString($deleteUrl, "?") ? "&" : "?") . "action=1";
                $opt->Body = "<a class=\"ew-row-link ew-delete\" data-ew-action=\"inline-delete\" title=\"" . $deleteTitle . "\" data-caption=\"" . $deleteTitle . "\" href=\"" . HtmlEncode($deleteUrl) . "\">" . $deleteCaption . "</a>";
            } else {
                $opt->Body = "<a class=\"ew-row-link ew-delete\" data-ew-action=\"\" title=\"" . $deleteTitle . "\" data-caption=\"" . $deleteTitle . "\" href=\"" . HtmlEncode($deleteUrl) . "\">" . $deleteCaption . "</a>";
            }
        } else {
            $opt->Body = "";
        }

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];
        $option->UseButtonGroup = false;

        // Add group option item
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->OnLeft = false;
        $item->Visible = false;

        // Add
        $item = &$option->add("add");
        $item->Visible = $Security->canAdd();
    }

    // Render other options
    protected function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = $option["add"];
        if ($Security->canAdd()) {
            $addCaption = $Language->phrase("AddLink");
            $addTitle = HtmlTitle($addCaption);
            $addUrl = $this->getAddUrl($this->masterKeyUrl());
            if ($this->UseModalLinks && !IsMobile()) {
                $item->Body = "<a class=\"btn btn-default btn-sm ew-add-edit ew-add\" title=\"" . $addTitle . "\" data-caption=\"" . $addTitle . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode($addUrl) . "\" data-btn=\"AddBtn\">" . $addCaption . "</a>";
            } else {
                $item->Body = "<a class=\"btn btn-default btn-sm ew-add-edit ew-add\" title=\"" . $addTitle . "\" data-caption=\"" . $addTitle . "\" href=\"" . HtmlEncode($addUrl) . "\">" . $addCaption . "</a>";
            }
        } else {
            $item->Body = "";
        }
    }

    // Get master foreign key url
    protected function masterKeyUrl()
    {
        $masterTblVar = Get("t", "");
        $url = "";
        if ($masterTblVar == "sale_asset") {
            $url = "" . Config("TABLE_SHOW_MASTER") . "=sale_asset&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->QueryStringValue) . "";
        }
        return $url;
    }

    // Set up foreign keys from filter
    protected function setupForeignKeysFromFilter($f)
    {
        $masterTblVar = Get("t", "");
        if ($masterTblVar == "sale_asset") {
            $find = "`asset_id`=";
            $x = strpos($f, $find);
            if ($x !== false) {
                $x += strlen($find);
                $val = substr($f, $x);
                $val = $this->unquoteValue($val, "DB");
                $this->asset_id->setQueryStringValue($val);
            }
        }
    }

    // Unquote value
    protected function unquoteValue($val, $dbid)
    {
        if (StartsString("'", $val) && EndsString("'", $val)) {
            if (GetConnectionType($dbid) == "MYSQL") {
                return stripslashes(substr($val, 1, strlen($val) - 2));
            } else {
                return str_replace("''", "'", substr($val, 1, strlen($val) - 2));
            }
        }
        return $val;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("assetlist"), "", $this->TableVar, true);
        $pageId = "preview";
        $Breadcrumb->add("preview", $pageId, $url);
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
