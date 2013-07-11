<?php

	class AdminController extends \Lemonade\Controller{

		protected $components = array("session", "auth");

		public function index(){
			echo "INDEX";
		}

		public function login(){
			if($this->request->isPost()){
				$this->auth->login("user", "123");
			}
			$this->view("login");
		}

		public function logout(){
			$this->auth->logout();
		}

	}
