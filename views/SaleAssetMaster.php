<?php

namespace PHPMaker2022\juzmatch;

// Table
$sale_asset = Container("sale_asset");
?>
<?php if ($sale_asset->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sale_assetmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sale_asset->asset_id->Visible) { // asset_id ?>
        <tr id="r_asset_id"<?= $sale_asset->asset_id->rowAttributes() ?>>
            <td class="<?= $sale_asset->TableLeftColumnClass ?>"><?= $sale_asset->asset_id->caption() ?></td>
            <td<?= $sale_asset->asset_id->cellAttributes() ?>>
<span id="el_sale_asset_asset_id">
<span<?= $sale_asset->asset_id->viewAttributes() ?>>
<?= $sale_asset->asset_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sale_asset->status_live->Visible) { // status_live ?>
        <tr id="r_status_live"<?= $sale_asset->status_live->rowAttributes() ?>>
            <td class="<?= $sale_asset->TableLeftColumnClass ?>"><?= $sale_asset->status_live->caption() ?></td>
            <td<?= $sale_asset->status_live->cellAttributes() ?>>
<span id="el_sale_asset_status_live">
<span<?= $sale_asset->status_live->viewAttributes() ?>>
<?= $sale_asset->status_live->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
