<?php

namespace PHPMaker2022\juzmatch;

// Table
$juzcalculator = Container("juzcalculator");
?>
<?php if ($juzcalculator->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_juzcalculatormaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($juzcalculator->income_all->Visible) { // income_all ?>
        <tr id="r_income_all"<?= $juzcalculator->income_all->rowAttributes() ?>>
            <td class="<?= $juzcalculator->TableLeftColumnClass ?>"><?= $juzcalculator->income_all->caption() ?></td>
            <td<?= $juzcalculator->income_all->cellAttributes() ?>>
<span id="el_juzcalculator_income_all">
<span<?= $juzcalculator->income_all->viewAttributes() ?>>
<?= $juzcalculator->income_all->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($juzcalculator->outcome_all->Visible) { // outcome_all ?>
        <tr id="r_outcome_all"<?= $juzcalculator->outcome_all->rowAttributes() ?>>
            <td class="<?= $juzcalculator->TableLeftColumnClass ?>"><?= $juzcalculator->outcome_all->caption() ?></td>
            <td<?= $juzcalculator->outcome_all->cellAttributes() ?>>
<span id="el_juzcalculator_outcome_all">
<span<?= $juzcalculator->outcome_all->viewAttributes() ?>>
<?= $juzcalculator->outcome_all->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($juzcalculator->rent_price->Visible) { // rent_price ?>
        <tr id="r_rent_price"<?= $juzcalculator->rent_price->rowAttributes() ?>>
            <td class="<?= $juzcalculator->TableLeftColumnClass ?>"><?= $juzcalculator->rent_price->caption() ?></td>
            <td<?= $juzcalculator->rent_price->cellAttributes() ?>>
<span id="el_juzcalculator_rent_price">
<span<?= $juzcalculator->rent_price->viewAttributes() ?>>
<?= $juzcalculator->rent_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($juzcalculator->asset_price->Visible) { // asset_price ?>
        <tr id="r_asset_price"<?= $juzcalculator->asset_price->rowAttributes() ?>>
            <td class="<?= $juzcalculator->TableLeftColumnClass ?>"><?= $juzcalculator->asset_price->caption() ?></td>
            <td<?= $juzcalculator->asset_price->cellAttributes() ?>>
<span id="el_juzcalculator_asset_price">
<span<?= $juzcalculator->asset_price->viewAttributes() ?>>
<?= $juzcalculator->asset_price->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($juzcalculator->cdate->Visible) { // cdate ?>
        <tr id="r_cdate"<?= $juzcalculator->cdate->rowAttributes() ?>>
            <td class="<?= $juzcalculator->TableLeftColumnClass ?>"><?= $juzcalculator->cdate->caption() ?></td>
            <td<?= $juzcalculator->cdate->cellAttributes() ?>>
<span id="el_juzcalculator_cdate">
<span<?= $juzcalculator->cdate->viewAttributes() ?>>
<?= $juzcalculator->cdate->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
