<?php

namespace PHPMaker2022\juzmatch;

// Table
$asset = Container("asset");
?>
<?php if ($asset->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_assetmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($asset->_title->Visible) { // title ?>
        <tr id="r__title"<?= $asset->_title->rowAttributes() ?>>
            <td class="<?= $asset->TableLeftColumnClass ?>"><?= $asset->_title->caption() ?></td>
            <td<?= $asset->_title->cellAttributes() ?>>
<span id="el_asset__title">
<span<?= $asset->_title->viewAttributes() ?>>
<?= $asset->_title->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($asset->brand_id->Visible) { // brand_id ?>
        <tr id="r_brand_id"<?= $asset->brand_id->rowAttributes() ?>>
            <td class="<?= $asset->TableLeftColumnClass ?>"><?= $asset->brand_id->caption() ?></td>
            <td<?= $asset->brand_id->cellAttributes() ?>>
<span id="el_asset_brand_id">
<span<?= $asset->brand_id->viewAttributes() ?>>
<?= $asset->brand_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($asset->asset_code->Visible) { // asset_code ?>
        <tr id="r_asset_code"<?= $asset->asset_code->rowAttributes() ?>>
            <td class="<?= $asset->TableLeftColumnClass ?>"><?= $asset->asset_code->caption() ?></td>
            <td<?= $asset->asset_code->cellAttributes() ?>>
<span id="el_asset_asset_code">
<span<?= $asset->asset_code->viewAttributes() ?>>
<?= $asset->asset_code->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($asset->asset_status->Visible) { // asset_status ?>
        <tr id="r_asset_status"<?= $asset->asset_status->rowAttributes() ?>>
            <td class="<?= $asset->TableLeftColumnClass ?>"><?= $asset->asset_status->caption() ?></td>
            <td<?= $asset->asset_status->cellAttributes() ?>>
<span id="el_asset_asset_status">
<span<?= $asset->asset_status->viewAttributes() ?>>
<?= $asset->asset_status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($asset->isactive->Visible) { // isactive ?>
        <tr id="r_isactive"<?= $asset->isactive->rowAttributes() ?>>
            <td class="<?= $asset->TableLeftColumnClass ?>"><?= $asset->isactive->caption() ?></td>
            <td<?= $asset->isactive->cellAttributes() ?>>
<span id="el_asset_isactive">
<span<?= $asset->isactive->viewAttributes() ?>>
<?= $asset->isactive->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($asset->price_mark->Visible) { // price_mark ?>
        <tr id="r_price_mark"<?= $asset->price_mark->rowAttributes() ?>>
            <td class="<?= $asset->TableLeftColumnClass ?>"><?= $asset->price_mark->caption() ?></td>
            <td<?= $asset->price_mark->cellAttributes() ?>>
<span id="el_asset_price_mark">
<span<?= $asset->price_mark->viewAttributes() ?>>
<?= $asset->price_mark->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($asset->usable_area->Visible) { // usable_area ?>
        <tr id="r_usable_area"<?= $asset->usable_area->rowAttributes() ?>>
            <td class="<?= $asset->TableLeftColumnClass ?>"><?= $asset->usable_area->caption() ?></td>
            <td<?= $asset->usable_area->cellAttributes() ?>>
<span id="el_asset_usable_area">
<span<?= $asset->usable_area->viewAttributes() ?>>
<?= $asset->usable_area->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($asset->land_size->Visible) { // land_size ?>
        <tr id="r_land_size"<?= $asset->land_size->rowAttributes() ?>>
            <td class="<?= $asset->TableLeftColumnClass ?>"><?= $asset->land_size->caption() ?></td>
            <td<?= $asset->land_size->cellAttributes() ?>>
<span id="el_asset_land_size">
<span<?= $asset->land_size->viewAttributes() ?>>
<?= $asset->land_size->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($asset->count_view->Visible) { // count_view ?>
        <tr id="r_count_view"<?= $asset->count_view->rowAttributes() ?>>
            <td class="<?= $asset->TableLeftColumnClass ?>"><?= $asset->count_view->caption() ?></td>
            <td<?= $asset->count_view->cellAttributes() ?>>
<span id="el_asset_count_view">
<span<?= $asset->count_view->viewAttributes() ?>>
<?= $asset->count_view->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($asset->count_favorite->Visible) { // count_favorite ?>
        <tr id="r_count_favorite"<?= $asset->count_favorite->rowAttributes() ?>>
            <td class="<?= $asset->TableLeftColumnClass ?>"><?= $asset->count_favorite->caption() ?></td>
            <td<?= $asset->count_favorite->cellAttributes() ?>>
<span id="el_asset_count_favorite">
<span<?= $asset->count_favorite->viewAttributes() ?>>
<?= $asset->count_favorite->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($asset->expired_date->Visible) { // expired_date ?>
        <tr id="r_expired_date"<?= $asset->expired_date->rowAttributes() ?>>
            <td class="<?= $asset->TableLeftColumnClass ?>"><?= $asset->expired_date->caption() ?></td>
            <td<?= $asset->expired_date->cellAttributes() ?>>
<span id="el_asset_expired_date">
<span<?= $asset->expired_date->viewAttributes() ?>>
<?= $asset->expired_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($asset->cdate->Visible) { // cdate ?>
        <tr id="r_cdate"<?= $asset->cdate->rowAttributes() ?>>
            <td class="<?= $asset->TableLeftColumnClass ?>"><?= $asset->cdate->caption() ?></td>
            <td<?= $asset->cdate->cellAttributes() ?>>
<span id="el_asset_cdate">
<span<?= $asset->cdate->viewAttributes() ?>>
<?= $asset->cdate->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
