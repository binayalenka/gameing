<?php ob_start();
class HomesController extends AppController {
	
	var $name = "Homes";
	var $helpers = array('Session','Html','Js','Form','Text');
	var $components=array('Session','Email','Cookie','RequestHandler');  
	var $uses = array('User','Contact','EmailTemplate','CmsPage');
	
	function beforeFilter()
	{
		
		if($this->Session->read('User.login'))
	   	{
			$isLogin = array('login_main','login','dashboard');
			if(in_array($this->params['action'],$isLogin))
			{
				if($this->Session->read('User.member_type') == '1')
				{
					$this->redirect(array('controller'=>'Instructors','action' => 'instructor_dashboard'));
				}elseif($this->Session->read('User.member_type') == '2'){
					$this->redirect(array('controller'=>'Students','action' => 'student_dashboard'));
				}	
			}
		}
	}
	//------------------------------------User Registration Section--------------
	/*function index($eventId=NULL,$insId=NULL)
	{
		$this->layout = "public";
		$title_for_layout = "Home";
		$this->loadModel('ClassRequest');
		$email_cookie = $this->Cookie->read('emailTambarkCookie');
		$pass_cookie  = $this->Cookie->read('passTambarkCookie');
		$cookie_type  = $this->Cookie->read('typeTambarkCookie');
		
		if(!empty($eventId) && !empty($insId) ){
			$e_id	= convert_uudecode(base64_decode($eventId));
			$t_id	= convert_uudecode(base64_decode($insId));
			$this->set(compact('e_id','t_id'));
			$this->Session->write('SuccessMessage',"Please complete registration.");	
		}elseif(!empty($eventId) && $insId=''){
			$this->Session->write('SuccessMessage',"Please login first to register for a class!");
		}
		$classRequest = $this->ClassRequest->find('all',array('order'=>array('ClassRequest.id desc')));
		$instructorInfo = $this->CmsPage->find('first',array('conditions'=>array('CmsPage.id'=>'3')));
		$studentInfo = $this->CmsPage->find('first',array('conditions'=>array('CmsPage.id'=>'4')));
		$this->set(compact('instructorInfo','studentInfo','email_cookie','pass_cookie','typeTambarkCookie','eventId','title_for_layout','classRequest'));
		if(empty($this->data))
		{
			$this->captchaImage();
		}
		if(!empty($this->data))
		{
			$error=array();
			$error=$this->validate_member_reg($this->data);	
			if(count($error)==0)
			{
				$data = $this->data;	
				$activation_code=md5(microtime());
				$data['User']['password'] = md5($this->data['User']['fpassword']);
				$data['User']['activation_code'] =$activation_code;
				$data['User']['date_added'] = date('d-m-Y');
				$data['User']['status'] = 0;
				
				$this->User->save($data);
				
				$getNewUserId = $this->User->getLastInsertId();
				
				//-------Automatic registration for classs---------------------------
				if(isset($data['User']['t_id']) && isset($data['User']['e_id']) && $data['User']['member_type'] == '2'){
					if(!empty($data['User']['t_id']) && !empty($data['User']['e_id'])){
						$register_for_class['StudentApplyEvent']['student_id'] = $getNewUserId;
						$register_for_class['StudentApplyEvent']['teacher_id'] = $data['User']['t_id'];
						$register_for_class['StudentApplyEvent']['event_id'] = $data['User']['e_id'];
						$register_for_class['StudentApplyEvent']['request_status'] = 'accept';
						$register_for_class['StudentApplyEvent']['date_added'] = date('Y-m-d');
						
						$this->StudentApplyEvent->save($register_for_class);
					}
				}
				//-------------EOF---------------------------------------------------
								
				//creating folder with respect to user id that is recently registred
				App::uses('Folder','Utility');
				$dir = new Folder();
				
				if($data['User']['member_type'] == '2'){
					$folder_name =array('personal_repo');
				}else{
					$folder_name =array('image','personal_repo');
				}
				foreach($folder_name as $name){		
					$dir->create('files'.DS.$getNewUserId.DS.$name);
				}
				//-------End of the function-----------------------------------------
				
				$getUserDetail=$this->User->findById($getNewUserId);
				
				if($getUserDetail['User']['member_type'] == "1")
				{
					//-----------------Mail for admin when new teacher registered-------------------
					$emailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('id'=>6)));						
					$emailData=$emailTemplate['EmailTemplate']['description'];						
					$link=HTTP_ROOT.'Users/activate_account/'.base64_encode(convert_uuencode($getUserDetail['User']['id']))."/".$activation_code;							
					$link="<a href='".$link."' style='text-decoration:none;color:#00aeef'>Activate Your Account</a>";						
					
					$emailData=str_replace(array('{name}','{last_name}','{activation_code}'),array($getUserDetail['User']['first_name'],$getUserDetail['User']['last_name'],$link),$emailData);							
					
					$emailTo=$getUserDetail['User']['email'];
					$emailFrom=$emailTemplate['EmailTemplate']['email_from'];
					$emailSubject=$emailTemplate['EmailTemplate']['subject'];
					
					//echo $emailTo.'</br>'.$emailFrom.'</br>'.$emailSubject.'</br>'.$emailData; die;
					$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);
					
					$this->redirect(array('controller'=>'Homes','action'=>'success_registration/'.base64_encode(convert_uuencode($getUserDetail['User']['id']))."/".base64_encode(convert_uuencode('teacher'))));
					
				}
				elseif($getUserDetail['User']['member_type'] == "2")
				{
					$emailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('id'=>1)));						
					$emailData=$emailTemplate['EmailTemplate']['description'];						
					$link=HTTP_ROOT.'Users/activate_account/'.base64_encode(convert_uuencode($getUserDetail['User']['id']))."/".$activation_code;							
					$link="<a href='".$link."' style='text-decoration:none;color:#00aeef'>Activate Your Account</a>";						
					$emailData=str_replace(array('{name}','{last_name}','{activation_code}'),array($getUserDetail['User']['first_name'],$getUserDetail['User']['last_name'],$link),$emailData);							
					$emailTo=$getUserDetail['User']['email'];
					$emailFrom=$emailTemplate['EmailTemplate']['email_from'];
					$emailSubject=$emailTemplate['EmailTemplate']['subject'];						
					
					//echo $emailTo.'</br>'.$emailFrom.'</br>'.$emailSubject.'</br>'.$emailData; die;
					$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);						
					
					$this->redirect(array('controller'=>'Homes','action'=>'success_registration/'.base64_encode(convert_uuencode($getUserDetail['User']['id']))."/".base64_encode(convert_uuencode('student'))));
				}
			}else {
				$this->set('error',$error);
			}
		}
	}*/
	//------------------------------------EOF---------------------------------------
        
	//------------------------------------Login function ---------------------------
	
