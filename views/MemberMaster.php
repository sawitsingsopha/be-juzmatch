<?php

namespace PHPMaker2022\juzmatch;

// Table
$member = Container("member");
?>
<?php if ($member->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_membermaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($member->first_name->Visible) { // first_name ?>
        <tr id="r_first_name"<?= $member->first_name->rowAttributes() ?>>
            <td class="<?= $member->TableLeftColumnClass ?>"><?= $member->first_name->caption() ?></td>
            <td<?= $member->first_name->cellAttributes() ?>>
<span id="el_member_first_name">
<span<?= $member->first_name->viewAttributes() ?>>
<?= $member->first_name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($member->last_name->Visible) { // last_name ?>
        <tr id="r_last_name"<?= $member->last_name->rowAttributes() ?>>
            <td class="<?= $member->TableLeftColumnClass ?>"><?= $member->last_name->caption() ?></td>
            <td<?= $member->last_name->cellAttributes() ?>>
<span id="el_member_last_name">
<span<?= $member->last_name->viewAttributes() ?>>
<?= $member->last_name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($member->idcardnumber->Visible) { // idcardnumber ?>
        <tr id="r_idcardnumber"<?= $member->idcardnumber->rowAttributes() ?>>
            <td class="<?= $member->TableLeftColumnClass ?>"><?= $member->idcardnumber->caption() ?></td>
            <td<?= $member->idcardnumber->cellAttributes() ?>>
<span id="el_member_idcardnumber">
<span<?= $member->idcardnumber->viewAttributes() ?>>
<?= $member->idcardnumber->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($member->_email->Visible) { // email ?>
        <tr id="r__email"<?= $member->_email->rowAttributes() ?>>
            <td class="<?= $member->TableLeftColumnClass ?>"><?= $member->_email->caption() ?></td>
            <td<?= $member->_email->cellAttributes() ?>>
<span id="el_member__email">
<span<?= $member->_email->viewAttributes() ?>>
<?= $member->_email->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($member->phone->Visible) { // phone ?>
        <tr id="r_phone"<?= $member->phone->rowAttributes() ?>>
            <td class="<?= $member->TableLeftColumnClass ?>"><?= $member->phone->caption() ?></td>
            <td<?= $member->phone->cellAttributes() ?>>
<span id="el_member_phone">
<span<?= $member->phone->viewAttributes() ?>>
<?= $member->phone->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($member->isbuyer->Visible) { // isbuyer ?>
        <tr id="r_isbuyer"<?= $member->isbuyer->rowAttributes() ?>>
            <td class="<?= $member->TableLeftColumnClass ?>"><?= $member->isbuyer->caption() ?></td>
            <td<?= $member->isbuyer->cellAttributes() ?>>
<span id="el_member_isbuyer">
<span<?= $member->isbuyer->viewAttributes() ?>>
<?= $member->isbuyer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($member->isinvertor->Visible) { // isinvertor ?>
        <tr id="r_isinvertor"<?= $member->isinvertor->rowAttributes() ?>>
            <td class="<?= $member->TableLeftColumnClass ?>"><?= $member->isinvertor->caption() ?></td>
            <td<?= $member->isinvertor->cellAttributes() ?>>
<span id="el_member_isinvertor">
<span<?= $member->isinvertor->viewAttributes() ?>>
<?= $member->isinvertor->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($member->issale->Visible) { // issale ?>
        <tr id="r_issale"<?= $member->issale->rowAttributes() ?>>
            <td class="<?= $member->TableLeftColumnClass ?>"><?= $member->issale->caption() ?></td>
            <td<?= $member->issale->cellAttributes() ?>>
<span id="el_member_issale">
<span<?= $member->issale->viewAttributes() ?>>
<?= $member->issale->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($member->image_profile->Visible) { // image_profile ?>
        <tr id="r_image_profile"<?= $member->image_profile->rowAttributes() ?>>
            <td class="<?= $member->TableLeftColumnClass ?>"><?= $member->image_profile->caption() ?></td>
            <td<?= $member->image_profile->cellAttributes() ?>>
<span id="el_member_image_profile">
<span>
<?= GetFileViewTag($member->image_profile, $member->image_profile->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($member->cdate->Visible) { // cdate ?>
        <tr id="r_cdate"<?= $member->cdate->rowAttributes() ?>>
            <td class="<?= $member->TableLeftColumnClass ?>"><?= $member->cdate->caption() ?></td>
            <td<?= $member->cdate->cellAttributes() ?>>
<span id="el_member_cdate">
<span<?= $member->cdate->viewAttributes() ?>>
<?= $member->cdate->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
