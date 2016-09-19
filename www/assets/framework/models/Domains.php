<?php

class Domains extends DB\SQL\Mapper{

    public function __construct(DB\SQL $db) {
        parent::__construct($db,'domains');
    }

    public function all() {
        $this->load();
        return $this->query;
    }

    public function getById($id) {
        $this->load(array('id=?',$id));
        return $this->query;
    }

    public function getByDomain($domain) {
        $this->load(array('name=?', $domain));
		return $this->query;
    }

    public function add($domainname,$type) {
        $this->name = $domainname;
		$this->type = $type;
        $this->save();
		return $this->id;
    }

    public function edit($id) {
        $this->load(array('id=?',$id));
        $this->copyFrom('POST');
        $this->update();
    }

    public function delete($id) {
        $this->load(array('id=?',$id));
        $this->erase();
    }
	
	public function countDomains() {
		return count($this->all());
	}

	public function listAllDomains() {
		return $this->db->exec('Select D.id, D.name, D.type, Count(R.domain_id) As records From domains D Left Outer Join records R On D.id = R.domain_id Group By D.id, D.name, D.type Order By name');
	}
	
}