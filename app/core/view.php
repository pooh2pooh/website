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
		function render($data);
	}

	class View implements iTemplate {

		private array $vars = [];

		function setVariable($name, $var) {
			$this->vars[$name] = $var;
		}

		/*
		 * Метод подменяет маркеры в шаблоне,
		 * {name} обычная переменная
		 * %{page}% файл вида страницы
		 */

		function getHtml($template) {
			foreach($this->vars as $name => $value) {
				$template = str_replace('{'.$name.'}', $value, $template);
				if(preg_match("/%[a-z].*\w[a-z]*\.php%/", $template)) {
                    $template = preg_replace("/%[a-z].*\w[a-z]*\.php%/", file_get_contents('app/views/'.$value), $template);
                }
			}
			return $template;
		}

		/*
		 * Метод рендерит html на экран приложения
		 */

		function render($data) {
			$layout = file_get_contents('app/views/templates/'.$data['layout']);

			foreach($data as $name => $value) {
				$this->setVariable($name, $value);
			}
			echo $this->getHtml($layout);
		}
	}