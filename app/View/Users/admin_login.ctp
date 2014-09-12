
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Admin Panel</title>

        <!------------------ INCLUDE JS FILES HERE-------------------------------->
<?php  echo $this->Html->script('admin/jquery-1.8.1.min.js');?>
<?php  echo $this->Html->script('admin/common.js');?>
<?php  echo $this->Html->script('ui/ui.widget.js');?>
<?php  echo  $this->Html->script('ui/ui.tabs.js'); ?>

        <!------------------ INCLUDE CSS FILES HERE-------------------------------->
<?php  echo $this->Html->css('admin/developer.css');?>
<?php  echo $this->Html->css('ui/ui.base.css');?>
<?php  echo $this->Html->css('ui/ui.login.css');?>
<?php  echo $this->Html->css('themes/black_rose/ui.css');?>
<?php  echo $this->Html->css('themes/black_rose/ui.css','stylesheet',array('title'=>'style'));?>


        <script type="text/javascript">
            $(document).ready(function() {
                // Tabs
                $('#tabs, #tabs2, #tabs5').tabs();
            });
        </script>
    </head>
    <body>
        <!-- Main -->
        <div id="page_wrapper">
            <div id="page-header">
                <div id="page-header-wrapper">
                    <div id="top">
                        <div style="width:30%; float:left; padding-top:10px;"><span class="logo" style="color:#FFF; font-size:32px;">GAME SITE</span></div>
                    </div>
                </div>
            </div>		   
            <div id="sub-nav">
                <div class="page-title">
                    <h1>Login Area</h1>
                    <span>Login to Admin Panel</span>
                </div>					
            </div>
            <div class="clear"></div>
            <div id="page-layout">
                <div id="page-content">
                    <div id="page-content-wrapper" class="no-bg-image wrapper-full">
                        <div id="tabs">
                            <ul>
                                <li><a href="#login">Login</a></li>						
                                <li><a href="#tabs-3">Recover password</a></li>
                            </ul>
                     <?php if($this->Session->check('success')){ ?>
                            <div class="success ui-corner-all successdeveloperClass" id="success">
                                <span class='successMessageText'>
                               <?php echo $this->Session->read('success');?>
                                </span>
                            </div>
                        <?php $this->Session->delete('success'); ?>
                    <?php } ?>

                            <div id="login">                    	
						<?php //if($this->Session->check('error')){ ?>														
                                <p class="adminLoginError" id="err_password"><?php if(isset($error['password'][0])) echo $error['password'][0]; ?>  </p> 						
                           <?php /*?> <?php $this->Session->delete('error'); ?><?php */?>
						<?php //} ?>

						<?php echo $this->Form->create('Admin',array("id"=>"AdminLogin",'url' => array('controller'=>'Users','action'=>'login','admin'=>true))); ?>
                                <ul>
                                    <li>
                                        <label for="email" class="desc">				
                                            User Name:
                                        </label>
                                        <div>
                                    	<?php echo $this->Form->input('username',array('type'=>'text','id'=>'email','class'=>'field text full','label'=>false,'div'=>false));?>

                                        </div>
                                    </li>
                                    <li>
                                        <label for="password" class="desc">
                                            Password:
                                        </label>				
                                        <div>
                                    	<?php echo $this->Form->input('password',array('type'=>'password','id'=>'password','class'=>'field text full','label'=>false,'div'=>false));?>										
                                        </div>
                                    </li>
                                    <li class="buttons">
                                        <div class="adminLoginSubmit">
                                            <div class="adminLoginButton">
                                    		<?php echo $this->Form->submit('Submit',array('onclick'=>'return ajax_form("AdminLogin","Users/validate_admin_login","adminLoginWait");','class'=>'ui-state-default ui-corner-all float-right ui-button','label'=>false,'div'=>false))?> 
                                            </div>
                                            <div class="adminLoginWait">
                                        	<?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                                            </div>                                   	
                                        </div>
                                    </li>
                                </ul>
						<?php echo $this->Form->end();?>
                            </div>					
                            <div id="tabs-3">

						<?php echo $this->Form->create('AdminEmail',array('url'=>array('controller'=>'Users','action'=>'password','admin'=>true),'id'=>'emailSend'));?>
                                <ul>
                                    <li>
                                        <label for="email" class="desc">
                                            Enter Registered Email:
                                        </label>
                                        <div>
                                    <?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$admin_info['Admin']['id'])); ?>
										<?php echo $this->Form->input('email',array('type'=>'text','class'=>'full text field','div'=>false,'label'=>false)); ?>
                                        </div>
                                        <p class="adminLoginError" id="err_email"><?php if(isset($error['email'][0])) echo $error['email'][0]; ?>  </p>

                                    </li>
                                    <li class="buttons">
                                        <div class="adminLoginSubmit">
                                            <div class="adminLoginButton">
                                    		<?php echo $this->Form->submit('Get Password',array('onclick'=>'return ajax_form("emailSend","Users/validate_recover_password_ajax","adminLoginWait");','class'=>'ui-state-default ui-corner-all float-right ui-button','label'=>false,'div'=>false))?> 

                                            </div>
                                            <div class="adminLoginWait">
                                        	<?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?>
                                            </div>                                   	
                                        </div>
                                    </li>
                                </ul>
						<?php echo $this->Form->end();?>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>    
        <!-- Main -->
    </body>
</html>


