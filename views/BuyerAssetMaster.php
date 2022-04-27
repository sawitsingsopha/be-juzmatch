<?php

namespace PHPMaker2022\juzmatch;

// Table
$buyer_asset = Container("buyer_asset");
?>
<?php if ($buyer_asset->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_buyer_assetmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($buyer_asset->asset_id->Visible) { // asset_id ?>
        <tr id="r_asset_id"<?= $buyer_asset->asset_id->rowAttributes() ?>>
            <td class="<?= $buyer_asset->TableLeftColumnClass ?>"><?= $buyer_asset->asset_id->caption() ?></td>
            <td<?= $buyer_asset->asset_id->cellAttributes() ?>>
<span id="el_buyer_asset_asset_id">
<span<?= $buyer_asset->asset_id->viewAttributes() ?>>
<?= $buyer_asset->asset_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_asset->booking_price->Visible) { // booking_price ?>
        <tr id="r_booking_price"<?= $buyer_asset->booking_price->rowAttributes() ?>>
            <td class="<?= $buyer_asset->TableLeftColumnClass ?>"><?= $buyer_asset->booking_price->caption() ?></td>
            <td<?= $buyer_asset->booking_price->cellAttributes() ?>>
<span id="el_buyer_asset_booking_price">
<span<?= $buyer_asset->booking_price->viewAttributes() ?>>
<?= $buyer_asset->booking_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_asset->pay_number->Visible) { // pay_number ?>
        <tr id="r_pay_number"<?= $buyer_asset->pay_number->rowAttributes() ?>>
            <td class="<?= $buyer_asset->TableLeftColumnClass ?>"><?= $buyer_asset->pay_number->caption() ?></td>
            <td<?= $buyer_asset->pay_number->cellAttributes() ?>>
<span id="el_buyer_asset_pay_number">
<span<?= $buyer_asset->pay_number->viewAttributes() ?>>
<?= $buyer_asset->pay_number->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_asset->status_payment->Visible) { // status_payment ?>
        <tr id="r_status_payment"<?= $buyer_asset->status_payment->rowAttributes() ?>>
            <td class="<?= $buyer_asset->TableLeftColumnClass ?>"><?= $buyer_asset->status_payment->caption() ?></td>
            <td<?= $buyer_asset->status_payment->cellAttributes() ?>>
<span id="el_buyer_asset_status_payment">
<span<?= $buyer_asset->status_payment->viewAttributes() ?>>
<?= $buyer_asset->status_payment->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_asset->date_booking->Visible) { // date_booking ?>
        <tr id="r_date_booking"<?= $buyer_asset->date_booking->rowAttributes() ?>>
            <td class="<?= $buyer_asset->TableLeftColumnClass ?>"><?= $buyer_asset->date_booking->caption() ?></td>
            <td<?= $buyer_asset->date_booking->cellAttributes() ?>>
<span id="el_buyer_asset_date_booking">
<span<?= $buyer_asset->date_booking->viewAttributes() ?>>
<?= $buyer_asset->date_booking->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_asset->date_payment->Visible) { // date_payment ?>
        <tr id="r_date_payment"<?= $buyer_asset->date_payment->rowAttributes() ?>>
            <td class="<?= $buyer_asset->TableLeftColumnClass ?>"><?= $buyer_asset->date_payment->caption() ?></td>
            <td<?= $buyer_asset->date_payment->cellAttributes() ?>>
<span id="el_buyer_asset_date_payment">
<span<?= $buyer_asset->date_payment->viewAttributes() ?>>
<?= $buyer_asset->date_payment->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_asset->due_date->Visible) { // due_date ?>
        <tr id="r_due_date"<?= $buyer_asset->due_date->rowAttributes() ?>>
            <td class="<?= $buyer_asset->TableLeftColumnClass ?>"><?= $buyer_asset->due_date->caption() ?></td>
            <td<?= $buyer_asset->due_date->cellAttributes() ?>>
<span id="el_buyer_asset_due_date">
<span<?= $buyer_asset->due_date->viewAttributes() ?>>
<?= $buyer_asset->due_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_asset->cdate->Visible) { // cdate ?>
        <tr id="r_cdate"<?= $buyer_asset->cdate->rowAttributes() ?>>
            <td class="<?= $buyer_asset->TableLeftColumnClass ?>"><?= $buyer_asset->cdate->caption() ?></td>
            <td<?= $buyer_asset->cdate->cellAttributes() ?>>
<span id="el_buyer_asset_cdate">
<span<?= $buyer_asset->cdate->viewAttributes() ?>>
<?= $buyer_asset->cdate->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_asset->status_expire->Visible) { // status_expire ?>
        <tr id="r_status_expire"<?= $buyer_asset->status_expire->rowAttributes() ?>>
            <td class="<?= $buyer_asset->TableLeftColumnClass ?>"><?= $buyer_asset->status_expire->caption() ?></td>
            <td<?= $buyer_asset->status_expire->cellAttributes() ?>>
<span id="el_buyer_asset_status_expire">
<span<?= $buyer_asset->status_expire->viewAttributes() ?>>
<?= $buyer_asset->status_expire->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer_asset->status_expire_reason->Visible) { // status_expire_reason ?>
        <tr id="r_status_expire_reason"<?= $buyer_asset->status_expire_reason->rowAttributes() ?>>
            <td class="<?= $buyer_asset->TableLeftColumnClass ?>"><?= $buyer_asset->status_expire_reason->caption() ?></td>
            <td<?= $buyer_asset->status_expire_reason->cellAttributes() ?>>
<span id="el_buyer_asset_status_expire_reason">
<span<?= $buyer_asset->status_expire_reason->viewAttributes() ?>>
<?= $buyer_asset->status_expire_reason->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
