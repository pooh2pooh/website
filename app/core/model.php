<?php

	##
	#
	# Класс работы с базой данных
	#
	##

	class Model {

		/*
		 * trait: Настройки подключения к базе
		 * и методы для работы с ошибками,
		 * @находятся в index.php
		 */
		use Debug;

		/*
		 * Конструктор создаёт объект,
		 * подключения к базе данных
		 */
		protected $db_object;

		function __construct() {
			try {
				$this->db_object = new PDO("$this->db_type:host=$this->db_server;dbname=$this->db_name;charset=$this->db_charset", $this->db_user, $this->db_pass);
			} catch(PDOException $e) {
				$this->sendError($e->getMessage(), $e->getFile().':'.$e->getLine());
			}
		}

		function getData($tbl_name = 'products', $orderby = 'id') {
			try {
				$sth = $this->db_object->prepare("SELECT * FROM $tbl_name ORDER BY :orderby");
				$sth->execute(array('orderby' => $orderby));
				$data_arr = $sth->fetchAll(PDO::FETCH_ASSOC);
				return $data_arr;
			} catch(PDOException $e) {
				$this->sendError($e->getMessage(), $e->getFile().':'.$e->getLine());
			}
		}
	}