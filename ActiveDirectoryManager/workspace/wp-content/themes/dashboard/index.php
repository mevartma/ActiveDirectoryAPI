<?php get_header(); ?>


<?php

$today = date('Ymd');

$query_arr = 
    array( 
        "posts_per_page"=> "1", 
        'meta_key'	=> 'featured',
        'orderby'	=> 'meta_value_num',  
        'meta_query' => array(
        		array(
        	        'key'		=> 'target_date',
        	        'compare'	=> '<=',
        	        'value'		=> $today,
        	    )
    	    ),
        "order" => "ASC" );
        
$the_query=new WP_Query($query_arr); $the_query->have_posts(); $the_query->the_post(); ?>
<div class="container">
    <div class="row main-post-container">
        <div class="col-sm-8 main-post">
            <div class="texts">
                <div class="meta">
                    <div>
                        <span class="grey">Asset <?php the_category(" in ");?></span>
                    </div>
                    <span class="grey">Target Date: <span class="yellow"><?= the_field("target_date"); ?></span></span>
                </div>
               
                    <span class="title"> <a class="white" href="<?=the_permalink()?>"><?= trim(get_the_title()) ?> </a></span>
               
                <br />
                <br />
                <span class="description"><?= the_field("brief"); ?></span>
                <br />
                <br />
                <br />
                <span class="date">By <?= the_author() ?> at <?= the_date() ?></span>
            </div>
        </div>
        <?php wp_reset_postdata(); ?>
        <div class="col-sm-4 posts-list">
            <?php 
            $query_arr["posts_per_page"] = 5;
            $the_query=new WP_Query($query_arr); while ($the_query->have_posts()) { $the_query->the_post(); ?>
            <div class="row posts-list-item">
                <div class="col-sm-3">
                    <?//=the_post_thumbnail('thumbnail'); ?>
                    <img src="<?=the_post_thumbnail_url('thumbnail');?>" />
                    <!--<img src="http://discussion.mikado-themes.com/wp-content/uploads/2016/02/watching-global-warming-in-action-85x85.jpg" />-->
                </div>
                <div class="col-sm-9">
                    <span class="grey">Asset <?php the_category("<span class='white'> in </span>"); ?>
                    </span>
                    <br />
                    <span class="title"><a class="white" href="<?=the_permalink()?>"><?= limit_length(get_the_title(),30); ?></a> <?= the_date() ?></span>
                    <br />
                    <span class="date">By <?= the_author() ?> at <?= get_the_date() ?>..</span>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    
    
    <div id="controls" class="row controls">
    <div class="" id="main_control" style="display:none">
        <div style="position:relative">
            <div class="grid-panel" style="position:relative"><span class="close-icon glyphicon glyphicon-remove-circle"></span></div>
        </div>
        <div id="html-content"></div>
    </div>
    
    <div class=" row gridster">
        <ul>
        </ul>
    </div>
    
     <script type="text/javascript">
     
     
     
      var gridster;

      var serialization = [
        {
            col: 1,
            row: 1,
            size_x: 1,
            size_y: 1,
            title : 'Calendar',
            name : "CALENDAR",
            iframe : "<iframe allowfullscreen frameborder=0 src='//www.mte-media.com/admin2/frames/widgets_index.php?ref=2967923&set=embed&widg=cal&lng=en' width='100%' height='800px' ></iframe>",
        },
        {
            col: 2,
            row: 1,
            size_x: 1,
            size_y: 1,
            name : "NEWS",
            title : 'News',
            iframe : "<iframe allowfullscreen frameborder=0 src='//www.mte-media.com/admin2/frames/widgets_index.php?ref=2967923&set=embed&widg=nlist&lng=undefined' width='86%' height='800px' ></iframe>"
        },
         {
            col: 3,
            row: 1,
            size_x: 1,
            size_y: 1,
            title : 'Market Summery',
            name : "MARKET_SUMMERY",
            iframe : "<iframe allowfullscreen frameborder=0 src='//www.mte-media.com/admin2/frames/widgets_index.php?ref=2967923&set=embed&widg=day&lng=en' width='100%' height='800px' ></iframe>"
         },
        {
            col: 4,
            row: 1,
            size_x: 1,
            size_y: 1,
            title : 'Chart Analysis',
            name : "CHARTS",
            iframe : "<iframe allowfullscreen frameborder=0 src='//www.mte-media.com/admin2/frames/widgets_index.php?ref=2967923&set=embed&widg=tecan&lng=en' width='70%' height='800px' ></iframe>"
        },
        {
            col: 5,
            row: 1,
            size_x: 1,
            size_y: 1,
            title : 'Live Market Summery',
            name : "MAEKET_SUMMERY",
            iframe : "<iframe allowfullscreen frameborder=0 src='http://www.mte-media.com/admin2/frames/widgets_index.php?ref=2967923&set=embed&widg=sgnlb' width='90%' height='800px' ></iframe>"
        },
        {
            col: 6,
            row: 1,
            size_x: 1,
            size_y: 1,
            name : "FEED3",
            title : 'Pivot Calculator',
            iframe : "<iframe allowfullscreen frameborder=0 src='http://www.mte-media.com/admin2/calcs/pivot_calculator.php?id=85&set=embed' width='40%' height='800px' ></iframe>"
            
        }
        
       
      ];


      // sort serialization
      serialization = Gridster.sort_by_row_and_col_asc(serialization);
      $(function(){

        gridster = $(".gridster ul").gridster({
          widget_base_dimensions: [180,180],
          widget_margins: [8, 8],
          avoid_overlapped_widgets : false,
          max_cols : 6  ,
          max_rows : 2
        }).data('gridster');


        gridster.remove_all_widgets();
        $.each(serialization, function() {
            var item = $('<li id="'+this.name+'" class="grid-item" />');
            var panel = $('<div class="grid-panel" />');
           
            panel.append('<span class="grid-expand glyphicon glyphicon-export" />');
            panel.append('<span style="display:none" class="grid-close glyphicon glyphicon-remove-circle"></span>');
            $("#html-content").append("<div style='display:none;' id='item_"+this.name+"'>"+this.iframe+"</div>")
            item.append(panel);
            item.append('<span>'+this.title+'</span>');
            gridster.add_widget(item,this.size_x,this.size_y,this.col,this.row);
        });

        
        var expanded = null;
     
        $(".grid-expand").on('click',function(){
           expand($(this).parent().parent().attr("id"));
        });
                
        $(".grid-panel .close-icon").on('click',function(){
            close();
        });
        
        function close(){
            $("#main_control").fadeOut();
        }
        
        var expand_data;
        var last_item;
        
        function expand(item){
            $("#main_control").fadeIn();
            var el = $("#"+item).find(".html-content");
            var height = el.find("iframe").height();
            $("#main_control").animate({
                width: "100%",
                height: height+'px',
            }, 1000);
             var top = $("#controls").offset().top - 10;
                $('html, body').animate({
                    scrollTop: top
                });
                
            $("#html-content").find("#item_"+last_item).fadeOut('fast');
            $("#html-content").find("#item_"+item).fadeIn('slow');
            
            last_item = item;
        }

      });
    </script>
    
    <style type="text/css">
        .close-icon{
            font-size: 20px;
            padding: 3px;    
            cursor:pointer;
        }
        #main_control{
            background-color:#2A2A2A;
            position:relative;
        }
        .grid-item{
            color:white;
            font-size:22px;
            background:#2A2A2A;
            list-style:none;
            padding-top:85px;
            cursor:pointer;
            
        }
        .grid-panel{
            position:absolute;
            top:0px;
            color:#2A2A2A;;
            background:#ffc900;
            width:100%;
            text-align:right;
            height:30px;
            padding-top:3px;
        }
        
        
        .grid-panel span:hover{
            color:red;
        }
        
        .close-item{
            position:absolute;
            top:0px;
            right:0px;
            width:100%;
            color:#2A2A2A;;
            background:#ffc900;
        }
        
         .grid-item:hover{
             /*border:solid 3px #ffc900;*/
             
         }

         

    </style>
    
    
