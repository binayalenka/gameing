<div class="mid_sectionmain">
	<div class="mid_sectionholders">
		<div class="mid_outerarea">
        	<div class="middle_bg">
        	<?php if($this->Session->check('SuccessMessage')) { ?>
                <div class="msg_top">
				<?php echo $this->Session->read('SuccessMessage'); ?>
                <?php $this->Session->delete('SuccessMessage');?>                   
                </div>
             <?php } ?>
          		<div class="new_registration_outr">
                	<div class="new_registration_inner"> 
                    	<div class="mid_innerbg_signup"> 
							<h5><?php echo __('Sign Up'); ?></h5>
							<?php echo $this->Form->create('Member',array('url'=>array('controller'=>'Homes','action'=>'index'),'id'=>'homeIndex')); ?>
								
								<?php 
									if(!empty($t_id) && !empty($e_id)){
										echo $this->Form->input('t_id',array('type'=>'hidden','value'=>$t_id,'div'=>false,'label'=>false));
										echo $this->Form->input('e_id',array('type'=>'hidden','value'=>$e_id,'div'=>false,'label'=>false)); 
									}
								?>
                                <div class="outer_signupyu">
                                	<div class="mid_chkboxarea_new" style="margin-bottom:15px;">
                                        <?php if(!empty($t_id) && !empty($e_id)){
                                            $options = array('2'=>'Student');
                                        }else{
                                            $options = array('1'=>'Instructor','2'=>'Student');
                                        }
                                        ?>
                                        <?php echo $this->Form->input('member_type',array('type'=>'radio','div'=>false,'class'=>'radioBox','legend'=>false,'options'=>$options)); ?>
                                    </div>
                                    <div style="float:left; margin-top:-20px;">
                                        <p class="error_msgs" id="err_member_type"><?php if(isset($error['member_type'][0])) echo $error['member_type'][0]; ?></p>
                                    </div>
                                    
                                    <div class="mid_rightforms_new">
                                      <label><?php echo __('First Name'); ?><em class="mandatory">*</em></label>
                                      <?php echo $this->Form->input('first_name',array('type'=>'text','div'=>false,'label'=>false)); ?> 
                                      <p class="error_msgs" id="err_first_name"><?php if(isset($error['first_name'][0])) echo $error['first_name'][0]; ?>  </p>
                                    </div>
                                    <div class="mid_rightforms_new">
                                      <label><?php echo __('Last Name'); ?><em class="mandatory">*</em></label>
                                         <?php echo $this->Form->input('last_name',array('type'=>'text','div'=>false,'label'=>false)); ?>
                                         <p class="error_msgs" id="err_last_name"><?php if(isset($error['last_name'][0])) echo $error['last_name'][0]; ?>  </p>
                                    </div>
                                    <div class="mid_rightforms_new">
                                      <label><?php echo __('Email'); ?><em class="mandatory">*</em></label>
                                      <?php echo $this->Form->input('email',array('type'=>'text','div'=>false,'label'=>false)); ?>
                                      <p class="error_msgs" id="err_email"><?php if(isset($error['email'][0])) echo $error['email'][0]; ?>  </p>
                                    </div>
                                    <div class="mid_rightforms_new">
                                      <label><?php echo __('Password'); ?><em class="mandatory">*</em></label>
                                      <?php echo $this->Form->input('fpassword',array('type'=>'password','div'=>false,'label'=>false)); ?>
                                      <p class="error_msgs" id="err_fpassword"><?php if(isset($error['fpassword'][0])) echo $error['fpassword'][0]; ?>  </p>
                                    </div>
                                    <div class="mid_rightforms_new">
                                      <label><?php echo('Confirm-Password'); ?><em class="mandatory">*</em></label>
                                      <?php echo $this->Form->input('Cpassword',array('type'=>'password','div'=>false,'label'=>false)); ?>
                                      <p class="error_msgs" id="err_Cpassword"><?php if(isset($error['Cpassword'][0])) echo $error['Cpassword'][0]; ?>  </p>
                                    </div>
                                    <div class="mid_rightforms_new">
                                      <label><?php echo __('Zip Code');?><em class="mandatory">*</em></label>
                                        <?php echo $this->Form->input('zipcode',array('type'=>'text','div'=>false,'label'=>false)); ?>
                                        <p class="error_msgs" id="err_zipcode"><?php if(isset($error['zipcode'][0])) echo $error['zipcode'][0]; ?>  </p>
                                    </div>

                                    <div class="mid_rightforms_news" style="margin-bottom: 2px;">
                                        <label><?php echo __('Enter Captcha Code');?><em class="mandatory">*</em></label>
                                        <?php echo $this->Form->input('captcha',array('type'=>'text','div'=>false,'label'=>false,'class'=>'new_txtbxstyle')); ?>
                                    </div>
                                    <p class="error_msgs" id="err_captcha"><?php if(isset($error['captcha'][0])) echo $error['captcha'][0]; ?>  </p>
                                    
                                    <div class="mid_rightformsne" style="margin-top: 5px;">
                                      <label><?php echo __('Captcha Code');?></label>
                                      <div class="captcha_image">
                                        <?php echo $this->Html->image('/font/captcha.gif',array('id'=>'captchaImage'));?>
                                      </div>
                                      <div class="captcha_refresh">
                                        <?php echo $this->Html->image(HTTP_ROOT.'img/front/refresh_captcha.png',array('id'=>'capcode','height'=>'25','width'=>'25','title'=>'ReCAPTCHA'));?>
                                      </div>
                                      <div class="regisImage1">
                                        <?php echo $this->Html->image('front/wait.gif',array('height'=>'27px'));?>
                                      </div>
                                    </div>
                                    
                                    <div class="mid_chkboxareanew">	
                                       <?php echo $this->Form->input('terms',array('type'=>'checkbox','div'=>false,'label'=>false));?>
                                         <span>
                                                <?php echo  $this->Html->link(__('Accept Terms And Conditions'),array('controller'=>'Homes','action'=>'terms_conditions'),array('target'=>'_blank','style'=>'text-decoration:none'));?>
                                                <em class="mandatory" style="margin-left:-3px;">*</em>
                                         </span><br/>
                                        <p class="error_msgs" id="err_terms"><?php if(isset($error['terms'][0])) echo $error['terms'][0]; ?>  </p>
                                    </div>
                                    <div class="mid_chkboxarea"><br/>
                                         <label><?php echo __('(All fields are mandatory)');?></label>
                                    </div>
                                    <div class="mid_formsubmit_s">
                                    <?php echo $this->Form->submit('',array('class'=>'ui-state-default ui-corner-all float-left ui-button','onclick'=>'return ajax_form("homeIndex","Homes/validate_registration_ajax","regisImage")','div'=>false,'label'=>false)); ?>
                                    <div class="regisImage">
                                        <?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                                        
                                    </div>
                                    <div class="container_sgnupwid">
                                    	<div class="signup_fb">
                                        	<a href="#"> <img src="../img/sgn_fb.png" /> </a>
                                        </div>
                                        <div class="img_or">
                                        <img src="../img/or_img.png" />
                                        </div>
                                        <div class="signup_gplus">
                                        	<a href="#"><img src="../img/sgn_gpl.png" /> </a>
                                        </div>
                                    </div>
								</div>
                            </div>
                            <?php echo $this->Form->end(); ?> 
                           <div class="clear"></div>
						</div>
                       	<div class="clear"></div>
                    </div>
                    <div class="clear"></div>
				</div>
        	</div>
		</div>
	</div>
    </div>
    <div class="clear"></div>
