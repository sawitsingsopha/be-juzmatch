<?php

namespace PHPMaker2022\juzmatch;

// Table
$outstanding_amount = Container("outstanding_amount");
?>
<?php if ($outstanding_amount->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_outstanding_amountmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($outstanding_amount->asset_code->Visible) { // asset_code ?>
        <tr id="r_asset_code"<?= $outstanding_amount->asset_code->rowAttributes() ?>>
            <td class="<?= $outstanding_amount->TableLeftColumnClass ?>"><?= $outstanding_amount->asset_code->caption() ?></td>
            <td<?= $outstanding_amount->asset_code->cellAttributes() ?>>
<span id="el_outstanding_amount_asset_code">
<span<?= $outstanding_amount->asset_code->viewAttributes() ?>>
<?= $outstanding_amount->asset_code->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($outstanding_amount->_title->Visible) { // title ?>
        <tr id="r__title"<?= $outstanding_amount->_title->rowAttributes() ?>>
            <td class="<?= $outstanding_amount->TableLeftColumnClass ?>"><?= $outstanding_amount->_title->caption() ?></td>
            <td<?= $outstanding_amount->_title->cellAttributes() ?>>
<span id="el_outstanding_amount__title">
<span<?= $outstanding_amount->_title->viewAttributes() ?>>
<?= $outstanding_amount->_title->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($outstanding_amount->asset_price->Visible) { // asset_price ?>
        <tr id="r_asset_price"<?= $outstanding_amount->asset_price->rowAttributes() ?>>
            <td class="<?= $outstanding_amount->TableLeftColumnClass ?>"><?= $outstanding_amount->asset_price->caption() ?></td>
            <td<?= $outstanding_amount->asset_price->cellAttributes() ?>>
<span id="el_outstanding_amount_asset_price">
<span<?= $outstanding_amount->asset_price->viewAttributes() ?>>
<?= $outstanding_amount->asset_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($outstanding_amount->price_paid->Visible) { // price_paid ?>
        <tr id="r_price_paid"<?= $outstanding_amount->price_paid->rowAttributes() ?>>
            <td class="<?= $outstanding_amount->TableLeftColumnClass ?>"><?= $outstanding_amount->price_paid->caption() ?></td>
            <td<?= $outstanding_amount->price_paid->cellAttributes() ?>>
<span id="el_outstanding_amount_price_paid">
<span<?= $outstanding_amount->price_paid->viewAttributes() ?>>
<?= $outstanding_amount->price_paid->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($outstanding_amount->remaining_price->Visible) { // remaining_price ?>
        <tr id="r_remaining_price"<?= $outstanding_amount->remaining_price->rowAttributes() ?>>
            <td class="<?= $outstanding_amount->TableLeftColumnClass ?>"><?= $outstanding_amount->remaining_price->caption() ?></td>
            <td<?= $outstanding_amount->remaining_price->cellAttributes() ?>>
<span id="el_outstanding_amount_remaining_price">
<span<?= $outstanding_amount->remaining_price->viewAttributes() ?>>
<?= $outstanding_amount->remaining_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($outstanding_amount->expiration_date->Visible) { // expiration_date ?>
        <tr id="r_expiration_date"<?= $outstanding_amount->expiration_date->rowAttributes() ?>>
            <td class="<?= $outstanding_amount->TableLeftColumnClass ?>"><?= $outstanding_amount->expiration_date->caption() ?></td>
            <td<?= $outstanding_amount->expiration_date->cellAttributes() ?>>
<span id="el_outstanding_amount_expiration_date">
<span<?= $outstanding_amount->expiration_date->viewAttributes() ?>>
<?= $outstanding_amount->expiration_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($outstanding_amount->accrued_period_diff->Visible) { // accrued_period_diff ?>
        <tr id="r_accrued_period_diff"<?= $outstanding_amount->accrued_period_diff->rowAttributes() ?>>
            <td class="<?= $outstanding_amount->TableLeftColumnClass ?>"><?= $outstanding_amount->accrued_period_diff->caption() ?></td>
            <td<?= $outstanding_amount->accrued_period_diff->cellAttributes() ?>>
<span id="el_outstanding_amount_accrued_period_diff">
<span<?= $outstanding_amount->accrued_period_diff->viewAttributes() ?>>
<?= $outstanding_amount->accrued_period_diff->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
