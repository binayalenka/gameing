<?php echo $this->Html->script('jquery.validate.js'); ?>


<style>
	form li span
	{
		width:100%;
	}
	tr.mceLast
	{
		display:none;
	}
</style>

<script type="text/javascript">
	
	$(document).ready(function() {
		
		$('.editTemplateForm').validate();
		
		var oFCKeditor = new FCKeditor() ;
		FCKeditor.BasePath	= ajax_url+'js/fckeditor/' ;
		//oFCKeditor.BasePath	= sBasePath ;
		//oFCKeditor.ReplaceTextarea() ;
		FCKeditor.ReplaceAllTextareas() ;
	});
	
</script>

<div id="sub-nav">
	<div class="page-title">
		<h1> Edit Email Template</h1>
	</div>
</div>


<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Email Template Detail</h2>
				<span></span>
			</div>
			
			<?php if($this->Session->check('error')){ ?>
				<div class="response-msg error ui-corner-all">
					<span>Error message</span>
					<?php echo $this->Session->read('error');?>
				</div>
				<?php $this->Session->delete('error'); ?>
			<?php } ?>
		
			<div class="content-box content-box-header" style="border:none;">

				<div class="column-content-box">

					<div class="ui-state-default ui-corner-top ui-box-header">

						<span class="ui-icon float-left ui-icon-notice"></span>

						Email Template Information

					</div>
					
					<div id="tabs"> 
                    <?php echo $this->Form->create('EmailTemplate',array('class'=>'editTemplateForm' ,'id'=>'editTemplateForm','url'=>array('controller'=>'users','action'=>'edit_email_template','admin'=>true)));
					 ?>
					
						<?php foreach($info as $info) { ?>
						
							<div id="tabs1">
								
								<div class="content-box-wrapper">
									
								<fieldset>
									<ul>
										<li>
                                         <?php 
											echo $this->Form->input('id',array('type'=>'hidden','value'=>$info['EmailTemplate']['id']));
											?>
											<label class="desc" >Subject</label>
											<div>
                                                
                                                <?php
												echo $this->Form->input('subject',array('type'=>'text','class'=>'field text full required','value'=>$info['EmailTemplate']['subject'],'div'=>'false','label'=>false));
												?>
											</div>
										</li>  
									  
										<li>
											<label class="desc" >From Email</label>
											<div>
                                             <?php
												echo $this->Form->input('email_from',array('type'=>'text','class'=>'field text full required','value'=>$info['EmailTemplate']['email_from'],'div'=>'false','label'=>false));
											?>
                                            </div>
										</li>
										<li>
											<label class="desc" >ShortCodes <font color="#FF0000"> &nbsp; Do Not Change These variables </font></label>
											<div>
                                             <?php
												echo $this->Form->input('a',array('class'=>'field text full required','value'=>$info['EmailTemplate']['allowed_vars'],'type'=>'text','div'=>'false','label'=>false,'readonly'=>true));
											?>
                                            </div>
										</li>
										<li>
											<label class="desc" >Email Content</label>
											<div>
												<?php /*?><textarea class="tinymce" style="width:100%;" name="data[<?php echo $i; ?>][EmailTemplate][html_content]"><?php echo $info['EmailTemplate']['html_content']; ?></textarea><?php */?>
                                                <?php
												echo $this->Form->input('description',array('class'=>'fck','value'=>$info['EmailTemplate']['description'],'type'=>'textarea','div'=>'false','label'=>false,'style'=>'width:100%'));
											?>
											</div>
										</li>                                       
										<li><?php
											echo $this->Form->input('Submit',array('type'=>'submit','class'=>'sub-bttn','value'=>'Submit','label'=>false,'div'=>false));
										 	?>
											
										</li>
									</ul>
								</fieldset>
								</div>
							</div>
						<?php  } ?>		
					</form>
	       	 	</div>
					
				<!--	<ul class="sidebar-position">
						<li class="float-left" style="margin-top:20px;"> <a title="Left Sidebar" id="sidebar-left" href="javascript:void(0);" class="btn ui-state-default ui-corner-all"> <span class="ui-icon ui-icon ui-icon-arrowthick-1-w"></span> Left Sidebar </a> </li>
						<li class="float-right"  style="margin-top:20px;"> <a title="Right Sidebar" id="sidebar-right" href="javascript:void(0);" class="btn ui-state-default ui-corner-all"> <span class="ui-icon ui-icon ui-icon-arrowthick-1-e"></span> Right Sidebar </a> </li>
					</ul>-->
					
			</div>
			<div class="clearfix"></div>
			<div id="sidebar">
				<?php // echo $this->element('adminElements/left_right_bar');?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
	<div class="clear"></div>