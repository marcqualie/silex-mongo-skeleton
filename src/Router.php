<?php

use Silex\Application;

class Router {
	
	public static function getController ($name)
	{


		/**
		 * Returns a controller intializer
		 */
		return function (Application $app, array $options = array()) use ($name) {
			$path = '\\Controller\\' . $name;
			if (class_exists($path))
			{
				$controller = new $path();
				$controller->app = $app;
				$controller->view = $name;
				$controller->init();
				$controller->exec($options);
				$response = $controller->render();
				return $response;
			}
		};

	}

}