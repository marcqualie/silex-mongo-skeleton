<?php


// Create Application Instance
include __DIR__ . '/vendor/autoload.php';
use Config\Config;
use Silex\Application;
$app = new Application();


// Exception Handler
use Symfony\Component\HttpKernel\Debug\ErrorHandler;
use Symfony\Component\HttpKernel\Debug\ExceptionHandler;
error_reporting(-1);
ErrorHandler::register();
ExceptionHandler::register();


// Environment
define('APPROOT', __DIR__);
$app['version'] = '0.0.0';
$app['env'] = getenv('APP_ENV') ?: 'development';
$app['debug'] = $app['env'] === 'development' ? true : false;


// Configuration
$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__ . '/app/Config/' . $app['env'] . '.php'));


// Connect to MongoDB and apply MinifySchema
$app->register(new MongoMinify\Silex\ServiceProvider());


// Register Twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(	
	'twig.path' => __DIR__ . '/app/View',
	'twig.options' => array(
		'cache' => __DIR__ . '/cache'
	)
));


// Logging
$app->register(new Silex\Provider\MonologServiceProvider(), array(
	'monolog.name' => 'SilexMongoSkeleton',
	'monolog.level' => Monolog\Logger::WARNING,
	'monolog.logfile' => __DIR__ . '/logs/' . date('Y-m-d') . '-' . $app['env'] . '.log',
));


// Custom Error Handler
$app->error(function ($exception, $code) use ($app) {
	if ($code === 404)
	{
		return 'Error 404: Not Found';
	}
});


// App Routes
$app->get('/', Router::getController('Index'));
$app->get('/example-json', Router::getController('JsonExample'));


// Return Instance
return $app;
