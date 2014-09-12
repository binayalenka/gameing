<?php $this->Paginator->options(array('url' => array('controller'=>'Users','action'=>'student_invitation_list','admin'=>true))); ?>
<div id="page-content">
	<div id="page-content-wrapper" style="padding:0; margin:0; background:0; box-shadow:0 0 0 0 #fff;">
		<div class="hastable">
			<table id="sort-table"> 
				<thead> 
					<tr>
					    <th width="5%" >S.No</th>
						<th width="12%">Instructor Name</th>
						<th width="15%" >Receiver E-Mail</th>
                        <th width="15%" >Class</th>
                        <th width="28%" >Message</th>
                        <th width="10%" >Invite Code</th>
                        <th width="7%" >Status</th>
                       	<th width="8%">Action</th> 
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
                                    <td><?php echo $info['Member']['first_name'].' '.$info['Member']['last_name'];?></td>
                                    <td><?php echo $info['SendInvitation']['email'];?></td>
                                    <td><?php echo $info['Event']['title'];?></td>
                                    <td><?php echo $this->Text->truncate(strip_tags($info['SendInvitation']['message']),150,array('ending'=>'...','exact'=>false));?></td>
                                    <td><?php echo $info['SendInvitation']['invite_code'];?></td>
                                    <td><?php echo $info['SendInvitation']['status'];?></td>
                                              
                                    <td>
                                    
										<?php 
											$id = base64_encode(convert_uuencode($info['SendInvitation']['id'])); 
											$table = base64_encode('SendInvitation');
											$renderPath = base64_encode('cmsPages');
											$renderElement = base64_encode('student_invitation_list');
										?>
										
                                        <a title="View" href="<?php echo HTTP_ROOT."admin/users/view_student_invitation/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
											<span class="ui-icon ui-icon-search"></span>
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
            