
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
		<h1>Class Request</h1>
	</div>
</div>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2 style="width:90%; ">Details</h2>
				<a style="margin-top:-10px;" class="ui-state-default ui-corner-all float-right ui-button" href="javascript:void(0);" onclick="history.go(-1);">Back</a>
				<span></span>
			</div>
			
			<div class="content-box content-box-header" style="border:none;">
			<div class="hastable">			
                   			
                            
                            <table id="sort-table"> 
                            <tbody>
                            	<tr>							
                                    <th width="10%;">Student Name</th> 
                                    <td width="30%;"><?php echo $info['ClassRequest']['name'];?></td>
                                </tr>
                              
                            	<tr>							
                                    <th width="10%;">E-mail</th> 
                                    <td width="30%;"><?php echo $info['ClassRequest']['email_id'];?></td> 
                                </tr>
                               	<tr>							
                                    <th width="10%;">Zip Code</th> 
                                    <td width="30%;"><?php echo $info['ClassRequest']['zip_code']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%">City</th>
                                     <td width="30%;"><?php echo $info['ClassRequest']['city']; ?></td>  
                                </tr>
                                <tr>							
                                    <th width="10%">State</th>
                                     <td width="30%;"><?php echo $info['ClassRequest']['state']; ?></td>  
                                </tr>
                                <tr>							
                                    <th width="10%">Country</th>
                                     <td width="30%;"><?php echo $info['ClassRequest']['country']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%">Class Name</th>
                                     <td width="30%;"><?php echo $info['Category']['name']; ?></td>  
                                </tr><tr>							
                                    <th width="10%">Description</th>
                                    <td width="30%;"><?php echo $info['ClassRequest']['class_description']; ?></td>  
                                </tr>
                                <tr>							
                                    <th width="10%">Date</th>
                                     <td width="30%;"><?php echo $info['ClassRequest']['date_added']; ?></td> 
                                </tr>
                                
                            </tbody>
						</table>                        	                        
					<div class="clear"></div>
				</div>
			</div>
			<div class="clearfix"></div>
			
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div> 