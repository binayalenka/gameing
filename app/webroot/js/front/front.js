var host = window.location.host;
var proto = window.location.protocol;
var ajax_url = proto+"//"+host+"/";

$(document).ready(function(){

//-------------------------------------------------------------- LOGIN FORM CODE ----------------------------------------

	$('.loginPopUp').click(function() {
		var loginBox = $(this).attr('id');		
		var checkFlag=$(this).attr('rel');		
		if(checkFlag=='waitFlag'){
			return false;
		}
		$.ajax({			
			url:ajax_url+'Members/renderLogin',
			beforeSend:function(){
					$('.loginPopUp').attr('rel','waitFlag');	
			},
			success:function(html){
				
				 console.log(window.console);
				  if(window.console || window.console.firebug) {
				   console.clear();
				  } 
								
				$('.loginForm').html(html);
				$(loginBox).fadeIn(200);		
				var popMargTop = ($(loginBox).height() + 24) / 2; 
				var popMargLeft = ($(loginBox).width() + 24) / 2; 		
				$(loginBox).css({ 
					'margin-top' : -popMargTop,
					'margin-left' : -popMargLeft
				});	   
				$('body').append('<div id="mask"></div>');
				$('#mask').fadeIn(200);	
				$('.loginPopUp').attr('rel','');	
			}
		});	 
		return false;
	});
	
	$('a.close').live('click', function() { 
		$('.login').show();
		  $('#mask , .login-popup').fadeOut(200 , function() {
			$('#mask').remove(); 
				<!--------------------- Hiding image and error messages on login popup----------------------->			
			$('#imageWait').hide(); 
			$('#err_user_name').text(''); 
			$('#err_pass').text(''); 
			$('#err_member_type').text(''); 
				<!--------------------- end----------------------->	
		}); 
		return false;
	});
	
//---END OF LOGIN FORM CODE ----------------------------------------	

//-------------------------------------------------------------- CODE FOR AJAX PAGINATION ----------------------------------------
	$(".pagination a").live('click',function(){	
		
		var getWaitClass= $('#pager').next().attr('class');	
		var acturl= $(this).attr('href');		
		$("."+getWaitClass).show();		
		var randNumber=randomFunc();	
			 
		$.ajax({		
			type:'post',
			url:acturl+randNumber,
			success:function(html){				 
				$(".loadPaginationContent").html(html);
				$("."+getWaitClass).hide();
			}	
		});
		return false;	
	});
		
	$('#back').live('click',function(){
									 
			window.history.previous.href
	});
//---END OF AJAX PAGINATION CODE ----------------------------------------


//------------------------------------------------------FUNCTION FOR DATE PICKER
	/*$(function() {
		$( ".datepicker" ).datepicker({			
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,		
			yearRange: '1930:2030',
			inline: true
		});
		
	});*/
	
		
//--------------------------------------------------------------------FUNCTION FOR ADD AND REMOVE MOBILEs AND EMAILs
		
		$('.addMoreButtonInput').live('click',function(){		
			var count=$(this).attr('rel');	
			var getId=$(this).attr('id');
			var getTableField=getId.split('-');
			var html='<div class="keywordleftdetail"><input type="text" class="text_fore" style="margin-bottom:3px;" name="data['+getTableField[0]+']['+getTableField[1]+'][]"><a href="javascript:void(0)" class="remove" id="'+getId+'" rel=""><img src="'+ajax_url+'/img/front/button_cancel.png"></a></div>';
			$("#"+getTableField[2]).append(html);
			$('#'+getId).attr('rel',parseInt(count)+1);	
			if(count>=2)
			{
				$('#'+getId).hide();
			}
		});	
				
		$('.remove').live('click',function(){
			$(this).parent().remove();	
			var getId=$(this).attr('id');
		
			var count=$('#'+getId).attr('rel');			
			$('#'+getId).attr('rel',parseInt(count)-1);
			if(count<=3)
			{					
				$('#'+getId).show();
			}
		})
//--------------------------------------------------------------------FUNCTION END-----------------------------------------------	

//--------------------------------------------------------------------DELETE EMAILS MOBLES THROUGH AJAX----------------
	$('.deleteMobileEmail').live('click',function(){
		
			var scrollTop=$(window).scrollTop();
			$('.loading').css('margin-top',scrollTop-10);
			$('.loading').show();
			var getId=$(this).attr('id');
			var getRel=$(this).attr('rel');
			var getTableName=getRel.split('%');
			var getRemoveDivId=$(this).parent().parent().attr('id');
			$.ajax({				
				url:ajax_url+'App/deleteMobileEmail/'+getId+'/'+getTableName[0],
				success:function(html){
					if(html=='y')
					{
						//alert(getRemoveDivId);
						$('.loading').hide();
						$('#'+getRemoveDivId).remove();
						var count=$('#'+getTableName[1]).attr('rel');			
						$('#'+getTableName[1]).attr('rel',parseInt(count)-1);
						if(count<=3)
						{					
							$('#'+getTableName[1]).show();
						}
						
						//window.location.reload();
					}
					else
					{
						$('.loading').hide();
					}
				}
			});
			return false;
	});
//--------------------------------------------------------------------END OF DELETE EMAILS MOBLES THROUGH AJAX----------------	

//--------------------------------------------------------------------PERMANENTADDRESS CONFIRMATION----------------	
	$('#confirmaStudentAddress').live('click',function(){
		
		var getCheckVal=$("#confirmaStudentAddress").is(':checked')
		if(getCheckVal==true)
		{
			var address1=$('#corresAddress1').val();
			var address2=$('#corresAddress2').val();
			var corrCity=$('#cCity').val();
			var corrPostCode=$('#cPostCode').val();
			
			$('#permaAddress1').val(address1);
			$('#permaAddress2').val(address2);
			$('#pCity').val(corrCity);	
			$('#pPostCode').val(corrPostCode);
		}
		if(getCheckVal==false)
		{
			$('#permaAddress1').val('');
			$('#permaAddress2').val('');
			$('#pCity').val('');	
			$('#pPostCode').val('');
		}

	});
//--------------------------------------------------------------------END OF DELETE EMAILS MOBLES THROUGH AJAX----------------	

//------------- Courses Year, Courses list, Tier Ajax request --------------------------------------------------------

	$('.selectYear').live('change',function(){
		$('.loadingCourse').show();
		var getYearVal=$(this).val();
		var getUniversityId=$(this).attr('id');
		var getRel=$(this).attr('rel');
		var explodeGetRel=getRel.split("_");
		$.ajax({
				url:ajax_url+'App/courses_list/'+getUniversityId+'/'+getYearVal+'/'+explodeGetRel[1],
				success:function(html){
						$('.loadingCourse').hide();
						$('.'+explodeGetRel[0]).html(html);
				}
		});
	});
	$('.selectCourse').live('change',function(){
	
		$('.loadingTier').show();
		var getCourseId=$(this).val();
		var getRel=$(this).attr('id');
		//var explodeGetRel=getRel.split("_");		
		$.ajax({
				url:ajax_url+'App/tier_list/'+getCourseId,
				success:function(html){
						$('.loadingTier').hide();
						$('.'+getRel).html(html);
				}
		});
	});
	


});
//--------------------------------------------------------------------END OF Function----------------	

