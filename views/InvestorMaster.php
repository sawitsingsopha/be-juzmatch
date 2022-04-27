<?php

namespace PHPMaker2022\juzmatch;

// Table
$investor = Container("investor");
?>
<?php if ($investor->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_investormaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($investor->first_name->Visible) { // first_name ?>
        <tr id="r_first_name"<?= $investor->first_name->rowAttributes() ?>>
            <td class="<?= $investor->TableLeftColumnClass ?>"><?= $investor->first_name->caption() ?></td>
            <td<?= $investor->first_name->cellAttributes() ?>>
<span id="el_investor_first_name">
<span<?= $investor->first_name->viewAttributes() ?>>
<?= $investor->first_name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($investor->last_name->Visible) { // last_name ?>
        <tr id="r_last_name"<?= $investor->last_name->rowAttributes() ?>>
            <td class="<?= $investor->TableLeftColumnClass ?>"><?= $investor->last_name->caption() ?></td>
            <td<?= $investor->last_name->cellAttributes() ?>>
<span id="el_investor_last_name">
<span<?= $investor->last_name->viewAttributes() ?>>
<?= $investor->last_name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($investor->idcardnumber->Visible) { // idcardnumber ?>
        <tr id="r_idcardnumber"<?= $investor->idcardnumber->rowAttributes() ?>>
            <td class="<?= $investor->TableLeftColumnClass ?>"><?= $investor->idcardnumber->caption() ?></td>
            <td<?= $investor->idcardnumber->cellAttributes() ?>>
<span id="el_investor_idcardnumber">
<span<?= $investor->idcardnumber->viewAttributes() ?>>
<?= $investor->idcardnumber->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($investor->_email->Visible) { // email ?>
        <tr id="r__email"<?= $investor->_email->rowAttributes() ?>>
            <td class="<?= $investor->TableLeftColumnClass ?>"><?= $investor->_email->caption() ?></td>
            <td<?= $investor->_email->cellAttributes() ?>>
<span id="el_investor__email">
<span<?= $investor->_email->viewAttributes() ?>>
<?= $investor->_email->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($investor->phone->Visible) { // phone ?>
        <tr id="r_phone"<?= $investor->phone->rowAttributes() ?>>
            <td class="<?= $investor->TableLeftColumnClass ?>"><?= $investor->phone->caption() ?></td>
            <td<?= $investor->phone->cellAttributes() ?>>
<span id="el_investor_phone">
<span<?= $investor->phone->viewAttributes() ?>>
<?= $investor->phone->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
