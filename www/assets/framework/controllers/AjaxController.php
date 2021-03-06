<?php

class AjaxController extends Controller{

	public function ajaxadddomain($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$domaindata = new DomainData($this->db);
		$logs = new BigBrother($this->db);
		$validate = new Validate();
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$usermaxaccounts = $this->f3->get('SESSION.maxdomains');
		$domainname = $f3->get('POST.domain');
		$postdomainemail = $f3->get('POST.email');
		$domainprimary = $f3->get('POST.primary');
		$domainadmin = $f3->get('POST.adminid');
		$domainadminemail = $f3->get('POST.adminemail');
		$domainrefresh = $this->f3->get('DEFAULTSOAREFRESH');
		$domainexpire = $this->f3->get('DEFAULTSOAEXPIRE');
		$domainretry = $this->f3->get('DEFAULTSOARETRY');
		$domainttl = $this->f3->get('DEFAUTLSOATTL');
		if($adminlevel == '2') {

			if (empty($domainname)) {
				$error = "Domain Name Cannot Be Empty";
				$this->returnError($error);
				return;
			}
	
			if (empty($postdomainemail)) {
				$error = "Domain Email Cannot Be Empty";
				$this->returnError($error);
				return;
			}
	
			if (empty($domainprimary)) {
				$error = "Domain Primary Cannot Be Empty";
				$this->returnError($error);
				return;
			}

			if (empty($domainadmin)) {
				$error = "Admin Account Cannot Be Empty";
				$this->returnError($error);
				return;
			}
			
			//Check if domain is already in the database
			$domains->getByDomain($domainname);
			if(!$domains->dry()) {
				$error = "Domain Already Exists";
				$this->returnError($error);
				return;	
			}
			// Check if admin account exists
			$users->getById($domainadmin);
			if($users->dry()) {
				$error = "Admin Account Does Not Exist";
				$this->returnError($error);
				return;	
			}
	
			// Check domain is not IDN, if so convert to puny, if not return original domain
			$domainname = $validate->isAsciiDomain($domainname);
			if ($validate->isValidDomain($domainname, $this->db) == false) {
				$error = "Sorry, ". $domainname ." is not a Valid Domain Name";
				$this->returnError($error);
				return;
			}
	
			// Check Primary is not IDN, if so convert to puny, if not return original domain
			$domainprimary = $validate->isAsciiDomain($domainprimary);
			if ($validate->isValidDomain($domainprimary, $this->db) === false) {
				$error = "Primary is not a Valid Domain Name";
				$this->returnError($error);
				return;
			}
	
			// Check email is not IDN, if so convert to puny, if not return original email
			$domainemail = $validate->isAsciiEmail($postdomainemail);
			if ($validate->isValidEmail($domainemail) === false) {
				$error = $domainemail ." is not a Valid Email Address";
				$this->returnError($error);
				return;
			}
	
			if (!isset($error)) {
					$soaData = Array();
					$soaData[] = $domainprimary;
					$soaData[] = $soa->mailToSOA($domainemail);
					$soaData[] = date("Ymd") . "00";
					$soaData[] = $domainrefresh;
					$soaData[] = $domainretry;
					$soaData[] = $domainexpire;
					$soaData[] = $domainttl;
	
					$soaContent = implode(" ", $soaData);
					$adddomain = $domains->add($domainname, 'MASTER');
				if ($adddomain > 0) {
					$addsoa = $records->addSOA($adddomain,$soaContent,$domainname,'SOA',$domainttl,'0');
					$adddomhash = $domaindata->addDomainData($adddomain,$domainname,$domainadmin);
						if ($addsoa >= 0 && $adddomhash === true) {
							$logs->addLogEntry($adddomain,$domainname,$this->f3->get('SESSION.userid'),$this->f3->get('SESSION.email'),'ADD',$domainname,$this->f3->get('SESSION.masteraccountid'));
							echo $adddomain;
							return;
						} else {
							$this->returnError("Something Went Wrong");
							return;
						}
				}
				else {
					$this->returnError("Something has gone wrong");
					return;
				}
			}
			else {
				$this->returnError($error);
				return;
			}
			$error = "";
		} elseif ($adminlevel == '1') {
			// Domain Admin
			$usercurrentaccounts = $domaindata->countUserDomains($userid);
			if($usercurrentaccounts == $usermaxaccounts) {
				$this->returnError('You already have used the maximum amount of domains on your account.');	
				return;
			} else {
				if (empty($domainname)) {
					$error = "Domain Name Cannot Be Empty";
					$this->returnError($error);
					return;
				}
				if (empty($postdomainemail)) {
					$error = "Domain Email Cannot Be Empty";
					$this->returnError($error);
					return;
				}
		
				if (empty($domainprimary)) {
					$error = "Domain Primary Cannot Be Empty";
					$this->returnError($error);
					return;
				}
	
				if (empty($domainadmin)) {
					$error = "Admin Account Cannot Be Empty";
					$this->returnError($error);
					return;
				}
				
				//Check if domain is already in the database
				$domains->getByDomain($domainname);
				if(!$domains->dry()) {
					$error = "Domain Already Exists";
					$this->returnError($error);
					return;	
				}
				// Check if admin account exists
				$users->getById($domainadmin);
				if($users->dry()) {
					$error = "Admin Account Does Not Exist";
					$this->returnError($error);
					return;	
				}
		
				// Check domain is not IDN, if so convert to puny, if not return original domain
				$domainname = $validate->isAsciiDomain($domainname);
				if ($validate->isValidDomain($domainname, $this->db) == false) {
					$error = "Sorry, ". $domainname ." is not a Valid Domain Name";
					$this->returnError($error);
					return;
				}
		
				// Check Primary is not IDN, if so convert to puny, if not return original domain
				$domainprimary = $validate->isAsciiDomain($domainprimary);
				if ($validate->isValidDomain($domainprimary, $this->db) === false) {
					$error = "Primary is not a Valid Domain Name";
					$this->returnError($error);
					return;
				}
		
				// Check email is not IDN, if so convert to puny, if not return original email
				$domainemail = $validate->isAsciiEmail($postdomainemail);
				if ($validate->isValidEmail($domainemail) === false) {
					$error = $domainemail ." is not a Valid Email Address";
					$this->returnError($error);
					return;
				}
		
				if (!isset($error)) {
						$soaData = Array();
						$soaData[] = $domainprimary;
						$soaData[] = $soa->mailToSOA($domainemail);
						$soaData[] = date("Ymd") . "00";
						$soaData[] = $domainrefresh;
						$soaData[] = $domainretry;
						$soaData[] = $domainexpire;
						$soaData[] = $domainttl;
		
						$soaContent = implode(" ", $soaData);
						$adddomain = $domains->add($domainname, 'MASTER');
					if ($adddomain > 0) {
						$addsoa = $records->addSOA($adddomain,$soaContent,$domainname,'SOA',$domainttl,'0');
						$adddomhash = $domaindata->addDomainData($adddomain,$domainname,$domainadmin);
							if ($addsoa >= 0 && $adddomhash === true) {
								$logs->addLogEntry($adddomain,$domainname,$this->f3->get('SESSION.userid'),$this->f3->get('SESSION.email'),'ADD',$domainname,$this->f3->get('SESSION.masteraccountid'));
								echo $adddomain;
								return;
							} else {
								$error = "Something Went Wrong";
								$this->returnError($error);
								return;
							}
					}
					else {
						$error = "Something has gone wrong";
						$this->returnError($error);
						return;
					}
				}
				else {
					$this->returnError($error);
					return;
				}
				$error = "";
			}
		} else {
			$this->returnError('Your account cannot do that');
			return;	
		}
	}

