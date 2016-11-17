<?php 
get_header();

the_post();

$time = strtotime(str_replace('/','-',get_field("target_date")));
$style = "";
if($time > time()){
    $style =  'style="text-decoration: line-through;color:red"';
}

?>
<div class="container">
    <div class="row bc white">
        <div class="col-sm-4">
             <?php bcn_display(); ?>
         </div> 
    </div>
    <div class="row">
        <div class="col-sm-4" style="text-align:left">
            <?=the_post_thumbnail( 'medium' ); ?>
        </div>
        
        <div class="col-sm-6" style="text-align:left">
            <h1 class="yellow" <?=$style?>>
                <?=the_title()?>
            </h1>
            <br />
           
            <span class="white">Target Date: <span <?=$style?> ><?=get_field("target_date");?></span></span>
            <br /><br />
            <span class="white" >
                <?=get_field("brief");?>
            </span>
        </div>
        
        
        

    </div>
    
    <div class="row" style="text-align:left">
        <div class="col-sm-10" style="text-align:justify">
            <br />
            <span class="white">
                <?=the_content();?>
            </span>
        </div>
    </div>
</div>
    
<?php get_footer()?>