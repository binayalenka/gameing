
<style>
	.hastable tbody th
	{
		padding:10px;
	}
	.hastable tr td
	{
		text-align:left;
	}	
</style>


<div id="sub-nav">
	<div class="page-title">
		<h1>Assignment</h1>
	</div>
</div>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2 style="width:90%; ">Assignment Information</h2>
				<a style="margin-top:-10px;" class="ui-state-default ui-corner-all float-right ui-button" href="javascript:void(0);" onclick="history.go(-1);">Back</a>
				<span></span>
			</div>
			
			<div class="content-box content-box-header" style="border:none;">
			<div class="hastable">			
                   			<table id="sort-table"> 
                            <tbody>
                            	<tr>							
                                    <th width="10%;">Assignment Title</th> 
                                    <td width="30%;"><?php echo $info['InstructorAssignment']['title']; ?></td> 
                                </tr>
                                
                                <tr>							
                                    <th width="10%;">Assignment</th> 
                                    <td width="30%;">
									<span style="text-decoration:underline;">
                                    <?php echo $this->Html->link($info['InstructorAssignment']['file'],HTTP_ROOT.'files/'.$info['InstructorAssignment']['t_id'].'/personal_repo/'.$info['InstructorAssignment']['file']);?>
                                    </span>
                                    </td> 
                                </tr>
                                
                                <tr>							
                                    <th width="10%;">Class Title</th> 
                                    <td width="30%;"><?php echo $info['Event']['title']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Instructor Name</th> 
                                    <td width="30%;"><?php echo $info['Event']['Member']['first_name']." ".$info['Event']['Member']['last_name']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Last Date</th> 
                                    <td width="30%;"><?php echo $info['InstructorAssignment']['date_added']; ?></td> 
                                </tr>
                            	<tr>							
                                    <th width="10%;">Subject</th> 
                                    <td width="30%;"><?php echo $info['InstructorAssignment']['description']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Status</th> 
                                    <td width="30%;">	<?php echo $info['InstructorAssignmentStudent']['status'] == '1'?'Submitted':'Pending';?>	</td>
                                </tr>
                               
							   <?php if($info['InstructorAssignmentStudent']['status'] == '1') { ?>
                              		<tr>							
                                    <th width="10%;">Download File</th> 
                                    <td width="30%;" style="font-size:12px !important">
											<?php 
												foreach($infoDoc as $infoDoc) {
												$path = 'files-'.$info['InstructorAssignmentStudent']['s_id'].'-personal_repo-';
												echo $this->Html->link($infoDoc['InstructorAssignmentDocument']['file_name'],array('controller'=>'App','action'=>'download_admin/',$path,$infoDoc['InstructorAssignmentDocument']['file_name'],'admin'=>false),array('title'=>'Download Submission','style'=>'padding-right:10px; margin-top:10px;'));
												echo "<p style='margin-top:-18px'></p></br>";
											}
											?>
                                    </td>
                                </tr>
                               <?php  } ?>
                                 
                            </tbody>
						</table>                        	                        
					
					<div class="clear"></div>
				</div>
					
				<!--	<ul class="sidebar-position">
						<li class="float-left" style="margin-top:20px;"> <a title="Left Sidebar" id="sidebar-left" href="javascript:void(0);" class="btn ui-state-default ui-corner-all"> <span class="ui-icon ui-icon ui-icon-arrowthick-1-w"></span> Left Sidebar </a> </li>
						<li class="float-right"  style="margin-top:20px;"> <a title="Right Sidebar" id="sidebar-right" href="javascript:void(0);" class="btn ui-state-default ui-corner-all"> <span class="ui-icon ui-icon ui-icon-arrowthick-1-e"></span> Right Sidebar </a> </li>
					</ul>-->
					
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