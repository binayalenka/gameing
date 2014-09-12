
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
		<h1>Send Invitation Details</h1>
	</div>
</div>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2 style="width:90%; ">Send Invitation Information</h2>
				<a style="margin-top:-10px;"class="ui-state-default ui-corner-all float-right ui-button" href="javascript:void(0);" onclick="history.go(-1);">Back</a>
				<span></span>
			</div>
			<div class="content-box content-box-header" style="border:none;">
			<div class="hastable">			
                   		<table id="sort-table"> 
                            <tbody>
                            	<tr>							
                                    <th width="10%;">Instructor Name</th> 
                                    <td width="30%;"><?php echo ucwords($info['Member']['first_name'].' '.$info['Member']['last_name']); ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Class</th> 
                                    <td width="30%;"><?php echo $info['Event']['title']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">E-Mail</th> 
                                    <td width="30%;"><?php echo $info['SendInvitation']['email']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Message</th> 
                                    <td width="30%;"><?php echo $info['SendInvitation']['message']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Date Added</th> 
                                    <td width="30%;"><?php echo $info['SendInvitation']['date_added']; ?></td> 
                                </tr>
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