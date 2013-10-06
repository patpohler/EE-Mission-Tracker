<?php
/*
=====================================================
A-Team Mission Tracker
-----------------------------------------------------
 http://www.github.com/patpohler
-----------------------------------------------------
 Copyright (c) 2013 Patrick Pohler
=====================================================
 This software is based upon and derived from
 ExpressionEngine software protected under
 copyright dated 2004 - 2012. Please see
 http://expressionengine.com/docs/license.html
=====================================================
 File: mcp.mission_tracker.php
-----------------------------------------------------
 Dependencies: 
-----------------------------------------------------
 Purpose: Allows the A-Team to track & manage their missions
=====================================================
*/

if ( ! defined('EXT'))
{
    exit('Invalid file request');
}

class Mission_tracker_mcp {
	
	function __construct() { 
		ee()->load->add_package_path(PATH_THIRD.'mission_tracker');
	}
	
	public function index() {
		ee()->load->helper('form');
		ee()->load->library('table');	
		ee()->load->library('javascript');
		
		ee()->cp->set_variable('cp_page_title', ee()->lang->line('mission_tracker_module_name'));
		
		ee()->load->model('Mission');
		
		$vars = array();
		$vars['missions'] = ee()->Mission->get_all_missions();
		
		return ee()->load->view('index', $vars, TRUE);
	}
	
	public function edit() {
		ee()->load->helper('form');
		ee()->load->library('table');
		ee()->load->library('javascript');
		
		ee()->cp->set_variable('cp_page_title', ee()->lang->line('mission_tracker_module_name'));
		$mission_id = ee()->input->get('mission_id');
		ee()->load->model('Mission');
		
		$vars = array();
		$mission = ee()->Mission->get($mission_id);
		$vars["data"] = $this->_get_form($mission);
		
		return ee()->load->view('edit', $vars, TRUE);
	}
	
	public function new_mission() {
		ee()->load->helper('form');
		ee()->load->library('table');	
		ee()->load->library('javascript');

		ee()->cp->set_variable('cp_page_title', "New Mission");
		$vars = array();
		$vars["data"] = $this->_get_form();
		
		return ee()->load->view('new', $vars, TRUE);
	}
	
	public function create() {
		$data = array();
		$data['client'] = ee()->input->post('client');
		$data['city'] = ee()->input->post('city');
		$data['status'] = ee()->input->post('status');
		$data['brief'] = ee()->input->post('brief');
		$data['outcome'] = ee()->input->post('outcome');
		
		ee()->load->model('Mission');
		ee()->Mission->insert($data);
		
		ee()->functions->redirect(BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=Mission_tracker'.AMP.'method=index');
	}
	
	public function delete() {
		$id = ee()->input->get_post('mission_id');
		
		ee()->load->model('Mission');
		ee()->Mission->delete($id);
		
		ee()->functions->redirect(BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=Mission_tracker'.AMP.'method=index');
	}
	
	public function update() {
		$data = array();
		$data['id']	= ee()->input->post('id');
		$data['client'] = ee()->input->post('client');
		$data['city'] = ee()->input->post('city');
		$data['status'] = ee()->input->post('status');
		$data['brief'] = ee()->input->post('brief');
		$data['outcome'] = ee()->input->post('outcome');
		
		ee()->load->model('Mission');
		ee()->Mission->update($data);
		
		ee()->functions->redirect(BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=Mission_tracker'.AMP.'method=index');
	}
	
	private function _get_form($mission = null) {
		$all_statuses = array('pending' => 'Pending', 'in-action' => 'In Action', 'closed' => 'Closed');
		$form = array(
			'client'	=> form_hidden('id', ($mission == null ? '' : $mission->id)).form_input('client', ($mission == null ? '' : $mission->client)),
			'city'		=> form_input('city', ($mission == null ? '' : $mission->city)),
			'status'	=> form_dropdown('status', $all_statuses, ($mission == null? '' : $mission->status)),
			'brief'		=> form_textarea('brief', ($mission == null ? '' : $mission->brief)),
			'outcome'	=> form_textarea('outcome', ($mission == null ? '' : $mission->outcome))
		);
		return $form;
	}
}