function ajax_form_new(form,site_url,classWait)
{   
	var form = form;
	$('.'+classWait).show();	
	var msg ='<ol>';
	var req = $.post
	(	 	
		ajax_url+site_url, 
		$('#' + form).serialize(), 
		function(html)
		{	
			var explode = html.split("\n");
			var shown = false;
			$('.'+classWait).hide();
			for ( var i in explode )
			{
				if(parseInt(i)!=i)
				break;
				var explode_again = explode[i].split("|");
				if ($.trim(explode_again[0])=='error') {
					shown = true;
					$('#err_' + explode_again[1]).show();
					if($('#err_' + explode_again[1]).length>0) {
						
						if($.trim(explode_again[2])=="Password doesn't match"){
							$('#pass').val('');
							$('#conPassword').val('');
						}
						$('#err_' + explode_again[1]).html(explode_again[2]);
						msg += "<li>" + explode_again[1] + "</li>";
					}
					$('.'+classWait).hide();
				}
				else if ($.trim(explode_again[0])=='ok') {
					$('#err_' + explode_again[1]).hide();
					$('.'+classWait).hide();					
				}
			}			
			if ( ! shown ){	
				if(form=='InstContactForm')
				{
					$.ajax({
					url	:	ajax_url+"students/contact_instructor",
					data	:	$('#InstContactForm').serialize(),
					type	:	'post',
					dataType:'json',
					success	:	function(resp)
								{
									if(resp.status=='y'){ 
										$('.regisImage').hide();
										$('#documentViewDiv').hide();
										$('#InstContactForm').find(':input').each(function() {
											switch(this.type){
												case 'password':
												case 'select-multiple':
												case 'select-one':
												case 'text':
												case 'textarea':
												$(this).val('');
												break;
											}
										});
										$('div#'+resp.Id).hide();
										$('div.black_overlay').hide();
										$('#successMessage').fadeIn(500,function(){$('#successMessage').html(resp.message)});
										$('#successMessage').fadeOut(5000);
									}
								}
					});				
					//$('#'+form).submit();							
					$('.'+classWait).hide();
					return false;
				}
				if(form=='rejectRequestForm'){
					$.ajax({
					url	:	ajax_url+"instructors/reject_request",
					data	:	$('#rejectRequestForm').serialize(),
					type	:	'post',
					dataType:'json',
					success	:	function(resp)
								{ 
									if(resp.status=='y'){
										$('.regisImage').hide();
										$('#documentViewDiv').hide();
										$('#rejectRequestForm').find(':input').each(function() {
											switch(this.type){
												case 'password':
												case 'select-multiple':
												case 'select-one':
												case 'text':
												case 'textarea':
												$(this).val('');
												break;
											}
										});
										$('div#'+resp.Id).hide();
										$('div.black_overlay').hide();
										$('#successMessage').fadeIn(500,function(){$('#successMessage').html(resp.message)});
										//$('#successMessage').fadeOut(5000);
										window.location.href=ajax_url+"instructors/pending_approval_list";
									}
								}
					});				
											
					$('.'+classWait).hide();
					return false;
				}
				$('#'+form).submit();	
			}
			else {	
				msg += "</ol>";
				var error = $.trim($(msg).find('li').html());
				//alert($('#err_'+error).offset().top);				
				var fieldId = ($('#err_'+error).offset().top)-100;
				
				$('body,html').animate({
						scrollTop: fieldId
				}, 2000);			
			}			
			req = null;
		}		
	);
	return false;
}
//---------------------------------------------------   FUNCTION FOR FEEDBACK FORM---------------------
function ajax_form_feedback(form,site_url,classWait)
{   
	var form = form;
	$('.'+classWait).show();
	var msg ='<ol>';	
	var req = $.post
	(	 	
		ajax_url+site_url, 
		$('#' + form).serialize(), 
		function(html)
		{	
			var explode = html.split("\n");
			var shown = false;
			$('.'+classWait).hide();
			for ( var i in explode )
			{
				if(parseInt(i)!=i)
				break;
				var explode_again = explode[i].split("|");
				if ($.trim(explode_again[0])=='error') {
					shown = true;
					$('#err_' + explode_again[1]).show();
					if($('#err_' + explode_again[1]).length>0) {
						$('#err_' + explode_again[1]).html(explode_again[2]);
						msg += "<li>" + explode_again[1] + "</li>";
					}
					$('.'+classWait).hide();
				}
				else if ($.trim(explode_again[0])=='ok') {
					$('#err_' + explode_again[1]).hide();
					$('.'+classWait).hide();					
				}
			}			
			if ( ! shown ){	
			if(form=='feedback'){			
				$.ajax({
						url:ajax_url+'Homes/feedback',
						data:$('#' + form).serialize(),
						type:'post',
						dataType:'json',
						success:function(resp){
							if(resp.status=='y'){
								$('#successMessage').fadeIn(500,function(){$('#successMessage').html(resp.message)});
								$('#successMessage').fadeOut(5000);
								$('#feedBackName').val('');
								$('#feedbackEmailId').val('');
								$('#feedbackText').val('');
							}
							if(resp.status=='n'){
								$('#successMessage').html(resp.message);
							}
						}
						
				});
			}
			else if(form=='tutorQualification' || form=='tutorEditQualification'){		
				
				$.ajax({
						url:ajax_url+'App/add_qualification',
						type:'post',
						data:$("#"+form).serialize(),
						success:function(resp){
							 $('.renderQualificationList').html(resp);
							 $("#degree").val('');
							 $("#universityName").val('');
							 $("#gradeGot").val('');
							 $("#yearAwarded").val('');
							 $('#mask , .login-popup').fadeOut(200 , function() {
								$('#mask').remove(); 
					 <!--------------------- Hiding image and error messages on login popup----------------------->			
								$('#imageWait').hide(); 
								$('#err_user_name').text(''); 
								$('#err_pass').text(''); 
								$('#err_member_type').text(''); 
					 <!--------------------- end----------------------->	
							}); 	
						}
					
				});
			}else if(form=='tutorExperience'||form=='tutorEditExperience'){
				
				$.ajax({
						url:ajax_url+'App/add_experience',
						type:'post',
						data:$("#"+form).serialize(),
						success:function(resp){
							 $('.renderExperienceList').html(resp);
							 $("#typeExp").val('');
							 $("#descriptionExp").val('');
							 $("#periodExp").val('');
							 $("#hourExp").val('');
							 
							 $('#mask , .login-popup').fadeOut(200 , function() {
								$('#mask').remove(); 
					 <!--------------------- Hiding image and error messages on login popup----------------------->			
								$('#imageWait').hide(); 
								$('#err_user_name').text(''); 
								$('#err_pass').text(''); 
								$('#err_member_type').text(''); 
					 <!--------------------- end----------------------->	
							}); 	
						}
				});	
			}
			else if(form=='tutorLanguage'||form=='tutorEditExperience1'){
				
				$.ajax({
						url:ajax_url+'App/add_language',
						type:'post',
						data:$("#"+form).serialize(),
						success:function(resp){
							 $('.renderLanguageList').html(resp);
							 $("#typeExp").val('');
							 $("#descriptionExp").val('');
							 $("#periodExp").val('');
							 $("#hourExp").val('');
							 
							 $('#mask , .login-popup').fadeOut(200 , function() {
								$('#mask').remove(); 
					 <!--------------------- Hiding image and error messages on login popup----------------------->			
								$('#imageWait').hide(); 
								$('#err_user_name').text(''); 
								$('#err_pass').text(''); 
								$('#err_member_type').text(''); 
					 <!--------------------- end----------------------->	
							}); 	
						}
				});	
			}
			else if(form=='tutorCompletedLesson'){				
				$.ajax({
						url:ajax_url+'Tutors/update_completed_lesson',
						type:'post',
						data:$("#"+form).serialize(),
						success:function(resp){
							window.location.href=ajax_url+'Tutors/report_booked_lesson/'+resp;
							
						}					
				});
			
			}			
				//$('#'+form).submit();							
				$('.'+classWait).hide();
				return false;
			}
			else {		
				msg += "</ol>";
				var error = $.trim($(msg).find('li').html());
				//alert($('#err_'+error).offset().top);				
				var fieldId = ($('#err_'+error).offset().top)-100;
				
				$('body,html').animate({
						scrollTop: fieldId
				}, 2000);			
			}			
			req = null;
		}		
	);
	return false;
}
	
