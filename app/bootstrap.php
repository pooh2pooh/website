<?php

	##
	#
	# Собираем ядро приложения,
	# интерфейсы: Model, View, Controller и Route
	#
	##

    trait Debug {

		/*
		 * Настраиваемые переменные,
		 * для подключения
		 */
		private string
			$db_server			= 'localhost',
			$db_type			= 'mysql',
			$db_name			= 'project_db',
			$db_charset			= 'utf8mb4',
			$db_user			= 'pooh',
			$db_pass			= '1234';
		private bool
			// @Применяется в index.php через bootstrap->run(<debug_mode>)
			$debug_mode			= true;

		// Отправляет ошибку на экран приложения
		function sendError($error_message, $file_location) {
			$this->debug_mode ? print $file_location : print 'ошибка: Включи debug чтобы получить больше информации';
			die('<br>' . $error_message);
		}

		// Обёртка для var_dump,
        // с форматированием вывода
        function debug(mixed $var) {
            echo '<pre>';
		    var_dump($var);
            echo '</pre>';
		    die();
        }
	}

	class bootstrap {

		/*
		 * trait: Методы для работы с ошибками,
		 * @находятся в index.php
		 */
		use Debug;

		function run($debug_mode = false) {

			$this->debug_mode = $debug_mode;

			// Собираем ядро приложения
			require_once "app/core/model.php";
			require_once "app/core/view.php";
			require_once "app/core/controller.php";
			require_once "app/core/route.php";

			// Запускаем маршрутизацию
			try {
				Route::run();
			} catch(Exception $e) {
				$this->sendError($e->getMessage(), $e->getFile().':'.$e->getLine());
			}

		}
	}
