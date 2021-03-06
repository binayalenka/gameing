
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
		<h1>Contacts Details</h1>
	</div>
</div>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2 style="width:90%; ">Contacts Information</h2>
				<a style="margin-top:-10px;" class="ui-state-default ui-corner-all float-right ui-button" href="javascript:void(0);" onclick="history.go(-1);">Back</a>
				<span></span>
			</div>
			
			<div class="content-box content-box-header" style="border:none;">
			<div class="hastable">			
                   			<table id="sort-table"> 
                            <tbody>
                            	<tr>							
                                    <th width="10%;">Name</th> 
                                    <td width="30%;"><?php echo $info['Contact']['first_name'].' '.$info['Contact']['last_name']; ?></td> 
                                </tr>
                                 
                            	<tr>							
                                    <th width="10%;">E-Mail</th> 
                                    <td width="30%;"><?php echo $info['Contact']['email']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Contact Type</th> 
                                    <td width="30%;"><?php echo $info['Contact']['contact_type']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Message</th> 
                                    <td width="30%;"><?php echo $info['Contact']['message']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Date Added</th> 
                                    <td width="30%;"><?php echo date('d-M-Y',strtotime($info['Contact']['date_added'])); ?></td> 
                                </tr>
                                 
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