	public function ajaxadeletedomain($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$validate = new Validate();
		$domaindata = new DomainData($this->db);
		$logs = new BigBrother($this->db);
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$domainid = $f3->get('POST.domainid');
		$domainname = $f3->get('POST.name');
		if($adminlevel == '2') {
			if (empty($domainid)) {
				$error = "A problem occured, please refresh the page.";
			}
	
			if (!$error) {
				$deletedomain = $domains->delete($domainid);
				$deletedomaindata = $domaindata->deleteByDomainID($domainid);
				$logs->addLogEntry($domainid,$domainname,$this->f3->get('SESSION.userid'),$this->f3->get('SESSION.email'),'DELETE',$domainname,$this->f3->get('SESSION.masteraccountid'));
				http_response_code(200);
				return;
			}
			else {
				$this->returnError($error);
				return;
			}
		} 
		if($adminlevel == '1') {
			  if($domaindata->checkIsOwner($domainid,$this->f3->get('SESSION.masteraccountid')) == true) {			
				if (empty($domainid)) {
					$error = "A problem occured, please refresh the page.";
				}
		
				if (!$error) {
					$deletedomain = $domains->delete($domainid);
					$deletedomaindata = $domaindata->deleteByDomainID($domainid);
					$logs->addLogEntry($domainid,$domainname,$this->f3->get('SESSION.userid'),$this->f3->get('SESSION.email'),'DELETE',$domainname,$this->f3->get('SESSION.masteraccountid'));
					http_response_code(200);
					return;
				}
				else {
					$this->returnError($error);
					return;
				}
			  }
		} 
		else {
			$this->returnError('Your account cannot do that');
		}
	}

