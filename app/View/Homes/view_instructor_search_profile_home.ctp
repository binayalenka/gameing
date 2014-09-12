<?php echo $this->Html->Css('general');?>
<?php echo $this->Html->script('tabs.js');?>
<?php echo $this->Html->Css('fancybox/jquery.fancybox');?>
<?php echo $this->Html->Css('fancybox/jquery.fancybox-buttons');?>

<?php echo $this->Html->Css('fancybox/jquery.fancybox-thumbs');?>
<?php echo $this->Html->script('fancybox/jquery.fancybox');?>
<?php echo $this->Html->script('fancybox/jquery.fancybox-buttons');?>
<script>

$(document).ready(function(){
	
	$(".fancybox-button").fancybox({
		prevEffect		: 'none',
		nextEffect		: 'none',
		closeBtn		: false,
		helpers		: {
			title	: { type : 'inside' },
			buttons	: {}
		}
	});


});
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
                <div class="inner_teacherprofile">
                  <div class="container_editinstructor">
                    <div class="ryt_lftinst">
                    	<div class="inenr_rytins">
                        	<div class="mainoute_instructor">
                            	<div class="inner_lftinstrcutr">
                                	<div class="uper_lftprofileimg">
                                    	<div class="inner_lftfrm change_pic" style="position:relative">
                                            <?php  
											if(!empty($member_info['Member']['image']) && file_exists('files/'.$member_info['Member']['id']."/".$member_info['Member']['image'])) 					  								{
														
												echo $this->Html->link($this->Html->image('/files/'.$member_info['Member']['id']."/".$member_info['Member']['image'],array('width'=>'170','height'=>'170')),'#',array('escape'=>false,'class'=>'fancybox','rel'=>'gallary1','div'=>false,'label'=>false));
												 
												 if($this->Session->read('Member.member_type')=='1'){
												 echo $this->Html->link('Change Picture','javascript:void(0);',array('class'=>'view_profile_image_change','id'=>$member_info['Member']['id']));
												 }
							   
											}else{
												 echo $this->Html->image('profile_pic.png',array('width'=>'170px','Height'=>'170px'));
												  if($this->Session->read('Member.member_type')=='1'){
												  echo $this->Html->link('Change Picture','javascript:void(0);',array('class'=>'view_profile_image_change','id'=>$member_info['Member']['id']));
												  }
											}
											?>
                                            <h2> <?php echo $member_info['Member']['first_name'].' '.$member_info['Member']['last_name']; ?></h2>
                                            <p><?php echo $member_info['Member']['company_name']; ?></p>
                                        </div>
                                        
                                        <div class="contact_box ">
                                        	<div class="inner_contactbx">
                                            	<h2> Contact </h2>
                                                <div class="box_contentcontact">
                                                	<div class="main_contactcont">
                                                    	<p><?php echo $member_info['Member']['email']; ?></p>
                                                        <p><?php echo $member_info['Member']['phone']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contact_box">
                                        	<div class="inner_contactbx">
                                            	<h2> Connect </h2>
                                                <div class="box_contentcontact">
                                                	<?php if(!empty($member_info['Member']['f_id']) || !empty($member_info['Member']['t_id']) || !empty($member_info['Member']['g_id'])){?>
                                                    <div class="main_contactcont">
														<div class="txt_fbconnect">
                                                        	<?php if(!empty($member_info['Member']['f_id'])){?>
                                                            <a href="<?php echo $member_info['Member']['f_id']; ?>" target="_blank">
															<?php echo $this->Html->image('fb.png'); ?>
                                                            <p> Facebook</p>
                                                            </a>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="txt_fbconnect">
                                                        	<?php if(!empty($member_info['Member']['t_id'])){?>
                                                            <a href="<?php echo $member_info['Member']['t_id']; ?>" target="_blank">
															<?php echo $this->Html->image('twitter.png'); ?>
                                                            <p> Twitter</p>
                                                            </a>
                                                            <?php } ?>
                                                        </div>
                                                         <div class="txt_fbconnect noe_connnectbdr">
                                                         	
															<?php if(!empty($member_info['Member']['g_id'])){?>
                                                            <a href="<?php echo $member_info['Member']['g_id']; ?>" target="_blank">
															
                                                            <?php echo $this->Html->image('gplus1.png'); ?>
                                                            <p> Google Plus</p>
                                                            </a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <?php }elseif(empty($member_info['Member']['f_id']) && empty($member_info['Member']['t_id']) && empty($member_info['Member']['g_id'])){?>
                                                    <div class="main_contactcont">
														<div class="txt_fbconnect">
                                                        	 <p>Not Available</p>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="check_formyclas">
                                         	<?php $membId = base64_encode(convert_uuencode($member_info['Member']['id']));?>
                                        	<a href="<?php echo HTTP_ROOT.'homes/view_search_instructor_calender_home/'.$membId;?>">
											<?php echo __('Check For My classes')?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="inner_rytinstructr">
                                	<div class="inner_rytintr">
                                    	<div class="upper_objective1s_1ns1">
                                            <div class="desc_objectives_1s">
                                                <div class="lft_tty">
                                                    <div class="inner_hourlyfelft1">
                                                        <?php echo $this->Html->image('educ.png'); ?>
                                                    </div>
                                                      <div class="rty_horlyfe1">
                                                        <div class="iner_txtjb">
                                                            <h2 class="edtxtcat"> Education </h2>
                                                            <p>
                                                            <?php 
																if(!empty($member_info['Member']['education'])){
																	echo $member_info['Member']['education']; 
																}else{
																	echo "Not available";
																}
																?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hourlyfee_cont">
                                                    <div class="inner_hourlyfelft">
                                                        <?php echo $this->Html->image('dolr_fe.png'); ?>
                                                    </div>
                                                    <div class="rty_horlyfe">
                                                        <div class="inner_hrlyf">
                                                            <h2> Hourly Fee </h2>
                                                        </div>
                                                        <div class="inner_hrlyf">
                                                            <label> Standard Hourly Fee: </label>
                                                            <p style="margin-left:-10px"> 
															<?php if(!empty($member_info['Member']['hourly_rate'])){ 
																echo '$'.$member_info['Member']['hourly_rate']; 
															}else{
																echo 'Not available'; 
															}
															?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tabs_contentstats">
                                        	<div id="container">     
                                                <ul class="menu">
                                                    <li id="news" class="active">About</li>
                                                    <li id="tutorials">Portfolio</li>
                                                    <li id="links">Experience</li>
                                                    <li id="details">Personal Details</li>
                                                </ul>
                                                <span class="clear"></span>
                                                <div class="content news">
                                                    <div class="upper_objective">
                                                        <h2> Objectives</h2>
                                                        <div class="desc_objectives_s1">
                                                            <p>
                                                            <?php echo $member_info['Member']['objective']; ?>
                                                            </p>
                                                            
                                                        </div>
                                                    </div>
                                                     <div class="upper_objective1s">
                                                        <h2> Primary Services</h2>
                                                        <div class="desc_objectives">
                                                            
                                                            <p>
                                                            <?php echo $member_info['Member']['primary_services']; ?>
                                                            </p>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="upper_objective1s">
                                                        <h2> Secondary Services</h2>
                                                        <div class="desc_objectives">
                                                           
                                                            <p>
                                                            <?php echo $member_info['Member']['additional_information']; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content tutorials">
                                                   <div class="upper_objective1s">
                                                    <h2> Portfolio </h2>
                                                    <div class="desc_objectives_ad1">
                                                    
                                                        <div class="main_audiocont_ns1">
                                                            <b><?php echo $this->Html->image('aud_im.png'); ?><p class="aud_vidtxt">  Pictures </p></b>
                                                            <div class="container_imgpr">
                                                                <div class="main_contimpr">
                                                                
                                                                <ul>
                                                                <?php $i=0;
																	if(!empty($member_info['VideoLink'])) {
																		foreach($member_info['VideoLink'] as $imgName) { 
																			if(!empty($imgName['image']) && file_exists('files/'.$member_info['Member']['id']."/image/".$imgName['image']) && $imgName['type']!='1') { $i++;
																?>
                                                                    <li> 
                                                                    
                                                                    <?php echo $this->Html->link($this->Html->image('/files/'.$member_info['Member']['id']."/image/".$imgName['image'],array('width'=>'125','height'=>'125','class'=>'img_border')),HTTP_ROOT.'files/'.$member_info['Member']['id']."/image/".$imgName['image'],array('escape'=>false,'class'=>'fancybox-button','rel'=>'fancybox-button','div'=>false,'label'=>false));?>
                                                                    
                                                                    </li>
                                                                  <?php 
																			} 
																		}
																	}if($i==0){ ?>
																		<P style="margin-top:15px;"><?php echo __('No image found.'); ?></P>
																	<?php  } ?>  
                                                                </ul>
                                                                
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="main_audiocont_ns1">
                                                            <b><?php echo $this->Html->image('vid_im.png'); ?><p class="aud_vidtxt"> Videos </p></b>
                                                            <div class="container_imgpr">
                                                                <div class="main_contimpr">
                                                                
                                                                <ul>
                                                                <?php 
																	$i=0;
																	if(!empty($member_info['VideoLink'])) {
																		foreach($member_info['VideoLink']	as $video) {
																			if($video['type'] =='1') {											
																				$videoUrlCount = strlen($video['video_link'])-11;
																				$youtubeUniqueId = substr($video['video_link'],$videoUrlCount); 
																				$id	=	base64_encode(convert_uuencode($video['id']));
																?>
                                                                    <li>
                                                                     <?php echo $this->Html->link($this->Html->image('http://img.youtube.com/vi/'.$youtubeUniqueId.'/0.jpg',array('class'=>'img_border')),HTTP_ROOT.'Homes/watch_video/'.$id,array('title'=>'Watch Video','escape'=>false));?>
                                                    				 <?php $i++; ?>
                                                                    </li>
                                                                    <?php 		
																				}
																		   }
																		}
																		if($i==0){ ?>
																			<P style="margin-top:15px;"><?php echo __('No video found.'); ?></P>
																	<?php } ?>
                                                                </ul>
                                                                
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                </div> 
                                                <div class="content links">
                                                    <div class="upper_objective1s">
                                                        <h2> Experience </h2>
                                                        <div class="desc_objectives">
                                                            <p>
                                                             <?php echo $member_info['Member']['experience']; ?>
                                                            </p>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content details" style="display:none;">
                                                    <div class="upper_objective1s">
                                                        <h2> Personal Profile</h2>
                                                        <div class="desc_objectives">
                                                            <table>
															<tr height="25px">
																<td width="115px"><b> Company Name :</b></td><td>
																<?php if($member_info['Member']['company_name'] !=''){echo $member_info['Member']['company_name'];}else{ echo "-";}?>
                                                                </td>
                                                            </tr>
															<tr height="25px">
															<td><b>Street :</b></td><td><?php if($member_info['Member']['street'] !=''){echo $member_info['Member']['street'];}
	else{ echo "-";} ?></td>
															</tr>
															<tr height="25px">
															<td><b>City :</b></td><td><?php if($member_info['Member']['city'] !=''){echo $member_info['Member']['city'];}
	else{ echo "-";} ?></td>
															</tr>
															<tr height="25px">
															<td><b>Country :</b></td><td><?php if($member_info['Country']['country_name'] !=''){echo $member_info['Country']['country_name'];}
	else{ echo "-";} ?></td>
															</tr>
															<tr height="25px">
															<td><b>Zipcode :</b></td><td><?php if($member_info['Member']['zipcode'] !=''){echo $member_info['Member']['zipcode'];}
	else{ echo "-";} ?></td>
															</tr>
															<tr height="25px">
															<td><b>Category :</b></td><td><?php if($member_info['Category']['name'] !=''){echo $member_info['Category']['name'];}
	else{ echo "-";} ?></td>
															</tr>
															<tr>
																<td><b>Sub-Categories :</b></td>
																<td><?php  if(count($subCategory)){
																		$sub='';
																		$i=1;																						                                                                                foreach ($subCategory as $value){
																			$sub .=$i++.'. '.$value.'<br>';
																			}
																		}else{
																			$sub='No Sub-Categories.';
																		}
																		echo $sub;
																	?>
																</td>
															</tr>
															</table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>
                        	</div>
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
    </div>
  </div>
  <div class="clear"></div>
</div>
<script type="text/javascript">
$(document).ready(function() {
		$('.change_pic').mouseenter(function(){
				 
				$(this).children('.view_profile_image_change').show();
				
		});
		$('.change_pic').mouseleave(function(){
			
			$(this).children('.view_profile_image_change').hide();
			
		});
		$('.view_profile_image_change').live('click',function(){
			
			var he=$(document).height();
			window.location.href=ajax_url+'Instructors/edit_profile_image';
			var id =$(this).attr('id');
			show_overlay();
			showDivAtCenter('showpopup');
			$.ajax({
				url:ajax_url+'Instructors/edit_profile_image',
				success:function(resp){
					$('#showpopup').hide();
					$('#documentViewDiv').css('width','800px');
					$('#documentViewDiv').show(); 
					$('#docMessageDetfine').html(resp); 
					showDivAtCenter('documentViewDiv');	
				}
			});
			
		});
});
</script>
<style type="text/css">
.fancybox-overlay{
 overflow-x: scroll !important;
}
</style>  
