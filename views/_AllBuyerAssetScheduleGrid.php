<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("AllBuyerAssetScheduleGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>

<style>
    #fall_buyer_asset_schedulegrid input{
        width:100px;
        text-align:right;
    }
</style>

<script>
var fall_buyer_asset_schedulegrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fall_buyer_asset_schedulegrid = new ew.Form("fall_buyer_asset_schedulegrid", "grid");
    fall_buyer_asset_schedulegrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { all_buyer_asset_schedule: currentTable } });
    var fields = currentTable.fields;
    fall_buyer_asset_schedulegrid.addFields([
        ["num_installment", [fields.num_installment.visible && fields.num_installment.required ? ew.Validators.required(fields.num_installment.caption) : null, ew.Validators.integer], fields.num_installment.isInvalid],
        ["installment_per_price", [fields.installment_per_price.visible && fields.installment_per_price.required ? ew.Validators.required(fields.installment_per_price.caption) : null, ew.Validators.float], fields.installment_per_price.isInvalid],
        ["interest", [fields.interest.visible && fields.interest.required ? ew.Validators.required(fields.interest.caption) : null, ew.Validators.float], fields.interest.isInvalid],
        ["principal", [fields.principal.visible && fields.principal.required ? ew.Validators.required(fields.principal.caption) : null, ew.Validators.float], fields.principal.isInvalid],
        ["remaining_principal", [fields.remaining_principal.visible && fields.remaining_principal.required ? ew.Validators.required(fields.remaining_principal.caption) : null, ew.Validators.float], fields.remaining_principal.isInvalid],
        ["pay_number", [fields.pay_number.visible && fields.pay_number.required ? ew.Validators.required(fields.pay_number.caption) : null], fields.pay_number.isInvalid],
        ["expired_date", [fields.expired_date.visible && fields.expired_date.required ? ew.Validators.required(fields.expired_date.caption) : null, ew.Validators.datetime(fields.expired_date.clientFormatPattern)], fields.expired_date.isInvalid],
        ["date_payment", [fields.date_payment.visible && fields.date_payment.required ? ew.Validators.required(fields.date_payment.caption) : null, ew.Validators.datetime(fields.date_payment.clientFormatPattern)], fields.date_payment.isInvalid],
        ["status_payment", [fields.status_payment.visible && fields.status_payment.required ? ew.Validators.required(fields.status_payment.caption) : null], fields.status_payment.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fall_buyer_asset_schedulegrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["num_installment",false],["installment_per_price",false],["interest",false],["principal",false],["remaining_principal",false],["pay_number",false],["expired_date",false],["date_payment",false],["status_payment",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fall_buyer_asset_schedulegrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fall_buyer_asset_schedulegrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fall_buyer_asset_schedulegrid.lists.status_payment = <?= $Grid->status_payment->toClientList($Grid) ?>;
    loadjs.done("fall_buyer_asset_schedulegrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> all_buyer_asset_schedule">
<div id="fall_buyer_asset_schedulegrid" class="ew-form ew-list-form">
<div id="gmp_all_buyer_asset_schedule" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_all_buyer_asset_schedulegrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->num_installment->Visible) { // num_installment ?>
        <th data-name="num_installment" class="<?= $Grid->num_installment->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_num_installment" class="all_buyer_asset_schedule_num_installment"><?= $Grid->renderFieldHeader($Grid->num_installment) ?></div></th>
<?php } ?>
<?php if ($Grid->installment_per_price->Visible) { // installment_per_price ?>
        <th data-name="installment_per_price" class="<?= $Grid->installment_per_price->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_installment_per_price" class="all_buyer_asset_schedule_installment_per_price"><?= $Grid->renderFieldHeader($Grid->installment_per_price) ?></div></th>
<?php } ?>
<?php if ($Grid->interest->Visible) { // interest ?>
        <th data-name="interest" class="<?= $Grid->interest->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_interest" class="all_buyer_asset_schedule_interest"><?= $Grid->renderFieldHeader($Grid->interest) ?></div></th>
<?php } ?>
<?php if ($Grid->principal->Visible) { // principal ?>
        <th data-name="principal" class="<?= $Grid->principal->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_principal" class="all_buyer_asset_schedule_principal"><?= $Grid->renderFieldHeader($Grid->principal) ?></div></th>
<?php } ?>
<?php if ($Grid->remaining_principal->Visible) { // remaining_principal ?>
        <th data-name="remaining_principal" class="<?= $Grid->remaining_principal->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_remaining_principal" class="all_buyer_asset_schedule_remaining_principal"><?= $Grid->renderFieldHeader($Grid->remaining_principal) ?></div></th>
<?php } ?>


<!-- <?php if ($Grid->pay_number->Visible) { // pay_number ?>
        <th data-name="pay_number" class="<?= $Grid->pay_number->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_pay_number" class="all_buyer_asset_schedule_pay_number"><?= $Grid->renderFieldHeader($Grid->pay_number) ?></div></th>
<?php } ?> -->


<!-- <?php if ($Grid->expired_date->Visible) { // expired_date ?>
        <th data-name="expired_date" class="<?= $Grid->expired_date->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_expired_date" class="all_buyer_asset_schedule_expired_date"><?= $Grid->renderFieldHeader($Grid->expired_date) ?></div></th>
<?php } ?> -->


<!-- <?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <th data-name="date_payment" class="<?= $Grid->date_payment->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_date_payment" class="all_buyer_asset_schedule_date_payment"><?= $Grid->renderFieldHeader($Grid->date_payment) ?></div></th>
<?php } ?> -->

<!-- <?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <th data-name="status_payment" class="<?= $Grid->status_payment->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_status_payment" class="all_buyer_asset_schedule_status_payment"><?= $Grid->renderFieldHeader($Grid->status_payment) ?></div></th>
<?php } ?> -->

<!-- <?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_cdate" class="all_buyer_asset_schedule_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
<?php } ?> -->
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
            "id" => "r" . $Grid->RowCount . "_all_buyer_asset_schedule",
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

    <script>
        loadjs.ready("load", function () {
        //    var asset_price = Number($('input[data-field="x_asset_price"]').value().replace(/[^0-9.-]+/g,""));
        //    var booking_price = Number($('input[data-field="x_booking_price"]').value().replace(/[^0-9.-]+/g,""));
        //    var down_price = Number($('input[data-field="x_down_price"]').value().replace(/[^0-9.-]+/g,""));

            // console.log("asset_price : "+ asset_price);
            // console.log("booking_price : "+ asset_price);
            // console.log("down_price : "+ asset_price);
        });
    </script>

    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>



































    <?php if ($Grid->num_installment->Visible) { // num_installment ?>
        <td data-name="num_installment"<?= $Grid->num_installment->cellAttributes() ?>>
        
        <?php // echo $Grid->RecordCount?>
        <?php // echo $Grid->StopRecord?>
        
        <?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_num_installment" class="el_all_buyer_asset_schedule_num_installment">
        <input type="<?= $Grid->num_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_num_installment" id="x<?= $Grid->RowIndex ?>_num_installment" data-table="all_buyer_asset_schedule" data-field="x_num_installment" value="<?= $Grid->num_installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->num_installment->getPlaceHolder()) ?>"<?= $Grid->num_installment->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->num_installment->getErrorMessage() ?></div>
        </span>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_num_installment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_num_installment" id="o<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->OldValue) ?>">
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_num_installment" class="el_all_buyer_asset_schedule_num_installment">
        <input readonly type="<?= $Grid->num_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_num_installment" id="x<?= $Grid->RowIndex ?>_num_installment" data-table="all_buyer_asset_schedule" data-field="x_num_installment" value="<?= $Grid->num_installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->num_installment->getPlaceHolder()) ?>"<?= $Grid->num_installment->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->num_installment->getErrorMessage() ?></div>
        </span>
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_num_installment" class="el_all_buyer_asset_schedule_num_installment">
        <span<?= $Grid->num_installment->viewAttributes() ?>>
        <?= $Grid->num_installment->getViewValue() ?></span>
        </span>
        <?php if ($Grid->isConfirm()) { ?>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_num_installment" data-hidden="1" name="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_num_installment" id="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->FormValue) ?>">
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_num_installment" data-hidden="1" name="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_num_installment" id="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->OldValue) ?>">
        <?php } ?>
        <?php } ?>
        </td>
    <?php } ?>

    <?php if ($Grid->installment_per_price->Visible) { // installment_per_price ?>
        <td data-name="installment_per_price"<?= $Grid->installment_per_price->cellAttributes() ?>>
        <?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_installment_per_price" class="el_all_buyer_asset_schedule_installment_per_price">
        <input type="<?= $Grid->installment_per_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_per_price" id="x<?= $Grid->RowIndex ?>_installment_per_price" data-table="all_buyer_asset_schedule" data-field="x_installment_per_price" value="<?= $Grid->installment_per_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_per_price->getPlaceHolder()) ?>"<?= $Grid->installment_per_price->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->installment_per_price->getErrorMessage() ?></div>
        </span>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_installment_per_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_installment_per_price" id="o<?= $Grid->RowIndex ?>_installment_per_price" value="<?= HtmlEncode($Grid->installment_per_price->OldValue) ?>">
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_installment_per_price" class="el_all_buyer_asset_schedule_installment_per_price">
        <input type="<?= $Grid->installment_per_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_per_price" id="x<?= $Grid->RowIndex ?>_installment_per_price" data-table="all_buyer_asset_schedule" data-field="x_installment_per_price" value="<?= $Grid->installment_per_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_per_price->getPlaceHolder()) ?>"<?= $Grid->installment_per_price->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->installment_per_price->getErrorMessage() ?></div>
        </span>
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_installment_per_price" class="el_all_buyer_asset_schedule_installment_per_price">
        <span<?= $Grid->installment_per_price->viewAttributes() ?>>
        <?= $Grid->installment_per_price->getViewValue() ?></span>
        </span>
        <?php if ($Grid->isConfirm()) { ?>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_installment_per_price" data-hidden="1" name="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_installment_per_price" id="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_installment_per_price" value="<?= HtmlEncode($Grid->installment_per_price->FormValue) ?>">
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_installment_per_price" data-hidden="1" name="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_installment_per_price" id="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_installment_per_price" value="<?= HtmlEncode($Grid->installment_per_price->OldValue) ?>">
        <?php } ?>
        <?php } ?>
        
        <?php
        // echo $Grid->RowCount;
        if ($Grid->RowCount <= 1) {
        ?>
            <script>
                loadjs.ready("load", function () {
                   // จำนวนวันที่ต้องจ่ายสำหรับเดือนแรก/จำนวนวันต่อเดือนของเดือนแรก*เงินจ่ายรายเดือน = เงินจ่ายรายเดือน
                   let installment_price_per = Number($('input[data-field="x_installment_price_per"]').val());
                   let number_days_pay_first_month = Number($('input[data-field="x_number_days_pay_first_month"]').val().replace(/[^0-9.-]+/g,"")); // จำนวนวันที่ต้องจ่ายสำหรับเดือนแรก
                   let number_days_in_first_month = Number($('input[data-field="x_number_days_in_first_month"]').val().replace(/[^0-9.-]+/g,"")); // จำนวนวันต่อเดือนของเดือนแรก

                   let total_value3 = 0;

                   if (number_days_pay_first_month <= 0) {
                    total_value3 = 0;
                   } else {
                    total_value3 = number_days_pay_first_month/number_days_in_first_month*installment_price_per;
                   }

                    // console.log("number_days_in_first_month <?=$Grid->RowIndex?> : "+ number_days_in_first_month);
                    // console.log("number_days_pay_first_month <?=$Grid->RowIndex?> : "+ number_days_pay_first_month);
                    // console.log("เงินจ่ายรายเดือน <?=$Grid->RowIndex?> : "+ total_value3);

                    $('input[name="x<?= $Grid->RowIndex ?>_installment_per_price"]').val(Math.round(total_value3));

                    $('#x_installment_price_per, #x_number_days_pay_first_month, #x_number_days_in_first_month').on('blur', function() {
                        console.log("Event Blur Active : จำนวนเงินขั้นต่ำที่ต้องจ่าย (งวดแรก)");

                        let installment_price_per = Number($('input[data-field="x_installment_price_per"]').val());
                        let number_days_pay_first_month = Number($('input[data-field="x_number_days_pay_first_month"]').val().replace(/[^0-9.-]+/g,"")); // จำนวนวันที่ต้องจ่ายสำหรับเดือนแรก
                        let number_days_in_first_month = Number($('input[data-field="x_number_days_in_first_month"]').val().replace(/[^0-9.-]+/g,"")); // จำนวนวันต่อเดือนของเดือนแรก

                        let total_value3 = 0;

                        if (number_days_pay_first_month <= 0) {
                            total_value3 = 0;
                        } else {
                            total_value3 = number_days_pay_first_month/number_days_in_first_month*installment_price_per;
                        }

                        $('input[name="x<?= $Grid->RowIndex ?>_installment_per_price"]').val(Math.round(total_value3));
                    });
                });
            </script>
        <?php
        } else if($Grid->RecordCount == $Grid->StopRecord) {
        ?>
            <script>
                loadjs.ready("load", function () {
                    // เงินจ่ายรายเดือน งวดสุดท้าย
                    let installment_price_per1 = $('input[name="x1_installment_per_price"]').val();
                    let installment_price_per = Number($('input[data-field="x_installment_price_per"]').val());

                    let total_value3_1 = 0;
                    let total_value3 = 0;

                    total_value3_1 = installment_price_per1;
                    if (total_value3_1 <= 0){
                        total_value3_1 = 0;
                    }

                    total_value3 = installment_price_per-total_value3_1;

                    if (total_value3 <= 0){
                        total_value3 = 0;
                    }

                    $('input[name="x<?= $Grid->RowIndex ?>_installment_per_price"]').val(Math.round(total_value3));

                    $('#x_installment_price_per, #x1_installment_per_price').on('input', function() {
                        console.log("Event Blur Active : จำนวนเงินขั้นต่ำที่ต้องจ่าย (งวดสุดท้าย)");
                        // เงินจ่ายรายเดือน งวดสุดท้าย
                        let installment_price_per1 = $('input[name="x1_installment_per_price"]').val();
                        let installment_price_per = Number($('input[data-field="x_installment_price_per"]').value().replace(/[^0-9.-]+/g,""));

                        let total_value3_1 = 0;
                        let total_value3 = 0;

                        total_value3_1 = installment_price_per1;
                        if (total_value3_1 <= 0){
                            total_value3_1 = 0;
                        }

                        total_value3 = installment_price_per-total_value3_1;

                        if (total_value3 <= 0){
                            total_value3 = 0;
                        }

                        $('input[name="x<?= $Grid->RowIndex ?>_installment_per_price"]').val(Math.round(total_value3));
                    });
                });
            </script>

        <?php
        } else {
        ?>
            <script>
                loadjs.ready("load", function () {
                    // เงินจ่ายรายเดือน
                    let installment_price_per = Number($('input[data-field="x_installment_price_per"]').value().replace(/[^0-9.-]+/g,""));
                    // console.log("เงินจ่ายรายเดือน <?=$Grid->RowIndex?> : "+ installment_price_per);

                    let total_value3 = 0;
                    // console.log("เงินจ่ายรายเดือน <?=$Grid->RowIndex?> : "+ installment_price_per);
                    total_value3 = installment_price_per;

                    if (total_value3 <= 0){
                        total_value3 = 0;
                    }

                    $('input[name="x<?= $Grid->RowIndex ?>_installment_per_price"]').val(Math.round(total_value3));

                    $('#x_installment_price_per').on('blur', function() {
                        console.log("Event Blur Active : เงินจ่ายรายเดือน");

                        let installment_price_per = Number($('input[data-field="x_installment_price_per"]').value().replace(/[^0-9.-]+/g,""));
                        // console.log("เงินจ่ายรายเดือน <?=$Grid->RowIndex?> : "+ installment_price_per);

                        let total_value3 = 0;
                        // console.log("เงินจ่ายรายเดือน <?=$Grid->RowIndex?> : "+ installment_price_per);
                        total_value3 = installment_price_per;

                        if (total_value3 <= 0){
                            total_value3 = 0;
                        }

                        $('input[name="x<?= $Grid->RowIndex ?>_installment_per_price"]').val(Math.round(total_value3));
                    });
                });
            </script>
        <?php
        }
        ?>
        </td>
    <?php } ?>

    <?php if ($Grid->interest->Visible) { // interest ?>
        <td data-name="interest"<?= $Grid->interest->cellAttributes() ?>>
        <?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_interest" class="el_all_buyer_asset_schedule_interest">
        <input type="<?= $Grid->interest->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_interest" id="x<?= $Grid->RowIndex ?>_interest" data-table="all_buyer_asset_schedule" data-field="x_interest" value="<?= $Grid->interest->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Grid->interest->getPlaceHolder()) ?>"<?= $Grid->interest->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->interest->getErrorMessage() ?></div>
        </span>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_interest" data-hidden="1" name="o<?= $Grid->RowIndex ?>_interest" id="o<?= $Grid->RowIndex ?>_interest" value="<?= HtmlEncode($Grid->interest->OldValue) ?>">
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_interest" class="el_all_buyer_asset_schedule_interest">
        <input readonly type="<?= $Grid->interest->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_interest" id="x<?= $Grid->RowIndex ?>_interest" data-table="all_buyer_asset_schedule" data-field="x_interest" value="<?= $Grid->interest->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Grid->interest->getPlaceHolder()) ?>"<?= $Grid->interest->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->interest->getErrorMessage() ?></div>
        </span>
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_interest" class="el_all_buyer_asset_schedule_interest">
        <span<?= $Grid->interest->viewAttributes() ?>>
        <?= $Grid->interest->getViewValue() ?></span>
        </span>
        <?php if ($Grid->isConfirm()) { ?>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_interest" data-hidden="1" name="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_interest" id="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_interest" value="<?= HtmlEncode($Grid->interest->FormValue) ?>">
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_interest" data-hidden="1" name="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_interest" id="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_interest" value="<?= HtmlEncode($Grid->interest->OldValue) ?>">
        <?php } ?>
        <?php } ?>
        <?php 
        // echo $Grid->RowCount;
        if ($Grid->RowCount <= 1) {
        ?>
            <script>
                loadjs.ready("load", function () {
                   // =(ดอกเบี้ยรายปี/12) * ราคาบ้าน * (จำนวนวันที่ต้องจ่ายสำหรับเดือนแรก/จำนวนวันต่อเดือนของเดือนแรก)
                
                   let annual_interest = $('input[data-field="x_annual_interest"]').val(); // ดอกเบี้ยรายปี
                   let asset_price = Number($('input[data-field="x_asset_price"]').val().replace(/[^0-9.-]+/g,"")); // ราคาบ้าน
                   let number_days_pay_first_month = Number($('input[data-field="x_number_days_pay_first_month"]').val().replace(/[^0-9.-]+/g,"")); // จำนวนวันที่ต้องจ่ายสำหรับเดือนแรก
                   let number_days_in_first_month = Number($('input[data-field="x_number_days_in_first_month"]').val().replace(/[^0-9.-]+/g,"")); // จำนวนวันต่อเดือนของเดือนแรก

                   let total_value = 0;

                    total_value = ((annual_interest/100)/12) * asset_price * (number_days_pay_first_month/number_days_in_first_month)

                    if(total_value <= 0){
                        total_value = 0;
                    }

                    // console.log("ดอกเบี้ย <?=$Grid->RowIndex?> : "+ total_value);

                   $('input[name="x<?= $Grid->RowIndex ?>_interest"]').val(Math.round(total_value));

                   $('#x_asset_price, #x_number_days_pay_first_month, #x_number_days_in_first_month, #x_annual_interest').on("blur", function() {
                        console.log("Event Blur Active : ดอกเบี้ยงวดแรก");
                        let annual_interest = $('input[data-field="x_annual_interest"]').val(); // ดอกเบี้ยรายปี
                        let asset_price = Number($('input[data-field="x_asset_price"]').val().replace(/[^0-9.-]+/g,"")); // ราคาบ้าน
                        let number_days_pay_first_month = Number($('input[data-field="x_number_days_pay_first_month"]').val().replace(/[^0-9.-]+/g,"")); // จำนวนวันที่ต้องจ่ายสำหรับเดือนแรก
                        let number_days_in_first_month = Number($('input[data-field="x_number_days_in_first_month"]').val().replace(/[^0-9.-]+/g,"")); // จำนวนวันต่อเดือนของเดือนแรก

                        let total_value = 0;

                            total_value = ((annual_interest/100)/12) * asset_price * (number_days_pay_first_month/number_days_in_first_month)

                            if(total_value <= 0){
                                total_value = 0;
                            }

                            // console.log("ดอกเบี้ย <?=$Grid->RowIndex?> : "+ total_value);

                        $('input[name="x<?= $Grid->RowIndex ?>_interest"]').val(Math.round(total_value));
                   });
                });
            </script>
        <?php
        } else {
        ?>
            <script>
                loadjs.ready("load", function () {
                   // ดอกเบี้ยรายปี/12*เงินต้นคงเหลือ(งวดที่แล้ว)
                   let total_value = 0;
                   let annual_interest = $('input[data-field="x_annual_interest"]').val(); // ดอกเบี้ยรายปี
                   let remaining_principal = $('input[name="x<?= $Grid->RowIndex - 1 ?>_remaining_principal"]').val(); // เงินต้นคงเหลือ(งวดที่แล้ว)

                    total_value = (annual_interest/100)/12 * remaining_principal;
                    // console.log("ดอกเบี้ย <?=$Grid->RowIndex?> : "+ total_value);

                    if (total_value <= 0) {
                        total_value = 0;
                    }

                   $('input[name="x<?= $Grid->RowIndex ?>_interest"]').val(Math.round(total_value));

                   $('#x_annual_interest, input[name="x<?= $Grid->RowIndex - 1 ?>_remaining_principal"]').on("input", function() {
                        console.log("Event Input Active : ดอกเบี้ยงวด : " + <?= $Grid->RowIndex ?> );
                        let total_value = 0;
                        let annual_interest = $('input[data-field="x_annual_interest"]').val(); // ดอกเบี้ยรายปี
                        let remaining_principal = $('input[name="x<?= $Grid->RowIndex - 1 ?>_remaining_principal"]').val(); // เงินต้นคงเหลือ(งวดที่แล้ว)

                        total_value = (annual_interest/100)/12 * remaining_principal;
                        // console.log("ดอกเบี้ย <?=$Grid->RowIndex?> : "+ total_value);

                        if (total_value <= 0) {
                            total_value = 0;
                        }

                        $('input[name="x<?= $Grid->RowIndex ?>_interest"]').val(Math.round(total_value));  
                   });
                });
            </script>
        <?php
        }
        ?>
        </td>
    <?php } ?>










    <?php if ($Grid->principal->Visible) { // principal ?>
        <td data-name="principal"<?= $Grid->principal->cellAttributes() ?>>
        <?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_principal" class="el_all_buyer_asset_schedule_principal">
        <input type="<?= $Grid->principal->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_principal" id="x<?= $Grid->RowIndex ?>_principal" data-table="all_buyer_asset_schedule" data-field="x_principal" value="<?= $Grid->principal->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Grid->principal->getPlaceHolder()) ?>"<?= $Grid->principal->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->principal->getErrorMessage() ?></div>
        </span>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_principal" data-hidden="1" name="o<?= $Grid->RowIndex ?>_principal" id="o<?= $Grid->RowIndex ?>_principal" value="<?= HtmlEncode($Grid->principal->OldValue) ?>">
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_principal" class="el_all_buyer_asset_schedule_principal">
        <input readonly type="<?= $Grid->principal->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_principal" id="x<?= $Grid->RowIndex ?>_principal" data-table="all_buyer_asset_schedule" data-field="x_principal" value="<?= $Grid->principal->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Grid->principal->getPlaceHolder()) ?>"<?= $Grid->principal->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->principal->getErrorMessage() ?></div>
        </span>
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_principal" class="el_all_buyer_asset_schedule_principal">
        <span<?= $Grid->principal->viewAttributes() ?>>
        <?= $Grid->principal->getViewValue() ?></span>
        </span>
        <?php if ($Grid->isConfirm()) { ?>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_principal" data-hidden="1" name="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_principal" id="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_principal" value="<?= HtmlEncode($Grid->principal->FormValue) ?>">
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_principal" data-hidden="1" name="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_principal" id="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_principal" value="<?= HtmlEncode($Grid->principal->OldValue) ?>">
        <?php } ?>
        <?php } ?>

        <script>
            loadjs.ready("load", function () {
                //  จำนวนเงินขั้นต่ำที่ต้องจ่าย - ดอกเบี้ย = เงินต้น

                let val4_<?=$Grid->RowIndex?>_installment_per_price = $('#x<?= $Grid->RowIndex ?>_installment_per_price').val();
                let val4_<?=$Grid->RowIndex?>_interest = $('#x<?= $Grid->RowIndex ?>_interest').val();

                let total_value4 = 0;

                total_value4 = val4_<?=$Grid->RowIndex?>_installment_per_price-val4_<?=$Grid->RowIndex?>_interest;

                if (total_value4 <= 0) {
                    total_value4 = 0;
                }

                // console.log("จำนวนเงินขั้นต่ำที่ต้องจ่าย <?=$Grid->RowIndex?> : "+ val4_<?=$Grid->RowIndex?>_installment_per_price);
                // console.log("ดอกเบี้ย <?=$Grid->RowIndex?> : "+ val4_<?=$Grid->RowIndex?>_interest);

                // console.log("เงินต้น <?=$Grid->RowIndex?> : "+ total_value4);

                $('input[name="x<?= $Grid->RowIndex ?>_principal"]').val(parseInt(total_value4));


                // check blur event
                $('#x<?= $Grid->RowIndex ?>_installment_per_price ,#x<?= $Grid->RowIndex ?>_interest').on("change", function() {
                    console.log('change 2 : <?= $Grid->RowIndex ?>');

                    let val4_<?=$Grid->RowIndex?>_installment_per_price = $('#x<?= $Grid->RowIndex ?>_installment_per_price').val();
                    let val4_<?=$Grid->RowIndex?>_interest = $('#x<?= $Grid->RowIndex ?>_interest').val();

                    let total_value4 = 0;

                    total_value4 = val4_<?=$Grid->RowIndex?>_installment_per_price-val4_<?=$Grid->RowIndex?>_interest;

                    if (total_value4 <= 0) {
                        total_value4 = 0;
                    }

                    $('input[name="x<?= $Grid->RowIndex ?>_principal"]').val(parseInt(total_value4));
                });

            });
        </script>
        
        </td>
    <?php } ?>










    <?php if ($Grid->remaining_principal->Visible) { // remaining_principal ?>
        <td data-name="remaining_principal"<?= $Grid->remaining_principal->cellAttributes() ?>>
        <?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_remaining_principal" class="el_all_buyer_asset_schedule_remaining_principal">
        <input type="<?= $Grid->remaining_principal->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_remaining_principal" id="x<?= $Grid->RowIndex ?>_remaining_principal" data-table="all_buyer_asset_schedule" data-field="x_remaining_principal" value="<?= $Grid->remaining_principal->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Grid->remaining_principal->getPlaceHolder()) ?>"<?= $Grid->remaining_principal->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->remaining_principal->getErrorMessage() ?></div>
        </span>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_remaining_principal" data-hidden="1" name="o<?= $Grid->RowIndex ?>_remaining_principal" id="o<?= $Grid->RowIndex ?>_remaining_principal" value="<?= HtmlEncode($Grid->remaining_principal->OldValue) ?>">
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_remaining_principal" class="el_all_buyer_asset_schedule_remaining_principal">
        <input readonly type="<?= $Grid->remaining_principal->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_remaining_principal" id="x<?= $Grid->RowIndex ?>_remaining_principal" data-table="all_buyer_asset_schedule" data-field="x_remaining_principal" value="<?= $Grid->remaining_principal->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Grid->remaining_principal->getPlaceHolder()) ?>"<?= $Grid->remaining_principal->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->remaining_principal->getErrorMessage() ?></div>
        </span>
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_remaining_principal" class="el_all_buyer_asset_schedule_remaining_principal">
        <span<?= $Grid->remaining_principal->viewAttributes() ?>>
        <?= $Grid->remaining_principal->getViewValue() ?></span>
        </span>
        <?php if ($Grid->isConfirm()) { ?>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_remaining_principal" data-hidden="1" name="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_remaining_principal" id="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_remaining_principal" value="<?= HtmlEncode($Grid->remaining_principal->FormValue) ?>">
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_remaining_principal" data-hidden="1" name="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_remaining_principal" id="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_remaining_principal" value="<?= HtmlEncode($Grid->remaining_principal->OldValue) ?>">
        <?php } ?>
        <?php } ?>
        <?php 
        // echo $Grid->RowCount;
        if ($Grid->RowCount <= 1) {
        ?>
            <script>
                loadjs.ready("load", function () {
                   // ราคาบ้าน - เงินต้น - เงินจอง - เงินดาวน์
                   let asset_price = Number($('input[data-field="x_asset_price"]').value().replace(/[^0-9.-]+/g,""));
                   let booking_price = Number($('input[data-field="x_booking_price"]').value().replace(/[^0-9.-]+/g,""));
                   let down_price = Number($('input[data-field="x_down_price"]').value().replace(/[^0-9.-]+/g,""));

                   let total_value = 0;
                   let val_<?=$Grid->RowIndex?>_principal = $('#x<?= $Grid->RowIndex ?>_principal').val();

                   total_value = asset_price-val_<?= $Grid->RowIndex ?>_principal-booking_price-down_price;

                   if (total_value <= 0) {
                        total_value = 0;
                   }

                    // console.log("เงินต้นคงเหลือ <?=$Grid->RowIndex?> : "+ total_value);
                   $('input[name="x<?= $Grid->RowIndex ?>_remaining_principal"]').val(parseInt(total_value));

                   $('input[data-field="x_asset_price"] ,input[data-field="x_booking_price"] ,input[data-field="x_down_price"] ,input[data-field="x<?= $Grid->RowIndex ?>_principal"]').on("change", function() {
                        console.log('change event');

                        let asset_price = Number($('input[data-field="x_asset_price"]').value().replace(/[^0-9.-]+/g,""));
                        let booking_price = Number($('input[data-field="x_booking_price"]').value().replace(/[^0-9.-]+/g,""));
                        let down_price = Number($('input[data-field="x_down_price"]').value().replace(/[^0-9.-]+/g,""));

                        let total_value = 0;
                        let val_<?=$Grid->RowIndex?>_principal = $('#x<?= $Grid->RowIndex ?>_principal').val();

                        total_value = asset_price-val_<?= $Grid->RowIndex ?>_principal-booking_price-down_price;

                        if (total_value <= 0) {
                                total_value = 0;
                        }

                        $('input[name="x<?= $Grid->RowIndex ?>_remaining_principal"]').val(parseInt(total_value));
                    });
                });
            </script>
        <?php
        } else {
        ?>
            <script>
                loadjs.ready("load", function () {
                   // เงินต้นคงเหลือ (เดือนก่อน) - เงินต้น

                    let total_value = 0;
                    let val_<?= $Grid->RowIndex-1 ?>_remaining_principal = $("#x<?= $Grid->RowIndex-1 ?>_remaining_principal").val();
                    let val_<?= $Grid->RowIndex ?>_principal = $('#x<?= $Grid->RowIndex ?>_principal').val();

                    total_value = val_<?= $Grid->RowIndex-1 ?>_remaining_principal-val_<?= $Grid->RowIndex ?>_principal;

                    if (total_value <= 0) {
                        total_value = 0;
                    }

                    // console.log("remaining_principal : "+ val_<?= $Grid->RowIndex-1 ?>_remaining_principal);
                    // console.log("principal : "+ val_<?= $Grid->RowIndex ?>_principal);

                    $('input[name="x<?= $Grid->RowIndex ?>_remaining_principal"]').val(parseInt(total_value));

                    $('#x<?= $Grid->RowIndex-1 ?>_remaining_principal, #x<?= $Grid->RowIndex ?>_principal').on('input', function() {
                        console.log("Event Input Active : เงินต้นคงเหลือ งวดที่ <?= $Grid->RowIndex-1 ?>");
                        console.log("Event Input Active : เงินต้น งวดที่ <?= $Grid->RowIndex ?>");

                        let total_value = 0;
                        let val_<?= $Grid->RowIndex-1 ?>_remaining_principal = $("#x<?= $Grid->RowIndex-1 ?>_remaining_principal").val();
                        let val_<?= $Grid->RowIndex ?>_principal = $('#x<?= $Grid->RowIndex ?>_principal').val();

                        total_value = val_<?= $Grid->RowIndex-1 ?>_remaining_principal-val_<?= $Grid->RowIndex ?>_principal;

                        if (total_value <= 0) {
                            total_value = 0;
                        }

                        $('input[name="x<?= $Grid->RowIndex ?>_remaining_principal"]').val(parseInt(total_value));
                    });
                });

            </script>
        <?php
        }
        ?>

        </td>

    <?php } ?>






















































    
    <!-- <?php if ($Grid->pay_number->Visible) { // pay_number ?>
        <td data-name="pay_number"<?= $Grid->pay_number->cellAttributes() ?>>
        <?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_pay_number" class="el_all_buyer_asset_schedule_pay_number">
        <input type="<?= $Grid->pay_number->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" data-table="all_buyer_asset_schedule" data-field="x_pay_number" value="<?= $Grid->pay_number->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->pay_number->getPlaceHolder()) ?>"<?= $Grid->pay_number->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->pay_number->getErrorMessage() ?></div>
        </span>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_pay_number" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pay_number" id="o<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->OldValue) ?>">
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_pay_number" class="el_all_buyer_asset_schedule_pay_number">
        <input type="<?= $Grid->pay_number->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" data-table="all_buyer_asset_schedule" data-field="x_pay_number" value="<?= $Grid->pay_number->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->pay_number->getPlaceHolder()) ?>"<?= $Grid->pay_number->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->pay_number->getErrorMessage() ?></div>
        </span>
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_pay_number" class="el_all_buyer_asset_schedule_pay_number">
        <span<?= $Grid->pay_number->viewAttributes() ?>>
        <?= $Grid->pay_number->getViewValue() ?></span>
        </span>
        <?php if ($Grid->isConfirm()) { ?>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_pay_number" data-hidden="1" name="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_pay_number" id="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->FormValue) ?>">
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_pay_number" data-hidden="1" name="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_pay_number" id="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->OldValue) ?>">
        <?php } ?>
        <?php } ?>
        </td>
    <?php } ?> -->

    <!-- <?php if ($Grid->expired_date->Visible) { // expired_date ?>
        <td data-name="expired_date"<?= $Grid->expired_date->cellAttributes() ?>>
        <?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_expired_date" class="el_all_buyer_asset_schedule_expired_date">
        <input type="<?= $Grid->expired_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" data-table="all_buyer_asset_schedule" data-field="x_expired_date" value="<?= $Grid->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->expired_date->getPlaceHolder()) ?>"<?= $Grid->expired_date->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->expired_date->getErrorMessage() ?></div>
        <?php if (!$Grid->expired_date->ReadOnly && !$Grid->expired_date->Disabled && !isset($Grid->expired_date->EditAttrs["readonly"]) && !isset($Grid->expired_date->EditAttrs["disabled"])) { ?>
        <script>
        loadjs.ready(["fall_buyer_asset_schedulegrid", "datetimepicker"], function () {
            let options = {
                localization: {
                    locale: ew.LANGUAGE_ID
                },
                display: {
                    inputFormat: "<?= DateFormat(7) ?>",
                    icons: {
                        previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                        next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
                    }
                }
            };
            ew.createDateTimePicker("fall_buyer_asset_schedulegrid", "x<?= $Grid->RowIndex ?>_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
        });
        </script>
        <?php } ?>
        </span>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_expired_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_expired_date" id="o<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->OldValue) ?>">
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_expired_date" class="el_all_buyer_asset_schedule_expired_date">
        <input type="<?= $Grid->expired_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" data-table="all_buyer_asset_schedule" data-field="x_expired_date" value="<?= $Grid->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->expired_date->getPlaceHolder()) ?>"<?= $Grid->expired_date->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->expired_date->getErrorMessage() ?></div>
        <?php if (!$Grid->expired_date->ReadOnly && !$Grid->expired_date->Disabled && !isset($Grid->expired_date->EditAttrs["readonly"]) && !isset($Grid->expired_date->EditAttrs["disabled"])) { ?>
        <script>
        loadjs.ready(["fall_buyer_asset_schedulegrid", "datetimepicker"], function () {
            let options = {
                localization: {
                    locale: ew.LANGUAGE_ID
                },
                display: {
                    inputFormat: "<?= DateFormat(7) ?>",
                    icons: {
                        previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                        next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
                    }
                }
            };
            ew.createDateTimePicker("fall_buyer_asset_schedulegrid", "x<?= $Grid->RowIndex ?>_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
        });
        </script>
        <?php } ?>
        </span>
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_expired_date" class="el_all_buyer_asset_schedule_expired_date">
        <span<?= $Grid->expired_date->viewAttributes() ?>>
        <?= $Grid->expired_date->getViewValue() ?></span>
        </span>
        <?php if ($Grid->isConfirm()) { ?>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_expired_date" data-hidden="1" name="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_expired_date" id="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->FormValue) ?>">
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_expired_date" data-hidden="1" name="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_expired_date" id="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->OldValue) ?>">
        <?php } ?>
        <?php } ?>
        </td>
    <?php } ?> -->

    <!-- <?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment"<?= $Grid->date_payment->cellAttributes() ?>>
        <?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_date_payment" class="el_all_buyer_asset_schedule_date_payment">
        <input type="<?= $Grid->date_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" data-table="all_buyer_asset_schedule" data-field="x_date_payment" value="<?= $Grid->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_payment->getPlaceHolder()) ?>"<?= $Grid->date_payment->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->date_payment->getErrorMessage() ?></div>
        <?php if (!$Grid->date_payment->ReadOnly && !$Grid->date_payment->Disabled && !isset($Grid->date_payment->EditAttrs["readonly"]) && !isset($Grid->date_payment->EditAttrs["disabled"])) { ?>
        <script>
        loadjs.ready(["fall_buyer_asset_schedulegrid", "datetimepicker"], function () {
            let options = {
                localization: {
                    locale: ew.LANGUAGE_ID
                },
                display: {
                    inputFormat: "<?= DateFormat(7) ?>",
                    icons: {
                        previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                        next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
                    }
                }
            };
            ew.createDateTimePicker("fall_buyer_asset_schedulegrid", "x<?= $Grid->RowIndex ?>_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
        });
        </script>
        <?php } ?>
        </span>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_date_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_payment" id="o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_date_payment" class="el_all_buyer_asset_schedule_date_payment">
        <input type="<?= $Grid->date_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" data-table="all_buyer_asset_schedule" data-field="x_date_payment" value="<?= $Grid->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_payment->getPlaceHolder()) ?>"<?= $Grid->date_payment->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Grid->date_payment->getErrorMessage() ?></div>
        <?php if (!$Grid->date_payment->ReadOnly && !$Grid->date_payment->Disabled && !isset($Grid->date_payment->EditAttrs["readonly"]) && !isset($Grid->date_payment->EditAttrs["disabled"])) { ?>
        <script>
        loadjs.ready(["fall_buyer_asset_schedulegrid", "datetimepicker"], function () {
            let options = {
                localization: {
                    locale: ew.LANGUAGE_ID
                },
                display: {
                    inputFormat: "<?= DateFormat(7) ?>",
                    icons: {
                        previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                        next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
                    }
                }
            };
            ew.createDateTimePicker("fall_buyer_asset_schedulegrid", "x<?= $Grid->RowIndex ?>_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
        });
        </script>
        <?php } ?>
        </span>
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_date_payment" class="el_all_buyer_asset_schedule_date_payment">
        <span<?= $Grid->date_payment->viewAttributes() ?>>
        <?= $Grid->date_payment->getViewValue() ?></span>
        </span>
        <?php if ($Grid->isConfirm()) { ?>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_date_payment" data-hidden="1" name="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_date_payment" id="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->FormValue) ?>">
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_date_payment" data-hidden="1" name="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_date_payment" id="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
        <?php } ?>
        <?php } ?>
        </td>
    <?php } ?> -->

    <!-- <?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment"<?= $Grid->status_payment->cellAttributes() ?>>
        <?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_status_payment" class="el_all_buyer_asset_schedule_status_payment">
            <select
                id="x<?= $Grid->RowIndex ?>_status_payment"
                name="x<?= $Grid->RowIndex ?>_status_payment"
                class="form-select ew-select<?= $Grid->status_payment->isInvalidClass() ?>"
                data-select2-id="fall_buyer_asset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment"
                data-table="all_buyer_asset_schedule"
                data-field="x_status_payment"
                data-value-separator="<?= $Grid->status_payment->displayValueSeparatorAttribute() ?>"
                data-placeholder="<?= HtmlEncode($Grid->status_payment->getPlaceHolder()) ?>"
                <?= $Grid->status_payment->editAttributes() ?>>
                <?= $Grid->status_payment->selectOptionListHtml("x{$Grid->RowIndex}_status_payment") ?>
            </select>
            <div class="invalid-feedback"><?= $Grid->status_payment->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fall_buyer_asset_schedulegrid", function() {
            var options = { name: "x<?= $Grid->RowIndex ?>_status_payment", selectId: "fall_buyer_asset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment" },
                el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
            options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
            if (fall_buyer_asset_schedulegrid.lists.status_payment.lookupOptions.length) {
                options.data = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fall_buyer_asset_schedulegrid" };
            } else {
                options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fall_buyer_asset_schedulegrid", limit: ew.LOOKUP_PAGE_SIZE };
            }
            options.minimumResultsForSearch = Infinity;
            options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.all_buyer_asset_schedule.fields.status_payment.selectOptions);
            ew.createSelect(options);
        });
        </script>
        </span>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_status_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_payment" id="o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_status_payment" class="el_all_buyer_asset_schedule_status_payment">
            <select
                id="x<?= $Grid->RowIndex ?>_status_payment"
                name="x<?= $Grid->RowIndex ?>_status_payment"
                class="form-select ew-select<?= $Grid->status_payment->isInvalidClass() ?>"
                data-select2-id="fall_buyer_asset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment"
                data-table="all_buyer_asset_schedule"
                data-field="x_status_payment"
                data-value-separator="<?= $Grid->status_payment->displayValueSeparatorAttribute() ?>"
                data-placeholder="<?= HtmlEncode($Grid->status_payment->getPlaceHolder()) ?>"
                <?= $Grid->status_payment->editAttributes() ?>>
                <?= $Grid->status_payment->selectOptionListHtml("x{$Grid->RowIndex}_status_payment") ?>
            </select>
            <div class="invalid-feedback"><?= $Grid->status_payment->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fall_buyer_asset_schedulegrid", function() {
            var options = { name: "x<?= $Grid->RowIndex ?>_status_payment", selectId: "fall_buyer_asset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment" },
                el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
            options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
            if (fall_buyer_asset_schedulegrid.lists.status_payment.lookupOptions.length) {
                options.data = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fall_buyer_asset_schedulegrid" };
            } else {
                options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fall_buyer_asset_schedulegrid", limit: ew.LOOKUP_PAGE_SIZE };
            }
            options.minimumResultsForSearch = Infinity;
            options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.all_buyer_asset_schedule.fields.status_payment.selectOptions);
            ew.createSelect(options);
        });
        </script>
        </span>
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_status_payment" class="el_all_buyer_asset_schedule_status_payment">
        <span<?= $Grid->status_payment->viewAttributes() ?>>
        <?= $Grid->status_payment->getViewValue() ?></span>
        </span>
        <?php if ($Grid->isConfirm()) { ?>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_status_payment" data-hidden="1" name="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_status_payment" id="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->FormValue) ?>">
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_status_payment" data-hidden="1" name="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_status_payment" id="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
        <?php } ?>
        <?php } ?>
        </td>
    <?php } ?> -->

    <!-- <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
        <?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
        <?php } ?>
        <?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
        <span id="el<?= $Grid->RowCount ?>_all_buyer_asset_schedule_cdate" class="el_all_buyer_asset_schedule_cdate">
        <span<?= $Grid->cdate->viewAttributes() ?>>
        <?= $Grid->cdate->getViewValue() ?></span>
        </span>
        <?php if ($Grid->isConfirm()) { ?>
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_cdate" data-hidden="1" name="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_cdate" id="fall_buyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
        <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_cdate" data-hidden="1" name="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_cdate" id="fall_buyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
        <?php } ?>
        <?php } ?>
        </td>
    <?php } ?> -->
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fall_buyer_asset_schedulegrid","load"], () => fall_buyer_asset_schedulegrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_all_buyer_asset_schedule", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->num_installment->Visible) { // num_installment ?>
        <td data-name="num_installment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_num_installment" class="el_all_buyer_asset_schedule_num_installment">
<input type="<?= $Grid->num_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_num_installment" id="x<?= $Grid->RowIndex ?>_num_installment" data-table="all_buyer_asset_schedule" data-field="x_num_installment" value="<?= $Grid->num_installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->num_installment->getPlaceHolder()) ?>"<?= $Grid->num_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->num_installment->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_num_installment" class="el_all_buyer_asset_schedule_num_installment">
<span<?= $Grid->num_installment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->num_installment->getDisplayValue($Grid->num_installment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_num_installment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_num_installment" id="x<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_num_installment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_num_installment" id="o<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->installment_per_price->Visible) { // installment_per_price ?>
        <td data-name="installment_per_price">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_installment_per_price" class="el_all_buyer_asset_schedule_installment_per_price">
<input type="<?= $Grid->installment_per_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_per_price" id="x<?= $Grid->RowIndex ?>_installment_per_price" data-table="all_buyer_asset_schedule" data-field="x_installment_per_price" value="<?= $Grid->installment_per_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_per_price->getPlaceHolder()) ?>"<?= $Grid->installment_per_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->installment_per_price->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_installment_per_price" class="el_all_buyer_asset_schedule_installment_per_price">
<span<?= $Grid->installment_per_price->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->installment_per_price->getDisplayValue($Grid->installment_per_price->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_installment_per_price" data-hidden="1" name="x<?= $Grid->RowIndex ?>_installment_per_price" id="x<?= $Grid->RowIndex ?>_installment_per_price" value="<?= HtmlEncode($Grid->installment_per_price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_installment_per_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_installment_per_price" id="o<?= $Grid->RowIndex ?>_installment_per_price" value="<?= HtmlEncode($Grid->installment_per_price->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->interest->Visible) { // interest ?>
        <td data-name="interest">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_interest" class="el_all_buyer_asset_schedule_interest">
<input type="<?= $Grid->interest->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_interest" id="x<?= $Grid->RowIndex ?>_interest" data-table="all_buyer_asset_schedule" data-field="x_interest" value="<?= $Grid->interest->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Grid->interest->getPlaceHolder()) ?>"<?= $Grid->interest->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->interest->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_interest" class="el_all_buyer_asset_schedule_interest">
<span<?= $Grid->interest->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->interest->getDisplayValue($Grid->interest->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_interest" data-hidden="1" name="x<?= $Grid->RowIndex ?>_interest" id="x<?= $Grid->RowIndex ?>_interest" value="<?= HtmlEncode($Grid->interest->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_interest" data-hidden="1" name="o<?= $Grid->RowIndex ?>_interest" id="o<?= $Grid->RowIndex ?>_interest" value="<?= HtmlEncode($Grid->interest->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->principal->Visible) { // principal ?>
        <td data-name="principal">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_principal" class="el_all_buyer_asset_schedule_principal">
<input type="<?= $Grid->principal->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_principal" id="x<?= $Grid->RowIndex ?>_principal" data-table="all_buyer_asset_schedule" data-field="x_principal" value="<?= $Grid->principal->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Grid->principal->getPlaceHolder()) ?>"<?= $Grid->principal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->principal->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_principal" class="el_all_buyer_asset_schedule_principal">
<span<?= $Grid->principal->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->principal->getDisplayValue($Grid->principal->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_principal" data-hidden="1" name="x<?= $Grid->RowIndex ?>_principal" id="x<?= $Grid->RowIndex ?>_principal" value="<?= HtmlEncode($Grid->principal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_principal" data-hidden="1" name="o<?= $Grid->RowIndex ?>_principal" id="o<?= $Grid->RowIndex ?>_principal" value="<?= HtmlEncode($Grid->principal->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->remaining_principal->Visible) { // remaining_principal ?>
        <td data-name="remaining_principal">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_remaining_principal" class="el_all_buyer_asset_schedule_remaining_principal">
<input type="<?= $Grid->remaining_principal->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_remaining_principal" id="x<?= $Grid->RowIndex ?>_remaining_principal" data-table="all_buyer_asset_schedule" data-field="x_remaining_principal" value="<?= $Grid->remaining_principal->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Grid->remaining_principal->getPlaceHolder()) ?>"<?= $Grid->remaining_principal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->remaining_principal->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_remaining_principal" class="el_all_buyer_asset_schedule_remaining_principal">
<span<?= $Grid->remaining_principal->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->remaining_principal->getDisplayValue($Grid->remaining_principal->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_remaining_principal" data-hidden="1" name="x<?= $Grid->RowIndex ?>_remaining_principal" id="x<?= $Grid->RowIndex ?>_remaining_principal" value="<?= HtmlEncode($Grid->remaining_principal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_remaining_principal" data-hidden="1" name="o<?= $Grid->RowIndex ?>_remaining_principal" id="o<?= $Grid->RowIndex ?>_remaining_principal" value="<?= HtmlEncode($Grid->remaining_principal->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->pay_number->Visible) { // pay_number ?>
        <td data-name="pay_number">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_pay_number" class="el_all_buyer_asset_schedule_pay_number">
<input type="<?= $Grid->pay_number->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" data-table="all_buyer_asset_schedule" data-field="x_pay_number" value="<?= $Grid->pay_number->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->pay_number->getPlaceHolder()) ?>"<?= $Grid->pay_number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pay_number->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_pay_number" class="el_all_buyer_asset_schedule_pay_number">
<span<?= $Grid->pay_number->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pay_number->getDisplayValue($Grid->pay_number->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_pay_number" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_pay_number" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pay_number" id="o<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->expired_date->Visible) { // expired_date ?>
        <td data-name="expired_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_expired_date" class="el_all_buyer_asset_schedule_expired_date">
<input type="<?= $Grid->expired_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" data-table="all_buyer_asset_schedule" data-field="x_expired_date" value="<?= $Grid->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->expired_date->getPlaceHolder()) ?>"<?= $Grid->expired_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->expired_date->getErrorMessage() ?></div>
<?php if (!$Grid->expired_date->ReadOnly && !$Grid->expired_date->Disabled && !isset($Grid->expired_date->EditAttrs["readonly"]) && !isset($Grid->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fall_buyer_asset_schedulegrid", "datetimepicker"], function () {
    let options = {
        localization: {
            locale: ew.LANGUAGE_ID
        },
        display: {
            inputFormat: "<?= DateFormat(7) ?>",
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fall_buyer_asset_schedulegrid", "x<?= $Grid->RowIndex ?>_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_expired_date" class="el_all_buyer_asset_schedule_expired_date">
<span<?= $Grid->expired_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->expired_date->getDisplayValue($Grid->expired_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_expired_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_expired_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_expired_date" id="o<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_date_payment" class="el_all_buyer_asset_schedule_date_payment">
<input type="<?= $Grid->date_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" data-table="all_buyer_asset_schedule" data-field="x_date_payment" value="<?= $Grid->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_payment->getPlaceHolder()) ?>"<?= $Grid->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_payment->getErrorMessage() ?></div>
<?php if (!$Grid->date_payment->ReadOnly && !$Grid->date_payment->Disabled && !isset($Grid->date_payment->EditAttrs["readonly"]) && !isset($Grid->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fall_buyer_asset_schedulegrid", "datetimepicker"], function () {
    let options = {
        localization: {
            locale: ew.LANGUAGE_ID
        },
        display: {
            inputFormat: "<?= DateFormat(7) ?>",
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fall_buyer_asset_schedulegrid", "x<?= $Grid->RowIndex ?>_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_date_payment" class="el_all_buyer_asset_schedule_date_payment">
<span<?= $Grid->date_payment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->date_payment->getDisplayValue($Grid->date_payment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_date_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_date_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_payment" id="o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_status_payment" class="el_all_buyer_asset_schedule_status_payment">
    <select
        id="x<?= $Grid->RowIndex ?>_status_payment"
        name="x<?= $Grid->RowIndex ?>_status_payment"
        class="form-select ew-select<?= $Grid->status_payment->isInvalidClass() ?>"
        data-select2-id="fall_buyer_asset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment"
        data-table="all_buyer_asset_schedule"
        data-field="x_status_payment"
        data-value-separator="<?= $Grid->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_payment->getPlaceHolder()) ?>"
        <?= $Grid->status_payment->editAttributes() ?>>
        <?= $Grid->status_payment->selectOptionListHtml("x{$Grid->RowIndex}_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_payment->getErrorMessage() ?></div>
<script>
loadjs.ready("fall_buyer_asset_schedulegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_payment", selectId: "fall_buyer_asset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fall_buyer_asset_schedulegrid.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fall_buyer_asset_schedulegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fall_buyer_asset_schedulegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.all_buyer_asset_schedule.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_status_payment" class="el_all_buyer_asset_schedule_status_payment">
<span<?= $Grid->status_payment->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_payment->getDisplayValue($Grid->status_payment->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_status_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_payment" id="x<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_status_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_payment" id="o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_all_buyer_asset_schedule_cdate" class="el_all_buyer_asset_schedule_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fall_buyer_asset_schedulegrid","load"], () => fall_buyer_asset_schedulegrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fall_buyer_asset_schedulegrid">
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
    ew.addEventHandlers("all_buyer_asset_schedule");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    var rowCount = $('#tbl_buyer_all_asset_rentlist >tbody >tr').length;
    if(rowCount >= 1){
        $(".ew-add-edit-option").remove()
    }

//     $('input').on('all', function () {
//     $(this)
//         .trigger('blur')
//         .trigger('change')
//         .trigger('click')
//         .trigger('dblclick')
//         .trigger('focus')
//         .trigger('hover');
// });
// $('input').trigger('all');

});
</script>
<?php if (!$Grid->isExport()) { ?>
<script>
loadjs.ready("fixedheadertable", function () {
    ew.fixedHeaderTable({
        delay: 0,
        container: "gmp_all_buyer_asset_schedule",
        width: "100%",
        height: "500px"
    });
});

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$("input").trigger("change");

</script>
<?php } ?>
<?php } ?>
