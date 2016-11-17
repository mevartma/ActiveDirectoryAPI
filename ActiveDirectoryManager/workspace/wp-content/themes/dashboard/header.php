<html>
<head>
<title>Tutorial theme</title>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/bootstrap/css/bootstrap.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
<link rel="stylesheet" href="http://gridster.net/dist/jquery.gridster.css" />

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/assets/jquery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="http://gridster.net/dist/jquery.gridster.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/assets/bootstrap/js/bootstrap.min.js"></script>
<script type='text/javascript' src='//cdn.jsdelivr.net/jquery.marquee/1.3.9/jquery.marquee.min.js'></script>
<?php wp_head(); ?>
</head>
<body>
<script type="text/javascript">
    $(function () {
        $('.marquee').marquee({
            duration: 5000,
            pauseOnHover: true,
            startVisible : false,
            gap : '50px',
        });
    });
    $(function () {
     $('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html, body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
      });
    });
    
    </script>


<div class="container marquee">
    <?php
        $the_query = new WP_Query( array("post_limits" => "20", "order_by" => "id" , "order" => "DESC") );
		
		while($the_query->have_posts()){
            	$the_query->the_post();
            	?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=the_permalink()?>"><?=the_title();?></a><span class="grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|</span><?php
		}
		
	?>
</div>
    
<div class="row menu">
  <nav class="navbar">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">
              <img src="https://www.24option.com/wp-content/uploads/2015/12/24option_237x60.png" />
          </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul style="float:right" class="nav navbar-nav">
            <li class="active"><a href="/">Home</a></li>
            <li><a href="/#ts">Trading Centeral</a></li>
            <li><a href="/#calendar">Calendar</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
         
        </div><!--/.nav-collapse -->
      </div>
    </nav>
</div>