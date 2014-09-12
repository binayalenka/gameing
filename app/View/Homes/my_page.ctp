<script>
	$(function(){
		$('.radioBox').click(function(){
			if($(this).val()=='2'){
				$('.hideInvitcode').show();
			}else{
				$('.hideInvitcode').hide();
			}
		});
	});
	$(function(){
		$('#up_pic').click(function(){
			$('#hide_link').hide();
			$('#hide_pic').show();
		});
		$('#up_vid').click(function(){
			$('#hide_pic').hide();
			$('#hide_link').show();
		});
		$('#click_cmnt').click(function(){
			$('#cmnt_show').slideToggle();
		});
		
	});
</script>
<div class="mid_sectionmain">
	<div class="mid_sectionholders">
		<div class="mid_outerarea">
        	<div class="middle_bg">
        	<?php if($this->Session->check('SuccessMessage')) { ?>
                <div class="msg_top">
				<?php echo $this->Session->read('SuccessMessage'); ?>
                <?php $this->Session->delete('SuccessMessage');?>                   
                </div>
             <?php } ?>
          		<div class="new_registration_outr">
                	<div class="new_registration_inner"> 
                    	<div class="mid_innerbgmypage"> 
							<div class="main_mypagecont">
                            	<div class="inner_myfdbackpage">
                                	<div class="lft_mypage">
                                    	<div class="inner_lftmypage">
                                        	<div class="upper_imagethumbnails">	
                                            	<img src="../img/im_thm.png"/>
                                                <p> John Smith</p>
                                            </div>
                                            <div class="inner_impayelink">
                                            	<ul>
                                                	<li> <a href="#">Inbox</a> </li>
                                                	<li> <a href="#">Send a message</a> </li>
                                                	<li> <a href="#">Create a class</a> </li>
                                                	<li> <a href="#">Create an assignment</a> </li>
                                                	<li> <a href="#">Create a promotion</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mid_mypage">
                                    	<div class="mid_mypageiner">
                                        	<div class="inenr_midpage">
                                                <div class="update_status">
                                                    <p id="up_pic"> Upload Picture</p>
                                                    <p id="up_vid"> Upload Video</p>
                                                    <div class="inner_posarea">
                                                    	<div class="main_postara" id="hide_pic" style="display:none;">
                                                        	<label> Upload Image/Document: </label>
                                                            <div class="main_uploaddoc">
                                                            	<input type="file" size="31.9" class="file_type" onchange="document.getElementById('file_fake1').value=this.value.replace(/.*?[\/\\]([^\/\\]+)$/,'$1')" style="width:294px;margin-top:2px;"/>	
                                                                <div class="contan_txtupload">
                                                                    <input type="text" id="file_fake1" class="txtuplad" />
                                                                    <input type="button" class="upload_btn" value="Upload" style="margin-top:3px;"/> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="main_postara" id="hide_link" style="display:none;">
                                                        	<label> Video Link: </label>
                                                            <input type="text" class="txt_pageput" />
                                                        </div>
                                                         <div class="main_postara">
                                                        	<label> Subject: </label>
                                                            <input type="text" class="txt_pageput" />
                                                        </div>
                                                        <div class="main_postara">
															<textarea placeholder="Description" style="resize:none"> </textarea>
                                                        </div>
                                                        <div class="main_postara1">
															<input type="button" class="upload_btn" value="Post" /> 
                                                        </div>
                                                    </div>
                                                    <div class="inner_posarea">
                                                    	<div class="container_postcontent">
                                                        	<div class="main_postcontent">
                                                            	<h3> Lorem Ipsum </h3>
                                                                <?php echo $this->Html->image('news_fd.png'); ?>
                                                                <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries. </p>
                                                            </div>
                                                            <div class="share_delet_cmnt">
                                                            	<div class="upper_share"> 
                                                                	<a href="javascript:void(0);" title="Share"> 
                                                                        <?php echo $this->Html->image('share.png'); ?>
                                                                    </a>
                                                                   	<a href="javascript:void(0);" title="Comment" id="click_cmnt"> 
                                                                    	<?php echo $this->Html->image('comment.png'); ?>
                                                                    </a>
                                                                     <a href="javascript:void(0);" title="Delete"> 
                                                                    	<?php echo $this->Html->image('delete.png'); ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="txt_boxshare" id="cmnt_show" style="display:none;">
                                                            	<div class="iner_txtboxshare">
                                                                    <textarea></textarea>
                                                                    <input type="button" value="Post" class="upload_btn1s">
                                                                </div>
                                                                <div class="comments_show">
                                                                	<div class="inner_cmntsshow">
                                                                    		<p><a href="#"> John Smith</a>	 Lorem Ipsum is a dummy text </p>
                                                                        <div class="img_crsicon">
                                                                        	<a href="#" title="Delete Comment"><img src="../img/crs.png" /> </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="inner_cmntsshow">
                                                                    		<p><a href="#"> John Smith</a>	 Lorem Ipsum is a dummy text </p>
                                                                        <div class="img_crsicon">
                                                                        	<a href="#" title="Delete Comment"><img src="../img/crs.png" /> </a>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    <div class="inner_cmntsshow">
                                                                    		<p><a href="#"> John Smith</a>	 Lorem Ipsum is a dummy text </p>
                                                                        <div class="img_crsicon">
                                                                        	<a href="#" title="Delete Comment"><img src="../img/crs.png" /> </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="container_postcontent">
                                                        	<div class="main_postcontent">
                                                            	<h3> Lorem Ipsum </h3>
                                                                <iframe width="400px" height="202px" src="http://www.youtube.com/embed/KLFVJVUlVBQ" frameborder="0" allowfullscreen></iframe>
                                                                <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's 
                                                                	standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
                                                                    a type specimen book. It has survived not only five centuries. </p>
                                                            </div>
                                                            <div class="share_delet_cmnt">
                                                            	<div class="upper_share"> 
                                                                	<a href="#" title="Share"> 
                                                                    	<img src="../img/share.png" />
                                                                    </a>
                                                                   
                                                                    <a href="#" title="Comment" > 
                                                                    	<img src="../img/comment.png" />
                                                                    </a>
                                                                     <a href="#" title="Delete"> 
                                                                    	<img src="../img/delete.png" />
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ryt_mypage">
                                   	 <div class="ryt_mypageiner">
                                     	<div class="inner_r8in">
                                            <div class="check_formyclas_instr">
                                                <a href="#"> Check For My Classes</a>
                                            </div>
                                            
                                            <div class="check_formyclas_shout">
                                                <a href="#"> Class Shoutout</a>
                                            </div>
                                        </div>
                                        <div class="main_promotions">
                                        	<div class="main_promtn">
                                            	<h2> Promotions</h2>
                                                <div class="container_promation">
                                                	<ul>
                                                    	<li><a href="#"> Lorem Ipsum is  text.</a> </li>
                                                        <li><a href="#"> Lorem Ipsum is a text.</a> </li>
                                                        <li><a href="#"> Lorem is a dummy text.</a> </li>
                                                        <li><a href="#"> Lorem dummy text.</a> </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                                    </div>
                                </div>
                            </div>
							
                           <div class="clear"></div>
						</div>
                       	<div class="clear"></div>
                    </div>
                    <div class="clear"></div>
				</div>
        	</div>
		</div>
	</div>
    </div>
    <div class="clear"></div>
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