<?php /*
    <div id="ts" class="row ts">
        <div class="col-md-4 col-md-offset-4">
            <h2 class="white">Trading Central Platform </h2>
            <br />
            <button onclick="window.open('http://24option-hf.tradingcentral.com/login.asp?token=<?=urlencode(tradingCentral_generateToken(gethostname()))?>')" class="big-btn">Access Now</button>
        </div>
    </div>

    <div id="calendar" class="row tools">
        <iframe style="width:100%;height:500px" scrolling="no" frameborder="0" allowtransparency="true" marginwidth="0" marginheight="0" frameborder=0 src="https://www.24option.com/iframe-economic-calendar/"></iframe>
    </div>

    <div class="row tools">
        <div class="row">
            <div class="col-md-6">
                <iframe allowfullscreen frameborder=0 src='//www.mte-media.com/admin2/frames/widgets_index.php?ref=2967923&set=embed&widg=tecan&lng=en' width='100%' height='800px'></iframe>
            </div>
            <div class="col-md-6">
                <iframe style="width:100%;height:500px" src="http://earnings.forexprostools.com?ecoDayBackground=%23000000&defaultFont=%23000000&innerBorderColor=%23ffc800&borderColor=%23ffc800&ecoDayFontColor=%23030303&columns=exc_flags,symbols,exc_importance,exc_actual,exc_forecast,exc_previous,companyname,period&features=datepicker,timeselector,filters&countries=29,25,54,145,34,174,163,32,70,6,27,37,122,15,113,107,55,24,59,71,22,17,51,39,93,106,14,48,33,23,10,35,92,57,94,68,42,109,188,7,105,172,21,43,20,60,87,44,193,125,45,53,38,170,100,56,52,238,36,90,112,110,11,26,162,9,12,46,41,202,63,123,61,143,4,5,138,178,75&calType=day&lang=1" frameborder="0" allowtransparency="true" marginwidth="0" marginheight="0"></iframe>
            </div>
        </div>
    </div>
    
    <div class="row tools">
        <div class="col-md-6">
            <!-- myfxbook.com economic calendar widget - Start -->
            <script type="text/javascript" src="http://widgets.myfxbook.com/scripts/fxCalendar.js"></script>
            <!-- myfxbook.com economic calendar widget - End -->
        </div>
        <div class="col-md-6">
            <!-- myfxbook.com top news widget - Start -->
            <script type="text/javascript" src="http://widgets.myfxbook.com/scripts/fxTopNews.js"></script>
            <!-- myfxbook.com top news widget - End -->
        </div>
    </div>

    <div class="row tools">
        <iframe scrolling="no" frameborder="0" allowtransparency="true" marginwidth="0" marginheight="0" frameborder=0 style="width:100%;height:543px" src="http://market24hclock.com/html5/global_clock1.html"></iframe>
    </div>
    */?>
</div>
<?php get_footer(); ?>