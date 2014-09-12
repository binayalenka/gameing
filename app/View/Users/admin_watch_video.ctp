<div id="page-content" >
	<div id="page-content-wrapper" style="min-height:500px; width:82%;">
        <div class="watch_videocontainer">
            <div class="wathc_video">
              	<div class="inner-page-title">
                    <h2> Watch Video</h2>
                    <a style="margin-top:-10px; margin-right:10px;" class="ui-state-default ui-corner-all float-right ui-button" href="javascript:void(0);" onclick="history.go(-1);">Back</a>
                    <span></span>
                </div>
                <div class="main_watcharea">
                	<div class="inner_watch_ara">
                    	<object width="500" height="400">													
                            <param name="movie" value="<?php echo $video['VideoLink']['video_link'];?>"></param>
                            <param name="allowFullScreen" value="true"></param>
                            <param name="wmode" value="transparent"></param></param>
                            <param name="allowscriptaccess" value="always"></param>
                            <embed src="<?php echo $video['VideoLink']['video_link'];?>" type="application/x-shockwave-flash" width="500" height="400"   wmode="transparent" allowscriptaccess="always" allowfullscreen="true">
                            </embed>
                         </object>
                    </div>
                </div>
              
            </div>
        </div>
      </div>  
</div>

<style>
#page_wrapper #page-content #page-content-wrapper, #live-search-results, .ui-dialog

	{
    background: url("images/page-container-bg.png") repeat-x scroll left top #F2F2F2;

}
.inner-page-title
{
    border-bottom: 1px solid #CDCDCD;
    margin: 0 0 15px;
    text-shadow: 1px 1px 0 #FFFFFF;
    width: 118%;
}
.inner-page-title span {
    border-bottom: 1px solid #FFFFFF;
    color: #777777;
    display: block;
    font-size: 1.3em;
    font-style: italic;
    padding: 24px 0 15px;
}
</style>