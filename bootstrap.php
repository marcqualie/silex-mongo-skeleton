<?php


// Create Application Instance
include __DIR__ . '/vendor/autoload.php';
use Config\Config;
use Silex\Application;
$app = new Application();


// Environment
define('APPROOT', __DIR__);
$app['version'] = '0.0.0';
$app['env'] = getenv('APP_ENV') ?: 'development';
$app['debug'] = $app['env'] === 'development' ? true : false;


// Configuration
$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__ . '/app/Config/' . $app['env'] . '.php'));


// Connect to MongoDB and apply MinifySchema
$app->register(new MongoMinify\SilexServiceProvider());


// Register Twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.cache_dir' => __DIR__ . '/cache',
	'twig.path' => __DIR__ . '/app/View'
));


// App Routes
$app->get('/', Router::getController('Index'));


// Return Instance
return $app;