function add_remove_class(search,replace,element_id)
{
	if ($('#' + element_id).hasClass(search)){
		$('#' + element_id).removeClass(search);
	}
	$('#' + element_id).addClass(replace);
}

function new_overlay(overlay_id)
{
	if($("#"+overlay_id).length!=0)
	{
		position=$("#"+overlay_id).offset();
		var left; var right; var width; var top; var bottom; var height;
		
		left = $("#"+overlay_id).css('padding-left');
		left = left.replace("px","");
		right = $("#"+overlay_id).css('padding-right');
		right = right.replace("px","");		
		width = $("#"+overlay_id).width();
		width = parseInt(width)+parseInt(left)+parseInt(right);
		
		top = $("#"+overlay_id).css('padding-top');
		top = top.replace("px","");
		bottom = $("#"+overlay_id).css('padding-bottom');
		bottom = bottom.replace("px","");		
		height = $("#"+overlay_id).height();
		height = parseInt(height)+parseInt(top)+parseInt(bottom);
		
		$("."+overlay_id).css("width",width);
		$("."+overlay_id).css("height",height);
		$("."+overlay_id).css(position);
		$("."+overlay_id).children("div#new_loading").css("top",($("#"+overlay_id).height())/2);
		$("."+overlay_id).children("div#new_loading").css("left",($("#"+overlay_id).width())/2);
	}
	$("."+overlay_id).show();	
}
function update_share()
{
	document.update_form.data[UserStatus][status].disabled="true";	
	document.update_form.data[UserStatus][status].style.backgroundColor="#FFFFFF";	
}
function showPopUp(trgt)
{
	$("#"+trgt).css('top',($(window).height()/2)-$("#"+trgt).height()/2);
	$("#"+trgt).css('left',$(window).width()/2-$("#"+trgt).width()/2);
	$("#"+trgt).fadeIn("slow");

}

