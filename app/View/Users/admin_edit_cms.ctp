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
		<h1> Edit CMS PAGE</h1>
	</div>
</div>


<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>CMS PAGE Detail</h2>
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

						CMS PAGE Information

					</div>
					
					<div id="tabs"> 
                     <?php echo $this->Form->create('CmsPage',array('class'=>'editTemplateForm','url'=>array('controller'=>'users','action'=>'edit_cms','id'=>'cmspage'))); ?>
						<div id="tabs1">
								<div class="content-box-wrapper">
									
								<fieldset>
									<ul>
										<li>
											<label class="desc" >Title</label>
											<div>
                                            <?php echo $this->Form->input('CmsPage.id',array('id'=>'pageid','type'=>'hidden','value'=>$info['CmsPage']['id'],'readonly'=>'readonly')); ?> 
                                            
												 <?php echo $this->Form->input('CmsPage.title',array('type'=>'text','id'=>'pagetitle','readonly'=>true,'value'=>$info['CmsPage']['title'],'class'=>'field text full required','div'=>false,'label'=>false)); ?> 
											</div>
										</li> 
                                        <li>
											<label class="desc" >Page Title</label>
											<div>
                                              	 <?php echo $this->Form->input('CmsPage.page_title',array('id'=>'pageid','type'=>'text','value'=>$info['CmsPage']['page_title'],'div'=>false,'label'=>false,'class'=>'field text full required')); ?> 
											</div>
										</li>    
									  	<li>
											<label class="desc" >Description</label>
											<div>
                                               <?php echo  $this->Form->input('CmsPage.description',array('class'=>'fck','style'=>'width:100%','value'=>$info['CmsPage']['description'],'div'=>false,'label'=>false)); ?>
											</div>
										</li>                                       
										<li>
                                      
											<input class="sub-bttn" type="submit" value="Submit"/>
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