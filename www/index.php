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
$f3->route('POST /ajax/domains/add [ajax]','AjaxController->ajaxadddomain');
$f3->route('POST /ajax/domains/delete [ajax]','AjaxController->ajaxadeletedomain');
$f3->route('POST /ajax/records/soaupdate [ajax]','AjaxController->ajaxsoaupdate');
$f3->route('POST /ajax/records/update [ajax]','AjaxController->ajaxupdaterecord');
$f3->route('POST /ajax/records/add [ajax]','AjaxController->ajaxaddrecord');
$f3->route('POST /ajax/records/delete [ajax]','AjaxController->ajaxdeleterecord');
// Users
$f3->route('GET /users','DashboardController->renderViewUsers');
$f3->route('GET /users/add','DashboardController->renderAddUser');
$f3->route('GET /users/edit/@USERID','DashboardController->renderEditUser');
// Users AJAX
$f3->route('POST /ajax/users/update [ajax]','AjaxController->ajaxuserupdate');
$f3->route('POST /ajax/users/add [ajax]','AjaxController->ajaxuseradd');
$f3->route('POST /ajax/users/delete [ajax]','AjaxController->ajaxuserdelete');

// General AJAX
$f3->route('GET /ajax/password [ajax]','AjaxController->newPassword');
// Handle Logins & Logout
$f3->route('GET /login','UsersController->renderLogin');
$f3->route('POST /login','UsersController->authenticate');
$f3->route('GET /logout','UsersController->logout');

$f3->run();