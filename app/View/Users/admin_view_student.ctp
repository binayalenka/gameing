<?php echo $this->Html->Css('fancybox/jquery.fancybox');?>
<?php echo $this->Html->Css('fancybox/jquery.fancybox-buttons');?>
<?php echo $this->Html->Css('fancybox/jquery.fancybox-thumbs');?>
<?php echo $this->Html->script('fancybox/jquery.fancybox');?>
<?php echo $this->Html->script('fancybox/jquery.fancybox-buttons');?>
<script>

$(document).ready(function(){
	
	$('#tabs').tabs();
	
});

</script>
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
		<h1>View Students Information</h1>
	</div>
</div>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2 style="width:90%; ">View Students Information</h2>
				<a style="margin-top:-10px;" class="ui-state-default ui-corner-all float-right ui-button" href="javascript:void(0);" onclick="history.go(-1);">Back</a>
				<span></span>
			</div>
			
            <div class="content-box content-box-header" style="border:none;">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs1">View Profile</a></li>
                        
                    </ul>
                    <div id="tabs1">
                    	<div class="hastable">			
                            <table id="sort-table"> 
                                <tbody>
                                	
                                    <tr>							
                                        <th width="10%;">Profile Picture</th> 
                                        <td width="30%;">
										<?php if($info['Member']['image']!='' && file_exists('files/'.$info['Member']['id'].'/'.$info['Member']['image']))
										{ 
											echo $this->Html->image(HTTP_ROOT.'files/'.$info['Member']['id'].'/'.$info['Member']['image'],array('width'=>100,'height'=>100));
											
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