<div id="sub-nav">
	<div class="page-title">
		<h1>Edit Blog</h1>
	</div>
</div>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Edit Blog</h2>
                <a style="margin-top:-10px;" class="ui-state-default ui-corner-all float-right ui-button" href="javascript:void(0);" onclick="history.go(-1);">Back</a>
				<span></span>
			</div>
			<div class="content-box content-box-header" style="border:none;">

				<div class="column-content-box">

					<div class="ui-state-default ui-corner-top ui-box-header">

						<span class="ui-icon float-left ui-icon-notice"></span>
						Edit Blog Post
                        </div>
					
					 <?php echo $this->Form->create('Blog',array('id'=>'BlogId','url'=>array('controller'=>'Users','action'=>'edit_blog','admin'=>true))); ?>
                    <div class="content-box-wrapper">
                 	<?php echo $this->Form->input('id',array('type'=>'hidden','readonly'=>true,'value'=>$blogInfo['Blog']['id'],'div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                    <?php echo $this->Form->input('m_id',array('type'=>'hidden','readonly'=>true,'value'=>$blogInfo['Blog']['m_id'],'div'=>false,'label'=>false,'class'=>'text full field required')); ?>
                    <fieldset>
                    <ul>
                        <li>
                            <label class="desc" >Title</label>
                            <div>
                                
								<?php echo $this->Form->input('title',array('type'=>'text','value'=>$blogInfo['Blog']['title'],'div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                             <p class="tutor-add-Error" id="err_title"><?php if(isset($error['title'][0])) echo $error['title'][0]; ?>  </p>   
                            </div>
                        </li>   
                        <li>
                            <label class="desc" >Description</label>
                            <div>
                                <?php echo $this->Form->input('description',array('type'=>'textarea','value'=>$blogInfo['Blog']['description'],'div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                             <p class="tutor-add-Error" id="err_description"><?php if(isset($error['description'][0])) echo $error['description'][0]; ?>  </p>                            </div>
                        </li>
                        <li>
                            <input class="sub-bttn" type="submit" value="Submit" onclick='return ajax_form("BlogId","Users/validate_add_blog_ajax","newloading")'/>
                            <div class="newloading">
                                <?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                            </div> 
                        </li>
                    </ul>
                    </fieldset>
                    </div>
                    <?php echo $this->Form->end(); ?>
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
</div>