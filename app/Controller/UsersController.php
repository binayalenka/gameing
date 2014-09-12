<?php
ob_start();

class UsersController extends AppController{
	var $name='Users';
	var $pageLimit = 10;
	var $helpers = array('Session','Html','Js','Form','Text','Paginator');
	var $components=array('Session','Email','RequestHandler','Upload');      

	var $uses=array('User','Admin','EmailTemplate','CmsPage'); 
	
	function beforeFilter()
	{
		//pr($this->params);die;
		$this->disableCache();
		$url = array('admin_login','validate_admin_login','validate_admin_login_ajax','admin_password','validate_recover_password_ajax','recover_password_ajax','admin_instructor_search_result');
		if($this->Session->read('Admin.id') =='' && !in_array($this->params['action'],$url)){
			$this->redirect(array('action'=>'login','admin'=>true));
		}
	}
//---- ADMIN LOGIN FUNCTIONALITY------------------------------------------------
	function admin_login()
	{
		 
                $admin_info=$this->Admin->find('first');
		$this->Set('admin_info',$admin_info);
		$this->layout="";
		
		if (!empty($this->data))
		{ 	
			//pr($this->data);die;
				
			$error = array ();
			$error=$this->validate_admin_login_ajax($this->data);
			
			if(count($error)==0)
			{
				if($this->data['Admin']['username']!="" && $this->data['Admin']['password']!="")
				{			
					$username = $this->data['Admin']['username'];
					$password = $this->data['Admin']['password'];
					
					$getAdminData = $this->Admin->find('first',array('conditions' => array('username'=>$username,'password'=>md5($password))));	
					if($getAdminData)
					{					
						$this->Admin->id=$getAdminData['Admin']['id'];
						$db = $this->Admin->getDataSource();
						$data['Admin']['last_login']=$db->expression("NOW()");
						$this->Admin->save($data);
						
						$this->Session->write('Admin.username', $getAdminData['Admin']['username']);
						$this->Session->write('Admin.id', $getAdminData['Admin']['id']);
						$this->Session->write('Admin.type', $getAdminData['Admin']['type']);
						$this->Session->write('Admin.last_login', $getAdminData['Admin']['last_login']);
						$this->redirect(array('controller'=>'users','action' => 'dashboard','admin' => true));
					}
				}
				$this->Session->write('error',AUTHENTICATION_FAILED);
			}else{
				$this->set('error',$error);
			}
		}
		
	}
		