function hidePopUp(trgt)
{
	$("#"+trgt).fadeOut("slow");
	$(".black_overlay").hide();
}

function show_overlay()
{
	if($(".black_overlay").length != '0')
	{
		if (window.innerHeight) 
		{// Firefox
			if(window.scrollMaxY)
			{
				yWithScroll = window.innerHeight + window.scrollMaxY;
				xWithScroll = window.innerWidth + window.scrollMaxX;
			}
			else
			{
				yWithScroll = window.innerHeight;
				xWithScroll = window.innerWidth ;
			}
		} 
		else if (document.body.scrollHeight > document.body.offsetHeight)
		{ // all but Explorer Mac
			yWithScroll = document.body.scrollHeight;
			xWithScroll = document.body.scrollWidth;
		}
		else 
		{ // works in Explorer 6 Strict, Mozilla (not FF) and Safari
			yWithScroll = document.body.offsetHeight;
			xWithScroll = document.body.offsetWidth;
		}
		$(".black_overlay").css('height',$(document).height());
		$(".black_overlay").show();		
	}
}

function showDivAtCenter(divid) 
{
	var scrolledX, scrolledY;
	if( self.pageYoffset )
	{
		scrolledX = self.pageXoffset;
		scrolledY = self.pageYoffset;
	} 
	else if( document.documentElement && document.documentElement.scrollTop ) 
	{
		scrolledX = document.documentElement.scrollLeft;
		scrolledY = document.documentElement.scrollTop;
	} 
	else if( document.body ) 
	{
		scrolledX = document.body.scrollLeft;
		scrolledY = document.body.scrollTop;
	}
	var centerX, centerY;
	if( self.innerHeight ) 
	{
		centerX = self.innerWidth;
		centerY = self.innerHeight;
	} 
	else if( document.documentElement && document.documentElement.clientHeight ) 
	{
		centerX = document.documentElement.clientWidth;
		centerY = document.documentElement.clientHeight;
	}
	else if( document.body ) 
	{
		centerX = document.body.clientWidth;
		centerY = document.body.clientHeight;
	}
	Xwidth=$('#'+divid).width();
	Yheight=$('#'+divid).height();
	
	var leftoffset = scrolledX + (centerX - Xwidth) / 2;
	var topoffset = scrolledY + (centerY - Yheight) / 2;
	
	leftoffset=(leftoffset<0)?0:leftoffset;
	topoffset=(topoffset<0)?0:topoffset;	
	var o=document.getElementById(divid);
	var r=o.style;
	r.top = topoffset + 'px';
	r.left = leftoffset + 'px';
	r.display = "block";  
}

