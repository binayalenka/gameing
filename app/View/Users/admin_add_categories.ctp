<style>
	form li span
	{
		width:100%;
	}
	tr.mceLast
	{
		display:none;
	}
	.size
	{
		width:255px !important;
		
	}
</style>
<div id="sub-nav">
	<div class="page-title">
		<h1>Add Category</h1>
	</div>
</div>

<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Add Category</h2>
                <a style="margin-top:-10px;" class="ui-state-default ui-corner-all float-right ui-button" href="javascript:void(0);" onclick="history.go(-1);">Back</a>
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
						Add Category
					</div>
					
					 <?php echo $this->Form->create('Category',array('id'=>'CateId','url'=>array('controller'=>'Users','action'=>'add_categories','admin'=>true))); ?>
                    <div class="content-box-wrapper">
                 	
                    <fieldset>
                    <ul>
                        <li>
                            <label class="desc" >Category Name</label>
                            <div>
                                <?php echo $this->Form->input('name',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                
                             <p class="tutor-add-Error" id="err_name"><?php if(isset($error['name'][0])) echo $error['name'][0]; ?>  </p>   
                            </div>
                        </li>   
                        <li>
                            <input class="sub-bttn" type="submit" value="Submit" onclick='return ajax_form("CateId","Users/validate_add_categories_ajax","newloading")'/>
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