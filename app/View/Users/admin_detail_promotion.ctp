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
		<h1>Promotion Details</h1>
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
                <div id="tabs">
                   
                    <div id="tabs1">
                    	<div class="hastable">			
                            <table id="sort-table"> 
                                <tbody>
                                    <tr>							
                                        <th width="10%;">Subject</th> 
                                        <td width="30%;"><?php echo ucwords($info['Promotion']['subject']);?></td> 
                                     </tr>
                                     <tr>							
                                        <th width="10%;">Student Name</th> 
                                        <td width="30%;"><?php echo $info['Member']['first_name'].' '.$info['Member']['last_name']; ?></td> 
                                    </tr>
                                    <tr>	
                                        <th width="10%;">Description</th> 
                                        <td width="30%;"><?php echo $info['Promotion']['message']; ?></td> 
                                    </tr>
                                    <tr>							
                                        <th width="10%;">Date</th> 
                                        <td width="30%;"><?php echo $info['Promotion']['date']; ?></td> 
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