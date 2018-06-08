<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['google']['application_name'] = 'PPK2018App';
$config['google']['client_id'] = '496802162480-8ipf7s1ig9oop1bn9o26incjiodta1qj.apps.googleusercontent.com';
$config['google']['client_secret'] = 'dbJCPl1avUWRNAfl7GzkTpIT';
$config['google']['redirect_uri'] = 'http://localhost/PPK2018/PPK_Control/';
$config['google']['api_key'] = 'AIzaSyBEoWz46CU1XjDeO4JkoDyxqSJRM6AbEao';
$config['google']['sess_name'] = "acc_token";
$config['google']['scopes'] = array(
	"https://www.googleapis.com/auth/drive", 
	"https://www.googleapis.com/auth/userinfo.email",
	"https://www.googleapis.com/auth/userinfo.profile"
);
