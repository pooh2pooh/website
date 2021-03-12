<?php

	##
	#
	# Класс работы с видом (шаблонами) приложения
	#
	##

	/*
	 * Перед использованием класса вида,
	 * ознакомьтесь с его интерфейсом.
	 * Сначала указываем все используемые маркеры {var}
	 * с помощью setVariables, имя => значение
	 */

	interface iTemplate {
		function setVariable($name, $var);
		function getHtml($template);
	}

	class View {

		private $vars = [];

		function setVariable($name, $var) {
			$this->vars[$name] = $var;
		}

		function getHtml($template) {
			foreach($this->vars as $name => $value) {
				$template = str_replace('{'.$name.'}', $value, $template);
			}
			return $template;
		}

		function render($page, $data, $layout = 'default.php') {
			!is_array($data) ? : extract($data);
			include 'app/views/templates/'.$layout.'.php';
		}
	}