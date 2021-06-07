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
		function getHtml(string $template);
		function render(array $data);
	}

	class View implements iTemplate {

	    use Debug;

		private array $vars = [];

		/*
		 * Метод устанавливает переменные шаблона
		 */

		function setVariable($name, $var) {
			$this->vars[$name] = $var;
		}

		/*
		 * Метод подменяет маркеры в шаблоне,
		 * {name} обычная переменная (может хранить html код)
		 * %{page}% подключаемый файл (виджет) страницы
		 */

		function getHtml(string $template) {
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

		function render(array $data) {
			$layout = file_get_contents('app/views/templates/'.$data['layout']);

			foreach($data as $name => $value) {
				$this->setVariable($name, $value);
			}
			echo $this->getHtml($layout);
		}

        /*
         * Метод построения форм
         */

        function formBuilder(array $form_params, array $values = NULL) {

        	//
        	// Параметры и данные формы

            $form_template = '';
            if (!sizeof($values)) {
            	$values = [
            		[],
            	];
            }

            //
            // tinyint (bool) — checkbox
            // string (varchar and int) — input text

            foreach ($form_params as $value) {

            	if (!isset($values[0][$value['name']])) {
            		$values[0][$value['name']] = '';
            	}
            	if (!strcmp($value['name'], 'picture')) {

            		if (!strlen($values[0][$value['name']]))
            			$values[0][$value['name']] = 'no-image.png';

            		$pic_form = '
            				<!-- Loading image -->
							<div class="overlay uploadProcess" style="display: none;">
								<div class="overlay-content"><img src="/images/loading.gif"></div>
							</div>
							<!-- Hidden upload form -->
							<input type="file" name="picture" id="fileInput" style="display: none;">
							<iframe id="uploadTarget" name="uploadTarget" src="#" style="width: 0; height: 0; border: 0px solid #fff;"></iframe>
							<!-- Product image -->
							<a class="editLink" href="javascript:void(0);"><img class="img-fluid" src="/images/'.$values[0][$value['name']].'" id="imagePreview"></a>
            		';
            	}

            	//
            	// Возвращает только название типа,
            	// без размера (длины)
                $form_type = strstr($value['type'], '(', true);

                if (!strcmp($value['name'], 'id')) {
                    $form_template .= '
                            <div class="form-floating d-none">
                                <input class="form-control" type="text" name="' . $value['name'] . '" value="' . $values[0][$value['name']] . '">
                                <label for="' . $value['name'] . '">' . $value['name'] . '</label>
                            </div>
                        ';
                } else if (!strcmp($form_type, 'tinyint')) {
                	$checked = $values[0][$value['name']] ? 'checked' : '';
                    $form_template .= '
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="'.$value['name'].'" name="'.$value['name'].'" value=1 '.$checked.'>
                            <label class="form-check-label" for="'.$value['name'].'">'.$value['name'].'</label>
                        </div>
                    ';
                } else if (!strcmp($form_type, 'int') ||
                    !strcmp($form_type, 'varchar') && strcmp($value['name'], 'picture')) {
                    $form_template .= '
                            <div class="form-floating">
                                <input class="form-control" type="text" id="' . $value['name'] . '" name="' . $value['name'] . '" value="'.$values[0][$value['name']].'" placeholder="text">
                                <label for="' . $value['name'] . '">' . $value['name'] . '</label>
                            </div>
                        ';
                }
            }
            return $pic_form . ' ' . $form_template;
        }
	}