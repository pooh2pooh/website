<?php

	class Controller_Index extends Controller {

		/*
		 * В этом классе нельзя переопределять
		 * function __construct
		 */

		function main_page($action) {

		    // Уничтожаем данные сессии
		    if(!strcmp($action, 'exit'))
		        session_destroy();

			$data = [
				'layout' 			=> 'template.php',
				'page'				=> 'main_page.php',
				'header'			=> 'header_inc.php',
				'footer'			=> 'footer_inc.php',
				'title' 			=> 'Главная страница',
				'product_template'	=> file_get_contents('app/views/templates/product.php'),
				'products'			=> '',
			];

			// Собираем каталог товаров,
			// @шаблон app/views/templates/product.php
			$data_array = $this->model->getData();

			foreach($data_array as $i => $array) {
				foreach($array as $name => $value) {
					$this->view->setVariable($name, $value);
				}
				$data['products'] .= $this->view->getHtml($data['product_template']);
			}

			$this->view->render($data);
		}

		function auth() {

			/*
			 * Авторизация пользователя,
			 *
			 */

			if(!isset($_POST['login']) || !isset($_POST['password'])) {
				// Если пользователь уже авторизован
				if(isset($_SESSION['hash']) && $this->isAuth()) {
					header('Location: '.$this->domain_url.'/auth/dashboard');
				}
				else {
					// Если пользователь не авторизован
					$data = [
						'layout'	=> 'auth.template.php',
						'page'		=> 'auth.php',
						'title'		=> 'Авторизация',
					];

					$this->view->render($data);
				}
			} else {
				// Если пользователь отправил форму авторизации
				if($this->isAuth($_POST['login'], md5($_POST['password']))) {
					$_SESSION['hash'] = md5(md5($_POST['password']));
					echo json_encode(array('result' => 'success'));
				}
			}
		}
	}