<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo HTTP_ROOT?>favicon.ico" />
        <title>Admin Panel</title>

    <?php
        echo $this->Html->css('admin/admin.css');
        echo $this->Html->css('admin/developer.css');
        echo $this->Html->css('ui/ui.base.css');
        echo $this->Html->css('themes/black_rose/ui.css','stylesheet',array('title'=>'style','media'=>'all'));
        echo $this->Html->css('themes/black_rose/ui.css');	   
        echo $this->Html->css('ui/ui.datepicker.css');
    ?>

    <?php  
	echo $this->Html->script('fancybox/jquery-1.8.2.min');
	echo $this->Html->script('admin/common.js');
	echo $this->Html->script('admin/cookie.js');
	echo $this->Html->script('admin/superfish.js');
	echo $this->Html->script('admin/live_search.js');	
	echo $this->Html->script('admin/custom.js');
	echo $this->Html->script('admin/sidebar_position.js');
	
	echo $this->Html->script('ui/ui.core.js');
	echo $this->Html->script('ui/ui.widget.js');
	echo $this->Html->script('ui/ui.mouse.js');
	echo $this->Html->script('ui/ui.sortable.js');
	echo $this->Html->script('ui/ui.draggable.js');
	echo $this->Html->script('ui/ui.resizable.js');
	echo $this->Html->script('ui/ui.position.js');
	echo $this->Html->script('ui/ui.button.js');
	echo $this->Html->script('ui/ui.dialog.js');
	echo $this->Html->script('ui/ui.datepicker.js');	
	echo $this->Html->script('ui/ui.tabs.js');
	
	echo $this->Html->script('fckeditor/fckeditor.js');
    ?>
    </head>
    <body>
        <!-- Main -->
        <div id="page_wrapper">
            <div class="loading"><div class='loadingText'>Loading...</div></div>

            <div id="page-header">
				<?php echo $this->element('adminElements/header'); ?>
            </div>

		   <?php echo $content_for_layout ?>

            <div id="footer">
           		<?php echo $this->element('adminElements/footer'); ?>
            </div>
            <div id="copyright">
                Powered by <a href="#" title="Binaya">binayalenka.com</a>
            </div>

        </div>    
        <!-- Main -->
    </body>
</html>