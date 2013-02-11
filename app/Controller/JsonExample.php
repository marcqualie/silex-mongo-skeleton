<?php

namespace Controller;

class JsonExample extends \Controller {
	
	
	/**
	 * Initialize
	 * @return [type] [description]
	 */
	public function init()
	{
		
	}


	/**
	 * Execute
	 */
	public function exec()
	{
		
		$data = array();
		$data['version'] = $this->app['version'];
		$data['project'] = 'https://github.com/marcqualie/silex-mongo-skeleton';
		$data['author'] = array(
			'name' => 'Marc Qualie',
			'homepage' => 'https://marcqualie.com'
		);
		$data['mongo'] = array(
			'driver' => phpversion('mongo'),
			'database' => $this->app['mongo']->name,
			'stats' => $this->app['mongo']->command(array(
				'dbStats' => 1
			))
		);
		return $this->json($data);

	}

}