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
		<h1>View Pending Approval </h1>
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
                                    <th width="10%;">Student Name</th> 
                                    <td width="30%;"><?php echo $info['Student']['first_name'].' '.$info['Student']['last_name']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Title</th> 
                                    <td width="30%;"><?php echo $info['Event']['title']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Class</th> 
                                    <td width="30%;">
									<?php 
										if($info['Event']['sub_cate_id']!='0')
										{	
											echo ucwords($info['Event']['SubCategory']['name']);
										}
										else
										{
											echo ucwords($info['Instructor']['sub_category_name']);
										} 
									?>
                                    </td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Start Date</th> 
                                    <td width="30%;"><?php echo $info['Event']['start_date']; ?></td> 
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