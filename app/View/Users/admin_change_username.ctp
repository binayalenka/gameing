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
		<h1>Edit Username and E-mail Id</h1>
	</div>
</div>

<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Edit Username and E-mail Id</h2>
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
						
					</div>
					
					<div id="tabs"> 
                     <?php echo $this->Form->create('ChangeUserName',array('id'=>'UserName','url'=>array('controller'=>'users','action'=>'change_username'))); ?>
						<div id="tabs1">
								<div class="content-box-wrapper">
								<?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$username['Admin']['id'])); ?> 	
								<fieldset>
									<ul>
                                        <li>
											<label class="desc" >Old Username</label>
											<div>
                                            	<?php echo $this->Form->input('username',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_username"><?php if(isset($error['username'][0])) echo $error['username'][0]; ?>  </p>   
											</div>
										</li>   
                                         <li>
											<label class="desc" >New Username</label>
											<div>
                                            	<?php echo $this->Form->input('newusername',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_newusername"><?php if(isset($error['newusername'][0])) echo $error['newusername'][0]; ?>  </p>   
											</div>
										 </li>  
                                         
                                         <li>
											<label class="desc" >Email Id</label>
											<div>
                                            	<?php echo $this->Form->input('email',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required','value'=>$username['Admin']['email'])); ?> 
                                                
                                             <p class="tutor-add-Error" id="err_email"><?php if(isset($error['email'][0])) echo $error['email'][0]; ?>  </p>   
											</div>
										</li>     
										 <li>
                                            <input class="sub-bttn" type="submit" value="Submit" onclick='return ajax_form("UserName","Users/validate_username_ajax","newloading") '/>
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