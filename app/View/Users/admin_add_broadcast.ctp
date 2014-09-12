<script type="text/javascript">
	$(document).ready(function(){
	
		var type = $(".websites6").val();
			if($.trim(type) == 'Video'){
				$(".videoType").show();
				$(".imageType").hide();
			}else if($.trim(type) == 'File'){
				$(".imageType").show();
				$(".videoType").hide();
			}
			
			$(".websites6").live('change',function(){
				var val = $('.websites6').val();
				if($.trim(val) == 'Video'){
					$(".videoType").show();
					$(".imageType").hide();
				}else if($.trim(val) == 'File'){
					$(".imageType").show();
					$(".videoType").hide();
				}else if($.trim(val) == ''){
					$(".imageType").hide();
					$(".videoType").hide();
				}
			});
		$('#CheckallStudent').click(function(){
				
				if($(this).is(':checked'))
				{
					$('.studentId').attr('checked',true);
				}else{
					$('.studentId').attr('checked',false);
				}
		});
		
	});
</script>
<style>
.width_min
{
	width:200px !important;
}

</style>
<div id="sub-nav">
	<div class="page-title">
		<h1>Add Broadcast</h1>
	</div>
</div>

<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Add Broadcast</h2>
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
						Add Broadcast
					</div>
					
					 <?php echo $this->Form->create('Broadcast',array('id'=>'broadcastForm','url'=>array('controller'=>'Users','action'=>'add_broadcast',$id,'admin'=>true),'enctype'=>'multipart/form-data')); ?>
                     <?php echo $this->Form->input('t_id',array('type'=>'hidden','value'=>$memberId,'div'=>false,'label'=>false)); ?> 
                    <div class="content-box-wrapper">
                 	
                    <fieldset>
                    <ul>
                        
                        
                        <li>
                            <label class="desc" >Type (optional)</label>
                            <div>
                            	<?php $type = array(''=>'Select','Video'=>'Audio/Video link','File'=>'File'); ?>
                                <?php echo $this->Form->input('type',array('type'=>'select','options'=>$type,'div'=>false,'label'=>false,'class'=>'text full field required websites6')); ?>
                                 <p class="tutor-add-Error" id="err_type"><?php if(isset($error['type'][0])) echo $error['type'][0]; ?>  </p> 
                            </div>
                        </li>
                        
                        <li>
                            <label class="desc" >Title</label>
                            <div>
                                <?php echo $this->Form->input('title',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                             <p class="tutor-add-Error" id="err_title"><?php if(isset($error['title'][0])) echo $error['title'][0]; ?>  </p>   
                            </div>
                        </li> 
                         <li>
                            <label class="desc" >Comment</label>
                            <div>
                                <?php echo $this->Form->input('comment',array('type'=>'textarea','style'=>'resize:none','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                             <p class="tutor-add-Error" id="err_comment"><?php if(isset($error['comment'][0])) echo $error['comment'][0]; ?>  </p>   
                            </div>
                        </li>   
                        
                        <li class="imageType" style="display:none">
                            <label class="desc" >Select File</label>
                            <div>
                                <?php echo $this->Form->input('file',array('type'=>'file','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                <label style="font-size:10px; float:left; width:100%;">	<?php echo __('eg:	only (doc, pdf, txt, xlsx, xls, docx) files are allowed');?>	</label>
                                <p class="tutor-add-Error" id="err_file"><?php if(isset($error['file'][0])) echo $error['file'][0]; ?></p>   
                            </div>
                        </li>
                        
                        <li class="videoType" style="display:none">
                            <label class="desc" >Video</label>
                            <div>
                                <?php echo $this->Form->input('url',array('type'=>'text','div'=>false,'label'=>false,'class'=>'text full field required')); ?> 
                                <?php echo __('eg:	http://www.youtube.com/watch?v=uq0deNeXaDg');?>	</label>
                             <p class="tutor-add-Error" id="err_url"><?php if(isset($error['url'][0])) echo $error['url'][0]; ?>  </p>   
                            </div>
                        </li> 
                        <li>
                        
                            <label class="desc" >Choose Student(s)</label>
                            <div class="hastable">
                                <table id="sort-table"> 
                                    <thead> 
                                        <tr>						
                                            <th width="5%"><?php echo $this->Form->input('checkall',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'CheckallStudent','title'=>'Select all students')); ?></th>                                              
                                             <th width="5%"> <?php echo __('Student Name'); ?> </th>
                                             <th width="5%"> <?php echo __('Email Id'); ?> </th> 
                                        </tr> 
                                    </thead> 
                                    <tbody> 
                                    <?php //pr($m_id);die;
                                        if(!empty($all_student))
                                        {
                                            //$i = $this->Paginator->counter('%start%');
                                            foreach($all_student as $students)
                                            { 
                                        ?>
                                                 <tr>
                                                    <td align="center" class="s_numbertxts"> 
                                                        <?php echo $this->Form->input('Broadcast.students_id.'.$students['Member']['id'],array('type'=>'checkbox','div'=>false,'label'=>false,'class'=>'studentId','title'=>'Select student','value'=>$students['Member']['id'])); ?>              
                                                    </td>                                                        
                                                    <td align="center" class="add_eventtxts"> <?php echo $students['Member']['first_name']." ".$students['Member']['last_name'];?> </td>
                                                    <td align="center" class="add_eventtxts"> <?php echo $students['Member']['email']; ?> </td>
                                                </tr>
                                        <?php	
                                                    
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
                                <p class="tutor-add-Error" id="err_checkall"><?php if(isset($error['checkall'][0])) echo $error['checkall'][0]; ?>  </p>
                                <div class="clear"></div>
                            </div>
                             
                        </li>    
                        
                        <li>
                            <input class="sub-bttn" type="submit" value="Submit" onclick='return ajax_form("broadcastForm","Users/validate_admin_add_broadCast_ajax","newloading")'/>
                            
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
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>
</div>