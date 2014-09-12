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
		<h1>Frequently Asked Questions</h1>
	</div>
</div>


<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Add Frequently Asked Questions</h2>
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

						Add Frequently Asked Questions

					</div>
					
					<div id="tabs"> 
                     <?php echo $this->Form->create('Faq',array('class'=>'editTemplateForm','id'=>'addFaq','url'=>array('controller'=>'users','action'=>'add_faq'))); ?>
						<div id="tabs1">
								<div class="content-box-wrapper">
									
								<fieldset>
									<ul>
                                    	<?php /*?><li>
											<label class="desc" >Faq For</label>
											<div>
                                             <?php echo $this->Form->input('Faq.faq_type',array('type'=>'select','id'=>'faq_for','value'=>"",'class'=>'field text full ','style'=>'height:25px;','div'=>false,'label'=>false,'options'=>array('1'=>'Student','2'=>'Tutor'))); ?> 
                                             <p class="tutor-add-Error" id="err_faq_type"><?php if(isset($error['faq_type'][0])) echo $error['faq_type'][0]; ?>  </p> 
											</div>
										</li> <?php */?>
										<li>
											<label class="desc" >Faq's Question</label>
											<div>
                                             <?php echo $this->Form->input('faq_ques',array('type'=>'text','id'=>'questions','class'=>'field text full ','div'=>false,'label'=>false)); ?> 
                                             <p class="tutor-add-Error" id="err_faq_ques"><?php if(isset($error['faq_ques'][0])) echo $error['faq_ques'][0]; ?>  </p> 
											</div>
										</li> 
                                        <li>
											<label class="desc" >Faq's Answer</label>
											<div>
                                              	  <?php echo $this->Form->input('faq_ans',array('type'=>'textarea','div'=>false,'label'=>false,'class'=>'fck')); ?>
                                                 <p class="tutor-add-Error" id="err_faq_ans"><?php if(isset($error['faq_ans'][0])) echo $error['faq_ans'][0]; ?>  </p> 
											</div>
										</li>    
										
                                        <li>
										
                                            <input class="sub-bttn" type="submit" value="Submit"/>
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
				<!--	
					<ul class="sidebar-position">
						<li class="float-left" style="margin-top:20px;"> <a title="Left Sidebar" id="sidebar-left" href="javascript:void(0);" class="btn ui-state-default ui-corner-all"> <span class="ui-icon ui-icon ui-icon-arrowthick-1-w"></span> Left Sidebar </a> </li>
						<li class="float-right"  style="margin-top:20px;"> <a title="Right Sidebar" id="sidebar-right" href="javascript:void(0);" class="btn ui-state-default ui-corner-all"> <span class="ui-icon ui-icon ui-icon-arrowthick-1-e"></span> Right Sidebar </a> </li>
					</ul>
					-->
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