<div class="sidebar-content">
	 <a id="close_sidebar" class="btn ui-state-default full-link ui-corner-all" href="#drill"> <span class="ui-icon ui-icon-circle-arrow-e"></span> Close Sidebar </a> 
	 <a id="open_sidebar" class="btn tooltip ui-state-default full-link icon-only ui-corner-all" title="Open Sidebar" href="#">
	 	<span class="ui-icon ui-icon-circle-arrow-w"></span>
	</a>
	
	<div class="hide_sidebar">
		<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
		<div class="portlet-header ui-widget-header">Users<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
			<div class="portlet-content">
				<ul id="style-switcher" class="side-menu">
										
					<?php /*?><li> <a class="<?php if(in_array($this->params['action'],array('admin_members'))){ echo "set_theme active"; } ?>" id="" href="<?php echo HTTP_ROOT ;?>admin/users/members" title="Members">Members</a> </li>	<?php */?>								
						
				</ul>
			</div>
		</div>
		<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
			<div class="portlet-header ui-widget-header">CMS<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
			<div class="portlet-content">
				<ul id="style-switcher" class="side-menu">
					<?php /*?><li> <a class="<?php if($this->params['action'] == 'admin_cms_pages' || $this->params['action'] == 'admin_cmspages_edit'){?>set_theme active<?php } ?>" href="<?php echo HTTP_ROOT;?>admin/CmsPages/cms_pages" title="Cms Pages">Cms Pages</a> </li>
					<li> <a class="<?php if(in_array($this->params['action'],array('admin_email_templates','admin_edit_email_template'))){ echo "set_theme active"; } ?>" href="<?php echo HTTP_ROOT;?>admin/users/email_templates" title="Email Templates">Email Templates</a> </li>
					
					<li> <a class="<?php if($this->params['action'] == 'admin_faqs' || $this->params['action'] == 'admin_faqview' || $this->params['action'] == 'admin_faqedit'){?>set_theme active<?php } ?>" href="<?php echo HTTP_ROOT;?>admin/Users/faqs" title="Faq">Faqs</a> </li><?php */?>
					
				</ul>	
			</div>
		</div>
		<?php /*?><div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
			<div class="portlet-header ui-widget-header">Newsletter<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
			<div class="portlet-content">
				<ul id="style-switcher" class="side-menu">
					<li> <a class="<?php if($this->params['action'] == 'admin_newsletter' || $this->params['action'] == 'admin_newsletterview' || $this->params['action'] == 'admin_newsletteredit'){?>set_theme active<?php } ?>" href="<?php echo HTTP_ROOT;?>admin/Users/newsletter" title="Newsletters">Newsletters</a> 
					</li>
				</ul>	
			</div>
		</div><?php */?>
						
		<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
			<div class="portlet-header ui-widget-header">Sidebar position
				<span class="ui-icon ui-icon-circle-arrow-s"></span>
			</div>
			<div class="portlet-content">
				<ul class="side-menu sidebar-position">
					<li> Where would you like to see the sidebar ?<br />
						<br />
					</li>
					<li> <a href="javascript:void(0);" id="sidebar-left" title="Switch to 100% width layout">On the <b>left side</b></a> </li>
					<li> <a href="javascript:void(0);" id="sidebar-right" title="Switch to 90% width layout">On the <b>right side</b></a> </li>
				</ul>
			</div>
		</div>
		
		<!--<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
			<div class="portlet-header ui-widget-header">Theme Switcher<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
			<div class="portlet-content">
				<ul id="style-switcher" class="side-menu">
					<li><a class="set_theme" id="black_rose" href="#" title="Black Rose Theme">Black Rose Theme</a></li>
					<li><a class="set_theme" id="gray_standard" href="#" title="Gray Standard Theme">Gray Standard Theme</a></li>
					<li><a class="set_theme" id="gray_lightness" href="#" title="Gray Lightness Theme">Gray Lightness Theme</a></li>
					<li><a class="set_theme" id="apple_pie" href="#" title="Apple Pie Theme">Apple Pie Theme</a></li>
					<li><a class="set_theme" id="blueberry" href="#" title="Blueberry Theme">Blueberry Theme</a></li>
					<li><a class="set_theme" id="blue_sky" href="#" title="BlueSky Theme">BlueSky Theme</a></li>
					<li><a class="set_theme" id="salmon" href="#" title="Salmon  Theme">Salmon  Theme</a></li>
					<li><a class="set_theme" id="turquoise" href="#" title="Turquoise Theme">Turquoise Theme</a></li>
				</ul>
			</div>
		</div>-->
						<!--<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
							<div class="portlet-header ui-widget-header">Change layout width</div>
							<div class="portlet-content">
								<ul class="side-menu layout-options">
									<li> What width would you like the page to have ?<br />
										<br />
									</li>
									<li> <a href="javascript:void(0);" id="" title="Switch to 100% width layout">Switch to <b>100%</b> width</a> </li>
									<li> <a href="javascript:void(0);" id="layout90" title="Switch to 90% width layout">Switch to <b>90%</b> width</a> </li>
									<li> <a href="javascript:void(0);" id="layout75" title="Switch to 75% width layout">Switch to <b>75%</b> width</a> </li>
									<li> <a href="javascript:void(0);" id="layout980" title="Switch to 980px layout">Switch to <b>980px</b> width</a> </li>
									<li> <a href="javascript:void(0);" id="layout1280" title="Switch to 1280px layout">Switch to <b>1280px</b> width</a> </li>
									<li> <a href="javascript:void(0);" id="layout1400" title="Switch to 1400px layout">Switch to <b>1400px</b> width</a> </li>
									<li> <a href="javascript:void(0);" id="layout1600" title="Switch to 1600px layout">Switch to <b>1600px</b> width</a> </li>
								</ul>
							</div>
						</div>
						<div class="box ui-widget ui-widget-content ui-corner-all">
							<h3>Navigation</h3>
							<div class="content"> 
								<a class="btn ui-state-default full-link ui-corner-all" href="#"> 
									<span class="ui-icon ui-icon-mail-closed"></span> Dummy link 
								</a>
								<a class="btn ui-state-default full-link ui-corner-all" href="#"> 
								<span class="ui-icon ui-icon-arrowreturnthick-1-n"></span> Dummy link </a> <a class="btn ui-state-default full-link ui-corner-all" href="#"> <span class="ui-icon ui-icon-scissors"></span> Dummy link </a> <a class="btn ui-state-default full-link ui-corner-all" href="#"> <span class="ui-icon ui-icon-signal-diag"></span> Dummy link </a> <a class="btn ui-state-default full-link ui-corner-all" href="#"> <span class="ui-icon ui-icon-alert"></span> With icon and also quite large link </a> </div>
						</div>-->
						
	</div>
</div>