<?php

/**
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2015, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */
// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

return
		array(
			"base_url" => "http://local.wus.dev/application/common/php/tools/hybridauth/index.php",
			"providers" => array(
				"Google" => array(
					"enabled" => false,
					"keys" => array("id" => "", "secret" => ""),
				),
				"Facebook" => array(
					"enabled" => true,
					"keys" => array("id" => "550102901804835", "secret" => "6af48d44b0a18ab3787a2d8dc1884fa9"),
					"scope" => "email",
					"trustForwarded" => false
				),
				"Instagram" => array(
					"enabled" => true,
					"keys" => array("id" => "e3619d9447ad4bf69cd934ee626e8713", "secret" => "2baf914cf50649a8b44722d5b3b86736")
				)
			),
			// If you want to enable logging, set 'debug_mode' to true.
			// You can also set it to
			// - "error" To log only error messages. Useful in production
			// - "info" To log info and error messages (ignore debug messages)
			"debug_mode" => true,
			// Path to file writable by the web server. Required if 'debug_mode' is not false
			"debug_file" => "log.txt",
);
