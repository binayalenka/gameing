<style>
.width_min
{
	width:200px !important;
}

</style>

<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").datepicker({	
			minDate: new Date(),
			dateFormat:'yy-mm-dd',
			changeMonth: true,
			changeYear: true,		
			yearRange: '1930:2030',
			inline: true
		});
		
		$('#EventTitle').focus();
	});
</script>
<?php $time = array();
for($i=0;$i<24;$i++)
{
	for($j=0;$j<=30;$j= $j+30)
	{
		if($i < 12) { 
			if($j == 0)
			 $time[$i.':00'] = $i.':00 AM';
			elseif($j > 0)
			 $time[$i.':'.$j] = $i.':'.$j." AM";
		}elseif($i==12){
			if($j == 0)
			 $time[$i.':00'] = $i .':00 PM';
			elseif($j > 0)	
			 $time[$i.':'.$j] = $i .':'.$j." PM";
		}else{
			if($j == 0)
			 $time[$i.':00'] = $i-12 .':00 PM';
			elseif($j > 0)	
			 $time[$i.':'.$j] = $i-12 .':'.$j." PM";
		}
	}
}
?>
<div id="sub-nav">
	<div class="page-title">
		<h1>Add Class</h1>
	</div>
</div>

<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Add Class</h2>
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
						Add Class Details
					</div>
					
					 <?php echo $this->Form->create('Event',array('id'=>'eventForm','url'=>array('controller'=>'Users','action'=>'add_event','admin'=>true),'enctype'=>'multipart/form-data')); ?>
                     <?php echo $this->Form->input('t_id',array('type'=>'hidden','value'=>$memberId,'div'=>false,'label'=>false)); ?> 
                    <div class="content-box-wrapper">
                 	
                    <fieldset>
                    <ul>
                        <li>
                            <label class="desc" >Title</label>
                            <div>
                                <?php echo $this->Form->input('title',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_title"><?php if(isset($error['title'][0])) echo $error['title'][0]; ?>  </p>   
                            </div>
                        </li>   
                         <li>
                            <label class="desc" >Category Name</label>
                            <div>
                                <?php echo $this->Form->input('cate_name',array('type'=>'text','value'=>$catgInfo['Category']['name'],'div'=>false,'label'=>false,'class'=>'text full field required','readonly'=>'readonly')); ?> 
                                <?php echo $this->Form->input('cate_id',array('type'=>'hidden','value'=>$catgInfo['Category']['id'],'div'=>false,'label'=>false,'class'=>'txt_ad','readonly'=>'readonly'))?>
                             <p class="tutor-add-Error" id="err_cate_name"><?php if(isset($error['cate_name'][0])) echo $error['cate_name'][0]; ?>  </p>   
                            </div>
                        </li>
                        
                        <li>
                            <label class="desc" >Sub-Category Name</label>
                            <div>
								<?php 
                                    if(!empty($memberInfo['Member']['sub_category_name']))
                                    {
                                        $sub_category_list = $sub_category_list + array('0'=>$memberInfo['Member']['sub_category_name']); 
                                    }
                                ?>
                                <?php echo $this->Form->input('sub_cate_id',array('type'=>'select','options'=>array(''=>'Select',$sub_category_list),'div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_sub_cate_id"><?php if(isset($error['sub_cate_id'][0])) echo $error['sub_cate_id'][0]; ?>  </p>   
                            </div>
                        </li>
                        <li>
                            <label class="desc" >Start Date</label>
                            <div>
                                <?php echo $this->Form->input('start_date',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required datepicker txt_ad width_min','readonly'=>true)); ?> 
                                
                             <p class="tutor-add-Error" id="err_start_date"><?php if(isset($error['start_date'][0])) echo $error['start_date'][0]; ?>  </p>   
                            </div>
                        </li>
                        <li>
                            <label class="desc" >End Date</label>
                            <div>
                                <?php echo $this->Form->input('end_date',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required datepicker txt_ad width_min','readonly'=>true)); ?> 
                                
                             <p class="tutor-add-Error" id="err_end_date"><?php if(isset($error['end_date'][0])) echo $error['end_date'][0]; ?>  </p>   
                            </div>
                        </li>
                        
                        <li>
                            <label class="desc" >Select Days</label>
                            <div>
                                <?php 
								$weekDays = array('1'=>'Monday','2'=>'Tuesday','3'=>'Wednesday','4'=>'Thursday','5'=>'Friday','6'=>'Saturday','7'=>'Sunday');
								echo $this->Form->input('days',array('type'=>'select','multiple' => 'checkbox','options'=>$weekDays,'div'=>false,'label'=>false))?>
                            </div>
                            <p class="tutor-add-Error" id="err_days"><?php if(isset($error['days'][0])) echo $error['days'][0]; ?>  </p>
                        </li>
                        
                        <li>
                            <label class="desc" >Start Time</label>
                            <div>
                                <?php echo $this->Form->input('start_time',array('type'=>'select','options'=>array(''=>'Select',$time),'div'=>false,'label'=>false,'class'=>'text full field required width_min')); ?> 
                                
                             <p class="tutor-add-Error" id="err_start_time"><?php if(isset($error['start_time'][0])) echo $error['start_time'][0]; ?>  </p>   
                            </div>
                        </li>
                        <li>
                            <label class="desc" >End Time</label>
                            <div>
                                <?php echo $this->Form->input('end_time',array('type'=>'select','options'=>array(''=>'Select',$time),'div'=>false,'label'=>false,'class'=>'text full field required width_min' )); ?> 
                                
                             <p class="tutor-add-Error" id="err_end_time"><?php if(isset($error['end_time'][0])) echo $error['end_time'][0]; ?>  </p>   
                            </div>
                        </li>
                        
                        <li>
                            <label class="desc" >Venue Name</label>
                            <div>
                                <?php echo $this->Form->input('venue_name',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_venue_name"><?php if(isset($error['venue_name'][0])) echo $error['venue_name'][0]; ?>  </p>   
                            </div>
                        </li>
                        <li>
                            <label class="desc" >City</label>
                            <div>
                                <?php echo $this->Form->input('city',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_city"><?php if(isset($error['city'][0])) echo $error['city'][0]; ?>  </p>   
                            </div>
                        </li>
                        <li>
                            <label class="desc" >State</label>
                            <div>
                                <?php echo $this->Form->input('state',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_state"><?php if(isset($error['state'][0])) echo $error['state'][0]; ?>  </p>   
                            </div>
                        </li>
                        <li>
                            <label class="desc" >Country</label>
                            <div>
                                <?php echo $this->Form->input('country',array('type'=>'select','options'=>array(''=>'Select',$country_list),'div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_country"><?php if(isset($error['country'][0])) echo $error['country'][0]; ?>  </p>   
                            </div>
                        </li>
                        <li>
                            <label class="desc" >Zip-Code</label>
                            <div>
                                <?php echo $this->Form->input('zip_code',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_zip_code"><?php if(isset($error['zip_code'][0])) echo $error['zip_code'][0]; ?>  </p>   
                            </div>
                        </li>
                        
                          <li>
                            <label class="desc" >Status</label>
                            <div>
                                <?php echo $this->Form->input('status',array('type'=>'select','options'=>array('1'=>'Active','0'=>'Inactive'),'div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                            </div>
                        </li>
                        
                          <li>
                            <label class="desc" ><?php echo __('Accepting New Students'); ?></label>
                            <div>
                               <?php echo $this->Form->input('accept_student',array('type'=>'select','options'=>array('yes'=>'Yes','no'=>'No'),'div'=>false,'label'=>false,'class'=>'text full field required')); ?>
                            </div>
                        </li>
                        
                        
                        <li>
                            <label class="desc" >Description</label>
                            <div>
                                <?php echo $this->Form->input('description',array('type'=>'textarea','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_description"><?php if(isset($error['description'][0])) echo $error['description'][0]; ?>  </p>   
                            </div>
                        </li>
                        
                        <li>
                            <input class="sub-bttn" type="submit" value="Submit" onclick='return ajax_form("eventForm","Users/validate_admin_add_event_ajax","newloading")'/>
                            
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
<style>
.checkbox
{
	float:left;
	width:auto;
}
.checkbox label{
	float:right;
	margin-top:-4px;
	padding-left:3px;
	padding-right:10px;
	font-size:12px;
}
</style>