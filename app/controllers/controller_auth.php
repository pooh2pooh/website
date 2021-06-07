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

                //
			    // Если есть id,
                // @удаляем соответствующую запись
			    if(isset($_POST['id'])) {
			        $sql = $this->model->queryBuilder('delete');
			        $this->model->setData($sql, array($_POST['id']));
                    echo json_encode(array('result' => 'success'));
                //
                // Иначе рендерим страницу Dashboard
                } else {

                    $data = [
                        'layout'	        => 'auth.template.php',
                        'page'		        => 'auth.dashboard.php',
                        'header'            => 'auth.header_inc.php',
                        'widget_products'   => 'auth.products_inc.php',
                        'toasts'            => 'auth.toasts_inc.php',
                        'footer'            => 'auth.footer_inc.php',
                        'title'		        => 'Управление сайтом',
                        'current'           => 'Управление сайтом',
                        'product_template'	=> file_get_contents('app/views/templates/auth.product.php'),
                        'products'          => '',
                        // Логин текущего пользователя
                        'login'             => $this->getLogin(),
                    ];

                    //
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
                    'header'            => 'auth.header_inc.php',
                    'widget_editor'     => file_get_contents('app/views/auth.editor_inc.php'),
                    'editor_content'    => '',
                    'toasts'            => 'auth.toasts_inc.php',
                    'footer'            => 'auth.footer_inc.php',
                    'title'             => 'Редактор',
                    'current'		    => 'Редактор',
                    // Логин текущего пользователя
                    'login'             => $this->getLogin(),
                ];



                //
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

                //
                // Рендерим содержимое виджета редактора
                foreach ($data as $name => $value) {
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
            if ($this->isAuth()) {

                //
                // Загружаем картинку
                if(!empty($_FILES['picture']['name'])){
                    
                    //File uplaod configuration
                    $result = 0;
                    $uploadDir = "images/";
                    $fileName = time().'_'.basename($_FILES['picture']['name']);
                    $targetPath = $uploadDir. $fileName;
                    
                    //Upload file to server
                    if(move_uploaded_file($_FILES['picture']['tmp_name'], $targetPath)){
                        //Get current user ID from session
                        $userId = 1;
                        
                        //Update picture name in the database
                        //$update = $db->query("UPDATE users SET picture = '".$fileName."' WHERE id = $userId");

                        $update = true;
                        
                        //Update status
                        if($update){
                            $result = 1;
                        }
                    }
                    
                    //Load JavaScript function to show the upload status
                    echo '<script type="text/javascript">window.top.window.completeUpload(' . $result . ',\'' . $fileName . '\');</script>  ';
                    return true;
                }

                //
                // Если обновление записи,
                // выполняем и завершаемся
                if (isset($_POST['id']) && $_POST['id'] > 0) {

                    $result = array(
                        'status' => 'success',
                        'name' => 'test',
                    );

                    // Переводим массив в JSON
                    echo json_encode($result);
                    return true;
                //
                // Если новая запись,
                // выполняем и завершаемся
                } else if (isset($_POST['name'])) {

                    $result = array(
                        'status' => 'success',
                        'name' => $_POST['name'],
                    );

                    // var_dump ($_POST);

                    $data_new_product = [];

                    //
                    // Обрабатываем переданные в POST запросе данные,
                    // и помещаем их в вновь созданный массив.
                    // Это нужно для сохранения порядка и обработки пустных значений
                    foreach ($_POST as $name => $value) {
                        if (!strcmp($name, 'id') || !strcmp($name, 'picture'))
                            continue;
                        else if (!strcmp($name, 'name')) {
                            if (!isset($_POST['picture']))
                                array_push($data_new_product, $value, NULL);
                            else
                                array_push($data_new_product, $value, $_POST['picture']);
                        }    
                        else if (!strcmp($name, 'on_main'))
                            array_push($data_new_product, 1);
                        else array_push($data_new_product, $value);
                    }

                    //
                    // Если не передан параметр чекбокс,
                    // отображать ли позицию на витрине
                    if (!isset($_POST['on_main']))
                        array_push($data_new_product, 0);

                    // var_dump ($_POST);

                    $sql = $this->model->queryBuilder('insert');

                    // var_dump ($sql);

                    $this->model->setData($sql, $data_new_product);

                    // Переводим массив в JSON
                    echo json_encode($result);
                    return true;
                }

                //
                // Рендерим страницу

                $data = [
                    'layout'	        => 'auth.template.php',
                    'page'		        => 'auth.productor.php',
                    'header'            => 'auth.header_inc.php',
                    'widget_productor'  => file_get_contents('app/views/auth.productor_inc.php'),
                    'toasts'            => 'auth.toasts_inc.php',
                    'footer'            => 'auth.footer_inc.php',
                    'title'             => 'Продуктор',
                    'current'		    => 'Продуктор',
                    // Логин текущего пользователя
                    'login'             => $this->getLogin(),
                ];

                $form_params = [
                    'id' => [
                        'name'  => '',
                        'type'  => '',
                    ],
                ];

                $tbl_structure = $this->model->queryBuilder('structure');
                $values = $this->model->getDataRow('products', $id_product);

                $tbl_structure_name = array_column($tbl_structure, 'Field');
                $tbl_structure_type = array_column($tbl_structure, 'Type');
                $form_structure = array_combine($tbl_structure_name, $tbl_structure_type);

                foreach ($form_structure as $name => $value) {
                    $form_params[$name]['name'] = $name;
                    $form_params[$name]['type'] = $value;

                }
                $data['forms'] = $this->view->formBuilder($form_params, $values);
                #$this->debug($form_params);

                $this->view->render($data);

            } else
                //
                // Если пользователь не авторизован,
                // возвращаем его на страницу авторизации
                header('Location: '.$this->domain_url.'/index/auth');
        }
	}