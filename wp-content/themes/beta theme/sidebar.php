




<!-- All this stuff in here only shows up if you DON'T have any widgets active in this zone -->

<div class="col-md-3 col sidebar" >


    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">Categories</h3>
        </div>
        <div class="panel-body">
            <?php wp_nav_menu(array('menu'=>'Categories','container'=>''));?>
        </div>
    </div>
    <?php //them widget right sidebar
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('Right Sidebar')) : else : ?>

<?php endif; 
?>

<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">News</h3>
    </div>
    <div class="panel-body">
        <ul>
            <li>News Monday</li>
            <li>News Monday</li>
            <li>News Monday</li>
            <li>TNews Monday</li>

        </ul>
    </div>
</div>

<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">News</h3>
    </div>
    <div class="panel-body">
        <?php 
if(function_exists('fetch_feed')){
    include_once(ABSPATH . WPINC . '/feed.php');
    $feed=fetch_feed('http://vnexpress.net/rss/the-gioi.rss');
    $limit=$feed->get_item_quantity(2);
    $items=$feed->get_items(0,$limit);
    if(!$items) echo "The feed is not available";
    else foreach ($items as $item):?>
<p class="date"><?php echo $item->get_date('F j, Y');?></p>
<h4><a href="<?php echo $item->get_permalink();?>">
<?php echo $item->get_title();?></a></h4>
<p><?php echo $item->get_description();?></p>
<?php endforeach;}?>

    </div>
</div>

</div><!-- end sidebar   -->

</div>  <!-- -end row -->               
</div>  <!-- end container --> 
</div>        <!-- end main -->


