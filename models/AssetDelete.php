<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class AssetDelete extends Asset
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'asset';

    // Page object name
    public $PageObjName = "AssetDelete";

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
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

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

        // Set up master/detail parameters
        $this->setupMasterParms();

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("assetlist"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->CurrentAction = "show"; // Display record
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("assetlist"); // Return to list
                return;
            }
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

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

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

            // brand_id
            $this->brand_id->LinkCustomAttributes = "";
            $this->brand_id->HrefValue = "";
            $this->brand_id->TooltipValue = "";

            // asset_code
            $this->asset_code->LinkCustomAttributes = "";
            $this->asset_code->HrefValue = "";
            $this->asset_code->TooltipValue = "";

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
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
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
        if ($this->UseTransaction) {
            $conn->beginTransaction();
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
        if ($deleteRows) {
            if ($this->UseTransaction) { // Commit transaction
                $conn->commit();
            }

            // Set warning message if delete some records failed
            if (count($failKeys) > 0) {
                $this->setWarningMessage(str_replace("%k", explode(", ", $failKeys), $Language->phrase("DeleteSomeRecordsFailed")));
            }
            if ($this->AuditTrailOnDelete) {
                $this->writeAuditTrailDummy($Language->phrase("BatchDeleteSuccess")); // Batch delete success
            }
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                $conn->rollback();
            }
            if ($this->AuditTrailOnDelete) {
                $this->writeAuditTrailDummy($Language->phrase("BatchDeleteRollback")); // Batch delete rollback
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("assetlist"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
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
}
