<?php $this->Paginator->options(array('url' => array('controller'=>'Users','action'=>'instructor_workroom_list',$id,'admin'=>true))); ?>
<div id="page-content">
	<div id="page-content-wrapper" style="padding:0; margin:0; background:0; box-shadow:0 0 0 0 #fff;">
		<div class="hastable">
			<table id="sort-table"> 
				<thead> 
					<tr>
					    <th width="5%" >S.No</th>
						<th width="20%">Class Title</th>
						<th width="35%" >Workroom Title</th>
                        <th width="10%" >Date</th>
                       	<th width="10%">Action</th> 
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
									<td><?php echo $i; ?></td> 
                                    <td><?php echo $info['Event']['title'];?></td>
                                    <td><?php echo $info['Workroom']['title'];?></td>
                                    <td><?php echo $info['Workroom']['date_added'];?></td>
                                    <td>
										<?php 
											$mem_id = base64_encode(convert_uuencode($info['Workroom']['m_id'])); 
											$id = base64_encode(convert_uuencode($info['Workroom']['id'])); 
											$table = base64_encode('Workroom');
											$renderPath = base64_encode('cmsPages');
											$renderElement = base64_encode('instructor_workroom_listing');
										?>
										
                                        <a title="View" href="<?php echo HTTP_ROOT."admin/users/workroom_posts/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
											<span class="ui-icon ui-icon-search"></span>
										</a>
                                       	<a title="Delete" href="javascript:void(0);" class="delRec btn_no_text btn ui-state-default ui-corner-all tooltip" id="<?php echo $id; ?>" onclick='deleteUser("admin/Users/delete_workroom_record","<?php echo $mem_id; ?>","<?php echo $page; ?>","<?php echo $id; ?>","<?php echo $table ?>","<?php echo $renderPath ?>","<?php echo $renderElement ?>")'>
                                        <span class="ui-icon ui-icon-circle-close"></span>
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
            