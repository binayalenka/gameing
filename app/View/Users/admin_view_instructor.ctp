<?php echo $this->Html->Css('fancybox/jquery.fancybox');?>
<?php echo $this->Html->Css('fancybox/jquery.fancybox-buttons');?>
<?php echo $this->Html->Css('fancybox/jquery.fancybox-thumbs');?>
<?php echo $this->Html->script('fancybox/jquery.fancybox');?>
<?php echo $this->Html->script('fancybox/jquery.fancybox-buttons');?>


<style>
	.hastable tbody th
	{
		padding:10px;
	}
	.hastable tr td
	{
		text-align:left;
	}
	.ryt_mainu
	{
		float: left;
   		width: 841px;
	}	
</style>
<script>
var countClick = 0;
$(document).ready(function(){
		
		$('#tabs').tabs();
	
	
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

<div id="sub-nav">
	<div class="page-title">
		<h1>View Instructors Information</h1>
	</div>
</div>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2 style="width:90%; ">View Instructors Information</h2>
				<a style="margin-top:-10px;" class="ui-state-default ui-corner-all float-right ui-button" href="javascript:void(0);" onclick="history.go(-1);">Back</a>
				<span></span>
			</div>
			
            <div class="content-box content-box-header" style="border:none;">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs1">View Profile</a></li>
                        <li><a href="#tabs2">View Images</a></li>						
                        <li><a href="#tabs3">View Videos</a></li>
                    </ul>
                    <div id="tabs1">
                    	<div class="hastable">			
                            <table id="sort-table"> 
                                <tbody>
                                	
                                    <tr>							
                                        <th width="10%;">Profile Picture</th> 
                                        <td width="30%;">
                                        
										<?php 
											 
										if($info['Member']['image']!='' && file_exists('files/'.$info['Member']['id'].'/'.$info['Member']['image']))
										{ 
											echo $this->Html->image('../files/'.$info['Member']['id'].'/'.$info['Member']['image'],array('width'=>100,'height'=>100));
											
										}else{
											echo $this->Html->image('profile_pic.png',array('width'=>100,'height'=>100));
										}
									?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">Name</th> 
                                        <td width="30%;"><?php echo $info['Member']['first_name'].' '.$info['Member']['last_name']; ?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">E-Mail</th> 
                                        <td width="30%;"><?php echo $info['Member']['email']; ?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">Company Name</th> 
                                        <td width="30%;"><?php echo $info['Member']['company_name']; ?></td> 
                                    </tr>
                                    <tr>
                                    	<th width="10%">Category</th>
                                        <td width="30%;">
										<?php 
											if(!empty($info['Category']['name'])){
												echo $info['Category']['name']; 
											}
										?>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<th width="10%">Sub-Categories</th>
                                        <td width="30%;">
											<?php 
												if(!empty($info['MemberCategory'])){
													foreach($info['MemberCategory'] as $subCategory)
													{	
														if($subCategory['SubCategory']['name'] != ''){
															echo $subCategory['SubCategory']['name']; 
														}
											?> </br>
 											<?php	}
												}
											?>
											<?php	
												echo $info['Member']['sub_category_name'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>							
                                        <th width="10%;">Phone</th> 
                                        <td width="30%;"><?php echo $info['Member']['phone']; ?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">Street</th> 
                                        <td width="30%;"><?php echo $info['Member']['street']; ?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">City</th> 
                                        <td width="30%;"><?php echo $info['Member']['city']; ?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">Zip-Code</th> 
                                        <td width="30%;"><?php echo $info['Member']['zipcode']; ?></td> 
                                    </tr>
                                     <tr>							
                                        <th width="10%;">State</th> 
                                        <td width="30%;"><?php echo $info['Member']['state']; ?></td> 
                                    </tr>
                                     <tr>							
                                        <th width="10%;">Country</th> 
                                        <td width="30%;"><?php echo $info['Country']['country_name']; ?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">Hourly rate</th> 
                                        <td width="30%;"><?php echo $info['Member']['hourly_rate']; ?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">Prepaid discount</th> 
                                        <td width="30%;"><?php echo $info['Member']['discount_from'].' - '.$info['Member']['discount_to']; ?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">Facebook Page-Id</th> 
                                        <td width="30%;"><?php echo $info['Member']['f_id']; ?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">Twitter Page-Id</th> 
                                        <td width="30%;"><?php echo $info['Member']['t_id']; ?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">Google plus Page-Id</th> 
                                        <td width="30%;"><?php echo $info['Member']['g_id']; ?></td> 
                                    </tr> 
                                    <tr>							
                                        <th width="10%;">Education</th> 
                                        <td width="30%;"><?php echo $info['Member']['education']; ?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">Experience</th> 
                                        <td width="30%;"><?php echo $info['Member']['experience']; ?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">Objective</th> 
                                        <td width="30%;"><?php echo $info['Member']['objective']; ?></td> 
                                    </tr>
                                     <tr>							
                                        <th width="10%;">Primary Services</th> 
                                        <td width="30%;"><?php echo $info['Member']['primary_services']; ?></td> 
                                    </tr>
                                     <tr>							
                                        <th width="10%;">Additional Information</th> 
                                        <td width="30%;"><?php echo $info['Member']['additional_information']; ?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">Memory Usage</th> 
                                        <td width="30%;">
											<?php if($mem_used != ''){ ?>
                                                
                                                     <b class="calender_catgs">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_bdrsmain">
                                                            <tr>
                                                                <td align="center"> <?php echo $mem_used_in_per.'% used'; ?> </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center"> <?php echo $mem_used; ?> </td>
                                                            </tr>
                                                        </table>
                                                     </b>
                                                
                                            <?php } ?> 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                        	                        
                        <div class="clear"></div>
                    </div>
                    </div>
                    <div id="tabs2">
                        <div class="ryt_mainu">
                            <div onclick="inner_rytupp">
                                <div class="images_container">
                                    <h1> Images </h1>
                                    <div class="inner_imgcont">
                                        <?php $i=0;
                                            if(!empty($info['VideoLink'])) { 
                                                foreach($info['VideoLink']	as $image) {
                                                    if($image['image']!='' && file_exists('files/'.$info['Member']['id'].'/image/'.$image['image'])) { $i++;
                                        
										?>
                                        <div class="main_imcont">
                                            <?php echo $this->Html->link($this->Html->image('../files/'.$info['Member']['id'].'/image/'.$image['image'],array('width'=>'125','height'=>'125')),HTTP_ROOT.'files/'.$info['Member']['id'].'/image/'.$image['image'],array('escape'=>false,'class'=>'fancybox-button','rel'=>'fancybox-button','div'=>false,'label'=>false));?>
                                            </div>
                                        <?php 		
                                                    }
                                                }
                                            }if($i==0){ ?>
                                            	<P>No image found.</P>
                                            <?php } ?>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div id="tabs3">
                        <div class="ryt_mainu">
                            <div onclick="inner_rytupp">
                                <div class="images_container">
                                    <h1> Videos </h1>
                                    <div class="inner_imgcont">
                                            <?php $i=0;
                                                if(!empty($info['VideoLink'])) { 
                                                    foreach($info['VideoLink']	as $video) {
                                                        if($video['video_link']!='') {	$i++;										
                                                            $videoUrlCount = strlen($video['video_link'])-11;
                                                            $youtubeUniqueId = substr($video['video_link'],$videoUrlCount); 
                                                            $id	=	base64_encode(convert_uuencode($video['id']));
                                            ?>
                                        <div class="main_imcont">
                                            <?php echo $this->Html->link($this->Html->image('http://img.youtube.com/vi/'.$youtubeUniqueId.'/0.jpg'),HTTP_ROOT.'admin/Users/watch_video/'.$id,array('title'=>'Watch Video','escape'=>false));?>
                                           
                                        </div>
                                            <?php 		
                                                    }
                                                }
                                            }if($i==0){ ?>
                                            	<P>No video found.</P>
											<?php } ?>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
            	</div>
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