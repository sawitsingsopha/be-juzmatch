<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for doc_juzmatch1
 */
class DocJuzmatch1 extends DbTable
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

    // Audit trail
    public $AuditTrailOnAdd = true;
    public $AuditTrailOnEdit = true;
    public $AuditTrailOnDelete = true;
    public $AuditTrailOnView = false;
    public $AuditTrailOnViewData = false;
    public $AuditTrailOnSearch = false;

    // Export
    public $ExportDoc;

    // Fields
    public $id;
    public $document_date;
    public $asset_code;
    public $asset_deed;
    public $asset_project;
    public $asset_area;
    public $buyer_name;
    public $buyer_lname;
    public $buyer_email;
    public $buyer_idcard;
    public $buyer_homeno;
    public $buyer_witness_name;
    public $buyer_witness_lname;
    public $buyer_witness_email;
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
    public $service_price;
    public $service_price_txt;
    public $first_down;
    public $first_down_txt;
    public $second_down;
    public $second_down_txt;
    public $contact_address;
    public $contact_address2;
    public $contact_email;
    public $contact_lineid;
    public $contact_phone;
    public $file_idcard;
    public $file_house_regis;
    public $file_titledeed;
    public $file_other;
    public $attach_file;
    public $status;
    public $doc_date;
    public $buyer_booking_asset_id;
    public $doc_creden_id;
    public $cdate;
    public $cuser;
    public $cip;
    public $udate;
    public $uuser;
    public $uip;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'doc_juzmatch1';
        $this->TableName = 'doc_juzmatch1';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`doc_juzmatch1`";
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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

        // asset_deed
        $this->asset_deed = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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

        // asset_project
        $this->asset_project = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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

        // asset_area
        $this->asset_area = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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

        // buyer_name
        $this->buyer_name = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
            'x_buyer_name',
            'buyer_name',
            '`buyer_name`',
            '`buyer_name`',
            201,
            500,
            -1,
            false,
            '`buyer_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->buyer_name->InputTextType = "text";
        $this->Fields['buyer_name'] = &$this->buyer_name;

        // buyer_lname
        $this->buyer_lname = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
            'x_buyer_lname',
            'buyer_lname',
            '`buyer_lname`',
            '`buyer_lname`',
            200,
            250,
            -1,
            false,
            '`buyer_lname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->buyer_lname->InputTextType = "text";
        $this->Fields['buyer_lname'] = &$this->buyer_lname;

        // buyer_email
        $this->buyer_email = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
            'x_buyer_email',
            'buyer_email',
            '`buyer_email`',
            '`buyer_email`',
            200,
            250,
            -1,
            false,
            '`buyer_email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->buyer_email->InputTextType = "text";
        $this->Fields['buyer_email'] = &$this->buyer_email;

        // buyer_idcard
        $this->buyer_idcard = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
            'x_buyer_idcard',
            'buyer_idcard',
            '`buyer_idcard`',
            '`buyer_idcard`',
            200,
            250,
            -1,
            false,
            '`buyer_idcard`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->buyer_idcard->InputTextType = "text";
        $this->Fields['buyer_idcard'] = &$this->buyer_idcard;

        // buyer_homeno
        $this->buyer_homeno = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
            'x_buyer_homeno',
            'buyer_homeno',
            '`buyer_homeno`',
            '`buyer_homeno`',
            200,
            250,
            -1,
            false,
            '`buyer_homeno`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->buyer_homeno->InputTextType = "text";
        $this->Fields['buyer_homeno'] = &$this->buyer_homeno;

        // buyer_witness_name
        $this->buyer_witness_name = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
            'x_buyer_witness_name',
            'buyer_witness_name',
            '`buyer_witness_name`',
            '`buyer_witness_name`',
            201,
            500,
            -1,
            false,
            '`buyer_witness_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->buyer_witness_name->InputTextType = "text";
        $this->Fields['buyer_witness_name'] = &$this->buyer_witness_name;

        // buyer_witness_lname
        $this->buyer_witness_lname = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
            'x_buyer_witness_lname',
            'buyer_witness_lname',
            '`buyer_witness_lname`',
            '`buyer_witness_lname`',
            200,
            250,
            -1,
            false,
            '`buyer_witness_lname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->buyer_witness_lname->InputTextType = "text";
        $this->Fields['buyer_witness_lname'] = &$this->buyer_witness_lname;

        // buyer_witness_email
        $this->buyer_witness_email = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
            'x_buyer_witness_email',
            'buyer_witness_email',
            '`buyer_witness_email`',
            '`buyer_witness_email`',
            200,
            250,
            -1,
            false,
            '`buyer_witness_email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->buyer_witness_email->InputTextType = "text";
        $this->Fields['buyer_witness_email'] = &$this->buyer_witness_email;

        // juzmatch_authority_name
        $this->juzmatch_authority_name = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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

        // service_price
        $this->service_price = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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
        $this->service_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['service_price'] = &$this->service_price;

        // service_price_txt
        $this->service_price_txt = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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
        $this->Fields['service_price_txt'] = &$this->service_price_txt;

        // first_down
        $this->first_down = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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
        $this->first_down->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['first_down'] = &$this->first_down;

        // first_down_txt
        $this->first_down_txt = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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
        $this->Fields['first_down_txt'] = &$this->first_down_txt;

        // second_down
        $this->second_down = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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
        $this->second_down->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['second_down'] = &$this->second_down;

        // second_down_txt
        $this->second_down_txt = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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
        $this->Fields['second_down_txt'] = &$this->second_down_txt;

        // contact_address
        $this->contact_address = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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

        // file_idcard
        $this->file_idcard = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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

        // file_titledeed
        $this->file_titledeed = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
            'x_file_titledeed',
            'file_titledeed',
            '`file_titledeed`',
            '`file_titledeed`',
            200,
            250,
            -1,
            true,
            '`file_titledeed`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'FILE'
        );
        $this->file_titledeed->InputTextType = "text";
        $this->file_titledeed->UploadPath = "/upload/";
        $this->Fields['file_titledeed'] = &$this->file_titledeed;

        // file_other
        $this->file_other = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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

        // attach_file
        $this->attach_file = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
        $this->status->Lookup = new Lookup('status', 'doc_juzmatch1', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->status->OptionCount = 3;
        $this->status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status'] = &$this->status;

        // doc_date
        $this->doc_date = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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

        // buyer_booking_asset_id
        $this->buyer_booking_asset_id = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
            'x_buyer_booking_asset_id',
            'buyer_booking_asset_id',
            '`buyer_booking_asset_id`',
            '`buyer_booking_asset_id`',
            3,
            11,
            -1,
            false,
            '`buyer_booking_asset_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->buyer_booking_asset_id->InputTextType = "text";
        $this->buyer_booking_asset_id->IsForeignKey = true; // Foreign key field
        $this->buyer_booking_asset_id->Nullable = false; // NOT NULL field
        $this->buyer_booking_asset_id->Required = true; // Required field
        $this->buyer_booking_asset_id->Sortable = false; // Allow sort
        $this->buyer_booking_asset_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['buyer_booking_asset_id'] = &$this->buyer_booking_asset_id;

        // doc_creden_id
        $this->doc_creden_id = new DbField(
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
            'doc_juzmatch1',
            'doc_juzmatch1',
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
        if ($this->getCurrentMasterTable() == "buyer_all_booking_asset") {
            if ($this->buyer_booking_asset_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`buyer_booking_asset_id`", $this->buyer_booking_asset_id->getSessionValue(), DATATYPE_NUMBER, "juzmatch1");
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
        if ($this->getCurrentMasterTable() == "buyer_all_booking_asset") {
            if ($this->buyer_booking_asset_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`buyer_booking_asset_id`", $this->buyer_booking_asset_id->getSessionValue(), DATATYPE_NUMBER, "juzmatch1");
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
            case "buyer_all_booking_asset":
                $key = $keys["buyer_booking_asset_id"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->buyer_booking_asset_id->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return "`buyer_booking_asset_id`=" . QuotedValue($keys["buyer_booking_asset_id"], $masterTable->buyer_booking_asset_id->DataType, $masterTable->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "buyer_all_booking_asset":
                return "`buyer_booking_asset_id`=" . QuotedValue($masterTable->buyer_booking_asset_id->DbValue, $this->buyer_booking_asset_id->DataType, $this->Dbid);
        }
        return "";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`doc_juzmatch1`";
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
            if ($this->AuditTrailOnAdd) {
                $this->writeAuditTrailOnAdd($rs);
            }
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
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'id';
            if (!array_key_exists($fldname, $rsaudit)) {
                $rsaudit[$fldname] = $rsold[$fldname];
            }
            $this->writeAuditTrailOnEdit($rsold, $rsaudit);
        }
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
        if ($success && $this->AuditTrailOnDelete) {
            $this->writeAuditTrailOnDelete($rs);
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
        $this->asset_deed->DbValue = $row['asset_deed'];
        $this->asset_project->DbValue = $row['asset_project'];
        $this->asset_area->DbValue = $row['asset_area'];
        $this->buyer_name->DbValue = $row['buyer_name'];
        $this->buyer_lname->DbValue = $row['buyer_lname'];
        $this->buyer_email->DbValue = $row['buyer_email'];
        $this->buyer_idcard->DbValue = $row['buyer_idcard'];
        $this->buyer_homeno->DbValue = $row['buyer_homeno'];
        $this->buyer_witness_name->DbValue = $row['buyer_witness_name'];
        $this->buyer_witness_lname->DbValue = $row['buyer_witness_lname'];
        $this->buyer_witness_email->DbValue = $row['buyer_witness_email'];
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
        $this->service_price->DbValue = $row['service_price'];
        $this->service_price_txt->DbValue = $row['service_price_txt'];
        $this->first_down->DbValue = $row['first_down'];
        $this->first_down_txt->DbValue = $row['first_down_txt'];
        $this->second_down->DbValue = $row['second_down'];
        $this->second_down_txt->DbValue = $row['second_down_txt'];
        $this->contact_address->DbValue = $row['contact_address'];
        $this->contact_address2->DbValue = $row['contact_address2'];
        $this->contact_email->DbValue = $row['contact_email'];
        $this->contact_lineid->DbValue = $row['contact_lineid'];
        $this->contact_phone->DbValue = $row['contact_phone'];
        $this->file_idcard->Upload->DbValue = $row['file_idcard'];
        $this->file_house_regis->Upload->DbValue = $row['file_house_regis'];
        $this->file_titledeed->Upload->DbValue = $row['file_titledeed'];
        $this->file_other->Upload->DbValue = $row['file_other'];
        $this->attach_file->DbValue = $row['attach_file'];
        $this->status->DbValue = $row['status'];
        $this->doc_date->DbValue = $row['doc_date'];
        $this->buyer_booking_asset_id->DbValue = $row['buyer_booking_asset_id'];
        $this->doc_creden_id->DbValue = $row['doc_creden_id'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cuser->DbValue = $row['cuser'];
        $this->cip->DbValue = $row['cip'];
        $this->udate->DbValue = $row['udate'];
        $this->uuser->DbValue = $row['uuser'];
        $this->uip->DbValue = $row['uip'];
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
        $this->file_titledeed->OldUploadPath = "/upload/";
        $oldFiles = EmptyValue($row['file_titledeed']) ? [] : [$row['file_titledeed']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->file_titledeed->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->file_titledeed->oldPhysicalUploadPath() . $oldFile);
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
        return $_SESSION[$name] ?? GetUrl("docjuzmatch1list");
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
        if ($pageName == "docjuzmatch1view") {
            return $Language->phrase("View");
        } elseif ($pageName == "docjuzmatch1edit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "docjuzmatch1add") {
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
                return "DocJuzmatch1View";
            case Config("API_ADD_ACTION"):
                return "DocJuzmatch1Add";
            case Config("API_EDIT_ACTION"):
                return "DocJuzmatch1Edit";
            case Config("API_DELETE_ACTION"):
                return "DocJuzmatch1Delete";
            case Config("API_LIST_ACTION"):
                return "DocJuzmatch1List";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "docjuzmatch1list";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("docjuzmatch1view", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("docjuzmatch1view", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "docjuzmatch1add?" . $this->getUrlParm($parm);
        } else {
            $url = "docjuzmatch1add";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("docjuzmatch1edit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("docjuzmatch1add", $this->getUrlParm($parm));
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
        return $this->keyUrl("docjuzmatch1delete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "buyer_all_booking_asset" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_buyer_booking_asset_id", $this->buyer_booking_asset_id->CurrentValue);
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
        $this->asset_deed->setDbValue($row['asset_deed']);
        $this->asset_project->setDbValue($row['asset_project']);
        $this->asset_area->setDbValue($row['asset_area']);
        $this->buyer_name->setDbValue($row['buyer_name']);
        $this->buyer_lname->setDbValue($row['buyer_lname']);
        $this->buyer_email->setDbValue($row['buyer_email']);
        $this->buyer_idcard->setDbValue($row['buyer_idcard']);
        $this->buyer_homeno->setDbValue($row['buyer_homeno']);
        $this->buyer_witness_name->setDbValue($row['buyer_witness_name']);
        $this->buyer_witness_lname->setDbValue($row['buyer_witness_lname']);
        $this->buyer_witness_email->setDbValue($row['buyer_witness_email']);
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
        $this->service_price->setDbValue($row['service_price']);
        $this->service_price_txt->setDbValue($row['service_price_txt']);
        $this->first_down->setDbValue($row['first_down']);
        $this->first_down_txt->setDbValue($row['first_down_txt']);
        $this->second_down->setDbValue($row['second_down']);
        $this->second_down_txt->setDbValue($row['second_down_txt']);
        $this->contact_address->setDbValue($row['contact_address']);
        $this->contact_address2->setDbValue($row['contact_address2']);
        $this->contact_email->setDbValue($row['contact_email']);
        $this->contact_lineid->setDbValue($row['contact_lineid']);
        $this->contact_phone->setDbValue($row['contact_phone']);
        $this->file_idcard->Upload->DbValue = $row['file_idcard'];
        $this->file_house_regis->Upload->DbValue = $row['file_house_regis'];
        $this->file_titledeed->Upload->DbValue = $row['file_titledeed'];
        $this->file_other->Upload->DbValue = $row['file_other'];
        $this->attach_file->setDbValue($row['attach_file']);
        $this->status->setDbValue($row['status']);
        $this->doc_date->setDbValue($row['doc_date']);
        $this->buyer_booking_asset_id->setDbValue($row['buyer_booking_asset_id']);
        $this->doc_creden_id->setDbValue($row['doc_creden_id']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
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

        // asset_deed

        // asset_project

        // asset_area

        // buyer_name

        // buyer_lname

        // buyer_email

        // buyer_idcard

        // buyer_homeno

        // buyer_witness_name

        // buyer_witness_lname

        // buyer_witness_email

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

        // service_price

        // service_price_txt

        // first_down

        // first_down_txt

        // second_down

        // second_down_txt

        // contact_address

        // contact_address2

        // contact_email

        // contact_lineid

        // contact_phone

        // file_idcard

        // file_house_regis

        // file_titledeed

        // file_other

        // attach_file

        // status

        // doc_date
        $this->doc_date->CellCssStyle = "white-space: nowrap;";

        // buyer_booking_asset_id
        $this->buyer_booking_asset_id->CellCssStyle = "white-space: nowrap;";

        // doc_creden_id
        $this->doc_creden_id->CellCssStyle = "white-space: nowrap;";

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

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

        // asset_deed
        $this->asset_deed->ViewValue = $this->asset_deed->CurrentValue;
        $this->asset_deed->ViewCustomAttributes = "";

        // asset_project
        $this->asset_project->ViewValue = $this->asset_project->CurrentValue;
        $this->asset_project->ViewCustomAttributes = "";

        // asset_area
        $this->asset_area->ViewValue = $this->asset_area->CurrentValue;
        $this->asset_area->ViewCustomAttributes = "";

        // buyer_name
        $this->buyer_name->ViewValue = $this->buyer_name->CurrentValue;
        $this->buyer_name->ViewCustomAttributes = "";

        // buyer_lname
        $this->buyer_lname->ViewValue = $this->buyer_lname->CurrentValue;
        $this->buyer_lname->ViewCustomAttributes = "";

        // buyer_email
        $this->buyer_email->ViewValue = $this->buyer_email->CurrentValue;
        $this->buyer_email->ViewCustomAttributes = "";

        // buyer_idcard
        $this->buyer_idcard->ViewValue = $this->buyer_idcard->CurrentValue;
        $this->buyer_idcard->ViewCustomAttributes = "";

        // buyer_homeno
        $this->buyer_homeno->ViewValue = $this->buyer_homeno->CurrentValue;
        $this->buyer_homeno->ViewCustomAttributes = "";

        // buyer_witness_name
        $this->buyer_witness_name->ViewValue = $this->buyer_witness_name->CurrentValue;
        $this->buyer_witness_name->ViewCustomAttributes = "";

        // buyer_witness_lname
        $this->buyer_witness_lname->ViewValue = $this->buyer_witness_lname->CurrentValue;
        $this->buyer_witness_lname->ViewCustomAttributes = "";

        // buyer_witness_email
        $this->buyer_witness_email->ViewValue = $this->buyer_witness_email->CurrentValue;
        $this->buyer_witness_email->ViewCustomAttributes = "";

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

        // service_price
        $this->service_price->ViewValue = $this->service_price->CurrentValue;
        $this->service_price->ViewValue = FormatNumber($this->service_price->ViewValue, $this->service_price->formatPattern());
        $this->service_price->ViewCustomAttributes = "";

        // service_price_txt
        $this->service_price_txt->ViewValue = $this->service_price_txt->CurrentValue;
        $this->service_price_txt->ViewCustomAttributes = "";

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

        // file_titledeed
        $this->file_titledeed->UploadPath = "/upload/";
        if (!EmptyValue($this->file_titledeed->Upload->DbValue)) {
            $this->file_titledeed->ViewValue = $this->file_titledeed->Upload->DbValue;
        } else {
            $this->file_titledeed->ViewValue = "";
        }
        $this->file_titledeed->ViewCustomAttributes = "";

        // file_other
        $this->file_other->UploadPath = "/upload/";
        if (!EmptyValue($this->file_other->Upload->DbValue)) {
            $this->file_other->ViewValue = $this->file_other->Upload->DbValue;
        } else {
            $this->file_other->ViewValue = "";
        }
        $this->file_other->ViewCustomAttributes = "";

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

        // doc_date
        $this->doc_date->ViewValue = $this->doc_date->CurrentValue;
        $this->doc_date->ViewValue = FormatDateTime($this->doc_date->ViewValue, $this->doc_date->formatPattern());
        $this->doc_date->ViewCustomAttributes = "";

        // buyer_booking_asset_id
        $this->buyer_booking_asset_id->ViewValue = $this->buyer_booking_asset_id->CurrentValue;
        $this->buyer_booking_asset_id->ViewValue = FormatNumber($this->buyer_booking_asset_id->ViewValue, $this->buyer_booking_asset_id->formatPattern());
        $this->buyer_booking_asset_id->ViewCustomAttributes = "";

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

        // asset_deed
        $this->asset_deed->LinkCustomAttributes = "";
        $this->asset_deed->HrefValue = "";
        $this->asset_deed->TooltipValue = "";

        // asset_project
        $this->asset_project->LinkCustomAttributes = "";
        $this->asset_project->HrefValue = "";
        $this->asset_project->TooltipValue = "";

        // asset_area
        $this->asset_area->LinkCustomAttributes = "";
        $this->asset_area->HrefValue = "";
        $this->asset_area->TooltipValue = "";

        // buyer_name
        $this->buyer_name->LinkCustomAttributes = "";
        $this->buyer_name->HrefValue = "";
        $this->buyer_name->TooltipValue = "";

        // buyer_lname
        $this->buyer_lname->LinkCustomAttributes = "";
        $this->buyer_lname->HrefValue = "";
        $this->buyer_lname->TooltipValue = "";

        // buyer_email
        $this->buyer_email->LinkCustomAttributes = "";
        $this->buyer_email->HrefValue = "";
        $this->buyer_email->TooltipValue = "";

        // buyer_idcard
        $this->buyer_idcard->LinkCustomAttributes = "";
        $this->buyer_idcard->HrefValue = "";
        $this->buyer_idcard->TooltipValue = "";

        // buyer_homeno
        $this->buyer_homeno->LinkCustomAttributes = "";
        $this->buyer_homeno->HrefValue = "";
        $this->buyer_homeno->TooltipValue = "";

        // buyer_witness_name
        $this->buyer_witness_name->LinkCustomAttributes = "";
        $this->buyer_witness_name->HrefValue = "";
        $this->buyer_witness_name->TooltipValue = "";

        // buyer_witness_lname
        $this->buyer_witness_lname->LinkCustomAttributes = "";
        $this->buyer_witness_lname->HrefValue = "";
        $this->buyer_witness_lname->TooltipValue = "";

        // buyer_witness_email
        $this->buyer_witness_email->LinkCustomAttributes = "";
        $this->buyer_witness_email->HrefValue = "";
        $this->buyer_witness_email->TooltipValue = "";

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

        // service_price
        $this->service_price->LinkCustomAttributes = "";
        $this->service_price->HrefValue = "";
        $this->service_price->TooltipValue = "";

        // service_price_txt
        $this->service_price_txt->LinkCustomAttributes = "";
        $this->service_price_txt->HrefValue = "";
        $this->service_price_txt->TooltipValue = "";

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

        // file_titledeed
        $this->file_titledeed->LinkCustomAttributes = "";
        $this->file_titledeed->HrefValue = "";
        $this->file_titledeed->ExportHrefValue = $this->file_titledeed->UploadPath . $this->file_titledeed->Upload->DbValue;
        $this->file_titledeed->TooltipValue = "";

        // file_other
        $this->file_other->LinkCustomAttributes = "";
        $this->file_other->HrefValue = "";
        $this->file_other->ExportHrefValue = $this->file_other->UploadPath . $this->file_other->Upload->DbValue;
        $this->file_other->TooltipValue = "";

        // attach_file
        $this->attach_file->LinkCustomAttributes = "";
        $this->attach_file->HrefValue = "";
        $this->attach_file->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // doc_date
        $this->doc_date->LinkCustomAttributes = "";
        $this->doc_date->HrefValue = "";
        $this->doc_date->TooltipValue = "";

        // buyer_booking_asset_id
        $this->buyer_booking_asset_id->LinkCustomAttributes = "";
        $this->buyer_booking_asset_id->HrefValue = "";
        $this->buyer_booking_asset_id->TooltipValue = "";

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

        // asset_deed
        $this->asset_deed->setupEditAttributes();
        $this->asset_deed->EditCustomAttributes = "";
        if (!$this->asset_deed->Raw) {
            $this->asset_deed->CurrentValue = HtmlDecode($this->asset_deed->CurrentValue);
        }
        $this->asset_deed->EditValue = $this->asset_deed->CurrentValue;
        $this->asset_deed->PlaceHolder = RemoveHtml($this->asset_deed->caption());

        // asset_project
        $this->asset_project->setupEditAttributes();
        $this->asset_project->EditCustomAttributes = "";
        if (!$this->asset_project->Raw) {
            $this->asset_project->CurrentValue = HtmlDecode($this->asset_project->CurrentValue);
        }
        $this->asset_project->EditValue = $this->asset_project->CurrentValue;
        $this->asset_project->PlaceHolder = RemoveHtml($this->asset_project->caption());

        // asset_area
        $this->asset_area->setupEditAttributes();
        $this->asset_area->EditCustomAttributes = "";
        if (!$this->asset_area->Raw) {
            $this->asset_area->CurrentValue = HtmlDecode($this->asset_area->CurrentValue);
        }
        $this->asset_area->EditValue = $this->asset_area->CurrentValue;
        $this->asset_area->PlaceHolder = RemoveHtml($this->asset_area->caption());

        // buyer_name
        $this->buyer_name->setupEditAttributes();
        $this->buyer_name->EditCustomAttributes = "";
        if (!$this->buyer_name->Raw) {
            $this->buyer_name->CurrentValue = HtmlDecode($this->buyer_name->CurrentValue);
        }
        $this->buyer_name->EditValue = $this->buyer_name->CurrentValue;
        $this->buyer_name->PlaceHolder = RemoveHtml($this->buyer_name->caption());

        // buyer_lname
        $this->buyer_lname->setupEditAttributes();
        $this->buyer_lname->EditCustomAttributes = "";
        if (!$this->buyer_lname->Raw) {
            $this->buyer_lname->CurrentValue = HtmlDecode($this->buyer_lname->CurrentValue);
        }
        $this->buyer_lname->EditValue = $this->buyer_lname->CurrentValue;
        $this->buyer_lname->PlaceHolder = RemoveHtml($this->buyer_lname->caption());

        // buyer_email
        $this->buyer_email->setupEditAttributes();
        $this->buyer_email->EditCustomAttributes = "";
        if (!$this->buyer_email->Raw) {
            $this->buyer_email->CurrentValue = HtmlDecode($this->buyer_email->CurrentValue);
        }
        $this->buyer_email->EditValue = $this->buyer_email->CurrentValue;
        $this->buyer_email->PlaceHolder = RemoveHtml($this->buyer_email->caption());

        // buyer_idcard
        $this->buyer_idcard->setupEditAttributes();
        $this->buyer_idcard->EditCustomAttributes = "";
        if (!$this->buyer_idcard->Raw) {
            $this->buyer_idcard->CurrentValue = HtmlDecode($this->buyer_idcard->CurrentValue);
        }
        $this->buyer_idcard->EditValue = $this->buyer_idcard->CurrentValue;
        $this->buyer_idcard->PlaceHolder = RemoveHtml($this->buyer_idcard->caption());

        // buyer_homeno
        $this->buyer_homeno->setupEditAttributes();
        $this->buyer_homeno->EditCustomAttributes = "";
        if (!$this->buyer_homeno->Raw) {
            $this->buyer_homeno->CurrentValue = HtmlDecode($this->buyer_homeno->CurrentValue);
        }
        $this->buyer_homeno->EditValue = $this->buyer_homeno->CurrentValue;
        $this->buyer_homeno->PlaceHolder = RemoveHtml($this->buyer_homeno->caption());

        // buyer_witness_name
        $this->buyer_witness_name->setupEditAttributes();
        $this->buyer_witness_name->EditCustomAttributes = "";
        if (!$this->buyer_witness_name->Raw) {
            $this->buyer_witness_name->CurrentValue = HtmlDecode($this->buyer_witness_name->CurrentValue);
        }
        $this->buyer_witness_name->EditValue = $this->buyer_witness_name->CurrentValue;
        $this->buyer_witness_name->PlaceHolder = RemoveHtml($this->buyer_witness_name->caption());

        // buyer_witness_lname
        $this->buyer_witness_lname->setupEditAttributes();
        $this->buyer_witness_lname->EditCustomAttributes = "";
        if (!$this->buyer_witness_lname->Raw) {
            $this->buyer_witness_lname->CurrentValue = HtmlDecode($this->buyer_witness_lname->CurrentValue);
        }
        $this->buyer_witness_lname->EditValue = $this->buyer_witness_lname->CurrentValue;
        $this->buyer_witness_lname->PlaceHolder = RemoveHtml($this->buyer_witness_lname->caption());

        // buyer_witness_email
        $this->buyer_witness_email->setupEditAttributes();
        $this->buyer_witness_email->EditCustomAttributes = "";
        if (!$this->buyer_witness_email->Raw) {
            $this->buyer_witness_email->CurrentValue = HtmlDecode($this->buyer_witness_email->CurrentValue);
        }
        $this->buyer_witness_email->EditValue = $this->buyer_witness_email->CurrentValue;
        $this->buyer_witness_email->PlaceHolder = RemoveHtml($this->buyer_witness_email->caption());

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

        // file_titledeed
        $this->file_titledeed->setupEditAttributes();
        $this->file_titledeed->EditCustomAttributes = "";
        $this->file_titledeed->UploadPath = "/upload/";
        if (!EmptyValue($this->file_titledeed->Upload->DbValue)) {
            $this->file_titledeed->EditValue = $this->file_titledeed->Upload->DbValue;
        } else {
            $this->file_titledeed->EditValue = "";
        }
        if (!EmptyValue($this->file_titledeed->CurrentValue)) {
            $this->file_titledeed->Upload->FileName = $this->file_titledeed->CurrentValue;
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

        // doc_date

        // buyer_booking_asset_id
        $this->buyer_booking_asset_id->setupEditAttributes();
        $this->buyer_booking_asset_id->EditCustomAttributes = "";
        if ($this->buyer_booking_asset_id->getSessionValue() != "") {
            $this->buyer_booking_asset_id->CurrentValue = GetForeignKeyValue($this->buyer_booking_asset_id->getSessionValue());
            $this->buyer_booking_asset_id->ViewValue = $this->buyer_booking_asset_id->CurrentValue;
            $this->buyer_booking_asset_id->ViewValue = FormatNumber($this->buyer_booking_asset_id->ViewValue, $this->buyer_booking_asset_id->formatPattern());
            $this->buyer_booking_asset_id->ViewCustomAttributes = "";
        } else {
            $this->buyer_booking_asset_id->EditValue = $this->buyer_booking_asset_id->CurrentValue;
            $this->buyer_booking_asset_id->PlaceHolder = RemoveHtml($this->buyer_booking_asset_id->caption());
            if (strval($this->buyer_booking_asset_id->EditValue) != "" && is_numeric($this->buyer_booking_asset_id->EditValue)) {
                $this->buyer_booking_asset_id->EditValue = FormatNumber($this->buyer_booking_asset_id->EditValue, null);
            }
        }

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
                    $doc->exportCaption($this->asset_deed);
                    $doc->exportCaption($this->asset_project);
                    $doc->exportCaption($this->asset_area);
                    $doc->exportCaption($this->buyer_name);
                    $doc->exportCaption($this->buyer_lname);
                    $doc->exportCaption($this->buyer_email);
                    $doc->exportCaption($this->buyer_idcard);
                    $doc->exportCaption($this->buyer_homeno);
                    $doc->exportCaption($this->buyer_witness_name);
                    $doc->exportCaption($this->buyer_witness_lname);
                    $doc->exportCaption($this->buyer_witness_email);
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
                    $doc->exportCaption($this->service_price);
                    $doc->exportCaption($this->service_price_txt);
                    $doc->exportCaption($this->first_down);
                    $doc->exportCaption($this->first_down_txt);
                    $doc->exportCaption($this->second_down);
                    $doc->exportCaption($this->second_down_txt);
                    $doc->exportCaption($this->contact_address);
                    $doc->exportCaption($this->contact_address2);
                    $doc->exportCaption($this->contact_email);
                    $doc->exportCaption($this->contact_lineid);
                    $doc->exportCaption($this->contact_phone);
                    $doc->exportCaption($this->file_idcard);
                    $doc->exportCaption($this->file_house_regis);
                    $doc->exportCaption($this->file_titledeed);
                    $doc->exportCaption($this->file_other);
                    $doc->exportCaption($this->attach_file);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->cdate);
                } else {
                    $doc->exportCaption($this->document_date);
                    $doc->exportCaption($this->asset_code);
                    $doc->exportCaption($this->asset_deed);
                    $doc->exportCaption($this->asset_project);
                    $doc->exportCaption($this->asset_area);
                    $doc->exportCaption($this->buyer_lname);
                    $doc->exportCaption($this->buyer_email);
                    $doc->exportCaption($this->buyer_idcard);
                    $doc->exportCaption($this->buyer_homeno);
                    $doc->exportCaption($this->buyer_witness_lname);
                    $doc->exportCaption($this->buyer_witness_email);
                    $doc->exportCaption($this->juzmatch_authority_lname);
                    $doc->exportCaption($this->juzmatch_authority_email);
                    $doc->exportCaption($this->juzmatch_authority_witness_lname);
                    $doc->exportCaption($this->juzmatch_authority_witness_email);
                    $doc->exportCaption($this->juzmatch_authority2_name);
                    $doc->exportCaption($this->juzmatch_authority2_lname);
                    $doc->exportCaption($this->juzmatch_authority2_email);
                    $doc->exportCaption($this->company_seal_name);
                    $doc->exportCaption($this->company_seal_email);
                    $doc->exportCaption($this->service_price);
                    $doc->exportCaption($this->service_price_txt);
                    $doc->exportCaption($this->first_down);
                    $doc->exportCaption($this->first_down_txt);
                    $doc->exportCaption($this->second_down);
                    $doc->exportCaption($this->second_down_txt);
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
                        $doc->exportField($this->asset_deed);
                        $doc->exportField($this->asset_project);
                        $doc->exportField($this->asset_area);
                        $doc->exportField($this->buyer_name);
                        $doc->exportField($this->buyer_lname);
                        $doc->exportField($this->buyer_email);
                        $doc->exportField($this->buyer_idcard);
                        $doc->exportField($this->buyer_homeno);
                        $doc->exportField($this->buyer_witness_name);
                        $doc->exportField($this->buyer_witness_lname);
                        $doc->exportField($this->buyer_witness_email);
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
                        $doc->exportField($this->service_price);
                        $doc->exportField($this->service_price_txt);
                        $doc->exportField($this->first_down);
                        $doc->exportField($this->first_down_txt);
                        $doc->exportField($this->second_down);
                        $doc->exportField($this->second_down_txt);
                        $doc->exportField($this->contact_address);
                        $doc->exportField($this->contact_address2);
                        $doc->exportField($this->contact_email);
                        $doc->exportField($this->contact_lineid);
                        $doc->exportField($this->contact_phone);
                        $doc->exportField($this->file_idcard);
                        $doc->exportField($this->file_house_regis);
                        $doc->exportField($this->file_titledeed);
                        $doc->exportField($this->file_other);
                        $doc->exportField($this->attach_file);
                        $doc->exportField($this->status);
                        $doc->exportField($this->cdate);
                    } else {
                        $doc->exportField($this->document_date);
                        $doc->exportField($this->asset_code);
                        $doc->exportField($this->asset_deed);
                        $doc->exportField($this->asset_project);
                        $doc->exportField($this->asset_area);
                        $doc->exportField($this->buyer_lname);
                        $doc->exportField($this->buyer_email);
                        $doc->exportField($this->buyer_idcard);
                        $doc->exportField($this->buyer_homeno);
                        $doc->exportField($this->buyer_witness_lname);
                        $doc->exportField($this->buyer_witness_email);
                        $doc->exportField($this->juzmatch_authority_lname);
                        $doc->exportField($this->juzmatch_authority_email);
                        $doc->exportField($this->juzmatch_authority_witness_lname);
                        $doc->exportField($this->juzmatch_authority_witness_email);
                        $doc->exportField($this->juzmatch_authority2_name);
                        $doc->exportField($this->juzmatch_authority2_lname);
                        $doc->exportField($this->juzmatch_authority2_email);
                        $doc->exportField($this->company_seal_name);
                        $doc->exportField($this->company_seal_email);
                        $doc->exportField($this->service_price);
                        $doc->exportField($this->service_price_txt);
                        $doc->exportField($this->first_down);
                        $doc->exportField($this->first_down_txt);
                        $doc->exportField($this->second_down);
                        $doc->exportField($this->second_down_txt);
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
        } elseif ($fldparm == 'file_titledeed') {
            $fldName = "file_titledeed";
            $fileNameFld = "file_titledeed";
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

    // Write Audit Trail start/end for grid update
    public function writeAuditTrailDummy($typ)
    {
        $table = 'doc_juzmatch1';
        $usr = CurrentUserID();
        WriteAuditLog($usr, $typ, $table, "", "", "", "");
    }

    // Write Audit Trail (add page)
    public function writeAuditTrailOnAdd(&$rs)
    {
        global $Language;
        if (!$this->AuditTrailOnAdd) {
            return;
        }
        $table = 'doc_juzmatch1';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['id'];

        // Write Audit Trail
        $usr = CurrentUserID();
        foreach (array_keys($rs) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && $this->Fields[$fldname]->DataType != DATATYPE_BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") {
                    $newvalue = $Language->phrase("PasswordMask"); // Password Field
                } elseif ($this->Fields[$fldname]->DataType == DATATYPE_MEMO) {
                    if (Config("AUDIT_TRAIL_TO_DATABASE")) {
                        $newvalue = $rs[$fldname];
                    } else {
                        $newvalue = "[MEMO]"; // Memo Field
                    }
                } elseif ($this->Fields[$fldname]->DataType == DATATYPE_XML) {
                    $newvalue = "[XML]"; // XML Field
                } else {
                    $newvalue = $rs[$fldname];
                }
                WriteAuditLog($usr, "A", $table, $fldname, $key, "", $newvalue);
            }
        }
    }

    // Write Audit Trail (edit page)
    public function writeAuditTrailOnEdit(&$rsold, &$rsnew)
    {
        global $Language;
        if (!$this->AuditTrailOnEdit) {
            return;
        }
        $table = 'doc_juzmatch1';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rsold['id'];

        // Write Audit Trail
        $usr = CurrentUserID();
        foreach (array_keys($rsnew) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && array_key_exists($fldname, $rsold) && $this->Fields[$fldname]->DataType != DATATYPE_BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->DataType == DATATYPE_DATE) { // DateTime field
                    $modified = (FormatDateTime($rsold[$fldname], 0) != FormatDateTime($rsnew[$fldname], 0));
                } else {
                    $modified = !CompareValue($rsold[$fldname], $rsnew[$fldname]);
                }
                if ($modified) {
                    if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") { // Password Field
                        $oldvalue = $Language->phrase("PasswordMask");
                        $newvalue = $Language->phrase("PasswordMask");
                    } elseif ($this->Fields[$fldname]->DataType == DATATYPE_MEMO) { // Memo field
                        if (Config("AUDIT_TRAIL_TO_DATABASE")) {
                            $oldvalue = $rsold[$fldname];
                            $newvalue = $rsnew[$fldname];
                        } else {
                            $oldvalue = "[MEMO]";
                            $newvalue = "[MEMO]";
                        }
                    } elseif ($this->Fields[$fldname]->DataType == DATATYPE_XML) { // XML field
                        $oldvalue = "[XML]";
                        $newvalue = "[XML]";
                    } else {
                        $oldvalue = $rsold[$fldname];
                        $newvalue = $rsnew[$fldname];
                    }
                    WriteAuditLog($usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
                }
            }
        }
    }

    // Write Audit Trail (delete page)
    public function writeAuditTrailOnDelete(&$rs)
    {
        global $Language;
        if (!$this->AuditTrailOnDelete) {
            return;
        }
        $table = 'doc_juzmatch1';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['id'];

        // Write Audit Trail
        $curUser = CurrentUserID();
        foreach (array_keys($rs) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && $this->Fields[$fldname]->DataType != DATATYPE_BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") {
                    $oldvalue = $Language->phrase("PasswordMask"); // Password Field
                } elseif ($this->Fields[$fldname]->DataType == DATATYPE_MEMO) {
                    if (Config("AUDIT_TRAIL_TO_DATABASE")) {
                        $oldvalue = $rs[$fldname];
                    } else {
                        $oldvalue = "[MEMO]"; // Memo field
                    }
                } elseif ($this->Fields[$fldname]->DataType == DATATYPE_XML) {
                    $oldvalue = "[XML]"; // XML field
                } else {
                    $oldvalue = $rs[$fldname];
                }
                WriteAuditLog($curUser, "D", $table, $fldname, $key, $oldvalue, "");
            }
        }
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
