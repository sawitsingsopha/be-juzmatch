<?php

namespace PHPMaker2022\juzmatch;

// Page object
$NumberOfUnpaidUnitsList = &$Page;
?>

<?php 

// SELECT COUNT(*) FROM ( SELECT buyer_config_asset_schedule.`buyer_config_asset_schedule_id` FROM `buyer_config_asset_schedule` LEFT JOIN buyer_asset_schedule ON buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id LEFT JOIN asset ON asset.asset_id = buyer_config_asset_schedule.asset_id GROUP BY buyer_config_asset_schedule.`buyer_config_asset_schedule_id` ) as count_1
// SELECT COUNT(*) FROM ( SELECT buyer_config_asset_schedule.`buyer_config_asset_schedule_id` FROM `buyer_config_asset_schedule` LEFT JOIN buyer_asset_schedule ON buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id LEFT JOIN asset ON asset.asset_id = buyer_config_asset_schedule.asset_id WHERE DATEDIFF(NOW(),( SELECT MIN(buyer_asset_schedule.expired_date) AS accrued_period FROM buyer_asset_schedule WHERE buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id AND buyer_asset_schedule.status_payment IN(1,3) GROUP BY buyer_config_asset_schedule.buyer_config_asset_schedule_id )) > 0 GROUP BY buyer_config_asset_schedule.member_id ORDER BY buyer_config_asset_schedule.cdate DESC ) as count_2
// SELECT COUNT(*) FROM ( SELECT buyer_config_asset_schedule.`buyer_config_asset_schedule_id` FROM `buyer_config_asset_schedule` LEFT JOIN buyer_asset_schedule ON buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id LEFT JOIN asset ON asset.asset_id = buyer_config_asset_schedule.asset_id WHERE DATEDIFF(NOW(),( SELECT MIN(buyer_asset_schedule.expired_date) AS accrued_period FROM buyer_asset_schedule WHERE buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id AND buyer_asset_schedule.status_payment IN(1,3) GROUP BY buyer_config_asset_schedule.buyer_config_asset_schedule_id )) > 0 GROUP BY buyer_config_asset_schedule.buyer_config_asset_schedule_id ORDER BY buyer_config_asset_schedule.cdate DESC ) as count_3
// select sum(count_4) count_4 from (SELECT (SELECT SUM(buyer_asset_schedule.installment_per_price) FROM buyer_asset_schedule WHERE buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id AND buyer_asset_schedule.status_payment IN(1,3) AND buyer_asset_schedule.expired_date < NOW()) as count_4 FROM `buyer_config_asset_schedule` LEFT JOIN buyer_asset_schedule ON buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id LEFT JOIN asset ON asset.asset_id = buyer_config_asset_schedule.asset_id WHERE DATEDIFF(NOW(),( SELECT MIN(buyer_asset_schedule.expired_date) AS accrued_period FROM buyer_asset_schedule WHERE buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id AND buyer_asset_schedule.status_payment IN(1,3) GROUP BY buyer_config_asset_schedule.buyer_config_asset_schedule_id)) > 0 GROUP BY buyer_config_asset_schedule.buyer_config_asset_schedule_id) tem

$count_1 = 0;
$count_2 = 0;
$count_3 = 0;
$count_4 = 0;

$sql_count_1 = "SELECT COUNT(*) as count_1 FROM ( SELECT buyer_config_asset_schedule.`buyer_config_asset_schedule_id` FROM `buyer_config_asset_schedule` LEFT JOIN buyer_asset_schedule ON buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id LEFT JOIN asset ON asset.asset_id = buyer_config_asset_schedule.asset_id WHERE asset.is_cancel_contract != 1 AND asset.asset_id is not null GROUP BY buyer_config_asset_schedule.`buyer_config_asset_schedule_id` ) as count_1";
$res_count_1 = ExecuteRow($sql_count_1);
$count_1 = $res_count_1['count_1'];

