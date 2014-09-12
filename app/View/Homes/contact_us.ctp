
<div class="mid_sectionmain">
    <div class="mid_sectionholders">
      <div class="mid_outerarea">
        <div class="middle_bg">
          <div class="instructor_profileinner">
            <div class="instructor_innermain">
            <?php if($this->Session->check('SuccessMessage')) { ?>
                    <div class="success_msg">
                        <?php echo $this->Session->read('SuccessMessage'); ?>
                        <?php $this->Session->delete('SuccessMessage');?>                   
                    </div>
                <?php } ?>
              <div class="instructor_innerspaces">
                <div class="instructor_innerbg">
                  <div class="instructor_innerbgspace">
                    <div class="contact_main">
                      <h5><?php echo $info['CmsPage']['page_title']; ?></h5>
                      <h6><?php echo __('Feel free to send us a message and we will get back to you as soon as possible.');?></h6>
                      <div class="contact_leftmain">
                        <?php echo $this->Form->create('Contact',array('id'=>'contactForm','url'=>array('controller'=>'Homes','action'=>'contact_us')));?>
                        <div class="contact_topforms">
                          <div class="contact_topformsleft">
                            <label><?php echo __('First Name');?> <b>*</b></label>
                            <?php echo $this->Form->input('first_name',array('type'=>'text','div'=>false,'label'=>false )); ?>
                            <p class="error_msgs" id="err_first_name"><?php if(isset($error['first_name'][0])) echo $error['first_name'][0]; ?> </p>
                          </div>
                          
                          <div class="contact_topformsleft">
                            <label><?php echo __('Last Name'); ?> </label>
                            <?php echo $this->Form->input('last_name',array('type'=>'text','div'=>false,'label'=>false));?>
                            
                          </div>
                          
                        </div>
                        <div class="contact_topforms">
                          
                          <div class="contact_topformsleft">
                            <label><?php echo __('Email'); ?> <b>*</b></label>
                            <?php echo $this->Form->input('email',array('type'=>'text','div'=>false,'label'=>false)); ?>
                            <p class="error_msgs" id="err_email"><?php if(isset($error['email'][0])) echo $error['email'][0]; ?> </p>
                          </div>
                          
                          <div class="contact_topformsleft">
                            <label><?php echo __('Contact Type'); ?> <b>*</b></label>
                           <div class="search_leftbox" style="width:100%; min-height:10px;">
                              <select name="data[Contact][contact_type]" id="websites5" style="width:247px; height:27px;">
                              <option name="" value="" selected="selected"><?php echo __('Select');?></option>
                                <option name="two" value="Genral Enquiry"><?php echo __('Genral Enquiry');?></option>
                                <option name="three" value="Other Enquiry"><?php echo __('Other Enquiry'); ?></option>
                              </select>
                            <p class="error_msgs" id="err_contact_type"><?php if(isset($error['contact_type'][0])) echo $error['contact_type'][0]; ?> </p>
                        	</div>
                          </div>
                        </div>
                        <div class="contact_topforms">
                          <div class="contact_msg">
                            <label><?php echo __('Your Message'); ?> <span>*</span></label>
                            <?php echo $this->Form->input('message',array('type'=>'textarea','div'=>false,'label'=>false)); ?>
                            <p class="error_msgs" id="err_message"><?php if(isset($error['message'][0])) echo $error['message'][0]; ?> </p>
                          </div>
                          <div class="contact_submitbtns">
                            <?php echo $this->Form->submit('',array('onclick'=>'return ajax_form("contactForm","Homes/contact_check_ajax","loginLoading")')); ?>
                          </div>
                          <div class="loginLoading">
							<?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
						 </div>
                        </div>
                        <?php echo $this->Form->end();?>
                      </div>
                      <div class="contact_rightmain">
                        <div class="contact_rightinner">
                          <div class="contact_rightdetails">
                            <h5><?php echo $info['CmsPage']['page_title']; ?></h5>
                            <span class="contact_address"><?php echo __('Address'); ?></span>
                            <?php echo $info['CmsPage']['description']; ?>
                          </div>
                          <div class="clear"></div>
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