
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
	
		$("#descriptionText").live('focusout',function(){
			var countCharacters = $("#descriptionText").val().length;
			if(countCharacters > 300){
				alert('Words should be less than or equal to 300');
				 $("#descriptionText").focus();
			}
		});
		$("#editToopTip").submit(function(){
			var countCharacters = $("#descriptionText").val().length;
			if(countCharacters > 300){
				alert('Words should be less than or equal to 300');
				 $("#descriptionText").focus();
				return false;
			}
			
		});
		/*var oFCKeditor = new FCKeditor() ;
		FCKeditor.BasePath	= ajax_url+'js/fckeditor/' ;
		//oFCKeditor.BasePath	= sBasePath ;
		//oFCKeditor.ReplaceTextarea() ;
		FCKeditor.ReplaceAllTextareas() ;*/
	});
</script>

<div id="sub-nav">
	<div class="page-title">
		<h1>Tooltip</h1>
	</div>
</div>


<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Edit Tooltip</h2>
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

						Edit Tooltip

					</div>
					
					<div id="tabs"> 
                     <?php echo $this->Form->create('Tooltip',array('class'=>'editTemplateForm','id'=>'editToopTip','url'=>array('controller'=>'users','action'=>'edit_tooltip'))); ?>
						<div id="tabs1">
								<div class="content-box-wrapper">
									
								<fieldset>
									<ul>
										<li>
											<label class="desc" >Title</label>
											<div>
                                            <?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$info['Tooltip']['id'],'readonly'=>'readonly')); ?> 
                                            <?php echo $this->Form->input('type',array('type'=>'hidden','value'=>$info['Tooltip']['type'],'readonly'=>'readonly')); ?> 
                                            
												 <?php echo $this->Form->input('title',array('type'=>'text','value'=>$info['Tooltip']['title'],'readonly'=>true,'class'=>'field text full','div'=>false,'label'=>false)); ?> 
                                             <p class="tutor-add-Error" id="err_faq_ques"><?php if(isset($error['title'][0])) echo $error['title'][0]; ?>  </p>    
											</div>
										</li> 
                                        <li>
											<label class="desc" >Message </label><label >(Message should be 300 characters only)</label>
                                            
											<div>
                                              	 <?php echo $this->Form->input('description',array('type'=>'textarea','value'=>$info['Tooltip']['description'],'div'=>false,'label'=>false,'style'=>'width:750px;','id'=>'descriptionText')); ?> 
                                             <p class="tutor-add-Error" id="err_faq_ans"><?php if(isset($error['description'][0])) echo $error['description'][0]; ?>  </p>   
											</div>
										</li>    
										
                                        <li>
                                            <input class="sub-bttn" type="submit" value="Submit"/>
                                            <div class="adminAddFaq">
                                                <?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                                            </div> 
                                           
										</li>
									</ul>
								</fieldset>
								</div>
							</div>
				     <?php echo $this->Form->end(); ?>
	       	 	</div>
				<!--	
					<ul class="sidebar-position">
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