$sql_count_2 = "SELECT COUNT(*) as count_2 FROM ( SELECT buyer_config_asset_schedule.`buyer_config_asset_schedule_id` FROM `buyer_config_asset_schedule` LEFT JOIN buyer_asset_schedule ON buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id LEFT JOIN asset ON asset.asset_id = buyer_config_asset_schedule.asset_id WHERE DATEDIFF(NOW(),( SELECT MIN(buyer_asset_schedule.expired_date) AS accrued_period FROM buyer_asset_schedule WHERE buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id AND buyer_asset_schedule.status_payment IN(1,3) AND asset.is_cancel_contract != 1 AND asset.asset_id is not null GROUP BY buyer_config_asset_schedule.buyer_config_asset_schedule_id )) > 0 GROUP BY buyer_config_asset_schedule.member_id ORDER BY buyer_config_asset_schedule.cdate DESC ) as count_2";
$res_count_2 = ExecuteRow($sql_count_2);
$count_2 = $res_count_2['count_2'];

// $sql_count_3 = "SELECT COUNT(*) as count_3 FROM ( SELECT buyer_config_asset_schedule.`buyer_config_asset_schedule_id` FROM `buyer_config_asset_schedule` LEFT JOIN buyer_asset_schedule ON buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id LEFT JOIN asset ON asset.asset_id = buyer_config_asset_schedule.asset_id WHERE DATEDIFF(NOW(),( SELECT MIN(buyer_asset_schedule.expired_date) AS accrued_period FROM buyer_asset_schedule WHERE buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id AND buyer_asset_schedule.status_payment IN(1,3) GROUP BY buyer_config_asset_schedule.buyer_config_asset_schedule_id )) > 0 GROUP BY buyer_config_asset_schedule.buyer_config_asset_schedule_id ORDER BY buyer_config_asset_schedule.cdate DESC ) as count_3";
$sql_count_3 = "select sum(count_3) count_3 from (SELECT (SELECT COUNT(*) FROM buyer_asset_schedule WHERE buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id AND buyer_asset_schedule.status_payment IN(1,3) AND buyer_asset_schedule.expired_date < NOW()) as count_3 FROM `buyer_config_asset_schedule` LEFT JOIN buyer_asset_schedule ON buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id LEFT JOIN asset ON asset.asset_id = buyer_config_asset_schedule.asset_id WHERE DATEDIFF(NOW(),( SELECT MIN(buyer_asset_schedule.expired_date) AS accrued_period FROM buyer_asset_schedule WHERE buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id AND buyer_asset_schedule.status_payment IN(1,3) AND asset.is_cancel_contract != 1 AND asset.asset_id is not null GROUP BY buyer_config_asset_schedule.buyer_config_asset_schedule_id)) > 0 GROUP BY buyer_config_asset_schedule.buyer_config_asset_schedule_id) tem";
$res_count_3 = ExecuteRow($sql_count_3);
$count_3 = $res_count_3['count_3'];

$sql_count_4 = "select sum(count_4) count_4 from (SELECT (SELECT SUM(buyer_asset_schedule.installment_per_price) FROM buyer_asset_schedule WHERE buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id AND buyer_asset_schedule.status_payment IN(1,3) AND buyer_asset_schedule.expired_date < NOW()) as count_4 FROM `buyer_config_asset_schedule` LEFT JOIN buyer_asset_schedule ON buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id LEFT JOIN asset ON asset.asset_id = buyer_config_asset_schedule.asset_id WHERE DATEDIFF(NOW(),( SELECT MIN(buyer_asset_schedule.expired_date) AS accrued_period FROM buyer_asset_schedule WHERE buyer_asset_schedule.buyer_config_asset_schedule_id = buyer_config_asset_schedule.buyer_config_asset_schedule_id AND buyer_asset_schedule.status_payment IN(1,3) AND asset.is_cancel_contract != 1 AND asset.asset_id is not null GROUP BY buyer_config_asset_schedule.buyer_config_asset_schedule_id)) > 0 GROUP BY buyer_config_asset_schedule.buyer_config_asset_schedule_id) tem";
$res_count_4 = ExecuteRow($sql_count_4);
$count_4 = $res_count_4['count_4'];
// $count_4 = number_format($count_4, 2, ',', ' ');
// ?>

