<script type="text/javascript">
    ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 600, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	/*togglehtml: ["suffix", "<img src='images/plus.gif' class='statusicon' />", "<img src='images/minus.gif' class='statusicon' />"],*/ //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "slow", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>
<div class="mid_sectionmain">
	<div class="mid_sectionholders">
    	<div class="mid_outerarea">
        	<div class="middle_bg">
            	<div class="instructor_profileinner">
                	<div class="instructor_innermain">
                    	<div class="instructor_innerspaces">
                        	<div class="instructor_innerbg">
                          		<div class="instructor_innerbgspace">
                            		<div class="contact_main">
                              			<h5><?php echo __('Frequently Asked Questions');?> </h5>
                              			<div class="glossymenu">
                              
                              				<?php foreach( $info as $info) {?>
                              					<a href="#" class="menuitem submenuheader gradient" headerindex="0h">
													<?php echo $info['Faq']['faq_ques']; ?>
                                                </a>
                                				<div class="submenu" contentindex="0c" style="display: none;">
                                  					<span class="faq_texts">
                                  						<?php echo $info['Faq']['faq_ans']; ?>
                                  					</span>
                                				</div>
                                			<?php } ?>
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