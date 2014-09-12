<style>
.ryt_addve
{
	margin-top: 7px;	
}
</style>
<script>
$(document).ready(function(){
	$('#contactForm').live('click',function(){
		show_overlay();
		showDivAtCenter('showpopup');
		var event_id = <?php echo $eventInfo['Event']['id'];?>;
		var teacher_id = <?php echo $eventInfo['Event']['t_id'];?>;
		$.post(ajax_url+'students/contact_instructor', { event_id : event_id, teacher_id : teacher_id } , function(resp){
			$('#showpopup').hide();
			$('#documentViewDiv').css('width','800px');
			$('#documentViewDiv').show(); 
			$('#docMessageDetfine').html(resp); 
			showDivAtCenter('documentViewDiv');
		});
	});	
});
</script>

<div class="mid_sectionmain">
	<div class="mid_sectionholders">
    	<div class="mid_outerarea">
        	<div class="middle_bg">
          		<div class="instructor_profileinner">
            		<div class="instructor_innermain">
            			<div class="success_msg" style="display: none;" id="successMessage">
                            
                        </div>
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
                      					<h5 style="margin-bottom:16px;"> <?php echo __('View Class'); ?> </h5>
                   						<div class="add_eventcont">
                        					<div class="main_addeve">
                            					<div class="outer_lftco">
                                                    <div class="outer_addeve">
                                        				<div class="lft_addve">
                                            				<label> <?php echo __('Instructor Name'); ?> </label>
                                        				</div>
                                        				<div class="ryt_addve">
                                            				<span>
                                                				<?php echo ucwords($eventInfo['Member']['first_name'].' '.$eventInfo['Member']['last_name']);?>
                                            				</span>
                                        				</div>
                                    				</div>
                                                    
                                                    <div class="outer_addeve">
                                        				<div class="lft_addve">
                                            				<label> <?php echo __('Title'); ?> </label>
                                        				</div>
                                        				<div class="ryt_addve">
                                            				<span>
                                                				<?php echo ucwords($eventInfo['Event']['title']);?>
                                            				</span>
                                        				</div>
                                    				</div>
                                					<div class="outer_addeve">
                                    					<div class="lft_addve">
                                        					<label> <?php echo __('Category'); ?>  </label>
                                    					</div>
                                    					<div class="ryt_addve">
                                        					<span>
                                        						<?php echo ucwords($eventInfo['Category']['name']);?>
                                        					</span>
                                    					</div>
                                					</div>
                                					<div class="outer_addeve">
                                    					<div class="lft_addve">
                                        					<label> <?php echo __('Sub Category'); ?> </label>
                                    					</div>
                                    					<div class="ryt_addve">
                                    						<span>
                                                            	<?php 
																  if($eventInfo['Event']['sub_cate_id']!='0')
																  {	
																	  echo ucwords($eventInfo['SubCategory']['name']);
																  }
																  else
																  {
																	  echo ucwords($eventInfo['Member']['sub_category_name']);
																  }
															  ?>
                                        					</span>
                                    					</div>
                                					</div>
                                					<div class="outer_addeve">
                                    					<div class="lft_addve">
                                        					<label> <?php echo __('Start Date'); ?> </label>
                                    					</div>
                                    					<div class="ryt_addve">
                                        					<span> 
                                            					<?php echo date('d-M-Y',strtotime($eventInfo['Event']['start_date']));?>
															</span>
                                    					</div>
                                					</div>
                                					<div class="outer_addeve">
                                    					<div class="lft_addve">
                                        					<label> <?php echo __('End Date'); ?> </label>
                                    					</div>
                                    					<div class="ryt_addve">
                                        					<span>
                                        						<?php echo date('d-M-Y',strtotime($eventInfo['Event']['end_date']));?>
                                        					</span>
                                    					</div>
                                    				</div>
                                					<div class="outer_addeve">
                                    					<div class="lft_addve">
                                        					<label> <?php echo __('Start Time'); ?> </label>
                                    					</div>
                                    					<div class="ryt_addve">
                                        					<span>
																<?php
																	if($eventInfo['Event']['start_time'] >= 12)
																	{	
																		$explodeData = explode(":",$eventInfo['Event']['start_time']);
																	   echo $explodeData[0] == '12' ?'12:00 PM':$eventInfo['Event']['start_time'] - 12 . ":00 PM";
																	}
																	else
																	{
																		echo $eventInfo['Event']['start_time'].' AM';
																	}
                                                                ?>
                                        					</span>
                                    					</div>
                                    				</div>
                                					<div class="outer_addeve">
                                    					<div class="lft_addve">
                                        					<label> <?php echo __('End Time'); ?> </label>
                                    					</div>
                                    					<div class="ryt_addve">
                                        					<span>
                                        						<?php
																	if($eventInfo['Event']['end_time'] >= 12)
																	{	
																		$explodeData = explode(":",$eventInfo['Event']['end_time']);
																		  echo $explodeData[0] == '12' ?'12:00 PM':$eventInfo['Event']['end_time'] - 12 . ":00 PM";
																	}
																	else
																	{
																		echo $eventInfo['Event']['end_time'].' AM';
																	}
																?>
																</span> 
															</div>
														</div>
                                                        <div class="outer_addeve">
                                                            <div class="lft_addve">
                                                                <label> <?php echo __('Venue Name'); ?> </label>
                                                            </div>
                                                            <div class="ryt_addve">
                                                                <span> 
                                                                    <?php echo $eventInfo['Event']['venue_name'];?>
                                                                </span>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="outer_addeve">
                                                            <div class="lft_addve">
                                                                <label> <?php echo __('City'); ?> </label>
                                                            </div>
                                                            <div class="ryt_addve">
                                                                <span> 
                                                                     <?php echo $eventInfo['Event']['city'];?>
                                                                </span>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="outer_addeve">
                                                            <div class="lft_addve">
                                                                <label> <?php echo __('State'); ?>  </label>
                                                            </div>
                                                            <div class="ryt_addve">
                                                                <span>
                                                                    <?php echo $eventInfo['Event']['state'];?> 
                                                                </span>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="outer_addeve">
                                                            <div class="lft_addve">
                                                                <label> <?php echo __('Country'); ?>  </label>
                                                            </div>
                                                            <div class="ryt_addve">
                                                                <span> 
                                                                    <?php echo $eventInfo['Country']['country_name'];?>
                                                                </span>
                                                            </div>                                        
                                                        </div>
                                                        <div class="outer_addeve">
                                                            <div class="lft_addve">
                                                                <label> <?php echo __('Zipcode'); ?>   </label>
                                                            </div>
                                                            <div class="ryt_addve">
                                                                <span> 
                                                                    <?php echo $eventInfo['Event']['zip_code'];?>
                                                                </span>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="outer_addeve">
                                                            <div class="lft_addve">
                                                                <label> <?php echo __('Description'); ?>    </label>
                                                            </div>
                                                            <div class="ryt_addve">
                                                                <span style="width: 550px;"> 
                                                                    <?php echo nl2br($eventInfo['Event']['description']);?>
                                                                </span>
                                                            </div>
                                                        </div>
                                					</div>
                                                    <?php 
														$eventId = base64_encode(convert_uuencode($eventInfo['Event']['id']));
														$search = base64_encode(convert_uuencode('searchPage'));
													?>
                                                    
                                                    <div class="container_maintb">
                                                        <div class="main_edtconst">
                                                            <a href="<?php echo HTTP_ROOT.'homes/registration/'.$eventId.'/'.$search;?>" class="req_event_but"  > </a>
                                                        </div>
                                                    </div>
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
.lft_addve {
    float: left;
    width: 168px;
}
.lft_addve label {
    color: #626262;
    float: left;
    font-size: 14px;
    font-weight: bold;
    margin-top: 5px;
    width: 100%;
}
</style>