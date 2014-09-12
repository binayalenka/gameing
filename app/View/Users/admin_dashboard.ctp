<style>
	form li span
	{
		width:100%;
	}
	tr.mceLast
	{
		display:none;
	}
	.ui-widget-content
	{
		float:left;
		width:95%;
	}
</style>

<script type="text/javascript">
	
	$(document).ready(function() {		
		$('#tabs, #tabs2, #tabs5').tabs();
		
	});
	
</script>

<div id="sub-nav">
	<div class="page-title">
		<h1>Dashboard</h1>
	</div>
</div>


<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Dashboard</h2>
			</div>
			
			 <?php if($this->Session->check('success')){ ?>
				<div class="success ui-corner-all successdeveloperClass" id="success">
					<span class='successMessageText'>
					   <?php echo $this->Session->read('success');?>
                    </span>
				</div>
				<?php $this->Session->delete('success'); ?>
			<?php } ?>
            
			<div class="content-box content-box-header" style="border:none;">
							
				<div id="tabs"> 
	        		<ul>
						<!--<li><a href="#tabs-1">Cms Pages</a></li>-->
						<li><a href="#tabs-2">Email Template</a></li>
					</ul>	
                    <?php /*?><div id="tabs-1">                                              
                        <div id="page-content">
                            <div id="page-content-wrapper" style="padding:0; margin:0; background:0; box-shadow:0 0 0 0 #fff;">
                                <div class="hastable">
                                    <table id="sort-table"> 
                                        <thead> 
                                            <tr>
                                                <th width="3%" >S.No</th>
                                                <th width="20%">Title</th>
                                                <th width="30%" >Description</th>
                                                <th width="5%" >Date Modified</th>
                                                <th width="5%">Action</th> 
                                            </tr> 
                                        </thead> 
                                        <tbody> 
                                        
                                        <?php
                                                if(!empty($info))
                                                {
                                                    $i =1;
                                                    foreach($info as $pages)
                                                    { 
                                                ?>
                                                        
                                                        <tr>
                                                            <td><?php echo $i; ?></td> 
                                                            <td><?php echo $pages['CmsPage']['title']?></td>
                                                            <td><?php echo $this->Text->truncate($pages['CmsPage']['description'],150,array('ending'=>'...','exact'=>false));?></td>            
                                                            <td><?php echo date('d-m-Y',strtotime($pages['CmsPage']['date_modified']));?></td>                     
                                                            <td>
                                                                <?php $id = base64_encode(convert_uuencode($pages['CmsPage']['id'])); ?>
                                                                
                                                                <a title="Edit" href="<?php echo HTTP_ROOT."admin/users/edit_cms/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
                                                                    <span class="ui-icon ui-icon-pencil"></span>
                                                                </a>										
                                                                
                                                            </td>
                                                        </tr> 
                                            <?php	
                                                        $i++;	
                                                    }
                                                } else {
                                            ?>
                                                    <tr>
                                                        <td colspan="7">No Record Found.</td>
                                                    </tr>
                                            <?php		
                                                }
                                            ?>							
                                            </tbody>
                                        </table>
                                        <div class="clear"></div>
                                      
                                    </div>
                                    <div class="clear"></div>			
                                </div>
                            <div class="clear"></div>
                        </div>
                    </div><?php */?>
                    
                    <div id="tabs-2">				
						<div id="page-content">
	<div id="page-content-wrapper" style="padding:0; margin:0; background:0; box-shadow:0 0 0 0 #fff;">
		<div class="hastable">
			<table id="sort-table"> 
				<thead> 
					<tr>
						<th>S.No</th>
						<th>Subject</th>
						<th>Description</th>
						<th>Action</th> 
					</tr> 
				</thead> 
				<tbody> 
					<?php
						
						if(!empty($emailTemp))
						{	$i=1;
							foreach($emailTemp as $info)
							{ 
						?>		
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo strtoupper($info['EmailTemplate']['subject']) ; ?></td>
									<td><?php echo strip_tags($this->Text->truncate($info['EmailTemplate']['description'],200,array('ending'=>'...','exact'=>false)));?></td>                                 
									<td>
										<?php $email_id = base64_encode(convert_uuencode($info['EmailTemplate']['id'])); ?>
										
										<a title="Edit" href="<?php echo HTTP_ROOT."admin/users/edit_email_template/".$email_id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
											<span class="ui-icon ui-icon-pencil"></span>
										</a>
		
									</td>
								</tr> 
					<?php	
								$i++;	
							}
						} else {
					?>
							<tr>
								<td colspan="7">No Record Found.</td>
							</tr>
					<?php		
						}
					?>					
				</tbody>
			</table>
			<div class="clear"></div>
			
			<?php /*?><div id="pager">					
				
				<?php echo $this->element('adminElements/table_head'); ?>
				
			</div><?php */?>
			
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
                    </div>
		        </div>
				
					<?php /*?><ul class="sidebar-position">
						<li class="float-left" style="margin-top:20px;"> <a title="Left Sidebar" id="sidebar-left" href="javascript:void(0);" class="btn ui-state-default ui-corner-all"> <span class="ui-icon ui-icon ui-icon-arrowthick-1-w"></span> Left Sidebar </a> </li>
						<li class="float-right"  style="margin-top:20px;"> <a title="Right Sidebar" id="sidebar-right" href="javascript:void(0);" class="btn ui-state-default ui-corner-all"> <span class="ui-icon ui-icon ui-icon-arrowthick-1-e"></span> Right Sidebar </a> </li>
					</ul><?php */?>
					
			</div>
			<div class="clearfix"></div>
			<div id="sidebar">
				<?php //echo $this->element('adminElements/left_right_bar');?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
	<div class="clear"></div>