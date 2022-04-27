<?php

namespace PHPMaker2022\juzmatch;

// Table
$all_buyer_config_asset_schedule = Container("all_buyer_config_asset_schedule");
?>
<?php if ($all_buyer_config_asset_schedule->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_all_buyer_config_asset_schedulemaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($all_buyer_config_asset_schedule->installment_all->Visible) { // installment_all ?>
        <tr id="r_installment_all"<?= $all_buyer_config_asset_schedule->installment_all->rowAttributes() ?>>
            <td class="<?= $all_buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $all_buyer_config_asset_schedule->installment_all->caption() ?></td>
            <td<?= $all_buyer_config_asset_schedule->installment_all->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_installment_all">
<span<?= $all_buyer_config_asset_schedule->installment_all->viewAttributes() ?>>
<?= $all_buyer_config_asset_schedule->installment_all->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($all_buyer_config_asset_schedule->asset_price->Visible) { // asset_price ?>
        <tr id="r_asset_price"<?= $all_buyer_config_asset_schedule->asset_price->rowAttributes() ?>>
            <td class="<?= $all_buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $all_buyer_config_asset_schedule->asset_price->caption() ?></td>
            <td<?= $all_buyer_config_asset_schedule->asset_price->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_asset_price">
<span<?= $all_buyer_config_asset_schedule->asset_price->viewAttributes() ?>>
<?= $all_buyer_config_asset_schedule->asset_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($all_buyer_config_asset_schedule->booking_price->Visible) { // booking_price ?>
        <tr id="r_booking_price"<?= $all_buyer_config_asset_schedule->booking_price->rowAttributes() ?>>
            <td class="<?= $all_buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $all_buyer_config_asset_schedule->booking_price->caption() ?></td>
            <td<?= $all_buyer_config_asset_schedule->booking_price->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_booking_price">
<span<?= $all_buyer_config_asset_schedule->booking_price->viewAttributes() ?>>
<?= $all_buyer_config_asset_schedule->booking_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($all_buyer_config_asset_schedule->down_price->Visible) { // down_price ?>
        <tr id="r_down_price"<?= $all_buyer_config_asset_schedule->down_price->rowAttributes() ?>>
            <td class="<?= $all_buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $all_buyer_config_asset_schedule->down_price->caption() ?></td>
            <td<?= $all_buyer_config_asset_schedule->down_price->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_down_price">
<span<?= $all_buyer_config_asset_schedule->down_price->viewAttributes() ?>>
<?= $all_buyer_config_asset_schedule->down_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($all_buyer_config_asset_schedule->installment_price_per->Visible) { // installment_price_per ?>
        <tr id="r_installment_price_per"<?= $all_buyer_config_asset_schedule->installment_price_per->rowAttributes() ?>>
            <td class="<?= $all_buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $all_buyer_config_asset_schedule->installment_price_per->caption() ?></td>
            <td<?= $all_buyer_config_asset_schedule->installment_price_per->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_installment_price_per">
<span<?= $all_buyer_config_asset_schedule->installment_price_per->viewAttributes() ?>>
<?= $all_buyer_config_asset_schedule->installment_price_per->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($all_buyer_config_asset_schedule->annual_interest->Visible) { // annual_interest ?>
        <tr id="r_annual_interest"<?= $all_buyer_config_asset_schedule->annual_interest->rowAttributes() ?>>
            <td class="<?= $all_buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $all_buyer_config_asset_schedule->annual_interest->caption() ?></td>
            <td<?= $all_buyer_config_asset_schedule->annual_interest->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_annual_interest">
<span<?= $all_buyer_config_asset_schedule->annual_interest->viewAttributes() ?>>
<?= $all_buyer_config_asset_schedule->annual_interest->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($all_buyer_config_asset_schedule->number_days_pay_first_month->Visible) { // number_days_pay_first_month ?>
        <tr id="r_number_days_pay_first_month"<?= $all_buyer_config_asset_schedule->number_days_pay_first_month->rowAttributes() ?>>
            <td class="<?= $all_buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $all_buyer_config_asset_schedule->number_days_pay_first_month->caption() ?></td>
            <td<?= $all_buyer_config_asset_schedule->number_days_pay_first_month->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_number_days_pay_first_month">
<span<?= $all_buyer_config_asset_schedule->number_days_pay_first_month->viewAttributes() ?>>
<?= $all_buyer_config_asset_schedule->number_days_pay_first_month->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($all_buyer_config_asset_schedule->number_days_in_first_month->Visible) { // number_days_in_first_month ?>
        <tr id="r_number_days_in_first_month"<?= $all_buyer_config_asset_schedule->number_days_in_first_month->rowAttributes() ?>>
            <td class="<?= $all_buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $all_buyer_config_asset_schedule->number_days_in_first_month->caption() ?></td>
            <td<?= $all_buyer_config_asset_schedule->number_days_in_first_month->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_number_days_in_first_month">
<span<?= $all_buyer_config_asset_schedule->number_days_in_first_month->viewAttributes() ?>>
<?= $all_buyer_config_asset_schedule->number_days_in_first_month->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($all_buyer_config_asset_schedule->move_in_on_20th->Visible) { // move_in_on_20th ?>
        <tr id="r_move_in_on_20th"<?= $all_buyer_config_asset_schedule->move_in_on_20th->rowAttributes() ?>>
            <td class="<?= $all_buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $all_buyer_config_asset_schedule->move_in_on_20th->caption() ?></td>
            <td<?= $all_buyer_config_asset_schedule->move_in_on_20th->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_move_in_on_20th">
<span<?= $all_buyer_config_asset_schedule->move_in_on_20th->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_move_in_on_20th_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $all_buyer_config_asset_schedule->move_in_on_20th->getViewValue() ?>" disabled<?php if (ConvertToBool($all_buyer_config_asset_schedule->move_in_on_20th->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_move_in_on_20th_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($all_buyer_config_asset_schedule->date_start_installment->Visible) { // date_start_installment ?>
        <tr id="r_date_start_installment"<?= $all_buyer_config_asset_schedule->date_start_installment->rowAttributes() ?>>
            <td class="<?= $all_buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $all_buyer_config_asset_schedule->date_start_installment->caption() ?></td>
            <td<?= $all_buyer_config_asset_schedule->date_start_installment->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_date_start_installment">
<span<?= $all_buyer_config_asset_schedule->date_start_installment->viewAttributes() ?>>
<?= $all_buyer_config_asset_schedule->date_start_installment->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($all_buyer_config_asset_schedule->status_approve->Visible) { // status_approve ?>
        <tr id="r_status_approve"<?= $all_buyer_config_asset_schedule->status_approve->rowAttributes() ?>>
            <td class="<?= $all_buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $all_buyer_config_asset_schedule->status_approve->caption() ?></td>
            <td<?= $all_buyer_config_asset_schedule->status_approve->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_status_approve">
<span<?= $all_buyer_config_asset_schedule->status_approve->viewAttributes() ?>>
<?= $all_buyer_config_asset_schedule->status_approve->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($all_buyer_config_asset_schedule->cdate->Visible) { // cdate ?>
        <tr id="r_cdate"<?= $all_buyer_config_asset_schedule->cdate->rowAttributes() ?>>
            <td class="<?= $all_buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $all_buyer_config_asset_schedule->cdate->caption() ?></td>
            <td<?= $all_buyer_config_asset_schedule->cdate->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_cdate">
<span<?= $all_buyer_config_asset_schedule->cdate->viewAttributes() ?>>
<?= $all_buyer_config_asset_schedule->cdate->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
