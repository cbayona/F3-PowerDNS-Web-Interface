<?php

class Users extends DB\SQL\Mapper{

    public function __construct(DB\SQL $db) {
        parent::__construct($db,'w_users');
    }

    public function all() {
        $this->load();
        return $this->query;
    }

    public function getById($id) {
        $this->load(array('userID=?',$id));
        return $this->query;
    }

    public function getByEmail($email) {
        $this->load(array('userEmail=?', $email));
    }

    public function add($useremail, $username, $userrole, $maxdomains, $password, $masteraccountid) {
        $this->userEmail = $useremail;
		$this->userName = $username;
		$this->userAdminLevel = $userrole;
		$this->userMaxDomains = $maxdomains;
		$this->userPassword = password_hash($password, PASSWORD_DEFAULT);

		$this->userEnabled = "1";
        $this->save();
		$insertid = $this->userID;
		if($userrole == "2") {
			$masteraccountid = "1";
		}
		$this->load(array('userID=?', $insertid));
		$this->userMasterAccount = $masteraccountid;
		$this->save();
		return $insertid;
    }

    public function edit($id) {
        $this->load(array('userID=?',$id));
        $this->copyFrom('POST');
        $this->update();
    }

    public function delete($id) {
        $this->load(array('userID=?',$id));
        $this->erase();
    }
	
	public function countUsers() {
		return count($this->all());
	}
	
	public function countUserUsers($masterid) {
		return count($this->load(array('userMasterAccount=?',$masterid)));	
	}

	public function countAdmins() {
		return count($this->load(array('userAdminLevel=?', '2')));
	}
	
	public function listAllUsers() {
	return $this->db->exec('Select w_users.userID, w_users.userEmail, w_users.userName, w_users.userHash, w_users.userEnabled, w_users.userMaxDomains, w_userlevels.userLevelDesc From w_users Inner Join w_userlevels On w_users.userAdminLevel = w_userlevels.userLevelID');	
	}
	
	public function listAllUsersMasterAccount($masteraccountid) {
		return $this->db->exec('Select w_users.userID, w_users.userEmail, w_users.userName, w_users.userHash, w_users.userEnabled, w_users.userMaxDomains, w_userlevels.userLevelDesc From w_users Inner Join w_userlevels On w_users.userAdminLevel = w_userlevels.userLevelID WHERE w_users.userMasterAccount=?',$masteraccountid);	
	}
	
	public function listAllEmails() {
		return $this->select('userID,userEmail',null,array('order'=>'userEmail ASC'));
	}

	public function listAllEmailsMasterAccount($masteraccountid) {
		return $this->db->exec('SELECT userID, userEmail, UserMasterAccount from w_users WHERE userMasterAccount=? ORDER BY userEmail ASC',$masteraccountid);
	}

	public function updateUser($userid, $useremail, $userrole, $username, $maxnumber, $userenabled) {
		$users = new Users($this->db);
		$this->load(array('userID=?',$userid));
		$this->userEnabled = $userenabled;
		$this->userName = $username;
		$this->userMaxDomains = $maxnumber;
		$this->userAdminLevel = $userrole;
		$this->userEmail = $useremail;
		$this->save();
		return $useremail;
	}

	public function checkIsMaster($userid,$masterid) {
		$this->load(array('userID=? AND userMasterAccount=?',$userid,$masterid));	
		if($this->dry()) {
			return false;
		} else {
			return true;
		}
	}
}