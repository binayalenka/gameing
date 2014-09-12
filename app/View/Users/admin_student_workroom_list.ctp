<?php  echo $this->Html->script('newadmin/sidebar_position.js');?>
<style>
#dashboard-buttons, .content-box {
    border: none;
}
</style>
<div id="sub-nav">
	<div class="page-title">
		<h1>Workroom Details</h1>
        
	</div>
</div>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Workroom</h2>
                 <a style="margin-top:-10px;" class="ui-state-default ui-corner-all float-right ui-button" href="javascript:void(0);" onclick="history.go(-1);">Back</a>
                 
                 <?php /*?><a href="<?php echo HTTP_ROOT.'admin/users/add_blog/'.$id; ?>" class="ui-state-default ui-corner-all float-right ui-button" style="margin-top:-10px;  margin-right:20px;">Add Blog</a><?php */?>
                 
                 
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
                <div class="content-box content-box-header" style="border:none;">			
                    <div class="loadPaginationContent">	
                        <?php echo $this->element('adminElements/cmsPages/student_workroom_listing'); ?>
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