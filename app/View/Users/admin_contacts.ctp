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
		<h1>Contacts</h1>
	</div>
</div>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2> Contacts Listing</h2>
				<a href="javascript:void(0)" class="ui-state-default ui-corner-all float-right ui-button hide_search" style="margin-top:-10px;">Click here to hide/show search option</a>
				<span></span>
			</div>
            <div class="search">
                <h2>Search</h2>
                <?php echo $this->Form->create('Contact',array('id'=>'searchContact')); ?>
                        <div class="search_contents">
                             <label class="desc" >Select Option</label>
                             <?php echo $this->Form->input('type',array('type'=>'select','id'=>'text_type','div'=>false, 'style'=>'width:148px; padding:4px; border:1px solid #abadb3;' ,'label'=>false,'class'=>'field text full required','options'=>array(''=>'Select','first_name'=>'First Name','last_name'=>'Last Name','email'=>'E-mail Id'))); ?>
                         </div>
                         <div class="search_contents"> 
                            <label class="desc" >&nbsp;</label>
                            <?php echo $this->Form->input('text',array('text'=>'text','id'=>'typedText','div'=>false, 'style'=>'width:145px; height:25px; padding:0px 0px 0px 3px; border:1px solid #abadb3;','label'=>false,'class'=>'field text full required')); ?>
                        </div> 
                        <div class="search_contents" style="margin-top:19px;">                        
                        	<?php echo $this->Form->submit('Search',array('div'=>false,'label'=>false,'id'=>'searchContactRecord','class'=>'field text full required txtts_inproperty')); ?>
                            
                      </div>  
                      <div class="adminTutorSearchWait">
						<?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                      </div>    
                 <?php echo $this->Form->end(); ?>                
           		</div>
                <div class="success ui-corner-all successdeveloperClass" id="Delete">
                    <span class='successMessageText'>
                       <?php echo __('Record deleted successfully',true);?>
                    </span>
                </div>
                                
                <div class="content-box content-box-header" style="border:none;">			
                    <div class="loadPaginationContent">	
                        <?php echo $this->element('adminElements/cmsPages/contact_list'); ?>
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