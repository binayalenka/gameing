<script type="text/javascript">
$('#resend').live('click',function(){
			
		var id ="<?php echo $id ?>";
		$.post(ajax_url+'/Homes/resend_email',{id : id},function(resp){
		$('.success_msg').html(resp);
			
		});
});
</script>
<div class="mid_sectionmain">
    <div class="mid_sectionholders">
      <div class="mid_outerarea">
        <div class="middle_bg">
          <div class="instructor_profileinner">
            <div class="instructor_innermain">
            <div class="success_msg">
                                
            </div>
              <div class="instructor_innerspaces">
                <div class="instructor_innerbg">
                	<div class="outer_innerabtus">
                        <div class="inner_aboutus">
                        <h5><?php echo __('Success Message');?></h5>
                            <div class="outer_aboutus">
                            	<div class="thnx_msg" > <h3> <?php echo $msg; ?> </h3>
                                	<div class="oter_co"> 
                                    	<div class="iner_co">
                                    	<span style="font:Verdana, Geneva, sans-serif; font-size:14px"><?php echo __('If you did not get an e-mail click on this link!'); ?></span>
                                    	<a href="javascript:void(0);" id="resend"><?php echo __('Resend Activation Link'); ?></a>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="msg_end">
                                        <b style="font-size:14px" > <?php echo __('Thanks'); ?> </b>
                                        <b style="font-size:14px" > <?php echo __('Tambark Team'); ?> </b>
                                    </div>
                            	</div>
                    		</div>
                  	</div>
                </div>
                <div class="clear"></div>
              </div>
            </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="clear"></div>
  </div>
  