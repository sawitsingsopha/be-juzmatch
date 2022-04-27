<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for article
 */
class Article extends DbTable
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
    public $article_id;
    public $article_category_id;
    public $_title;
    public $title_en;
    public $detail;
    public $detail_en;
    public $image;
    public $order_by;
    public $tag;
    public $highlight;
    public $count_view;
    public $count_share_facebook;
    public $count_share_line;
    public $count_share_twitter;
    public $count_share_email;
    public $active_status;
    public $meta_title;
    public $meta_title_en;
    public $meta_description;
    public $meta_description_en;
    public $meta_keyword;
    public $meta_keyword_en;
    public $og_tag_title;
    public $og_tag_title_en;
    public $og_tag_type;
    public $og_tag_url;
    public $og_tag_description;
    public $og_tag_description_en;
    public $og_tag_image;
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
        $this->TableVar = 'article';
        $this->TableName = 'article';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`article`";
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

        // article_id
        $this->article_id = new DbField(
            'article',
            'article',
            'x_article_id',
            'article_id',
            '`article_id`',
            '`article_id`',
            19,
            10,
            -1,
            false,
            '`article_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->article_id->InputTextType = "text";
        $this->article_id->IsAutoIncrement = true; // Autoincrement field
        $this->article_id->IsPrimaryKey = true; // Primary key field
        $this->article_id->Sortable = false; // Allow sort
        $this->article_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['article_id'] = &$this->article_id;

        // article_category_id
        $this->article_category_id = new DbField(
            'article',
            'article',
            'x_article_category_id',
            'article_category_id',
            '`article_category_id`',
            '`article_category_id`',
            3,
            11,
            -1,
            false,
            '`article_category_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->article_category_id->InputTextType = "text";
        $this->article_category_id->Nullable = false; // NOT NULL field
        $this->article_category_id->Required = true; // Required field
        $this->article_category_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->article_category_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->article_category_id->Lookup = new Lookup('article_category_id', 'article_category', false, 'article_category_id', ["article_title","","",""], [], [], [], [], [], [], '`order_by` ASC', '', "`article_title`");
        $this->article_category_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['article_category_id'] = &$this->article_category_id;

        // title
        $this->_title = new DbField(
            'article',
            'article',
            'x__title',
            'title',
            '`title`',
            '`title`',
            200,
            255,
            -1,
            false,
            '`title`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->_title->InputTextType = "text";
        $this->_title->Nullable = false; // NOT NULL field
        $this->_title->Required = true; // Required field
        $this->Fields['title'] = &$this->_title;

        // title_en
        $this->title_en = new DbField(
            'article',
            'article',
            'x_title_en',
            'title_en',
            '`title_en`',
            '`title_en`',
            200,
            255,
            -1,
            false,
            '`title_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->title_en->InputTextType = "text";
        $this->title_en->Nullable = false; // NOT NULL field
        $this->title_en->Required = true; // Required field
        $this->Fields['title_en'] = &$this->title_en;

        // detail
        $this->detail = new DbField(
            'article',
            'article',
            'x_detail',
            'detail',
            '`detail`',
            '`detail`',
            201,
            65535,
            -1,
            false,
            '`detail`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->detail->InputTextType = "text";
        $this->detail->Nullable = false; // NOT NULL field
        $this->detail->Required = true; // Required field
        $this->Fields['detail'] = &$this->detail;

        // detail_en
        $this->detail_en = new DbField(
            'article',
            'article',
            'x_detail_en',
            'detail_en',
            '`detail_en`',
            '`detail_en`',
            201,
            65535,
            -1,
            false,
            '`detail_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->detail_en->InputTextType = "text";
        $this->detail_en->Nullable = false; // NOT NULL field
        $this->detail_en->Required = true; // Required field
        $this->Fields['detail_en'] = &$this->detail_en;

        // image
        $this->image = new DbField(
            'article',
            'article',
            'x_image',
            'image',
            '`image`',
            '`image`',
            200,
            255,
            -1,
            true,
            '`image`',
            false,
            false,
            false,
            'IMAGE',
            'FILE'
        );
        $this->image->InputTextType = "text";
        $this->image->Required = true; // Required field
        $this->image->UploadAllowedFileExt = "jpg,jpeg,png";
        $this->image->UploadMaxFileSize = 300000;
        $this->image->UploadPath = './upload/Juzhightlight';
        $this->Fields['image'] = &$this->image;

        // order_by
        $this->order_by = new DbField(
            'article',
            'article',
            'x_order_by',
            'order_by',
            '`order_by`',
            '`order_by`',
            3,
            11,
            -1,
            false,
            '`order_by`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->order_by->InputTextType = "text";
        $this->order_by->Nullable = false; // NOT NULL field
        $this->order_by->Required = true; // Required field
        $this->order_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['order_by'] = &$this->order_by;

        // tag
        $this->tag = new DbField(
            'article',
            'article',
            'x_tag',
            'tag',
            '`tag`',
            '`tag`',
            200,
            255,
            -1,
            false,
            '`tag`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->tag->InputTextType = "text";
        $this->tag->Required = true; // Required field
        $this->Fields['tag'] = &$this->tag;

        // highlight
        $this->highlight = new DbField(
            'article',
            'article',
            'x_highlight',
            'highlight',
            '`highlight`',
            '`highlight`',
            3,
            11,
            -1,
            false,
            '`highlight`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->highlight->InputTextType = "text";
        $this->highlight->Lookup = new Lookup('highlight', 'article', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->highlight->OptionCount = 2;
        $this->highlight->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['highlight'] = &$this->highlight;

        // count_view
        $this->count_view = new DbField(
            'article',
            'article',
            'x_count_view',
            'count_view',
            '`count_view`',
            '`count_view`',
            19,
            11,
            -1,
            false,
            '`count_view`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->count_view->InputTextType = "text";
        $this->count_view->Required = true; // Required field
        $this->count_view->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['count_view'] = &$this->count_view;

        // count_share_facebook
        $this->count_share_facebook = new DbField(
            'article',
            'article',
            'x_count_share_facebook',
            'count_share_facebook',
            '`count_share_facebook`',
            '`count_share_facebook`',
            19,
            11,
            -1,
            false,
            '`count_share_facebook`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->count_share_facebook->InputTextType = "text";
        $this->count_share_facebook->Required = true; // Required field
        $this->count_share_facebook->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['count_share_facebook'] = &$this->count_share_facebook;

        // count_share_line
        $this->count_share_line = new DbField(
            'article',
            'article',
            'x_count_share_line',
            'count_share_line',
            '`count_share_line`',
            '`count_share_line`',
            19,
            11,
            -1,
            false,
            '`count_share_line`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->count_share_line->InputTextType = "text";
        $this->count_share_line->Required = true; // Required field
        $this->count_share_line->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['count_share_line'] = &$this->count_share_line;

        // count_share_twitter
        $this->count_share_twitter = new DbField(
            'article',
            'article',
            'x_count_share_twitter',
            'count_share_twitter',
            '`count_share_twitter`',
            '`count_share_twitter`',
            19,
            11,
            -1,
            false,
            '`count_share_twitter`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->count_share_twitter->InputTextType = "text";
        $this->count_share_twitter->Required = true; // Required field
        $this->count_share_twitter->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['count_share_twitter'] = &$this->count_share_twitter;

        // count_share_email
        $this->count_share_email = new DbField(
            'article',
            'article',
            'x_count_share_email',
            'count_share_email',
            '`count_share_email`',
            '`count_share_email`',
            19,
            11,
            -1,
            false,
            '`count_share_email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->count_share_email->InputTextType = "text";
        $this->count_share_email->Required = true; // Required field
        $this->count_share_email->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['count_share_email'] = &$this->count_share_email;

        // active_status
        $this->active_status = new DbField(
            'article',
            'article',
            'x_active_status',
            'active_status',
            '`active_status`',
            '`active_status`',
            3,
            11,
            -1,
            false,
            '`active_status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->active_status->InputTextType = "text";
        $this->active_status->Required = true; // Required field
        $this->active_status->Lookup = new Lookup('active_status', 'article', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->active_status->OptionCount = 2;
        $this->active_status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['active_status'] = &$this->active_status;

        // meta_title
        $this->meta_title = new DbField(
            'article',
            'article',
            'x_meta_title',
            'meta_title',
            '`meta_title`',
            '`meta_title`',
            200,
            60,
            -1,
            false,
            '`meta_title`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->meta_title->InputTextType = "text";
        $this->Fields['meta_title'] = &$this->meta_title;

        // meta_title_en
        $this->meta_title_en = new DbField(
            'article',
            'article',
            'x_meta_title_en',
            'meta_title_en',
            '`meta_title_en`',
            '`meta_title_en`',
            200,
            60,
            -1,
            false,
            '`meta_title_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->meta_title_en->InputTextType = "text";
        $this->Fields['meta_title_en'] = &$this->meta_title_en;

        // meta_description
        $this->meta_description = new DbField(
            'article',
            'article',
            'x_meta_description',
            'meta_description',
            '`meta_description`',
            '`meta_description`',
            200,
            160,
            -1,
            false,
            '`meta_description`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->meta_description->InputTextType = "text";
        $this->Fields['meta_description'] = &$this->meta_description;

        // meta_description_en
        $this->meta_description_en = new DbField(
            'article',
            'article',
            'x_meta_description_en',
            'meta_description_en',
            '`meta_description_en`',
            '`meta_description_en`',
            200,
            160,
            -1,
            false,
            '`meta_description_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->meta_description_en->InputTextType = "text";
        $this->Fields['meta_description_en'] = &$this->meta_description_en;

        // meta_keyword
        $this->meta_keyword = new DbField(
            'article',
            'article',
            'x_meta_keyword',
            'meta_keyword',
            '`meta_keyword`',
            '`meta_keyword`',
            201,
            65535,
            -1,
            false,
            '`meta_keyword`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->meta_keyword->InputTextType = "text";
        $this->Fields['meta_keyword'] = &$this->meta_keyword;

        // meta_keyword_en
        $this->meta_keyword_en = new DbField(
            'article',
            'article',
            'x_meta_keyword_en',
            'meta_keyword_en',
            '`meta_keyword_en`',
            '`meta_keyword_en`',
            201,
            65535,
            -1,
            false,
            '`meta_keyword_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->meta_keyword_en->InputTextType = "text";
        $this->Fields['meta_keyword_en'] = &$this->meta_keyword_en;

        // og_tag_title
        $this->og_tag_title = new DbField(
            'article',
            'article',
            'x_og_tag_title',
            'og_tag_title',
            '`og_tag_title`',
            '`og_tag_title`',
            200,
            100,
            -1,
            false,
            '`og_tag_title`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->og_tag_title->InputTextType = "text";
        $this->og_tag_title->Sortable = false; // Allow sort
        $this->Fields['og_tag_title'] = &$this->og_tag_title;

        // og_tag_title_en
        $this->og_tag_title_en = new DbField(
            'article',
            'article',
            'x_og_tag_title_en',
            'og_tag_title_en',
            '`og_tag_title_en`',
            '`og_tag_title_en`',
            200,
            100,
            -1,
            false,
            '`og_tag_title_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->og_tag_title_en->InputTextType = "text";
        $this->og_tag_title_en->Sortable = false; // Allow sort
        $this->Fields['og_tag_title_en'] = &$this->og_tag_title_en;

        // og_tag_type
        $this->og_tag_type = new DbField(
            'article',
            'article',
            'x_og_tag_type',
            'og_tag_type',
            '`og_tag_type`',
            '`og_tag_type`',
            200,
            255,
            -1,
            false,
            '`og_tag_type`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->og_tag_type->InputTextType = "text";
        $this->og_tag_type->Sortable = false; // Allow sort
        $this->Fields['og_tag_type'] = &$this->og_tag_type;

        // og_tag_url
        $this->og_tag_url = new DbField(
            'article',
            'article',
            'x_og_tag_url',
            'og_tag_url',
            '`og_tag_url`',
            '`og_tag_url`',
            200,
            255,
            -1,
            false,
            '`og_tag_url`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->og_tag_url->InputTextType = "text";
        $this->og_tag_url->Sortable = false; // Allow sort
        $this->Fields['og_tag_url'] = &$this->og_tag_url;

        // og_tag_description
        $this->og_tag_description = new DbField(
            'article',
            'article',
            'x_og_tag_description',
            'og_tag_description',
            '`og_tag_description`',
            '`og_tag_description`',
            200,
            255,
            -1,
            false,
            '`og_tag_description`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->og_tag_description->InputTextType = "text";
        $this->og_tag_description->Sortable = false; // Allow sort
        $this->Fields['og_tag_description'] = &$this->og_tag_description;

        // og_tag_description_en
        $this->og_tag_description_en = new DbField(
            'article',
            'article',
            'x_og_tag_description_en',
            'og_tag_description_en',
            '`og_tag_description_en`',
            '`og_tag_description_en`',
            200,
            255,
            -1,
            false,
            '`og_tag_description_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->og_tag_description_en->InputTextType = "text";
        $this->og_tag_description_en->Sortable = false; // Allow sort
        $this->Fields['og_tag_description_en'] = &$this->og_tag_description_en;

        // og_tag_image
        $this->og_tag_image = new DbField(
            'article',
            'article',
            'x_og_tag_image',
            'og_tag_image',
            '`og_tag_image`',
            '`og_tag_image`',
            200,
            255,
            -1,
            false,
            '`og_tag_image`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->og_tag_image->InputTextType = "text";
        $this->og_tag_image->Sortable = false; // Allow sort
        $this->Fields['og_tag_image'] = &$this->og_tag_image;

        // cdate
        $this->cdate = new DbField(
            'article',
            'article',
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
            'article',
            'article',
            'x_cuser',
            'cuser',
            '`cuser`',
            '`cuser`',
            200,
            36,
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
            'article',
            'article',
            'x_cip',
            'cip',
            '`cip`',
            '`cip`',
            200,
            36,
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
            'article',
            'article',
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
            'article',
            'article',
            'x_uuser',
            'uuser',
            '`uuser`',
            '`uuser`',
            200,
            36,
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
            'article',
            'article',
            'x_uip',
            'uip',
            '`uip`',
            '`uip`',
            200,
            36,
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

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`article`";
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
            $this->article_id->setDbValue($conn->lastInsertId());
            $rs['article_id'] = $this->article_id->DbValue;
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
            $fldname = 'article_id';
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
            if (array_key_exists('article_id', $rs)) {
                AddFilter($where, QuotedName('article_id', $this->Dbid) . '=' . QuotedValue($rs['article_id'], $this->article_id->DataType, $this->Dbid));
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
        $this->article_id->DbValue = $row['article_id'];
        $this->article_category_id->DbValue = $row['article_category_id'];
        $this->_title->DbValue = $row['title'];
        $this->title_en->DbValue = $row['title_en'];
        $this->detail->DbValue = $row['detail'];
        $this->detail_en->DbValue = $row['detail_en'];
        $this->image->Upload->DbValue = $row['image'];
        $this->order_by->DbValue = $row['order_by'];
        $this->tag->DbValue = $row['tag'];
        $this->highlight->DbValue = $row['highlight'];
        $this->count_view->DbValue = $row['count_view'];
        $this->count_share_facebook->DbValue = $row['count_share_facebook'];
        $this->count_share_line->DbValue = $row['count_share_line'];
        $this->count_share_twitter->DbValue = $row['count_share_twitter'];
        $this->count_share_email->DbValue = $row['count_share_email'];
        $this->active_status->DbValue = $row['active_status'];
        $this->meta_title->DbValue = $row['meta_title'];
        $this->meta_title_en->DbValue = $row['meta_title_en'];
        $this->meta_description->DbValue = $row['meta_description'];
        $this->meta_description_en->DbValue = $row['meta_description_en'];
        $this->meta_keyword->DbValue = $row['meta_keyword'];
        $this->meta_keyword_en->DbValue = $row['meta_keyword_en'];
        $this->og_tag_title->DbValue = $row['og_tag_title'];
        $this->og_tag_title_en->DbValue = $row['og_tag_title_en'];
        $this->og_tag_type->DbValue = $row['og_tag_type'];
        $this->og_tag_url->DbValue = $row['og_tag_url'];
        $this->og_tag_description->DbValue = $row['og_tag_description'];
        $this->og_tag_description_en->DbValue = $row['og_tag_description_en'];
        $this->og_tag_image->DbValue = $row['og_tag_image'];
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
        $this->image->OldUploadPath = './upload/Juzhightlight';
        $oldFiles = EmptyValue($row['image']) ? [] : [$row['image']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->image->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->image->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`article_id` = @article_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->article_id->CurrentValue : $this->article_id->OldValue;
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
                $this->article_id->CurrentValue = $keys[0];
            } else {
                $this->article_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('article_id', $row) ? $row['article_id'] : null;
        } else {
            $val = $this->article_id->OldValue !== null ? $this->article_id->OldValue : $this->article_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@article_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("articlelist");
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
        if ($pageName == "articleview") {
            return $Language->phrase("View");
        } elseif ($pageName == "articleedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "articleadd") {
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
                return "ArticleView";
            case Config("API_ADD_ACTION"):
                return "ArticleAdd";
            case Config("API_EDIT_ACTION"):
                return "ArticleEdit";
            case Config("API_DELETE_ACTION"):
                return "ArticleDelete";
            case Config("API_LIST_ACTION"):
                return "ArticleList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "articlelist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("articleview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("articleview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "articleadd?" . $this->getUrlParm($parm);
        } else {
            $url = "articleadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("articleedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("articleadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("articledelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"article_id\":" . JsonEncode($this->article_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->article_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->article_id->CurrentValue);
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
            if (($keyValue = Param("article_id") ?? Route("article_id")) !== null) {
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
                $this->article_id->CurrentValue = $key;
            } else {
                $this->article_id->OldValue = $key;
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
        $this->article_id->setDbValue($row['article_id']);
        $this->article_category_id->setDbValue($row['article_category_id']);
        $this->_title->setDbValue($row['title']);
        $this->title_en->setDbValue($row['title_en']);
        $this->detail->setDbValue($row['detail']);
        $this->detail_en->setDbValue($row['detail_en']);
        $this->image->Upload->DbValue = $row['image'];
        $this->order_by->setDbValue($row['order_by']);
        $this->tag->setDbValue($row['tag']);
        $this->highlight->setDbValue($row['highlight']);
        $this->count_view->setDbValue($row['count_view']);
        $this->count_share_facebook->setDbValue($row['count_share_facebook']);
        $this->count_share_line->setDbValue($row['count_share_line']);
        $this->count_share_twitter->setDbValue($row['count_share_twitter']);
        $this->count_share_email->setDbValue($row['count_share_email']);
        $this->active_status->setDbValue($row['active_status']);
        $this->meta_title->setDbValue($row['meta_title']);
        $this->meta_title_en->setDbValue($row['meta_title_en']);
        $this->meta_description->setDbValue($row['meta_description']);
        $this->meta_description_en->setDbValue($row['meta_description_en']);
        $this->meta_keyword->setDbValue($row['meta_keyword']);
        $this->meta_keyword_en->setDbValue($row['meta_keyword_en']);
        $this->og_tag_title->setDbValue($row['og_tag_title']);
        $this->og_tag_title_en->setDbValue($row['og_tag_title_en']);
        $this->og_tag_type->setDbValue($row['og_tag_type']);
        $this->og_tag_url->setDbValue($row['og_tag_url']);
        $this->og_tag_description->setDbValue($row['og_tag_description']);
        $this->og_tag_description_en->setDbValue($row['og_tag_description_en']);
        $this->og_tag_image->setDbValue($row['og_tag_image']);
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

        // article_id

        // article_category_id

        // title

        // title_en

        // detail

        // detail_en

        // image

        // order_by

        // tag

        // highlight

        // count_view

        // count_share_facebook

        // count_share_line

        // count_share_twitter

        // count_share_email

        // active_status

        // meta_title

        // meta_title_en

        // meta_description

        // meta_description_en

        // meta_keyword

        // meta_keyword_en

        // og_tag_title
        $this->og_tag_title->CellCssStyle = "white-space: nowrap;";

        // og_tag_title_en
        $this->og_tag_title_en->CellCssStyle = "white-space: nowrap;";

        // og_tag_type
        $this->og_tag_type->CellCssStyle = "white-space: nowrap;";

        // og_tag_url
        $this->og_tag_url->CellCssStyle = "white-space: nowrap;";

        // og_tag_description
        $this->og_tag_description->CellCssStyle = "white-space: nowrap;";

        // og_tag_description_en
        $this->og_tag_description_en->CellCssStyle = "white-space: nowrap;";

        // og_tag_image
        $this->og_tag_image->CellCssStyle = "white-space: nowrap;";

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // article_id
        $this->article_id->ViewValue = $this->article_id->CurrentValue;
        $this->article_id->ViewCustomAttributes = "";

        // article_category_id
        $curVal = strval($this->article_category_id->CurrentValue);
        if ($curVal != "") {
            $this->article_category_id->ViewValue = $this->article_category_id->lookupCacheOption($curVal);
            if ($this->article_category_id->ViewValue === null) { // Lookup from database
                $filterWrk = "`article_category_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return "`active_status` = 1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->article_category_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->article_category_id->Lookup->renderViewRow($rswrk[0]);
                    $this->article_category_id->ViewValue = $this->article_category_id->displayValue($arwrk);
                } else {
                    $this->article_category_id->ViewValue = FormatNumber($this->article_category_id->CurrentValue, $this->article_category_id->formatPattern());
                }
            }
        } else {
            $this->article_category_id->ViewValue = null;
        }
        $this->article_category_id->ViewCustomAttributes = "";

        // title
        $this->_title->ViewValue = $this->_title->CurrentValue;
        $this->_title->ViewCustomAttributes = "";

        // title_en
        $this->title_en->ViewValue = $this->title_en->CurrentValue;
        $this->title_en->ViewCustomAttributes = "";

        // detail
        $this->detail->ViewValue = $this->detail->CurrentValue;
        $this->detail->ViewCustomAttributes = "";

        // detail_en
        $this->detail_en->ViewValue = $this->detail_en->CurrentValue;
        $this->detail_en->ViewCustomAttributes = "";

        // image
        $this->image->UploadPath = './upload/Juzhightlight';
        if (!EmptyValue($this->image->Upload->DbValue)) {
            $this->image->ImageWidth = 100;
            $this->image->ImageHeight = 100;
            $this->image->ImageAlt = $this->image->alt();
            $this->image->ImageCssClass = "ew-image";
            $this->image->ViewValue = $this->image->Upload->DbValue;
        } else {
            $this->image->ViewValue = "";
        }
        $this->image->ViewCustomAttributes = "";

        // order_by
        $this->order_by->ViewValue = $this->order_by->CurrentValue;
        $this->order_by->ViewValue = FormatNumber($this->order_by->ViewValue, $this->order_by->formatPattern());
        $this->order_by->ViewCustomAttributes = "";

        // tag
        $this->tag->ViewValue = $this->tag->CurrentValue;
        $this->tag->ViewCustomAttributes = "";

        // highlight
        if (strval($this->highlight->CurrentValue) != "") {
            $this->highlight->ViewValue = $this->highlight->optionCaption($this->highlight->CurrentValue);
        } else {
            $this->highlight->ViewValue = null;
        }
        $this->highlight->ViewCustomAttributes = "";

        // count_view
        $this->count_view->ViewValue = $this->count_view->CurrentValue;
        $this->count_view->ViewValue = FormatNumber($this->count_view->ViewValue, $this->count_view->formatPattern());
        $this->count_view->ViewCustomAttributes = "";

        // count_share_facebook
        $this->count_share_facebook->ViewValue = $this->count_share_facebook->CurrentValue;
        $this->count_share_facebook->ViewValue = FormatNumber($this->count_share_facebook->ViewValue, $this->count_share_facebook->formatPattern());
        $this->count_share_facebook->ViewCustomAttributes = "";

        // count_share_line
        $this->count_share_line->ViewValue = $this->count_share_line->CurrentValue;
        $this->count_share_line->ViewValue = FormatNumber($this->count_share_line->ViewValue, $this->count_share_line->formatPattern());
        $this->count_share_line->ViewCustomAttributes = "";

        // count_share_twitter
        $this->count_share_twitter->ViewValue = $this->count_share_twitter->CurrentValue;
        $this->count_share_twitter->ViewValue = FormatNumber($this->count_share_twitter->ViewValue, $this->count_share_twitter->formatPattern());
        $this->count_share_twitter->ViewCustomAttributes = "";

        // count_share_email
        $this->count_share_email->ViewValue = $this->count_share_email->CurrentValue;
        $this->count_share_email->ViewValue = FormatNumber($this->count_share_email->ViewValue, $this->count_share_email->formatPattern());
        $this->count_share_email->ViewCustomAttributes = "";

        // active_status
        if (strval($this->active_status->CurrentValue) != "") {
            $this->active_status->ViewValue = $this->active_status->optionCaption($this->active_status->CurrentValue);
        } else {
            $this->active_status->ViewValue = null;
        }
        $this->active_status->ViewCustomAttributes = "";

        // meta_title
        $this->meta_title->ViewValue = $this->meta_title->CurrentValue;
        $this->meta_title->ViewCustomAttributes = "";

        // meta_title_en
        $this->meta_title_en->ViewValue = $this->meta_title_en->CurrentValue;
        $this->meta_title_en->ViewCustomAttributes = "";

        // meta_description
        $this->meta_description->ViewValue = $this->meta_description->CurrentValue;
        $this->meta_description->ViewCustomAttributes = "";

        // meta_description_en
        $this->meta_description_en->ViewValue = $this->meta_description_en->CurrentValue;
        $this->meta_description_en->ViewCustomAttributes = "";

        // meta_keyword
        $this->meta_keyword->ViewValue = $this->meta_keyword->CurrentValue;
        $this->meta_keyword->ViewCustomAttributes = "";

        // meta_keyword_en
        $this->meta_keyword_en->ViewValue = $this->meta_keyword_en->CurrentValue;
        $this->meta_keyword_en->ViewCustomAttributes = "";

        // og_tag_title
        $this->og_tag_title->ViewValue = $this->og_tag_title->CurrentValue;
        $this->og_tag_title->ViewCustomAttributes = "";

        // og_tag_title_en
        $this->og_tag_title_en->ViewValue = $this->og_tag_title_en->CurrentValue;
        $this->og_tag_title_en->ViewCustomAttributes = "";

        // og_tag_type
        $this->og_tag_type->ViewValue = $this->og_tag_type->CurrentValue;
        $this->og_tag_type->ViewCustomAttributes = "";

        // og_tag_url
        $this->og_tag_url->ViewValue = $this->og_tag_url->CurrentValue;
        $this->og_tag_url->ViewCustomAttributes = "";

        // og_tag_description
        $this->og_tag_description->ViewValue = $this->og_tag_description->CurrentValue;
        $this->og_tag_description->ViewCustomAttributes = "";

        // og_tag_description_en
        $this->og_tag_description_en->ViewValue = $this->og_tag_description_en->CurrentValue;
        $this->og_tag_description_en->ViewCustomAttributes = "";

        // og_tag_image
        $this->og_tag_image->ViewValue = $this->og_tag_image->CurrentValue;
        $this->og_tag_image->ViewCustomAttributes = "";

        // cdate
        $this->cdate->ViewValue = $this->cdate->CurrentValue;
        $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
        $this->cdate->ViewCustomAttributes = "";

        // cuser
        $this->cuser->ViewValue = $this->cuser->CurrentValue;
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
        $this->uuser->ViewCustomAttributes = "";

        // uip
        $this->uip->ViewValue = $this->uip->CurrentValue;
        $this->uip->ViewCustomAttributes = "";

        // article_id
        $this->article_id->LinkCustomAttributes = "";
        $this->article_id->HrefValue = "";
        $this->article_id->TooltipValue = "";

        // article_category_id
        $this->article_category_id->LinkCustomAttributes = "";
        $this->article_category_id->HrefValue = "";
        $this->article_category_id->TooltipValue = "";

        // title
        $this->_title->LinkCustomAttributes = "";
        $this->_title->HrefValue = "";
        $this->_title->TooltipValue = "";

        // title_en
        $this->title_en->LinkCustomAttributes = "";
        $this->title_en->HrefValue = "";
        $this->title_en->TooltipValue = "";

        // detail
        $this->detail->LinkCustomAttributes = "";
        $this->detail->HrefValue = "";
        $this->detail->TooltipValue = "";

        // detail_en
        $this->detail_en->LinkCustomAttributes = "";
        $this->detail_en->HrefValue = "";
        $this->detail_en->TooltipValue = "";

        // image
        $this->image->LinkCustomAttributes = "";
        $this->image->UploadPath = './upload/Juzhightlight';
        if (!EmptyValue($this->image->Upload->DbValue)) {
            $this->image->HrefValue = GetFileUploadUrl($this->image, $this->image->htmlDecode($this->image->Upload->DbValue)); // Add prefix/suffix
            $this->image->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->image->HrefValue = FullUrl($this->image->HrefValue, "href");
            }
        } else {
            $this->image->HrefValue = "";
        }
        $this->image->ExportHrefValue = $this->image->UploadPath . $this->image->Upload->DbValue;
        $this->image->TooltipValue = "";
        if ($this->image->UseColorbox) {
            if (EmptyValue($this->image->TooltipValue)) {
                $this->image->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->image->LinkAttrs["data-rel"] = "article_x_image";
            $this->image->LinkAttrs->appendClass("ew-lightbox");
        }

        // order_by
        $this->order_by->LinkCustomAttributes = "";
        $this->order_by->HrefValue = "";
        $this->order_by->TooltipValue = "";

        // tag
        $this->tag->LinkCustomAttributes = "";
        $this->tag->HrefValue = "";
        $this->tag->TooltipValue = "";

        // highlight
        $this->highlight->LinkCustomAttributes = "";
        $this->highlight->HrefValue = "";
        $this->highlight->TooltipValue = "";

        // count_view
        $this->count_view->LinkCustomAttributes = "";
        $this->count_view->HrefValue = "";
        $this->count_view->TooltipValue = "";

        // count_share_facebook
        $this->count_share_facebook->LinkCustomAttributes = "";
        $this->count_share_facebook->HrefValue = "";
        $this->count_share_facebook->TooltipValue = "";

        // count_share_line
        $this->count_share_line->LinkCustomAttributes = "";
        $this->count_share_line->HrefValue = "";
        $this->count_share_line->TooltipValue = "";

        // count_share_twitter
        $this->count_share_twitter->LinkCustomAttributes = "";
        $this->count_share_twitter->HrefValue = "";
        $this->count_share_twitter->TooltipValue = "";

        // count_share_email
        $this->count_share_email->LinkCustomAttributes = "";
        $this->count_share_email->HrefValue = "";
        $this->count_share_email->TooltipValue = "";

        // active_status
        $this->active_status->LinkCustomAttributes = "";
        $this->active_status->HrefValue = "";
        $this->active_status->TooltipValue = "";

        // meta_title
        $this->meta_title->LinkCustomAttributes = "";
        $this->meta_title->HrefValue = "";
        $this->meta_title->TooltipValue = "";

        // meta_title_en
        $this->meta_title_en->LinkCustomAttributes = "";
        $this->meta_title_en->HrefValue = "";
        $this->meta_title_en->TooltipValue = "";

        // meta_description
        $this->meta_description->LinkCustomAttributes = "";
        $this->meta_description->HrefValue = "";
        $this->meta_description->TooltipValue = "";

        // meta_description_en
        $this->meta_description_en->LinkCustomAttributes = "";
        $this->meta_description_en->HrefValue = "";
        $this->meta_description_en->TooltipValue = "";

        // meta_keyword
        $this->meta_keyword->LinkCustomAttributes = "";
        $this->meta_keyword->HrefValue = "";
        $this->meta_keyword->TooltipValue = "";

        // meta_keyword_en
        $this->meta_keyword_en->LinkCustomAttributes = "";
        $this->meta_keyword_en->HrefValue = "";
        $this->meta_keyword_en->TooltipValue = "";

        // og_tag_title
        $this->og_tag_title->LinkCustomAttributes = "";
        $this->og_tag_title->HrefValue = "";
        $this->og_tag_title->TooltipValue = "";

        // og_tag_title_en
        $this->og_tag_title_en->LinkCustomAttributes = "";
        $this->og_tag_title_en->HrefValue = "";
        $this->og_tag_title_en->TooltipValue = "";

        // og_tag_type
        $this->og_tag_type->LinkCustomAttributes = "";
        $this->og_tag_type->HrefValue = "";
        $this->og_tag_type->TooltipValue = "";

        // og_tag_url
        $this->og_tag_url->LinkCustomAttributes = "";
        $this->og_tag_url->HrefValue = "";
        $this->og_tag_url->TooltipValue = "";

        // og_tag_description
        $this->og_tag_description->LinkCustomAttributes = "";
        $this->og_tag_description->HrefValue = "";
        $this->og_tag_description->TooltipValue = "";

        // og_tag_description_en
        $this->og_tag_description_en->LinkCustomAttributes = "";
        $this->og_tag_description_en->HrefValue = "";
        $this->og_tag_description_en->TooltipValue = "";

        // og_tag_image
        $this->og_tag_image->LinkCustomAttributes = "";
        $this->og_tag_image->HrefValue = "";
        $this->og_tag_image->TooltipValue = "";

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

        // article_id
        $this->article_id->setupEditAttributes();
        $this->article_id->EditCustomAttributes = "";
        $this->article_id->EditValue = $this->article_id->CurrentValue;
        $this->article_id->ViewCustomAttributes = "";

        // article_category_id
        $this->article_category_id->setupEditAttributes();
        $this->article_category_id->EditCustomAttributes = "";
        $this->article_category_id->PlaceHolder = RemoveHtml($this->article_category_id->caption());

        // title
        $this->_title->setupEditAttributes();
        $this->_title->EditCustomAttributes = "";
        if (!$this->_title->Raw) {
            $this->_title->CurrentValue = HtmlDecode($this->_title->CurrentValue);
        }
        $this->_title->EditValue = $this->_title->CurrentValue;
        $this->_title->PlaceHolder = RemoveHtml($this->_title->caption());

        // title_en
        $this->title_en->setupEditAttributes();
        $this->title_en->EditCustomAttributes = "";
        if (!$this->title_en->Raw) {
            $this->title_en->CurrentValue = HtmlDecode($this->title_en->CurrentValue);
        }
        $this->title_en->EditValue = $this->title_en->CurrentValue;
        $this->title_en->PlaceHolder = RemoveHtml($this->title_en->caption());

        // detail
        $this->detail->setupEditAttributes();
        $this->detail->EditCustomAttributes = "";
        $this->detail->EditValue = $this->detail->CurrentValue;
        $this->detail->PlaceHolder = RemoveHtml($this->detail->caption());

        // detail_en
        $this->detail_en->setupEditAttributes();
        $this->detail_en->EditCustomAttributes = "";
        $this->detail_en->EditValue = $this->detail_en->CurrentValue;
        $this->detail_en->PlaceHolder = RemoveHtml($this->detail_en->caption());

        // image
        $this->image->setupEditAttributes();
        $this->image->EditCustomAttributes = "";
        $this->image->UploadPath = './upload/Juzhightlight';
        if (!EmptyValue($this->image->Upload->DbValue)) {
            $this->image->ImageWidth = 100;
            $this->image->ImageHeight = 100;
            $this->image->ImageAlt = $this->image->alt();
            $this->image->ImageCssClass = "ew-image";
            $this->image->EditValue = $this->image->Upload->DbValue;
        } else {
            $this->image->EditValue = "";
        }
        if (!EmptyValue($this->image->CurrentValue)) {
            $this->image->Upload->FileName = $this->image->CurrentValue;
        }

        // order_by
        $this->order_by->setupEditAttributes();
        $this->order_by->EditCustomAttributes = "";
        $this->order_by->EditValue = $this->order_by->CurrentValue;
        $this->order_by->PlaceHolder = RemoveHtml($this->order_by->caption());
        if (strval($this->order_by->EditValue) != "" && is_numeric($this->order_by->EditValue)) {
            $this->order_by->EditValue = FormatNumber($this->order_by->EditValue, null);
        }

        // tag
        $this->tag->setupEditAttributes();
        $this->tag->EditCustomAttributes = "";
        if (!$this->tag->Raw) {
            $this->tag->CurrentValue = HtmlDecode($this->tag->CurrentValue);
        }
        $this->tag->EditValue = $this->tag->CurrentValue;
        $this->tag->PlaceHolder = RemoveHtml($this->tag->caption());

        // highlight
        $this->highlight->EditCustomAttributes = "";
        $this->highlight->EditValue = $this->highlight->options(false);
        $this->highlight->PlaceHolder = RemoveHtml($this->highlight->caption());

        // count_view
        $this->count_view->setupEditAttributes();
        $this->count_view->EditCustomAttributes = "";
        $this->count_view->EditValue = $this->count_view->CurrentValue;
        $this->count_view->PlaceHolder = RemoveHtml($this->count_view->caption());
        if (strval($this->count_view->EditValue) != "" && is_numeric($this->count_view->EditValue)) {
            $this->count_view->EditValue = FormatNumber($this->count_view->EditValue, null);
        }

        // count_share_facebook
        $this->count_share_facebook->setupEditAttributes();
        $this->count_share_facebook->EditCustomAttributes = "";
        $this->count_share_facebook->EditValue = $this->count_share_facebook->CurrentValue;
        $this->count_share_facebook->PlaceHolder = RemoveHtml($this->count_share_facebook->caption());
        if (strval($this->count_share_facebook->EditValue) != "" && is_numeric($this->count_share_facebook->EditValue)) {
            $this->count_share_facebook->EditValue = FormatNumber($this->count_share_facebook->EditValue, null);
        }

        // count_share_line
        $this->count_share_line->setupEditAttributes();
        $this->count_share_line->EditCustomAttributes = "";
        $this->count_share_line->EditValue = $this->count_share_line->CurrentValue;
        $this->count_share_line->PlaceHolder = RemoveHtml($this->count_share_line->caption());
        if (strval($this->count_share_line->EditValue) != "" && is_numeric($this->count_share_line->EditValue)) {
            $this->count_share_line->EditValue = FormatNumber($this->count_share_line->EditValue, null);
        }

        // count_share_twitter
        $this->count_share_twitter->setupEditAttributes();
        $this->count_share_twitter->EditCustomAttributes = "";
        $this->count_share_twitter->EditValue = $this->count_share_twitter->CurrentValue;
        $this->count_share_twitter->PlaceHolder = RemoveHtml($this->count_share_twitter->caption());
        if (strval($this->count_share_twitter->EditValue) != "" && is_numeric($this->count_share_twitter->EditValue)) {
            $this->count_share_twitter->EditValue = FormatNumber($this->count_share_twitter->EditValue, null);
        }

        // count_share_email
        $this->count_share_email->setupEditAttributes();
        $this->count_share_email->EditCustomAttributes = "";
        $this->count_share_email->EditValue = $this->count_share_email->CurrentValue;
        $this->count_share_email->PlaceHolder = RemoveHtml($this->count_share_email->caption());
        if (strval($this->count_share_email->EditValue) != "" && is_numeric($this->count_share_email->EditValue)) {
            $this->count_share_email->EditValue = FormatNumber($this->count_share_email->EditValue, null);
        }

        // active_status
        $this->active_status->EditCustomAttributes = "";
        $this->active_status->EditValue = $this->active_status->options(false);
        $this->active_status->PlaceHolder = RemoveHtml($this->active_status->caption());

        // meta_title
        $this->meta_title->setupEditAttributes();
        $this->meta_title->EditCustomAttributes = "";
        if (!$this->meta_title->Raw) {
            $this->meta_title->CurrentValue = HtmlDecode($this->meta_title->CurrentValue);
        }
        $this->meta_title->EditValue = $this->meta_title->CurrentValue;
        $this->meta_title->PlaceHolder = RemoveHtml($this->meta_title->caption());

        // meta_title_en
        $this->meta_title_en->setupEditAttributes();
        $this->meta_title_en->EditCustomAttributes = "";
        if (!$this->meta_title_en->Raw) {
            $this->meta_title_en->CurrentValue = HtmlDecode($this->meta_title_en->CurrentValue);
        }
        $this->meta_title_en->EditValue = $this->meta_title_en->CurrentValue;
        $this->meta_title_en->PlaceHolder = RemoveHtml($this->meta_title_en->caption());

        // meta_description
        $this->meta_description->setupEditAttributes();
        $this->meta_description->EditCustomAttributes = "";
        if (!$this->meta_description->Raw) {
            $this->meta_description->CurrentValue = HtmlDecode($this->meta_description->CurrentValue);
        }
        $this->meta_description->EditValue = $this->meta_description->CurrentValue;
        $this->meta_description->PlaceHolder = RemoveHtml($this->meta_description->caption());

        // meta_description_en
        $this->meta_description_en->setupEditAttributes();
        $this->meta_description_en->EditCustomAttributes = "";
        if (!$this->meta_description_en->Raw) {
            $this->meta_description_en->CurrentValue = HtmlDecode($this->meta_description_en->CurrentValue);
        }
        $this->meta_description_en->EditValue = $this->meta_description_en->CurrentValue;
        $this->meta_description_en->PlaceHolder = RemoveHtml($this->meta_description_en->caption());

        // meta_keyword
        $this->meta_keyword->setupEditAttributes();
        $this->meta_keyword->EditCustomAttributes = "";
        $this->meta_keyword->EditValue = $this->meta_keyword->CurrentValue;
        $this->meta_keyword->PlaceHolder = RemoveHtml($this->meta_keyword->caption());

        // meta_keyword_en
        $this->meta_keyword_en->setupEditAttributes();
        $this->meta_keyword_en->EditCustomAttributes = "";
        $this->meta_keyword_en->EditValue = $this->meta_keyword_en->CurrentValue;
        $this->meta_keyword_en->PlaceHolder = RemoveHtml($this->meta_keyword_en->caption());

        // og_tag_title
        $this->og_tag_title->setupEditAttributes();
        $this->og_tag_title->EditCustomAttributes = "";
        if (!$this->og_tag_title->Raw) {
            $this->og_tag_title->CurrentValue = HtmlDecode($this->og_tag_title->CurrentValue);
        }
        $this->og_tag_title->EditValue = $this->og_tag_title->CurrentValue;
        $this->og_tag_title->PlaceHolder = RemoveHtml($this->og_tag_title->caption());

        // og_tag_title_en
        $this->og_tag_title_en->setupEditAttributes();
        $this->og_tag_title_en->EditCustomAttributes = "";
        if (!$this->og_tag_title_en->Raw) {
            $this->og_tag_title_en->CurrentValue = HtmlDecode($this->og_tag_title_en->CurrentValue);
        }
        $this->og_tag_title_en->EditValue = $this->og_tag_title_en->CurrentValue;
        $this->og_tag_title_en->PlaceHolder = RemoveHtml($this->og_tag_title_en->caption());

        // og_tag_type
        $this->og_tag_type->setupEditAttributes();
        $this->og_tag_type->EditCustomAttributes = "";
        if (!$this->og_tag_type->Raw) {
            $this->og_tag_type->CurrentValue = HtmlDecode($this->og_tag_type->CurrentValue);
        }
        $this->og_tag_type->EditValue = $this->og_tag_type->CurrentValue;
        $this->og_tag_type->PlaceHolder = RemoveHtml($this->og_tag_type->caption());

        // og_tag_url
        $this->og_tag_url->setupEditAttributes();
        $this->og_tag_url->EditCustomAttributes = "";
        if (!$this->og_tag_url->Raw) {
            $this->og_tag_url->CurrentValue = HtmlDecode($this->og_tag_url->CurrentValue);
        }
        $this->og_tag_url->EditValue = $this->og_tag_url->CurrentValue;
        $this->og_tag_url->PlaceHolder = RemoveHtml($this->og_tag_url->caption());

        // og_tag_description
        $this->og_tag_description->setupEditAttributes();
        $this->og_tag_description->EditCustomAttributes = "";
        if (!$this->og_tag_description->Raw) {
            $this->og_tag_description->CurrentValue = HtmlDecode($this->og_tag_description->CurrentValue);
        }
        $this->og_tag_description->EditValue = $this->og_tag_description->CurrentValue;
        $this->og_tag_description->PlaceHolder = RemoveHtml($this->og_tag_description->caption());

        // og_tag_description_en
        $this->og_tag_description_en->setupEditAttributes();
        $this->og_tag_description_en->EditCustomAttributes = "";
        if (!$this->og_tag_description_en->Raw) {
            $this->og_tag_description_en->CurrentValue = HtmlDecode($this->og_tag_description_en->CurrentValue);
        }
        $this->og_tag_description_en->EditValue = $this->og_tag_description_en->CurrentValue;
        $this->og_tag_description_en->PlaceHolder = RemoveHtml($this->og_tag_description_en->caption());

        // og_tag_image
        $this->og_tag_image->setupEditAttributes();
        $this->og_tag_image->EditCustomAttributes = "";
        if (!$this->og_tag_image->Raw) {
            $this->og_tag_image->CurrentValue = HtmlDecode($this->og_tag_image->CurrentValue);
        }
        $this->og_tag_image->EditValue = $this->og_tag_image->CurrentValue;
        $this->og_tag_image->PlaceHolder = RemoveHtml($this->og_tag_image->caption());

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
                    $doc->exportCaption($this->article_category_id);
                    $doc->exportCaption($this->_title);
                    $doc->exportCaption($this->title_en);
                    $doc->exportCaption($this->detail);
                    $doc->exportCaption($this->detail_en);
                    $doc->exportCaption($this->image);
                    $doc->exportCaption($this->order_by);
                    $doc->exportCaption($this->tag);
                    $doc->exportCaption($this->highlight);
                    $doc->exportCaption($this->count_view);
                    $doc->exportCaption($this->count_share_facebook);
                    $doc->exportCaption($this->count_share_line);
                    $doc->exportCaption($this->count_share_twitter);
                    $doc->exportCaption($this->count_share_email);
                    $doc->exportCaption($this->active_status);
                    $doc->exportCaption($this->meta_title);
                    $doc->exportCaption($this->meta_title_en);
                    $doc->exportCaption($this->meta_description);
                    $doc->exportCaption($this->meta_description_en);
                    $doc->exportCaption($this->meta_keyword);
                    $doc->exportCaption($this->meta_keyword_en);
                    $doc->exportCaption($this->cdate);
                } else {
                    $doc->exportCaption($this->article_category_id);
                    $doc->exportCaption($this->_title);
                    $doc->exportCaption($this->title_en);
                    $doc->exportCaption($this->image);
                    $doc->exportCaption($this->order_by);
                    $doc->exportCaption($this->tag);
                    $doc->exportCaption($this->highlight);
                    $doc->exportCaption($this->count_view);
                    $doc->exportCaption($this->count_share_facebook);
                    $doc->exportCaption($this->count_share_line);
                    $doc->exportCaption($this->count_share_twitter);
                    $doc->exportCaption($this->count_share_email);
                    $doc->exportCaption($this->active_status);
                    $doc->exportCaption($this->meta_title);
                    $doc->exportCaption($this->meta_title_en);
                    $doc->exportCaption($this->meta_description);
                    $doc->exportCaption($this->meta_description_en);
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
                        $doc->exportField($this->article_category_id);
                        $doc->exportField($this->_title);
                        $doc->exportField($this->title_en);
                        $doc->exportField($this->detail);
                        $doc->exportField($this->detail_en);
                        $doc->exportField($this->image);
                        $doc->exportField($this->order_by);
                        $doc->exportField($this->tag);
                        $doc->exportField($this->highlight);
                        $doc->exportField($this->count_view);
                        $doc->exportField($this->count_share_facebook);
                        $doc->exportField($this->count_share_line);
                        $doc->exportField($this->count_share_twitter);
                        $doc->exportField($this->count_share_email);
                        $doc->exportField($this->active_status);
                        $doc->exportField($this->meta_title);
                        $doc->exportField($this->meta_title_en);
                        $doc->exportField($this->meta_description);
                        $doc->exportField($this->meta_description_en);
                        $doc->exportField($this->meta_keyword);
                        $doc->exportField($this->meta_keyword_en);
                        $doc->exportField($this->cdate);
                    } else {
                        $doc->exportField($this->article_category_id);
                        $doc->exportField($this->_title);
                        $doc->exportField($this->title_en);
                        $doc->exportField($this->image);
                        $doc->exportField($this->order_by);
                        $doc->exportField($this->tag);
                        $doc->exportField($this->highlight);
                        $doc->exportField($this->count_view);
                        $doc->exportField($this->count_share_facebook);
                        $doc->exportField($this->count_share_line);
                        $doc->exportField($this->count_share_twitter);
                        $doc->exportField($this->count_share_email);
                        $doc->exportField($this->active_status);
                        $doc->exportField($this->meta_title);
                        $doc->exportField($this->meta_title_en);
                        $doc->exportField($this->meta_description);
                        $doc->exportField($this->meta_description_en);
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
        if ($fldparm == 'image') {
            $fldName = "image";
            $fileNameFld = "image";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->article_id->CurrentValue = $ar[0];
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
        $table = 'article';
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
        $table = 'article';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['article_id'];

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
        $table = 'article';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rsold['article_id'];

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
        $table = 'article';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['article_id'];

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
