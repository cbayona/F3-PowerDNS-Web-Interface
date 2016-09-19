<?php
class DomainsController extends Controller {
	
	public function siteadminajaxadddomain($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$domaindata = new DomainData($this->db);
		$validate = new Validate();
		if($validate->requiredLevel('2')) {
			$adminlevel = $this->f3->get('SESSION.adminlevel');
			$userleveldesc = $this->f3->get('SESSION.adminleveldesc');
			$this->f3->set('USERSNAME', $this->f3->get('SESSION.realname'));
			$this->f3->set('USERSEMAIL', $this->f3->get('SESSION.email'));
			$domainname = $f3->get('POST.domain');
			$domainemail = $f3->get('POST.email');
			$domainprimary = $f3->get('POST.primary');
			$domainrefresh = $this->f3->get('DEFAULTSOAREFRESH');
			$domainexpire = $this->f3->get('DEFAULTSOAEXPIRE');
			$domainretry = $this->f3->get('DEFAULTSOARETRY');
			$domainttl = $this->f3->get('DEFAUTLSOATTL');
			if (empty($domainname)) {
				$error = "Domain Name Cannot Be Empty";
				$this->returnError($error);
				return;
			}
	
			if (empty($domainemail)) {
				$error = "Content Cannot Be Empty";
				$this->returnError($error);
				return;
			}
	
			if (empty($domainprimary)) {
				$error = "Content Cannot Be Empty";
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
			$domainemail = $validate->isAsciiEmail($domainemail);
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
					$adddomhash = $domaindata->addDomainHash($adddomain,$domainname);
						if ($addsoa >= 0 && $adddomhash === true) {
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
		} else {
			$this->returnError('Your account cannot do that');
			return;	
		}
	}

	public function siteadminajaxadeletedomain($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$validate = new Validate();
		$domaindata = new DomainData($this->db);
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$userleveldesc = $this->f3->get('SESSION.adminleveldesc');
		$domainid = $f3->get('POST.domainid');
		$domainname = $f3->get('POST.name');
		if($validate->requiredLevel('2')) {
			if (empty($domainid)) {
				$error = "A problem occured, please refresh the page.";
			}
	
			if (!$error) {
				$deletedomain = $domains->delete($domainid);
				$deletedomaindata = $domaindata->deleteByDomainID($domainid);
				http_response_code(200);
				return;
			}
			else {
				$this->returnError($error);
				return;
			}
		} else {
			$this->returnError('Your account cannot do that');
		}
	}

	public function siteadminajaxsoaupdate($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$validate = new Validate();
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$userleveldesc = $this->f3->get('SESSION.adminleveldesc');
		$domainid = $this->f3->get('PARAMS.DOMAINID');
		$this->f3->set('USERSNAME', $this->f3->get('SESSION.realname'));
		$this->f3->set('USERSEMAIL', $this->f3->get('SESSION.email'));
		$domainid = $f3->get('POST.domainid');
		$domainname = $f3->get('POST.domainname');
		$soaprimary = $f3->get('POST.soaPrimary');
		$soamail = $f3->get('POST.soaMail');
		$soaretry = $f3->get('POST.soaRetry');
		$soaexpire = $f3->get('POST.soaExpire');
		$soattl = $f3->get('POST.soaTtl');
		$soaserial = $f3->get('POST.soaSerial');
		$soarefresh = $f3->get('POST.soaRefresh');
		if($validate->requiredLevel('2')) {
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
		} else {
			$this->returnError('Your account cannot do that');
		}
	}

	public function siteadminajaxupdaterecord($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$validate = new Validate();
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$userleveldesc = $this->f3->get('SESSION.adminleveldesc');
		$domainid = $this->f3->get('PARAMS.DOMAINID');
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
		if($validate->requiredLevel('2')) {
			$records->load(array(
				'id=?',
				$pk
			));
			if ($records->dry()) {
				// Error Handling
			}
	
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
		} else {
			$this->returnError('Your account cannot do that');
		}
	}

	public function siteadminajaxaddrecord($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$validate = new Validate();
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$userleveldesc = $this->f3->get('SESSION.adminleveldesc');
		$this->f3->set('USERLEVELDESC', $userleveldesc);
		$this->f3->set('PAGETITLE', 'Edit Domain');
		$this->f3->set('USERSNAME', $this->f3->get('SESSION.realname'));
		$this->f3->set('USERSEMAIL', $this->f3->get('SESSION.email'));
		$recordtype = $f3->get('POST.type');
		$recordcontent = $f3->get('POST.content');
		$recordpriority = $f3->get('POST.prio');
		$recordttl = $f3->get('POST.ttl');
		$domainid = $f3->get('POST.domain');
		$domainname = $f3->get('POST.name');
		if($validate->requiredLevel('2')) {
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
				if ($validate->isValidIP($f3->get('POST.value')) == false) {
					$error = $recordtype . " Records <b>content</b> must be an IP Address";
					$this->returnError($error);
					return;
				}
			}
	
			if ($recordtype == "MX") {
				if ($validate->isValidIP($f3->get('POST.value')) !== false) {
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
		} else {
			$this->returnError('Your account cannot do that');
		}
	}

	public function siteadminajaxdeleterecord($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$validate = new Validate();
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$userleveldesc = $this->f3->get('SESSION.adminleveldesc');
		$recordid = $f3->get('POST.id');
		$recordtype = $f3->get('POST.type');
		$recordname = $f3->get('POST.name');
		$recordcontent = $f3->get('POST.content');
		$domainid = $f3->get('POST.domainid');
		$domainname = $f3->get('POST.domain');
		if($validate->requiredLevel('2')) {
			if (empty($recordtype)) {
				$error = "Record Type Cannot Be Empty";
			}
	
			if (empty($recordcontent)) {
				$error = "Content Cannot Be Empty";
			}
	
			if (!$error) {
				$deleterecord = $records->deleteHost($recordid, $recordtype, $recordname, $recordcontent, $domainid);
				http_response_code(200);
				return;
			}
			else {
				$this->returnError($error);
				return;
			}
		} else {
			$this->returnError('Your account cannot do that');
		}
	}

	public function returnError($errormsg)
	{
		http_response_code(400);
		echo $errormsg;
	}
}