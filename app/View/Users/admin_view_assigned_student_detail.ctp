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
				<h2 style="width:90%; ">Assigned Student Information</h2>
				<a style="margin-top:-10px;" class="ui-state-default ui-corner-all float-right ui-button" href="javascript:void(0);" onclick="history.go(-1);">Back</a>
				<span></span>
			</div>
			
			<div class="content-box content-box-header" style="border:none;">
			<div class="hastable">			
                   			<table id="sort-table"> 
                            <tbody>
                            	<tr>
                                	<td class="head_for_table">
                                    	S.No.
                                    </td>
                                    
                                    <td class="head_for_table">
                                    	Document Name/Download
                                    </td>
                                    
                                    <td class="head_for_table">
                                    	Date Added
                                    </td>
                                </tr>
								<?php 
									foreach($info as $key=>$info){ ?>							
                            	<tr>
                                	
                                    <th width="20%;">Document-<?php echo $key+1; ?></th> 
                                    <td width="30%;">	 
										<?php 
											$path = 'files-'.$s_id.'-personal_repo-';
                                            echo $this->Html->link($info['InstructorAssignmentDocument']['file_name'],array('controller'=>'App','action'=>'download_admin/',$path,$info['InstructorAssignmentDocument']['file_name'],'admin'=>false),array('title'=>'Download your Submission','style'=>'padding-right:10px;'));
										?>
                                    </td>
                                    <td width="20%;"><?php echo $info['InstructorAssignmentDocument']['date_added']; ?></td> 
                                </tr>
                                
                               	<?php 
									}
								?>                                
                            </tbody>
						</table>                        	                        
					
					<div class="clear"></div>
				</div>
			</div>
			<div class="clearfix"></div>
				<div id="sidebar">
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div> 
<style>
.head_for_table
{
	text-align:center !important;
	font-size:12px;
	font-weight:bold;
}
</style>