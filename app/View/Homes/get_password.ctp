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
                     <h4><?php echo __('Forgot Password');?></h4>
                     <div class="login_formsholders">
                         <?php echo $this->Form->create('Member',array('url'=>array('controller'=>'Homes','action'=>'get_password'),'id'=>'password'));?>
                         <div class="login_formsrepeat">
                          <label><?php echo __('Enter Email Id'); ?></label>
                          <?php echo $this->Form->input('user_name',array('type'=>'text','div'=>false,'label'=>false)); ?>
                          <p class="error_msgs" id="err_user_name" style="width:150px;"><?php if(isset($error['user_name'][0])) echo $error['user_name'][0]; ?>  </p> 
                         </div>
                         	
                         <div class="login_submit">
                         <?php echo $this->Form->submit('',array('class'=>'ui-state-default ui-corner-all float-left ui-button','type'=>'submit','onclick'=>'return ajax_form_new("password","Homes/email_check_ajax","loginLoading")')); ?>
						 
                         </div>
                         <div class="loginLoading">
							<?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
						 </div> 
                         <?php echo $this->Form->end(); ?>
                     </div>
                    </div>
                    <div class="ryt_msgcont">
                    	<div class="ryt_msgcontainer">
                        	<div class="main_r8msg">
                        	<p> <strong><?php echo __('Note:'); ?> </strong>
							<?php echo __('Please make sure to fill in the correct Email ID because your password will only be sent to the Email Id you are registered with. After submitting this form please check your mail where you will get your PASSWORD within a few minutes. </p> <p> Thanks for Joining Us !'); ?></p>
                            </div>
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
.login_left{border-right:none;  width:100%;}
.login_formsholders { width:41%; margin-left:293px;}
</style>