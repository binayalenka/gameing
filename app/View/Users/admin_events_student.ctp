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
	$('.hide_select').hide();
	$('#text_type').change(function(){
		
		var value = $(this).val();
		if(value=='subcategory')
		{
			$('.hide_text').hide();
			$('.hide_select').show();
		}else{
			$('.hide_text').show();
			$('.hide_select').hide();
		}
	
	});

});
</script>
<div id="sub-nav">
	<div class="page-title">
		<h1>Students Classes Listing</h1>
	</div>
</div>

<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">        
			<div class="inner-page-title">
				<h2>Students Classes Listing</h2>
                <?php /*?> <a href="javascript:history.go(-1)" class="ui-state-default ui-corner-all float-right ui-button" style="margin-top:-10px; margin-right:50px;">Back</a>
                <a href="javascript:void(0)" class="ui-state-default ui-corner-all float-right ui-button hide_search" style="margin-top:-10px; margin-right:50px;">Click here to hide/show search option</a><?php */?>
				<span></span>
			</div>
            <?php /*?><div class="search">
                <h2>Search</h2>
                <?php echo $this->Form->create('Event',array('id'=>'searchEventsForStudent')); ?>
                        <div class="search_contents">
                             <label class="desc" >Select Option</label>
                             <?php echo $this->Form->input('type',array('type'=>'select','id'=>'text_type','div'=>false, 'style'=>'width:148px; padding:4px; border:1px solid #abadb3;' ,'label'=>false,'class'=>'field text full required','options'=>array(''=>'Select','title'=>'Title','subcategory'=>'Sub-Category','zipcode'=>'ZipCode'))); ?>
                             <?php echo $this->Form->input('mem_id',array('type'=>'hidden','value'=>$loginMemId,'readonly'=>true));?>
                         </div>
                         <div class="search_contents hide_text"> 
                            <label class="desc" >&nbsp;</label>
                            <?php echo $this->Form->input('text',array('type'=>'text','id'=>'typedText','div'=>false, 'style'=>'width:145px; height:25px; padding:0px 0px 0px 3px; border:1px solid #abadb3;','label'=>false,'class'=>'field text full required')); ?>
                        </div>
                        
                        <div class="search_contents hide_select"> 
                            <label class="desc" >&nbsp;</label>
                            <?php 
							if(!empty($login_member_details['Member']['cate_id'])){
								$AllSubCate = $AllSubCate + array('0'=>$login_member_details['Member']['sub_category_name']); 
							}
							
							echo $this->Form->input('select',array('type'=>'select','options'=>array($AllSubCate),'id'=>'typedSelect','div'=>false, 'style'=>'width:148px; padding:4px; border:1px solid #abadb3;','label'=>false,'class'=>'field text full required')); ?>
                        </div>
                         
                        <div class="search_contents" style="margin-top:19px;">                        
                        	<?php echo $this->Form->submit('Search',array('div'=>false,'label'=>false,'id'=>'searchEventsForStudentSubmit','class'=>'field text full txtts_inproperty')); ?>
                            
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
			
			<div class="content-box content-box-header" id='check'>
            	<div class="loadPaginationContent">				
					<?php echo $this->element('adminElements/events/events_student_list');?>
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