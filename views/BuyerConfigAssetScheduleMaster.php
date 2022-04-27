<?php

namespace PHPMaker2022\juzmatch;

// Table
$buyer_config_asset_schedule = Container("buyer_config_asset_schedule");
?>
<?php if ($buyer_config_asset_schedule->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_buyer_config_asset_schedulemaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($buyer_config_asset_schedule->installment_all->Visible) { // installment_all ?>
        <tr id="r_installment_all"<?= $buyer_config_asset_schedule->installment_all->rowAttributes() ?>>
            <td class="<?= $buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $buyer_config_asset_schedule->installment_all->caption() ?></td>
            <td<?= $buyer_config_asset_schedule->installment_all->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_installment_all">
<span<?= $buyer_config_asset_schedule->installment_all->viewAttributes() ?>>
<?= $buyer_config_asset_schedule->installment_all->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_config_asset_schedule->installment_price_per->Visible) { // installment_price_per ?>
        <tr id="r_installment_price_per"<?= $buyer_config_asset_schedule->installment_price_per->rowAttributes() ?>>
            <td class="<?= $buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $buyer_config_asset_schedule->installment_price_per->caption() ?></td>
            <td<?= $buyer_config_asset_schedule->installment_price_per->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_installment_price_per">
<span<?= $buyer_config_asset_schedule->installment_price_per->viewAttributes() ?>>
<?= $buyer_config_asset_schedule->installment_price_per->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_config_asset_schedule->date_start_installment->Visible) { // date_start_installment ?>
        <tr id="r_date_start_installment"<?= $buyer_config_asset_schedule->date_start_installment->rowAttributes() ?>>
            <td class="<?= $buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $buyer_config_asset_schedule->date_start_installment->caption() ?></td>
            <td<?= $buyer_config_asset_schedule->date_start_installment->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_date_start_installment">
<span<?= $buyer_config_asset_schedule->date_start_installment->viewAttributes() ?>>
<?= $buyer_config_asset_schedule->date_start_installment->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_config_asset_schedule->status_approve->Visible) { // status_approve ?>
        <tr id="r_status_approve"<?= $buyer_config_asset_schedule->status_approve->rowAttributes() ?>>
            <td class="<?= $buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $buyer_config_asset_schedule->status_approve->caption() ?></td>
            <td<?= $buyer_config_asset_schedule->status_approve->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_status_approve">
<span<?= $buyer_config_asset_schedule->status_approve->viewAttributes() ?>>
<?= $buyer_config_asset_schedule->status_approve->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_config_asset_schedule->asset_price->Visible) { // asset_price ?>
        <tr id="r_asset_price"<?= $buyer_config_asset_schedule->asset_price->rowAttributes() ?>>
            <td class="<?= $buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $buyer_config_asset_schedule->asset_price->caption() ?></td>
            <td<?= $buyer_config_asset_schedule->asset_price->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_asset_price">
<span<?= $buyer_config_asset_schedule->asset_price->viewAttributes() ?>>
<?= $buyer_config_asset_schedule->asset_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_config_asset_schedule->booking_price->Visible) { // booking_price ?>
        <tr id="r_booking_price"<?= $buyer_config_asset_schedule->booking_price->rowAttributes() ?>>
            <td class="<?= $buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $buyer_config_asset_schedule->booking_price->caption() ?></td>
            <td<?= $buyer_config_asset_schedule->booking_price->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_booking_price">
<span<?= $buyer_config_asset_schedule->booking_price->viewAttributes() ?>>
<?= $buyer_config_asset_schedule->booking_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_config_asset_schedule->down_price->Visible) { // down_price ?>
        <tr id="r_down_price"<?= $buyer_config_asset_schedule->down_price->rowAttributes() ?>>
            <td class="<?= $buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $buyer_config_asset_schedule->down_price->caption() ?></td>
            <td<?= $buyer_config_asset_schedule->down_price->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_down_price">
<span<?= $buyer_config_asset_schedule->down_price->viewAttributes() ?>>
<?= $buyer_config_asset_schedule->down_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_config_asset_schedule->move_in_on_20th->Visible) { // move_in_on_20th ?>
        <tr id="r_move_in_on_20th"<?= $buyer_config_asset_schedule->move_in_on_20th->rowAttributes() ?>>
            <td class="<?= $buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $buyer_config_asset_schedule->move_in_on_20th->caption() ?></td>
            <td<?= $buyer_config_asset_schedule->move_in_on_20th->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_move_in_on_20th">
<span<?= $buyer_config_asset_schedule->move_in_on_20th->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_move_in_on_20th_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $buyer_config_asset_schedule->move_in_on_20th->getViewValue() ?>" disabled<?php if (ConvertToBool($buyer_config_asset_schedule->move_in_on_20th->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_move_in_on_20th_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_config_asset_schedule->number_days_pay_first_month->Visible) { // number_days_pay_first_month ?>
        <tr id="r_number_days_pay_first_month"<?= $buyer_config_asset_schedule->number_days_pay_first_month->rowAttributes() ?>>
            <td class="<?= $buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $buyer_config_asset_schedule->number_days_pay_first_month->caption() ?></td>
            <td<?= $buyer_config_asset_schedule->number_days_pay_first_month->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_number_days_pay_first_month">
<span<?= $buyer_config_asset_schedule->number_days_pay_first_month->viewAttributes() ?>>
<?= $buyer_config_asset_schedule->number_days_pay_first_month->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_config_asset_schedule->number_days_in_first_month->Visible) { // number_days_in_first_month ?>
        <tr id="r_number_days_in_first_month"<?= $buyer_config_asset_schedule->number_days_in_first_month->rowAttributes() ?>>
            <td class="<?= $buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $buyer_config_asset_schedule->number_days_in_first_month->caption() ?></td>
            <td<?= $buyer_config_asset_schedule->number_days_in_first_month->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_number_days_in_first_month">
<span<?= $buyer_config_asset_schedule->number_days_in_first_month->viewAttributes() ?>>
<?= $buyer_config_asset_schedule->number_days_in_first_month->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_config_asset_schedule->cdate->Visible) { // cdate ?>
        <tr id="r_cdate"<?= $buyer_config_asset_schedule->cdate->rowAttributes() ?>>
            <td class="<?= $buyer_config_asset_schedule->TableLeftColumnClass ?>"><?= $buyer_config_asset_schedule->cdate->caption() ?></td>
            <td<?= $buyer_config_asset_schedule->cdate->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_cdate">
<span<?= $buyer_config_asset_schedule->cdate->viewAttributes() ?>>
<?= $buyer_config_asset_schedule->cdate->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