	function login_main()
	{
		
		$this->layout = "public";
		$email_cookie = $this->Cookie->read('emailTambarkCookie');
		$pass_cookie  = $this->Cookie->read('passTambarkCookie');
		$cookie_type  = $this->Cookie->read('typeTambarkCookie');
		
		$info = $this->CmsPage->find('first',array('conditions'=>array('CmsPage.id'=>5)));		
		$this->set(compact('info','email_cookie','pass_cookie','cookie_type'));
		
		if(!empty($this->data))
		{		
			$error=array();
			$error=$this->validate_login($this->data);			
			if(count($error)==0){					
				$checkexistUser=$this->User->find('first',array('conditions'=>array('email'=>$this->data['User']['user_name'],'password'=>md5($this->data['User']['password']))));		
					
				$this->Session->write("User.login",1);
				$this->Session->write("User.id",$checkexistUser['User']['id']);
				$this->Session->write('User.member_type',$checkexistUser['User']['member_type']);
				$this->Session->write('User.status',$checkexistUser['User']['status']);
				$this->Session->write('User.email',$checkexistUser['User']['email']);
				$this->Session->write('User.Fname', $checkexistUser['User']['first_name']);
				$this->Session->write('User.Lname', $checkexistUser['User']['last_name']);
				$this->Session->write('User.lastLogin',$checkexistUser['User']['last_login']);
				
				$this->get_member_memory_usage($checkexistUser['User']['id']);
				
				
				$date = date("d-m-Y");
				$time = date("h:i:s a",time());				
				$data['User']['id']=$checkexistUser['User']['id'];
				$data['User']['last_login']=$date.'_'.$time;
				$this->User->save($data);
				//pr($this->data);die;
				//----------------Remember Me--------------------------------------------------------
				if(isset($this->data['User']['checkbox']) && $this->data['User']['checkbox']=='1'){
					$this->Cookie->write('emailTambarkCookie',$this->data['User']['user_name'],false,60*60*24*365);
					$this->Cookie->write('passTambarkCookie',$this->data['User']['password'],false,60*60*24*365);	
					$this->Cookie->write('typeTambarkCookie',$this->data['User']['checkbox'],false,60*60*24*365);					
				}
				else{
					$this->Cookie->delete('emailTambarkCookie');
					$this->Cookie->delete('passTambarkCookie');
					$this->Cookie->delete('typeTambarkCookie');
				}			
				//------------After login Teacher and Student navigate to their dashboad---------------
				switch($checkexistUser['User']['member_type']){	
					
					case '1':					
						$url=array('controller'=>'Instructors','action'=>'my_page');
					break;					
					case '2':
						$event_id = $this->data['User']['event_id'];
					if(isset($event_id) && $event_id!=''){						
						$url=array('controller'=>'Students','action'=>'view_instructor_event/'.$event_id);
					}else{
						$url=array('controller'=>'Students','action'=>'my_page');
					}
					break;
				}	
				$this->redirect($url);
			}
			else{
				$this->set('error',$error);					
			}
		}
	
	}
	//------------------------------------EOF---------------------------------------------------
	//------------------------------------User Homepage Section---------------------------
	function dashboard()
	{
           $this->layout = "public";
           $title_for_layout = "Home";
        }
         //------------------------------------EOF---------------------------------------------------
	//------------------------------------User Registration Section---------------------------
	function registration($eventId=NULL,$check=NULL)
	{
		$this->layout = "public";
		$title_for_layout = "Home";
		$this->loadModel('ClassRequest');
		$this->loadModel('Event');
		$this->loadModel('SendInvitation');
		
		$email_cookie = $this->Cookie->read('emailTambarkCookie');
		$pass_cookie  = $this->Cookie->read('passTambarkCookie');
		$cookie_type  = $this->Cookie->read('typeTambarkCookie');
		
		$e_id	= convert_uudecode(base64_decode($eventId));
		$check	= convert_uudecode(base64_decode($check));
		
		
		
		// condition for indentifing form where user came on the registration page
		if(!empty($e_id) && $check=='searchPage'){
			$this->set(compact('e_id','check'));
			$this->Session->write('SuccessMessage',"Please login first to register for a class!");
		}elseif(!empty($e_id) && $check!='searchPage'){       // instructor send request from dashboard to add class with code
			
			$memEmail = $this->SendInvitation->find('first',array('conditions'=>array('SendInvitation.invite_code'=>$e_id,'SendInvitation.email'=>$check,'SendInvitation.status'=>'Unused'),'recursive'=>'0'));
			
			if(isset($memEmail) && !empty($memEmail)){   
				$memExist = $this->User->find('first',array('conditions'=>array('User.email'=>$memEmail['SendInvitation']['email']),'recursive'=>'0'));
				if(isset($memExist) && !empty($memExist)){ echo "member find";
					$register_for_class['StudentApplyEvent']['student_id'] = $memExist['User']['id'];
					$register_for_class['StudentApplyEvent']['teacher_id'] = $memEmail['SendInvitation']['t_id'];
					$register_for_class['StudentApplyEvent']['event_id'] = $memEmail['SendInvitation']['e_id'];
					$register_for_class['StudentApplyEvent']['request_status'] = 'accept';
					$register_for_class['StudentApplyEvent']['date_added'] = date('Y-m-d');
					
					$alreadyAdded = $this->StudentApplyEvent->find('count',array('conditions'=>array('StudentApplyEvent.student_id'=>$memExist['User']['id'],'StudentApplyEvent.teacher_id'=>$memEmail['SendInvitation']['t_id'],'StudentApplyEvent.event_id'=>$memEmail['SendInvitation']['e_id']),'recursive'=>'0'));
					if($alreadyAdded>0){ 
					}else{
						$this->StudentApplyEvent->save($register_for_class);
						
						$this->SendInvitation->updateAll(array('SendInvitation.status'=>"'Used'",'SendInvitation.s_id'=>$memExist['User']['id']),array('SendInvitation.invite_code'=>$e_id,'SendInvitation.email'=>$memExist['User']['email']));	
					}
					//Write session if user automatically added class after clicking on the link
					
					$this->Session->write("User.login",1);
					$this->Session->write("User.id",$memExist['User']['id']);
					$this->Session->write('User.member_type',$memExist['User']['member_type']);
					$this->Session->write('User.status',$memExist['User']['status']);
					$this->Session->write('User.email',$memExist['User']['email']);
					$this->Session->write('User.Fname', $memExist['User']['first_name']);
					$this->Session->write('User.Lname', $memExist['User']['last_name']);
					$this->Session->write('User.lastLogin',$memExist['User']['last_login']);
					
					//---------------------------EOF--------------------------------------------
					
					$this->redirect(array('controller'=>'Students','action'=>'student_dashboard'));
				}else{
					$this->set(compact('e_id','check'));
					$this->set('inviteCode',$e_id);
					$this->Session->write('SuccessMessage',"Please complete registration.");
				}
			}else{ 
				$this->set(compact('e_id','check'));
				$this->set('inviteCode',$e_id);
				$this->Session->write('SuccessMessage',"Please complete registration.");
			}
		}
		//--------------------------end--------------------------------------------
		$classRequest = $this->ClassRequest->find('all',array('order'=>array('ClassRequest.id desc')));
		$instructorInfo = $this->CmsPage->find('first',array('conditions'=>array('CmsPage.id'=>'3')));
		$studentInfo = $this->CmsPage->find('first',array('conditions'=>array('CmsPage.id'=>'4')));
		$this->set(compact('instructorInfo','studentInfo','email_cookie','pass_cookie','typeTambarkCookie','eventId','title_for_layout','classRequest'));
		if(empty($this->data))
		{
			$this->captchaImage();
		}
		if(!empty($this->data))
		{
			$error=array();
			$error=$this->validate_member_reg($this->data);	
			if(count($error)==0)
			{
				$data = $this->data;	
				$activation_code=md5(microtime());
				$data['User']['password'] = md5($this->data['User']['fpassword']);
				$data['User']['activation_code'] =$activation_code;
				$data['User']['date_added'] = date('d-m-Y');
				$data['User']['status'] = 0;
				
				$this->User->save($data);
				$getNewUserId = $this->User->getLastInsertId();
				
				/*//-------User entered invite code but not coming from through email link---------------------------
				if(!empty($data['User']['invite_code']) && empty($data['User']['e_id']) && $data['User']['member_type'] == '2'){ 
				
					$inviteCode = $this->SendInvitation->find('first',array('conditions'=>array('SendInvitation.invite_code'=>$data['User']['invite_code'],'SendInvitation.status'=>'Unused')));
					$register_for_class['StudentApplyEvent']['student_id'] = $getNewUserId;
					$register_for_class['StudentApplyEvent']['teacher_id'] = $inviteCode['SendInvitation']['t_id'];
					$register_for_class['StudentApplyEvent']['event_id'] = $inviteCode['SendInvitation']['e_id'];
					$register_for_class['StudentApplyEvent']['request_status'] = 'accept';
					$register_for_class['StudentApplyEvent']['date_added'] = date('Y-m-d');
					
					$this->StudentApplyEvent->save($register_for_class);
					
					$this->SendInvitation->updateAll(array('status'=>"'Used'",'s_id'=>$getNewUserId),array('invite_code'=>$data['User']['invite_code']));
				}
				//-------------End---------------------------------------------------*/
				//-------Automatic registration for class when user comes with invite code---------------------------
				if(!empty($data['User']['e_id']) && $data['User']['check']!='searchPage' && $data['User']['member_type'] == '2'){ 
				
					$inviteCode = $this->SendInvitation->find('first',array('conditions'=>array('SendInvitation.invite_code'=>$data['User']['invite_code'],'SendInvitation.status'=>'Unused','SendInvitation.email'=>$data['User']['check'])));
					if(isset($inviteCode) && !empty($inviteCode)){
						$register_for_class['StudentApplyEvent']['student_id'] = $getNewUserId;
						$register_for_class['StudentApplyEvent']['teacher_id'] = $inviteCode['SendInvitation']['t_id'];
						$register_for_class['StudentApplyEvent']['event_id'] = $inviteCode['SendInvitation']['e_id'];
						$register_for_class['StudentApplyEvent']['request_status'] = 'accept';
						$register_for_class['StudentApplyEvent']['date_added'] = date('Y-m-d');
						$this->StudentApplyEvent->save($register_for_class);
						$this->SendInvitation->updateAll(array('SendInvitation.status'=>"'Used'",'SendInvitation.s_id'=>$getNewUserId),array('SendInvitation.invite_code'=>$data['User']['invite_code'],'SendInvitation.email'=>$data['User']['check']));
					}
				}
				//-------------End---------------------------------------------------
				
				//-------Automatic registration for class when user come from search page---------------------------
				elseif(!empty($data['User']['e_id']) && $data['User']['check']=='searchPage' && $data['User']['member_type'] == '2'){
					
					$event = $this->Event->find('first',array('conditions'=>array('Event.id'=>$data['User']['e_id'])));
					$register_for_class['StudentApplyEvent']['student_id'] = $getNewUserId;
					$register_for_class['StudentApplyEvent']['teacher_id'] = $event['Event']['t_id'];
					$register_for_class['StudentApplyEvent']['event_id'] = $data['User']['e_id'];
					$register_for_class['StudentApplyEvent']['request_status'] = 'accept';
					$register_for_class['StudentApplyEvent']['date_added'] = date('Y-m-d');
					
					$this->StudentApplyEvent->save($register_for_class);
				}elseif(!empty($data['User']['e_id']) && $data['User']['check']=='searchPage' && $data['User']['member_type'] == '2' && !empty($data['User']['invite_code'])){
					$inviteCode = $this->SendInvitation->find('first',array('conditions'=>array('SendInvitation.invite_code'=>$data['User']['invite_code'],'SendInvitation.status'=>'Unused')));
					$register_for_class['StudentApplyEvent']['student_id'] = $getNewUserId;
					$register_for_class['StudentApplyEvent']['teacher_id'] = $inviteCode['SendInvitation']['t_id'];
					$register_for_class['StudentApplyEvent']['event_id'] = $inviteCode['SendInvitation']['e_id'];
					$register_for_class['StudentApplyEvent']['request_status'] = 'accept';
					$register_for_class['StudentApplyEvent']['date_added'] = date('Y-m-d');
					
					$this->StudentApplyEvent->save($register_for_class);
					
					$this->SendInvitation->updateAll(array('status'=>"'Used'",'s_id'=>$getNewUserId),array('invite_code'=>$data['User']['invite_code']));
					
				}
				//-------------End---------------------------------------------------
								
				//creating folder with respect to user id that is recently registred
				App::uses('Folder','Utility');
				$dir = new Folder();
				
				if($data['User']['member_type'] == '2'){
					$folder_name =array('personal_repo');
				}else{
					$folder_name =array('image','personal_repo');
				}
				foreach($folder_name as $name){		
					$dir->create('files'.DS.$getNewUserId.DS.$name);
				}
				//-------End-----------------------------------------
				
				$getUserDetail=$this->User->findById($getNewUserId);
				
				//-----------------Mail for admin when new teacher registered-------------------
					$this->loadModel('Admin');
					$adminUser = $this->Admin->findById('1');
					if($getUserDetail['User']['member_type'] == "1")
					{
						$userType = "Instructor";
					}elseif($getUserDetail['User']['member_type'] == "2"){
						$userType = "Student";
					}
					$emailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('id'=>38)));						
					$emailData=$emailTemplate['EmailTemplate']['description'];						
					$emailData=str_replace(array('{user_name}','{user_type}'),array($getUserDetail['User']['first_name'],$userType),$emailData);							
					$emailTo=$adminUser['Admin']['email'];
					$emailFrom=$emailTemplate['EmailTemplate']['email_from'];
					$emailSubject=$emailTemplate['EmailTemplate']['subject'];
					//echo $emailTo.'</br>'.$emailFrom.'</br>'.$emailSubject.'</br>'.$emailData; die;
					$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);
				