function randomFunc()
{
	var d = new Date();
	var randomNumber = "/" + d.getHours() +""+ d.getMinutes() +""+ d.getSeconds() +""+ d.getMilliseconds();
	return randomNumber;
}

  /*  Funtion for Teacher Search  */
  
  $('#SeacrhTeacher').live('click',function(){
	  
			$('.seacrhImage').show();
			$.ajax({
					url:ajax_url+"students/teacherSearchData",
					data:$('#searchTeacherorm').serialize(),
					type:'post',
					success:function(html){
						$('.seacrhImage').hide();
						if(html=='error'){											
							$(".loadPaginationContent").html('No Record Found');
						} 
						else{
							$(".loadPaginationContent").html(html);
						}
					}
				});		
			return false;									
												 
	});
  
  /*  End of TS*/
  /*  Funtion for Teacher Search before login  */
  
  $('#SeacrhInstructor').live('click',function(){
	  
			$('.seacrhImage').show();
			$.ajax({
					url:ajax_url+"Homes/instructorSearchData",
					data:$('#searchInstructorForm').serialize(),
					type:'post',
					success:function(html){
						$('.seacrhImage').hide();
						if(html=='error'){											
							$(".loadPaginationContent").html('No Record Found');
						} 
						else{
							$(".loadPaginationContent").html(html);
						}
					}
				});		
			return false;									
												 
	});
  
  /*  End of TS*/
  
  
 