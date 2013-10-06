<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Extension inspired by Ben Croker's Open API extension
https://github.com/putyourlightson/open-api/blob/master/open-api/system/expressionengine/third_party/open_api/ext.open_api.php
*/

class Mission_tracker_ext
{
	var $name			= 'Mission Tracker';
	var $version		= '0.5';
	var $description	= 'API for tracking A-Team Missions';
	var $settings_exist	= 'y';
	var $docs_url		= '';

	var $settings		= array();
	
	function __construct($settings = '') {
		$this->settings = $settings;
		ee()->load->add_package_path(PATH_THIRD.'mission_tracker');
	}
	
	/*
	Parses segment_1, see if it matches the "API" segment setting, then routes to a method in
	the API library matching segment_2
	*/
	function route_url($session) {
		if (isset($this->settings['api_trigger']) AND $this->settings['api_trigger'] AND ee()->uri->segment(1) == $this->settings['api_trigger']) {
			// set the session
			ee()->session = $session;

			// load api library depending on segment_2 
			if(ee()->uri->segment(2) == "mission") {
				ee()->load->library(ee()->uri->segment(2).'_lib', null, 'mission_api');

				// call the method in the second segment
				ee()->mission_api->call_method(ee()->uri->segment(3));
			} else {
				ee()->output->set_status_header(500);
				echo("No matching API method found '".ee()->uri->segment(2)."'");
			}

			// stop any further processing
			die();
		}
	}
	
	function settings() {	
		$settings = array();
	    $settings['api_trigger'] = array('i', '', '');
		return $settings;
	}
	
	function update_extension($current='') {
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}

		ee()->db->where('class', __CLASS__);
		ee()->db->update(
			'extensions',
			array('version' => $this->version)
		);
	}
	
	function activate_extension() {
		// add sessions start hook
		$data = array(
			'class'	 	=> __CLASS__,
			'method'	=> 'route_url',
			'hook'	  	=> 'sessions_start',
			'settings'  => '',
			'priority'  => 10,
			'version'   => $this->version,
			'enabled'   => 'y'
		);	
		ee()->db->insert('extensions', $data);		
	}
	
	function disable_extension() {
		ee()->db->where('class', __CLASS__);
		ee()->db->delete('extensions');
	}
}