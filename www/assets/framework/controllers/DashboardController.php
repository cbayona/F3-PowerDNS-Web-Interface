<?php
class DashboardController extends Controller {
	public function renderDashboard($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$domaindata = new DomainData($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$siteadmin = new SiteAdmin($this->db);
		$validate = new Validate($this->db);
		$logins = new Logins($this->db);
		$logs = new BigBrother($this->db);
		$validate->isLoggedIn($f3);
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$userleveldesc = $this->f3->get('SESSION.adminleveldesc');
		$userid = $this->f3->get('SESSION.userid');
		$maxdomains = $this->f3->get('SESSION.maxdomains');
		$masteraccountid = $this->f3->get('SESSION.masteraccountid');
		switch ($adminlevel) {
		case 1:
			// Domain Admin
			$urlslug = "domainadmin/";
			break;

		case 2:
			// Site Admin
			$urlslug = "siteadmin/";
			break;

		default:
			// Normal User
			$urlslug = "domainuser/";
			break;
		}

		$this->f3->set('USERLEVELDESC', $userleveldesc);
		$this->f3->set('PAGETITLE', 'Admin Dashboard');
		$this->f3->set('MENUACTIVE', 'HOME');
		$this->f3->set('USERSNAME', $this->f3->get('SESSION.realname'));
		$this->f3->set('USERSEMAIL', $this->f3->get('SESSION.email'));
		$this->f3->set('convIP',function ($ip) { return inet_ntop($ip);});
		if ($adminlevel == "2") {

			// Site Admin
			$domainscount = $domains->countDomains();
			$recordscount = $records->countRecords();
			$userscount = $users->countUsers();
			$adminscount = $users->countAdmins();
			if ($domainscount < 1) {
				$domainscount = "0";
			};
			if ($recordscount < 1) {
				$recordsscount = "0";
			};
			if ($userscount < 1) {
				$userscount = "0";
			};
			if ($adminscount < 1) {
				$adminscount = "0";
			};
			$this->f3->set('PAGECONTENT', $urlslug . 'dashboard-content.html');
			$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
			$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-dashboard.html');
			$this->f3->set('PAGECSS', $urlslug . 'css/css-dashboard.html');
			$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
			$this->f3->set('DOMAINSCOUNT', $domainscount);
			$this->f3->set('RECORDSCOUNT', $recordscount);
			$this->f3->set('USERSCOUNT', $userscount);
			$this->f3->set('ADMINSCOUNT', $adminscount);
		}

		if ($adminlevel == "1") {

			// Domain Admin
			$this->f3->set('PAGECONTENT', $urlslug . 'dashboard-content.html');
			$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
			$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-dashboard.html');
			$this->f3->set('PAGECSS', $urlslug . 'css/css-dashboard.html');
			$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
			$userdomainscount = $domaindata->countUserDomains($userid);
			$this->f3->set('DOMAINSUSEDCOUNT', $userdomainscount);
			if ($maxdomains == "0") {

				// Unlimited Domains
				$domainsavailable = "NaN";
				$userstatsfile = "dashboard-stats-unlimited.html";
			}
			else {

				// User has a limit
				$domainsavailable = $maxdomains - $userdomainscount;
				$userstatsfile = "dashboard-stats-limited.html";
			}

			$this->f3->set('DOMAINSAVAILABLECOUNT', $domainsavailable);
			$userscount = $users->countUserUsers($masterid);
			if ($userdomainscount < 1) {
				$userdomainscount = "0";
			};
			if ($userscount < 1) {
				$userscount = "0";
			};
			$latestlogins = $logins->getByMaster($masteraccountid);
			$latestlogs = $logs->showLastTenMaster($masteraccountid);
			$this->f3->set('LOGINS', $latestlogins);
			$this->f3->set('LATESTLOGS', $latestlogs);
			$this->f3->set('STATSINCLUDE', $urlslug . $userstatsfile);
			$this->f3->set('PAGECONTENT', $urlslug . 'dashboard-content.html');
			$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
			$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-dashboard.html');
			$this->f3->set('PAGECSS', $urlslug . 'css/css-dashboard.html');
			$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
			$this->f3->set('DOMAINSCOUNT', $userdomainscount);
			$this->f3->set('USERSCOUNT', $userscount);
		}
		echo $template->render('page-dashboard.html');
	}

	public function renderViewDomains($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$validate = new Validate($this->db);
		$validate->isLoggedIn($f3);
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$userleveldesc = $this->f3->get('SESSION.adminleveldesc');
		$userid = $this->f3->get('SESSION.userid');
		$maxdomains = $this->f3->get('SESSION.maxdomains');
		$masteraccountid = $this->f3->get('SESSION.masteraccountid');
		switch ($adminlevel) {
		case 1:
			// Domain Admin
			$urlslug = "domainadmin/";
			break;

		case 2:
			// Site Admin
			$urlslug = "siteadmin/";
			break;

		default:
			// Normal User
			$urlslug = "domainuser/";
			break;
		}

		$this->f3->set('USERLEVELDESC', $userleveldesc);
		$this->f3->set('PAGETITLE', 'Admin Dashboard');
		$this->f3->set('MENUACTIVE', 'DOMAINS');
		$this->f3->set('USERSNAME', $this->f3->get('SESSION.realname'));
		$this->f3->set('USERSEMAIL', $this->f3->get('SESSION.email'));
		$this->f3->set('idn_to_utf8', function ($domain){ return idn_to_utf8($domain); });
		if ($adminlevel == "2") {
			// Site Admin
			$alldomains = $domains->listAllDomains();
			if (count($alldomains) == "0") {
				echo "error - no domains?";
			}
			else {
				$this->f3->set('DOMAINLIST', $alldomains);
			}

			$this->f3->set('PAGECONTENT', $urlslug . 'domains-view.html');
			$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
			$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-domains-view.html');
			$this->f3->set('PAGECSS', $urlslug . 'css/css-domains-view.html');
			$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
		}

		if ($adminlevel == "1") {
			// Domain Admin
			$alldomains = $domains->listAllDomainsMaster($masteraccountid);
			if (count($alldomains) == "0") {
				echo "error - no domains?";
			}
			else {
				$this->f3->set('DOMAINLIST', $alldomains);
			}

			$this->f3->set('PAGECONTENT', $urlslug . 'domains-view.html');
			$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
			$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-domains-view.html');
			$this->f3->set('PAGECSS', $urlslug . 'css/css-domains-view.html');
			$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
		}

		echo $template->render('page-domains-view.html');
	}

	public function renderAddDomain($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$validate = new Validate($this->db);
		$validate->isLoggedIn($f3);
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$userleveldesc = $this->f3->get('SESSION.adminleveldesc');
		switch ($adminlevel) {
		case 1:
			// Domain Admin
			$urlslug = "domainadmin/";
			break;

		case 2:
			// Site Admin
			$urlslug = "siteadmin/";
			break;

		default:
			// Normal User
			$urlslug = "domainuser/";
			break;
		}

		$this->f3->set('USERLEVELDESC', $userleveldesc);
		$this->f3->set('PAGETITLE', 'Add Domain');
		$this->f3->set('MENUACTIVE', 'DOMAINS');
		$this->f3->set('USERSNAME', $this->f3->get('SESSION.realname'));
		$this->f3->set('USERSEMAIL', $this->f3->get('SESSION.email'));
		if ($adminlevel == "2") {

			// Site Admin
			$useremails = $users->listAllEmails();
			$this->f3->set('ALLEMAILS', $useremails);
			$this->f3->set('PAGECONTENT', $urlslug . 'domains-add.html');
			$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
			$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-domains-add.html');
			$this->f3->set('PAGECSS', $urlslug . 'css/css-domains-add.html');
			$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
		}

		if ($adminlevel == "1") {
			$masteraccountid = $this->f3->get('SESSION.masteraccountid');
			$useremails = $users->listAllEmailsMasterAccount($masteraccountid);
			$this->f3->set('ALLEMAILS', $useremails);
			$this->f3->set('PAGECONTENT', $urlslug . 'domains-add.html');
			$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
			$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-domains-add.html');
			$this->f3->set('PAGECSS', $urlslug . 'css/css-domains-add.html');
			$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
		}

		echo $template->render('page-domains-view.html');
	}

	public function renderEditDomain($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$domaindata = new DomainData($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$validate = new Validate($this->db);
		$validate->isLoggedIn($f3);
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$userleveldesc = $this->f3->get('SESSION.adminleveldesc');
		$userid = $this->f3->get('SESSION.userid');
		$maxdomains = $this->f3->get('SESSION.maxdomains');
		$masteraccountid = $this->f3->get('SESSION.masteraccountid');
		switch ($adminlevel) {
		case 1:
			// Domain Admin
			$urlslug = "domainadmin/";
			break;

		case 2:
			// Site Admin
			$urlslug = "siteadmin/";
			break;

		default:
			// Normal User
			$urlslug = "domainuser/";
			break;
		}

		$domainid = $this->f3->get('PARAMS.DOMAINID');
		$this->f3->set('USERLEVELDESC', $userleveldesc);
		$this->f3->set('PAGETITLE', 'Edit Domain');
		$this->f3->set('MENUACTIVE', 'DOMAINS');
		$this->f3->set('USERSNAME', $this->f3->get('SESSION.realname'));
		$this->f3->set('USERSEMAIL', $this->f3->get('SESSION.email'));
		$this->f3->set('idn_to_utf8', function ($domain) { return idn_to_utf8($domain); });
		$this->f3->set('idn_to_utf8_email', function ($email) {
			list($user, $domain) = explode('@', $email);
			$user = idn_to_utf8($user);
			$domain = idn_to_utf8($domain);
			$email = $user . '@' . $domain;
			return $email;
		});
		if ($adminlevel == "2") {
			// Site Admin
			$domains->getById($domainid);
			if ($domains->dry()) {
				// Error Handling
			}

			$this->f3->set('DOMAINNAME', $domains->name);
			$this->f3->set('DOMAINID', $domainid);
			list($soaprimary, $soaemail, $soaserial, $soarefresh, $soaretry, $soaexpire, $soattl) = $soa->getSOADetails($domainid);
			$this->f3->set('SOAPRIMARY', $soaprimary);
			$this->f3->set('SOAEMAIL', $soaemail);
			$this->f3->set('SOASERIAL', $soaserial);
			$this->f3->set('SOAREFRESH', $soarefresh);
			$this->f3->set('SOARETRY', $soaretry);
			$this->f3->set('SOAEXPIRE', $soaexpire);
			$this->f3->set('SOATTL', $soattl);
			$domainrecords = $records->getDomainRecords($domainid);
			if ($records->dry()) {
				// Error Handling
			}

			$this->f3->set('DOMAINRECORDS', $domainrecords);
			$this->f3->set('PAGECONTENT', $urlslug . 'domains-edit.html');
			$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
			$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-domains-edit.html');
			$this->f3->set('PAGECSS', $urlslug . 'css/css-domains-edit.html');
			$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
		}

		if ($adminlevel == "1") {
			// Domain Admin
			if ($domaindata->checkIsOwner($domainid, $userid) == true) {
				$domains->getById($domainid);
				if ($domains->dry()) {
					// Error Handling
				}

				$this->f3->set('DOMAINNAME', $domains->name);
				$this->f3->set('DOMAINID', $domainid);
				list($soaprimary, $soaemail, $soaserial, $soarefresh, $soaretry, $soaexpire, $soattl) = $soa->getSOADetails($domainid);
				$this->f3->set('SOAPRIMARY', $soaprimary);
				$this->f3->set('SOAEMAIL', $soaemail);
				$this->f3->set('SOASERIAL', $soaserial);
				$this->f3->set('SOAREFRESH', $soarefresh);
				$this->f3->set('SOARETRY', $soaretry);
				$this->f3->set('SOAEXPIRE', $soaexpire);
				$this->f3->set('SOATTL', $soattl);
				$domainrecords = $records->getDomainRecords($domainid);
				if ($records->dry()) {
					// Error Handling
				}

				$this->f3->set('DOMAINRECORDS', $domainrecords);
				$this->f3->set('PAGECONTENT', $urlslug . 'domains-edit.html');
				$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
				$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-domains-edit.html');
				$this->f3->set('PAGECSS', $urlslug . 'css/css-domains-edit.html');
				$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
			}
			else {
				$f3->reroute('/invalid-permissions/edit-domain');
			}
		}

		echo $template->render('page-domains-view.html');
	}

	public function renderViewUsers($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$validate = new Validate($this->db);
		$validate->isLoggedIn($f3);
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$userleveldesc = $this->f3->get('SESSION.adminleveldesc');
		switch ($adminlevel) {
		case 1:
			// Domain Admin
			$urlslug = "domainadmin/";
			break;

		case 2:
			// Site Admin
			$urlslug = "siteadmin/";
			break;

		default:
			// Normal User
			$urlslug = "domainuser/";
			break;
		}

		$this->f3->set('USERLEVELDESC', $userleveldesc);
		$this->f3->set('PAGETITLE', 'Admin Dashboard');
		$this->f3->set('MENUACTIVE', 'USERS');
		$this->f3->set('USERSNAME', $this->f3->get('SESSION.realname'));
		$this->f3->set('USERSEMAIL', $this->f3->get('SESSION.email'));
		$this->f3->set('idn_to_utf8', function ($domain) { return idn_to_utf8($domain); });
		if ($adminlevel == "2") {
			// Site Admin
			$allusers = $users->listAllUsers();
			if (count($allusers) == "0") {
				echo "error - no users?";
			}
			else {
				$this->f3->set('USERLIST', $allusers);
			}

			$this->f3->set('PAGECONTENT', $urlslug . 'users-view.html');
			$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
			$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-users-view.html');
			$this->f3->set('PAGECSS', $urlslug . 'css/css-users-view.html');
			$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
		}

		if ($adminlevel == "1") {
			// Domain Admin
			$masteraccountid = $this->f3->get('SESSION.masteraccountid');
			$allusers = $users->listAllUsersMasterAccount($masteraccountid);
			if (count($allusers) == "0") {
				echo "error - no users?";
			}
			else {
				$this->f3->set('USERLIST', $allusers);
			}

			$this->f3->set('PAGECONTENT', $urlslug . 'users-view.html');
			$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
			$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-users-view.html');
			$this->f3->set('PAGECSS', $urlslug . 'css/css-users-view.html');
			$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
		}

		echo $template->render('page-users-view.html');
	}

	public function renderEditUser($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$soa = new SOA($this->db);
		$validate = new Validate($this->db);
		$validate->isLoggedIn($f3);
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$userleveldesc = $this->f3->get('SESSION.adminleveldesc');
		switch ($adminlevel) {
		case 1:
			// Domain Admin
			$urlslug = "domainadmin/";
			break;

		case 2:
			// Site Admin
			$urlslug = "siteadmin/";
			break;

		default:
			// Normal User
			$urlslug = "domainuser/";
			break;
		}

		$userid = $this->f3->get('PARAMS.USERID');
		$this->f3->set('USERLEVELDESC', $userleveldesc);
		$this->f3->set('PAGETITLE', 'Edit User');
		$this->f3->set('MENUACTIVE', 'USERSS');
		$this->f3->set('USERSNAME', $this->f3->get('SESSION.realname'));
		$this->f3->set('USERSEMAIL', $this->f3->get('SESSION.email'));
		if ($adminlevel == "2") {
			// Site Admin
			$users->getById($userid);
			if ($users->dry()) {
				// Error Handling
			}

			$userdomains = $domains->listAllDomainsUserID($userid);
			if (empty($userdomains)) {
			}

			$useremails = $users->listAllEmails();
			$this->f3->set('ALLEMAILS', $useremails);
			$this->f3->set('USEREMAIL', $users->userEmail);
			$this->f3->set('USERNAME', $users->userName);
			$this->f3->set('USERADMINLEVEL', $users->userAdminLevel);
			$this->f3->set('USERENABLED', $users->userEnabled);
			$this->f3->set('USERMAXDOM', $users->userMaxDomains);
			$this->f3->set('USERID', $userid);
			$this->f3->set('USERDOMLIST', $userdomains);
			$domainrecords = $records->getDomainRecords($domainid);
			if ($records->dry()) {
				// Error Handling
			}

			$this->f3->set('DOMAINRECORDS', $domainrecords);
			$this->f3->set('PAGECONTENT', $urlslug . 'users-edit.html');
			$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
			$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-users-edit.html');
			$this->f3->set('PAGECSS', $urlslug . 'css/css-domains-edit.html');
			$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
		}

		if ($adminlevel == "1") {
			// Domain Admin
			$masteraccountid = $this->f3->get('SESSION.masteraccountid');
			if($users->checkIsMaster($userid,$masteraccountid) == true) {
				$users->getById($userid);
				if ($users->dry()) {
					// Error Handling
				}
	
				$userdomains = $domains->listAllDomainsUserID($userid);
				if (empty($userdomains)) {
				}
	
				$useremails = $users->listAllEmails();
				$this->f3->set('ALLEMAILS', $useremails);
				$this->f3->set('USEREMAIL', $users->userEmail);
				$this->f3->set('USERNAME', $users->userName);
				$this->f3->set('USERADMINLEVEL', $users->userAdminLevel);
				$this->f3->set('USERENABLED', $users->userEnabled);
				$this->f3->set('USERMAXDOM', $users->userMaxDomains);
				$this->f3->set('USERID', $userid);
				$this->f3->set('USERDOMLIST', $userdomains);
				$domainrecords = $records->getDomainRecords($domainid);
				if ($records->dry()) {
					// Error Handling
				}
	
				$this->f3->set('DOMAINRECORDS', $domainrecords);
				$this->f3->set('PAGECONTENT', $urlslug . 'users-edit.html');
				$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
				$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-users-edit.html');
				$this->f3->set('PAGECSS', $urlslug . 'css/css-domains-edit.html');
				$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
			}
			echo $this->db->log();
		}
		echo $template->render('page-domains-view.html');
	}

	public function renderAddUser($f3) {
		$template = new Template;
		$domains = new Domains($this->db);
		$records = new Records($this->db);
		$users = new Users($this->db);
		$validate = new Validate($this->db);
		$validate->isLoggedIn($f3);
		$adminlevel = $this->f3->get('SESSION.adminlevel');
		$userleveldesc = $this->f3->get('SESSION.adminleveldesc');
		switch ($adminlevel) {
		case 1:
			// Domain Admin
			$urlslug = "domainadmin/";
			break;

		case 2:
			// Site Admin
			$urlslug = "siteadmin/";
			break;

		default:
			// Normal User
			$urlslug = "domainuser/";
			break;
		}

		$this->f3->set('USERLEVELDESC', $userleveldesc);
		$this->f3->set('PAGETITLE', 'Add User');
		$this->f3->set('MENUACTIVE', 'USERS');
		$this->f3->set('USERSNAME', $this->f3->get('SESSION.realname'));
		$this->f3->set('USERSEMAIL', $this->f3->get('SESSION.email'));
		if ($adminlevel == "2") {
			// Site Admin
			$this->f3->set('ALLEMAILS', $useremails);
			$this->f3->set('PAGECONTENT', $urlslug . 'users-add.html');
			$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
			$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-users-add.html');
			$this->f3->set('PAGECSS', $urlslug . 'css/css-domains-add.html');
			$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
		}

		if ($adminlevel == "1") {
			// Domain Admin
			$this->f3->set('ALLEMAILS', $useremails);
			$this->f3->set('PAGECONTENT', $urlslug . 'users-add.html');
			$this->f3->set('PAGESIDEMENU', $urlslug . 'sidemenu.html');
			$this->f3->set('PAGEJAVASCRIPT', $urlslug . 'js/js-users-add.html');
			$this->f3->set('PAGECSS', $urlslug . 'css/css-domains-add.html');
			$this->f3->set('PAGETOPNAV', $urlslug . 'header-nav.html');
		}

		echo $this->db->log();
		echo $template->render('page-domains-view.html');
	}
}