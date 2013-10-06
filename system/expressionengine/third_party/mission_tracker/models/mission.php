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
 File: mission.php
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

class Mission extends CI_Model {
	
	var $id;
	var $client = '';
	var $city = '';
	var $status = '';
	var $brief = '';
	var $outcome = '';
	
	
	function __construct()
    {  
        // Call the Model constructor
        parent::__construct();
    }
	
	public function get($mission_id, $return_array = FALSE) {
		$query = ee()->db->get_where('missions', array('id' => $mission_id));

		if($return_array) {
			return $query->result_array();
		}
		else {
			$row = $query->row();
			$this->id = $row->id;
			$this->client = $row->client;
			$this->city = $row->city;
			$this->status = $row->status;
			$this->brief = $row->brief;
			$this->outcome = $row->outcome;
			
			return $this;
		}
	}
	
	public function get_all_missions($return_array = FALSE)
	{
		$query = ee()->db->get('missions');
		if($return_array)
			return $query->result_array();
		else
			return $query->result();
	}
	
	public function insert($data) {
		$this->client = $data["client"];
		$this->city = $data["city"];
		$this->status = $data["status"];
		$this->brief = $data["brief"];
		$this->outcome = $data["outcome"];
		
		ee()->db->insert('missions', $this);
		
		$this->id = ee()->db->insert_id();
	}
	
	public function update($data) {
		$this->client = $data["client"];
		$this->city = $data["city"];
		$this->status = $data["status"];
		$this->brief = $data["brief"];
		$this->outcome = $data["outcome"];
		$this->id = $data["id"];
		
		ee()->db->update('missions', $this, array('id' => $data["id"]));
	}
	
	public function delete($id) {
		ee()->db->delete('missions', array('id' => $id));
	}
}