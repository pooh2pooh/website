<?php ini_set('display_errors', true);

	##
	#
	# Точка входа для приложения,
	# отсюда собираем ядро и выполняем маршрутизацию
	#
	##

	require_once "app/bootstrap.php";

	// Запускаем приложение
	/*
	 * Настраиваемые параметры,
	 * @debug_mode: false
	 */
	$app = new bootstrap();
	$app->run(true);
