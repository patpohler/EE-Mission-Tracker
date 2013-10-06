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
 File: upd.mission_tracker.php
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

class Mission_tracker_upd {
	var $version = '0.5';
	
	function __construct() { 
        // Make a local reference to the ExpressionEngine super object 
        $this->EE =& get_instance(); 
    }

	function install() {
		$this->EE->load->dbforge();
		
		$data = array(
			'module_name' => 'Mission_tracker',
			'module_version' => $this->version,
			'has_cp_backend' => 'y',
			'has_publish_fields' => 'n'
		);
		
		$this->EE->db->insert('modules', $data);
		
		#$this->install_actions();
		
		$this->install_missions();
		
		return true;
	}
	
	function install_missions() {
		$fields = array(
			'id'			=> array('type' => 'int', 'constraint' => '10', 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'client'		=> array('type' => 'varchar', 'constraint' => '1000'),
			'city'			=> array('type' => 'varchar', 'constraint' => '1000'),
			'status'		=> array('type' => 'varchar', 'constraint' => '500'),
			'brief'			=> array('type' => 'text', 'null' => true, 'default' => null),
			'outcome'		=> array('type' => 'text', 'null' => true, 'default' => null),
		);

		$this->EE->dbforge->add_field($fields);
		$this->EE->dbforge->add_key('id', TRUE);

		$this->EE->dbforge->create_table('missions');
	}
	
	function uninstall() {
		$this->EE->load->dbforge();
		$this->EE->db->select('module_id');
		
		$query = $this->EE->db->get_where('modules', array('module_name' => 'Mission_tracker'));
		
	    $this->EE->db->where('module_id', $query->row('module_id'));
	    $this->EE->db->delete('modules');

	    $this->EE->db->where('class', 'Mission_tracker');
	    $this->EE->db->delete('actions');
	
		$this->EE->dbforge->drop_table('missions');
		
		return TRUE;
	}
	
	function update($current = '')
	{
		$this->EE->load->dbforge();
		
		
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
		
	    return FALSE;
	}
}