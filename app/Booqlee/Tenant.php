<?php

namespace Booqlee;
use Config;

class Tenant {

  public static function connect($options = null)
  {
    // $options['database'] = 'testin123';

		$database = $options['database'];
		// $this->database = $database;
		// Figure out the driver and get the default configuration for the driver
		$driver  = isset($options['driver']) ? $options['driver'] : Config::get("database.default");
		$default = Config::get("database.connections.$driver");
		// Loop through our default array and update options if we have non-defaults
		foreach($default as $item => $value)
		{
			$default[$item] = isset($options[$item]) ? $options[$item] : $default[$item];
		}
		// Set the temporary configuration
		Config::set("database.connections.$database", $default);

    // dd(Config::get("database.connections.$database"));

		// Create the connection
		// $this->connection = $database;

  }

}
