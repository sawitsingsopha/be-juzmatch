<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class DocJuzmatch1Preview extends DocJuzmatch1
{
    use MessagesTrait;

    // Page ID
    public $PageID = "preview";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'doc_juzmatch1';

    // Page object name
    public $PageObjName = "DocJuzmatch1Preview";

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

        // Table object (doc_juzmatch1)
        if (!isset($GLOBALS["doc_juzmatch1"]) || get_class($GLOBALS["doc_juzmatch1"]) == PROJECT_NAMESPACE . "doc_juzmatch1") {
            $GLOBALS["doc_juzmatch1"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'doc_juzmatch1');
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
                $tbl = Container("doc_juzmatch1");
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
		        $this->file_idcard->OldUploadPath = "/upload/";
		        $this->file_idcard->UploadPath = $this->file_idcard->OldUploadPath;
		        $this->file_house_regis->OldUploadPath = "/upload/";
		        $this->file_house_regis->UploadPath = $this->file_house_regis->OldUploadPath;
		        $this->file_titledeed->OldUploadPath = "/upload/";
		        $this->file_titledeed->UploadPath = $this->file_titledeed->OldUploadPath;
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
        $this->id->Visible = false;
        $this->document_date->setVisibility();
        $this->asset_code->setVisibility();
        $this->asset_deed->setVisibility();
        $this->asset_project->setVisibility();
        $this->asset_area->setVisibility();
        $this->buyer_name->Visible = false;
        $this->buyer_lname->setVisibility();
        $this->buyer_email->setVisibility();
        $this->buyer_idcard->setVisibility();
        $this->buyer_homeno->setVisibility();
        $this->buyer_witness_name->Visible = false;
        $this->buyer_witness_lname->setVisibility();
        $this->buyer_witness_email->setVisibility();
        $this->juzmatch_authority_name->Visible = false;
        $this->juzmatch_authority_lname->setVisibility();
        $this->juzmatch_authority_email->setVisibility();
        $this->juzmatch_authority_witness_name->Visible = false;
        $this->juzmatch_authority_witness_lname->setVisibility();
        $this->juzmatch_authority_witness_email->setVisibility();
        $this->juzmatch_authority2_name->setVisibility();
        $this->juzmatch_authority2_lname->setVisibility();
        $this->juzmatch_authority2_email->setVisibility();
        $this->company_seal_name->setVisibility();
        $this->company_seal_email->setVisibility();
        $this->service_price->setVisibility();
        $this->service_price_txt->setVisibility();
        $this->first_down->setVisibility();
        $this->first_down_txt->setVisibility();
        $this->second_down->setVisibility();
        $this->second_down_txt->setVisibility();
        $this->contact_address->setVisibility();
        $this->contact_address2->setVisibility();
        $this->contact_email->setVisibility();
        $this->contact_lineid->setVisibility();
        $this->contact_phone->setVisibility();
        $this->file_idcard->Visible = false;
        $this->file_house_regis->Visible = false;
        $this->file_titledeed->Visible = false;
        $this->file_other->Visible = false;
        $this->attach_file->Visible = false;
        $this->status->Visible = false;
        $this->doc_date->Visible = false;
        $this->buyer_booking_asset_id->Visible = false;
        $this->doc_creden_id->Visible = false;
        $this->cdate->setVisibility();
        $this->cuser->Visible = false;
        $this->cip->Visible = false;
        $this->udate->Visible = false;
        $this->uuser->Visible = false;
        $this->uip->Visible = false;
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
        $this->setupLookupOptions($this->status);

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
            $this->id->setSort("");
            $this->document_date->setSort("");
            $this->asset_code->setSort("");
            $this->asset_deed->setSort("");
            $this->asset_project->setSort("");
            $this->asset_area->setSort("");
            $this->buyer_name->setSort("");
            $this->buyer_lname->setSort("");
            $this->buyer_email->setSort("");
            $this->buyer_idcard->setSort("");
            $this->buyer_homeno->setSort("");
            $this->buyer_witness_name->setSort("");
            $this->buyer_witness_lname->setSort("");
            $this->buyer_witness_email->setSort("");
            $this->juzmatch_authority_name->setSort("");
            $this->juzmatch_authority_lname->setSort("");
            $this->juzmatch_authority_email->setSort("");
            $this->juzmatch_authority_witness_name->setSort("");
            $this->juzmatch_authority_witness_lname->setSort("");
            $this->juzmatch_authority_witness_email->setSort("");
            $this->juzmatch_authority2_name->setSort("");
            $this->juzmatch_authority2_lname->setSort("");
            $this->juzmatch_authority2_email->setSort("");
            $this->company_seal_name->setSort("");
            $this->company_seal_email->setSort("");
            $this->service_price->setSort("");
            $this->service_price_txt->setSort("");
            $this->first_down->setSort("");
            $this->first_down_txt->setSort("");
            $this->second_down->setSort("");
            $this->second_down_txt->setSort("");
            $this->contact_address->setSort("");
            $this->contact_address2->setSort("");
            $this->contact_email->setSort("");
            $this->contact_lineid->setSort("");
            $this->contact_phone->setSort("");
            $this->file_idcard->setSort("");
            $this->file_house_regis->setSort("");
            $this->file_titledeed->setSort("");
            $this->file_other->setSort("");
            $this->attach_file->setSort("");
            $this->status->setSort("");
            $this->doc_date->setSort("");
            $this->buyer_booking_asset_id->setSort("");
            $this->doc_creden_id->setSort("");
            $this->cdate->setSort("");
            $this->cuser->setSort("");
            $this->cip->setSort("");
            $this->udate->setSort("");
            $this->uuser->setSort("");
            $this->uip->setSort("");

            // Save sort to session
            $this->setSessionOrderBy("");
        } else {
            $this->StartRecord = (int)Get("start") ?: 1;
            $this->CurrentOrder = Get("sort", "");
            $this->CurrentOrderType = Get("sortorder", "");
        }

        // Check for sort field
        if ($this->CurrentOrder !== "") {
            $this->updateSort($this->document_date, $ctrl); // document_date
            $this->updateSort($this->asset_code, $ctrl); // asset_code
            $this->updateSort($this->asset_deed, $ctrl); // asset_deed
            $this->updateSort($this->asset_project, $ctrl); // asset_project
            $this->updateSort($this->asset_area, $ctrl); // asset_area
            $this->updateSort($this->buyer_lname, $ctrl); // buyer_lname
            $this->updateSort($this->buyer_email, $ctrl); // buyer_email
            $this->updateSort($this->buyer_idcard, $ctrl); // buyer_idcard
            $this->updateSort($this->buyer_homeno, $ctrl); // buyer_homeno
            $this->updateSort($this->buyer_witness_lname, $ctrl); // buyer_witness_lname
            $this->updateSort($this->buyer_witness_email, $ctrl); // buyer_witness_email
            $this->updateSort($this->juzmatch_authority_lname, $ctrl); // juzmatch_authority_lname
            $this->updateSort($this->juzmatch_authority_email, $ctrl); // juzmatch_authority_email
            $this->updateSort($this->juzmatch_authority_witness_lname, $ctrl); // juzmatch_authority_witness_lname
            $this->updateSort($this->juzmatch_authority_witness_email, $ctrl); // juzmatch_authority_witness_email
            $this->updateSort($this->juzmatch_authority2_name, $ctrl); // juzmatch_authority2_name
            $this->updateSort($this->juzmatch_authority2_lname, $ctrl); // juzmatch_authority2_lname
            $this->updateSort($this->juzmatch_authority2_email, $ctrl); // juzmatch_authority2_email
            $this->updateSort($this->company_seal_name, $ctrl); // company_seal_name
            $this->updateSort($this->company_seal_email, $ctrl); // company_seal_email
            $this->updateSort($this->service_price, $ctrl); // service_price
            $this->updateSort($this->service_price_txt, $ctrl); // service_price_txt
            $this->updateSort($this->first_down, $ctrl); // first_down
            $this->updateSort($this->first_down_txt, $ctrl); // first_down_txt
            $this->updateSort($this->second_down, $ctrl); // second_down
            $this->updateSort($this->second_down_txt, $ctrl); // second_down_txt
            $this->updateSort($this->contact_address, $ctrl); // contact_address
            $this->updateSort($this->contact_address2, $ctrl); // contact_address2
            $this->updateSort($this->contact_email, $ctrl); // contact_email
            $this->updateSort($this->contact_lineid, $ctrl); // contact_lineid
            $this->updateSort($this->contact_phone, $ctrl); // contact_phone
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
            $sort = "";
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
        if ($masterTblVar == "buyer_all_booking_asset") {
            $url = "" . Config("TABLE_SHOW_MASTER") . "=buyer_all_booking_asset&" . GetForeignKeyUrl("fk_buyer_booking_asset_id", $this->buyer_booking_asset_id->QueryStringValue) . "";
        }
        return $url;
    }

    // Set up foreign keys from filter
    protected function setupForeignKeysFromFilter($f)
    {
        $masterTblVar = Get("t", "");
        if ($masterTblVar == "buyer_all_booking_asset") {
            $find = "`buyer_booking_asset_id`=";
            $x = strpos($f, $find);
            if ($x !== false) {
                $x += strlen($find);
                $val = substr($f, $x);
                $val = $this->unquoteValue($val, "DB");
                $this->buyer_booking_asset_id->setQueryStringValue($val);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("docjuzmatch1list"), "", $this->TableVar, true);
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
