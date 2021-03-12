<?php

	##
	#
	# Класс работы с маршрутизацией
	#
	##

	class Route {

		static function run() {

			// Контроллер и действие по-умолчанию
			$controller_name	= 'Index';
			$action_name 		= 'main_page';
			$param				= '';

			// Парсим строку на,
			// контроллер / действие / параметры
			$routes = explode('/', $_SERVER['REQUEST_URI']);

			empty($routes[1]) ? : $controller_name = $routes[1];
			empty($routes[2]) ? : $action_name = $routes[2];
			empty($routes[3]) ? : $param = urldecode($routes[3]);

			// Присваиваем префиксы файлов,
			// модели и контроллера
			$model_name 		= 'Model_'.$controller_name;
			$controller_name	= 'Controller_'.$controller_name;

			// Подключаем файл Модели,
			// его может и не быть
			$model_file = strtolower($model_name).'.php';
			$model_path = 'app/models/'.$model_file;
			!file_exists($model_path) ? : include $model_path;

			// Подключаем файл Контроллера,
			$controller_file = strtolower($controller_name).'.php';
			$controller_path = 'app/controllers/'.$controller_file;
			!file_exists($controller_path) ? throw new Exception('Не найден файл контроллера!') : include $controller_path;

			$controller = new $controller_name;
			$action = $action_name;

			!method_exists($controller, $action) ? throw new Exception('Не найден метод '.$action.' контроллера '.$controller) : $controller->$action($param);
		}

	}