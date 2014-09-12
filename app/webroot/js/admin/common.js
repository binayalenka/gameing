var host = window.location.host;
var proto = window.location.protocol;
var ajax_url = proto+"//"+host+"/";

$(document).ready(function(){

//------------------------------------------------------------------------------------Function For Ajax pagination----------------------		
		$(".pagination a").live('click',function(){	
		
		var acturl= $(this).attr('href');		
		$(".loading").show();		
		//var randNumber=randomFunc();	
			 
		$.ajax({		
			type:'post',
			url:acturl,
			success:function(html){				 
				$(".loadPaginationContent").html(html);
				$(".loading").hide();
			}	
		});
	
		return false;	
	});
//------------------------------------------------------------------------------------Function END----------------------
	$('#showEmailLink').live('click',function(){			
		
		var relVal=$('#addMoreEmail').attr('rel');	
		$('#addMoreEmail').attr('rel',parseInt(relVal)+1);
		if(relVal>=2)
		{
			$('#addMoreEmail').hide();
		}
		else
		{
			$('#addMoreEmail').show();
		}
		$('#divMoreEmail').show();
		$('#showEmailLink').hide();	
	});
	$('#showMobileLink').live('click',function(){
		var relVal=$('#addMoreMobile').attr('rel');	
		$('#addMoreMobile').attr('rel',parseInt(relVal)+1);
		if(relVal>=2)
		{
			$('#addMoreMobile').hide();
		}
		else
		{
			$('#addMoreMobile').show();
		}
		$('#divMoreMobile').show();
		$('#showMobileLink').hide();		
	});
	$('.deleteMobileEmail').live('click',function(){
		
			var scrollTop=$(window).scrollTop();
			$('.loading').css('margin-top',scrollTop-10);
			$('.loading').show();
			var getId=$(this).attr('id');
			var getRel=$(this).attr('rel');
			var getTableName=getRel.split('%');
			var getRemoveDivId=$(this).parent().parent().attr('id');
			$.ajax({				
				url:ajax_url+'admin/Users/deleteStudentMobileEmail/'+getId+'/'+getTableName[0],
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

});

$(document).keypress(function(e){

	if(e.keyCode==27)//Disable popup on pressing `ESC`
	{
		//$('#documentViewDiv').hide();
		$('#documentViewDiv').fadeOut();
		hidePopUp('showpopup'); 	
	}
	
});

function overlay()
{
	if($("#overlay").length!=0)
	{
		
		position=$("#overlay").offset();
		$(".overlay").css("width",$("#overlay").width());
		$(".overlay").css("height",$("#overlay").height());
		$(".overlay").css(position);
		$("#new_loading").css("top",($("#overlay").height())/2);
		$("#new_loading").css("left",($("#overlay").width())/2);
	}
	$(".overlay").show();
}

/* ------ pop up js by inder --------*/
function loadPiece(obj) {
	show_overlay();
	if($("#pagingStatus").length != '0'){
		$("#pagingStatus").val(obj.href);
	}
    $(obj.divName).load(unescape(obj.href), {}, function(){
		hidePopUp("showpopup2");
		if(obj.callback){
			obj.callback();
		}
    });
} 


function showPopUp(trgt)
{
	//$("#"+trgt).css('top',($(window).height()/2)-$("#"+trgt).height()/2);
	$("#"+trgt).css('left',$(window).width()/2-$("#"+trgt).width()/2);
	$("#"+trgt).show();
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

function ajax_form(form,site_url,classWait)
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
				}
				else if ($.trim(explode_again[0])=='ok') {
					$('#err_' + explode_again[1]).hide();										
				}
			}
						
			if ( ! shown ){				
				$('#'+form).submit();							
				$(".overlay").hide();
			}
			else 
			{	
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

//--------------------------------------------FUNCTION FOR DELETE OF STUDENT------------------------------------

	function deleteUser(url,page,id,tableName,renderPath,renderElement)
	{
		if(confirm('Do you want to delete this record?')){
			$(".loading").show();
			var randNumber=randomFunc();
			$.ajax({
							
				url:ajax_url+url+'/'+page+'/'+id+'/'+tableName+'/'+renderPath+'/'+renderElement+randNumber,
				success:function(html){
					$(".loadPaginationContent").html(html);
					$(".loading").hide();
					$("#Delete").fadeIn(1000);
					$("#Delete").fadeOut(11000);
					
				}
			});
			return false;
		}
		else
		{
			return false;
		}
		
	}
	
//-------------------------------------------END OF FUNCTION FOR DELETE OF STUDENT


//--------------------------------------------FUNCTION FOR DELETE OF STUDENT------------------------------------

	function deleteMembers(url,page,id,tableName,renderPath,renderElement,member)
	{
		if(confirm('Do you want to delete this record?')){
			$(".loading").show();
			var randNumber=randomFunc();
			$.ajax({
							
				url:ajax_url+url+'/'+page+'/'+id+'/'+tableName+'/'+renderPath+'/'+renderElement+'/'+member+randNumber,
				success:function(html){
					$(".loadPaginationContent").html(html);
					$(".loading").hide();
					$("#Delete").fadeIn(1000);
					$("#Delete").fadeOut(11000);
					
				}
			});
			return false;
		}
		else
		{
			return false;
		}
		
	}

//----------------------DELETE ACTIVE CHANGE PROFILE REQUEST-------------------

function deleteChangeRequest(url,change_id,t_id,id,tableName,renderPath,renderElement)
	{
		if(confirm('Do you want to delete this record?')){
			$(".loading").show();
			var randNumber=randomFunc();
			$.ajax({
							
				url:ajax_url+url+'/'+change_id+'/'+t_id+'/'+id+'/'+tableName+'/'+renderPath+'/'+renderElement+randNumber,
				success:function(html){
					$(".loadPaginationContent").html(html);
					$(".loading").hide();
					
				}
			});
			return false;
		}
		else
		{
			return false;
		}
		
	}


//--------------------------------------------FUNCTION FOR UPDATE STATUS


	function updateStatus(url,page,id,tableName,renderPath,renderElement)
	{
		
		$(".loading").show();
		var randNumber=randomFunc();
		$.ajax({			
			url:ajax_url+url+'/'+page+'/'+id+'/'+tableName+'/'+renderPath+'/'+renderElement+randNumber,
			success:function(html){
				$(".loadPaginationContent").html(html);
				$(".loading").hide();
				$("#Update").fadeIn(1000);
				$("#Update").fadeOut(11000);
				
			}
		});
		return false;
	}
	
//---------------------------------EOF---------------------------------------

//------------FUNCTION TO ASSIGN OR REJECT JOB-------------------------------

	function assignJob(url,tutorName,page,t_id,job_id,tableName,table_id,renderPath,renderElement)
	{	
		if(confirm("Are you sure you would like to assign this job to  "+tutorName))
			{
			$(".loading").show();
			var randNumber=randomFunc();
				$.ajax({
					url:ajax_url+url+'/'+t_id+'/'+job_id+'/'+tableName+'/'+table_id+'/'+randNumber,
					dataType:'json',
					success:function(html){
						if(html.suc=='y'){
							window.location.href=ajax_url+'admin/Users/interested_tutors/'+html.id;
						}	
						
					}
				});
				return false;
		}else{
			return false;
		}
	}
			
//---------------------------------------------EOF ASSIGN OR REJECT JOB------------	
	

//--------------------------------------------FUNCTION FOR TUTOR ACTIVATION-----

	function activate(url,page,id,tableName,renderPath,renderElement)
	{
		
		$(".loading").show();
		var randNumber=randomFunc();
		$.ajax({			
			url:ajax_url+url+'/'+page+'/'+id+'/'+tableName+'/'+renderPath+'/'+renderElement+randNumber,
			success:function(html){
				$(".loadPaginationContent").html(html);
				$(".loading").hide();
				
			}
		});
		return false;
	}
	
	
	
//--------------------------------------------END OF TUTOR ACTIVATION FUNCTION--


//DELETE NEW APPLICATION DATA-------------------------------------------------------


function deleteApplicationData(url,t_id,id,tableName,renderPath,renderElement)
	{
		if(confirm('Do you want to delete this record?')){
			$(".loading").show();
			var randNumber=randomFunc();
			$.ajax({
							
				url:ajax_url+url+'/'+t_id+'/'+id+'/'+tableName+'/'+renderPath+'/'+renderElement+randNumber,
				success:function(html){
					$(".loadPaginationContent").html(html);
					$(".loading").hide();
					
				}
			});
			return false;
		}
		else
		{
			return false;
		}
		
	}

//-----------------------------END----------------------------------------------

//--------------------------------------------FUNCTION FOR EDIT TUTOR'S DETAILS-----

	function editTutor(url,id,tableName,renderPath)
	{
		
		$(".loading").show();
		var randNumber=randomFunc();
		$.ajax({			
			url:ajax_url+url+'/'+id,
			success:function(html){
				$(".loadPaginationContent").html(html);
				$(".loading").hide();
				
			}
		});
		return false;
	}
	
	
	
//--------------------------------------------END OF EDIT TUTOR'S DETAILS FUNCTION--

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
	
	//-------------------------------Search contact records---------------------------------------
	
	$('#searchContactRecord').live('click',function(){
			$('.adminTutorSearchWait').show();
			$.ajax({
					url:ajax_url+"admin/users/contactSearch",
					data:$('#searchContact').serialize(),
					type:'post',
					success:function(html){
						$('.adminTutorSearchWait').hide();
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
	
	//-------------------------------End function------------------------------------
	//-------------------------------SEARCH Instructor  FUNCTION--------------
	$('#searchRecord').live('click',function(){
			$('.adminTutorSearchWait').show();
			$.ajax({
					url:ajax_url+"admin/users/instructorSearch",
					data:$('#searchTeacher').serialize(),
					type:'post',
					success:function(html){ 		
						$('.adminTutorSearchWait').hide();
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
	
	//------------------------------------END OF FUNCTION--------------
	
	//-------------------------------SEARCH STUDENT  FRUNCTION--------------
	$('#searchStudentRecord').live('click',function(){
			$('.adminTutorSearchWait').show();
			$.ajax({
					url:ajax_url+"admin/users/studentSearch",
					data:$('#searchStudent').serialize(),
					type:'post',
					success:function(html){
						$('.adminTutorSearchWait').hide();
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
	
	//------------------------------------END OF FUNCTION--------------
	
	
	//-------------------------------SEARCH CATEGORY  FRUNCTION--------------
	$('#searchCategorySubmit').live('click',function(){
			$('.adminTutorSearchWait').show();
			$.ajax({
					url:ajax_url+"admin/users/categorySearch",
					data:$('#seacrhCategory').serialize(),
					type:'post',
					success:function(html){
						$('.adminTutorSearchWait').hide();
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
	
	//------------------------------------END OF FUNCTION--------------
	
	//-------------------------------SEARCH CATEGORY  FRUNCTION--------------
	$('#searchSubCategorySubmit').live('click',function(){
			$('.adminTutorSearchWait').show();
			$.ajax({
					url:ajax_url+"admin/users/subCategorySearch",
					data:$('#seacrhSubCategory').serialize(),
					type:'post',
					success:function(html){
						$('.adminTutorSearchWait').hide();
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
	
	
	
	//-------------------------------SEARCH INSTRUCTOR EVENT  FUNCTION--------------
	$('#searchInstructorForEventSubmit').live('click',function(){ 
		$('.adminTutorSearchWait').show();
		$.ajax({
				url:ajax_url+"admin/users/instructorEventSearch",
				data:$('#searchInstructorForEvent').serialize(),
				type:'post',
				success:function(html){
					$('.adminTutorSearchWait').hide();
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
	
	//------------------------------------END OF FUNCTION--------------
	//-------------------------------SEARCH STUDENT EVENT  FUNCTION--------------
	$('#searchStudentForEventSubmit').live('click',function(){ 
		$('.adminTutorSearchWait').show();
		$.ajax({
				url:ajax_url+"admin/users/studentEventSearch",
				data:$('#searchStudentForEvent').serialize(),
				type:'post',
				success:function(html){
					$('.adminTutorSearchWait').hide();
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
	
	//------------------------------------END OF FUNCTION--------------
	
	//-------------------------------SEARCH STUDENT EVENT  FUNCTION--------------
	$('#searchEventsForStudentSubmit').live('click',function(){ 
		$('.adminTutorSearchWait').show();
		$.ajax({
				url:ajax_url+"admin/users/EventSearchStudent",
				data:$('#searchEventsForStudent').serialize(),
				type:'post',
				success:function(html){
					$('.adminTutorSearchWait').hide();
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
	
	//------------------------------------END OF FUNCTION--------------
	
	
	//-------------------------------SEARCH Instructor  FUNCTION--------------
	$('#searchEventRecord').live('click',function(){ 
		
		$('.adminTutorSearchWait').show();
		$.ajax({
				url:ajax_url+"admin/users/eventSearch",
				data:$('#searchEvent').serialize(),
				type:'post',
				success:function(html){
					$('.adminTutorSearchWait').hide();
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
	
	//------------------------------------END OF FUNCTION--------------
	
	$('#searchBroadcastRecord').live('click',function(){ 
		
		$('.adminTutorSearchWait').show();
		$.ajax({
				url:ajax_url+"admin/users/broadcastSearch",
				data:$('#searchBroadcast').serialize(),
				type:'post',
				success:function(html){
					$('.adminTutorSearchWait').hide();
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
	
	$('#searchContactAdminRecord').live('click',function(){
			$('.adminTutorSearchWait').show();
			$.ajax({
					url:ajax_url+"admin/users/contactAdminSearch",
					data:$('#searchContactAdmin').serialize(),
					type:'post',
					success:function(html){
						$('.adminTutorSearchWait').hide();
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
	$('#searchContactStudentRecord').live('click',function(){
			$('.adminTutorSearchWait').show();
			$.ajax({
					url:ajax_url+"admin/users/contactStudentSearch",
					data:$('#searchContactStudent').serialize(),
					type:'post',
					success:function(html){
						$('.adminTutorSearchWait').hide();
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
	
	function randomFunc()
	{
		var d = new Date();
		var randomNumber = "/" + d.getHours() +""+ d.getMinutes() +""+ d.getSeconds() +""+ d.getMilliseconds();
		return randomNumber;
	}
	
