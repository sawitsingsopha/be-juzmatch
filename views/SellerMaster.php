<?php

namespace PHPMaker2022\juzmatch;

// Table
$seller = Container("seller");
?>
<?php if ($seller->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sellermaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($seller->first_name->Visible) { // first_name ?>
        <tr id="r_first_name"<?= $seller->first_name->rowAttributes() ?>>
            <td class="<?= $seller->TableLeftColumnClass ?>"><?= $seller->first_name->caption() ?></td>
            <td<?= $seller->first_name->cellAttributes() ?>>
<span id="el_seller_first_name">
<span<?= $seller->first_name->viewAttributes() ?>>
<?= $seller->first_name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($seller->last_name->Visible) { // last_name ?>
        <tr id="r_last_name"<?= $seller->last_name->rowAttributes() ?>>
            <td class="<?= $seller->TableLeftColumnClass ?>"><?= $seller->last_name->caption() ?></td>
            <td<?= $seller->last_name->cellAttributes() ?>>
<span id="el_seller_last_name">
<span<?= $seller->last_name->viewAttributes() ?>>
<?= $seller->last_name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($seller->idcardnumber->Visible) { // idcardnumber ?>
        <tr id="r_idcardnumber"<?= $seller->idcardnumber->rowAttributes() ?>>
            <td class="<?= $seller->TableLeftColumnClass ?>"><?= $seller->idcardnumber->caption() ?></td>
            <td<?= $seller->idcardnumber->cellAttributes() ?>>
<span id="el_seller_idcardnumber">
<span<?= $seller->idcardnumber->viewAttributes() ?>>
<?= $seller->idcardnumber->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($seller->_email->Visible) { // email ?>
        <tr id="r__email"<?= $seller->_email->rowAttributes() ?>>
            <td class="<?= $seller->TableLeftColumnClass ?>"><?= $seller->_email->caption() ?></td>
            <td<?= $seller->_email->cellAttributes() ?>>
<span id="el_seller__email">
<span<?= $seller->_email->viewAttributes() ?>>
<?= $seller->_email->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($seller->phone->Visible) { // phone ?>
        <tr id="r_phone"<?= $seller->phone->rowAttributes() ?>>
            <td class="<?= $seller->TableLeftColumnClass ?>"><?= $seller->phone->caption() ?></td>
            <td<?= $seller->phone->cellAttributes() ?>>
<span id="el_seller_phone">
<span<?= $seller->phone->viewAttributes() ?>>
<?= $seller->phone->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($seller->image_profile->Visible) { // image_profile ?>
        <tr id="r_image_profile"<?= $seller->image_profile->rowAttributes() ?>>
            <td class="<?= $seller->TableLeftColumnClass ?>"><?= $seller->image_profile->caption() ?></td>
            <td<?= $seller->image_profile->cellAttributes() ?>>
<span id="el_seller_image_profile">
<span>
<?= GetFileViewTag($seller->image_profile, $seller->image_profile->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
