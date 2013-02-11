<?php

class Controller {

	public $app;

	// Meta
	public $title = 'Default Title';
	public $description = '';
	public $heading = 'Page Heading';

	// Globals
	public $params = array();
	public $layout = 'Default';
	public $view = 'Default';

	// Timers
	public $timer_start;
	public $timer_end;


	/**
	 * Constructor - Don't Override
	 */
	public function __construct()
	{
		$this->timer_start = microtime(true);
	}


	/**
	 * Initialize
	 */
	public function init()
	{

	}


	/**
	 * Default Execute
	 */
	public function exec()
	{

	}


	/**
	 * Global Render Function
	 */
	public function render()
	{

		$params = $this->params;

		// Set Global page data
		$params['page']['file'] = 'Page/' . $this->view . '.twig';
		$params['page']['title'] = $this->title;
		$params['page']['description'] = $this->description;
		$params['page']['heading'] = $this->heading;

		return $this->app['twig']->render('Layout/' . $this->layout . '.twig', $params);

	}


	/**
	 * Output JSON and Exit
	 * These are mainly used for API helpers
	 */
	public function json ($data, $status = 200, array $extra = array())
	{
		$this->app->json(array(
			'time' => round(microtime(true) - $this->timer_start, 4)
		) + $extra
		  + array(
		  		'data' => $data
		  	),
		  $status)
		  ->send();
		exit;
	}
	public function jsonError ($message, $status = 500)
	{
		if (is_array($message) !== true)
		{
			$message = array($message);
		}
		$this->json(
			array(),
			$status,
			array(
				'error' => $message
			)
		);
	}

}