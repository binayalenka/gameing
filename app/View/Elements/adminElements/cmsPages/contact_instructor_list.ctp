<?php $this->Paginator->options(array('url' => array('controller'=>'Users','action'=>'student_contact_instructor','admin'=>true))); ?>
<div id="page-content">
	<div id="page-content-wrapper" style="padding:0; margin:0; background:0; box-shadow:0 0 0 0 #fff;">
		<div class="hastable">
			<table id="sort-table"> 
				<thead> 
					<tr>
					    <th width="5%" >S.No</th>
						<th width="10%">Student Name</th>
						<th width="13%" >Title</th>
                        <th width="30%" >Message</th>
                        <th width="10%" >Date Added</th>
                       	<th width="7%">Action</th> 
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
                                    <td><?php echo $info['Student']['first_name'].' '.$info['Student']['last_name'];?></td>
                                    <td><?php echo $info['ContactInstructor']['title'];?></td>
                                    <td><?php echo $this->Text->truncate(strip_tags($info['ContactInstructor']['message']),100,array('ending'=>'...','exact'=>false));?></td>
                                    <td><?php echo date('d-M-Y',strtotime($info['ContactInstructor']['send_date']));?></td>
                                              
                                    <td>
										<?php 
											$id = base64_encode(convert_uuencode($info['ContactInstructor']['id'])); 
											$stuId = base64_encode(convert_uuencode($info['Student']['id'])); 
											$table= base64_encode('ContactInstructor');
											$renderPath=base64_encode('cmsPages');
											$renderElement=base64_encode('Contact_instructor_list');
										?>
										
                                        <a title="View" href="<?php echo HTTP_ROOT."admin/users/view_contact_student/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
											<span class="ui-icon ui-icon-search"></span>
										</a>
                                        
                                        <a title="View Assigned Instructor" href="<?php echo HTTP_ROOT."admin/users/view_assigned_instructor/".$id.'/'.$stuId;?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
											<span class="ui-icon ui-icon-person"></span>
										</a>
                                        
                                       	<a title="Delete" href="javascript:void(0);" class="delRec btn_no_text btn ui-state-default ui-corner-all tooltip" id="<?php echo $id; ?>" onclick='deleteUser("admin/Users/delete_record","<?php echo $page; ?>","<?php echo $id; ?>","<?php echo $table ?>","<?php echo $renderPath ?>","<?php echo $renderElement ?>")'>
										
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
            