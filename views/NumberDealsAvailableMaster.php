<?php

namespace PHPMaker2022\juzmatch;

// Table
$number_deals_available = Container("number_deals_available");
?>
<?php if ($number_deals_available->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_number_deals_availablemaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($number_deals_available->asset_code->Visible) { // asset_code ?>
        <tr id="r_asset_code"<?= $number_deals_available->asset_code->rowAttributes() ?>>
            <td class="<?= $number_deals_available->TableLeftColumnClass ?>"><?= $number_deals_available->asset_code->caption() ?></td>
            <td<?= $number_deals_available->asset_code->cellAttributes() ?>>
<span id="el_number_deals_available_asset_code">
<span<?= $number_deals_available->asset_code->viewAttributes() ?>>
<?= $number_deals_available->asset_code->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_deals_available->_title->Visible) { // title ?>
        <tr id="r__title"<?= $number_deals_available->_title->rowAttributes() ?>>
            <td class="<?= $number_deals_available->TableLeftColumnClass ?>"><?= $number_deals_available->_title->caption() ?></td>
            <td<?= $number_deals_available->_title->cellAttributes() ?>>
<span id="el_number_deals_available__title">
<span<?= $number_deals_available->_title->viewAttributes() ?>>
<?= $number_deals_available->_title->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_deals_available->asset_price->Visible) { // asset_price ?>
        <tr id="r_asset_price"<?= $number_deals_available->asset_price->rowAttributes() ?>>
            <td class="<?= $number_deals_available->TableLeftColumnClass ?>"><?= $number_deals_available->asset_price->caption() ?></td>
            <td<?= $number_deals_available->asset_price->cellAttributes() ?>>
<span id="el_number_deals_available_asset_price">
<span<?= $number_deals_available->asset_price->viewAttributes() ?>>
<?= $number_deals_available->asset_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_deals_available->price_paid->Visible) { // price_paid ?>
        <tr id="r_price_paid"<?= $number_deals_available->price_paid->rowAttributes() ?>>
            <td class="<?= $number_deals_available->TableLeftColumnClass ?>"><?= $number_deals_available->price_paid->caption() ?></td>
            <td<?= $number_deals_available->price_paid->cellAttributes() ?>>
<span id="el_number_deals_available_price_paid">
<span<?= $number_deals_available->price_paid->viewAttributes() ?>>
<?= $number_deals_available->price_paid->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_deals_available->remaining_price->Visible) { // remaining_price ?>
        <tr id="r_remaining_price"<?= $number_deals_available->remaining_price->rowAttributes() ?>>
            <td class="<?= $number_deals_available->TableLeftColumnClass ?>"><?= $number_deals_available->remaining_price->caption() ?></td>
            <td<?= $number_deals_available->remaining_price->cellAttributes() ?>>
<span id="el_number_deals_available_remaining_price">
<span<?= $number_deals_available->remaining_price->viewAttributes() ?>>
<?= $number_deals_available->remaining_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_deals_available->expiration_date->Visible) { // expiration_date ?>
        <tr id="r_expiration_date"<?= $number_deals_available->expiration_date->rowAttributes() ?>>
            <td class="<?= $number_deals_available->TableLeftColumnClass ?>"><?= $number_deals_available->expiration_date->caption() ?></td>
            <td<?= $number_deals_available->expiration_date->cellAttributes() ?>>
<span id="el_number_deals_available_expiration_date">
<span<?= $number_deals_available->expiration_date->viewAttributes() ?>>
<?= $number_deals_available->expiration_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_deals_available->accrued_period_diff->Visible) { // accrued_period_diff ?>
        <tr id="r_accrued_period_diff"<?= $number_deals_available->accrued_period_diff->rowAttributes() ?>>
            <td class="<?= $number_deals_available->TableLeftColumnClass ?>"><?= $number_deals_available->accrued_period_diff->caption() ?></td>
            <td<?= $number_deals_available->accrued_period_diff->cellAttributes() ?>>
<span id="el_number_deals_available_accrued_period_diff">
<span<?= $number_deals_available->accrued_period_diff->viewAttributes() ?>>
<?= $number_deals_available->accrued_period_diff->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
