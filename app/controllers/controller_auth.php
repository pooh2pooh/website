<?php

	class Controller_Auth extends Controller {

		/*
		 * Если не указано действие
		 */

		function main_page() {
			if(!$this->isAuth())
				header('Location: '.$this->domain_url.'/index/auth');
			else
				header('Location: '.$this->domain_url.'/auth/dashboard');
		}

		/*
		 * Страница Управление,
		 * @для авторизованного пользователя
		 */

		function dashboard() {

			if($this->isAuth()) {

			    // Если есть id,
                // @удаляем соответствующую запись
			    if(isset($_POST['id'])) {
			        $sql = $this->model->queryBuilder('delete');
			        $this->model->setData($sql, array($_POST['id']));
                    echo json_encode(array('result' => 'success'));
                // Иначе рендерим страницу Dashboard
                } else {

                    $data = [
                        'layout'	        => 'auth.template.php',
                        'page'		        => 'auth.dashboard.php',
                        'header'            => 'auth.navbar_inc.php',
                        'sidenav'           => 'auth.sidenav_inc.php',
                        'widget_products'   => 'auth.products_inc.php',
                        'toasts'            => 'auth.toasts_inc.php',
                        'footer'            => 'auth.footer_inc.php',
                        'title'		        => 'Управление сайтом',
                        'product_template'	=> file_get_contents('app/views/templates/auth.product.php'),
                        'products'          => '',
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
            } else
                header('Location: '.$this->domain_url.'/index/auth');
		}

        /*
         * Страница Редактор,
         * @для авторизованного пользователя
         */

		function editor($code_editor) {
            if($this->isAuth()) {

                $data = [
                    'layout'	        => 'auth.template.php',
                    'page'		        => 'auth.editor.php',
                    'header'            => 'auth.navbar_inc.php',
                    'sidenav'           => 'auth.sidenav_inc.php',
                    'widget_editor'     => file_get_contents('app/views/auth.editor_inc.php'),
                    'editor_content'    => '',
                    'toasts'            => 'auth.toasts_inc.php',
                    'footer'            => 'auth.footer_inc.php',
                    'title'		        => 'Редактор',
                ];

                // Читаем файл для передачи в редактор
                if(!strcmp($code_editor, 'default')) {
                    $data['code_editor'] = file_get_contents('app/views/templates/template.php');
                } else if(!strcmp($code_editor, 'product')) {
                    $data['code_editor'] = file_get_contents('app/views/templates/product.php');
                } else if(!strcmp($code_editor, 'auth')) {
                    $data['code_editor'] = file_get_contents('app/views/templates/auth.template.php');
                } else if(!strcmp($code_editor, 'auth.product')) {
                    $data['code_editor'] = file_get_contents('app/views/templates/auth.product.php');
                } else if(!strcmp($code_editor, 'login')) {
                    $data['code_editor'] = file_get_contents('app/views/auth.php');
                } else if(!strcmp($code_editor, 'main_page')) {
                    $data['code_editor'] = file_get_contents('app/views/main_page.php');
                } else if(!strcmp($code_editor, 'header')) {
                    $data['code_editor'] = file_get_contents('app/views/header_inc.php');
                } else if(!strcmp($code_editor, 'footer')) {
                    $data['code_editor'] = file_get_contents('app/views/footer_inc.php');
                }

                // Рендерим содержимое виджета редактора
                foreach($data as $name => $value) {
                    if(!strcmp($name, 'code_editor')) continue;
                        $this->view->setVariable($name, htmlspecialchars($value));
                }
                $data['editor_content'] .= $this->view->getHtml($data['widget_editor']);

                $this->view->render($data);

            } else
                header('Location: '.$this->domain_url.'/index/auth');
        }

        /*
         * Страница Продуктора,
         * @для авторизованного пользователя
         */

        function productor($id_product) {
            if($this->isAuth()) {

                $data = [
                    'layout'	        => 'auth.template.php',
                    'page'		        => 'auth.productor.php',
                    'header'            => 'auth.navbar_inc.php',
                    'sidenav'           => 'auth.sidenav_inc.php',
                    'widget_productor'  => 'auth.productor_inc.php',
                    'toasts'            => 'auth.toasts_inc.php',
                    'footer'            => 'auth.footer_inc.php',
                    'title'		        => 'Продуктор',
                ];

                $this->view->render($data);

            } else
                header('Location: '.$this->domain_url.'/index/auth');
        }
	}