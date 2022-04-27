<?php

namespace PHPMaker2022\juzmatch;

// Table
$invertor_booking = Container("invertor_booking");
?>
<?php if ($invertor_booking->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_invertor_bookingmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($invertor_booking->asset_id->Visible) { // asset_id ?>
        <tr id="r_asset_id"<?= $invertor_booking->asset_id->rowAttributes() ?>>
            <td class="<?= $invertor_booking->TableLeftColumnClass ?>"><?= $invertor_booking->asset_id->caption() ?></td>
            <td<?= $invertor_booking->asset_id->cellAttributes() ?>>
<span id="el_invertor_booking_asset_id">
<span<?= $invertor_booking->asset_id->viewAttributes() ?>>
<?= $invertor_booking->asset_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invertor_booking->date_booking->Visible) { // date_booking ?>
        <tr id="r_date_booking"<?= $invertor_booking->date_booking->rowAttributes() ?>>
            <td class="<?= $invertor_booking->TableLeftColumnClass ?>"><?= $invertor_booking->date_booking->caption() ?></td>
            <td<?= $invertor_booking->date_booking->cellAttributes() ?>>
<span id="el_invertor_booking_date_booking">
<span<?= $invertor_booking->date_booking->viewAttributes() ?>>
<?= $invertor_booking->date_booking->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invertor_booking->status_expire->Visible) { // status_expire ?>
        <tr id="r_status_expire"<?= $invertor_booking->status_expire->rowAttributes() ?>>
            <td class="<?= $invertor_booking->TableLeftColumnClass ?>"><?= $invertor_booking->status_expire->caption() ?></td>
            <td<?= $invertor_booking->status_expire->cellAttributes() ?>>
<span id="el_invertor_booking_status_expire">
<span<?= $invertor_booking->status_expire->viewAttributes() ?>>
<?= $invertor_booking->status_expire->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invertor_booking->status_expire_reason->Visible) { // status_expire_reason ?>
        <tr id="r_status_expire_reason"<?= $invertor_booking->status_expire_reason->rowAttributes() ?>>
            <td class="<?= $invertor_booking->TableLeftColumnClass ?>"><?= $invertor_booking->status_expire_reason->caption() ?></td>
            <td<?= $invertor_booking->status_expire_reason->cellAttributes() ?>>
<span id="el_invertor_booking_status_expire_reason">
<span<?= $invertor_booking->status_expire_reason->viewAttributes() ?>>
<?= $invertor_booking->status_expire_reason->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invertor_booking->payment_status->Visible) { // payment_status ?>
        <tr id="r_payment_status"<?= $invertor_booking->payment_status->rowAttributes() ?>>
            <td class="<?= $invertor_booking->TableLeftColumnClass ?>"><?= $invertor_booking->payment_status->caption() ?></td>
            <td<?= $invertor_booking->payment_status->cellAttributes() ?>>
<span id="el_invertor_booking_payment_status">
<span<?= $invertor_booking->payment_status->viewAttributes() ?>>
<?= $invertor_booking->payment_status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invertor_booking->is_email->Visible) { // is_email ?>
        <tr id="r_is_email"<?= $invertor_booking->is_email->rowAttributes() ?>>
            <td class="<?= $invertor_booking->TableLeftColumnClass ?>"><?= $invertor_booking->is_email->caption() ?></td>
            <td<?= $invertor_booking->is_email->cellAttributes() ?>>
<span id="el_invertor_booking_is_email">
<span<?= $invertor_booking->is_email->viewAttributes() ?>>
<?= $invertor_booking->is_email->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invertor_booking->receipt_status->Visible) { // receipt_status ?>
        <tr id="r_receipt_status"<?= $invertor_booking->receipt_status->rowAttributes() ?>>
            <td class="<?= $invertor_booking->TableLeftColumnClass ?>"><?= $invertor_booking->receipt_status->caption() ?></td>
            <td<?= $invertor_booking->receipt_status->cellAttributes() ?>>
<span id="el_invertor_booking_receipt_status">
<span<?= $invertor_booking->receipt_status->viewAttributes() ?>>
<?= $invertor_booking->receipt_status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
