<?php  echo $this->Html->script('newadmin/sidebar_position.js');?>
<div id="sub-nav">
	<div class="page-title">
		<h1>Frequently Asked Questions</h1>
	</div>
</div>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2> FAQs Pages Listing</h2>
				<a href="<?php echo HTTP_ROOT.'admin/users/add_faq'; ?>" class="ui-state-default ui-corner-all float-right ui-button" style="margin-top:-10px;">Add Faq</a>
				<span></span>
			</div>
			 <?php if($this->Session->check('success')){ ?>
				<div class="success ui-corner-all successdeveloperClass" id="success">
					<span class='successMessageText'>
					   <?php echo $this->Session->read('success');?>
                    </span>
				</div>
				<?php $this->Session->delete('success'); ?>
			<?php } ?>
            
            <div class="success ui-corner-all successdeveloperClass" id="Delete">
                <span class='successMessageText'>
                   <?php echo __('Record deleted successfully',true);?>
                </span>
			</div>
            <div class="success ui-corner-all successdeveloperClass" id="Update">
                <span class='successMessageText'>
                   <?php echo __('Status updated successfully',true);?>
                </span>
			</div>
            
			<div class="content-box content-box-header" style="border:none;">			
				<div class="loadPaginationContent">	
					<?php echo $this->element('adminElements/cmsPages/faq_list'); ?>
				</div>
			</div>
			<div class="clearfix"></div>
			<div id="sidebar">
				<?php // echo $this->element('adminElements/left_right_bar');?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>