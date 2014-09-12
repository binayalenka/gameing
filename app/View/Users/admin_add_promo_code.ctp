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
	function randomString()
	{
		var chars = "!@#$%&?abcdefghijklmnopqrstkuvwxyzABCDEFGHIJKLMNOPQRSTUVWXTZ0123456789";
		var string_length = 8;
		var randomstring = '';
		for (var i=0; i<string_length; i++) {
			var rnum = Math.floor(Math.random() * chars.length);
			randomstring += chars.substring(rnum,rnum+1);
	}	
	$('#set_promo').val(randomstring);
	
} 
</script>
<div id="sub-nav">
	<div class="page-title">
		<h1>Add Promo Code</h1>
	</div>
</div>

<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper" class="no-bg-image wrapper-full">
			<div class="inner-page-title">
				<h2>Add Promo Code</h2>
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
						Add Promo Code
					</div>
					
					 <?php echo $this->Form->create('PromoCode',array('id'=>'promoId','url'=>array('controller'=>'Users','action'=>'add_promo_code','admin'=>true))); ?>
                    <div class="content-box-wrapper">
                 	
                    <fieldset>
                    <ul>
                        <li>
                            <label class="desc" >Promo Code</label>
                            <div>
                                <?php echo $this->Form->input('promo_code',array('type'=>'text','readonly'=>true,'value'=>'','div'=>false,'label'=>false,'class'=>'text field required','id'=>'set_promo')); ?>
                                <?php echo $this->Form->input('Generate Promo Code',array('type'=>'button','onclick'=>'randomString(); return false;','div'=>false,'label'=>false)) ;?> 
                            </div>
                            <p class="tutor-add-Error"><?php if(isset($error['promo_code'][0])) echo $error['promo_code'][0]; ?>  </p>   
                        </li>
                         <li>
                            <label class="desc" >Enter Expiry Date</label>
                            <div>
                                <?php echo $this->Form->input('expiry_date',array('type'=>'text','readonly'=>true,'div'=>false,'label'=>false,'class'=>'text field required datepicker')); ?>
                            </div>
                            <p class="tutor-add-Error"><?php if(isset($error['promo_code'][1])) echo $error['promo_code'][1]; ?>  </p>   
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