	function validate_admin_login()
	{
		$this->layout="";
		$this->autoRender=false;		
		if($this->RequestHandler->isAjax())
		{
			$errors_msg = null;
			$errors=$this->validate_admin_login_ajax($this->data);
						
			if ( is_array ( $this->data ) )
			{
				foreach ($this->data['Admin'] as $key => $value )
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
	function validate_admin_login_ajax($data)
	{			
		$errors = array ();
		
		$username = $data['Admin']['username'];
		$password = $data['Admin']['password'];
		$checkexistUser=$this->Admin->find('count',array('conditions'=>array('username'=>$username,'password'=>md5($password))));	
		
		if($checkexistUser==0)
		{
			$errors ['password'] [] = 'Authentication failed. Please enter correct username and password.'."\n";
		}			
		return $errors;			
	}
//-------------------------------------------------------------------- END OF ADMIN LOGIN

//-ADMIN LOGOUT-----------------------------------------------------------------------------------------------

	function admin_logout()
	{
		$this->Session->delete('Admin');
		$this->Session->delete('back_ctp');
		$this->redirect(array('action' => 'login','admin' => true));
	}
//-------------------------------------------------------------------- END OF ADMIN LOGIN

/*---------------Change Password---------*/
	
	function admin_change_password()
	{
		$this->layout='admin';
		$username=$this->Admin->find('first');
		$this->set('username',$username);
		if(!empty($this->data)){ 
			$error=array();
			$error=$this->change_password_ajax($this->data);	
			if(count($error)==0){
				$data['Admin']['id']=$this->data['ChangePass']['id'];
				$data['Admin']['password']=md5($this->data['ChangePass']['new_pass']);
				$this->Admin->save($data);
				$this->Session->write('success','Password has been updated successfully');
				$this->redirect(array('controller'=>'Users','action'=>'change_password','admin'=>true));
			}
			else{
				$this->set('error',$error);
			}
		}
	}
	function validate_change_password_ajax()
	{
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())
		{
			$errors_msg = null;
			$errors=$this->change_password_ajax($this->data);
						
			if ( is_array ( $this->data ) )
			{
				foreach ($this->data['ChangePass'] as $key => $value )
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
	
	function change_password_ajax($data)
	{			
		$errors = array ();
		
		$admin_info=$this->Admin->findById($data['ChangePass']['id']);	
		//pr($admin_info);die;
		if (trim($data['ChangePass']['old_pass'])==""){
			$errors ['old_pass'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['ChangePass']['new_pass'])==""){
			$errors ['new_pass'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['ChangePass']['con_pass'])==""){
			$errors ['con_pass'] [] = __(FIELD_REQUIRED,true)."\n";
		}		
		elseif($admin_info['Admin']['password']!=md5($data['ChangePass']['old_pass'])){
			$errors ['old_pass'] [] = __('Please enter correct old password',true)."\n";
		}
		elseif(trim($data['ChangePass']['new_pass'])!=trim($data['ChangePass']['con_pass'])){
			$errors ['con_pass'] [] = __(PASSWORD_MATCH,true)."\n";
		}
		
		
		return $errors;			
	}
/*-----------------EOF CHANGE PASSWORD----------------------------------*/

/*-----------------CHANGE USERNAME---------------------------------------*/
	
	function admin_change_username()
	{
		$this->layout='admin';
		$username=$this->Admin->find('first');
		$this->set('username',$username);
		if(!empty($this->data)){ 
			$error=array();
			$error=$this->change_username_ajax($this->data);	
			if(count($error)==0){
				
				$admin_info=$this->Admin->find('first');
				$emailTo[1]=$admin_info['Admin']['email'];
				$emailTo[2]=$this->data['ChangeUserName']['email'];
				
				$data['Admin']['id']=$this->data['ChangeUserName']['id'];
				$data['Admin']['username']=$this->data['ChangeUserName']['newusername'];
				$data['Admin']['email']=$this->data['ChangeUserName']['email']; 
				$this->Admin->save($data);
				
				for($i=1;$i<=2;$i++)
				{
				$emailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('id'=>30),'fields'=>array('subject','description','email_from')));
				$emailFrom=$emailTemplate['EmailTemplate']['email_from'];
				$emailSubject=$emailTemplate['EmailTemplate']['subject'];	
				$emailData=$emailTemplate['EmailTemplate']['description'];								
				$emailData=str_replace(array('{user_name}','{new_email}'),array($this->data['ChangeUserName']['newusername'],$this->data['ChangeUserName']['email']),$emailData); 
				$this->send_email($emailTo[$i],$emailFrom,$emailSubject,$emailData);
				}
				
				$this->Session->write('success','Username has been updated successfully');
				$this->redirect(array('controller'=>'Users','action'=>'change_username','admin'=>true));
			}
			else{
				$this->set('error',$error);
			}
		}
	}
	function validate_username_ajax()
	{
		$this->layout="";
		$this->autoRender=false;
		
		if($this->RequestHandler->isAjax())
		{
			$errors_msg = null;
			$errors=$this->change_username_ajax($this->data);
						
			if ( is_array ( $this->data ) )
			{
				foreach ($this->data['ChangeUserName'] as $key => $value )
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
	
	function change_username_ajax($data)
	{			
		$errors = array ();
		$admin_info=$this->Admin->findById($data['ChangeUserName']['id']);
		if (trim($data['ChangeUserName']['username'])==""){
			$errors ['username'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['ChangeUserName']['newusername'])==""){
			$errors ['newusername'] [] = __(FIELD_REQUIRED,true)."\n";
		}elseif($admin_info['Admin']['username']!=$data['ChangeUserName']['username']){
			$errors ['username'] [] = __('Please enter correct old username',true)."\n";
		}
		
		if (trim($data['ChangeUserName']['email'])==""){
			$errors ['email'] [] = __(FIELD_REQUIRED,true)."\n";
		}elseif($this->validEmail(trim($data['ChangeUserName']['email']))=="false"){
			$errors ['email'] [] = __(INVALID_EMAIL,true)."\n";
		}
		return $errors;			
	}
	/*---------------------------------EOF CHANGE USERNAME----------------*/
	/*-----------------RECOVER PASSWORD---------------------------------------*/
	
	function admin_password()
	{
		if(!empty($this->data)){  
			$error=array(); 
			$error=$this->recover_password_ajax($this->data);	
			if(count($error)==0){ 
				$data['Admin']['id']=$this->data['AdminEmail']['id'];
				$pass = str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
				$pass=substr($pass,0,6);
				$data['Admin']['password']=md5($pass);
				if($this->Admin->save($data)){
				
				$emailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('id'=>3),'fields'=>array('subject','description','email_from')));
				$admin_info=$this->Admin->find('first');
				$emailTo=$admin_info['Admin']['email'];
				$emailFrom=$emailTemplate['EmailTemplate']['email_from'];
				$emailSubject=$emailTemplate['EmailTemplate']['subject'];	
				$emailData=$emailTemplate['EmailTemplate']['description'];								
				$emailData=str_replace(array('{password}'),array($pass),$emailData);
				$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);
					
				}
				$this->Session->write('success','New password has been send to your registered e-mail id');
				$this->redirect(array('controller'=>'Users','action'=>'login','admin'=>true));
			}
			else{
				$this->set('error',$error);
			}
		}
	}
	function validate_recover_password_ajax()
	{
		
		if($this->RequestHandler->isAjax())
		{
			$errors_msg = null;
			$errors=$this->recover_password_ajax($this->data);
						
			if ( is_array ( $this->data ) )
			{
				foreach ($this->data['AdminEmail'] as $key => $value )
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
	
	function recover_password_ajax($data)
	{			
		$errors = array (); 
		$admin_info=$this->Admin->findById($data['AdminEmail']['id']);
		//pr($admin_info);die;
		if (trim($data['AdminEmail']['email'])==""){
			$errors ['email'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		elseif($admin_info['Admin']['email']!=$data['AdminEmail']['email']){
			$errors ['email'] [] = __('Email does not exists',true)."\n";
		}
		return $errors;			
	}
	/*---------------------------------EOF RECOVER PASSWORD----------------*/
	//-ADMIN DASHBOARD--------------------------

	function admin_dashboard()
	{
		
			     
		$this->layout="admin";
		$emailTemp = $this->EmailTemplate->find('all');
		
		$this->set(compact('emailTemp'));
		
	}
	//------------------------------------------------------END ADMIN DASHBOARD--------------------------

	function admin_teacher()
	{
		$this->layout="admin";
		$page= isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		
		$counter = $this->Member->find('count',array('conditions'=>array('Member.member_type'=>'1')));
		
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Member.id DESC');
		$info = $this->paginate('Member',array('Member.member_type'=>'1'));
		$this->set(compact('info','page','counter'));
		
		if($this->RequestHandler->isAjax())
		{
			$this->layout="";
			$this->viewPath = 'Elements'.DS.'adminElements/teacher';
			$this->render('teacher_list');
		}
	}
	
	function admin_student()
	{
		$this->layout='admin';		
		$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		//pr($this->params); die;
		$counter = $this->Member->find('count',array('conditions'=>array('Member.member_type'=>'2')));
		
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Member.id DESC');
		$info=$this->paginate('Member',array('Member.member_type'=>'2'));
		$this->set(compact('info','page','counter'));
		
		if($this->RequestHandler->isAjax())
		{
			 $this->layout="";
			 $this->viewPath = 'Elements'.DS.'adminElements/teacher';
			 $this->render('student_list');
		}
	}
	function admin_cmspages()
	{
		$this->layout='admin';
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'id ASC'); 
		$info=$this->paginate('CmsPage');
		$this->set(compact('info'));
		
		if($this->RequestHandler->isAjax())
		{
			 $this->layout="";
			 $this->viewPath ='Elements'.DS.'adminElements/cmsPages';
			 $this->render('cms_list');
		}
	}
	function admin_edit_cms($id=NULL)
	{
		$this->layout='admin';		
		if(!empty($id))	{	
			$pageid=convert_uudecode(base64_decode($id));
			$info = $this->CmsPage->find('first',array('conditions'=>array('CmsPage.id'=>$pageid)));
			$this->set('info',$info);
		}		
		if(!empty($this->data)){ //pr($this->data);die;	
			$this->request->data['CmsPage']['date_modified']=date('d-m-Y');
			$this->CmsPage->save($this->data); 
			$this->Session->write('success','Information has been updated');
			$this->redirect(array('action'=>'cmspages','admin' => true));									
		}
	}
	//--------------MANAGE EMAIL TEMPLATE------------------------------

	function admin_email_templates()
	{
		//$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$this->layout="admin";
		$this->paginate = array('order'=>'EmailTemplate.id ASC','limit'=>$this->pageLimit);
		$info = $this->paginate('EmailTemplate'); 
		$this->set(compact('info','page'));
		
		 if($this->RequestHandler->isAjax()){
		   $this->layout="";
		   $this->viewPath = 'Elements'.DS.'adminElements/emailTemplate';
		   $this->render('template_list');
	   }
	}
	
	function admin_edit_email_template($id=NULL)
	{
		$this->layout="admin";
		if(!empty($id))
		{
			$main_id = convert_uudecode(base64_decode($id));
			$info = $this->EmailTemplate->find('all',array('conditions'=>array('id'=>$main_id)));
			$this->set('info',$info);
		}
		
		if(!empty($this->data))
		{
			$this->EmailTemplate->save($this->data);
			$this->Session->write('success','The template has been updated');
			$this->redirect(array('action'=>'email_templates','admin' => true));

		}
	}
//--------------------------------------------------------------------------- END EMAIL TEMPLATE---
//----------------------Frequently Asked Questions----------------------------
	
	function admin_faq()
	{
		$this->layout='admin';
		$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Faq.id DESC'); 
		$info=$this->paginate('Faq');
		$this->set(compact('info','page'));
		
		if($this->RequestHandler->isAjax()){
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath='Elements'.DS.'adminElements/cmsPages';
			$this->render('faq_list');
		}
	}
	function admin_add_faq()
	{
		$this->layout='admin';
		
		if(!empty($this->data))
		{
			$error=array();
			$error=$this->check_faq($this->data);
			if(count($error)==0){
				$data = $this->data;
				$data['Faq']['date_added'] = date('d-m-Y');
				$data['Faq']['date_modified'] = "";
				$this->Faq->save($data);
				$this->Session->write('success','FAQ added successfully');
				$this->redirect(array('controller'=>'users','action'=>'faq','admin'=>true));
			}
			else
			{
				$this->set('error',$error);
				$this->data=$this->data;
			}
		}
	}
	function admin_edit_faq($id=NULL)
	{
		$this->layout='admin';
		$id = convert_uudecode(base64_decode($id));
		$info = $this->Faq->find('first',array('conditions'=>array('Faq.id'=>$id))); //pr($info);die;
		$this->set(compact('info'));
		
		if(!empty($this->data))
		{
			$error=array();
			$error=$this->check_faq($this->data); //pr(count($error));die;
			if(count($error)==0){
				$data = $this->data;
				$data['Faq']['date_modified'] = date('d-m-Y');
				$this->Faq->save($data);				
				$this->Session->write('success','FAQ edited successfully.');
				$this->redirect(array('controller'=>'users','action'=>'faq','admin'=>true));
			}
			else
			{
				$this->set('error',$error); 
				$this->set('info',$this->data);
			}
		}
	}
	
	function admin_view_faq($id=NULL)
	{
		$this->layout='admin';
		$id = convert_uudecode(base64_decode($id));
		$info = $this->Faq->find('first',array('conditions'=>array('Faq.id'=>$id)));
		$this->set(compact('info'));
	}
	
	/*function faq_check_ajax()
	{
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())
		{
			$errors_msg = null;
			$errors=$this->check_faq($this->data);		
			if ( is_array ( $this->data ) )
			{
				foreach ($this->data['Faq'] as $key => $value )
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
	} */
	
	function check_faq($data)
	{			
		$errors = array ();
		if(trim($data['Faq']['faq_ques']==""))
		{
			$errors['faq_ques'] []= __(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['Faq']['faq_ans'])=="")
		{
			$errors['faq_ans'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		
		return $errors;
	}
	//------End of Frequently Asked Questions-
	
	//------FUNCTION FOR DELETE SINGLE RECORD FROM TABLE--

	function admin_delete_record($page=NULL,$d_id=NULL,$tableName=NULL,$renderPath=NULL,$renderElement=NULL)
	{
		$this->layout='';
		$this->loadModel('Contact');
		$this->loadModel('ContactAdmin');
		$this->loadModel('ContactInstructor');
		$this->loadModel('InviteTeacher');
		$this->loadModel('PromoCode');
		$this->loadModel('Blog');
		$this->loadModel('SendInvitation');
		$this->loadModel('ClassRequest');
		$d_id=convert_uudecode(base64_decode($d_id));
		$tableName=base64_decode($tableName);
		$renderPath=base64_decode($renderPath);
		$renderElement=base64_decode($renderElement);
		//echo $page.'-'.$d_id.'-'.$tableName.'-'.$renderPath.'-'.$renderElement;die;
		if($this->RequestHandler->isAjax())
		{		
			$this->layout=false;
			$this->autoRender = false;				
			$getRec = $this->$tableName->find('first',array('conditions'=>array($tableName.'.id'=>$d_id)));
			$id ='';
			if($tableName == 'Assignment'){
				$id = base64_encode(convert_uuencode($getRec['Assignment']['event_id']));
			}
			$field=array();
			if(!empty($getRec))
			{
				$this->$tableName->delete(array($tableName.'.id'=>$d_id));
			}		   	
			$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
			$info = $this->paginate($tableName);
			
			if(empty($info) && $page>1)
			{
				$page=$page-1;
				$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
				$info = $this->paginate($tableName);
			}
			$this->set(compact('info','page','id'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render($renderElement);			
		}
	}
	
	function admin_delete_blog_record($id=NULL,$page=NULL,$d_id=NULL,$tableName=NULL,$renderPath=NULL,$renderElement=NULL)
	{
		$this->layout='';
		$this->loadModel('Blog');
		$mem_id=convert_uudecode(base64_decode($id));
		$d_id=convert_uudecode(base64_decode($d_id));
		$tableName=base64_decode($tableName);
		$renderPath=base64_decode($renderPath);
		
		if($this->RequestHandler->isAjax())
		{		
			$this->layout=false;
			$this->autoRender = false;				
			$getRec = $this->$tableName->find('first',array('conditions'=>array($tableName.'.id'=>$d_id)));
			
			if(!empty($getRec))
			{
				$this->$tableName->delete(array($tableName.'.id'=>$d_id));
			}	
			$conditions=array($tableName.'.m_id'=>$mem_id);	   	
			$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
			$info = $this->paginate($tableName,$conditions);
			
			if(empty($info) && $page>1)
			{
				$page=$page-1;
				$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
				
				$info = $this->paginate($tableName,$conditions);
			}
			
			$this->set(compact('info','page','id'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render('blog_listing');			
		}
	}
	
	function admin_delete_workroom_record($id=NULL,$page=NULL,$workroom_id=NULL,$tableName=NULL,$renderPath=NULL,$renderElement=NULL)
	{
		$this->layout='';
		$this->loadModel('Workroom');
		$mem_id=convert_uudecode(base64_decode($id));
		$workroom_id=convert_uudecode(base64_decode($workroom_id));
		$tableName=base64_decode($tableName);
		$renderPath=base64_decode($renderPath);
		
		if($this->RequestHandler->isAjax())
		{		
			$this->layout=false;
			$this->autoRender = false;				
			$getRec = $this->$tableName->find('first',array('conditions'=>array($tableName.'.id'=>$workroom_id)));
			
			if(!empty($getRec))
			{
				$this->$tableName->delete(array($tableName.'.id'=>$workroom_id));
			}	
			$conditions=array($tableName.'.m_id'=>$mem_id);	   	
			$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
			$info = $this->paginate($tableName,$conditions);
			
			if(empty($info) && $page>1)
			{
				$page=$page-1;
				$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
				
				$info = $this->paginate($tableName,$conditions);
			}
			
			$this->set(compact('info','page','id'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render('instructor_workroom_listing');			
		}
	}
		
	function admin_delete_workroom_blog_record($id=NULL,$page=NULL,$d_id=NULL,$tableName=NULL,$renderPath=NULL,$renderElement=NULL)
	{
		$this->layout='';
		$this->loadModel('WorkroomPost');
		$mem_id=convert_uudecode(base64_decode($id));
		$d_id=convert_uudecode(base64_decode($d_id));
		$tableName=base64_decode($tableName);
		$renderPath=base64_decode($renderPath);
		$renderElement=base64_decode($renderElement);
		
		if($this->RequestHandler->isAjax())
		{		
			$this->layout=false;
			$this->autoRender = false;				
			$getRec = $this->$tableName->find('first',array('conditions'=>array($tableName.'.id'=>$d_id)));
			
			if(!empty($getRec))
			{
				$this->$tableName->delete(array($tableName.'.id'=>$d_id));
			}	
			$conditions=array($tableName.'.m_id'=>$mem_id);	   	
			$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
			$info = $this->paginate($tableName,$conditions);
			
			if(empty($info) && $page>1)
			{
				$page=$page-1;
				$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
				
				$info = $this->paginate($tableName,$conditions);
			}
			
			$this->set(compact('info','page','id'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render('workroom_posts_listing');			
		}
	}
	
	function admin_delete_remark_record($blog_id=NULL,$page=NULL,$d_id=NULL,$tableName=NULL,$renderPath=NULL,$renderElement=NULL)
	{
		$this->layout='';
		$this->loadModel('BlogRemark');
		$this->loadModel('WorkroomPostRemark');
		$blog_id=convert_uudecode(base64_decode($blog_id));
		$d_id=convert_uudecode(base64_decode($d_id));
		$tableName=base64_decode($tableName);
		$renderPath=base64_decode($renderPath);
		
		if($this->RequestHandler->isAjax())
		{		
			$this->layout=false;
			$this->autoRender = false;				
			$getRec = $this->$tableName->find('first',array('conditions'=>array($tableName.'.id'=>$d_id)));
			
			if(!empty($getRec))
			{
				$this->$tableName->delete(array($tableName.'.id'=>$d_id));
			}
			
			$conditions=array($tableName.'.blog_id'=>$blog_id);	   	
			
			$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
			$info = $this->paginate($tableName,$conditions);
			
			if(empty($info) && $page>1)
			{
				$page=$page-1;
				$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
				
				$info = $this->paginate($tableName,$conditions);
			}
			
			$this->set(compact('info','page','id'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render('comment_listing');			
		}
	}
	
	function admin_delete_workroom_remark_record($blog_id=NULL,$page=NULL,$d_id=NULL,$tableName=NULL,$renderPath=NULL,$renderElement=NULL)
	{
		$this->layout='';
		$this->loadModel('WorkroomPostRemark');
		$blog_id=convert_uudecode(base64_decode($blog_id));
		$d_id=convert_uudecode(base64_decode($d_id));
		$tableName=base64_decode($tableName);
		$renderPath=base64_decode($renderPath);
		
		if($this->RequestHandler->isAjax())
		{		
			$this->layout=false;
			$this->autoRender = false;				
			$getRec = $this->$tableName->find('first',array('conditions'=>array($tableName.'.id'=>$d_id)));
			
			if(!empty($getRec))
			{
				$this->$tableName->delete(array($tableName.'.id'=>$d_id));
			}
			
			$conditions=array($tableName.'.post_id'=>$blog_id);	   	
			
			$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
			$info = $this->paginate($tableName,$conditions);
			
			if(empty($info) && $page>1)
			{
				$page=$page-1;
				$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
				
				$info = $this->paginate($tableName,$conditions);
			}
			
			$this->set(compact('info','page','id'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render('work_comment_listing');			
		}
	}
	
	function admin_delete_assignment($page=NULL,$d_id=NULL,$tableName=NULL,$renderPath=NULL,$renderElement=NULL,$event_id=NULL)
	{
		$this->layout='';
		
		$d_id=convert_uudecode(base64_decode($d_id));
		$event_id=convert_uudecode(base64_decode($event_id));
		$tableName=base64_decode($tableName);
		$renderPath=base64_decode($renderPath);
		$renderElement=base64_decode($renderElement);
		//echo $page.'-'.$d_id.'-'.$tableName.'-'.$renderPath.'-'.$renderElement.'-'.$event_id;die;
		if($this->RequestHandler->isAjax())
		{	
			$this->layout=false;
			$this->autoRender = false;		
			
			if($tableName == 'InstructorAssignment'){
				
				$this->loadModel('InstructorAssignment');
				$checkRecord = $this->InstructorAssignment->find('first',array('conditions'=>array('InstructorAssignment.id'=>$d_id),'contain'=>false));
				$conditions= '';
				if(!empty($checkRecord)) { 
					$this->loadModel('InstructorAssignmentStudent');					
					$checkStudentRecord = $this->InstructorAssignmentStudent->find('all',array('conditions'=>array('InstructorAssignmentStudent.inst_assign_id'=>$d_id),'contain'=>false));		
					if($this->InstructorAssignment->delete($d_id))
					{
						$this->loadModel('InstructorAssignmentDocument');
						//pr($checkStudentRecord);die;
						foreach($checkStudentRecord as $record)
						{
							$checkStudentDocument = $this->InstructorAssignmentDocument->find('all',array('conditions'=>array('InstructorAssignmentDocument.assign_id'=>$record['InstructorAssignmentStudent']['id']),'contain'=>false));
							if($this->InstructorAssignmentStudent->delete($record['InstructorAssignmentStudent']['id']))
							{
								
								foreach($checkStudentDocument as $recordDocument)
								{
									if(!empty($recordDocument['InstructorAssignmentDocument']['file_name']))
									{
										if(file_exists('files/'.$record['InstructorAssignmentStudent']['s_id']."/personal_repo/".$recordDocument['InstructorAssignmentDocument']['file_name']))
										{
											unlink('files/'.$record['InstructorAssignmentStudent']['s_id']."/personal_repo/".$recordDocument['InstructorAssignmentDocument']['file_name']);
										}
									}
								}
							}
						}
						$conditions=array('InstructorAssignment.e_id'=>$event_id);
					}
				}
			}else if($tableName == 'InstructorAssignmentStudent'){
				$this->loadModel('InstructorAssignmentStudent');
				$this->loadModel('InstructorAssignmentDocument');
				$checkRecord = $this->InstructorAssignmentStudent->find('first',array('conditions'=>array('InstructorAssignmentStudent.id'=>$d_id),'contain'=>false));	
			
				//pr($checkRecord);die;
				$checkStudentDocument = $this->InstructorAssignmentDocument->find('all',array('conditions'=>array('InstructorAssignmentDocument.assign_id'=>$checkRecord['InstructorAssignmentStudent']['id']),'contain'=>false));
						//pr($checkStudentDocument);die;
				
				if(!empty($checkRecord)) { 
				
					$checkStudentDocument = $this->InstructorAssignmentDocument->find('all',array('conditions'=>array('InstructorAssignmentDocument.assign_id'=>$checkRecord['InstructorAssignmentStudent']['id']),'contain'=>false));
					if($this->InstructorAssignmentStudent->delete($d_id))
					{	
						foreach($checkStudentDocument as $recordDocument)
						{
							if(!empty($recordDocument['InstructorAssignmentDocument']['file_name']))
							{
								if(file_exists('files/'.$checkRecord['InstructorAssignmentStudent']['s_id']."/personal_repo/".$recordDocument['InstructorAssignmentDocument']['file_name']))
								{
									unlink('files/'.$checkRecord['InstructorAssignmentStudent']['s_id']."/personal_repo/".$recordDocument['InstructorAssignmentDocument']['file_name']);
								}
							}
						}
						
						$conditions=array('InstructorAssignmentStudent.inst_assign_id'=>$event_id);
						
					}
					if($renderElement == 'student_assignment_list'){
						
						$conditions = array('InstructorAssignmentStudent.e_id'=>$event_id,'InstructorAssignmentStudent.s_id'=>$checkRecord['InstructorAssignmentStudent']['s_id']);
						$this->set('student_id',base64_encode(convert_uuencode($checkRecord['InstructorAssignmentStudent']['s_id'])));
						
						$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
						$info = $this->paginate($tableName,$conditions);
						
						if(empty($info) && $page>1)
						{
							$page=$page-1;
							$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
							$info = $this->paginate($tableName,$conditions);
						}
					}
				}
			}
					
			if($renderElement != 'student_assignment_list'){
				$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
				$info = $this->paginate($tableName,$conditions);
				
				if(empty($info) && $page>1)
				{
					$page=$page-1;
					$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
					$info = $this->paginate($tableName,$conditions);
				}
			}
			
			$id=base64_encode(convert_uuencode($event_id));			
			$this->set(compact('info','page','id'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render($renderElement);	
		}
	}
	
	function admin_delete_record_id($page=NULL,$d_id=NULL,$tableName=NULL,$renderPath=NULL,$renderElement=NULL)
	{
		$this->layout='';
		$d_id=convert_uudecode(base64_decode($d_id));
		$tableName=base64_decode($tableName);
		$renderPath=base64_decode($renderPath);
		$renderElement=base64_decode($renderElement);
		$this->loadModel($tableName);
		if($this->RequestHandler->isAjax())
		{		
			$this->layout=false;
			$this->autoRender = false;				
			$getRec = $this->$tableName->find('first',array('conditions'=>array($tableName.'.id'=>$d_id)));
			$id ='';
			$field ='';
			if(!empty($getRec))
			{
				$this->$tableName->delete(array($tableName.'.id'=>$d_id));
			}
			
			if($tableName == 'AssignmentRemark'){
				$field = 'assign_id';				
				$id = base64_encode(convert_uuencode($getRec['AssignmentRemark']['assign_id']));
			}
			if($tableName == 'InstructorAssignmentRemark'){
				$field = 'student_assign_id';				
				$id = base64_encode(convert_uuencode($getRec['InstructorAssignmentRemark']['student_assign_id']));
			}
			elseif($tableName == 'BroadcastRemark'){
				$field = 'b_id';				
				$id = base64_encode(convert_uuencode($getRec['BroadcastRemark']['b_id']));
			}				
				$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC','conditions'=>array($tableName.'.'.$field=>$getRec[$tableName][$field]));
				$info = $this->paginate($tableName);				
				if(empty($info) && $page>1)
				{
					$page=$page-1;					
					$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC','conditions'=>array($tableName.'.'.$field=>$getRec[$tableName][$field]));
					$info = $this->paginate($tableName);
				}
			   	
			
			$this->set(compact('info','page','id'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render($renderElement);			
		}
	}
//-----------------------------------------------------------END OF FUNCTION FOR DELETE SINGLE RECORD FROM TABLE-------- 
	//------FUNCTION FOR CHANGE STATUS(ENABLE/DISABLE)-------------------------------------

	function admin_update_status($page=NULL,$id=NULL,$tableName=NULL,$renderPath=NULL,$renderElement=NULL)
	{
		$this->layout='';
		$id=convert_uudecode(base64_decode($id));
		$tableName=base64_decode($tableName);
		$renderPath=base64_decode($renderPath);
		$renderElement=base64_decode($renderElement);		
		if($this->RequestHandler->isAjax()){		
			$this->layout=false;
			$this->autoRender = false;				
			$getRec = $this->$tableName->find('first',array('conditions'=>array($tableName.'.id'=>$id)));			
			$field=array();
			if(!empty($getRec)){
				if($getRec[$tableName]['status']=='0'){
					$this->$tableName->id=$id;					
					$field[$tableName]['status'] = 1;					
					$this->$tableName->save($field);
				}
				else{
					$this->$tableName->id=$id;					
					$field[$tableName]['status'] = '0';					
					$this->$tableName->save($field);					
				}
			}		   	
			$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
			$info = $this->paginate($tableName);
			$this->set(compact('info','page'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render($renderElement);			
		}		
	} 
//------------------------------------------------------------END OF FUNCTION FOR CHANGE STATUS(ENABLE/DISABLE)--

//-----------------------------------------------------------Instructor Add Profile-----------------------------------
	function admin_add_student()
	{
		$this->layout="admin";
		
		$title_for_layout=':: Tambark ::';		
		//---------------------------------------------Load Model------------------------------
			$this->loadModel('Member');
		//---------------------------------------------End Load Model------------------------------
		$lastMemberDetail=$this->Member->find('first',array('order'=>'Member.id desc'));
		$error = array();
		if(!empty($this->data))
		{
			$error = $this->validate_add_profile_steps($this->data);					
			$data = $this->data;
			if(isset($lastMemberDetail['Member']['unique_id']) || empty($lastMemberDetail))
			{
				if(empty($lastMemberDetail)){
					$data['Member']['unique_id'] = 1000;
				}elseif($lastMemberDetail['Member']['unique_id']==''){
					$data['Member']['unique_id'] = 1000;
				}else{
					$data['Member']['unique_id'] = $lastMemberDetail['Member']['unique_id'] +1;
				}
			}
			
			//$encrypted = Security::rijndael('a secret', Configure::read('Security.key'), 'encrypt');
			//$secret = Security::cipher('my secret password', '2');
			//$nosecret = Security::cipher($secret, '2');
			
			
			if(count($error) == "0"){
				$data['Member']['password'] = md5($this->data['Member']['fpassword']);
				//$data['Member']['password'] = Security::cipher($this->data['Member']['fpassword'],'2');
				$saved = $this->Member->save($data);
				$lastMemId = $this->Member->getLastInsertId($data);
				
				App::uses('Folder','Utility');
				$dir = new Folder();
				if($data['Member']['member_type'] == '2'){
					$folder_name =array('personal_repo');
				}else{
					$folder_name =array('image','personal_repo');
				}
				foreach($folder_name as $name){		
					$dir->create('files'.DS.$lastMemId.DS.$name);
				}
				
				$memDetails = $this->Member->findById($lastMemId);
				
				if($saved){
					$emailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>7)));
					$emailData=$emailTemplate['EmailTemplate']['description'];						
					$emailData=str_replace(array('{name}','{last_name}','{email}','{password}'),array($memDetails['Member']['first_name'],$memDetails['Member']['last_name'],$memDetails['Member']['email'],$this->data['Member']['fpassword']),$emailData);							
					$emailTo=$memDetails['Member']['email'];
					$emailFrom=$emailTemplate['EmailTemplate']['email_from'];
					$emailSubject=$emailTemplate['EmailTemplate']['subject'];
					$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);
					
				}
				$this->Session->write('SuccessMessage','Student added successfully.');			
				$this->redirect(array('action'=>'student','admin'=>true));
			}else {
				$this->set('error',$error);
			}
		}
	}	
	function admin_add_instructor()
	{
		$this->layout="admin";
		
		$title_for_layout=':: Tambark ::';		
		//---------------------------------------------Load Model------------------------------
			$this->loadModel('Country');
			$this->loadModel('Member');
			$this->loadModel('VideoLink');
		//---------------------------------------------End Load Model------------------------------
		
		$country_list=$this->Country->find('all');
		$country_list=Set::combine($country_list,'{n}.Country.id','{n}.Country.country_name');		
		$this->set(compact('title_for_layout','country_list'));
		
		$lastMemberDetail=$this->Member->find('first',array('order'=>'Member.id desc'));
		
		$error = array();
		if(!empty($this->data))
		{
			$error = $this->validate_add_profile_steps($this->data);					
			$data = $this->data;
			if(isset($lastMemberDetail['Member']['unique_id']) || empty($lastMemberDetail))
			{
				if(empty($lastMemberDetail)){
					$data['Member']['unique_id'] = 1000;
				}elseif($lastMemberDetail['Member']['unique_id']==''){
					$data['Member']['unique_id'] = 1000;
				}else{
					$data['Member']['unique_id'] = $lastMemberDetail['Member']['unique_id'] +1;
				}
			}
			
			
			if(count($error) == "0"){
				$data['Member']['password'] = md5($this->data['Member']['fpassword']);
				$saved = $this->Member->save($data);
				$lastMemId = $this->Member->getLastInsertId($data);
				
				App::uses('Folder','Utility');
				$dir = new Folder();
				if($data['Member']['member_type'] == '2'){
					$folder_name =array('personal_repo');
				}else{
					$folder_name =array('image','personal_repo');
				}
				foreach($folder_name as $name){		
					$dir->create('files'.DS.$lastMemId.DS.$name);
				}
				
				
				$memDetails = $this->Member->findById($lastMemId);
				
				if($saved)
				{
					$emailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>7)));
					$emailData=$emailTemplate['EmailTemplate']['description'];						
					$emailData=str_replace(array('{name}','{last_name}','{email}','{password}'),array($memDetails['Member']['first_name'],$memDetails['Member']['last_name'],$memDetails['Member']['email'],$this->data['Member']['fpassword']),$emailData);							
					
					$emailTo=$memDetails['Member']['email'];
					$emailFrom=$emailTemplate['EmailTemplate']['email_from'];
					$emailSubject=$emailTemplate['EmailTemplate']['subject'];
					$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);
					
				}
				$this->Session->write('SuccessMessage','Instructor added successfully.');			
				$this->redirect(array('action'=>'teacher','admin'=>true));
			}else {
				$this->set('error',$error);
			}
		}
	}	
	function validate_add_profile_ajax()
	{
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())	{
			$errors_msg = null;
			$errors=$this->validate_add_profile_steps($this->data);					
			if ( is_array ( $this->data )){
				foreach ($this->data['Member'] as $key => $value ){
					if( array_key_exists ( $key, $errors) )	{
						foreach ( $errors [ $key ] as $k => $v ){
							$errors_msg .= "error|$key|$v";
						}	
					}
					else {
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}	
	}
	
	function validate_add_profile_steps($data)
	{			
		$errors = array ();
		if(isset($data['Member']['first_name'])){
			if(trim($data['Member']['first_name'])=="")	{
				$errors ['first_name'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['first_name'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Member']['last_name'])){
			if(trim($data['Member']['last_name'])=="")	{
				$errors ['last_name'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['last_name'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		
		if (trim($data['Member']['email'])=="")
		{
			$errors ['email'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		elseif(trim($data['Member']['email'])!="")
		{
			
			$checkEmail=explode('@',$data['Member']['email']);
			$checkexistEmail=$this->Member->find('count',array('conditions'=>array('email'=>$data['Member']['email'])));
			
			if($this->validEmail($data['Member']['email'])=='false')
				$errors ['email'] [] = __(INVALID_EMAIL,true)."\n";
			elseif($checkexistEmail>0)
			{
				$errors ['email'] [] = __(EMAIL_EXISTS,true)."\n";	
			}
		}
		
		if (trim($data['Member']['fpassword'])=="")
		{
			$errors ['fpassword'] [] = __(FIELD_REQUIRED,true)."\n";
		}			
		if (trim($data['Member']['Cpassword'])=="")
		{
			$errors ['Cpassword'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		elseif(trim($data['Member']['fpassword'])!=trim($data['Member']['Cpassword']))
		{
			$errors ['Cpassword'] [] = __(PASSWORD_MATCH,true)."\n";
		}
		elseif(strlen($data['Member']['Cpassword'])<6)
		{
			$errors ['Cpassword'] [] = __(PASSWORD_LENGTH_VALIDATION,true)."\n";
		}
		
		if(isset($data['Member']['zipcode'])){
			if(trim($data['Member']['zipcode'])=="")	{
				$errors ['zipcode'] [] = __(FIELD_REQUIRED,true)."\n";
			}
		}
		else{
			$errors ['zipcode'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		
		return $errors;			
	}
	
//-----------------------------------------------------------End of	Instructor add profile----------------------------

//-----------------------------------------------------------Instructor Edit Profile----------------------------------
	function admin_edit_instructor($m_id=NULL)
	{
		$this->layout="admin";
		
		$title_for_layout=':: Tambark ::';		
		//---------------------------------------------Load Model------------------------------
			$this->loadModel('Country');
			$this->loadModel('Member');
			$this->loadModel('VideoLink');
			$this->loadModel('MemberCategory');
			
		//---------------------------------------------End Load Model------------------------------
		$id = convert_uudecode(base64_decode($m_id));
		$login_member_details=$this->Member->find('first',array('conditions'=>array('Member.id'=>$id),'recursive'=>2));
		//pr($login_member_details);die;
		
		if(!empty($login_member_details['VideoLink'])) { 
			$i=1;
			$j=1;
			foreach($login_member_details['VideoLink'] as $link){
				if($link['image']!='')
				$i++;
			}
			foreach($login_member_details['VideoLink'] as $video){
				if($video['video_link'])
				$j++;
			}
		}
		
		$country_list=$this->Country->find('all');
		$country_list=Set::combine($country_list,'{n}.Country.id','{n}.Country.country_name');		
		
		$category_list=$this->Category->find('all',array('conditions'=>array('Category.status'=>1)));
		$category_list=Set::combine($category_list,'{n}.Category.id','{n}.Category.name');
				
		$sub_category_list=$this->SubCategory->find('all',array('conditions'=>array('SubCategory.status'=>1)));
		$sub_category_list=Set::combine($sub_category_list,'{n}.SubCategory.id','{n}.SubCategory.name');
		
		if(isset($login_member_details['MemberCategory'][0]['cate_id']))
		{	
			if(!empty($login_member_details['MemberCategory'][0]['cate_id']))
			{	
				$sub_category_id = $this->MemberCategory->find('all',array('conditions'=>array('MemberCategory.cate_id'=>$login_member_details['MemberCategory'][0]['cate_id'],'MemberCategory.m_id'=>$id)));
				
				$show_sub_cate = array();
				foreach($sub_category_id as $sub_category_id){ 
					
					$show_sub_cate[] = $sub_category_id['MemberCategory']['sub_cate_id'];
					
				}
				$this->set(compact('show_sub_cate'));
				
				$sub_category_list=$this->SubCategory->find('all',array('conditions'=>array('SubCategory.status'=>1,'SubCategory.c_id'=>$login_member_details['MemberCategory'][0]['cate_id'])));
				$sub_category_list=Set::combine($sub_category_list,'{n}.SubCategory.id','{n}.SubCategory.name');
			}
		}
		if(!empty($login_member_details['Member']['cate_id'])){
			$sub_category=$this->SubCategory->find('all',array('conditions'=>array('SubCategory.status'=>1,'SubCategory.c_id'=>$login_member_details['Member']['cate_id'])));
			$sub_category=Set::combine($sub_category,'{n}.SubCategory.id','{n}.SubCategory.name');
			$this->set(compact('sub_category'));
		}
		$this->set(compact('title_for_layout','country_list','login_member_details','category_list','sub_category_list','i','j'));
		
		if(!empty($this->data))
		{
			$errors = array();
			$errors = $this->validate_edit_profile_steps($this->data);					
			if(count($errors) == "0"){
				$data = $this->data;
				
				$login_member_details = $this->Member->findById($data['Member']['id']);
				
				if(isset($data['Member']['image'])){
					if($data['Member']['image']['name']!=''){
						$imgName = pathinfo($data['Member']['image']['name']);			
						$ext = strtolower($imgName['extension']);					
						if($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif'){					
							$destination = realpath('../../app/webroot/files').'/'.$data['Member']['id'].'/';
							$filename = time().'-'.$data['Member']['image']['name'];
							$old_image = $login_member_details['Member']['image'];
							$file = $this->data['Member']['image'];
							$result1 = $this->Upload->upload($file, $destination, $filename, array());
							$data['Member']['image']=$filename;						
							if($result1 && !empty($old_image) && file_exists('files/'.$data['Member']['id'].'/'.$old_image)){					
								unlink('../files/'.$data['Member']['id'].'/'.$old_image);
							}
						}					
					}
					else
					{
						$data['Member']['image']=$login_member_details['Member']['image'];
					}	
				}
				$this->MemberCategory->deleteAll(array('MemberCategory.m_id'=>$data['Member']['id']));
				foreach($data['Member']['sub_cate_id'] as $subCate)
				{
					$subCategory['MemberCategory']['m_id'] = $data['Member']['id'];
					$subCategory['MemberCategory']['cate_id'] = $data['Member']['cate_id'];
					$subCategory['MemberCategory']['sub_cate_id'] =$subCate;
					$this->MemberCategory->create();
					$this->MemberCategory->save($subCategory);
				}
			
				if($data['Member']['other_sub_cat']==1)
				{	
					$data['Member']['cate_id'] = $data['Member']['cate_id'];
					$data['Member']['sub_category_name'] = $data['Member']['sub_category_name'];
				}elseif($data['Member']['other_sub_cat']==0){
					$data['Member']['sub_category_name'] = "";
				}
				
				$this->Member->save($data);	
				$this->Session->write('SuccessMessage','Profile updated successfully.');			
				$this->redirect(array('action'=>'teacher','admin'=>true));
			}else{
				
				$this->set('errors',$errors);
			}
		}	
	}
	function validate_edit_profile_ajax()
	{
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())	{
			$errors_msg = null;
			$errors=$this->validate_edit_profile_steps($this->data);					
			if ( is_array ( $this->data ) )	{
				foreach ($this->data['Member'] as $key => $value ){
					if( array_key_exists ( $key, $errors) )	{
						foreach ( $errors [ $key ] as $k => $v ){
							$errors_msg .= "error|$key|$v";
						}	
					}
					else {
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}	
	}
	
	function validate_edit_profile_steps($data)
	{			
		//pr($data);die;
		$errors = array ();
			
		if(isset($data['Member']['first_name'])){
			if(trim($data['Member']['first_name'])=="")	{
				$errors ['first_name'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['first_name'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Member']['last_name'])){
			if(trim($data['Member']['last_name'])=="")	{
				$errors ['last_name'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['last_name'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		
		if(isset($data['Member']['cate_id'])){
			if(trim($data['Member']['cate_id'])=="")	{
				$errors ['cate_id'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['cate_id'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		
		if(isset($data['Member']['image'])) { 
			if(is_array($data['Member']['image'])){ 
								 
				if($data['Member']['image']['name']!='')
				{ 	
					$fileName = pathinfo($data['Member']['image']['name']);			
					$ext = strtolower($fileName['extension']);		
					if($ext=='jpeg' || $ext=='jpg' || $ext=='gif' || $ext=='png')
					{	
					}else{
						$errors ['image'] [] = __('Please check file extension',true)."\n";
						
					}
				}
			}			
		}
		
		if(empty($data['Member']['sub_category_name']) && !isset($data['Member']['sub_category_name'])){
			if(isset($data['Member']['sub_cate_id'])){
				if(isset($data['Member']['sub_cate_id'][0])){
					if($data['Member']['sub_cate_id'][0]=="")	{
						$errors ['sub_cate_id'] [] = __(FIELD_REQUIRED,true)."\n";
					}			
				}else{
					$errors ['sub_cate_id'] [] = __(FIELD_REQUIRED,true)."\n";
				}
			}
			else{
				$errors ['sub_cate_id'] [] = __(FIELD_REQUIRED,true)."\n";
			}
		}
		
		if($data['Member']['other_sub_cat']=='1')
		{
			if(empty($data['Member']['sub_category_name']))
			{
				$errors ['sub_category_name'] [] = __(FIELD_REQUIRED,true)."\n";
			}
		}
		
		
		if(isset($data['Member']['country'])){
			if(trim($data['Member']['country'])=="")	{
				$errors ['country'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['country'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Member']['state'])){
			if(trim($data['Member']['state'])=="")	{
				$errors ['state'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['state'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		
		if(isset($data['Member']['city'])){
			if(trim($data['Member']['city'])=="")	{
				$errors ['city'] [] = __(FIELD_REQUIRED,true)."\n";
			}
		}
		else{
			$errors ['city'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		
		if(isset($data['Member']['zipcode'])){
			if(trim($data['Member']['zipcode'])=="")	{
				$errors ['zipcode'] [] = __(FIELD_REQUIRED,true)."\n";
			}
		}
		else{
			$errors ['zipcode'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if($data['Member']['phone']!=''){
			if($data['Member']['phone']!='' && !ctype_digit($data['Member']['phone'])){
				$errors	['phone'][] = __(NUMERIC_VALUE_ONLY,true)."\n";
			}
			elseif($data['Member']['phone']!='' && strlen($data['Member']['phone'])!='10'){
				$errors	['phone'][] = __(TEN_DIGIT_LIMIT,true)."\n";
			}
		}
		
		if(isset($data['Member']['hourly_rate'])){
			
			if($data['Member']['hourly_rate']!='' && !ctype_digit($data['Member']['hourly_rate'])){
				$errors	['hourly_rate'][] = __(NUMERIC_VALUE_ONLY,true)."\n";
			}
		}
		if(isset($data['Member']['experience'])){
			if(trim($data['Member']['experience'])=="")	{
				$errors ['experience'] [] = __(FIELD_REQUIRED,true)."\n";
			}
		}
		else{
			$errors ['experience'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		
		if(isset($data['Member']['objective'])){
			if(trim($data['Member']['objective'])=="")	{
				$errors ['objective'] [] = __(FIELD_REQUIRED,true)."\n";
			}
		}
		else{
			$errors ['objective'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		
		
		
		
		if(isset($data['Member']['primary_services'])){
			if(trim($data['Member']['primary_services'])=="")	{
				$errors ['primary_services'] [] = __(FIELD_REQUIRED,true)."\n";
			}
		}
		else{
			$errors ['primary_services'] [] = __(FIELD_REQUIRED,true)."\n";
		}	
		if(isset($data['Member']['additional_information'])){
			if(trim($data['Member']['additional_information'])=="")	{
				$errors ['additional_information'] [] = __(FIELD_REQUIRED,true)."\n";
			}
		}
		else{
			$errors ['additional_information'] [] = __(FIELD_REQUIRED,true)."\n";
		}			
		return $errors;			
	}
	
	//-----upload images-
	
	function admin_upload_link_video()
	{
		$m_id = base64_encode(convert_uuencode($this->data['VideoLink']['mem_id']));
			if(!empty($this->data)){
			$data = $this->data;
			$error= array();
				$this->loadModel('VideoLink');
			
			//----------------------------------------VALIDATION-----------------
			
			if(isset($this->data['VideoLink']['picture']))
			{
				
				$new_images=count($this->data['VideoLink']['picture']);
				$limit = $this->VideoLink->find('count',array('conditions'=>array('VideoLink.m_id'=>$this->data['VideoLink']['mem_id'],'VideoLink.type'=>"2")));
				if(($limit+$new_images)>5){
					$error ['picture'] [] = __('Only 4 pictures allowed!',true)."\n";
				}
			}
			//------------------------------------------END END OF VALIDTION---------------------------
			if(count($error)==0){
				
				if($this->data['VideoLink']['picture'][0]['name']!=''){
					$destination = realpath('../../app/webroot/files').'/'.$data['VideoLink']['mem_id'].'/image/';
					for($j=0; $j<=count($this->data['VideoLink']['picture'])-1; $j++)
					{		
						if(!empty($this->data['VideoLink']['picture'][$j]['name']))
						{	
							$file['picture'][$j]['name'] = $this->data['VideoLink']['picture'][$j]['name'];	
							$file['picture'][$j]['type'] =	$this->data['VideoLink']['picture'][$j]['type'];	
							$file['picture'][$j]['tmp_name'] = $this->data['VideoLink']['picture'][$j]['tmp_name'];	
							$file['picture'][$j]['error'] = $this->data['VideoLink']['picture'][$j]['error'];	
							$file['picture'][$j]['size'] = $this->data['VideoLink']['picture'][$j]['size'];	
						}
					}				
					
					for($i=0; $i<count($file['picture']); $i++)
					{	
						$imgName = pathinfo($file['picture'][$i]['name']);
						$ext = strtolower($imgName['extension']);
						
						if($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif')
						{						
							$newImgName = 'image'.$i.'-'.time().".".$ext;						
							$image = $file['picture'][$i];
							$result = $this->Upload->upload($image, $destination, $newImgName, array());												
							
							if($result)
							{
								$data['VideoLink']['m_id'] = $this->data['VideoLink']['mem_id'];
								$data['VideoLink']['type'] = "2";
								$data['VideoLink']['image'] = $newImgName;							
								$data['VideoLink']['video_link'] ="";
								$this->VideoLink->create();
								$this->VideoLink->save($data);
							}
						}
					}
				}
							
				$this->Session->write('SuccessMessage','Profile has been updated successfully.');
				$this->redirect(array('action'=>'teacher','admin'=>true));
			
			}
			else{
				
				if(isset($error['picture'][0]))
				{
					$this->Session->write('ErrorMessage2',$error['picture'][0]);
				}
				$this->redirect(array('action'=>'edit_instructor/'.$m_id.'/#tabs2','admin'=>true));
			}
		}
	}
	//------------------------edit link----------------------------------------
	function admin_upload_link()
	{
		$this->loadModel('VideoLink');
		$errors= array();
		
		
		if(!empty($this->data))
		{
			$errors = $this->validate_edit_link_steps($this->data);
			$data = $this->data;
			if(count($errors) == 0){
				foreach($data['VideoLink']['video_link'] as $link )
				{	
						
					if(!empty($link)){
						$dataVideoLink['VideoLink']['m_id'] = $this->data['VideoLink']['mem_id'];
						$videoName = str_replace(array('/watch?','='),'/',$link);
						$dataVideoLink['VideoLink']['video_link'] = trim($videoName);
						$dataVideoLink['VideoLink']['type'] = "1";
						$dataVideoLink['VideoLink']['image']="NULL";
						$this->VideoLink->create();
						$this->VideoLink->save($dataVideoLink);
					}
				}
				
				$this->Session->write('SuccessMessage','Profile has been updated successfully.');
				$this->redirect(array('action'=>'teacher','admin'=>true));
			}
		}else{
			$this->set('errors',$errors);
		}
	}
	function validate_edit_link_ajax()
	{
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())	{
			$errors_msg = null;
			$errors=$this->validate_edit_link_steps($this->data);					
			if ( is_array ( $this->data ) )	{
				foreach ($this->data['VideoLink'] as $key => $value ){
					if( array_key_exists ( $key, $errors) )	{
						foreach ( $errors [ $key ] as $k => $v ){
							$errors_msg .= "error|$key|$v";
						}	
					}
					else {
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}	
	}
	
	function validate_edit_link_steps($data)
	{	
		$this->loadModel('VideoLink');
		
		$errors = array ();
		if (trim($data['VideoLink']['video_link'][0])=="")
		{
			$errors ['video_link'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['VideoLink']['video_link']))
		{	
			foreach($data['VideoLink']['video_link'] as $link) 
			{ 	
			
				if (!empty($link) && !preg_match('@^(?:http://(?:www\.)?youtube.com/)(watch\?v=|v/)([a-zA-Z0-9_]*)@', $link)) 
				{
					
					$errors ['video_link'] [] = __('Please enter valid youtube url.',true)."\n";
				} 
			}
			$limit = $this->VideoLink->find('count',array('conditions'=>array('VideoLink.m_id'=>$this->data['VideoLink']['mem_id'],'VideoLink.type'=>"1")));
			$insert_lilmit = count($data);
			
			if($limit+$insert_lilmit > 4 && trim($data['VideoLink']['video_link'][0])==""){
				$errors ['video_link'] [] = __(FIELD_REQUIRED,true)."\n";
			}elseif($limit+$insert_lilmit > 4)
			{
				$errors ['video_link'] [] = __('Only 4 Links Allowed!.',true)."\n";
			}
		}		
		return $errors;			
	}
	//------------------------------End of Instructor Edit profile-------------
	//------------------------------Instructor View Profile--------------------
	function admin_view_instructor($id=NULL)
	{
		$this->layout="admin";
		
		$id = convert_uudecode(base64_decode($id));
		$subCategory=array();
		$this->Member->Behaviors->attach('Containable');
		$info = $this->Member->find('first',array('conditions'=>array('Member.id'=>$id),'contain'=>array('MemberCategory'=>array('SubCategory.name'),'Country','VideoLink','Category.name')));
		//pr($info);die;
		if(file_exists('files/'. $info['Member']['id'])){
			App::uses('Folder','Utility');
			$dir = new Folder('files/'. $info['Member']['id']);
			$mem_used_in_bytes = $dir->dirSize();
			
			$mem_limit = 5368709120; // Limit 5GB
			$base = log($mem_used_in_bytes) / log(1024);
			$suffixes = array('byte', 'KB', 'MB', 'GB');   
			
			$mem_used_in_per = round(($mem_used_in_bytes/$mem_limit)*100,2);
			if($mem_used_in_bytes > 0){
				$mem_used = round(pow(1024, $base - floor($base)), 2) .' '. $suffixes[floor($base)];
			}else{
				$mem_used = $mem_used_in_bytes .' '. $suffixes[floor($base)];
			}
			
			$memory_limit_for_user = $info['Member']['member_type'] = 1 ? 5 : 2;
			$mem_used = 'Using '.$mem_used.' of your '.$memory_limit_for_user.' GB';
		}
		else{
			$mem_used='';
			$mem_used_in_per='';
		}
		
		$this->set(compact('info','mem_used','mem_used_in_per'));
	}
	//------------------------------End of Instructor View profile-------------
	//------------------------------contact-us listing-------------------------
	function admin_contacts()
	{
		
		$this->layout='admin';
		$this->loadModel('Contact');
		
		$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Contact.id DESC'); 
		$info=$this->paginate('Contact');
		$this->set(compact('info','page'));
		
		if($this->RequestHandler->isAjax()){
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath='Elements'.DS.'adminElements/cmsPages';
			$this->render('contact_list');
		}
	}
	function admin_view_contact_us($id=NULL)
	{
		$this->layout='admin';
		$this->loadModel('Contact');
		
		
		$id = convert_uudecode(base64_decode($id));
		$info = $this->Contact->find('first',array('conditions'=>array('Contact.id'=>$id)));
		$this->set(compact('info'));
	}
	//------------------------------End of contact-us listing-----------------
	//-------------------------------Manage Categories------------------------
	function admin_categories()
	{
		$this->layout='admin';
		$this->loadModel('Category');		
		$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		
		
		$this->paginate = array('limit'=>$this->pageLimit,'order'=>'Category.id DESC','recursive'=>'-1');
		$info=$this->paginate('Category');
		$this->set(compact('info','page'));
		
		if($this->RequestHandler->isAjax())
		{	
			 $this->layout="";
			 $this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			 $this->render('categories_list');
		}
	}
	function admin_add_categories()
	{
		
		$this->layout="admin";
		$title_for_layout=':: Tambark ::';		
		//---------------------------------------------Load Model------------------------------
			$this->loadModel('Category');
		//---------------------------------------------End Load Model------------------------------
		$error = array();
		if(!empty($this->data))
		{
			$error = $this->validate_add_categories_steps($this->data);					
			$data = $this->data;
			if(count($error) == "0"){
				
				$data['Category']['date'] = date('Y-m-d');
				$data['Category']['status'] = "1";
				$this->Category->save($data);	
				$this->Session->write('SuccessMessage','Category added successfully.');			
				$this->redirect(array('action'=>'categories','admin'=>true));
			}else {
				$this->set('error',$error);
			}
		}
	} 
	function validate_add_categories_ajax()
	{
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())	{
			$errors_msg = null;
			$errors=$this->validate_add_categories_steps($this->data);					
			if ( is_array ( $this->data ) )	{
				foreach ($this->data['Category'] as $key => $value ){
					if( array_key_exists ( $key, $errors) )	{
						foreach ( $errors [ $key ] as $k => $v ){
							$errors_msg .= "error|$key|$v";
						}	
					}
					else {
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}	
	}
	
	function validate_add_categories_steps($data)
	{			
		$errors = array ();
			
		if(isset($data['Category']['name'])){
			if(trim($data['Category']['name'])=="")	{
				$errors ['name'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		if(trim($data['Category']['name'])!='')
		{
			if($this->validCategory($data['Category']['name'])=='false')
			{
				$errors ['name'] [] = __(CATEGROY_EXISTS,true)."\n";
			}
		}
		return $errors;			
	}
	
	
	function admin_edit_categories($id=NULL)
	{
		$this->layout="admin";
		$title_for_layout=':: Tambark ::';		
		$id = convert_uudecode(base64_decode($id));
		
		$info = $this->Category->findById($id);
		$this->set(compact('info'));
		
		$error = array();
		if(!empty($this->data))
		{
			$error = $this->validate_edit_categories_ajax($this->data);					
			$data = $this->data;
			if(count($error) == "0"){
				
				$data['Category']['id'] = $data['Category']['id'];
				$data['Category']['date'] = date('Y-m-d');
				$this->Category->save($data);	
				$this->Session->write('SuccessMessage','Category edited successfully.');			
				$this->redirect(array('action'=>'categories','admin'=>true));
			}else {
				$this->set('error',$error);
			}
		}
	}
	
	function validate_edit_categories_ajax()
	{
		
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())	{
			$errors_msg = null;
			$errors=$this->validate_edit_categories_steps($this->data);					
			if ( is_array ( $this->data ) )	{
				foreach ($this->data['Category'] as $key => $value ){
					if( array_key_exists ( $key, $errors) )	{
						foreach ( $errors [ $key ] as $k => $v ){
							$errors_msg .= "error|$key|$v";
						}	
					}
					else {
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}	
	
	}
	function validate_edit_categories_steps($data)
	{			
		$errors = array ();
			
		if(isset($data['Category']['name'])){
			if(trim($data['Category']['name'])=="")	{
				$errors ['name'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		return $errors;			
	}	
	//--------------------------------End of Manage category--------------------
	//--------------------------------Manage Sub-category----------------------
	function admin_sub_categories()
	{
		$this->layout='admin';
		$this->loadModel('SubCategory');
		$this->loadModel('Category');
				
		$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		
		$category_list = $this->Category->find('all');
		$category_list = Set::combine($category_list,'{n}.Category.id','{n}.Category.name');
				
		if(!$this->request->is('ajax'))
		{
			$this->Session->delete('SubCategory.c_id');
			$this->Session->delete('SubCategory.name');
			$this->Session->delete('searchConditions');
		}
		
		$error = array();
		
		if(!empty($this->data))
		{
			//$error = $this->validate_search_sub_categories_steps($this->data);
			
			$conditions = array();
			
			if(count($error) == "0")
			{
				if(!empty($this->data['SubCategory']['c_id']))
				{
					$conditions = array_merge($conditions,array('SubCategory.c_id'=>$this->data['SubCategory']['c_id']));
					$this->Session->write('SubCategory.c_id',$this->data['SubCategory']['c_id']);
				}
				
				if(!empty($this->data['SubCategory']['name']))
				{
					$conditions = array_merge($conditions,array('SubCategory.name LIKE'=>'%'.$this->data['SubCategory']['name'].'%'));
					$this->Session->write('SubCategory.name',$this->data['SubCategory']['name']);
				}
			
				$this->Session->write('searchConditions',$conditions);
			}
		}
		
		if($this->Session->read('searchConditions'))
		{		
			$searchConditions = $this->Session->read('searchConditions');
		}
		else
		{
			$searchConditions = array();
		}
		
		$this->paginate = array('limit'=>$this->pageLimit,'order'=>'SubCategory.id DESC');
		$info=$this->paginate('SubCategory',$searchConditions);
		$this->set(compact('info','page','category_list'));
		
		if($this->RequestHandler->isAjax())
		{
			 $this->layout = "";
			 $this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			 $this->render('sub_categories_list');
		}
	}
	
	
	function admin_add_sub_categories()
	{
		
		$this->layout="admin";
		$title_for_layout=':: Tambark ::';		
		//---------------------------------------------Load Model------------------------------
		$this->loadModel('SubCategory');
		//---------------------------------------------End Load Model------------------------------
		
		$category_list=$this->Category->find('all');
		$category_list=Set::combine($category_list,'{n}.Category.id','{n}.Category.name');		
		$this->set(compact('category_list'));
		
		$error = array();
		if(!empty($this->data))
		{	
			$error = $this->validate_add_sub_categories_steps($this->data);					
			$data = $this->data;
			if(count($error) == "0"){
				$data['SubCategory']['date'] = date('Y-m-d');
				$data['SubCategory']['status'] = "1";
				$this->SubCategory->save($data);	
				$this->Session->write('SuccessMessage','Sub-category added successfully.');			
				$this->redirect(array('action'=>'sub_categories','admin'=>true));
			}else {
				$this->set('error',$error);
			}
		}
	} 
	function validate_add_sub_categories_ajax()
	{
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())	{
			$errors_msg = null;
			$errors=$this->validate_add_sub_categories_steps($this->data);					
			if ( is_array ( $this->data ) )	{
				foreach ($this->data['SubCategory'] as $key => $value ){
					if( array_key_exists ( $key, $errors) )	{
						foreach ( $errors [ $key ] as $k => $v ){
							$errors_msg .= "error|$key|$v";
						}	
					}
					else {
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}	
	}
	
	function validate_add_sub_categories_steps($data)
	{			
		$errors = array ();
		if(isset($data['SubCategory']['c_id'])){
			if(trim($data['SubCategory']['c_id'])=="")	{
				$errors ['c_id'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		if(isset($data['SubCategory']['name'])){
			if(trim($data['SubCategory']['name'])=="")	{
				$errors ['name'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		if(trim($data['SubCategory']['name'])!='')
		{
			if($this->validSubCategory($data['SubCategory']['c_id'],$data['SubCategory']['name'])=='false')
			{
				$errors ['name'] [] = __(SUB_CATEGROY_EXISTS,true)."\n";
			}
		}
		return $errors;			
	}
	
	function admin_edit_sub_categories($id=NULL)
	{
		$this->layout="admin";
		$title_for_layout=':: Tambark ::';		
		$id = convert_uudecode(base64_decode($id));
		
		$category_list=$this->Category->find('all');
		$category_list=Set::combine($category_list,'{n}.Category.id','{n}.Category.name');		
		$this->set(compact('category_list'));
		
		$info = $this->SubCategory->findById($id);
		$this->set(compact('info'));
		
		$error = array();
		if(!empty($this->data))
		{
			$error = $this->validate_edit_sub_categories_steps($this->data);					
			$data = $this->data;
			if(count($error) == "0"){
				
				$data['SubCategory']['id'] = $data['SubCategory']['id'];
				$data['SubCategory']['date'] = date('Y-m-d');
				$this->SubCategory->save($data);	
				$this->Session->write('SuccessMessage','Sub-category edited successfully.');			
				$this->redirect(array('action'=>'sub_categories','admin'=>true));
			}else {
				$this->set('error',$error);
			}
		}
	}
	
	function validate_edit_sub_categories_ajax()
	{
		
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())	{
			$errors_msg = null;
			$errors=$this->validate_edit_sub_categories_steps($this->data);					
			if ( is_array ( $this->data ) )	{
				foreach ($this->data['SubCategory'] as $key => $value ){
					if( array_key_exists ( $key, $errors) )	{
						foreach ( $errors [ $key ] as $k => $v ){
							$errors_msg .= "error|$key|$v";
						}	
					}
					else {
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}	
	}
	function validate_edit_sub_categories_steps($data)
	{
		$errors = array ();
		if(isset($data['SubCategory']['name'])){
			if(trim($data['SubCategory']['name'])=="")	{
				$errors ['name'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		if(isset($data['SubCategory']['c_id'])){
			if(trim($data['SubCategory']['c_id'])=="")	{
				$errors ['c_id'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		return $errors;
	}
	//---------------------------------End of Manage Sub-category----------------
	function remove_photo($en_id=NULL,$memId=NULL)
	{
		$this->loadModel('VideoLink');
		
		$id = convert_uudecode(base64_decode($en_id));
		$delId = convert_uudecode(base64_decode($memId));
		$record=$this->VideoLink->findById($id);
		if(!empty($record)){
			$this->VideoLink->delete($id);
			if($record['VideoLink']['image']!='' && file_exists('files'.'/'.$delId.'/image/'.$record['VideoLink']['image'])){
			unlink('files'.'/'.$delId.'/image/'.$record['VideoLink']['image']);
				 
			}
			$this->Session->write('SuccessMessage','Record deleted Successfully.');
			$this->redirect(array('controller'=>'Users','action'=>'edit_instructor/'.$memId.'/#tabs2','admin'=>true));
		}
		else{
			$this->redirect(array('controller'=>'Users','action'=>'edit_instructor/'.$memId.'/#tabs2','admin'=>true));
		}
	}
	function remove_video($en_id=NULL,$memId=NULL)
	{
		$this->loadModel('VideoLink');
		
		$id = convert_uudecode(base64_decode($en_id));
		$record=$this->VideoLink->findById($id);
		if(!empty($record)){
			$this->VideoLink->delete($id);
			$this->Session->write('SuccessMessage','Record Deleted Successfully.');
			$this->redirect(array('controller'=>'Users','action'=>'edit_instructor/'.$memId.'/#tabs3','admin'=>true));
		}
		else{
			$this->redirect(array('controller'=>'Users','action'=>'edit_instructor/'.$memId.'/#tabs3','admin'=>true));
		}
	}
	function admin_watch_video($id=NULL)
	{
		$this->layout="admin";
		
		$this->loadModel('VideoLink');
		$id=convert_uudecode(base64_decode($id));
		$video=$this->VideoLink->findById($id);
		if(!empty($video)){
			$this->set('video',$video);
		}
		else{
			$this->redirect(array('action'=>'edit_instructor','admin'=>true));
		}
	
	}
	//------------------------------Student View Profile--------------------
	function admin_view_student($id=NULL)
	{
		$this->layout="admin";
		$id = convert_uudecode(base64_decode($id));
		
		$info = $this->Member->findById($id);
		
		if(file_exists('files/'. $info['Member']['id'])){
			App::uses('Folder','Utility');
			$dir = new Folder('files/'. $info['Member']['id']);
			$mem_used_in_bytes = $dir->dirSize();
			
			$mem_limit = 5368709120; // Limit 5GB
			$base = log($mem_used_in_bytes) / log(1024);
			$suffixes = array('byte', 'KB', 'MB', 'GB');   
			
			$mem_used_in_per = round(($mem_used_in_bytes/$mem_limit)*100,2);
			if($mem_used_in_bytes > 0){
				$mem_used = round(pow(1024, $base - floor($base)), 2) .' '. $suffixes[floor($base)];
			}else{
				$mem_used = $mem_used_in_bytes .' '. $suffixes[floor($base)];
			}
			
			$memory_limit_for_user = $info['Member']['member_type'] = 1 ? 5 : 2;
			$mem_used = 'Using '.$mem_used.' of your '.$memory_limit_for_user.' GB';
		}
		else{
			$mem_used='';
			$mem_used_in_per='';
		}
		
		$this->set(compact('info','mem_used','mem_used_in_per'));
	}
	//------------------------------End of Instructor View profile-------------
	
	//-----------------------------------------------------------Student Edit Profile----------------------------------
	function admin_edit_student($id=NULL)
	{
		$this->layout = "admin";
		
		$title_for_layout = ':: Tambark ::';		
		//---------------------------------------------Load Model------------------------------
			$this->loadModel('Country');
			$this->loadModel('Member');
			$this->loadModel('VideoLink');
		//---------------------------------------------End Load Model------------------------------
		$id = convert_uudecode(base64_decode($id));
		$login_member_details = $this->Member->find('first',array('conditions'=>array('Member.id'=>$id)));
		//pr($login_member_details); die;	
		
		$country_list = $this->Country->find('all');
		$country_list = Set::combine($country_list,'{n}.Country.id','{n}.Country.country_name');
				
		$this->set(compact('title_for_layout','country_list','login_member_details','i','j'));
		//pr($this->data); die;	
		if(!empty($this->data))
		{
			$error = array();
			$error = $this->validate_edit_student_profile_steps($this->data);					
			if(count($error) == "0"){
				$data = $this->data;
				
				$login_member_details = $this->Member->findById($data['Member']['id']);
				
				if(isset($data['Member']['image'])){
					if($data['Member']['image']['name']!=''){
						$imgName = pathinfo($data['Member']['image']['name']);			
						$ext = strtolower($imgName['extension']);					
						if($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif'){					
							$destination = realpath('../../app/webroot/files').'/'.$data['Member']['id'].'/';
							$filename = time().'-'.$data['Member']['image']['name'];
							$old_image = $login_member_details['Member']['image'];
							$file = $this->data['Member']['image'];
							$result1 = $this->Upload->upload($file, $destination, $filename, array());
							$data['Member']['image'] = $filename;						
							if($result1 && !empty($old_image) && file_exists('files'.'/'.$data['Member']['id'].'/'.$old_image)){					
								unlink('files'.'/'.$data['Member']['id'].'/'.$old_image);
							}
						}					
					}
					else
					{
						$data['Member']['image'] = $login_member_details['Member']['image'];
					}	
				}
				
				$this->Member->save($data);	
				$this->Session->write('SuccessMessage','Profile updated successfully.');			
				$this->redirect(array('action'=>'student','admin'=>true));
			}else {
				//pr($error); die;
				$this->set('errors',$error);
			}
		}	
	}
	function validate_edit_student_profile_ajax()
	{
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())	{
			$errors_msg = null;
			$errors=$this->validate_edit_student_profile_steps($this->data);					
			if ( is_array ( $this->data ) )	{
				foreach ($this->data['Member'] as $key => $value ){
					if( array_key_exists ( $key, $errors) )	{
						foreach ( $errors [ $key ] as $k => $v ){
							$errors_msg .= "error|$key|$v";
						}	
					}
					else {
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}	
	}
	
	function validate_edit_student_profile_steps($data)
	{			
		$errors = array ();
			
		if(isset($data['Member']['first_name'])){
			if(trim($data['Member']['first_name'])=="")	{
				$errors ['first_name'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['first_name'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Member']['last_name'])){
			if(trim($data['Member']['last_name'])=="")	{
				$errors ['last_name'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['last_name'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Member']['street'])){
			if(trim($data['Member']['street'])=="")	{
				$errors ['street'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['street'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Member']['image'])) { 
			if(is_array($data['Member']['image'])){ 
								 
				if($data['Member']['image']['name']!='')
				{ 	
					$fileName = pathinfo($data['Member']['image']['name']);			
					$ext = strtolower($fileName['extension']);		
					if($ext=='jpeg' || $ext=='jpg' || $ext=='gif' || $ext=='png')
					{	
					}else{
						$errors ['image'] [] = __('Please check file extension',true)."\n";
						
					}
				}
			}			
		}
		if(isset($data['Member']['country'])){
			if(trim($data['Member']['country'])=="")	{
				$errors ['country'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['country'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Member']['state'])){
			if(trim($data['Member']['state'])=="")	{
				$errors ['state'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['state'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		
		if(isset($data['Member']['city'])){
			if(trim($data['Member']['city'])=="")	{
				$errors ['city'] [] = __(FIELD_REQUIRED,true)."\n";
			}
		}
		else{
			$errors ['city'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		
		if(isset($data['Member']['zipcode'])){
			if(trim($data['Member']['zipcode'])=="")	{
				$errors ['zipcode'] [] = __(FIELD_REQUIRED,true)."\n";
			}
		}
		else{
			$errors ['zipcode'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Member']['phone'])){
			if(trim($data['Member']['phone'])=="")	{
				$errors ['phone'] [] = __(FIELD_REQUIRED,true)."\n";
			}
			elseif($data['Member']['phone']!='' && !ctype_digit($data['Member']['phone'])){
				$errors	['phone'][] = __(NUMERIC_VALUE_ONLY,true)."\n";
			}
			elseif($data['Member']['phone']!='' && strlen($data['Member']['phone'])!='10'){
				$errors	['phone'][] = __(TEN_DIGIT_LIMIT,true)."\n";
			}
		}
		else{
			$errors ['phone'] [] = __(FIELD_REQUIRED,true)."\n";
		}	
					
		return $errors;			
	}
	
	//------FUNCTION FOR CHANGE STATUS OF MEMBER(ENABLE/DISABLE)-------------------------------------

	function admin_update_member_status($page=NULL,$id=NULL,$tableName=NULL,$renderPath=NULL,$renderElement=NULL)
	{
		$this->layout='';
		
		$this->loadModel("Event");
		$id=convert_uudecode(base64_decode($id));
		$tableName=base64_decode($tableName);
		$renderPath=base64_decode($renderPath);
		$renderElement=base64_decode($renderElement);		
		
		if($this->RequestHandler->isAjax()){		
			$this->layout=false;
			$this->autoRender = false;				
			$getRec = $this->$tableName->find('first',array('conditions'=>array($tableName.'.id'=>$id)));			
			$field=array();
			if(!empty($getRec)){
				if($getRec[$tableName]['status']=='0'){
					$this->$tableName->id=$id;					
					$field[$tableName]['status'] = 1;					
					$this->$tableName->save($field);
				}
				else{
					$this->$tableName->id=$id;					
					$field[$tableName]['status'] = '0';					
					$this->$tableName->save($field);					
				}
			}		   	
			$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC','conditions'=>array($tableName.'.member_type'=>$getRec['Member']['member_type']));
			$info = $this->paginate($tableName);
			$this->set(compact('info','page'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render($renderElement);			
		}		
	} 
	//------------------------------------------------------------END OF FUNCTION FOR CHANGE STATUS(ENABLE/DISABLE)--

	//------FUNCTION FOR DELETE SINGLE RECORD FROM MEMEBR TABLE-------------------------------------  

	/* function admin_delete_member_record($id=NULL)
	{
		$this->layout='';
		$this->loadModel('Member');
		$this->loadModel('Event');
		$this->loadModel('StudentApplyEvent');
		$this->loadModel('ContactAdmin');
		$this->loadModel('Broadcast');
		$this->loadModel('ContactInstructor');
		
		$id = convert_uudecode(base64_decode($id));
		
		if(!empty($id))
		{
			if($this->Member->delete($id)){
				$this->StudentApplyEvent->deleteAll(array('StudentApplyEvent.teacher_id'=>$id));
				$this->ContactAdmin->deleteAll(array('ContactAdmin.mem_id'=>$id));
				$this->Broadcast->deleteAll(array('Broadcast.m_id'=>$id));
				$this->ContactInstructor->deleteAll(array('ContactInstructor.teacher_id'=>$id));
				$this->Event->deleteAll(array('Event.t_id'=>$id));				
			}
			$this->Session->write('SuccessMessage','Record deleted successfully.');
			$this->redirect($this->referer());
		}
	} */
	
	function admin_delete_member_record($page=NULL,$d_id=NULL,$tableName=NULL,$renderPath=NULL,$renderElement=NULL,$mem=NULL)
	{
		$this->layout='';
		$this->loadModel('Contact');
		$this->loadModel('ContactAdmin');
		$this->loadModel('ContactInstructor');
		$this->loadModel('Member');
		$this->loadModel('StudentApplyEvent');
		$this->loadModel('Broadcast');
		$this->loadModel('Event');
		$this->loadModel('BroadcastStudent');
		$this->loadModel('Assignment');
		$this->loadModel('BroadcastRemark');
		$this->loadModel('Blog');
		$this->loadModel('BlogRemark');
		$this->loadModel('Promotion');
		$this->loadModel('StickyNote');
		$this->loadModel('StudentRepository');
		$this->loadModel('InstructorRepository');
		$this->loadModel('SendInvitation');
		$this->loadModel('Promotion');
		$this->loadModel('ClassRequestBlock');
		$this->loadModel('ContactInstructorStudent');
		$this->loadModel('InviteTeacher');
		$this->loadModel('InstructorAssignment');
		$this->loadModel('InstructorAssignmentStudent');
		$this->loadModel('InstructorAssignmentRemark');
		$this->loadModel('InstructorAssignmentDocument');
		$this->loadModel('SendInvitation');
				
		$d_id=convert_uudecode(base64_decode($d_id));
		$tableName=base64_decode($tableName);
		$renderPath=base64_decode($renderPath);
		$renderElement=base64_decode($renderElement);
		
		if($this->RequestHandler->isAjax())
		{		
			$this->layout=false;
			$this->autoRender = false;				
			$getRec = $this->$tableName->find('first',array('conditions'=>array($tableName.'.id'=>$d_id)));
			$id ='';
			$field=array();
			if(!empty($getRec))
			{
				$member_type=convert_uudecode(base64_decode($mem));
				$conditions=array('Member.member_type'=>$member_type);
				if($member_type== '1'){
					$this->SendInvitation->deleteAll(array('SendInvitation.t_id'=>$d_id),false);
					$this->StudentApplyEvent->deleteAll(array('StudentApplyEvent.teacher_id'=>$d_id));
					$this->ContactAdmin->deleteAll(array('ContactAdmin.mem_id'=>$d_id));
					$this->Broadcast->deleteAll(array('Broadcast.m_id'=>$d_id));
					$this->ContactInstructor->deleteAll(array('ContactInstructor.teacher_id'=>$id));
					$this->ContactInstructorStudent->deleteAll(array('ContactInstructorStudent.teacher_id'=>$d_id));
					
					$this->Blog->deleteAll(array('Blog.m_id'=>$d_id));
					$this->StickyNote->deleteAll(array('StickyNote.member_id'=>$d_id));
					$this->InstructorRepository->deleteAll(array('InstructorRepository.m_id'=>$d_id));	
					$this->SendInvitation->deleteAll(array('SendInvitation.t_id'=>$d_id));
					$this->Promotion->deleteAll(array('Promotion.member_id'=>$d_id));
					$this->ClassRequestBlock->deleteAll(array('ClassRequestBlock.m_id'=>$d_id));
					$this->InviteTeacher->deleteAll(array('InviteTeacher.member_id'=>$d_id));
					
					$findAllInstructorEvents = $this->Event->find('all',array('conditions'=>array('Event.t_id'=>$d_id)));
					foreach($findAllInstructorEvents as $records){	
						$assignments = $this->InstructorAssignment->find('all',array('conditions'=>array('InstructorAssignment.e_id'=>$records['Event']['id'])));					
						$this->InstructorAssignment->deleteAll(array('InstructorAssignment.e_id'=>$records['Event']['id']),false);
						foreach($assignments as $assignments){
							$assignmentsStudents = $this->InstructorAssignmentStudent->find('all',array('conditions'=>array('InstructorAssignmentStudent.inst_assign_id'=>$assignments['InstructorAssignment']['id'])));
							if(!empty($assignmentsStudents)){
								$this->InstructorAssignmentStudent->deleteAll(array('InstructorAssignmentStudent.inst_assign_id'=>$assignments['InstructorAssignment']['id']),false);
								foreach($assignmentsStudents as $assignmentsStudents){
									$assignmentsStudentsDocument = $this->InstructorAssignmentDocument->find('all',array('conditions'=>array('InstructorAssignmentDocument.assign_id'=>$assignmentsStudents['InstructorAssignmentStudent']['id'])));
									$assignmentsStudentsRemark = $this->InstructorAssignmentRemark->find('all',array('conditions'=>array('InstructorAssignmentRemark.student_assign_id'=>$assignmentsStudents['InstructorAssignmentStudent']['id'])));
									if(!empty($assignmentsStudentsRemark)){
										$this->InstructorAssignmentRemark->deleteAll(array('InstructorAssignmentRemark.student_assign_id'=>$assignmentsStudents['InstructorAssignmentStudent']['id']),false);				
									}
									if(!empty($assignmentsStudentsDocument)){
										$this->InstructorAssignmentDocument->deleteAll(array('InstructorAssignmentDocument.assign_id'=>$assignmentsStudents['InstructorAssignmentStudent']['id']),false);
										
										foreach($assignmentsStudentsDocument as $assignmentsStudentsDocument){
											if(file_exists('files/'.$assignmentsStudents['InstructorAssignmentStudent']['s_id'].'/personal_repo/'.$assignmentsStudentsDocument['InstructorAssignmentDocument']['file_name'])){
												unlink('files/'.$assignmentsStudents['InstructorAssignmentStudent']['s_id'].'/personal_repo/'.$assignmentsStudentsDocument['InstructorAssignmentDocument']['file_name']);
												$this->StudentRepository->deleteAll(array('StudentRepository.doc_id'=>$assignmentsStudentsDocument['InstructorAssignmentStudent']['id'],'StudentRepository.type'=>'Assignment'),false);
											}
											
										}
									}
								}
							}
						}
			
					}
					
					$this->Event->deleteAll(array('Event.t_id'=>$d_id));
					
				}elseif($member_type=='2'){
					
					$this->StudentApplyEvent->deleteAll(array('StudentApplyEvent.student_id'=>$d_id));
					$this->ContactInstructor->deleteAll(array('ContactInstructor.student_id'=>$d_id));
					$this->ContactInstructorStudent->deleteAll(array('ContactInstructorStudent.student_id'=>$d_id));
					$this->Assignment->deleteAll(array('Assignment.student_id'=>$d_id));
					$this->BroadcastStudent->deleteAll(array('BroadcastStudent.s_id'=>$d_id));
					$this->BroadcastRemark->deleteAll(array('BroadcastRemark.m_id'=>$d_id));
					$this->Blog->deleteAll(array('Blog.m_id'=>$d_id));
					$this->BlogRemark->deleteAll(array('BlogRemark.m_id'=>$d_id));
					$this->StickyNote->deleteAll(array('StickyNote.student_id'=>$d_id));
					$this->StudentRepository->deleteAll(array('StudentRepository.m_id'=>$d_id));
					$this->SendInvitation->deleteAll(array('SendInvitation.s_id'=>$d_id));
					
					$assignmentsStudents = $this->InstructorAssignmentStudent->find('all',array('conditions'=>array('InstructorAssignmentStudent.s_id'=>$d_id)));
					foreach($assignments as $assignments){
						if(!empty($assignmentsStudents)){
							$this->InstructorAssignmentStudent->deleteAll(array('InstructorAssignmentStudent.s_id'=>$d_id),false);
							foreach($assignmentsStudents as $assignmentsStudents){
								$assignmentsStudentsDocument = $this->InstructorAssignmentDocument->find('all',array('conditions'=>array('InstructorAssignmentDocument.assign_id'=>$assignmentsStudents['InstructorAssignmentStudent']['id'])));
								$assignmentsStudentsRemark = $this->InstructorAssignmentRemark->find('all',array('conditions'=>array('InstructorAssignmentRemark.student_assign_id'=>$assignmentsStudents['InstructorAssignmentStudent']['id'])));
								if(!empty($assignmentsStudentsRemark)){
									$this->InstructorAssignmentRemark->deleteAll(array('InstructorAssignmentRemark.student_assign_id'=>$assignmentsStudents['InstructorAssignmentStudent']['id']),false);				
								}
								if(!empty($assignmentsStudentsDocument)){
									$this->InstructorAssignmentDocument->deleteAll(array('InstructorAssignmentDocument.assign_id'=>$assignmentsStudents['InstructorAssignmentStudent']['id']),false);
									
									foreach($assignmentsStudentsDocument as $assignmentsStudentsDocument){
										if(file_exists('files/'.$assignmentsStudents['InstructorAssignmentStudent']['s_id'].'/personal_repo/'.$assignmentsStudentsDocument['InstructorAssignmentDocument']['file_name'])){
											unlink('files/'.$assignmentsStudents['InstructorAssignmentStudent']['s_id'].'/personal_repo/'.$assignmentsStudentsDocument['InstructorAssignmentDocument']['file_name']);
											$this->StudentRepository->deleteAll(array('StudentRepository.doc_id'=>$assignmentsStudentsDocument['InstructorAssignmentStudent']['id'],'StudentRepository.type'=>'Assignment'),false);
										}
										
									}
								}
							}
						}
					}
					
				}
				$this->$tableName->delete(array($tableName.'.id'=>$d_id));
				App::uses('Folder','Utility');
				$dir = new Folder();
				$dir->delete('files/'.$d_id);
			}		   	
			$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
			$info = $this->paginate($tableName,$conditions);
			
			if(empty($info) && $page>1)
			{
				$page=$page-1;
				$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
				$info = $this->paginate($tableName,$conditions);
			}
			$this->set(compact('info','page','id'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render($renderElement);			
		}
	}
	
	
	/*function admin_delete_student_record($id=NULL)
	{
		$this->layout='';
		$this->loadModel('Member');
		$this->loadModel('ContactInstructor');
		$this->loadModel('StudentApplyEvent');
		
		$id = convert_uudecode(base64_decode($id));
		
		if(!empty($id))
		{
			if($this->Member->delete($id)){
				$this->StudentApplyEvent->deleteAll(array('StudentApplyEvent.student_id'=>$id));
				$this->ContactInstructor->deleteAll(array('ContactInstructor.student_id'=>$id));
			}
			$this->Session->write('SuccessMessage','Record deleted successfully.');
			$this->redirect($this->referer());
		}
	} */
	//---------------------------------------END OF FUNCTION FOR DELETE SINGLE RECORD FROM MEMEBR TABLE--------
	function admin_add_sub_category($cat_id=NULL)
	{
		$this->loadModel('SubCategory');
		
		$this->autoRender = false;
		if($this->RequestHandler->isAjax())
		{
			$this->layout="";
			$sub_category_list = $this->SubCategory->find('all',array('conditions'=>array('SubCategory.c_id'=>$cat_id,'SubCategory.status'=>'1')));
			
			$sub_category_list=Set::combine($sub_category_list,'{n}.SubCategory.id','{n}.SubCategory.name');
			$this->set('sub_category_list',$sub_category_list);
			
			$this->viewPath = 'Elements'.DS.'frontElements/Instructor';	
			$this->render('sub_cat_list');
		
		}
		
	}
	//----------------------------------Searching for the instrutor---------------------
	
	function admin_instructorSearch($condition=null)
	{
		$this->loadModel('Member');
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		if(isset($this->params['named']['page']))
		{
			
		}else{
			$this->request->params['named']['page'] = 1;
		}
		$condition=array();
		$qryStr='';
		if(isset($this->params['named']['condition']))
		{
			$condition=$this->sort_condition();		
			$qryStr=$this->params['named']['condition'];
		}
		else
		{
			if($this->data['Member']['type']=="first_name" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.first_name LIKE"=>"%".trim($this->data['Member']['text'])."%"));
				$qryStr=$qryStr."Member.first_name LIKE-||".'%'.trim($this->data['Member']['text']).'%'."||-";
			}
			if($this->data['Member']['type']=="last_name" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.last_name LIKE"=>"%".trim($this->data['Member']['text'])."%"));
				$qryStr=$qryStr."Member.last_name LIKE-||".'%'.trim($this->data['Member']['text']).'%'."||-";
			}
			if($this->data['Member']['type']=="email" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.email"=>trim($this->data['Member']['text'])));
				$qryStr=$qryStr."Member.email-||".trim($this->data['Member']['text'])."||-";
			}
			if($this->data['Member']['type']=="phone" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.phone"=>trim($this->data['Member']['text'])));
				$qryStr=$qryStr."Member.phone-||".trim($this->data['Member']['text'])."||-";
			}
			if($this->data['Member']['type']=="zipcode" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.zipcode"=>trim($this->data['Member']['text'])));
				$qryStr=$qryStr."Member.zipcode-||".trim($this->data['Member']['text'])."||-";
			}
			$query=$this->Member->find('all',array('conditions'=>$condition));
			if(!isset($this->params['named']['condition'])){			
				$qryStr=base64_encode($qryStr);
			}	
		}
		$this->set('qryStr',$qryStr);
		if($this->RequestHandler->isAjax()) 
		{
			$this->layout="";
			$this->autoRender=false;
			$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Member.id DESC','conditions'=>$condition);
			$info = $this->paginate('Member',array('Member.member_type'=>'1'));
			$this->set(compact('info','page'));				
			$this->viewPath = 'Elements'.DS.'adminElements/teacher';
			$this->render('search_teacher_list');
		}		
		else
		{
			echo "error";die;
		}	
	}
	function sort_condition()
	{
		$conditions=array();
		$action = $this->params['action'];
		//echo $model[$action];
		if(isset($this->params['named']['condition']))
		{
			$this->set('qryStr',$this->params['named']['condition']);
			$qryStr=$this->params['named']['condition'];
			$con=explode("||-",base64_decode($qryStr));
			if($con[count($con)-1]=='')
			{
				array_pop($con);
			}
			
			$or['OR']=array();
			foreach($con as $val):
				$qry=explode("-||",$val);
				//print_r($qry);
				if($qry[0]=="Member.first_name LIKE")
				{	
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.first_name LIKE'=>$qry[1]));
				}
				if($qry[0]=="Member.last_name LIKE")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.last_name LIKE'=>$var));
				}
				if($qry[0]=="Member.email")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.email'=>$var));
				}
				if($qry[0]=="Member.phone")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.phone'=>$var));
				}
				if($qry[0]=="Member.zipcode")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.zipcode'=>$var));
				}
			endforeach;
		}
		return $conditions;
	}
	//---------------------End of the searching for the instructor----------------------
	//---------------------Searching for the student records----------------------------
	function admin_studentSearch($condition=null)
	{
		$this->loadModel('Member');
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		if(isset($this->params['named']['page']))
		{
			
		}else{
			$this->request->params['named']['page'] = 1;
		}
		$condition=array();
		$qryStr='';
		if(isset($this->params['named']['condition']))
		{
			$condition=$this->student_sort_condition();		
			$qryStr=$this->params['named']['condition'];
		}
		else
		{
			if($this->data['Member']['type']=="first_name" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.first_name LIKE"=>"%".trim($this->data['Member']['text'])."%"));
				$qryStr=$qryStr."Member.first_name LIKE-||".'%'.trim($this->data['Member']['text']).'%'."||-";
			}
			if($this->data['Member']['type']=="last_name" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.last_name LIKE"=>"%".trim($this->data['Member']['text'])."%"));
				$qryStr=$qryStr."Member.last_name LIKE-||".'%'.trim($this->data['Member']['text']).'%'."||-";
			}
			if($this->data['Member']['type']=="email" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.email"=>trim($this->data['Member']['text'])));
				$qryStr=$qryStr."Member.email-||".trim($this->data['Member']['text'])."||-";
			}
			if($this->data['Member']['type']=="phone" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.phone"=>trim($this->data['Member']['text'])));
				$qryStr=$qryStr."Member.phone-||".trim($this->data['Member']['text'])."||-";
			}
			if($this->data['Member']['type']=="zipcode" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.zipcode"=>trim($this->data['Member']['text'])));
				$qryStr=$qryStr."Member.zipcode-||".trim($this->data['Member']['text'])."||-";
			}
			$query=$this->Member->find('all',array('conditions'=>$condition));
			if(!isset($this->params['named']['condition'])){			
				$qryStr=base64_encode($qryStr);
			}	
		}
		$this->set('qryStr',$qryStr);
		if($this->RequestHandler->isAjax()) 
		{
			$this->layout="";
			$this->autoRender=false;
			$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Member.id DESC','conditions'=>$condition);
			$info = $this->paginate('Member',array('Member.member_type'=>'2'));
			$this->set(compact('info','page'));				
			$this->viewPath = 'Elements'.DS.'adminElements/teacher';
			$this->render('search_student_list');
		}		
		else
		{
			echo "error";die;
		}	
	}
	function student_sort_condition()
	{
		$this->loadModel('Contact');
		
		$conditions=array();
		$action = $this->params['action'];
		//echo $model[$action];
		if(isset($this->params['named']['condition']))
		{
			$this->set('qryStr',$this->params['named']['condition']);
			$qryStr=$this->params['named']['condition'];
			$con=explode("||-",base64_decode($qryStr));
			if($con[count($con)-1]=='')
			{
				array_pop($con);
			}
			
			$or['OR']=array();
			foreach($con as $val):
				$qry=explode("-||",$val);
				//print_r($qry);
				if($qry[0]=="Member.first_name LIKE")
				{	
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.first_name LIKE'=>$qry[1]));
				}
				if($qry[0]=="Member.last_name LIKE")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.last_name LIKE'=>$var));
				}
				if($qry[0]=="Member.email")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.email'=>$var));
				}
				if($qry[0]=="Member.phone")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.phone'=>$var));
				}
				if($qry[0]=="Member.zipcode")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.zipcode'=>$var));
				}
			endforeach;
		}
		return $conditions;
	}
	
	//---------------------End of the student searching records-------------------------
	//---------------------Searching for the contacts-----------------------------------
	
	function admin_contactSearch($condition=null)
	{
		$this->loadModel('Contact');
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		if(isset($this->params['named']['page']))
		{
			
		}else{
			$this->request->params['named']['page'] = 1;
		}
		$condition=array();
		$qryStr='';
		if(isset($this->params['named']['condition']))
		{
			$condition=$this->contact_sort_condition();		
			$qryStr=$this->params['named']['condition'];
		}
		else
		{
			if($this->data['Contact']['type']=="first_name" && trim($this->data['Contact']['text'])!=''){
				$condition=array_merge($condition,array("Contact.first_name LIKE"=>"%".trim($this->data['Contact']['text'])."%"));
				$qryStr=$qryStr."Contact.first_name LIKE-||".'%'.trim($this->data['Contact']['text']).'%'."||-";
			}
			if($this->data['Contact']['type']=="last_name" && trim($this->data['Contact']['text'])!=''){
				$condition=array_merge($condition,array("Contact.last_name LIKE"=>"%".trim($this->data['Contact']['text'])."%"));
				$qryStr=$qryStr."Contact.last_name LIKE-||".'%'.trim($this->data['Contact']['text']).'%'."||-";
			}
			if($this->data['Contact']['type']=="email" && trim($this->data['Contact']['text'])!=''){
				$condition=array_merge($condition,array("Contact.email"=>trim($this->data['Contact']['text'])));
				$qryStr=$qryStr."Contact.email-||".trim($this->data['Contact']['text'])."||-";
			}
			$query=$this->Contact->find('all',array('conditions'=>$condition));
			if(!isset($this->params['named']['condition'])){			
				$qryStr=base64_encode($qryStr);
			}	
		}
		$this->set('qryStr',$qryStr);
		if($this->RequestHandler->isAjax()) 
		{
			$this->layout="";
			$this->autoRender=false;
			$this->paginate=array('limit'=>$this->pageLimit,'conditions'=>$condition);
			$info = $this->paginate('Contact');
			$this->set(compact('info','page'));				
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('search_contact_list');
		}		
		else
		{
			echo "error";die;
		}	
	}
	function contact_sort_condition()
	{
		$conditions=array();
		$action = $this->params['action'];
		//echo $model[$action];
		if(isset($this->params['named']['condition']))
		{
			$this->set('qryStr',$this->params['named']['condition']);
			$qryStr=$this->params['named']['condition'];
			$con=explode("||-",base64_decode($qryStr));
			if($con[count($con)-1]=='')
			{
				array_pop($con);
			}
			
			$or['OR']=array();
			foreach($con as $val):
				$qry=explode("-||",$val);
				//print_r($qry);
				if($qry[0]=="Contact.first_name LIKE")
				{	
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Contact.first_name LIKE'=>$qry[1]));
				}
				if($qry[0]=="Contact.last_name LIKE")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Contact.last_name LIKE'=>$var));
				}
				if($qry[0]=="Contact.email")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Contact.email'=>$var));
				}
				
			endforeach;
		}
		return $conditions;
	}
	//---------------------End of the contact searching---------------------------------
	//---------------------Searching for the student records----------------------------
	function admin_categorySearch($condition=null)
	{
		$this->loadModel('Category');
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		
		if(isset($this->params['named']['page']))
		{
			
		}else{
			$this->request->params['named']['page'] = 1;
		}
		
		$condition=array();
		$qryStr='';
		
		if(isset($this->params['named']['condition']))
		{
			$condition=$this->category_sort_condition();		
			$qryStr=$this->params['named']['condition'];
		}
		else
		{
			if($this->data['Category']['name']!=''){
				$condition=array_merge($condition,array("Category.name LIKE"=>"%".trim($this->data['Category']['name'])."%"));
				$qryStr=$qryStr."Category.name LIKE-||".'%'.trim($this->data['Category']['name']).'%'."||-";
			}
			
			$query=$this->Category->find('all',array('conditions'=>$condition));
			if(!isset($this->params['named']['condition'])){			
				$qryStr=base64_encode($qryStr);
			}	
		}
		$this->set('qryStr',$qryStr);
		if($this->RequestHandler->isAjax()) 
		{
			$this->layout="";
			$this->autoRender=false;
			$this->paginate=array('limit'=>$this->pageLimit,'conditions'=>$condition,'order'=>'Category.id DESC');
			$info = $this->paginate('Category');
			$this->set(compact('info','page'));				
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('search_categories_list');
		}		
		else
		{
			echo "error";die;
		}	
	}
	function category_sort_condition()
	{
		$conditions=array();
		$action = $this->params['action'];
		//echo $model[$action];
		if(isset($this->params['named']['condition']))
		{
			$this->set('qryStr',$this->params['named']['condition']);
			$qryStr=$this->params['named']['condition'];
			$con=explode("||-",base64_decode($qryStr));
			if($con[count($con)-1]=='')
			{
				array_pop($con);
			}
			
			$or['OR']=array();
			foreach($con as $val):
				$qry=explode("-||",$val);
				//print_r($qry);
				if($qry[0]=="Category.name LIKE")
				{	
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Category.name LIKE'=>$qry[1]));
				}
				
			endforeach;
		}
		return $conditions;
	}
	//---------------------End of the searching for the student records-----------------
	function admin_subCategorySearch($condition=NULL)
	{
		$this->loadModel('Category'); 
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		
		if(isset($this->params['named']['page']))
		{
			
		}else{
			$this->request->params['named']['page'] = 1;
		}
		
		$condition=array();
		$qryStr='';
		
		if(isset($this->params['named']['condition']))
		{
			$condition=$this->sub_category_sort_condition();		
			$qryStr=$this->params['named']['condition'];
		}
		else
		{
			if($this->data['SubCategory']['c_id']!=''){
				$condition=array_merge($condition,array("SubCategory.c_id"=>$this->data['SubCategory']['c_id']));
				$qryStr="SubCategory.c_id-||".trim($this->data['SubCategory']['c_id'])."||-";				
			}
		
			if(trim($this->data['SubCategory']['name'])!=''){
				$condition=array_merge($condition,array("SubCategory.name LIKE"=>"%".trim($this->data['SubCategory']['name'])."%"));
				$qryStr=$qryStr."SubCategory.name LIKE-||".trim($this->data['SubCategory']['name'])."||-";
			}
		
			$query=$this->SubCategory->find('all',array('conditions'=>$condition));
			if(!isset($this->params['named']['condition'])){			
				$qryStr=base64_encode($qryStr);
			}	
		}
		$this->set('qryStr',$qryStr);
		if($this->RequestHandler->isAjax()) 
		{
			$this->layout="";
			$this->autoRender=false; 
			$this->paginate=array('limit'=>$this->pageLimit,'conditions'=>$condition,'order'=>'SubCategory.id DESC');
			$info = $this->paginate('SubCategory');
			$this->set(compact('info','page'));				
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('search_sub_categories_list');
		}		
		else
		{
			echo "error";die;
		}	
	}
	function sub_category_sort_condition()
	{
		$conditions=array();
		$action = $this->params['action'];
		//echo $model[$action];
		if(isset($this->params['named']['condition']))
		{
			$this->set('qryStr',$this->params['named']['condition']);
			$qryStr=$this->params['named']['condition'];
			$con=explode("||-",base64_decode($qryStr));
			if($con[count($con)-1]=='')
			{
				array_pop($con);
			}
			  
			foreach($con as $val):
				$qry=explode("-||",$val);
				
				if($qry[0]=="SubCategory.c_id")
				{	
					$conditions=array_merge($conditions,array('SubCategory.c_id'=>$qry[1])); 
				}
				if($qry[0]=="SubCategory.name LIKE")
				{	
					$conditions=array_merge($conditions,array('SubCategory.name LIKE'=>"%".$qry[1]."%"));
				}
				
			endforeach;
			
		}
		return $conditions;
	}
	//---------------------End of the searching for the student records-----------------
	function remove_photo_admin($id=NULL)
	{
		$this->loadModel('Member');
		$record=$this->Member->findById($id);
		if(!empty($record)){
			$data['Member']['id'] = $record['Member']['id'];
			$data['Member']['image'] = "";
			$this->Member->save($data);
			
			if($record['Member']['image']!='' && file_exists('files'.'/'.$data['Member']['id'].'/'.$record['Member']['image'])){
				unlink('files'.'/'.$data['Member']['id'].'/'.$record['Member']['image']);
			}
			$this->Session->write('SuccessMessage','Picture deleted successfully.');
			$this->redirect(array('action'=>'teacher','admin'=>true));
		}
		else{
			$this->redirect(array('action'=>'teacher','admin'=>true));
		}
	}
	/*  ............. Manage Teacher's Invitations ...................  */
	function admin_teacher_invitation()
	{
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		
		$this->loadModel('InviteTeacher');
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		
		$this->paginate = array('limit'=>$this->pageLimit,'order'=>'InviteTeacher.id DESC');
		$info = $this->paginate('InviteTeacher');
		$this->set(compact('page','info'));
		if($this->RequestHandler->isAjax())
		{
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('teacher_invitation_list');
		}
	}
	function admin_view_invitation($invId = NULL)
	{
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		
		$invId = convert_uudecode(base64_decode($invId));
		$this->loadModel('InviteTeacher');
		
		$info = $this->InviteTeacher->find('first',array('conditions'=>array('InviteTeacher.id'=>$invId)));
		$this->set('info',$info);
	}
	/*  .............End of Manage Teacher's Invitations ...................  */
	function admin_instructor_search_result($query=NULL)
	{
		//echo "hello"; die;
		$data = "S.No.,Name,Email,Phone,City,ZipCode,State,Country\n";
		$condition=array();
		$qryStr='';
		if(!isset($this->params['named']['condition'])){
			$this->request->params['named']['condition']=$query;
			$condition=$this->sort_condition();
			$qryStr=$this->params['named']['condition'];
		}
		$condition=array_merge($condition,array('Member.member_type'=>'1')); 
		$info = $this->Member->find('all',array('conditions'=>$condition));
		$i=1;
		foreach($info as $info){
			$data .= $i.",";
			$data .= $info['Member']['first_name'].' '.$info['Member']['last_name'].",";
			$data .= $info['Member']['email'].",";
			$data .= $info['Member']['phone'].",";
			$data .= $info['Member']['city'].",";
			$data .= $info['Member']['zipcode'].",";
			$data .= $info['Member']['state'].",";
			$data .= $info['Country']['country_name']."\n";
			$i++;
		}
		header("Content-Type: application/csv");
		header("Content-Disposition:attachment;filename=instructor_records.csv");
		echo $data;
		die();
	}
	function admin_student_search_result($query=NULL)
	{
		$data = "S.No.,Name,Email,Phone,City,ZipCode,State,Country\n";
		$condition=array();
		$qryStr='';
		if(!isset($this->params['named']['condition'])){
			$this->request->params['named']['condition']=$query;
			$condition=$this->student_sort_condition();
			$qryStr=$this->params['named']['condition'];
		}
		$condition=array_merge($condition,array('Member.member_type'=>'2')); 
		$info = $this->Member->find('all',array('conditions'=>$condition));
		$i=1;
		foreach($info as $info){
			$data .= $i.",";
			$data .= $info['Member']['first_name'].' '.$info['Member']['last_name'].",";
			$data .= $info['Member']['email'].",";
			$data .= $info['Member']['phone'].",";
			$data .= $info['Member']['city'].",";
			$data .= $info['Member']['zipcode'].",";
			$data .= $info['Member']['state'].",";
			$data .= $info['Country']['country_name']."\n";
			$i++;
		}
		header("Content-Type: application/csv");
		header("Content-Disposition:attachment;filename=student_records.csv");
		echo $data;
		die();
	}
	function admin_category_search_result($query=Null)
	{
		$data = "S.No.,Category Name,Date\n";
		$condition=array();
		$qryStr='';
		if(!isset($this->params['named']['condition'])){
			$this->request->params['named']['condition']=$query;
			$condition=$this->category_sort_condition();
			$qryStr=$this->params['named']['condition'];
		}
		$condition=array_merge($condition); 
		$info = $this->Category->find('all',array('conditions'=>$condition));
		$i=1;
		foreach($info as $info){
			$data .= $i.",";
			$data .= $info['Category']['name'].",";
			$data .= $info['Category']['date']."\n";
			$i++;
		}
		header("Content-Type: application/csv");
		header("Content-Disposition:attachment;filename=category_records.csv");
		echo $data;
		die();
	}
	function admin_sub_category_search_result($query=Null)
	{
		$data = "S.No.,Category Name,Sub-Category Name,Date\n";
		$condition=array();
		$qryStr='';
		if(!isset($this->params['named']['condition'])){
			$this->request->params['named']['condition']=$query;
			$condition=$this->sub_category_sort_condition();
			$qryStr=$this->params['named']['condition'];
		}
		$condition=array_merge($condition); 
		$info = $this->SubCategory->find('all',array('conditions'=>$condition));
		$i=1;
		foreach($info as $info){
			$data .= $i.",";
			$data .= $info['Category']['name'].",";
			$data .= $info['SubCategory']['name'].",";
			$data .= $info['SubCategory']['date']."\n";
			$i++;
		}
		header("Content-Type: application/csv");
		header("Content-Disposition:attachment;filename=subcategory_records.csv");
		echo $data;
		die();
	}
	function admin_contact_search_result($query=Null)
	{
		$this->loadModel('Contact');
		$data = "S.No.,Name,E-mail,Contact Type,Message,Date\n";
		$condition=array();
		$qryStr='';
		if(!isset($this->params['named']['condition'])){
			$this->request->params['named']['condition']=$query;
			$condition=$this->contact_sort_condition();
			$qryStr=$this->params['named']['condition'];
		}
		$condition=array_merge($condition); 
		$info = $this->Contact->find('all',array('conditions'=>$condition));
		$i=1;
		foreach($info as $info){
			$data .= $i.",";
			$data .= $info['Contact']['first_name'].' '.$info['Contact']['last_name'].",";
			$data .= $info['Contact']['email'].",";
			$data .= $info['Contact']['contact_type'].",";
			$data .= str_replace(",",' ',$info['Contact']['message']).",";
			$data .= $info['Contact']['date_added']."\n";
			$i++;
		}
		header("Content-Type: application/csv");
		header("Content-Disposition:attachment;filename=contact_records.csv");
		echo $data;
		die();
	}
	function admin_instructor_events()
	{
		$this->layout="admin";
		$this->loadModeL("Member");
		$page= isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		
		$info = $this->Member->find('all',array('conditions'=>array('Member.member_type'=>'1')));
		$this->set(compact('info'));
		
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Member.id DESC');
		$conditions=array('Member.member_type'=>'1');
		$info=$this->paginate('Member',$conditions);
		$this->set(compact('info','page'));
		if($this->RequestHandler->isAjax()){
			$this->layout = '';
			$this->autoRender = false;
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('instructor_events_list');
		}
	}
	function admin_events($id=NULL)
	{
		$this->layout="admin";
		$this->loadModeL("Event");
		$this->loadModeL("MemberCategory");
		$this->loadModeL("SubCategory");
		$page= isset($this->params['named']['page'])?$this->params['named']['page']:'1';
 		
		$m_id=convert_uudecode(base64_decode($id));
		$login_member_details=$this->Member->find('first',array('conditions'=>array('Member.id'=>$m_id),'recursive'=>2));
		
		$sub_cate_info = $this->MemberCategory->find('list',array('conditions'=>array('MemberCategory.m_id'=>$m_id),'fields'=>array('MemberCategory.sub_cate_id')));
		$AllSubCate = $this->SubCategory->find('list',array('conditions'=>array('SubCategory.id'=>$sub_cate_info),'fields'=>array('SubCategory.id','SubCategory.name')));		
		//pr($AllSub); die;
		if(!empty($login_member_details['Member']['cate_id'])){
			$sub_category=$this->SubCategory->find('all',array('conditions'=>array('SubCategory.status'=>1,'SubCategory.c_id'=>$login_member_details['Member']['cate_id'])));
			$sub_category=Set::combine($sub_category,'{n}.SubCategory.id','{n}.SubCategory.name');
			$this->set(compact('sub_category'));
		}
		
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Event.id DESC');
		$conditions = array('Event.t_id'=>$m_id);
		$info = $this->paginate('Event',$conditions);
		$this->set(compact('info','page','id','AllSubCate','m_id','sub_category','login_member_details'));
		
		//pr($info); die;
		
		if($this->RequestHandler->isAjax())
		{
			$this->layout="";
			$this->autoRender=false;
			$this->viewPath = 'Elements'.DS.'adminElements/events';
			$this->render('events_list');
		}
	}
	function admin_add_event($id=NULL)
	{
		$this->layout="admin";
		$this->loadModel('Country');
		$this->loadModel('Member');
		$this->loadModel('SubCategory');
		$this->loadModel('Category');
		
		$memberId = convert_uudecode(base64_decode($id));
		//pr($memberId); die;
		$country_list = $this->Country->find('all');
		$country_list = Set::combine($country_list,'{n}.Country.id','{n}.Country.country_name');
		
		$this->Member->unBindModel(array('hasMany'=>array('VideoLink')));
		$memberInfo = $this->Member->find('first',array('conditions'=>array('Member.id'=>$memberId),'recursive'=>2));
		
		$subCatgID = array();
		if(!empty($memberInfo['MemberCategory']))
		{
			foreach($memberInfo['MemberCategory'] as $memberData)
			{
				$subCatgId[] = $memberData['sub_cate_id'];
			}
			$catgInfo = $this->Category->find('first',array('conditions'=>array('Category.id'=>@$memberInfo['MemberCategory'][0]['cate_id'])));
			$sub_category_list = $this->SubCategory->find('list',array('conditions'=>array('SubCategory.id'=>$subCatgId),'fields'=>array('id','name')));
		}
		elseif(!empty($memberInfo['Member']['cate_id']) && empty($memberInfo['MemberCategory']))
		{
			$sub_category_list = array();
			$catgInfo = $this->Category->find('first',array('conditions'=>array('Category.id'=>$memberInfo['Member']['cate_id'])));
		}
		elseif(!empty($memberInfo['Member']['cate_id']))
		{
			$catgInfo = $this->Category->find('first',array('conditions'=>array('Category.id'=>$memberInfo['Member']['cate_id'])));
		}
		
		$this->set(compact('country_list','memberInfo','sub_category_list','catgInfo','memberId'));
		
		if(!empty($this->data))
		{
			$id = base64_encode(convert_uuencode($this->data['Event']['t_id']));
			$this->loadModel('Event');
			$data = $this->data;
			$allDays = NULL;
			
			foreach($data['Event']['days'] as $days){
				if($allDays == NULL){
					$allDays = $days;
				}elseif($allDays != NULL){
					$allDays = $allDays.','.$days;
				}
			}
			$data['Event']['days'] = $allDays;
			$data['Event']['date_added'] = date('y-m-d');
			$data['Event']['start_date'] = date('y-m-d',strtotime($data['Event']['start_date']));
			$data['Event']['end_added'] = date('y-m-d',strtotime($data['Event']['end_date']));
			
			$this->Event->save($data);
			
			$this->Session->write('SuccessMessage','Event has been added successfully.');
			$this->redirect(array('controller'=>'Users','action'=>'events/'.$id));
		}	
	}
	function validate_admin_add_event_ajax()
	{
	
		$this->layout="";
		$this->loadModel('Event');
		
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())	{
			$errors_msg = null;
			$errors=$this->validate_admin_add_event_steps($this->data);					
			if ( is_array ( $this->data ) )	{
				foreach ($this->data['Event'] as $key => $value ){
					if( array_key_exists ( $key, $errors) )	{
						foreach ( $errors [ $key ] as $k => $v ){
							$errors_msg .= "error|$key|$v";
						}	
					}
					else {
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}
	}
	function validate_admin_add_event_steps($data)
	{		
		$errors = array ();
		$this->loadModel('Event');
		//pr($this->data);die;
		if(isset($data['Event']['title'])){
			if(trim($data['Event']['title'])=="")	{
				$errors ['title'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['title'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Event']['cate_name'])){
			if(trim($data['Event']['cate_name'])=="")	{
				$errors ['cate_name'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['cate_name'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		
		if(isset($data['Event']['sub_cate_id'])){
			if(trim($data['Event']['sub_cate_id'])=="")	{
				$errors ['sub_cate_id'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['sub_cate_id'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Event']['start_date'])){
			if(trim($data['Event']['start_date'])=="")	{
				$errors ['start_date'] [] = __(FIELD_REQUIRED,true)."\n";
			}elseif(trim($data['Event']['start_date'])!=""){
				$explode = explode("-",$data['Event']['start_date']);
							
				if(count($explode)==0 || ($explode[2]<1 || $explode[2]>31) || ($explode[1]<1 || $explode[1]>12) || ($explode[0]<2012 || $explode[0]>2200)){
					$errors ['start_date'] [] = __('Please enter a valid date',true)."\n";
				}
				elseif(strtotime($data['Event']['start_date']) <= strtotime('d-m-Y') ){
					$errors ['start_date'] [] = __('Event date should be greater than from current date',true)."\n";
				}	
			}
		}
		else{
			$errors ['start_date'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Event']['end_date'])){
			if(trim($data['Event']['end_date'])=="")	{
				$errors ['end_date'] [] = __(FIELD_REQUIRED,true)."\n";
			}elseif(trim($data['Event']['end_date'])!=""){
				$explode = explode("-",$data['Event']['end_date']);
							
				if(count($explode)==0 || ($explode[2]<1 || $explode[2]>31) || ($explode[1]<1 || $explode[1]>12) || ($explode[0]<2012 || $explode[0]>2200)){
					$errors ['end_date'] [] = __('Please enter a valid date',true)."\n";
				}
				elseif(strtotime($data['Event']['end_date']) <= strtotime('d-m-Y') ){
					$errors ['end_date'] [] = __('Event date should be greater than from current date',true)."\n";
				}
				elseif(strtotime($data['Event']['end_date']) <= strtotime($data['Event']['start_date']) ){
					$errors ['end_date'] [] = __('End date should be greater than from start date',true)."\n";
				}	
			}		
		}
		else{
			$errors ['end_date'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Event']['days'])){
			$i = 0;
			foreach($data['Event']['days'] as $days){
				if(trim($days)!=""){
					$i++;
				}	
			}
			if($i==0){
				$errors ['days'] [] = __(FIELD_REQUIRED,true)."\n";	
			}
		}
		else{
			$errors ['days'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Event']['start_time'])){
			if(trim($data['Event']['start_time'])=="")	{
				$errors ['start_time'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['start_time'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Event']['end_time'])){
			if(trim($data['Event']['end_time'])=="")	{
				$errors ['end_time'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['end_time'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		
		if(trim($data['Event']['end_time'])!='')
		{
			$start = array();
			$end = array();
			$start = explode(':',$data['Event']['start_time']);
			$end = explode(':',$data['Event']['end_time']);
			if($end['0']<$start['0'])
			{
				$errors ['end_time'] [] = __(WRONG_END_TIME,true)."\n";
			}
		}
		/*if(isset($data['Event']['venue_name'])){
			if(trim($data['Event']['venue_name'])=="")	{
				$errors ['venue_name'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['venue_name'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Event']['city'])){
			if(trim($data['Event']['city'])=="")	{
				$errors ['city'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['city'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Event']['state'])){
			if(trim($data['Event']['state'])=="")	{
				$errors ['state'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['state'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Event']['country'])){
			if(trim($data['Event']['country'])=="")	{
				$errors ['country'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['country'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Event']['zip_code'])){
			if(trim($data['Event']['zip_code'])=="")	{
				$errors ['zip_code'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['zip_code'] [] = __(FIELD_REQUIRED,true)."\n";
		}*/
		if(trim($data['Event']['zip_code']) == "")
		{
			$errors ['zip_code'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		if(isset($data['Event']['description'])){
			if(trim($data['Event']['description'])=="")	{
				$errors ['description'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['description'] [] = __(FIELD_REQUIRED,true)."\n";
		}


		
		return $errors;			
	}
	function admin_edit_event($id=NULL,$m_id=NULL)
	{
		$eventId = convert_uudecode(base64_decode($id));
		$memberId = convert_uudecode(base64_decode($m_id));
		$this->layout = 'admin';
		
		$this->loadModel('Country');
		$this->loadModel('MemberCategory');
		$this->loadModel('SubCategory');
		$this->loadModel('Category');
		$this->loadModel('Event');
		
		$country_list = $this->Country->find('all');
		$country_list = Set::combine($country_list,'{n}.Country.id','{n}.Country.country_name');
		$memberInfo = $this->Member->find('first',array('conditions'=>array('Member.id'=>$memberId),'recursive'=>'-1'));
		$eventData = $this->Event->find('first',array('conditions'=>array('Event.id'=>$eventId)));
		$memberSubCatg = $this->MemberCategory->find('list',array('conditions'=>array('MemberCategory.m_id'=>$memberId),'fields'=>array('id','sub_cate_id')));
		$catgInfo = $this->Category->find('first',array('conditions'=>array('Category.id'=>$eventData['Event']['cate_id'])));
		
		if(!empty($memberSubCatg))
		{
			$sub_category_list = $this->SubCategory->find('list',array('conditions'=>array('SubCategory.id'=>$memberSubCatg),'fields'=>array('id','name')));	
		}
		elseif($eventData['Event']['sub_cate_id']=='0')
		{
			$sub_category_list = array();
		}
		$this->set(compact('country_list','memberSubCatg','sub_category_list','catgInfo','eventData','memberInfo'));
		
		
		
		if(!empty($this->data))
		{
			$error = array();
			$error = $this->validate_admin_add_event_steps($this->data);
			$memId = base64_encode(convert_uuencode($this->data['Event']['t_id']));
			if(count($error)=='0')
			{
				$data = $this->data;
				
				foreach($data['Event']['days'] as $days){
					if($allDays == NULL){
						$allDays = $days;
					}elseif($allDays != NULL){
						$allDays = $allDays.','.$days;
					}
				}
				$data['Event']['days'] = $allDays;
				
				$data['Event']['start_date'] = date('y-m-d',strtotime($data['Event']['start_date']));
				$data['Event']['end_added'] = date('y-m-d',strtotime($data['Event']['end_date']));
				$this->Event->save($data);
				
				
				$event_id = base64_encode(convert_uuencode($this->data['Event']['id']));
				
				$this->Session->write('SuccessMessage','Event has been updated successfully.');
				$this->redirect(array('controller'=>'users','action'=>'events/'.$memId));
			}
			else {
				$this->set('error',$error);
			}
		}
	}
	function admin_view_event($id=NULL)
	{
		$this->layout="admin";
		$this->loadModeL("Event");
		
		$id=convert_uudecode(base64_decode($id));
		$info = $this->Event->find('first',array('conditions'=>array('Event.id'=>$id)));
		$this->set(compact('info'));
			
	}
	function admin_update_event_status($page=NULL,$id=NULL,$tableName=NULL,$renderPath=NULL,$renderElement=NULL)
	{
		$this->layout='';
		
		$this->loadModel("Event");
		$id=convert_uudecode(base64_decode($id));
		$tableName=base64_decode($tableName);
		$renderPath=base64_decode($renderPath);
		$renderElement=base64_decode($renderElement);		
		
		$memInfo = $this->Event->find('first',array('conditions'=>array('Event.id'=>$id)));
		
		
		if($this->RequestHandler->isAjax()){		
			$this->layout=false;
			$this->autoRender = false;				
			$getRec = $this->$tableName->find('first',array('conditions'=>array($tableName.'.id'=>$id)));			
			$field=array();
			if(!empty($getRec)){
				if($getRec[$tableName]['status']=='0'){
					$this->$tableName->id=$id;					
					$field[$tableName]['status'] = 1;					
					$this->$tableName->save($field);
				}
				else{
					$this->$tableName->id=$id;					
					$field[$tableName]['status'] = '0';					
					$this->$tableName->save($field);					
				}
			}		   	
			$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
			$conditions=array('Event.t_id'=>$memInfo['Event']['t_id']);
			$info = $this->paginate($tableName,$conditions);
			$this->set(compact('info','page'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render($renderElement);			
		}		
	}
	function admin_delete_event_record($id=NULL)
	{
		$this->layout='';
		$this->loadModel('Event');
		$this->loadModel('StudentApplyEvent');
		$id = convert_uudecode(base64_decode($id));
		
		if(!empty($id))
		{
			if($this->Event->delete($id))
			{
				$this->StudentApplyEvent->deleteAll(array('StudentApplyEvent.event_id'=>$id),false);
			}
			
			$this->Session->write('SuccessMessage','Record deleted successfully.');
			$this->redirect($this->referer());
		}
	}
	function admin_instructorEventSearch()
	{
		$this->loadModel('Member');
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		if(isset($this->params['named']['page']))
		{
			
		}else{
			$this->request->params['named']['page'] = 1;
		}
		$condition=array();
		$qryStr='';
		if(isset($this->params['named']['condition']))
		{
			$condition=$this->sort_event_instructor();		
			$qryStr=$this->params['named']['condition'];
		}
		else
		{
			if($this->data['Member']['type']=="first_name" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.first_name LIKE"=>"%".trim($this->data['Member']['text'])."%"));
				$qryStr=$qryStr."Member.first_name LIKE-||".'%'.trim($this->data['Member']['text']).'%'."||-";
			}
			if($this->data['Member']['type']=="last_name" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.last_name LIKE"=>"%".trim($this->data['Member']['text'])."%"));
				$qryStr=$qryStr."Member.last_name LIKE-||".'%'.trim($this->data['Member']['text']).'%'."||-";
			}
			if($this->data['Member']['type']=="email" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.email"=>trim($this->data['Member']['text'])));
				$qryStr=$qryStr."Member.email-||".trim($this->data['Member']['text'])."||-";
			}
			if($this->data['Member']['type']=="phone" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.phone"=>trim($this->data['Member']['text'])));
				$qryStr=$qryStr."Member.phone-||".trim($this->data['Member']['text'])."||-";
			}
			if($this->data['Member']['type']=="zipcode" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.zipcode"=>trim($this->data['Member']['text'])));
				$qryStr=$qryStr."Member.zipcode-||".trim($this->data['Member']['text'])."||-";
			}
			$query=$this->Member->find('all',array('conditions'=>$condition));
			if(!isset($this->params['named']['condition'])){			
				$qryStr=base64_encode($qryStr);
			}	
		}
		$this->set('qryStr',$qryStr);
		if($this->RequestHandler->isAjax()) 
		{
			$this->layout="";
			$this->autoRender=false;
			$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Member.id DESC','conditions'=>$condition);
			$info = $this->paginate('Member',array('Member.member_type'=>'1'));
			$this->set(compact('info','page'));				
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('search_instructor_events_list');
		}		
		else
		{
			echo "error";die;
		}	
	
	}
	function sort_event_instructor()
	{
		$conditions=array();
		$action = $this->params['action'];
		//echo $model[$action];
		if(isset($this->params['named']['condition']))
		{
			$this->set('qryStr',$this->params['named']['condition']);
			$qryStr=$this->params['named']['condition'];
			$con=explode("||-",base64_decode($qryStr));
			if($con[count($con)-1]=='')
			{
				array_pop($con);
			}
			
			$or['OR']=array();
			foreach($con as $val):
				$qry=explode("-||",$val);
				//print_r($qry);
				if($qry[0]=="Member.first_name LIKE")
				{	
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.first_name LIKE'=>$qry[1]));
				}
				if($qry[0]=="Member.last_name LIKE")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.last_name LIKE'=>$var));
				}
				if($qry[0]=="Member.email")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.email'=>$var));
				}
				if($qry[0]=="Member.phone")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.phone'=>$var));
				}
				if($qry[0]=="Member.zipcode")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.zipcode'=>$var));
				}
			endforeach;
		}
		return $conditions;
	}
	function admin_instructor_download_result($query=NULL)
	{
		//echo "hello"; die;
		$data = "S.No.,Name,Email,Phone,City,ZipCode,State,Country\n";
		$condition=array();
		$qryStr='';
		if(!isset($this->params['named']['condition'])){
			$this->request->params['named']['condition']=$query;
			$condition=$this->sort_condition();
			$qryStr=$this->params['named']['condition'];
		}
		$condition=array_merge($condition,array('Member.member_type'=>'1')); 
		$info = $this->Member->find('all',array('conditions'=>$condition));
		$i=1;
		foreach($info as $info){
			$data .= $i.",";
			$data .= $info['Member']['first_name'].' '.$info['Member']['last_name'].",";
			$data .= $info['Member']['email'].",";
			$data .= $info['Member']['phone'].",";
			$data .= $info['Member']['city'].",";
			$data .= $info['Member']['zipcode'].",";
			$data .= $info['Member']['state'].",";
			$data .= $info['Member']['country']."\n";
			$i++;
		}
		header("Content-Type: application/csv");
		header("Content-Disposition:attachment;filename=instructor_records.csv");
		echo $data;
		die();
	}
	
	//-----------------Searching Event function-----------------------

	function admin_eventSearch()
	{
		$this->loadModel('Member');
		$this->loadModel('Event');
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		if(isset($this->params['named']['page'])){
		}else{
			$this->request->params['named']['page'] = 1;
		}
		$condition=array();
		$qryStr='';
		
		if(isset($this->params['named']['condition']))
		{
			$condition=$this->sort_event();		
			$qryStr=$this->params['named']['condition'];
		}
		else
		{	
			//pr($this->data['Event']['mem_id']); die;
			if($this->data['Event']['type']=="title" && trim($this->data['Event']['text'])!=''){
				$condition=array_merge($condition,array("Event.title LIKE"=>"%".trim($this->data['Event']['text'])."%"));
				$qryStr=$qryStr."Event.title LIKE-||".'%'.trim($this->data['Event']['text']).'%'."||-";
			}
			if($this->data['Event']['type']=="subcategory" && $this->data['Event']['select']!=''){
				$condition=array_merge($condition,array("Event.sub_cate_id"=>$this->data['Event']['select']));
				$qryStr=$qryStr."Event.sub_cate_id-||".$this->data['Event']['select']."||-";
			}
			if($this->data['Event']['type']=="zipcode" && trim($this->data['Event']['text'])!=''){
				$condition=array_merge($condition,array("Event.zip_code"=>trim($this->data['Event']['text'])));
				$qryStr=$qryStr."Event.zip_code-||".trim($this->data['Event']['text'])."||-";
			}
			if($this->data['Event']['mem_id']!=""){
				$condition=array_merge($condition,array("Event.t_id"=>trim($this->data['Event']['mem_id'])));
				$qryStr=$qryStr."Event.t_id-||".trim($this->data['Event']['mem_id'])."||-";
			}
			
			$query=$this->Event->find('all',array('conditions'=>$condition,'recursive'=>0));
			if(!isset($this->params['named']['condition'])){			
				$qryStr=base64_encode($qryStr);
			}	
		}
		$this->set('qryStr',$qryStr);
		if($this->RequestHandler->isAjax()) 
		{
			$this->layout="";
			$this->autoRender=false;
			$this->paginate=array('limit'=>$this->pageLimit,'conditions'=>$condition);
			$info = $this->paginate('Event');
			$this->set(compact('info','page'));				
			$this->viewPath = 'Elements'.DS.'adminElements/events';
			$this->render('search_events_list');
		}		
		else
		{
			echo "error";die;
		}	
	}
	function sort_event()
	{
		$conditions=array();
		$action = $this->params['action'];
		//echo $model[$action];
		if(isset($this->params['named']['condition']))
		{
			$this->set('qryStr',$this->params['named']['condition']);
			$qryStr=$this->params['named']['condition'];
			$con=explode("||-",base64_decode($qryStr));
			if($con[count($con)-1]=='')
			{
				array_pop($con);
			}
			$or['OR']=array();
			foreach($con as $val):
				$qry=explode("-||",$val);
				//print_r($qry);
				if($qry[0]=="Event.title LIKE")
				{	
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Event.title LIKE'=>$qry[1]));
				}
				if($qry[0]=="Event.sub_cate_id")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Event.sub_cate_id'=>$var));
				}
				if($qry[0]=="Event.zipcode")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Event.zipcode'=>$var));
				}
				if($qry[0]=="Event.mem_id")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Event.t_id'=>$var));
				}
			endforeach;
		}
		return $conditions;
	}
	function admin_event_download_result($query=Null)
	{
		$this->loadModel('Event');
		$data = "S.No.,Title,Category Name,SubCategory Name,Start Date,End Date,Start Time,End Time,Venue Name,City,State,Country,Zip Code,Description\n";
		$condition=array();
		$qryStr='';
		if(!isset($this->params['named']['condition'])){
			$this->request->params['named']['condition']=$query;
			$condition=$this->sort_event();
			$qryStr=$this->params['named']['condition'];
		}
		$info = $this->Event->find('all',array('conditions'=>$condition));
		$i=1;
		foreach($info as $info){
			$data .= $i.",";
			$data .= $info['Event']['title'].",";
			$data .= $info['Category']['name'].",";
			$data .= $info['SubCategory']['name'].",";
			$data .= $info['Event']['start_date'].",";
			$data .= $info['Event']['end_date'].",";
			$data .= $info['Event']['start_time'].",";
			$data .= $info['Event']['end_time'].",";
			$data .= $info['Event']['venue_name'].",";
			$data .= $info['Event']['city'].",";
			$data .= $info['Event']['state'].",";
			$data .= str_replace(",","_",trim($info['Country']['country_name'])).",";
			$data .= $info['Event']['zip_code'].",";
			$data .= str_replace(",","",$info['Event']['description'])."\n";
			$i++;
		}
		//pr($data); die;
		header("Content-Type: application/csv");
		header("Content-Disposition:attachment;filename=event_records.csv");
		echo $data;
		die();
	}
	
	//-----------------End of search event----------------------------
	
	function admin_student_events()
	{
		$this->layout="admin";
		$this->loadModeL("Member");
		$page= isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		
		$info = $this->Member->find('all',array('conditions'=>array('Member.member_type'=>'2')));
		$this->set(compact('info'));
		
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Member.id DESC');
		$conditions=array('Member.member_type'=>'2');
		$info=$this->paginate('Member',$conditions);
		$this->set(compact('info','page'));
		if($this->request->is('ajax'))
		{
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath='Elements'.DS.'adminElements/cmsPages';
			$this->render('student_events_list');
				
		}
	}
	function admin_student_view_event($id=NULL,$m_id=NULL)
	{
		$this->layout="admin";
		$this->loadModeL("Event");
		
		$id=convert_uudecode(base64_decode($id));
		$m_id=convert_uudecode(base64_decode($m_id));
		$memInfo=$this->Member->find('first',array('conditions'=>array('Member.id'=>$m_id),'fields'=>array('Member.id','Member.first_name','Member.last_name')));
		$info = $this->Event->find('first',array('conditions'=>array('Event.id'=>$id)));
		$this->set(compact('info','memInfo'));
			
	}
	function admin_studentEventSearch()
	{
		$this->loadModel('Member');
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		if(isset($this->params['named']['page']))
		{
			
		}else{
			$this->request->params['named']['page'] = 1;
		}
		$condition=array();
		$qryStr='';
		if(isset($this->params['named']['condition']))
		{
			$condition=$this->sort_event_student();		
			$qryStr=$this->params['named']['condition'];
		}
		else
		{
			if($this->data['Member']['type']=="first_name" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.first_name LIKE"=>"%".trim($this->data['Member']['text'])."%"));
				$qryStr=$qryStr."Member.first_name LIKE-||".'%'.trim($this->data['Member']['text']).'%'."||-";
			}
			if($this->data['Member']['type']=="last_name" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.last_name LIKE"=>"%".trim($this->data['Member']['text'])."%"));
				$qryStr=$qryStr."Member.last_name LIKE-||".'%'.trim($this->data['Member']['text']).'%'."||-";
			}
			if($this->data['Member']['type']=="email" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.email"=>trim($this->data['Member']['text'])));
				$qryStr=$qryStr."Member.email-||".trim($this->data['Member']['text'])."||-";
			}
			if($this->data['Member']['type']=="phone" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.phone"=>trim($this->data['Member']['text'])));
				$qryStr=$qryStr."Member.phone-||".trim($this->data['Member']['text'])."||-";
			}
			if($this->data['Member']['type']=="zipcode" && trim($this->data['Member']['text'])!=''){
				$condition=array_merge($condition,array("Member.zipcode"=>trim($this->data['Member']['text'])));
				$qryStr=$qryStr."Member.zipcode-||".trim($this->data['Member']['text'])."||-";
			}
			$query=$this->Member->find('all',array('conditions'=>$condition));
			if(!isset($this->params['named']['condition'])){			
				$qryStr=base64_encode($qryStr);
			}	
		}
		$this->set('qryStr',$qryStr);
		if($this->RequestHandler->isAjax()) 
		{
			$this->layout="";
			$this->autoRender=false;
			$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Member.id DESC','conditions'=>$condition);
			$info = $this->paginate('Member',array('Member.member_type'=>'2'));
			$this->set(compact('info','page'));				
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('search_student_events_list');
		}		
		else
		{
			echo "error";die;
		}	
	
	}
	function sort_event_student()
	{
		$conditions=array();
		$action = $this->params['action'];
		//echo $model[$action];
		if(isset($this->params['named']['condition']))
		{
			$this->set('qryStr',$this->params['named']['condition']);
			$qryStr=$this->params['named']['condition'];
			$con=explode("||-",base64_decode($qryStr));
			if($con[count($con)-1]=='')
			{
				array_pop($con);
			}
			
			$or['OR']=array();
			foreach($con as $val):
				$qry=explode("-||",$val);
				//print_r($qry);
				if($qry[0]=="Member.first_name LIKE")
				{	
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.first_name LIKE'=>$qry[1]));
				}
				if($qry[0]=="Member.last_name LIKE")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.last_name LIKE'=>$var));
				}
				if($qry[0]=="Member.email")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.email'=>$var));
				}
				if($qry[0]=="Member.phone")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.phone'=>$var));
				}
				if($qry[0]=="Member.zipcode")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.zipcode'=>$var));
				}
			endforeach;
		}
		return $conditions;
	}
	function admin_student_download_result($query=NULL)
	{
		//echo "hello"; die;
		$data = "S.No.,Name,Email,Phone,City,ZipCode,State,Country\n";
		$condition=array();
		$qryStr='';
		if(!isset($this->params['named']['condition'])){
			$this->request->params['named']['condition']=$query;
			$condition=$this->sort_condition();
			$qryStr=$this->params['named']['condition'];
		}
		$condition=array_merge($condition,array('Member.member_type'=>'2')); 
		$info = $this->Member->find('all',array('conditions'=>$condition));
		$i=1;
		foreach($info as $info){
			$data .= $i.",";
			$data .= $info['Member']['first_name'].' '.$info['Member']['last_name'].",";
			$data .= $info['Member']['email'].",";
			$data .= $info['Member']['phone'].",";
			$data .= $info['Member']['city'].",";
			$data .= $info['Member']['zipcode'].",";
			$data .= $info['Member']['state'].",";
			$data .= $info['Member']['country']."\n";
			$i++;
		}
		header("Content-Type: application/csv");
		header("Content-Disposition:attachment;filename=instructor_records.csv");
		echo $data;
		die();
	}
	
	function admin_events_student($id=NULL)
	{
		$this->layout = 'admin';
		$this->loadModel('StudentApplyEvent');
		$this->loadModel('Member');
		$this->loadModel('MemberCategory');
		$this->loadModel('SubCategory');
		$this->loadModel('Event');
		
		$page= isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$loginMemId=convert_uudecode(base64_decode($id));
		$this->set(compact('id'));
		$this->StudentApplyEvent->unBindModel(array('belongsTo'=>array('Student','Instructor')));
		
		$this->paginate = array('limit'=>$this->pageLimit,'order'=>'StudentApplyEvent.id DESC','conditions'=>array('StudentApplyEvent.student_id'=>$loginMemId),'fields'=>array('StudentApplyEvent.*'),'recursive'=>2);
		$classInfo = $this->paginate('StudentApplyEvent'); 
		//pr($classInfo);die;
		
		$sub_cate_info = $this->StudentApplyEvent->find('list',array('conditions'=>array('StudentApplyEvent.student_id'=>$loginMemId),'fields'=>array('StudentApplyEvent.event_id')));
		
		$event_sab_cate = $this->Event->find('list',array('conditions'=>array('Event.id'=>$sub_cate_info),'fields'=>array('Event.sub_cate_id')));
		$AllSubCate = $this->SubCategory->find('list',array('conditions'=>array('SubCategory.id'=>$event_sab_cate),'fields'=>array('SubCategory.id','SubCategory.name')));		
		//pr($classInfo); die;
		
		$this->set(compact('classInfo','page','loginMemId','AllSubCate'));
		
		if($this->RequestHandler->isAjax())
		{
			$this->layout = '';
			$this->autoRender = false;
			$this->render('/Elements/adminElements/events/events_student_list');
		}
	}
	
	function admin_EventSearchStudent()
	{
		$this->loadModel('Event');
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$student_id=$this->data['Event']['mem_id']; 
		if(isset($this->params['named']['page']))
		{
			
		}else{
			$this->request->params['named']['page'] = 1;
		}
		$condition=array();
		$qryStr='';
		if(isset($this->params['named']['condition']))
		{
			$condition=$this->sort_event_student_search();		
			$qryStr=$this->params['named']['condition'];
		}
		else
		{
			if($this->data['Event']['type']=="title" && trim($this->data['Event']['text'])!=''){
				$condition=array_merge($condition,array("Event.title LIKE"=>"%".trim($this->data['Event']['text'])."%"));
				$qryStr=$qryStr."Event.title LIKE-||".'%'.trim($this->data['Event']['text']).'%'."||-";
			}
			if($this->data['Event']['type']=="subcategory" && $this->data['Event']['select']!=''){
				$condition=array_merge($condition,array("Event.sub_cate_id"=>$this->data['Event']['select']));
				$qryStr=$qryStr."Event.sub_cate_id-||".$this->data['Event']['select']."||-";
			}
			if($this->data['Event']['type']=="zipcode" && trim($this->data['Event']['text'])!=''){
				$condition=array_merge($condition,array("Event.zip_code"=>trim($this->data['Event']['text'])));
				$qryStr=$qryStr."Event.zip_code-||".trim($this->data['Event']['text'])."||-";
			}	
			$query=$this->Event->find('all',array('conditions'=>$condition,'recursive'=>2));
			if(!isset($this->params['named']['condition'])){			
				$qryStr=base64_encode($qryStr);
			}	
		}
		$this->set('qryStr',$qryStr);
		if($this->RequestHandler->isAjax()) 
		{
			$this->layout="";
			$this->autoRender=false;
			$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Event.id DESC','conditions'=>$condition,'recursive'=>2);
			$this->Event->unBind(array('belongsTo'=>array('Category','SubCategory','Member','Country')));
			$classInfo = $this->paginate('Event');
			$this->set(compact('classInfo','page'));
			$this->viewPath = 'Elements'.DS.'adminElements/events';
			$this->render('search_events_student_list');
		}		
		else
		{
			echo "error";die;
		}	
	
	}
	function sort_event_student_search()
	{
		$conditions=array();
		$action = $this->params['action'];
		//echo $model[$action];
		if(isset($this->params['named']['condition']))
		{
			$this->set('qryStr',$this->params['named']['condition']);
			$qryStr=$this->params['named']['condition'];
			$con=explode("||-",base64_decode($qryStr));
			if($con[count($con)-1]=='')
			{
				array_pop($con);
			}
			
			$or['OR']=array();
			foreach($con as $val):
				$qry=explode("-||",$val);
				//print_r($qry);
				if($qry[0]=="Event.teacher_name LIKE")
				{	
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Event.teacher_name LIKE'=>$qry[1]));
				}
				if($qry[0]=="Event.class LIKE")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.class LIKE'=>$var));
				}
			endforeach;
		}
		return $conditions;
	}
	
	function admin_instructor_contact_admin()
	{
		
		$this->layout='admin';
		$this->loadModel('ContactAdmin');
		
		$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'ContactAdmin.id DESC'); 
		$info=$this->paginate('ContactAdmin');
		$this->set(compact('info','page'));
		
		if($this->RequestHandler->isAjax()){
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath='Elements'.DS.'adminElements/cmsPages';
			$this->render('contact_admin_list');
		}
	}
	function admin_view_contact($id=NULL)
	{
		
		$this->layout='admin';
		$this->loadModel('ContactAdmin');
		
		$id = convert_uudecode(base64_decode($id));
		$info = $this->ContactAdmin->find('first',array('conditions'=>array('ContactAdmin.id'=>$id)));
		$this->set(compact('info'));
	}
	function admin_contactAdminSearch($condition=null)
	{
		$this->loadModel('ContactAdmin');
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		if(isset($this->params['named']['page']))
		{
			
		}else{
			$this->request->params['named']['page'] = 1;
		}
		$condition=array();
		$qryStr='';
		if(isset($this->params['named']['condition']))
		{
			$condition=$this->contact_admin_sort_condition();		
			$qryStr=$this->params['named']['condition'];
		}
		else
		{
			if($this->data['ContactAdmin']['type']=="first_name" && trim($this->data['ContactAdmin']['text'])!=''){
				$condition=array_merge($condition,array("Member.first_name LIKE"=>"%".trim($this->data['ContactAdmin']['text'])."%"));
				$qryStr=$qryStr."Member.first_name LIKE-||".'%'.trim($this->data['ContactAdmin']['text']).'%'."||-";
			}
			if($this->data['ContactAdmin']['type']=="last_name" && trim($this->data['ContactAdmin']['text'])!=''){
				$condition=array_merge($condition,array("Member.last_name LIKE"=>"%".trim($this->data['ContactAdmin']['text'])."%"));
				$qryStr=$qryStr."Member.last_name LIKE-||".'%'.trim($this->data['ContactAdmin']['text']).'%'."||-";
			}
			if($this->data['ContactAdmin']['type']=="subject" && trim($this->data['ContactAdmin']['text'])!=''){
				$condition=array_merge($condition,array("ContactAdmin.subject LIKE"=>"%".trim($this->data['ContactAdmin']['text'])."%"));
				$qryStr=$qryStr."ContactAdmin.subject LIKE-||".'%'.trim($this->data['ContactAdmin']['text']).'%'."||-";
			}
			$query=$this->ContactAdmin->find('all',array('conditions'=>$condition));
			if(!isset($this->params['named']['condition'])){			
				$qryStr=base64_encode($qryStr);
			}	
		}
		$this->set('qryStr',$qryStr);
		if($this->RequestHandler->isAjax()) 
		{
			$this->layout="";
			$this->autoRender=false;
			$this->paginate=array('limit'=>$this->pageLimit,'conditions'=>$condition);
			$info = $this->paginate('ContactAdmin');
			$this->set(compact('info','page'));				
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('search_contact_admin_list');
		}		
		else
		{
			echo "error";die;
		}	
	}
	function contact_admin_sort_condition()
	{
		$conditions=array();
		$action = $this->params['action'];
		//echo $model[$action];
		if(isset($this->params['named']['condition']))
		{
			$this->set('qryStr',$this->params['named']['condition']);
			$qryStr=$this->params['named']['condition'];
			
			$con=explode("||-",base64_decode($qryStr));
			if($con[count($con)-1]=='')
			{
				array_pop($con);
			}
			foreach($con as $val):
				$qry=explode("-||",$val);
				
				if($qry[0]=="Member.first_name LIKE")
				{	
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.first_name LIKE'=>$qry[1]));
					
				}
				if($qry[0]=="Member.last_name LIKE")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Member.last_name LIKE'=>$var));
				}
				if($qry[0]=="ContactAdmin.subject LIKE")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('ContactAdmin.subject LIKE'=>$var));
				}
				
			endforeach;
		}
		return $conditions;
	}
	function admin_contact_admin_result($query=NULL)
	{
		$this->loadModel('ContactAdmin');
		$data = "S.No.,Name,Subject,Message,Date Added\n";
		$condition=array();
		$qryStr='';
		if(!isset($this->params['named']['condition'])){
			$this->request->params['named']['condition']=$query;
			$condition=$this->contact_admin_sort_condition();
			//pr($condition); die;
			$qryStr=$this->params['named']['condition'];
		}
		$info = $this->ContactAdmin->find('all',array('conditions'=>$condition));
		$i=1;
		foreach($info as $info){
			$data .= $i.",";
			$data .= $info['Member']['first_name'].' '.$info['Member']['last_name'].",";
			$data .= str_replace(',',' ',$info['ContactAdmin']['subject']).",";
			$data .= str_replace(',',' ',$info['ContactAdmin']['message']).",";
			$data .= $info['ContactAdmin']['date_added']."\n";
			$i++;
		}
		header("Content-Type: application/csv");
		header("Content-Disposition:attachment;filename=contact_records.csv");
		echo $data;
		die();
	}
	function admin_student_contact_instructor()
	{
		$this->layout='admin';
		$this->loadModel('ContactInstructor');
		
		$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'ContactInstructor.id DESC');
		$info=$this->paginate('ContactInstructor');
		$this->set(compact('info','page'));
		
		if($this->RequestHandler->isAjax()){
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath='Elements'.DS.'adminElements/cmsPages';
			$this->render('contact_instructor_list');
		}
	}
	function admin_view_contact_student($id=NULL)
	{
		
		$this->layout='admin';
		$this->loadModel('ContactInstructor');
		
		$id = convert_uudecode(base64_decode($id));
		$info = $this->ContactInstructor->find('first',array('conditions'=>array('ContactInstructor.id'=>$id)));
		$this->set(compact('info'));
	}
	function admin_contactStudentSearch($condition=NULL)
	{
		$this->loadModel('ContactInstructor'); 
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		if(isset($this->params['named']['page']))
		{
			
		}else{
			$this->request->params['named']['page'] = 1;
		}
		$condition=array(); 
		$qryStr='';
		if(isset($this->params['named']['condition']))
		{
			$condition=$this->contact_student_sort_condition();		
			$qryStr=$this->params['named']['condition'];
		}
		else
		{	
			
			if($this->data['ContactInstructor']['type']=="first_name" && trim($this->data['ContactInstructor']['text'])!=''){
				$condition=array_merge($condition,array("Student.first_name LIKE"=>"%".trim($this->data['ContactInstructor']['text'])."%"));
				$qryStr=$qryStr."Student.first_name LIKE-||".'%'.trim($this->data['ContactInstructor']['text']).'%'."||-";
			}
			if($this->data['ContactInstructor']['type']=="last_name" && trim($this->data['ContactInstructor']['text'])!=''){
				$condition=array_merge($condition,array("Student.last_name LIKE"=>"%".trim($this->data['ContactInstructor']['text'])."%"));
				$qryStr=$qryStr."Student.last_name LIKE-||".'%'.trim($this->data['ContactInstructor']['text']).'%'."||-";
			}
			if($this->data['ContactInstructor']['type']=="email" && trim($this->data['ContactInstructor']['text'])!=''){
				$condition=array_merge($condition,array("Student.email LIKE"=>"%".trim($this->data['ContactInstructor']['text'])."%"));
				$qryStr=$qryStr."Student.email-||".'%'.trim($this->data['ContactInstructor']['text']).'%'."||-";
			}
		
			$query=$this->ContactInstructor->find('all',array('conditions'=>$condition)); 
			if(!isset($this->params['named']['condition'])){			
				$qryStr=base64_encode($qryStr);
			}	
		}
		$this->set('qryStr',$qryStr);
		if($this->RequestHandler->isAjax()) 
		{
			$this->layout="";
			$this->autoRender=false;
			$this->paginate=array('limit'=>$this->pageLimit,'conditions'=>$condition);
			$info = $this->paginate('ContactInstructor');
			$this->set(compact('info','page'));				
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('search_contact_instructor_list');
		}		
		else
		{
			echo "error";die;
		}
	}
	//-----------------------------student Bulletins---------------------
	function admin_bulletins($m_id=NULL)
	{
		$this->layout="admin";
		$this->loadModel("StudentApplyEvent");
		$this->loadModel("Broadcast");
		$page= isset($this->params['named']['page'])?$this->params['named']['page']:'1';
 		$id=convert_uudecode(base64_decode($m_id)); 
		$instructor_id = $this->StudentApplyEvent->find('list',array('conditions'=>array('StudentApplyEvent.Student_id'=>$id,'StudentApplyEvent.request_status'=>'accept'),'fields'=>array('StudentApplyEvent.teacher_id')));
		$instructor_id = array_unique($instructor_id);
		
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Broadcast.Id DESC');
		$conditions = array('Broadcast.m_id'=>$instructor_id,'Broadcast.student_view'=>'accept');
		$info = $this->paginate('Broadcast',$conditions);
		
		$this->set(compact('info','page','m_id'));
		//pr($info); die;
		if($this->RequestHandler->isAjax())
		{
			$this->layout="";
			$this->viewPath = 'Elements'.DS.'adminElements/events';
			$this->render('bulletin_list');
		}
	}
	
	
	function admin_delete_bulletin($page=NULL,$d_id=NULL,$tableName=NULL,$renderPath=NULL,$renderElement=NULL,$m_id=NULL)
	{
		$this->loadModel("StudentApplyEvent");
		$this->loadModel("Broadcast");
		
		$tableName=base64_decode($tableName);
		$renderPath=base64_decode($renderPath); 
		$renderElement=base64_decode($renderElement);
		$M_id=convert_uudecode(base64_decode($m_id)); 
		$bulletin_id=convert_uudecode(base64_decode($d_id)); 
		$instructor_id = $this->StudentApplyEvent->find('list',array('conditions'=>array('StudentApplyEvent.Student_id'=>$M_id,'StudentApplyEvent.request_status'=>'accept'),'fields'=>array('StudentApplyEvent.teacher_id')));
		$instructor_id = array_unique($instructor_id);
		
		//echo $tableName. "-".$broadcastId. "-".$renderPath. "-".$renderElement. "-".$memId. "-".$broadcastId;die;
		if($this->RequestHandler->isAjax())
		{		
			$this->layout=false;
			$this->autoRender = false;				
			$getRec = $this->$tableName->find('first',array('conditions'=>array($tableName.'.id'=>$bulletin_id)));
			if(!empty($getRec))
			{
				
				$this->$tableName->delete(array($tableName.'.id'=>$bulletin_id));
			}
			$conditions = array('Broadcast.m_id'=>$instructor_id,'Broadcast.student_view'=>'accept');		   	
			$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
			$info = $this->paginate($tableName,$conditions);
			
			if(empty($info) && $page>1)
			{
				$page=$page-1;
				$this->paginate=array('limit'=>$this->pageLimit,'Broadcast.m_id'=>$instructor_id,'page'=>$page,'order'=>$tableName.'.id DESC');
				$info = $this->paginate($tableName,$conditions);
			} 
			$this->set(compact('info','page','m_id'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render($renderElement);			
		}
	}
	
	//-----------------------------EOF-----------------------------------
	function contact_student_sort_condition()
	{	
		$conditions=array();
		$action = $this->params['action'];
		if(isset($this->params['named']['condition']))
		{
			$this->set('qryStr',$this->params['named']['condition']);
			$qryStr=$this->params['named']['condition'];
			$con=explode("||-",base64_decode($qryStr));
			if($con[count($con)-1]=='')
			{
				array_pop($con);
			}
			foreach($con as $val):
				$qry=explode("-||",$val);
				if($qry[0]=="Student.first_name LIKE")
				{	
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Student.first_name LIKE'=>$qry[1]));
				}
				if($qry[0]=="Student.last_name LIKE")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Student.last_name LIKE'=>$var));
				}
				if($qry[0]=="Event.title LIKE")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Event.title LIKE'=>$var));
				}
				if($qry[0]=="Student.email")
				{
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Student.email'=>$var));
				}
			endforeach;
		}
		
		return $conditions;
	}
	function admin_contact_student_result($query=NULL)
	{
		$this->loadModel('ContactInstructor');
		$data = "S.No.,Student Name,Instructor Name,Event,E-Mail,Message,Date Added\n";
		$condition=array();
		$qryStr='';
		if(!isset($this->params['named']['condition'])){
			$this->request->params['named']['condition']=$query;
			$condition=$this->contact_student_sort_condition();
			$qryStr=$this->params['named']['condition'];
		}
		$info = $this->ContactInstructor->find('all',array('conditions'=>$condition));
		$i=1;
		foreach($info as $info){
			$data .= $i.",";
			$data .= $info['Student']['first_name'].' '.$info['Student']['last_name'].",";
			$data .= $info['Instructor']['first_name'].' '.$info['Instructor']['last_name'].",";
			$data .= $info['Event']['title'].",";
			$data .= $info['Student']['email'].",";
			$data .= str_replace(',',' ',$info['ContactInstructor']['message']).",";
			$data .= $info['ContactInstructor']['send_date']."\n";
			$i++;
		}
		header("Content-Type: application/csv");
		header("Content-Disposition:attachment;filename=contact_records.csv");
		echo $data;
		die();
	}
	
	function admin_send_mail($id=NULL)
	{
		$this->layout='admin';
		$this->set(compact('id'));
		if(!empty($this->data))
		{
			$errors=array();
			$errors=$this->check_mail($this->data);
			if(count($errors)==0){
				$data = $this->data;
				
				$id=convert_uudecode(base64_decode($data['SendMail']['id']));
				$member = $this->Member->find('first',array('conditions'=>array('Member.id'=>$id)));
				$admin = $this->Admin->find('first',array('conditions'=>array('Admin.id'=>1)));
				
				$emailFrom = $admin['Admin']['email'];
				$emailTo = $member['Member']['email'];
				$emailSubject = $data['SendMail']['subject'];
				$emailData = $data['SendMail']['message'];
				$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);
				
				$this->Session->write('success','E-Mail sent successfully');
				$this->redirect(array('controller'=>'users','action'=>'send_mail/'.$data['SendMail']['id'],'admin'=>true));
			}
			else
			{
				$this->set('error',$errors);
				$this->data=$this->data;
			}
		}
	}
	function check_mail($data)
	{			
		$errors = array ();
		if(trim($data['SendMail']['subject']==""))
		{
			$errors['subject'] []= __(FIELD_REQUIRED,true)."\n";
		}
		if(strip_tags($data['SendMail']['message'])=="")
		{
			$errors ['message'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		return $errors;
	}
	function admin_update_status_mail($m_id=NULL)
	{
		$this->layout='admin';
		$this->loadModel("Event");
		$id=convert_uudecode(base64_decode($m_id));
		$this->set(compact('m_id'));
		if(!empty($this->data))
		{
			$errors=array();
			$errors=$this->check_mail($this->data);
			if(count($errors)==0){
				$data = $this->data;
				$id=convert_uudecode(base64_decode($data['SendMail']['id']));
				
				$getRec = $this->Event->find('first',array('conditions'=>array('Event.id'=>$id)));
				$admin = $this->Admin->find('first',array('conditions'=>array('Admin.id'=>1)));
				
				$emailFrom = $admin['Admin']['email'];
				$emailTo = $getRec['Member']['email'];
				$emailSubject = $data['SendMail']['subject'];
				$emailData = $data['SendMail']['message'];
				$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);
				
				$field=array();
				if(!empty($getRec)){
					if($getRec['Event']['status']=='0'){
						$this->Event->id=$id;					
						$field['Event']['status'] = 1;					
						$this->Event->save($field);
					}else{
						$this->Event->id=$id;					
						$field['Event']['status'] = '0';					
						$this->Event->save($field);					
					}
				}
				$mem_id = base64_encode(convert_uuencode($getRec['Member']['id']));
				$this->Session->write('SuccessMessage','Record has been updated successfully');
				$this->redirect(array('controller'=>'users','action'=>'events/'.$mem_id,'admin'=>true));
			}
			else
			{
				$this->set('error',$errors);
			}
		}
	}
	function admin_delete_record_mail($m_id=NULL)
	{
		$this->layout='admin';
		$this->loadModel("Event");
		$this->loadModel("StudentApplyEvent");
		$this->loadModel("Admin");
		$this->loadModel("Member");
		$this->loadModel('SendInvitation');
		
		$id=convert_uudecode(base64_decode($m_id));
		$this->set(compact('m_id'));
		
		if(!empty($this->data))
		{
			$errors=array();
			$errors=$this->check_mail($this->data);
			if(count($errors)==0){
				$data = $this->data;
				$id=convert_uudecode(base64_decode($data['SendMail']['id']));
				
				$getRec = $this->Event->find('first',array('conditions'=>array('Event.id'=>$id)));
				$admin = $this->Admin->find('first',array('conditions'=>array('Admin.id'=>1)));
				
				$emailFrom = $admin['Admin']['email'];
				$emailTo = $getRec['Member']['email'];
				$emailSubject = $data['SendMail']['subject'];
				$emailData = $data['SendMail']['message'];
				$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);
				
				if(!empty($id))
				{
					if($this->Event->delete($id))
					{
						$this->loadModel('InstructorAssignment');
						$this->loadModel('InstructorAssignmentStudent');
						$this->loadModel('InstructorAssignmentDocument');
						$this->loadModel('SendInvitation');
						$this->loadModel('StudentRepository');
						$this->loadModel('InstructorAssignmentRemark');
						$this->loadModel('SendInvitation'); 
						
						$this->SendInvitation->deleteAll(array('SendInvitation.e_id'=>$id),false);
						$this->StudentApplyEvent->deleteAll(array('StudentApplyEvent.event_id'=>$id),false);
						$this->SendInvitation->deleteAll(array('SendInvitation.e_id'=>$id),false);
						
						$assignments = $this->InstructorAssignment->find('all',array('conditions'=>array('InstructorAssignment.e_id'=>$id)));
			
						if(!empty($assignments)){
							$this->InstructorAssignment->deleteAll(array('InstructorAssignment.e_id'=>$id),false);
							foreach($assignments as $assignments){
								$assignmentsStudents = $this->InstructorAssignmentStudent->find('all',array('conditions'=>array('InstructorAssignmentStudent.inst_assign_id'=>$assignments['InstructorAssignment']['id'])));
								if(!empty($assignmentsStudents)){
									$this->InstructorAssignmentStudent->deleteAll(array('InstructorAssignmentStudent.inst_assign_id'=>$assignments['InstructorAssignment']['id']),false);
									foreach($assignmentsStudents as $assignmentsStudents){
										$assignmentsStudentsDocument = $this->InstructorAssignmentDocument->find('all',array('conditions'=>array('InstructorAssignmentDocument.assign_id'=>$assignmentsStudents['InstructorAssignmentStudent']['id'])));
										$assignmentsStudentsRemark = $this->InstructorAssignmentRemark->find('all',array('conditions'=>array('InstructorAssignmentRemark.student_assign_id'=>$assignmentsStudents['InstructorAssignmentStudent']['id'])));
										if(!empty($assignmentsStudentsRemark)){
											$this->InstructorAssignmentRemark->deleteAll(array('InstructorAssignmentRemark.student_assign_id'=>$assignmentsStudents['InstructorAssignmentStudent']['id']),false);				
										}
										if(!empty($assignmentsStudentsDocument)){
											$this->InstructorAssignmentDocument->deleteAll(array('InstructorAssignmentDocument.assign_id'=>$assignmentsStudents['InstructorAssignmentStudent']['id']),false);
											
											foreach($assignmentsStudentsDocument as $assignmentsStudentsDocument){
												if(file_exists('files/'.$assignmentsStudents['InstructorAssignmentStudent']['s_id'].'/personal_repo/'.$assignmentsStudentsDocument['InstructorAssignmentDocument']['file_name'])){
													unlink('files/'.$assignmentsStudents['InstructorAssignmentStudent']['s_id'].'/personal_repo/'.$assignmentsStudentsDocument['InstructorAssignmentDocument']['file_name']);
												}
												$this->StudentRepository->deleteAll(array('StudentRepository.doc_id'=>$assignmentsStudentsDocument['InstructorAssignmentStudent']['id'],'StudentRepository.type'=>'Assignment'),false);
											}
										}
									}
								}
							}
						}
					}
				}
				
				$mem_id = base64_encode(convert_uuencode($getRec['Member']['id']));
				$this->Session->write('SuccessMessage','Record has been deleted successfully');
				$this->redirect(array('controller'=>'users','action'=>'events/'.$mem_id,'admin'=>true));
			}
			else
			{
				$this->set('error',$errors);
			}
		}
	}
	
	function admin_broadcasts($m_id=NULL)
	{
		$this->layout="admin"; 
		$this->loadModel("Event");
		$this->loadModel("Broadcast");
		$page= isset($this->params['named']['page'])?$this->params['named']['page']:'1';
 		
		$id=convert_uudecode(base64_decode($m_id));
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Broadcast.Id DESC');
		$conditions = array('Broadcast.m_id'=>$id);
		$info = $this->paginate('Broadcast',$conditions);
		
		$this->set(compact('info','page','m_id'));
		
		if($this->RequestHandler->isAjax())
		{
			$this->layout="";
			$this->viewPath = 'Elements'.DS.'adminElements/events';
			$this->render('broadcast_list');
		}
	}
	
	function admin_add_broadcast($id=NULL)
	{
		$this->layout="admin";
		$this->loadModel("Broadcast");
		$this->loadModel("StudentApplyEvent");
		
		$memberId = convert_uudecode(base64_decode($id));
		$this->set(compact('memberId','id'));
		
		$all_events = $this->StudentApplyEvent->find('list',array('conditions'=>array('StudentApplyEvent.teacher_id'=>$memberId,'StudentApplyEvent.request_status'=>'accept'),'fields'=>array('StudentApplyEvent.id','StudentApplyEvent.student_id')));
		
		$all_student = '';
		if(count($all_events) !=''){
			$this->loadModel('Member');
			$this->Member->Behaviors->attach('Containable');
			$all_student = $this->Member->find('all',array('conditions'=>array('Member.id'=>$all_events),'contain'=>array(),'fields'=>array('Member.id','Member.first_name','Member.last_name','Member.email')));
		}
		
		$this->set(compact('all_student'));
		if(!empty($this->data))
		{
			$error = array();
			$error = $this->validate_add_broadCast_steps($this->data);
			if(count($error) == '0')
			{ 
				if($this->data['Broadcast']['type'] == 'File')
				{
					if($this->data['Broadcast']['file']['name']!='' && $this->data['Broadcast']['file']['error']==0)
					{					
						$destination = realpath('../../app/webroot/files/broadCast') .'/';
						$imgName = pathinfo($this->data['Broadcast']['file']['name']);
						$ext = strtolower($imgName['extension']);
						$name = explode(".",$this->data['Broadcast']['file']['name']);
						if(in_array($ext,array('doc','pdf','txt','ppt','pptx','docx','jpeg','jpg','png')))
						{
							$newImgName = time().".".$ext;
							$image = $this->data['Broadcast']['file'];
							$result = $this->Upload->upload($image, $destination, $newImgName, array());											
							if($result)
							{
								$this->request->data['Broadcast']['file_name'] = $newImgName;								
							}
						}else{
							$error ['file'] [] = __('Please upload (doc, pdf, txt, ppt, pptx, docx, jpeg, jpg and png) files only',true)."\n";
							$this->set('error',$error);
						}
					} else {
						$error ['file'] [] = __('Please select file',true)."\n";
						$this->set('error',$error);
					}
				} 
				elseif($this->data['Broadcast']['type'] == 'Video'){
					$videoName = str_replace(array('/watch?','='),'/',$this->data['Broadcast']['url']);
					$this->request->data['Broadcast']['file_name'] = trim($videoName);
				}	
				else{
					$this->request->data['Broadcast']['type'] = 'Message';
					$this->request->data['Broadcast']['file_name'] = '';
				}			
				if(count($error) == '0')
				{
					$id = base64_encode(convert_uuencode($this->data['Broadcast']['t_id']));
					
					$this->loadModel('Broadcast');
					$this->request->data['Broadcast']['m_id'] = $this->data['Broadcast']['t_id'];
					$this->request->data['Broadcast']['date_added'] = date('Y-m-d');
					if($this->Broadcast->save($this->data)){
						$b_id = $this->Broadcast->getlastInsertId();
						$this->loadModel('BroadcastStudent');
						$s_id = array_filter($this->data['Broadcast']['students_id']);
						foreach($s_id as $students){
							
							$data['BroadcastStudent']['s_id'] = $students;
							$data['BroadcastStudent']['t_id'] = $memberId;
							$data['BroadcastStudent']['b_id'] = $b_id;
							$this->BroadcastStudent->create();
							if($this->BroadcastStudent->save($data)){
								$student_info = $this->Member->find('first',array('conditions'=>array('Member.id'=>$students),'fields'=>array('Member.email','Member.first_name','Member.last_name')));	
							
								$emailTemplate = $this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>'31')));
								$emailData = $emailTemplate['EmailTemplate']['description'];						
								$emailData = str_replace(array('{first_name}','{last_name}'),array(ucfirst($student_info['Member']['first_name']),ucfirst($student_info['Member']['last_name'])),$emailData);							
								   
								$emailTo = $student_info['Member']['email'];
								$emailFrom = $emailTemplate['EmailTemplate']['email_from'];
								$emailSubject = $emailTemplate['EmailTemplate']['subject'];
								//echo $emailTo.'//'.$emailFrom.'//'.$emailData;die;
								$this->send_email($emailTo,$emailFrom,$emailSubject,$emailData);
							}
						}
					}
					if($this->request->data['Broadcast']['type'] == 'File'){
						$this->Session->write('SuccessMessage','File has been added successfully.');
					}elseif($this->request->data['Broadcast']['type'] == 'Video'){
						$this->Session->write('SuccessMessage','Video has been added successfully.');
					}else{
						$this->Session->write('SuccessMessage','Message has been added successfully.');
					}
					
					$this->redirect(array('controller'=>'Users','action'=>'broadcasts/'.$id));
				}
			} else {
				$this->set('error',$error);
			}
			
		}
	}
	
	function validate_admin_add_broadCast_ajax()
	{
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())	{
			$errors_msg = null;
			$errors=$this->validate_add_broadCast_steps($this->data);					
			if ( is_array ( $this->data ) )	{
				foreach ($this->data['Broadcast'] as $key => $value ){
					if( array_key_exists ( $key, $errors) )	{
						foreach ( $errors [ $key ] as $k => $v ){
							$errors_msg .= "error|$key|$v";
						}	
					}
					else {
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}
	}
	function validate_add_broadCast_steps($data)
	{		
		$errors = array ();
		//pr($this->data);
		if($data['Broadcast']['type']==''){
			if($data['Broadcast']['comment']==''){
				$errors ['comment'] [] = __('Please enter your message in comment box',true)."\n";
			}
		}
		if(trim($data['Broadcast']['type'])!="" && trim($data['Broadcast']['type'])=='Video'){
			if($data['Broadcast']['url'] == ''){
				$errors ['url'] [] = __(FIELD_REQUIRED,true)."\n";
			}
			elseif (!preg_match('@^(?:http://(?:www\.)?youtube.com/)(watch\?v=|v/)([a-zA-Z0-9_]*)@', $data['Broadcast']['url'])) 
			{
				$errors ['url'] [] = __('Please enter valid youtube url.',true)."\n";
			} 
		}
		
		if(isset($data['Broadcast']['title'])){
			if(trim($data['Broadcast']['title'])=="")	{
				$errors ['title'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		else{
			$errors ['title'] [] = __(FIELD_REQUIRED,true)."\n";
		}		
		if(isset($data['Broadcast']['students_id'])){
				if(!empty($data['Broadcast']['students_id'])){
					$ids = array();
					
					foreach($data['Broadcast']['students_id'] as $students){				
						if($students != '' && $students != 0 && ctype_digit($students)){
							array_push($ids,$students);
						}
					}
					if(count($ids) == 0){
						$errors ['checkall'] [] = __('Please select atleast one student',true)."\n";
					}
				}else{
					$errors ['checkall'] [] = __('Please select atleast one student',true)."\n";
				}
			}else{
				$errors ['checkall'] [] = __('Please select atleast one student',true)."\n";
			}
		return $errors;			
	}
	
	function admin_delete_broadcast($page=NULL,$d_id=NULL,$tableName=NULL,$renderPath=NULL,$renderElement=NULL,$m_id=NULL)
	{
		$this->loadModel('Broadcast');
		$broadcastId = convert_uudecode(base64_decode($d_id));
		$tableName=base64_decode($tableName);
		$renderPath=base64_decode($renderPath); 
		$renderElement=base64_decode($renderElement);
		$memId = convert_uudecode(base64_decode($m_id));
		//echo $tableName. "-".$broadcastId. "-".$renderPath. "-".$renderElement. "-".$memId. "-".$tableName;die;
		if($this->RequestHandler->isAjax())
		{		
			$this->layout=false;
			$this->autoRender = false;				
			$getRec = $this->$tableName->find('first',array('conditions'=>array($tableName.'.id'=>$broadcastId)));
			$conditions = array('Broadcast.m_id'=>$memId);
			if(!empty($getRec))
			{				
				$this->$tableName->delete(array($tableName.'.id'=>$broadcastId));
			}		   	

			$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
			$info = $this->paginate($tableName,$conditions);
			
			if(empty($info) && $page>1)
			{
				$page=$page-1;				
				$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>$tableName.'.id DESC');
				$info = $this->paginate($tableName,$conditions);
			} 
			$this->set(compact('info','page','m_id'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render($renderElement);			
		}
	}
	
	function admin_watch_broadcast_video($id=NULL)
	{
		$this->layout="admin";
		
		$this->loadModel('VideoLink');
		$id=convert_uudecode(base64_decode($id));
		$video=$this->Broadcast->findById($id);
		if(!empty($video)){
			$this->set('video',$video);
		}
		else{
			$this->redirect(array('action'=>'edit_instructor','admin'=>true));
		}
	
	}
	
	function admin_broadcast_remark($id=NULL)
	{
		$this->layout='admin';	
		$broadcast_id = convert_uudecode(base64_decode($id));	
		$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		//pr($this->params); die;
		
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'BroadcastRemark.id DESC','conditions'=>array('BroadcastRemark.b_id'=>$broadcast_id));
		$info	=	$this->paginate('BroadcastRemark');
		//pr($info);die;
		$this->set(compact('info','page','id'));
		
		if($this->RequestHandler->isAjax())
		{
			 $this->layout="";
			 $this->viewPath = 'Elements'.DS.'adminElements/events';
			 $this->render('broadcast_remark_list');
		}
	}
	function admin_download_file($name=NULL)
	{
		if(!empty($name))
		{
			$file=explode('.',$name);
			$newPath = 'files/broadcast/'.$name;
			if(file_exists($newPath))
			{	
				$size = filesize($newPath);
				header("Content-type: application/".trim($file[1]));
				header("Content-Length:".$size);
				header("Content-Disposition: attachment; filename=".$name);
				$fp = fread(fopen($newPath,'r'),$size);
				echo $fp;								
			}
		}
		die();
	}
	function admin_pending_student_approval($m_id=NULL)
	{
		$this->layout="admin";
		$this->loadModel("StudentApplyEvent");
		$id = convert_uudecode(base64_decode($m_id)); 
		
		$this->paginate = array('limit'=>$this->pageLimit,'order'=>'StudentApplyEvent.id DESC','recursive'=>2);
		$conditions = array('StudentApplyEvent.teacher_id'=>$id,'StudentApplyEvent.request_status'=>'pending');
		$info = $this->paginate('StudentApplyEvent',$conditions);
		//pr($info); die; 
		$this->set(compact('info','m_id'));
		
	}
	function admin_view_pending_approval($m_id=NULL)
	{
		$this->layout="admin";
		$this->loadModel("StudentApplyEvent");
		$id = convert_uudecode(base64_decode($m_id));
		$info = $this->StudentApplyEvent->find('first',array('conditions'=>array('StudentApplyEvent.id'=>$id),'recursive'=>2));
		
		$this->set(compact('info','m_id'));
	}
	function admin_delete_pending_appproval($id=NULL,$m_id=NULL)
	{
		$this->loadModel("StudentApplyEvent");
		$id = convert_uudecode(base64_decode($id));
		if(!empty($id))
		{
			$this->StudentApplyEvent->delete($id);
		}
		$this->Session->write('SuccessMessage',"Recored has been deleted successfully");
		$this->redirect(array('controller'=>'Users','action'=>'pending_student_approval/'.$m_id));
	}
	
	function admin_assignment($id=NULL)
	{
		$this->layout='admin';	
		$event_id = convert_uudecode(base64_decode($id));	
		$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		//pr($event_id); die;
		$this->loadModel('InstructorAssignment');
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'InstructorAssignment.id DESC','conditions'=>array('InstructorAssignment.e_id'=>$event_id),'contain'=>false);
		$info	=	$this->paginate('InstructorAssignment');
		//pr($info);die;
		$this->set(compact('info','page','id'));
		
		if($this->RequestHandler->isAjax())
		{
			 $this->layout="";
			 $this->viewPath = 'Elements'.DS.'adminElements/events';
			 $this->render('assignment_list');
		}
	}
	function admin_student_assignment($id=NULL,$student_id=NULL)
	{
		$this->layout='admin';	
		$event_id = convert_uudecode(base64_decode($id));
		$s_id = convert_uudecode(base64_decode($student_id));	
		$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		//pr($event_id); die;
		$this->loadModel('InstructorAssignmentStudent');
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'InstructorAssignmentStudent.id DESC','conditions'=>array('InstructorAssignmentStudent.e_id'=>$event_id,'InstructorAssignmentStudent.s_id'=>$s_id));
		$info	=	$this->paginate('InstructorAssignmentStudent');
		//pr($info);die;
		$this->set(compact('info','page','id','student_id'));
		
		if($this->RequestHandler->isAjax())
		{
			 $this->layout="";
			 $this->viewPath = 'Elements'.DS.'adminElements/events';
			 $this->render('student_assignment_list');
		}
	}
	function admin_assignment_remark($id=NULL)
	{
		$this->layout='admin';	
		$assigmnet_id = convert_uudecode(base64_decode($id));	
		$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		//pr($assigmnet_id); die;
		$this->loadModel('InstructorAssignmentRemark');
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'InstructorAssignmentRemark.id DESC','conditions'=>array('InstructorAssignmentRemark.student_assign_id'=>$assigmnet_id));
		$info	=	$this->paginate('InstructorAssignmentRemark');
		//pr($info);die;
		$this->set(compact('info','page','id'));
		
		if($this->RequestHandler->isAjax())
		{
			 $this->layout="";
			 $this->viewPath = 'Elements'.DS.'adminElements/events';
			 $this->render('assignment_remark_list');
		}
	}
	
	function admin_download($path=NULL,$file=NULL)
	{
		$path = str_replace("-","/",$path);
		$this->viewClass = 'Media';
		
		if(file_exists($path.$file)){
			$fileName = pathinfo($file);
			$this->viewClass = 'Media';
			$params = array(
				'id'        => $file,
				'name'      => $fileName['filename'],
				'download'  => true,
				'cache'		=> false,
				'path'      => $path . DS
			);
			$this->set($params);
		}
		else{
			$this->redirect(array('controller'=>'Users','action'=>'dashboard'));
			
		}		
	}
	
	//---Seraching Broadcast --RAHUL---//
	

	function admin_broadcastSearch()
	{
		$this->loadModel('Member');
		$this->loadModel('Broadcast');
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		if(isset($this->params['named']['page'])){
		}else{
			$this->request->params['named']['page'] = 1;
		}
		$condition=array();
		$qryStr='';
		
		if(isset($this->params['named']['condition']))
		{
			$condition=$this->sort_broadcast();		
			$qryStr=$this->params['named']['condition'];
		}
		else
		{	
			$mem_id=$id=convert_uudecode(base64_decode($this->data['Broadcast']['mem_id']));
			if($this->data['Broadcast']['type']=="title" && trim($this->data['Broadcast']['text'])!=''){
				$condition=array_merge($condition,array("Broadcast.title LIKE"=>"%".trim($this->data['Broadcast']['text'])."%"));
				$qryStr=$qryStr."Broadcast.title LIKE-||".'%'.$this->data['Broadcast']['text'].'%'."||-";
			}
			if($this->data['Broadcast']['type']=="type" && trim($this->data['Broadcast']['text'])!=''){
				$condition=array_merge($condition,array("Broadcast.type LIKE"=>"%".trim($this->data['Broadcast']['text'])."%"));
				$qryStr=$qryStr."Broadcast.type LIKE-||".'%'.$this->data['Broadcast']['text'].'%'."||-";
			}
			$condition=array_merge($condition,array("Broadcast.m_id"=>$mem_id)); 
			$query=$this->Broadcast->find('all',array('conditions'=>$condition,'recursive'=>'0'));
			if(!isset($this->params['named']['condition'])){			
				$qryStr=base64_encode($qryStr);
			}	
		}
		$this->set('qryStr',$qryStr);
		if($this->RequestHandler->isAjax()) 
		{
			$this->layout="";
			$this->autoRender=false;
			$this->paginate=array('limit'=>$this->pageLimit,'conditions'=>$condition,'order'=>'Broadcast.Id DESC');
			$info = $this->paginate('Broadcast');
			$this->set(compact('info','page'));				
			$this->viewPath = 'Elements'.DS.'adminElements/events';
			$this->render('broadcast_list');
		}		
		else
		{
			echo "error";die;
		}	
	}
	function sort_broadcast()
	{
		$conditions=array();
		$action = $this->params['action'];
		//echo $model[$action];
		if(isset($this->params['named']['condition']))
		{
			$this->set('qryStr',$this->params['named']['condition']);
			$qryStr=$this->params['named']['condition'];
			$con=explode("||-",base64_decode($qryStr));
			if($con[count($con)-1]=='')
			{
				array_pop($con);
			}
			$or['OR']=array();
			foreach($con as $val):
				$qry=explode("-||",$val);
				//print_r($qry);
				if($qry[0]=="Broadcast.title LIKE")
				{	
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Broadcast.title LIKE'=>$qry[1]));
				}
				if($qry[0]=="Broadcast.type LIKE")
				{	
					$var=str_replace("%","",$qry[1]);
					$conditions=array_merge($conditions,array('Broadcast.type LIKE'=>$qry[1]));
				}
			endforeach;
		}
		return $conditions;
	}
	//-----------------End of search event----------------------------
	function admin_memory_management()
	{
		$this->layout='admin';
		$this->loadModel('MemoryManagement');		
		$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		
		$this->paginate = array('limit'=>$this->pageLimit,'order'=>'MemoryManagement.id DESC');
		$info=$this->paginate('MemoryManagement');
		$this->set(compact('info','page'));
		
		if($this->RequestHandler->isAjax())
		{	
			 $this->layout="";
			 $this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			 $this->render('memory_management');
		}
	}
	
	function admin_edit_memory_managment($id=NULL)
	{
		$this->layout="admin";
		$this->loadModel('MemoryManagement');
		$id = convert_uudecode(base64_decode($id));
		$info = $this->MemoryManagement->find('first',array('conditions'=>array('MemoryManagement.id'=>$id)));
		$this->set(compact('info'));
		
		if(!empty($this->data)){
			//pr($this->data);die;
			$error = array();
			if($this->data['MemoryManagement']['student'] == ''){
				$error['student'][0] = "This field is required!"; 
			}
			elseif(!ctype_digit($this->data['MemoryManagement']['student'])){
				$error['student'][0] = "Only numeric values are allwoed"; 
			}
			
			if($this->data['MemoryManagement']['teacher'] == ''){
				$error['teacher'][1] = "This field is required!"; 
			}
			if(!ctype_digit($this->data['MemoryManagement']['teacher'])){
				$error['teacher'][1] = "Only numeric values are allwoed"; 
			}
			if(count($error) == '0'){
				$this->request->data['MemoryManagement']['date_modified']= date('Y-m-d');
				$this->MemoryManagement->save($this->data);
				$this->Session->write('SuccessMessage','Memory  has been edited Successfully');
				$this->redirect(array('controller'=>'Users','action'=>'memory_management'));
			}else{
				$info = $this->data;
				$this->set(compact('error','info'));
			}
		}
	}
	function admin_blogs($id=NULL)
	{
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		$this->loadModel("Blog");
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$this->set(compact('id'));
		
		$id = convert_uudecode(base64_decode($id));
		$this->paginate = array('limit'=>$this->pageLimit,'order'=>'Blog.id DESC');
		$conditions = array('Blog.m_id'=>$id);
		$info = $this->paginate('Blog',$conditions);
		$this->set(compact('page','info'));
		
		if($this->RequestHandler->isAjax())
		{
			
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('blog_listing');
		}
	}
	
	function admin_view_blog($id=NULL)
	{	
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		$this->loadModel('Blog');
		
		$id = convert_uudecode(base64_decode($id));
		$info = $this->Blog->find('first',array('conditions'=>array('Blog.id'=>$id)));
		$this->set('info',$info);
	}
	
	function admin_add_blog($mem_id=NULL)
	{
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		$this->loadModel('Blog');
		$this->set(compact('mem_id'));
		
		if(!empty($this->data)){
			$errors = array();
			$errors = $this->validate_add_blog_ajax($this->data);
			if(count($errors) == 0)
			{
				$data = $this->data;
				$data['Blog']['m_id'] = convert_uudecode(base64_decode($data['Blog']['mem_id']));
				$data['Blog']['date_added'] = date('Y-m-d'); 
				$data['Blog']['time'] = date("g.i A",time()); 
				$data['Blog']['status'] = '1';
				$this->Blog->save($data); 
				
				$this->Session->write('success','Post has been added successfully');
				$this->redirect(array('action'=>'admin_blogs/'.$data['Blog']['mem_id']));
			}else{
				$this->set('error',$errors);
			}
		}
	}
	function admin_edit_blog($id=NULL)
	{
		$this->layout="admin";
		$this->loadModel("Blog");
		$id = convert_uudecode(base64_decode($id));
		$blogInfo = $this->Blog->find('first',array('conditions'=>array('Blog.id'=>$id)));
		$this->set(compact('blogInfo'));
		
		if(!empty($this->data)){
			$errors = array();
			
			$errors = $this->validate_add_blog_ajax($this->data);
			if(count($errors) == 0)
			{
				$data = $this->data;
				
				$this->Blog->save($data); 
				
				$mem_id = base64_encode(convert_uuencode($data['Blog']['m_id']));
				$this->Session->write('success','Post has been edited successfully');
				$this->redirect(array('action'=>'admin_blogs/'.$mem_id));
			}else{
				$this->set('error',$errors);
			}
		}
	}
	function validate_add_blog_ajax()
	{
		$this->layout="";
		$this->autoRender=false;
		if($this->RequestHandler->isAjax())	{
			$errors_msg = null;
			$errors=$this->validate_add_blog_steps($this->data);					
			if ( is_array ( $this->data ) )	{
				foreach ($this->data['Blog'] as $key => $value ){
					if( array_key_exists ( $key, $errors) )	{
						foreach ( $errors [ $key ] as $k => $v ){
							$errors_msg .= "error|$key|$v";
						}	
					}
					else {
						$errors_msg .= "ok|$key\n";
					}
				}
			}
			echo $errors_msg;
			die;
		}	
	}
	
	function validate_add_blog_steps($data)
	{			
		$errors = array ();
		if(isset($data['Blog']['title'])){
			if(trim($data['Blog']['title'])=="")	{
				$errors ['title'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		if(isset($data['Blog']['description'])){
			if(trim($data['Blog']['description'])=="")	{
				$errors ['description'] [] = __(FIELD_REQUIRED,true)."\n";
			}			
		}
		return $errors;			
	}
	function admin_remark($blog_id=NULL)
	{
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		$this->loadModel("BlogRemark");
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$this->set(compact('blog_id'));
		
		$id = convert_uudecode(base64_decode($blog_id));
		$this->paginate = array('limit'=>$this->pageLimit,'order'=>'BlogRemark.id DESC');
		$conditions = array('BlogRemark.blog_id'=>$id);
		$info = $this->paginate('BlogRemark',$conditions);
		$this->set(compact('page','info'));
		
		if($this->RequestHandler->isAjax())
		{
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('comment_listing');
		}
	}
	function admin_view_remark($id=NULL)
	{	
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		$this->loadModel('BlogRemark');
		
		$id = convert_uudecode(base64_decode($id));
		$info = $this->BlogRemark->find('first',array('conditions'=>array('BlogRemark.id'=>$id)));
		$this->set('info',$info);
	}
	function admin_add_remark($blog_id=NULL)
	{																																											
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		$this->loadModel('Blog');
		$this->set(compact('blog_id'));
		
		if(!empty($this->data)){
			$errors = array();
			$errors = $this->validate_add_blog_ajax($this->data);
			if(count($errors) == 0)
			{
				$data = $this->data;
				$data['Blog']['m_id'] = convert_uudecode(base64_decode($data['Blog']['mem_id']));
				$data['Blog']['date_added'] = date('Y-m-d');
				$data['Blog']['status'] = '1';
				$this->Blog->save($data); 
				
				$this->Session->write('success','Post has been added successfully');
				$this->redirect(array('action'=>'admin_blogs/'.$data['Blog']['mem_id']));
			}else{
				$this->set('error',$errors);
			}
		}
	}
	// New Fucntionality
	function admin_view_assignment_detail($id=NULL)
	{
		$this->layout='admin';
		$this->loadModel('InstructorAssignment');
		$id = convert_uudecode(base64_decode($id));
		$info = $this->InstructorAssignment->find('first',array('conditions'=>array('InstructorAssignment.id'=>$id),'contain'=>false));
		
		$this->set(compact('info'));
	}
	function admin_view_student_assignment_detail($id=NULL)
	{
		$this->layout='admin';
		$this->loadModel('InstructorAssignmentStudent');
		$this->loadModel('InstructorAssignmentDocument');
		$id = convert_uudecode(base64_decode($id));
		$info = $this->InstructorAssignmentStudent->find('first',array('conditions'=>array('InstructorAssignmentStudent.id'=>$id),'contain'=>array('InstructorAssignment','Event'=>array('Member'=>array('first_name','last_name')))));

		$infoDoc = $this->InstructorAssignmentDocument->find('all',array('conditions'=>array('InstructorAssignmentDocument.assign_id'=>$id)));
		//pr($info);die;
		
		$this->set(compact('info','infoDoc'));
	}
	
	function admin_assigned_student($id=NULL)
	{
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		$this->loadModel("InstructorAssignmentStudent");
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$this->set(compact('id'));
		
		$id = convert_uudecode(base64_decode($id));
		$this->paginate = array('limit'=>$this->pageLimit,'order'=>'InstructorAssignmentStudent.id DESC','contain'=>array('Member'=>array('first_name','last_name'),'InstructorAssignment'=>array('title')));
		$conditions = array('InstructorAssignmentStudent.inst_assign_id'=>$id);
		$info = $this->paginate('InstructorAssignmentStudent',$conditions);
		$this->set(compact('page','info'));
		//pr($info);die;
		if($this->RequestHandler->isAjax())
		{
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath = 'Elements'.DS.'adminElements/events';
			$this->render('assigned_student_list');
		}
	}
	function admin_view_assigned_student_detail($id=NULL,$s_id=NULL)
	{
		$this->layout='admin';
		$this->loadModel('InstructorAssignmentDocument');
		$id = convert_uudecode(base64_decode($id));
		$s_id = convert_uudecode(base64_decode($s_id));
		$info = $this->InstructorAssignmentDocument->find('all',array('conditions'=>array('InstructorAssignmentDocument.assign_id'=>$id),'contain'=>false));
		//pr($info);die;
		$this->set(compact('info','s_id'));
	}
	function admin_send_invitation()
	{
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		
		$this->loadModel('SendInvitation');
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		
		$this->paginate = array('limit'=>$this->pageLimit,'order'=>'SendInvitation.id DESC');
		$info = $this->paginate('SendInvitation');
		$this->set(compact('page','info'));
		if($this->RequestHandler->isAjax())
		{
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('send_invitation_list');
		}
	}
	function admin_view_send_invitation($id=NULL)
	{
		 
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		
		$id = convert_uudecode(base64_decode($id));
		$this->loadModel('SendInvitation');
		
		$info = $this->SendInvitation->find('first',array('conditions'=>array('SendInvitation.id'=>$id)));
		$this->set('info',$info);
	}
	
	function admin_instructor_tooltip()
	{
		$this->layout="admin";
		$this->loadModeL("Tooltip");
		$page= isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		
		$info = $this->Tooltip->find('all');
		$this->set(compact('info'));
		
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Tooltip.id DESC','conditions'=>array('Tooltip.type'=>'2'));
		$info=$this->paginate('Tooltip');
		$this->set(compact('info','page'));
		if($this->RequestHandler->isAjax()){
			$this->layout = '';
			$this->autoRender = false;
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('instructor_tooltip_list');
		}
	}
	function admin_student_tooltip()
	{
		$this->layout="admin";
		$this->loadModeL("Tooltip");
		$page= isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		
		$info = $this->Tooltip->find('all');
		$this->set(compact('info'));
		
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'Tooltip.id DESC','conditions'=>array('Tooltip.type'=>'1'));
		$info=$this->paginate('Tooltip');
		$this->set(compact('info','page'));
		if($this->RequestHandler->isAjax()){
			$this->layout = '';
			$this->autoRender = false;
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('instructor_tooltip_list');
		}
	}
	function admin_view_tooltip($id=NULL)
	{		 
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		$id = convert_uudecode(base64_decode($id));
		$this->loadModel('Tooltip');
		$info = $this->Tooltip->find('first',array('conditions'=>array('Tooltip.id'=>$id)));
		$this->set('info',$info);
	}
	function admin_edit_tooltip($id=NULL)
	{
		$this->layout='admin';
		$id = convert_uudecode(base64_decode($id));
		$this->loadModel('Tooltip');
		$info = $this->Tooltip->find('first',array('conditions'=>array('Tooltip.id'=>$id))); //pr($info);die;
		$this->set(compact('info'));
		
		if(!empty($this->data))
		{
			$error=array();
			$error=$this->check_tooltip($this->data); //pr(count($error));die;
			if(count($error)==0){
				$data = $this->data;
				$data['Tooltip']['date_modified'] = date('d-m-Y');
				$this->Tooltip->save($data);				
				$this->Session->write('SuccessMessage','Tooltip message edited successfully.');
				if($this->data['Tooltip']['type'] == '1'){
					$this->redirect(array('controller'=>'users','action'=>'student_tooltip','admin'=>true));
				}
				if($this->data['Tooltip']['type'] == '2'){
					$this->redirect(array('controller'=>'users','action'=>'instructor_tooltip','admin'=>true));
				}
			}
			else
			{
				$this->set('error',$error); 
				$this->set('info',$this->data);
			}
		}
	}
	function check_tooltip($data)
	{			
		$errors = array ();
		if(trim($data['Tooltip']['title']==""))
		{
			$errors['title'] []= __(FIELD_REQUIRED,true)."\n";
		}
		if (trim($data['Tooltip']['description'])=="")
		{
			$errors['description'] [] = __(FIELD_REQUIRED,true)."\n";
		}
		
		return $errors;
	}
	function admin_view_assigned_instructor($id=NULL,$stuId=NULL)
	{
		$this->layout="admin";
		$this->loadModel("ContactInstructorStudent");
		$page= isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$id = convert_uudecode(base64_decode($id));
		$stuId = convert_uudecode(base64_decode($stuId));
		
		$this->paginate = array('order'=>'ContactInstructorStudent.id DESC','limit'=>'10');
		$conditions = array('ContactInstructorStudent.student_id'=>$stuId,'ContactInstructorStudent.message_id'=>$id);
		$info = $this->paginate('ContactInstructorStudent',$conditions);
		$this->set(compact('info','page'));
		
		if($this->RequestHandler->isAjax()){
			$this->layout = "";
			$this->autoRender = false;
			$this->render('/Elements/adminElements/cmsPages/assigned_instructor_list');
		}
	}
	
	function admin_view_sticky_note($id=NULL)
	{
		$this->layout="admin";
		$this->loadModel("StickyNote");
		$page= isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		if(!empty($id))
		{
			$sticky_id = convert_uudecode(base64_decode($id));
			$this->paginate = array('order'=>'StickyNote.id DESC','limit'=>'10','fields'=>array('StickyNote.*','Member.first_name','Member.last_name'));
			$conditions = array('StickyNote.member_id'=>$sticky_id);
			$info = $this->paginate('StickyNote',$conditions);
			$this->set(compact('info','page','id'));
			//pr($info);die;
			
			if($this->RequestHandler->isAjax())
			{
				$this->layout = "";
				$this->autoRender = false;
				$this->viewPath = 'Elements'.DS.'adminElements/teacher';
				$this->render('sticky_note_list');
			}
		}
	}
	
	function admin_delete_sticky_record($page=NULL,$d_id=NULL,$table_name,$renderPath=NULL,$renderElement=NULL)
	{
		$this->loadModel('StickyNote');
		$renderPath=base64_decode($renderPath);
		$renderElement=base64_decode($renderElement);
		$id = convert_uudecode(base64_decode($d_id));
		if($this->request->is('ajax'))
		{
			$this->layout=false;
			$this->autoRender = false;	
			$d_record = $this->StickyNote->findById($id);
			$path = 'files/'.$d_record['StickyNote']['member_id'].'/personal_repo/'.$d_record['StickyNote']['sticky_file'];
			if($d_record['StickyNote']['type'] == 'file'){
				if(file_exists($path)){
					unlink($path);
				}
			}
			$this->StickyNote->delete($id);
			
			$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>'StickyNote.id DESC');
			$conditions = array('StickyNote.member_id'=>$d_record['StickyNote']['member_id']);
			$info = $this->paginate('StickyNote',$conditions);
			
			if(empty($info) && $page>1)
			{
				$page=$page-1;
				$this->paginate=array('limit'=>$this->pageLimit,'page'=>$page,'order'=>'StickyNote.id DESC');
				$conditions = array('StickyNote.member_id'=>$d_record['StickyNote']['member_id']);
				$info = $this->paginate('StickyNote',$conditions);
			}
			$this->set(compact('info','page','id'));			
			$this->viewPath = 'Elements'.DS.'adminElements/'.$renderPath;
			$this->render($renderElement);	
		}
	}
	
	function admin_detail_sticky_note($id=NULL)
	{
		$this->layout="admin";
		$this->loadModel("StickyNote");
		if(!empty($id))
		{
			$id = convert_uudecode(base64_decode($id));
			$info = $this->StickyNote->find('first',array('conditions'=>array('StickyNote.id'=>$id),'fields'=>array('StickyNote.*','Member.first_name','Member.last_name')));
			$this->set('info',$info);
		}
	}
	
	function admin_view_promotion($id)
	{
		$this->layout="admin";
		$this->loadModel("Promotion");
		$page= isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		if(!empty($id))
		{
			$pro_id = convert_uudecode(base64_decode($id));
			$this->paginate = array('order'=>'Promotion.id DESC','limit'=>'10');
			$conditions = array('Promotion.member_id'=>$pro_id);
			$info = $this->paginate('Promotion',$conditions);
			$this->set(compact('info','page','id'));
			//pr($info);die;
			
			if($this->RequestHandler->isAjax())
			{
				$this->layout = "";
				$this->autoRender = false;
				$this->viewPath = 'Elements'.DS.'adminElements/teacher';
				$this->render('promotion_list');
			}
		}
	}
	
	function admin_detail_promotion($id=NULL)
	{
		$this->layout="admin";
		$this->loadModel("Promotion");
		if(!empty($id))
		{
			$id = convert_uudecode(base64_decode($id));
			$info = $this->Promotion->find('first',array('conditions'=>array('Promotion.id'=>$id),'fields'=>array('Promotion.*','Member.first_name','Member.last_name'),'contain'=>array('Member')));
			$this->set('info',$info);
		}
	}
	function  admin_view_email($id)
	{
		$this->layout="admin";
		$this->loadModel("PromotionEmail");
		$page= isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		if(!empty($id))
		{
			$e_id = convert_uudecode(base64_decode($id));
			$this->paginate = array('order'=>'PromotionEmail.id ASC','limit'=>'10');
			$conditions = array('PromotionEmail.promotion_id'=>$e_id);
			$info = $this->paginate('PromotionEmail',$conditions);
			$this->set(compact('info','page','id'));
			
			if($this->RequestHandler->isAjax())
			{
				$this->layout = "";
				$this->autoRender = false;
				$this->viewPath = 'Elements'.DS.'adminElements/teacher';
				$this->render('promotion_email_list');
			}
		}
	}
	function admin_student_class_request()
	{
		$this->layout='admin';
		$this->loadModel('ClassRequest');
		
		$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'ClassRequest.id DESC');
		$info=$this->paginate('ClassRequest');
		$this->set(compact('info','page'));
		
		if($this->RequestHandler->isAjax()){
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath='Elements'.DS.'adminElements/cmsPages';
			$this->render('class_request_list');
		}
	}
	
	function admin_view_class_request($id=NULL)
	{
		
		$this->layout='admin';
		$this->loadModel('ClassRequest');
		
		$id = convert_uudecode(base64_decode($id));
		$info = $this->ClassRequest->find('first',array('conditions'=>array('ClassRequest.id'=>$id)));
		$this->set(compact('info'));
	}
	
	/*------------------ tamnbark 20april---------------------*/
	
	function admin_student_invitation_list()
	{ 
		$this->layout='admin';
		$this->loadModel('SendInvitation');
		$page=isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$this->paginate=array('limit'=>$this->pageLimit,'order'=>'SendInvitation.id ASC','fields'=>array('SendInvitation.*','Event.title','Member.first_name','Member.last_name','Member.email'));
		$info = $this->paginate('SendInvitation');
		//print "<pre>";print_r($info);die;
		$this->set(compact('info','page'));
		
		if($this->RequestHandler->isAjax()){
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath='Elements'.DS.'adminElements/cmsPages';
			$this->render('student_invitation_list');
		}
	}
	
	function admin_view_student_invitation($id=NULL)
	{
		$this->layout='admin';
		if(!empty($id))
		{
			$this->loadModel('SendInvitation');
			$id = convert_uudecode(base64_decode($id));
			$info = $this->SendInvitation->find('first',array('conditions'=>array('SendInvitation.id'=>$id),'fields'=>array('SendInvitation.*','Event.title','Member.first_name','Member.last_name','Member.email')));
			$this->set('info',$info);
		}
	}
	function admin_instructor_workroom_list($id=NULL)
	{
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		$this->loadModel("Workroom");
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$this->set(compact('id'));
		
		$id = convert_uudecode(base64_decode($id));
		$this->paginate = array('limit'=>$this->pageLimit,'order'=>'Workroom.id DESC');
		$conditions = array('Workroom.m_id'=>$id);
		$info = $this->paginate('Workroom',$conditions);
		$this->set(compact('page','info'));
		
		if($this->RequestHandler->isAjax())
		{
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('instructor_workroom_listing');
		}
	}
	
	function admin_workroom_posts($id=NULL)
	{
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		$this->loadModel("WorkroomPost");
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$this->set(compact('id'));
		
		$id = convert_uudecode(base64_decode($id));
		$this->paginate = array('limit'=>$this->pageLimit,'order'=>'WorkroomPost.id DESC');
		$conditions = array('WorkroomPost.workroom_id'=>$id);
		$info = $this->paginate('WorkroomPost',$conditions);
		$this->set(compact('page','info'));
		//pr($info); die;
		if($this->RequestHandler->isAjax())
		{
			
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('blog_listing');
		}
	}
	function admin_view_workroom_blog($id=NULL)
	{	
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		$this->loadModel('WorkroomPost');
		
		$id = convert_uudecode(base64_decode($id));
		$info = $this->WorkroomPost->find('first',array('conditions'=>array('WorkroomPost.id'=>$id)));
		$this->set('info',$info);
	}
	
	function admin_workroom_post_remark($blog_id=NULL)
	{
		
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		$this->loadModel("WorkroomPostRemark");
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$this->set(compact('blog_id'));
		
		$id = convert_uudecode(base64_decode($blog_id));
		$this->paginate = array('limit'=>$this->pageLimit,'order'=>'WorkroomPostRemark.id DESC');
		$conditions = array('WorkroomPostRemark.post_id'=>$id);
		$info = $this->paginate('WorkroomPostRemark',$conditions);
		$this->set(compact('page','info'));
		
		if($this->RequestHandler->isAjax())
		{
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('work_comment_listing');
		}
	}
	function admin_view_workroom_remark($id=NULL)
	{	
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		$this->loadModel('WorkroomPostRemark');
		
		$id = convert_uudecode(base64_decode($id));
		$info = $this->WorkroomPostRemark->find('first',array('conditions'=>array('WorkroomPostRemark.id'=>$id)));
		$this->set('info',$info);
	}
	
	function admin_student_workroom_list($id=null)
	{
		
		$this->layout = 'admin';
		$this->pageTitle = ':: Tambark ::';
		$this->loadModel("Workroom");
		$this->loadModel("StudentApplyEvent");
		$page = isset($this->params['named']['page'])?$this->params['named']['page']:'1';
		$this->set(compact('id'));
		
		$id = convert_uudecode(base64_decode($id));
		$allEvent = $this->StudentApplyEvent->find('list',array('conditions'=>array('StudentApplyEvent.student_id'=>$id),'fields'=>array('id','event_id')));
		
		$this->paginate = array('limit'=>$this->pageLimit,'order'=>'Workroom.id DESC');
		$conditions = array('Workroom.e_id'=>$allEvent);
		$info = $this->paginate('Workroom',$conditions);
		$this->set(compact('page','info'));
		
		if($this->RequestHandler->isAjax())
		{
			$this->layout='';
			$this->autoRender=false;
			$this->viewPath = 'Elements'.DS.'adminElements/cmsPages';
			$this->render('student_workroom_listing');
		}
	}
}