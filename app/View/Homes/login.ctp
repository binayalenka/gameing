<script type="text/javascript">
	
	$(document).ready(function(){
			
			$('#user_email').focus();
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
                    				<div class="login_left">
                     					<h4><?php echo __('Sign In'); ?></h4>
                     					<div class="login_formsholders">
                         					<?php echo $this->Form->create('Member',array('url'=>array('controller'=>'homes','action'=>'login'),'id'=>'loginForm'));?>
                         					<div class="login_formsrepeat">
                          						<label><?php echo __('Email'); ?></label>
                          						<?php echo $this->Form->input('user_name',array('type'=>'text','div'=>false,'label'=>false,'id'=>'user_email','value'=>$email_cookie)); ?>
                          						<p class="error_msgs" id="err_user_name"><?php if(isset($error['user_name'][0])) echo $error['user_name'][0]; ?>  </p>
                         					</div> 
                         
                         					<div class="login_formsrepeat">
                          						<label><?php echo __('Password'); ?></label>
                          						<?php echo $this->Form->input('password',array('type'=>'Password','div'=>false,'label'=>false,'value'=>$pass_cookie)); ?>
												<p class="error_msgs" id="err_password"><?php if(isset($error['password'][0])) echo $error['password'][0]; ?>  </p>
                         					</div>                         
                                             <div class="remember_password">
                                              <?php echo $this->Form->input('checkbox',array('type'=>'checkbox','div'=>false,'label'=>false,'checked'=>(isset($email_cookie) && $email_cookie!='')?'checked':false)); ?> 
                                              <span><?php echo __('Remember me on this computer.');?></span>                                              
                                             </div> 
                         
                         					<div class="login_submit">
                         						<?php echo $this->Form->submit('',array('class'=>'ui-state-default ui-corner-all float-left ui-button','type'=>'submit','onclick'=>'return ajax_form("loginForm","Homes/login_check_ajax","loginLoading")')); ?>
						 
                         					</div>
                         					<div class="loginLoading">
												<?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
						 					</div> 
                         				<?php echo $this->Form->end(); ?>
                         				<div class="login_forgotpassword">
											<?php echo $this->Html->link('Forgot Password?',HTTP_ROOT.'Homes/get_password'); ?>
                                        </div>
                     				</div>
                    			</div>
                                <div class="main_lftlogin">
                                    <div class="login_right_description">
                                        <?php echo $info['CmsPage']['description']; ?>
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
<style> /* -PROBLEM CREATING --*/
.login_right_description
{
	width:93%;
}
.login_left
{
	border-right:none;
}
</style>