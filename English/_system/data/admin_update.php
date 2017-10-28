<?php
error_reporting(0);
session_start();
require '../config.php';

if(isset($_SESSION['admin'])){
	if(isset($_POST['name']) &&  isset($_POST['user']) && isset($_POST['pass'])){
		$admin = new Admin;
		$admin->Update($_POST['user'], $_POST['pass'], $_POST['name']);
	}
}