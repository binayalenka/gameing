<?php  echo $this->Html->script('newadmin/sidebar_position.js');?>
<style>
#dashboard-buttons, .content-box {
    border: none;
}
</style>
<script>
$(document).ready(function(){
	$('.hide_search').live('click',function(){
		$('.search').toggle(500);
	});

});
</script>
<div id="sub-nav">
	<div class="page-title">
		<h1>Student Requests for Classes</h1>
	</div>
</div>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Student Requests for Classes</h2>
				<a href="javascript:history.go(-1)" class="ui-state-default ui-corner-all float-right ui-button hide_search" style="margin-top:-10px;">Back</a>
				<span></span>
			</div>
            
                <div class="success ui-corner-all successdeveloperClass" id="Delete">
                    <span class='successMessageText'>
                       <?php echo __('Record deleted successfully',true);?>
                    </span>
                </div>
                <div class="content-box content-box-header" style="border:none;">			
                    <div class="loadPaginationContent">	
                        <?php echo $this->element('adminElements/cmsPages/class_request_list'); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div id="sidebar">
                </div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>