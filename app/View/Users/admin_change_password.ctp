<style>
	form li span
	{
		width:100%;
	}
	tr.mceLast
	{
		display:none;
	}
</style>
<div id="sub-nav">
	<div class="page-title">
		<h1>Change Password</h1>
	</div>
</div>


<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Change Password</h2>
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

						Change Password

					</div>
					
					<div id="tabs"> 
                     <?php echo $this->Form->create('ChangePass',array('id'=>'pass','url'=>array('controller'=>'users','action'=>'change_password'))); ?>
						<div id="tabs1">
								<div class="content-box-wrapper">
								<?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$username['Admin']['id'])); ?> 	
								<fieldset>
									<ul>
                                        <li>
											<label class="desc" >Old Password</label>
											<div>
                                            	<?php echo $this->Form->input('old_pass',array('type'=>'password','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_old_pass"><?php if(isset($error['old_pass'][0])) echo $error['old_pass'][0]; ?>  </p>   
											</div>
										</li>    
										<li>
											<label class="desc" >New Password</label>
											<div>
                                            	
                                             <?php echo $this->Form->input('new_pass',array('type'=>'password','div'=>false,'label'=>false,'class'=>'text full field required')); ?>    
                                             <p class="tutor-add-Error" id="err_new_pass"><?php if(isset($error['new_pass'][0])) echo $error['new_pass'][0]; ?>  </p>   
											</div>
										</li>
                                        <li>
											<label class="desc" >Confirm Password</label>
											<div>
                                            	<?php echo $this->Form->input('con_pass',array('type'=>'password','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_con_pass"><?php if(isset($error['con_pass'][0])) echo $error['con_pass'][0]; ?>  </p>   
											</div>
										</li>
                                        <li>
                                            <input class="sub-bttn" type="submit" value="Submit" onclick='return ajax_form("pass","Users/validate_change_password_ajax","newloading") '/>
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
				<!--	
					<ul class="sidebar-position">
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