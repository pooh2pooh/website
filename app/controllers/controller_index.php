<?php

	class Controller_Index extends Controller {

		/*
		 * В этом классе нельзя переопределять
		 * function __construct
		 */

		function main_page() {

			$data = [
				'layout' 			=> 'default',
				'title' 			=> 'Main page',
				'header_template'	=> file_get_contents('app/views/templates/header.php'),
				'product_template'	=> file_get_contents('app/views/templates/product.php'),
				'products'			=> 'Here Catalog > ',
			];

			$data_array = $this->model->getData();

			foreach($data_array as $name => $value) {
				$this->view->setVariable('id', $value['id']);
				$this->view->setVariable('name', $value['name']);
				$data['products'] .= $this->view->getHtml($data['product_template']);
			}

			$this->view->render('main_page.php', $data);
		}
	}