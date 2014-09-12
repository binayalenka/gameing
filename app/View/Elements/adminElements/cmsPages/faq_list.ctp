<?php $this->Paginator->options(array('url' => array('controller'=>'Users','action'=>'admin_faq','admin'=>true))); ?>
<div id="page-content">
	<div id="page-content-wrapper" style="padding:0; margin:0; background:0; box-shadow:0 0 0 0 #fff;">
		<div class="hastable">
			<table id="sort-table"> 
				<thead> 
					<tr>
					    <th width="5%" >S.No</th>
						<th width="20%">Frequently Asked Questions</th>
						<th width="30%" >Answers</th>
                       <!--  <th width="10%" >Faq Type </th>-->
                        <th width="10%" >Date Added </th>
                        <th width="10%" >Date Modified</th>
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
									<td><?php echo $i; ?></td> 
                                    <td><?php echo $info['Faq']['faq_ques']?></td>
                                    <td><?php echo $this->Text->truncate(strip_tags($info['Faq']['faq_ans']),150,array('ending'=>'...','exact'=>false));?></td>
                                    <?php /*?><td>
										<?php 
											if($info['Faq']['faq_type']!=0){
												switch($info['Faq']['faq_type']){
												case '1':
														echo "Student";
														break;
												case '2':
														echo "Tutor";
														break;			
												}
												
											}else{
												echo "No Record found";	
											}
												
										?>
                                    </td> <?php */?>   
                                    <td><?php echo date('d-M-Y',strtotime($info['Faq']['date_added']));?></td>
                                    <td><?php echo date('d-M-Y',strtotime($info['Faq']['date_modified'])); ?></td>                     
                                    <td>
                                    
										<?php 
											$id = base64_encode(convert_uuencode($info['Faq']['id'])); 
											$table= base64_encode('Faq');
											$renderPath=base64_encode('cmsPages');
											$renderElement=base64_encode('faq_list');
										?>
										
                                        <a title="View" href="<?php echo HTTP_ROOT."admin/users/view_faq/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
											<span class="ui-icon ui-icon-search"></span>
										</a>
                                        
                                        <a title="Edit" href="<?php echo HTTP_ROOT."admin/users/edit_faq/".$id; ?>" class="btn_no_text btn ui-state-default ui-corner-all tooltip">
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
				<div id="pager">					
				
					<?php echo $this->element('adminElements/table_head'); ?>
				
				</div>
			</div>
        	<div class="clear"></div>			
		</div>
		<div class="clear"></div>
	</div> 
            