<?php echo $this->Html->script('jquery.validate.js'); ?>
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
		<h1>Categories</h1>
	</div>
</div>

<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">        
			<div class="inner-page-title">
				<h2>Categories Listing</h2>
                <a href="<?php echo HTTP_ROOT.'admin/users/add_categories'; ?>" class="ui-state-default ui-corner-all float-right ui-button" style="margin-top:-10px;">Add Category</a>
				<a href="javascript:void(0)" class="ui-state-default ui-corner-all float-right ui-button hide_search" style="margin-top:-10px; margin-right:50px;">Click here to hide/show search option</a>
				<span></span>
			</div>
            <div class="search" >
                	<h2>Search</h2>
                    <?php echo $this->Form->create('Category',array('id'=>'seacrhCategory','url'=>array('controller'=>'Users','action'=>'categories','admin'=>true))); ?>
                         
                         <div class="search_contents"> 
                            <label class="desc" >Enter Category Name &nbsp;</label>
                            
                            <?php echo $this->Form->input('name',array('type'=>'text','id'=>'category_search','div'=>false, 'style'=>'width:145px; height:25px; padding:0px 0px 0px 3px; border:1px solid #abadb3;','label'=>false,'class'=>'field text full required')); ?> 
                        	
                        </div>  
                        <div class="search_contents" style="margin-top:19px;">                        
                        	<input class="sub-bttn" id="searchCategorySubmit" type="submit" value="Submit" />                   
                      </div>  
                      <div class="adminTutorSearchWait">
						<?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                    </div>    
                       <?php echo $this->Form->end(); ?>                
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
					<?php echo $this->element('adminElements/cmsPages/categories_list');?>
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