<?php
if ($addBsContainer): ?>
  <div class="<?php echo $bootstrapContainer; ?>">
<?php
endif;
foreach ($list as $row): ?>
<div class="tag2menu-container <?php echo $bootstrapRow; ?>">
  <?php
  $totalCols = 0;
  foreach($row as $tag): ?>
    <?php
    $items = $tag->items;

    /*if($bootstrapVersion > 1) { // 1 = no bootstrap
        $numItems = count($items);//2
        $bootstrapSize= $params->get('bootstrapSize');//4
        $numCols = intval(ceil($numItems/$maxItemsPerCol));//2
        $multipleCols = false;
        if($numCols > 1) {
            $multipleCols = true;
            $colSize = intval(ceil($numItems/$numCols));//1
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
  ?>
</div>
<?php endforeach;
if ($addBsContainer): ?>
</div>
<?php endif; ?>