</div> 

<script>
$(document).ready(function () {
	$('#capcode').live('click',function(){
		var randomNumber= randomFunc();
		$('.regisImage1').show();
		$.ajax({
			url:ajax_url+'homes/capturecode'+randomNumber,
			//cache:false,
			success:function(html){
				
				$('.captcha_image').html(html);
				$('.regisImage1').hide();
			}
		});
	});
});
</script>
<style>
.captcha_refresh
{
	float: left;
    margin-left: 10px;
	margin-top:7px;
	cursor:pointer;
}
.captcha_image
{
	float: left;
    min-width: 100px;
	min-height: 40px;
}
.regisImage1
{
	float:left;
	display:none;
    margin-left: 10px;
    margin-top: 7px;;
}
.mid_chkboxareanew
{
	float:left;
}
.msg_top
{
	position: absolute;
    text-align: center;
    text-transform: uppercase;
    width: 600px;
    word-wrap: break-word;
	color: #5D7F00;
    float: left;
    font-size: 11px;
    font-weight: bold;
    margin-left: 20px;
    padding: 18px 0;
    text-align: center;
    text-transform: uppercase;
    
}
.search_btton
{
 float:right;
 margin-right:-18px;
}
.button_image_for_all_in {

	-webkit-border-radius: 4px 4px 4px 4px;
	border-radius: 4px 4px 4px 4px; 
	
	border:1px solid #999;
	background: #88b72d; /* Old browsers */
	background: -moz-linear-gradient(top,  #88b72d 0%, #5b8d27 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#88b72d), color-stop(100%,#5b8d27)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #88b72d 0%,#5b8d27 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #88b72d 0%,#5b8d27 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #88b72d 0%,#5b8d27 100%); /* IE10+ */
	background: linear-gradient(to bottom,  #88b72d 0%,#5b8d27 100%); /* W3C */
	
	box-shadow: 0 0 1px 1px #999 ;
	-moz-box-shadow: 0 0 1px 1px #999 ;
	-webkit-box-shadow: 0 0 1px 1px #999 ;

   /* background: linear-gradient(to bottom, #88B72D 0%, #5B8D27 100%) repeat scroll 0 0 transparent;
    border: 1px solid #999999;*/
    border-radius: 4px 4px 4px 4px;
    box-shadow: 0 0 1px 1px #999999;
    color: #FFFFFF;
    float: right;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: bold;
    height: auto;
    margin-right: 20px;
    margin-top: 0;
    padding: 8px 8px;
    text-decoration: none;
    width: auto;
}
</style>