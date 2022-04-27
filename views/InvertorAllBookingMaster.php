<?php

namespace PHPMaker2022\juzmatch;

// Table
$invertor_all_booking = Container("invertor_all_booking");
?>
<?php if ($invertor_all_booking->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_invertor_all_bookingmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($invertor_all_booking->asset_id->Visible) { // asset_id ?>
        <tr id="r_asset_id"<?= $invertor_all_booking->asset_id->rowAttributes() ?>>
            <td class="<?= $invertor_all_booking->TableLeftColumnClass ?>"><?= $invertor_all_booking->asset_id->caption() ?></td>
            <td<?= $invertor_all_booking->asset_id->cellAttributes() ?>>
<span id="el_invertor_all_booking_asset_id">
<span<?= $invertor_all_booking->asset_id->viewAttributes() ?>>
<?= $invertor_all_booking->asset_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invertor_all_booking->member_id->Visible) { // member_id ?>
        <tr id="r_member_id"<?= $invertor_all_booking->member_id->rowAttributes() ?>>
            <td class="<?= $invertor_all_booking->TableLeftColumnClass ?>"><?= $invertor_all_booking->member_id->caption() ?></td>
            <td<?= $invertor_all_booking->member_id->cellAttributes() ?>>
<span id="el_invertor_all_booking_member_id">
<span<?= $invertor_all_booking->member_id->viewAttributes() ?>>
<?= $invertor_all_booking->member_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invertor_all_booking->date_booking->Visible) { // date_booking ?>
        <tr id="r_date_booking"<?= $invertor_all_booking->date_booking->rowAttributes() ?>>
            <td class="<?= $invertor_all_booking->TableLeftColumnClass ?>"><?= $invertor_all_booking->date_booking->caption() ?></td>
            <td<?= $invertor_all_booking->date_booking->cellAttributes() ?>>
<span id="el_invertor_all_booking_date_booking">
<span<?= $invertor_all_booking->date_booking->viewAttributes() ?>>
<?= $invertor_all_booking->date_booking->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invertor_all_booking->status_expire->Visible) { // status_expire ?>
        <tr id="r_status_expire"<?= $invertor_all_booking->status_expire->rowAttributes() ?>>
            <td class="<?= $invertor_all_booking->TableLeftColumnClass ?>"><?= $invertor_all_booking->status_expire->caption() ?></td>
            <td<?= $invertor_all_booking->status_expire->cellAttributes() ?>>
<span id="el_invertor_all_booking_status_expire">
<span<?= $invertor_all_booking->status_expire->viewAttributes() ?>>
<?= $invertor_all_booking->status_expire->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invertor_all_booking->status_expire_reason->Visible) { // status_expire_reason ?>
        <tr id="r_status_expire_reason"<?= $invertor_all_booking->status_expire_reason->rowAttributes() ?>>
            <td class="<?= $invertor_all_booking->TableLeftColumnClass ?>"><?= $invertor_all_booking->status_expire_reason->caption() ?></td>
            <td<?= $invertor_all_booking->status_expire_reason->cellAttributes() ?>>
<span id="el_invertor_all_booking_status_expire_reason">
<span<?= $invertor_all_booking->status_expire_reason->viewAttributes() ?>>
<?= $invertor_all_booking->status_expire_reason->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invertor_all_booking->payment_status->Visible) { // payment_status ?>
        <tr id="r_payment_status"<?= $invertor_all_booking->payment_status->rowAttributes() ?>>
            <td class="<?= $invertor_all_booking->TableLeftColumnClass ?>"><?= $invertor_all_booking->payment_status->caption() ?></td>
            <td<?= $invertor_all_booking->payment_status->cellAttributes() ?>>
<span id="el_invertor_all_booking_payment_status">
<span<?= $invertor_all_booking->payment_status->viewAttributes() ?>>
<?= $invertor_all_booking->payment_status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
