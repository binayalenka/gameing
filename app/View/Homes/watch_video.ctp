<div class="mid_sectionmain">
    <div class="mid_sectionholders">
      <div class="mid_outerarea">
        <div class="middle_bg">
          <div class="instructor_profileinner">
            <div class="instructor_innermain">
              <div class="instructor_innerspaces">
                <div class="instructor_innerbg">
                  <div class="instructor_innerbgspace">
                    <div class="student_dashboardmain">
                      <h5><?php echo __('Watch Video');?></h5>
                      <div class="student_dashboard_inner">
                      	<div class="video_streaming">
                            <object width="500" height="400">													
                                <param name="movie" value="<?php echo $video['VideoLink']['video_link'];?>"></param>
                                <param name="allowFullScreen" value="true"></param>
                                <param name="wmode" value="transparent"></param></param>
                                <param name="allowscriptaccess" value="always"></param>
                                <embed src="<?php echo $video['VideoLink']['video_link'];?>" type="application/x-shockwave-flash" width="500" height="400"   wmode="transparent" allowscriptaccess="always" allowfullscreen="true">
                                </embed>
                             </object>
                         </div>
                        <div class="clear"></div>
                      </div>
                    </div>
                    <div class="clear"></div>
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