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
		<h1>Assigned Instructors</h1>
	</div>
</div>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Assigned Instructors listing</h2>
				<a href="javascript:history.go(-1)" class="ui-state-default ui-corner-all float-right ui-button hide_search" style="margin-top:-10px;">Back</a>
				<span></span>
			</div>
            <?php /*?><div class="search">
                <h2>Search</h2>
                <?php echo $this->Form->create('ContactInstructor',array('id'=>'searchContactStudent')); ?>
                        <div class="search_contents">
                             <label class="desc" >Select Option</label>
                             <?php echo $this->Form->input('type',array('type'=>'select','id'=>'text_type','div'=>false, 'style'=>'width:148px; padding:4px; border:1px solid #abadb3;' ,'label'=>false,'class'=>'field text full required','options'=>array(''=>'Select','first_name'=>'Student First Name','last_name'=>'Student Last Name','email'=>'E-Mail'))); ?>
                         </div>
                         <div class="search_contents"> 
                            <label class="desc" >&nbsp;</label>
                            <?php echo $this->Form->input('text',array('text'=>'text','id'=>'typedText','div'=>false, 'style'=>'width:145px; height:25px; padding:0px 0px 0px 3px; border:1px solid #abadb3;','label'=>false,'class'=>'field text full required')); ?>
                        </div> 
                        <div class="search_contents" style="margin-top:19px;">                        
                        	<?php echo $this->Form->submit('Search',array('div'=>false,'label'=>false,'id'=>'searchContactStudentRecord','class'=>'field text full required txtts_inproperty')); ?>
                            
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
                        <?php echo $this->element('adminElements/cmsPages/assigned_instructor_list'); ?>
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