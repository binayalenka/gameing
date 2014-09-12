<?php $this->Paginator->options(array('url' => array('controller'=>'Users','action'=>'admin_instructor_events'))); ?>
<div id="page-content">

	<div id="page-content-wrapper" style="padding:0; margin:0; background:0; box-shadow:0 0 0 0 #fff;">

		<div class="hastable">
	
			<table id="sort-table"> 
				<thead> 
					<tr>
						<th width="3%">S.No.</th>
                        <th width="9%">Profile Picture</th> 
                        <th width="13%">Name</th> 
						<th width="15%">Email</th>
                        <th width="10%">Phone</th>
                        <th width="10%">City</th> 
                        <th width="10%">ZipCode</th> 
						<th width="10%">State</th> 
                        <th width="10%">Country</th> 
                        <th width="10%">View Events</th> 
					</tr> 
				</thead> 
				<tbody> 
			
					<?php
						if(!empty($info))
						{
							$i = $this->Paginator->counter('%start%');
							foreach($info as $teacher_detail)
							{ 
						?>
								<tr>
									<td><?php echo $i; ?></td>
                                    <td>
									<?php if($teacher_detail['Member']['image']!='' && file_exists('files/'.$teacher_detail['Member']['id'].'/'.$teacher_detail['Member']['image'])) 
										{ 
											echo $this->Html->image(HTTP_ROOT.'files/'.$teacher_detail['Member']['id'].'/'.$teacher_detail['Member']['image'],array('width'=>100,'height'=>100,'div'=>false,'label'=>false));
										}else{
											echo $this->Html->image('profile_pic.png',array('width'=>100,'height'=>100));
										}
									?>
                                    </td>
									<td><?php echo $teacher_detail['Member']['first_name']." ".$teacher_detail['Member']['last_name']; ?></td> 
									<td><?php echo $teacher_detail['Member']['email']; ?></td>
                                    <td><?php echo $teacher_detail['Member']['phone']; ?></td>
                                    <td><?php echo $teacher_detail['Member']['city']; ?></td>
                                    <td><?php echo $teacher_detail['Member']['zipcode']; ?></td>
                                    <td><?php echo $teacher_detail['Member']['state']; ?></td>
                                    <td><?php echo $teacher_detail['Country']['country_name']; ?></td>
									<td >
										<?php 
												$id = base64_encode(convert_uuencode($teacher_detail['Member']['id'])); 
												$table= base64_encode('Member');
												$renderPath=base64_encode('cmsPages');
												$renderElement=base64_encode('instructor_events_list');
										?>
										<?php //echo $memberType;?>
										<a title="View Classes" href="<?php echo HTTP_ROOT."admin/Users/events/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
											<span class="ui-icon ui-icon-search"></span>
										</a>
                                        <a title="View BroadCast" href="<?php echo HTTP_ROOT."admin/Users/broadcasts/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
											<span class="ui-icon ui-icon-video"></span>
										</a>
                                        <a title="View Pending Approval" href="<?php echo HTTP_ROOT."admin/Users/pending_student_approval/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
											<span class="ui-icon ui-icon-clock"></span>
										</a>
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
