<?php

	##
	#
	# Класс работы с логикой приложения
	#
	##

	class Controller {

		public 	$model,
				$view;

		function __construct() {
			$this->model 	= new Model();
			$this->view 	= new View();
		}
	}