<?php $this->Paginator->options(array('url' => array('controller'=>'Users','action'=>'admin_student_tooltip'))); ?>
<div id="page-content">

	<div id="page-content-wrapper" style="padding:0; margin:0; background:0; box-shadow:0 0 0 0 #fff;">

		<div class="hastable">
	
			<table id="sort-table"> 
				<thead> 
					<tr>
						<th width="3%">S.No.</th>
                        <th width="9%">Title</th> 
                        <th width="13%">Message</th> 
                        <th width="13%">Action</th> 
						
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
									<td><?php echo $teacher_detail['Tooltip']['title']; ?></td>
                                    <td><?php echo $this->Text->truncate($teacher_detail['Tooltip']['description'],'50',array('ending'=>'...','exact'=>true)); ?></td>
                                    <td >
										<?php 
												$id = base64_encode(convert_uuencode($teacher_detail['Tooltip']['id'])); 
												$table= base64_encode('Tooltip');
												$renderPath=base64_encode('cmsPages');
												$renderElement=base64_encode('instructor_tooltip_list');
										?>
										<?php //echo $memberType;?>
										<a title="View" href="<?php echo HTTP_ROOT."admin/Users/view_tooltip/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
											<span class="ui-icon ui-icon-search"></span>
										</a>
                                         <a title="Edit" href="<?php echo HTTP_ROOT."admin/users/edit_tooltip/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
											<span class="ui-icon ui-icon-pencil"></span>
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
