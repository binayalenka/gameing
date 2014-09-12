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
		<h1>Promotion Listing</h1>
	</div>
</div>

<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">        
			<div class="inner-page-title">
				<h2>Promotion Listing</h2>
                <?php /*?><a href="<?php echo HTTP_ROOT.'admin/users/add_instructor'; ?>" class="ui-state-default ui-corner-all float-right ui-button" style="margin-top:-10px;">Add Instructor</a>
                <a href="javascript:void(0)" class="ui-state-default ui-corner-all float-right ui-button hide_search" style="margin-top:-10px; margin-right:50px;">Click here to hide/show search option</a><?php */?>
				<span></span>
			</div>
            
			
			<?php if($this->Session->check('SuccessMessage')){ ?>
				<div class="success ui-corner-all successdeveloperClass" id="success">
					<span class='successMessageText'>
					   <?php echo $this->Session->read('SuccessMessage');?>
                    </span>
				</div>
				<?php $this->Session->delete('SuccessMessage'); ?>
			<?php } ?>
            
			<div class="success ui-corner-all successdeveloperClass" id="Delete">
                <span class='successMessageText'>
                   <?php echo __('Records deleted successfully',true);?>
                </span>
			</div>
            <div class="success ui-corner-all successdeveloperClass" id="Update">
                <span class='successMessageText'>
                   <?php echo __('Status updated successfully',true);?>
                </span>
			</div>
              
			<div class="content-box content-box-header" id='check'>
            	<div class="loadPaginationContent">				
					<?php echo $this->element('adminElements/teacher/promotion_list');?>
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
