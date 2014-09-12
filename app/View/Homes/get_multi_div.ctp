<div class="populate">
<?phpforeach($counts as $count) { ?>
<div class="clickMe"><input class="populateButton" name="button" value="click me"/></div>
<?php } ?>
</div>

<script>
$(document).ready(function () {
	$('#capcode').live('click',function(){
		var randomNumber= randomFunc();
		$('.regisImage1').show();
		$.ajax({
			url:ajax_url+'homes/capturecode'+randomNumber,
			//cache:false,
			success:function(html){
				
				$('.captcha_image').html(html);
				$('.regisImage1').hide();
			}
		});
	});
});
</script>
