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
                <div id="tabs1">
                    <div class="hastable">			
                        <table id="sort-table"> 
                            <tbody>
                                <tr>							
                                    <th width="10%;">Title</th> 
                                    <td width="30%;"><?php echo $info['Event']['title']; ?></td> 
                                </tr>
                                 
                                <tr>							
                                    <th width="10%;">Category</th> 
                                    <td width="30%;"><?php echo $info['Category']['name']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Sub-Category</th> 
                                    <td width="30%;">
									<?php 
										if($info['Event']['sub_cate_id']!='0')
										{	
											echo ucwords($info['SubCategory']['name']);
										}
										else
										{
											echo ucwords($info['Member']['sub_category_name']);
										} 
									?>
                                    </td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Start Date</th> 
                                    <td width="30%;"><?php echo $info['Event']['start_date']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Held On</th> 
                                    <td width="30%;">
									<?php 
										$allSelectdays = explode(',',$info['Event']['days']);
										$weekDays = array('1'=>'Monday','2'=>'Tuesday','3'=>'Wednesday','4'=>'Thursday','5'=>'Friday','6'=>'Saturday','7'=>'Sunday');
										$days = array();
										foreach($allSelectdays as $alldays){
											$days[] = $weekDays[$alldays];
										} 
										echo implode(", ",$days);
										?>
                                    </td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">End Date</th> 
                                    <td width="30%;"><?php echo $info['Event']['end_date']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Start Time</th> 
                                    <td width="30%;">
                                    <?php if($info['Event']['start_time'] > 12){  
										echo $info['Event']['start_time'] - 12 .':00'." PM";
										} else{
										echo $info['Event']['start_time']." AM";
										}
									?>
                                    </td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">End Time</th> 
                                    <td width="30%;">
                                    <?php if($info['Event']['end_time'] > 12){  
										echo $info['Event']['end_time'] - 12 .':00'." PM";
										} else{
										echo $info['Event']['end_time']." AM";
										}
									?>
                                    </td> 
                                </tr>
                                 <tr>							
                                    <th width="10%;">Venue Name</th> 
                                    <td width="30%;"><?php echo $info['Event']['venue_name']; ?></td> 
                                </tr>
                                 <tr>							
                                    <th width="10%;">City</th> 
                                    <td width="30%;"><?php echo $info['Event']['city']; ?></td> 
                                </tr>
                                 <tr>							
                                    <th width="10%;">State</th> 
                                    <td width="30%;"><?php echo $info['Event']['state']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Country</th> 
                                    <td width="30%;"><?php echo $info['Country']['country_name']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Zip-Code</th> 
                                    <td width="30%;"><?php echo $info['Event']['zip_code']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Status</th> 
                                    <td width="30%;">
									<?php 
										if($info['Event']['status']=='1'){
											echo "Active";
										}elseif($info['Event']['status']=='0'){
											echo "Inactive";
										}
										?>
									</td> 
                                </tr>
                                <tr>							
                                    <th width="10%;"><?php echo __('Accepting New Student'); ?></th> 
                                    <td width="30%;"><?php echo ucwords($info['Event']['accept_student']);?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Description</th> 
                                    <td width="30%;"><?php echo $info['Event']['description']; ?></td> 
                                </tr>
                            </tbody>
                        </table>                        	                        
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