<script type="text/javascript">

</script>
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
                    <div class="search_main">
                      <h5 style="margin-bottom:16px;"> <?php echo __('Request For Class'); ?> </h5>
                   		<div class="add_eventcont">
                        	<?php echo $this->Form->create('ClassRequest',array('url'=>array('controller'=>'Homes','action'=>'request_class'),'id'=>'requestClass'))?>                                  
                                <div class="main_addeve">  
                                	<div class="outer_addeve">
                                        <div class="lft_addve">
                                            <label> <?php echo __('Name'); ?> </label>
                                        </div>
                                        <div class="ryt_addve">
                                            <span>
                                                <?php echo $this->Form->input('name',array('type'=>'text','div'=>false,'label'=>false,'class'=>'txt_ad'))?>
                                                <p class="error_msgs" id="err_name"><?php if(isset($error['name'][0])) echo $error['name'][0]; ?>  </p> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="outer_addeve">
                                        <div class="lft_addve">
                                            <label> <?php echo __('Email Id'); ?> </label>
                                        </div>
                                        <div class="ryt_addve">
                                            <span>
                                                <?php echo $this->Form->input('email_id',array('type'=>'text','div'=>false,'label'=>false,'class'=>'txt_ad'))?>
                                                <p class="error_msgs" id="err_email_id"><?php if(isset($error['title'][0])) echo $error['title'][0]; ?>  </p> 
                                            </span>
                                        </div>
                                    </div>
                                  	<div class="outer_addeve">
                                        <div class="lft_addve">
                                            <label> <?php echo __('Zip-Code'); ?> </label>
                                        </div>
                                        <div class="ryt_addve">
                                            <span>
                                                <?php echo $this->Form->input('zip_code',array('type'=>'text','div'=>false,'label'=>false,'class'=>'txt_ad'))?>
                                                <p class="error_msgs" id="err_zip_code"><?php if(isset($error['title'][0])) echo $error['title'][0]; ?>  </p> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="outer_addeve">
                                        <div class="lft_addve">
                                            <label> <?php echo __('City'); ?> </label>
                                        </div>
                                        <div class="ryt_addve">
                                            <span>
                                                <?php echo $this->Form->input('city',array('type'=>'text','div'=>false,'label'=>false,'class'=>'txt_ad'))?>
                                                <p class="error_msgs" id="err_city"><?php if(isset($error['title'][0])) echo $error['title'][0]; ?>  </p> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="outer_addeve">
                                        <div class="lft_addve">
                                            <label> <?php echo __('State'); ?> </label>
                                        </div>
                                        <div class="ryt_addve">
                                            <span>
                                                <?php echo $this->Form->input('state',array('type'=>'text','div'=>false,'label'=>false,'class'=>'txt_ad'))?>
                                                <p class="error_msgs" id="err_state"><?php if(isset($error['title'][0])) echo $error['title'][0]; ?>  </p> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="outer_addeve">
                                        <div class="lft_addve">
                                            <label> <?php echo __('Country'); ?> </label>
                                        </div>
                                        <div class="ryt_addve">
                                            <span>
                                                <?php echo $this->Form->input('country',array('type'=>'text','div'=>false,'label'=>false,'class'=>'txt_ad'))?>
                                                <p class="error_msgs" id="err_country"><?php if(isset($error['title'][0])) echo $error['title'][0]; ?>  </p> 
                                            </span>
                                        </div>
                                    </div>                                   
                                    <div class="outer_addeve">
                                        <div class="lft_addve">
                                            <label> <?php echo __('Select Category'); ?> </label>
                                        </div>
                                        <div class="ryt_addve">
                                            <span>
                                                <?php echo $this->Form->input('class_name',array('type'=>'select','options'=>$cateGory,'div'=>false,'label'=>false,'style'=>'width:290px; height:25px; float:left;')); ?>
                                                <p class="error_msgs" id="err_class_name"><?php if(isset($error['title'][0])) echo $error['title'][0]; ?>  </p> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="outer_addeve">
                                    	
                                        <div class="lft_addve">
                                            <label> <?php echo __('Class description'); ?> </label>
                                        </div>
                                        <div class="inner_rytdesc">
                                            <span>
                                                <?php  echo $this->Form->input('class_description',array('type'=>'textarea','div'=>false,'label'=>false));?>
                                               <label class="labelNote">   <?php echo __('Description should not be greater than 10 words');?> </label>
                                                <p class="error_msgs" id="err_class_description"><?php if(isset($error['title'][0])) echo $error['title'][0]; ?>  </p> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="outer_addeve">
                                        <div class="btn_subtmi">
                                            <div class="inner_btnsb">
                                                <div class="contact_submitbtns" style="margin-left:100px;">                                                    
													<?php echo $this->Form->input('',array('type'=>'submit','class'=>false,'div'=>false,'label'=>false,'onclick'=>'return ajax_form("requestClass","Homes/check_request_class_ajax","addBroadCastLoading")','style'=>'margin-left: -80px;'));?>
                                                     <div class="addBroadCastLoading">
                                                        <?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                                                     </div>                                                     
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              <?php echo $this->Form->end();?>                              
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
 .span_type_text1{
 float:left;
 width:35px;
 
 }
 .span_type_text2{
 float:left; 
 font-size:11px;
 font-weight:bold;
 width:auto;
 }
.labelNote {
    color: #626262;
    float: left;
    font-size: 14px;
    font-weight: normal;
    margin-top: 5px;
    width: 100%;
}
 </style>