				if($getUserDetail['User']['member_type'] == "1")
				{
					//-----------------Mail for admin when new teacher registered-------------------
					$emailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('id'=>6)));						
					$emailData=$emailTemplate['EmailTemplate']['description'];						
					$link=HTTP_ROOT.'Users/activate_account/'.base64_encode(convert_uuencode($getUserDetail['User']['id']))."/".$activation_code;							
					$link="<a href='".$link."' style='text-decoration:none;color:#00aeef'>Activate Your Account</a>";						
					
					$emailData=str_replace(array('{name}','{last_name}','{activation_code}'),array($getUserDetail['User']['first_name'],$getUserDetail['User']['last_name'],$link),$emailData);							
					
					$emailTo=$getUserDetail['User']['email'];
					$emailFrom=$emailTemplate['EmailTemplate']['email_from'];
					$emailSubject=$emailTemplate['EmailTemplate']['subject'];
					//echo $emailTo.'</br>'.$emailFrom.'</br>'.$emailSubject.'</br>'.$emailData; die;
					$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);
					$this->redirect(array('controller'=>'Homes','action'=>'success_registration/'.base64_encode(convert_uuencode($getUserDetail['User']['id']))."/".base64_encode(convert_uuencode('1'))));
					
				}
				elseif($getUserDetail['User']['member_type'] == "2")
				{
					$emailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('id'=>1)));						
					$emailData=$emailTemplate['EmailTemplate']['description'];						
					$link=HTTP_ROOT.'Users/activate_account/'.base64_encode(convert_uuencode($getUserDetail['User']['id']))."/".$activation_code;							
					$link="<a href='".$link."' style='text-decoration:none;color:#00aeef'>Activate Your Account</a>";						
					$emailData=str_replace(array('{name}','{last_name}','{activation_code}'),array($getUserDetail['User']['first_name'],$getUserDetail['User']['last_name'],$link),$emailData);							
					$emailTo=$getUserDetail['User']['email'];
					$emailFrom=$emailTemplate['EmailTemplate']['email_from'];
					$emailSubject=$emailTemplate['EmailTemplate']['subject'];						
					//echo $emailTo.'</br>'.$emailFrom.'</br>'.$emailSubject.'</br>'.$emailData; die;
					$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);						
					$this->redirect(array('controller'=>'Homes','action'=>'success_registration/'.base64_encode(convert_uuencode($getUserDetail['User']['id']))."/".base64_encode(convert_uuencode('2'))));
				}
					
			}else {
				$this->set('error',$error);
			}
		}
	}
	
	//------------------------------------EOF--------------------------------------------
	
	function capturecode()
	{
		if($this->RequestHandler->isAjax()) 
		{
			$this->layout='';
			$this->autoRender = false;
			Configure::write('debug', 2);
			$this->captchaImage();
			$this->viewPath = 'Elements'.DS.'frontElements';
			$this->render('imagecapture');
		}			
	}	
	function validate_registration_ajax()
	{
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())
		{
			$errors_msg = null;
			$errors=$this->validate_member_reg($this->data);
						
			if ( is_array ( $this->data ) )
			{
				foreach ($this->data['User'] as $key => $value )
				{ 
					if( array_key_exists ( $key, $errors) )
					{
						foreach ( $errors [ $key ] as $k => $v )
						{
							$errors_msg .= "error|$key|$v";
						}	
					}
					else 
					{
						$errors_msg .= "ok|$key|\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}	
	}
	
	function validate_member_reg($data)
	{		
		
		$this->loadModel("SendInvitation");
			
		$errors = array ();
		if (trim($data['User']['first_name'])=="")
		{
			$errors ['first_name'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['User']['last_name'])=="")
		{
			$errors ['last_name'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['User']['email'])=="")
		{
			$errors ['email'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		elseif(trim($data['User']['email'])!="")
		{
			$checkEmail=explode('@',$data['User']['email']);
			$checkexistEmail=$this->User->find('count',array('conditions'=>array('User.email'=>$data['User']['email'])));
			
			if($this->validEmail($data['User']['email'])=='false')
				$errors ['email'] [] = __(INVALID_EMAIL,true)."\n";
			elseif($checkexistEmail>0)
			{
				$errors ['email'] [] = __(EMAIL_EXISTS,true)."\n";	
			}
		}
		if(trim($data['User']['invite_code'])!=""){
			$infoCode = $this->SendInvitation->find('count',array('conditions'=>array('SendInvitation.invite_code'=>trim($data['User']['invite_code']),'SendInvitation.status'=>'Unused')));
			
			if($infoCode==0){
				$errors ['invite_code'] [] = __('Incorrect invite code',true)."\n";
			}
		}
		if (trim($data['User']['member_type']) == "")
		{
			$errors ['member_type'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['User']['fpassword'])=="")
		{
			$errors ['fpassword'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(trim($data['User']['terms'])=="0")	{
				$errors ['terms'] [] = __('Please check terms and conditions',true)."\n";
			}				
		if (trim($data['User']['Cpassword'])=="")
		{
			$errors ['Cpassword'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		elseif(trim($data['User']['fpassword'])!=trim($data['User']['Cpassword']))
		{
			$errors ['Cpassword'] [] = __(PASSWORD_MATCH,true)."\n";
		}
		elseif(strlen($data['User']['Cpassword'])<6)
		{
			$errors ['Cpassword'] [] = __(PASSWORD_LENGTH_VALIDATION,true)."\n";
		}
		
		if (trim($data['User']['zipcode'])=="")
		{
			$errors ['zipcode'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['User']['captcha'])=="")
		{
			$errors ['captcha'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		elseif (trim(md5($data['User']['captcha'])) != $this->Session->read('captchaCode'))
		{
			 
			$errors ['captcha'] [] = __("Incorrect captcha code",true)."\n";
		}
		
		return $errors;			
	}
	//-----------------------------------------------------------End of User Registration Section
	
	//-------------------------Student/Instructor CMS Page-----------------------------------------
	
	function view_cms($id=NULL){
		$this->layout="public";	
		$id=convert_uudecode(base64_decode($id));
		$cmsInfo=$this->CmsPage->find('first',array('conditions'=>array('CmsPage.id'=>$id)));
		$this->set(compact('cmsInfo'));
	}
	
	//--------------------------------------------------------EOF------------------------------------
	
	//----------------------------------------Login section for Teacher and Student-----------------------------------------
	function login()
	{
		$this->layout = "public";
		$email_cookie = $this->Cookie->read('emailTambarkCookie');
		$pass_cookie  = $this->Cookie->read('passTambarkCookie');
		$cookie_type  = $this->Cookie->read('typeTambarkCookie');
		
		$info = $this->CmsPage->find('first',array('conditions'=>array('CmsPage.id'=>5)));		
		$this->set(compact('info','email_cookie','pass_cookie','cookie_type'));
		
		if(!empty($this->data))
		{		
			$error=array();
			$error=$this->validate_login($this->data);			
			if(count($error)==0){					
				$checkexistUser=$this->User->find('first',array('conditions'=>array('email'=>$this->data['User']['user_name'],'password'=>md5($this->data['User']['password']))));		
					
				$this->Session->write("User.login",1);
				$this->Session->write("User.id",$checkexistUser['User']['id']);
				$this->Session->write('User.member_type',$checkexistUser['User']['member_type']);
				$this->Session->write('User.status',$checkexistUser['User']['status']);
				$this->Session->write('User.email',$checkexistUser['User']['email']);
				$this->Session->write('User.Fname', $checkexistUser['User']['first_name']);
				$this->Session->write('User.Lname', $checkexistUser['User']['last_name']);
				$this->Session->write('User.lastLogin',$checkexistUser['User']['last_login']);
				
				$this->get_member_memory_usage($checkexistUser['User']['id']);
				
				$date = date("d-m-Y");
				$time = date("h:i:s a",time());				
				$data['User']['id']=$checkexistUser['User']['id'];
				$data['User']['last_login']=$date.'_'.$time;
				$this->User->save($data);
				//pr($this->data);die;
				//----------------Remember Me--------------------------------------------------------
				if(isset($this->data['User']['checkbox']) && $this->data['User']['checkbox']=='1'){
					$this->Cookie->write('emailTambarkCookie',$this->data['User']['user_name'],false,60*60*24*365);
					$this->Cookie->write('passTambarkCookie',$this->data['User']['password'],false,60*60*24*365);	
					$this->Cookie->write('typeTambarkCookie',$this->data['User']['checkbox'],false,60*60*24*365);					
				}
				else{
					$this->Cookie->delete('emailTambarkCookie');
					$this->Cookie->delete('passTambarkCookie');
					$this->Cookie->delete('typeTambarkCookie');
				}			
				//------------After login Teacher and Student navigate to their dashboad---------------
				switch($checkexistUser['User']['member_type']){	
					
					case '1':					
						$url=array('controller'=>'Instructors','action'=>'my_page');
					break;					
					case '2':
						$event_id = $this->data['User']['event_id'];
					if(isset($event_id) && $event_id!=''){						
						$url=array('controller'=>'Students','action'=>'view_instructor_event/'.$event_id);
					}else{
						$url=array('controller'=>'Students','action'=>'my_page');
					}
					break;
				}	
				$this->redirect($url);
			}
			else{
				$this->set('error',$error);					
			}
		}
	}
	
	function login_check_ajax()
	{		
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())
		{
			$errors_msg = null;
			$errors=$this->validate_login($this->data);							
			if ( is_array ( $this->data ) )
			{
				foreach ($this->data['User'] as $key => $value )
				{
					if( array_key_exists ( $key, $errors) )
					{
						foreach ( $errors [ $key ] as $k => $v )
						{
							$errors_msg .= "error|$key|$v";
						}		
					}
					else 
					{
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}	
	}
	
	function validate_login($data)
	{			
		$errors = array ();
		if(trim($data['User']['user_name']==""))
		{
			$errors['user_name'] []= __(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['User']['password'])=="")
		{
			$errors ['password'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(trim($data['User']['user_name'])!="" && trim($data['User']['password'])!="")
		{
			$checkexistUser=$this->User->find('first',array('conditions'=>array('email'=>$data['User']['user_name'],'password'=>md5($this->data['User']['password']))));	
			
			if(empty($checkexistUser))
			{
				$errors ['password'] [] = __(WRONG_CREDENTIALS,true)."\n";
			}elseif($checkexistUser['User']['status']=='0'){
				$errors ['password'] [] = "Your Account is in-active."."\n";
			}
		}
		return $errors;
	}
	//------------------------------------------------------End of Login section for Teacher and Student	
	
	//---------------------------------Logout Section---------------------------------------------------
	
	function logout()
	{
		$this->Session->delete('User');
		$this->redirect(array('action' => 'login'));
	}
	
	//-------------------------------------------------------End of Logout Section
	
	//---------------------FORGET PASSWORD---------------------------------------
	
	function get_password()
	{
		$this->layout = "public";
		if(!empty($this->data)){
			$error=$this->validate_email($this->data);
			if(count($error)==0){
				$info=$this->User->find('first',array('conditions'=>array('User.email'=>$this->data['User']['user_name']),'recursive'=>'-1','fields'=>array('User.first_name','User.last_name','User.email','id')));
				$str="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
				$pass=str_shuffle($str);
				$pass=substr($pass,0,6);
				$data['User']['id']=$info['User']['id'];
				$data['User']['password']=md5($pass);
				
				if($this->User->save($data)){
					$emailTemp=$this->EmailTemplate->findById('5');
					$emailTo=$info['User']['email'];
					$emailFrom=$emailTemp['EmailTemplate']['email_from'];
					$emailSubject=$emailTemp['EmailTemplate']['subject'];
					$emailData=$emailTemp['EmailTemplate']['description'];
					$emailData=str_replace(array('{first_name}','{last_name}','{password}'),array($info['User']['first_name'],$info['User']['last_name'],$pass),$emailData);
					$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);
					
				}
				$this->Session->write('SuccessMessage','Your password has been send to your email Id');
				$this->redirect(array('controller'=>'Homes','action'=>'login_main'));
			}else{
				$this->set('error',$error);	
			}
			
		}
	}
	
	function email_check_ajax()
	{		
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())
		{
			$errors_msg = null;
			$errors=$this->validate_email($this->data);							
			if ( is_array ( $this->data ) )
			{
				foreach ($this->data['User'] as $key => $value )
				{
					if( array_key_exists ( $key, $errors) )
					{
						foreach ( $errors [ $key ] as $k => $v )
						{
							$errors_msg .= "error|$key|$v";
						}		
					}
					else 
					{
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}	
	}
	
	function validate_email($data)
	{			
		$errors = array ();
		$checkexistUser=$this->User->find('first',array('conditions'=>array('email'=>$data['User']['user_name'])));	
		if(trim($data['User']['user_name']==""))
		{
			$errors['user_name'] []= __(FIELD_REQUIRED,true)."\n";
		}
		elseif(empty($checkexistUser))
		{
			$errors ['user_name'] [] = __('E-Mail doesn\'t exists',true)."\n";
		}
		return $errors;
	}
	
	//-------------------------------------EOF-----------------------------------

	//-----------------------------Message After registration-----------------------
	function success_registration( $id=NULL,$member_type=NULL)
	{
		$this->layout = "public";
		//-------------------Sending mail to the admin when user registred----------------------
		$id=convert_uudecode(base64_decode($id));
		$member_type=convert_uudecode(base64_decode($member_type));
		if($member_type=="2")
		{$memSend='Student';}elseif($member_type=="1"){$memSend='Instructor';}
		$mem_inf=$this->User->find('first', array('conditions'=>array('User.id'=>$id),'fields'=>array('first_name','last_name','member_type'),'contain'=>false));
		$emailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('id'=>36)));						
		$emailData=$emailTemplate['EmailTemplate']['description'];						
		$emailData=str_replace(array('{user_name}','{user_type}'),array($mem_inf['User']['first_name'].' '.$mem_inf['User']['last_name'],$memSend),$emailData);							
		$emailTo=ADMIN_EMAIL;
		$emailFrom=$emailTemplate['EmailTemplate']['email_from'];
		$emailSubject=$emailTemplate['EmailTemplate']['subject'];						
		
		$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);						
		//-------------------EOF------------------------------------------------
		
		if($member_type=="2")
		{
			$msg = "Thanks for registering with us, we have sent an activation email to your registered email address. Kindly activate your account";
			$this->set(compact('msg','id'));
				
		}elseif($member_type=="1"){
			$msg = "Thanks for registering with us, we have sent an activation email to your registered email address. Kindly activate your account";
			$this->set(compact('msg','id'));
		}

	}
	function resend_email()
	{
		$id=$_POST['id'];
		
		$id=convert_uudecode(base64_decode($id));
		$getUserDetail=$this->User->findById($id);
		$activation_code = $getUserDetail['User']['activation_code'];
			
		if($getUserDetail['User']['member_type'] == "1")
		{
			//-----------------Mail for admin when new teacher registered-------------------
			$emailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('id'=>6)));						
			$emailData=$emailTemplate['EmailTemplate']['description'];						
			$link=HTTP_ROOT.'Users/activate_account/'.base64_encode(convert_uuencode($getUserDetail['User']['id']))."/".$activation_code;							
			$link="<a href='".$link."' style='text-decoration:none;color:#00aeef'>Activate Your Account</a>";						
			
			$emailData=str_replace(array('{name}','{last_name}','{activation_code}'),array($getUserDetail['User']['first_name'],$getUserDetail['User']['last_name'],$link),$emailData);							
			
			$emailTo=$getUserDetail['User']['email'];
			$emailFrom=$emailTemplate['EmailTemplate']['email_from'];
			$emailSubject=$emailTemplate['EmailTemplate']['subject'];
			//echo $emailTo.'/////'.$emailFrom	.'////'.$emailSubject.'////'.$emailData; die;
			$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);
			
			echo "E-mail sent successfully!";
					
		}
		elseif($getUserDetail['User']['member_type'] == "2"){
			
			$emailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('id'=>1)));						
			$emailData=$emailTemplate['EmailTemplate']['description'];						
			$link=HTTP_ROOT.'Users/activate_account/'.base64_encode(convert_uuencode($getUserDetail['User']['id']))."/".$activation_code;							
			$link="<a href='".$link."' style='text-decoration:none;color:#00aeef'>Activate Your Account</a>";						
			$emailData=str_replace(array('{name}','{last_name}','{activation_code}'),array($getUserDetail['User']['first_name'],$getUserDetail['User']['last_name'],$link),$emailData);							
			$emailTo=$getUserDetail['User']['email'];
			$emailFrom=$emailTemplate['EmailTemplate']['email_from'];
			$emailSubject=$emailTemplate['EmailTemplate']['subject'];						
			
			$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);						
			echo "E-mail sent successfully!";
		}
		die;
		
	}
	function expired_link()
	{       
		$this->layout = "public";
		$msg ="This link has been expired!";
		$this->set(compact('msg'));
	}
	//---------------------------------CMS Pages Section---------------------------------------------------
	function about_us()
	{
		$this->layout = "public";
		$title_for_layout = "About Us";
		$info = $this->CmsPage->find('first',array('conditions'=>array('id'=>1)));
		$this->set(compact('info','title_for_layout'));
	}
	
	function contact_us()
	{
		$this->layout = "public";
		$title_for_layout = "Contact Us";
		$info = $this->CmsPage->find('first',array('conditions'=>array('id'=>2)));
		$this->set(compact('info','title_for_layout'));
		//pr($this->data); die;
		if($this->data)
		{
			$error = array();
			$error = $this->validate_contact($this->data);
			if(count($error)==0)
			{
				$data = $this->data;
				$data['Contact']['date_added'] =date('Y-m-d'); 
				$saved = $this->Contact->save($data);
				
				if($saved)
				{
					$emailTemplate = $this->EmailTemplate->find('first',array('conditions'=>array('id'=>4)));
					$emailData= $emailTemplate['EmailTemplate']['description'];
					$emailData = str_replace(array('{first_name}','{last_name}'),array($data['Contact']['first_name'],$data['Contact']['last_name']),$emailData);
					$emailTo = $data['Contact']['email'];
					$emailFrom = $emailTemplate['EmailTemplate']['email_from'];
					$emailSubject = $emailTemplate['EmailTemplate']['subject'];
					
					$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);
					$this->Session->write('SuccessMessage','Thanks for contacting Us! We will contact you soon.');
					$this->redirect(array('controller'=>'Homes','action'=>'contact_us'));
                }
				
			}else{
				echo $this->set('error',$error);
			}
		}
		
	}
	function contact_check_ajax()
	{
		
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())
		{
			$errors_msg = null;
			$errors=$this->validate_contact($this->data);							
			if ( is_array ( $this->data ) )
			{
				foreach ($this->data['Contact'] as $key => $value )
				{
					if( array_key_exists ( $key, $errors) )
					{
						foreach ( $errors [ $key ] as $k => $v )
						{
							$errors_msg .= "error|$key|$v";
						}		
					}
					else 
					{
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}	
	}
	
	function validate_contact($data)
	{			
		$errors = array ();
		if (trim($data['Contact']['first_name'])=="")
		{
			$errors ['first_name'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(trim($data['Contact']['contact_type'])=="")
		{
			$errors['contact_type'][]=__(FIELD_REQUIRED,true)."\n";
		}
		if(trim($data['Contact']['message'])=="")
		{
			$errors['message'][]=__(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['Contact']['email'])=="")
		{
			$errors ['email'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		elseif(trim($data['Contact']['email'])!="")
		{
			if($this->validEmail($data['Contact']['email'])=='false')
			$errors ['email'] [] = __(INVALID_EMAIL,true)."\n";
		}
		return $errors;
	}
	function faq()
	{
		$this->layout = "public";
		$title_for_layout = "FAQ's";
		$info = $this->Faq->find('all');
		$this->set(compact('info','title_for_layout'));
 	}
	//-------------------------------------------------------End of CMS Pages Section
	/*--------Teacher Search----------------------------*/
	
	function search_instructor()
	{
		$this->layout = "public";
		$title_for_layout = 'Search Instructor';	
		$searchConditions = array();
		$qryStr = '';
		$this->loadModel('Country');
		$this->loadModel('Category');
		$this->loadModel('SubCategory');
		$this->loadModel('User');
		$this->loadModel('UserCategory');
		
		$country_list = $this->Country->find('all');
		$country_list = Set::combine($country_list,'{n}.Country.id','{n}.Country.country_name');
		$category_list = $this->Category->find('all',array('conditions'=>array('Category.status'=>'1')));
		$category_list = Set::combine($category_list,'{n}.Category.id','{n}.Category.name');
		$sub_category_list = $this->SubCategory->find('all',array('conditions'=>array('SubCategory.status'=>'1')));
		$sub_category_list = Set::combine($sub_category_list,'{n}.SubCategory.id','{n}.SubCategory.name');
		
		$this->set(compact('country_list','category_list','sub_category_list','qryStr','title_for_layout'));
		
		$getInfo = $this->User->find('all',array('conditions'=>array('User.member_type'=>'1','User.status'=>'1')));
		$this->User->unBindModel(array('hasMany'=>array('VideoLink')));
		$this->paginate = array('limit'=>'10','order'=>'User.id DESC');
		$result = $this->paginate('User',array('User.member_type'=>'1','User.status'=>'1'));
		$this->set('teacherInfo',$result);
		$this->set('getInfo',$getInfo);
		
		if($this->request->is('ajax'))
		{
			$this->layout = '';
			$this->autoRender = false;	
			$this->render('/Elements/frontElements/search_instructor_listing');
		}
		
	}
	
	function instructorSearchData($condition=null)
	{
		if(isset($this->params['named']['page'])){				
		}else {
			$this->request->params['named']['page'] = 1;
		}
		$this->loadModel('User');
		$this->loadModel('UserCategory');
		
		$condition=array();
		$qryStr='';
		$membId = array();
		
		if(isset($this->params['named']['condition'])){
			$condition = $this->sortTeacher_condition();
			$qryStr = $this->params['named']['condition'];
		}
		else{
			
			if($this->data['User']['cate_id']!=''){
				$member_id = $this->UserCategory->find('all',array('conditions'=>array('UserCategory.cate_id'=>$this->data['User']['cate_id']),'recursive'=>'-1'));
				
				$membId1 = array();
				foreach($member_id as $member_id)
				{
					$membId1[] = $member_id['UserCategory']['m_id'];
				}
				$membId = array_merge($membId,$membId1);
			}
			if($this->data['User']['sub_cate_id']!=''){
				$member_id = $this->UserCategory->find('all',array('conditions'=>array('UserCategory.sub_cate_id'=>$this->data['User']['sub_cate_id']),'recursive'=>'-1'));
				$membId2 = array();
				foreach($member_id as $member_id)
				{
					$membId2[] = $member_id['UserCategory']['m_id'];
				}
				$membId = array_intersect($membId,$membId2);
			}
			$membId = array_unique($membId);
			
			if(!empty($membId))
			{				
				$condition = array_merge($condition,array('User.id'=>$membId));
				$condition = array_merge($condition,array("User.id"=>$membId));
				$membId = implode(",",$membId);
				$qryStr = $qryStr."User.id-||".$membId."||-";
			}
			
			if($this->data['User']['country']!=''){
				$condition = array_merge($condition,array("User.country"=>$this->data['User']['country']));
				$qryStr = $qryStr."User.country-||".$this->data['User']['country']."||-";
			}
			
			$zipcode = trim($this->data['User']['zipcode']);
			if($zipcode!=''){
				$condition = array_merge($condition,array("User.zipcode"=>$zipcode));
				$qryStr = $qryStr."User.zipcode-||".$this->data['User']['zipcode']."||-";
			}
			$otherSub = trim($this->data['User']['other_subcategory']);
			if($this->data['User']['cate_id']!='' && $otherSub!=''){
				$condition = array_merge($condition,array("User.cate_id"=>$this->data['User']['cate_id'],"User.sub_category_name LIKE"=>'%'.$otherSub."%"));
				$qryStr = $qryStr."User.cate_id-||".$this->data['User']['cate_id']."||-";
				$qryStr = $qryStr."User.sub_category_name-||".$this->data['User']['other_subcategory']."||-";
			}
			if(!isset($this->params['named']['condition'])){			
				$qryStr = base64_encode($qryStr);
			}	
		}
		$this->set('qryStr',$qryStr);
		if($this->RequestHandler->isAjax()) 
		{
			$this->layout="";
			$this->autoRender=false;
			$getInfo = $this->User->find('all',array('conditions'=>array('User.member_type'=>'1','User.status'=>'1')));
			$this->User->unBindModel(array('hasMany'=>array('VideoLink')));
			$info = '';
			if(sizeof($condition)!='0'){
				$this->paginate=array('limit' => 10,'order'=>'User.id DESC','conditions'=>array_merge($condition,array('User.member_type'=>'1','User.status'=>'1')));
				$info = $this->paginate('User');
			}
			$this->set('getInfo',$getInfo);
			$this->set('teacherInfo', $info);				
			$this->viewPath = 'Elements'.DS.'frontElements';
			$this->render('search_instructor_listing');
		}		
		else
		{
			echo "error";die;
		}		
		
	}
	function sortTeacher_condition()
	{
		$conditions = array();
		$action = $this->params['action'];
		//echo $model[$action];
		if(isset($this->params['named']['condition']))
		{
			$this->set('qryStr',$this->params['named']['condition']);
			$qryStr = $this->params['named']['condition'];
			$con=explode("||-",base64_decode($qryStr));
			if($con[count($con)-1]=='')
			{
				array_pop($con);
			}
			
			$or['OR']=array();
			foreach($con as $val):
				$qry = explode("-||",$val);
				
				if($qry[0]=="User.id")
				{	
					$ids = explode(",",$qry[1]);
					$conditions = array_merge($conditions,array('User.id'=>$ids));
				}
				
			endforeach;
		}
		return $conditions;
	}
	
	/*-------------------------------EOTS1-----------------------*/
	
	function findSubCategory()
	{
		if($this->request->is('ajax'))
		{
			$str = '<option value="">'.'Select Sub Category'.'</option>';
			
			$catgId = $_POST['category_id'];
			
			$this->loadModel('SubCategory');
			$subCatgInfo = $this->SubCategory->find('all',array('conditions'=>array('SubCategory.c_id'=>$catgId),'recursive'=>'-1'));
			
			foreach($subCatgInfo as $subCatgInfo)
			{
				$str .= "<option value='".$subCatgInfo['SubCategory']['id']."'>".$subCatgInfo['SubCategory']['name']."</option>";  
			}
			echo $str;
			die;
		}
	}
	function view_instructor_search_profile_home($teacherId = NULL,$allIds=NULL)
	{
		$this->layout = "public";
		$title_for_layout="My Profile";
		
		//---------------------------------------------Load Model------------------------------
			$this->loadModel('Country');
			$this->loadModel('User');
			$this->loadModel('VideoLink');
			$this->loadModel('Category');
			$this->loadModel('SubCategory');
			$this->loadModel('UserCategory');
		//---------------------------------------------End Load Model------------------------------
		
		if(!empty($teacherId))
		{
			$MemId = convert_uudecode(base64_decode($teacherId));
		}
		else
		{
			$MemId = $this->Session->read('User.id');
		}
		
		$member_info = $this->User->find('first',array('conditions'=>array('User.id'=>$MemId,'User.status'=>1)));	
		if(isset($member_info['UserCategory'][0]['cate_id']))
		{	
			$infoCate = $this->Category->find('first',array('conditions'=>array('Category.id'=>$member_info['UserCategory'][0]['cate_id'],'Category.status'=>1)));
			$infoSubCate =	$this->UserCategory->find('all',array('conditions'=>array('UserCategory.m_id'=>$MemId,'UserCategory.cate_id'=>$member_info['UserCategory'][0]['cate_id'])));
			foreach($infoSubCate as $infoSubCate)
			{
				$subCate = $this->SubCategory->find('first',array('conditions'=>array('SubCategory.id'=>$infoSubCate['UserCategory']['sub_cate_id'],'SubCategory.status'=>1)));
				$subCategory[]=$subCate['SubCategory']['name'];
			}

			$this->set(compact('infoCate','subCategory'));
		}
		
		$this->set(compact('member_info','title_for_layout'));
	
	}
	function view_search_instructor_calender_home($InstId=NULL)
	{
		$InstId = convert_uudecode(base64_decode($InstId));
		$this->layout = 'public';
		$title_for_layout = 'Instructor Calender';
		$this->loadmodel('Event');
		
		$this->paginate = array('limit'=>'10','conditions'=>array('Event.t_id'=>$InstId,'Event.status'=>1),'fields'=>array('User.*','Event.*','Category.name','SubCategory.name'));
		$find_all_events = $this->paginate('Event');
		$this->set(compact('find_all_events','title_for_layout'));
		//pr($find_all_events); die;
		
		if($this->RequestHandler->isAjax())
		{
			$this->layout = '';
			$this->autoRender = false;
			$this->viewPath = 'Elements'.DS.'frontElements';
			$this->render('instructor_event_listing_home');
		}
	}
	function view_instructor_event_home($eventId=NULL)
	{
		$eventId = convert_uudecode(base64_decode($eventId));
		$this->layout = 'public';
		$title_for_layout = 'View Instructor Class';
		
		$this->loadModel('Event');
		$this->loadModel('StudentApplyEvent');
		$this->loadModel('Assignment');
		
		$this->Event->bindModel(array('hasMany'=>array('StudentApplyEvent'=>array('foreignKey'=>'event_id')	)));
		$eventInfo = $this->Event->find('first',array('conditions'=>array('Event.id'=>$eventId),'fields'=>array('Event.*','User.first_name','User.last_name','User.sub_category_name','Category.name','SubCategory.name','Country.country_name')));
		$assignSubmit = $this->Assignment->find('first',array('conditions'=>array('Assignment.event_id'=>$eventId,'Assignment.student_id'=>$this->Session->read('User.id'))));
		$this->set(compact('title_for_layout','eventInfo','assignSubmit'));
	}
	function watch_video($id=NULL)
	{
		$this->layout='public';
		$this->loadModel('VideoLink');
		$id=convert_uudecode(base64_decode($id));
		$video=$this->VideoLink->findById($id);
		if(!empty($video)){
			$this->set('video',$video);
		}else{
			$this->redirect(array('action'=>'instructor_edit_profile'));
		}
	}
	function terms_conditions()
	{
		$this->layout = "public";
		$title_for_layout = "Terms and conditions";
		$info = $this->CmsPage->find('first',array('conditions'=>array('id'=>'13')));
		$this->set(compact('info','title_for_layout'));
	}
	function error()
	{
		$this->layout="public";
		$title_for_layout="Error";
		$this->set(compact('title_for_layout'));
	}
	/*---------------------------tuturial-cms-page-section------by--ishan---------------------------------*/
	function tutorial()
	{
		$this->layout="public";
		$title_for_layout="Tutorial";
		$info = $this->CmsPage->find('first',array('conditions'=>array('id'=>14)));
		$this->set(compact('info',''));
	}
	function request_class()
	{
		$this->layout = "public";
		$title_for_layout = "Tambark : Request For Class";
		$this->loadModel('ClassRequest');
		$this->loadModel('Category');
		$cateGory = $this->Category->find('list',array('conditions'=>array('Category.status'=>'1'),'fields'=>array('id','name')));
		if(!empty($cateGory)){
			$cateGory = array(''=>'Choose',$cateGory);
		}else{
			$cateGory  =array(''=>'No record found');
		}
		$this->set(compact('cateGory'));
		if(!empty($this->data)){
			$error = array();
			$error = $this->check_request_class_ajax($this->data);
			if(count($error) == '0'){
				$this->request->data['ClassRequest']['date_added'] = date('Y-m-d');
				$this->ClassRequest->save($this->data);
				$this->Session->write('SuccessMessage','Request has been sent successfully for a class');
				$this->redirect($this->referer());
			}else{
				$this->set('error',$error);
			}
		}
	}	
	function check_request_class_ajax()
	{		
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())
		{
			$errors_msg = null;
			$errors=$this->validate_request_class($this->data);							
			if ( is_array ( $this->data ) )
			{
				foreach ($this->data['ClassRequest'] as $key => $value )
				{
					if( array_key_exists ( $key, $errors) )
					{
						foreach ( $errors [ $key ] as $k => $v )
						{
							$errors_msg .= "error|$key|$v";
						}		
					}
					else 
					{
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}	
	}
	
	function validate_request_class($data)
	{			
		$errors = array ();
		if(trim($data['ClassRequest']['name']==""))
		{
			$errors['name'] []= __(FIELD_REQUIRED,true)."\n";
		}
		if(trim($data['ClassRequest']['email_id']==""))
		{
			$errors['email_id'] []= __(FIELD_REQUIRED,true)."\n";
		}
		elseif($this->validEmail($data['ClassRequest']['email_id']) == 'false')
		{
			$errors['email_id'] []= __(INVALID_EMAIL,true)."\n";
		}
		if (trim($data['ClassRequest']['zip_code'])=="")
		{
			$errors ['zip_code'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['ClassRequest']['city'])=="")
		{
			$errors ['city'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['ClassRequest']['state'])=="")
		{
			$errors ['state'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['ClassRequest']['country'])=="")
		{
			$errors ['country'] [] = __(FIELD_REQUIRED,true)."\n";
		}if (trim($data['ClassRequest']['class_name'])=="")
		{
			$errors ['class_name'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['ClassRequest']['class_description'])=="")
		{
			$errors ['class_description'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		elseif(trim($data['ClassRequest']['class_description'])!=""){
			$countWords = str_word_count($data['ClassRequest']['class_description']);
			if($countWords > 10) {
				$errors ['class_description'] [] = __('Description should be 10 words only',true)."\n";
			}
		}
		return $errors;
	}
	
	function fb_close()
	{
		echo "<script>
				window.opener.location.reload()
				self.close();
			  </script>";
	}
	
}
?>