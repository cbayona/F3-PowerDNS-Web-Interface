<?php
$f3=require('../lib/base.php');
$f3->set('DEBUG',1);
if ((float)PCRE_VERSION<7.9)
	trigger_error('PCRE version is out of date');
$f3->config('../config.ini');
// Main Dashboard Controller
$f3->route('GET /','DashboardController->renderDashboard');
// SITEADMIN
// Domains
$f3->route('GET /domains','DashboardController->renderViewDomains');
$f3->route('GET /domains/add','DashboardController->renderAddDomain');
$f3->route('GET /domains/edit/@DOMAINID','DashboardController->renderEditDomain');
// Domains AJAX
$f3->route('POST /ajax/domains/add [ajax]','DomainsController->siteadminajaxadddomain');
$f3->route('POST /ajax/domains/delete [ajax]','DomainsController->siteadminajaxadeletedomain');
$f3->route('POST /ajax/records/soaupdate [ajax]','DomainsController->siteadminajaxsoaupdate');
$f3->route('POST /ajax/records/update [ajax]','DomainsController->siteadminajaxupdaterecord');
$f3->route('POST /ajax/records/add [ajax]','DomainsController->siteadminajaxaddrecord');
$f3->route('POST /ajax/records/delete [ajax]','DomainsController->siteadminajaxdeleterecord');

// Handle Logins & Logout
$f3->route('GET /login','UsersController->renderLogin');
$f3->route('POST /login','UsersController->authenticate');
$f3->route('GET /logout','UsersController->logout');

$f3->run();