<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for doc_juzmatch2
 */
class DocJuzmatch2 extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-4 col-form-label ew-label";
    public $RightColumnClass = "col-sm-8";
    public $OffsetColumnClass = "col-sm-8 offset-sm-4";
    public $TableLeftColumnClass = "w-col-4";

    // Export
    public $ExportDoc;

    // Fields
    public $id;
    public $document_date;
    public $asset_code;
    public $asset_project;
    public $asset_deed;
    public $asset_area;
    public $investor_name;
    public $investor_lname;
    public $investor_email;
    public $investor_idcard;
    public $investor_homeno;
    public $investment_money;
    public $investment_money_txt;
    public $loan_contact_date;
    public $contract_expired;
    public $first_benefits_month;
    public $one_installment_amount;
    public $two_installment_amount1;
    public $two_installment_amount2;
    public $investor_paid_amount;
    public $first_benefits_date;
    public $one_benefit_amount;
    public $two_benefit_amount1;
    public $two_benefit_amount2;
    public $management_agent_date;
    public $begin_date;
    public $investor_witness_name;
    public $investor_witness_lname;
    public $investor_witness_email;
    public $juzmatch_authority_name;
    public $juzmatch_authority_lname;
    public $juzmatch_authority_email;
    public $juzmatch_authority_witness_name;
    public $juzmatch_authority_witness_lname;
    public $juzmatch_authority_witness_email;
    public $juzmatch_authority2_name;
    public $juzmatch_authority2_lname;
    public $juzmatch_authority2_email;
    public $company_seal_name;
    public $company_seal_email;
    public $file_idcard;
    public $file_house_regis;
    public $file_other;
    public $contact_address;
    public $contact_address2;
    public $contact_email;
    public $contact_lineid;
    public $contact_phone;
    public $file_loan;
    public $attach_file;
    public $status;
    public $doc_creden_id;
    public $cdate;
    public $cuser;
    public $cip;
    public $udate;
    public $uuser;
    public $uip;
    public $doc_date;
    public $investor_booking_id;
    public $first_down;
    public $first_down_txt;
    public $second_down;
    public $second_down_txt;
    public $service_price;
    public $service_price_txt;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'doc_juzmatch2';
        $this->TableName = 'doc_juzmatch2';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`doc_juzmatch2`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_DEFAULT; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4; // Page size (PhpSpreadsheet only)
        $this->ExportWordVersion = 12; // Word version (PHPWord only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = "A4"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_id',
            'id',
            '`id`',
            '`id`',
            3,
            11,
            -1,
            false,
            '`id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->id->InputTextType = "text";
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = false; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['id'] = &$this->id;

        // document_date
        $this->document_date = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_document_date',
            'document_date',
            '`document_date`',
            CastDateFieldForLike("`document_date`", 117, "DB"),
            135,
            19,
            117,
            false,
            '`document_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->document_date->InputTextType = "text";
        $this->document_date->DefaultErrorMessage = str_replace("%s", DateFormat(117), $Language->phrase("IncorrectDate"));
        $this->Fields['document_date'] = &$this->document_date;

        // asset_code
        $this->asset_code = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_asset_code',
            'asset_code',
            '`asset_code`',
            '`asset_code`',
            200,
            250,
            -1,
            false,
            '`asset_code`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->asset_code->InputTextType = "text";
        $this->Fields['asset_code'] = &$this->asset_code;

        // asset_project
        $this->asset_project = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_asset_project',
            'asset_project',
            '`asset_project`',
            '`asset_project`',
            200,
            250,
            -1,
            false,
            '`asset_project`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->asset_project->InputTextType = "text";
        $this->Fields['asset_project'] = &$this->asset_project;

        // asset_deed
        $this->asset_deed = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_asset_deed',
            'asset_deed',
            '`asset_deed`',
            '`asset_deed`',
            200,
            250,
            -1,
            false,
            '`asset_deed`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->asset_deed->InputTextType = "text";
        $this->Fields['asset_deed'] = &$this->asset_deed;

        // asset_area
        $this->asset_area = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_asset_area',
            'asset_area',
            '`asset_area`',
            '`asset_area`',
            200,
            250,
            -1,
            false,
            '`asset_area`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->asset_area->InputTextType = "text";
        $this->Fields['asset_area'] = &$this->asset_area;

        // investor_name
        $this->investor_name = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_investor_name',
            'investor_name',
            '`investor_name`',
            '`investor_name`',
            201,
            500,
            -1,
            false,
            '`investor_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->investor_name->InputTextType = "text";
        $this->Fields['investor_name'] = &$this->investor_name;

        // investor_lname
        $this->investor_lname = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_investor_lname',
            'investor_lname',
            '`investor_lname`',
            '`investor_lname`',
            200,
            250,
            -1,
            false,
            '`investor_lname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->investor_lname->InputTextType = "text";
        $this->Fields['investor_lname'] = &$this->investor_lname;

        // investor_email
        $this->investor_email = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_investor_email',
            'investor_email',
            '`investor_email`',
            '`investor_email`',
            200,
            250,
            -1,
            false,
            '`investor_email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->investor_email->InputTextType = "text";
        $this->Fields['investor_email'] = &$this->investor_email;

        // investor_idcard
        $this->investor_idcard = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_investor_idcard',
            'investor_idcard',
            '`investor_idcard`',
            '`investor_idcard`',
            200,
            250,
            -1,
            false,
            '`investor_idcard`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->investor_idcard->InputTextType = "text";
        $this->Fields['investor_idcard'] = &$this->investor_idcard;

        // investor_homeno
        $this->investor_homeno = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_investor_homeno',
            'investor_homeno',
            '`investor_homeno`',
            '`investor_homeno`',
            200,
            250,
            -1,
            false,
            '`investor_homeno`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->investor_homeno->InputTextType = "text";
        $this->Fields['investor_homeno'] = &$this->investor_homeno;

        // investment_money
        $this->investment_money = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_investment_money',
            'investment_money',
            '`investment_money`',
            '`investment_money`',
            5,
            22,
            -1,
            false,
            '`investment_money`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->investment_money->InputTextType = "text";
        $this->investment_money->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['investment_money'] = &$this->investment_money;

        // investment_money_txt
        $this->investment_money_txt = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_investment_money_txt',
            'investment_money_txt',
            '`investment_money_txt`',
            '`investment_money_txt`',
            201,
            500,
            -1,
            false,
            '`investment_money_txt`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->investment_money_txt->InputTextType = "text";
        $this->Fields['investment_money_txt'] = &$this->investment_money_txt;

        // loan_contact_date
        $this->loan_contact_date = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_loan_contact_date',
            'loan_contact_date',
            '`loan_contact_date`',
            CastDateFieldForLike("`loan_contact_date`", 7, "DB"),
            133,
            10,
            7,
            false,
            '`loan_contact_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->loan_contact_date->InputTextType = "text";
        $this->loan_contact_date->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->Fields['loan_contact_date'] = &$this->loan_contact_date;

        // contract_expired
        $this->contract_expired = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_contract_expired',
            'contract_expired',
            '`contract_expired`',
            CastDateFieldForLike("`contract_expired`", 7, "DB"),
            133,
            10,
            7,
            false,
            '`contract_expired`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contract_expired->InputTextType = "text";
        $this->contract_expired->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->Fields['contract_expired'] = &$this->contract_expired;

        // first_benefits_month
        $this->first_benefits_month = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_first_benefits_month',
            'first_benefits_month',
            '`first_benefits_month`',
            '`first_benefits_month`',
            3,
            11,
            -1,
            false,
            '`first_benefits_month`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->first_benefits_month->InputTextType = "text";
        $this->first_benefits_month->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['first_benefits_month'] = &$this->first_benefits_month;

        // one_installment_amount
        $this->one_installment_amount = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_one_installment_amount',
            'one_installment_amount',
            '`one_installment_amount`',
            '`one_installment_amount`',
            5,
            22,
            -1,
            false,
            '`one_installment_amount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->one_installment_amount->InputTextType = "text";
        $this->one_installment_amount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['one_installment_amount'] = &$this->one_installment_amount;

        // two_installment_amount1
        $this->two_installment_amount1 = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_two_installment_amount1',
            'two_installment_amount1',
            '`two_installment_amount1`',
            '`two_installment_amount1`',
            5,
            22,
            -1,
            false,
            '`two_installment_amount1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->two_installment_amount1->InputTextType = "text";
        $this->two_installment_amount1->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['two_installment_amount1'] = &$this->two_installment_amount1;

        // two_installment_amount2
        $this->two_installment_amount2 = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_two_installment_amount2',
            'two_installment_amount2',
            '`two_installment_amount2`',
            '`two_installment_amount2`',
            5,
            22,
            -1,
            false,
            '`two_installment_amount2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->two_installment_amount2->InputTextType = "text";
        $this->two_installment_amount2->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['two_installment_amount2'] = &$this->two_installment_amount2;

        // investor_paid_amount
        $this->investor_paid_amount = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_investor_paid_amount',
            'investor_paid_amount',
            '`investor_paid_amount`',
            '`investor_paid_amount`',
            5,
            22,
            -1,
            false,
            '`investor_paid_amount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->investor_paid_amount->InputTextType = "text";
        $this->investor_paid_amount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['investor_paid_amount'] = &$this->investor_paid_amount;

        // first_benefits_date
        $this->first_benefits_date = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_first_benefits_date',
            'first_benefits_date',
            '`first_benefits_date`',
            CastDateFieldForLike("`first_benefits_date`", 7, "DB"),
            133,
            10,
            7,
            false,
            '`first_benefits_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->first_benefits_date->InputTextType = "text";
        $this->first_benefits_date->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->Fields['first_benefits_date'] = &$this->first_benefits_date;

        // one_benefit_amount
        $this->one_benefit_amount = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_one_benefit_amount',
            'one_benefit_amount',
            '`one_benefit_amount`',
            '`one_benefit_amount`',
            5,
            22,
            -1,
            false,
            '`one_benefit_amount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->one_benefit_amount->InputTextType = "text";
        $this->one_benefit_amount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['one_benefit_amount'] = &$this->one_benefit_amount;

        // two_benefit_amount1
        $this->two_benefit_amount1 = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_two_benefit_amount1',
            'two_benefit_amount1',
            '`two_benefit_amount1`',
            '`two_benefit_amount1`',
            5,
            22,
            -1,
            false,
            '`two_benefit_amount1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->two_benefit_amount1->InputTextType = "text";
        $this->two_benefit_amount1->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['two_benefit_amount1'] = &$this->two_benefit_amount1;

        // two_benefit_amount2
        $this->two_benefit_amount2 = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_two_benefit_amount2',
            'two_benefit_amount2',
            '`two_benefit_amount2`',
            '`two_benefit_amount2`',
            5,
            22,
            -1,
            false,
            '`two_benefit_amount2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->two_benefit_amount2->InputTextType = "text";
        $this->two_benefit_amount2->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['two_benefit_amount2'] = &$this->two_benefit_amount2;

        // management_agent_date
        $this->management_agent_date = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_management_agent_date',
            'management_agent_date',
            '`management_agent_date`',
            CastDateFieldForLike("`management_agent_date`", 7, "DB"),
            133,
            10,
            7,
            false,
            '`management_agent_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->management_agent_date->InputTextType = "text";
        $this->management_agent_date->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->Fields['management_agent_date'] = &$this->management_agent_date;

        // begin_date
        $this->begin_date = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_begin_date',
            'begin_date',
            '`begin_date`',
            '`begin_date`',
            3,
            11,
            -1,
            false,
            '`begin_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->begin_date->InputTextType = "text";
        $this->begin_date->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['begin_date'] = &$this->begin_date;

        // investor_witness_name
        $this->investor_witness_name = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_investor_witness_name',
            'investor_witness_name',
            '`investor_witness_name`',
            '`investor_witness_name`',
            201,
            500,
            -1,
            false,
            '`investor_witness_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->investor_witness_name->InputTextType = "text";
        $this->Fields['investor_witness_name'] = &$this->investor_witness_name;

        // investor_witness_lname
        $this->investor_witness_lname = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_investor_witness_lname',
            'investor_witness_lname',
            '`investor_witness_lname`',
            '`investor_witness_lname`',
            200,
            250,
            -1,
            false,
            '`investor_witness_lname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->investor_witness_lname->InputTextType = "text";
        $this->Fields['investor_witness_lname'] = &$this->investor_witness_lname;

        // investor_witness_email
        $this->investor_witness_email = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_investor_witness_email',
            'investor_witness_email',
            '`investor_witness_email`',
            '`investor_witness_email`',
            200,
            250,
            -1,
            false,
            '`investor_witness_email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->investor_witness_email->InputTextType = "text";
        $this->Fields['investor_witness_email'] = &$this->investor_witness_email;

        // juzmatch_authority_name
        $this->juzmatch_authority_name = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_juzmatch_authority_name',
            'juzmatch_authority_name',
            '`juzmatch_authority_name`',
            '`juzmatch_authority_name`',
            201,
            500,
            -1,
            false,
            '`juzmatch_authority_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->juzmatch_authority_name->InputTextType = "text";
        $this->Fields['juzmatch_authority_name'] = &$this->juzmatch_authority_name;

        // juzmatch_authority_lname
        $this->juzmatch_authority_lname = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_juzmatch_authority_lname',
            'juzmatch_authority_lname',
            '`juzmatch_authority_lname`',
            '`juzmatch_authority_lname`',
            200,
            250,
            -1,
            false,
            '`juzmatch_authority_lname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->juzmatch_authority_lname->InputTextType = "text";
        $this->Fields['juzmatch_authority_lname'] = &$this->juzmatch_authority_lname;

        // juzmatch_authority_email
        $this->juzmatch_authority_email = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_juzmatch_authority_email',
            'juzmatch_authority_email',
            '`juzmatch_authority_email`',
            '`juzmatch_authority_email`',
            200,
            250,
            -1,
            false,
            '`juzmatch_authority_email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->juzmatch_authority_email->InputTextType = "text";
        $this->Fields['juzmatch_authority_email'] = &$this->juzmatch_authority_email;

        // juzmatch_authority_witness_name
        $this->juzmatch_authority_witness_name = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_juzmatch_authority_witness_name',
            'juzmatch_authority_witness_name',
            '`juzmatch_authority_witness_name`',
            '`juzmatch_authority_witness_name`',
            201,
            500,
            -1,
            false,
            '`juzmatch_authority_witness_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->juzmatch_authority_witness_name->InputTextType = "text";
        $this->Fields['juzmatch_authority_witness_name'] = &$this->juzmatch_authority_witness_name;

        // juzmatch_authority_witness_lname
        $this->juzmatch_authority_witness_lname = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_juzmatch_authority_witness_lname',
            'juzmatch_authority_witness_lname',
            '`juzmatch_authority_witness_lname`',
            '`juzmatch_authority_witness_lname`',
            200,
            250,
            -1,
            false,
            '`juzmatch_authority_witness_lname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->juzmatch_authority_witness_lname->InputTextType = "text";
        $this->Fields['juzmatch_authority_witness_lname'] = &$this->juzmatch_authority_witness_lname;

        // juzmatch_authority_witness_email
        $this->juzmatch_authority_witness_email = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_juzmatch_authority_witness_email',
            'juzmatch_authority_witness_email',
            '`juzmatch_authority_witness_email`',
            '`juzmatch_authority_witness_email`',
            200,
            250,
            -1,
            false,
            '`juzmatch_authority_witness_email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->juzmatch_authority_witness_email->InputTextType = "text";
        $this->Fields['juzmatch_authority_witness_email'] = &$this->juzmatch_authority_witness_email;

        // juzmatch_authority2_name
        $this->juzmatch_authority2_name = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_juzmatch_authority2_name',
            'juzmatch_authority2_name',
            '`juzmatch_authority2_name`',
            '`juzmatch_authority2_name`',
            201,
            500,
            -1,
            false,
            '`juzmatch_authority2_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->juzmatch_authority2_name->InputTextType = "text";
        $this->Fields['juzmatch_authority2_name'] = &$this->juzmatch_authority2_name;

        // juzmatch_authority2_lname
        $this->juzmatch_authority2_lname = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_juzmatch_authority2_lname',
            'juzmatch_authority2_lname',
            '`juzmatch_authority2_lname`',
            '`juzmatch_authority2_lname`',
            200,
            250,
            -1,
            false,
            '`juzmatch_authority2_lname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->juzmatch_authority2_lname->InputTextType = "text";
        $this->Fields['juzmatch_authority2_lname'] = &$this->juzmatch_authority2_lname;

        // juzmatch_authority2_email
        $this->juzmatch_authority2_email = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_juzmatch_authority2_email',
            'juzmatch_authority2_email',
            '`juzmatch_authority2_email`',
            '`juzmatch_authority2_email`',
            200,
            250,
            -1,
            false,
            '`juzmatch_authority2_email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->juzmatch_authority2_email->InputTextType = "text";
        $this->Fields['juzmatch_authority2_email'] = &$this->juzmatch_authority2_email;

        // company_seal_name
        $this->company_seal_name = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_company_seal_name',
            'company_seal_name',
            '`company_seal_name`',
            '`company_seal_name`',
            200,
            250,
            -1,
            false,
            '`company_seal_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->company_seal_name->InputTextType = "text";
        $this->Fields['company_seal_name'] = &$this->company_seal_name;

        // company_seal_email
        $this->company_seal_email = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_company_seal_email',
            'company_seal_email',
            '`company_seal_email`',
            '`company_seal_email`',
            200,
            250,
            -1,
            false,
            '`company_seal_email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->company_seal_email->InputTextType = "text";
        $this->Fields['company_seal_email'] = &$this->company_seal_email;

        // file_idcard
        $this->file_idcard = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_file_idcard',
            'file_idcard',
            '`file_idcard`',
            '`file_idcard`',
            200,
            250,
            -1,
            true,
            '`file_idcard`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'FILE'
        );
        $this->file_idcard->InputTextType = "text";
        $this->file_idcard->UploadPath = "/upload/";
        $this->Fields['file_idcard'] = &$this->file_idcard;

        // file_house_regis
        $this->file_house_regis = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_file_house_regis',
            'file_house_regis',
            '`file_house_regis`',
            '`file_house_regis`',
            200,
            250,
            -1,
            true,
            '`file_house_regis`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'FILE'
        );
        $this->file_house_regis->InputTextType = "text";
        $this->file_house_regis->UploadPath = "/upload/";
        $this->Fields['file_house_regis'] = &$this->file_house_regis;

        // file_other
        $this->file_other = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_file_other',
            'file_other',
            '`file_other`',
            '`file_other`',
            200,
            250,
            -1,
            true,
            '`file_other`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'FILE'
        );
        $this->file_other->InputTextType = "text";
        $this->file_other->UploadPath = "/upload/";
        $this->Fields['file_other'] = &$this->file_other;

        // contact_address
        $this->contact_address = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_contact_address',
            'contact_address',
            '`contact_address`',
            '`contact_address`',
            200,
            250,
            -1,
            false,
            '`contact_address`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_address->InputTextType = "text";
        $this->Fields['contact_address'] = &$this->contact_address;

        // contact_address2
        $this->contact_address2 = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_contact_address2',
            'contact_address2',
            '`contact_address2`',
            '`contact_address2`',
            200,
            250,
            -1,
            false,
            '`contact_address2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_address2->InputTextType = "text";
        $this->Fields['contact_address2'] = &$this->contact_address2;

        // contact_email
        $this->contact_email = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_contact_email',
            'contact_email',
            '`contact_email`',
            '`contact_email`',
            200,
            250,
            -1,
            false,
            '`contact_email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_email->InputTextType = "text";
        $this->Fields['contact_email'] = &$this->contact_email;

        // contact_lineid
        $this->contact_lineid = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_contact_lineid',
            'contact_lineid',
            '`contact_lineid`',
            '`contact_lineid`',
            200,
            250,
            -1,
            false,
            '`contact_lineid`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_lineid->InputTextType = "text";
        $this->Fields['contact_lineid'] = &$this->contact_lineid;

        // contact_phone
        $this->contact_phone = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_contact_phone',
            'contact_phone',
            '`contact_phone`',
            '`contact_phone`',
            200,
            250,
            -1,
            false,
            '`contact_phone`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_phone->InputTextType = "text";
        $this->Fields['contact_phone'] = &$this->contact_phone;

        // file_loan
        $this->file_loan = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_file_loan',
            'file_loan',
            '`file_loan`',
            '`file_loan`',
            200,
            250,
            -1,
            false,
            '`file_loan`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->file_loan->InputTextType = "text";
        $this->Fields['file_loan'] = &$this->file_loan;

        // attach_file
        $this->attach_file = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_attach_file',
            'attach_file',
            '`attach_file`',
            '`attach_file`',
            200,
            250,
            -1,
            false,
            '`attach_file`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->attach_file->InputTextType = "text";
        $this->Fields['attach_file'] = &$this->attach_file;

        // status
        $this->status = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_status',
            'status',
            '`status`',
            '`status`',
            3,
            11,
            -1,
            false,
            '`status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->status->InputTextType = "text";
        $this->status->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->status->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->status->Lookup = new Lookup('status', 'doc_juzmatch2', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->status->OptionCount = 3;
        $this->status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status'] = &$this->status;

        // doc_creden_id
        $this->doc_creden_id = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_doc_creden_id',
            'doc_creden_id',
            '`doc_creden_id`',
            '`doc_creden_id`',
            3,
            11,
            -1,
            false,
            '`doc_creden_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->doc_creden_id->InputTextType = "text";
        $this->doc_creden_id->Sortable = false; // Allow sort
        $this->doc_creden_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['doc_creden_id'] = &$this->doc_creden_id;

        // cdate
        $this->cdate = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_cdate',
            'cdate',
            '`cdate`',
            CastDateFieldForLike("`cdate`", 111, "DB"),
            135,
            19,
            111,
            false,
            '`cdate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->cdate->InputTextType = "text";
        $this->cdate->DefaultErrorMessage = str_replace("%s", DateFormat(111), $Language->phrase("IncorrectDate"));
        $this->Fields['cdate'] = &$this->cdate;

        // cuser
        $this->cuser = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_cuser',
            'cuser',
            '`cuser`',
            '`cuser`',
            3,
            11,
            -1,
            false,
            '`cuser`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->cuser->InputTextType = "text";
        $this->cuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['cuser'] = &$this->cuser;

        // cip
        $this->cip = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_cip',
            'cip',
            '`cip`',
            '`cip`',
            200,
            50,
            -1,
            false,
            '`cip`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->cip->InputTextType = "text";
        $this->Fields['cip'] = &$this->cip;

        // udate
        $this->udate = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_udate',
            'udate',
            '`udate`',
            CastDateFieldForLike("`udate`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`udate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->udate->InputTextType = "text";
        $this->udate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['udate'] = &$this->udate;

        // uuser
        $this->uuser = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_uuser',
            'uuser',
            '`uuser`',
            '`uuser`',
            3,
            11,
            -1,
            false,
            '`uuser`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->uuser->InputTextType = "text";
        $this->uuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['uuser'] = &$this->uuser;

        // uip
        $this->uip = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_uip',
            'uip',
            '`uip`',
            '`uip`',
            200,
            50,
            -1,
            false,
            '`uip`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->uip->InputTextType = "text";
        $this->Fields['uip'] = &$this->uip;

        // doc_date
        $this->doc_date = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_doc_date',
            'doc_date',
            '`doc_date`',
            CastDateFieldForLike("`doc_date`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`doc_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->doc_date->InputTextType = "text";
        $this->doc_date->Sortable = false; // Allow sort
        $this->doc_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['doc_date'] = &$this->doc_date;

        // investor_booking_id
        $this->investor_booking_id = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_investor_booking_id',
            'investor_booking_id',
            '`investor_booking_id`',
            '`investor_booking_id`',
            3,
            11,
            -1,
            false,
            '`investor_booking_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->investor_booking_id->InputTextType = "text";
        $this->investor_booking_id->IsForeignKey = true; // Foreign key field
        $this->investor_booking_id->Nullable = false; // NOT NULL field
        $this->investor_booking_id->Required = true; // Required field
        $this->investor_booking_id->Sortable = false; // Allow sort
        $this->investor_booking_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['investor_booking_id'] = &$this->investor_booking_id;

        // first_down
        $this->first_down = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_first_down',
            'first_down',
            '`first_down`',
            '`first_down`',
            5,
            22,
            -1,
            false,
            '`first_down`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->first_down->InputTextType = "text";
        $this->first_down->Sortable = false; // Allow sort
        $this->first_down->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['first_down'] = &$this->first_down;

        // first_down_txt
        $this->first_down_txt = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_first_down_txt',
            'first_down_txt',
            '`first_down_txt`',
            '`first_down_txt`',
            200,
            250,
            -1,
            false,
            '`first_down_txt`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->first_down_txt->InputTextType = "text";
        $this->first_down_txt->Sortable = false; // Allow sort
        $this->Fields['first_down_txt'] = &$this->first_down_txt;

        // second_down
        $this->second_down = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_second_down',
            'second_down',
            '`second_down`',
            '`second_down`',
            5,
            22,
            -1,
            false,
            '`second_down`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->second_down->InputTextType = "text";
        $this->second_down->Sortable = false; // Allow sort
        $this->second_down->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['second_down'] = &$this->second_down;

        // second_down_txt
        $this->second_down_txt = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_second_down_txt',
            'second_down_txt',
            '`second_down_txt`',
            '`second_down_txt`',
            200,
            250,
            -1,
            false,
            '`second_down_txt`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->second_down_txt->InputTextType = "text";
        $this->second_down_txt->Sortable = false; // Allow sort
        $this->Fields['second_down_txt'] = &$this->second_down_txt;

        // service_price
        $this->service_price = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_service_price',
            'service_price',
            '`service_price`',
            '`service_price`',
            5,
            22,
            -1,
            false,
            '`service_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->service_price->InputTextType = "text";
        $this->service_price->Sortable = false; // Allow sort
        $this->service_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['service_price'] = &$this->service_price;

        // service_price_txt
        $this->service_price_txt = new DbField(
            'doc_juzmatch2',
            'doc_juzmatch2',
            'x_service_price_txt',
            'service_price_txt',
            '`service_price_txt`',
            '`service_price_txt`',
            200,
            250,
            -1,
            false,
            '`service_price_txt`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->service_price_txt->InputTextType = "text";
        $this->service_price_txt->Sortable = false; // Allow sort
        $this->Fields['service_price_txt'] = &$this->service_price_txt;

        // Add Doctrine Cache
        $this->Cache = new ArrayCache();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Multiple column sort
    public function updateSort(&$fld, $ctrl)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortField . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            if ($ctrl) {
                $orderBy = $this->getSessionOrderBy();
                $arOrderBy = !empty($orderBy) ? explode(", ", $orderBy) : [];
                if ($lastOrderBy != "" && in_array($lastOrderBy, $arOrderBy)) {
                    foreach ($arOrderBy as $key => $val) {
                        if ($val == $lastOrderBy) {
                            if ($curOrderBy == "") {
                                unset($arOrderBy[$key]);
                            } else {
                                $arOrderBy[$key] = $curOrderBy;
                            }
                        }
                    }
                } elseif ($curOrderBy != "") {
                    $arOrderBy[] = $curOrderBy;
                }
                $orderBy = implode(", ", $arOrderBy);
                $this->setSessionOrderBy($orderBy); // Save to Session
            } else {
                $this->setSessionOrderBy($curOrderBy); // Save to Session
            }
        } else {
            if (!$ctrl) {
                $fld->setSort("");
            }
        }
    }

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Get master WHERE clause from session values
    public function getMasterFilterFromSession()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "invertor_all_booking") {
            if ($this->investor_booking_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`invertor_booking_id`", $this->investor_booking_id->getSessionValue(), DATATYPE_NUMBER, "juzmatch1");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Get detail WHERE clause from session values
    public function getDetailFilterFromSession()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "invertor_all_booking") {
            if ($this->investor_booking_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`investor_booking_id`", $this->investor_booking_id->getSessionValue(), DATATYPE_NUMBER, "juzmatch1");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    /**
     * Get master filter
     *
     * @param object $masterTable Master Table
     * @param array $keys Detail Keys
     * @return mixed NULL is returned if all keys are empty, Empty string is returned if some keys are empty and is required
     */
    public function getMasterFilter($masterTable, $keys)
    {
        $validKeys = true;
        switch ($masterTable->TableVar) {
            case "invertor_all_booking":
                $key = $keys["investor_booking_id"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->invertor_booking_id->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return "`invertor_booking_id`=" . QuotedValue($keys["investor_booking_id"], $masterTable->invertor_booking_id->DataType, $masterTable->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "invertor_all_booking":
                return "`investor_booking_id`=" . QuotedValue($masterTable->invertor_booking_id->DbValue, $this->investor_booking_id->DataType, $this->Dbid);
        }
        return "";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`doc_juzmatch2`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlwrk);
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    public function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->id->setDbValue($conn->lastInsertId());
            $rs['id'] = $this->id->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->id->DbValue = $row['id'];
        $this->document_date->DbValue = $row['document_date'];
        $this->asset_code->DbValue = $row['asset_code'];
        $this->asset_project->DbValue = $row['asset_project'];
        $this->asset_deed->DbValue = $row['asset_deed'];
        $this->asset_area->DbValue = $row['asset_area'];
        $this->investor_name->DbValue = $row['investor_name'];
        $this->investor_lname->DbValue = $row['investor_lname'];
        $this->investor_email->DbValue = $row['investor_email'];
        $this->investor_idcard->DbValue = $row['investor_idcard'];
        $this->investor_homeno->DbValue = $row['investor_homeno'];
        $this->investment_money->DbValue = $row['investment_money'];
        $this->investment_money_txt->DbValue = $row['investment_money_txt'];
        $this->loan_contact_date->DbValue = $row['loan_contact_date'];
        $this->contract_expired->DbValue = $row['contract_expired'];
        $this->first_benefits_month->DbValue = $row['first_benefits_month'];
        $this->one_installment_amount->DbValue = $row['one_installment_amount'];
        $this->two_installment_amount1->DbValue = $row['two_installment_amount1'];
        $this->two_installment_amount2->DbValue = $row['two_installment_amount2'];
        $this->investor_paid_amount->DbValue = $row['investor_paid_amount'];
        $this->first_benefits_date->DbValue = $row['first_benefits_date'];
        $this->one_benefit_amount->DbValue = $row['one_benefit_amount'];
        $this->two_benefit_amount1->DbValue = $row['two_benefit_amount1'];
        $this->two_benefit_amount2->DbValue = $row['two_benefit_amount2'];
        $this->management_agent_date->DbValue = $row['management_agent_date'];
        $this->begin_date->DbValue = $row['begin_date'];
        $this->investor_witness_name->DbValue = $row['investor_witness_name'];
        $this->investor_witness_lname->DbValue = $row['investor_witness_lname'];
        $this->investor_witness_email->DbValue = $row['investor_witness_email'];
        $this->juzmatch_authority_name->DbValue = $row['juzmatch_authority_name'];
        $this->juzmatch_authority_lname->DbValue = $row['juzmatch_authority_lname'];
        $this->juzmatch_authority_email->DbValue = $row['juzmatch_authority_email'];
        $this->juzmatch_authority_witness_name->DbValue = $row['juzmatch_authority_witness_name'];
        $this->juzmatch_authority_witness_lname->DbValue = $row['juzmatch_authority_witness_lname'];
        $this->juzmatch_authority_witness_email->DbValue = $row['juzmatch_authority_witness_email'];
        $this->juzmatch_authority2_name->DbValue = $row['juzmatch_authority2_name'];
        $this->juzmatch_authority2_lname->DbValue = $row['juzmatch_authority2_lname'];
        $this->juzmatch_authority2_email->DbValue = $row['juzmatch_authority2_email'];
        $this->company_seal_name->DbValue = $row['company_seal_name'];
        $this->company_seal_email->DbValue = $row['company_seal_email'];
        $this->file_idcard->Upload->DbValue = $row['file_idcard'];
        $this->file_house_regis->Upload->DbValue = $row['file_house_regis'];
        $this->file_other->Upload->DbValue = $row['file_other'];
        $this->contact_address->DbValue = $row['contact_address'];
        $this->contact_address2->DbValue = $row['contact_address2'];
        $this->contact_email->DbValue = $row['contact_email'];
        $this->contact_lineid->DbValue = $row['contact_lineid'];
        $this->contact_phone->DbValue = $row['contact_phone'];
        $this->file_loan->DbValue = $row['file_loan'];
        $this->attach_file->DbValue = $row['attach_file'];
        $this->status->DbValue = $row['status'];
        $this->doc_creden_id->DbValue = $row['doc_creden_id'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cuser->DbValue = $row['cuser'];
        $this->cip->DbValue = $row['cip'];
        $this->udate->DbValue = $row['udate'];
        $this->uuser->DbValue = $row['uuser'];
        $this->uip->DbValue = $row['uip'];
        $this->doc_date->DbValue = $row['doc_date'];
        $this->investor_booking_id->DbValue = $row['investor_booking_id'];
        $this->first_down->DbValue = $row['first_down'];
        $this->first_down_txt->DbValue = $row['first_down_txt'];
        $this->second_down->DbValue = $row['second_down'];
        $this->second_down_txt->DbValue = $row['second_down_txt'];
        $this->service_price->DbValue = $row['service_price'];
        $this->service_price_txt->DbValue = $row['service_price_txt'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $this->file_idcard->OldUploadPath = "/upload/";
        $oldFiles = EmptyValue($row['file_idcard']) ? [] : [$row['file_idcard']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->file_idcard->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->file_idcard->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $this->file_house_regis->OldUploadPath = "/upload/";
        $oldFiles = EmptyValue($row['file_house_regis']) ? [] : [$row['file_house_regis']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->file_house_regis->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->file_house_regis->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $this->file_other->OldUploadPath = "/upload/";
        $oldFiles = EmptyValue($row['file_other']) ? [] : [$row['file_other']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->file_other->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->file_other->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = $this->id->OldValue !== null ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("docjuzmatch2list");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "docjuzmatch2view") {
            return $Language->phrase("View");
        } elseif ($pageName == "docjuzmatch2edit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "docjuzmatch2add") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "DocJuzmatch2View";
            case Config("API_ADD_ACTION"):
                return "DocJuzmatch2Add";
            case Config("API_EDIT_ACTION"):
                return "DocJuzmatch2Edit";
            case Config("API_DELETE_ACTION"):
                return "DocJuzmatch2Delete";
            case Config("API_LIST_ACTION"):
                return "DocJuzmatch2List";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "docjuzmatch2list";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("docjuzmatch2view", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("docjuzmatch2view", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "docjuzmatch2add?" . $this->getUrlParm($parm);
        } else {
            $url = "docjuzmatch2add";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("docjuzmatch2edit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("docjuzmatch2add", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("docjuzmatch2delete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "invertor_all_booking" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_invertor_booking_id", $this->investor_booking_id->CurrentValue);
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"id\":" . JsonEncode($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language;
        $sortUrl = "";
        $attrs = "";
        if ($fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-sort-url="' . $sortUrl . '" data-sort-type="2"';
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") . '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->id->setDbValue($row['id']);
        $this->document_date->setDbValue($row['document_date']);
        $this->asset_code->setDbValue($row['asset_code']);
        $this->asset_project->setDbValue($row['asset_project']);
        $this->asset_deed->setDbValue($row['asset_deed']);
        $this->asset_area->setDbValue($row['asset_area']);
        $this->investor_name->setDbValue($row['investor_name']);
        $this->investor_lname->setDbValue($row['investor_lname']);
        $this->investor_email->setDbValue($row['investor_email']);
        $this->investor_idcard->setDbValue($row['investor_idcard']);
        $this->investor_homeno->setDbValue($row['investor_homeno']);
        $this->investment_money->setDbValue($row['investment_money']);
        $this->investment_money_txt->setDbValue($row['investment_money_txt']);
        $this->loan_contact_date->setDbValue($row['loan_contact_date']);
        $this->contract_expired->setDbValue($row['contract_expired']);
        $this->first_benefits_month->setDbValue($row['first_benefits_month']);
        $this->one_installment_amount->setDbValue($row['one_installment_amount']);
        $this->two_installment_amount1->setDbValue($row['two_installment_amount1']);
        $this->two_installment_amount2->setDbValue($row['two_installment_amount2']);
        $this->investor_paid_amount->setDbValue($row['investor_paid_amount']);
        $this->first_benefits_date->setDbValue($row['first_benefits_date']);
        $this->one_benefit_amount->setDbValue($row['one_benefit_amount']);
        $this->two_benefit_amount1->setDbValue($row['two_benefit_amount1']);
        $this->two_benefit_amount2->setDbValue($row['two_benefit_amount2']);
        $this->management_agent_date->setDbValue($row['management_agent_date']);
        $this->begin_date->setDbValue($row['begin_date']);
        $this->investor_witness_name->setDbValue($row['investor_witness_name']);
        $this->investor_witness_lname->setDbValue($row['investor_witness_lname']);
        $this->investor_witness_email->setDbValue($row['investor_witness_email']);
        $this->juzmatch_authority_name->setDbValue($row['juzmatch_authority_name']);
        $this->juzmatch_authority_lname->setDbValue($row['juzmatch_authority_lname']);
        $this->juzmatch_authority_email->setDbValue($row['juzmatch_authority_email']);
        $this->juzmatch_authority_witness_name->setDbValue($row['juzmatch_authority_witness_name']);
        $this->juzmatch_authority_witness_lname->setDbValue($row['juzmatch_authority_witness_lname']);
        $this->juzmatch_authority_witness_email->setDbValue($row['juzmatch_authority_witness_email']);
        $this->juzmatch_authority2_name->setDbValue($row['juzmatch_authority2_name']);
        $this->juzmatch_authority2_lname->setDbValue($row['juzmatch_authority2_lname']);
        $this->juzmatch_authority2_email->setDbValue($row['juzmatch_authority2_email']);
        $this->company_seal_name->setDbValue($row['company_seal_name']);
        $this->company_seal_email->setDbValue($row['company_seal_email']);
        $this->file_idcard->Upload->DbValue = $row['file_idcard'];
        $this->file_house_regis->Upload->DbValue = $row['file_house_regis'];
        $this->file_other->Upload->DbValue = $row['file_other'];
        $this->contact_address->setDbValue($row['contact_address']);
        $this->contact_address2->setDbValue($row['contact_address2']);
        $this->contact_email->setDbValue($row['contact_email']);
        $this->contact_lineid->setDbValue($row['contact_lineid']);
        $this->contact_phone->setDbValue($row['contact_phone']);
        $this->file_loan->setDbValue($row['file_loan']);
        $this->attach_file->setDbValue($row['attach_file']);
        $this->status->setDbValue($row['status']);
        $this->doc_creden_id->setDbValue($row['doc_creden_id']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->doc_date->setDbValue($row['doc_date']);
        $this->investor_booking_id->setDbValue($row['investor_booking_id']);
        $this->first_down->setDbValue($row['first_down']);
        $this->first_down_txt->setDbValue($row['first_down_txt']);
        $this->second_down->setDbValue($row['second_down']);
        $this->second_down_txt->setDbValue($row['second_down_txt']);
        $this->service_price->setDbValue($row['service_price']);
        $this->service_price_txt->setDbValue($row['service_price_txt']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id
        $this->id->CellCssStyle = "white-space: nowrap;";

        // document_date

        // asset_code

        // asset_project

        // asset_deed

        // asset_area

        // investor_name

        // investor_lname

        // investor_email

        // investor_idcard

        // investor_homeno

        // investment_money

        // investment_money_txt

        // loan_contact_date

        // contract_expired

        // first_benefits_month

        // one_installment_amount

        // two_installment_amount1

        // two_installment_amount2

        // investor_paid_amount

        // first_benefits_date

        // one_benefit_amount

        // two_benefit_amount1

        // two_benefit_amount2

        // management_agent_date

        // begin_date

        // investor_witness_name

        // investor_witness_lname

        // investor_witness_email

        // juzmatch_authority_name

        // juzmatch_authority_lname

        // juzmatch_authority_email

        // juzmatch_authority_witness_name

        // juzmatch_authority_witness_lname

        // juzmatch_authority_witness_email

        // juzmatch_authority2_name

        // juzmatch_authority2_lname

        // juzmatch_authority2_email

        // company_seal_name

        // company_seal_email

        // file_idcard

        // file_house_regis

        // file_other

        // contact_address

        // contact_address2

        // contact_email

        // contact_lineid

        // contact_phone

        // file_loan

        // attach_file

        // status

        // doc_creden_id
        $this->doc_creden_id->CellCssStyle = "white-space: nowrap;";

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // doc_date
        $this->doc_date->CellCssStyle = "white-space: nowrap;";

        // investor_booking_id
        $this->investor_booking_id->CellCssStyle = "white-space: nowrap;";

        // first_down
        $this->first_down->CellCssStyle = "white-space: nowrap;";

        // first_down_txt
        $this->first_down_txt->CellCssStyle = "white-space: nowrap;";

        // second_down
        $this->second_down->CellCssStyle = "white-space: nowrap;";

        // second_down_txt
        $this->second_down_txt->CellCssStyle = "white-space: nowrap;";

        // service_price
        $this->service_price->CellCssStyle = "white-space: nowrap;";

        // service_price_txt
        $this->service_price_txt->CellCssStyle = "white-space: nowrap;";

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // document_date
        $this->document_date->ViewValue = $this->document_date->CurrentValue;
        $this->document_date->ViewValue = FormatDateTime($this->document_date->ViewValue, $this->document_date->formatPattern());
        $this->document_date->ViewCustomAttributes = "";

        // asset_code
        $this->asset_code->ViewValue = $this->asset_code->CurrentValue;
        $this->asset_code->ViewCustomAttributes = "";

        // asset_project
        $this->asset_project->ViewValue = $this->asset_project->CurrentValue;
        $this->asset_project->ViewCustomAttributes = "";

        // asset_deed
        $this->asset_deed->ViewValue = $this->asset_deed->CurrentValue;
        $this->asset_deed->ViewCustomAttributes = "";

        // asset_area
        $this->asset_area->ViewValue = $this->asset_area->CurrentValue;
        $this->asset_area->ViewCustomAttributes = "";

        // investor_name
        $this->investor_name->ViewValue = $this->investor_name->CurrentValue;
        $this->investor_name->ViewCustomAttributes = "";

        // investor_lname
        $this->investor_lname->ViewValue = $this->investor_lname->CurrentValue;
        $this->investor_lname->ViewCustomAttributes = "";

        // investor_email
        $this->investor_email->ViewValue = $this->investor_email->CurrentValue;
        $this->investor_email->ViewCustomAttributes = "";

        // investor_idcard
        $this->investor_idcard->ViewValue = $this->investor_idcard->CurrentValue;
        $this->investor_idcard->ViewCustomAttributes = "";

        // investor_homeno
        $this->investor_homeno->ViewValue = $this->investor_homeno->CurrentValue;
        $this->investor_homeno->ViewCustomAttributes = "";

        // investment_money
        $this->investment_money->ViewValue = $this->investment_money->CurrentValue;
        $this->investment_money->ViewValue = FormatNumber($this->investment_money->ViewValue, $this->investment_money->formatPattern());
        $this->investment_money->ViewCustomAttributes = "";

        // investment_money_txt
        $this->investment_money_txt->ViewValue = $this->investment_money_txt->CurrentValue;
        $this->investment_money_txt->ViewCustomAttributes = "";

        // loan_contact_date
        $this->loan_contact_date->ViewValue = $this->loan_contact_date->CurrentValue;
        $this->loan_contact_date->ViewValue = FormatDateTime($this->loan_contact_date->ViewValue, $this->loan_contact_date->formatPattern());
        $this->loan_contact_date->ViewCustomAttributes = "";

        // contract_expired
        $this->contract_expired->ViewValue = $this->contract_expired->CurrentValue;
        $this->contract_expired->ViewValue = FormatDateTime($this->contract_expired->ViewValue, $this->contract_expired->formatPattern());
        $this->contract_expired->ViewCustomAttributes = "";

        // first_benefits_month
        $this->first_benefits_month->ViewValue = $this->first_benefits_month->CurrentValue;
        $this->first_benefits_month->ViewValue = FormatNumber($this->first_benefits_month->ViewValue, $this->first_benefits_month->formatPattern());
        $this->first_benefits_month->ViewCustomAttributes = "";

        // one_installment_amount
        $this->one_installment_amount->ViewValue = $this->one_installment_amount->CurrentValue;
        $this->one_installment_amount->ViewValue = FormatNumber($this->one_installment_amount->ViewValue, $this->one_installment_amount->formatPattern());
        $this->one_installment_amount->ViewCustomAttributes = "";

        // two_installment_amount1
        $this->two_installment_amount1->ViewValue = $this->two_installment_amount1->CurrentValue;
        $this->two_installment_amount1->ViewValue = FormatNumber($this->two_installment_amount1->ViewValue, $this->two_installment_amount1->formatPattern());
        $this->two_installment_amount1->ViewCustomAttributes = "";

        // two_installment_amount2
        $this->two_installment_amount2->ViewValue = $this->two_installment_amount2->CurrentValue;
        $this->two_installment_amount2->ViewValue = FormatNumber($this->two_installment_amount2->ViewValue, $this->two_installment_amount2->formatPattern());
        $this->two_installment_amount2->ViewCustomAttributes = "";

        // investor_paid_amount
        $this->investor_paid_amount->ViewValue = $this->investor_paid_amount->CurrentValue;
        $this->investor_paid_amount->ViewValue = FormatNumber($this->investor_paid_amount->ViewValue, $this->investor_paid_amount->formatPattern());
        $this->investor_paid_amount->ViewCustomAttributes = "";

        // first_benefits_date
        $this->first_benefits_date->ViewValue = $this->first_benefits_date->CurrentValue;
        $this->first_benefits_date->ViewValue = FormatDateTime($this->first_benefits_date->ViewValue, $this->first_benefits_date->formatPattern());
        $this->first_benefits_date->ViewCustomAttributes = "";

        // one_benefit_amount
        $this->one_benefit_amount->ViewValue = $this->one_benefit_amount->CurrentValue;
        $this->one_benefit_amount->ViewValue = FormatNumber($this->one_benefit_amount->ViewValue, $this->one_benefit_amount->formatPattern());
        $this->one_benefit_amount->ViewCustomAttributes = "";

        // two_benefit_amount1
        $this->two_benefit_amount1->ViewValue = $this->two_benefit_amount1->CurrentValue;
        $this->two_benefit_amount1->ViewValue = FormatNumber($this->two_benefit_amount1->ViewValue, $this->two_benefit_amount1->formatPattern());
        $this->two_benefit_amount1->ViewCustomAttributes = "";

        // two_benefit_amount2
        $this->two_benefit_amount2->ViewValue = $this->two_benefit_amount2->CurrentValue;
        $this->two_benefit_amount2->ViewValue = FormatNumber($this->two_benefit_amount2->ViewValue, $this->two_benefit_amount2->formatPattern());
        $this->two_benefit_amount2->ViewCustomAttributes = "";

        // management_agent_date
        $this->management_agent_date->ViewValue = $this->management_agent_date->CurrentValue;
        $this->management_agent_date->ViewValue = FormatDateTime($this->management_agent_date->ViewValue, $this->management_agent_date->formatPattern());
        $this->management_agent_date->ViewCustomAttributes = "";

        // begin_date
        $this->begin_date->ViewValue = $this->begin_date->CurrentValue;
        $this->begin_date->ViewValue = FormatNumber($this->begin_date->ViewValue, $this->begin_date->formatPattern());
        $this->begin_date->ViewCustomAttributes = "";

        // investor_witness_name
        $this->investor_witness_name->ViewValue = $this->investor_witness_name->CurrentValue;
        $this->investor_witness_name->ViewCustomAttributes = "";

        // investor_witness_lname
        $this->investor_witness_lname->ViewValue = $this->investor_witness_lname->CurrentValue;
        $this->investor_witness_lname->ViewCustomAttributes = "";

        // investor_witness_email
        $this->investor_witness_email->ViewValue = $this->investor_witness_email->CurrentValue;
        $this->investor_witness_email->ViewCustomAttributes = "";

        // juzmatch_authority_name
        $this->juzmatch_authority_name->ViewValue = $this->juzmatch_authority_name->CurrentValue;
        $this->juzmatch_authority_name->ViewCustomAttributes = "";

        // juzmatch_authority_lname
        $this->juzmatch_authority_lname->ViewValue = $this->juzmatch_authority_lname->CurrentValue;
        $this->juzmatch_authority_lname->ViewCustomAttributes = "";

        // juzmatch_authority_email
        $this->juzmatch_authority_email->ViewValue = $this->juzmatch_authority_email->CurrentValue;
        $this->juzmatch_authority_email->ViewCustomAttributes = "";

        // juzmatch_authority_witness_name
        $this->juzmatch_authority_witness_name->ViewValue = $this->juzmatch_authority_witness_name->CurrentValue;
        $this->juzmatch_authority_witness_name->ViewCustomAttributes = "";

        // juzmatch_authority_witness_lname
        $this->juzmatch_authority_witness_lname->ViewValue = $this->juzmatch_authority_witness_lname->CurrentValue;
        $this->juzmatch_authority_witness_lname->ViewCustomAttributes = "";

        // juzmatch_authority_witness_email
        $this->juzmatch_authority_witness_email->ViewValue = $this->juzmatch_authority_witness_email->CurrentValue;
        $this->juzmatch_authority_witness_email->ViewCustomAttributes = "";

        // juzmatch_authority2_name
        $this->juzmatch_authority2_name->ViewValue = $this->juzmatch_authority2_name->CurrentValue;
        $this->juzmatch_authority2_name->ViewCustomAttributes = "";

        // juzmatch_authority2_lname
        $this->juzmatch_authority2_lname->ViewValue = $this->juzmatch_authority2_lname->CurrentValue;
        $this->juzmatch_authority2_lname->ViewCustomAttributes = "";

        // juzmatch_authority2_email
        $this->juzmatch_authority2_email->ViewValue = $this->juzmatch_authority2_email->CurrentValue;
        $this->juzmatch_authority2_email->ViewCustomAttributes = "";

        // company_seal_name
        $this->company_seal_name->ViewValue = $this->company_seal_name->CurrentValue;
        $this->company_seal_name->ViewCustomAttributes = "";

        // company_seal_email
        $this->company_seal_email->ViewValue = $this->company_seal_email->CurrentValue;
        $this->company_seal_email->ViewCustomAttributes = "";

        // file_idcard
        $this->file_idcard->UploadPath = "/upload/";
        if (!EmptyValue($this->file_idcard->Upload->DbValue)) {
            $this->file_idcard->ViewValue = $this->file_idcard->Upload->DbValue;
        } else {
            $this->file_idcard->ViewValue = "";
        }
        $this->file_idcard->ViewCustomAttributes = "";

        // file_house_regis
        $this->file_house_regis->UploadPath = "/upload/";
        if (!EmptyValue($this->file_house_regis->Upload->DbValue)) {
            $this->file_house_regis->ViewValue = $this->file_house_regis->Upload->DbValue;
        } else {
            $this->file_house_regis->ViewValue = "";
        }
        $this->file_house_regis->ViewCustomAttributes = "";

        // file_other
        $this->file_other->UploadPath = "/upload/";
        if (!EmptyValue($this->file_other->Upload->DbValue)) {
            $this->file_other->ViewValue = $this->file_other->Upload->DbValue;
        } else {
            $this->file_other->ViewValue = "";
        }
        $this->file_other->ViewCustomAttributes = "";

        // contact_address
        $this->contact_address->ViewValue = $this->contact_address->CurrentValue;
        $this->contact_address->ViewCustomAttributes = "";

        // contact_address2
        $this->contact_address2->ViewValue = $this->contact_address2->CurrentValue;
        $this->contact_address2->ViewCustomAttributes = "";

        // contact_email
        $this->contact_email->ViewValue = $this->contact_email->CurrentValue;
        $this->contact_email->ViewCustomAttributes = "";

        // contact_lineid
        $this->contact_lineid->ViewValue = $this->contact_lineid->CurrentValue;
        $this->contact_lineid->ViewCustomAttributes = "";

        // contact_phone
        $this->contact_phone->ViewValue = $this->contact_phone->CurrentValue;
        $this->contact_phone->ViewCustomAttributes = "";

        // file_loan
        $this->file_loan->ViewValue = $this->file_loan->CurrentValue;
        $this->file_loan->ViewCustomAttributes = "";

        // attach_file
        $this->attach_file->ViewValue = $this->attach_file->CurrentValue;
        $this->attach_file->ViewCustomAttributes = "";

        // status
        if (strval($this->status->CurrentValue) != "") {
            $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
        } else {
            $this->status->ViewValue = null;
        }
        $this->status->ViewCustomAttributes = "";

        // doc_creden_id
        $this->doc_creden_id->ViewValue = $this->doc_creden_id->CurrentValue;
        $this->doc_creden_id->ViewValue = FormatNumber($this->doc_creden_id->ViewValue, $this->doc_creden_id->formatPattern());
        $this->doc_creden_id->ViewCustomAttributes = "";

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

        // udate
        $this->udate->ViewValue = $this->udate->CurrentValue;
        $this->udate->ViewValue = FormatDateTime($this->udate->ViewValue, $this->udate->formatPattern());
        $this->udate->ViewCustomAttributes = "";

        // uuser
        $this->uuser->ViewValue = $this->uuser->CurrentValue;
        $this->uuser->ViewValue = FormatNumber($this->uuser->ViewValue, $this->uuser->formatPattern());
        $this->uuser->ViewCustomAttributes = "";

        // uip
        $this->uip->ViewValue = $this->uip->CurrentValue;
        $this->uip->ViewCustomAttributes = "";

        // doc_date
        $this->doc_date->ViewValue = $this->doc_date->CurrentValue;
        $this->doc_date->ViewValue = FormatDateTime($this->doc_date->ViewValue, $this->doc_date->formatPattern());
        $this->doc_date->ViewCustomAttributes = "";

        // investor_booking_id
        $this->investor_booking_id->ViewValue = $this->investor_booking_id->CurrentValue;
        $this->investor_booking_id->ViewValue = FormatNumber($this->investor_booking_id->ViewValue, $this->investor_booking_id->formatPattern());
        $this->investor_booking_id->ViewCustomAttributes = "";

        // first_down
        $this->first_down->ViewValue = $this->first_down->CurrentValue;
        $this->first_down->ViewValue = FormatNumber($this->first_down->ViewValue, $this->first_down->formatPattern());
        $this->first_down->ViewCustomAttributes = "";

        // first_down_txt
        $this->first_down_txt->ViewValue = $this->first_down_txt->CurrentValue;
        $this->first_down_txt->ViewCustomAttributes = "";

        // second_down
        $this->second_down->ViewValue = $this->second_down->CurrentValue;
        $this->second_down->ViewValue = FormatNumber($this->second_down->ViewValue, $this->second_down->formatPattern());
        $this->second_down->ViewCustomAttributes = "";

        // second_down_txt
        $this->second_down_txt->ViewValue = $this->second_down_txt->CurrentValue;
        $this->second_down_txt->ViewCustomAttributes = "";

        // service_price
        $this->service_price->ViewValue = $this->service_price->CurrentValue;
        $this->service_price->ViewValue = FormatNumber($this->service_price->ViewValue, $this->service_price->formatPattern());
        $this->service_price->ViewCustomAttributes = "";

        // service_price_txt
        $this->service_price_txt->ViewValue = $this->service_price_txt->CurrentValue;
        $this->service_price_txt->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // document_date
        $this->document_date->LinkCustomAttributes = "";
        $this->document_date->HrefValue = "";
        $this->document_date->TooltipValue = "";

        // asset_code
        $this->asset_code->LinkCustomAttributes = "";
        $this->asset_code->HrefValue = "";
        $this->asset_code->TooltipValue = "";

        // asset_project
        $this->asset_project->LinkCustomAttributes = "";
        $this->asset_project->HrefValue = "";
        $this->asset_project->TooltipValue = "";

        // asset_deed
        $this->asset_deed->LinkCustomAttributes = "";
        $this->asset_deed->HrefValue = "";
        $this->asset_deed->TooltipValue = "";

        // asset_area
        $this->asset_area->LinkCustomAttributes = "";
        $this->asset_area->HrefValue = "";
        $this->asset_area->TooltipValue = "";

        // investor_name
        $this->investor_name->LinkCustomAttributes = "";
        $this->investor_name->HrefValue = "";
        $this->investor_name->TooltipValue = "";

        // investor_lname
        $this->investor_lname->LinkCustomAttributes = "";
        $this->investor_lname->HrefValue = "";
        $this->investor_lname->TooltipValue = "";

        // investor_email
        $this->investor_email->LinkCustomAttributes = "";
        $this->investor_email->HrefValue = "";
        $this->investor_email->TooltipValue = "";

        // investor_idcard
        $this->investor_idcard->LinkCustomAttributes = "";
        $this->investor_idcard->HrefValue = "";
        $this->investor_idcard->TooltipValue = "";

        // investor_homeno
        $this->investor_homeno->LinkCustomAttributes = "";
        $this->investor_homeno->HrefValue = "";
        $this->investor_homeno->TooltipValue = "";

        // investment_money
        $this->investment_money->LinkCustomAttributes = "";
        $this->investment_money->HrefValue = "";
        $this->investment_money->TooltipValue = "";

        // investment_money_txt
        $this->investment_money_txt->LinkCustomAttributes = "";
        $this->investment_money_txt->HrefValue = "";
        $this->investment_money_txt->TooltipValue = "";

        // loan_contact_date
        $this->loan_contact_date->LinkCustomAttributes = "";
        $this->loan_contact_date->HrefValue = "";
        $this->loan_contact_date->TooltipValue = "";

        // contract_expired
        $this->contract_expired->LinkCustomAttributes = "";
        $this->contract_expired->HrefValue = "";
        $this->contract_expired->TooltipValue = "";

        // first_benefits_month
        $this->first_benefits_month->LinkCustomAttributes = "";
        $this->first_benefits_month->HrefValue = "";
        $this->first_benefits_month->TooltipValue = "";

        // one_installment_amount
        $this->one_installment_amount->LinkCustomAttributes = "";
        $this->one_installment_amount->HrefValue = "";
        $this->one_installment_amount->TooltipValue = "";

        // two_installment_amount1
        $this->two_installment_amount1->LinkCustomAttributes = "";
        $this->two_installment_amount1->HrefValue = "";
        $this->two_installment_amount1->TooltipValue = "";

        // two_installment_amount2
        $this->two_installment_amount2->LinkCustomAttributes = "";
        $this->two_installment_amount2->HrefValue = "";
        $this->two_installment_amount2->TooltipValue = "";

        // investor_paid_amount
        $this->investor_paid_amount->LinkCustomAttributes = "";
        $this->investor_paid_amount->HrefValue = "";
        $this->investor_paid_amount->TooltipValue = "";

        // first_benefits_date
        $this->first_benefits_date->LinkCustomAttributes = "";
        $this->first_benefits_date->HrefValue = "";
        $this->first_benefits_date->TooltipValue = "";

        // one_benefit_amount
        $this->one_benefit_amount->LinkCustomAttributes = "";
        $this->one_benefit_amount->HrefValue = "";
        $this->one_benefit_amount->TooltipValue = "";

        // two_benefit_amount1
        $this->two_benefit_amount1->LinkCustomAttributes = "";
        $this->two_benefit_amount1->HrefValue = "";
        $this->two_benefit_amount1->TooltipValue = "";

        // two_benefit_amount2
        $this->two_benefit_amount2->LinkCustomAttributes = "";
        $this->two_benefit_amount2->HrefValue = "";
        $this->two_benefit_amount2->TooltipValue = "";

        // management_agent_date
        $this->management_agent_date->LinkCustomAttributes = "";
        $this->management_agent_date->HrefValue = "";
        $this->management_agent_date->TooltipValue = "";

        // begin_date
        $this->begin_date->LinkCustomAttributes = "";
        $this->begin_date->HrefValue = "";
        $this->begin_date->TooltipValue = "";

        // investor_witness_name
        $this->investor_witness_name->LinkCustomAttributes = "";
        $this->investor_witness_name->HrefValue = "";
        $this->investor_witness_name->TooltipValue = "";

        // investor_witness_lname
        $this->investor_witness_lname->LinkCustomAttributes = "";
        $this->investor_witness_lname->HrefValue = "";
        $this->investor_witness_lname->TooltipValue = "";

        // investor_witness_email
        $this->investor_witness_email->LinkCustomAttributes = "";
        $this->investor_witness_email->HrefValue = "";
        $this->investor_witness_email->TooltipValue = "";

        // juzmatch_authority_name
        $this->juzmatch_authority_name->LinkCustomAttributes = "";
        $this->juzmatch_authority_name->HrefValue = "";
        $this->juzmatch_authority_name->TooltipValue = "";

        // juzmatch_authority_lname
        $this->juzmatch_authority_lname->LinkCustomAttributes = "";
        $this->juzmatch_authority_lname->HrefValue = "";
        $this->juzmatch_authority_lname->TooltipValue = "";

        // juzmatch_authority_email
        $this->juzmatch_authority_email->LinkCustomAttributes = "";
        $this->juzmatch_authority_email->HrefValue = "";
        $this->juzmatch_authority_email->TooltipValue = "";

        // juzmatch_authority_witness_name
        $this->juzmatch_authority_witness_name->LinkCustomAttributes = "";
        $this->juzmatch_authority_witness_name->HrefValue = "";
        $this->juzmatch_authority_witness_name->TooltipValue = "";

        // juzmatch_authority_witness_lname
        $this->juzmatch_authority_witness_lname->LinkCustomAttributes = "";
        $this->juzmatch_authority_witness_lname->HrefValue = "";
        $this->juzmatch_authority_witness_lname->TooltipValue = "";

        // juzmatch_authority_witness_email
        $this->juzmatch_authority_witness_email->LinkCustomAttributes = "";
        $this->juzmatch_authority_witness_email->HrefValue = "";
        $this->juzmatch_authority_witness_email->TooltipValue = "";

        // juzmatch_authority2_name
        $this->juzmatch_authority2_name->LinkCustomAttributes = "";
        $this->juzmatch_authority2_name->HrefValue = "";
        $this->juzmatch_authority2_name->TooltipValue = "";

        // juzmatch_authority2_lname
        $this->juzmatch_authority2_lname->LinkCustomAttributes = "";
        $this->juzmatch_authority2_lname->HrefValue = "";
        $this->juzmatch_authority2_lname->TooltipValue = "";

        // juzmatch_authority2_email
        $this->juzmatch_authority2_email->LinkCustomAttributes = "";
        $this->juzmatch_authority2_email->HrefValue = "";
        $this->juzmatch_authority2_email->TooltipValue = "";

        // company_seal_name
        $this->company_seal_name->LinkCustomAttributes = "";
        $this->company_seal_name->HrefValue = "";
        $this->company_seal_name->TooltipValue = "";

        // company_seal_email
        $this->company_seal_email->LinkCustomAttributes = "";
        $this->company_seal_email->HrefValue = "";
        $this->company_seal_email->TooltipValue = "";

        // file_idcard
        $this->file_idcard->LinkCustomAttributes = "";
        $this->file_idcard->HrefValue = "";
        $this->file_idcard->ExportHrefValue = $this->file_idcard->UploadPath . $this->file_idcard->Upload->DbValue;
        $this->file_idcard->TooltipValue = "";

        // file_house_regis
        $this->file_house_regis->LinkCustomAttributes = "";
        $this->file_house_regis->HrefValue = "";
        $this->file_house_regis->ExportHrefValue = $this->file_house_regis->UploadPath . $this->file_house_regis->Upload->DbValue;
        $this->file_house_regis->TooltipValue = "";

        // file_other
        $this->file_other->LinkCustomAttributes = "";
        $this->file_other->HrefValue = "";
        $this->file_other->ExportHrefValue = $this->file_other->UploadPath . $this->file_other->Upload->DbValue;
        $this->file_other->TooltipValue = "";

        // contact_address
        $this->contact_address->LinkCustomAttributes = "";
        $this->contact_address->HrefValue = "";
        $this->contact_address->TooltipValue = "";

        // contact_address2
        $this->contact_address2->LinkCustomAttributes = "";
        $this->contact_address2->HrefValue = "";
        $this->contact_address2->TooltipValue = "";

        // contact_email
        $this->contact_email->LinkCustomAttributes = "";
        $this->contact_email->HrefValue = "";
        $this->contact_email->TooltipValue = "";

        // contact_lineid
        $this->contact_lineid->LinkCustomAttributes = "";
        $this->contact_lineid->HrefValue = "";
        $this->contact_lineid->TooltipValue = "";

        // contact_phone
        $this->contact_phone->LinkCustomAttributes = "";
        $this->contact_phone->HrefValue = "";
        $this->contact_phone->TooltipValue = "";

        // file_loan
        $this->file_loan->LinkCustomAttributes = "";
        $this->file_loan->HrefValue = "";
        $this->file_loan->TooltipValue = "";

        // attach_file
        $this->attach_file->LinkCustomAttributes = "";
        $this->attach_file->HrefValue = "";
        $this->attach_file->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // doc_creden_id
        $this->doc_creden_id->LinkCustomAttributes = "";
        $this->doc_creden_id->HrefValue = "";
        $this->doc_creden_id->TooltipValue = "";

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

        // udate
        $this->udate->LinkCustomAttributes = "";
        $this->udate->HrefValue = "";
        $this->udate->TooltipValue = "";

        // uuser
        $this->uuser->LinkCustomAttributes = "";
        $this->uuser->HrefValue = "";
        $this->uuser->TooltipValue = "";

        // uip
        $this->uip->LinkCustomAttributes = "";
        $this->uip->HrefValue = "";
        $this->uip->TooltipValue = "";

        // doc_date
        $this->doc_date->LinkCustomAttributes = "";
        $this->doc_date->HrefValue = "";
        $this->doc_date->TooltipValue = "";

        // investor_booking_id
        $this->investor_booking_id->LinkCustomAttributes = "";
        $this->investor_booking_id->HrefValue = "";
        $this->investor_booking_id->TooltipValue = "";

        // first_down
        $this->first_down->LinkCustomAttributes = "";
        $this->first_down->HrefValue = "";
        $this->first_down->TooltipValue = "";

        // first_down_txt
        $this->first_down_txt->LinkCustomAttributes = "";
        $this->first_down_txt->HrefValue = "";
        $this->first_down_txt->TooltipValue = "";

        // second_down
        $this->second_down->LinkCustomAttributes = "";
        $this->second_down->HrefValue = "";
        $this->second_down->TooltipValue = "";

        // second_down_txt
        $this->second_down_txt->LinkCustomAttributes = "";
        $this->second_down_txt->HrefValue = "";
        $this->second_down_txt->TooltipValue = "";

        // service_price
        $this->service_price->LinkCustomAttributes = "";
        $this->service_price->HrefValue = "";
        $this->service_price->TooltipValue = "";

        // service_price_txt
        $this->service_price_txt->LinkCustomAttributes = "";
        $this->service_price_txt->HrefValue = "";
        $this->service_price_txt->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // id
        $this->id->setupEditAttributes();
        $this->id->EditCustomAttributes = "";
        $this->id->EditValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // document_date

        // asset_code
        $this->asset_code->setupEditAttributes();
        $this->asset_code->EditCustomAttributes = "";
        if (!$this->asset_code->Raw) {
            $this->asset_code->CurrentValue = HtmlDecode($this->asset_code->CurrentValue);
        }
        $this->asset_code->EditValue = $this->asset_code->CurrentValue;
        $this->asset_code->PlaceHolder = RemoveHtml($this->asset_code->caption());

        // asset_project
        $this->asset_project->setupEditAttributes();
        $this->asset_project->EditCustomAttributes = "";
        if (!$this->asset_project->Raw) {
            $this->asset_project->CurrentValue = HtmlDecode($this->asset_project->CurrentValue);
        }
        $this->asset_project->EditValue = $this->asset_project->CurrentValue;
        $this->asset_project->PlaceHolder = RemoveHtml($this->asset_project->caption());

        // asset_deed
        $this->asset_deed->setupEditAttributes();
        $this->asset_deed->EditCustomAttributes = "";
        if (!$this->asset_deed->Raw) {
            $this->asset_deed->CurrentValue = HtmlDecode($this->asset_deed->CurrentValue);
        }
        $this->asset_deed->EditValue = $this->asset_deed->CurrentValue;
        $this->asset_deed->PlaceHolder = RemoveHtml($this->asset_deed->caption());

        // asset_area
        $this->asset_area->setupEditAttributes();
        $this->asset_area->EditCustomAttributes = "";
        if (!$this->asset_area->Raw) {
            $this->asset_area->CurrentValue = HtmlDecode($this->asset_area->CurrentValue);
        }
        $this->asset_area->EditValue = $this->asset_area->CurrentValue;
        $this->asset_area->PlaceHolder = RemoveHtml($this->asset_area->caption());

        // investor_name
        $this->investor_name->setupEditAttributes();
        $this->investor_name->EditCustomAttributes = "";
        if (!$this->investor_name->Raw) {
            $this->investor_name->CurrentValue = HtmlDecode($this->investor_name->CurrentValue);
        }
        $this->investor_name->EditValue = $this->investor_name->CurrentValue;
        $this->investor_name->PlaceHolder = RemoveHtml($this->investor_name->caption());

        // investor_lname
        $this->investor_lname->setupEditAttributes();
        $this->investor_lname->EditCustomAttributes = "";
        if (!$this->investor_lname->Raw) {
            $this->investor_lname->CurrentValue = HtmlDecode($this->investor_lname->CurrentValue);
        }
        $this->investor_lname->EditValue = $this->investor_lname->CurrentValue;
        $this->investor_lname->PlaceHolder = RemoveHtml($this->investor_lname->caption());

        // investor_email
        $this->investor_email->setupEditAttributes();
        $this->investor_email->EditCustomAttributes = "";
        if (!$this->investor_email->Raw) {
            $this->investor_email->CurrentValue = HtmlDecode($this->investor_email->CurrentValue);
        }
        $this->investor_email->EditValue = $this->investor_email->CurrentValue;
        $this->investor_email->PlaceHolder = RemoveHtml($this->investor_email->caption());

        // investor_idcard
        $this->investor_idcard->setupEditAttributes();
        $this->investor_idcard->EditCustomAttributes = "";
        if (!$this->investor_idcard->Raw) {
            $this->investor_idcard->CurrentValue = HtmlDecode($this->investor_idcard->CurrentValue);
        }
        $this->investor_idcard->EditValue = $this->investor_idcard->CurrentValue;
        $this->investor_idcard->PlaceHolder = RemoveHtml($this->investor_idcard->caption());

        // investor_homeno
        $this->investor_homeno->setupEditAttributes();
        $this->investor_homeno->EditCustomAttributes = "";
        if (!$this->investor_homeno->Raw) {
            $this->investor_homeno->CurrentValue = HtmlDecode($this->investor_homeno->CurrentValue);
        }
        $this->investor_homeno->EditValue = $this->investor_homeno->CurrentValue;
        $this->investor_homeno->PlaceHolder = RemoveHtml($this->investor_homeno->caption());

        // investment_money
        $this->investment_money->setupEditAttributes();
        $this->investment_money->EditCustomAttributes = "";
        $this->investment_money->EditValue = $this->investment_money->CurrentValue;
        $this->investment_money->PlaceHolder = RemoveHtml($this->investment_money->caption());
        if (strval($this->investment_money->EditValue) != "" && is_numeric($this->investment_money->EditValue)) {
            $this->investment_money->EditValue = FormatNumber($this->investment_money->EditValue, null);
        }

        // investment_money_txt
        $this->investment_money_txt->setupEditAttributes();
        $this->investment_money_txt->EditCustomAttributes = "";
        if (!$this->investment_money_txt->Raw) {
            $this->investment_money_txt->CurrentValue = HtmlDecode($this->investment_money_txt->CurrentValue);
        }
        $this->investment_money_txt->EditValue = $this->investment_money_txt->CurrentValue;
        $this->investment_money_txt->PlaceHolder = RemoveHtml($this->investment_money_txt->caption());

        // loan_contact_date
        $this->loan_contact_date->setupEditAttributes();
        $this->loan_contact_date->EditCustomAttributes = "";
        $this->loan_contact_date->EditValue = FormatDateTime($this->loan_contact_date->CurrentValue, $this->loan_contact_date->formatPattern());
        $this->loan_contact_date->PlaceHolder = RemoveHtml($this->loan_contact_date->caption());

        // contract_expired
        $this->contract_expired->setupEditAttributes();
        $this->contract_expired->EditCustomAttributes = "";
        $this->contract_expired->EditValue = FormatDateTime($this->contract_expired->CurrentValue, $this->contract_expired->formatPattern());
        $this->contract_expired->PlaceHolder = RemoveHtml($this->contract_expired->caption());

        // first_benefits_month
        $this->first_benefits_month->setupEditAttributes();
        $this->first_benefits_month->EditCustomAttributes = "";
        $this->first_benefits_month->EditValue = $this->first_benefits_month->CurrentValue;
        $this->first_benefits_month->PlaceHolder = RemoveHtml($this->first_benefits_month->caption());
        if (strval($this->first_benefits_month->EditValue) != "" && is_numeric($this->first_benefits_month->EditValue)) {
            $this->first_benefits_month->EditValue = FormatNumber($this->first_benefits_month->EditValue, null);
        }

        // one_installment_amount
        $this->one_installment_amount->setupEditAttributes();
        $this->one_installment_amount->EditCustomAttributes = "";
        $this->one_installment_amount->EditValue = $this->one_installment_amount->CurrentValue;
        $this->one_installment_amount->PlaceHolder = RemoveHtml($this->one_installment_amount->caption());
        if (strval($this->one_installment_amount->EditValue) != "" && is_numeric($this->one_installment_amount->EditValue)) {
            $this->one_installment_amount->EditValue = FormatNumber($this->one_installment_amount->EditValue, null);
        }

        // two_installment_amount1
        $this->two_installment_amount1->setupEditAttributes();
        $this->two_installment_amount1->EditCustomAttributes = "";
        $this->two_installment_amount1->EditValue = $this->two_installment_amount1->CurrentValue;
        $this->two_installment_amount1->PlaceHolder = RemoveHtml($this->two_installment_amount1->caption());
        if (strval($this->two_installment_amount1->EditValue) != "" && is_numeric($this->two_installment_amount1->EditValue)) {
            $this->two_installment_amount1->EditValue = FormatNumber($this->two_installment_amount1->EditValue, null);
        }

        // two_installment_amount2
        $this->two_installment_amount2->setupEditAttributes();
        $this->two_installment_amount2->EditCustomAttributes = "";
        $this->two_installment_amount2->EditValue = $this->two_installment_amount2->CurrentValue;
        $this->two_installment_amount2->PlaceHolder = RemoveHtml($this->two_installment_amount2->caption());
        if (strval($this->two_installment_amount2->EditValue) != "" && is_numeric($this->two_installment_amount2->EditValue)) {
            $this->two_installment_amount2->EditValue = FormatNumber($this->two_installment_amount2->EditValue, null);
        }

        // investor_paid_amount
        $this->investor_paid_amount->setupEditAttributes();
        $this->investor_paid_amount->EditCustomAttributes = "";
        $this->investor_paid_amount->EditValue = $this->investor_paid_amount->CurrentValue;
        $this->investor_paid_amount->PlaceHolder = RemoveHtml($this->investor_paid_amount->caption());
        if (strval($this->investor_paid_amount->EditValue) != "" && is_numeric($this->investor_paid_amount->EditValue)) {
            $this->investor_paid_amount->EditValue = FormatNumber($this->investor_paid_amount->EditValue, null);
        }

        // first_benefits_date
        $this->first_benefits_date->setupEditAttributes();
        $this->first_benefits_date->EditCustomAttributes = "";
        $this->first_benefits_date->EditValue = FormatDateTime($this->first_benefits_date->CurrentValue, $this->first_benefits_date->formatPattern());
        $this->first_benefits_date->PlaceHolder = RemoveHtml($this->first_benefits_date->caption());

        // one_benefit_amount
        $this->one_benefit_amount->setupEditAttributes();
        $this->one_benefit_amount->EditCustomAttributes = "";
        $this->one_benefit_amount->EditValue = $this->one_benefit_amount->CurrentValue;
        $this->one_benefit_amount->PlaceHolder = RemoveHtml($this->one_benefit_amount->caption());
        if (strval($this->one_benefit_amount->EditValue) != "" && is_numeric($this->one_benefit_amount->EditValue)) {
            $this->one_benefit_amount->EditValue = FormatNumber($this->one_benefit_amount->EditValue, null);
        }

        // two_benefit_amount1
        $this->two_benefit_amount1->setupEditAttributes();
        $this->two_benefit_amount1->EditCustomAttributes = "";
        $this->two_benefit_amount1->EditValue = $this->two_benefit_amount1->CurrentValue;
        $this->two_benefit_amount1->PlaceHolder = RemoveHtml($this->two_benefit_amount1->caption());
        if (strval($this->two_benefit_amount1->EditValue) != "" && is_numeric($this->two_benefit_amount1->EditValue)) {
            $this->two_benefit_amount1->EditValue = FormatNumber($this->two_benefit_amount1->EditValue, null);
        }

        // two_benefit_amount2
        $this->two_benefit_amount2->setupEditAttributes();
        $this->two_benefit_amount2->EditCustomAttributes = "";
        $this->two_benefit_amount2->EditValue = $this->two_benefit_amount2->CurrentValue;
        $this->two_benefit_amount2->PlaceHolder = RemoveHtml($this->two_benefit_amount2->caption());
        if (strval($this->two_benefit_amount2->EditValue) != "" && is_numeric($this->two_benefit_amount2->EditValue)) {
            $this->two_benefit_amount2->EditValue = FormatNumber($this->two_benefit_amount2->EditValue, null);
        }

        // management_agent_date
        $this->management_agent_date->setupEditAttributes();
        $this->management_agent_date->EditCustomAttributes = "";
        $this->management_agent_date->EditValue = FormatDateTime($this->management_agent_date->CurrentValue, $this->management_agent_date->formatPattern());
        $this->management_agent_date->PlaceHolder = RemoveHtml($this->management_agent_date->caption());

        // begin_date
        $this->begin_date->setupEditAttributes();
        $this->begin_date->EditCustomAttributes = "";
        $this->begin_date->EditValue = $this->begin_date->CurrentValue;
        $this->begin_date->PlaceHolder = RemoveHtml($this->begin_date->caption());
        if (strval($this->begin_date->EditValue) != "" && is_numeric($this->begin_date->EditValue)) {
            $this->begin_date->EditValue = FormatNumber($this->begin_date->EditValue, null);
        }

        // investor_witness_name
        $this->investor_witness_name->setupEditAttributes();
        $this->investor_witness_name->EditCustomAttributes = "";
        if (!$this->investor_witness_name->Raw) {
            $this->investor_witness_name->CurrentValue = HtmlDecode($this->investor_witness_name->CurrentValue);
        }
        $this->investor_witness_name->EditValue = $this->investor_witness_name->CurrentValue;
        $this->investor_witness_name->PlaceHolder = RemoveHtml($this->investor_witness_name->caption());

        // investor_witness_lname
        $this->investor_witness_lname->setupEditAttributes();
        $this->investor_witness_lname->EditCustomAttributes = "";
        if (!$this->investor_witness_lname->Raw) {
            $this->investor_witness_lname->CurrentValue = HtmlDecode($this->investor_witness_lname->CurrentValue);
        }
        $this->investor_witness_lname->EditValue = $this->investor_witness_lname->CurrentValue;
        $this->investor_witness_lname->PlaceHolder = RemoveHtml($this->investor_witness_lname->caption());

        // investor_witness_email
        $this->investor_witness_email->setupEditAttributes();
        $this->investor_witness_email->EditCustomAttributes = "";
        if (!$this->investor_witness_email->Raw) {
            $this->investor_witness_email->CurrentValue = HtmlDecode($this->investor_witness_email->CurrentValue);
        }
        $this->investor_witness_email->EditValue = $this->investor_witness_email->CurrentValue;
        $this->investor_witness_email->PlaceHolder = RemoveHtml($this->investor_witness_email->caption());

        // juzmatch_authority_name
        $this->juzmatch_authority_name->setupEditAttributes();
        $this->juzmatch_authority_name->EditCustomAttributes = "";
        if (!$this->juzmatch_authority_name->Raw) {
            $this->juzmatch_authority_name->CurrentValue = HtmlDecode($this->juzmatch_authority_name->CurrentValue);
        }
        $this->juzmatch_authority_name->EditValue = $this->juzmatch_authority_name->CurrentValue;
        $this->juzmatch_authority_name->PlaceHolder = RemoveHtml($this->juzmatch_authority_name->caption());

        // juzmatch_authority_lname
        $this->juzmatch_authority_lname->setupEditAttributes();
        $this->juzmatch_authority_lname->EditCustomAttributes = "";
        if (!$this->juzmatch_authority_lname->Raw) {
            $this->juzmatch_authority_lname->CurrentValue = HtmlDecode($this->juzmatch_authority_lname->CurrentValue);
        }
        $this->juzmatch_authority_lname->EditValue = $this->juzmatch_authority_lname->CurrentValue;
        $this->juzmatch_authority_lname->PlaceHolder = RemoveHtml($this->juzmatch_authority_lname->caption());

        // juzmatch_authority_email
        $this->juzmatch_authority_email->setupEditAttributes();
        $this->juzmatch_authority_email->EditCustomAttributes = "";
        if (!$this->juzmatch_authority_email->Raw) {
            $this->juzmatch_authority_email->CurrentValue = HtmlDecode($this->juzmatch_authority_email->CurrentValue);
        }
        $this->juzmatch_authority_email->EditValue = $this->juzmatch_authority_email->CurrentValue;
        $this->juzmatch_authority_email->PlaceHolder = RemoveHtml($this->juzmatch_authority_email->caption());

        // juzmatch_authority_witness_name
        $this->juzmatch_authority_witness_name->setupEditAttributes();
        $this->juzmatch_authority_witness_name->EditCustomAttributes = "";
        if (!$this->juzmatch_authority_witness_name->Raw) {
            $this->juzmatch_authority_witness_name->CurrentValue = HtmlDecode($this->juzmatch_authority_witness_name->CurrentValue);
        }
        $this->juzmatch_authority_witness_name->EditValue = $this->juzmatch_authority_witness_name->CurrentValue;
        $this->juzmatch_authority_witness_name->PlaceHolder = RemoveHtml($this->juzmatch_authority_witness_name->caption());

        // juzmatch_authority_witness_lname
        $this->juzmatch_authority_witness_lname->setupEditAttributes();
        $this->juzmatch_authority_witness_lname->EditCustomAttributes = "";
        if (!$this->juzmatch_authority_witness_lname->Raw) {
            $this->juzmatch_authority_witness_lname->CurrentValue = HtmlDecode($this->juzmatch_authority_witness_lname->CurrentValue);
        }
        $this->juzmatch_authority_witness_lname->EditValue = $this->juzmatch_authority_witness_lname->CurrentValue;
        $this->juzmatch_authority_witness_lname->PlaceHolder = RemoveHtml($this->juzmatch_authority_witness_lname->caption());

        // juzmatch_authority_witness_email
        $this->juzmatch_authority_witness_email->setupEditAttributes();
        $this->juzmatch_authority_witness_email->EditCustomAttributes = "";
        if (!$this->juzmatch_authority_witness_email->Raw) {
            $this->juzmatch_authority_witness_email->CurrentValue = HtmlDecode($this->juzmatch_authority_witness_email->CurrentValue);
        }
        $this->juzmatch_authority_witness_email->EditValue = $this->juzmatch_authority_witness_email->CurrentValue;
        $this->juzmatch_authority_witness_email->PlaceHolder = RemoveHtml($this->juzmatch_authority_witness_email->caption());

        // juzmatch_authority2_name
        $this->juzmatch_authority2_name->setupEditAttributes();
        $this->juzmatch_authority2_name->EditCustomAttributes = "";
        if (!$this->juzmatch_authority2_name->Raw) {
            $this->juzmatch_authority2_name->CurrentValue = HtmlDecode($this->juzmatch_authority2_name->CurrentValue);
        }
        $this->juzmatch_authority2_name->EditValue = $this->juzmatch_authority2_name->CurrentValue;
        $this->juzmatch_authority2_name->PlaceHolder = RemoveHtml($this->juzmatch_authority2_name->caption());

        // juzmatch_authority2_lname
        $this->juzmatch_authority2_lname->setupEditAttributes();
        $this->juzmatch_authority2_lname->EditCustomAttributes = "";
        if (!$this->juzmatch_authority2_lname->Raw) {
            $this->juzmatch_authority2_lname->CurrentValue = HtmlDecode($this->juzmatch_authority2_lname->CurrentValue);
        }
        $this->juzmatch_authority2_lname->EditValue = $this->juzmatch_authority2_lname->CurrentValue;
        $this->juzmatch_authority2_lname->PlaceHolder = RemoveHtml($this->juzmatch_authority2_lname->caption());

        // juzmatch_authority2_email
        $this->juzmatch_authority2_email->setupEditAttributes();
        $this->juzmatch_authority2_email->EditCustomAttributes = "";
        if (!$this->juzmatch_authority2_email->Raw) {
            $this->juzmatch_authority2_email->CurrentValue = HtmlDecode($this->juzmatch_authority2_email->CurrentValue);
        }
        $this->juzmatch_authority2_email->EditValue = $this->juzmatch_authority2_email->CurrentValue;
        $this->juzmatch_authority2_email->PlaceHolder = RemoveHtml($this->juzmatch_authority2_email->caption());

        // company_seal_name
        $this->company_seal_name->setupEditAttributes();
        $this->company_seal_name->EditCustomAttributes = "";
        if (!$this->company_seal_name->Raw) {
            $this->company_seal_name->CurrentValue = HtmlDecode($this->company_seal_name->CurrentValue);
        }
        $this->company_seal_name->EditValue = $this->company_seal_name->CurrentValue;
        $this->company_seal_name->PlaceHolder = RemoveHtml($this->company_seal_name->caption());

        // company_seal_email
        $this->company_seal_email->setupEditAttributes();
        $this->company_seal_email->EditCustomAttributes = "";
        if (!$this->company_seal_email->Raw) {
            $this->company_seal_email->CurrentValue = HtmlDecode($this->company_seal_email->CurrentValue);
        }
        $this->company_seal_email->EditValue = $this->company_seal_email->CurrentValue;
        $this->company_seal_email->PlaceHolder = RemoveHtml($this->company_seal_email->caption());

        // file_idcard
        $this->file_idcard->setupEditAttributes();
        $this->file_idcard->EditCustomAttributes = "";
        $this->file_idcard->UploadPath = "/upload/";
        if (!EmptyValue($this->file_idcard->Upload->DbValue)) {
            $this->file_idcard->EditValue = $this->file_idcard->Upload->DbValue;
        } else {
            $this->file_idcard->EditValue = "";
        }
        if (!EmptyValue($this->file_idcard->CurrentValue)) {
            $this->file_idcard->Upload->FileName = $this->file_idcard->CurrentValue;
        }

        // file_house_regis
        $this->file_house_regis->setupEditAttributes();
        $this->file_house_regis->EditCustomAttributes = "";
        $this->file_house_regis->UploadPath = "/upload/";
        if (!EmptyValue($this->file_house_regis->Upload->DbValue)) {
            $this->file_house_regis->EditValue = $this->file_house_regis->Upload->DbValue;
        } else {
            $this->file_house_regis->EditValue = "";
        }
        if (!EmptyValue($this->file_house_regis->CurrentValue)) {
            $this->file_house_regis->Upload->FileName = $this->file_house_regis->CurrentValue;
        }

        // file_other
        $this->file_other->setupEditAttributes();
        $this->file_other->EditCustomAttributes = "";
        $this->file_other->UploadPath = "/upload/";
        if (!EmptyValue($this->file_other->Upload->DbValue)) {
            $this->file_other->EditValue = $this->file_other->Upload->DbValue;
        } else {
            $this->file_other->EditValue = "";
        }
        if (!EmptyValue($this->file_other->CurrentValue)) {
            $this->file_other->Upload->FileName = $this->file_other->CurrentValue;
        }

        // contact_address
        $this->contact_address->setupEditAttributes();
        $this->contact_address->EditCustomAttributes = "";
        if (!$this->contact_address->Raw) {
            $this->contact_address->CurrentValue = HtmlDecode($this->contact_address->CurrentValue);
        }
        $this->contact_address->EditValue = $this->contact_address->CurrentValue;
        $this->contact_address->PlaceHolder = RemoveHtml($this->contact_address->caption());

        // contact_address2
        $this->contact_address2->setupEditAttributes();
        $this->contact_address2->EditCustomAttributes = "";
        if (!$this->contact_address2->Raw) {
            $this->contact_address2->CurrentValue = HtmlDecode($this->contact_address2->CurrentValue);
        }
        $this->contact_address2->EditValue = $this->contact_address2->CurrentValue;
        $this->contact_address2->PlaceHolder = RemoveHtml($this->contact_address2->caption());

        // contact_email
        $this->contact_email->setupEditAttributes();
        $this->contact_email->EditCustomAttributes = "";
        if (!$this->contact_email->Raw) {
            $this->contact_email->CurrentValue = HtmlDecode($this->contact_email->CurrentValue);
        }
        $this->contact_email->EditValue = $this->contact_email->CurrentValue;
        $this->contact_email->PlaceHolder = RemoveHtml($this->contact_email->caption());

        // contact_lineid
        $this->contact_lineid->setupEditAttributes();
        $this->contact_lineid->EditCustomAttributes = "";
        if (!$this->contact_lineid->Raw) {
            $this->contact_lineid->CurrentValue = HtmlDecode($this->contact_lineid->CurrentValue);
        }
        $this->contact_lineid->EditValue = $this->contact_lineid->CurrentValue;
        $this->contact_lineid->PlaceHolder = RemoveHtml($this->contact_lineid->caption());

        // contact_phone
        $this->contact_phone->setupEditAttributes();
        $this->contact_phone->EditCustomAttributes = "";
        if (!$this->contact_phone->Raw) {
            $this->contact_phone->CurrentValue = HtmlDecode($this->contact_phone->CurrentValue);
        }
        $this->contact_phone->EditValue = $this->contact_phone->CurrentValue;
        $this->contact_phone->PlaceHolder = RemoveHtml($this->contact_phone->caption());

        // file_loan
        $this->file_loan->setupEditAttributes();
        $this->file_loan->EditCustomAttributes = "";
        if (!$this->file_loan->Raw) {
            $this->file_loan->CurrentValue = HtmlDecode($this->file_loan->CurrentValue);
        }
        $this->file_loan->EditValue = $this->file_loan->CurrentValue;
        $this->file_loan->PlaceHolder = RemoveHtml($this->file_loan->caption());

        // attach_file
        $this->attach_file->setupEditAttributes();
        $this->attach_file->EditCustomAttributes = "";
        if (!$this->attach_file->Raw) {
            $this->attach_file->CurrentValue = HtmlDecode($this->attach_file->CurrentValue);
        }
        $this->attach_file->EditValue = $this->attach_file->CurrentValue;
        $this->attach_file->PlaceHolder = RemoveHtml($this->attach_file->caption());

        // status
        $this->status->setupEditAttributes();
        $this->status->EditCustomAttributes = "";
        $this->status->EditValue = $this->status->options(true);
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // doc_creden_id
        $this->doc_creden_id->setupEditAttributes();
        $this->doc_creden_id->EditCustomAttributes = "";
        $this->doc_creden_id->EditValue = $this->doc_creden_id->CurrentValue;
        $this->doc_creden_id->PlaceHolder = RemoveHtml($this->doc_creden_id->caption());
        if (strval($this->doc_creden_id->EditValue) != "" && is_numeric($this->doc_creden_id->EditValue)) {
            $this->doc_creden_id->EditValue = FormatNumber($this->doc_creden_id->EditValue, null);
        }

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // doc_date

        // investor_booking_id
        $this->investor_booking_id->setupEditAttributes();
        $this->investor_booking_id->EditCustomAttributes = "";
        if ($this->investor_booking_id->getSessionValue() != "") {
            $this->investor_booking_id->CurrentValue = GetForeignKeyValue($this->investor_booking_id->getSessionValue());
            $this->investor_booking_id->ViewValue = $this->investor_booking_id->CurrentValue;
            $this->investor_booking_id->ViewValue = FormatNumber($this->investor_booking_id->ViewValue, $this->investor_booking_id->formatPattern());
            $this->investor_booking_id->ViewCustomAttributes = "";
        } else {
            $this->investor_booking_id->EditValue = $this->investor_booking_id->CurrentValue;
            $this->investor_booking_id->PlaceHolder = RemoveHtml($this->investor_booking_id->caption());
            if (strval($this->investor_booking_id->EditValue) != "" && is_numeric($this->investor_booking_id->EditValue)) {
                $this->investor_booking_id->EditValue = FormatNumber($this->investor_booking_id->EditValue, null);
            }
        }

        // first_down
        $this->first_down->setupEditAttributes();
        $this->first_down->EditCustomAttributes = "";
        $this->first_down->EditValue = $this->first_down->CurrentValue;
        $this->first_down->PlaceHolder = RemoveHtml($this->first_down->caption());
        if (strval($this->first_down->EditValue) != "" && is_numeric($this->first_down->EditValue)) {
            $this->first_down->EditValue = FormatNumber($this->first_down->EditValue, null);
        }

        // first_down_txt
        $this->first_down_txt->setupEditAttributes();
        $this->first_down_txt->EditCustomAttributes = "";
        if (!$this->first_down_txt->Raw) {
            $this->first_down_txt->CurrentValue = HtmlDecode($this->first_down_txt->CurrentValue);
        }
        $this->first_down_txt->EditValue = $this->first_down_txt->CurrentValue;
        $this->first_down_txt->PlaceHolder = RemoveHtml($this->first_down_txt->caption());

        // second_down
        $this->second_down->setupEditAttributes();
        $this->second_down->EditCustomAttributes = "";
        $this->second_down->EditValue = $this->second_down->CurrentValue;
        $this->second_down->PlaceHolder = RemoveHtml($this->second_down->caption());
        if (strval($this->second_down->EditValue) != "" && is_numeric($this->second_down->EditValue)) {
            $this->second_down->EditValue = FormatNumber($this->second_down->EditValue, null);
        }

        // second_down_txt
        $this->second_down_txt->setupEditAttributes();
        $this->second_down_txt->EditCustomAttributes = "";
        if (!$this->second_down_txt->Raw) {
            $this->second_down_txt->CurrentValue = HtmlDecode($this->second_down_txt->CurrentValue);
        }
        $this->second_down_txt->EditValue = $this->second_down_txt->CurrentValue;
        $this->second_down_txt->PlaceHolder = RemoveHtml($this->second_down_txt->caption());

        // service_price
        $this->service_price->setupEditAttributes();
        $this->service_price->EditCustomAttributes = "";
        $this->service_price->EditValue = $this->service_price->CurrentValue;
        $this->service_price->PlaceHolder = RemoveHtml($this->service_price->caption());
        if (strval($this->service_price->EditValue) != "" && is_numeric($this->service_price->EditValue)) {
            $this->service_price->EditValue = FormatNumber($this->service_price->EditValue, null);
        }

        // service_price_txt
        $this->service_price_txt->setupEditAttributes();
        $this->service_price_txt->EditCustomAttributes = "";
        if (!$this->service_price_txt->Raw) {
            $this->service_price_txt->CurrentValue = HtmlDecode($this->service_price_txt->CurrentValue);
        }
        $this->service_price_txt->EditValue = $this->service_price_txt->CurrentValue;
        $this->service_price_txt->PlaceHolder = RemoveHtml($this->service_price_txt->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->document_date);
                    $doc->exportCaption($this->asset_code);
                    $doc->exportCaption($this->asset_project);
                    $doc->exportCaption($this->asset_deed);
                    $doc->exportCaption($this->asset_area);
                    $doc->exportCaption($this->investor_name);
                    $doc->exportCaption($this->investor_lname);
                    $doc->exportCaption($this->investor_email);
                    $doc->exportCaption($this->investor_idcard);
                    $doc->exportCaption($this->investor_homeno);
                    $doc->exportCaption($this->investment_money);
                    $doc->exportCaption($this->investment_money_txt);
                    $doc->exportCaption($this->loan_contact_date);
                    $doc->exportCaption($this->contract_expired);
                    $doc->exportCaption($this->first_benefits_month);
                    $doc->exportCaption($this->one_installment_amount);
                    $doc->exportCaption($this->two_installment_amount1);
                    $doc->exportCaption($this->two_installment_amount2);
                    $doc->exportCaption($this->investor_paid_amount);
                    $doc->exportCaption($this->first_benefits_date);
                    $doc->exportCaption($this->one_benefit_amount);
                    $doc->exportCaption($this->two_benefit_amount1);
                    $doc->exportCaption($this->two_benefit_amount2);
                    $doc->exportCaption($this->management_agent_date);
                    $doc->exportCaption($this->begin_date);
                    $doc->exportCaption($this->investor_witness_name);
                    $doc->exportCaption($this->investor_witness_lname);
                    $doc->exportCaption($this->investor_witness_email);
                    $doc->exportCaption($this->juzmatch_authority_name);
                    $doc->exportCaption($this->juzmatch_authority_lname);
                    $doc->exportCaption($this->juzmatch_authority_email);
                    $doc->exportCaption($this->juzmatch_authority_witness_name);
                    $doc->exportCaption($this->juzmatch_authority_witness_lname);
                    $doc->exportCaption($this->juzmatch_authority_witness_email);
                    $doc->exportCaption($this->juzmatch_authority2_name);
                    $doc->exportCaption($this->juzmatch_authority2_lname);
                    $doc->exportCaption($this->juzmatch_authority2_email);
                    $doc->exportCaption($this->company_seal_name);
                    $doc->exportCaption($this->company_seal_email);
                    $doc->exportCaption($this->file_idcard);
                    $doc->exportCaption($this->file_house_regis);
                    $doc->exportCaption($this->file_other);
                    $doc->exportCaption($this->contact_address);
                    $doc->exportCaption($this->contact_address2);
                    $doc->exportCaption($this->contact_email);
                    $doc->exportCaption($this->contact_lineid);
                    $doc->exportCaption($this->contact_phone);
                    $doc->exportCaption($this->file_loan);
                    $doc->exportCaption($this->attach_file);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->cdate);
                } else {
                    $doc->exportCaption($this->document_date);
                    $doc->exportCaption($this->asset_code);
                    $doc->exportCaption($this->asset_project);
                    $doc->exportCaption($this->asset_deed);
                    $doc->exportCaption($this->asset_area);
                    $doc->exportCaption($this->investor_lname);
                    $doc->exportCaption($this->investor_email);
                    $doc->exportCaption($this->investor_idcard);
                    $doc->exportCaption($this->investor_homeno);
                    $doc->exportCaption($this->investment_money);
                    $doc->exportCaption($this->loan_contact_date);
                    $doc->exportCaption($this->contract_expired);
                    $doc->exportCaption($this->first_benefits_month);
                    $doc->exportCaption($this->one_installment_amount);
                    $doc->exportCaption($this->two_installment_amount1);
                    $doc->exportCaption($this->two_installment_amount2);
                    $doc->exportCaption($this->investor_paid_amount);
                    $doc->exportCaption($this->first_benefits_date);
                    $doc->exportCaption($this->one_benefit_amount);
                    $doc->exportCaption($this->two_benefit_amount1);
                    $doc->exportCaption($this->two_benefit_amount2);
                    $doc->exportCaption($this->management_agent_date);
                    $doc->exportCaption($this->begin_date);
                    $doc->exportCaption($this->investor_witness_lname);
                    $doc->exportCaption($this->investor_witness_email);
                    $doc->exportCaption($this->juzmatch_authority_lname);
                    $doc->exportCaption($this->juzmatch_authority_email);
                    $doc->exportCaption($this->juzmatch_authority_witness_lname);
                    $doc->exportCaption($this->juzmatch_authority_witness_email);
                    $doc->exportCaption($this->juzmatch_authority2_name);
                    $doc->exportCaption($this->juzmatch_authority2_lname);
                    $doc->exportCaption($this->juzmatch_authority2_email);
                    $doc->exportCaption($this->company_seal_name);
                    $doc->exportCaption($this->company_seal_email);
                    $doc->exportCaption($this->contact_address);
                    $doc->exportCaption($this->contact_address2);
                    $doc->exportCaption($this->contact_email);
                    $doc->exportCaption($this->contact_lineid);
                    $doc->exportCaption($this->contact_phone);
                    $doc->exportCaption($this->attach_file);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->document_date);
                        $doc->exportField($this->asset_code);
                        $doc->exportField($this->asset_project);
                        $doc->exportField($this->asset_deed);
                        $doc->exportField($this->asset_area);
                        $doc->exportField($this->investor_name);
                        $doc->exportField($this->investor_lname);
                        $doc->exportField($this->investor_email);
                        $doc->exportField($this->investor_idcard);
                        $doc->exportField($this->investor_homeno);
                        $doc->exportField($this->investment_money);
                        $doc->exportField($this->investment_money_txt);
                        $doc->exportField($this->loan_contact_date);
                        $doc->exportField($this->contract_expired);
                        $doc->exportField($this->first_benefits_month);
                        $doc->exportField($this->one_installment_amount);
                        $doc->exportField($this->two_installment_amount1);
                        $doc->exportField($this->two_installment_amount2);
                        $doc->exportField($this->investor_paid_amount);
                        $doc->exportField($this->first_benefits_date);
                        $doc->exportField($this->one_benefit_amount);
                        $doc->exportField($this->two_benefit_amount1);
                        $doc->exportField($this->two_benefit_amount2);
                        $doc->exportField($this->management_agent_date);
                        $doc->exportField($this->begin_date);
                        $doc->exportField($this->investor_witness_name);
                        $doc->exportField($this->investor_witness_lname);
                        $doc->exportField($this->investor_witness_email);
                        $doc->exportField($this->juzmatch_authority_name);
                        $doc->exportField($this->juzmatch_authority_lname);
                        $doc->exportField($this->juzmatch_authority_email);
                        $doc->exportField($this->juzmatch_authority_witness_name);
                        $doc->exportField($this->juzmatch_authority_witness_lname);
                        $doc->exportField($this->juzmatch_authority_witness_email);
                        $doc->exportField($this->juzmatch_authority2_name);
                        $doc->exportField($this->juzmatch_authority2_lname);
                        $doc->exportField($this->juzmatch_authority2_email);
                        $doc->exportField($this->company_seal_name);
                        $doc->exportField($this->company_seal_email);
                        $doc->exportField($this->file_idcard);
                        $doc->exportField($this->file_house_regis);
                        $doc->exportField($this->file_other);
                        $doc->exportField($this->contact_address);
                        $doc->exportField($this->contact_address2);
                        $doc->exportField($this->contact_email);
                        $doc->exportField($this->contact_lineid);
                        $doc->exportField($this->contact_phone);
                        $doc->exportField($this->file_loan);
                        $doc->exportField($this->attach_file);
                        $doc->exportField($this->status);
                        $doc->exportField($this->cdate);
                    } else {
                        $doc->exportField($this->document_date);
                        $doc->exportField($this->asset_code);
                        $doc->exportField($this->asset_project);
                        $doc->exportField($this->asset_deed);
                        $doc->exportField($this->asset_area);
                        $doc->exportField($this->investor_lname);
                        $doc->exportField($this->investor_email);
                        $doc->exportField($this->investor_idcard);
                        $doc->exportField($this->investor_homeno);
                        $doc->exportField($this->investment_money);
                        $doc->exportField($this->loan_contact_date);
                        $doc->exportField($this->contract_expired);
                        $doc->exportField($this->first_benefits_month);
                        $doc->exportField($this->one_installment_amount);
                        $doc->exportField($this->two_installment_amount1);
                        $doc->exportField($this->two_installment_amount2);
                        $doc->exportField($this->investor_paid_amount);
                        $doc->exportField($this->first_benefits_date);
                        $doc->exportField($this->one_benefit_amount);
                        $doc->exportField($this->two_benefit_amount1);
                        $doc->exportField($this->two_benefit_amount2);
                        $doc->exportField($this->management_agent_date);
                        $doc->exportField($this->begin_date);
                        $doc->exportField($this->investor_witness_lname);
                        $doc->exportField($this->investor_witness_email);
                        $doc->exportField($this->juzmatch_authority_lname);
                        $doc->exportField($this->juzmatch_authority_email);
                        $doc->exportField($this->juzmatch_authority_witness_lname);
                        $doc->exportField($this->juzmatch_authority_witness_email);
                        $doc->exportField($this->juzmatch_authority2_name);
                        $doc->exportField($this->juzmatch_authority2_lname);
                        $doc->exportField($this->juzmatch_authority2_email);
                        $doc->exportField($this->company_seal_name);
                        $doc->exportField($this->company_seal_email);
                        $doc->exportField($this->contact_address);
                        $doc->exportField($this->contact_address2);
                        $doc->exportField($this->contact_email);
                        $doc->exportField($this->contact_lineid);
                        $doc->exportField($this->contact_phone);
                        $doc->exportField($this->attach_file);
                        $doc->exportField($this->status);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'file_idcard') {
            $fldName = "file_idcard";
            $fileNameFld = "file_idcard";
        } elseif ($fldparm == 'file_house_regis') {
            $fldName = "file_house_regis";
            $fileNameFld = "file_house_regis";
        } elseif ($fldparm == 'file_other') {
            $fldName = "file_other";
            $fileNameFld = "file_other";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->id->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssociative($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower(@$pathinfo["extension"]);
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
