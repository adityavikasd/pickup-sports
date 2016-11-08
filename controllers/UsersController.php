<?php
/*
    class UsersController extends CI_Controller{
    function index(){
        $this->load->view("welcome",$data);
    }
}
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class UsersController extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome.html');
	}
    
    public function login()
	{
		$this->load->view('login');
	}
    
    public function register()
	{
		$this->load->view('register.html');
	}
    
}