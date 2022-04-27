<?php

namespace PHPMaker2022\juzmatch;

// Table
$number_of_accrued = Container("number_of_accrued");
?>
<?php if ($number_of_accrued->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_number_of_accruedmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($number_of_accrued->asset_code->Visible) { // asset_code ?>
        <tr id="r_asset_code"<?= $number_of_accrued->asset_code->rowAttributes() ?>>
            <td class="<?= $number_of_accrued->TableLeftColumnClass ?>"><?= $number_of_accrued->asset_code->caption() ?></td>
            <td<?= $number_of_accrued->asset_code->cellAttributes() ?>>
<span id="el_number_of_accrued_asset_code">
<span<?= $number_of_accrued->asset_code->viewAttributes() ?>>
<?= $number_of_accrued->asset_code->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_of_accrued->_title->Visible) { // title ?>
        <tr id="r__title"<?= $number_of_accrued->_title->rowAttributes() ?>>
            <td class="<?= $number_of_accrued->TableLeftColumnClass ?>"><?= $number_of_accrued->_title->caption() ?></td>
            <td<?= $number_of_accrued->_title->cellAttributes() ?>>
<span id="el_number_of_accrued__title">
<span<?= $number_of_accrued->_title->viewAttributes() ?>>
<?= $number_of_accrued->_title->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_of_accrued->asset_price->Visible) { // asset_price ?>
        <tr id="r_asset_price"<?= $number_of_accrued->asset_price->rowAttributes() ?>>
            <td class="<?= $number_of_accrued->TableLeftColumnClass ?>"><?= $number_of_accrued->asset_price->caption() ?></td>
            <td<?= $number_of_accrued->asset_price->cellAttributes() ?>>
<span id="el_number_of_accrued_asset_price">
<span<?= $number_of_accrued->asset_price->viewAttributes() ?>>
<?= $number_of_accrued->asset_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_of_accrued->price_paid->Visible) { // price_paid ?>
        <tr id="r_price_paid"<?= $number_of_accrued->price_paid->rowAttributes() ?>>
            <td class="<?= $number_of_accrued->TableLeftColumnClass ?>"><?= $number_of_accrued->price_paid->caption() ?></td>
            <td<?= $number_of_accrued->price_paid->cellAttributes() ?>>
<span id="el_number_of_accrued_price_paid">
<span<?= $number_of_accrued->price_paid->viewAttributes() ?>>
<?= $number_of_accrued->price_paid->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_of_accrued->remaining_price->Visible) { // remaining_price ?>
        <tr id="r_remaining_price"<?= $number_of_accrued->remaining_price->rowAttributes() ?>>
            <td class="<?= $number_of_accrued->TableLeftColumnClass ?>"><?= $number_of_accrued->remaining_price->caption() ?></td>
            <td<?= $number_of_accrued->remaining_price->cellAttributes() ?>>
<span id="el_number_of_accrued_remaining_price">
<span<?= $number_of_accrued->remaining_price->viewAttributes() ?>>
<?= $number_of_accrued->remaining_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_of_accrued->expiration_date->Visible) { // expiration_date ?>
        <tr id="r_expiration_date"<?= $number_of_accrued->expiration_date->rowAttributes() ?>>
            <td class="<?= $number_of_accrued->TableLeftColumnClass ?>"><?= $number_of_accrued->expiration_date->caption() ?></td>
            <td<?= $number_of_accrued->expiration_date->cellAttributes() ?>>
<span id="el_number_of_accrued_expiration_date">
<span<?= $number_of_accrued->expiration_date->viewAttributes() ?>>
<?= $number_of_accrued->expiration_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($number_of_accrued->accrued_period_diff->Visible) { // accrued_period_diff ?>
        <tr id="r_accrued_period_diff"<?= $number_of_accrued->accrued_period_diff->rowAttributes() ?>>
            <td class="<?= $number_of_accrued->TableLeftColumnClass ?>"><?= $number_of_accrued->accrued_period_diff->caption() ?></td>
            <td<?= $number_of_accrued->accrued_period_diff->cellAttributes() ?>>
<span id="el_number_of_accrued_accrued_period_diff">
<span<?= $number_of_accrued->accrued_period_diff->viewAttributes() ?>>
<?= $number_of_accrued->accrued_period_diff->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
