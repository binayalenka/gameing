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

</style>
<script>
var countClick = 0;
$(document).ready(function(){
		
		$('#tabs').tabs();
		
});
</script>

<div id="sub-nav">
	<div class="page-title">
		<h1>Edit Student</h1>
	</div>
</div>

<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Edit Student</h2>
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

						Edit Student

					</div>
					
					<div id="tabs">
                        <ul>
                            <li><a href="#tabs1">Edit Profile</a></li>
                            
                        </ul> 
                        
                     <?php 
					 $id = base64_encode(convert_uuencode($login_member_details['Member']['id']));
					 echo $this->Form->create('Member',array('id'=>'UserName','url'=>array('controller'=>'Users','action'=>'edit_student/'.$id,'admin'=>true),'enctype'=>'multipart/form-data')); ?>
					<div id="tabs1">
						<div class="content-box-wrapper">
								<?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$login_member_details['Member']['id'])); ?> 	
								<fieldset>
									<ul>
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
											<label class="desc" >Profile Picture</label>
											<div>
                                            	<?php echo $this->Form->input('image',array('type'=>'file','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                                <p class="tutor-add-Error" id="err_image"><?php if(isset($errors['image'][0])) echo $errors['image'][0]; ?>  </p>
                                            </div>
										</li>
                                        <li>
											<label class="desc" >Street Name</label>
											<div>
                                            	<?php echo $this->Form->input('street',array('type'=>'text','value'=>$login_member_details['Member']['street'],'div'=>false,'label'=>false,'class'=>'text full field ')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_street"><?php if(isset($errors['street'][0])) echo $errors['street'][0]; ?>  </p>   
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
                                            <input class="sub-bttn" type="submit" value="Submit" onclick='return ajax_form("UserName","Users/validate_edit_student_profile_ajax","newloading")'/>
                                            <div class="newloading">
                                                <?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                                            </div> 
										</li>
									</ul>
								</fieldset>
								</div>
					</div>
				    <?php echo $this->Form->end(); ?>
                     
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
</div>
