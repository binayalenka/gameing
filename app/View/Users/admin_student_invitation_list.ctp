<?php  echo $this->Html->script('newadmin/sidebar_position.js');?>
<style>
#dashboard-buttons, .content-box {
    border: none;
}
</style>
<div id="sub-nav">
	<div class="page-title">
		<h1>Student Invitation</h1>
	</div>
</div>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2> Student Invitation Listing</h2>
				
				<span></span>
			</div>
            <?php /*?><div class="search">
                	<h2>Search</h2>
                    <?php echo $this->Form->create('SubCategory',array('id'=>'subCateId')); ?>
                        <div class="search_contents">
                             <label class="desc" >Select Option</label>
                                <?php echo $this->Form->input('c_id',array('type'=>'select','id'=>'category_id','div'=>false, 'style'=>'width:148px; padding:4px; border:1px solid #abadb3;' ,'label'=>false,'class'=>'field text full required','options'=>array(''=>'Select Category',$category_list),'value'=>($this->Session->check('SubCategory.c_id')) ? $this->Session->read('SubCategory.c_id') : '')); ?>
                                <p class="error_msgs" style="color: #B50007;" id="err_c_id"><?php if(isset($error['c_id'][0])) echo $error['c_id'][0]; ?></p>
                         </div> 
                         <div class="search_contents"> 
                            <label class="desc" >&nbsp;</label>
                            <?php echo $this->Form->input('name',array('type'=>'text','id'=>'subCatgName','div'=>false, 'style'=>'width:145px; height:25px; padding:0px 0px 0px 3px; border:1px solid #abadb3;','label'=>false,'class'=>'field text full','value'=>($this->Session->check('SubCategory.c_id')) ? $this->Session->read('SubCategory.name') : '')); ?> 
                          </div>  
                        <div class="search_contents" style="margin-top:19px;">                        
                        	<input class="sub-bttn" type="submit" value="Submit" onclick='return ajax_form("subCateId","Users/validate_search_sub_categories_ajax","newloading")'/>                        
                      </div>  
                      <div class="adminTutorSearchWait">
						<?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                    </div>    
                       <?php echo $this->Form->end(); ?>                
                </div><?php */?>
                
                <div class="success ui-corner-all successdeveloperClass" id="Delete">
                    <span class='successMessageText'>
                       <?php echo __('Record deleted successfully',true);?>
                    </span>
                </div>
                
                <div class="content-box content-box-header" style="border:none;">			
                    <div class="loadPaginationContent">	
                        <?php echo $this->element('adminElements/cmsPages/student_invitation_list'); ?>
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