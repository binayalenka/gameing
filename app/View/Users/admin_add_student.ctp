<div id="sub-nav">
	<div class="page-title">
		<h1>Add Student</h1>
	</div>
</div>

<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Add Student</h2>
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
						Add Student
                        </div>
					
					 <?php echo $this->Form->create('Member',array('id'=>'UserName','url'=>array('controller'=>'Users','action'=>'add_student','admin'=>true))); ?>
                    <div class="content-box-wrapper">
                 	
                    <?php echo $this->Form->input('terms',array('type'=>'hidden','value'=>'1','readonly'=>true,'div'=>false,'label'=>false)); ?>
                    <?php echo $this->Form->input('member_type',array('type'=>'hidden','value'=>'2','readonly'=>true,'div'=>false,'label'=>false)); ?>
                    <fieldset>
                    <ul>
                        <li>
                            <label class="desc" >First Name</label>
                            <div>
                                <?php echo $this->Form->input('first_name',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_first_name"><?php if(isset($error['first_name'][0])) echo $error['first_name'][0]; ?>  </p>   
                            </div>
                        </li>   
                         <li>
                            <label class="desc" >Last Name</label>
                            <div>
                                <?php echo $this->Form->input('last_name',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_last_name"><?php if(isset($error['last_name'][0])) echo $error['last_name'][0]; ?>  </p>   
                            </div>
                        </li>
                        
                        <li>
                            <label class="desc" >E-Mail</label>
                            <div>
                                <?php echo $this->Form->input('email',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_email"><?php if(isset($error['email'][0])) echo $error['email'][0]; ?>  </p>   
                            </div>
                        </li>
                        <li>
                            <label class="desc" >Password</label>
                            <div>
                                <?php echo $this->Form->input('fpassword',array('type'=>'password','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_fpassword"><?php if(isset($error['fpassword'][0])) echo $error['fpassword'][0]; ?>  </p>   
                            </div>
                        </li>
                        <li>
                            <label class="desc" >Confirm-Password</label>
                            <div>
                                <?php echo $this->Form->input('Cpassword',array('type'=>'password','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_Cpassword"><?php if(isset($error['Cpassword'][0])) echo $error['Cpassword'][0]; ?>  </p>   
                            </div>
                        </li>
                        
                        <li>
                            <label class="desc" >Zip-Code</label>
                            <div>
                                <?php echo $this->Form->input('zipcode',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_zipcode"><?php if(isset($error['zipcode'][0])) echo $error['zipcode'][0]; ?>  </p>   
                            </div>
                        </li>
                        <li>
                            <input class="sub-bttn" type="submit" value="Submit" onclick='return ajax_form("UserName","Users/validate_add_profile_ajax","newloading")'/>
                            <div class="newloading">
                                <?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                            </div> 
                        </li>
                    </ul>
                    </fieldset>
                    </div>
                    <?php echo $this->Form->end(); ?>
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