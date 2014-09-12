<?php $this->Paginator->options(array('url' => array('controller'=>'Users','action'=>'cmspages','admin'=>true))); ?>
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
							$i = $this->Paginator->counter('%start%');
							foreach($info as $pages)
							{ 
						?>
                        		
                                <tr>
									<td><?php echo $i; ?></td> 
                                    <td><?php echo $pages['CmsPage']['title']?></td>
                                    <td><?php echo $this->Text->truncate(strip_tags($pages['CmsPage']['description']),150,array('ending'=>'...','exact'=>false));?></td>            
                                    <td><?php echo date('d-M-Y',strtotime($pages['CmsPage']['date_modified']));?></td>                     
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
				<div id="pager">					
				
					<?php echo $this->element('adminElements/table_head'); ?>
				
				</div>
			</div>
        	<div class="clear"></div>			
		</div>
		<div class="clear"></div>
	</div> 
            