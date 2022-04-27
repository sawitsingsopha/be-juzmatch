<?php

namespace PHPMaker2022\juzmatch;

// Table
$buyer = Container("buyer");
?>
<?php if ($buyer->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_buyermaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($buyer->first_name->Visible) { // first_name ?>
        <tr id="r_first_name"<?= $buyer->first_name->rowAttributes() ?>>
            <td class="<?= $buyer->TableLeftColumnClass ?>"><?= $buyer->first_name->caption() ?></td>
            <td<?= $buyer->first_name->cellAttributes() ?>>
<span id="el_buyer_first_name">
<span<?= $buyer->first_name->viewAttributes() ?>>
<?= $buyer->first_name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer->last_name->Visible) { // last_name ?>
        <tr id="r_last_name"<?= $buyer->last_name->rowAttributes() ?>>
            <td class="<?= $buyer->TableLeftColumnClass ?>"><?= $buyer->last_name->caption() ?></td>
            <td<?= $buyer->last_name->cellAttributes() ?>>
<span id="el_buyer_last_name">
<span<?= $buyer->last_name->viewAttributes() ?>>
<?= $buyer->last_name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer->idcardnumber->Visible) { // idcardnumber ?>
        <tr id="r_idcardnumber"<?= $buyer->idcardnumber->rowAttributes() ?>>
            <td class="<?= $buyer->TableLeftColumnClass ?>"><?= $buyer->idcardnumber->caption() ?></td>
            <td<?= $buyer->idcardnumber->cellAttributes() ?>>
<span id="el_buyer_idcardnumber">
<span<?= $buyer->idcardnumber->viewAttributes() ?>>
<?= $buyer->idcardnumber->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer->_email->Visible) { // email ?>
        <tr id="r__email"<?= $buyer->_email->rowAttributes() ?>>
            <td class="<?= $buyer->TableLeftColumnClass ?>"><?= $buyer->_email->caption() ?></td>
            <td<?= $buyer->_email->cellAttributes() ?>>
<span id="el_buyer__email">
<span<?= $buyer->_email->viewAttributes() ?>>
<?= $buyer->_email->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer->phone->Visible) { // phone ?>
        <tr id="r_phone"<?= $buyer->phone->rowAttributes() ?>>
            <td class="<?= $buyer->TableLeftColumnClass ?>"><?= $buyer->phone->caption() ?></td>
            <td<?= $buyer->phone->cellAttributes() ?>>
<span id="el_buyer_phone">
<span<?= $buyer->phone->viewAttributes() ?>>
<?= $buyer->phone->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($buyer->image_profile->Visible) { // image_profile ?>
        <tr id="r_image_profile"<?= $buyer->image_profile->rowAttributes() ?>>
            <td class="<?= $buyer->TableLeftColumnClass ?>"><?= $buyer->image_profile->caption() ?></td>
            <td<?= $buyer->image_profile->cellAttributes() ?>>
<span id="el_buyer_image_profile">
<span>
<?= GetFileViewTag($buyer->image_profile, $buyer->image_profile->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
