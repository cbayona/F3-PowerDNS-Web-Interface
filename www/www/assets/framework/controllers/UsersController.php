<?php

class UsersController extends Controller{
    function renderLogin($f3){
        $template=new Template;
        echo $template->render('login.html');
    }

    function beforeroute(){
    }

    function authenticate($f3) {

        $email = $this->f3->get('POST.email');
        $password = $this->f3->get('POST.password');

        $users = new Users($this->db);
		$userlevel = new UserLevel($this->db);
        $users->getByEmail($email);

        if($users->dry()) {
            $this->f3->reroute('/login');
        }

        if(password_verify($password, $users->userPassword)) {
			if($users->userEnabled == "1") {
            $this->f3->set('SESSION.email', $users->userEmail);
            $this->f3->set('SESSION.realname', $users->userName);
            $this->f3->set('SESSION.adminlevel', $users->userAdminLevel);
            $this->f3->set('SESSION.adminleveldesc', $userlevel->getLevelDesc($users->userAdminLevel));
            $this->f3->set('SESSION.userid', $users->userID);			
            $this->f3->reroute('/');
			} else {
				Flash::instance()->addMessage('Your account is disabled. Please contact your Domain Administrator', 'danger');
				$this->f3->reroute('/login');	
			}
        } else {
			Flash::instance()->addMessage('Incorrect Email or Password.', 'danger');
            $this->f3->reroute('/login');
        }
    }
	
	function logout ($f3) {
	 $this->f3->clear('SESSION');	
	 $this->f3->reroute('/');
	}
}