<div class="row">
  <div class="col-md-3 col-sm-6 col-12">
    <a href="/numberdealsavailablelist">
        <div class="info-box">
        <span class="info-box-icon bg-primary"><i class="far fa-star"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">จำนวน Deal ที่อยู่ในมือ</span>
            <span class="info-box-number"><?=$count_1?></span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </a>
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <a href="/numberofaccruedlist">
    <div class="info-box">
      <span class="info-box-icon bg-success"><i class="far fa-star"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">จำนวนผู้ค้างจ่าย</span>
        <span class="info-box-number"><?=$count_2?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </a>
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <a href="/numberofunpaidunitslist">
    <div class="info-box">
      <span class="info-box-icon bg-orange"><i class="far fa-star"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">จำนวนงวดที่ค้างจ่าย</span>
        <span class="info-box-number"><?=$count_3?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </a>
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <a href="/outstandingamountlist">
    <div class="info-box">
      <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">จำนวนเงินที่ค้างจ่าย</span>
        <span class="info-box-number"><?=  "฿ ".number_format($count_4, 2) ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </a>
  </div>
  <!-- /.col -->
</div>

<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { number_of_unpaid_units: currentTable } });
var currentForm, currentPageID;
var fnumber_of_unpaid_unitslist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fnumber_of_unpaid_unitslist = new ew.Form("fnumber_of_unpaid_unitslist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fnumber_of_unpaid_unitslist;
    fnumber_of_unpaid_unitslist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fnumber_of_unpaid_unitslist");
});
var fnumber_of_unpaid_unitssrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fnumber_of_unpaid_unitssrch = new ew.Form("fnumber_of_unpaid_unitssrch", "list");
    currentSearchForm = fnumber_of_unpaid_unitssrch;

    // Add fields
    var fields = currentTable.fields;
    fnumber_of_unpaid_unitssrch.addFields([
        ["asset_code", [], fields.asset_code.isInvalid],
        ["_title", [], fields._title.isInvalid],
        ["asset_price", [ew.Validators.float], fields.asset_price.isInvalid],
        ["price_paid", [ew.Validators.float], fields.price_paid.isInvalid],
        ["remaining_price", [ew.Validators.float], fields.remaining_price.isInvalid],
        ["expiration_date", [ew.Validators.datetime(fields.expiration_date.clientFormatPattern)], fields.expiration_date.isInvalid],
        ["y_expiration_date", [ew.Validators.between], false],
        ["accrued_period_diff", [], fields.accrued_period_diff.isInvalid]
    ]);

    // Validate form
    fnumber_of_unpaid_unitssrch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fnumber_of_unpaid_unitssrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnumber_of_unpaid_unitssrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists

    // Filters
    fnumber_of_unpaid_unitssrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fnumber_of_unpaid_unitssrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if ($Security->canImport()) { ?>
    <?php if (!$Page->isExport()) { ?>
    <div class="btn-toolbar ew-toolbar">
    <?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
    <?php $Page->ExportOptions->render("body") ?>
    <?php } ?>
    <?php if ($Page->ImportOptions->visible()) { ?>
    <?php $Page->ImportOptions->render("body") ?>
    <?php } ?>
    <?php if ($Page->SearchOptions->visible()) { ?>
    <?php $Page->SearchOptions->render("body") ?>
    <?php } ?>
    <?php if ($Page->FilterOptions->visible()) { ?>
    <?php $Page->FilterOptions->render("body") ?>
    <?php } ?>
    </div>
    <?php } ?>
<?php } ?>

