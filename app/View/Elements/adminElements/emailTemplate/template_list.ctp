<?php $this->Paginator->options(array('url' => array('controller'=>'Users','action'=>'email_templates','admin'=>true))); ?>

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
						if(!empty($info))
						{
							$i = $this->Paginator->counter('%start%');
							foreach($info as $info)
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
			
			<div id="pager">					
				
				<?php echo $this->element('adminElements/table_head'); ?>
				
			</div>
			
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