	public function ajaxsoaupdate($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$domaindata = new DomainData($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$logs = new BigBrother($this->db);
		$validate = new Validate();
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$domainid = $f3->get('POST.domainid');
		$domainname = $f3->get('POST.domainname');
		$soaprimary = $f3->get('POST.soaPrimary');
		$soamail = $f3->get('POST.soaMail');
		$soaretry = $f3->get('POST.soaRetry');
		$soaexpire = $f3->get('POST.soaExpire');
		$soattl = $f3->get('POST.soaTtl');
		$soaserial = $f3->get('POST.soaSerial');
		$soarefresh = $f3->get('POST.soaRefresh');
		if($adminlevel == '2') {
			if ($validate->isValidDomainID($domainid, $this->db) == false) {
				$error = "Not a Valid Domain ID";
				$this->returnError($error);
				return;
			}
	
			// Check domain is not IDN, if so convert to puny, if not return original domain
			$soaprimary = $validate->isAsciiDomain($soaprimary);
			if ($validate->isValidDomain($soaprimary, $this->db) === false) {
				$error = "Primary is not a Valid Domain Name";
				$this->returnError($error);
				return;
			}
	
			// Check email is not IDN, if so convert to puny, if not return original email
			$soaemail = $validate->isAsciiEmail($soamail);
			if ($validate->isValidEmail($soaemail) === false) {
				$error = "Not a Valid Email Address";
				$this->returnError($error);
				return;
			}
	
			if ($validate->isValidNumberG0($soaretry) === false) {
				$error = "Retry Value must be a number greater than 0";
				$this->returnError($error);
				return;
			}
	
			if ($validate->isValidNumberG0($soaexpire) === false) {
				$error = "Expire Value must be a number greater than 0";
				$this->returnError($error);
				return;
			}
	
			if ($validate->isValidNumberG0($soattl) === false) {
				$error = "TTL Value must be a number greater than 0";
				$this->returnError($error);
				return;
			}
	
			if ($validate->isValidNumberG0($soarefresh) === false) {
				$error = "Refresh Value must be a number greater than 0";
				$this->returnError($error);
				return;
			}
			
			$updatedrecord = $records->updateSOA($domainid, $soaprimary, $soaemail, $soaserial, $soarefresh, $soaretry, $soaexpire, $soattl);
			if ($updatedrecord > 0) {
				$updatedserial = $records->updateSerial($domainid);
				if ($updatedserial > 0) {
					$logs->addLogEntry($domainid,$domainname,$this->f3->get('SESSION.userid'),$this->f3->get('SESSION.email'),'UPDATE','SOA for '.$domainname,$this->f3->get('SESSION.masteraccountid'));
					http_response_code(200);
					echo json_encode(array(
						"id" => $updatedrecord,
						"newserial" => $updatedserial
					));
				}
				else {
					$error = "Record not Updated 1";
					$this->returnError($error);
					return;
				}
			}
			else {
				$error = "Record not Updated";
				$this->returnError($error);
				return;
			}
		} 
			if($adminlevel == '1' || $adminlevel == '0') {
			  if($domaindata->checkIsOwner($domainid,$this->f3->get('SESSION.masteraccountid')) == true) {
				if ($validate->isValidDomainID($domainid, $this->db) == false) {
					$error = "Not a Valid Domain ID";
					$this->returnError($error);
					return;
				}
		
				// Check domain is not IDN, if so convert to puny, if not return original domain
				$soaprimary = $validate->isAsciiDomain($soaprimary);
				if ($validate->isValidDomain($soaprimary, $this->db) === false) {
					$error = "Primary is not a Valid Domain Name";
					$this->returnError($error);
					return;
				}
		
				// Check email is not IDN, if so convert to puny, if not return original email
				$soaemail = $validate->isAsciiEmail($soamail);
				if ($validate->isValidEmail($soaemail) === false) {
					$error = "Not a Valid Email Address";
					$this->returnError($error);
					return;
				}
		
				if ($validate->isValidNumberG0($soaretry) === false) {
					$error = "Retry Value must be a number greater than 0";
					$this->returnError($error);
					return;
				}
		
				if ($validate->isValidNumberG0($soaexpire) === false) {
					$error = "Expire Value must be a number greater than 0";
					$this->returnError($error);
					return;
				}
		
				if ($validate->isValidNumberG0($soattl) === false) {
					$error = "TTL Value must be a number greater than 0";
					$this->returnError($error);
					return;
				}
		
				if ($validate->isValidNumberG0($soarefresh) === false) {
					$error = "Refresh Value must be a number greater than 0";
					$this->returnError($error);
					return;
				}
				
				$updatedrecord = $records->updateSOA($domainid, $soaprimary, $soaemail, $soaserial, $soarefresh, $soaretry, $soaexpire, $soattl);
				if ($updatedrecord > 0) {
					$updatedserial = $records->updateSerial($domainid);
					if ($updatedserial > 0) {
						$logs->addLogEntry($domainid,$domainname,$this->f3->get('SESSION.userid'),$this->f3->get('SESSION.email'),'UPDATE','SOA for '.$domainname,$this->f3->get('SESSION.masteraccountid'));
						http_response_code(200);
						echo json_encode(array(
							"id" => $updatedrecord,
							"newserial" => $updatedserial
						));
					}
					else {
						$error = "Record not Updated 1";
						$this->returnError($error);
						return;
					}
				}
				else {
					$error = "Record not Updated";
					$this->returnError($error);
					return;
				}
			}
		} else {
			$this->returnError('Your account cannot do that');
		}
	}

	public function ajaxupdaterecord($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$domaindata = new DomainData($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$logs = new BigBrother($this->db);
		$soa = new SOA($this->db);
		$validate = new Validate();
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$records->copyfrom('POST',function ($val) {
			return array_intersect_key($val, array_flip(array(
				'name',
				'value',
				'pk'
			)));
		});
		$pk = $f3->get('POST.pk');
		$name = $f3->get('POST.name');
		$value = $f3->get('POST.value');
		if($adminlevel == '2') {
			$records->load(array(
				'id=?',
				$pk
			));
			if ($records->dry()) {
				// Error Handling
				$this->returnError("There's been an internal problem");
				return;
			}
			$domainid=$records->domain_id;
			$domaininfo = $domains->getById($domainid);
			$domainname = $domaininfo->name;
			$error = "";
			if ($f3->GET('POST.pk')) $records->load(array('id=?',$f3->GET('POST.pk')
			));
			if ($f3->exists('POST.name')) {
				if ($f3->get('POST.name') == "name") {
					$records->set('name', $f3->get('POST.value'));
				}
	
				if ($f3->get('POST.name') == "content") {
					if ($validate->isValidIP($f3->get('POST.value')) !== false) {
						if ($f3->get('POST.recordtype') == "A" || $f3->get('POST.recordtype') == "AAAA") {
							$records->set('content', $f3->get('POST.value'));
						}
						else {
							$errors = $f3->get('POST.recordtype') . " Records content must be a valid IP Address";
						}
						if ($f3->get('POST.recordtype') == "MX") {
							$errors = "MX content must not be an IP Address";
						}
					}
				}
	
				if ($f3->get('POST.name') == "priority") {
					if ((int)$f3->get('POST.value') == $f3->get('POST.value')) {
						$records->set('prio', $f3->get('POST.value'));
					}
					else {
						$errors = "Not a valid number";
					}
				}
	
				if ($f3->get('POST.name') == "ttl") {
					if ((int)$f3->get('POST.value') == $f3->get('POST.value') && (int)$f3->get('POST.value') > 0) {
						$records->set('ttl', $f3->get('POST.value'));
					}
					else {
						if ((int)$f3->get('POST.value') > 0) {
							$errors = "Not a valid number";
						}
						else {
							$errors = "TTL Must be > 0";
						}
					}
				}
	
				if (!$errors) {
					$records->save();
					$logs->addLogEntry($domainid,$domainname,$this->f3->get('SESSION.userid'),$this->f3->get('SESSION.email'),'UPDATE',$f->get('POST.name').' '.$f3->get('POST.value'),$this->f3->get('SESSION.masteraccountid'));
					http_response_code(200);
					echo "Record Updated";
				}
				else {
					http_response_code(400);
					echo $errors;
				}
			}
			else {
				http_response_code(400);
				echo "Record Not Updated";
			}
		} 
		if($adminlevel == '1' || $adminlevel == '0') {
			$records->load(array(
				'id=?',
				$pk
			));
			if ($records->dry()) {
				// Error Handling
				$this->returnError("There's been an internal problem");
				return;
			}
			$domainid=$records->domain_id;
			$domaininfo = $domains->getById($domainid);
			$domainname = $domaininfo->name;
			$error = "";
		  if($domaindata->checkIsOwner($domainid,$this->f3->get('SESSION.masteraccountid')) == true) {
			if ($f3->GET('POST.pk')) $records->load(array('id=?',$f3->GET('POST.pk')
			));
			if ($f3->exists('POST.name')) {
				if ($f3->get('POST.name') == "recordtype") {
					$records->set('type', $f3->get('POST.value'));	
				}

				if ($f3->get('POST.name') == "name") {
					$records->set('name', $f3->get('POST.value'));
				}
	
				if ($f3->get('POST.name') == "content") {
					if ($validate->isValidIP($f3->get('POST.value')) !== false) {
						if ($f3->get('POST.recordtype') == "A" || $f3->get('POST.recordtype') == "AAAA") {
							$records->set('content', $f3->get('POST.value'));
						}
						else {
							$errors = $f3->get('POST.recordtype') . " Records content must be a valid IP Address";
						}
						if ($f3->get('POST.recordtype') == "MX") {
							$errors = "MX content must not be an IP Address";
						}
					}
				}
	
				if ($f3->get('POST.name') == "priority") {
					if ((int)$f3->get('POST.value') == $f3->get('POST.value')) {
						$records->set('prio', $f3->get('POST.value'));
					}
					else {
						$errors = "Not a valid number";
					}
				}
	
				if ($f3->get('POST.name') == "ttl") {
					if ((int)$f3->get('POST.value') == $f3->get('POST.value') && (int)$f3->get('POST.value') > 0) {
						$records->set('ttl', $f3->get('POST.value'));
					}
					else {
						if ((int)$f3->get('POST.value') > 0) {
							$errors = "Not a valid number";
						}
						else {
							$errors = "TTL Must be > 0";
						}
					}
				}
	
				if (!$errors) {
					$records->save();
					$logs->addLogEntry($domainid,$domainname,$this->f3->get('SESSION.userid'),$this->f3->get('SESSION.email'),'UPDATE',$f3->get('POST.name').' '.$f3->get('POST.value'),$this->f3->get('SESSION.masteraccountid'));
					http_response_code(200);
					echo "Record Updated";
				}
				else {
					http_response_code(400);
					echo $errors;
				}
			}
			else {
				http_response_code(400);
				echo "Record Not Updated";
			}
		  }
		  
		} else {
			$this->returnError('Your account cannot do that');
		}
	}

	public function ajaxaddrecord($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$domaindata = new DomainData($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$logs = new BigBrother($this->db);
		$validate = new Validate();
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$recordtype = $f3->get('POST.type');
		$recordcontent = $f3->get('POST.content');
		$recordpriority = $f3->get('POST.prio');
		$recordttl = $f3->get('POST.ttl');
		$domainid = $f3->get('POST.domain');
		$domainname = $f3->get('POST.name');
		if($adminlevel == '2') {
			if (empty($recordtype)) {
				$error = "Record Type Cannot Be Empty";
				$this->returnError($error);
				return;
			}
	
			if (empty($recordcontent)) {
				$error = "Content Cannot Be Empty";
				$this->returnError($error);
				return;
			}
	
			if ((int)$recordpriority < 0) {
				$error = "Priority Must Be A Number 0 or higher";
				$this->returnError($error);
				return;
			}
	
			if ((int)$recordttl < 0) {
				$error = "TTL Must Be A Number 0 or higher";
				$this->returnError($error);
				return;
			}
	
			if ($recordtype == "A" || $recordcontent == "AAAA") {
				if ($validate->isValidIP($f3->get('POST.content')) == false) {
					$error = $recordtype . " Records <b>content</b> must be an IP Address";
					$this->returnError($error);
					return;
				}
			}
	
			if ($recordtype == "MX") {
				if ($validate->isValidIP($f3->get('POST.content')) !== false) {
					$error = "MX Records <b>content</b> must not be an IP Address";
					$this->returnError($error);
					return;
				}
			}
	
			if ($domainname == $recordcontent) {
				$error = "You cannot point the domain back to itself";
				$this->returnError($error);
				return;
			}
	
			if (!isset($error)) {
				$addrecord = $records->addNewHost($domainid, $domainname, $recordtype, $recordcontent, $recordpriority, $recordttl);
				if ($addrecord >= 0) {
					$updatedserial = $records->updateSerial($domainid);
					$logs->addLogEntry($domainid,$domainname,$this->f3->get('SESSION.userid'),$this->f3->get('SESSION.email'),'ADD',$recordtype.' '.$recordcontent,$this->f3->get('SESSION.masteraccountid'));
					http_response_code(200);
					echo json_encode(array(
						"newid" => $addrecord,
						"newserial" => $updatedserial
					));
				}
				else {
					$error = "Something Went Wrong";
					$this->returnError($error);
					return;
				}
			}
			else {
				$this->returnError($error);
				return;
			}
			$error = "";
		} 
		if($adminlevel == '1' || $adminlevel == '0') {
			if($domaindata->checkIsOwner($domainid,$this->f3->get('SESSION.masteraccountid')) == true) {
				if (empty($recordtype)) {
					$error = "Record Type Cannot Be Empty";
					$this->returnError($error);
					return;
				}
		
				if (empty($recordcontent)) {
					$error = "Content Cannot Be Empty";
					$this->returnError($error);
					return;
				}
		
				if ((int)$recordpriority < 0) {
					$error = "Priority Must Be A Number 0 or higher";
					$this->returnError($error);
					return;
				}
		
				if ((int)$recordttl < 0) {
					$error = "TTL Must Be A Number 0 or higher";
					$this->returnError($error);
					return;
				}
		
				if ($recordtype == "A" || $recordcontent == "AAAA") {
					if ($validate->isValidIP($f3->get('POST.content')) == false) {
						$error = $recordtype . " Records <b>content</b> must be an IP Address";
						$this->returnError($error);
						return;
					}
				}
		
				if ($recordtype == "MX") {
					if ($validate->isValidIP($f3->get('POST.content')) !== false) {
						$error = "MX Records <b>content</b> must not be an IP Address";
						$this->returnError($error);
						return;
					}
				}
		
				if ($domainname == $recordcontent) {
					$error = "You cannot point the domain back to itself";
					$this->returnError($error);
					return;
				}
		
				if (!isset($error)) {
					$addrecord = $records->addNewHost($domainid, $domainname, $recordtype, $recordcontent, $recordpriority, $recordttl);
					if ($addrecord >= 0) {
						$updatedserial = $records->updateSerial($domainid);
						$logs->addLogEntry($domainid,$domainname,$this->f3->get('SESSION.userid'),$this->f3->get('SESSION.email'),'ADD',$recordtype.' '.$recordcontent,$this->f3->get('SESSION.masteraccountid'));
						http_response_code(200);
						echo json_encode(array(
							"newid" => $addrecord,
							"newserial" => $updatedserial
						));
					}
					else {
						$error = "Something Went Wrong";
						$this->returnError($error);
						return;
					}
			}
			else {
				$this->returnError($error);
				return;
			}
			$error = "";
			}
		} else {
			$this->returnError('Your account cannot do that');
		}
	}

	public function ajaxdeleterecord($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$domaindata = new DomainData($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$logs = new BigBrother($this->db);
		$validate = new Validate();
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$recordid = $f3->get('POST.id');
		$recordtype = $f3->get('POST.type');
		$recordname = $f3->get('POST.name');
		$recordcontent = $f3->get('POST.content');
		$domainid = $f3->get('POST.domainid');
		$domainname = $f3->get('POST.domain');
		if($adminlevel == '2') {
			if (empty($recordtype)) {
				$error = "Record Type Cannot Be Empty";
			}
	
			if (empty($recordcontent)) {
				$error = "Content Cannot Be Empty";
			}
	
			if (!$error) {
				$deleterecord = $records->deleteHost($recordid, $recordtype, $recordname, $recordcontent, $domainid);
				$logs->addLogEntry($domainid,$domainname,$this->f3->get('SESSION.userid'),$this->f3->get('SESSION.email'),'DELETE',$recordtype.' '.$recordname.' '.$recordcontent,$this->f3->get('SESSION.masteraccountid'));
				http_response_code(200);
				return;
			}
			else {
				$this->returnError($error);
				return;
			}
		}
		if($adminlevel == '1' || $adminlevel == '0') {
			if($domaindata->checkIsOwner($domainid,$this->f3->get('SESSION.masteraccountid')) == true) {
				if (empty($recordtype)) {
					$error = "Record Type Cannot Be Empty";
				}
		
				if (empty($recordcontent)) {
					$error = "Content Cannot Be Empty";
				}
		
				if (!$error) {
					$deleterecord = $records->deleteHost($recordid, $recordtype, $recordname, $recordcontent, $domainid);
					$logs->addLogEntry($domainid,$domainname,$this->f3->get('SESSION.userid'),$this->f3->get('SESSION.email'),'DELETE',$recordtype.' '.$recordname.' '.$recordcontent,$this->f3->get('SESSION.masteraccountid'));
					http_response_code(200);
					return;
				}
				else {
					$this->returnError($error);
					return;
				}
			}
		} else {
			$this->returnError('Your account cannot do that');
		}
	}
	
	public function ajaxuserupdate($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$validate = new Validate();
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$userid = $f3->get('POST.accountid');
		$useremail = $f3->get('POST.accountemail');
		$username = $f3->get('POST.accountname');
		$userrole = $f3->get('POST.accountrole');
		$maxdomains = $f3->get('POST.accountmaxdomains');
		$userenabled = $f3->get('POST.accountenabled');
		$masteraccountid = $this->f3->get('SESSION.masteraccountid');
		if($adminlevel == '2') {
			$users->getById($userid);
			if($users->dry()) {
				$error = "Admin Account Does Not Exist";
				$this->returnError($error);
				return;	
			}

			if ($validate->isValidNumber($userrole) === false) {
				$error = "User Role value is incorrect";
				$this->returnError($error);
				return;
			}
	
			if ($validate->isValidNumber($maxdomains) === false) {
				$error = "Max Accounts value is incorrect";
				$this->returnError($error);
				return;
			}
	
			if ($validate->isValidNumber($userenabled) === false) {
				$error = "User Enabled value is incorrect";
				$this->returnError($error);
				return;
			}
				
			$updateduser = $users->updateUser($userid, $useremail, $userrole, $username, $maxdomains, $userenabled);
			if ($updateduser !== false) {
					http_response_code(200);
					echo json_encode(array("newemail" => $updateduser));
			}
			else {
				$error = "Record not Updated";
				$this->returnError($error);
				return;
			}
		} 
		
		if($adminlevel == '1') {
			if($users->checkIsMaster($userid,$masteraccountid) == true) {
				$users->getById($userid);
				if($users->dry()) {
					$error = "Admin Account Does Not Exist";
					$this->returnError($error);
					return;	
				}
	
				if ($validate->isValidNumber($userrole) === false) {
					$error = "User Role value is incorrect";
					$this->returnError($error);
					return;
				}
		
				if ($validate->isValidNumber($maxdomains) === false) {
					$error = "Max Accounts value is incorrect";
					$this->returnError($error);
					return;
				}
		
				if ($validate->isValidNumber($userenabled) === false) {
					$error = "User Enabled value is incorrect";
					$this->returnError($error);
					return;
				}
					
				$updateduser = $users->updateUser($userid, $useremail, $userrole, $username, $maxdomains, $userenabled);
				if ($updateduser !== false) {
						http_response_code(200);
						echo json_encode(array("newemail" => $updateduser));
				}
				else {
					$error = "Record not Updated";
					$this->returnError($error);
					return;
				}
			} else { 
				$this->error("Record Not Updated");
				return;
			}
		}
		else {
			$this->returnError('Your account cannot do that');
		}
	}

	public function ajaxuseradd($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$validate = new Validate();
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$useremail = $f3->get('POST.useremail');
		$username = $f3->get('POST.username');
		$userrole = $f3->get('POST.role');
		$maxdomains = $f3->get('POST.maxdomains');
		$password1 = $f3->get('POST.userpassword1');
		$password2 = $f3->get('POST.userpassword2');
		$masteraccountid = $this->f3->get('SESSION.masteraccountid');
		$userenabled = '1';
		if($adminlevel == '2') {
			if (empty($useremail)) {
				$error = "The Users Email Cannot Be Empty";
				$this->returnError($error);
				return;	
			} else {
				if($validate->isValidEmail($useremail)	=== false) {
				$error = "The Users Email Appears To Be Incorrect";
				$this->returnError($error);
				return;	
				}
			}
			$users->getByEmail($useremail);
			if(!$users->dry()) {
				$error = "The Users Email Account Is Already In The Database";
				$this->returnError($error);
				return;	
			}
							
			if (empty($username)) {
				$error = "The Users Name Cannot Be Empty";
				$this->returnError($error);
				return;	
			}
	
			if (empty($adminlevel)) {
				if ($validate->isValidNumber($adminlevel) === false) {
					$error = "Max Accounts value is incorrect";
					$this->returnError($error);
					return;
				}
			}
			
			if (empty($maxdomains) && !strlen($maxdomains)) {
				$error = "Max Domains Must Not Be Empty";
					$this->returnError($error);
					return;	
				} else {
				if ($validate->isValidNumber($maxdomains) === false) {
					$error = "Max Domains Must Be A Number";
					$this->returnError($error);
					return;
				} 
			}
	
			if(empty($password1)) {
					$error = "First Password Field Cannot Be Empty";
					$this->returnError($error);
					return;				
			}
			
			if(empty($password2)) {
					$error = "Second Password Field Cannot Be Empty";
					$this->returnError($error);
					return;								
			}
	
			if ($password1 !== $password2) {
				$error = "Passwords Do not Match";
				$this->returnError($error);
				return;
			}

			if (strlen($password1) < 9) {
				$error = "Passwords Must Be At Least 9 Characters";
				$this->returnError($error);
				return;
			}
			
			if($adminlevel == 2) {
				$masteraccountid = $f3->get('SITEMASTERUSERID');
			} 

			$useremail = $f3->get('POST.useremail');
			$username = $f3->get('POST.username');
			$userrole = $f3->get('POST.role');
			$maxdomains = $f3->get('POST.maxdomains');
			$password1 = $f3->get('POST.userpassword1');
			$password2 = $f3->get('POST.userpassword2');
			$adduser = $users->add($useremail, $username, $userrole, $maxdomains, $password1, $masteraccountid);
			if ($adduser >= 0) {
					http_response_code(200);
					echo json_encode(array("userid" => $adduser));
			}
			else {
				$error = "User Not Added";
				$this->returnError($error);
				return;
			}
		} 

		if($adminlevel == '1') {
			if (empty($useremail)) {
				$error = "The Users Email Cannot Be Empty";
				$this->returnError($error);
				return;	
			} else {
				if($validate->isValidEmail($useremail)	=== false) {
				$error = "The Users Email Appears To Be Incorrect";
				$this->returnError($error);
				return;	
				}
			}
			$users->getByEmail($useremail);
			if(!$users->dry()) {
				$error = "The Users Email Account Is Already In The Database";
				$this->returnError($error);
				return;	
			}
							
			if (empty($username)) {
				$error = "The Users Name Cannot Be Empty";
				$this->returnError($error);
				return;	
			}
	
			if (empty($adminlevel)) {
				if ($validate->isValidNumber($adminlevel) === false) {
					$error = "User Level value is incorrect";
					$this->returnError($error);
					return;
				}
			}

			if ($adminlevel == '2') {
				$this->returnError("You don't have permission to do that");	
			}
			
			if (empty($maxdomains) && !strlen($maxdomains)) {
				$error = "Max Domains Must Not Be Empty";
					$this->returnError($error);
					return;	
				} else {
				if ($validate->isValidNumber($maxdomains) === false) {
					$error = "Max Domains Must Be A Number";
					$this->returnError($error);
					return;
				} 
			}
	
			if(empty($password1)) {
					$error = "First Password Field Cannot Be Empty";
					$this->returnError($error);
					return;				
			}
			
			if(empty($password2)) {
					$error = "Second Password Field Cannot Be Empty";
					$this->returnError($error);
					return;								
			}
	
			if ($password1 !== $password2) {
				$error = "Passwords Do not Match";
				$this->returnError($error);
				return;
			}

			if (strlen($password1) < 9) {
				$error = "Passwords Must Be At Least 9 Characters";
				$this->returnError($error);
				return;
			}
			
			$useremail = $f3->get('POST.useremail');
			$username = $f3->get('POST.username');
			$userrole = $f3->get('POST.role');
			$maxdomains = $f3->get('POST.maxdomains');
			$password1 = $f3->get('POST.userpassword1');
			$password2 = $f3->get('POST.userpassword2');
			$adduser = $users->add($useremail, $username, $userrole, $maxdomains, $password1, $masteraccountid);
			if ($adduser >= 0) {
					http_response_code(200);
					echo json_encode(array("userid" => $adduser));
			}
			else {
				$error = "User Not Added";
				$this->returnError($error);
				return;
			}
		} else {
			$this->returnError('Your account cannot do that');
		}
	}

	public function ajaxuserdelete($f3) {
		$template = new Template;
		$users = new Users($this->db);
		$validate = new Validate();
		$domaindata = new DomainData($this->db);
		$logs = new BigBrother($this->db);
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$userid = $f3->get('POST.userid');
		$useremail = $f3->get('POST.useremail');
		if($adminlevel == '2') {
			if (empty($userid)) {
				$error = "A problem occured, please refresh the page.";
			}
	
			if (!$error) {
				$user = $users->delete($userid);
				$logs->addLogEntry($domainid,$domainname,$this->f3->get('SESSION.userid'),$this->f3->get('SESSION.email'),'DELETED',$useremail,$this->f3->get('SESSION.masteraccountid'));
				http_response_code(200);
				return;
			}
			else {
				$this->returnError($error);
				return;
			}
		} 		
		if($adminlevel == '1') {
			  if($users->checkIsMaster($userid,$this->f3->get('SESSION.masteraccountid')) == true) {			
				if (empty($userid)) {
					$error = "A problem occured, please refresh the page.";
				}
		
				if (!$error) {
					$user = $users->delete($userid);
					$logs->addLogEntry($domainid,$domainname,$this->f3->get('SESSION.userid'),$this->f3->get('SESSION.email'),'DELETED',$useremail,$this->f3->get('SESSION.masteraccountid'));
					http_response_code(200);
					return;
				}
				else {
					$this->returnError($error);
					return;
				}
			  }
		} 
		else {
			$this->returnError('Your account cannot do that');
		}
	}
	
	public function newPassword() {
		$validate = new Validate();
		$newpass = $validate->genPassword();
	 	echo json_encode(array("password" => $newpass));
	}

	public function returnError($error) {
		http_response_code(400);
		echo $error;	
	}
}
