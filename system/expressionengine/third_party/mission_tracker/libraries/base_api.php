<?php

/* Base_api contains functions to help with common API tasks (like outputs) */

class Base_api implements iApi_library {
	function __construct() {
		ee()->load->add_package_path(PATH_THIRD.'mission_tracker');
	}
	
	function call_method($method='') {	
		// start output buffer so we can catch any errors
		ob_start();

		// check if method exists
		if (!method_exists($this, $method))
		{
			$this->response('Method does not exist', 400);
		}

		// call the method
		$this->$method();
	}
	
	function response($data='', $response_code=200) {
		// clear output buffer 
		ob_clean();

		// json encode response
		$response = json_encode($data);

		// if is an error response
		if ($response_code >= 400)
		{
			$response = is_array($data) ? implode(', ', $data) : $data;
		}

		else
		{
			header('Content-Type: application/json');
		}

		// set the response code in the header
		ee()->output->set_status_header($response_code);

		// output the response and end the script
		echo $response;

		exit();
	}
}