<script type="text/javascript">

	$(document).ready(function(){
		$('#category').change(function(){
			
			var category_id = $(this).val();
			if(category_id!='')
			{
				$.post(ajax_url+'homes/findSubCategory', { category_id : category_id }, function(resp){ 
					$('#subCategory').html(resp);
					
				});
			}
		});
		$('#otherSubCategoryCheck').click(function(){
			if($('#otherSubCategoryCheck').is(':checked')){
				$('#otherSubCategory').show();
				$('#otherSubCategory').val('');
				$('#otherSubCategory').attr('disable',true);
			}else{
				$('#otherSubCategory').hide();
				$('#otherSubCategory').attr('disable',false);
			}
		});
	});

</script>
<div class="mid_sectionmain">
    <div class="mid_sectionholders">
    	<div class="mid_outerarea">
        	<div class="middle_bg">
          		<div class="instructor_profileinner">
            		<div class="instructor_innermain">
              			<div class="instructor_innerspaces">
                			<div class="instructor_innerbg">
                  				<div class="instructor_innerbgspace">
                    				<div class="search_main">
                      					<h5>
											<?php echo __('Search Results'); ?>
                                             <div class="admin_cont">
                                                <a href="<?php echo HTTP_ROOT.'Homes/request_class';?>" class="button_image_for_all"> <?php echo __('Request For Class'); ?></a>                                                
                                            </div>
                                        </h5>
                                        <?php echo $this->Form->create('Member',array('id'=>'searchInstructorForm'));?>
                                            <div class="search_dropbox">
                                                <h6><?php echo __('Select Category'); ?></h6>
                                                <h6><?php echo __('Select Country'); ?></h6>
                                                <div class="search_leftbox">
                                                    <?php echo $this->Form->input('cate_id',array('type'=>'select','options'=>array(''=>__('Select Category'),$category_list),'id'=>'category','style'=>'width:247px;','div'=>false,'label'=>false)); ?>
                                                </div>
                             
                                                <div class="search_leftbox">
                                                    <?php echo $this->Form->input('country',array('type'=>'select','options'=>array(''=>__('Select Country'),$country_list),'id'=>'websites2','style'=>'width:247px;','div'=>false,'label'=>false)); ?>
                                                </div>
                                            </div>
                                            
                                            <div class="search_dropbox">
                                                <h6><?php echo __('Select Sub Category'); ?></h6>
                                                <h6><?php echo __('Zipcode/Pincode'); ?> </h6>
                                                <div class="search_leftbox">
                                                    <?php echo $this->Form->input('sub_cate_id',array('type'=>'select','options'=>array(''=>__('Select Sub Category')),'id'=>'subCategory','style'=>'width:247px;','div'=>false,'label'=>false)); ?>
                                                </div>                                                
                                                <div class="search_leftbox">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td colspan="2" height="0"></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="38%">
                                                                <?php echo $this->Form->input('zipcode',array('type'=>'text','div'=>false,'label'=>false));?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                            	</div>
                                        	</div>
                                            <div class="search_dropbox" style="margin-top:-20px;"> 
                                                <h6>
												<?php echo $this->Form->input('checkbox',array('type'=>'checkbox','id'=>'otherSubCategoryCheck','div'=>false,'class'=>false,'label'=>'Click here if your sub-category not available'));?>
                                                </h6>
                                                <div class="search_leftbox">
                                                <?php echo $this->Form->input('other_subcategory',array('type'=>'text','id'=>'otherSubCategory','div'=>false,'label'=>false,'style'=>'display:none')); ?>
                                                </div>                                                
                                                <div class="search_leftbox">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>                                                           
                                                            <td width="62%">
                                                                <div class="search">
                                                                    <?php echo $this->Form->input('',array('type'=>'submit','label'=>false,'div'=>false,'id'=>'SeacrhInstructor'))?>
                                                                </div>
                                                                <div class="seacrhImage" style="display: none;">
                                                                    <?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                            	</div>                                                
                                        	</div>
                                    <?php echo $this->Form->end();?>
                                	<div class="loadPaginationContent">
                                	</div>
                                </div>
                    			<div class="clear"></div>
                  			</div>
                		</div>
                		<div class="clear"></div>
              		</div>
            	</div>
            	<div class="clear"></div>
          	</div>
        </div>
     </div>
   </div>
   <div class="clear"></div>
</div>
<style>
.sub_category{
	display:none;
	margin-left:10px;
}
</style>