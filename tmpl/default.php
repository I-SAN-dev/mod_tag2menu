<div class="tag2menu-container <?php $addBsContainer ? echo $bootstrapContainer : echo $bootstrapRow; ?>">
  <?php if ($addBsContainer): ?>
    <div class="<?php echo $bootstrapRow">
<?php
  endif;
  foreach($list as $tag): ?>
    <?php
    $items = $tag->items;
    /*if($bootstrapVersion > 1) { // 1 = no bootstrap
        $numItems = count($items);
        $bootstrapSize= $params->get('bootstrapSize');
        $numCols = intval(ceil($numItems/$maxItemsPerCol));
        $multipleCols = false;
        if($numCols > 1) {
            $multipleCols = true;
            $colSize = intval(ceil($numItems/$numCols));//8
            $cols = array_chunk($items, $colSize);
            $bootstrapSize = min(12,$numCols*$bootstrapSize);
        }
    }*/
    ?>
    <div class="tag2menu-item <?php echo $bootstrapCol.$tag->bootstrapSize; ?>">
    <h3>
    <?php echo $beforeHeadlines.' ';
    if($useNote && !empty($tag->note)):
        echo $tag->note;
    else:
        echo $tag->title;
    endif;
    echo $afterHeadlines;
     ?>
    </h3>
    <?php if($tag->multipleCols): ?>
    <div class="<?php echo $bootstrapRow; ?>">
        <?php foreach($items as $col): ?>
        <div class="<?php echo $bootstrapCol.intval(12/$tag->numCols); ?>">
            <?php require JModuleHelper::getLayoutPath('mod_tag2menu', 'default_menu'); ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else:
        $col = $items;
        require JModuleHelper::getLayoutPath('mod_tag2menu', 'default_menu');
    endif; ?>
    </div>
<?php
  endforeach;
  if ($addBsContainer): ?>
  </div>
<?php endif; ?>
</div>
