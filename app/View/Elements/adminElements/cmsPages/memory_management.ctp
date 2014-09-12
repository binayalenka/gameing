<?php $this->Paginator->options(array('url' => array('controller'=>'Users','action'=>'admin_memory_management'))); ?>


 <div id="page-content">
	<div id="page-content-wrapper" style="padding:0; margin:0; background:0; box-shadow:0 0 0 0 #fff;">
		<div class="hastable">
			<table id="sort-table"> 
				<thead> 
					<tr>
						<th width="15%">Memory For Student</th> 
                        <th width="15%">Memory For Instructor</th>
                        <th width="15%">Date Modified</th>  
                        <th width="15%">Action</th>  
					</tr> 
				</thead> 
				<tbody> 
					<?php
						if(!empty($info))
						{
							$i = $this->Paginator->counter('%start%');
							foreach($info as $info)
							{ 
						?>
								<tr>
                                    <td><?php echo $info['MemoryManagement']['student']." ".$info['MemoryManagement']['student_memory_type'];?></td>
                                    <td><?php echo $info['MemoryManagement']['teacher']." ".$info['MemoryManagement']['teacher_memory_type'];?></td>
                                    <td><?php echo $info['MemoryManagement']['date_modified'];?></td>
                                   
                                    <td>
                                    	<?php $id = base64_encode(convert_uuencode($info['MemoryManagement']['id'])); ?>
                                        <a title="Edit" href="<?php echo HTTP_ROOT."admin/users/edit_memory_managment/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
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
			<div id="pager" class="pagination">
				<?php echo $this->element('adminElements/table_head'); ?>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
