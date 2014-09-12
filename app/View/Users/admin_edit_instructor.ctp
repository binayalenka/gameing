<?php echo $this->Html->script('multiple.js'); ?>
<style>
	form li span
	{
		width:100%;
	}
	tr.mceLast
	{
		display:none;
	}
	.size
	{
		width:255px !important;
		
	}
	.a_remove_edit
	{
		background: none repeat scroll 0 0 #000000;
		color: #FFFFFF;
		display: none;
		float: left;
		font-size: 12px;
		height: 18px;
		left: 0;
		line-height: 18px;
		
		opacity: 0.7;
		position: absolute;
		text-align: center;
		top: 108px;
		width: 181px;
		z-index: 111;
	}
	.a_remove_edit:hover
	{
		cursor:pointer;
	}
	.b_remove
	{
		background: none repeat scroll 0 0 #000000;
		color: #FFFFFF;
		display:none;
		margin-left: -123px;
		margin-top: 107px;   
		float: left;
		font-size: 12px;
		height: 18px;
		line-height: 18px;
		opacity: 0.7;
		position: absolute;
		text-align: center;
		z-index:111;
		width: 123px;
	}
	.b_remove:hover
	{
		cursor:pointer;
	}
	
/*18jan changes {Sahil}*/
.main_upp 
{
    float: left;
    width: 100%;
}
.lft_mainupp 
{
    float: left;
    width: 24%;
}
.ryt_mainupp 
{
    float: right;
    width: 74%;
}
.size 
{
    width: 87% !important;
}
/*18jan changes {Sahil}*/

</style>
<script>
var countClick = 0;
$(document).ready(function(){
		
		$('#tabs').tabs();
		
		$('.main_imcont').mouseenter(function(){
				
				$(this).children('.a_remove_edit').show();
				
		});
		
		$('.main_imcont').mouseleave(function(){
			
			$(this).children('.a_remove_edit').hide();
			
		});
		$('.profile_pic').mouseenter(function(){
			
				$(this).children('.b_remove').show();
				
		});
		
		$('.profile_pic').mouseleave(function(){
			
			$(this).children('.b_remove').hide();
			
		});
		
	
		$('.addMoreButtonMobile1').live('click',function(){		
			var count=$(this).attr('rel');	
			var getId=$(this).attr('id');
			var getTableField=getId.split('-');
			var html='<div class="keywordleftdetail"><input type="text" class="text_fore size" style="margin-bottom:3px;" name="data[VideoLink][video_link][]"><a href="javascript:void(0)" class="removeVideoLinks" id="'+getId+'" rel=""><img src="'+ajax_url+'/img/front/button_cancel.png" class="showLink"></a></div>';
			$('.renderVideoLink').append(html);
			
			
		});	
				
		$('.removeVideoLinks').live('click',function(){
			$(this).parent().remove();	
			var getId=$(this).attr('id');
		
			var count=$('#'+getId).attr('rel');			
			$('#'+getId).attr('rel',parseInt(count)-1);
			if(count<=3)
			{					
				$('#'+getId).show();
			}
		});	
		
		$('.hideLink').live('click',function(){
			countClick = countClick + 1;
			if(countClick == 3)
			{
				$(this).hide();
			}
		});
		$('.showLink').live('click',function(){
			countClick = countClick - 1;
			if(countClick <=3)
			{
				$('.hideLink').show();
			}
		});
		$('.add_sub_cate').live('change',function(){
			$('.img_cate').show();
			var cat_id = $(this).val();
			$.ajax({
				url:ajax_url+'admin/Users/add_sub_category/'+cat_id,
				success:function(resp){
					$('.img_cate').hide();
					$('.renderSubCat').html(resp);return false;
				}
			});
		});

		
		
		var strng = $('#count1').val();
		var a =strng.split(" ").length - 1;
		$('.showDec').text(a+1);
		
		$('#count1').live('keypress',function(e){
			var digits = $(this).val();
			var unicode=e.keyCode? e.keyCode : e.charCode
			var strng = $('#count1').val();
			if(strng == ''){
				$('.showDec').text('0');	
			}else{
				var a =strng.split(" ").length - 1;
				$('.showDec').text(a+1);	
			}

			
			if(a >= 199)
			{
				alert('Please enter only 200 words!');
			}
			if(a>199)
			{
				alert('Please enter only 200 words!');		
			}
		});
		
		// when page load first----------
		var strng = $('#count2').val();
		var a =strng.split(" ").length - 1;
		$('.showDec1').text(a+1);
		
		$('#count2').live('keypress',function(e){
			var digits = $(this).val();
			var unicode=e.keyCode? e.keyCode : e.charCode
			var strng = $('#count2').val();
			
			if(strng == ''){
				$('.showDec1').text('0');	
			}else{
				var a =strng.split(" ").length - 1;
				$('.showDec1').text(a+1);
			}

			if(a >= 499)
			{
				alert('Please enter only 500 words!');
			}
			if(a>499)
			{
				alert('Please enter only 500 words!');		
			}
		});
		
		$("#otherCheckBox").live('click',function(){
			var val = 	$("#otherCheckBox").is(':checked');
			if(val==true)
			{
				$(".otherSubCatgNameLabel").show();
				$("#otherSubCatgName").show();
				$("#otherSubCatgName").attr('disabled',false);
				$("#otherSubCatgName").val('');
				
			}else
			{
				$(".otherSubCatgNameLabel").hide();
				$("#otherSubCatgName").hide();
				$("#otherSubCatgName").attr('disabled',true);
				$("#err_sub_category_name").hide();
			}
		});

});
</script>