<style>
.captcha_refresh
{
	float: left;
    margin-left: 10px;
	margin-top:7px;
	cursor:pointer;
}
.captcha_image
{
	float: left;
    min-width: 100px;
	min-height: 40px;
}
.regisImage1
{
	float:left;
	display:none;
    margin-left: 10px;
    margin-top: 7px;;
}
.mid_chkboxareanew
{
	float:left;
}
.msg_top
{
	position: absolute;
    text-align: center;
    text-transform: uppercase;
    width: 68%;
    word-wrap: break-word;
	color: #5D7F00;
    float: left;
    font-size: 11px;
    font-weight: bold;
    margin-left: 20px;
    padding: 18px 0;
    text-align: center;
    text-transform: uppercase;
    
}
.search_btton
{
 float:right;
 margin-right:-18px;
}
.button_image_for_all_in {

	-webkit-border-radius: 4px 4px 4px 4px;
	border-radius: 4px 4px 4px 4px; 
	
	border:1px solid #999;
	background: #88b72d; /* Old browsers */
	background: -moz-linear-gradient(top,  #88b72d 0%, #5b8d27 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#88b72d), color-stop(100%,#5b8d27)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #88b72d 0%,#5b8d27 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #88b72d 0%,#5b8d27 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #88b72d 0%,#5b8d27 100%); /* IE10+ */
	background: linear-gradient(to bottom,  #88b72d 0%,#5b8d27 100%); /* W3C */
	
	box-shadow: 0 0 1px 1px #999 ;
	-moz-box-shadow: 0 0 1px 1px #999 ;
	-webkit-box-shadow: 0 0 1px 1px #999 ;

   /* background: linear-gradient(to bottom, #88B72D 0%, #5B8D27 100%) repeat scroll 0 0 transparent;
    border: 1px solid #999999;*/
    border-radius: 4px 4px 4px 4px;
    box-shadow: 0 0 1px 1px #999999;
    color: #FFFFFF;
    float: right;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: bold;
    height: auto;
    margin-right: 20px;
    margin-top: 0;
    padding: 8px 8px;
    text-decoration: none;
    width: auto;
}
</style>