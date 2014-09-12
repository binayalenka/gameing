<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="fb:app_id" content="121166684733943" />
<meta property="og:site_name" content="Gamesite" />
<meta property="og:title" content="Gamesite" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://www.binayalenka.com" />
<meta property="og:image" content="https://www.binayalenka.com/img/facebook.png" />
<meta property="og:description" content="" /> 

<link rel="shortcut icon" href="<?php echo HTTP_ROOT?>favicon.ico" />
<!--CSS included-->
<?php echo $this->Html->Css('front/developer.css'); ?>
<?php echo $this->Html->Css('front/style.css'); ?>
<?php echo $this->Html->Css('front/skins/tango/skin.css'); ?>
<?php //echo $this->Html->Css('front/dd.css'); ?>
<?php //echo $this->Html->Css('front/faq.css'); ?>
<?php // echo $this->Html->css('front/colortip-1.0-jquery.css'); ?>

<!--CSS included-->

<!--JS included-->
<?php 
	echo $this->Html->script('jquery-1.8.1.min.js');
	//echo $this->Html->script('fancybox/jquery-1.8.2.min'); 
	echo $this->Html->script('front/jquery.jcarousel.min.js');
	//echo $this->Html->script('front/test.js');
	//echo $this->Html->script('front/external1.js');
	//echo $this->Html->script('admin/common.js');
	//echo $this->Html->script('front/front.js');
	//echo $this->Html->script('front/colortip-1.0-jquery.js');
?>	
<!--JS included-->
<title><?php echo $title_for_layout;?></title>
</head>
<body>
 <div class="contatiner">
	<div class="container_inner">
		<div id="header">
    <!--<div class="page_outer">-->
        <?php echo $this->element('frontElements/header') ;?>
      <!--Mid Section Start-->
       <?php echo $content_for_layout; ?>
      <!--Mid Section End-->
      <?php echo $this->element('frontElements/footer');?>
    </div>
            </div>
     </div>
</body>
</html>
