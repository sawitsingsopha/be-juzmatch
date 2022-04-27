<?php

namespace PHPMaker2022\juzmatch;

// Table
$number_of_unpaid_units = Container("number_of_unpaid_units");
?>
<?php if ($number_of_unpaid_units->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_number_of_unpaid_unitsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($number_of_unpaid_units->asset_code->Visible) { // asset_code ?>
        <tr id="r_asset_code"<?= $number_of_unpaid_units->asset_code->rowAttributes() ?>>
            <td class="<?= $number_of_unpaid_units->TableLeftColumnClass ?>"><?= $number_of_unpaid_units->asset_code->caption() ?></td>
            <td<?= $number_of_unpaid_units->asset_code->cellAttributes() ?>>
<span id="el_number_of_unpaid_units_asset_code">
<span<?= $number_of_unpaid_units->asset_code->viewAttributes() ?>>
<?= $number_of_unpaid_units->asset_code->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_of_unpaid_units->_title->Visible) { // title ?>
        <tr id="r__title"<?= $number_of_unpaid_units->_title->rowAttributes() ?>>
            <td class="<?= $number_of_unpaid_units->TableLeftColumnClass ?>"><?= $number_of_unpaid_units->_title->caption() ?></td>
            <td<?= $number_of_unpaid_units->_title->cellAttributes() ?>>
<span id="el_number_of_unpaid_units__title">
<span<?= $number_of_unpaid_units->_title->viewAttributes() ?>>
<?= $number_of_unpaid_units->_title->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_of_unpaid_units->asset_price->Visible) { // asset_price ?>
        <tr id="r_asset_price"<?= $number_of_unpaid_units->asset_price->rowAttributes() ?>>
            <td class="<?= $number_of_unpaid_units->TableLeftColumnClass ?>"><?= $number_of_unpaid_units->asset_price->caption() ?></td>
            <td<?= $number_of_unpaid_units->asset_price->cellAttributes() ?>>
<span id="el_number_of_unpaid_units_asset_price">
<span<?= $number_of_unpaid_units->asset_price->viewAttributes() ?>>
<?= $number_of_unpaid_units->asset_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_of_unpaid_units->price_paid->Visible) { // price_paid ?>
        <tr id="r_price_paid"<?= $number_of_unpaid_units->price_paid->rowAttributes() ?>>
            <td class="<?= $number_of_unpaid_units->TableLeftColumnClass ?>"><?= $number_of_unpaid_units->price_paid->caption() ?></td>
            <td<?= $number_of_unpaid_units->price_paid->cellAttributes() ?>>
<span id="el_number_of_unpaid_units_price_paid">
<span<?= $number_of_unpaid_units->price_paid->viewAttributes() ?>>
<?= $number_of_unpaid_units->price_paid->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_of_unpaid_units->remaining_price->Visible) { // remaining_price ?>
        <tr id="r_remaining_price"<?= $number_of_unpaid_units->remaining_price->rowAttributes() ?>>
            <td class="<?= $number_of_unpaid_units->TableLeftColumnClass ?>"><?= $number_of_unpaid_units->remaining_price->caption() ?></td>
            <td<?= $number_of_unpaid_units->remaining_price->cellAttributes() ?>>
<span id="el_number_of_unpaid_units_remaining_price">
<span<?= $number_of_unpaid_units->remaining_price->viewAttributes() ?>>
<?= $number_of_unpaid_units->remaining_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_of_unpaid_units->expiration_date->Visible) { // expiration_date ?>
        <tr id="r_expiration_date"<?= $number_of_unpaid_units->expiration_date->rowAttributes() ?>>
            <td class="<?= $number_of_unpaid_units->TableLeftColumnClass ?>"><?= $number_of_unpaid_units->expiration_date->caption() ?></td>
            <td<?= $number_of_unpaid_units->expiration_date->cellAttributes() ?>>
<span id="el_number_of_unpaid_units_expiration_date">
<span<?= $number_of_unpaid_units->expiration_date->viewAttributes() ?>>
<?= $number_of_unpaid_units->expiration_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_of_unpaid_units->accrued_period_diff->Visible) { // accrued_period_diff ?>
        <tr id="r_accrued_period_diff"<?= $number_of_unpaid_units->accrued_period_diff->rowAttributes() ?>>
            <td class="<?= $number_of_unpaid_units->TableLeftColumnClass ?>"><?= $number_of_unpaid_units->accrued_period_diff->caption() ?></td>
            <td<?= $number_of_unpaid_units->accrued_period_diff->cellAttributes() ?>>
<span id="el_number_of_unpaid_units_accrued_period_diff">
<span<?= $number_of_unpaid_units->accrued_period_diff->viewAttributes() ?>>
<?= $number_of_unpaid_units->accrued_period_diff->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
