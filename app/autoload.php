<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 06.05.2017
 * Time: 13:58
 */

/**
 * Функция __autoload для автоматического подключения классов
 */
spl_autoload_register(function ($class_name) {
	$array_paths = array(
		'/',
		'/classes/',
		'/models/',
		'/controllers/',
	);

	// Проходим по массиву папок
	foreach ($array_paths as $path) {

		// Формируем имя и путь к файлу с классом
		$path = ROOT . $path . $class_name . '.php';

		// Если такой файл существует, подключаем его
		if (file_exists($path)) {
			include_once $path;
		} else {

			$classParts = explode('\\', $class_name);
			var_dump($classParts);
			$classParts[0] = __DIR__;

			if (count($classParts) > 1) {
				$classParts[1] = lcfirst($classParts[1]);
			}

			$path = implode(DIRECTORY_SEPARATOR, $classParts) . '.php';

			if (file_exists($path)) {
				require_once $path;
			}
		}
	}
});

//spl_autoload_register(function ($class) {
//
//	if (file_exists(__DIR__ . '/controllers/' . $class . '.php')) {
//		require_once __DIR__ . '/controllers/' . $class . '.php';
//	} elseif (file_exists(__DIR__ . '/models/' . $class . '.php')) {
//		require_once __DIR__ . '/models/' . $class . '.php';
//	} elseif (file_exists(__DIR__ . '/classes/' . $class . '.php')) {
//		require_once __DIR__ . '/classes/' . $class . '.php';
//	} elseif (file_exists(__DIR__ . '/' . $class . '.php')) {
//		require_once __DIR__ . '/' . $class . '.php';
//	} else {
//		$classParts = explode('\\', $class);
//
//		var_dump($classParts);
//		$classParts[0] = __DIR__;
//		$path = implode(DIRECTORY_SEPARATOR, $classParts) . '.php';
//		var_dump($path);
//		if (file_exists($path)) {
//			require_once $path;
//		}
//	}
//});