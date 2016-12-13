<?php

namespace Booqnow;
use Config;

class Tenant {

  /**
   * Connect to the chosen tenant connection
   * @param  array $options - Input options data
   * @return void
   */
  public static function connect($options = null)
  {
		$database = $options['database'];

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
  }

}
