<?php

class BigBrother extends DB\SQL\Mapper{

    public function __construct(DB\SQL $db) {
        parent::__construct($db,'w_logs');
    }

    public function all() {
        $this->load();
        return $this->query;
    }

    public function getById($id) {
        $this->load(array('id=?',$id));
        return $this->query;
    }

    public function addLogEntry($domainid,$domainname,$userid,$useremail,$action,$record,$masterid) {
		if(empty($action)) { $action = $domainname; };
		$this->domainID=$domainid;
		$this->domainName=$domainname;
		$this->userID=$userid;
		$this->userEmail=$useremail;
		$this->action=$action;
		$this->record=$record;
		$this->masterID=$masterid;		
        $this->save();
		return $this->id;
    }
}