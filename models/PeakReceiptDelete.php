<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class PeakReceiptDelete extends PeakReceipt
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'peak_receipt';

    // Page object name
    public $PageObjName = "PeakReceiptDelete";

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

        // Table object (peak_receipt)
        if (!isset($GLOBALS["peak_receipt"]) || get_class($GLOBALS["peak_receipt"]) == PROJECT_NAMESPACE . "peak_receipt") {
            $GLOBALS["peak_receipt"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'peak_receipt');
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
                $tbl = Container("peak_receipt");
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
        $this->id->setVisibility();
        $this->create_date->setVisibility();
        $this->request_status->setVisibility();
        $this->request_date->setVisibility();
        $this->request_message->Visible = false;
        $this->issueddate->setVisibility();
        $this->duedate->setVisibility();
        $this->contactcode->setVisibility();
        $this->tag->Visible = false;
        $this->istaxinvoice->setVisibility();
        $this->taxstatus->setVisibility();
        $this->paymentdate->setVisibility();
        $this->paymentmethodid->setVisibility();
        $this->paymentMethodCode->setVisibility();
        $this->amount->setVisibility();
        $this->remark->setVisibility();
        $this->receipt_id->setVisibility();
        $this->receipt_code->setVisibility();
        $this->receipt_status->setVisibility();
        $this->preTaxAmount->setVisibility();
        $this->vatAmount->setVisibility();
        $this->netAmount->setVisibility();
        $this->whtAmount->setVisibility();
        $this->paymentAmount->setVisibility();
        $this->remainAmount->setVisibility();
        $this->remainWhtAmount->setVisibility();
        $this->onlineViewLink->Visible = false;
        $this->isPartialReceipt->setVisibility();
        $this->journals_id->setVisibility();
        $this->journals_code->setVisibility();
        $this->refid->setVisibility();
        $this->transition_type->setVisibility();
        $this->is_email->setVisibility();
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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("peakreceiptlist"); // Prevent SQL injection, return to list
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
                $this->terminate("peakreceiptlist"); // Return to list
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
        $this->id->setDbValue($row['id']);
        $this->create_date->setDbValue($row['create_date']);
        $this->request_status->setDbValue($row['request_status']);
        $this->request_date->setDbValue($row['request_date']);
        $this->request_message->setDbValue($row['request_message']);
        $this->issueddate->setDbValue($row['issueddate']);
        $this->duedate->setDbValue($row['duedate']);
        $this->contactcode->setDbValue($row['contactcode']);
        $this->tag->setDbValue($row['tag']);
        $this->istaxinvoice->setDbValue($row['istaxinvoice']);
        $this->taxstatus->setDbValue($row['taxstatus']);
        $this->paymentdate->setDbValue($row['paymentdate']);
        $this->paymentmethodid->setDbValue($row['paymentmethodid']);
        $this->paymentMethodCode->setDbValue($row['paymentMethodCode']);
        $this->amount->setDbValue($row['amount']);
        $this->remark->setDbValue($row['remark']);
        $this->receipt_id->setDbValue($row['receipt_id']);
        $this->receipt_code->setDbValue($row['receipt_code']);
        $this->receipt_status->setDbValue($row['receipt_status']);
        $this->preTaxAmount->setDbValue($row['preTaxAmount']);
        $this->vatAmount->setDbValue($row['vatAmount']);
        $this->netAmount->setDbValue($row['netAmount']);
        $this->whtAmount->setDbValue($row['whtAmount']);
        $this->paymentAmount->setDbValue($row['paymentAmount']);
        $this->remainAmount->setDbValue($row['remainAmount']);
        $this->remainWhtAmount->setDbValue($row['remainWhtAmount']);
        $this->onlineViewLink->setDbValue($row['onlineViewLink']);
        $this->isPartialReceipt->setDbValue($row['isPartialReceipt']);
        $this->journals_id->setDbValue($row['journals_id']);
        $this->journals_code->setDbValue($row['journals_code']);
        $this->refid->setDbValue($row['refid']);
        $this->transition_type->setDbValue($row['transition_type']);
        $this->is_email->setDbValue($row['is_email']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['create_date'] = null;
        $row['request_status'] = null;
        $row['request_date'] = null;
        $row['request_message'] = null;
        $row['issueddate'] = null;
        $row['duedate'] = null;
        $row['contactcode'] = null;
        $row['tag'] = null;
        $row['istaxinvoice'] = null;
        $row['taxstatus'] = null;
        $row['paymentdate'] = null;
        $row['paymentmethodid'] = null;
        $row['paymentMethodCode'] = null;
        $row['amount'] = null;
        $row['remark'] = null;
        $row['receipt_id'] = null;
        $row['receipt_code'] = null;
        $row['receipt_status'] = null;
        $row['preTaxAmount'] = null;
        $row['vatAmount'] = null;
        $row['netAmount'] = null;
        $row['whtAmount'] = null;
        $row['paymentAmount'] = null;
        $row['remainAmount'] = null;
        $row['remainWhtAmount'] = null;
        $row['onlineViewLink'] = null;
        $row['isPartialReceipt'] = null;
        $row['journals_id'] = null;
        $row['journals_code'] = null;
        $row['refid'] = null;
        $row['transition_type'] = null;
        $row['is_email'] = null;
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

        // id

        // create_date

        // request_status

        // request_date

        // request_message

        // issueddate

        // duedate

        // contactcode

        // tag

        // istaxinvoice

        // taxstatus

        // paymentdate

        // paymentmethodid

        // paymentMethodCode

        // amount

        // remark

        // receipt_id

        // receipt_code

        // receipt_status

        // preTaxAmount

        // vatAmount

        // netAmount

        // whtAmount

        // paymentAmount

        // remainAmount

        // remainWhtAmount

        // onlineViewLink

        // isPartialReceipt

        // journals_id

        // journals_code

        // refid

        // transition_type

        // is_email

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // create_date
            $this->create_date->ViewValue = $this->create_date->CurrentValue;
            $this->create_date->ViewValue = FormatDateTime($this->create_date->ViewValue, $this->create_date->formatPattern());
            $this->create_date->ViewCustomAttributes = "";

            // request_status
            $this->request_status->ViewValue = $this->request_status->CurrentValue;
            $this->request_status->ViewValue = FormatNumber($this->request_status->ViewValue, $this->request_status->formatPattern());
            $this->request_status->ViewCustomAttributes = "";

            // request_date
            $this->request_date->ViewValue = $this->request_date->CurrentValue;
            $this->request_date->ViewValue = FormatDateTime($this->request_date->ViewValue, $this->request_date->formatPattern());
            $this->request_date->ViewCustomAttributes = "";

            // issueddate
            $this->issueddate->ViewValue = $this->issueddate->CurrentValue;
            $this->issueddate->ViewValue = FormatDateTime($this->issueddate->ViewValue, $this->issueddate->formatPattern());
            $this->issueddate->ViewCustomAttributes = "";

            // duedate
            $this->duedate->ViewValue = $this->duedate->CurrentValue;
            $this->duedate->ViewValue = FormatDateTime($this->duedate->ViewValue, $this->duedate->formatPattern());
            $this->duedate->ViewCustomAttributes = "";

            // contactcode
            $this->contactcode->ViewValue = $this->contactcode->CurrentValue;
            $this->contactcode->ViewCustomAttributes = "";

            // istaxinvoice
            $this->istaxinvoice->ViewValue = $this->istaxinvoice->CurrentValue;
            $this->istaxinvoice->ViewValue = FormatNumber($this->istaxinvoice->ViewValue, $this->istaxinvoice->formatPattern());
            $this->istaxinvoice->ViewCustomAttributes = "";

            // taxstatus
            $this->taxstatus->ViewValue = $this->taxstatus->CurrentValue;
            $this->taxstatus->ViewValue = FormatNumber($this->taxstatus->ViewValue, $this->taxstatus->formatPattern());
            $this->taxstatus->ViewCustomAttributes = "";

            // paymentdate
            $this->paymentdate->ViewValue = $this->paymentdate->CurrentValue;
            $this->paymentdate->ViewValue = FormatDateTime($this->paymentdate->ViewValue, $this->paymentdate->formatPattern());
            $this->paymentdate->ViewCustomAttributes = "";

            // paymentmethodid
            $this->paymentmethodid->ViewValue = $this->paymentmethodid->CurrentValue;
            $this->paymentmethodid->ViewCustomAttributes = "";

            // paymentMethodCode
            $this->paymentMethodCode->ViewValue = $this->paymentMethodCode->CurrentValue;
            $this->paymentMethodCode->ViewCustomAttributes = "";

            // amount
            $this->amount->ViewValue = $this->amount->CurrentValue;
            $this->amount->ViewValue = FormatNumber($this->amount->ViewValue, $this->amount->formatPattern());
            $this->amount->ViewCustomAttributes = "";

            // remark
            $this->remark->ViewValue = $this->remark->CurrentValue;
            $this->remark->ViewCustomAttributes = "";

            // receipt_id
            $this->receipt_id->ViewValue = $this->receipt_id->CurrentValue;
            $this->receipt_id->ViewCustomAttributes = "";

            // receipt_code
            $this->receipt_code->ViewValue = $this->receipt_code->CurrentValue;
            $this->receipt_code->ViewCustomAttributes = "";

            // receipt_status
            $this->receipt_status->ViewValue = $this->receipt_status->CurrentValue;
            $this->receipt_status->ViewCustomAttributes = "";

            // preTaxAmount
            $this->preTaxAmount->ViewValue = $this->preTaxAmount->CurrentValue;
            $this->preTaxAmount->ViewValue = FormatNumber($this->preTaxAmount->ViewValue, $this->preTaxAmount->formatPattern());
            $this->preTaxAmount->ViewCustomAttributes = "";

            // vatAmount
            $this->vatAmount->ViewValue = $this->vatAmount->CurrentValue;
            $this->vatAmount->ViewValue = FormatNumber($this->vatAmount->ViewValue, $this->vatAmount->formatPattern());
            $this->vatAmount->ViewCustomAttributes = "";

            // netAmount
            $this->netAmount->ViewValue = $this->netAmount->CurrentValue;
            $this->netAmount->ViewValue = FormatNumber($this->netAmount->ViewValue, $this->netAmount->formatPattern());
            $this->netAmount->ViewCustomAttributes = "";

            // whtAmount
            $this->whtAmount->ViewValue = $this->whtAmount->CurrentValue;
            $this->whtAmount->ViewValue = FormatNumber($this->whtAmount->ViewValue, $this->whtAmount->formatPattern());
            $this->whtAmount->ViewCustomAttributes = "";

            // paymentAmount
            $this->paymentAmount->ViewValue = $this->paymentAmount->CurrentValue;
            $this->paymentAmount->ViewValue = FormatNumber($this->paymentAmount->ViewValue, $this->paymentAmount->formatPattern());
            $this->paymentAmount->ViewCustomAttributes = "";

            // remainAmount
            $this->remainAmount->ViewValue = $this->remainAmount->CurrentValue;
            $this->remainAmount->ViewValue = FormatNumber($this->remainAmount->ViewValue, $this->remainAmount->formatPattern());
            $this->remainAmount->ViewCustomAttributes = "";

            // remainWhtAmount
            $this->remainWhtAmount->ViewValue = $this->remainWhtAmount->CurrentValue;
            $this->remainWhtAmount->ViewValue = FormatNumber($this->remainWhtAmount->ViewValue, $this->remainWhtAmount->formatPattern());
            $this->remainWhtAmount->ViewCustomAttributes = "";

            // isPartialReceipt
            $this->isPartialReceipt->ViewValue = $this->isPartialReceipt->CurrentValue;
            $this->isPartialReceipt->ViewValue = FormatNumber($this->isPartialReceipt->ViewValue, $this->isPartialReceipt->formatPattern());
            $this->isPartialReceipt->ViewCustomAttributes = "";

            // journals_id
            $this->journals_id->ViewValue = $this->journals_id->CurrentValue;
            $this->journals_id->ViewCustomAttributes = "";

            // journals_code
            $this->journals_code->ViewValue = $this->journals_code->CurrentValue;
            $this->journals_code->ViewCustomAttributes = "";

            // refid
            $this->refid->ViewValue = $this->refid->CurrentValue;
            $this->refid->ViewValue = FormatNumber($this->refid->ViewValue, $this->refid->formatPattern());
            $this->refid->ViewCustomAttributes = "";

            // transition_type
            $this->transition_type->ViewValue = $this->transition_type->CurrentValue;
            $this->transition_type->ViewValue = FormatNumber($this->transition_type->ViewValue, $this->transition_type->formatPattern());
            $this->transition_type->ViewCustomAttributes = "";

            // is_email
            $this->is_email->ViewValue = $this->is_email->CurrentValue;
            $this->is_email->ViewValue = FormatNumber($this->is_email->ViewValue, $this->is_email->formatPattern());
            $this->is_email->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // create_date
            $this->create_date->LinkCustomAttributes = "";
            $this->create_date->HrefValue = "";
            $this->create_date->TooltipValue = "";

            // request_status
            $this->request_status->LinkCustomAttributes = "";
            $this->request_status->HrefValue = "";
            $this->request_status->TooltipValue = "";

            // request_date
            $this->request_date->LinkCustomAttributes = "";
            $this->request_date->HrefValue = "";
            $this->request_date->TooltipValue = "";

            // issueddate
            $this->issueddate->LinkCustomAttributes = "";
            $this->issueddate->HrefValue = "";
            $this->issueddate->TooltipValue = "";

            // duedate
            $this->duedate->LinkCustomAttributes = "";
            $this->duedate->HrefValue = "";
            $this->duedate->TooltipValue = "";

            // contactcode
            $this->contactcode->LinkCustomAttributes = "";
            $this->contactcode->HrefValue = "";
            $this->contactcode->TooltipValue = "";

            // istaxinvoice
            $this->istaxinvoice->LinkCustomAttributes = "";
            $this->istaxinvoice->HrefValue = "";
            $this->istaxinvoice->TooltipValue = "";

            // taxstatus
            $this->taxstatus->LinkCustomAttributes = "";
            $this->taxstatus->HrefValue = "";
            $this->taxstatus->TooltipValue = "";

            // paymentdate
            $this->paymentdate->LinkCustomAttributes = "";
            $this->paymentdate->HrefValue = "";
            $this->paymentdate->TooltipValue = "";

            // paymentmethodid
            $this->paymentmethodid->LinkCustomAttributes = "";
            $this->paymentmethodid->HrefValue = "";
            $this->paymentmethodid->TooltipValue = "";

            // paymentMethodCode
            $this->paymentMethodCode->LinkCustomAttributes = "";
            $this->paymentMethodCode->HrefValue = "";
            $this->paymentMethodCode->TooltipValue = "";

            // amount
            $this->amount->LinkCustomAttributes = "";
            $this->amount->HrefValue = "";
            $this->amount->TooltipValue = "";

            // remark
            $this->remark->LinkCustomAttributes = "";
            $this->remark->HrefValue = "";
            $this->remark->TooltipValue = "";

            // receipt_id
            $this->receipt_id->LinkCustomAttributes = "";
            $this->receipt_id->HrefValue = "";
            $this->receipt_id->TooltipValue = "";

            // receipt_code
            $this->receipt_code->LinkCustomAttributes = "";
            $this->receipt_code->HrefValue = "";
            $this->receipt_code->TooltipValue = "";

            // receipt_status
            $this->receipt_status->LinkCustomAttributes = "";
            $this->receipt_status->HrefValue = "";
            $this->receipt_status->TooltipValue = "";

            // preTaxAmount
            $this->preTaxAmount->LinkCustomAttributes = "";
            $this->preTaxAmount->HrefValue = "";
            $this->preTaxAmount->TooltipValue = "";

            // vatAmount
            $this->vatAmount->LinkCustomAttributes = "";
            $this->vatAmount->HrefValue = "";
            $this->vatAmount->TooltipValue = "";

            // netAmount
            $this->netAmount->LinkCustomAttributes = "";
            $this->netAmount->HrefValue = "";
            $this->netAmount->TooltipValue = "";

            // whtAmount
            $this->whtAmount->LinkCustomAttributes = "";
            $this->whtAmount->HrefValue = "";
            $this->whtAmount->TooltipValue = "";

            // paymentAmount
            $this->paymentAmount->LinkCustomAttributes = "";
            $this->paymentAmount->HrefValue = "";
            $this->paymentAmount->TooltipValue = "";

            // remainAmount
            $this->remainAmount->LinkCustomAttributes = "";
            $this->remainAmount->HrefValue = "";
            $this->remainAmount->TooltipValue = "";

            // remainWhtAmount
            $this->remainWhtAmount->LinkCustomAttributes = "";
            $this->remainWhtAmount->HrefValue = "";
            $this->remainWhtAmount->TooltipValue = "";

            // isPartialReceipt
            $this->isPartialReceipt->LinkCustomAttributes = "";
            $this->isPartialReceipt->HrefValue = "";
            $this->isPartialReceipt->TooltipValue = "";

            // journals_id
            $this->journals_id->LinkCustomAttributes = "";
            $this->journals_id->HrefValue = "";
            $this->journals_id->TooltipValue = "";

            // journals_code
            $this->journals_code->LinkCustomAttributes = "";
            $this->journals_code->HrefValue = "";
            $this->journals_code->TooltipValue = "";

            // refid
            $this->refid->LinkCustomAttributes = "";
            $this->refid->HrefValue = "";
            $this->refid->TooltipValue = "";

            // transition_type
            $this->transition_type->LinkCustomAttributes = "";
            $this->transition_type->HrefValue = "";
            $this->transition_type->TooltipValue = "";

            // is_email
            $this->is_email->LinkCustomAttributes = "";
            $this->is_email->HrefValue = "";
            $this->is_email->TooltipValue = "";
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

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['id'];

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
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                $conn->rollback();
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("peakreceiptlist"), "", $this->TableVar, true);
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
