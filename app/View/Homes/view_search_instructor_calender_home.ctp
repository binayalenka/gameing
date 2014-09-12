<?php 
	echo $this->Html->css('event_calendar/ui.theme.css');
	echo $this->Html->css('event_calendar/ui.core.css');
	echo $this->Html->css('event_calendar/ui.datepicker.css');
	//echo $this->Html->css('ui/ui.demos.css');	
	echo $this->Html->script('event_calander/ui.datepicker');	  
?>


<script type="text/javascript">
$(function() {
	var dates = new Array();
	var i = 0;
	<?php foreach($find_all_events as $key=>$events) { $date = $events['Event']['start_date'];	$finalDate = explode("-",$date); ?>
		dates[i] = new Date(<?php echo $finalDate[0]; ?>,<?php echo $finalDate[1]-1; ?>,<?php echo $finalDate[2]; ?>);
		i++;
	<?php } ?>
		$( ".datepicker" ).datepicker({	
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,		
			yearRange: '1930:2030',
			beforeShowDay: highlightDays,
			inline: true
		});
		
		function highlightDays(date) {
        for (var i = 0; i < dates.length; i++) {
                if ($.trim(dates[i])==date) {
                        return [true, 'highlight'];
                }
        }
        return [true, ''];
}
		
	});
	$(document).ready(function(){
		$('.ui-state-default').live('click',function(){
			var year = $('.ui-datepicker-year').val();
			var month = $('.ui-datepicker-month').val();
			var date = $(this).text();
			$(".waitSearchEvent").show();
			new_overlay('idForOverlay');
			$.ajax({
					url:ajax_url+'App/student_search_event_home/'+'<?php echo $this->params['pass']['0']; ?>',
					type: 'post',
					data : {'date':date,'month':month,'year':year},
					success:function(resp){
						$(".overlay").hide();
						//$(".waitSearchEvent").hide();
						$(".loadPaginationContent").html(resp);
						
					},
					error: function(xhr, textStatus, errorThrown){
						$(".waitSearchEvent").hide();
						var err = xhr.status;alert(xhr.status);
						if($.trim(err)!='')
						{
							switch($.trim(err))
							{
								case '0':	alert('Internet Not Available.'); break;
								case '200': alert('parsing Error'); break;
								case '400':	alert('Server understood the request but request content was invalid'); break;
								case '401':	alert('Unauthorised access'); break;
								case '403':	alert('Forbidden resouce can\'t be accessed'); break;
								case '500':	alert('Internal Server Error'); break;
								case '503':	alert('Service Unavailable'); break;
							}
						}else if(xhr.responseText=='abort'){
							alert('Request was aborted by the server');						
						}else {
							alert('Unknow Error');						
						}					
					} 	
			});
		});	
	
	})

</script>
<div class="mid_sectionmain">
    <div class="mid_sectionholders">
      <div class="mid_outerarea">
        <div class="middle_bg">
          <div class="instructor_profileinner">
            <div class="instructor_innermain">
            	<?php if($this->Session->check('SuccessMessage')) { ?>
                    <div class="success_msg">
                        <?php echo $this->Session->read('SuccessMessage'); ?>
                        <?php $this->Session->delete('SuccessMessage');?>                   
                    </div>
                <?php } ?>
              <div class="instructor_innerspaces">
                <div class="instructor_innerbg">
                  <div class="instructor_innerbgspace">
                    <div class="search_main">
                        <h5 style="margin-bottom:16px;"> <?php echo __('Instructor Class Calendar');?> </h5>                    
                        <div class="datepicker divForCalander" id='idForOverlay'> </div>
                        <div class="divForTask">
                        	<div class="add_view_event"> <?php echo $this->Html->image('front/view_all_event.png',array('url'=>HTTP_ROOT.'homes/view_search_instructor_calender_home/'.$this->params['pass']['0'],'id'=>'refreshEventList','title'=>'Click Here to View All Class Listing'));?> </div> 
                        </div>                   
                        <div class="events_outter loadPaginationContent">                        	
                            <?php  echo $this->element('frontElements/instructor_event_listing_home'); ?>                             
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
    <div class="clear"></div>    
  </div>
 <div class="overlay idForOverlay "> 
 	 <div class="waitSearchEvent">                        	
		<?php echo $this->Html->image('event_loader1.gif',array());?>
    </div>
 </div> 
  <style type="text/css">
  	
	
	.ui-state-default
	{
		height: 30px;
		padding-top: 15px !important;
		text-align:center !important;
	}
	.add_view_event
	{
		float:left;
		width:auto;
		padding:5px;
	}
  </style>