<div id="sub-nav">
	<div class="page-title">
		<h1>Edit Instructor</h1>
	</div>
</div>

<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Edit Instructor</h2>
                <a style="margin-top:-10px;" class="ui-state-default ui-corner-all float-right ui-button" href="javascript:void(0);" onclick="history.go(-1);">Back</a>
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
			<div class="content-box content-box-header" style="border:none;">

				<div class="column-content-box">

					<div class="ui-state-default ui-corner-top ui-box-header">

						<span class="ui-icon float-left ui-icon-notice"></span>
						Edit Instructor
					</div>
					
					<div id="tabs">
                        <ul>
                            <li><a href="#tabs1">Edit Profile</a></li>
                            <li><a href="#tabs2">Edit Images</a></li>						
                            <li><a href="#tabs3">Edit Video Links</a></li>
                        </ul> 
                     <?php 
					 $id = base64_encode(convert_uuencode($login_member_details['Member']['id']));
					 echo $this->Form->create('Member',array('id'=>'UserName','url'=>array('controller'=>'Users','action'=>'edit_instructor/'.$id,'admin'=>true),'enctype'=>'multipart/form-data')); ?>
                     
                     
					<div id="tabs1">
						<div class="content-box-wrapper">
								<?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$login_member_details['Member']['id'])); ?> 	
								<fieldset>
									<ul>
                                        <li>
											<label class="desc" >Profile Picture</label>
											<div class="profile_pic">
												<?php if(!empty($login_member_details['Member']['image']) && file_exists('files/'.$login_member_details['Member']['id'].'/'.$login_member_details['Member']['image'])) { ?>
													<?php echo $this->Html->image('../files/'.$login_member_details['Member']['id'].'/'.$login_member_details['Member']['image'],array('width'=>'125','height'=>'125'));?>
                                                    <?php echo $this->Html->link('Remove Photo',HTTP_ROOT.'Users/remove_photo_admin/'.$login_member_details['Member']['id'],array('class'=>'b_remove'));?>
                                                <?php } else  { ?>
                                                    <?php echo $this->Html->image('profile_pic.png');?>
                                                <?php } ?> 
											</div>
										</li>
                                         <li>
											<label class="desc" >Profile Picture</label>
											<div>
                                            	<?php echo $this->Form->input('image',array('type'=>'file','div'=>false,'label'=>false,'class'=>'text full field')); ?> 
                                                <p class="tutor-add-Error" id="err_image"><?php if(isset($errors['image'][0])) echo $errors['image'][0]; ?>  </p>
                                            </div>
										</li>
                                        <li>
											<label class="desc" >First Name</label>
											<div>
                                            	<?php echo $this->Form->input('first_name',array('type'=>'text','value'=>$login_member_details['Member']['first_name'],'div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_first_name"><?php if(isset($errors['first_name'][0])) echo $errors['first_name'][0]; ?>  </p>   
											</div>
										</li>   
                                         <li>
											<label class="desc" >Last Name</label>
											<div>
                                            	<?php echo $this->Form->input('last_name',array('type'=>'text','value'=>$login_member_details['Member']['last_name'],'div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_last_name"><?php if(isset($errors['last_name'][0])) echo $errors['last_name'][0]; ?>  </p>   
											</div>
										</li>
                                      
                                       <li>
											<label class="desc" >Category</label>
											<div>
                                            	<?php 
												if(!empty($login_member_details['MemberCategory'][0]['cate_id']))
												{
													$cateSelect=@$login_member_details['MemberCategory'][0]['cate_id'];
												}else{
													$cateSelect = "";
												}
												if(!empty($login_member_details['Member']['cate_id']))
												{
													$cateSelect=$login_member_details['Member']['cate_id'];
												}else{
													$cateSelect = "";
												}
												
												echo $this->Form->input('cate_id',array('type'=>'select','options'=>array(''=>__('Select'),$category_list),'selected'=>$cateSelect,'div'=>false,'label'=>false,'class'=>'text full field required add_sub_cate')); ?> 
                                             <p class="tutor-add-Error" id="err_cate_id"><?php if(isset($errors['cate_id'][0])) echo $errors['cate_id'][0]; ?>  </p>
                                             <div style="margin-right: -20px !important; margin-top:-38px; float:right; display:none !important;" class="img_cate">
												<?php echo $this->Html->image('front/wait.gif',array('height'=>'22px'));?>
                                             </div>   
										</div>
										</li>
                                        
                                        <li>
											<label class="desc" >Sub-Category</label>
											<div class="renderSubCat">
                                            	<?php
												if(isset($show_sub_cate))
												{$show_sub_cate = $show_sub_cate;}else{$show_sub_cate=0;}
												if(!empty($sub_category_list)){
													$list=$sub_category_list;
												}
												if(!empty($sub_category)){
													$list=$sub_category;
												}
												 echo $this->Form->input('sub_cate_id',array('type'=>'select','selected'=>$show_sub_cate,'multiple'=>'multiple','options'=>array(''=>__('Select'),$list),'div'=>false,'label'=>false,'class'=>'text full field required','id'=>'websites4')); ?> 
                                                
											</div>
                                            <label style="font-size:10px;">	<?php echo __('(Hold ctrl key to select multiple sub-categories)');?>	</label>                                             <p class="tutor-add-Error" id="err_sub_cate_id"><?php if(isset($errors['sub_cate_id'][0])) echo $errors['sub_cate_id'][0]; ?>  </p>
										</li>
                                        
                                        <?php echo $this->Form->input('sub_cat_name',array('type'=>'hidden','value'=>'','div'=>false,'label'=>false,'id'=>'subCatg')); ?>
                                        <li>
                                        	<div class="checkBox">
                                        		<?php echo $this->Form->input('other_sub_cat',array('type'=>'checkbox','id'=>'otherCheckBox','checked'=>$login_member_details['Member']['other_sub_cat']==1?'checked':false,'div'=>false,'label'=>false,'style'=>'width:auto;')); ?>
							   					<?php echo __('<span style="float:left; width:auto; margin:2px;"> Check this, if your Sub-Category is not available</span>');?>	                	</div>
                                        </li>
                                        
                                        <li id="sub_catg_name" class="otherSubCatgNameLabel" <?php $login_member_details['Member']['other_sub_cat']=='1'?'':'style="display:none;"';?> >
											<label class="desc">Enter Sub-Category Name</label>
											<div>
                                            	<?php echo $this->Form->input('sub_category_name',array('type'=>'text','disabled'=>$login_member_details['Member']['other_sub_cat']!=1?'disabled':false,'value'=>$login_member_details['Member']['other_sub_cat']==1?$login_member_details['Member']['sub_category_name']:'','style'=>$login_member_details['Member']['other_sub_cat']!=1?'display:none':'','div'=>false,'label'=>false,'id'=>'otherSubCatgName','class'=>'text full field ')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_sub_category_name"><?php if(isset($errors['sub_category_name'][0])) echo $errors['sub_category_name'][0]; ?></p>
											</div>
										</li>
                                        
                                         <li>
											<label class="desc" >Company Name</label>
											<div>
                                            	<?php echo $this->Form->input('company_name',array('type'=>'text','value'=>$login_member_details['Member']['company_name'],'div'=>false,'label'=>false,'class'=>'text full field ')); ?>
                                                 
											</div>
										</li>
                                        
                                        <li>
											<label class="desc" >Street Name</label>
											<div>
                                            	<?php echo $this->Form->input('street',array('type'=>'text','value'=>$login_member_details['Member']['street'],'div'=>false,'label'=>false,'class'=>'text full field ')); ?> 
                                                
                                             </div>
										</li>
                                        <li>
											<label class="desc" >Country</label>
											<div>
                                            	<?php echo $this->Form->input('country',array('type'=>'select','options'=>array(''=>__('Select'),$country_list),'value'=>$login_member_details['Member']['country'],'div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_country"><?php if(isset($errors['country'][0])) echo $errors['country'][0]; ?>  </p>   
											</div>
										</li>
                                        <li>
											<label class="desc" >State</label>
											<div>
                                            	<?php echo $this->Form->input('state',array('type'=>'text','value'=>$login_member_details['Member']['state'],'div'=>false,'label'=>false,'class'=>'text full field ')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_state"><?php if(isset($errors['state'][0])) echo $errors['state'][0]; ?>  </p>   
											</div>
										</li>
                                        <li>
											<label class="desc" >City</label>
											<div>
                                            	<?php echo $this->Form->input('city',array('type'=>'text','value'=>$login_member_details['Member']['city'],'div'=>false,'label'=>false,'class'=>'text full field ')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_city"><?php if(isset($errors['city'][0])) echo $errors['city'][0]; ?>  </p>   
											</div>
										</li>
                                        <li>
											<label class="desc" >Zip-Code</label>
											<div>
                                            	<?php echo $this->Form->input('zipcode',array('type'=>'text','value'=>$login_member_details['Member']['zipcode'],'div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_zipcode"><?php if(isset($errors['zipcode'][0])) echo $errors['zipcode'][0]; ?>  </p>   
											</div>
										</li>
                                        <li>
											<label class="desc" >Phone</label>
											<div>
                                            	<?php echo $this->Form->input('phone',array('type'=>'text','value'=>$login_member_details['Member']['phone'],'div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_phone"><?php if(isset($errors['phone'][0])) echo $errors['phone'][0]; ?>  </p>   
											</div>
										</li>
                                        
                                         <li>
											<label class="desc" >Hourly fee($)</label>
											<div>
                                            	<?php echo $this->Form->input('hourly_rate',array('type'=>'text','value'=>$login_member_details['Member']['hourly_rate'],'div'=>false,'label'=>false,'class'=>'text full field digits')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_hourly_rate"><?php if(isset($errors['hourly_rate'][0])) echo $errors['hourly_rate'][0]; ?>  </p>   
											</div>
										</li>
                                        <li>
											<label class="desc" >Facebook Page-Id</label>
											<div>
                                            	<?php echo $this->Form->input('f_id',array('type'=>'text','value'=>$login_member_details['Member']['f_id'],'div'=>false,'label'=>false,'class'=>'text full field')); ?>
                                                <p>(Ex: https://www.facebook.com/xyz)</p> 
											</div>
										</li>
                                        
                                        <li>
											<label class="desc" >Google Page-Id</label>
											<div>
                                            	<?php echo $this->Form->input('g_id',array('type'=>'text','value'=>$login_member_details['Member']['g_id'],'div'=>false,'label'=>false,'class'=>'text full field')); ?> 
                                                <p>(Ex: https://plus.google.com/123456)</p>
											</div>
										</li>
                                        
                                        <li>
											<label class="desc" >Twitter Page-Id</label>
											<div>
                                            	<?php echo $this->Form->input('t_id',array('type'=>'text','value'=>$login_member_details['Member']['t_id'],'div'=>false,'label'=>false,'class'=>'text full field')); ?> 
                                                <p>(Ex: https://www.twitter.com/xyz)</p>
											</div>
										</li>
                                        
                                        <li>
											<label class="desc" >Education </label>
											<div>
                                            	<?php echo $this->Form->input('education',array('type'=>'textarea','value'=>$login_member_details['Member']['education'],'div'=>false,'label'=>false,'oncopy'=>'return false','class'=>'text full field')); ?> 
                                             
											</div>
										</li>
                                        
                                        <li>
											<label class="desc" >Objective</label>
											<div>
                                            	<?php echo $this->Form->input('objective',array('type'=>'textarea','value'=>$login_member_details['Member']['objective'],'div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_objective"><?php if(isset($errors['objective'][0])) echo $errors['objective'][0]; ?>  </p>   
											</div>
										</li>
                                        
                                        <li>
											<label class="desc" >Experience</label>
											<div>
                                            	<?php echo $this->Form->input('experience',array('type'=>'textarea','value'=>$login_member_details['Member']['experience'],'div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                                <p class="tutor-add-Error" id="err_experience"><?php if(isset($errors['experience'][0])) echo $errors['experience'][0]; ?></p>
                                             </div>
										</li>
                                          
                                          <li>
											<label class="desc" >Primary Services <div class="countMsg"><div class="countTextClass">Words count</div> <div class="showDec"></div></div></label>
											<div>
                                            	<?php echo $this->Form->input('primary_services',array('type'=>'textarea','value'=>$login_member_details['Member']['primary_services'],'div'=>false,'label'=>false,'class'=>'text full field required','id'=>'count1','oncopy'=>'return false','onpaste'=>'return false','oncut'=>'return false')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_primary_services"><?php if(isset($errors['primary_services'][0])) echo $errors['primary_services'][0]; ?>  </p>   
											</div>
										</li>
                                        <li>
											<label class="desc" >Additional Information <div class="countMsg"><div class="countTextClass">Words count</div> <div class="showDec1"></div></div></label>
											<div>
                                            	<?php echo $this->Form->input('additional_information',array('type'=>'textarea','value'=>$login_member_details['Member']['additional_information'],'div'=>false,'label'=>false,'class'=>'text full field required','id'=>'count2','oncopy'=>'return false','onpaste'=>'return false','oncut'=>'return false')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_additional_information"><?php if(isset($errors['additional_information'][0])) echo $errors['additional_information'][0]; ?>  </p>   
											</div>
										</li>
                                         <li>
                                            <input class="sub-bttn" type="submit" value="Submit" onclick='return ajax_form("UserName","Users/validate_edit_profile_ajax","newloading")'/>
                                            <div class="newloading">
                                                <?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                                            </div> 
										</li>
									</ul>
								</fieldset>
								</div>
					</div>
				    <?php echo $this->Form->end(); ?>
                     
                    
                    <div id="tabs2">
                        <div class="content-box-wrapper">
                        <fieldset>
                            <ul>
                                <li>
                                    <div class="main_upp">
                                        <div class="lft_mainupp">
                                         <?php echo $this->Form->create('VideoLink',array('id'=>'videoLinkId','url'=>array('controller'=>'Users','action'=>'upload_link_video'),'enctype'=>'multipart/form-data')); ?>
                                          <?php echo $this->Form->input('mem_id',array('type'=>'hidden','value'=>$login_member_details['Member']['id'])); ?> 
                                            
                                            <div class="inner_lftup">
                                                    <label class="desc" >Images</label>
                                                <div>
                                                    <?php echo $this->Form->input('picture.',array('type'=>'file','div'=>false,'label'=>false,'class'=>'multi text full field')); ?>
                                                 
                                                 <p class="error_msgs" id="err_picture">
													<?php echo $this->Session->read('ErrorMessage2'); ?>
                                                    <?php $this->Session->delete('ErrorMessage2');?> 
                                                 </p>   
                                                </div>
                                            </div>
                                            <div class="inner_lftup">
                                               <input class="sub-bttn" type="submit" value="Submit"/>
                                                <div class="newloading">
                                                    <?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                                                </div>
                                    		</div>
                                            <?php echo $this->Form->end(); ?>
									</div>
                                        <div class="ryt_mainupp">
                                            <div onclick="inner_rytupp">
                                                <div class="images_container">
                                                    <h1> Images </h1>
                                                    <div class="inner_imgcont">
                                                        <?php $i=0;
                                                            if(!empty($login_member_details['VideoLink'])) { 
                                                                foreach($login_member_details['VideoLink']	as $image) {
                                                                    if($image['image']!='' && file_exists('files/'.$login_member_details['Member']['id'].'/image/'.$image['image'])) { $i++;
																		$id	= base64_encode(convert_uuencode($image['id']));
																		 $memId=base64_encode(convert_uuencode($login_member_details['Member']['id']));
                                                        ?>
                                                        <div class="main_imcont" style="position:relative;">
                                                            <?php echo $this->Html->link($this->Html->image('../files/'.$login_member_details['Member']['id'].'/image/'.$image['image']),'javascript:void(0)',array('escape'=>false));?>
                                                              <?php echo $this->Html->link('Remove Photo',HTTP_ROOT.'Users/remove_photo/'.$id.'/'.$memId,array('class'=>'a_remove_edit'));?>
                                                        </div>
                                                        <?php 		
                                                                    }
                                                                }
                                                            }if($i==0){ ?>
                                                            <P>No image found.</P>
                                                        <?php } ?>
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
								</div>
                           </li>
						</ul>
                        </fieldset>
					</div>
					</div>
                    <div id="tabs3">
                        <div class="content-box-wrapper">
                            <fieldset>
                                <ul>
                                    <li>
                                        <div class="main_upp">
                                            <div class="lft_mainupp">
                                             <?php echo $this->Form->create('VideoLink',array('id'=>'LinkId','url'=>array('controller'=>'Users','action'=>'upload_link','admin'=>true),'enctype'=>'multipart/form-data')); ?>
                                              <?php echo $this->Form->input('mem_id',array('type'=>'hidden','value'=>$login_member_details['Member']['id'])); ?> 
                                                <div class="inner_lftup">
                                                <label class="desc" >Video Links(Please enter valid youtube url)</label>
                                                    <div>
                                                        <?php echo $this->Form->input('video_link.',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field size')); ?>                                                  <p style="font-size:10px;"><?php echo __('eg:	http://www.youtube.com/watch?v=uq0deNeXaDg');?></p>
                                                        <p class="tutor-add-Error" id="err_video_link"><?php if(isset($errors['video_link'][0])) echo $errors['additional_information'][0]; ?>  </p>    
                                                    </div>
                                                    <?php echo $this->Html->link(__('Add More Video[+]',true),'javascript:void(0);',array('class'=>'addMoreButtonInput1 addMoreButtonMobile1 hideLink','id'=>'Tutor-tutor_mobile-getMoreMobileNumbers-hideMobile'));?>
                                                    
                                                     <div class="profile_formsrepeat renderVideoLink">    
                                                     
                                                     </div>
                                                </div>
                                                <div class="inner_lftup">
                                                   <input class="sub-bttn" type="submit" value="Submit" onclick='return ajax_form("LinkId","Users/validate_edit_link_ajax","newloading")'/>
                                                    <div class="newloading">
                                                        <?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                                                    </div>
                                                </div>
                                                <?php echo $this->Form->end(); ?>
                                        </div>
                                            <div class="ryt_mainupp">
                                                <div onclick="inner_rytupp">
                                                    <div class="images_container">
                                                        <h1> Videos </h1>
                                                        <div class="inner_imgcont">
                                                                <?php $i=0;
                                                                    if(!empty($login_member_details['VideoLink'])) { 
                                                                        foreach($login_member_details['VideoLink']	as $video) {
                                                                            if($video['video_link']!='') { $i++;											
                                                                                $videoUrlCount = strlen($video['video_link'])-11;
                                                                                $youtubeUniqueId = substr($video['video_link'],$videoUrlCount); 
                                                                                $vid	=	base64_encode(convert_uuencode($video['id']));
																				$memId=base64_encode(convert_uuencode($login_member_details['Member']['id']));
                                                                ?>
                                                            <div class="main_imcont" style="position:relative;">
                                                                <?php echo $this->Html->link($this->Html->image('http://img.youtube.com/vi/'.$youtubeUniqueId.'/0.jpg'),HTTP_ROOT.'admin/Users/watch_video/'.$vid,array('title'=>'Watch Video','escape'=>false));?>
                                                                <?php echo $this->Html->link('Remove Video',HTTP_ROOT.'Users/remove_video/'.$vid.'/'.$memId,array('class'=>'a_remove_edit'));?>
                                                            </div>
                                                                <?php 		
                                                                        }
                                                                    }
                                                                }if($i==0){ ?>
                                                                    <P>No video found.</P>
                                                                <?php } ?>
                                                          </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                               </li>
                            </ul>
                            </fieldset>
                        </div>
                    </div>
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
<style type="text/css">
#otherCheckBox
{
	float:left;
	width:auto;
}
.countMsg
{
	float:right;
	width:auto;
}
.countTextClass
{
	float:left;
	width:auto;
}
.showDec 
{
	float:left;
	width:auto;
}
.showDec1
{
	float:left;
	width:auto;
}
</style>