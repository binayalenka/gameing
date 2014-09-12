<?php $this->Paginator->options(array('url' => array('controller'=>'Users','action'=>'admin_promo_code'))); ?>


 <div id="page-content">
	<div id="page-content-wrapper" style="padding:0; margin:0; background:0; box-shadow:0 0 0 0 #fff;">
		<div class="hastable">
			<table id="sort-table"> 
				<thead> 
					<tr>
						<th width="5%">S.No.</th>
                       	<th width="15%">Promo Code</th> 
                        <th width="15%">Expiry Date</th> 
                        <th width="15%">Added Date</th> 
						<th width="15%">Status</th>
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
                                    <td><?php echo $info['PromoCode']['promo_code']?></td>
                                    <td><?php echo $info['PromoCode']['expiry_date']?></td>
                                    <td><?php echo $info['PromoCode']['date_added'];?></td>
                                    <td>
									<?php echo $info['PromoCode']['status'];?>
                                    </td> 
                                    <td>
										<?php 
											$id = base64_encode(convert_uuencode($info['PromoCode']['id'])); 
											$table= base64_encode('PromoCode');
											$renderPath=base64_encode('cmsPages');
											$renderElement=base64_encode('promo_code_list');
										?>
                                        <a title="View Events" href="<?php echo HTTP_ROOT."admin/Users/view_promo_code/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
											<span class="ui-icon ui-icon-search"></span>
										</a>
                                        
                                        <a title="Edit" href="<?php echo HTTP_ROOT."admin/users/edit_promo_code/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
											<span class="ui-icon ui-icon-pencil"></span>
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
