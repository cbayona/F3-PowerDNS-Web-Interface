<?php

class Validate extends Controller {

    public function __construct() {
    }
	
	public function isValidIP($ip){
		if(filter_var($ip, FILTER_VALIDATE_IP)) {
		  return true;
		}
		else {
		  return false;
		}
	}

	public function isValidEmail($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		} else {
			return false;	
		}
	}

	public function isValidDomainID($domainid,$db) {
		$filter_options = array('options' => array( 'min_range' => 0));
		if(filter_var($domainid, FILTER_VALIDATE_INT, $filter_options ) !== FALSE) {
		   $domains = new Domains($db);
		   $domains->getById($domainid);
		   if($domains->dry()) {
		   		return false;
		   } else {
			return true;
		   }
		} else {
			return false;
		}
	}

	public function isAsciiDomain($domain) {
			return idn_to_ascii($domain);
	}
	
	public function isAsciiEmail($email) {
		//$email = 'post@øl.no';
		list($user, $domain) = explode('@', $email);
			$user = idn_to_ascii($user);
			$domain = idn_to_ascii($domain);	
			$email = $user . '@' . $domain;
			return $email;
	}

	public function showRealDomain($domain) {
		return idn_to_utf8($domain);	
	}

	public function isValidDomain($domain) {
		if (preg_match('/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}/', $domain)) {
			return true;
		} else {
			return false;	
		}
	}
	
	public function isValidNumberG0($number) {
		if(!ctype_digit($number) && $number < 1) {
			return false;	
		}
	}

	public function isLoggedIn($f3) {
		if($f3->get('SESSION.adminlevel')) {
			return true;
		} else {
			$f3->reroute('/login');	
		}
	}
	
	public function requiredLevel($requiredlevel) {
		$f3 = Base::instance();
		if($f3->get('SESSION.adminlevel')) {
			$adminlevel = $f3->get('SESSION.adminlevel');
			if($adminlevel >= $requiredlevel) {
				// User meets minimum level
				return true;	
			} else {
				return false;	
			}
		}
	}	
}