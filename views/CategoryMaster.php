<?php

namespace PHPMaker2022\juzmatch;

// Table
$category = Container("category");
?>
<?php if ($category->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_categorymaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($category->category_name->Visible) { // category_name ?>
        <tr id="r_category_name"<?= $category->category_name->rowAttributes() ?>>
            <td class="<?= $category->TableLeftColumnClass ?>"><?= $category->category_name->caption() ?></td>
            <td<?= $category->category_name->cellAttributes() ?>>
<span id="el_category_category_name">
<span<?= $category->category_name->viewAttributes() ?>>
<?= $category->category_name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($category->image->Visible) { // image ?>
        <tr id="r_image"<?= $category->image->rowAttributes() ?>>
            <td class="<?= $category->TableLeftColumnClass ?>"><?= $category->image->caption() ?></td>
            <td<?= $category->image->cellAttributes() ?>>
<span id="el_category_image">
<span>
<?= GetFileViewTag($category->image, $category->image->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($category->order_by->Visible) { // order_by ?>
        <tr id="r_order_by"<?= $category->order_by->rowAttributes() ?>>
            <td class="<?= $category->TableLeftColumnClass ?>"><?= $category->order_by->caption() ?></td>
            <td<?= $category->order_by->cellAttributes() ?>>
<span id="el_category_order_by">
<span<?= $category->order_by->viewAttributes() ?>>
<?= $category->order_by->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($category->isactive->Visible) { // isactive ?>
        <tr id="r_isactive"<?= $category->isactive->rowAttributes() ?>>
            <td class="<?= $category->TableLeftColumnClass ?>"><?= $category->isactive->caption() ?></td>
            <td<?= $category->isactive->cellAttributes() ?>>
<span id="el_category_isactive">
<span<?= $category->isactive->viewAttributes() ?>>
<?= $category->isactive->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