<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fnumber_of_unpaid_unitssrch" id="fnumber_of_unpaid_unitssrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fnumber_of_unpaid_unitssrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="number_of_unpaid_units">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->asset_price->Visible) { // asset_price ?>
<?php
if (!$Page->asset_price->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_asset_price" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->asset_price->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_asset_price" class="ew-search-caption ew-label"><?= $Page->asset_price->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_asset_price" id="z_asset_price" value="=">
</div>
        </div>
        <div id="el_number_of_unpaid_units_asset_price" class="ew-search-field">
<input type="<?= $Page->asset_price->getInputTextType() ?>" name="x_asset_price" id="x_asset_price" data-table="number_of_unpaid_units" data-field="x_asset_price" value="<?= $Page->asset_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->asset_price->getPlaceHolder()) ?>"<?= $Page->asset_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->asset_price->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->price_paid->Visible) { // price_paid ?>
<?php
if (!$Page->price_paid->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_price_paid" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->price_paid->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_price_paid" class="ew-search-caption ew-label"><?= $Page->price_paid->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_price_paid" id="z_price_paid" value="=">
</div>
        </div>
        <div id="el_number_of_unpaid_units_price_paid" class="ew-search-field">
<input type="<?= $Page->price_paid->getInputTextType() ?>" name="x_price_paid" id="x_price_paid" data-table="number_of_unpaid_units" data-field="x_price_paid" value="<?= $Page->price_paid->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->price_paid->getPlaceHolder()) ?>"<?= $Page->price_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->price_paid->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->remaining_price->Visible) { // remaining_price ?>
<?php
if (!$Page->remaining_price->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_remaining_price" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->remaining_price->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_remaining_price" class="ew-search-caption ew-label"><?= $Page->remaining_price->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_remaining_price" id="z_remaining_price" value="=">
</div>
        </div>
        <div id="el_number_of_unpaid_units_remaining_price" class="ew-search-field">
<input type="<?= $Page->remaining_price->getInputTextType() ?>" name="x_remaining_price" id="x_remaining_price" data-table="number_of_unpaid_units" data-field="x_remaining_price" value="<?= $Page->remaining_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->remaining_price->getPlaceHolder()) ?>"<?= $Page->remaining_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->remaining_price->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->expiration_date->Visible) { // expiration_date ?>
<?php
if (!$Page->expiration_date->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_expiration_date" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->expiration_date->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_expiration_date" class="ew-search-caption ew-label"><?= $Page->expiration_date->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_expiration_date" id="z_expiration_date" value="BETWEEN">
</div>
        </div>
        <div id="el_number_of_unpaid_units_expiration_date" class="ew-search-field">
<input type="<?= $Page->expiration_date->getInputTextType() ?>" name="x_expiration_date" id="x_expiration_date" data-table="number_of_unpaid_units" data-field="x_expiration_date" value="<?= $Page->expiration_date->EditValue ?>" placeholder="<?= HtmlEncode($Page->expiration_date->getPlaceHolder()) ?>"<?= $Page->expiration_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->expiration_date->getErrorMessage(false) ?></div>
<?php if (!$Page->expiration_date->ReadOnly && !$Page->expiration_date->Disabled && !isset($Page->expiration_date->EditAttrs["readonly"]) && !isset($Page->expiration_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnumber_of_unpaid_unitssrch", "datetimepicker"], function () {
    let format = "<?= DateFormat(111) ?>",
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
    ew.createDateTimePicker("fnumber_of_unpaid_unitssrch", "x_expiration_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_number_of_unpaid_units_expiration_date" class="ew-search-field2">
<input type="<?= $Page->expiration_date->getInputTextType() ?>" name="y_expiration_date" id="y_expiration_date" data-table="number_of_unpaid_units" data-field="x_expiration_date" value="<?= $Page->expiration_date->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->expiration_date->getPlaceHolder()) ?>"<?= $Page->expiration_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->expiration_date->getErrorMessage(false) ?></div>
<?php if (!$Page->expiration_date->ReadOnly && !$Page->expiration_date->Disabled && !isset($Page->expiration_date->EditAttrs["readonly"]) && !isset($Page->expiration_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnumber_of_unpaid_unitssrch", "datetimepicker"], function () {
    let format = "<?= DateFormat(111) ?>",
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
    ew.createDateTimePicker("fnumber_of_unpaid_unitssrch", "y_expiration_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
</div><!-- /.row -->
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fnumber_of_unpaid_unitssrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fnumber_of_unpaid_unitssrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fnumber_of_unpaid_unitssrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fnumber_of_unpaid_unitssrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> number_of_unpaid_units">
<form name="fnumber_of_unpaid_unitslist" id="fnumber_of_unpaid_unitslist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="number_of_unpaid_units">
<div id="gmp_number_of_unpaid_units" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_number_of_unpaid_unitslist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
        <th data-name="asset_code" class="<?= $Page->asset_code->headerCellClass() ?>"><div id="elh_number_of_unpaid_units_asset_code" class="number_of_unpaid_units_asset_code"><?= $Page->renderFieldHeader($Page->asset_code) ?></div></th>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
        <th data-name="_title" class="<?= $Page->_title->headerCellClass() ?>"><div id="elh_number_of_unpaid_units__title" class="number_of_unpaid_units__title"><?= $Page->renderFieldHeader($Page->_title) ?></div></th>
<?php } ?>
<?php if ($Page->asset_price->Visible) { // asset_price ?>
        <th data-name="asset_price" class="<?= $Page->asset_price->headerCellClass() ?>"><div id="elh_number_of_unpaid_units_asset_price" class="number_of_unpaid_units_asset_price"><?= $Page->renderFieldHeader($Page->asset_price) ?></div></th>
<?php } ?>
<?php if ($Page->price_paid->Visible) { // price_paid ?>
        <th data-name="price_paid" class="<?= $Page->price_paid->headerCellClass() ?>"><div id="elh_number_of_unpaid_units_price_paid" class="number_of_unpaid_units_price_paid"><?= $Page->renderFieldHeader($Page->price_paid) ?></div></th>
<?php } ?>
<?php if ($Page->remaining_price->Visible) { // remaining_price ?>
        <th data-name="remaining_price" class="<?= $Page->remaining_price->headerCellClass() ?>"><div id="elh_number_of_unpaid_units_remaining_price" class="number_of_unpaid_units_remaining_price"><?= $Page->renderFieldHeader($Page->remaining_price) ?></div></th>
<?php } ?>
<?php if ($Page->expiration_date->Visible) { // expiration_date ?>
        <th data-name="expiration_date" class="<?= $Page->expiration_date->headerCellClass() ?>"><div id="elh_number_of_unpaid_units_expiration_date" class="number_of_unpaid_units_expiration_date"><?= $Page->renderFieldHeader($Page->expiration_date) ?></div></th>
<?php } ?>
<?php if ($Page->accrued_period_diff->Visible) { // accrued_period_diff ?>
        <th data-name="accrued_period_diff" class="<?= $Page->accrued_period_diff->headerCellClass() ?>"><div id="elh_number_of_unpaid_units_accrued_period_diff" class="number_of_unpaid_units_accrued_period_diff"><?= $Page->renderFieldHeader($Page->accrued_period_diff) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif ($Page->isGridAdd() && !$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row attributes
        $Page->RowAttrs->merge([
            "data-rowindex" => $Page->RowCount,
            "id" => "r" . $Page->RowCount . "_number_of_unpaid_units",
            "data-rowtype" => $Page->RowType,
            "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Page->isAdd() && $Page->RowType == ROWTYPE_ADD || $Page->isEdit() && $Page->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Page->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->asset_code->Visible) { // asset_code ?>
        <td data-name="asset_code"<?= $Page->asset_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_number_of_unpaid_units_asset_code" class="el_number_of_unpaid_units_asset_code">
<span<?= $Page->asset_code->viewAttributes() ?>>
<?= $Page->asset_code->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_title->Visible) { // title ?>
        <td data-name="_title"<?= $Page->_title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_number_of_unpaid_units__title" class="el_number_of_unpaid_units__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_price->Visible) { // asset_price ?>
        <td data-name="asset_price"<?= $Page->asset_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_number_of_unpaid_units_asset_price" class="el_number_of_unpaid_units_asset_price">
<span<?= $Page->asset_price->viewAttributes() ?>>
<?= $Page->asset_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->price_paid->Visible) { // price_paid ?>
        <td data-name="price_paid"<?= $Page->price_paid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_number_of_unpaid_units_price_paid" class="el_number_of_unpaid_units_price_paid">
<span<?= $Page->price_paid->viewAttributes() ?>>
<?= $Page->price_paid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->remaining_price->Visible) { // remaining_price ?>
        <td data-name="remaining_price"<?= $Page->remaining_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_number_of_unpaid_units_remaining_price" class="el_number_of_unpaid_units_remaining_price">
<span<?= $Page->remaining_price->viewAttributes() ?>>
<?= $Page->remaining_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->expiration_date->Visible) { // expiration_date ?>
        <td data-name="expiration_date"<?= $Page->expiration_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_number_of_unpaid_units_expiration_date" class="el_number_of_unpaid_units_expiration_date">
<span<?= $Page->expiration_date->viewAttributes() ?>>
<?= $Page->expiration_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->accrued_period_diff->Visible) { // accrued_period_diff ?>
        <td data-name="accrued_period_diff"<?= $Page->accrued_period_diff->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_number_of_unpaid_units_accrued_period_diff" class="el_number_of_unpaid_units_accrued_period_diff">
<span<?= $Page->accrued_period_diff->viewAttributes() ?>>
<?= $Page->accrued_period_diff->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("fixedheadertable", function () {
    ew.fixedHeaderTable({
        delay: 0,
        container: "gmp_number_of_unpaid_units",
        width: "100%",
        height: "500px"
    });
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("number_of_unpaid_units");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
