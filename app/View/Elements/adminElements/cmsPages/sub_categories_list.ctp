<?php $this->Paginator->options(array('url' => array('controller'=>'Users','action'=>'admin_sub_categories'))); ?>


 <div id="page-content">

	<div id="page-content-wrapper" style="padding:0; margin:0; background:0; box-shadow:0 0 0 0 #fff;">

		<div class="hastable">
	
			<table id="sort-table"> 
				<thead> 
					<tr>
						<th width="5%">S.No.</th>
                        <th>Category</th>
                         <th>Sub-Category</th>
						<th width="25%">Date</th>
                        <th width="25%">Action</th> 
					</tr> 
				</thead> 
				<tbody> 
			
					<?php
						if(!empty($info))
						{
							$i = $this->Paginator->counter('%start%');
							foreach($info as $category)
							{ 
						?>
								<tr>
									<td><?php echo $i; ?></td> 
									<td><?php echo $category['Category']['name']; ?></td>
                                    <td><?php echo $category['SubCategory']['name']; ?></td>
									<td><?php echo date('d-M-Y',strtotime($category['SubCategory']['date'])); ?></td>
                                    <td>
										<?php 
											$id = base64_encode(convert_uuencode($category['SubCategory']['id'])); 
											$table= base64_encode('SubCategory');
											$renderPath=base64_encode('cmsPages');
											$renderElement=base64_encode('sub_categories_list');
										?>
										<a title="Edit" href="<?php echo HTTP_ROOT."admin/users/edit_sub_categories/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
											<span class="ui-icon ui-icon-pencil"></span>
										</a>
										<a title="Update Status" href="javascript:void(0);" class="updateStatus btn_no_text btn ui-corner-all tooltip <?php echo($category['SubCategory']['status']==0?'ui-state-hover':'ui-state-default') ?>" onclick='updateStatus("admin/Users/update_status","<?php echo $page; ?>","<?php echo $id; ?>","<?php echo $table ?>","<?php echo $renderPath ?>","<?php echo $renderElement	 ?>")'>
											<span class="ui-icon ui-icon-lightbulb"></span>
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
			
			<div id="pager" class="pagination">
				<?php echo $this->element('adminElements/table_head'); ?>
			</div>
				
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
