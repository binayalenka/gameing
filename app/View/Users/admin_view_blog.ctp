
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
		<h1>Post Details</h1>
	</div>
</div>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2 style="width:90%; ">Post Details</h2>
				<a style="margin-top:-10px;" class="ui-state-default ui-corner-all float-right ui-button" href="javascript:void(0);" onclick="history.go(-1);">Back</a>
				<span></span>
			</div>
			
			<div class="content-box content-box-header" style="border:none;">
			<div class="hastable">			
                   			<table id="sort-table"> 
                            <tbody>
                                <tr>							
                                    <th width="10%;">Title</th> 
                                    <td width="30%;"><?php echo $info['Blog']['title']; ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">File/Picture/video</th> 
                                    <td width="30%;">
									<?php // echo ucwords($info['Blog']['description']); ?>
                                    <?php if($info['Blog']['m_type']==1){
												$path='/image/';
											}else{
												$path='/';
											}
									?>
									<?php //pr($posts['Blog']['id']);
									if(!empty($info['Blog']['image'])){
										$imgArray = array('jpg','jpeg','png','gif');
										$docArray = array('doc','docx');
										
										$ext = explode('.',$info['Blog']['image']);
										if(in_array($ext[1],$imgArray)){
											echo $this->Html->image('../files/'.$info['Blog']['m_id'].$path.$info['Blog']['image'],array('style'=>'width:400px;height:300px;'));	
										}elseif(in_array($ext[1],$docArray)){
											echo $this->Html->image(HTTP_ROOT.'img/docDownload.png',array('url'=>'../../files/'.$info['Blog']['m_id'].$path.$info['Blog']['image'],'style'=>'width:100px;height:100px;cursor:pointer','title'=>'click here to download this document.','alt'=>$info['Blog']['image']));
										}
									}elseif($info['Blog']['image']== NULL && $info['Blog']['video_link']!= NULL){ ?>
									
										<iframe width="400px" height="202px" src="<?php echo $info['Blog']['video_link'];?>" frameborder="0" allowfullscreen></iframe>
									<?php }
									?>
                                                                       
                                    </td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Description</th> 
                                    <td width="30%;"><?php echo ucwords($info['Blog']['description']); ?></td> 
                                </tr>
                                <tr>							
                                    <th width="10%;">Date Added</th> 
                                    <td width="30%;"><?php echo $info['Blog']['date_added']; ?></td> 
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