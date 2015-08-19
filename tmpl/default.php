<?php
// in some cases it is necessary to add a container element to make the bootstrap rows and cols work
if ($addBsContainer): ?>
  <div class="<?php echo $bootstrapContainer; // 'container' or 'container-fluid' ?>">
<?php
endif;
// the list is organized in rows which hold one or more menu each
foreach ($list as $row): ?>
<div class="tag2menu-container <?php echo $bootstrapRow; ?>">
  <?php foreach($row as $tag): ?>
    <div class="tag2menu-item <?php echo $bootstrapCol.$tag->bootstrapSize; ?>">
    <h3>
    <?php
    // get the menu items
    $items = $tag->items;
    // text before the menu headline
    echo $beforeHeadlines.' ';
    // either the tag title or the tag note can be used as headline
    if($useNote && !empty($tag->note)):
        echo $tag->note;
    else:
        echo $tag->title;
    endif;

    // text after menu headline
    echo $afterHeadlines;
     ?>
    </h3>
    <?php // only add another row and cols if necessary
    if($tag->multipleCols): ?>
    <div class="<?php echo $bootstrapRow; ?>">
        <?php foreach($items as $col): ?>
        <div class="<?php echo $bootstrapCol.intval(12/$tag->numCols); ?>">
            <?php // get the menu ul
            require JModuleHelper::getLayoutPath('mod_tag2menu', 'default_menu'); ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else:
      // get the single-col menu
      $col = $items;
      require JModuleHelper::getLayoutPath('mod_tag2menu', 'default_menu');
    endif; ?>
    </div>
<?php endforeach; ?>
</div>
<?php endforeach;
if ($addBsContainer): ?>
</div>
<?php endif; ?>
