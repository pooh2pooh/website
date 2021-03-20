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
		protected PDO $db_object;

		function __construct() {
			try {
				$this->db_object = new PDO("$this->db_type:host=$this->db_server;dbname=$this->db_name;charset=$this->db_charset", $this->db_user, $this->db_pass);
			} catch(PDOException $e) {
				$this->sendError($e->getMessage(), $e->getFile().':'.$e->getLine());
			}
		}

		function queryBuilder($method = 'update', $tbl_name = 'products'): bool|string {
            // КОНСТРУКТОР ДЛЯ SQL ЗАПРОСА
            $sql            = ''; // запрос
            $table_field    = ''; // список полей таблицы
            $sql_ph         = ''; // плэйсхолдеры
            try {
                // Получаем структуру таблицы из базы,
                // и собираем запрос
                $sth = $this->db_object->prepare("SHOW COLUMNS FROM $tbl_name");
                $sth->execute();
                $tbl_structure = $sth->fetchAll(PDO::FETCH_ASSOC);
                if(!strcmp($method, 'insert')) {
                    foreach ($tbl_structure as $i => $tbl) {
                        if (!strcmp($tbl['Extra'], 'auto_increment')) continue;
                        $table_field .= ' ' . $tbl['Field'] . ',';
                        $sql_ph .= ' ?,';
                    }
                    $sql = 'INSERT INTO ' . $tbl_name . ' ' . '(' . mb_substr(trim($table_field), 0, -1) . ') VALUES (' . mb_substr(trim($sql_ph), 0, -1) . ')';
                } else if(!strcmp($method, 'update')) {
                    foreach ($tbl_structure as $i => $tbl) {
                        if (!strcmp($tbl['Extra'], 'auto_increment')) continue;
                        $table_field .= ' ' . $tbl['Field'] . ' = ?,';
                    }
                    $sql = 'UPDATE ' . $tbl_name . ' SET ' . mb_substr(trim($table_field), 0, -1) . ' WHERE id = ?';
                } else if(!strcmp($method, 'delete')) {
                    $sql = 'DELETE FROM ' . $tbl_name . ' WHERE id = ?';
                }
                return $sql;
            } catch(PDOException $e) {
                $this->sendError($e->getMessage(), $e->getFile().':'.$e->getLine());
                return false;
            }
        }

        /*
         * Метод возвращает данные из базы
         * @аргументы: имя таблицы, имя поля для сортировки
         */
		function getData($tbl_name = 'products', $orderby = 'id'): bool|array
        {
			try {
				$sth = $this->db_object->prepare("SELECT * FROM $tbl_name ORDER BY :orderby");
				$sth->execute(array('orderby' => $orderby));
                return $sth->fetchAll(PDO::FETCH_ASSOC);
			} catch(PDOException $e) {
				$this->sendError($e->getMessage(), $e->getFile().':'.$e->getLine());
				return false;
			}
		}

        /*
         * Метод изменения данных в базе
         * @аргументы: запрос из queryBuilder, данные
         */
        function setData(string $sql, array $data): bool
        {
            try {
                // Здесь $sql это готовый запрос из метода queryBuilder()
                $result = $this->db_object->prepare($sql);
                $result->execute($data);
                return true;

            } catch(PDOException $e) {
                $this->sendError($e->getMessage(), $e->getFile().':'.$e->getLine());
                return false;
            }
        }

	}