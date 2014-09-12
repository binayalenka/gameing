<script language="javascript" type="text/javascript">
$(document).ready(function(){
		$(".datepicker").datepicker({	
			minDate: new Date(),
			dateFormat:'yy-mm-dd',
			changeMonth: true,
			changeYear: true,		
			yearRange: '1930:2030',
			inline: true
		});
	});
</script>
<div id="sub-nav">
	<div class="page-title">
		<h1>Edit Memory Management</h1>
	</div>
</div>

<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Edit Memory Management</h2>
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

						
					</div>
					<?php  $id = base64_encode(convert_uuencode($info['MemoryManagement']['id'])); ?>
					 <?php echo $this->Form->create('MemoryManagement',array('id'=>'promoId','url'=>array('controller'=>'Users','action'=>'edit_memory_managment/'.$id,'admin'=>true))); ?>
                    <div class="content-box-wrapper">
                    <fieldset>
                    <ul>
                        <li>
                            <label class="desc" >Memory for Student</label>
                            <div>
                            	<?php $memory_type = array('MB'=>'MB','GB'=>'GB'); ?> 
                                <?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$info['MemoryManagement']['id'])); ?>
                                <?php echo $this->Form->input('student',array('type'=>'text','value'=>$info['MemoryManagement']['student'],'div'=>false,'label'=>false,'class'=>'text field required')); ?>
                                <?php echo $this->Form->input('student_memory_type',array('type'=>'select','options'=>$memory_type,'value'=>$info['MemoryManagement']['student_memory_type'],'div'=>false,'label'=>false,'class'=>'text field required')); ?>
                            </div>
                            <p class="tutor-add-Error"><?php if(isset($error['student'][0])) echo $error['student'][0]; ?>  </p>
                        </li>
                         <li>
                            <label class="desc" >Memory for Instructor</label>
                            <div>
                                <?php echo $this->Form->input('teacher',array('type'=>'text','value'=>$info['MemoryManagement']['teacher'],'div'=>false,'label'=>false,'class'=>'text field required')); ?>
                                <?php echo $this->Form->input('teacher_memory_type',array('type'=>'select','options'=>$memory_type,'value'=>$info['MemoryManagement']['teacher_memory_type'],'div'=>false,'label'=>false,'class'=>'text field required')); ?>
                            </div>
                             <p class="tutor-add-Error"><?php if(isset($error['teacher'][1])) echo $error['teacher'][1]; ?>  </p>
                        </li>    
                        <li>
                            <input class="sub-bttn" type="submit" value="Submit" />
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