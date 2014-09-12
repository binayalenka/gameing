
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
                                    <th width="10%;">Student Name</th> 
                                    <td width="30%;"><?php echo $info['Student']['first_name'].' '.$info['Student']['last_name'];?></td>
                                </tr>
                              
                            	<tr>							
                                    <th width="10%;">E-mail</th> 
                                    <td width="30%;"><?php echo $info['Student']['email'];?></td> 
                                </tr>
                               	<tr>							
                                    <th width="10%;">Message</th> 
                                    <td width="30%;"><?php echo $info['ContactInstructor']['message']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Send Date</th> 
                                    <td width="30%;"><?php echo date('d-M-Y',strtotime($info['ContactInstructor']['send_date']));?></td> 
                                </tr>
                            </tbody>
						</table>                        	                        
					<div class="clear"></div>
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