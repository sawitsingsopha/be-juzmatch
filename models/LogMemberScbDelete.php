<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class LogMemberScbDelete extends LogMemberScb
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'log_member_scb';

    // Page object name
    public $PageObjName = "LogMemberScbDelete";

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

        // Table object (log_member_scb)
        if (!isset($GLOBALS["log_member_scb"]) || get_class($GLOBALS["log_member_scb"]) == PROJECT_NAMESPACE . "log_member_scb") {
            $GLOBALS["log_member_scb"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'log_member_scb');
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
                $tbl = Container("log_member_scb");
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
            $key .= @$ar['log_member_scb_id'];
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
            $this->log_member_scb_id->Visible = false;
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
        $this->log_member_scb_id->setVisibility();
        $this->reference_id->setVisibility();
        $this->reference_url->Visible = false;
        $this->member_id->setVisibility();
        $this->refreshtoken->Visible = false;
        $this->auth_code->Visible = false;
        $this->_token->Visible = false;
        $this->state->Visible = false;
        $this->cdate->setVisibility();
        $this->cuser->setVisibility();
        $this->cip->setVisibility();
        $this->status->setVisibility();
        $this->at_expire_in->Visible = false;
        $this->rt_expire_in->Visible = false;
        $this->asset_id->setVisibility();
        $this->decision_status->setVisibility();
        $this->decision_timestamp->setVisibility();
        $this->deposit_amount->setVisibility();
        $this->due_date->setVisibility();
        $this->rental_fee->setVisibility();
        $this->fullName->setVisibility();
        $this->age->setVisibility();
        $this->maritalStatus->setVisibility();
        $this->noOfChildren->setVisibility();
        $this->educationLevel->setVisibility();
        $this->workplace->setVisibility();
        $this->occupation->setVisibility();
        $this->jobPosition->setVisibility();
        $this->submissionDate->setVisibility();
        $this->bankruptcy_tendency->setVisibility();
        $this->blacklist_tendency->setVisibility();
        $this->money_laundering_tendency->setVisibility();
        $this->mobile_fraud_behavior->setVisibility();
        $this->face_similarity_score->setVisibility();
        $this->identification_verification_matched_flag->setVisibility();
        $this->bankstatement_confident_score->setVisibility();
        $this->estimated_monthly_income->setVisibility();
        $this->estimated_monthly_debt->setVisibility();
        $this->income_stability->setVisibility();
        $this->customer_grade->setVisibility();
        $this->color_sign->setVisibility();
        $this->rental_period->setVisibility();
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
            $this->terminate("logmemberscblist"); // Prevent SQL injection, return to list
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
                $this->terminate("logmemberscblist"); // Return to list
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
        $this->log_member_scb_id->setDbValue($row['log_member_scb_id']);
        $this->reference_id->setDbValue($row['reference_id']);
        $this->reference_url->setDbValue($row['reference_url']);
        $this->member_id->setDbValue($row['member_id']);
        $this->refreshtoken->setDbValue($row['refreshtoken']);
        $this->auth_code->setDbValue($row['auth_code']);
        $this->_token->setDbValue($row['token']);
        $this->state->setDbValue($row['state']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->status->setDbValue($row['status']);
        $this->at_expire_in->setDbValue($row['at_expire_in']);
        $this->rt_expire_in->setDbValue($row['rt_expire_in']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->decision_status->setDbValue($row['decision_status']);
        $this->decision_timestamp->setDbValue($row['decision_timestamp']);
        $this->deposit_amount->setDbValue($row['deposit_amount']);
        $this->due_date->setDbValue($row['due_date']);
        $this->rental_fee->setDbValue($row['rental_fee']);
        $this->fullName->setDbValue($row['fullName']);
        $this->age->setDbValue($row['age']);
        $this->maritalStatus->setDbValue($row['maritalStatus']);
        $this->noOfChildren->setDbValue($row['noOfChildren']);
        $this->educationLevel->setDbValue($row['educationLevel']);
        $this->workplace->setDbValue($row['workplace']);
        $this->occupation->setDbValue($row['occupation']);
        $this->jobPosition->setDbValue($row['jobPosition']);
        $this->submissionDate->setDbValue($row['submissionDate']);
        $this->bankruptcy_tendency->setDbValue($row['bankruptcy_tendency']);
        $this->blacklist_tendency->setDbValue($row['blacklist_tendency']);
        $this->money_laundering_tendency->setDbValue($row['money_laundering_tendency']);
        $this->mobile_fraud_behavior->setDbValue($row['mobile_fraud_behavior']);
        $this->face_similarity_score->setDbValue($row['face_similarity_score']);
        $this->identification_verification_matched_flag->setDbValue($row['identification_verification_matched_flag']);
        $this->bankstatement_confident_score->setDbValue($row['bankstatement_confident_score']);
        $this->estimated_monthly_income->setDbValue($row['estimated_monthly_income']);
        $this->estimated_monthly_debt->setDbValue($row['estimated_monthly_debt']);
        $this->income_stability->setDbValue($row['income_stability']);
        $this->customer_grade->setDbValue($row['customer_grade']);
        $this->color_sign->setDbValue($row['color_sign']);
        $this->rental_period->setDbValue($row['rental_period']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['log_member_scb_id'] = null;
        $row['reference_id'] = null;
        $row['reference_url'] = null;
        $row['member_id'] = null;
        $row['refreshtoken'] = null;
        $row['auth_code'] = null;
        $row['token'] = null;
        $row['state'] = null;
        $row['cdate'] = null;
        $row['cuser'] = null;
        $row['cip'] = null;
        $row['status'] = null;
        $row['at_expire_in'] = null;
        $row['rt_expire_in'] = null;
        $row['asset_id'] = null;
        $row['decision_status'] = null;
        $row['decision_timestamp'] = null;
        $row['deposit_amount'] = null;
        $row['due_date'] = null;
        $row['rental_fee'] = null;
        $row['fullName'] = null;
        $row['age'] = null;
        $row['maritalStatus'] = null;
        $row['noOfChildren'] = null;
        $row['educationLevel'] = null;
        $row['workplace'] = null;
        $row['occupation'] = null;
        $row['jobPosition'] = null;
        $row['submissionDate'] = null;
        $row['bankruptcy_tendency'] = null;
        $row['blacklist_tendency'] = null;
        $row['money_laundering_tendency'] = null;
        $row['mobile_fraud_behavior'] = null;
        $row['face_similarity_score'] = null;
        $row['identification_verification_matched_flag'] = null;
        $row['bankstatement_confident_score'] = null;
        $row['estimated_monthly_income'] = null;
        $row['estimated_monthly_debt'] = null;
        $row['income_stability'] = null;
        $row['customer_grade'] = null;
        $row['color_sign'] = null;
        $row['rental_period'] = null;
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

        // log_member_scb_id

        // reference_id

        // reference_url

        // member_id

        // refreshtoken

        // auth_code

        // token

        // state

        // cdate

        // cuser

        // cip

        // status

        // at_expire_in

        // rt_expire_in

        // asset_id

        // decision_status

        // decision_timestamp

        // deposit_amount

        // due_date

        // rental_fee

        // fullName

        // age

        // maritalStatus

        // noOfChildren

        // educationLevel

        // workplace

        // occupation

        // jobPosition

        // submissionDate

        // bankruptcy_tendency

        // blacklist_tendency

        // money_laundering_tendency

        // mobile_fraud_behavior

        // face_similarity_score

        // identification_verification_matched_flag

        // bankstatement_confident_score

        // estimated_monthly_income

        // estimated_monthly_debt

        // income_stability

        // customer_grade

        // color_sign

        // rental_period

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // log_member_scb_id
            $this->log_member_scb_id->ViewValue = $this->log_member_scb_id->CurrentValue;
            $this->log_member_scb_id->ViewCustomAttributes = "";

            // reference_id
            $this->reference_id->ViewValue = $this->reference_id->CurrentValue;
            $this->reference_id->ViewCustomAttributes = "";

            // member_id
            $this->member_id->ViewValue = $this->member_id->CurrentValue;
            $this->member_id->ViewValue = FormatNumber($this->member_id->ViewValue, $this->member_id->formatPattern());
            $this->member_id->ViewCustomAttributes = "";

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

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // asset_id
            $this->asset_id->ViewValue = $this->asset_id->CurrentValue;
            $this->asset_id->ViewValue = FormatNumber($this->asset_id->ViewValue, $this->asset_id->formatPattern());
            $this->asset_id->ViewCustomAttributes = "";

            // decision_status
            $this->decision_status->ViewValue = $this->decision_status->CurrentValue;
            $this->decision_status->ViewCustomAttributes = "";

            // decision_timestamp
            $this->decision_timestamp->ViewValue = $this->decision_timestamp->CurrentValue;
            $this->decision_timestamp->ViewValue = FormatDateTime($this->decision_timestamp->ViewValue, $this->decision_timestamp->formatPattern());
            $this->decision_timestamp->ViewCustomAttributes = "";

            // deposit_amount
            $this->deposit_amount->ViewValue = $this->deposit_amount->CurrentValue;
            $this->deposit_amount->ViewValue = FormatNumber($this->deposit_amount->ViewValue, $this->deposit_amount->formatPattern());
            $this->deposit_amount->ViewCustomAttributes = "";

            // due_date
            $this->due_date->ViewValue = $this->due_date->CurrentValue;
            $this->due_date->ViewValue = FormatNumber($this->due_date->ViewValue, $this->due_date->formatPattern());
            $this->due_date->ViewCustomAttributes = "";

            // rental_fee
            $this->rental_fee->ViewValue = $this->rental_fee->CurrentValue;
            $this->rental_fee->ViewValue = FormatNumber($this->rental_fee->ViewValue, $this->rental_fee->formatPattern());
            $this->rental_fee->ViewCustomAttributes = "";

            // fullName
            $this->fullName->ViewValue = $this->fullName->CurrentValue;
            $this->fullName->ViewCustomAttributes = "";

            // age
            $this->age->ViewValue = $this->age->CurrentValue;
            $this->age->ViewValue = FormatNumber($this->age->ViewValue, $this->age->formatPattern());
            $this->age->ViewCustomAttributes = "";

            // maritalStatus
            $this->maritalStatus->ViewValue = $this->maritalStatus->CurrentValue;
            $this->maritalStatus->ViewCustomAttributes = "";

            // noOfChildren
            $this->noOfChildren->ViewValue = $this->noOfChildren->CurrentValue;
            $this->noOfChildren->ViewCustomAttributes = "";

            // educationLevel
            $this->educationLevel->ViewValue = $this->educationLevel->CurrentValue;
            $this->educationLevel->ViewCustomAttributes = "";

            // workplace
            $this->workplace->ViewValue = $this->workplace->CurrentValue;
            $this->workplace->ViewCustomAttributes = "";

            // occupation
            $this->occupation->ViewValue = $this->occupation->CurrentValue;
            $this->occupation->ViewCustomAttributes = "";

            // jobPosition
            $this->jobPosition->ViewValue = $this->jobPosition->CurrentValue;
            $this->jobPosition->ViewCustomAttributes = "";

            // submissionDate
            $this->submissionDate->ViewValue = $this->submissionDate->CurrentValue;
            $this->submissionDate->ViewValue = FormatDateTime($this->submissionDate->ViewValue, $this->submissionDate->formatPattern());
            $this->submissionDate->ViewCustomAttributes = "";

            // bankruptcy_tendency
            $this->bankruptcy_tendency->ViewValue = $this->bankruptcy_tendency->CurrentValue;
            $this->bankruptcy_tendency->ViewCustomAttributes = "";

            // blacklist_tendency
            $this->blacklist_tendency->ViewValue = $this->blacklist_tendency->CurrentValue;
            $this->blacklist_tendency->ViewCustomAttributes = "";

            // money_laundering_tendency
            $this->money_laundering_tendency->ViewValue = $this->money_laundering_tendency->CurrentValue;
            $this->money_laundering_tendency->ViewCustomAttributes = "";

            // mobile_fraud_behavior
            $this->mobile_fraud_behavior->ViewValue = $this->mobile_fraud_behavior->CurrentValue;
            $this->mobile_fraud_behavior->ViewCustomAttributes = "";

            // face_similarity_score
            $this->face_similarity_score->ViewValue = $this->face_similarity_score->CurrentValue;
            $this->face_similarity_score->ViewCustomAttributes = "";

            // identification_verification_matched_flag
            $this->identification_verification_matched_flag->ViewValue = $this->identification_verification_matched_flag->CurrentValue;
            $this->identification_verification_matched_flag->ViewCustomAttributes = "";

            // bankstatement_confident_score
            $this->bankstatement_confident_score->ViewValue = $this->bankstatement_confident_score->CurrentValue;
            $this->bankstatement_confident_score->ViewCustomAttributes = "";

            // estimated_monthly_income
            $this->estimated_monthly_income->ViewValue = $this->estimated_monthly_income->CurrentValue;
            $this->estimated_monthly_income->ViewCustomAttributes = "";

            // estimated_monthly_debt
            $this->estimated_monthly_debt->ViewValue = $this->estimated_monthly_debt->CurrentValue;
            $this->estimated_monthly_debt->ViewCustomAttributes = "";

            // income_stability
            $this->income_stability->ViewValue = $this->income_stability->CurrentValue;
            $this->income_stability->ViewCustomAttributes = "";

            // customer_grade
            $this->customer_grade->ViewValue = $this->customer_grade->CurrentValue;
            $this->customer_grade->ViewCustomAttributes = "";

            // color_sign
            $this->color_sign->ViewValue = $this->color_sign->CurrentValue;
            $this->color_sign->ViewCustomAttributes = "";

            // rental_period
            $this->rental_period->ViewValue = $this->rental_period->CurrentValue;
            $this->rental_period->ViewValue = FormatNumber($this->rental_period->ViewValue, $this->rental_period->formatPattern());
            $this->rental_period->ViewCustomAttributes = "";

            // log_member_scb_id
            $this->log_member_scb_id->LinkCustomAttributes = "";
            $this->log_member_scb_id->HrefValue = "";
            $this->log_member_scb_id->TooltipValue = "";

            // reference_id
            $this->reference_id->LinkCustomAttributes = "";
            $this->reference_id->HrefValue = "";
            $this->reference_id->TooltipValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";
            $this->cdate->TooltipValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";
            $this->cuser->TooltipValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";
            $this->cip->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";
            $this->asset_id->TooltipValue = "";

            // decision_status
            $this->decision_status->LinkCustomAttributes = "";
            $this->decision_status->HrefValue = "";
            $this->decision_status->TooltipValue = "";

            // decision_timestamp
            $this->decision_timestamp->LinkCustomAttributes = "";
            $this->decision_timestamp->HrefValue = "";
            $this->decision_timestamp->TooltipValue = "";

            // deposit_amount
            $this->deposit_amount->LinkCustomAttributes = "";
            $this->deposit_amount->HrefValue = "";
            $this->deposit_amount->TooltipValue = "";

            // due_date
            $this->due_date->LinkCustomAttributes = "";
            $this->due_date->HrefValue = "";
            $this->due_date->TooltipValue = "";

            // rental_fee
            $this->rental_fee->LinkCustomAttributes = "";
            $this->rental_fee->HrefValue = "";
            $this->rental_fee->TooltipValue = "";

            // fullName
            $this->fullName->LinkCustomAttributes = "";
            $this->fullName->HrefValue = "";
            $this->fullName->TooltipValue = "";

            // age
            $this->age->LinkCustomAttributes = "";
            $this->age->HrefValue = "";
            $this->age->TooltipValue = "";

            // maritalStatus
            $this->maritalStatus->LinkCustomAttributes = "";
            $this->maritalStatus->HrefValue = "";
            $this->maritalStatus->TooltipValue = "";

            // noOfChildren
            $this->noOfChildren->LinkCustomAttributes = "";
            $this->noOfChildren->HrefValue = "";
            $this->noOfChildren->TooltipValue = "";

            // educationLevel
            $this->educationLevel->LinkCustomAttributes = "";
            $this->educationLevel->HrefValue = "";
            $this->educationLevel->TooltipValue = "";

            // workplace
            $this->workplace->LinkCustomAttributes = "";
            $this->workplace->HrefValue = "";
            $this->workplace->TooltipValue = "";

            // occupation
            $this->occupation->LinkCustomAttributes = "";
            $this->occupation->HrefValue = "";
            $this->occupation->TooltipValue = "";

            // jobPosition
            $this->jobPosition->LinkCustomAttributes = "";
            $this->jobPosition->HrefValue = "";
            $this->jobPosition->TooltipValue = "";

            // submissionDate
            $this->submissionDate->LinkCustomAttributes = "";
            $this->submissionDate->HrefValue = "";
            $this->submissionDate->TooltipValue = "";

            // bankruptcy_tendency
            $this->bankruptcy_tendency->LinkCustomAttributes = "";
            $this->bankruptcy_tendency->HrefValue = "";
            $this->bankruptcy_tendency->TooltipValue = "";

            // blacklist_tendency
            $this->blacklist_tendency->LinkCustomAttributes = "";
            $this->blacklist_tendency->HrefValue = "";
            $this->blacklist_tendency->TooltipValue = "";

            // money_laundering_tendency
            $this->money_laundering_tendency->LinkCustomAttributes = "";
            $this->money_laundering_tendency->HrefValue = "";
            $this->money_laundering_tendency->TooltipValue = "";

            // mobile_fraud_behavior
            $this->mobile_fraud_behavior->LinkCustomAttributes = "";
            $this->mobile_fraud_behavior->HrefValue = "";
            $this->mobile_fraud_behavior->TooltipValue = "";

            // face_similarity_score
            $this->face_similarity_score->LinkCustomAttributes = "";
            $this->face_similarity_score->HrefValue = "";
            $this->face_similarity_score->TooltipValue = "";

            // identification_verification_matched_flag
            $this->identification_verification_matched_flag->LinkCustomAttributes = "";
            $this->identification_verification_matched_flag->HrefValue = "";
            $this->identification_verification_matched_flag->TooltipValue = "";

            // bankstatement_confident_score
            $this->bankstatement_confident_score->LinkCustomAttributes = "";
            $this->bankstatement_confident_score->HrefValue = "";
            $this->bankstatement_confident_score->TooltipValue = "";

            // estimated_monthly_income
            $this->estimated_monthly_income->LinkCustomAttributes = "";
            $this->estimated_monthly_income->HrefValue = "";
            $this->estimated_monthly_income->TooltipValue = "";

            // estimated_monthly_debt
            $this->estimated_monthly_debt->LinkCustomAttributes = "";
            $this->estimated_monthly_debt->HrefValue = "";
            $this->estimated_monthly_debt->TooltipValue = "";

            // income_stability
            $this->income_stability->LinkCustomAttributes = "";
            $this->income_stability->HrefValue = "";
            $this->income_stability->TooltipValue = "";

            // customer_grade
            $this->customer_grade->LinkCustomAttributes = "";
            $this->customer_grade->HrefValue = "";
            $this->customer_grade->TooltipValue = "";

            // color_sign
            $this->color_sign->LinkCustomAttributes = "";
            $this->color_sign->HrefValue = "";
            $this->color_sign->TooltipValue = "";

            // rental_period
            $this->rental_period->LinkCustomAttributes = "";
            $this->rental_period->HrefValue = "";
            $this->rental_period->TooltipValue = "";
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
            $thisKey .= $row['log_member_scb_id'];

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("logmemberscblist"), "", $this->TableVar, true);
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
