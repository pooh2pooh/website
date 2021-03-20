<?php

	##
	#
	# Класс работы с логикой приложения
	#
	##

	class Controller {

		public string $domain_url;
        public object $model;
		public object $view;

		function __construct() {
			if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
				$this->domain_url = 'https://'.$_SERVER['SERVER_NAME'];
			else
				$this->domain_url = 'http://'.$_SERVER['SERVER_NAME'];

			$this->model 	= new Model();
			$this->view 	= new View();
		}

		/*
		 * Метод возвращает true,
		 * когда пользователь авторизован
		 */

		function isAuth($login = '', $password_hash = ''): bool
        {

			$data_array = $this->model->getData('users');

			foreach($data_array as $name => $value) {
				if(strlen($login) && !strcmp($login, $value['login'])) {
					if(strlen($password_hash) && !strcmp($password_hash, $value['password'])) return true;
				} else if(isset($_SESSION['hash']) && !strcmp($_SESSION['hash'], md5($value['password']))) return true;
			}
			return false;
		}
	}