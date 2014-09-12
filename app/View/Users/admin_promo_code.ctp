<div id="sub-nav">
	<div class="page-title">
		<h1>Promo Code Listing</h1>
	</div>
</div>

<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">        
			<div class="inner-page-title">
				<h2>Promo Code Listing</h2>
                <a href="<?php echo HTTP_ROOT.'admin/users/add_promo_code'; ?>" class="ui-state-default ui-corner-all float-right ui-button" style="margin-top:-10px;">Add Promo Code</a>
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
                   <?php echo __('Record deleted successfully',true);?>
                </span>
			</div>
            <div class="success ui-corner-all successdeveloperClass" id="Update">
                <span class='successMessageText'>
                   <?php echo __('Status updated successfully',true);?>
                </span>
			</div>
              
            
			<div class="content-box content-box-header" id='check'>
            	<div class="loadPaginationContent">				
					<?php echo $this->element('adminElements/cmsPages/promo_code_list');?>
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