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
	
		var oFCKeditor = new FCKeditor() ;
		FCKeditor.BasePath	= ajax_url+'js/fckeditor/' ;
		//oFCKeditor.BasePath	= sBasePath ;
		//oFCKeditor.ReplaceTextarea() ;
		FCKeditor.ReplaceAllTextareas() ;
	});
	
</script>
<div id="sub-nav">
	<div class="page-title">
		<h1> Delete Record</h1>
	</div>
</div>


<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Create an e-mail in your own words</h2>
				<span></span>
			</div>
			
			 <?php if($this->Session->check('success')){ ?>
				<div class="success ui-corner-all successdeveloperClass" id="success">
					<span class='successMessageText'>
					   <?php echo $this->Session->read('success');?>
                    </span>
				</div>
				<?php $this->Session->delete('success'); ?>
			<?php } ?>
		
			<div class="content-box content-box-header" style="border:none;">

				<div class="column-content-box">

					<div class="ui-state-default ui-corner-top ui-box-header">

						<span class="ui-icon float-left ui-icon-notice"></span>
						Delete Record
					</div>
					
					<div id="tabs"> 
                     <?php echo $this->Form->create('SendMail',array('id'=>'sendMailUpdateStatus','url'=>array('controller'=>'users','action'=>'delete_record_mail/'.$m_id))); ?>
						<div id="tabs1">
								<div class="content-box-wrapper">
								<?php  echo $this->Form->input('id',array('type'=>'hidden','value'=>$m_id,'div'=>false,'label'=>false));?> 	
								<fieldset>
									<ul>
										<li>
											<label class="desc" >Subject</label>
											<div>
                                             <?php echo $this->Form->input('subject',array('type'=>'text','id'=>'questions','class'=>'field text full ','div'=>false,'label'=>false)); ?> 
                                             <p class="tutor-add-Error" id="err_subject"><?php if(isset($error['subject'][0])) echo $error['subject'][0]; ?>  </p> 
											</div>
										</li> 
                                        <li>
											<label class="desc" >Message</label>
											<div>
                                              	  <?php echo $this->Form->input('message',array('type'=>'textarea','div'=>false,'label'=>false,'class'=>'fck')); ?>
                                                 <p class="tutor-add-Error" id="err_message"><?php if(isset($error['message'][0])) echo $error['message'][0]; ?>  </p> 
											</div>
										</li>    
										<li>
										
                                            <input class="sub-bttn" type="submit" value="Delete Record"/>
											 <div class="adminAddFaq">
                                        		<?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                                            </div> 
										</li>
                                       
									</ul>
                                    <?php echo $this->Form->end(); ?>
								</fieldset>
								</div>
							</div>
					</form>
	       	 	</div>
			</div>
			<div class="clearfix"></div>
			<div id="sidebar">
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>