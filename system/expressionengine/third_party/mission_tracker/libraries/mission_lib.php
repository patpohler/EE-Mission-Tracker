<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('iapi_library.php');
require_once('base_api.php');

class Mission_lib extends Base_api {
			
	function show_all() {
		ee()->load->model('Mission');
		
		$missions = ee()->Mission->get_all_missions();
		$this->response($missions);
	}
	
	function create() {
		$data = array();
		$data['client'] = ee()->input->post('client');
		$data['city'] = ee()->input->post('city');
		$data['status'] = ee()->input->post('status');
		$data['brief'] = ee()->input->post('brief');
		$data['outcome'] = ee()->input->post('outcome');

		ee()->load->model('Mission');
		ee()->Mission->insert($data);
		
		$this->response(ee()->Mission);
	}
	
	function show() {
		$id = ee()->input->get('id');
		
		ee()->load->model("Mission");
		$mission = ee()->Mission->get($id, true);
		
		$this->response($mission);
	}
	
	function update() {
		$data = array();
		$data['id'] = ee()->input->post('id');
		$data['client'] = ee()->input->post('client');
		$data['city'] = ee()->input->post('city');
		$data['status'] = ee()->input->post('status');
		$data['brief'] = ee()->input->post('brief');
		$data['outcome'] = ee()->input->post('outcome');
		
		ee()->load->model('Mission');
		ee()->Mission->update($data);
		
		$this->response(ee()->Mission);
	}
	
	function delete() {
		$id = ee()->input->get_post('id');
		
		ee()->load->model('Mission');
		ee()->Mission->delete($id);
		
		$this->response("Mission removed!");
	}
}