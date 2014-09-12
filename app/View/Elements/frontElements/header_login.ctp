<script type="text/javascript">

	$(document).ready(function(){
		$('#MemberUserName').focus();	
	});
	
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="index_headerbg"><div class="logo_signincontainer">
        	<div class="logo_container">
            	<a href="<?php echo HTTP_ROOT ;?>">
              		<?php echo $this->Html->image('logo.png',array('width'=>'222','height'=>'53')); ?> 
				</a>
			</div>
			<div class="header_rightsignin">
            	<h5>Sign In</h5>
            		<?php echo $this->Form->create('Member',array('url'=>array('controller'=>'homes','action'=>'login'),'id'=>'loginForm'));?>
                    <?php echo $this->Form->input('event_id',array('type'=>'hidden','value'=>$eventId)); ?> 
               <div class="outer_btntxt"> 	    
                    <div class="sign_informs">
                        <h6>E-mail</h6>
                            <?php echo $this->Form->input('user_name',array('type'=>'text','value'=>$email_cookie,'div'=>false,'label'=>false)); ?>
                        <p class="error_msgs" id="err_user_name"><?php if(isset($error['user_name'][0])) echo $error['user_name'][0]; ?>  </p>
                    </div>
                    <div class="sign_informs">
                        <h6>Password</h6>
                            <?php echo $this->Form->input('password',array('type'=>'Password','value'=>$pass_cookie,'div'=>false,'label'=>false)); ?>
                        <p class="error_msgs" id="err_password"><?php if(isset($error['password'][0])) echo $error['password'][0]; ?>  </p>
                    </div>
                    <div class="submit_header">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td valign="top">
                                    <?php echo $this->Form->submit('',array('class'=>'ui-state-default ui-corner-all float-left ui-button btn_mg','onclick'=>'return ajax_form("loginForm","Homes/login_check_ajax","loginHeaderLoading")')); ?>
                                </td>
                            </tr>
                        </table>
                        <div class="loginHeaderLoading">
                            <?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                        </div>
                    </div>
                </div>
                <div class="remember_password">
                    <?php echo $this->Form->input('checkbox',array('type'=>'checkbox','checked'=>(isset($email_cookie) && $email_cookie!='')?'checked':false,'div'=>false,'label'=>false)); ?> 
                    <span>
                    	<div class='remeberText'>Remember me on this computer.</div>
                        <div class="forgot_password"><?php echo $this->Html->link('Forgot Password?',HTTP_ROOT.'Homes/get_password'); ?></div>
                    </span>
                    
                </div>
                
                
					<?php echo $this->Form->end(); ?>
			</div>
        	<div class="clear"></div>
		</div>
		</td>
	</tr>
</table>


