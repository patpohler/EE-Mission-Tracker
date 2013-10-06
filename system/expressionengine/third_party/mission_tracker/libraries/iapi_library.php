<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* all API libraries MUST implement this interface in order for the ext.mission_track method to work */
interface iApi_library {
	public function call_method($method = '');
}