<?php

namespace PHPMaker2022\juzmatch;

// Table
$inverter_asset = Container("inverter_asset");
?>
<?php if ($inverter_asset->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_inverter_assetmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($inverter_asset->asset_id->Visible) { // asset_id ?>
        <tr id="r_asset_id"<?= $inverter_asset->asset_id->rowAttributes() ?>>
            <td class="<?= $inverter_asset->TableLeftColumnClass ?>"><?= $inverter_asset->asset_id->caption() ?></td>
            <td<?= $inverter_asset->asset_id->cellAttributes() ?>>
<span id="el_inverter_asset_asset_id">
<span<?= $inverter_asset->asset_id->viewAttributes() ?>>
<?= $inverter_asset->asset_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($inverter_asset->status_expire->Visible) { // status_expire ?>
        <tr id="r_status_expire"<?= $inverter_asset->status_expire->rowAttributes() ?>>
            <td class="<?= $inverter_asset->TableLeftColumnClass ?>"><?= $inverter_asset->status_expire->caption() ?></td>
            <td<?= $inverter_asset->status_expire->cellAttributes() ?>>
<span id="el_inverter_asset_status_expire">
<span<?= $inverter_asset->status_expire->viewAttributes() ?>>
<?= $inverter_asset->status_expire->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($inverter_asset->status_expire_reason->Visible) { // status_expire_reason ?>
        <tr id="r_status_expire_reason"<?= $inverter_asset->status_expire_reason->rowAttributes() ?>>
            <td class="<?= $inverter_asset->TableLeftColumnClass ?>"><?= $inverter_asset->status_expire_reason->caption() ?></td>
            <td<?= $inverter_asset->status_expire_reason->cellAttributes() ?>>
<span id="el_inverter_asset_status_expire_reason">
<span<?= $inverter_asset->status_expire_reason->viewAttributes() ?>>
<?= $inverter_asset->status_expire_reason->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($inverter_asset->res_paidAgent->Visible) { // res_paidAgent ?>
        <tr id="r_res_paidAgent"<?= $inverter_asset->res_paidAgent->rowAttributes() ?>>
            <td class="<?= $inverter_asset->TableLeftColumnClass ?>"><?= $inverter_asset->res_paidAgent->caption() ?></td>
            <td<?= $inverter_asset->res_paidAgent->cellAttributes() ?>>
<span id="el_inverter_asset_res_paidAgent">
<span<?= $inverter_asset->res_paidAgent->viewAttributes() ?>>
<?= $inverter_asset->res_paidAgent->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($inverter_asset->res_paidChannel->Visible) { // res_paidChannel ?>
        <tr id="r_res_paidChannel"<?= $inverter_asset->res_paidChannel->rowAttributes() ?>>
            <td class="<?= $inverter_asset->TableLeftColumnClass ?>"><?= $inverter_asset->res_paidChannel->caption() ?></td>
            <td<?= $inverter_asset->res_paidChannel->cellAttributes() ?>>
<span id="el_inverter_asset_res_paidChannel">
<span<?= $inverter_asset->res_paidChannel->viewAttributes() ?>>
<?= $inverter_asset->res_paidChannel->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($inverter_asset->res_maskedPan->Visible) { // res_maskedPan ?>
        <tr id="r_res_maskedPan"<?= $inverter_asset->res_maskedPan->rowAttributes() ?>>
            <td class="<?= $inverter_asset->TableLeftColumnClass ?>"><?= $inverter_asset->res_maskedPan->caption() ?></td>
            <td<?= $inverter_asset->res_maskedPan->cellAttributes() ?>>
<span id="el_inverter_asset_res_maskedPan">
<span<?= $inverter_asset->res_maskedPan->viewAttributes() ?>>
<?= $inverter_asset->res_maskedPan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
