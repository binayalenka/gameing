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
		<h1>Assignment Assigned</h1>
	</div>
</div>

<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">        
			<div class="inner-page-title">
				<h2>Assignment Assigned Student List</h2>
                <a href="javascript:history.go(-1);" class="ui-state-default ui-corner-all float-right ui-button" style="margin-top:-10px;">Back</a>
               <?php /*?> <a href="<?php echo HTTP_ROOT.'admin/Users/add_student'; ?>" class="ui-state-default ui-corner-all float-right ui-button" style="margin-top:-10px;">Add Student</a>
				<a href="javascript:void(0)" class="ui-state-default ui-corner-all float-right ui-button hide_search" style="margin-top:-10px; margin-right:50px;">Click here to hide/show search option</a><?php */?>
				<span></span>
			</div>
           <?php /*?> <div class="search">
                	<h2>Search</h2>
                    <?php echo $this->Form->create('Member',array('id'=>'searchStudent')); ?>
                        <div class="search_contents">
                             <label class="desc" >Select Option</label>
                             <?php echo $this->Form->input('type',array('type'=>'select','id'=>'text_type','div'=>false, 'style'=>'width:148px; padding:4px; border:1px solid #abadb3;' ,'label'=>false,'class'=>'field text full required','options'=>array(''=>'Select','first_name'=>'First Name','last_name'=>'Last Name','email'=>'E-mail Id','phone'=>'Phone','zipcode'=>'Zip-Code'))); ?>
                         </div>
                         <div class="search_contents"> 
                            <label class="desc" >&nbsp;</label>
                            <?php echo $this->Form->input('text',array('text'=>'text','id'=>'typedText','div'=>false, 'style'=>'width:145px; height:25px; padding:0px 0px 0px 3px; border:1px solid #abadb3;','label'=>false,'class'=>'field text full required')); ?>
                        </div> 
                       <div class="search_contents" style="margin-top:19px;">                        
                        	<?php echo $this->Form->submit('Search',array('div'=>false,'label'=>false,'id'=>'searchStudentRecord','class'=>'field text full required txtts_inproperty')); ?>
                            
                      </div>  
                      <div class="adminTutorSearchWait">
						<?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                      </div>    
                   <?php echo $this->Form->end(); ?>                
             </div><?php */?>
			
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
			<div class="content-box content-box-header" id='check'>
            	<div class="loadPaginationContent">				
					<?php echo $this->element('adminElements/events/assigned_student_list');?>
                </div>   
               <!-- <ul class="sidebar-position">
                    <li class="float-left" style="margin-top:20px;"> <a title="Left Sidebar" id="sidebar-left" href="javascript:void(0);" class="btn ui-state-default ui-corner-all"> <span class="ui-icon ui-icon ui-icon-arrowthick-1-w"></span> Left Sidebar </a> </li>
                    <li class="float-right"  style="margin-top:20px;"> <a title="Right Sidebar" id="sidebar-right" href="javascript:void(0);" class="btn ui-state-default ui-corner-all"> <span class="ui-icon ui-icon ui-icon-arrowthick-1-e"></span> Right Sidebar </a> </li>
                </ul>
				-->
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