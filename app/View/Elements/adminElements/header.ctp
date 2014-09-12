<div id="page-header-wrapper">
    <div id="top">
        <div style="width:30%; float:left; padding-top:10px;">
            <span class="logo" style="color:#FFF; font-size:32px;">
                <a href="<?php echo HTTP_ROOT;?>admin/users/dashboard" style="color:#FFF;">GAME ADMIN PANEL</a>
            </span>
        </div>
        <div class="welcome">
            <span class="note">
                Welcome 
                <a href="" title="Welcome <?php echo $this->Session->read('Admin.username');?>">
						<?php echo $this->Session->read('Admin.username');?>
                </a>
            </span>
			<?php /*?><a class="btn ui-state-default ui-corner-all" href="<?php echo HTTP_ROOT;?>admin/users/change_password">

				<span class="ui-icon ui-icon-wrench"></span>

				Settings

			</a><?php */?>

			<?php /*?><a class="btn ui-state-default ui-corner-all" href="<?php  echo HTTP_ROOT.'admin/users/account' ;?>">

				<span class="ui-icon ui-icon-person"></span>

				My account

			</a><?php */?>

            <a class="btn ui-state-default ui-corner-all" href="<?php echo HTTP_ROOT;?>admin/users/logout">
                <span class="ui-icon ui-icon-power"></span>
                Logout
            </a>					
        </div>
    </div>
    <ul id="navigation">
        <li>
            <a href="<?php echo HTTP_ROOT;?>admin/users/dashboard" class="sf-with-ul">Dashboard</a>
        </li>
        <li><a href="#">Tags</a>
            <ul>
                <li>
                    <a href="#">Create New Tag</a>
                </li>
                <li>
                    <a href="#">Listing of Tags</a>
                </li>
				<li>
                    <a href="#">Listing of Pages</a>
                </li>
            </ul>
        </li>
        <li><a href="#">Games</a>
            <ul>
                <li>
                    <a href="#">Create New Game</a>
                </li>
                <li>
                    <a href="#">Listing of Games</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)" class="sf-with-ul">Users</a>
            <ul>

                <li>
                    <a href="javascript:void(0)" class="sf-with-ul">Super Admin</a>
                    <ul>
                        <li>
                            <a href="<?php echo HTTP_ROOT;?>admin/users/change_username">Change Username</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_ROOT;?>admin/users/change_password">Change Password</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo HTTP_ROOT;?>admin/users/teacher">Game Admin</a>
                </li>
                <li>
                    <a href="<?php echo HTTP_ROOT;?>admin/users/student">Game Users</a>
                </li>
            </ul>						

        </li>

        <li>
            <a href="javascript:void(0)" class="sf-with-ul">CMS</a>
            <ul>
                <li>
                    <a href="<?php echo HTTP_ROOT;?>admin/users/email_templates">Email Templates</a>
                </li>	
                <li>
                    <a href="<?php echo HTTP_ROOT;?>admin/users/cmspages">Cms Pages</a>
                </li>
                <!--<li>
                    <a href="<?php echo HTTP_ROOT;?>admin/users/faq">FAQs</a>
                </li>-->
<!--                <li><a href="#">Tool Tip Content</a>
                    <ul>
                        <li>
                            <a href="<?php echo HTTP_ROOT;?>admin/users/instructor_tooltip">Instructor</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_ROOT;?>admin/users/student_tooltip">Student</a>
                        </li>
                    </ul>
                </li>-->
            </ul>
        </li>
<!--        <li>
            <a href="javascript:void(0)" class="sf-with-ul">Manage</a>
            <ul>
                <li>
                    <a href="<?php echo HTTP_ROOT;?>admin/users/contacts">Contact Us</a>
                </li>
                <li>
                    <a href="<?php echo HTTP_ROOT;?>admin/users/categories">Categories</a>
                </li>
                <li>
                    <a href="<?php echo HTTP_ROOT;?>admin/users/sub_categories">Sub-Categories</a>
                </li>
                <li>
                    <a href="<?php echo HTTP_ROOT;?>admin/users/teacher_invitation">Invite Instructor </a>
                </li>
               <?php /*?> <li>
					<a href="<?php echo HTTP_ROOT;?>admin/users/send_invitation">Invite Student</a>
				</li><?php */?>
                <li><a href="#">Classes and Broadcasts</a>
                    <ul>
                        <li>
                            <a href="<?php echo HTTP_ROOT;?>admin/users/instructor_events">Instructor</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_ROOT;?>admin/users/student_events">Student</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo HTTP_ROOT;?>admin/users/memory_management">Memory Management</a>
                </li>
                <li>
                    <a href="<?php echo HTTP_ROOT;?>admin/users/student_class_request">Class Request</a>
                </li>

                <li>
                    <a href="<?php echo HTTP_ROOT;?>admin/users/student_invitation_list">Student Invitation Listing</a>
                </li>

            </ul>
        </li>
        <li>
            <a href="javascript:void(0)" class="sf-with-ul">Contacts</a>
            <ul>
                <li>
                    <a href="<?php echo HTTP_ROOT;?>admin/users/instructor_contact_admin">Instructor To Admin</a>
                </li>
                <li>
                    <a href="<?php echo HTTP_ROOT;?>admin/users/student_contact_instructor">Student To Instructor</a>
                </li>
            </ul>
        </li>-->
		<?php /*?><li>
			<a href="javascript:void(0)" class="sf-with-ul">News Letter</a>
			<ul>
				<li>
					<a href="<?php echo HTTP_ROOT;?>admin/users/newsletter" class="sf-with-ul">Newsletter</a>
                    
				</li>
                <li>
                	<a href="<?php echo HTTP_ROOT;?>admin/users/mail_shots" class="sf-with-ul">Mail Shots</a>
                </li>
			</ul>
		</li>
        <li>
			<a href="javascript:void(0)" class="sf-with-ul">History</a>
			<ul>
				<li>
					<a href="<?php echo HTTP_ROOT;?>admin/users/tutor_history" class="sf-with-ul">Tutors</a>
				</li>
                <li>
                	<a href="<?php echo HTTP_ROOT;?>admin/users/student_history" class="sf-with-ul">Students</a>
                </li>
			</ul>
		</li>
        <?php */?>

    </ul>
</div>
