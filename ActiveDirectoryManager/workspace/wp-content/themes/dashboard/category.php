<?php
/**
* A Simple Category Template
*/

get_header(); ?> 

<div class="container category-page">
    <div class="col-sm-10 posts-list">
        <?php
        while ( have_posts() ) : the_post(); ?>
        
            <div class="row posts-list-item">
                <div class="col-sm-2">
                    <a href="<?=the_permalink()?>">
                    <img style="width:110px" src="http://discussion.mikado-themes.com/wp-content/uploads/2016/02/watching-global-warming-in-action-85x85.jpg" />
                    </a>
                </div>
                <div class="col-sm-10">
                    <span class="grey">Asset <?php the_category("<span class='white'> in </span>"); ?>
                    </span>
                    <br />
                     <a href="<?=the_permalink()?>">
                    <span class="title"><?= the_title() ?></span><?=get_field('brief')?>
                    </a>
                    <br />
                    <span class="date">By <?= the_author() ?> at <?= get_the_date() ?>..</span>
                </div>
            </div>
        
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>