<?php
/**
 * This file is part of mod_tag2menu
 * It contains standard Joomla menu markup genrated from tagged items
 */
 ?>
<ul class="nav menu">
<?php foreach ($col as $item) :
    $id = $item->content_item_id.':'.$item->core_alias;
    $typeAlias = $item->type_alias;
?>
    <li
        <?php if ($id == $curId && $typeAlias == $curTypeAlias): ?>
        class="current active"
        <?php endif; ?>
        >
        <a
           href="<?php echo JRoute::_(TagsHelperRoute::getItemRoute($item->content_item_id, $item->core_alias, $item->core_catid, $item->core_language, $item->type_alias, $item->router)); ?>"
           class=""
           ><?php echo $item->core_title; ?></a>
    </li>
<?php endforeach; ?>
</ul>
