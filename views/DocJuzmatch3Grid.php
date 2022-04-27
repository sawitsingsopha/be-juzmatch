<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("DocJuzmatch3Grid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fdoc_juzmatch3grid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_juzmatch3grid = new ew.Form("fdoc_juzmatch3grid", "grid");
    fdoc_juzmatch3grid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { doc_juzmatch3: currentTable } });
    var fields = currentTable.fields;
    fdoc_juzmatch3grid.addFields([
        ["document_date", [fields.document_date.visible && fields.document_date.required ? ew.Validators.required(fields.document_date.caption) : null], fields.document_date.isInvalid],
        ["years", [fields.years.visible && fields.years.required ? ew.Validators.required(fields.years.caption) : null, ew.Validators.integer], fields.years.isInvalid],
        ["start_date", [fields.start_date.visible && fields.start_date.required ? ew.Validators.required(fields.start_date.caption) : null, ew.Validators.datetime(fields.start_date.clientFormatPattern)], fields.start_date.isInvalid],
        ["end_date", [fields.end_date.visible && fields.end_date.required ? ew.Validators.required(fields.end_date.caption) : null, ew.Validators.datetime(fields.end_date.clientFormatPattern)], fields.end_date.isInvalid],
        ["asset_code", [fields.asset_code.visible && fields.asset_code.required ? ew.Validators.required(fields.asset_code.caption) : null], fields.asset_code.isInvalid],
        ["asset_project", [fields.asset_project.visible && fields.asset_project.required ? ew.Validators.required(fields.asset_project.caption) : null], fields.asset_project.isInvalid],
        ["asset_deed", [fields.asset_deed.visible && fields.asset_deed.required ? ew.Validators.required(fields.asset_deed.caption) : null], fields.asset_deed.isInvalid],
        ["asset_area", [fields.asset_area.visible && fields.asset_area.required ? ew.Validators.required(fields.asset_area.caption) : null], fields.asset_area.isInvalid],
        ["appoint_agent_date", [fields.appoint_agent_date.visible && fields.appoint_agent_date.required ? ew.Validators.required(fields.appoint_agent_date.caption) : null, ew.Validators.datetime(fields.appoint_agent_date.clientFormatPattern)], fields.appoint_agent_date.isInvalid],
        ["buyer_lname", [fields.buyer_lname.visible && fields.buyer_lname.required ? ew.Validators.required(fields.buyer_lname.caption) : null], fields.buyer_lname.isInvalid],
        ["buyer_email", [fields.buyer_email.visible && fields.buyer_email.required ? ew.Validators.required(fields.buyer_email.caption) : null], fields.buyer_email.isInvalid],
        ["buyer_idcard", [fields.buyer_idcard.visible && fields.buyer_idcard.required ? ew.Validators.required(fields.buyer_idcard.caption) : null], fields.buyer_idcard.isInvalid],
        ["buyer_homeno", [fields.buyer_homeno.visible && fields.buyer_homeno.required ? ew.Validators.required(fields.buyer_homeno.caption) : null], fields.buyer_homeno.isInvalid],
        ["buyer_witness_lname", [fields.buyer_witness_lname.visible && fields.buyer_witness_lname.required ? ew.Validators.required(fields.buyer_witness_lname.caption) : null], fields.buyer_witness_lname.isInvalid],
        ["buyer_witness_email", [fields.buyer_witness_email.visible && fields.buyer_witness_email.required ? ew.Validators.required(fields.buyer_witness_email.caption) : null], fields.buyer_witness_email.isInvalid],
        ["investor_lname", [fields.investor_lname.visible && fields.investor_lname.required ? ew.Validators.required(fields.investor_lname.caption) : null], fields.investor_lname.isInvalid],
        ["investor_email", [fields.investor_email.visible && fields.investor_email.required ? ew.Validators.required(fields.investor_email.caption) : null], fields.investor_email.isInvalid],
        ["juzmatch_authority_lname", [fields.juzmatch_authority_lname.visible && fields.juzmatch_authority_lname.required ? ew.Validators.required(fields.juzmatch_authority_lname.caption) : null], fields.juzmatch_authority_lname.isInvalid],
        ["juzmatch_authority_email", [fields.juzmatch_authority_email.visible && fields.juzmatch_authority_email.required ? ew.Validators.required(fields.juzmatch_authority_email.caption) : null], fields.juzmatch_authority_email.isInvalid],
        ["juzmatch_authority_witness_lname", [fields.juzmatch_authority_witness_lname.visible && fields.juzmatch_authority_witness_lname.required ? ew.Validators.required(fields.juzmatch_authority_witness_lname.caption) : null], fields.juzmatch_authority_witness_lname.isInvalid],
        ["juzmatch_authority_witness_email", [fields.juzmatch_authority_witness_email.visible && fields.juzmatch_authority_witness_email.required ? ew.Validators.required(fields.juzmatch_authority_witness_email.caption) : null], fields.juzmatch_authority_witness_email.isInvalid],
        ["juzmatch_authority2_name", [fields.juzmatch_authority2_name.visible && fields.juzmatch_authority2_name.required ? ew.Validators.required(fields.juzmatch_authority2_name.caption) : null], fields.juzmatch_authority2_name.isInvalid],
        ["juzmatch_authority2_lname", [fields.juzmatch_authority2_lname.visible && fields.juzmatch_authority2_lname.required ? ew.Validators.required(fields.juzmatch_authority2_lname.caption) : null], fields.juzmatch_authority2_lname.isInvalid],
        ["juzmatch_authority2_email", [fields.juzmatch_authority2_email.visible && fields.juzmatch_authority2_email.required ? ew.Validators.required(fields.juzmatch_authority2_email.caption) : null], fields.juzmatch_authority2_email.isInvalid],
        ["company_seal_name", [fields.company_seal_name.visible && fields.company_seal_name.required ? ew.Validators.required(fields.company_seal_name.caption) : null], fields.company_seal_name.isInvalid],
        ["company_seal_email", [fields.company_seal_email.visible && fields.company_seal_email.required ? ew.Validators.required(fields.company_seal_email.caption) : null], fields.company_seal_email.isInvalid],
        ["total", [fields.total.visible && fields.total.required ? ew.Validators.required(fields.total.caption) : null, ew.Validators.float], fields.total.isInvalid],
        ["total_txt", [fields.total_txt.visible && fields.total_txt.required ? ew.Validators.required(fields.total_txt.caption) : null], fields.total_txt.isInvalid],
        ["next_pay_date", [fields.next_pay_date.visible && fields.next_pay_date.required ? ew.Validators.required(fields.next_pay_date.caption) : null, ew.Validators.datetime(fields.next_pay_date.clientFormatPattern)], fields.next_pay_date.isInvalid],
        ["next_pay_date_txt", [fields.next_pay_date_txt.visible && fields.next_pay_date_txt.required ? ew.Validators.required(fields.next_pay_date_txt.caption) : null], fields.next_pay_date_txt.isInvalid],
        ["service_price", [fields.service_price.visible && fields.service_price.required ? ew.Validators.required(fields.service_price.caption) : null, ew.Validators.float], fields.service_price.isInvalid],
        ["service_price_txt", [fields.service_price_txt.visible && fields.service_price_txt.required ? ew.Validators.required(fields.service_price_txt.caption) : null], fields.service_price_txt.isInvalid],
        ["provide_service_date", [fields.provide_service_date.visible && fields.provide_service_date.required ? ew.Validators.required(fields.provide_service_date.caption) : null, ew.Validators.datetime(fields.provide_service_date.clientFormatPattern)], fields.provide_service_date.isInvalid],
        ["contact_address", [fields.contact_address.visible && fields.contact_address.required ? ew.Validators.required(fields.contact_address.caption) : null], fields.contact_address.isInvalid],
        ["contact_address2", [fields.contact_address2.visible && fields.contact_address2.required ? ew.Validators.required(fields.contact_address2.caption) : null], fields.contact_address2.isInvalid],
        ["contact_email", [fields.contact_email.visible && fields.contact_email.required ? ew.Validators.required(fields.contact_email.caption) : null], fields.contact_email.isInvalid],
        ["contact_lineid", [fields.contact_lineid.visible && fields.contact_lineid.required ? ew.Validators.required(fields.contact_lineid.caption) : null], fields.contact_lineid.isInvalid],
        ["contact_phone", [fields.contact_phone.visible && fields.contact_phone.required ? ew.Validators.required(fields.contact_phone.caption) : null], fields.contact_phone.isInvalid],
        ["attach_file", [fields.attach_file.visible && fields.attach_file.required ? ew.Validators.required(fields.attach_file.caption) : null], fields.attach_file.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fdoc_juzmatch3grid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["years",false],["start_date",false],["end_date",false],["asset_code",false],["asset_project",false],["asset_deed",false],["asset_area",false],["appoint_agent_date",false],["buyer_lname",false],["buyer_email",false],["buyer_idcard",false],["buyer_homeno",false],["buyer_witness_lname",false],["buyer_witness_email",false],["investor_lname",false],["investor_email",false],["juzmatch_authority_lname",false],["juzmatch_authority_email",false],["juzmatch_authority_witness_lname",false],["juzmatch_authority_witness_email",false],["juzmatch_authority2_name",false],["juzmatch_authority2_lname",false],["juzmatch_authority2_email",false],["company_seal_name",false],["company_seal_email",false],["total",false],["total_txt",false],["next_pay_date",false],["next_pay_date_txt",false],["service_price",false],["service_price_txt",false],["provide_service_date",false],["contact_address",false],["contact_address2",false],["contact_email",false],["contact_lineid",false],["contact_phone",false],["attach_file",false],["status",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fdoc_juzmatch3grid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdoc_juzmatch3grid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fdoc_juzmatch3grid.lists.status = <?= $Grid->status->toClientList($Grid) ?>;
    loadjs.done("fdoc_juzmatch3grid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> doc_juzmatch3">
<div id="fdoc_juzmatch3grid" class="ew-form ew-list-form">
<div id="gmp_doc_juzmatch3" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_doc_juzmatch3grid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->document_date->Visible) { // document_date ?>
        <th data-name="document_date" class="<?= $Grid->document_date->headerCellClass() ?>"><div id="elh_doc_juzmatch3_document_date" class="doc_juzmatch3_document_date"><?= $Grid->renderFieldHeader($Grid->document_date) ?></div></th>
<?php } ?>
<?php if ($Grid->years->Visible) { // years ?>
        <th data-name="years" class="<?= $Grid->years->headerCellClass() ?>"><div id="elh_doc_juzmatch3_years" class="doc_juzmatch3_years"><?= $Grid->renderFieldHeader($Grid->years) ?></div></th>
<?php } ?>
<?php if ($Grid->start_date->Visible) { // start_date ?>
        <th data-name="start_date" class="<?= $Grid->start_date->headerCellClass() ?>"><div id="elh_doc_juzmatch3_start_date" class="doc_juzmatch3_start_date"><?= $Grid->renderFieldHeader($Grid->start_date) ?></div></th>
<?php } ?>
<?php if ($Grid->end_date->Visible) { // end_date ?>
        <th data-name="end_date" class="<?= $Grid->end_date->headerCellClass() ?>"><div id="elh_doc_juzmatch3_end_date" class="doc_juzmatch3_end_date"><?= $Grid->renderFieldHeader($Grid->end_date) ?></div></th>
<?php } ?>
<?php if ($Grid->asset_code->Visible) { // asset_code ?>
        <th data-name="asset_code" class="<?= $Grid->asset_code->headerCellClass() ?>"><div id="elh_doc_juzmatch3_asset_code" class="doc_juzmatch3_asset_code"><?= $Grid->renderFieldHeader($Grid->asset_code) ?></div></th>
<?php } ?>
<?php if ($Grid->asset_project->Visible) { // asset_project ?>
        <th data-name="asset_project" class="<?= $Grid->asset_project->headerCellClass() ?>"><div id="elh_doc_juzmatch3_asset_project" class="doc_juzmatch3_asset_project"><?= $Grid->renderFieldHeader($Grid->asset_project) ?></div></th>
<?php } ?>
<?php if ($Grid->asset_deed->Visible) { // asset_deed ?>
        <th data-name="asset_deed" class="<?= $Grid->asset_deed->headerCellClass() ?>"><div id="elh_doc_juzmatch3_asset_deed" class="doc_juzmatch3_asset_deed"><?= $Grid->renderFieldHeader($Grid->asset_deed) ?></div></th>
<?php } ?>
<?php if ($Grid->asset_area->Visible) { // asset_area ?>
        <th data-name="asset_area" class="<?= $Grid->asset_area->headerCellClass() ?>"><div id="elh_doc_juzmatch3_asset_area" class="doc_juzmatch3_asset_area"><?= $Grid->renderFieldHeader($Grid->asset_area) ?></div></th>
<?php } ?>
<?php if ($Grid->appoint_agent_date->Visible) { // appoint_agent_date ?>
        <th data-name="appoint_agent_date" class="<?= $Grid->appoint_agent_date->headerCellClass() ?>"><div id="elh_doc_juzmatch3_appoint_agent_date" class="doc_juzmatch3_appoint_agent_date"><?= $Grid->renderFieldHeader($Grid->appoint_agent_date) ?></div></th>
<?php } ?>
<?php if ($Grid->buyer_lname->Visible) { // buyer_lname ?>
        <th data-name="buyer_lname" class="<?= $Grid->buyer_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch3_buyer_lname" class="doc_juzmatch3_buyer_lname"><?= $Grid->renderFieldHeader($Grid->buyer_lname) ?></div></th>
<?php } ?>
<?php if ($Grid->buyer_email->Visible) { // buyer_email ?>
        <th data-name="buyer_email" class="<?= $Grid->buyer_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_buyer_email" class="doc_juzmatch3_buyer_email"><?= $Grid->renderFieldHeader($Grid->buyer_email) ?></div></th>
<?php } ?>
<?php if ($Grid->buyer_idcard->Visible) { // buyer_idcard ?>
        <th data-name="buyer_idcard" class="<?= $Grid->buyer_idcard->headerCellClass() ?>"><div id="elh_doc_juzmatch3_buyer_idcard" class="doc_juzmatch3_buyer_idcard"><?= $Grid->renderFieldHeader($Grid->buyer_idcard) ?></div></th>
<?php } ?>
<?php if ($Grid->buyer_homeno->Visible) { // buyer_homeno ?>
        <th data-name="buyer_homeno" class="<?= $Grid->buyer_homeno->headerCellClass() ?>"><div id="elh_doc_juzmatch3_buyer_homeno" class="doc_juzmatch3_buyer_homeno"><?= $Grid->renderFieldHeader($Grid->buyer_homeno) ?></div></th>
<?php } ?>
<?php if ($Grid->buyer_witness_lname->Visible) { // buyer_witness_lname ?>
        <th data-name="buyer_witness_lname" class="<?= $Grid->buyer_witness_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch3_buyer_witness_lname" class="doc_juzmatch3_buyer_witness_lname"><?= $Grid->renderFieldHeader($Grid->buyer_witness_lname) ?></div></th>
<?php } ?>
<?php if ($Grid->buyer_witness_email->Visible) { // buyer_witness_email ?>
        <th data-name="buyer_witness_email" class="<?= $Grid->buyer_witness_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_buyer_witness_email" class="doc_juzmatch3_buyer_witness_email"><?= $Grid->renderFieldHeader($Grid->buyer_witness_email) ?></div></th>
<?php } ?>
<?php if ($Grid->investor_lname->Visible) { // investor_lname ?>
        <th data-name="investor_lname" class="<?= $Grid->investor_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch3_investor_lname" class="doc_juzmatch3_investor_lname"><?= $Grid->renderFieldHeader($Grid->investor_lname) ?></div></th>
<?php } ?>
<?php if ($Grid->investor_email->Visible) { // investor_email ?>
        <th data-name="investor_email" class="<?= $Grid->investor_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_investor_email" class="doc_juzmatch3_investor_email"><?= $Grid->renderFieldHeader($Grid->investor_email) ?></div></th>
<?php } ?>
<?php if ($Grid->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
        <th data-name="juzmatch_authority_lname" class="<?= $Grid->juzmatch_authority_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch3_juzmatch_authority_lname" class="doc_juzmatch3_juzmatch_authority_lname"><?= $Grid->renderFieldHeader($Grid->juzmatch_authority_lname) ?></div></th>
<?php } ?>
<?php if ($Grid->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
        <th data-name="juzmatch_authority_email" class="<?= $Grid->juzmatch_authority_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_juzmatch_authority_email" class="doc_juzmatch3_juzmatch_authority_email"><?= $Grid->renderFieldHeader($Grid->juzmatch_authority_email) ?></div></th>
<?php } ?>
<?php if ($Grid->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
        <th data-name="juzmatch_authority_witness_lname" class="<?= $Grid->juzmatch_authority_witness_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch3_juzmatch_authority_witness_lname" class="doc_juzmatch3_juzmatch_authority_witness_lname"><?= $Grid->renderFieldHeader($Grid->juzmatch_authority_witness_lname) ?></div></th>
<?php } ?>
<?php if ($Grid->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
        <th data-name="juzmatch_authority_witness_email" class="<?= $Grid->juzmatch_authority_witness_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_juzmatch_authority_witness_email" class="doc_juzmatch3_juzmatch_authority_witness_email"><?= $Grid->renderFieldHeader($Grid->juzmatch_authority_witness_email) ?></div></th>
<?php } ?>
<?php if ($Grid->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
        <th data-name="juzmatch_authority2_name" class="<?= $Grid->juzmatch_authority2_name->headerCellClass() ?>"><div id="elh_doc_juzmatch3_juzmatch_authority2_name" class="doc_juzmatch3_juzmatch_authority2_name"><?= $Grid->renderFieldHeader($Grid->juzmatch_authority2_name) ?></div></th>
<?php } ?>
<?php if ($Grid->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
        <th data-name="juzmatch_authority2_lname" class="<?= $Grid->juzmatch_authority2_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch3_juzmatch_authority2_lname" class="doc_juzmatch3_juzmatch_authority2_lname"><?= $Grid->renderFieldHeader($Grid->juzmatch_authority2_lname) ?></div></th>
<?php } ?>
<?php if ($Grid->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
        <th data-name="juzmatch_authority2_email" class="<?= $Grid->juzmatch_authority2_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_juzmatch_authority2_email" class="doc_juzmatch3_juzmatch_authority2_email"><?= $Grid->renderFieldHeader($Grid->juzmatch_authority2_email) ?></div></th>
<?php } ?>
<?php if ($Grid->company_seal_name->Visible) { // company_seal_name ?>
        <th data-name="company_seal_name" class="<?= $Grid->company_seal_name->headerCellClass() ?>"><div id="elh_doc_juzmatch3_company_seal_name" class="doc_juzmatch3_company_seal_name"><?= $Grid->renderFieldHeader($Grid->company_seal_name) ?></div></th>
<?php } ?>
<?php if ($Grid->company_seal_email->Visible) { // company_seal_email ?>
        <th data-name="company_seal_email" class="<?= $Grid->company_seal_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_company_seal_email" class="doc_juzmatch3_company_seal_email"><?= $Grid->renderFieldHeader($Grid->company_seal_email) ?></div></th>
<?php } ?>
<?php if ($Grid->total->Visible) { // total ?>
        <th data-name="total" class="<?= $Grid->total->headerCellClass() ?>"><div id="elh_doc_juzmatch3_total" class="doc_juzmatch3_total"><?= $Grid->renderFieldHeader($Grid->total) ?></div></th>
<?php } ?>
<?php if ($Grid->total_txt->Visible) { // total_txt ?>
        <th data-name="total_txt" class="<?= $Grid->total_txt->headerCellClass() ?>"><div id="elh_doc_juzmatch3_total_txt" class="doc_juzmatch3_total_txt"><?= $Grid->renderFieldHeader($Grid->total_txt) ?></div></th>
<?php } ?>
<?php if ($Grid->next_pay_date->Visible) { // next_pay_date ?>
        <th data-name="next_pay_date" class="<?= $Grid->next_pay_date->headerCellClass() ?>"><div id="elh_doc_juzmatch3_next_pay_date" class="doc_juzmatch3_next_pay_date"><?= $Grid->renderFieldHeader($Grid->next_pay_date) ?></div></th>
<?php } ?>
<?php if ($Grid->next_pay_date_txt->Visible) { // next_pay_date_txt ?>
        <th data-name="next_pay_date_txt" class="<?= $Grid->next_pay_date_txt->headerCellClass() ?>"><div id="elh_doc_juzmatch3_next_pay_date_txt" class="doc_juzmatch3_next_pay_date_txt"><?= $Grid->renderFieldHeader($Grid->next_pay_date_txt) ?></div></th>
<?php } ?>
<?php if ($Grid->service_price->Visible) { // service_price ?>
        <th data-name="service_price" class="<?= $Grid->service_price->headerCellClass() ?>"><div id="elh_doc_juzmatch3_service_price" class="doc_juzmatch3_service_price"><?= $Grid->renderFieldHeader($Grid->service_price) ?></div></th>
<?php } ?>
<?php if ($Grid->service_price_txt->Visible) { // service_price_txt ?>
        <th data-name="service_price_txt" class="<?= $Grid->service_price_txt->headerCellClass() ?>"><div id="elh_doc_juzmatch3_service_price_txt" class="doc_juzmatch3_service_price_txt"><?= $Grid->renderFieldHeader($Grid->service_price_txt) ?></div></th>
<?php } ?>
<?php if ($Grid->provide_service_date->Visible) { // provide_service_date ?>
        <th data-name="provide_service_date" class="<?= $Grid->provide_service_date->headerCellClass() ?>"><div id="elh_doc_juzmatch3_provide_service_date" class="doc_juzmatch3_provide_service_date"><?= $Grid->renderFieldHeader($Grid->provide_service_date) ?></div></th>
<?php } ?>
<?php if ($Grid->contact_address->Visible) { // contact_address ?>
        <th data-name="contact_address" class="<?= $Grid->contact_address->headerCellClass() ?>"><div id="elh_doc_juzmatch3_contact_address" class="doc_juzmatch3_contact_address"><?= $Grid->renderFieldHeader($Grid->contact_address) ?></div></th>
<?php } ?>
<?php if ($Grid->contact_address2->Visible) { // contact_address2 ?>
        <th data-name="contact_address2" class="<?= $Grid->contact_address2->headerCellClass() ?>"><div id="elh_doc_juzmatch3_contact_address2" class="doc_juzmatch3_contact_address2"><?= $Grid->renderFieldHeader($Grid->contact_address2) ?></div></th>
<?php } ?>
<?php if ($Grid->contact_email->Visible) { // contact_email ?>
        <th data-name="contact_email" class="<?= $Grid->contact_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_contact_email" class="doc_juzmatch3_contact_email"><?= $Grid->renderFieldHeader($Grid->contact_email) ?></div></th>
<?php } ?>
<?php if ($Grid->contact_lineid->Visible) { // contact_lineid ?>
        <th data-name="contact_lineid" class="<?= $Grid->contact_lineid->headerCellClass() ?>"><div id="elh_doc_juzmatch3_contact_lineid" class="doc_juzmatch3_contact_lineid"><?= $Grid->renderFieldHeader($Grid->contact_lineid) ?></div></th>
<?php } ?>
<?php if ($Grid->contact_phone->Visible) { // contact_phone ?>
        <th data-name="contact_phone" class="<?= $Grid->contact_phone->headerCellClass() ?>"><div id="elh_doc_juzmatch3_contact_phone" class="doc_juzmatch3_contact_phone"><?= $Grid->renderFieldHeader($Grid->contact_phone) ?></div></th>
<?php } ?>
<?php if ($Grid->attach_file->Visible) { // attach_file ?>
        <th data-name="attach_file" class="<?= $Grid->attach_file->headerCellClass() ?>"><div id="elh_doc_juzmatch3_attach_file" class="doc_juzmatch3_attach_file"><?= $Grid->renderFieldHeader($Grid->attach_file) ?></div></th>
<?php } ?>
<?php if ($Grid->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Grid->status->headerCellClass() ?>"><div id="elh_doc_juzmatch3_status" class="doc_juzmatch3_status"><?= $Grid->renderFieldHeader($Grid->status) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_doc_juzmatch3_cdate" class="doc_juzmatch3_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif ($Grid->isGridAdd() && !$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isAdd() || $Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row attributes
        $Grid->RowAttrs->merge([
            "data-rowindex" => $Grid->RowCount,
            "id" => "r" . $Grid->RowCount . "_doc_juzmatch3",
            "data-rowtype" => $Grid->RowType,
            "class" => ($Grid->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Grid->isAdd() && $Grid->RowType == ROWTYPE_ADD || $Grid->isEdit() && $Grid->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Grid->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if (
            $Page->RowAction != "delete" &&
            $Page->RowAction != "insertdelete" &&
            !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())
        ) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->document_date->Visible) { // document_date ?>
        <td data-name="document_date"<?= $Grid->document_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_document_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_document_date" id="o<?= $Grid->RowIndex ?>_document_date" value="<?= HtmlEncode($Grid->document_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_document_date" class="el_doc_juzmatch3_document_date">
<span<?= $Grid->document_date->viewAttributes() ?>>
<?= $Grid->document_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_document_date" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_document_date" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_document_date" value="<?= HtmlEncode($Grid->document_date->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_document_date" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_document_date" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_document_date" value="<?= HtmlEncode($Grid->document_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->years->Visible) { // years ?>
        <td data-name="years"<?= $Grid->years->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_years" class="el_doc_juzmatch3_years">
<input type="<?= $Grid->years->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_years" id="x<?= $Grid->RowIndex ?>_years" data-table="doc_juzmatch3" data-field="x_years" value="<?= $Grid->years->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Grid->years->getPlaceHolder()) ?>"<?= $Grid->years->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->years->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_years" data-hidden="1" name="o<?= $Grid->RowIndex ?>_years" id="o<?= $Grid->RowIndex ?>_years" value="<?= HtmlEncode($Grid->years->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_years" class="el_doc_juzmatch3_years">
<input type="<?= $Grid->years->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_years" id="x<?= $Grid->RowIndex ?>_years" data-table="doc_juzmatch3" data-field="x_years" value="<?= $Grid->years->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Grid->years->getPlaceHolder()) ?>"<?= $Grid->years->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->years->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_years" class="el_doc_juzmatch3_years">
<span<?= $Grid->years->viewAttributes() ?>>
<?= $Grid->years->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_years" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_years" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_years" value="<?= HtmlEncode($Grid->years->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_years" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_years" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_years" value="<?= HtmlEncode($Grid->years->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->start_date->Visible) { // start_date ?>
        <td data-name="start_date"<?= $Grid->start_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_start_date" class="el_doc_juzmatch3_start_date">
<input type="<?= $Grid->start_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_start_date" id="x<?= $Grid->RowIndex ?>_start_date" data-table="doc_juzmatch3" data-field="x_start_date" value="<?= $Grid->start_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->start_date->getPlaceHolder()) ?>"<?= $Grid->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->start_date->getErrorMessage() ?></div>
<?php if (!$Grid->start_date->ReadOnly && !$Grid->start_date->Disabled && !isset($Grid->start_date->EditAttrs["readonly"]) && !isset($Grid->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_start_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_start_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_start_date" id="o<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_start_date" class="el_doc_juzmatch3_start_date">
<input type="<?= $Grid->start_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_start_date" id="x<?= $Grid->RowIndex ?>_start_date" data-table="doc_juzmatch3" data-field="x_start_date" value="<?= $Grid->start_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->start_date->getPlaceHolder()) ?>"<?= $Grid->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->start_date->getErrorMessage() ?></div>
<?php if (!$Grid->start_date->ReadOnly && !$Grid->start_date->Disabled && !isset($Grid->start_date->EditAttrs["readonly"]) && !isset($Grid->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_start_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_start_date" class="el_doc_juzmatch3_start_date">
<span<?= $Grid->start_date->viewAttributes() ?>>
<?= $Grid->start_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_start_date" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_start_date" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_start_date" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_start_date" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->end_date->Visible) { // end_date ?>
        <td data-name="end_date"<?= $Grid->end_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_end_date" class="el_doc_juzmatch3_end_date">
<input type="<?= $Grid->end_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_end_date" id="x<?= $Grid->RowIndex ?>_end_date" data-table="doc_juzmatch3" data-field="x_end_date" value="<?= $Grid->end_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->end_date->getPlaceHolder()) ?>"<?= $Grid->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->end_date->getErrorMessage() ?></div>
<?php if (!$Grid->end_date->ReadOnly && !$Grid->end_date->Disabled && !isset($Grid->end_date->EditAttrs["readonly"]) && !isset($Grid->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_end_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_end_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_end_date" id="o<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_end_date" class="el_doc_juzmatch3_end_date">
<input type="<?= $Grid->end_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_end_date" id="x<?= $Grid->RowIndex ?>_end_date" data-table="doc_juzmatch3" data-field="x_end_date" value="<?= $Grid->end_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->end_date->getPlaceHolder()) ?>"<?= $Grid->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->end_date->getErrorMessage() ?></div>
<?php if (!$Grid->end_date->ReadOnly && !$Grid->end_date->Disabled && !isset($Grid->end_date->EditAttrs["readonly"]) && !isset($Grid->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_end_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_end_date" class="el_doc_juzmatch3_end_date">
<span<?= $Grid->end_date->viewAttributes() ?>>
<?= $Grid->end_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_end_date" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_end_date" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_end_date" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_end_date" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->asset_code->Visible) { // asset_code ?>
        <td data-name="asset_code"<?= $Grid->asset_code->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_asset_code" class="el_doc_juzmatch3_asset_code">
<input type="<?= $Grid->asset_code->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_code" id="x<?= $Grid->RowIndex ?>_asset_code" data-table="doc_juzmatch3" data-field="x_asset_code" value="<?= $Grid->asset_code->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->asset_code->getPlaceHolder()) ?>"<?= $Grid->asset_code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_code->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_code" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_code" id="o<?= $Grid->RowIndex ?>_asset_code" value="<?= HtmlEncode($Grid->asset_code->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_asset_code" class="el_doc_juzmatch3_asset_code">
<input type="<?= $Grid->asset_code->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_code" id="x<?= $Grid->RowIndex ?>_asset_code" data-table="doc_juzmatch3" data-field="x_asset_code" value="<?= $Grid->asset_code->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->asset_code->getPlaceHolder()) ?>"<?= $Grid->asset_code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_code->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_asset_code" class="el_doc_juzmatch3_asset_code">
<span<?= $Grid->asset_code->viewAttributes() ?>>
<?= $Grid->asset_code->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_code" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_asset_code" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_asset_code" value="<?= HtmlEncode($Grid->asset_code->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_code" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_asset_code" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_asset_code" value="<?= HtmlEncode($Grid->asset_code->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->asset_project->Visible) { // asset_project ?>
        <td data-name="asset_project"<?= $Grid->asset_project->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_asset_project" class="el_doc_juzmatch3_asset_project">
<input type="<?= $Grid->asset_project->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_project" id="x<?= $Grid->RowIndex ?>_asset_project" data-table="doc_juzmatch3" data-field="x_asset_project" value="<?= $Grid->asset_project->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->asset_project->getPlaceHolder()) ?>"<?= $Grid->asset_project->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_project->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_project" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_project" id="o<?= $Grid->RowIndex ?>_asset_project" value="<?= HtmlEncode($Grid->asset_project->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_asset_project" class="el_doc_juzmatch3_asset_project">
<input type="<?= $Grid->asset_project->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_project" id="x<?= $Grid->RowIndex ?>_asset_project" data-table="doc_juzmatch3" data-field="x_asset_project" value="<?= $Grid->asset_project->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->asset_project->getPlaceHolder()) ?>"<?= $Grid->asset_project->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_project->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_asset_project" class="el_doc_juzmatch3_asset_project">
<span<?= $Grid->asset_project->viewAttributes() ?>>
<?= $Grid->asset_project->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_project" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_asset_project" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_asset_project" value="<?= HtmlEncode($Grid->asset_project->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_project" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_asset_project" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_asset_project" value="<?= HtmlEncode($Grid->asset_project->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->asset_deed->Visible) { // asset_deed ?>
        <td data-name="asset_deed"<?= $Grid->asset_deed->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_asset_deed" class="el_doc_juzmatch3_asset_deed">
<input type="<?= $Grid->asset_deed->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_deed" id="x<?= $Grid->RowIndex ?>_asset_deed" data-table="doc_juzmatch3" data-field="x_asset_deed" value="<?= $Grid->asset_deed->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->asset_deed->getPlaceHolder()) ?>"<?= $Grid->asset_deed->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_deed->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_deed" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_deed" id="o<?= $Grid->RowIndex ?>_asset_deed" value="<?= HtmlEncode($Grid->asset_deed->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_asset_deed" class="el_doc_juzmatch3_asset_deed">
<input type="<?= $Grid->asset_deed->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_deed" id="x<?= $Grid->RowIndex ?>_asset_deed" data-table="doc_juzmatch3" data-field="x_asset_deed" value="<?= $Grid->asset_deed->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->asset_deed->getPlaceHolder()) ?>"<?= $Grid->asset_deed->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_deed->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_asset_deed" class="el_doc_juzmatch3_asset_deed">
<span<?= $Grid->asset_deed->viewAttributes() ?>>
<?= $Grid->asset_deed->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_deed" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_asset_deed" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_asset_deed" value="<?= HtmlEncode($Grid->asset_deed->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_deed" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_asset_deed" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_asset_deed" value="<?= HtmlEncode($Grid->asset_deed->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->asset_area->Visible) { // asset_area ?>
        <td data-name="asset_area"<?= $Grid->asset_area->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_asset_area" class="el_doc_juzmatch3_asset_area">
<input type="<?= $Grid->asset_area->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_area" id="x<?= $Grid->RowIndex ?>_asset_area" data-table="doc_juzmatch3" data-field="x_asset_area" value="<?= $Grid->asset_area->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->asset_area->getPlaceHolder()) ?>"<?= $Grid->asset_area->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_area->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_area" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_area" id="o<?= $Grid->RowIndex ?>_asset_area" value="<?= HtmlEncode($Grid->asset_area->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_asset_area" class="el_doc_juzmatch3_asset_area">
<input type="<?= $Grid->asset_area->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_area" id="x<?= $Grid->RowIndex ?>_asset_area" data-table="doc_juzmatch3" data-field="x_asset_area" value="<?= $Grid->asset_area->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->asset_area->getPlaceHolder()) ?>"<?= $Grid->asset_area->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_area->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_asset_area" class="el_doc_juzmatch3_asset_area">
<span<?= $Grid->asset_area->viewAttributes() ?>>
<?= $Grid->asset_area->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_area" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_asset_area" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_asset_area" value="<?= HtmlEncode($Grid->asset_area->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_area" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_asset_area" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_asset_area" value="<?= HtmlEncode($Grid->asset_area->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->appoint_agent_date->Visible) { // appoint_agent_date ?>
        <td data-name="appoint_agent_date"<?= $Grid->appoint_agent_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_appoint_agent_date" class="el_doc_juzmatch3_appoint_agent_date">
<input type="<?= $Grid->appoint_agent_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_appoint_agent_date" id="x<?= $Grid->RowIndex ?>_appoint_agent_date" data-table="doc_juzmatch3" data-field="x_appoint_agent_date" value="<?= $Grid->appoint_agent_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->appoint_agent_date->getPlaceHolder()) ?>"<?= $Grid->appoint_agent_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->appoint_agent_date->getErrorMessage() ?></div>
<?php if (!$Grid->appoint_agent_date->ReadOnly && !$Grid->appoint_agent_date->Disabled && !isset($Grid->appoint_agent_date->EditAttrs["readonly"]) && !isset($Grid->appoint_agent_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_appoint_agent_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_appoint_agent_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_appoint_agent_date" id="o<?= $Grid->RowIndex ?>_appoint_agent_date" value="<?= HtmlEncode($Grid->appoint_agent_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_appoint_agent_date" class="el_doc_juzmatch3_appoint_agent_date">
<input type="<?= $Grid->appoint_agent_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_appoint_agent_date" id="x<?= $Grid->RowIndex ?>_appoint_agent_date" data-table="doc_juzmatch3" data-field="x_appoint_agent_date" value="<?= $Grid->appoint_agent_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->appoint_agent_date->getPlaceHolder()) ?>"<?= $Grid->appoint_agent_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->appoint_agent_date->getErrorMessage() ?></div>
<?php if (!$Grid->appoint_agent_date->ReadOnly && !$Grid->appoint_agent_date->Disabled && !isset($Grid->appoint_agent_date->EditAttrs["readonly"]) && !isset($Grid->appoint_agent_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_appoint_agent_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_appoint_agent_date" class="el_doc_juzmatch3_appoint_agent_date">
<span<?= $Grid->appoint_agent_date->viewAttributes() ?>>
<?= $Grid->appoint_agent_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_appoint_agent_date" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_appoint_agent_date" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_appoint_agent_date" value="<?= HtmlEncode($Grid->appoint_agent_date->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_appoint_agent_date" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_appoint_agent_date" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_appoint_agent_date" value="<?= HtmlEncode($Grid->appoint_agent_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->buyer_lname->Visible) { // buyer_lname ?>
        <td data-name="buyer_lname"<?= $Grid->buyer_lname->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_lname" class="el_doc_juzmatch3_buyer_lname">
<input type="<?= $Grid->buyer_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_lname" id="x<?= $Grid->RowIndex ?>_buyer_lname" data-table="doc_juzmatch3" data-field="x_buyer_lname" value="<?= $Grid->buyer_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_lname->getPlaceHolder()) ?>"<?= $Grid->buyer_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_lname->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_lname" data-hidden="1" name="o<?= $Grid->RowIndex ?>_buyer_lname" id="o<?= $Grid->RowIndex ?>_buyer_lname" value="<?= HtmlEncode($Grid->buyer_lname->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_lname" class="el_doc_juzmatch3_buyer_lname">
<input type="<?= $Grid->buyer_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_lname" id="x<?= $Grid->RowIndex ?>_buyer_lname" data-table="doc_juzmatch3" data-field="x_buyer_lname" value="<?= $Grid->buyer_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_lname->getPlaceHolder()) ?>"<?= $Grid->buyer_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_lname->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_lname" class="el_doc_juzmatch3_buyer_lname">
<span<?= $Grid->buyer_lname->viewAttributes() ?>>
<?= $Grid->buyer_lname->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_lname" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_buyer_lname" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_buyer_lname" value="<?= HtmlEncode($Grid->buyer_lname->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_lname" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_buyer_lname" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_buyer_lname" value="<?= HtmlEncode($Grid->buyer_lname->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->buyer_email->Visible) { // buyer_email ?>
        <td data-name="buyer_email"<?= $Grid->buyer_email->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_email" class="el_doc_juzmatch3_buyer_email">
<input type="<?= $Grid->buyer_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_email" id="x<?= $Grid->RowIndex ?>_buyer_email" data-table="doc_juzmatch3" data-field="x_buyer_email" value="<?= $Grid->buyer_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_email->getPlaceHolder()) ?>"<?= $Grid->buyer_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_buyer_email" id="o<?= $Grid->RowIndex ?>_buyer_email" value="<?= HtmlEncode($Grid->buyer_email->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_email" class="el_doc_juzmatch3_buyer_email">
<input type="<?= $Grid->buyer_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_email" id="x<?= $Grid->RowIndex ?>_buyer_email" data-table="doc_juzmatch3" data-field="x_buyer_email" value="<?= $Grid->buyer_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_email->getPlaceHolder()) ?>"<?= $Grid->buyer_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_email" class="el_doc_juzmatch3_buyer_email">
<span<?= $Grid->buyer_email->viewAttributes() ?>>
<?= $Grid->buyer_email->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_email" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_buyer_email" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_buyer_email" value="<?= HtmlEncode($Grid->buyer_email->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_email" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_buyer_email" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_buyer_email" value="<?= HtmlEncode($Grid->buyer_email->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->buyer_idcard->Visible) { // buyer_idcard ?>
        <td data-name="buyer_idcard"<?= $Grid->buyer_idcard->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_idcard" class="el_doc_juzmatch3_buyer_idcard">
<input type="<?= $Grid->buyer_idcard->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_idcard" id="x<?= $Grid->RowIndex ?>_buyer_idcard" data-table="doc_juzmatch3" data-field="x_buyer_idcard" value="<?= $Grid->buyer_idcard->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_idcard->getPlaceHolder()) ?>"<?= $Grid->buyer_idcard->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_idcard->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_idcard" data-hidden="1" name="o<?= $Grid->RowIndex ?>_buyer_idcard" id="o<?= $Grid->RowIndex ?>_buyer_idcard" value="<?= HtmlEncode($Grid->buyer_idcard->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_idcard" class="el_doc_juzmatch3_buyer_idcard">
<input type="<?= $Grid->buyer_idcard->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_idcard" id="x<?= $Grid->RowIndex ?>_buyer_idcard" data-table="doc_juzmatch3" data-field="x_buyer_idcard" value="<?= $Grid->buyer_idcard->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_idcard->getPlaceHolder()) ?>"<?= $Grid->buyer_idcard->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_idcard->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_idcard" class="el_doc_juzmatch3_buyer_idcard">
<span<?= $Grid->buyer_idcard->viewAttributes() ?>>
<?= $Grid->buyer_idcard->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_idcard" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_buyer_idcard" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_buyer_idcard" value="<?= HtmlEncode($Grid->buyer_idcard->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_idcard" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_buyer_idcard" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_buyer_idcard" value="<?= HtmlEncode($Grid->buyer_idcard->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->buyer_homeno->Visible) { // buyer_homeno ?>
        <td data-name="buyer_homeno"<?= $Grid->buyer_homeno->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_homeno" class="el_doc_juzmatch3_buyer_homeno">
<input type="<?= $Grid->buyer_homeno->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_homeno" id="x<?= $Grid->RowIndex ?>_buyer_homeno" data-table="doc_juzmatch3" data-field="x_buyer_homeno" value="<?= $Grid->buyer_homeno->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_homeno->getPlaceHolder()) ?>"<?= $Grid->buyer_homeno->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_homeno->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_homeno" data-hidden="1" name="o<?= $Grid->RowIndex ?>_buyer_homeno" id="o<?= $Grid->RowIndex ?>_buyer_homeno" value="<?= HtmlEncode($Grid->buyer_homeno->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_homeno" class="el_doc_juzmatch3_buyer_homeno">
<input type="<?= $Grid->buyer_homeno->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_homeno" id="x<?= $Grid->RowIndex ?>_buyer_homeno" data-table="doc_juzmatch3" data-field="x_buyer_homeno" value="<?= $Grid->buyer_homeno->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_homeno->getPlaceHolder()) ?>"<?= $Grid->buyer_homeno->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_homeno->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_homeno" class="el_doc_juzmatch3_buyer_homeno">
<span<?= $Grid->buyer_homeno->viewAttributes() ?>>
<?= $Grid->buyer_homeno->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_homeno" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_buyer_homeno" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_buyer_homeno" value="<?= HtmlEncode($Grid->buyer_homeno->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_homeno" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_buyer_homeno" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_buyer_homeno" value="<?= HtmlEncode($Grid->buyer_homeno->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->buyer_witness_lname->Visible) { // buyer_witness_lname ?>
        <td data-name="buyer_witness_lname"<?= $Grid->buyer_witness_lname->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_witness_lname" class="el_doc_juzmatch3_buyer_witness_lname">
<input type="<?= $Grid->buyer_witness_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_witness_lname" id="x<?= $Grid->RowIndex ?>_buyer_witness_lname" data-table="doc_juzmatch3" data-field="x_buyer_witness_lname" value="<?= $Grid->buyer_witness_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_witness_lname->getPlaceHolder()) ?>"<?= $Grid->buyer_witness_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_witness_lname->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_witness_lname" data-hidden="1" name="o<?= $Grid->RowIndex ?>_buyer_witness_lname" id="o<?= $Grid->RowIndex ?>_buyer_witness_lname" value="<?= HtmlEncode($Grid->buyer_witness_lname->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_witness_lname" class="el_doc_juzmatch3_buyer_witness_lname">
<input type="<?= $Grid->buyer_witness_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_witness_lname" id="x<?= $Grid->RowIndex ?>_buyer_witness_lname" data-table="doc_juzmatch3" data-field="x_buyer_witness_lname" value="<?= $Grid->buyer_witness_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_witness_lname->getPlaceHolder()) ?>"<?= $Grid->buyer_witness_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_witness_lname->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_witness_lname" class="el_doc_juzmatch3_buyer_witness_lname">
<span<?= $Grid->buyer_witness_lname->viewAttributes() ?>>
<?= $Grid->buyer_witness_lname->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_witness_lname" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_buyer_witness_lname" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_buyer_witness_lname" value="<?= HtmlEncode($Grid->buyer_witness_lname->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_witness_lname" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_buyer_witness_lname" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_buyer_witness_lname" value="<?= HtmlEncode($Grid->buyer_witness_lname->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->buyer_witness_email->Visible) { // buyer_witness_email ?>
        <td data-name="buyer_witness_email"<?= $Grid->buyer_witness_email->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_witness_email" class="el_doc_juzmatch3_buyer_witness_email">
<input type="<?= $Grid->buyer_witness_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_witness_email" id="x<?= $Grid->RowIndex ?>_buyer_witness_email" data-table="doc_juzmatch3" data-field="x_buyer_witness_email" value="<?= $Grid->buyer_witness_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_witness_email->getPlaceHolder()) ?>"<?= $Grid->buyer_witness_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_witness_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_witness_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_buyer_witness_email" id="o<?= $Grid->RowIndex ?>_buyer_witness_email" value="<?= HtmlEncode($Grid->buyer_witness_email->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_witness_email" class="el_doc_juzmatch3_buyer_witness_email">
<input type="<?= $Grid->buyer_witness_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_witness_email" id="x<?= $Grid->RowIndex ?>_buyer_witness_email" data-table="doc_juzmatch3" data-field="x_buyer_witness_email" value="<?= $Grid->buyer_witness_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_witness_email->getPlaceHolder()) ?>"<?= $Grid->buyer_witness_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_witness_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_buyer_witness_email" class="el_doc_juzmatch3_buyer_witness_email">
<span<?= $Grid->buyer_witness_email->viewAttributes() ?>>
<?= $Grid->buyer_witness_email->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_witness_email" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_buyer_witness_email" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_buyer_witness_email" value="<?= HtmlEncode($Grid->buyer_witness_email->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_witness_email" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_buyer_witness_email" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_buyer_witness_email" value="<?= HtmlEncode($Grid->buyer_witness_email->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->investor_lname->Visible) { // investor_lname ?>
        <td data-name="investor_lname"<?= $Grid->investor_lname->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_investor_lname" class="el_doc_juzmatch3_investor_lname">
<input type="<?= $Grid->investor_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_investor_lname" id="x<?= $Grid->RowIndex ?>_investor_lname" data-table="doc_juzmatch3" data-field="x_investor_lname" value="<?= $Grid->investor_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->investor_lname->getPlaceHolder()) ?>"<?= $Grid->investor_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->investor_lname->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_investor_lname" data-hidden="1" name="o<?= $Grid->RowIndex ?>_investor_lname" id="o<?= $Grid->RowIndex ?>_investor_lname" value="<?= HtmlEncode($Grid->investor_lname->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_investor_lname" class="el_doc_juzmatch3_investor_lname">
<input type="<?= $Grid->investor_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_investor_lname" id="x<?= $Grid->RowIndex ?>_investor_lname" data-table="doc_juzmatch3" data-field="x_investor_lname" value="<?= $Grid->investor_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->investor_lname->getPlaceHolder()) ?>"<?= $Grid->investor_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->investor_lname->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_investor_lname" class="el_doc_juzmatch3_investor_lname">
<span<?= $Grid->investor_lname->viewAttributes() ?>>
<?= $Grid->investor_lname->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_investor_lname" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_investor_lname" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_investor_lname" value="<?= HtmlEncode($Grid->investor_lname->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_investor_lname" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_investor_lname" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_investor_lname" value="<?= HtmlEncode($Grid->investor_lname->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->investor_email->Visible) { // investor_email ?>
        <td data-name="investor_email"<?= $Grid->investor_email->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_investor_email" class="el_doc_juzmatch3_investor_email">
<input type="<?= $Grid->investor_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_investor_email" id="x<?= $Grid->RowIndex ?>_investor_email" data-table="doc_juzmatch3" data-field="x_investor_email" value="<?= $Grid->investor_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->investor_email->getPlaceHolder()) ?>"<?= $Grid->investor_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->investor_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_investor_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_investor_email" id="o<?= $Grid->RowIndex ?>_investor_email" value="<?= HtmlEncode($Grid->investor_email->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_investor_email" class="el_doc_juzmatch3_investor_email">
<input type="<?= $Grid->investor_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_investor_email" id="x<?= $Grid->RowIndex ?>_investor_email" data-table="doc_juzmatch3" data-field="x_investor_email" value="<?= $Grid->investor_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->investor_email->getPlaceHolder()) ?>"<?= $Grid->investor_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->investor_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_investor_email" class="el_doc_juzmatch3_investor_email">
<span<?= $Grid->investor_email->viewAttributes() ?>>
<?= $Grid->investor_email->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_investor_email" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_investor_email" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_investor_email" value="<?= HtmlEncode($Grid->investor_email->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_investor_email" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_investor_email" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_investor_email" value="<?= HtmlEncode($Grid->investor_email->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
        <td data-name="juzmatch_authority_lname"<?= $Grid->juzmatch_authority_lname->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority_lname" class="el_doc_juzmatch3_juzmatch_authority_lname">
<input type="<?= $Grid->juzmatch_authority_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_lname" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_lname" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_lname" value="<?= $Grid->juzmatch_authority_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority_lname->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority_lname->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_lname" data-hidden="1" name="o<?= $Grid->RowIndex ?>_juzmatch_authority_lname" id="o<?= $Grid->RowIndex ?>_juzmatch_authority_lname" value="<?= HtmlEncode($Grid->juzmatch_authority_lname->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority_lname" class="el_doc_juzmatch3_juzmatch_authority_lname">
<input type="<?= $Grid->juzmatch_authority_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_lname" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_lname" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_lname" value="<?= $Grid->juzmatch_authority_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority_lname->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority_lname->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority_lname" class="el_doc_juzmatch3_juzmatch_authority_lname">
<span<?= $Grid->juzmatch_authority_lname->viewAttributes() ?>>
<?= $Grid->juzmatch_authority_lname->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_lname" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_juzmatch_authority_lname" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_juzmatch_authority_lname" value="<?= HtmlEncode($Grid->juzmatch_authority_lname->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_lname" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_juzmatch_authority_lname" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_juzmatch_authority_lname" value="<?= HtmlEncode($Grid->juzmatch_authority_lname->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
        <td data-name="juzmatch_authority_email"<?= $Grid->juzmatch_authority_email->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority_email" class="el_doc_juzmatch3_juzmatch_authority_email">
<input type="<?= $Grid->juzmatch_authority_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_email" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_email" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_email" value="<?= $Grid->juzmatch_authority_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority_email->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_juzmatch_authority_email" id="o<?= $Grid->RowIndex ?>_juzmatch_authority_email" value="<?= HtmlEncode($Grid->juzmatch_authority_email->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority_email" class="el_doc_juzmatch3_juzmatch_authority_email">
<input type="<?= $Grid->juzmatch_authority_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_email" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_email" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_email" value="<?= $Grid->juzmatch_authority_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority_email->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority_email" class="el_doc_juzmatch3_juzmatch_authority_email">
<span<?= $Grid->juzmatch_authority_email->viewAttributes() ?>>
<?= $Grid->juzmatch_authority_email->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_email" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_juzmatch_authority_email" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_juzmatch_authority_email" value="<?= HtmlEncode($Grid->juzmatch_authority_email->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_email" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_juzmatch_authority_email" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_juzmatch_authority_email" value="<?= HtmlEncode($Grid->juzmatch_authority_email->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
        <td data-name="juzmatch_authority_witness_lname"<?= $Grid->juzmatch_authority_witness_lname->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority_witness_lname" class="el_doc_juzmatch3_juzmatch_authority_witness_lname">
<input type="<?= $Grid->juzmatch_authority_witness_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_lname" value="<?= $Grid->juzmatch_authority_witness_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority_witness_lname->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority_witness_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority_witness_lname->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_lname" data-hidden="1" name="o<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" id="o<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" value="<?= HtmlEncode($Grid->juzmatch_authority_witness_lname->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority_witness_lname" class="el_doc_juzmatch3_juzmatch_authority_witness_lname">
<input type="<?= $Grid->juzmatch_authority_witness_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_lname" value="<?= $Grid->juzmatch_authority_witness_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority_witness_lname->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority_witness_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority_witness_lname->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority_witness_lname" class="el_doc_juzmatch3_juzmatch_authority_witness_lname">
<span<?= $Grid->juzmatch_authority_witness_lname->viewAttributes() ?>>
<?= $Grid->juzmatch_authority_witness_lname->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_lname" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" value="<?= HtmlEncode($Grid->juzmatch_authority_witness_lname->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_lname" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" value="<?= HtmlEncode($Grid->juzmatch_authority_witness_lname->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
        <td data-name="juzmatch_authority_witness_email"<?= $Grid->juzmatch_authority_witness_email->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority_witness_email" class="el_doc_juzmatch3_juzmatch_authority_witness_email">
<input type="<?= $Grid->juzmatch_authority_witness_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_email" value="<?= $Grid->juzmatch_authority_witness_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority_witness_email->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority_witness_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority_witness_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" id="o<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" value="<?= HtmlEncode($Grid->juzmatch_authority_witness_email->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority_witness_email" class="el_doc_juzmatch3_juzmatch_authority_witness_email">
<input type="<?= $Grid->juzmatch_authority_witness_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_email" value="<?= $Grid->juzmatch_authority_witness_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority_witness_email->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority_witness_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority_witness_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority_witness_email" class="el_doc_juzmatch3_juzmatch_authority_witness_email">
<span<?= $Grid->juzmatch_authority_witness_email->viewAttributes() ?>>
<?= $Grid->juzmatch_authority_witness_email->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_email" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" value="<?= HtmlEncode($Grid->juzmatch_authority_witness_email->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_email" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" value="<?= HtmlEncode($Grid->juzmatch_authority_witness_email->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
        <td data-name="juzmatch_authority2_name"<?= $Grid->juzmatch_authority2_name->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority2_name" class="el_doc_juzmatch3_juzmatch_authority2_name">
<input type="<?= $Grid->juzmatch_authority2_name->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority2_name" id="x<?= $Grid->RowIndex ?>_juzmatch_authority2_name" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_name" value="<?= $Grid->juzmatch_authority2_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Grid->juzmatch_authority2_name->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority2_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority2_name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_juzmatch_authority2_name" id="o<?= $Grid->RowIndex ?>_juzmatch_authority2_name" value="<?= HtmlEncode($Grid->juzmatch_authority2_name->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority2_name" class="el_doc_juzmatch3_juzmatch_authority2_name">
<input type="<?= $Grid->juzmatch_authority2_name->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority2_name" id="x<?= $Grid->RowIndex ?>_juzmatch_authority2_name" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_name" value="<?= $Grid->juzmatch_authority2_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Grid->juzmatch_authority2_name->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority2_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority2_name->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority2_name" class="el_doc_juzmatch3_juzmatch_authority2_name">
<span<?= $Grid->juzmatch_authority2_name->viewAttributes() ?>>
<?= $Grid->juzmatch_authority2_name->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_name" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_juzmatch_authority2_name" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_juzmatch_authority2_name" value="<?= HtmlEncode($Grid->juzmatch_authority2_name->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_name" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_juzmatch_authority2_name" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_juzmatch_authority2_name" value="<?= HtmlEncode($Grid->juzmatch_authority2_name->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
        <td data-name="juzmatch_authority2_lname"<?= $Grid->juzmatch_authority2_lname->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority2_lname" class="el_doc_juzmatch3_juzmatch_authority2_lname">
<input type="<?= $Grid->juzmatch_authority2_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" id="x<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_lname" value="<?= $Grid->juzmatch_authority2_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority2_lname->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority2_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority2_lname->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_lname" data-hidden="1" name="o<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" id="o<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" value="<?= HtmlEncode($Grid->juzmatch_authority2_lname->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority2_lname" class="el_doc_juzmatch3_juzmatch_authority2_lname">
<input type="<?= $Grid->juzmatch_authority2_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" id="x<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_lname" value="<?= $Grid->juzmatch_authority2_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority2_lname->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority2_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority2_lname->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority2_lname" class="el_doc_juzmatch3_juzmatch_authority2_lname">
<span<?= $Grid->juzmatch_authority2_lname->viewAttributes() ?>>
<?= $Grid->juzmatch_authority2_lname->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_lname" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" value="<?= HtmlEncode($Grid->juzmatch_authority2_lname->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_lname" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" value="<?= HtmlEncode($Grid->juzmatch_authority2_lname->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
        <td data-name="juzmatch_authority2_email"<?= $Grid->juzmatch_authority2_email->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority2_email" class="el_doc_juzmatch3_juzmatch_authority2_email">
<input type="<?= $Grid->juzmatch_authority2_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority2_email" id="x<?= $Grid->RowIndex ?>_juzmatch_authority2_email" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_email" value="<?= $Grid->juzmatch_authority2_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority2_email->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority2_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority2_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_juzmatch_authority2_email" id="o<?= $Grid->RowIndex ?>_juzmatch_authority2_email" value="<?= HtmlEncode($Grid->juzmatch_authority2_email->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority2_email" class="el_doc_juzmatch3_juzmatch_authority2_email">
<input type="<?= $Grid->juzmatch_authority2_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority2_email" id="x<?= $Grid->RowIndex ?>_juzmatch_authority2_email" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_email" value="<?= $Grid->juzmatch_authority2_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority2_email->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority2_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority2_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_juzmatch_authority2_email" class="el_doc_juzmatch3_juzmatch_authority2_email">
<span<?= $Grid->juzmatch_authority2_email->viewAttributes() ?>>
<?= $Grid->juzmatch_authority2_email->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_email" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_juzmatch_authority2_email" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_juzmatch_authority2_email" value="<?= HtmlEncode($Grid->juzmatch_authority2_email->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_email" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_juzmatch_authority2_email" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_juzmatch_authority2_email" value="<?= HtmlEncode($Grid->juzmatch_authority2_email->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->company_seal_name->Visible) { // company_seal_name ?>
        <td data-name="company_seal_name"<?= $Grid->company_seal_name->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_company_seal_name" class="el_doc_juzmatch3_company_seal_name">
<input type="<?= $Grid->company_seal_name->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_company_seal_name" id="x<?= $Grid->RowIndex ?>_company_seal_name" data-table="doc_juzmatch3" data-field="x_company_seal_name" value="<?= $Grid->company_seal_name->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->company_seal_name->getPlaceHolder()) ?>"<?= $Grid->company_seal_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->company_seal_name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_company_seal_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_company_seal_name" id="o<?= $Grid->RowIndex ?>_company_seal_name" value="<?= HtmlEncode($Grid->company_seal_name->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_company_seal_name" class="el_doc_juzmatch3_company_seal_name">
<input type="<?= $Grid->company_seal_name->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_company_seal_name" id="x<?= $Grid->RowIndex ?>_company_seal_name" data-table="doc_juzmatch3" data-field="x_company_seal_name" value="<?= $Grid->company_seal_name->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->company_seal_name->getPlaceHolder()) ?>"<?= $Grid->company_seal_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->company_seal_name->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_company_seal_name" class="el_doc_juzmatch3_company_seal_name">
<span<?= $Grid->company_seal_name->viewAttributes() ?>>
<?= $Grid->company_seal_name->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_company_seal_name" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_company_seal_name" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_company_seal_name" value="<?= HtmlEncode($Grid->company_seal_name->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_company_seal_name" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_company_seal_name" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_company_seal_name" value="<?= HtmlEncode($Grid->company_seal_name->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->company_seal_email->Visible) { // company_seal_email ?>
        <td data-name="company_seal_email"<?= $Grid->company_seal_email->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_company_seal_email" class="el_doc_juzmatch3_company_seal_email">
<input type="<?= $Grid->company_seal_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_company_seal_email" id="x<?= $Grid->RowIndex ?>_company_seal_email" data-table="doc_juzmatch3" data-field="x_company_seal_email" value="<?= $Grid->company_seal_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->company_seal_email->getPlaceHolder()) ?>"<?= $Grid->company_seal_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->company_seal_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_company_seal_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_company_seal_email" id="o<?= $Grid->RowIndex ?>_company_seal_email" value="<?= HtmlEncode($Grid->company_seal_email->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_company_seal_email" class="el_doc_juzmatch3_company_seal_email">
<input type="<?= $Grid->company_seal_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_company_seal_email" id="x<?= $Grid->RowIndex ?>_company_seal_email" data-table="doc_juzmatch3" data-field="x_company_seal_email" value="<?= $Grid->company_seal_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->company_seal_email->getPlaceHolder()) ?>"<?= $Grid->company_seal_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->company_seal_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_company_seal_email" class="el_doc_juzmatch3_company_seal_email">
<span<?= $Grid->company_seal_email->viewAttributes() ?>>
<?= $Grid->company_seal_email->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_company_seal_email" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_company_seal_email" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_company_seal_email" value="<?= HtmlEncode($Grid->company_seal_email->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_company_seal_email" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_company_seal_email" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_company_seal_email" value="<?= HtmlEncode($Grid->company_seal_email->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->total->Visible) { // total ?>
        <td data-name="total"<?= $Grid->total->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_total" class="el_doc_juzmatch3_total">
<input type="<?= $Grid->total->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_total" id="x<?= $Grid->RowIndex ?>_total" data-table="doc_juzmatch3" data-field="x_total" value="<?= $Grid->total->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Grid->total->getPlaceHolder()) ?>"<?= $Grid->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_total" data-hidden="1" name="o<?= $Grid->RowIndex ?>_total" id="o<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_total" class="el_doc_juzmatch3_total">
<input type="<?= $Grid->total->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_total" id="x<?= $Grid->RowIndex ?>_total" data-table="doc_juzmatch3" data-field="x_total" value="<?= $Grid->total->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Grid->total->getPlaceHolder()) ?>"<?= $Grid->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_total" class="el_doc_juzmatch3_total">
<span<?= $Grid->total->viewAttributes() ?>>
<?= $Grid->total->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_total" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_total" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_total" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_total" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->total_txt->Visible) { // total_txt ?>
        <td data-name="total_txt"<?= $Grid->total_txt->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_total_txt" class="el_doc_juzmatch3_total_txt">
<input type="<?= $Grid->total_txt->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_total_txt" id="x<?= $Grid->RowIndex ?>_total_txt" data-table="doc_juzmatch3" data-field="x_total_txt" value="<?= $Grid->total_txt->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Grid->total_txt->getPlaceHolder()) ?>"<?= $Grid->total_txt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total_txt->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_total_txt" data-hidden="1" name="o<?= $Grid->RowIndex ?>_total_txt" id="o<?= $Grid->RowIndex ?>_total_txt" value="<?= HtmlEncode($Grid->total_txt->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_total_txt" class="el_doc_juzmatch3_total_txt">
<input type="<?= $Grid->total_txt->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_total_txt" id="x<?= $Grid->RowIndex ?>_total_txt" data-table="doc_juzmatch3" data-field="x_total_txt" value="<?= $Grid->total_txt->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Grid->total_txt->getPlaceHolder()) ?>"<?= $Grid->total_txt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total_txt->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_total_txt" class="el_doc_juzmatch3_total_txt">
<span<?= $Grid->total_txt->viewAttributes() ?>>
<?= $Grid->total_txt->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_total_txt" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_total_txt" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_total_txt" value="<?= HtmlEncode($Grid->total_txt->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_total_txt" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_total_txt" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_total_txt" value="<?= HtmlEncode($Grid->total_txt->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->next_pay_date->Visible) { // next_pay_date ?>
        <td data-name="next_pay_date"<?= $Grid->next_pay_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_next_pay_date" class="el_doc_juzmatch3_next_pay_date">
<input type="<?= $Grid->next_pay_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_next_pay_date" id="x<?= $Grid->RowIndex ?>_next_pay_date" data-table="doc_juzmatch3" data-field="x_next_pay_date" value="<?= $Grid->next_pay_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->next_pay_date->getPlaceHolder()) ?>"<?= $Grid->next_pay_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->next_pay_date->getErrorMessage() ?></div>
<?php if (!$Grid->next_pay_date->ReadOnly && !$Grid->next_pay_date->Disabled && !isset($Grid->next_pay_date->EditAttrs["readonly"]) && !isset($Grid->next_pay_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_next_pay_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_next_pay_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_next_pay_date" id="o<?= $Grid->RowIndex ?>_next_pay_date" value="<?= HtmlEncode($Grid->next_pay_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_next_pay_date" class="el_doc_juzmatch3_next_pay_date">
<input type="<?= $Grid->next_pay_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_next_pay_date" id="x<?= $Grid->RowIndex ?>_next_pay_date" data-table="doc_juzmatch3" data-field="x_next_pay_date" value="<?= $Grid->next_pay_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->next_pay_date->getPlaceHolder()) ?>"<?= $Grid->next_pay_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->next_pay_date->getErrorMessage() ?></div>
<?php if (!$Grid->next_pay_date->ReadOnly && !$Grid->next_pay_date->Disabled && !isset($Grid->next_pay_date->EditAttrs["readonly"]) && !isset($Grid->next_pay_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_next_pay_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_next_pay_date" class="el_doc_juzmatch3_next_pay_date">
<span<?= $Grid->next_pay_date->viewAttributes() ?>>
<?= $Grid->next_pay_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_next_pay_date" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_next_pay_date" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_next_pay_date" value="<?= HtmlEncode($Grid->next_pay_date->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_next_pay_date" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_next_pay_date" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_next_pay_date" value="<?= HtmlEncode($Grid->next_pay_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->next_pay_date_txt->Visible) { // next_pay_date_txt ?>
        <td data-name="next_pay_date_txt"<?= $Grid->next_pay_date_txt->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_next_pay_date_txt" class="el_doc_juzmatch3_next_pay_date_txt">
<input type="<?= $Grid->next_pay_date_txt->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_next_pay_date_txt" id="x<?= $Grid->RowIndex ?>_next_pay_date_txt" data-table="doc_juzmatch3" data-field="x_next_pay_date_txt" value="<?= $Grid->next_pay_date_txt->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->next_pay_date_txt->getPlaceHolder()) ?>"<?= $Grid->next_pay_date_txt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->next_pay_date_txt->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_next_pay_date_txt" data-hidden="1" name="o<?= $Grid->RowIndex ?>_next_pay_date_txt" id="o<?= $Grid->RowIndex ?>_next_pay_date_txt" value="<?= HtmlEncode($Grid->next_pay_date_txt->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_next_pay_date_txt" class="el_doc_juzmatch3_next_pay_date_txt">
<input type="<?= $Grid->next_pay_date_txt->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_next_pay_date_txt" id="x<?= $Grid->RowIndex ?>_next_pay_date_txt" data-table="doc_juzmatch3" data-field="x_next_pay_date_txt" value="<?= $Grid->next_pay_date_txt->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->next_pay_date_txt->getPlaceHolder()) ?>"<?= $Grid->next_pay_date_txt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->next_pay_date_txt->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_next_pay_date_txt" class="el_doc_juzmatch3_next_pay_date_txt">
<span<?= $Grid->next_pay_date_txt->viewAttributes() ?>>
<?= $Grid->next_pay_date_txt->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_next_pay_date_txt" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_next_pay_date_txt" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_next_pay_date_txt" value="<?= HtmlEncode($Grid->next_pay_date_txt->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_next_pay_date_txt" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_next_pay_date_txt" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_next_pay_date_txt" value="<?= HtmlEncode($Grid->next_pay_date_txt->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->service_price->Visible) { // service_price ?>
        <td data-name="service_price"<?= $Grid->service_price->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_service_price" class="el_doc_juzmatch3_service_price">
<input type="<?= $Grid->service_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_service_price" id="x<?= $Grid->RowIndex ?>_service_price" data-table="doc_juzmatch3" data-field="x_service_price" value="<?= $Grid->service_price->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Grid->service_price->getPlaceHolder()) ?>"<?= $Grid->service_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->service_price->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_service_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_service_price" id="o<?= $Grid->RowIndex ?>_service_price" value="<?= HtmlEncode($Grid->service_price->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_service_price" class="el_doc_juzmatch3_service_price">
<input type="<?= $Grid->service_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_service_price" id="x<?= $Grid->RowIndex ?>_service_price" data-table="doc_juzmatch3" data-field="x_service_price" value="<?= $Grid->service_price->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Grid->service_price->getPlaceHolder()) ?>"<?= $Grid->service_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->service_price->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_service_price" class="el_doc_juzmatch3_service_price">
<span<?= $Grid->service_price->viewAttributes() ?>>
<?= $Grid->service_price->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_service_price" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_service_price" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_service_price" value="<?= HtmlEncode($Grid->service_price->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_service_price" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_service_price" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_service_price" value="<?= HtmlEncode($Grid->service_price->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->service_price_txt->Visible) { // service_price_txt ?>
        <td data-name="service_price_txt"<?= $Grid->service_price_txt->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_service_price_txt" class="el_doc_juzmatch3_service_price_txt">
<input type="<?= $Grid->service_price_txt->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_service_price_txt" id="x<?= $Grid->RowIndex ?>_service_price_txt" data-table="doc_juzmatch3" data-field="x_service_price_txt" value="<?= $Grid->service_price_txt->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->service_price_txt->getPlaceHolder()) ?>"<?= $Grid->service_price_txt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->service_price_txt->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_service_price_txt" data-hidden="1" name="o<?= $Grid->RowIndex ?>_service_price_txt" id="o<?= $Grid->RowIndex ?>_service_price_txt" value="<?= HtmlEncode($Grid->service_price_txt->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_service_price_txt" class="el_doc_juzmatch3_service_price_txt">
<input type="<?= $Grid->service_price_txt->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_service_price_txt" id="x<?= $Grid->RowIndex ?>_service_price_txt" data-table="doc_juzmatch3" data-field="x_service_price_txt" value="<?= $Grid->service_price_txt->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->service_price_txt->getPlaceHolder()) ?>"<?= $Grid->service_price_txt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->service_price_txt->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_service_price_txt" class="el_doc_juzmatch3_service_price_txt">
<span<?= $Grid->service_price_txt->viewAttributes() ?>>
<?= $Grid->service_price_txt->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_service_price_txt" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_service_price_txt" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_service_price_txt" value="<?= HtmlEncode($Grid->service_price_txt->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_service_price_txt" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_service_price_txt" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_service_price_txt" value="<?= HtmlEncode($Grid->service_price_txt->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->provide_service_date->Visible) { // provide_service_date ?>
        <td data-name="provide_service_date"<?= $Grid->provide_service_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_provide_service_date" class="el_doc_juzmatch3_provide_service_date">
<input type="<?= $Grid->provide_service_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_provide_service_date" id="x<?= $Grid->RowIndex ?>_provide_service_date" data-table="doc_juzmatch3" data-field="x_provide_service_date" value="<?= $Grid->provide_service_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->provide_service_date->getPlaceHolder()) ?>"<?= $Grid->provide_service_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->provide_service_date->getErrorMessage() ?></div>
<?php if (!$Grid->provide_service_date->ReadOnly && !$Grid->provide_service_date->Disabled && !isset($Grid->provide_service_date->EditAttrs["readonly"]) && !isset($Grid->provide_service_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_provide_service_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_provide_service_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_provide_service_date" id="o<?= $Grid->RowIndex ?>_provide_service_date" value="<?= HtmlEncode($Grid->provide_service_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_provide_service_date" class="el_doc_juzmatch3_provide_service_date">
<input type="<?= $Grid->provide_service_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_provide_service_date" id="x<?= $Grid->RowIndex ?>_provide_service_date" data-table="doc_juzmatch3" data-field="x_provide_service_date" value="<?= $Grid->provide_service_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->provide_service_date->getPlaceHolder()) ?>"<?= $Grid->provide_service_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->provide_service_date->getErrorMessage() ?></div>
<?php if (!$Grid->provide_service_date->ReadOnly && !$Grid->provide_service_date->Disabled && !isset($Grid->provide_service_date->EditAttrs["readonly"]) && !isset($Grid->provide_service_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_provide_service_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_provide_service_date" class="el_doc_juzmatch3_provide_service_date">
<span<?= $Grid->provide_service_date->viewAttributes() ?>>
<?= $Grid->provide_service_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_provide_service_date" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_provide_service_date" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_provide_service_date" value="<?= HtmlEncode($Grid->provide_service_date->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_provide_service_date" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_provide_service_date" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_provide_service_date" value="<?= HtmlEncode($Grid->provide_service_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->contact_address->Visible) { // contact_address ?>
        <td data-name="contact_address"<?= $Grid->contact_address->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_address" class="el_doc_juzmatch3_contact_address">
<input type="<?= $Grid->contact_address->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_address" id="x<?= $Grid->RowIndex ?>_contact_address" data-table="doc_juzmatch3" data-field="x_contact_address" value="<?= $Grid->contact_address->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_address->getPlaceHolder()) ?>"<?= $Grid->contact_address->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_address->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_address" data-hidden="1" name="o<?= $Grid->RowIndex ?>_contact_address" id="o<?= $Grid->RowIndex ?>_contact_address" value="<?= HtmlEncode($Grid->contact_address->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_address" class="el_doc_juzmatch3_contact_address">
<input type="<?= $Grid->contact_address->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_address" id="x<?= $Grid->RowIndex ?>_contact_address" data-table="doc_juzmatch3" data-field="x_contact_address" value="<?= $Grid->contact_address->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_address->getPlaceHolder()) ?>"<?= $Grid->contact_address->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_address->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_address" class="el_doc_juzmatch3_contact_address">
<span<?= $Grid->contact_address->viewAttributes() ?>>
<?= $Grid->contact_address->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_address" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_contact_address" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_contact_address" value="<?= HtmlEncode($Grid->contact_address->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_address" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_contact_address" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_contact_address" value="<?= HtmlEncode($Grid->contact_address->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->contact_address2->Visible) { // contact_address2 ?>
        <td data-name="contact_address2"<?= $Grid->contact_address2->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_address2" class="el_doc_juzmatch3_contact_address2">
<input type="<?= $Grid->contact_address2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_address2" id="x<?= $Grid->RowIndex ?>_contact_address2" data-table="doc_juzmatch3" data-field="x_contact_address2" value="<?= $Grid->contact_address2->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_address2->getPlaceHolder()) ?>"<?= $Grid->contact_address2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_address2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_address2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_contact_address2" id="o<?= $Grid->RowIndex ?>_contact_address2" value="<?= HtmlEncode($Grid->contact_address2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_address2" class="el_doc_juzmatch3_contact_address2">
<input type="<?= $Grid->contact_address2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_address2" id="x<?= $Grid->RowIndex ?>_contact_address2" data-table="doc_juzmatch3" data-field="x_contact_address2" value="<?= $Grid->contact_address2->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_address2->getPlaceHolder()) ?>"<?= $Grid->contact_address2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_address2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_address2" class="el_doc_juzmatch3_contact_address2">
<span<?= $Grid->contact_address2->viewAttributes() ?>>
<?= $Grid->contact_address2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_address2" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_contact_address2" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_contact_address2" value="<?= HtmlEncode($Grid->contact_address2->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_address2" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_contact_address2" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_contact_address2" value="<?= HtmlEncode($Grid->contact_address2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->contact_email->Visible) { // contact_email ?>
        <td data-name="contact_email"<?= $Grid->contact_email->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_email" class="el_doc_juzmatch3_contact_email">
<input type="<?= $Grid->contact_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_email" id="x<?= $Grid->RowIndex ?>_contact_email" data-table="doc_juzmatch3" data-field="x_contact_email" value="<?= $Grid->contact_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_email->getPlaceHolder()) ?>"<?= $Grid->contact_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_contact_email" id="o<?= $Grid->RowIndex ?>_contact_email" value="<?= HtmlEncode($Grid->contact_email->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_email" class="el_doc_juzmatch3_contact_email">
<input type="<?= $Grid->contact_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_email" id="x<?= $Grid->RowIndex ?>_contact_email" data-table="doc_juzmatch3" data-field="x_contact_email" value="<?= $Grid->contact_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_email->getPlaceHolder()) ?>"<?= $Grid->contact_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_email" class="el_doc_juzmatch3_contact_email">
<span<?= $Grid->contact_email->viewAttributes() ?>>
<?= $Grid->contact_email->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_email" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_contact_email" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_contact_email" value="<?= HtmlEncode($Grid->contact_email->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_email" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_contact_email" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_contact_email" value="<?= HtmlEncode($Grid->contact_email->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->contact_lineid->Visible) { // contact_lineid ?>
        <td data-name="contact_lineid"<?= $Grid->contact_lineid->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_lineid" class="el_doc_juzmatch3_contact_lineid">
<input type="<?= $Grid->contact_lineid->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_lineid" id="x<?= $Grid->RowIndex ?>_contact_lineid" data-table="doc_juzmatch3" data-field="x_contact_lineid" value="<?= $Grid->contact_lineid->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_lineid->getPlaceHolder()) ?>"<?= $Grid->contact_lineid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_lineid->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_lineid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_contact_lineid" id="o<?= $Grid->RowIndex ?>_contact_lineid" value="<?= HtmlEncode($Grid->contact_lineid->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_lineid" class="el_doc_juzmatch3_contact_lineid">
<input type="<?= $Grid->contact_lineid->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_lineid" id="x<?= $Grid->RowIndex ?>_contact_lineid" data-table="doc_juzmatch3" data-field="x_contact_lineid" value="<?= $Grid->contact_lineid->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_lineid->getPlaceHolder()) ?>"<?= $Grid->contact_lineid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_lineid->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_lineid" class="el_doc_juzmatch3_contact_lineid">
<span<?= $Grid->contact_lineid->viewAttributes() ?>>
<?= $Grid->contact_lineid->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_lineid" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_contact_lineid" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_contact_lineid" value="<?= HtmlEncode($Grid->contact_lineid->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_lineid" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_contact_lineid" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_contact_lineid" value="<?= HtmlEncode($Grid->contact_lineid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->contact_phone->Visible) { // contact_phone ?>
        <td data-name="contact_phone"<?= $Grid->contact_phone->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_phone" class="el_doc_juzmatch3_contact_phone">
<input type="<?= $Grid->contact_phone->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_phone" id="x<?= $Grid->RowIndex ?>_contact_phone" data-table="doc_juzmatch3" data-field="x_contact_phone" value="<?= $Grid->contact_phone->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_phone->getPlaceHolder()) ?>"<?= $Grid->contact_phone->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_phone->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_phone" data-hidden="1" name="o<?= $Grid->RowIndex ?>_contact_phone" id="o<?= $Grid->RowIndex ?>_contact_phone" value="<?= HtmlEncode($Grid->contact_phone->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_phone" class="el_doc_juzmatch3_contact_phone">
<input type="<?= $Grid->contact_phone->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_phone" id="x<?= $Grid->RowIndex ?>_contact_phone" data-table="doc_juzmatch3" data-field="x_contact_phone" value="<?= $Grid->contact_phone->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_phone->getPlaceHolder()) ?>"<?= $Grid->contact_phone->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_phone->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_contact_phone" class="el_doc_juzmatch3_contact_phone">
<span<?= $Grid->contact_phone->viewAttributes() ?>>
<?= $Grid->contact_phone->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_phone" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_contact_phone" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_contact_phone" value="<?= HtmlEncode($Grid->contact_phone->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_phone" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_contact_phone" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_contact_phone" value="<?= HtmlEncode($Grid->contact_phone->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->attach_file->Visible) { // attach_file ?>
        <td data-name="attach_file"<?= $Grid->attach_file->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_attach_file" class="el_doc_juzmatch3_attach_file">
<input type="<?= $Grid->attach_file->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_attach_file" id="x<?= $Grid->RowIndex ?>_attach_file" data-table="doc_juzmatch3" data-field="x_attach_file" value="<?= $Grid->attach_file->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->attach_file->getPlaceHolder()) ?>"<?= $Grid->attach_file->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->attach_file->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_attach_file" data-hidden="1" name="o<?= $Grid->RowIndex ?>_attach_file" id="o<?= $Grid->RowIndex ?>_attach_file" value="<?= HtmlEncode($Grid->attach_file->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_attach_file" class="el_doc_juzmatch3_attach_file">
<input type="<?= $Grid->attach_file->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_attach_file" id="x<?= $Grid->RowIndex ?>_attach_file" data-table="doc_juzmatch3" data-field="x_attach_file" value="<?= $Grid->attach_file->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->attach_file->getPlaceHolder()) ?>"<?= $Grid->attach_file->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->attach_file->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_attach_file" class="el_doc_juzmatch3_attach_file">
<span<?= $Grid->attach_file->viewAttributes() ?>>
<?= $Grid->attach_file->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_attach_file" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_attach_file" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_attach_file" value="<?= HtmlEncode($Grid->attach_file->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_attach_file" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_attach_file" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_attach_file" value="<?= HtmlEncode($Grid->attach_file->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status"<?= $Grid->status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_status" class="el_doc_juzmatch3_status">
    <select
        id="x<?= $Grid->RowIndex ?>_status"
        name="x<?= $Grid->RowIndex ?>_status"
        class="form-select ew-select<?= $Grid->status->isInvalidClass() ?>"
        data-select2-id="fdoc_juzmatch3grid_x<?= $Grid->RowIndex ?>_status"
        data-table="doc_juzmatch3"
        data-field="x_status"
        data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>"
        <?= $Grid->status->editAttributes() ?>>
        <?= $Grid->status->selectOptionListHtml("x{$Grid->RowIndex}_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
<script>
loadjs.ready("fdoc_juzmatch3grid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status", selectId: "fdoc_juzmatch3grid_x<?= $Grid->RowIndex ?>_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdoc_juzmatch3grid.lists.status.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status", form: "fdoc_juzmatch3grid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status", form: "fdoc_juzmatch3grid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.doc_juzmatch3.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_status" class="el_doc_juzmatch3_status">
    <select
        id="x<?= $Grid->RowIndex ?>_status"
        name="x<?= $Grid->RowIndex ?>_status"
        class="form-select ew-select<?= $Grid->status->isInvalidClass() ?>"
        data-select2-id="fdoc_juzmatch3grid_x<?= $Grid->RowIndex ?>_status"
        data-table="doc_juzmatch3"
        data-field="x_status"
        data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>"
        <?= $Grid->status->editAttributes() ?>>
        <?= $Grid->status->selectOptionListHtml("x{$Grid->RowIndex}_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
<script>
loadjs.ready("fdoc_juzmatch3grid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status", selectId: "fdoc_juzmatch3grid_x<?= $Grid->RowIndex ?>_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdoc_juzmatch3grid.lists.status.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status", form: "fdoc_juzmatch3grid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status", form: "fdoc_juzmatch3grid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.doc_juzmatch3.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_status" class="el_doc_juzmatch3_status">
<span<?= $Grid->status->viewAttributes() ?>>
<?= $Grid->status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_status" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_status" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_status" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_status" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_doc_juzmatch3_cdate" class="el_doc_juzmatch3_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_cdate" data-hidden="1" name="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_cdate" id="fdoc_juzmatch3grid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="doc_juzmatch3" data-field="x_cdate" data-hidden="1" name="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_cdate" id="fdoc_juzmatch3grid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid","load"], () => fdoc_juzmatch3grid.updateLists(<?= $Grid->RowIndex ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
    $Grid->RowIndex = '$rowindex$';
    $Grid->loadRowValues();

    // Set row properties
    $Grid->resetAttributes();
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_doc_juzmatch3", "data-rowtype" => ROWTYPE_ADD]);
    $Grid->RowAttrs->appendClass("ew-template");

    // Reset previous form error if any
    $Grid->resetFormError();

    // Render row
    $Grid->RowType = ROWTYPE_ADD;
    $Grid->renderRow();

    // Render list options
    $Grid->renderListOptions();
    $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->document_date->Visible) { // document_date ?>
        <td data-name="document_date">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_document_date" class="el_doc_juzmatch3_document_date">
<span<?= $Grid->document_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->document_date->getDisplayValue($Grid->document_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_document_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_document_date" id="x<?= $Grid->RowIndex ?>_document_date" value="<?= HtmlEncode($Grid->document_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_document_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_document_date" id="o<?= $Grid->RowIndex ?>_document_date" value="<?= HtmlEncode($Grid->document_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->years->Visible) { // years ?>
        <td data-name="years">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_years" class="el_doc_juzmatch3_years">
<input type="<?= $Grid->years->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_years" id="x<?= $Grid->RowIndex ?>_years" data-table="doc_juzmatch3" data-field="x_years" value="<?= $Grid->years->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Grid->years->getPlaceHolder()) ?>"<?= $Grid->years->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->years->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_years" class="el_doc_juzmatch3_years">
<span<?= $Grid->years->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->years->getDisplayValue($Grid->years->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_years" data-hidden="1" name="x<?= $Grid->RowIndex ?>_years" id="x<?= $Grid->RowIndex ?>_years" value="<?= HtmlEncode($Grid->years->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_years" data-hidden="1" name="o<?= $Grid->RowIndex ?>_years" id="o<?= $Grid->RowIndex ?>_years" value="<?= HtmlEncode($Grid->years->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->start_date->Visible) { // start_date ?>
        <td data-name="start_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_start_date" class="el_doc_juzmatch3_start_date">
<input type="<?= $Grid->start_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_start_date" id="x<?= $Grid->RowIndex ?>_start_date" data-table="doc_juzmatch3" data-field="x_start_date" value="<?= $Grid->start_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->start_date->getPlaceHolder()) ?>"<?= $Grid->start_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->start_date->getErrorMessage() ?></div>
<?php if (!$Grid->start_date->ReadOnly && !$Grid->start_date->Disabled && !isset($Grid->start_date->EditAttrs["readonly"]) && !isset($Grid->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_start_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_start_date" class="el_doc_juzmatch3_start_date">
<span<?= $Grid->start_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->start_date->getDisplayValue($Grid->start_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_start_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_start_date" id="x<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_start_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_start_date" id="o<?= $Grid->RowIndex ?>_start_date" value="<?= HtmlEncode($Grid->start_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->end_date->Visible) { // end_date ?>
        <td data-name="end_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_end_date" class="el_doc_juzmatch3_end_date">
<input type="<?= $Grid->end_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_end_date" id="x<?= $Grid->RowIndex ?>_end_date" data-table="doc_juzmatch3" data-field="x_end_date" value="<?= $Grid->end_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->end_date->getPlaceHolder()) ?>"<?= $Grid->end_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->end_date->getErrorMessage() ?></div>
<?php if (!$Grid->end_date->ReadOnly && !$Grid->end_date->Disabled && !isset($Grid->end_date->EditAttrs["readonly"]) && !isset($Grid->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_end_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_end_date" class="el_doc_juzmatch3_end_date">
<span<?= $Grid->end_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->end_date->getDisplayValue($Grid->end_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_end_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_end_date" id="x<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_end_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_end_date" id="o<?= $Grid->RowIndex ?>_end_date" value="<?= HtmlEncode($Grid->end_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->asset_code->Visible) { // asset_code ?>
        <td data-name="asset_code">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_asset_code" class="el_doc_juzmatch3_asset_code">
<input type="<?= $Grid->asset_code->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_code" id="x<?= $Grid->RowIndex ?>_asset_code" data-table="doc_juzmatch3" data-field="x_asset_code" value="<?= $Grid->asset_code->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->asset_code->getPlaceHolder()) ?>"<?= $Grid->asset_code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_code->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_asset_code" class="el_doc_juzmatch3_asset_code">
<span<?= $Grid->asset_code->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->asset_code->getDisplayValue($Grid->asset_code->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_code" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_code" id="x<?= $Grid->RowIndex ?>_asset_code" value="<?= HtmlEncode($Grid->asset_code->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_code" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_code" id="o<?= $Grid->RowIndex ?>_asset_code" value="<?= HtmlEncode($Grid->asset_code->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->asset_project->Visible) { // asset_project ?>
        <td data-name="asset_project">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_asset_project" class="el_doc_juzmatch3_asset_project">
<input type="<?= $Grid->asset_project->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_project" id="x<?= $Grid->RowIndex ?>_asset_project" data-table="doc_juzmatch3" data-field="x_asset_project" value="<?= $Grid->asset_project->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->asset_project->getPlaceHolder()) ?>"<?= $Grid->asset_project->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_project->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_asset_project" class="el_doc_juzmatch3_asset_project">
<span<?= $Grid->asset_project->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->asset_project->getDisplayValue($Grid->asset_project->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_project" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_project" id="x<?= $Grid->RowIndex ?>_asset_project" value="<?= HtmlEncode($Grid->asset_project->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_project" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_project" id="o<?= $Grid->RowIndex ?>_asset_project" value="<?= HtmlEncode($Grid->asset_project->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->asset_deed->Visible) { // asset_deed ?>
        <td data-name="asset_deed">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_asset_deed" class="el_doc_juzmatch3_asset_deed">
<input type="<?= $Grid->asset_deed->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_deed" id="x<?= $Grid->RowIndex ?>_asset_deed" data-table="doc_juzmatch3" data-field="x_asset_deed" value="<?= $Grid->asset_deed->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->asset_deed->getPlaceHolder()) ?>"<?= $Grid->asset_deed->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_deed->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_asset_deed" class="el_doc_juzmatch3_asset_deed">
<span<?= $Grid->asset_deed->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->asset_deed->getDisplayValue($Grid->asset_deed->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_deed" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_deed" id="x<?= $Grid->RowIndex ?>_asset_deed" value="<?= HtmlEncode($Grid->asset_deed->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_deed" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_deed" id="o<?= $Grid->RowIndex ?>_asset_deed" value="<?= HtmlEncode($Grid->asset_deed->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->asset_area->Visible) { // asset_area ?>
        <td data-name="asset_area">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_asset_area" class="el_doc_juzmatch3_asset_area">
<input type="<?= $Grid->asset_area->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_area" id="x<?= $Grid->RowIndex ?>_asset_area" data-table="doc_juzmatch3" data-field="x_asset_area" value="<?= $Grid->asset_area->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->asset_area->getPlaceHolder()) ?>"<?= $Grid->asset_area->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_area->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_asset_area" class="el_doc_juzmatch3_asset_area">
<span<?= $Grid->asset_area->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->asset_area->getDisplayValue($Grid->asset_area->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_area" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_area" id="x<?= $Grid->RowIndex ?>_asset_area" value="<?= HtmlEncode($Grid->asset_area->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_asset_area" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_area" id="o<?= $Grid->RowIndex ?>_asset_area" value="<?= HtmlEncode($Grid->asset_area->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->appoint_agent_date->Visible) { // appoint_agent_date ?>
        <td data-name="appoint_agent_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_appoint_agent_date" class="el_doc_juzmatch3_appoint_agent_date">
<input type="<?= $Grid->appoint_agent_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_appoint_agent_date" id="x<?= $Grid->RowIndex ?>_appoint_agent_date" data-table="doc_juzmatch3" data-field="x_appoint_agent_date" value="<?= $Grid->appoint_agent_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->appoint_agent_date->getPlaceHolder()) ?>"<?= $Grid->appoint_agent_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->appoint_agent_date->getErrorMessage() ?></div>
<?php if (!$Grid->appoint_agent_date->ReadOnly && !$Grid->appoint_agent_date->Disabled && !isset($Grid->appoint_agent_date->EditAttrs["readonly"]) && !isset($Grid->appoint_agent_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_appoint_agent_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_appoint_agent_date" class="el_doc_juzmatch3_appoint_agent_date">
<span<?= $Grid->appoint_agent_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->appoint_agent_date->getDisplayValue($Grid->appoint_agent_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_appoint_agent_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_appoint_agent_date" id="x<?= $Grid->RowIndex ?>_appoint_agent_date" value="<?= HtmlEncode($Grid->appoint_agent_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_appoint_agent_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_appoint_agent_date" id="o<?= $Grid->RowIndex ?>_appoint_agent_date" value="<?= HtmlEncode($Grid->appoint_agent_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->buyer_lname->Visible) { // buyer_lname ?>
        <td data-name="buyer_lname">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_buyer_lname" class="el_doc_juzmatch3_buyer_lname">
<input type="<?= $Grid->buyer_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_lname" id="x<?= $Grid->RowIndex ?>_buyer_lname" data-table="doc_juzmatch3" data-field="x_buyer_lname" value="<?= $Grid->buyer_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_lname->getPlaceHolder()) ?>"<?= $Grid->buyer_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_lname->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_buyer_lname" class="el_doc_juzmatch3_buyer_lname">
<span<?= $Grid->buyer_lname->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->buyer_lname->getDisplayValue($Grid->buyer_lname->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_lname" data-hidden="1" name="x<?= $Grid->RowIndex ?>_buyer_lname" id="x<?= $Grid->RowIndex ?>_buyer_lname" value="<?= HtmlEncode($Grid->buyer_lname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_lname" data-hidden="1" name="o<?= $Grid->RowIndex ?>_buyer_lname" id="o<?= $Grid->RowIndex ?>_buyer_lname" value="<?= HtmlEncode($Grid->buyer_lname->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->buyer_email->Visible) { // buyer_email ?>
        <td data-name="buyer_email">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_buyer_email" class="el_doc_juzmatch3_buyer_email">
<input type="<?= $Grid->buyer_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_email" id="x<?= $Grid->RowIndex ?>_buyer_email" data-table="doc_juzmatch3" data-field="x_buyer_email" value="<?= $Grid->buyer_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_email->getPlaceHolder()) ?>"<?= $Grid->buyer_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_buyer_email" class="el_doc_juzmatch3_buyer_email">
<span<?= $Grid->buyer_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->buyer_email->getDisplayValue($Grid->buyer_email->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_email" data-hidden="1" name="x<?= $Grid->RowIndex ?>_buyer_email" id="x<?= $Grid->RowIndex ?>_buyer_email" value="<?= HtmlEncode($Grid->buyer_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_buyer_email" id="o<?= $Grid->RowIndex ?>_buyer_email" value="<?= HtmlEncode($Grid->buyer_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->buyer_idcard->Visible) { // buyer_idcard ?>
        <td data-name="buyer_idcard">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_buyer_idcard" class="el_doc_juzmatch3_buyer_idcard">
<input type="<?= $Grid->buyer_idcard->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_idcard" id="x<?= $Grid->RowIndex ?>_buyer_idcard" data-table="doc_juzmatch3" data-field="x_buyer_idcard" value="<?= $Grid->buyer_idcard->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_idcard->getPlaceHolder()) ?>"<?= $Grid->buyer_idcard->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_idcard->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_buyer_idcard" class="el_doc_juzmatch3_buyer_idcard">
<span<?= $Grid->buyer_idcard->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->buyer_idcard->getDisplayValue($Grid->buyer_idcard->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_idcard" data-hidden="1" name="x<?= $Grid->RowIndex ?>_buyer_idcard" id="x<?= $Grid->RowIndex ?>_buyer_idcard" value="<?= HtmlEncode($Grid->buyer_idcard->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_idcard" data-hidden="1" name="o<?= $Grid->RowIndex ?>_buyer_idcard" id="o<?= $Grid->RowIndex ?>_buyer_idcard" value="<?= HtmlEncode($Grid->buyer_idcard->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->buyer_homeno->Visible) { // buyer_homeno ?>
        <td data-name="buyer_homeno">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_buyer_homeno" class="el_doc_juzmatch3_buyer_homeno">
<input type="<?= $Grid->buyer_homeno->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_homeno" id="x<?= $Grid->RowIndex ?>_buyer_homeno" data-table="doc_juzmatch3" data-field="x_buyer_homeno" value="<?= $Grid->buyer_homeno->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_homeno->getPlaceHolder()) ?>"<?= $Grid->buyer_homeno->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_homeno->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_buyer_homeno" class="el_doc_juzmatch3_buyer_homeno">
<span<?= $Grid->buyer_homeno->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->buyer_homeno->getDisplayValue($Grid->buyer_homeno->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_homeno" data-hidden="1" name="x<?= $Grid->RowIndex ?>_buyer_homeno" id="x<?= $Grid->RowIndex ?>_buyer_homeno" value="<?= HtmlEncode($Grid->buyer_homeno->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_homeno" data-hidden="1" name="o<?= $Grid->RowIndex ?>_buyer_homeno" id="o<?= $Grid->RowIndex ?>_buyer_homeno" value="<?= HtmlEncode($Grid->buyer_homeno->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->buyer_witness_lname->Visible) { // buyer_witness_lname ?>
        <td data-name="buyer_witness_lname">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_buyer_witness_lname" class="el_doc_juzmatch3_buyer_witness_lname">
<input type="<?= $Grid->buyer_witness_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_witness_lname" id="x<?= $Grid->RowIndex ?>_buyer_witness_lname" data-table="doc_juzmatch3" data-field="x_buyer_witness_lname" value="<?= $Grid->buyer_witness_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_witness_lname->getPlaceHolder()) ?>"<?= $Grid->buyer_witness_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_witness_lname->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_buyer_witness_lname" class="el_doc_juzmatch3_buyer_witness_lname">
<span<?= $Grid->buyer_witness_lname->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->buyer_witness_lname->getDisplayValue($Grid->buyer_witness_lname->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_witness_lname" data-hidden="1" name="x<?= $Grid->RowIndex ?>_buyer_witness_lname" id="x<?= $Grid->RowIndex ?>_buyer_witness_lname" value="<?= HtmlEncode($Grid->buyer_witness_lname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_witness_lname" data-hidden="1" name="o<?= $Grid->RowIndex ?>_buyer_witness_lname" id="o<?= $Grid->RowIndex ?>_buyer_witness_lname" value="<?= HtmlEncode($Grid->buyer_witness_lname->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->buyer_witness_email->Visible) { // buyer_witness_email ?>
        <td data-name="buyer_witness_email">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_buyer_witness_email" class="el_doc_juzmatch3_buyer_witness_email">
<input type="<?= $Grid->buyer_witness_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_buyer_witness_email" id="x<?= $Grid->RowIndex ?>_buyer_witness_email" data-table="doc_juzmatch3" data-field="x_buyer_witness_email" value="<?= $Grid->buyer_witness_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->buyer_witness_email->getPlaceHolder()) ?>"<?= $Grid->buyer_witness_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->buyer_witness_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_buyer_witness_email" class="el_doc_juzmatch3_buyer_witness_email">
<span<?= $Grid->buyer_witness_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->buyer_witness_email->getDisplayValue($Grid->buyer_witness_email->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_witness_email" data-hidden="1" name="x<?= $Grid->RowIndex ?>_buyer_witness_email" id="x<?= $Grid->RowIndex ?>_buyer_witness_email" value="<?= HtmlEncode($Grid->buyer_witness_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_buyer_witness_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_buyer_witness_email" id="o<?= $Grid->RowIndex ?>_buyer_witness_email" value="<?= HtmlEncode($Grid->buyer_witness_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->investor_lname->Visible) { // investor_lname ?>
        <td data-name="investor_lname">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_investor_lname" class="el_doc_juzmatch3_investor_lname">
<input type="<?= $Grid->investor_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_investor_lname" id="x<?= $Grid->RowIndex ?>_investor_lname" data-table="doc_juzmatch3" data-field="x_investor_lname" value="<?= $Grid->investor_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->investor_lname->getPlaceHolder()) ?>"<?= $Grid->investor_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->investor_lname->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_investor_lname" class="el_doc_juzmatch3_investor_lname">
<span<?= $Grid->investor_lname->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->investor_lname->getDisplayValue($Grid->investor_lname->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_investor_lname" data-hidden="1" name="x<?= $Grid->RowIndex ?>_investor_lname" id="x<?= $Grid->RowIndex ?>_investor_lname" value="<?= HtmlEncode($Grid->investor_lname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_investor_lname" data-hidden="1" name="o<?= $Grid->RowIndex ?>_investor_lname" id="o<?= $Grid->RowIndex ?>_investor_lname" value="<?= HtmlEncode($Grid->investor_lname->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->investor_email->Visible) { // investor_email ?>
        <td data-name="investor_email">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_investor_email" class="el_doc_juzmatch3_investor_email">
<input type="<?= $Grid->investor_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_investor_email" id="x<?= $Grid->RowIndex ?>_investor_email" data-table="doc_juzmatch3" data-field="x_investor_email" value="<?= $Grid->investor_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->investor_email->getPlaceHolder()) ?>"<?= $Grid->investor_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->investor_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_investor_email" class="el_doc_juzmatch3_investor_email">
<span<?= $Grid->investor_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->investor_email->getDisplayValue($Grid->investor_email->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_investor_email" data-hidden="1" name="x<?= $Grid->RowIndex ?>_investor_email" id="x<?= $Grid->RowIndex ?>_investor_email" value="<?= HtmlEncode($Grid->investor_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_investor_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_investor_email" id="o<?= $Grid->RowIndex ?>_investor_email" value="<?= HtmlEncode($Grid->investor_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
        <td data-name="juzmatch_authority_lname">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_juzmatch_authority_lname" class="el_doc_juzmatch3_juzmatch_authority_lname">
<input type="<?= $Grid->juzmatch_authority_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_lname" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_lname" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_lname" value="<?= $Grid->juzmatch_authority_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority_lname->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority_lname->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_juzmatch_authority_lname" class="el_doc_juzmatch3_juzmatch_authority_lname">
<span<?= $Grid->juzmatch_authority_lname->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->juzmatch_authority_lname->getDisplayValue($Grid->juzmatch_authority_lname->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_lname" data-hidden="1" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_lname" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_lname" value="<?= HtmlEncode($Grid->juzmatch_authority_lname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_lname" data-hidden="1" name="o<?= $Grid->RowIndex ?>_juzmatch_authority_lname" id="o<?= $Grid->RowIndex ?>_juzmatch_authority_lname" value="<?= HtmlEncode($Grid->juzmatch_authority_lname->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
        <td data-name="juzmatch_authority_email">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_juzmatch_authority_email" class="el_doc_juzmatch3_juzmatch_authority_email">
<input type="<?= $Grid->juzmatch_authority_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_email" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_email" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_email" value="<?= $Grid->juzmatch_authority_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority_email->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_juzmatch_authority_email" class="el_doc_juzmatch3_juzmatch_authority_email">
<span<?= $Grid->juzmatch_authority_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->juzmatch_authority_email->getDisplayValue($Grid->juzmatch_authority_email->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_email" data-hidden="1" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_email" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_email" value="<?= HtmlEncode($Grid->juzmatch_authority_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_juzmatch_authority_email" id="o<?= $Grid->RowIndex ?>_juzmatch_authority_email" value="<?= HtmlEncode($Grid->juzmatch_authority_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
        <td data-name="juzmatch_authority_witness_lname">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_juzmatch_authority_witness_lname" class="el_doc_juzmatch3_juzmatch_authority_witness_lname">
<input type="<?= $Grid->juzmatch_authority_witness_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_lname" value="<?= $Grid->juzmatch_authority_witness_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority_witness_lname->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority_witness_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority_witness_lname->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_juzmatch_authority_witness_lname" class="el_doc_juzmatch3_juzmatch_authority_witness_lname">
<span<?= $Grid->juzmatch_authority_witness_lname->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->juzmatch_authority_witness_lname->getDisplayValue($Grid->juzmatch_authority_witness_lname->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_lname" data-hidden="1" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" value="<?= HtmlEncode($Grid->juzmatch_authority_witness_lname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_lname" data-hidden="1" name="o<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" id="o<?= $Grid->RowIndex ?>_juzmatch_authority_witness_lname" value="<?= HtmlEncode($Grid->juzmatch_authority_witness_lname->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
        <td data-name="juzmatch_authority_witness_email">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_juzmatch_authority_witness_email" class="el_doc_juzmatch3_juzmatch_authority_witness_email">
<input type="<?= $Grid->juzmatch_authority_witness_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_email" value="<?= $Grid->juzmatch_authority_witness_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority_witness_email->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority_witness_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority_witness_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_juzmatch_authority_witness_email" class="el_doc_juzmatch3_juzmatch_authority_witness_email">
<span<?= $Grid->juzmatch_authority_witness_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->juzmatch_authority_witness_email->getDisplayValue($Grid->juzmatch_authority_witness_email->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_email" data-hidden="1" name="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" id="x<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" value="<?= HtmlEncode($Grid->juzmatch_authority_witness_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" id="o<?= $Grid->RowIndex ?>_juzmatch_authority_witness_email" value="<?= HtmlEncode($Grid->juzmatch_authority_witness_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
        <td data-name="juzmatch_authority2_name">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_juzmatch_authority2_name" class="el_doc_juzmatch3_juzmatch_authority2_name">
<input type="<?= $Grid->juzmatch_authority2_name->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority2_name" id="x<?= $Grid->RowIndex ?>_juzmatch_authority2_name" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_name" value="<?= $Grid->juzmatch_authority2_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Grid->juzmatch_authority2_name->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority2_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority2_name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_juzmatch_authority2_name" class="el_doc_juzmatch3_juzmatch_authority2_name">
<span<?= $Grid->juzmatch_authority2_name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->juzmatch_authority2_name->getDisplayValue($Grid->juzmatch_authority2_name->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_name" data-hidden="1" name="x<?= $Grid->RowIndex ?>_juzmatch_authority2_name" id="x<?= $Grid->RowIndex ?>_juzmatch_authority2_name" value="<?= HtmlEncode($Grid->juzmatch_authority2_name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_juzmatch_authority2_name" id="o<?= $Grid->RowIndex ?>_juzmatch_authority2_name" value="<?= HtmlEncode($Grid->juzmatch_authority2_name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
        <td data-name="juzmatch_authority2_lname">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_juzmatch_authority2_lname" class="el_doc_juzmatch3_juzmatch_authority2_lname">
<input type="<?= $Grid->juzmatch_authority2_lname->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" id="x<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_lname" value="<?= $Grid->juzmatch_authority2_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority2_lname->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority2_lname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority2_lname->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_juzmatch_authority2_lname" class="el_doc_juzmatch3_juzmatch_authority2_lname">
<span<?= $Grid->juzmatch_authority2_lname->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->juzmatch_authority2_lname->getDisplayValue($Grid->juzmatch_authority2_lname->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_lname" data-hidden="1" name="x<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" id="x<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" value="<?= HtmlEncode($Grid->juzmatch_authority2_lname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_lname" data-hidden="1" name="o<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" id="o<?= $Grid->RowIndex ?>_juzmatch_authority2_lname" value="<?= HtmlEncode($Grid->juzmatch_authority2_lname->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
        <td data-name="juzmatch_authority2_email">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_juzmatch_authority2_email" class="el_doc_juzmatch3_juzmatch_authority2_email">
<input type="<?= $Grid->juzmatch_authority2_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_juzmatch_authority2_email" id="x<?= $Grid->RowIndex ?>_juzmatch_authority2_email" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_email" value="<?= $Grid->juzmatch_authority2_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->juzmatch_authority2_email->getPlaceHolder()) ?>"<?= $Grid->juzmatch_authority2_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->juzmatch_authority2_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_juzmatch_authority2_email" class="el_doc_juzmatch3_juzmatch_authority2_email">
<span<?= $Grid->juzmatch_authority2_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->juzmatch_authority2_email->getDisplayValue($Grid->juzmatch_authority2_email->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_email" data-hidden="1" name="x<?= $Grid->RowIndex ?>_juzmatch_authority2_email" id="x<?= $Grid->RowIndex ?>_juzmatch_authority2_email" value="<?= HtmlEncode($Grid->juzmatch_authority2_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_juzmatch_authority2_email" id="o<?= $Grid->RowIndex ?>_juzmatch_authority2_email" value="<?= HtmlEncode($Grid->juzmatch_authority2_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->company_seal_name->Visible) { // company_seal_name ?>
        <td data-name="company_seal_name">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_company_seal_name" class="el_doc_juzmatch3_company_seal_name">
<input type="<?= $Grid->company_seal_name->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_company_seal_name" id="x<?= $Grid->RowIndex ?>_company_seal_name" data-table="doc_juzmatch3" data-field="x_company_seal_name" value="<?= $Grid->company_seal_name->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->company_seal_name->getPlaceHolder()) ?>"<?= $Grid->company_seal_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->company_seal_name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_company_seal_name" class="el_doc_juzmatch3_company_seal_name">
<span<?= $Grid->company_seal_name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->company_seal_name->getDisplayValue($Grid->company_seal_name->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_company_seal_name" data-hidden="1" name="x<?= $Grid->RowIndex ?>_company_seal_name" id="x<?= $Grid->RowIndex ?>_company_seal_name" value="<?= HtmlEncode($Grid->company_seal_name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_company_seal_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_company_seal_name" id="o<?= $Grid->RowIndex ?>_company_seal_name" value="<?= HtmlEncode($Grid->company_seal_name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->company_seal_email->Visible) { // company_seal_email ?>
        <td data-name="company_seal_email">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_company_seal_email" class="el_doc_juzmatch3_company_seal_email">
<input type="<?= $Grid->company_seal_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_company_seal_email" id="x<?= $Grid->RowIndex ?>_company_seal_email" data-table="doc_juzmatch3" data-field="x_company_seal_email" value="<?= $Grid->company_seal_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->company_seal_email->getPlaceHolder()) ?>"<?= $Grid->company_seal_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->company_seal_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_company_seal_email" class="el_doc_juzmatch3_company_seal_email">
<span<?= $Grid->company_seal_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->company_seal_email->getDisplayValue($Grid->company_seal_email->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_company_seal_email" data-hidden="1" name="x<?= $Grid->RowIndex ?>_company_seal_email" id="x<?= $Grid->RowIndex ?>_company_seal_email" value="<?= HtmlEncode($Grid->company_seal_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_company_seal_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_company_seal_email" id="o<?= $Grid->RowIndex ?>_company_seal_email" value="<?= HtmlEncode($Grid->company_seal_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->total->Visible) { // total ?>
        <td data-name="total">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_total" class="el_doc_juzmatch3_total">
<input type="<?= $Grid->total->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_total" id="x<?= $Grid->RowIndex ?>_total" data-table="doc_juzmatch3" data-field="x_total" value="<?= $Grid->total->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Grid->total->getPlaceHolder()) ?>"<?= $Grid->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_total" class="el_doc_juzmatch3_total">
<span<?= $Grid->total->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->total->getDisplayValue($Grid->total->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_total" data-hidden="1" name="x<?= $Grid->RowIndex ?>_total" id="x<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_total" data-hidden="1" name="o<?= $Grid->RowIndex ?>_total" id="o<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->total_txt->Visible) { // total_txt ?>
        <td data-name="total_txt">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_total_txt" class="el_doc_juzmatch3_total_txt">
<input type="<?= $Grid->total_txt->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_total_txt" id="x<?= $Grid->RowIndex ?>_total_txt" data-table="doc_juzmatch3" data-field="x_total_txt" value="<?= $Grid->total_txt->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Grid->total_txt->getPlaceHolder()) ?>"<?= $Grid->total_txt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total_txt->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_total_txt" class="el_doc_juzmatch3_total_txt">
<span<?= $Grid->total_txt->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->total_txt->getDisplayValue($Grid->total_txt->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_total_txt" data-hidden="1" name="x<?= $Grid->RowIndex ?>_total_txt" id="x<?= $Grid->RowIndex ?>_total_txt" value="<?= HtmlEncode($Grid->total_txt->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_total_txt" data-hidden="1" name="o<?= $Grid->RowIndex ?>_total_txt" id="o<?= $Grid->RowIndex ?>_total_txt" value="<?= HtmlEncode($Grid->total_txt->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->next_pay_date->Visible) { // next_pay_date ?>
        <td data-name="next_pay_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_next_pay_date" class="el_doc_juzmatch3_next_pay_date">
<input type="<?= $Grid->next_pay_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_next_pay_date" id="x<?= $Grid->RowIndex ?>_next_pay_date" data-table="doc_juzmatch3" data-field="x_next_pay_date" value="<?= $Grid->next_pay_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->next_pay_date->getPlaceHolder()) ?>"<?= $Grid->next_pay_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->next_pay_date->getErrorMessage() ?></div>
<?php if (!$Grid->next_pay_date->ReadOnly && !$Grid->next_pay_date->Disabled && !isset($Grid->next_pay_date->EditAttrs["readonly"]) && !isset($Grid->next_pay_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_next_pay_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_next_pay_date" class="el_doc_juzmatch3_next_pay_date">
<span<?= $Grid->next_pay_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->next_pay_date->getDisplayValue($Grid->next_pay_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_next_pay_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_next_pay_date" id="x<?= $Grid->RowIndex ?>_next_pay_date" value="<?= HtmlEncode($Grid->next_pay_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_next_pay_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_next_pay_date" id="o<?= $Grid->RowIndex ?>_next_pay_date" value="<?= HtmlEncode($Grid->next_pay_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->next_pay_date_txt->Visible) { // next_pay_date_txt ?>
        <td data-name="next_pay_date_txt">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_next_pay_date_txt" class="el_doc_juzmatch3_next_pay_date_txt">
<input type="<?= $Grid->next_pay_date_txt->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_next_pay_date_txt" id="x<?= $Grid->RowIndex ?>_next_pay_date_txt" data-table="doc_juzmatch3" data-field="x_next_pay_date_txt" value="<?= $Grid->next_pay_date_txt->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->next_pay_date_txt->getPlaceHolder()) ?>"<?= $Grid->next_pay_date_txt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->next_pay_date_txt->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_next_pay_date_txt" class="el_doc_juzmatch3_next_pay_date_txt">
<span<?= $Grid->next_pay_date_txt->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->next_pay_date_txt->getDisplayValue($Grid->next_pay_date_txt->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_next_pay_date_txt" data-hidden="1" name="x<?= $Grid->RowIndex ?>_next_pay_date_txt" id="x<?= $Grid->RowIndex ?>_next_pay_date_txt" value="<?= HtmlEncode($Grid->next_pay_date_txt->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_next_pay_date_txt" data-hidden="1" name="o<?= $Grid->RowIndex ?>_next_pay_date_txt" id="o<?= $Grid->RowIndex ?>_next_pay_date_txt" value="<?= HtmlEncode($Grid->next_pay_date_txt->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->service_price->Visible) { // service_price ?>
        <td data-name="service_price">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_service_price" class="el_doc_juzmatch3_service_price">
<input type="<?= $Grid->service_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_service_price" id="x<?= $Grid->RowIndex ?>_service_price" data-table="doc_juzmatch3" data-field="x_service_price" value="<?= $Grid->service_price->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Grid->service_price->getPlaceHolder()) ?>"<?= $Grid->service_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->service_price->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_service_price" class="el_doc_juzmatch3_service_price">
<span<?= $Grid->service_price->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->service_price->getDisplayValue($Grid->service_price->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_service_price" data-hidden="1" name="x<?= $Grid->RowIndex ?>_service_price" id="x<?= $Grid->RowIndex ?>_service_price" value="<?= HtmlEncode($Grid->service_price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_service_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_service_price" id="o<?= $Grid->RowIndex ?>_service_price" value="<?= HtmlEncode($Grid->service_price->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->service_price_txt->Visible) { // service_price_txt ?>
        <td data-name="service_price_txt">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_service_price_txt" class="el_doc_juzmatch3_service_price_txt">
<input type="<?= $Grid->service_price_txt->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_service_price_txt" id="x<?= $Grid->RowIndex ?>_service_price_txt" data-table="doc_juzmatch3" data-field="x_service_price_txt" value="<?= $Grid->service_price_txt->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->service_price_txt->getPlaceHolder()) ?>"<?= $Grid->service_price_txt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->service_price_txt->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_service_price_txt" class="el_doc_juzmatch3_service_price_txt">
<span<?= $Grid->service_price_txt->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->service_price_txt->getDisplayValue($Grid->service_price_txt->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_service_price_txt" data-hidden="1" name="x<?= $Grid->RowIndex ?>_service_price_txt" id="x<?= $Grid->RowIndex ?>_service_price_txt" value="<?= HtmlEncode($Grid->service_price_txt->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_service_price_txt" data-hidden="1" name="o<?= $Grid->RowIndex ?>_service_price_txt" id="o<?= $Grid->RowIndex ?>_service_price_txt" value="<?= HtmlEncode($Grid->service_price_txt->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->provide_service_date->Visible) { // provide_service_date ?>
        <td data-name="provide_service_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_provide_service_date" class="el_doc_juzmatch3_provide_service_date">
<input type="<?= $Grid->provide_service_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_provide_service_date" id="x<?= $Grid->RowIndex ?>_provide_service_date" data-table="doc_juzmatch3" data-field="x_provide_service_date" value="<?= $Grid->provide_service_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->provide_service_date->getPlaceHolder()) ?>"<?= $Grid->provide_service_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->provide_service_date->getErrorMessage() ?></div>
<?php if (!$Grid->provide_service_date->ReadOnly && !$Grid->provide_service_date->Disabled && !isset($Grid->provide_service_date->EditAttrs["readonly"]) && !isset($Grid->provide_service_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3grid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fdoc_juzmatch3grid", "x<?= $Grid->RowIndex ?>_provide_service_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_provide_service_date" class="el_doc_juzmatch3_provide_service_date">
<span<?= $Grid->provide_service_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->provide_service_date->getDisplayValue($Grid->provide_service_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_provide_service_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_provide_service_date" id="x<?= $Grid->RowIndex ?>_provide_service_date" value="<?= HtmlEncode($Grid->provide_service_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_provide_service_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_provide_service_date" id="o<?= $Grid->RowIndex ?>_provide_service_date" value="<?= HtmlEncode($Grid->provide_service_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->contact_address->Visible) { // contact_address ?>
        <td data-name="contact_address">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_contact_address" class="el_doc_juzmatch3_contact_address">
<input type="<?= $Grid->contact_address->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_address" id="x<?= $Grid->RowIndex ?>_contact_address" data-table="doc_juzmatch3" data-field="x_contact_address" value="<?= $Grid->contact_address->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_address->getPlaceHolder()) ?>"<?= $Grid->contact_address->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_address->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_contact_address" class="el_doc_juzmatch3_contact_address">
<span<?= $Grid->contact_address->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->contact_address->getDisplayValue($Grid->contact_address->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_address" data-hidden="1" name="x<?= $Grid->RowIndex ?>_contact_address" id="x<?= $Grid->RowIndex ?>_contact_address" value="<?= HtmlEncode($Grid->contact_address->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_address" data-hidden="1" name="o<?= $Grid->RowIndex ?>_contact_address" id="o<?= $Grid->RowIndex ?>_contact_address" value="<?= HtmlEncode($Grid->contact_address->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->contact_address2->Visible) { // contact_address2 ?>
        <td data-name="contact_address2">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_contact_address2" class="el_doc_juzmatch3_contact_address2">
<input type="<?= $Grid->contact_address2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_address2" id="x<?= $Grid->RowIndex ?>_contact_address2" data-table="doc_juzmatch3" data-field="x_contact_address2" value="<?= $Grid->contact_address2->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_address2->getPlaceHolder()) ?>"<?= $Grid->contact_address2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_address2->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_contact_address2" class="el_doc_juzmatch3_contact_address2">
<span<?= $Grid->contact_address2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->contact_address2->getDisplayValue($Grid->contact_address2->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_address2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_contact_address2" id="x<?= $Grid->RowIndex ?>_contact_address2" value="<?= HtmlEncode($Grid->contact_address2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_address2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_contact_address2" id="o<?= $Grid->RowIndex ?>_contact_address2" value="<?= HtmlEncode($Grid->contact_address2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->contact_email->Visible) { // contact_email ?>
        <td data-name="contact_email">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_contact_email" class="el_doc_juzmatch3_contact_email">
<input type="<?= $Grid->contact_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_email" id="x<?= $Grid->RowIndex ?>_contact_email" data-table="doc_juzmatch3" data-field="x_contact_email" value="<?= $Grid->contact_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_email->getPlaceHolder()) ?>"<?= $Grid->contact_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_contact_email" class="el_doc_juzmatch3_contact_email">
<span<?= $Grid->contact_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->contact_email->getDisplayValue($Grid->contact_email->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_email" data-hidden="1" name="x<?= $Grid->RowIndex ?>_contact_email" id="x<?= $Grid->RowIndex ?>_contact_email" value="<?= HtmlEncode($Grid->contact_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_contact_email" id="o<?= $Grid->RowIndex ?>_contact_email" value="<?= HtmlEncode($Grid->contact_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->contact_lineid->Visible) { // contact_lineid ?>
        <td data-name="contact_lineid">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_contact_lineid" class="el_doc_juzmatch3_contact_lineid">
<input type="<?= $Grid->contact_lineid->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_lineid" id="x<?= $Grid->RowIndex ?>_contact_lineid" data-table="doc_juzmatch3" data-field="x_contact_lineid" value="<?= $Grid->contact_lineid->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_lineid->getPlaceHolder()) ?>"<?= $Grid->contact_lineid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_lineid->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_contact_lineid" class="el_doc_juzmatch3_contact_lineid">
<span<?= $Grid->contact_lineid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->contact_lineid->getDisplayValue($Grid->contact_lineid->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_lineid" data-hidden="1" name="x<?= $Grid->RowIndex ?>_contact_lineid" id="x<?= $Grid->RowIndex ?>_contact_lineid" value="<?= HtmlEncode($Grid->contact_lineid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_lineid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_contact_lineid" id="o<?= $Grid->RowIndex ?>_contact_lineid" value="<?= HtmlEncode($Grid->contact_lineid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->contact_phone->Visible) { // contact_phone ?>
        <td data-name="contact_phone">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_contact_phone" class="el_doc_juzmatch3_contact_phone">
<input type="<?= $Grid->contact_phone->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contact_phone" id="x<?= $Grid->RowIndex ?>_contact_phone" data-table="doc_juzmatch3" data-field="x_contact_phone" value="<?= $Grid->contact_phone->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->contact_phone->getPlaceHolder()) ?>"<?= $Grid->contact_phone->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contact_phone->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_contact_phone" class="el_doc_juzmatch3_contact_phone">
<span<?= $Grid->contact_phone->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->contact_phone->getDisplayValue($Grid->contact_phone->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_phone" data-hidden="1" name="x<?= $Grid->RowIndex ?>_contact_phone" id="x<?= $Grid->RowIndex ?>_contact_phone" value="<?= HtmlEncode($Grid->contact_phone->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_contact_phone" data-hidden="1" name="o<?= $Grid->RowIndex ?>_contact_phone" id="o<?= $Grid->RowIndex ?>_contact_phone" value="<?= HtmlEncode($Grid->contact_phone->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->attach_file->Visible) { // attach_file ?>
        <td data-name="attach_file">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_attach_file" class="el_doc_juzmatch3_attach_file">
<input type="<?= $Grid->attach_file->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_attach_file" id="x<?= $Grid->RowIndex ?>_attach_file" data-table="doc_juzmatch3" data-field="x_attach_file" value="<?= $Grid->attach_file->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Grid->attach_file->getPlaceHolder()) ?>"<?= $Grid->attach_file->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->attach_file->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_attach_file" class="el_doc_juzmatch3_attach_file">
<span<?= $Grid->attach_file->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->attach_file->getDisplayValue($Grid->attach_file->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_attach_file" data-hidden="1" name="x<?= $Grid->RowIndex ?>_attach_file" id="x<?= $Grid->RowIndex ?>_attach_file" value="<?= HtmlEncode($Grid->attach_file->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_attach_file" data-hidden="1" name="o<?= $Grid->RowIndex ?>_attach_file" id="o<?= $Grid->RowIndex ?>_attach_file" value="<?= HtmlEncode($Grid->attach_file->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_doc_juzmatch3_status" class="el_doc_juzmatch3_status">
    <select
        id="x<?= $Grid->RowIndex ?>_status"
        name="x<?= $Grid->RowIndex ?>_status"
        class="form-select ew-select<?= $Grid->status->isInvalidClass() ?>"
        data-select2-id="fdoc_juzmatch3grid_x<?= $Grid->RowIndex ?>_status"
        data-table="doc_juzmatch3"
        data-field="x_status"
        data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>"
        <?= $Grid->status->editAttributes() ?>>
        <?= $Grid->status->selectOptionListHtml("x{$Grid->RowIndex}_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
<script>
loadjs.ready("fdoc_juzmatch3grid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status", selectId: "fdoc_juzmatch3grid_x<?= $Grid->RowIndex ?>_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdoc_juzmatch3grid.lists.status.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status", form: "fdoc_juzmatch3grid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status", form: "fdoc_juzmatch3grid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.doc_juzmatch3.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_status" class="el_doc_juzmatch3_status">
<span<?= $Grid->status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status->getDisplayValue($Grid->status->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_doc_juzmatch3_cdate" class="el_doc_juzmatch3_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="doc_juzmatch3" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fdoc_juzmatch3grid","load"], () => fdoc_juzmatch3grid.updateLists(<?= $Grid->RowIndex ?>, true));
</script>
    </tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdoc_juzmatch3grid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("doc_juzmatch3");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
